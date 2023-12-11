<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permision;
use App\Models\Account_Permision;
use Illuminate\Http\Request;

class PermisionController extends Controller
{
    //
    public function index($message){
        return view('backend.page.permision.index',compact('message'));
    }
    
    public function createPerAccount(Request $request,$account , $message){
        Account_Permision::where('account_id', $account)->delete();
        $addRole = $request->except('_token');

        foreach ($addRole as  $value) {
            Account_Permision::create([
                'account_id' => $account,
                'per_id' => $value,
            ]);
        }
        $message = 'Bạn đã thêm quyền thành công';
        return redirect()->route('permision.index',['message'=>$message]);
        
     }

     public function getnamePer($id){
        $perId = Account_Permision::where('account_id', $id)->pluck('per_id');

        $namePer = Permision::whereIn('per_id',$perId)->get();

        return $namePer;
    }

    public function getPermision($id = null){
        if(empty($id)){
            $data = Permision::all();
        }else{
            $data = Permision::where('per_id',$id)->first();
        }
        return $data;
     }
}
