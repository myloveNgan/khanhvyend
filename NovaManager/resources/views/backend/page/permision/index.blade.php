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
use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\PermisionController;
use App\Http\Controllers\Backend\EmployeesController;
$getPos = PositionController::getPosition();
$getDept = DepartmentsController::getDepartments();

$user = session('user');
$getRole = AccountController::roleAccount($user->account_id);
$account = AccountController::getRoleAccountByDept($getRole);

//

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
                                        <th>Username</th>
                                        <th>Phòng ban</th>
                                        <th>Chức vụ</th>
                                        <th>Các quyền </th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($account as $key => $item)
                                    @if($item->account_id != $user->account_id)
                                    <?php $number++; ?>
                                        <tr>
                                            <td>{{ $number }}</td>
                                            <?php $getEmployees = EmployeesController::getEmployees($item->account_id); ?>
                                            <td>{{ $getEmployees->name ? $getEmployees->name : 'Đang cập nhật' }}</td>
                                            <td>{{ $item->username }}</td>
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
                                                <span style="font-size: 16px" class="badge badge-primary-inverse">{{ $perNameItem->name }}</span>                   
                                                @endforeach
                                            </td>
                                            <td>                                       
                                                <button type="button" class="btn btn-primary-rgba outline-none text-danger"
                                                    data-toggle="modal" data-target="#add_per{{ $item->account_id }}"><i
                                                        class="feather icon-plus"></i></button>
                                            </td>
                                        </tr>


                                        {{-- modal them quyen --}}
                                        <div class="modal fade text-left" id="add_per{{ $item->account_id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Phân quyền cho
                                                            tài khoản {{ $item->account_id }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('permision.account', ['account' => $item->account_id, 'message' => 'mess']) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <div class="custom-control custom-checkbox">
                                                                        @php
                                                                            $checkAdd = false;
                                                                            $checkEdit = false;
                                                                            $checkDelete = false;
                                                                            $checkView = false;
                                                                        @endphp
                                                                        @foreach ($perName as $perNameItem)
                                                                            @php
                                                                                switch ($perNameItem->name) {
                                                                                    case 'Thêm':
                                                                                        $checkAdd = true;
                                                                                        break;
                                                                                    case 'Sửa':
                                                                                        $checkEdit = true;
                                                                                        break;
                                                                                    case 'Xóa':
                                                                                        $checkDelete = true;
                                                                                        break;
                                                                                    case 'Xem':
                                                                                        $checkView = true;
                                                                                        break;
                                                                                }
                                                                            @endphp
                                                                        @endforeach
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input
                                                                                @if ($checkAdd) checked @endif
                                                                                value="1" type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="addrole{{ $item->account_id }}"
                                                                                id="addrole{{ $item->account_id }}">
                                                                            <label class="custom-control-label"
                                                                                for="addrole{{ $item->account_id }}">Thêm</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox">
                                                                            <input
                                                                                @if ($checkEdit) checked @endif
                                                                                value="2" type="checkbox"
                                                                                name="editrole{{ $item->account_id }}"
                                                                                class="custom-control-input"
                                                                                id="editrole{{ $item->account_id }}">
                                                                            <label class="custom-control-label"
                                                                                for="editrole{{ $item->account_id }}">Sửa</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox">
                                                                            <input
                                                                                @if ($checkDelete) checked @endif
                                                                                value="3" type="checkbox"
                                                                                name="deleterole{{ $item->account_id }}"
                                                                                class="custom-control-input"
                                                                                id="deleterole{{ $item->account_id }}">
                                                                            <label class="custom-control-label"
                                                                                for="deleterole{{ $item->account_id }}">Xóa</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox">
                                                                            <input
                                                                                @if ($checkView) checked @endif
                                                                                value="4" type="checkbox"
                                                                                name="readrole{{ $item->account_id }}"
                                                                                class="custom-control-input"
                                                                                id="readrole{{ $item->account_id }}">
                                                                            <label class="custom-control-label"
                                                                                for="readrole{{ $item->account_id }}">Xem</label>
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
