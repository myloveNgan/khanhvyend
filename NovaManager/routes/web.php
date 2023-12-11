<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController as Admin;
use App\Http\Controllers\Backend\AccountController as Account;
use App\Http\Controllers\Backend\EmployeesController as Employees;
use App\Http\Controllers\Frontend\AcountController as AccountFrontend;
use App\Http\Controllers\Backend\PermisionController as Permision;
use App\Http\Controllers\Backend\TasksController as Tasks;
use App\Http\Controllers\Backend\RoleController as Role;
use App\Http\Controllers\Backend\NotificationController as Notifi;
use App\Http\Controllers\Backend\DepartmentsController as Department;
use App\Http\Controllers\Backend\PositionController as Position;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin',[Admin::class,'show'])->name('admin');

Route::get('/login', function () {
    return view('backend.auth.index');
})->name('account.login');

Route::get('/', function () {
    return view('backend.auth.index');
})->name('account.login');

Route::get('/dashboard', function () {
    return view('backend.page.dashboard.index');
})->name('dashboard');

Route::post('/logincheck',[Account::class,'CheckLogin'])->name('account.checklogin');

// account
Route::get('/account/{message}',[Account::class,'index'])->name('account.index');
Route::post('/accountcreate',[Account::class,'create'])->name('account.create');
Route::get('/accountdelete/{account}',[Account::class,'delete'])->name('account.delete');
Route::post('/accountedit/{account}',[Account::class,'edit'])->name('account.edit');
Route::get('/accountlogout',[Account::class,'logout'])->name('account.logout');

Route::get('/ajax_get_searchAccount', [Account::class,'ajaxaccount'])->name('account.search');
// employees
Route::post('/employeescreate/{account}',[Employees::class,'create'])->name('employees.create');
Route::get('/employees/{message}',[Employees::class,'index'])->name('employees.index');
Route::get('/employeeslist/{message}',[Employees::class,'getList'])->name('employees.list');
Route::post('/employeeslistedit/{account}',[Employees::class,'edit'])->name('employees.list.edit');
Route::get('/employeeslistdelete/{account}',[Employees::class,'delete'])->name('employees.list.delete');

Route::get('/ajax_get_searchEmployees', [Employees::class,'ajaxemployees'])->name('employees.search');
// permision
Route::get('/permision/{message}',[Permision::class,'index'])->name('permision.index');
Route::post('/permision/{account}/{message}',[Permision::class,'createPerAccount'])->name('permision.account');

// rold
Route::get('/role/{message}',[Role::class,'index'])->name('role.index');
Route::post('/role/{account}/{deptRole}/{message}',[Role::class,'create'])->name('role.create');

// tasks
Route::get('/tasks/{message}',[Tasks::class,'index'])->name('tasks.index');
Route::get('/taskscreate/{assigned_by}',[Tasks::class,'create'])->name('tasks.create');
Route::post('/tasksupdate/{task_id}',[Tasks::class,'update'])->name('tasks.update');
Route::get('/tasksdetail/{task_id}',[Tasks::class,'getTaskDetailById'])->name('tasks.detail');

// notification
Route::get('/notifidelete/{notifiId}/{link}',[Notifi::class,'delete'])->name('notifi.delete');
