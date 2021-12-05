@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .sim_btns{
            display: none;
        }
        .bike_btns{
            display: none;
        }
        .platform_btns{
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Rider</a></li>
        <li>Rider Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="form-group col-4 offset-4">
                <h4 class="text-center">Riders Report</h4>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary sim_btn">Sim</button>
                    <button class="btn btn-info bike_btn">Bike</button>
                    <button class="btn btn-danger platform_btn">Platform</button>
                </div>
            </div><br>
            <div class="row sim_btns">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary btn-sm" id="SimCheckin" onclick="platform_getid(this)">Check In ( {{$sim_checkins}} )</button>
                    <button class="btn btn-primary btn-sm" id="SimCheckout" onclick="platform_getid(this)">Check Out ( {{$sim_checkouts}} )</button>
                    <button class="btn btn-primary btn-sm" id="SimReplacementCheckin" onclick="platform_getid(this)">Replacement Check In ( {{$sim_replace_checkins}} )</button>
                    <button class="btn btn-primary btn-sm" id="SimReplacementCheckout" onclick="platform_getid(this)">Replacement Check Out ( {{$sim_replace_checkouts}} )</button>
                    <button class="btn btn-primary btn-sm" id="ActivelyWorikingSim" onclick="platform_getid(this)">Actively Working ( {{$sim_actives}} )</button>
                </div>
            </div>
            <div class="row bike_btns">
                <div class="col-md-12 text-center">
                    <button class="btn btn-info btn-sm" id="BikeCheckin" onclick="platform_getid(this)">Check In ( {{$bike_checkins}} )</button>
                    <button class="btn btn-info btn-sm" id="BikeCheckout" onclick="platform_getid(this)">Check Out ( {{$bike_checkouts}} )</button>
                    <button class="btn btn-info btn-sm" id="BikeReplacementCheckin" onclick="platform_getid(this)">Replacement Check In ( {{$bike_replace_checkins}} )</button>
                    <button class="btn btn-info btn-sm" id="BikeReplacementCheckout" onclick="platform_getid(this)">Replacement Check Out ( {{$bike_replace_checkouts}} )</button>
                    <button class="btn btn-info btn-sm" id="ActivelyWorkingBike" onclick="platform_getid(this)">Actively Working ( {{$bike_actives}} )</button>
                </div>
            </div>
            <div class="row platform_btns">
                <div class="col-md-12 text-center">
                    <button class="btn btn-danger btn-sm" id="PlatformCheckin" onclick="platform_getid(this)">Check In ( {{$platform_checkins}} )</button>
                    <button class="btn btn-danger btn-sm" id="PlatformCheckout" onclick="platform_getid(this)">Check Out ( {{$platform_checkouts}} )</button>
                    <button class="btn btn-danger btn-sm" id="ActivelyWorkingPlatform" onclick="platform_getid(this)">Actively Working ( {{$platform_actives}} )</button>
                </div>
            </div><br>
            <div class="city_buttons"></div>
            <div id="platform_buttons"></div><hr>
            <div class="append_div">
            </div>

        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $('.sim_btn').click(function(){
            $('.sim_btns').show(300);
            $('.bike_btns').hide();
            $('.platform_btns').hide();
            $('.city_buttons').empty();
            $('#platform_buttons').empty();
            $('.append_div').empty();
            $('.checkout').empty();
            $('.bike_plat').empty();
        });
        $('.bike_btn').click(function(){
            $('.sim_btns').hide();
            $('.bike_btns').show(300);
            $('.platform_btns').hide();
            $('.city_buttons').empty();
            $('#platform_buttons').empty();
            $('.append_div').empty();
            $('.checkin').empty();
            $('.sim_plat').empty();
        });
        $('.platform_btn').click(function(){
            $('.sim_btns').hide();
            $('.bike_btns').hide();
            $('.platform_btns').show(300);
            $('.append_div').empty();
            $('.checkin').empty();
            $('.checkout').empty();
            $('.sim_plat').empty();
            $('.bike_plat').empty();
        });
        $('.platform_btns').click(function(){
            $('#platform_buttons').empty();
            $('.append_div').empty();
        });
        $('.city_buttons').click(function(){
            $('.append_div').empty();
        });
        $('.bike_btns').click(function(){
            $('.append_div').empty();
            $('#platform_buttons').empty();
        });
        $('.sim_btns').click(function(){
            $('.append_div').empty();
            $('#platform_buttons').empty();
        });
    </script>
    <script>
        function platform_getid(value) {
            var btnValue = value.id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_city_button') }}",
                method: 'POST',
                data: {_token:token,btnValue:btnValue},
                success: function(response) {
                    $('.city_buttons').empty();
                    $('.city_buttons').append(response);
                }
            });
        }
    </script>
    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>
@endsection
