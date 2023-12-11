<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Account;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index($message)
    {
        return view('backend.page.employees.index', compact('message'));
    }

    public function getList($message)
    {
        return view('backend.page.employees.list', compact('message'));
    }

    public function getEmployees($id = null)
    {
        if (empty($id)) {
            $employees = Employees::all();
        } else {
            $employees = Employees::where('account_id', $id)->first();
        }
        return $employees;
    }

    public function create(Request $request, $account_id)
    {
        $employee = Employees::find($account_id);
        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $this->validate($request, [
                'images' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $image_path = $request->file('images')->store('images', 'public');
        } else {
            $image_path = $employee->images;
        }

        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->date = $request->input('date');
        $employee->phone = $request->input('phone');
        $employee->gender = $request->input('gender');
        $employee->images =  $image_path;
        $employee->save();
        $message = "Bạn đã cập nhật lưu thành công";

        return redirect()->route('employees.index', ['message' => $message]);
    }

    public function edit(Request $request, $account_id)
    {
        try {
            $employee = Employees::where('account_id', $account_id)->firstOrFail();
            $img = $employee->images;
            $employee->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'date' => $request->input('date'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'EmploymentStatus' => $request->input('cv'),
                'StartDate' => $request->input('startdate'),
                'images' => $img,
            ]);
            $message = "Bạn đã cập nhật lưu thành công";
        } catch (\Exception $e) {
            $message = "Đã xảy ra lỗi: " . $e->getMessage();
        }

        return redirect()->route('employees.list', ['message' => $message]);
    }

    public function delete($account_id)
    {
        try {
            $employee = Employees::where('account_id', $account_id)->firstOrFail();
            $employee->update([
                'name' => null,
                'email' => null,
                'date' => null,
                'phone' => null,
                'gender' => null,
                'EmploymentStatus' => null,
                'StartDate' => null,
                'images' => null,
            ]);
            $message = "Bạn đã cập nhật lưu thành công";
            $message = "Bạn đã xóa tài khoản thành công";
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $message = "Không tìm thấy tài khoản để xóa";
        }
        return redirect()->route('employees.list', ['message' => $message]);
    }


    public function getEmployeesByAccount($account)
    {
        $accountId = [];
        foreach ($account as $item) {
            $accountId[] = $item->account_id;
        }
        $getEmp = Employees::whereIn('account_id', $accountId)->get();

        return $getEmp;
    }

    // ajax
    public function ajaxemployees(Request $request)
    {
        // $searchTerm = $request->input('search');
        // $userId = $request->input('account');

        // $getRole = $this->roleAccount($userId);

        // $deptIds = [];
        // foreach ($getRole as $item) {
        //     if ($item->role_account == 1) {
        //         $deptIds[] = $item->dept_id;
        //     }
        // }

        // $accounts = Account::whereIn('dept_id', $deptIds);

        // $employees = Employees::where('name', 'like', '%' . $searchTerm . '%')
        //     ->orwhere('email', 'like', '%' . $searchTerm . '%')
        //     ->get();

        // return view('backend.page.employees.ajax_get_searchEmployees', compact('searchTerm'));

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
     
         return view('backend.page.employees.ajax_get_searchEmployees', compact('accounts'));
    }
}
