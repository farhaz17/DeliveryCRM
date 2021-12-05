@extends('admin-panel.base.main')
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
        .text-attr-digit {
            font-size: 50px;
            font-weight: 900;
            color:#000000;
            font-family: Digital-7;
        }
        input#search2 {
            width: 20px;
            height: 20px;
        }
        input#search3 {
            width: 20px;
            height: 20px;
        }
        input#att_platform {
            width: 20px;
            height: 20px;
        }
        span.search-text {
            font-size: 15px;
            font-weight: 600;
        }

        .text-attr-platform{
            font-size: 12px;
            font-weight: 700;
        }
        .text-attr-platform2{
            font-size: 7px;
            font-weight: 800;
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
            font-size: 16px;
            text-align: center;
            font-family: Roboto Slab;
        }
        p.text-attr {
            font-size: 16px;
            font-weight: 700;
            /*font-family: Redwing;*/
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
                position: relative;
                top: -56px;
                left: 20%;
            }
            .main-content {
                margin: 10px;
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
                width: 183px;
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
        @media only screen
        and (min-device-width : 1100px)
        and (max-device-width : 1200px) {
            .card.card-profile-1.mb-4 {
                width: 153px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf;
            }

            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                /* top: -29px; */
                left: -27%;
                white-space: nowrap;
            }

            p.text-attr {
                font-size: 18px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
            }
            .main-content {
                margin: 10px;
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px;
            }



        }


        @media only screen
        and (min-device-width : 1200px)
        and (max-device-width : 1300px) {
            .card.card-profile-1.mb-4 {
                width: 165px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf;
            }

            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                /* top: -29px; */
                left: -27%;
                white-space: nowrap;
            }

            p.text-attr {
                font-size: 14px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
                white-space: nowrap;
            }
            .main-content {
                margin: 10px;
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px;
            }
            .text-attr-platform {
                font-size: 10px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 33px;
                white-space: nowrap;
            }

            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px;
            }
        }

            @media only screen
            and (min-device-width : 1301px)
            and (max-device-width : 1400px) {
                .card.card-profile-1.mb-4 {
                    width: 180px;
                    height: 80px;
                    line-height: 5px;
                    margin-left: 5px;
                    margin-top: 3px;
                    border-radius: 5px;
                    border: 1px solid #bfbfbf;
                }

                p.text-attr-title.font-weight-bold {
                    font-size: 20px;
                    position: relative;
                    /* top: -29px; */
                    left: -27%;
                    white-space: nowrap;
                }

                p.text-attr {
                    font-size: 16px;
                    font-weight: 700;
                    position: relative;
                    top: -45px;
                    left: 37px;
                    white-space: nowrap;
                }
                .main-content {
                    margin: 10px;
                }
                .text-attr-digit {
                    font-size: 40px;
                    font-weight: 900;
                    color: #000000;
                    font-family: Digital-7;
                    position: relative;
                    top: -47px;
                    left: 39px;
                }
                .text-attr-platform2 {
                    font-size: 7px;
                    font-weight: 800;
                    position: relative;
                    top: -45px;
                    left: 33px;
                }
                .text-attr-platform {
                    font-size: 10px;
                    font-weight: 700;
                    position: relative;
                    top: -45px;
                    left: 33px;
                    white-space: nowrap;
                }



                .text-attr-platform2 {
                    font-size: 7px;
                    font-weight: 800;
                    position: relative;
                    top: -45px;
                    left: 33px;
                }



        }

        @media only screen
        and (min-device-width : 1401px)
        and (max-device-width : 1500px) {
            .card.card-profile-1.mb-4 {
                width: 188px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf;
            }

            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                /* top: -29px; */
                left: -27%;
                white-space: nowrap;
            }

            p.text-attr {
                font-size: 16px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
                white-space: nowrap;
            }

            .main-content {
                margin: 10px;
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px;
            }
            .text-attr-platform {
                font-size: 12px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 35px;
                white-space: nowrap;
            }

            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px;
            }



        }


        @media only screen
        and (min-device-width : 1501px)
        and (max-device-width : 1600px) {
            .card.card-profile-1.mb-4 {
                width: 200px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf;
            }


            .main-content {
                margin: 10px;
            }



        }




    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rider Attendances</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
        <div class="card">
            <div class="card-body">
                <div class="col-md-4 form-group mb-6">
                    <label class="radio-outline-primary">
                        <input type="radio" id="search2" class="radio_cls" name="radio">&nbsp;&nbsp;<span class="search-text">Date Search</span>
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio-outline-success">
                        <input type="radio" id="search3" class="radio_cls" name="radio">&nbsp;&nbsp;<span class="search-text">User Search</span>
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio-outline-success">
                        <i class="text-20 i-Data-Refresh text-success" id="att_platform"></i>
                    </label>
                </div>
                <div class="search_date_div" style="display: none">
                    <div class="col-md-4 form-group mb-3 offset-1"  style="float: left;"  >
                        <label for="end_date">Search</label>
                        <input type="date" name="keyword" class="form-control form-control-plaintext" required id="keyword">
                    </div>
                    <div class="col-md-4 form-group mb-3"  style="float: left;"  >
                        <label for="end_date">Platform</label>
                        <select  multiple="multiple" class="form-control select multi-select" id="platform" name="platform[]" required>
                            <option value="All">All</option>
                            @foreach($platforms as $plat)
                            <option value="{{$plat->id}}">{{$plat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 form-group mb-3"  style="float: left; margin-top: 20px;">
                        <button class="btn btn-info btn-block btn-icon m-1" id="search_date" data="datatable"  type="button">
                            <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span> Search
                        </button>
                    </div>
                </div>
                <div class="search_user_div" style="display: none">
                    <div class="col-md-4 form-group mb-3 offset-1" style="float: left;"  >
                        <label for="start_date">Filter By</label>
                        <select  id="filter_by" class="form-control form-control-plaintext" required>
                            <option selected disabled >Filter By</option>
                            <option value="1"> Passport Number</option>
                            <option value="2">Name</option>
                            <option value="3">PPUID</option>
                            <option value="4">ZDS Code</option>
                            <option value="5">Plate Number</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3 "  style="float: left;">
                        <label for="end_date">Search</label>
                        <input type="text" name="keyword2" class="form-control form-control-plaintext" required id="keyword2">
                    </div>
                    <div class="col-md-1 form-group mb-3 "  style="float: left; margin-top: 20px;">
                        <button class="btn btn-info btn-block btn-icon m-1" id="apply_filter" data="datatable"  type="button">
                            <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="spinner spinner-success mr-3" style=" font-size: 30px"></div>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>
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
                                <p class="text-attr-title ml-4 font-weight-bold mt-3">
                                    Absent
                                </p>

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
        @if(in_array(1, auth()->user()->user_group_id))
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body">
                        <div class="row">
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
                                        alt="icon">
                            </div>
                            <div class="col-sm-10">
                                <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
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
        @elseif(in_array($row['platform_id'], auth()->user()->user_platform_id))
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body">
                        <div class="row">
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
                                        alt="icon">
                            </div>
                            <div class="col-sm-10">
                                <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
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
        @endif
        @endforeach
    </div>
    <!--------Passport Additional Information--------->
    <div class="col-md-12 mb-3">
        <div id="att-data"></div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function (){
            $('#platform').select2({
                placeholder: 'Select an option'
            });
        });
    </script>
    <script>
        $("#search2").change(function () {
            $(".search_date_div").hide();
            $(".search_user_div").hide();
            $(".search_date_div").show();
            $('#platform').select2({
                placeholder: 'Select an option'
            });
            $('#platform').on("select2:select", function (e) {
                var data = e.params.data.text;
                if(data=='All'){
                    $("#platform > option").prop("selected","selected");
                    $("#platform").trigger("change");
                }
            });
        })
        $("#search3").change(function () {
            $(".search_user_div").hide();
            $(".search_date_div").hide();
            $(".search_user_div").show();
        });
        $("#search_date").click(function () {
            var keyword = $('#keyword').val();
            var platform =$('#platform').val();
            var token = $("input[name='_token']").val();
            if(keyword != '' && platform!='') {
                $.ajax({
                    url: "{{ route('ajax_get_attendance_date') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {_token: token, keyword: keyword,platform:platform},
                    beforeSend: function () {
                        $(".loading_msg").show();
                    },
                    success: function (response) {
                        $('#att-data').empty();
                        $('.table2').empty();
                        $('#att-data').append(response.html);
                        $(".loading_msg").hide();
                    }
                });
            }
            else{
                toastr.error("Please select date and platform both");
            }
        });
    </script>
    <script>
        $("#apply_filter").click(function(){
            var keyword  =   $("#keyword2").val();
            var filter_by  =   $("#filter_by").val();
            var token = $("input[name='_token']").val();
            if(keyword != '' &&  filter_by != ''){
            $.ajax({
                url: "{{ route('ajax_get_attendance_user') }}",
                method: 'POST',
                dataType: 'json',
                data:{keyword:keyword, filter_by:filter_by,_token:token},
                beforeSend: function () {
                    $(".loading_msg").show();
                },
                success: function (response) {

                    $('#att-data').empty();
                    $('.table2').empty();
                    $('#att-data').append(response.html);
                    $(".loading_msg").hide();
                }});
            }else{
                toastr.error("Please select both options");
            }
        });
    </script>
    <script>
        $("#att_platform").click(function(){
            $.ajax({
                url: "{{ route('ajax_refresh_show') }}",
                method: 'POST',
                data: { "_token": "{{ csrf_token() }}",},
                success: function(response) {
                    $('.table2').empty();
                    $('#att-data').empty();
                    $('.table2').append(response.html);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }
                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()
                }
            }) ;
        });
    </script>
    <script>
        $(document).on("click", "#presentSubmit", function (e) {
            console.log("present")
            $('#presentModal').modal('hide');
            e.preventDefault();
            var passport_id = $("input[name='passport_id']").val();
            var created_at = $("input[name='created_at']").val();
            var keyword = $('#keyword').val();
            var platform =$('#platform').val();
            $.ajax({
            type: 'post',
            url: "{{ route('update_to_present') }}",
            data: {_token: "{{ csrf_token() }}",passport_id:passport_id, created_at:created_at, present:"present"},
            success: function (response) {
                console.log(response)
                $.ajax({
                        url: "{{ route('ajax_get_attendance_date') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: {_token: "{{ csrf_token() }}", keyword: keyword,platform:platform},
                        beforeSend: function () {
                            $(".loading_msg").show();
                        },
                        success: function (response) {
                            console.log("done")
                            $('#att-data').empty();
                            $('.table2').empty();
                            $('#att-data').append(response.html);
                            $(".loading_msg").hide();
                        },
                        error: function (request, status, error) {
                            alert(request.responseText);
                        }
                    });
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
            });
        });
        $(document).on("click", "#presentBulkSubmit, #leaveBulkSubmit", function (e) {
            $('#presentBulkModal').modal('hide');
            $('#leaveBulkModal').modal('hide');
            e.preventDefault();
            if(e.target.id == 'presentBulkSubmit') {
                var present_or_leave = 1;
            }
            else if(e.target.id == 'leaveBulkSubmit') {
                var present_or_leave = 2;
            }
            var passport_id = $('input[name="passport_id[]"]').map(function(){
                    return this.value;
                }).get();
            var created_at = $("input[name='created_at']").val();
            var keyword = $('#keyword').val();
            var platform =$('#platform').val();
            $.ajax({
                type: 'post',
                url: "{{ route('update_to_present') }}",
                data: {_token: "{{ csrf_token() }}", 'passport_id[]':passport_id, created_at:created_at, present_or_leave: present_or_leave},
                success: function (response) {
                    console.log(response)
                    $.ajax({
                            url: "{{ route('ajax_get_attendance_date') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: "{{ csrf_token() }}", keyword: keyword,platform:platform},
                            beforeSend: function () {
                                $(".loading_msg").show();
                            },
                            success: function (response) {
                                console.log("done")
                                $('#att-data').empty();
                                $('.table2').empty();
                                $('#att-data').append(response.html);
                                $(".loading_msg").hide();
                            },
                            error: function (request, status, error) {
                                alert(request.responseText);
                            }
                        });
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        });
        $(document).on("click", "#leaveSubmit", function (e) {
            // console.log("present")
            $('#leaveModal').modal('hide');
            e.preventDefault();
            var passport_id = $("input[name='passport_id']").val();
            var created_at = $("input[name='created_at']").val();
            var keyword = $('#keyword').val();
            var platform =$('#platform').val();
            $.ajax({
            type: 'post',
            url: "{{ route('update_to_present') }}",
            data: {_token: "{{ csrf_token() }}",passport_id:passport_id, created_at:created_at, leave:"leave"},
            success: function (response) {
                console.log(response)
                $.ajax({
                        url: "{{ route('ajax_get_attendance_date') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: {_token: "{{ csrf_token() }}", keyword: keyword,platform:platform},
                        beforeSend: function () {
                            $(".loading_msg").show();
                        },
                        success: function (response) {
                            console.log("done")
                            $('#att-data').empty();
                            $('.table2').empty();
                            $('#att-data').append(response.html);
                            $(".loading_msg").hide();
                        },
                        error: function (request, status, error) {
                            alert(request.responseText);
                        }
                    });
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
            });
        });
        $(document).on("click", ".present-btn", function () {
            var pid = $(this).attr('data-id');
            var created = $(this).attr('data-created');
            $("input[name='passport_id']").val(pid);
            $("input[name='created_at']").val(created);
        });
        $(document).on("click", "#bulkTransferPresent", function () {
            // console.log("bulk")
            var created = $(this).attr('data-created');
            $("input[name='created_at']").val(created);
            $(".transfer-checkbox").each(function(index){
                var passport_id = $(this).val();
                if($(this).is(":checked")){
                // add a hidden input element to modal with article ID as value
                $("#passport_ids").append("<input name='passport_id[]' value='"+passport_id+"'  type='hidden' />")
            }
            });
        });
        $(document).on("click", "#bulkTransferLeave", function () {
            // console.log("bulk")
            var created = $(this).attr('data-created');
            $("input[name='created_at']").val(created);
            $(".transfer-checkbox").each(function(index){
                var passport_id = $(this).val();
                if($(this).is(":checked")){
                // add a hidden input element to modal with article ID as value
                $("#leave_passport_ids").append("<input name='passport_id[]' value='"+passport_id+"'  type='hidden' />")
            }
            });
        });
    </script>
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
