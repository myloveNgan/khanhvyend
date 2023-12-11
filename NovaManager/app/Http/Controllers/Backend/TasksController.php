<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use App\Models\Account_Tasks;
use App\Models\Account_Role;
use App\Models\Role;
use App\Models\Account;
use App\Models\Employees;
use App\Models\Notification;
use App\Models\Account_Notifi;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class TasksController extends Controller
{
    public function index($message)
    {
        return view('backend.page.tasks.index', compact('message'));
    }

    public function create(Request $request, $assigned_by)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $priority = $request->input('priority');
        $notes = $request->input('notes');
        $userName = $request->input('userName');
        $paths = $request->input('paths');

        // // get_files
        // $path_files = 'public/uploads/document/';
        // $get_files = $request->file;
        // $new_files = null;
        // if ($get_files instanceof UploadedFile) {
        //     $new_files = time() . '.' . $get_files->getClientOriginalExtension();
        //     $get_files->move($path_files, $new_files);
        //     dd($new_files);
        // }
        
        $tasks = new Tasks();
        $tasks->title = $title;
        $tasks->description = $description;
        $tasks->start_date = $startDate;
        $tasks->end_date = $endDate;
        $tasks->priority = $priority;
        $tasks->status = null;
        $tasks->estimated_completion_time = null;
        $tasks->assigned_by = $assigned_by;
        $tasks->notes = $notes;
        $tasks->paths = $paths;
        $tasks->progress_percent = 0;
        // $tasks->files = $new_files;
       
       if($userName != null){
        if ($tasks->save()) {
            foreach($userName as $item){
                $accountTasks = new Account_Tasks();
                $accountTasks->account_id = $item;
                $accountTasks->task_id = $tasks->task_id;
                $accountTasks->save();
            }
            $message = "Bạn đã phân việc thành công";
            return redirect()->route('tasks.index', ['message' => $message]);
        }
       }else{
        $message = "Bạn chưa phân việc cho tài khoản nào";
        return redirect()->route('tasks.index', ['message' => $message]);
       }
        
        $message = "Bạn đã phân việc thất bại";
        return redirect()->route('tasks.index', ['message' => $message]);
    }

    public function update(Request $request, $task_id)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $paths = $request->input('paths');
        $notes = $request->input('notes');
        $taskstatus = $request->input('taskstatus');
        $priority = $request->input('priority');
        $progressPercent = $request->input('progress_percent');
        $task = Tasks::find($task_id);

        if (!$task) {
            $message = "Không tìm thấy task !!";
            return redirect()->route('tasks.index', ['message' => $message]);
        } else {
            $task->title = $title;
            $task->description = $description;
            $task->start_date = $startDate;
            $task->end_date = $endDate;
            $task->paths = $paths;
            $task->notes = $notes;
            $task->status = $taskstatus;
            $task->priority = $priority;
            $task->progress_percent = $progressPercent;
            if($task->save()){
                // làm thông báo cho user
                $notifi = new Notification();
                $notifi->link = url()->previous();
                $notifi->create_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $notifi->status = 1 ;
                $notifi->notiByUser = $task->assigned_by;
                $notifi->noti_title = $task->title;
              
                if($notifi->save()){
                    $employees = TasksController::getAccountByTask($task->task_id);
                    foreach($employees as $items){
                        $account_notifi = new Account_Notifi();
                        $account_notifi->notifi_id = $notifi->notifi_id;
                        $account_notifi->account_id =  $items->account_id;
                        $account_notifi->save();
                    }
                   
                }            
            }
            $message = "Bạn đã sửa thành công";
            return redirect()->route('tasks.index', ['message' => $message]);
        }
    }

    public function getTasks($id = null)
    {
        if (empty($id)) {
            $data = Tasks::all();
        } else {
            $data = Tasks::where('task_id', $id);
        }
        return $data;
    }

    public function getTasksByAccount($account)
    {
        $accountId = [];
        foreach ($account as $item) {
            $accountId[] = $item->account_id;
        }
        $accountTasks = Account_Tasks::whereIn('account_id', $accountId)->pluck('task_id')->all();

        $tasks = Tasks::whereIn('task_id', $accountTasks)->get();

        return $tasks;
    }

    public function getRoleTasks($account_id)
    {
        $role = Account_Role::where('account_id', $account_id)->pluck('role_id');
        $deptIds = [];
        $role_tasks = Role::whereIn('role_id', $role)->get();
        foreach ($role_tasks as $item) {
            if ($item->role_tasks == 1) {
                $deptIds[] = $item->dept_id;   // trả về được dữ liệu các phòng ban mà accoun_id có quyền quản lý
            }
        }


        $account_id = Account::whereIn('dept_id', $deptIds)->pluck('account_id');
        $data = Employees::whereIn('account_id', $account_id)->get();

        return $data;
    }

    public function getNameUserTasks($task_id)
    {
        $account_id = Account_Tasks::where('task_id', $task_id)->first();

        $name = Employees::where('account_id', $account_id)->pluck('name');
        return $name;
    }


    // dữ liệu của 
    public function getTasksWithNamesByAccount($account,$userId)
    {
        $accountId = [];
        foreach ($account as $item) {
            $accountId[] = $item->account_id;
        }

        $accountTasks = Account_Tasks::whereIn('account_id', $accountId)->pluck('task_id')->all();
        $tasks = Tasks::whereIn('task_id', $accountTasks)->get();
        $taskNames = [];

        foreach ($tasks as $task) {
            $account_id = Account_Tasks::where('task_id', $task->task_id)->pluck('account_id');
            $name = Employees::whereIn('account_id', $account_id)->pluck('name');
            $taskNames[$task->task_id] = $name;
        }


        $tasksWithNames = $tasks->map(function ($task) use ($taskNames) {
            $task['name'] = $taskNames[$task->task_id];
            return $task;
        });

        return $tasksWithNames;
    }

    // công việc của chính bản thân
    public function getTaskByUser($user){
        $task_id = Account_Tasks::where('account_id', $user->account_id)->pluck('task_id');
        $task = Tasks::whereIn('task_id', $task_id)->get();
        return $task;
    }

    // chi tiết công việc
    public function getTaskDetailById($taskId){
        $task = Tasks::where('task_id',$taskId)->first();
        return view('backend.page.tasks.detail',compact('task'));
    }

    // Thông tin người được giao việc 
    public function getAccountByTask($taskId){
        $accountTasks = Account_Tasks::where('task_id',$taskId)->pluck('account_id');
        
        $emp = Employees::whereIn('account_id',$accountTasks)->get();
        return $emp;
    }

    // kiểm tra công việc đó có phải của mình không
    public function getCheckTaskByAccount($account_id,$task_id){
        $accountTasks = Account_Tasks::where('account_id',$account_id)
                                       ->where('task_id',$task_id)->get();
        if($accountTasks->isEmpty()){
            return false;
        }
        return true;
    }
    
}
