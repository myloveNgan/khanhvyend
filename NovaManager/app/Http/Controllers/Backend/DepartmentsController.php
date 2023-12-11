<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function getDepartments($id = null){
        if(empty($id)){
            $departments = Departments::all();
        }else{
            $departments = Departments::where('dept_id',$id)->first();
        }
        return $departments;
    }
}
