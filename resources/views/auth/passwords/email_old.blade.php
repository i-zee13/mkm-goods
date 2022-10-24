{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}







<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>E-bob</title>
<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,800" rel="stylesheet">
<link rel="stylesheet" href="/css/bootstrap.min.css">

<!-- Custom fonts for this template-->
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<link href="/css/style.css" rel="stylesheet">
<link href="/css/menu.css" rel="stylesheet">
</head>

<body class="bg_main">
 
	<div id="wrapper">
  <div class="log_con">
    <div class="container-fluid"> 
      <!-- Row -->
      <div class="table-struct full-width">
        <div class="table-cell vertical-align-middle auth-form-wrap">
          <div class="auth-form">
              <div class="row m-0">
                <div class="col-md-6">
                  <div class="login-left">
                    <div class="logo-company"> <img src="/images/sell-360.svg"  alt=""/> </div>
                    <h4>Customer Experience Solution</h4>
                  </div>
                </div>
                <div class="col-md-6"  style="background-color: #f5f5f5">
                  <div class="login-right">
                    <h3 class="mb-20">Forgot <span>your password?</span></h3>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <div class="user"> <span class="fa fa-envelope"></span>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                      </div>
                      <div class="form-group mb-0 mt-15">
                        <button type="submit" class="btn btn-info btn-login w-auto">Reset Password</button> 
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <div class="Log_footer"> Copyright ©  2019 Sell3sixty All rights reserved.<br>
            Design &amp; Developed by <a href="https://allomate.com" target="_blank">Allomate Solutions</a> </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/js/jquery-3.3.1.slim.min.js"></script> 
<script src="/js/popper.min.js"></script> 
<script src="/js/bootstrap.min.js"></script>
 

</body>
</html>

