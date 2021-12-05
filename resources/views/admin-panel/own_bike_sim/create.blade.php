@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
    <style>
        div.dataTables_wrapper div.dataTables_processing {

            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
    </style>




    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Add Rider Bike/Own</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>





    <div class="row">
        <div class="col-sm-12">
            <div class="card text-left">
                <div class="card-body">

                    <div class="card-title mb-3">Add Rider Bike/Own</div>
                    <form  action="{{ route('own_sim_bike.store') }}" method="POST" enctype="multipart/form-data">

                        {!! csrf_field() !!}


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

                        <input type="hidden" name="passport_id_selected_checkout_input" id="passport_id_selected_checkout_input">

                        <div class="row">
                                <div class="col-md-5 form-group  mb-3">
                                    <label for="repair_category">Search Rider</label><br>
                                    <div class="input-group ">
                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead_checkout" id="keyword" required autocomplete="off" type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                        <div id="clear">
                                            X
                                        </div>
                                    </div>
                                    <input type="text" id="app_id" style="display: none" >
                                </div>

                                <div class="col-md-2 form-group mb-3">
                                    <label for="repair_category">Rider Have own Bike.?</label>
                                    <label class="checkbox checkbox-outline-primary">
                                        <input type="checkbox" name="rider_bike" value="1"><span>Yes</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            <div class="col-md-2 form-group mb-3">
                                <label for="repair_category">Rider have own sim.?</label>
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" name="rider_sim" value="1"><span>Yes</span><span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Check IN</label>
                                <input class="form-control form-control" id="checkin" name="checkin" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" type="datetime-local" required  />
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-12">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
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




                }
            });




        });
    </script>



    <script>
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

    </script>


    <script>

        $('#platform_id').select2({
            placeholder: 'Select an option'
        });
    </script>


    <script>
        $(document).ready(function () {
            // load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable').DataTable().destroy();
                    load_data(start_date, end_date);
                }
                else
                {
                    tostr_display("error","Both date is required");
                }

            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#datatable').DataTable().destroy();
                load_data();
            });


        });

        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('rider_profile.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }

        function resetPassportFile() {
            $('#passport-change').hide();
            $('.passport-div').show();
        }
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
