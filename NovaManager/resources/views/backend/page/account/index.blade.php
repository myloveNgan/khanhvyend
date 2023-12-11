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
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\EmployeesController;
$getPos = PositionController::getPosition();
$getDept = DepartmentsController::getDepartments();
$user = session('user');
$tt = $user->account_id;
$getRole = AccountController::roleAccount($user->account_id);
$account = AccountController::getRoleAccountByDept($getRole);


?>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-4 col-lg-4">
            <h4 class="page-title">Tài khoản</h4>
            <div>
                {{ Breadcrumbs::render('nameaccount', 'mess') }}
            </div>

        </div>

        <div class="col-md-4">
            <input type="text" placeholder="Tìm kiếm..." id="search" name="search" class="form-control" value="">
        </div>
        @include('backend.page.account.create')
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
                                        {{-- <th>Password</th> --}}
                                        <th>Phòng ban</th>
                                        <th>Chức vụ</th>
                                        <th>Mã nhân viên</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="danhsach">
                                    <?php $number = 0; ?>
                                    @foreach ($account as $key => $item)
                                        @if ($item->account_id != $user->account_id)
                                            <?php $number++; ?>
                                            <tr>
                                                <td>{{ $number }}</td>
                                                <?php $getEmployees = EmployeesController::getEmployees($item->account_id); ?>
                                                <td>{{ isset($getEmployees->name) ? $getEmployees->name : 'Đang cập nhật' }}
                                                </td>
                                                <td>{{ $item->username }}</td>
                                                {{-- <td>{{ $item->password }}</td> --}}
                                                <?php
                                                $deptName = DepartmentsController::getDepartments($item->dept_id);
                                                ?>
                                                <td>{{ $deptName->name }}</td>

                                                <?php $positionName = PositionController::getPosition($item->pos_id); ?>

                                                <td>{{ $positionName->name }}</td>


                                                <td><span class="badge badge-primary-inverse">{{ $item->account_id }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary-rgba outline-none"
                                                        data-toggle="modal"
                                                        data-target="#editAcount{{ $item->account_id }}"><i
                                                            class="feather icon-edit edit_role_none"></i></button>
                                                    <button type="button"
                                                        class="btn btn-primary-rgba outline-none text-danger delete_role_none"
                                                        data-toggle="modal"
                                                        data-target="#deleteAcount{{ $item->account_id }}"><i
                                                            class="feather icon-trash delete_role_none"></i></button>
                                                </td>
                                            </tr>

                                            {{-- modal xóa --}}
                                            <div class="modal fade text-left" id="deleteAcount{{ $item->account_id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Xóa tài
                                                                khoản
                                                                {{ $item->username }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>

                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <a class="text-danger"
                                                                    href="{{ route('account.delete', ['account' => $item->account_id]) }}">Xóa
                                                                    tài khoản</a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- modal sua --}}
                                            <div class="modal fade text-left" id="editAcount{{ $item->account_id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Sửa thông
                                                                tin
                                                                tài khoản </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('account.edit', ['account' => $item->account_id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="appointno">Tài khoản đăng nhập :</label>
                                                                        <input value="{{ $item->username }}" type="text"
                                                                            class="form-control" name="username"
                                                                            id="appointno"
                                                                            placeholder="Email hoặc số điện thoại">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="appointpatient">Mật khẩu :</label>
                                                                        <input value="{{ $item->password }}" type="text"
                                                                            class="form-control" name="password"
                                                                            id="appointpatient" placeholder="Mật khẩu">
                                                                    </div>
                                                                    {{-- <div class="form-group col-md-12">
                                                                <label for="appointdoctor">Nhập lại mật khẩu :</label>
                                                                <input type="text" class="form-control"
                                                                    id="appointdoctor"
                                                                    placeholder="Nhập lại mật khẩu">
                                                            </div> --}}
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="appointpaystatus">Phòng ban</label>
                                                                        <select id="appointpaystatus" name="dept"
                                                                            class="form-control">
                                                                            @foreach ($getDept as $item)
                                                                                <option
                                                                                    @if ($deptName->name == $item->name) selected @endif
                                                                                    value="{{ $item->dept_id }}">
                                                                                    {{ $item->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="appointpaystatus">Chức vụ</label>
                                                                        <select id="appointpaystatus" name="pos"
                                                                            class="form-control">
                                                                            @foreach ($getPos as $item)
                                                                                <option
                                                                                    @if ($positionName->name == $item->name) selected @endif
                                                                                    value="{{ $item->pos_id }}">
                                                                                    {{ $item->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="feather icon-plus mr-2"></i>Sửa tài
                                                                        khoản</button>
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
                            <div class="pagination news__pagination d-flex justify-content-center">
                                {{-- {{ $account->onEachSide(1)->links('pagination::bootstrap-4') }} --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                var success = @json($success);
                if (success == 'Tên người dùng đã tồn tại') {
                    $(document).ready(function() {
                        new PNotify({
                            title: 'Thông báo',
                            text: success,
                            type: 'error'
                        });
                    });
                } else if (success != null) {
                    $(document).ready(function() {
                        new PNotify({
                            title: 'Thông báo',
                            text: success,
                            type: 'info',
                            hide: true,
                            delay: 2000
                        });
                    });
                }
            </script>
            <!-- End col -->
        </div>

        <script type="text/javascript">
        var account = @json($tt);
            $('#search').on('keyup',function(){
                $value = $(this).val();
                console.log(account);
                $.ajax({
                    type: 'get',
                    url: "{{ route('account.search') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'search': $value,
                        'account': account
                    },
                    success:function(data){
                        $('tbody').html(data);
                    }
                });
            })
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
    @endsection
