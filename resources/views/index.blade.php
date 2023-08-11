@extends('layouts.app')
@section('content')
    @push('custom-styles')
        <style>
            a {
                color: #000000 !important;
                text-decoration: none;
                background-color: transparent;
            }
        </style>
    @endpush
    <br>
    <br>
    <br>
    <!-- Start Breadcrumbbar -->
    {{-- <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <div class="media">
                    <span class="breadcrumb-icon"><i class="ri-user-6-fill"></i></span>
                    <div class="media-body">
                        <h4 class="page-title">CRM</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">CRM</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button class="btn btn-primary"><i class="ri-add-line align-middle mr-2"></i>ADD</button>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12 col-xl-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total User</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4>{{ count($total_user) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Active User</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4>{{ count($total_active_users) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-12 col-xl-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Males</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4>{{ count($total_user_male) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-12 col-xl-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Females</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4>{{ count($total_user_female) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Others</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4>{{ count($total_user_other) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            {{-- <div class="col-lg-12 col-xl-4">
                <div class="card m-b-30">
                    <div class="card-header text-center">
                        <h5 class="card-title mb-0">Project Status</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="apex-circle-chart"></div>
                    </div>
                </div>
            </div> --}}
            <!-- End col -->
            <!-- Start col -->
            {{-- <div class="col-lg-12 col-xl-8">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profit & Expenses</h5>
                    </div>
                    <div class="card-body py-0">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-4">
                                <h4 class="text-muted"><sup>$</sup>59876.00</h4>
                                <p>Current Balance</p>
                                <ul class="list-unstyled my-5">
                                    <li><i class="ri-checkbox-blank-circle-fill text-primary font-10 mr-2"></i>Amount Earned</li>
                                    <li><i class="ri-checkbox-blank-circle-fill text-success font-10 mr-2"></i>Amount Spent</li>
                                </ul>
                                <button type="button" class="btn btn-primary">Export<i class="ri-arrow-right-line align-middle ml-2"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-8">
                                <div id="apex-horizontal-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- End col -->
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12 col-xl-6">
                <div class="card m-b-30">
                    {{-- <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6 col-lg-9">
                                <h5 class="card-title mb-0">Latest Projects</h5>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select class="form-control font-12">
                                    <option value="class1" selected>Jan 20</option>
                                    <option value="class2">Feb 20</option>
                                    <option value="class3">Mar 20</option>
                                    <option value="class4">Apr 20</option>
                                    <option value="class5">May 20</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"> Profile Image</th>
                                        <th scope="col"> Name</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Age</th>
                                        {{-- <th scope="col">Price</th> --}}
                                        <th scope="col">Online Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @forelse($active_users as $user)
                                        <tr>
                                            <th scope="row">{{ $count++ }}</th>

                                            <td> <a href="{{ route('users.edit', $user->id) }}" class="active-list"><img
                                                        src="{{ asset($user->profile_image) }}" width="50px"
                                                        height="50px" srcset=""></a></td>

                                            <td><a href="{{ route('users.edit', $user->id) }}"
                                                    class="active-list">{{ $user->name }}</a></td>
                                            <td><a href="{{ route('users.edit', $user->id) }}"
                                                    class="active-list">{{ $user->phone }}</a></td>
                                            <td><a href="{{ route('users.edit', $user->id) }}"
                                                    class="active-list">{{ $user->age }}</a></td>
                                            
                                            <td><span class="badge badge-success"><a
                                                        href="{{ route('users.edit', $user->id) }}"
                                                        class="active-list">Active</a></span></td>
                                        </tr>
                                    @empty
                                        <span>NO One Is Online</span>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- {{ $active_users->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-12 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header text-center">
                        <h5 class="card-title mb-0">Top Profiles</h5>
                    </div>
                    <div class="card-body">
                        {{-- @dd(top_rated_profile()); --}}
                        <div class="user-slider">
                            @forelse($new as $user)
                                <div class="user-slider-item">
                                    <div class="card-body text-center">
                                        @php
                                            $firstCharacter = substr($user->first_name, 0, 2);
                                        @endphp
                                        <a href="{{ route('users.edit', $user->id) }}">
                                            <span
                                                class="action-icon badge badge-primary-inverse">{{ $firstCharacter }}</span>
                                            <h5>{{ $user->name }}</h5>
                                            <p>{{ $user->phone }}</p>
                                            <p class="mt-3 mb-0"><span
                                                    class="badge badge-primary font-weight-normal font-14 py-1 px-2">Most
                                                    Liked Persons</span></p>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <span>None</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            {{-- <div class="col-lg-12 col-xl-3">
                <div class="card bg-secondary-rgba text-center m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Achievements</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{asset('public/assets/images/general/winner.svg')}}" class="img-fluid img-winner" alt="achievements">
                        <h5 class="my-0">Worked more than 40 hours for 3 weeks.</h5>
                    </div>
                </div>
            </div> --}}
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    <!-- Start Footerbar -->
    <div class="footerbar">
        <footer class="footer">
            <p class="mb-0">© 2020 Minaati - All Rights Reserved.</p>
        </footer>
    </div>
@endsection
