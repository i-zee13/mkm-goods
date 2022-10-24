<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
 
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/login-style.css" rel="stylesheet">
</head>

<body>

    <body class="bg_main">

        <div id="wrapper" class="pass-change-bg">
            <div class="log_con">

                <div class="container">
 
                    <div class="table-struct full-width">
                        <div class="table-cell vertical-align-middle auth-form-wrap">
                            <div class="auth-form">

                                <div class="row m-0">
                                    <div class="col-md-12 col-height">
                                        <div class="login-right">
                                            <div class="log-form">
                                                <h3 class="mb-20">Forgot<span> Your Password</span></h3>
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
                                                        <button type="submit" class="btn btn-info btn-login w-auto">Reset
                                                            Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="Log_footer"> Copyright © 2020 {{ config('app.name') }} All rights reserved.
                        <br> Design &amp; Developed by <a href="https://allomate.com" target="_blank">Allomate Solutions</a>
                    </div>
                </div>

            </div>

        </div>

    </body>

    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>