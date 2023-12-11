<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employees;
use App\Models\Account_Role;
use App\Models\Account_Permision;
use App\Models\Account_Tasks;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function CheckLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        
        
        $user = Account::where('username', $username)
            ->where('password', $password)->first();

        $user = Account::where('username', $username)->first();
        if ($user && password_verify($password, $user->password)) {
            if ($user !== null) {
                session(['user' => $user]);
    
                $userData = session('user');
                $per_id = Account_Role::where('account_id', $userData->account_id)->get();
    
                $permissions = ['create' => 0, 'edit' => 0, 'delete' => 0, 'read' => 0];
    
                foreach ($per_id as $items) {
                    switch ($items->per_id) {
                        case 1:
                            $permissions['create'] = 1;
                            break;
                        case 2:
                            $permissions['edit'] = 1;
                            break;
                        case 3:
                            $permissions['delete'] = 1;
                            break;
                        case 4:
                            $permissions['read'] = 1;
                            break;
                    }
                }
                session(['permissions' => $permissions]);
                return redirect()->route('admin');
            } else {
                return redirect()->route('account.login');
            }
        }
        return redirect()->route('account.login');
    }

    public function logout()
    {
        if (session()->has('user')) {
            session()->forget('user');
            return redirect()->route('account.login');
        }
    }

    public function index($message)
    {
        return view('backend.page.account.index', compact('message'));
    }

    // lấy ROLE_ID quyền của tài khoản trong bảng Account_Role
    public function roleAccount($account)
    {
        $roleId = Account_Role::where('account_id', $account)->pluck('role_id');
        $data = Role::WhereIn('role_id', $roleId)->get();
        return $data;
    }

    // lấy được các tài khoản ở trong phòng ban nào
    public function getRoleAccountByDept($getRole)
    {
        $deptIds = [];
        foreach ($getRole as $item) {
            if ($item->role_account == 1) {
                $deptIds[] = $item->dept_id;
            }
        }
        $account = Account::whereIn('dept_id', $deptIds)->get();
        return $account;
    }

    public function getRoleAccountByDept2($getRole)
    {
        $deptIds = [];
        foreach ($getRole as $item) {
            if ($item->role_account == 1) {
                $deptIds[] = $item->dept_id;
            }
        }
        $account = Account::whereIn('dept_id', $deptIds);
        return $account;
    }

    public function create(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $hashpassword = password_hash($password, PASSWORD_BCRYPT);
        $dept_id = $request->input('dept');
        $pos_id = $request->input('pos');

        $usernameExists = $this->CheckExist($username);
        if ($usernameExists) {
            $error = 'Tên người dùng đã tồn tại';
            return redirect()->route('account.index', ['message' => $error]);
        } else {
            $accountNew = new Account();
            $accountNew->username = $username;
            $accountNew->password = $hashpassword;
            $accountNew->dept_id = $dept_id;
            $accountNew->pos_id = $pos_id;
            $accountNew->save();

            $account_id = $accountNew->account_id;
            $emp = new Employees();
            $emp->account_id = $account_id;
            $emp->name = null;
            $emp->email = null;
            $emp->date =null;
            $emp->phone = null;
            $emp->gender = null;
            $emp->images = null;
            $emp->EmploymentStatus = null;
            $emp->StartDate = null;
            $emp->save();
            $success = 'Bạn đã thêm tài khoản thành công';
            return redirect()->route('account.index', ['message' => $success]);
        }
    }

    public function delete($account)
    {
        $accountdelete = Account::find($account);
        $employeesDelete = Employees::where('account_id', $account);
        $accRoleDelete = Account_Role::where('account_id', $account);
        $accPermisionDelete = Account_Permision::where('account_id', $account);
        $accTasksDelete = Account_Tasks::where('account_id', $account);
        if ($accountdelete->exists()) {

            if ($employeesDelete->exists()) {
                $employeesDelete->delete();
            }

            if ($accRoleDelete->exists()) {
                $accRoleDelete->delete();
            }

            if ($accPermisionDelete->exists()) {
                $accPermisionDelete->delete();
            }

            if ($accTasksDelete->exists()) {
                $accTasksDelete->delete();
            }

            $accountdelete->delete();
            $delete = 'Bạn đã xóa tài khoản thành công';
            return redirect()->route('account.index', ['message' => $delete]);
        }
    }

    public function edit(Request $request, $accountId){
        $userName = $request->input('username');
       
        $existingAccount = Account::where('username', $userName)
        ->where('account_id', '!=', $accountId)
        ->first();
        
        if($existingAccount){
            $message = "Tên đăng nhập đã tồn tại";
            return redirect()->route('account.index', ['message' => $message]);
        }else{
            $account = Account::find($accountId);
            $newPassword = $request->input('password');
            $newDeptId = $request->input('dept');
            $newPosId = $request->input('pos');
            $account->username = $userName;
            $account->password = $newPassword;
            $account->dept_id = $newDeptId;
            $account->pos_id = $newPosId;
            $account->save();
            $message = "Bạn đã sửa tài khoản thành công";
            return redirect()->route('account.index', ['message' => $message]);
        }
    }

    public function CheckExist($username)
    {
        $check = Account::where('username', $username)->first();
        return $check !== null;
    }

    public function getAccount($id = null)
    {
        if (empty($id)) {
            $account = Account::all();
        } else {
            $account = Account::where('account_id', $id)->first();
        }
        return $account;
    }

    // ajax
     // $account = Account::where('account_id', 'like', '%' . $searchTerm . '%')->get();
     public function ajaxaccount(Request $request)
     {
         $searchTerm = $request->input('search');
         $userId = $request->input('account');
     
         $getRole = $this->roleAccount($userId);
     
         $deptIds = [];
         foreach ($getRole as $item) {
             if ($item->role_account == 1) {
                 $deptIds[] = $item->dept_id;
             }
         }
     
         $accounts = Account::whereIn('dept_id', $deptIds)
             ->where('account_id', 'like', '%' . $searchTerm . '%')
             ->orwhere('username', 'like', '%' . $searchTerm . '%')
             ->get();
     
         return view('backend.page.account.ajax_get_searchAccount', compact('accounts'));
     }
     
}
