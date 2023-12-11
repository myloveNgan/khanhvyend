<?php
if ($message == 'mess') {
    $message = null;
}
$success = null;
if (isset($message)) {
    $success = $message;
}
use App\Http\Controllers\Backend\EmployeesController;
use App\Http\Controllers\Backend\AccountController;

$user = session('user');
$getRole = AccountController::roleAccount($user->account_id);
$account = AccountController::getRoleAccountByDept($getRole);
$tt = $user->account_id;
$getEmp = EmployeesController::getEmployeesByAccount($account);
?>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-4">
            <h4 class="page-title">Tài khoản</h4>
        </div>

        <div class="col-md-4">
            <input type="text" placeholder="Tìm kiếm..." id="search" name="search" class="form-control" value="">
        </div>
    @endsection
    @section('content')
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">Thông tin nhân sự</h5>
                            </div>
                            <div class="col-6">
                                <ul class="list-inline-group text-right mb-0 pl-0">
                                    <li class="list-inline-item">
                                        <div class="form-group mb-0 amount-spent-select">
                                            <select class="form-control" id="formControlSelect">
                                                <option>All</option>
                                                <option>Last Week</option>
                                                <option>Last Month</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Chức vụ</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($getEmp as $key => $items)
                                        @if ($items->account_id != $user->account_id)
                                            <?php $number++; ?>
                                            <tr>
                                                <th scope="row">#{{ $number }}</th>
                                                <td><img src="{{ asset(isset($items->images) ? 'storage/' . $items->images : 'backend/assets/images/users/profile.svg') }}"
                                                        class="img-fluid" width="35" alt="product"></td>
                                                <td>{{ isset($items->name) ? $items->name : '......' }}</td>
                                                <td>{{ isset($items->email) ? $items->email : '......' }}</td>
                                                <td>{{ isset($items->phone) ? $items->phone : '......' }}</td>
                                                <td>{{ isset($items->gender) ? $items->gender : '.....' }}</td>
                                                <td>
                                                    {{ isset($items->date) ? Carbon\Carbon::parse($items->date)->format('d/m/Y') : '.....' }}
                                                </td>
                                                <td>{{ $items->EmploymentStatus ? $items->EmploymentStatus : '.....' }}</td>
                                                <td>
                                                    {{ isset($items->StartDate) ? Carbon\Carbon::parse($items->StartDate)->format('d/m/Y') : '.....' }}
                                                </td>
                                                <td>
                                                    <div class="button-list">

                                                        <button type="button" class="btn btn-success-rgba outline-none"
                                                            data-toggle="modal"
                                                            data-target="#editAcount{{ $items->account_id }}"><i
                                                                class="feather icon-edit edit_role_none"></i></button>
                                                        <button type="button" class="btn btn-danger-rgba delete_role_none"
                                                            data-toggle="modal"
                                                            data-target="#deleteAcount{{ $items->account_id }}"><i
                                                                class="feather icon-trash delete_role_none"></i></button>
                                                    </div>
                                                </td>
                                            </tr>


                                            {{-- modal sua --}}
                                            <div class="modal fade text-left" id="editAcount{{ $items->account_id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Sửa thông
                                                                tin
                                                                của {{ $items->name }} </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('employees.list.edit', ['account' => $items->account_id]) }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="name-f">Họ và tên</label>
                                                                        <input type="text" value="{{ $items->name }}"
                                                                            class="form-control" name="name"
                                                                            id="name-f" placeholder="Họ và tên."
                                                                            required>
                                                                    </div>
                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="email">Email</label>
                                                                        <input type="email" value="{{ $items->email }}"
                                                                            class="form-control" name="email"
                                                                            id="email" placeholder="Nhập email của bạn."
                                                                            required>
                                                                    </div>
                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="address-1">Ngày sinh</label>
                                                                        <input type="date" value="{{ $items->date }}"
                                                                            class="form-control" name="date"
                                                                            id="address-1" placeholder="Ngáy sinh" required>
                                                                    </div>
                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="address-2">Số điện thoại</label>
                                                                        <input type="address" value="{{ $items->phone }}"
                                                                            class="form-control" name="phone"
                                                                            id="address-2" placeholder="Số điện thoại."
                                                                            required>
                                                                    </div>
                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="sex">Giới tính</label>
                                                                        <select name="gender" id="sex"
                                                                            class="form-control browser-default custom-select">
                                                                            <option value="Nam"
                                                                                {{ $items->gender == 'Nam' ? 'selected' : '' }}>
                                                                                Nam</option>
                                                                            <option value="Nữ"
                                                                                {{ $items->gender == 'Nữ' ? 'selected' : '' }}>
                                                                                Nữ</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="">Chức vụ</label>
                                                                        <select name="cv" id="cv"
                                                                            class="form-control browser-default custom-select">
                                                                            <option
                                                                                {{ $items->EmploymentStatus == 'Chính thức' ? 'selected' : '' }}
                                                                                value="Chính thức">Chính thức</option>
                                                                            <option
                                                                                {{ $items->EmploymentStatus == 'Thử việc' ? 'selected' : '' }}
                                                                                value="Thử việc">Thử việc</option>
                                                                            <option
                                                                                {{ $items->EmploymentStatus == 'Thực tập sinh' ? 'selected' : '' }}
                                                                                value="Thực tập sinh">Thực tập sinh
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6 form-group">
                                                                        <label for="">Ngày bắt đầu làm việc</label>
                                                                        <input type="date"
                                                                            value="{{ $items->StartDate }}"
                                                                            class="form-control" name="startdate"
                                                                            id="address-1" placeholder="Ngáy sinh"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-sm-12 form-group mb-0">
                                                                        <button type="submit"
                                                                            class="btn btn-primary float-right">Thêm</button>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- modal xóa --}}
                                            <div class="modal fade text-left" id="deleteAcount{{ $items->account_id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Xóa tài
                                                                khoản
                                                                {{ $items->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>

                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <a class="text-danger"
                                                                    href="{{ route('employees.list.delete', ['account' => $items->account_id]) }}">Xóa
                                                                    tài khoản</a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- <div class="pagination news__pagination d-flex justify-content-center">
                            {{ $getEmp->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
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

<script type="text/javascript">
    var account = @json($tt);
        $('#search').on('keyup',function(){
            $value = $(this).val();
            console.log(account);
            $.ajax({
                type: 'get',
                url: "{{ route('employees.search') }}",
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
