<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Account_Role;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index($message)
    {
        return view('backend.page.roles.index', compact('message'));
    }

    public function create(Request $request, $accountId, $deptRole)
    {

        $data = $this->getRoleByAccountId($accountId);   
      
        $dept = explode(",", $deptRole);
        
        foreach ($dept as $deptId) { 
            if(!$data->isEmpty()){
                foreach($data as $items){
                  if($deptId == $items->dept_id){
                    $accountrole = $request->input('accountrole' . $accountId . $deptId) ?? 0;
                    $revenuerole = $request->input('revenuerole' . $accountId . $deptId) ?? 0;
                    $tasksrole = $request->input('tasksrole' . $accountId . $deptId) ?? 0;
                    $role = Role::find($items->role_id);
                    $role->role_account = $accountrole;
                    $role->role_revenue = $revenuerole;
                    $role->role_tasks = $tasksrole;
                    $role->save();
                  }
                }
            }else{
                $accountrole = $request->input('accountrole' . $accountId . $deptId) ?? 0;
                $revenuerole = $request->input('revenuerole' . $accountId . $deptId) ?? 0;
                $tasksrole = $request->input('tasksrole' . $accountId . $deptId) ?? 0;
    
                
                    $role = new Role;
                    $role->role_account = $accountrole;
                    $role->role_revenue = $revenuerole;
                    $role->role_tasks = $tasksrole;
                    $role->dept_id = $deptId;
                    if($role->save()){
                        $accountRole = new Account_Role;
                        $accountRole->account_id = $accountId;
                        $accountRole->role_id = $role->role_id;
                        $accountRole->save();
                    }
                
            }   
        }

        $message = 'Bạn đã thêm quyền thành công';
        return redirect()->route('role.index', ['message'=>$message]);
    }

    public function getRoleByAccountId($accountId){
        $roleId = Account_Role::where('account_id',$accountId)->pluck('role_id');

        $data = Role::whereIn('role_id',$roleId)->get();
        return $data;
    }
}
