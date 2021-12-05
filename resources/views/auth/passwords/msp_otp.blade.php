
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zone Multi Solution provider</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{asset('assets/css/themes/lite-purple.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
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
        .resend-btn{
            background: none;
            color: #8b0000;
            font-weight: bold;
        }
        .timers{
            color: #8b0000;
            font-weight: bold;
        }

    </style>
</head>
{{--@section('content')--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5" style="position: relative; top:200px">
                <div class="p-4 mt-5">
                <div class="card">
                    <div class="card-header ml-3 font-weight-bold">We have sent you OTP at <u> {{$email}}</u> Check Email  and Enter OTP </div>
                    <div class="auth-logo text-center mb-4"><img src="{{asset('assets/images/logo.png')}}" alt=""></div>
                    <div class="card-body">
                        <form method="POST" action="{{route('update_password_msp')}}">
                            {{ method_field('GET') }}

                            @if(isset($message))

                                <div class="alert alert-card alert-danger" role="alert">
                                    {{$message}}
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif
                            <h1 class="mb-12 text-18">Enter OTP</h1>
                            <div class="form-group row">


                                <div class="col-md-12">
                                    <input id="otp" type="text" class="form-control" name="otp" placeholder="Enter OTP" required autofocus>


                                    <input id="email" type="hidden" class="form-control" name="email" value="{{$email}}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button class="btn btn-rounded sign-in-btn btn-block mt-2">Enter OTP</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <p class="timers ml-4 ">Resend OTP in: <span class="countdown"></span></p>

                                <div class="resend" >
                                    <form method="POST" action="{{ route('forget_password_msp') }}">
                                        {!! csrf_field() !!}
                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                <input id="email" type="hidden" class="form-control" name="email" value="{{$email}}" required autofocus>
                                                <button class="btn resend-btn ml-5">Resend OTP</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>




                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
{{--@endsection--}}
<script>
    $(document).ready(function () {
        $('.resend').hide();

        var timer2 = "1:00";
        var interval = setInterval(function() {


            var timer = timer2.split(':');
            //by parsing integer, I avoid all extra string processing
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('.countdown').html(minutes + ':' + seconds);
            timer2 = minutes + ':' + seconds;
        }, 1000);



        setTimeout(function () {
            $('.resend').show();
            $('.countdown').hide();
            $('.timers').hide();

        }, 60000);
    });
</script>





