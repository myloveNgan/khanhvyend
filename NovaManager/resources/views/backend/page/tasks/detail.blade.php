<?php
use App\Http\Controllers\Backend\TasksController;
$user = session('user');
$check = TasksController::getCheckTaskByAccount($user->account_id, $task->task_id);
$employees = TasksController::getAccountByTask($task->task_id);
?>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Tài khoản</h4>
            <div>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/admin">Trang chủ</a></li>


                    <li class="breadcrumb-item active">Danh sách tài khoản</li>

                </ol>


            </div>
        </div>
    @endsection
    @section('content')
    @if($check == false)
        <form method="post" action="{{ route('tasks.update', ['task_id' => $task->task_id]) }}"
            class="event-taskid modal-content" id="updateTaskForm">
            @csrf
            <div class="modal-body">
                <input name="title" type="text" style="font-size: 30px; color: #000"
                    class="text-capitalize font-weight-bold event-title form-control border-0 text-center"
                    placeholder="Tên tiêu đề " value="{{ $task->title }}">
                <div class="">
                    <h6 class="font-weight-bold">Chi tiết công việc :
                        <textarea name="description" placeholder="Chi tiết công việc"
                            id=""class="col-12 form-control border-0 event-body" rows="2">{{ $task->description }}</textarea>
                    </h6>

                </div>
                <div class="event-date">
                    <h6 class="font-weight-bold">Thời gian:
                        <div class="row">
                            <input type='datetime-local' class="form-control event-startdate col-md-5" name="startdate"
                                value="{{ $task->start_date }}">
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                đến
                            </div>

                            <input type='datetime-local' class="form-control event-enddate col-md-5" name="enddate"
                                value="{{ $task->end_date }}">
                        </div>
                    </h6>

                </div>

                <div class="">
                    <h6 class="font-weight-bold">Đường dẫn:
                        <input name="paths" type="text" class="event-paths col-12 form-control border-0"
                            value="{{ $task->paths }}">
                    </h6>
                </div>

                <div class="">
                    <h6 class="font-weight-bold">Ghi chú:
                        <textarea name="notes" placeholder="Chi tiết công việc" id=""class="col-12 form-control border-0 event-notes"
                            rows="2">{{ $task->notes }}</textarea>
                    </h6>
                </div>


                <div class="">
                    <h6 class="font-weight-bold"> Người được giao việc:
                        @foreach ($employees as $items)
                            <span class="event-taskname text-capitalize mr-2">
                                {{ $items->name }}
                            </span>
                        @endforeach
                    </h6>
                </div>

                <div class="d-flex row algin-items-center">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Trạng thái :</label>
                        <select name="taskstatus" class="status form-control">
                            <option {{ $task->status == 'Chưa hoàn thành' ? 'selected' : '' }} value="Chưa hoàn thành">Chưa
                                hoàn thành</option>
                            <option {{ $task->status == 'Đang làm' ? 'selected' : '' }} value="Đang làm">Đang làm</option>
                            <option {{ $task->status == 'Hoàn thành' ? 'selected' : '' }} value="Hoàn thành">Hoàn thành
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Mức độ ưu tiên công việc</label>
                        <select class="form-control priority" name="priority">
                            <option {{ $task->priority == 'blue' ? 'selected' : '' }} value="blue">Ưu tiên thấp</option>
                            <option {{ $task->priority == 'orange' ? 'selected' : '' }} value="orange">Ưu tiên trung bình
                            </option>
                            <option {{ $task->priority == 'red' ? 'selected' : '' }} value="red">Ưu tiên cao</option>
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
                                from: {{ $task->progress_percent }}
                            });

                        });
                    </script>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary edit_role_none">Sửa</button>
            </div>
        </form>
    @endif
    @if($check)
       h
    @endif
    @endsection
