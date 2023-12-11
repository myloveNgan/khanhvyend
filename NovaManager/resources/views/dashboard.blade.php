<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/soyuz/html/light-vertical/hospital-appointment.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Nov 2023 11:39:10 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Soyuz is a bootstrap 4x + laravel admin dashboard template">
    <meta name="keywords" content="admin, admin dashboard, admin panel, admin template, analytics, bootstrap 4, laravel, clean, crm, ecommerce, hospital, responsive, rtl, sass support, ui kits">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <title>Admin-Novaedu</title>
    <!-- Fevicon -->
   
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <link href="{{ asset('backend/assets/plugins/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet" />
    <!-- Start css -->
    <!--pnotify -->
    <link href="{{ asset('backend/assets/plugins/pnotify/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css">
    <!--rangesSlider -->
    <link href="{{ asset('backend/assets/plugins/ion-rangeSlider/ion.rangeSlider.css') }}" rel="stylesheet" type="text/css">



    <link href="{{ asset('backend/assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet">
    <!-- jvectormap css -->
    <link href="{{ asset('backend/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{ asset('backend/assets/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/plugins/slick/slick-theme.css') }}" rel="stylesheet">

    <!-- Switchery css -->
    <link href="{{ asset('backend/assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    {{-- <link href="{{ asset('backend/assets/css/main.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('backend/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- End css -->
</head>
<body class="vertical-layout">    
    <!-- Start Infobar Setting Sidebar -->
    <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
        <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
            <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><img src="{{ asset('backend/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close" alt="close"></a>
        </div>
        <div class="infobar-settings-sidebar-body">
            <div class="custom-mode-setting">
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">New Order Notification</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-first" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Low Stock Alerts</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-second" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Vacation Mode</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-third" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Order Tracking</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Newsletter Subscription</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Show Review</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-sixth" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Enable Wallet</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-8"><h6 class="mb-0">Sales Report</h6></div>
                    <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
                </div>
            </div>
            <div class="custom-layout-setting">
                <div class="row align-items-center pb-3">
                    <div class="col-12">
                        <h6 class="mb-3">Select Account</h6>
                    </div>
                    <div class="col-6">
                        <div class="account-box active">
                            <img src="{{ asset('backend/assets/images/users/boy.svg') }}" class="img-fluid" alt="user">
                            <h5>John</h5>
                            <p>CEO</p>
                        </div>                        
                    </div>
                    <div class="col-6">
                        <div class="account-box">
                            <img src="{{ asset('backend/assets/images/users/women.svg') }}" class="img-fluid" alt="user">
                            <h5>Kate</h5>
                            <p>COO</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="account-box">
                            <img src="{{ asset('backend/assets/images/users/men.svg') }}" class="img-fluid" alt="user">
                            <h5>Mark</h5>
                            <p>MD</p>
                        </div>                        
                    </div>
                    <div class="col-6">
                        <div class="account-box">
                            <p class="dash-analytic-icon"><i class="feather icon-plus font-35"></i></p>
                            <h5>Add</h5>
                            <p>ACCOUNT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        @include('backend.common.sidebar')
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            @include('backend.common.header')
            <!-- End Topbar -->
            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                @yield('breadcrumbbar')
                   
                @yield('add')    
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                @yield('content')
                <!-- End row -->
            </div>
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
            @include('backend.common.footer')
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    
    <script src="{{ asset('backend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/detect.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vertical-menu.js') }}"></script>
    <!-- Switchery js -->
    <script src="{{ asset('backend/assets/plugins/switchery/switchery.min.js') }}"></script>  
   
    <script src="{{ asset('backend/assets/plugins/moment/moment.js') }}"></script>  

    <script src='{{ asset('backend/assets/plugins/fullcalendar/js/fullcalendar.min.js') }}'></script>

    <script src="{{ asset('backend/assets/plugins/pnotify/js/pnotify.custom.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/js/custom/custom-pnotify.js') }}"></script> --}}

    <!-- Range Slider js -->
    <script src="{{ asset('backend/assets/plugins/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/js/custom/custom-range-slider.js') }}"></script> --}}

     <!-- Apex js -->
     <script src="{{ asset('backend/assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
     <script src="{{ asset('backend/assets/plugins/apexcharts/irregular-data-series.js') }}"></script>  
     <!-- Vector Maps js -->
     <script src="{{ asset('backend/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
     <script src="{{ asset('backend/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>  
     <!-- Slick js -->
     <script src="{{ asset('backend/assets/plugins/slick/slick.min.js') }}"></script>    
     <!-- Custom Dashboard js -->   
     <script src="{{ asset('backend/assets/js/custom/custom-dashboard.js') }}"></script>
    <!-- Core js -->
    <script src="{{ asset('backend/assets/js/core.js') }}"></script>
    
    <!-- End js -->

    
</body>

</html>