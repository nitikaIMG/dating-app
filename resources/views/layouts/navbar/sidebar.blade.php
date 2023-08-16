<!-- Start Leftbar -->
<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Logobar -->
        <div class="logobar">
            <a href="{{ route('dashboard') }}" class="logo logo-large" style="color: aqua;font-weight:bold;"><img
                    src="{{ asset('public/assets/images/logo11.png') }}" width="70px" class="img-fluid"
                    alt="logo">MatchMingle</a>
            <a href="{{ route('dashboard') }}" class="logo logo-small">MatchMingle</a>
        </div>
        <!-- End Logobar -->
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li>
                        <a href="dashboard-ecommerce.html">
                            <i class="ri-store-2-fill"></i><span>E-Commerce</span>
                        </a>
                    </li> --}}
                {{-- <li>
                        <a href="dashboard-hospital.html">
                            <i class="ri-hospital-fill"></i><span>Hospital</span>
                        </a>
                    </li> --}}
                <li class="vertical-header"></li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ri-user-6-fill"></i><span>All Users</span><i class="ri-arrow-right-s-line"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="feather icon-server"></i><span>Explore</span><i class="ri-arrow-right-s-line"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('explore.index') }}">Explores</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ri-apps-line"></i><span>Subscription</span><i class="ri-arrow-right-s-line"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('subscription.index') }}">Subscriptions</a></li>
                        {{-- <li><a href="apps-chat.html">Chat</a></li>
                            <li>
                                <a href="javaScript:void();">Email<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="apps-email-inbox.html">Inbox</a></li>
                                    <li><a href="apps-email-open.html">Open</a></li>
                                    <li><a href="apps-email-compose.html">Compose</a></li>
                                </ul>
                            </li>
                            <li><a href="apps-kanban-board.html">Kanban Board</a></li>
                            <li><a href="apps-onboarding-screens.html">Onboarding Screens</a></li> --}}
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <i class="fa fa-info-circle" aria-hidden="true"></i><span>Users Basic</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="{{route('zodiac.index')}}">Zodiacs</a></li>
                            <li><a href="{{route('education.index')}}">Education Levels</a></li>
                            <li><a href="{{route('personality.index')}}">Personality Type</a></li>
                            <li><a href="{{route('communication.index')}}">Communication Style</a></li>
                            <li><a href="{{route('children.index')}}">Children Q.</a></li>
                            <li><a href="{{route('receivelove.index')}}">Receive Love</a></li>
                            <li><a href="{{route('relationship_goal.index')}}">Relationship Goal</a></li>
                            <li><a href="{{route('relationship_type.index')}}">Relationship Type</a></li>
                            <li><a href="{{route('vaccine.index')}}">Vaccine Q.</a></li>
                            <li><a href="{{route('pet.index')}}">Pets Q.</a></li>
                            <li><a href="{{route('drinking.index')}}">Drink Q.</a></li>
                            <li><a href="{{route('smoke.index')}}">Smoke Q.</a></li>
                            <li><a href="{{route('dietary.index')}}">Dietary Preference Q.</a></li>
                            <li><a href="{{route('sleepinghabit.index')}}">Sleeping Habit Q.</a></li>
                            <li><a href="{{route('workout.index')}}">Workout</a></li>
                            <li><a href="{{route('languages.index')}}">Languages</a></li>
                            <li><a href="{{route('passion.index')}}">Passion</a></li>
                            <li><a href="{{route('sexualorientation.index')}}">Sexual Orientation</a></li>
                             {{-- <li><a href="apps-chat.html">Chat</a></li> --}}
                            {{-- <li>
                                <a href="javaScript:void();">Zodiac<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{route('zodiac.index')}}">zodiacs</a></li>
                                </ul>
                            </li> --}}
                        {{--
                            <li><a href="apps-kanban-board.html">Kanban Board</a></li>
                            <li><a href="apps-onboarding-screens.html">Onboarding Screens</a></li> --}}
                    </ul>
                </li>
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-file-copy-2-line"></i><span>Forms</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="form-inputs.html">Basic Elements</a></li>
                            <li><a href="form-groups.html">Groups</a></li>
                            <li><a href="form-layouts.html">Layouts</a></li>
                            <li><a href="form-colorpickers.html">Color Pickers</a></li>
                            <li><a href="form-datepickers.html">Date Pickers</a></li>
                            <li><a href="form-editors.html">Editors</a></li>
                            <li><a href="form-file-uploads.html">File Uploads</a></li>
                            <li><a href="form-input-mask.html">Input Mask</a></li>
                            <li><a href="form-maxlength.html">MaxLength</a></li>
                            <li><a href="form-selects.html">Selects</a></li>
                            <li><a href="form-touchspin.html">Touchspin</a></li>
                            <li><a href="form-validations.html">Validations</a></li>
                            <li><a href="form-wizards.html">Wizards</a></li>
                            <li><a href="form-xeditable.html">X-editable</a></li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-pie-chart-line"></i><span>Charts</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="chart-apex.html">Apex</a></li>
                            <li><a href="chart-c3.html">C3</a></li>
                            <li><a href="chart-chartistjs.html">Chartist</a></li>
                            <li><a href="chart-chartjs.html">Chartjs</a></li>
                            <li><a href="chart-flot.html">Flot</a></li>
                            <li><a href="chart-knob.html">Knob</a></li>
                            <li><a href="chart-morris.html">Morris</a></li>
                            <li><a href="chart-piety.html">Piety</a></li>
                            <li><a href="chart-sparkline.html">Sparkline</a></li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-service-line"></i><span>Icons</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="icon-svg.html">SVG</a></li>
                            <li><a href="icon-dripicons.html">Dripicons</a></li>
                            <li><a href="icon-feather.html">Feather</a></li>
                            <li><a href="icon-flag.html">Flag</a></li>
                            <li><a href="icon-font-awesome.html">Font Awesome</a></li>
                            <li><a href="icon-ionicons.html">Ion</a></li>
                            <li><a href="icon-line-awesome.html">Line Awesome</a></li>
                            <li><a href="icon-material-design.html">Material Design</a></li>
                            <li><a href="icon-remixicon.html">Remixicon</a></li>
                            <li><a href="icon-simple-line.html">Simple Line</a></li>
                            <li><a href="icon-socicon.html">Socicon</a></li>
                            <li><a href="icon-themify.html">Themify</a></li>
                            <li><a href="icon-typicons.html">Typicons</a></li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-table-line"></i><span>Tables</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="table-bootstrap.html">Bootstrap</a></li>
                            <li><a href="table-datatable.html">Datatable</a></li>
                            <li><a href="table-editable.html">Editable</a></li>
                            <li><a href="table-footable.html">Foo</a></li>
                            <li><a href="table-rwdtable.html">RWD</a></li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-map-pin-line"></i><span>Maps</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="map-google.html">Google</a></li>
                            <li><a href="map-vector.html">Vector</a></li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="javaScript:void();">
                            <i class="ri-pages-line"></i><span>Pages</span><i class="ri-arrow-right-s-line"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li>
                                <a href="javaScript:void();">Basic<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="page-starter.html">Starter</a></li>
                                    <li><a href="page-blog.html">Blog</a></li>
                                    <li><a href="page-faq.html">FAQ</a></li>
                                    <li><a href="page-gallery.html">Gallery</a></li>
                                    <li><a href="page-invoice.html">Invoice</a></li>
                                    <li><a href="page-pricing.html">Pricing</a></li>
                                    <li><a href="page-timeline.html">Timeline</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">Store<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="ecommerce-product-list.html">Product List</a></li>
                                    <li><a href="ecommerce-product-detail.html">Product Detail</a></li>
                                    <li><a href="ecommerce-order-list.html">Order List</a></li>
                                    <li><a href="ecommerce-order-detail.html">Order Detail</a></li>
                                    <li><a href="ecommerce-shop.html">Shop</a></li>
                                    <li><a href="ecommerce-single-product.html">Single Product</a></li>
                                    <li><a href="ecommerce-cart.html">Cart</a></li>
                                    <li><a href="ecommerce-checkout.html">Checkout</a></li>
                                    <li><a href="ecommerce-thankyou.html">Thank You</a></li>
                                    <li><a href="ecommerce-myaccount.html">My Account</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">Authentication<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="user-login.html">Login</a></li>
                                    <li><a href="user-register.html">Register</a></li>
                                    <li><a href="user-forgotpsw.html">Forgot Password</a></li>
                                    <li><a href="user-lock-screen.html">Lock Screen</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">Error<i class="ri-arrow-right-s-line"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="error-comingsoon.html">Coming Soon</a></li>
                                    <li><a href="error-maintenance.html">Maintenance</a></li>
                                    <li><a href="error-404.html">Error 404</a></li>
                                    <li><a href="error-500.html">Error 500</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}
                {{-- <li>
                        <a href="widgets.html">
                            <i class="ri-palette-line"></i><span>Widgets</span><span class="new-icon"></span>
                        </a>
                    </li> --}}
            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>
<!-- End Leftbar -->
