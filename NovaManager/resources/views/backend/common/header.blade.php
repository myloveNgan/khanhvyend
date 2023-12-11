<?php
use App\Http\Controllers\Backend\EmployeesController;
use App\Http\Controllers\Backend\NotificationController;
use Carbon\Carbon;
$data = session('user');
$getEmployees = EmployeesController::getEmployees($data->account_id);
$getNotifi = NotificationController::getNotifiByUser($data->account_id);
?>
<div class="topbar-mobile">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="mobile-logobar">
                <a href="index.html" class="mobile-logo"><img src="{{ asset('backend/assets/images/nova-logo.png') }}"
                        class="img-fluid" alt="logo"></a>
            </div>
            <div class="mobile-togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="topbar-toggle-icon">
                            <a class="topbar-toggle-hamburger" href="javascript:void();">
                                <img src="{{ asset('backend/assets/images/svg-icon/horizontal.svg') }}"
                                    class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                <img src="{{ asset('backend/assets/images/svg-icon/verticle.svg') }}"
                                    class="img-fluid menu-hamburger-vertical" alt="verticle">
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="javascript:void();">
                                <img src="{{ asset('backend/assets/images/svg-icon/menu.svg') }}"
                                    class="img-fluid menu-hamburger-collapse" alt="collapse">
                                <img src="{{ asset('backend/assets/images/svg-icon/close.svg') }}"
                                    class="img-fluid menu-hamburger-close" alt="close">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Start Topbar -->
<div class="topbar">
    <!-- Start row -->
    <div class="row align-items-center">
        <!-- Start col -->
        <div class="col-md-12 align-self-center">
            <div class="togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="javascript:void();">
                                <img src="{{ asset('backend/assets/images/svg-icon/menu.svg') }}"
                                    class="img-fluid menu-hamburger-collapse" alt="menu">
                                <img src="{{ asset('backend/assets/images/svg-icon/close.svg') }}"
                                    class="img-fluid menu-hamburger-close" alt="close">
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="searchbar">
                            <form>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addonSearch"><img
                                                src="{{ asset('backend/assets/images/svg-icon/search.svg') }}"
                                                class="img-fluid" alt="search"></button>
                                    </div>
                                    <input type="search" class="form-control" placeholder="Search" aria-label="Search"
                                        aria-describedby="button-addonSearch">
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="infobar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="languagebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="languagelink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                        class="live-icon">EN</span><span
                                        class="feather icon-chevron-down live-icon"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                    <a class="dropdown-item" href="#"><i
                                            class="flag flag-icon-us flag-icon-squared"></i>English</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="flag flag-icon-de flag-icon-squared"></i>German</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="flag flag-icon-bl flag-icon-squared"></i>France</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="flag flag-icon-ru flag-icon-squared"></i>Russian</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="settingbar">
                            <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon">
                                <img src="{{ asset('backend/assets/images/svg-icon/settings.svg') }}" class="img-fluid"
                                    alt="settings">
                                <span class="live-icon">3</span>
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="notifybar">
                            <div class="dropdown">
                                <a class="dropdown-toggle infobar-icon" href="#" role="button"
                                    id="notoficationlink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><img
                                        src="{{ asset('backend/assets/images/svg-icon/notifications.svg') }}"
                                        class="img-fluid" alt="notifications">
                                    <span class="live-icon">{{ NotificationController::getSumNoti($data->account_id) }}</span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                    <div class="notification-dropdown-title">
                                        <h4>Thông báo</h4>
                                    </div>
                                    <ul class="list-unstyled">
                                        @foreach ($getNotifi as $items)
                                        <a href="{{ route('notifi.delete', ['notifiId' => $items->notifi_id, 'link' => $items->link]) }}" class="media dropdown-item">
                                                <span class="action-icon badge badge-success-inverse">N</span>
                                                <?php
                                                $time1 =  $items->create_date ;
                                                $time2 = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                                                $result = NotificationController::compareTime($time1, $time2);
                                                ?>
                                                <div class="media-body">
                                                    <h5 class="action-title">{{ $items->noti_title }}</h5>
                                                    <p><span class="timing">{{ $result }}</span></p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="profilebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="profilelink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        class="rounded-circle"
                                        src="{{ asset(isset($getEmployees->images) ? 'storage/' . $getEmployees->images : 'backend/assets/images/users/profile.svg') }}"
                                        class="img-fluid" alt="profile"><span
                                        class="live-icon">{{ $getEmployees ? $getEmployees->name : 'Đang cập nhật' }}</span><span
                                        class="feather icon-chevron-down live-icon"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                    <div class="dropdown-item">
                                        <div class="profilename">
                                            <h5>{{ $getEmployees ? $getEmployees->name : 'Đang cập nhật' }}</h5>
                                        </div>
                                    </div>
                                    <div class="userbox">
                                        <ul class="list-unstyled mb-0">
                                            <li class="media dropdown-item">
                                                <a href="{{ route('employees.index', ['message' => 'mess']) }}"
                                                    class="profile-icon"><img
                                                        src="{{ asset('backend/assets/images/svg-icon/crm.svg') }}"
                                                        class="img-fluid" alt="user">Tài khoản</a>
                                            </li>
                                            <li class="media dropdown-item">
                                                <a href="#" class="profile-icon"><img
                                                        src="{{ asset('backend/assets/images/svg-icon/email.svg') }}"
                                                        class="img-fluid" alt="email">Email</a>
                                            </li>
                                            <li class="media dropdown-item">
                                                <a href="{{ route('account.logout') }}" class="profile-icon"><img
                                                        src="{{ asset('backend/assets/images/svg-icon/logout.svg') }}"
                                                        class="img-fluid" alt="logout">Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
