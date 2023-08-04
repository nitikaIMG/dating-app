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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-head">
                            <a href="index.html" class="logo"><img src="{{asset('public/assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                        </div>                                        
                        <h4 class="text-primary my-4">Log in !</h4>

                        {{-- <div class="row mb-3"> --}}
                        <div class="form-group">

                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

                            {{-- <div class="col-md-6"> --}}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            {{-- </div> --}}
                        </div>

                        {{-- <div class="row mb-3"> --}}
                            <div class="form-group">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}
                            
                            {{-- <div class="col-md-6"> --}}
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                {{-- </div> --}}
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-5 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row mb-0"> --}}
                        <div class="form-group">

                            {{-- <div class="col-md-8 offset-md-4"> --}}
                                <button type="submit" class="btn btn-success btn-lg btn-block font-18">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            {{-- </div> --}}
                        </div>
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
