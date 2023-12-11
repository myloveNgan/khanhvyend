<?php
if ($message == 'mess') {
    $message = null;
}
$success = null;
if (isset($message)) {
    $success = $message;
}
use App\Http\Controllers\Backend\PositionController;
use App\Http\Controllers\Backend\DepartmentsController;
use App\Http\Controllers\Backend\EmployeesController;
use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\PermisionController;
use App\Http\Controllers\Backend\RoleController;
$getPos = PositionController::getPosition();
$getDept = DepartmentsController::getDepartments();

$user = session('user');
$getRole = AccountController::roleAccount($user->account_id);
$account = AccountController::getRoleAccountByDept($getRole);
// dd($getRole);
?>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Phân quyền </h4>

            <div>
                phân quyền
            </div>

        </div>
        {{-- @include('backend.page.permision.create') --}}
    @endsection
    @section('content')
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Danh sách tài khoản</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và Tên</th>
                                        {{-- <th>Tên đăng nhập</th> --}}
                                        <th>Phòng ban</th>
                                        <th>Chức vụ</th>
                                        <th>Các quyền </th>
                                        <th>Quản lý các phòng</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($account as $key => $item)
                                        @if ($item->account_id != $user->account_id)
                                            <?php $number++; ?>
                                            <tr>
                                                <td>{{ $number }}</td>
                                                <?php $getEmployees = EmployeesController::getEmployees($item->account_id); ?>
                                                <td>{{ $getEmployees->name ? $getEmployees->name : 'Đang cập nhật' }}</td>
                                                {{-- <td>{{ $item->username }}</td> --}}
                                                <?php
                                                $deptName = DepartmentsController::getDepartments($item->dept_id);
                                                ?>
                                                <td>{{ $deptName->name }}</td>
                                                <?php $positionName = PositionController::getPosition($item->pos_id); ?>
                                                <td>{{ $positionName->name }}</td>
                                                <?php
                                                $perName = PermisionController::getnamePer($item->account_id);
                                                ?>
                                                <td>
                                                    @foreach ($perName as $perNameItem)
                                                        <span
                                                            class="badge badge-primary-inverse">{{ $perNameItem->name }}</span>
                                                    @endforeach
                                                </td>
                                                <?php $getRoleAccount = AccountController::roleAccount($item->account_id);
                                                ?>
                                                <td>

                                                    @foreach ($getRoleAccount as $roles)
                                                        @if ($roles->role_account == 1 || $roles->role_revenue == 1 || $roles->role_tasks == 1)
                                                        <?php
                                                        $role_account = '';
                                                        $role_revenue = '';
                                                        $role_tasks = '';
                                                        if($roles->role_account == 1){
                                                            $role_account = 'Tài khoản';
                                                        }

                                                        if($roles->role_revenue == 1){
                                                            $role_revenue = 'Doanh thu';
                                                        }

                                                        if($roles->role_tasks == 1){
                                                            $role_tasks = 'Công việc';
                                                        }
                                                        ?>
                                                        <button class="btn badge badge-success-inverse" data-container="body" data-toggle="popover" data-placement="top"
                                                         data-trigger="focus" title="Quản lý" data-content="{{ $role_account.' !! '.$role_revenue.' !! '.$role_tasks }}">{{ DepartmentsController::getDepartments($roles->dept_id)->name }}</button>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-primary-rgba outline-none text-danger"
                                                        data-toggle="modal" data-target="#add_per{{ $item->account_id }}"><i
                                                            class="feather icon-plus"></i></button>
                                                </td>
                                            </tr>


                                            {{-- modal them quyen roles --}}
                                            <div class="modal fade text-left" id="add_per{{ $item->account_id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Phân quyền
                                                                cho
                                                                tài khoản {{ $item->account_id }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pl-0 pr-0">
                                                            <form
                                                                action="{{ route('role.create', ['account' => $item->account_id, 'deptRole' => implode(',', $getRole->pluck('dept_id')->toArray()), 'message' => 'mess']) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <div class="">
                                                                                <div class="form-group col-md-12 p-0">

                                                                                    <div class="row">
                                                                                        <div class="col-md-4">

                                                                                        </div>

                                                                                        <div
                                                                                            class="row col-md-8 d-flex justify-content-sm-between">
                                                                                            <p>Tài khoản</p>

                                                                                            <p>Doanh thu</p>

                                                                                            <p>Giao việc</p>

                                                                                        </div>
                                                                                    </div>
                                                                                    @foreach ($getRole as $roles)
                                                                                        @if ($roles->role_account == 1 || $roles->role_revenue == 1)
                                                                                        @endif

                                                                                        {{-- <option value="{{ DepartmentsController::getDepartments($roles->dept_id)->dept_id }}">{{ DepartmentsController::getDepartments($roles->dept_id)->   }}</option> --}}
                                                                                        {{-- <span style="font-size: 16px" class="badge badge-primary-inverse">{{ DepartmentsController::getDepartments($roles->dept_id)->name }}</span>                    --}}

                                                                                        <div class="roles__acount mb-3">
                                                                                            <?php $nameDept = DepartmentsController::getDepartments($roles->dept_id)->name;
                                                                                            $deptId = DepartmentsController::getDepartments($roles->dept_id)->dept_id;
                                                                                            
                                                                                            $checkedAccount = '';
                                                                                            $checkedRevenue = '';
                                                                                            $checkedTasks = '';
                                                                                            $data = RoleController::getRoleByAccountId($item->account_id);
                                                                                            foreach ($data as $key => $value) {
                                                                                                if ($deptId == $value->dept_id) {
                                                                                                    if ($value->role_account == 1) {
                                                                                                        $checkedAccount = 'checked';
                                                                                                    }
                                                                                            
                                                                                                    if ($value->role_revenue == 1) {
                                                                                                        $checkedRevenue = 'checked';
                                                                                                    }
                                                                                            
                                                                                                    if ($value->role_tasks == 1) {
                                                                                                        $checkedTasks = 'checked';
                                                                                                    }
                                                                                                    break;
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="font-weight-bold col-md-4">
                                                                                                    {{ $nameDept }}
                                                                                                </div>
                                                                                                <div class="row col-md-8">
                                                                                                    <div
                                                                                                        class="custom-control custom-checkbox col-md-4">
                                                                                                        <input
                                                                                                            {{ $checkedAccount }}
                                                                                                            value="1"
                                                                                                            type="checkbox"
                                                                                                            class="custom-control-input"
                                                                                                            name="accountrole{{ $item->account_id }}{{ $deptId }}"
                                                                                                            id="accountrole{{ $item->account_id }}{{ $deptId }}">
                                                                                                        <label
                                                                                                            class="custom-control-label"
                                                                                                            for="accountrole{{ $item->account_id }}{{ $deptId }}"></label>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="custom-control custom-checkbox col-md-4">
                                                                                                        <input
                                                                                                            {{ $checkedRevenue }}
                                                                                                            value="1"
                                                                                                            type="checkbox"
                                                                                                            name="revenuerole{{ $item->account_id }}{{ $deptId }}"
                                                                                                            class="custom-control-input"
                                                                                                            id="revenuerole{{ $item->account_id }}{{ $deptId }}">
                                                                                                        <label
                                                                                                            class="custom-control-label"
                                                                                                            for="revenuerole{{ $item->account_id }}{{ $deptId }}"></label>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="custom-control custom-checkbox col-md-4">
                                                                                                        <input
                                                                                                            {{ $checkedTasks }}
                                                                                                            value="1"
                                                                                                            type="checkbox"
                                                                                                            name="tasksrole{{ $item->account_id }}{{ $deptId }}"
                                                                                                            class="custom-control-input"
                                                                                                            id="tasksrole{{ $item->account_id }}{{ $deptId }}">
                                                                                                        <label
                                                                                                            class="custom-control-label"
                                                                                                            for="tasksrole{{ $item->account_id }}{{ $deptId }}"></label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach



                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="feather icon-plus mr-2"></i>Thay đổi
                                                                        quyền</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        {{-- <button class="btn ml-5 btn-outline-warning" data-container="body" data-toggle="popover" data-placement="top"
            data-trigger="hover" title="Quản lý" data-content="this is a popover">hover</button> --}}

        <script>
            $(function() {
                $('[data-toggle="popover"]').popover()
            })
        </script>

<script>
    var success = @json($success);
   if(success != null){
        $(document).ready(function() {
new PNotify( {
    title: 'Thông báo', 
    text: success, 
    type: 'info',
    hide: true, 
    delay: 2000
});
});
    }

</script>
    @endsection
