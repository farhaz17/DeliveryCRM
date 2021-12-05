<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gull - Laravel + Bootstrap 4 admin template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('assets/css/themes/lite-purple.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

</head>
<div class="auth-layout-wrap" style="background-image: url({{ asset('assets/images/photo-wide-4.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{ asset('assets/images/photo-long-3.jpg') }})">
                    <div class="pl-3 auth-right">
                        <div class="auth-logo text-center mt-4"><img src="{{ asset('assets/images/logo.png') }}" alt=""></div>
                        <div class="flex-grow-1"></div>
{{--                        <div class="w-100 mb-4">--}}
{{--                            <a class="btn btn-outline-primary btn-block btn-icon-text btn-rounded" href="signin.html"><i class="i-Mail-with-At-Sign"></i> Sign in with Email</a>--}}
{{--                            <a class="btn btn-outline-google btn-block btn-icon-text btn-rounded"><i class="i-Google-Plus"></i> Sign in with Google</a>--}}
{{--                            <a class="btn btn-outline-facebook btn-block btn-icon-text btn-rounded"><i class="i-Facebook-2"></i> Sign in with Facebook</a>--}}
{{--                        </div>--}}
                        <div class="flex-grow-1"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <h1 class="mb-3 text-18">Sign Up</h1>
                        <form action="{{ route('rider_sign_up') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="username">Enter Passport Number</label>
                                <input class="form-control form-control-rounded" name="passport_no" id="passport_no" type="text">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control form-control-rounded" id="email" name="email" type="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control form-control-rounded" name="password" id="password" type="password">
                            </div>
                            <div class="form-group">
                                <label for="repassword">Confirm password</label>
                                <input class="form-control form-control-rounded" id="password_confirmation" name="password_confirmation" type="password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/plugins/jquery-3.3.1.min.js') }}"></script>

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
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

