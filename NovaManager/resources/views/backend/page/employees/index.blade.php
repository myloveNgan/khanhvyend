<?php
if ($message == 'mess') {
    $message = null;
}
if (isset($message)) {
    echo "<script>
            setTimeout(function() {
                alert('$message ');
            }, 1000);
          </script>";
}
use App\Http\Controllers\Backend\EmployeesController;
use App\Http\Controllers\Backend\AccountController;
$data = session('user');
$getEmployees = EmployeesController::getEmployees($data->account_id);

$account = AccountController::getAccount($data->account_id);
?>
@extends('dashboard')
@section('breadcrumbbar')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Tài khoản</h4>
    </div>
@endsection
@section('content')

  {{-- test --}}
  <div class="row">
    <!-- Start col -->
    <div class="col-lg-5 col-xl-3">
        <div class="card m-b-30">
            <div class="card-header">                                
                <h5 class="card-title mb-0">Tài khoản</h5>
            </div>
            <div class="card-body">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-2 active" id="v-pills-dashboard-tab" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="true"><i class="feather icon-grid mr-2"></i>Thông tin cá nhân</a>
                    <a class="nav-link mb-2" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-user mr-2"></i>Thay đổi thông tin</a>
                    <a class="nav-link" id="v-pills-logout-tab" data-toggle="pill" href="#v-pills-logout" role="tab" aria-controls="v-pills-logout" aria-selected="false"><i class="feather icon-log-out mr-2"></i>Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-lg-7 col-xl-9">
        <div class="tab-content" id="v-pills-tabContent">
            <!-- Dashboard Start -->
            <div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <h5 class="card-title mb-0">Thông tin cá nhân</h5>
                    </div>
                    <div class="card-body">
                        <div class="profilebox py-4 text-center">
                            @if($getEmployees != null)
                            <img class="rounded-circle" style="height: 100px" src="{{ asset('storage/' . $getEmployees->images) }}" alt="">
                            @endif
                            <div class="profilename">
                                <h5>{{ $getEmployees->name }}</h5>
                                <p class="text-muted my-3"><a href="my-account.html"><i class="feather icon-edit-2 mr-2"></i>Edit Profile</a></p>
                            </div>
                            <div class="button-list">
                                <a href="#" class="btn btn-primary-rgba font-18"><i class="feather icon-facebook"></i></a>
                                <a href="#" class="btn btn-info-rgba font-18"><i class="feather icon-twitter"></i></a>
                                <a href="#" class="btn btn-danger-rgba font-18"><i class="feather icon-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <div class="ecom-dashboard-widget">
                                    <div class="media">
                                        <i class="feather icon-package"></i>
                                        <div class="media-body">
                                            <h5>My Orders</h5>
                                            <p>Pending (1)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <div class="ecom-dashboard-widget">
                                    <div class="media">
                                        <i class="feather icon-heart"></i>
                                        <div class="media-body">
                                            <h5>My Wishlist</h5>
                                            <p>Items (5)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <div class="ecom-dashboard-widget">
                                    <div class="media">
                                        <i class="feather icon-credit-card"></i>
                                        <div class="media-body">
                                            <h5>My Wallet</h5>
                                            <p>Balance ($90)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>  
                <!-- End row -->
            </div>
            
            
            <!-- My Profile Start -->
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="{{ route('employees.create',['account'=>$data->account_id]) }}" method="post"  enctype="multipart/form-data">
                          @csrf
                          <div class="card-body">
                            <div class="profilebox pt-4 text-center">
                                <ul class="list-inline d-flex">
                                    <li class="list-inline-item col-md-6">
                                      @if($getEmployees != null)
                                      <img class="rounded-circle" style="height: 100px" src="{{ asset('storage/' . $getEmployees->images) }}" alt="">
                                      @endif
                                    </li>
                                    <div class="col-md-6">
                                        <input placeholder="Chọn ảnh" name="images" class="form-control form-control-lg" id="formFileLg" type="file">
                                    </div>
                                    
                                </ul>
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  
                                    <label for="username">Họ và tên</label>
                                    <input type="text" value="{{ $getEmployees ? $getEmployees->name : '' }}" name="name" class="form-control" placeholder="Họ và tên." required id="username">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="useremail">Email</label>
                                <input type="email" value="{{ $getEmployees ? $getEmployees->email : '' }}" class="form-control" name="email" id="useremail" placeholder="Nhập email của bạn." required>
                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="usermobile">Số điện thoại</label>
                                <input type="text" value="{{ $getEmployees ? $getEmployees->phone : '' }}" class="form-control" name="phone" id="usermobile" placeholder="Số điện thoại." required>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="userbirthdate">Ngày sinh</label>
                                  <input type="date" value="{{$getEmployees ? $getEmployees->date : '' }}" class="form-control" name="date" id="userbirthdate" placeholder="Ngày sinh" required>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="usermale" name="gender" class="custom-control-input" value="Nam" {{ $getEmployees && $getEmployees->gender == 'Nam' ? 'checked' : '' }}>
                                  <label class="custom-control-label" for="usermale">Nam</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="userfemale" name="gender" class="custom-control-input" value="Nữ" {{ $getEmployees && $getEmployees->gender == 'Nữ' ? 'checked' : '' }}>
                                  <label class="custom-control-label" for="userfemale">Nữ</label>
                              </div>
                              
                            </div>
                            <button type="submit" class="btn btn-primary-rgba font-16"><i class="feather icon-save mr-2"></i>Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- My Profile End -->
            <!-- My Logout Start -->
            <div class="tab-pane fade" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <h5 class="card-title mb-0">Logout</h5>                                       
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-xl-4">
                                <div class="logout-content text-center my-5">
                                    <img src="{{ asset('backend/assets/images/ecommerce/logout.svg') }}" class="img-fluid mb-5" alt="logout">
                                    <h2 class="text-success">Logout ?</h2>
                                    <p class="my-4">Bạn có chắc chắn muốn Đăng xuất? Chúc bạn có một ngày làm việc vui vẻ.</p>
                                    <div class="button-list">
                                        <a href="{{ route('account.logout') }}" type="button" class="btn btn-danger font-16 text-white"><i class="feather icon-check mr-2"></i>Yes, I'm sure</a>
                                        {{-- <button type="button" class="btn btn-success-rgba font-16"><i class="feather icon-x mr-2"></i>Cancel</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- My Logout End -->                            
        </div>                        
    </div>
    <!-- End col -->
</div>
  {{-- end test --}}
  <!-- /.container -->
  <script>
    const canvas = document.getElementById('draw');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
ctx.strokeStyle = 'BADA55';
// ctx.lineJoin = 'round';
ctx.lineCap = 'round';
ctx.lineWidth = 100;
// ctx.globalCompositeOperation = 'xor'

let isDrawing = false;
let lastX;
let lastY;
let hue = 0
let direction = true

function draw(e) {
  if (!isDrawing) return
  ctx.strokeStyle = `hsl(${hue}, 100%, 50%)`;
  ctx.lineWidth = 0;
  ctx.beginPath();
  ctx.moveTo(lastX, lastY);
  ctx.lineTo(e.offsetX, e.offsetY);
  ctx.stroke();
  lastX = e.offsetX;
  lastY = e.offsetY;
  hue++;
  if (hue >= 360) {
    hue = 0 ;
  }
  if ( ctx.lineWidth >= 100 || ctx.lineWidth <= 1 ) {
    direction = !direction
  }
  direction ? ctx.lineWidth++ : ctx.lineWidth--
}

canvas.addEventListener('mousedown',(e) => {
  isDrawing = true
  lastX = e.offsetX
  lastY = e.offsetY

})

canvas.addEventListener('mousemove',draw)

canvas.addEventListener('mouseup',() => isDrawing = false)
canvas.addEventListener('mouseout',() => isDrawing = false)
  </script>
@endsection
