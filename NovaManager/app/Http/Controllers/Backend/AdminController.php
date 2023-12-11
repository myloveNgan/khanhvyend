<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Account_Role;
use App\Models\Account;
use App\Models\Account_Permision;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        if (session()->has('user')) {
            $userData = session('user');
            $per_id = Account_Permision::where('account_id', $userData->account_id)->get();
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
           
            return redirect()->route('account.index',['message'=>'mess']);
            
        } else {
            return view('backend.auth.index');
        }    
    }
}
