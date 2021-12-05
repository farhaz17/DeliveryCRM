@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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
            <li><a href="">Request Passport</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <form method="post" action="{{ route('request_passport.store') }}">
        {!! csrf_field() !!}

        <div class="row m-4">
            <div class="col-md-4 form-group  mb-3">
                <label for="repair_category">Search Passport</label><br>
                <div class="input-group ">
                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                    <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                    <div id="clear">
                        X
                    </div>
                </div>
            </div>
            <input type="hidden" name="passport_id" />
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category">Remark</label>
                <textarea class="form-control form-control" name="remark" rows="4" type="text" placeholder="Remark (optional)"  ></textarea>
            </div>
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category">Reason</label>
                <select class="form-control" name="reason">
                    <option value="1">Reason 1</option>
                    <option value="2">Reason 2</option>
                    <option value="3">Reason 3</option>
                    <option value="4">Reason 4</option>
                </select>
            </div>
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category">Request From</label>
                <select class="form-control" name="request_from">
                    <option value="1">Rider</option>
                    <option value="2">User</option>
                </select>
            </div>
            <div id="submitDate" class="col-md-4 form-group mb-3">
                <label for="repair_category">returning Date</label>
                <input id="return_date" class="form-control form-control" name="return_date" type="date" placeholder="Submiting Date"  required/>
            </div>
            <div id="" class="col-md-4 form-group mb-3 mt-4">
                <input class="" type="checkbox" id="no_return">
                <label class="p-1" for="repair_category">No Return</label>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </div>
    </form>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('js/custom_js/passport_request.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

<script>
    $('#no_return').on('change', function() {

        var el = $('#submitDate');
        if ($('#no_return').is(":checked")) {
            el.find('input').prop({
                required: false
            });
            $( "#return_date" ).prop( "disabled", true );
        }
        else{
            el.find('input').prop({
                required: true
            });
            $( "#return_date" ).prop( "disabled", false );
        }

    })
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