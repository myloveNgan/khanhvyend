@php
    $permissions = session('permissions');

    $currentPath = $_SERVER['REQUEST_URI'];
    $showTask = (strpos($currentPath, 'tasks') !== false)  ? 'show active' : '';
    $showRole = (strpos($currentPath, 'role') !== false)  ? 'show' : '';
    $showAccount = (strpos($currentPath, 'employeeslist') !== false || strpos($currentPath, 'account') !== false || strpos($currentPath, 'admin') !== false || strpos($currentPath, 'role') !== false || strpos($currentPath, 'permision') !== false || strpos($currentPath, 'employees') !== false ) ? 'show active' : '';
@endphp
    @if($permissions['create'] == 0)
    <style>
            .add_role_none{
                display: none
            } 
    </style>
    @endif

    @if($permissions['delete'] == 0)
    <style>
            .delete_role_none{
                display: none
            } 
    </style>
    @endif

    @if($permissions['edit'] == 0)
    <style>
            .edit_role_none{
                display: none
            } 
    </style>
    @endif

    @if($permissions['read'] == 0)
    <style>
            .read_role_none{
                display: none
            } 
    </style>
    @endif

<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">               
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <div class="vertical-menu-icon">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <div class="logobar">
                        <a href="" class="logo logo-small"><img src="{{ asset('backend/assets/images/small_logo.svg') }}" class="img-fluid" alt="logo"></a>
                    </div>
                    <a class="nav-link" id="v-pills-uikits-tab" data-toggle="pill" href="#v-pills-uikits" role="tab" aria-controls="v-pills-uikits" aria-selected="false"><img src="{{ asset('backend/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="UI Kits" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thống kế"></a>
                    <a class="nav-link active" id="v-pills-pages-tab" data-toggle="pill" href="#v-pills-pages" role="tab" aria-controls="v-pills-pages" aria-selected="true"><img src="{{ asset('backend/assets/images/svg-icon/crm.svg') }}" class="img-fluid" alt="Pages" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quản lý nhân sự"></a>
                    <a class="nav-link" id="v-pills-ecommerce-tab" data-toggle="pill" href="#v-pills-ecommerce" role="tab" aria-controls="v-pills-ecommerce" aria-selected="false"><img src="{{ asset('backend/assets/images/svg-icon/ui-kits.svg') }}" class="img-fluid" alt="eCommerce" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quản lý doanh thu"></a>                            
                    <a class="nav-link" id="v-pills-hospital-tab" data-toggle="pill" href="#v-pills-hospital" role="tab" aria-controls="v-pills-hospital" aria-selected="false"><img src="{{ asset('backend/assets/images/svg-icon/hospital.svg') }}" class="img-fluid" alt="Hospital" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quản lý lịch làm việc, giao việc"></a>
                   
                </div>
            </div>
            <div class="vertical-menu-detail">
                <div class="logobar">
                    <a href="/" class="logo logo-large"><img src="{{ asset('backend/assets/images/nova-logo.png') }}" class="img-fluid" alt="logo"></a>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade {{ $showAccount }}" id="v-pills-pages" role="tabpanel" aria-labelledby="v-pills-pages-tab">
                        <ul class="vertical-menu in">
                            <li><h5 class="menu-title">Quản lý nhân sự</h5></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="{{ asset('backend/assets/images/svg-icon/basic_page.svg') }}" class="img-fluid" alt="basic_page"><span>Quản lý nhân sự</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{ route('account.index',['message'=>'mess']) }}">Danh sách tài khoản</a></li>
                                    <li><a href="{{ route('employees.list',['message'=>'mess']) }}">Loại nhân sự</a></li>
                                    {{-- <li><a href="page-faq.html">Thống kê</a></li>
                                    <li><a href="page-gallery.html">Thời gian làm việc nhân sự</a></li>            --}}
                                </ul>
                            </li>     
                            
                            <li>
                                <a href="javaScript:void();">
                                  <img src="{{ asset('backend/assets/images/svg-icon/basic_page.svg') }}" class="img-fluid" alt="basic_page"><span>Phân quyền</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                  
                                    <li><a href="{{ route('role.index',['message'=>'mess']) }}">Phân quyền quản lý</a></li>
                                    <li><a href="{{ route('permision.index',['message'=>'mess']) }}">Phân quyền chức năng</a></li>
                                </ul>
                            </li>
                        </ul>

                        
                    </div>
                    <div class="tab-pane fade" id="v-pills-ecommerce" role="tabpanel" aria-labelledby="v-pills-ecommerce-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">Doanh thu</h5></li>
                            <li class="d-none"><a href="dashboard-ecommerce.html"><img src="{{ asset('backend/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="dashboard">Doanh thu</a></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="{{ asset('backend/assets/images/svg-icon/frontend.svg') }}" class="img-fluid" alt="frontend"><span>Doanh thu</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="ecommerce-shop.html">Phòng IT</a></li>
                                    <li><a href="ecommerce-single-product.html">Phòng truyền thông</a></li>
                                    <li><a href="ecommerce-cart.html">Phòng kinh doanh</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>                            
                    <div class="tab-pane fade {{ $showTask }}" id="v-pills-hospital" role="tabpanel" aria-labelledby="v-pills-hospital-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">Phân công việc</h5></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="{{ asset('backend/assets/images/svg-icon/basic.svg') }}" class="img-fluid" alt="basic"><span>Phòng ban</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{ route('tasks.index',['message'=>'mess']) }}">Quản lý công việc</a></li>
                                    {{-- <li><a href="basic-ui-kits-alerts.html">Phòng IT</a></li>
                                    <li><a href="basic-ui-kits-badges.html">Phòng TT</a></li>
                                    <li><a href="basic-ui-kits-buttons.html">Phong KD</a></li> --}}
                                    
                                </ul>
                            </li> 
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-uikits" role="tabpanel" aria-labelledby="v-pills-uikits-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">Quản lý</h5></li>
                            <li>
                                <a href="{{ route('dashboard') }}" class="active"><img src="{{ asset('backend/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="dashboard">Trang chủ</a>
                            </li>
                        </ul>                                
                    </div>
                    
                </div>
                
            </div>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>