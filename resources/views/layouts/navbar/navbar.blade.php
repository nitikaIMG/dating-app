{{-- <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
    <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
        <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><i class="ri-close-line menu-hamburger-close"></i></a>
    </div> 
    <div class="infobar-settings-sidebar-body">
        <div class="custom-mode-setting">
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Payment Reminders</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-first" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Stock Updates</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-second" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Open for New Products</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-third" /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Enable SMS</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Newsletter Subscription</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Show Map</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-sixth" /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">e-Statement</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
            </div>
            <div class="row align-items-center">
                <div class="col-8"><h6 class="mb-0">Monthly Report</h6></div>
                <div class="col-4"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
            </div>
        </div>
    </div>
</div>
<div class="infobar-settings-sidebar-overlay"></div> --}}


<div class="topbar-mobile">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="mobile-logobar">
                <a href="index.html" class="mobile-logo"><img src="{{asset('public/assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
            </div>
            <div class="mobile-togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="topbar-toggle-icon">
                            <a class="topbar-toggle-hamburger" href="javascript:void();">
                                <i class="ri-more-fill menu-hamburger-horizontal"></i>
                                <i class="ri-more-2-fill menu-hamburger-vertical"></i>
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="javascript:void();">
                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                <i class="ri-close-line menu-hamburger-close"></i>
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
                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                <i class="ri-close-line menu-hamburger-close"></i>
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="searchbar">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon2"><i class="ri-search-2-line"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="infobar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="settingbar">
                            <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon"><i class="ri-settings-line"></i></a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="notifybar">
                            <div class="dropdown">
                                <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ri-notification-line"></i>
                                <span class="live-icon"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                    <div class="notification-dropdown-title">
                                        <h5>Notifications<a href="#">Clear all</a></h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-primary"><i class="ri-bank-card-2-line"></i></span>
                                            <div class="media-body">
                                                <h5 class="action-title">Payment Success !!!</h5>
                                                <p><span class="timing">Today, 09:05 AM</span></p>
                                            </div>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-success"><i class="ri-file-user-line"></i></span>
                                            <div class="media-body">
                                                <h5 class="action-title">Riva applied for job</h5>
                                                <p><span class="timing">Yesterday, 02:30 PM</span></p>
                                            </div>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-secondary"><i class="ri-pencil-line"></i></span>
                                            <div class="media-body">
                                                <h5 class="action-title">Maria requested to leave</h5>
                                                <p><span class="timing">5 June 2020, 12:10 PM</span></p>
                                            </div>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-warning"><i class="ri-shopping-cart-line"></i></span>
                                            <div class="media-body">
                                                <h5 class="action-title">New order placed</h5>
                                                <p><span class="timing">1 Jun 2020, 04:40 PM</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="notification-dropdown-footer">
                                        <h5><a href="#">See all</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="languagebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-us flag-icon-squared"></i></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                    <a class="dropdown-item" href="#"><i class="flag flag-icon-us flag-icon-squared"></i>English</a>
                                    <a class="dropdown-item" href="#"><i class="flag flag-icon-de flag-icon-squared"></i>German</a>
                                    <a class="dropdown-item" href="#"><i class="flag flag-icon-bl flag-icon-squared"></i>France</a>
                                    <a class="dropdown-item" href="#"><i class="flag flag-icon-ru flag-icon-squared"></i>Russian</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="profilebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('public/assets/images/users/profile.svg')}}" class="img-fluid" alt="profile"><span class="live-icon">{{Auth::user()->name}}</span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                    <a class="dropdown-item" href="#"><i class="ri-user-6-line"></i>My Profile</a>
                                    <a class="dropdown-item" href="#"><i class="ri-mail-line"></i>Email</a>
                                    <a class="dropdown-item" href="#"><i class="ri-settings-3-line"></i>Settings</a>
                                        <a class="dropdown-item text-danger"  href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                         <i class="ri-shut-down-line"></i>
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
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