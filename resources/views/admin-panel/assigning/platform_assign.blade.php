@extends('admin-panel.base.main')
@section('css')

    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>

        a.disabled {
            pointer-events: none;
            cursor: default;
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
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assignings</a></li>
            <li>Platform Check-in/Check-out</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    platform code update and new modal start--}}

    <div class="modal fade bd-example-modal-md " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="POST" id="update_form" action="{{ route('usercodes.update',1) }}">
                    @method('PUT')
                    {!! csrf_field() !!}

                    <input type="hidden" id="is_display_from_checkin" value="1">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update User Codes</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Platform Name</label>
                                <input class="form-control" readonly name="platform_name" id="platform_name">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 form-group" id="new_on_board_check_div" >
                            <label class="checkbox checkbox-outline-success">
                                <input type="checkbox"  id="new_on_board_check"><span class="font-weight-bold">New On Board</span><span class="checkmark"></span>
                            </label>
                        </div>



                        <input type="hidden" name="passport_id" id="passport_ids">
                        <input type="hidden" name="platform_id" id="platform_id_selected_current">

                        <br>
                        <div class="row ">
                            <div class="col-md-12 form-group">
                                <label>Platform Code</label>
                                <input class="form-control"  name="plateform_code" id="plateform_code">
                            </div>
                        </div>
                        <input type="hidden" id="plateform_code_id" name="plateform_code">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="card-title">Is Agreement Created.?</div>
                                <span  class="badge badge-pill badge-primary p-2 m-1 hide" id="agreement_yes">Yes</span>
                                <span class="badge badge-pill badge-danger p-2 m-1 hide" id="agreement_no">No</span>
                                <a class="btn btn-primary text-white hide"  id="agreement_create_link" target="_blank">Create Agreement</a>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="card-title">Is Driving Licence.?</div>
                                <span class="badge badge-pill badge-primary p-2 m-1 hide" id="licence_yes">Yes</span>
                                <span class="badge badge-pill badge-danger p-2 m-1 hide" id="licence_no">No</span>
                                <a class="btn btn-primary text-white hide" target="_blank" id="licence_create_link" >Create Driving Licence</a>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2 " id="update_button_ab" type="button">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    end here modal update here--}}




    <h4 class="card-title mb-3">Platform Assign</h4>

    <ul class="nav nav-tabs" id="dropdwonTab">
        <li class="nav-item"><a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" aria-expanded="true">Platform OnBoard</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" aria-expanded="false">Platform OffBoard</a></li>
    </ul>
    <div class="tab-content px-1 pt-1" id="dropdwonTabContent">
        <div class="tab-pane  fade show active " id="home" role="tabpanel" aria-labelledby="home-tab" aria-expanded="true">


            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <form action ="{{ route('plateform_assign') }}" method="POST" id="form_checkin">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                    <label class="radio-outline-success ">Name:</label>
                                    <h6 id="name_passport" class="text-dark ml-3 "></h6>
                                </div>
                            </div>
                            <input type="hidden" name="passport_id_selected" id="passport_id_selected">


                            <div class="row">
                                <div class="col-md-5">
                                    <?php $work_count = 0;  ?>
                                    @foreach($sub_cat_work as $work)
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" class="search_type_cls" {{ ($work_count=="0") ? 'checked' : '' }}   value="{{ $work->id }}" name="work_type" /><span>{{ $work->name }}</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <?php $work_count = $work_count+1;  ?>
                                    @endforeach
                                </div>

                                <div class="col-md-3" id="sim_elig" style="display: none">
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" value="1" name="sim_eligibility"><span>SIM Eligbility</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-md-3" id="bike_elig" style="display: none">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" value="1" name="bike_eligibilty"><span>Bike Eligibilty</span><span class="checkmark"></span>
                                    </label>
                                </div>


                            </div>



                            <div class="row">
                                <div class="col-md-3 form-group mb-3" id="passport_div" style="display: none">
                                    <label for="repair_category">Passport Number</label><br>
                                    <div id="all-check" >
                                    </div>
                                </div>

                                <div class="col-md-3 form-group mb-3" id="ppuid_div" style="display: none">
                                    <label for="repair_category">PPUID</label><br>
                                    <div id="all-ppuid" >
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-3" id="zds_code_div" style="display: none">
                                    <label for="repair_category">ZDS Code</label><br>
                                    <div id="all-zds" >
                                    </div>
                                </div>

                                <div class="col-md-6 form-group  mb-3">
                                    <label for="repair_category">Search Rider</label><br>
                                    <div class="input-group ">
                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead" id="keyword" autocomplete="off" type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                        <div id="clear">
                                            X
                                        </div>
                                    </div>

                                    <input type="text" id="app_id" style="display: none" >

                                </div>




                                <div class="col-md-6 form-group mb-3" id="unique_div1" style="display: none" >
                                    <label for="repair_category">Name</label><br>
                                    <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>
                                </div>



                                {{--                                    <div class="col-md-2 form-group mb-3 new_on_board_div" style="display: none" >--}}
                                {{--                                        <label for="repair_category">New On Board</label> <br>--}}
                                {{--                                        <select name="new_on_board" id="new_on_board">--}}
                                {{--                                            <option value=""  >Select option</option>--}}
                                {{--                                            <option value="1">Yes</option>--}}
                                {{--                                            <option value="2">No</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}

                                <input type="hidden" id="checkbox_value" name="new_on_board" value="3">


                                <div class="col-md-2 form-group mb-3 div_platform" style="display: none;">
                                    <label for="repair_category">Plateform</label>
                                    <select id="plateform" name="plateform" class="form-control" required>
                                        <option value=""  >Select option</option>
                                        @foreach($plateform as $plate)
                                            <option value="{{ $plate->id }}">{{ $plate->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Cities</label>
                                    <select id="cities" name="city_id" class="form-control cls_card_type" required>
                                        <option value="" selected disabled>Select option</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" @if(isset($platforms_data)) {{ ($city->id==$platforms_data->city_id) ? 'selected' : '' }} @endif >{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>









                                <div class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Check IN</label>
                                    <input class="form-control form-control" id="checkin" name="checkin" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" type="datetime-local" required  />
                                </div>

                                <div class="col-md-3 form-group mb-3 append_div dc_div">
                                    <label for="repair_category">Select DC</label>
                                    <select class="form-control" name="to_dc_id" id="to_dc_id" required >
                                        <option value="" selected  >select an option</option>

                                    </select>
                                </div>

                                <div class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Rider Have own Bike.?</label>
                                    <label class="checkbox checkbox-outline-primary">
                                        <input type="checkbox" name="rider_bike" value="1" ><span>Yes</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-md-3 form-group mb-3">
                                    <label for="repair_category">Rider have own sim.?</label>
                                    <label class="checkbox checkbox-outline-primary">
                                        <input type="checkbox"   name="rider_sim"  value="1"><span>Yes</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="row to_display_dc_remain_div" style="display: none;" >
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="repair_category" class="font-weight-bold">Total DC LIMIT</label>
                                            <h4 class="text-primary font-weight-bold" id="to_total_dc_html">0</h4>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="repair_category" class="font-weight-bold" >Total Rider Assigned TO DC</label>
                                            <h4 class="text-info font-weight-bold" id="to_total_assigned_dc_html" >0</h4>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="repair_category" class="font-weight-bold">Total Limit Remain of DC</label>
                                            <h4 class="text-success font-weight-bold" id="to_total_remain_dc_html" >0</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary">Save</button>
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
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                        <div class="card-body">

                                            <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                <label for="start_date">Filter By</label>
                                                <select  id="filter_by" class="form-control form-control-plaintext" required >
                                                    <option selected disabled >Filter By</option>
                                                    <option value="1"> Passport Number</option>
                                                    <option value="2">Name</option>
                                                    <option value="3">ZDS Code</option>
                                                    <option value="4">PlatForm</option>
                                                </select>

                                            </div>

                                            <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                <label for="end_date">Search</label>
                                                <input type="text" name="keyword" class="form-control form-control-plaintext" required id="keyword_search">

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
                                        <table class="display table table-striped table-bordered" id="datatable_platform" style="width: 100%">
                                            <thead class="thead-dark">
                                            <tr>

                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Plateform</th>
                                                <th scope="col">Zds Code</th>
                                                <th scope="col">City</th>
                                                <th scope="col">Checkin</th>
                                                <th scope="col">Checkout</th>
                                                <th scope="col">Remarks</th>

                                                <th scope="col">Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--------- Bike CheckOut Model---------->


                        <!--------- Plateform CheckOut Model---------->
                        <div class="modal fade" id="plateform_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="row">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verifyModalContent_title">Plateform Checkout</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">


                                            <form  action="{{action('Assign\AssginPlateformController@update' ,"1")}}" id="plateform_modal_form" method="post">
                                                <input type="hidden" id="plateform_primary_id" name="plateform_primary_id">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}

                                                <label for="repair_category">Check Out</label>
                                                <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" required  />

                                                <label for="repair_category">Remarks</label>
                                                <textarea class="form-control form-control" id="remarks" name="remarks"></textarea>







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
                    </div>
                </div>
            </div>

        </div>
        {{--        first tab end here--}}

        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab" aria-expanded="false">

            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <form action="{{action('Assign\AssginPlateformController@update' ,"1")}}" method="POST" id="form_checkout">

                            {!! csrf_field() !!}
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 form-check-inline mb-3 text-center" id="name_div_checkout" style="display: none;" >


                                    <label class="radio-outline-success font-weight-bold">Name:</label>
                                    <h6 id="name_passport_checkout" class="text-dark ml-3 "></h6>
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                    <label class="radio-outline-success   font-weight-bold ">Platform:</label>
                                    <h6 id="name_passport_checkout_platform_name" class="text-dark ml-3 "></h6>
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                    <label class="radio-outline-success   font-weight-bold ">Chekin Date & Time:</label>
                                    <h6 id="name_passport_checkout_checkin" class="text-dark ml-3 "></h6>
                                    <h6 id="platform_id_selected_checkout" class="text-dark ml-3 " style="display: none"></h6>
                                    <h6 id="passport_id_selected_checkout" class="text-dark ml-3 " style="display: none"></h6>

                                </div>


                            </div>
                            <input type="hidden" name="passport_id_selected_checkout" id="passport_id_selected_checkout_input">
                            <input type="hidden" name="current_platform_id" id="current_platform_id">


                            <div class="row">

                                <div class="col-md-6 form-group  mb-3">
                                    <label for="repair_category">Search Rider</label><br>
                                    <div class="input-group ">
                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead_checkout" id="keyword_checkout" autocomplete="off" type="text" value="" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                        <div id="clear">
                                            X
                                        </div>
                                    </div>
                                    <input type="text" id="app_id" style="display: none" >
                                </div>


                                <div class="col-md-3 form-group mb-3" id="unique_div1" style="display: none" >
                                    <label for="repair_category">Name</label><br>
                                    <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>
                                </div>



                                <div class="col-md-6 form-group mb-3" id="unique_div1">
                                    <label for="repair_category">Check Out</label>
                                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>"  required  />

                                </div>



                                <div class="col-md-6 form-group mb-3 div_platform" >
                                    <label for="repair_category">Remarks</label>
                                    <textarea class="form-control form-control" id="remarks" name="remarks" cols="" rows="4"></textarea>
                                </div>

                                <div class="col-md-6 mb-3 text-left">
                                    <label for="repair_category">Checkout Type</label>
                                    <select class="form-control" name="checkout_type" id="checkout_type" required id="checkout_type">
                                        <option value="" selected disabled>please select option</option>
                                        @foreach(get_checkout_type_names() as $key => $v)
                                            <option value="{{ $key }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 from_date_div_cls" style="display: none">
                                    <label for="repair_category">From Date</label>
                                    <input type="text" autocomplete="off" id="from_date" name="from_date" class="form-control">
                                </div>

                                <div class="col-md-3 vacation_day_div_cls" style="display: none">
                                    <label for="repair_category">Number Of Leaves</label>
                                    <input type="number" autocomplete="off" id="leaves_day" name="leaves_day" class="form-control">
                                </div>

                                <div class="col-md-6 expected_div_cls mb-3" style="display: none">
                                    <label for="repair_category">Expected Date To Return</label>
                                    <input type="text" autocomplete="off" id="expected_date" name="expected_date" readonly class="form-control">
                                </div>



                                <div class="col-md-6 plaform_div_cls" style="display: none;">
                                    <label for="repair_category">Platform</label>
                                    <select class="form-control select multi-select" id="platform" name="platform[]" multiple="multiple">
                                        @foreach($plateform as $plat)
                                            @php
                                                $isSelected=isset($userData)?($userData->user_platform_id?in_array($plat->id,$userData->user_platform_id):false):false;
                                            @endphp
                                            <option value="{{$plat->id}}"@if($isSelected) selected @endif>{{$plat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>




                                <div class="col-md-12">
                                    <button class="btn btn-primary">Save</button>
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
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                        <div class="card-body">

                                            <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                <label for="start_date">Filter By</label>
                                                <select  id="filter_by" class="form-control form-control-plaintext" required >
                                                    <option selected disabled >Filter By</option>
                                                    <option value="1"> Passport Number</option>
                                                    <option value="2">Name</option>
                                                    <option value="3">ZDS Code</option>
                                                    <option value="4">PlatForm</option>
                                                </select>

                                            </div>

                                            <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                <label for="end_date">Search</label>
                                                <input type="text" name="keyword_search_checkout" class="form-control form-control-plaintext" required id="keyword_search_checkout">

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
                                        <table class="display table table-striped table-bordered" id="datatable_platform_checkout" style="width: 100%">
                                            <thead class="thead-dark">
                                            <tr>

                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Plateform</th>
                                                <th scope="col">Zds Code</th>
                                                <th scope="col">City</th>
                                                <th scope="col">Checkin</th>
                                                <th scope="col">Checkout</th>
                                                <th scope="col">Remarks</th>

                                                <th scope="col">Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--------- Bike CheckOut Model---------->


                        <!--------- Plateform CheckOut Model---------->
                        <div class="modal fade" id="plateform_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="row">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verifyModalContent_title">Plateform Checkout</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">


                                            <form  action="{{action('Assign\AssginPlateformController@update' ,"1")}}" id="plateform_modal_form" method="post">
                                                <input type="hidden" id="plateform_primary_id" name="plateform_primary_id">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}

                                                <label for="repair_category">Check Out</label>
                                                <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>"  required  />

                                                <label for="repair_category">Remarks</label>
                                                <input class="form-control form-control" id="remarks" name="remarks" type="text"   />


                                                <div class="row">

                                                    <div class="col-md-6 mb-3 text-left">
                                                        <label for="repair_category">Checkout Type</label>
                                                        <select class="form-control" name="checkout_type" id="checkout_type" required id="checkout_type">
                                                            <option value="" selected disabled>please select option</option>
                                                            <option value="1">Shuffle Platform</option>
                                                            <option value="2">Vacation</option>
                                                            <option value="3">Terminate By Platform</option>
                                                            <option value="4">Terminate By Company</option>
                                                            <option value="5">Accident</option>
                                                            <option value="6">Absconded</option>
                                                            <option value="7">Demised</option>
                                                            <option value="8">Cancellation</option>
                                                            <option value="9">ForceFully Taken</option>
                                                        </select>
                                                    </div>



                                                </div>



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
                    </div>
                </div>
            </div>

        </div>
        {{--        checkout tab end here--}}

    </div>
    {{--    tab content here--}}



@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // $("#checkin").val(new Date().toJSON().slice(0,19));
            $('#to_dc_id').select2({
                placeholder: 'Select an option'
            });
        })
    </script>

    <script>
        $(".search_type_cls").change(function(){
            var selected = $(this).val();

                if(selected=="11"){  //supervise checked
                $(".dc_div").hide();
                $("#to_dc_id").prop('required',false);
                }else{

                $(".dc_div").show();
                $("#to_dc_id").prop('required',true);

                }

        })
        </script>


    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {

                    return process(data);
                });
            },
            highlighter: function (item, data) {
                var parts = item.split('#'),
                    html = '<div class="row drop-row">';
                if (data.type == 0) {
                    html += '<div class="col-lg-12 sugg-drop">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }

                return html;
            }
        });
    </script>

    <script>
        $(document).on('click', '.sugg-drop', function(){
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();

            $.ajax({
                url: "{{ route('get_passport_name_detail') }}",
                method: 'POST',
                data:{passport_id:keyword,_token:token},
                success: function (response) {

                    var  array = JSON.parse(response);
                    $("#name_div").show();
                    $("#name_passport").html(array.name);
                    $("#passport_id_selected").val(array.id);
                    $(".div_platform").show();
                    $(".new_on_board_div").show();
                    $('#plateform').select2({
                        placeholder: 'Select an option'
                    });
                    $("#plateform").val(null).trigger('change');


                    var four_pl =  array.four_pl_status;
                    if(four_pl=='1' ){
                        $("#sim_elig").show();
                        $("#bike_elig").show();
                    }
                    else{
                        $("#sim_elig").hide();
                        $("#bike_elig").hide();
                    }

                }
            });
        });
    </script>

    <script>
        //new on board not requre the platform code
        $(document).ready(function() {
            $('#new_on_board_check').val($(this).is(':checked'));
            $('#new_on_board_check').change(function() {
                if($(this).is(":checked")) {
                    $("#checkbox_value").val('1');
                }
                else{
                    $("#checkbox_value").val('2');
                }
            });
        });

        // if ($('#new_on_board_check').is(":checked"))
        // {
        //     alert('asdf');
        //     // it is checked
        // }

        $("input[type='checkbox']").val();

        $("#platform").change(function () {
            var id = $("#new_on_board option:selected").val();

            // $("#new_on_board_val").val(id);
        });
        $("#plateform").change(function () {

            var value_ab = $(this).val();
            var value_text = $("#plateform option:selected" ).text();

            var passport_id = $("#passport_id_selected").val();
            var token = $("input[name='_token']").val()
            var val='0';

            $("#is_display_from_checkin").val("1");




            // var onboard = $('input[name="new_on_board"]');




            if(value_ab!=""){

                $("#edit_modal").modal('show');
                $("#platform_name").val(value_text);
                $("#platform_id_selected_current").val(value_ab);
                // $("#platform_name").val(passport_id);


                $.ajax({
                    url: "{{ route('get_specific_rider_plaform_code') }}",
                    method: 'POST',
                    data:{platform:value_ab,passport_id:passport_id,_token:token},
                    success: function (response) {
                        var  array = JSON.parse(response);


                        if(array.is_agreement=="yes"){
                            $("#agreement_yes").show();
                            $("#agreement_no").hide();
                            $("#agreement_create_link").hide();
                        }else{
                            $("#agreement_yes").hide();
                            $("#agreement_no").show();
                            $("#agreement_create_link").attr('href',array.is_agreement);
                            $("#agreement_create_link").show();
                        }

                        if(array.is_driving=="yes"){
                            $("#licence_yes").show();
                            $("#licence_no").hide();
                            $("#licence_create_link").hide();
                        }else{
                            $("#licence_yes").hide();
                            $("#licence_no").show();
                            $("#licence_create_link").attr('href',array.is_driving);
                            $("#licence_create_link").show();
                        }

                        $("#plateform_code").val("");
                        $("#plateform_code_id").val("");
                        if(array.platform_code!=""){
                            $("#plateform_code").val(array.platform_code);
                            $("#plateform_code_id").val(array.id);

                            $("#plateform_code").prop('readonly',true);
                            $("#plateform_code").css('background-color','#8080805c');

                            var action=  $("#update_form").attr('action');
                            var ab = action.split('usercodes/');
                            var action_change =  ab[0]+'usercodes/'+array.id;
                            $("#update_form").attr('action',action_change);
                        }else{
                            var action=  $("#update_form").attr('action');

                            var ab = action.split('usercodes/');

                            var action_change =  ab[0]+'usercodes/0';

                            $("#update_form").attr('action',action_change);

                            $("#plateform_code").removeAttr('readonly');
                            $("#plateform_code").css('background-color','#fff');

                            console.log("code is not exist");
                        }


                    }
                });

            }

            $('#to_dc_id').empty();

            $.ajax({
                url: "{{ route('get_dc_by_platforms') }}",
                method: 'get',
                dataType: 'json',
                data: {user_id: "0", platform_id:value_ab},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        var html_ab = '';
                        for(var i=0; i<len; i++){
                            // html_ab += '<option value="'+response[i].id+'">'+response[i].name+'</option>';
                            add_dynamic_dc(response[i].id,response[i].name);
                        }

                    }
                }
            });


        });
    </script>

    <script>
        function add_dynamic_dc(id,text_ab){



            if ($('#to_dc_id').find("option[value='"+id+"']").length) {
                // $('#visa_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default

                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#to_dc_id').append(newOption);
            }
            $('#to_dc_id').val(null).trigger('change');
        }
    </script>

    <script>
        $("#update_button_ab").click(function () {

            var now_action = $("#update_form").attr('action');
            var platform_code = $("#plateform_code").val();
            var platform_id = $("#platform_id_selected_checkout").val();
            var platform_id2 = $("#platform_id_selected_current").val();
            var platform_id_checkin = $("#plateform").val();

            var platform_code = $("#plateform_code").val();
            var platform_id = $("#plateform option:selected").val();

            var display_status = $("#is_display_from_checkin").val();

            if(display_status=="1"){
                var passport_id = $("#passport_id_selected").val();
            }else{
                var passport_id = $("#passport_id_selected_checkout_input").val();
            }



            var new_on_board_val = $("#checkbox_value").val();



            var token = $("input[name='_token']").val();

            var contact_html = "";
            $.ajax({
                url: now_action,
                method: 'PUT',
                data: {platform_code: platform_code, platform_id:platform_id, platform_id2:platform_id2,platform_id_checkin:platform_id_checkin,passport_id:passport_id,new_on_board_val:new_on_board_val,_token:token},
                success: function(response) {
                    var arr = $.parseJSON(response);

                    if(arr !== null){
                        if(arr['alert-type']=="success"){
                            toastr["success"](arr['message']);
                            // var passport_id = arr['passport_id'];
                            // var platform_name = arr['platform_name'];
                            // $("#"+passport_id+"-"+platform_name).html(platform_code);
                        }else{
                            toastr["error"](arr['message']);
                        }

                    }
                }
            });

        });
    </script>


    {{--                    for checkout javascript start here--}}

    <script type="text/javascript">
        var path = "{{ route('autocomplete_from_checkin_platform') }}";
        $('input.typeahead_checkout').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {

                    return process(data);
                });
            },
            highlighter: function (item, data) {
                var parts = item.split('#'),
                    html = '<div class="row drop-row">';
                if (data.type == 0) {
                    html += '<div class="col-lg-12 sugg-drop_checkout">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
                    html += '<div class="col-lg-12 sugg-drop_checkout" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }

                return html;
            }
        });
    </script>

    <script>
        $(document).on('click', '.sugg-drop_checkout', function(){
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();
            var platform_id = "";



            $.ajax({
                url: "{{ route('get_passport_name_detail') }}",
                method: 'POST',
                data:{passport_id:keyword,_token:token},
                success: function (response) {

                    var  array = JSON.parse(response);
                    $("#name_div_checkout").show();
                    $("#name_passport_checkout").html(array.name);
                    $("#name_passport_checkout_platform_name").html(array.platform_name);
                    $("#name_passport_checkout_checkin").html(array.checkin_time);
                    $("#passport_id_selected_checkout").val(array.id);
                    $("#passport_id_selected_checkout_input").val(array.id);
                    $("#passport_ids").val(array.id);
                    $("#platform_id_selected_checkout").val(array.platform_id);
                    $("#last_platform").val(array.last_platform);
                    platform_id =  $("#current_platform_id").val(array.platform_id);
                    platform_id =  $("#current_platform_id").val(array.platform_id);

                    $("#platform_id_selected_current").val(array.platform_id);
                    display_popup_on_checkout_tab(array.platform_id);



                }
            });




        });
    </script>


    <script>

        function  display_popup_on_checkout_tab(value_ab) {


            var value_text = $("#name_passport_checkout_platform_name").text();
            var passport_id = $("#passport_id_selected_checkout_input").val();
            var token = $("input[name='_token']").val();

            $("#is_display_from_checkin").val("0");


            $("#edit_modal").modal('show');
            $("#new_on_board_check_div").hide();

            $("#platform_name").val(value_text);


            $.ajax({
                url: "{{ route('get_specific_rider_plaform_code') }}",
                method: 'POST',
                data:{platform:value_ab,passport_id:passport_id,_token:token},
                success: function (response) {
                    var  array = JSON.parse(response);


                    if(array.is_agreement=="yes"){
                        $("#agreement_yes").show();
                        $("#agreement_no").hide();
                        $("#agreement_create_link").hide();
                    }else{
                        $("#agreement_yes").hide();
                        $("#agreement_no").show();
                        $("#agreement_create_link").attr('href',array.is_agreement);
                        $("#agreement_create_link").show();
                    }

                    if(array.is_driving=="yes"){
                        $("#licence_yes").show();
                        $("#licence_no").hide();
                        $("#licence_create_link").hide();
                    }else{
                        $("#licence_yes").hide();
                        $("#licence_no").show();
                        $("#licence_create_link").attr('href',array.is_driving);
                        $("#licence_create_link").show();
                    }

                    $("#plateform_code").val("");
                    $("#plateform_code_id").val("");
                    if(array.platform_code!=""){
                        $("#plateform_code").val(array.platform_code);
                        $("#plateform_code_id").val(array.id);

                        $("#plateform_code").prop('readonly',true);
                        $("#plateform_code").css('background-color','#8080805c');

                        var action=  $("#update_form").attr('action');
                        var ab = action.split('usercodes/');
                        var action_change =  ab[0]+'usercodes/'+array.id;
                        $("#update_form").attr('action',action_change);
                    }else{
                        var action=  $("#update_form").attr('action');

                        var ab = action.split('usercodes/');

                        var action_change =  ab[0]+'usercodes/0';

                        $("#update_form").attr('action',action_change);

                        $("#plateform_code").removeAttr('readonly');
                        $("#plateform_code").css('background-color','#fff');

                        console.log("code is not exist");
                    }


                }
            });

        }

    </script>



    <script>

        $("#from_date").change(function () {

            $("#leaves_day").val(null);
            $("#expected_date").val("");
        });

        ;(function($, window, document, undefined){
            $("#leaves_day").on("change", function(){
                var date = new Date($("#from_date").val());
                var days = parseInt($("#leaves_day").val());

                if(days!=null || days!=""){

                    if(!isNaN(date.getTime())){
                        date.setDate(date.getDate()+days);
                        $("#expected_date").val(date.toInputFormat());
                    } else {
                        alert("Invalid Date");
                    }
                }



            });


            //From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
            Date.prototype.toInputFormat = function() {
                var yyyy = this.getFullYear().toString();
                console.log(yyyy);
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
            };
        })(jQuery, this, document);

    </script>



    {{--                    for checkout end here javascript--}}



    <script>
        tail.DateTime("#expected_date--",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#from_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        $("#checkout_type").change(function(){

            var  vars = $(this).val();

            if(vars=="1" ||vars=="3" || vars=="4" ){
                $(".plaform_div_cls").show();
                $("#platform").prop('required',true);
                $('#platform').select2({
                    placeholder: 'Select an option'
                });

                $('#platform').val(null).trigger('change');

                $(".expected_div_cls").hide();
                $("#expected_date").prop('required',false);
                $("#expected_date").val("");

                $(".vacation_day_div_cls").hide();
                $("#leaves_day").prop('required',false);
                $("#leaves_day").val("");

                $(".from_date_div_cls").hide();
                $("#from_date").prop('required',false);
                $("#from_date").val("");

// vacation
                $(".expected_div_cls").show();


                $(".vacation_day_div_cls").show();


                $(".from_date_div_cls").show();




            }else if(vars=="6" || vars=="7"){
                $(".expected_div_cls").hide();
                $("#expected_date").prop('required',false);
                $("#expected_date").val("");

                $(".plaform_div_cls").hide();
                $("#platform").prop('required',false);
                $('#platform').val(null).trigger('change');

                $(".vacation_day_div_cls").hide();
                $("#leaves_day").prop('required',false);
                $("#leaves_day").val("");

                $(".from_date_div_cls").hide();
                $("#from_date").prop('required',false);
                $("#from_date").val("");

                // vacation
                $(".expected_div_cls").show();


                $(".vacation_day_div_cls").show();


                $(".from_date_div_cls").show();


            }else if(vars=="2"){
                $(".expected_div_cls").show();
                $("#expected_date").prop('required',true);
                $("#expected_date").val("");

                $(".vacation_day_div_cls").show();
                $("#leaves_day").prop('required',true);
                $("#leaves_day").val("");

                $(".from_date_div_cls").show();
                $("#from_date").prop('required',true);
                $("#from_date").val("");






                $(".plaform_div_cls").hide();
                $("#platform").prop('required',false);

                $('#platform').select2({
                    placeholder: 'Select an option'
                });
                $('#platform').val(null).trigger('change');
            }
            else if(vars=="5"){
                $(".expected_div_cls").show();
                $("#expected_date").prop('required',true);
                $("#expected_date").val("");

                $(".plaform_div_cls").hide();
                $("#platform").prop('required',false);


                $(".vacation_day_div_cls").hide();
                $("#leaves_day").prop('required',false);
                $("#leaves_day").val("");

                $(".from_date_div_cls").hide();
                $("#from_date").prop('required',false);
                $("#from_date").val("");

                // vacation
                $(".expected_div_cls").show();


                $(".vacation_day_div_cls").show();


                $(".from_date_div_cls").show();


                $('#platform').select2({
                    placeholder: 'Select an option'
                });
                $('#platform').val(null).trigger('change');
            }else{
                $(".expected_div_cls").hide();
                $("#expected_date").prop('required',false);
                $("#expected_date").val("");

                $(".plaform_div_cls").hide();
                $("#platform").prop('required',false);
                $('#platform').val(null).trigger('change');


                $(".vacation_day_div_cls").hide();
                $("#leaves_day").prop('required',false);
                $("#leaves_day").val("");

                $(".from_date_div_cls").hide();
                $("#from_date").prop('required',false);
                $("#from_date").val("");

                // vacation
                $(".expected_div_cls").show();


                $(".vacation_day_div_cls").show();


                $(".from_date_div_cls").show();

            }








        });

    </script>

    <script>
        function assign_load_data(keyword= '', filter_by= ''){

            var token = $("input[name='_token']").val();

            var table = $('#datatable_platform').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },


                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                // "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                    url : "{{ route('assign_plateform') }}",
                    data:{keyword:keyword, filter_by:filter_by,verify:"verify table",_token:token},
                },

                "deferRender": true,
                columns: [
                    {data: 'passport_number', name: 'passport_number'},
                    {data: 'name', name: 'name'},
                    {data: 'platform', name: 'platform'},
                    {data: 'zds_code', name: 'zds_code'},
                    {data: 'city', name: 'city'},
                    {data: 'checkin', name: 'checkin'},
                    {data: 'checkout', name: 'checkout'},
                    {data: 'remarks', name: 'remarks'},
                    {data: 'action', name: 'action'},

                ]
            });

        }
    </script>


    <script>
        $("#apply_filter").click(function(){

            var keyword  =   $("#keyword_search").val();
            var filter_by  =   $("#filter_by").val();

            if(keyword!='' &&  filter_by!='')
            {
                $('#datatable_platform').DataTable().destroy();
                assign_load_data(keyword, filter_by);
            }
            else
            {
                tostr_display("error","Both field is required");
            }

        });

        $("#remove_apply_filter").click(function(){

            $("#keyword_search").val('');
            $("#filter_by").val('');
            var keyword = 'nothing';
            var filter_by = '5';

            if(keyword != '' &&  filter_by != '')
            {
                $('#datatable_platform').DataTable().destroy();
                assign_load_data(keyword, filter_by);
            }
            else
            {
                tostr_display("error","Both field is required");
            }

        });
    </script>


    <script>

        $('#plateform').select2({
            placeholder: 'Select an option'
        });

        $('#passport_number3').select2({
            placeholder: 'Select an option'
        });


        $(document).ready(function () {

            assign_load_data();
        });


        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable_sim').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="profile-basic-tab"){
                    $('#pass1').select2({
                        placeholder: 'Select an option'
                    });

                    $('#bike').select2({
                        placeholder: 'Select an option'
                    });



                    var table = $('#datatable_bike').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else{
                    $('#passport_number3').select2({
                        placeholder: 'Select an option'
                    });
                    $('#plateform').select2({
                        placeholder: 'Select an option'
                    });
                    var table = $('#datatable_platform').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
        });

    </script>

    <script>
        $("#passport_number").change(function () {
            $("#unique_div").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {

                    var res = response.split('$');
                    $("#sur_name").html(res[0]);
                    $("#given_names").html(res[1]);
                    $("#unique_div").show();
                    $("#exp_div").show();
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
                }
            });

        });
    </script>

    <script>
        $("#clear").click(function(){
            $("#keyword").val('');
        });
    </script>

    <script>
        $("#pass1").change(function () {
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
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
                }
            });

        });
    </script>
    <script>
        $("#passport_number3").change(function () {
            $("#unique_div3").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {



                    var res = response.split('$');
                    $("#sur_name3").html(res[0]);
                    $("#given_names3").html(res[1]);
                    $("#unique_div3").show();
                    $("#exp_div").show();
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
                }
            });

        });
    </script>

    <script>

        $(document).on('change','#pass3', function(){
            // $("#pass1").change(function () {
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
            // $("#unique_div1").css('display','block');
            // var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_passports_platform') }}",
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
            // $("#unique_div1").css('display','block');
            // var passport_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_ppuid_platform') }}",
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
                url: "{{ route('ajax_get_zds_platform') }}",
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
        $(".sim_btn_cls").click(function(){
            var ids = $(this).attr('id');

            var  action = $("#sim_form").attr("action");

            var ab = action.split("assign/");

            var action_now =  ab[0]+'assign/'+ids;

            $("#sim_form").attr('action',action_now);

            // $("#")
            // alert(ab);

            $("#sim_primary_id").val(ids);
            $('#form_update').modal('show');
        });
    </script>


    <script>
        $(".bik_btn_cls").click(function(){
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
        $(document).on('click','.plateform_btn_cls', function(){
            var ids = $(this).attr('id');

            var  action = $("#plateform_modal_form").attr("action");

            var ab = action.split("assign_plateform/");

            var action_now =  ab[0]+'assign_plateform/'+ids;

            $("#plateform_modal_form").attr('action',action_now);


            $("#plateform_primary_id").val(ids);
            $('#plateform_checkout').modal('show');
        });
    </script>


    @if(isset($checkout))

        <script>
            $(function(){
                $('#form_update').modal('show')
            });
        </script>

    @endif

    @if(isset($bike_checkout))

        <script>
            $(function(){
                $('#bike_checkout').modal('show')
            });
        </script>

    @endif

    @if(isset($plateform_checkout))

        <script>
            $(function(){
                $('#plateform_checkout').modal('show')
            });
        </script>

    @endif

    <script>
        $(document).on("change", "#to_dc_id", function (e) {
            // e.stopPropagation();

            var selected_platform = $("#plateform option:selected").val();
            var user_id = $("#to_dc_id").val();

            var to_dc_id = $("#to_dc_id").val();


            if(selected_platform!=null && user_id!=null){
                $.ajax({
                    url: "{{ route('get_remain_dc_counts') }}",
                    method: 'get',
                    data: {user_id: user_id,platform_id:selected_platform},
                    success: function(response) {

                        var  array = JSON.parse(response);

                        $(".to_display_dc_remain_div").show(400);
                        $("#to_total_dc_html").html(array.total_dc_limit);
                        $("#to_total_assigned_dc_html").html(array.total_rider_assigned);
                        $("#to_total_remain_dc_html").html(array.total_rider_remain);

                        if(parseInt(array.total_rider_remain)< 1){
                            tostr_display("error","Limit is completed, please select another DC");
                        }



                    }
                });

            }else{
                $(".to_display_dc_remain_div").hide();

            }

        });
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

