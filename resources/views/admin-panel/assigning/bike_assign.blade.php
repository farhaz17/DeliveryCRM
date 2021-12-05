@extends('admin-panel.base.main')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" />
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .pending_passport_cls{
            height: 300px;
            overflow: scroll;
        }
    </style>

    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        img.responsive.bike-img {
            width: 50px;
            height: 50px;
            position: relative;
            top: 20%;
        }
        .title-css {
            text-align: center;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .user-profile .profile-picture {
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: 60px;
        }
        p.text-attr {
            font-weight: 600;
        }
        a#agreement-history {
            font-weight: 600;
            font-size: 12px;
            color: #000000;
        }
        a#agreement-upload {
            font-weight: 600;
            font-size: 12px;
            color: #000000;
        }
        .div-left {
            border-right: 1px solid;
        }
        /*bootsnip css*/
        .block-update-card {
            height: 100%;
            border: 1px #FFFFFF solid;
            width: 375px;
            float: left;
            margin-left: 25px;
            margin-top: 20px;
            padding: 0;
            box-shadow: 1px 1px 8px #d8d8d8;
            background-color: #FFFFFF;
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
            width: 80px;
            height: 80px;
            position: relative;
            /*top: 10px;*/
        }
        .block-update-card .update-card-body {
            margin-top: 10px;
            margin-left: 5px;
            line-height: 5px;
            cursor: pointer;
        }
        .block-update-card .update-card-body h4 {
            color: #737373;
            font-weight: bold;
            font-size: 13px;
        }
        .block-update-card .update-card-body p {
            color: #000000;
            font-size: 12px;
            white-space: nowrap;
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

        /*
        Creating a block for social media buttons
        */
        .card-body-social {
            font-size: 30px;
            margin-top: 10px;
        }
        .card-body-social .git {
            color: black;
            cursor: pointer;
            margin-left: 10px;
        }
        .card-body-social .twitter {
            color: #19C4FF;
            cursor: pointer;
            margin-left: 10px;
        }
        .card-body-social .google-plus {
            color: #DD4B39;
            cursor: pointer;
            margin-left: 10px;
        }
        .card-body-social .facebook {
            color: #49649F;
            cursor: pointer;
            margin-left: 10px;
        }
        .card-body-social .linkedin {
            color: #007BB6;
            cursor: pointer;
            margin-left: 10px;
        }

        .music-card {
            background-color: green;
        }
        table#datatable2 {
            font-size: 11px;
        }
        /*responsivenes*/
        @media only screen and (min-width: 1073px) {

            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 340px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }

            a#agreement-history {
                font-weight: 600;
                font-size: 10px;
                color: #000000;
            }
            a#agreement-upload {
                font-weight: 600;
                font-size: 10px;
                color: #000000;
            }
            a#agreement-new {
                font-weight: 600;
                font-size: 9px;
                color: #000000;
            }
        }
        /*@media only screen and (min-width: 1300px) {*/

        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 312px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/

        /*    a#agreement-history {*/
        /*        font-weight: 600;*/
        /*        font-size: 10px;*/
        /*        color: #000000;*/
        /*    }*/
        /*    a#agreement-upload {*/
        /*        font-weight: 600;*/
        /*        font-size: 10px;*/
        /*        color: #000000;*/
        /*    }*/
        /*    a#agreement-new {*/
        /*        font-weight: 600;*/
        /*        font-size: 9px;*/
        /*        color: #000000;*/
        /*    }*/
        /*}*/
        /*@media only screen and (min-width: 1440px) {*/
        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 320px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/
        /*}*/
        /*@media only screen and (min-width: 1500px) {*/
        /*    !* for sumo sized (mac) screens *!*/
        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 280px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/
        /*}*/
        /*@media only screen and (min-width: 1600px) {*/
        /*    !* for sumo sized (mac) screens *!*/
        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 300px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/
        /*}*/
        /*@media only screen and (min-width: 1700px) {*/
        /*    !* for sumo sized (mac) screens *!*/
        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 330px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/
        /*}*/

        /*@media only screen and (min-width: 1800px) {*/
        /*    !* for sumo sized (mac) screens *!*/
        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 375px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/
        /*}*/
        /*@media only screen and (max-device-width: 480px) {*/
        /*    !* styles for mobile browsers smaller than 480px; (iPhone) *!*/
        /*}*/
        /*@media only screen and (device-width: 768px) {*/
        /*    !* default iPad screens *!*/
        /*}*/
        /*!* different techniques for iPad screening *!*/
        /*@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait) {*/
        /*    !* For portrait layouts only *!*/
        /*}*/

        /*@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) {*/
        /*    !* For landscape layouts only *!*/
        /*}*/
        /*sliding manu */
        .menu-wrapper {
            position: relative;
            /* max-width: 500px; */
            height: 100px;
            margin: 1em auto;
            /* border: 1px solid black; */
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .pn-ProductNav_Link {
            text-decoration: none;
            color: #888;
            font-size: 1.2em;
            font-family: -apple-system, sans-serif;
            display: -webkit-inline-box;
            display: inline-flex;
            -webkit-box-align: center;
            align-items: center;
            min-height: 44px;
            margin-left: 11px;
            padding-left: 11px;
            border-left: 1px solid #eee;
        }

        .menu {
            height: 120px;
            /*  background: #f3f3f3; */
            box-sizing: border-box;
            white-space: nowrap;
            overflow-x: hidden;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            border: none;
        }
        .menu .item {
            display: inline-block;
            width: 100px;
            height: 100%;
            /* outline: 1px dotted gray;*/
            padding: 1em;
            box-sizing: border-box;
        }



        .paddle {
            position: absolute;
            top: 0;
            bottom: 24px;
            width: 3em;
            border: none;
            background: #ffffff;
            cursor:pointer;

        }

        .left-paddle {
            left: 0;
        }

        .right-paddle {
            right: 0;
        }

        .hidden {
            display: none;
        }

        .print {
            margin: auto;
            max-width: 500px;
        }
        .print span {
            display: inline-block;
            width: 100px;
        }
        .pn-Advancer_Icon {
            width: 20px;
            height: 44px;
            fill: #bbb;
        }
        .pn-ProductNav_Link + .pn-ProductNav_Link {
            margin-left: 11px;
            padding-left: 11px;
            border-left: 1px solid #eee;
        }

        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }

        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }


        /*responsive css*/


        /*@media only screen*/
        /*and (min-device-width : 1370px)*/
        /*and (max-device-width : 1730px) {*/


        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 430px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
        /*    }*/

        /*}*/


        @media only screen
        and (min-device-width : 1300px)
        and (max-device-width : 1368px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 480px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }



        }





        @media only screen
        and (min-device-width : 1400px)
        and (max-device-width : 1500px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 340px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }



        }


        @media only screen
        and (min-device-width : 1501px)
        and (max-device-width : 1600px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 390px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }


        }


        @media only screen
        and (min-device-width : 1601px)
        and (max-device-width : 1700px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 306px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }
        }



        @media only screen
        and (min-device-width : 1801px)
        and (max-device-width : 1900px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 348px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }



        }


        @media only screen
        and (min-device-width : 1901px)
        and (max-device-width : 2000px) {
            .block-update-card {
                height: 100%;
                border: 1px #FFFFFF solid;
                width: 370px;
                float: left;
                margin-left: 25px;
                margin-top: 20px;
                padding: 0;
                box-shadow: 1px 1px 8px #d8d8d8;
                background-color: #FFFFFF;
            }
        }
    </style>

@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA Operation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bike Assignment Operation</li>
        </ol>
    </nav>


    <!--  bike box Modal-->
<div class="modal fade bd-example-modal-lg"  id="bike_box_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Bike Box Detail</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
                <div class="modal-body append_bike_box">


                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>

        </div>
    </div>
</div><!-- end of bike box modal -->

{{-- view image start --}}
<div class="modal fade" id="ViewImage"  role="dialog" aria-labelledby="UploadImageTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="update_img" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadImageTitle">Uploaded Box Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body append_img">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-sm btn-primary" style="display: none;" id="box_img_btn">Save</butyton> --}}
                </div>
            </form>
        </div>
    </div>
</div>
{{-- view image end --}}






    <div class="separator-breadcrumb border-top"></div>
    <h4 class="card-title mb-3">Bike Assign</h4>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Bike Checkin</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Bike Checkout</a></li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <!-------------------------Bike content------------------------>
                        <form action ="{{ route('bike_assign') }}" method="POST" id="form_checkin">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                    <label class="radio-outline-success text-primary font-weight-bold ">Name:</label>
                                    <h6 id="name_passport" class="text-dark ml-3 "></h6>
                                </div>
                                <div class="col-md-5 form-check-inline mb-3 text-center" id="platform_div" style="display: none;" >
                                    <label class="radio-outline-success font-weight-bold text-primary ">Current Platform:</label>
                                    <h6 id="name_platform" class="text-dark ml-3 "></h6>
                                </div>
                            </div>
                            <input type="hidden" name="passport_id_selected" id="passport_id_selected">
                            <input type="hidden" name="four_pl_status" id="four_pl_status" >

                            <div class="row">

                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                            <input type="radio" checked="" value="1" name="rider_type"><span>Rider</span><span class="checkmark"></span>
                                             </label>
                                     </div>

                                        <div class="form-check-inline">
                                           <label class="radio radio-outline-success">
                                              <input type="radio"  value="2" name="rider_type"><span>Front Line Warrior</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-4 form-group  mb-3">
                                    <label for="repair_category">Search Rider</label><br>
                                    <div class="input-group ">
                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                        <div id="clear">X</div>
                                    </div>
                                    <input type="text"  class="mb-3" id="app_id" style="display: none" >
                                    <button class="btn btn-primary mt-3">Save</button>
                                </div>
                                <div class="col-md-2 form-group mb-3">
                                    <label for="bike">Bike</label>
                                    <br>
                                    <select id="bike" name="bike" class="form-control form-control-sm" required>
                                        <option value=""  >Select option</option>
                                        @foreach($working_bikes as $bike)
                                            @if($bike["cencel"]=="")
                                                <option value="{{ $bike->id }}">{{ $bike->plate_no  }} | {{ $bike['plate_code'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="repair_category">Check IN</label>
                                    <input class="form-control form-control" id="checkin" autocomplete="off" readonly name="checkin" type="text"   required  />
                                </div>
                                <div class="col-md-12">
                                </div>
                            </div>
                        </form>
                        <br>
                        <!----------- Bike table ---------->
                        <div class="col-md-12 mb-3">
                            {{--accordian start--}}
                            <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                            <a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false">
                                                <span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                        <div class="card-body">
                                            <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                <label for="start_date">Filter By</label>
                                                <select  id="filter_by" class="form-control form-control-sm" required >
                                                    <option selected disabled >Filter By</option>
                                                    <option value="1">Passport Number</option>
                                                    <option value="2">Name</option>
                                                    <option value="3">PPUID</option>
                                                    <option value="4">ZDS Code</option>
                                                    <option value="5">Plate Number</option>
                                                    <option value="6">PlatForm</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                <label for="end_date">Search</label>
                                                <input type="text" name="keyword" class="form-control form-control-sm" required id="keyword_filter">
                                            </div>
                                            <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                            <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                <label for="end_date" style="visibility: hidden;">End Date</label>
                                                <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- accordian end here--}}
                            <div class=" text-left">
                                <div >
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable_bike" style="width: 100%">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Passport Number</th>
                                                <th scope="col">PPUID</th>
                                                <th scope="col">ZDS Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Plate No</th>
                                                <th scope="col">PlatForm</th>
                                                <th scope="col">Checkin</th>
                                                <th scope="col">Checkout</th>
                                                <th scope="col">Images</th>
                                                <th scope="col">Remakrs</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        {{--                                            {{ $assign_bike->render() }}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--      first  checkin tab end--}}

        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <!-------------------------Bike content------------------------>
                        <form action="{{ action('Assign\AssginBikeController@update',"1") }}" method="POST" id="form_checkout">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-3 form-check-inline mb-3 text-center" id="name_div_checkout" style="display: none;" >
                                    <label class="radio-outline-success text-primary font-weight-bold ">Name:</label>
                                    <h6 id="name_passport_checkout" class="text-dark ml-3 "></h6>
                                </div>
                                <div class="col-md-3 form-check-inline mb-3 text-center" id="name_platform_checkout_div" style="display: none;" >
                                    <label class="radio-outline-success text-primary font-weight-bold ">Last Platform Checkout Name:</label>
                                    <h6 id="name_platform_checkout" class="text-dark ml-3 "></h6>
                                </div>
                                <div class="col-md-3 form-check-inline mb-3 text-center" id="name_platform_checkout_time_div" style="display: none;" >
                                    <label class="radio-outline-success text-primary font-weight-bold ">Last Platform Checkout Time:</label>
                                    <h6 id="name_platform_checkout_time" class="text-dark ml-3 "></h6>
                                </div>
                                <div class="col-md-3 form-check-inline mb-3 text-center" id="name_bike_checkout_div" style="display: none;" >
                                    <label class="radio-outline-success text-primary font-weight-bold ">Bike Number:</label>
                                    <h6 id="name_bike_checkout" class="text-dark ml-3 "></h6>
                                </div>
                            </div>
                            <input type="hidden" name="passport_id_selected_checkout" id="passport_id_selected_checkout">



                            <div class="row">

                                <div class="col-md-3 form-group  mb-3">
                                    <label for="repair_category">Search Rider</label><br>
                                    <div class="input-group ">
                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead_checkout " id="keyword_checkout" autocomplete="off" type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                        <div id="clear">X</div>
                                    </div>
                                    <input type="text"  class="mb-3" id="app_id" style="display: none" >
                                    <button class="btn btn-primary mt-3">Save</button>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Check Out</label>
                                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" required  />
                                </div>
                                <div  class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Remarks</label>
                                    <input class="form-control form-control" id="remarks" required name="remarks" type="text"   />
                                </div>
                                <div  class="col-md-3 form-group mb-3">
                                <label for="start_date">Bike Taken</label>
                                <select  id="checkout_reason" name="checkout_reason" class="form-control form-control-sm" required >
                                    <option value="">Select option</option>
                                    <option value="0">Accident</option>
                                    <option value="1">Impounding</option>
                                    <option value="3">Under maintenance</option>
                                    <option value="4" id="given" style="">Given</option>
                                    <option value="5">Lost</option>
                                    <option value="6" id="force" style="">Forcefuly Taken</option>
                                </select>
                                </div>
                                <div class="col-md-12">
                                </div>
                            </div>
                        </form>
                        <br>
                        <!----------- Bike table ---------->
                        <div class="col-md-12 mb-3">
                            {{--accordian start--}}
                            <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                            <a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false">
                                                <span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                        <div class="card-body">
                                            <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                <label for="start_date">Filter By</label>
                                                <select  id="filter_by" class="form-control form-control-sm" required >
                                                    <option selected disabled >Filter By</option>
                                                    <option value="1"> Passport Number</option>
                                                    <option value="2">Name</option>
                                                    <option value="3">PPUID</option>
                                                    <option value="4">ZDS Code</option>
                                                    <option value="5">Plate Number</option>
                                                    <option value="6">PlatForm</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                <label for="end_date">Search</label>
                                                <input type="text" name="keyword_checkout" class="form-control form-control-sm" required id="keyword_checkout">
                                            </div>
                                            <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                            <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                <label for="end_date" style="visibility: hidden;">End Date</label>
                                                <button class="btn btn-info btn-icon m-1" id="apply_filter_checkout" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter_checkout" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- accordian end here--}}
                            <div class=" text-left">
                                <div >
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-sm text-11 table-bordered" id="datatable_bike_checkout" style="width: 100%">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Passport Number</th>
                                                    <th scope="col">PPUID</th>
                                                    <th scope="col">ZDS Code</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Plate No</th>
                                                    <th scope="col">PlatForm</th>
                                                    <th scope="col">Checkin</th>
                                                    <th scope="col">Checkout</th>
                                                    <th scope="col">Images</th>
                                                    <th scope="col">Remakrs</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        {{--                                            {{ $assign_bike->render() }}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        checkout tab end--}}
    </div>
    <!--------- Bike CheckOut Model---------->
    <div class="modal fade" id="bike_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Bike Checkout</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form  action="{{ action('Assign\AssginBikeController@update',"1") }}" id="bike_modal_form" method="post">
                            <input type="hidden" id="bike_primary_id" name="primary_id_bike">
                            @csrf
                            @method('put')
                            <label for="repair_category">Check Out</label>
                            <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />
                            <label for="repair_category">Remarks</label>
                            <input class="form-control form-control" id="remarks" name="remarks" type="text"   />
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" > Save  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------checkout model ends--------->
{{--            bike details modal--}}
            <div class="modal fade bike_history" id="edit_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bike_history">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2">Bike Detail</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="card mb-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div id="names_div">
                                                <div id="all-detail" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/custom_js/bike_assign.js') }}"></script>
    <script src="{{ asset('js/custom_js/date_formate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" ></script>


    <script>
         $(document).on('change','#bike',function(){
            var id = $(this).val();
            $('#checkin').val("") ;
            $.ajax({
                url: "{{ route('get_latest_bike_time') }}",
                method: 'GET',
                data: {bike_id: id,type:"bike"},
                success: function (response) {
                    var  array = JSON.parse(response);

                    // alert(array['latest_date']);

                    if(array['latest_date']==""){
                        $('#checkin').datetimepicker({
                        mask:'9999/19/39 29:59'
                         });
                    }else{

                        $('#checkin').datetimepicker({
                        mask:'9999/19/39 29:59',
                        minDate: array['latest_date'],
                        maxDate:false
                      });

                    }
                }
            });

            var bike = $(this).val();


            $.ajax({
                url: "{{ route('box_process_details_ajax') }}",
                method: "get",
                data: {bike:id},
                success: function(response){
                    $("#bike_box_modal").modal('show');
                    $('.append_bike_box').empty();
                    $('.append_bike_box').append(response.html);
                }
            });







        });

        function ViewImage(id){
            var id = id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_box_image') }}",
                method: "get",
                data:{id:id,_token:token},
                success:function(response){
                    $('.append_img').empty();
                    $("body").removeClass("loading");
                    $('.append_img').append(response.html);
                    $('#ViewImage').modal('show');
                }
            });
        }

    </script>


    <script>
        // $('#checkin').datetimepicker({
        //     mask:'9999/19/39 29:59',
        //     minDate: '2021/11/05',
        //     maxDate:false
        // });
        // .datetimepicker();
        // $('#checkin').datetimepicker('toggle');

        </script>

    <script>
        function assign_load_data(keyword= '', filter_by= ''){
            var token = $("input[name='_token']").val();
            var table = $('#datatable_bike').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0][1],"width": "30%"}
                ],
                "processing": true,
                "serverSide": true,
                ajax:{
                    url : "{{ route('assign_bike') }}",
                    data:{keyword:keyword, filter_by:filter_by,verify:"verify table",_token:token},
                },
                "deferRender": true,
                columns: [
                    {data: 'passport_number', name: 'passport_number'},
                    {data: 'ppuid', name: 'ppuid'},
                    {data: 'zds_code', name: 'zds_code'},
                    {data: 'name', name: 'name'},
                    {data: 'plate_no', name: 'plate_no'},
                    {data: 'platform', name: 'platform'},
                    {data: 'checkin', name: 'checkin'},
                    {data: 'checkout', name: 'checkout'},
                    {data: 'image', name: 'image'},
                    {data: 'remarks', name: 'remarks'},
                    {data: 'action', name: 'action'},
                ]
            });
        }
    </script>
    <script>
        $("#apply_filter").click(function(){
            var keyword  =   $("#keyword_filter").val();
            var filter_by  =   $("#filter_by").val();
            if(keyword != '' &&  filter_by != '')
            {
                $('#datatable_bike').DataTable().destroy();
                assign_load_data(keyword, filter_by);
            }
            else
            {
                tostr_display("error","Both field is required");
            }
        });

        $("#remove_apply_filter").click(function(){
            $("#keyword_filter").val('');
            $("#filter_by").val('');
            var keyword = 'nothing';
            var filter_by = '7';
            if(keyword != '' &&  filter_by != '')
            {
                $('#datatable_bike').DataTable().destroy();
                assign_load_data(keyword, filter_by);
            }
            else
            {
                tostr_display("error","Both field is required");
            }
        });
    </script>
    <script>
        $(document).on('click','.renew_btn_cls',function(){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('bike_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token: token},
                success: function (response) {
                    $('#all-detail').empty();
                    $('#all-detail').append(response.html);
                    $('.bike_history').modal('show');
                }
            });
        });
    </script>

    <script>
        $('#bike').select2({
            placeholder: 'Select an option'
        });
    </script>
    <script>
        $(document).on('change','#pass2', function(){
            $("#unique_div1").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {
                    var res = response.split('$');
                    $("#sur_name1").html(res[0]);
                    $("#given_names1").html(res[1]);
                    $("#unique_div1").show();
                    $("#exp_div").show();
                }
            });
        });
    </script>

    <script>
        $(document).on('change','#pass1', function(){
            $("#unique_div1").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {
                    var res = response.split('$');
                    $("#sur_name1").html(res[0]);
                    $("#given_names1").html(res[1]);
                    $("#unique_div1").show();
                    $("#exp_div").show();
                    ;
                }
            });
        });
    </script>

    <script>
        $(document).on('change','#pass3', function(){
            $("#unique_div1").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {
                    var res = response.split('$');
                    $("#sur_name1").html(res[0]);
                    $("#given_names1").html(res[1]);
                    $("#unique_div1").show();
                    $("#exp_div").show();
                }
            });
        });
    </script>
    <script>
        $("#pass-input2").change(function () {
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_passports') }}",
                method: 'POST',
                dataType: 'json',
                data: {_token: token},
                success: function (response) {
                    $('#all-check').empty();
                    $("#sur_name1").empty();
                    $("#given_names1").empty();
                    $("#unique_div1").hide();
                    $('#all-check').append(response.html);
                    $('#passport_div').hide();
                    $('#ppuid_div').hide();
                    $('#zds_code_div').hide();
                    $('#passport_div').show();
                    $(".select2-container").css("width","100%");
                    $('#pass1').select2({
                        placeholder: 'Select an option'
                    });
                }});
            });
    $("#pp-input2").change(function () {
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('ajax_get_ppuid') }}",
            method: 'POST',
            dataType: 'json',
            data: {_token: token},
            success: function (response) {
                $('#all-ppuid').empty();
                $("#sur_name1").empty();
                $("#given_names1").empty();
                $("#unique_div1").hide();
                $('#all-ppuid').append(response.html);
                $('#passport_div').hide();
                $('#ppuid_div').hide();
                $('#zds_code_div').hide();
                $('#ppuid_div').show();
                $(".select2-container").css("width","100%");
                $('#pass2').select2({
                    placeholder: 'Select an option'
                });
            }});
        });
        $("#zds-input2").change(function () {
            // $("#unique_div1").css('display','block');
            // var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_zds') }}",
                method: 'POST',
                dataType: 'json',
                data: {_token: token},
                success: function (response) {
                    $('#all-zds').empty();
                    $("#sur_name1").empty();
                    $("#given_names1").empty();
                    $("#unique_div1").hide();
                    $('#all-zds').append(response.html);
                    $('#passport_div').hide();
                    $('#ppuid_div').hide();
                    $('#zds_code_div').hide();
                    $('#zds_code_div').show();
                    $(".select2-container").css("width","100%");
                    $('#pass3').select2({
                        placeholder: 'Select an option'
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('change','#pass1,#pass2',function(){
            var ids = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('check_bike_reserve_ajax') }}",
                method: 'POST',
                data: {_token: token,passport_id:ids,type:"passport"},
                success: function (response) {
                    if(response!="false"){
                        $('#bike').val(response).trigger('change');
                    }else{
                        $('#bike').val(null).trigger('change');
                    }
                }
            });
        });
        $(document).on('change','#pass3',function(){
            var ids = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('check_bike_reserve_ajax') }}",
                method: 'POST',
                data: {_token: token,passport_id:ids,type:"zds_code"},
                success: function (response) {
                    if(response!="false"){
                        $('#bike').val(response).trigger('change');
                    }else{
                        $('#bike').val(null).trigger('change');
                    }
                }
            });
        });
        $(document).on('change','.radio_cls',function(){
            $('#bike').val(null).trigger('change');
        });
    </script>
    <script>
        $(document).on('click','.bik_btn_cls',function(){
        // $(".bik_btn_cls").click(function(){
            var ids = $(this).attr('id');
            var  action = $("#bike_modal_form").attr("action");
            var ab = action.split("assign_bike/");
            var action_now =  ab[0]+'assign_bike/'+ids;
            $("#bike_modal_form").attr('action',action_now);
            $("#bike_primary_id").val(ids);
            $('#bike_checkout').modal('show');
        });
    </script>
    <script>
        // $("#bike").change(function () {
        //     var ab = $(this).val();
        //     $.ajax({
        //         url: "get_asset_checkin_detail",
        //         method: 'get',
        //         data:{selected_id:ab,type:"2"},
        //         success: function (response) {
        //             var  array = JSON.parse(response);
        //             if(array.rider_name=="error"){

        //             }else{
        //                 $("#checkin_information_table").modal("show");
        //                 $("#checkin_checkin").html(array.checkin_time);
        //                 $("#platform_name").html(array.platform_name);
        //                 $("#rider_name_checkin").html(array.rider_name);
        //             }
        //         }
        //     });
        // });
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
    <script>
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }
        }
    </script>
@endsection
