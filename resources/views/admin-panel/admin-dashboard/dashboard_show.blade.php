@extends('admin-panel.base.main_dashboard')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&family=Roboto+Slab:wght@900&display=swap" rel="stylesheet">


    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
        @font-face {
            font-family: Digital-7;
            src: url({{'assets/fonts/iconsmind/digital-7.ttf'}});
            font-weight: bold;
        }

        .main-content {
            margin: 20px;
        }
        .text-attr-digit {
            font-size: 50px;
            font-weight: 900;
            color:#000000;
            font-family: Digital-7;
        }



        .block-update-card {
            /* height: 81%; */
            border: 1px #FFFFFF solid;
            width: 372px;
            float: left;
            margin-left: 25px;
            margin-top: 20px;
            padding: 0;
            box-shadow: 1px 1px 8px #d8d8d8;
            background-color: #FFFFFF;
            height: 60px;
        }
        .block-update-card .h-status {
            width: 100%;
            height: 7px;
            background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
        }
        .block-update-card .v-status {
            width: 5px;
            height: 80px;
            float: left;
            margin-right: 5px;
            background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
        }
        .block-update-card .update-card-MDimentions {
            width: 60px;
            height: 60px;
            position: relative;
            /* top: 10px; */
        }
        .text-attr-platform{
            font-size: 14px;
            font-weight: 800;
        }
        .text-attr-platform2{
            font-size: 11px;
            font-weight: 800;
        }
        /*.block-update-card .update-card-body {*/
        /*    margin-top: 20px;*/
        /*    margin-left: 10px;*/
        /*    line-height: 6px;*/
        /*    cursor: pointer;*/
        /*}*/
        .block-update-card .update-card-body h4 {
            color: #737373;
            font-weight: bold;
            font-size: 13px;
        }
        .block-update-card .update-card-body p {
            color: #000000;
            font-size: 14px;
        }
        .block-update-card .card-action-pellet {
            padding: 5px;
        }
        .block-update-card .card-action-pellet div {
            margin-right: 10px;
            font-size: 15px;
            cursor: pointer;
            color: #dddddd;
        }
        .block-update-card .card-action-pellet div:hover {
            color: #999999;
        }
        .block-update-card .card-bottom-status {
            color: #a9a9aa;
            font-weight: bold;
            font-size: 14px;
            border-top: #e0e0e0 1px solid;
            padding-top: 5px;
            margin: 0px;
        }
        .block-update-card .card-bottom-status:hover {
            background-color: #dd4b39;
            color: #FFFFFF;
            cursor: pointer;
        }

        /*new*/
        img.title_imag-icon {
            height: 55px;
            width: 56px;
            max-width: 300px;
        }
        .card.card-profile-1.mb-4 {
            /*width: 380px;*/
            height: 80px;
            line-height: 5px;
            margin-left: 5px;
            margin-top: 3px;
            border-radius: 5px;
            border: 1px solid #bfbfbf;
        }
        p.text-attr-title.font-weight-bold {
            font-size: 24px;
            text-align: center;
            font-family: Roboto Slab;
            /*font-family: Redwing;*/
        }
        p.text-attr {
            font-size: 18px;
            font-weight: 700;

            /*font-family: Redwing;*/
        }


        @media only screen
        and (min-device-width : 768px)
        and (max-device-width : 1024px)
        and (orientation : portrait) {

            img.title_imag-icon {
                height: 35px;
                width: 35px;
                max-width: 300px;
            }
            .card.card-profile-1.mb-4 {
                width: 150px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
            }
            p.text-attr-title.font-weight-bold {
                font-size: 15px;
                /* font-family: Redwing; */
            }
            p.text-attr {
                font-size: 13px;
                /* font-family: Redwing; */
            }

            p.text-attr-title.font-weight-bold {
                font-size: 15px;
                /* font-family: Redwing; */
                position: relative;
                top: -33px;
                left: 20%;
            }
            p.text-attr.ml-4 {
                position: relative;
                top: -34px;
                left: 22%;
            }
            .main-content {
                margin: 6px;
            }



            }

        @media only screen and (min-width: 411px) and (max-width: 767px) {
            p.text-attr-title.font-weight-bold {
                font-size: 24px;
                position: relative;
                top: -59px;
                left: 20%;

            }

            p.text-attr {
                font-size: 20px;
                /* font-family: Redwing; */
                position: relative;
                top: -56px;
                left: 20%;
            }
            .main-content {
                margin: 10px;
            }
        }


        @media only screen and (min-device-width: 375px) and (max-device-width: 667px) and (orientation : portrait) {
            p.text-attr-title.font-weight-bold {
                font-size: 24px;
                position: relative;
                top: -59px;
                left: 20%;

            }

            p.text-attr {
                font-size: 20px;
                /* font-family: Redwing; */
                position: relative;
                top: -56px;
                left: 20%;
            }
            .main-content {
                margin: 10px;
            }
        }



    </style>
@endsection
@section('content')







        <div class="card">
        <div class="table2">
            <div class="row">

                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title font-weight-bold mt-3 ml-4">Platform </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------------->
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title font-weight-bold mt-3 ml-4">Present </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------------------->
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title ml-4 font-weight-bold mt-3">Absent </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------------------------->
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------------------------->
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title font-weight-bold mt-3 ml-4">Total Riders </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------------------------->
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-profile-1 mb-4 mr-1">
                        <div class="card-body text-left">
                            <div class="row">

                                <div class="col-sm-10">
                                    <p class="text-attr-title font-weight-bold mt-3 ml-4">On Leave </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>


                @foreach($platform_att as $row)

                    <div class="row">

                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body">
                                    <div class="row">
{{--                                        style="background-image:url('assets/images/icons/drawable/careem.png')"--}}
                                    <div class="col-sm-2 bg-left" >

                                        <img class="title_imag-icon"
                                             @if($row['platform_id']=='1')
                                             src="assets/images/icons/drawable/careem.png"
                                             @elseif($row['platform_id']=='2')
                                             src="assets/images/icons/drawable/zomato.png"
                                             @elseif($row['platform_id']=='3')
                                             src="assets/images/icons/drawable/uber-eats.png"
                                             @elseif($row['platform_id']=='4')
                                             src="assets/images/icons/drawable/deliveroo.png"
                                             @elseif($row['platform_id']=='5')
                                             src="assets/images/icons/drawable/swan.png"
                                             @elseif($row['platform_id']=='6')
                                             src="assets/images/icons/drawable/bnk.png"
                                             @elseif($row['platform_id']=='7')
                                             src="assets/images/icons/drawable/somu_sushu.png"
                                             @elseif($row['platform_id']=='8')
                                             src="assets/images/icons/drawable/hey_karry.png"
                                             @elseif($row['platform_id']=='9')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='10')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='11')
                                             src="assets/images/icons/drawable/i-mile.png"
                                             @elseif($row['platform_id']=='12')
                                             src="assets/images/icons/drawable/spicy_klub.png"
                                             @elseif($row['platform_id']=='13')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='14')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='15')
                                             src="assets/images/icons/drawable/talabat.png"
                                             @elseif($row['platform_id']=='16')
                                             src="assets/images/icons/drawable/trot.png"
                                             @elseif($row['platform_id']=='17')
                                             src="assets/images/icons/drawable/chocomelt.png"
                                             @elseif($row['platform_id']=='18')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='19')
                                             src="assets/images/icons/drawable/kabab_shop.png"
                                             @elseif($row['platform_id']=='20')
                                             src="assets/images/icons/drawable/platform.png"
                                             @elseif($row['platform_id']=='21')
                                             src="assets/images/icons/drawable/thai-wok.png"
                                             @elseif($row['platform_id']=='22')
                                             src="assets/images/icons/drawable/aster.png"
                                             @elseif($row['platform_id']=='23')
                                             src="assets/images/icons/drawable/med-care.png"
                                             @elseif($row['platform_id']=='24')
                                             src="assets/images/icons/drawable/med-care.png"
                                             @elseif($row['platform_id']=='25')
                                             src="assets/images/icons/drawable/insta.png"
                                             @else
                                             src="assets/images/icons/drawable/platform.png"
                                             @endif
                                             alt="icon"></div>

                                    <div class="col-sm-10">
{{--                                        <p class="text-attr-title font-weight-bold mt-3 ml-4">Platform </p>--}}
                                        <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'
                        ||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
                                            class="text-attr-platform ml-4 mt-4"
                                            @elseif($row['platform_id']=='24'||$row['platform_id']=='17')
                                            class="text-attr-platform2 ml-4 mt-4"
                                            @else
                                            class="text-attr ml-4 mt-4" @endif >{{$row['platform']}}
                                        </p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!-------------------------------->
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/yes_sir.png" alt="icon"></div>
                                        <div class="col-sm-10">
{{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Present </p>--}}
                                            <p class="text-attr-digit ml-4 mt-4" style="color: green">{{$row['present']}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!----------------------------->
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/delete-user.png" alt="icon"></div>
                                        <div class="col-sm-10">
{{--                                            <p class="text-attr-title ml-4 font-weight-bold mt-3">Absent </p>--}}
                                            <p class="text-attr-digit ml-4 mt-4" style="color: red">{{$row['absent']}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!----------------------------------->
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/order-food.png" alt="icon"></div>
                                        <div class="col-sm-10">
{{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
                                            <p class="text-attr-digit ml-4 mt-4">{{$row['orders']}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!----------------------------------->
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/bike.png" alt="icon"></div>
                                        <div class="col-sm-10">
{{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
                                            <p class="text-attr-digit ml-4 mt-4">{{$row['total_rider']}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----------------------------------->
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-profile-1 mb-4 mr-1">
                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/day.png" alt="icon"></div>
                                        <div class="col-sm-10">
{{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
                                            <p class="text-attr-digit ml-4 mt-4">{{$row['leave']}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                @endforeach
            </div>

        </div>




    <!--------Passport Additional Information--------->





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>

        window.setInterval(function () {
            // var token = $("input[name='_token']").val();
            // var token = '6bKiEbzhFPMnagFR92MDRpzRM25xpiZZsXkxsAzC';
            $.ajax({
                url: "{{ route('dashboard_show_refresh') }}",
                method: 'POST',
                data: { "_token": "{{ csrf_token() }}",},
                success: function(response) {
                    $('.table2').empty();
                    $('.table2').append(response.html);
                }
            });
        },600000 );
        //600000
    </script>
    <script>
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
    </script>



@endsection
