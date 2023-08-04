@extends('layouts.app1')
@section('content')
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
                                <form action="#">
                                    <div class="form-head">
                                        <a href="index.html" class="logo"><img src="{{asset('public/assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                                    </div>                                        
                                    <h4 class="text-primary my-4">Log in !</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username" placeholder="Email ID" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-checkbox text-left">
                                              <input type="checkbox" class="custom-control-input" id="rememberme">
                                              <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                                            </div>                                
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="forgot-psw"> 
                                            <a id="forgot-psw" href="user-forgotpsw.html" class="font-14">Forgot Password?</a>
                                          </div>
                                        </div>
                                    </div>                          
                                  <button type="submit" class="btn btn-success btn-lg btn-block font-18">Log in</button>
                                </form>
                                <div class="login-or">
                                    <h6 class="text-muted">OR</h6>
                                </div>
                                <div class="social-login text-center">
                                    <button type="submit" class="btn btn-primary rounded-circle font-18"><i class="ri-facebook-line"></i></button>
                                    <button type="submit" class="btn btn-danger rounded-circle font-18 ml-2"><i class="ri-google-line"></i></button>
                                </div>
                                <p class="mb-0 mt-3">Don't have a account? <a href="user-register.html">Sign up</a></p>
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
@endsection