{{--@extends('layouts.app')--}}
{{--@section('css')--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />--}}
{{--@endsection--}}

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


{{--@section('content')--}}
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8 mt-5" style="position: relative; top:200px">

            <div class="p-4 mt-5">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>
                <div class="auth-logo text-center mb-4"><img src="{{asset('assets/images/logo.png')}}" alt=""></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('forget_password_msp') }}">
                        {!! csrf_field() !!}
                        @if(isset($message))
                            <div class="alert alert-card alert-danger" role="alert">
                                {{$message}}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        <h1 class="mb-12 text-18">Reset Password</h1>
                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="email"  placeholder="Enter Email Address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus>

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

@section('js')

    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
            break;
    }
    @endif
</script>


@endsection

