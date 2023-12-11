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
use App\Http\Controllers\Backend\TasksController;
$user = session('user');
$getRole = AccountController::roleAccount($user->account_id); // lấy quyền của tài khoản trong bảng Account_Role
$account = AccountController::getRoleAccountByDept($getRole); // lấy tài khoản ở trong phòng ban nào
$getEmp = EmployeesController::getEmployeesByAccount($account); // lấy tên +  (account_id)
$getTask = TasksController::getTasksWithNamesByAccount($getEmp, $user->account_id); // lấy các công việc của nhân sự () : cài này là lấy được tất cả account mà bạn quản lý

$accountaddTasks = TasksController::getRoleTasks($user->account_id); // kiểm tra xem các tài khoản của phòng ban mà bạn có thể quản lý , để bạn có quyền giao việc

$getUser = TasksController::getTaskByUser($user); // công việc của chính bản thân

?>
<style>
    .modal-dialog {
        max-width: 700px !important;
    }
</style>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Giao việc</h4>

            <div>
                Giao việc
            </div>

        </div>
    @endsection
    @section('content')
        <div class="row">
            <!-- Start col -->
            <div class="col-12">
                <div class="row col-12">
                    <div class="col-md-12 col-lg-12 col-xl-10">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="pl-2 pr-2 pt-0">
                                    <h2 class="mb-4">Lịch giao việc</h2>
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- calendar modal -->
                                <div id="modal-view-event" class="modal modal-top fade calendar-modal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="post" action="{{ route('tasks.update', ['task_id' => 'x']) }}"
                                            class="event-taskid modal-content" id="updateTaskForm">
                                            @csrf
                                            <div class="modal-body">
                                                <input name="title" type="text" style="font-size: 30px; color: #000"
                                                    class="text-capitalize font-weight-bold event-title form-control border-0 text-center"
                                                    placeholder="Tên tiêu đề " value="">
                                                <div class="">
                                                    <h6 class="font-weight-bold">Chi tiết công việc :
                                                        <textarea name="description" placeholder="Chi tiết công việc"
                                                            id=""class="col-12 form-control border-0 event-body" rows="2"></textarea>
                                                    </h6>

                                                </div>
                                                <div class="event-date">
                                                    <h6 class="font-weight-bold">Thời gian:
                                                        <div class="row">
                                                            <input type='datetime-local'
                                                                class="form-control event-startdate col-md-5"
                                                                name="startdate">
                                                            <div
                                                                class="col-2 d-flex align-items-center justify-content-center">
                                                                đến
                                                            </div>

                                                            <input type='datetime-local'
                                                                class="form-control event-enddate col-md-5" name="enddate">
                                                        </div>
                                                    </h6>

                                                </div>

                                                <div class="">
                                                    <h6 class="font-weight-bold">Đường dẫn:
                                                        <input name="paths" type="text"
                                                            class="event-paths col-12 form-control border-0">
                                                    </h6>
                                                </div>

                                                <div class="">
                                                    <h6 class="font-weight-bold">Ghi chú:
                                                        <textarea name="notes" placeholder="Chi tiết công việc" id=""class="col-12 form-control border-0 event-notes"
                                                            rows="2"></textarea>
                                                    </h6>
                                                </div>


                                                <div class="">
                                                    <h6 class="font-weight-bold text-black"> Người được giao việc:
                                                        <span class="event-taskname text-capitalize"></span>
                                                    </h6>
                                                </div>

                                                <div class="d-flex row algin-items-center">
                                                    <div class="col-md-6">
                                                        <label class="font-weight-bold">Trạng thái :</label>
                                                        <select name="taskstatus" class="status form-control">
                                                            <option value="Chưa hoàn thành">Chưa hoàn thành</option>
                                                            <option value="Đang làm">Đang làm</option>
                                                            <option value="Hoàn thành">Hoàn thành</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-weight-bold">Mức độ ưu tiên công việc</label>
                                                        <select class="form-control priority" name="priority">
                                                            <option value="blue">Ưu tiên thấp</option>
                                                            <option value="orange">Ưu tiên trung bình</option>
                                                            <option value="red">Ưu tiên cao</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="">
                                                        <label class="font-weight-bold">Phần trăm công việc :</label>
                                                       <div class="col-md-6">
                                                        <input id="range-slider-basic" name="progress_percent">
                                                       </div>
                                                    </div>

                                                    <script>
                                                        $(function() {
                                                            'use strict';
                                                            /* -- Range Slider - Basic -- */
                                                            $("#range-slider-basic").ionRangeSlider({
                                                                min: 0,
                                                                max: 100,
                                                                from: 0
                                                            });
                                                           
                                                        });
                                                    </script>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                {{-- <button type="submit" class="btn btn-primary edit_role_none">Sửa</button> --}}
                                                <a id="detailTaskForm" href="{{ route('tasks.detail', ['task_id' => 'x']) }}" class="btn btn-primary text-white">Chi tiết công việc</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="get" id="add-event" enctype="multipart/form-data"
                                                action="{{ route('tasks.create', ['assigned_by' => $user->account_id]) }}">
                                                @csrf
                                                <div>
                                                    <h4 style="background: #506FE4"
                                                        class="text-center font-weight-bold text-white py-2">Giao công
                                                        việc</h4>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-black">Tiêu đề công việc</label>
                                                            <input type="text" placeholder="Tiêu đề công việc"
                                                                class="form-control" name="title">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div>
                                                                    {{-- datetimepicker --}}
                                                                    <label class="font-weight-bold text-black">Thời gian bắt
                                                                        đầu</label>
                                                                    <input type='datetime-local' class="form-control"
                                                                        name="startdate">
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div>

                                                                    <label class="font-weight-bold text-black">Thời gian kết
                                                                        thúc</label>
                                                                    {{-- datetimepicker --}}
                                                                    <input type='datetime-local' class="form-control"
                                                                        name="enddate">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-black">Chi tiết công việc</label>
                                                            <textarea name="description" placeholder="Chi tiết công việc" id=""class="col-12 form-control"
                                                                rows="2"></textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="d-flex algin-items-center row">
                                                                    <label class="font-weight-bold text-black col-6">Người được giao
                                                                        việc</label>

                                                                   <div class="col-6 d-inline-block">
                                                                    <input id="searchByUser" class="w-100 form-control" type="text"  placeholder="Tìm kiếm">
                                                                   </div>
                                                                </div>
                                                                <script type="text/javascript">
                                                                          $('#searchByUser').on('keyup',function(){
                                                                            $value = $(this).val();
                                                                            alert($value);
                                                                          });
                                                                </script>
                                                                <select multiple class="form-control" name="userName[]"
                                                                    id="">
                                                                    @foreach ($accountaddTasks as $item)
                                                                        @if ($item->account_id != $user->account_id)
                                                                            @if ($item->name != null)
                                                                                <option value="{{ $item->account_id }}">
                                                                                    {{ $item->name }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="font-weight-bold text-black">Mức độ ưu tiên công
                                                                việc</label>
                                                            <select class="form-control" name="priority">
                                                                <option value="blue">Ưu tiên thấp</option>
                                                                <option value="orange">Ưu tiên trung bình</option>
                                                                <option value="red">Ưu tiên cao</option>
                                                            </select>
                                                        </div>

                                                        <div class="font-weight-bold d-none " id="toggleButton2">Thêm file:</div>
                                                        <div id="myDiv2" style="">
                                                            <div class="row d-none">
                                                               
                                                                <input type="file" name="file"
                                                                    class="col-6 form-control" placeholder="Thêm file">
                                                            </div>
                                                        </div>

                                                        <div class="font-weight-bold d-inline-block text-black" id="toggleButton">
                                                            Thêm links</div>
                                                        <div class="font-weight-bold" id="myDiv"
                                                            style="display: none;">
                                                            <div class="form-group">
                                                                <input name="paths" class="form-control"
                                                                    placeholder="Gán link">
                                                            </div>
                                                        </div>

                                                        <div class="font-weight-bold d-inline-block text-black" id="toggleButton3">
                                                            Thêm note</div>
                                                        <div id="myDiv3" style="display: none;">
                                                            <div class="row">
                                                                <textarea name="notes" class="col-12 form-control" placeholder="Ghi chú ..." id="" rows="2"></textarea>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var myDiv = document.getElementById("myDiv");
                                                                var toggleButton = document.getElementById("toggleButton");

                                                                var isDivVisible = false;

                                                                toggleButton.addEventListener("click", function() {
                                                                    if (isDivVisible) {
                                                                        myDiv.style.display = "none";
                                                                    } else {
                                                                        myDiv.style.display = "block";
                                                                    }

                                                                    isDivVisible = !isDivVisible;
                                                                });


                                                                var myDiv2 = document.getElementById("myDiv2");
                                                                var toggleButton2 = document.getElementById("toggleButton2");

                                                                var isDivVisible2 = false;

                                                                toggleButton2.addEventListener("click", function() {
                                                                    if (isDivVisible2) {
                                                                        myDiv2.style.display = "none";
                                                                    } else {
                                                                        myDiv2.style.display = "block";
                                                                    }

                                                                    isDivVisible2 = !isDivVisible2;
                                                                });


                                                                var myDiv3 = document.getElementById("myDiv3");
                                                                var toggleButton3 = document.getElementById("toggleButton3");

                                                                var isDivVisible3 = false;

                                                                toggleButton3.addEventListener("click", function() {
                                                                    if (isDivVisible3) {
                                                                        myDiv3.style.display = "none";
                                                                    } else {
                                                                        myDiv3.style.display = "block";
                                                                    }

                                                                    isDivVisible3 = !isDivVisible3;
                                                                });
                                                            });
                                                        </script>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                    <button type="button" class="btn btn-primary"
                                                        data-dismiss="modal">Đóng</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    jQuery(document).ready(function() {
                                        jQuery('.datetimepicker').datepicker({
                                            timepicker: true,
                                            language: 'en',
                                            range: true,
                                            multipleDates: true,
                                            multipleDatesSeparator: " - "
                                        });
                                        jQuery("#add-event").submit(function() {
                                            alert("Submitted");
                                            var values = {};
                                            $.each($('#add-event').serializeArray(), function(i, field) {
                                                values[field.name] = field.value;
                                            });
                                            console.log(
                                                values
                                            );
                                        });
                                    });


                                    (function() {
                                        'use strict';
                                        // ------------------------------------------------------- //
                                        // Calendar
                                        // ------------------------------------------------------ //
                                        jQuery(function() {

                                            var getTask = @json($getTask);
                                            console.log(getTask);
                                            var getUser = @json($getUser);
                                            var accountaddTasks = @json($accountaddTasks);
                                            if (getTask.length > 0) {
                                                var events = getTask.map(task => {
                                                    return {
                                                        title: task.title,
                                                        color: task.priority,
                                                        description: task.description,
                                                        start: task.start_date,
                                                        dateStart: task.start_date,
                                                        dateEnd: task.end_date,
                                                        paths: task.paths,
                                                        notes: task.notes,
                                                        taskname: task.name,
                                                        taskstatus: task.status,
                                                        taskid: task.task_id,
                                                        progress_percent:task.progress_percent,
                                                        allDay: true
                                                    };
                                                });
                                            } else {
                                                var events = getUser.map(task => {
                                                    return {
                                                        title: task.title,
                                                        color: task.priority,
                                                        description: task.description,
                                                        start: task.start_date,
                                                        dateStart: task.start_date,
                                                        dateEnd: task.end_date,
                                                        paths: task.paths,
                                                        notes: task.notes,
                                                        taskname: task.name,
                                                        taskstatus: task.status,
                                                        taskid: task.task_id,
                                                        progress_percent:task.progress_percent,
                                                        allDay: true
                                                    };
                                                });
                                            }
                                            jQuery('#calendar').fullCalendar({
                                                themeSystem: 'bootstrap4',

                                                businessHours: false,
                                                defaultView: 'month',

                                                editable: true,
                                                // header
                                                header: {
                                                    left: 'title',
                                                    center: 'month,agendaWeek,agendaDay',
                                                    right: 'today prev,next'
                                                },

                                                events: events,
                                                eventRender: function(event, element) {
                                                    if (event.icon) {
                                                        element.find(".fc-title").prepend("<i class='fa fa-" + event.icon +
                                                            "'></i>");
                                                    }
                                                },


                                                dayClick: function(date, jsEvent, view) {
                                                    var clickedDate = date.format('YYYY-MM-DD');
                                                    var currentTime = moment().format('HH:mm');
                                                    var combinedDateTime = clickedDate + 'T' + currentTime;
                                                    $('input[name="startdate"]').val(combinedDateTime);
                                                    if (accountaddTasks && accountaddTasks.length > 0) {
                                                        jQuery('#modal-view-event-add').modal();
                                                    }
                                                },

                                                eventClick: function(event, jsEvent, view) {
                                                    jQuery('.event-icon').html("<i class='fa fa-" + event.icon + "'></i>");
                                                    jQuery('.event-title').val(event.title);
                                                    jQuery('.event-body').val(event.description);
                                                    var formattedDate = moment(event.dateStart).format('YYYY-MM-DDTHH:mm');
                                                    jQuery('.event-startdate').val(formattedDate);

                                                    var formattendDate = moment(event.dateEnd).format('YYYY-MM-DDTHH:mm');
                                                    jQuery('.event-enddate').val(formattendDate);

                                                    jQuery('.event-paths').val(event.paths);
                                                    jQuery('.event-notes').val(event.notes);

                                                    jQuery('.event-taskname').html(event.taskname);


                                                    var taskId = event.taskid;
                                                    var form = document.getElementById('updateTaskForm');
                                                    form.action = "{{ route('tasks.update', ['task_id' => 'x']) }}".replace('x',
                                                        taskId);

                                                   
                                                    var newHref = "{{ route('tasks.detail', ['task_id' => 'x']) }}".replace('x', taskId);
                                                    $('#detailTaskForm').attr('href', newHref);

                                                    var taskStatusValue = event.taskstatus;
                                                    jQuery('.status option[value="' + taskStatusValue + '"]').prop('selected',
                                                        true);

                                                    var taskPriorityValue = event.color;
                                                    jQuery('.priority option[value="' + taskPriorityValue + '"]').prop(
                                                        'selected', true);
                                                    
                                                    $("#range-slider-basic").data("ionRangeSlider").update({ from: event.progress_percent });
                                                    jQuery('.eventUrl').attr('href', event.url);
                                                    jQuery('#modal-view-event').modal();
                                                },
                                            })
                                        });

                                    })(jQuery);
                                </script>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2">
                        <h5 style="border-bottom: 2px solid #000 ;display: inline-block;" class="font-weight-bold">Ghi chú
                        </h5>
                        <div>
                            <div class="d-flex mb-3">
                                <button style="background-color: blue;
                            border: none;"
                                    class="mr-2 px-3"></button>
                                <p style="font-size: 13px" class="m-0">Ưu tiền thấp</p>
                            </div>

                            <div class="d-flex mb-3">
                                <button style="background-color: orange;
                            border: none;"
                                    class="mr-2 px-3"></button>
                               
                                <p style="font-size: 13px" class="m-0"> Ưu tiền trung bình</p>
                            </div>

                            <div class="d-flex mb-3">
                                <button style="background-color: red;
                            border: none;"
                                    class="mr-2 px-3"></button>
                                    <p style="font-size: 13px" class="m-0"> Ưu tiền cao</p>
                               
                            </div>

                            <div class="d-none mb-3">
                                <button style="background-color: green;
                            border: none;"
                                    class="mr-2 px-3"></button>
                                Công việc của bạn
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <script>
                    var success = @json($success);
                    if (success != null) {
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

                
            @endsection
