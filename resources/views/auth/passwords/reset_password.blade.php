
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
        body{
            background: #8b0000;
        }

    </style>
</head>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5" style="position: relative; top:200px">
                <div class="p-4 mt-5">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>
                    @if(isset($message))
                        <div class="alert alert-card alert-danger" role="alert">
                            {{$message}}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{'update_password_final'}}">
                            {{ method_field('GET') }}

                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label font-weight-bold">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{$email}}" required autocomplete="email" autofocus>
                                    <input id="otp" type="hidden" class="form-control"  name="otp" value="{{$otp}}" required  autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label font-weight-bold">{{ __('Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-12 col-form-label font-weight-bold">{{ __('Confirm Password') }}</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-rounded sign-in-btn btn-block mt-2">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

{{--@endsection--}}
