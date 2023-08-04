@extends('layouts.app1')

@section('content')
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box forgot-password-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                            
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-head">
                            <a href="index.html" class="logo"><img src="{{asset('public/assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                        </div> 
                        <h4 class="text-primary my-4">Forgot Password ?</h4>
                        <p class="mb-4">Enter the email address below to receive reset password instructions.</p>

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

                        <div class="row mb-0">
                            <div class="offset-md-0" style="margin-left: 15px">
                                <button type="submit" class="btn btn-success btn-lg btn-block font-18"style="width: 175%" >
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
