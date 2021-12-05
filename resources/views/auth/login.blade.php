
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zone Multi Solution provider</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{asset('assets/css/themes/lite-purple.min.css')}}" rel="stylesheet">
    <style>
        .btn-primary, .btn-outline-primary {
            border-color: #8b0000;
        }
        .sign-in-btn.btn-block {
            background: darkred;
            color: #ffffff;
        }

    </style>
</head>
<div class="auth-layout-wrap" style="background: #8b0000">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('message'))
                        @if(Session::get('alert-type', 'info'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                      @endif
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('assets/images/logo.png')}}" alt=""></div>
                        @if(isset($message))
                            <div class="alert alert-card alert-success" role="alert">
                                {{$message}}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif


                        <h1 class="mb-12 text-18">Sign In</h1>
                        <form method="POST" action="{{ route('login') }}" class="form-element">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control{{ $errors->has('email') || Session::has('error') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  autofocus  placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-rounded sign-in-btn btn-block mt-2">Sign In</button>
                        </form>
                        {{--<div class="mt-3 text-center"><a class="text-muted" href="forgot.html">--}}
                        {{--<u>Forgot Password?</u></a></div>--}}
                    </div>
                    <div class="container ml-4">
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
{{--                                href="/zone_repair/public/forgot-password"--}}
                                <span class="psw"> <a href="forgot-password">Forgot Password?</a></span>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>


                    </div>
                </div>
                {{--<div class="col-md-6 text-center" style="background-size: cover;background-image: url(../../dist-assets/images/photo-long-3.jpg)">--}}
                {{--<div class="pr-3 auth-right"><a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="signup.html"><i class="i-Mail-with-At-Sign"></i> Sign up with Email</a><a class="btn btn-rounded btn-outline-google btn-block btn-icon-text"><i class="i-Google-Plus"></i> Sign up with Google</a><a class="btn btn-rounded btn-block btn-icon-text btn-outline-facebook"><i class="i-Facebook-2"></i> Sign up with Facebook</a></div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
