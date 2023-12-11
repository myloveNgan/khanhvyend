<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/soyuz/html/light-vertical/user-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Nov 2023 11:40:17 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Soyuz is a bootstrap 4x + laravel admin dashboard template">
    <meta name="keywords" content="admin, admin dashboard, admin panel, admin template, analytics, bootstrap 4, laravel, clean, crm, ecommerce, hospital, responsive, rtl, sass support, ui kits">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <!-- Start css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- End css -->
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('account.checklogin') }}" method="POST">
										@csrf
                                        <div class="form-head">
                                            <a href="index.html" class="logo"><img src="{{ asset('backend/assets/images/nova-logo.png') }}" class="img-fluid" alt="logo"></a>
                                        </div>                                        
                                        <h4  style="color: #7CC150">Đăng nhập</h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu đăng nhập" required>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-6 d-none">
                                                <div class="custom-control custom-checkbox text-left">
                                                  <input type="checkbox" class="custom-control-input" id="rememberme">
                                                  <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                                                </div>                                
                                            </div>
                                            <div class="col-sm-6 d-none">
                                              <div class="forgot-psw"> 
                                                <a id="forgot-psw" href="" class="font-14">Forgot Password?</a>
                                              </div>
                                            </div>
                                        </div>                          
                                      <button type="submit" class="btn btn-success btn-lg btn-block font-18">Đăng nhập</button>
                                    </form>
                                    <div class="login-or d-none">
                                        <h6 class="text-muted">OR</h6>
                                    </div>
                                    {{-- <div class="button-list text-center">
                                        <button type="submit" class="btn btn-primary-rgba font-18"><i class="mdi mdi-facebook mr-2"></i>Facebook</button>
                                        <button type="submit" class="btn btn-danger-rgba font-18"><i class="mdi mdi-google mr-2"></i>Google</button>
                                    </div> --}}
                                    <p class="mb-0 mt-3 d-none">Don't have a account? <a href="">Sign up</a></p>
                                </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/detect.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>
    <!-- End js -->
    <script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>

<!-- Mirrored from themesbox.in/admin-templates/soyuz/html/light-vertical/user-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Nov 2023 11:40:17 GMT -->
</html>