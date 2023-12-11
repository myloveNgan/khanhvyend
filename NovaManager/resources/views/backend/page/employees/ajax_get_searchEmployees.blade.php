<?php $number = 0;
use App\Http\Controllers\Backend\PositionController;
use App\Http\Controllers\Backend\DepartmentsController;
use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\EmployeesController;
$getPos = PositionController::getPosition();
$getDept = DepartmentsController::getDepartments();
$user = session('user');
$getRole = AccountController::roleAccount($user->account_id);
?>

@foreach ($accounts as $item)
    @if ($item->account_id != $user->account_id)
        <?php $number++; ?>
        <tr>
            <td>{{ $number }}</td>
            <?php $getEmployees = EmployeesController::getEmployees($item->account_id); ?>
            <td>{{ isset($getEmployees->name) ? $getEmployees->name : 'Đang cập nhật' }}
            <td>{{ $item->username }}</td>
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
        </tr>
    @endif
@endforeach
