@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />


    {{--    passport slider nation--}}
    <style>

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
            height: 55%;
            padding: 1em;
            box-sizing: border-box;
            border: 1px solid #ffc107;
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
            width: 12px;
            height: 40px;
            /* fill: #bbb; */
            background: white;
            border: none;
        }
        .pn-ProductNav_Link + .pn-ProductNav_Link {
            margin-left: 11px;
            padding-left: 11px;
            border-left: 1px solid #eee;
        }


        .ul-widget-app__browser-list-1 {
            display: flex;
            align-items: center;
            justify-content: left;
            white-space: nowrap;
            /* font-size: 24px; */
        }
        /*dashboard css*/
        .passport-card {
            width: 200px;
            height: 120px;
        }

        /*.codd-card {*/
        /*    width: 330px;*/
        /*    height: 120px;*/
        /*}*/
        .card-bike {
            height: 83px;
        }

        /*agreement-css*/
        .card-agreement {
            background: #4d4cac;
            color: #ffffff;
            border-radius: 14px;
            width: 253px;
        }
        i.i-Newspaper.text-32.mr-3 {
            background: #9e9de8;
            border-radius: 30px;
            padding: 13px;
        }
        h4.span-agreement {
            color: #fff;
            font-weight: 700;
        }
        .card-agreement {
            color: #ffffff;
            border-radius: 14px;
            margin-left: 20px;
            max-width: 350px;
            height: 100px;
        }
        .not-employee {
            background: #9698d6;
        }
        i.i-Engineering.text-32.mr-3 {
            background: #4d4cac;
            border-radius: 30px;
            padding: 13px;
        }
        .card-full {
            background: #d24a55;
        }
        i.i-Conference.text-32.mr-3 {
            background: #ffcdd1;
            border-radius: 30px;
            padding: 13px;
        }
        i.i-Boy.text-32.mr-3 {
            background: #d24a55;
            border-radius: 30px;
            padding: 13px;
        }
        .cart-part-time {
            background: #f39199;
        }
        .total-emp {
            background: green;
        }

        /*tickets css*/

        i.i-Movie-Ticket.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #4d4cac;
        }


        i.i-Ticket {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #9698d6;
        }

        i.i-Loading.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #d24a55;
        }


        i.i-Close-Window.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #f39199;
        }


        i.i-Receipt-3.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #008000;
        }


        .btn.btn-tick-total {
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            background: #8b0000;
            color: #fff;
            padding: 3px;
        }


        .btn.btn-tick-pending {
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            background: #9698d6;
            color: #fff;
            padding: 3px;
        }

        .btn.btn-tick-process {
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            background: #d24a55;
            color: #fff;
            padding: 3px;
        }
        .btn.btn-tick-close {
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            background: #f3919c;
            color: #fff;
            padding: 3px;
        }
        .btn.btn-tick-rejectd {
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            background: #008000;
            color: #fff;
            padding: 3px;
        }
        .mrl {
            margin-left: -10px;
        }
        .m-1 {
            font-weight: bold;
        }
        tr.ticket-table-row {
            background: rebeccapurple;
            color: #fff;
            /* height: 1px; */
        }

        /*registration fail*/
        i.i-Arrow-Forward.register-fail-icon {
            font-size: 45px;
            border: 1px solid;
            border-radius: 25px;
            padding: 3px;
            color:  #ffc107;
        }
        /*.regis-fail {*/
        /*    width: 730px;*/
        /*    position: relative;*/
        /*    !*left: 15%;*!*/
        /*}*/
        /*linces css*/

        .card.mb-4.linces.o-hidden {
            background: #e25a4e;
            color: #fff;
        }
        .license_title {
            background: #595061;
            /*width: 210px;*/
            padding: 10px;
            border-bottom-left-radius: 50px 20px;
            border-bottom-right-radius: 50px 20px;

        }
        .onboard-tr {
            background: #e25a4e;
            color: #ffffff;
        }

        /*cod css*/
        .cod-text {
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }
        .interview-text {
            font-size: 15px;
            font-weight: bold;
            white-space: nowrap;
        }
        .interview-nbr {
            font-size: 14px;
            font-weight: 800;
        }
        table#sales_table {
            font-size: 14px;
            line-height: 4px;
            /* margin-bottom: -12px; */
            padding: -2px;
        }
        table#ticket-table-dep {
            line-height: 25px;
            font-size: 18px;
        }
        .onboard-card {
            height: 365px;
            overflow: scroll;
            overflow-x: hidden;
        }

        /*-----------responsive css------------------------*/


        /*@media screen and (max-width: 1713px) {*/
        /*    .card-agreement {*/
        /*        color: #ffffff;*/
        /*        border-radius: 14px;*/
        /*        margin-left: 3px;*/
        /*        max-width: 332px;*/
        /*        height: 100px;*/
        /*    }*/
        /*}*/

        /*@media screen and (max-width: 1573px) {*/
        /*    .card-agreement {*/
        /*        color: #ffffff;*/
        /*        border-radius: 14px;*/
        /*        margin-left: 1px;*/
        /*        max-width: 300px;*/
        /*        height: 100px;*/

        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1437px) {*/
        /*    .card-agreement {*/
        /*        color: #ffffff;*/
        /*        border-radius: 14px;*/
        /*        margin-left: 1px;*/
        /*        max-width: 275px;*/
        /*        height: 100px;*/

        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1201px) {*/
        /*    .card-agreement {*/
        /*        color: #ffffff;*/
        /*        border-radius: 14px;*/
        /*        margin-left: 5px;*/
        /*        max-width: 232px;*/
        /*        height: 100px;*/

        /*    }*/
        /*}*/
        /*@media screen and (max-width: 480px) {*/
        /*    .username:before {*/
        /*        content:"";*/
        /*    }*/
        /*}*/

        /*all devices*/

        /* Smartphones (portrait and landscape) ----------- */
        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
            /* Styles */
            table#sales_table {
                font-size: 10px;
                line-height: 4px;
                /* margin-bottom: -12px; */
                padding: -2px;
            }
            .text-15 {
                font-size: 12px;
            }
            .cod-text {
                font-size: 13px;
                font-weight: bold;
                color: #000;
            }
            .menu-wrapper {
                position: relative;
                /* max-width: 500px; */
                height: 100px;
                margin: 1em auto;
                /* border: 1px solid black; */
                overflow-x: hidden;
                overflow-y: hidden;
                display: none;
            }
            .passport-card {
                width: 284px;
                height: 120px;
            }
        }

        /* Smartphones (landscape) ----------- */
        @media only screen and (min-width : 321px) {
            /* Styles */
        }

        /* Smartphones (portrait) ----------- */
        @media only screen and (max-width : 320px) {
            /* Styles */
        }

        /* iPads (portrait and landscape) ----------- */
        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
            /* Styles */
            .card-icon-bg {
                position: relative;
                z-index: 1;
                width: 630px;
                margin-left: 71px;
            }
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 57px;
                max-width: 460px;
                height: 100px;
            }
            .menu-wrapper {
                position: relative;
                /* max-width: 500px; */
                height: 100px;
                margin: 1em auto;
                /* border: 1px solid black; */
                overflow-x: hidden;
                overflow-y: hidden;
                display: none;
            }
        }

        /* iPads (landscape) ----------- */
        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
            /* Styles */
            .card-icon-bg {
                position: relative;
                z-index: 1;
                width: 630px;
                margin-left: 71px;
            }
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 57px;
                max-width: 460px;
                height: 100px;
            }
        }

        /* iPads (portrait) ----------- */
        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) {
            /* Styles */
        }
        /**********
        iPad 3
        **********/
        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) and (-webkit-min-device-pixel-ratio : 2) {
            /* Styles */
        }

        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) and (-webkit-min-device-pixel-ratio : 2) {
            /* Styles */
        }
        /* Desktops and laptops ----------- */
        @media only screen  and (min-width : 1100px) {
            /* Styles */
            .menu-wrapper {
                position: relative;
                height: 100px;
                margin: 1em auto;
                overflow-x: hidden;
                overflow-y: hidden;
                left: 4%;
            }
            .text-18 {
                font-size: 12px;
            }
            .interview-text {
                font-size: 9px;
                font-weight: bold;
                white-space: none;
            }

        }
        @media only screen  and (min-width : 1224px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 240px;
                height: 100px;
            }
            .menu-wrapper {
                position: relative;
                height: 100px;
                margin: 1em auto;
                overflow-x: hidden;
                overflow-y: hidden;
                left: 0%;
            }
        }

        @media only screen  and (min-width : 1670px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 350px;
                height: 100px;
            }
        }
        @media only screen  and (min-width : 1670px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 350px;
                height: 100px;
            }
        }
        @media only screen  and (min-width : 1725px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 370px;
                height: 100px;
            }
        }
        @media only screen  and (min-width : 1725px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 370px;
                height: 100px;
            }
        }

        /* Large screens ----------- */
        @media only screen  and (min-width : 1824px) {
            /* Styles */
            .card-agreement {
                color: #ffffff;
                border-radius: 14px;
                margin-left: 2px;
                max-width: 390px;
                height: 100px;
            }
        }

        /* iPhone 4 ----------- */
        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) and (orientation : landscape) and (-webkit-min-device-pixel-ratio : 2) {
            /* Styles */

        } @media only screen and (min-device-width : 320px) and (max-device-width : 480px) and (orientation : landscape) and (-webkit-min-device-pixel-ratio : 2) {
            /* Styles */

        }

        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) and (orientation : portrait) and (-webkit-min-device-pixel-ratio : 2) {
            /* Styles */
        }

        /* iPhone 5 ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 568px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        @media only screen and (min-device-width: 320px) and (max-device-height: 568px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        /* iPhone 6, 7, 8 ----------- */
        @media only screen and (min-device-width: 375px) and (max-device-height: 667px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        @media only screen and (min-device-width: 375px) and (max-device-height: 667px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        /* iPhone 6+, 7+, 8+ ----------- */
        @media only screen and (min-device-width: 414px) and (max-device-height: 736px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        @media only screen and (min-device-width: 414px) and (max-device-height: 736px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        /* iPhone X ----------- */
        @media only screen and (min-device-width: 375px) and (max-device-height: 812px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        @media only screen and (min-device-width: 375px) and (max-device-height: 812px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        /* iPhone XS Max, XR ----------- */
        @media only screen and (min-device-width: 414px) and (max-device-height: 896px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        @media only screen and (min-device-width: 414px) and (max-device-height: 896px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        /* Samsung Galaxy S3 ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 2){
            /* Styles */
        }

        /* Samsung Galaxy S4 ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        /* Samsung Galaxy S5 ----------- */
        @media only screen and (min-device-width: 360px) and (max-device-height: 640px) and (orientation : landscape) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }

        @media only screen and (min-device-width: 360px) and (max-device-height: 640px) and (orientation : portrait) and (-webkit-device-pixel-ratio: 3){
            /* Styles */
        }
        .card > hr {
            margin-right: 150px;
            margin-left: 150px;
        }
        .platforms-div {
            height: 312px;
            overflow: scroll;
            overflow-x: hidden;
        }
        .table-responsive.table-emp {
            height: 310px;
        }
        .table-responsive.ar_platform {
            overflow: scroll;
            height: 443px;
            overflow-x: none;
        }
        i.i-Wallet.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #4d4cac;
        }

        i.i-Dollar-Sign.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #9698d6
        }

        i.i-Money.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #d24a55
        }

        i.i-Money-2.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #f3919c;
        }
        i.i-Wallet.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #4d4cac;
        }

        i.i-Dollar-Sign.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #9698d6
        }

        i.i-Money.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #d24a55
        }

        i.i-Money-2.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #f3919c;
        }

        i.i-Add-File.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #663399;
        }
        button.btn.btn-tick-total_agreed {
            background: rebeccapurple;
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            padding: 3px;

        }
        i.i-Money-Bag.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #f62d51;
        }
        button.btn.btn-tick-total_rec {
            background: #f62d51;
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            padding: 3px;

        }
        i.i-Pound.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #4caf50;
        }
        button.btn.btn-tick-total_dis {
            background: #4caf50;
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            padding: 3px;

        }
        i.i-Euro.ticket-icon {
            font-size: 45px;
            position: relative;
            top: 20%;
            color: #8b0000;
        }
        button.btn.btn-tick-pending_pound {
            background: #9698d7;
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            padding: 3px;
        }
        button.btn.btn-tick-process_add {
            background: #d24a55;
            width: 118px;
            height: 34px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            padding: 3px;
        }

    </style>

    {{--    passport slider nation ends--}}
@endsection

@section('content')

        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Numbers</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Graphs</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">




        <div class="row">
            <!-- ICON BG-->
{{--            <div class="col-lg-12 col-md-6 col-sm-6">--}}
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body  card-pass text-center">

                        <div class="col-sm-2">
                            <div class="card passport-card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Book nc-globe text-warning"></i>
                                    <div class="numbers">
                                        <p class="card-category">Total Passports</p>
                                        <p class="card-title text-warning"><b>{{count($passport)}}</b></p>
                                        <p>
                                        </p>
                                    </div>


                                </div>
                            </div>
                        </div>


                        {{--                        total passport div ends--}}
                        <div class="col-sm-10 mt-3">
{{--                        <marquee>--}}



                            <div class="menu-wrapper">
                                <ul class="menu">
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Pakistan</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','1'))}}</h5>
                                        </div>
                                    </li>
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">India</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','2'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Bangladesh</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','3'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Afganistan</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','4'))}}</h5>
                                        </div>
                                    </li>
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Cameroon</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','5'))}}</h5>
                                        </div>
                                    </li>
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Philippines</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','6'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Oganda</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','7'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Athuobya</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','8'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Emirates</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','9'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Gambya</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','10'))}}</h5>
                                        </div>
                                    </li>


                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Ghana</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','11'))}}</h5>
                                        </div>
                                    </li>
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Jordan</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','12'))}}</h5>
                                        </div>
                                    </li>
                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Nigerya</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','13'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Nipal</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','14'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Rowanda</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','14'))}}</h5>
                                        </div>
                                    </li>


                                    <li class="item">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Sirelanka</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','16'))}}</h5>
                                        </div>
                                    </li>

                                    <li class="item"  style="visibility: hidden">
                                        <div class="flex-grow-1">
                                            <span class="text-small text-muted">Sirelanka</span>
                                            <h5 class="m-0 font-weight-bold">{{count($passport->where('nation_id','16'))}}</h5>
                                        </div>
                                    </li>



                                </ul>


                                <div class="paddles">
                                    <button class="left-paddle paddle hidden">
                                        <svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M445.44 38.183L-2.53 512l447.97 473.817 85.857-81.173-409.6-433.23v81.172l409.6-433.23L445.44 38.18z"/></svg>
                                    </button>
                                    <button class="right-paddle paddle">
                                        <svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M105.56 985.817L553.53 512 105.56 38.183l-85.857 81.173 409.6 433.23v-81.172l-409.6 433.23 85.856 81.174z"/></svg>
                                    </button>
                                </div>


                            </div>
{{--                        </marquee>--}}


                        </div>
                    </div>
{{--                </div>--}}
            </div>



            {{-------------------row1 ends-------------------------}}
        </div>

        {{-------------------------------row 2 starts------------------------}}

        <div class="row">

            <div class="col-lg-6 col-md-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="card-title">SIMs</div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mb-4 sim-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">

                                            <div class="ul-widget__content-v2">
                                                <i class="i-Memory-Card text-white bg-success rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{count($sims)}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Total SIMs</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>




                                <div class="card mb-4 sim-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">
                                            <div class="ul-widget__content-v2">
                                                <i class="i-Memory-Card text-white bg-info rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{count($assigned_sims->where('status','1')->where('assigned_to','1'))}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Rider SIMs</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4 sim-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">
                                            <div class="ul-widget__content-v2">
                                                <i class="i-Memory-Card text-white bg-primary rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{count($company_assign)}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Company SIMs</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6 mt-5">


                                <div class="card mb-4 mt-2 sim-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">
                                            <div class="ul-widget__content-v2">
                                                <i class="i-Memory-Card text-white bg-danger rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{count($sims->where('status','0'))}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Free SIMs</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="card mb-4 mt-2  sim-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">
                                            <div class="ul-widget__content-v2">
                                                <i class="i-Memory-Card text-white bg-dark rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{count($sims->where('reserve_status','1'))}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Reserve SIMs</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="card-title">Bikes</div>


                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                    <i class="i-Motorcycle text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">Total Vehicle</h4><span>{{count($bikes)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 border border-light bg-primary text-white rounded d-flex align-items-center">
                                    <i class="i-University1 text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">Company Vehicle</h4><span>{{count($bikes->where('category_type','0'))}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 border border-light rounded d-flex align-items-center">
                                    <i class="i-Money-2 text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1">Lease Vehicle</h4><span>{{count($bikes->where('category_type','1'))}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 border border-light rounded d-flex align-items-center">
                                    <i class="i-Magnifi-Glass1 text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1">Tracking Bikes</h4><span>{{count($tracking_bikes)}}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                    <i class="i-Bicycle text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">Currently Company Used Bike</h4><span>{{count($bikes->where('status','1')->where('category_type','0'))}}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                    <i class="i-Motorcycle text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">Currently Company Free Bike</h4><span>{{count($bikes->where('status','0')->where('category_type','0'))}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 border border-light rounded d-flex align-items-center">
                                    <i class="i-Gears text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1">Currently Lease used Bike</h4><span>{{count($bikes->where('status','1')->where('category_type','1'))}}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 border border-light rounded d-flex align-items-center">
                                    <i class="i-Gear text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1">Currently Lease free Bike</h4><span>{{count($bikes->where('status','0')->where('category_type','1'))}}</span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6 col-md-12 mb-4 card-bike">
                                <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                    <i class="i-Car-2 text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">Total Limo Cars</h4><span>{{count($bikes->where('traffic_file','50102369'))}}</span>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                </div>
            </div>
        </div>



    {{--        ------------------row2 ends----------------}}
    {{--        ------------------row3 starts----------------}}
    <br>
    <div class="row">

        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Agreement</div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-4 card-agreement total-agreement">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Newspaper text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white">Total Agreement</h4><span><h4  class="span-agreement">{{count($agreement) }}</h4></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-4 card-agreement not-employee">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Engineering text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white"> Not  Employees</h4><span><h4  class="span-agreement">{{count($agreement->where('employee_type_id','0')) }}</h4></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-4 card-agreement card-full">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Conference text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white"> Full Time Employees</h4><span><h4  class="span-agreement">{{count($agreement->where('employee_type_id','2')) }}</h4></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 mb-4 card-agreement cart-part-time">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Boy text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white"> Part Time Employees</h4><span><h4  class="span-agreement">{{count($agreement->where('employee_type_id','1')) }}</h4></span>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-12 mb-4 card-agreement total-emp">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Business-Mens text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white"> Total Employees</h4><span><h4  class="span-agreement"> {{count($elec_pre_app) }}</h4></span>
                                </div>
                            </div>
                        </div>

                    </div>





                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-12">


            <div class="card mb-6">
                    <div class="col-md-12 text-center mt-2">
                        <div class="card mb-4 regis-fail">
                            <div class="card-body mt-3 mb-3">
                                <p class="mb-1 text-22 font-weight-bold">{{count($reg_fail)}}</p>
                                <h6 class="mb-2 text-muted text-18 font-weight-bold">Total Pending Registration Failure</h6>
                                <div class="progress mb-2" style="height: 4px">
                                    <div class="progress-bar bg-warning" style="width: 100%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <i class="i-Arrow-Forward register-fail-icon"></i>
                            </div>
                            <hr>
                        </div>
                        <div class="platforms-div mb-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped  table-dark text-15  text-center dataTable no-footer" role="grid" aria-describedby="sales_table_info">
                                    <tr style="background: #8b0000">
                                        <th>Platform</th>
                                        <th>#</th>
                                    </tr>
                                    @foreach($platforms as $plat)
                                        <tr>
                                            <td>{{$plat->name}}</td>
                                            <th class="platform-data">{{count($assign_platform->where("plateform", $plat->id))}}</th>
                                        </tr>
                                    @endforeach
                                </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>

        </div>

    {{--        ------------------row3 ends----------------}}

    {{--        ------------------------------row4 stars--}}
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Tickets</div>
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <!-- ICON BG-->

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-profile-1 mb-4">
                                    <div class="card-body text-center">
                                        <div class="avatar box-shadow-2 mb-3">
                                            <i class="i-Movie-Ticket ticket-icon"></i>
                                        </div>
                                        <h5 class="m-1">Total Tickets</h5>
                                        <button class="btn btn-tick-total">{{count($tickets) }}</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="card card-profile-1 mb-4">
                                    <div class="card-body text-center">
                                        <div class="avatar box-shadow-2 mb-3">
                                            <i class="i-Ticket ticket-icon"></i>
                                        </div>
                                        <h5 class="m-1">Pending Tickets</h5>
                                        <button class="btn  btn-tick-pending ">{{count($tickets->where("is_checked", '0')) }}</button>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">


                                <div class="card card-profile-1 mb-4">
                                    <div class="card-body text-center">
                                        <div class="avatar box-shadow-2 mb-3">
                                            <i class="i-Loading ticket-icon"></i>
                                        </div>
                                        <h5 class="m-1">In-Process Tickets</h5>
                                        <button class="btn  btn-tick-process">{{count($tickets->where("is_checked", '2')) }}</button>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="card card-profile-1 mb-4">
                                    <div class="card-body text-center">
                                        <div class="avatar box-shadow-2 mb-3">
                                            <i class="i-Close-Window ticket-icon"></i>
                                        </div>
                                        <h5 class="m-1">Closed Tickets</h5>
                                        <button class="btn btn-tick-close">{{count($tickets->where("is_checked", '1'))}}</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">

                            <div class="card card-profile-1 mb-4 mrl">
                                <div class="card-body text-center">
                                    <div class="avatar box-shadow-2 mb-3">
                                        <i class="i-Receipt-3 ticket-icon"></i>
                                    </div>
                                    <h5 class="m-1">Rejected Tickets</h5>
                                    <button class="btn btn-tick-rejectd ">{{count($tickets->where("is_checked", '3')) }}</button>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{--                <div class="card mb-6">--}}
            {{--                    <div class="card-body">--}}
            {{--                        <div class="card-title">Tickets</div>--}}
            {{--                        <p> Total Tickets: {{count($tickets) }}</p>--}}
            {{--                        <p> Pending Tickets: {{count($tickets->where("is_checked", '0')) }}</p>--}}
            {{--                        <p> In-Process Tickets: {{count($tickets->where("is_checked", '2')) }}</p>--}}
            {{--                        <p> Closed Tickets: {{count($tickets->where("is_checked", '1'))}}</p>--}}
            {{--                        <p> Rejected Tickets: {{count($tickets->where("is_checked", '3')) }}</p>--}}

            {{--                    </div>--}}
            {{--                </div>--}}

        </div>

        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Department Tickets</div>
                    <div class="table-responsive">
                        <table class="table ticket-table text-15  text-center dataTable no-footer" id="ticket-table-dep" role="grid" aria-describedby="sales_table_info">
                            <tr class="ticket-table-row">
                                <th>Department</th>
                                <th>Pending</th>
                                <th>In-Process</th>
                                <th>Closed</th>
                                <th>Rejectd</th>
                            </tr>
                            @foreach($maj_dep as $maj)
                                <tr>
                                    <td>{{$maj->major_department}}</td>
                                    @php
                                        $array_issue=array();
                                    @endphp
                                    @foreach($maj->issue_dep as $dep_issues)
                                        @php
                                            $array_issue[]=$dep_issues->id;
                                        @endphp
                                    @endforeach
                                    <td>{{count($tickets->where("is_checked", '0')->whereIn('department_id',$array_issue))}}</td>
                                    <td>{{count($tickets->where("is_checked", '2')->whereIn('department_id',$array_issue))}}</td>
                                    <td>{{count($tickets->where("is_checked", '1')->whereIn('department_id',$array_issue))}}</td>
                                    <td>{{count($tickets->where("is_checked", '3')->whereIn('department_id',$array_issue))}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!----------------------row4 ends------------------------>
    <!----------------------row5 starts---------------------->
    <br>
    {{--        <div class="row">--}}
    {{--            <div class="col-lg-6 col-md-12">--}}




    {{--                <div class="card mb-6">--}}
    {{--                    <div class="card-body">--}}
    {{--                        <div class="col-md-12 text-center">--}}
    {{--                            <div class="card mb-4 regis-fail">--}}
    {{--                                <div class="card-body">--}}
    {{--                                    <p class="mb-1 text-22 font-weight-bold">{{count($reg_fail)}}</p>--}}
    {{--                                    <h6 class="mb-2 text-muted text-18 font-weight-bold">Total Pending Registration Failure</h6>--}}
    {{--                                    <div class="progress mb-2" style="height: 4px">--}}
    {{--                                        <div class="progress-bar bg-primary" style="width: 100%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
    {{--                                    </div>--}}
    {{--                                    <i class="i-Arrow-Forward register-fail-icon"></i>--}}


    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="card-title">Pending Registration Failure</div>--}}
    {{--                        <p>Total Pending Registration Failure:{{count($reg_fail)}}</p>--}}

    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--            <div class="col-lg-6 col-md-12">--}}

    {{--                <div class="card mb-6">--}}
    {{--                    <div class="card-body">--}}

    {{--                        <div class="card-title">User Codes</div>--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-sm-6">--}}
    {{--                                <div class="card mb-4 sim-card o-hidden">--}}
    {{--                                    <div class="card-body">--}}
    {{--                                        <div class="ul-widget__row-v2" style="position: relative;">--}}

    {{--                                            <div class="ul-widget__content-v2">--}}
    {{--                                                <i class="i-Record-2 text-white bg-dark rounded-circle p-2 mr-0"></i>--}}
    {{--                                                <h4 class="heading mt-3 ml-0">{{count($passport)}}</h4>--}}
    {{--                                                <p class="text-muted m-0 font-weight-bold">PPUID</p>--}}
    {{--                                            </div>--}}

    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-sm-6">--}}
    {{--                                <div class="card mb-4 sim-card o-hidden">--}}
    {{--                                    <div class="card-body">--}}
    {{--                                        <div class="ul-widget__row-v2" style="position: relative;">--}}

    {{--                                            <div class="ul-widget__content-v2">--}}
    {{--                                                <i class="i-Align-Justify-Center text-white bg-warning rounded-circle p-2 mr-0"></i>--}}
    {{--                                                <h4 class="heading mt-3 ml-0">{{count($zds_code)}}</h4>--}}
    {{--                                                <p class="text-muted m-0 font-weight-bold">ZDS code</p>--}}
    {{--                                            </div>--}}

    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}



    {{--                        </div>--}}



    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    <br>
    <!----------------------row5 ends------------------------>
    <!----------------------row6 Driving Linces------------------------>

    <div class="row">
        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Driving License</div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card mb-4 linces o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2 text-white">
                                            <div class="license_title text-white">
                                                <p class="m-0 font-weight-bold text-white">Total Driving License (Bikes)</p>
                                            </div>

                                            {{--                                            <i class="i-Align-Justify-Center text-white bg-warning rounded-circle p-2 mr-0"></i>--}}
                                            <h4 class="heading mt-3 ml-0 text-white">{{count($driving_license->where("license_type",'1'))}}</h4>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card mb-4 linces o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <div class="license_title">
                                                <p class="m-0 font-weight-bold text-white">Total Driving License (Cars)</p>
                                            </div>
                                            {{--                                            <i class="i-Align-Justify-Center text-white bg-warning rounded-circle p-2 mr-0"></i>--}}

                                            <h4 class="heading mt-3 ml-0 text-white">{{count($driving_license->where("license_type",'2'))}}</h4>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                        <p>Total Driving License (Bikes):{{count($driving_license->where("license_type",'1'))}}</p>--}}
                    {{--                        <p>Total Driving License (Cars):{{count($driving_license->where("license_type",'2'))}}</p>--}}

                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">

                    <div class="card mb-6">
                        <div class="card-body">

                            <div class="card-title">User Codes</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card mb-4 sim-card o-hidden">
                                        <div class="card-body">
                                            <div class="ul-widget__row-v2" style="position: relative;">

                                                <div class="ul-widget__content-v2">
                                                    <i class="i-Record-2 text-white bg-dark rounded-circle p-2 mr-0"></i>
                                                    <h4 class="heading mt-3 ml-0">{{count($passport)}}</h4>
                                                    <p class="text-muted m-0 font-weight-bold">PPUID</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="card mb-4 sim-card o-hidden">
                                        <div class="card-body">
                                            <div class="ul-widget__row-v2" style="position: relative;">

                                                <div class="ul-widget__content-v2">
                                                    <i class="i-Align-Justify-Center text-white bg-warning rounded-circle p-2 mr-0"></i>
                                                    <h4 class="heading mt-3 ml-0">{{count($zds_code)}}</h4>
                                                    <p class="text-muted m-0 font-weight-bold">ZDS code</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>



                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div><br>


    <!----------------------row6 ends------------------------>
    <!----------------------row7------------------------>
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Hiring Pool</div>
                    <div class="row mt-5">
{{--                        <div class="col-lg-6 col-md-12 mb-4 card-agreement total-agreement">--}}
{{--                            <div class="p-4  rounded d-flex align-items-center">--}}
{{--                                <i class="i-Newspaper text-32 mr-3"></i>--}}
{{--                                <div>--}}
{{--                                    @php--}}
{{--                                      $hire_total= count($hiring_pool->where("applicant_status","0"))+count($hiring_pool->where("applicant_status","1"))+count($hiring_pool->where("applicant_status","2"))--}}
{{--                                    @endphp--}}

{{--                                    <h4 class="text-18 mb-1  text-white">Total Hiring Pool</h4><span><h4  class="span-agreement">{{$hire_total}}</h4></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-lg-6 col-md-12 mb-4 card-agreement not-employee">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Engineering text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white"> Document Pending</h4><span><h4  class="span-agreement">{{count($short_list)}}</h4></span>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-12 mb-4 card-agreement cart-part-time">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Boy text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white">Pending</h4><span><h4  class="span-agreement">{{$total_hiring_pending}}</h4></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 mb-4 card-agreement total-emp">
                            <div class="p-4  rounded d-flex align-items-center">
                                <i class="i-Business-Mens text-32 mr-3"></i>
                                <div>
                                    <h4 class="text-18 mb-1  text-white">Rejected</h4><span><h4  class="span-agreement">{{count($hiring_pool->where("applicant_status",'1'))}}</h4></span>
                                </div>
                            </div>
                        </div>

                    </div>



                    {{--                        <p>Total Hiring Pool:{{count($hiring_pool)}}</p>--}}
                    {{--                        <p>Pending:{{count($hiring_pool->where("applicant_status",'0'))}}</p>--}}
                    {{--                        <p>Document Process:{{count($hiring_pool->where("applicant_status",'2'))}}</p>--}}
                    {{--                        <p>Rejected:{{count($hiring_pool->where("applicant_status",'1'))}}</p>--}}

                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body onboard-card">
                    <div class="card-title">Hiring Pool (Platform)</div>

                    @php
                        $array_platform=array();
                    @endphp
                    <div class="table-responsive">
                    <table class="table on-boarding-table text-15  text-center dataTable no-footer" id="sales_table" role="grid" aria-describedby="sales_table_info">

                        <tr class="onboard-tr">
                            <th>PlatForm</th>
                            <th>Pending</th>
                            <th>Document</th>
                            <th>Rejected</th>
                        </tr>

                        @foreach($platforms as $platform)
                            @php
                                $array_platform[]=$platform->id;
                            @endphp
                            <tr>
                                <td>{{$platform->name}}</td>
                                <td>{{count($hiring_pool->where("applicant_status",'0')->whereIn('platform_id',$platform->id))}}</td>
                                <td>{{count($hiring_pool->where("applicant_status",'2')->whereIn('platform_id',$platform->id))}}</td>
                                <td>{{count($hiring_pool->where("applicant_status",'1')->whereIn('platform_id',$platform->id))}}</td>
                            </tr>
                        @endforeach
                    </table>
                    </div>

                    {{--                            <p>Pending:{{count($hiring_pool->where("applicant_status",'0')->whereIn('platform_id',$platform->id))}}</p>--}}
                    {{--                            <p>Document Process:{{count($hiring_pool->where("applicant_status",'2')->whereIn('platform_id',$platform->id))}}</p>--}}
                    {{--                            <p>Rejected:{{count($hiring_pool->where("applicant_status",'1')->whereIn('platform_id',$platform->id))}}</p>--}}






                </div>
            </div>

        </div>
    </div>
    <!----------------------row7 end------------------------>
    <!----------------------row8------------------------>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">COD</div>


{{--                    <div class="col-sm-12 col-md-6 mb-4">--}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mb-4 codd-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">

                                            <div class="ul-widget__content-v2">
                                                <i class="i-Financial text-white bg-success rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{$cod_uploads->sum('amount')}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Total COD Generated</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mb-4  codd-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">

                                            <div class="ul-widget__content-v2">
                                                <i class="i-Euro text-white bg-warning rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{$cod->sum('amount')}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Total COD Received</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mb-4  codd-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">

                                            <div class="ul-widget__content-v2">
                                                <i class="i-Money1 text-white bg-dark rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{$cod->where('type','0')->sum('amount')}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Receive By Cash</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mb-4  codd-card o-hidden">
                                    <div class="card-body">
                                        <div class="ul-widget__row-v2" style="position: relative;">

                                            <div class="ul-widget__content-v2">
                                                <i class="i-Dollar text-white bg-primary rounded-circle p-2 mr-0"></i>
                                                <h4 class="heading mt-3 ml-0">{{$cod->where('type','1')->sum('amount')}}</h4>
                                                <p class="text-muted m-0 font-weight-bold">Receive By Bank</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                        <div class="card">
                            <div class="card-body">
                                <div class="ul-widget__head">
                                    <div class="ul-widget__head-label">
                                        <h3 class="ul-widget__head-title">COD</h3>
                                    </div>
                                    <div class="ul-widget__head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget-s6-tab1-content" role="tab" aria-selected="true">Adjustment</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget-s6-tab2-content" role="tab" aria-selected="false">Bank Issues</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget-s6-tab3-content" role="tab" aria-selected="false">Cash</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ul-widget__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="__g-widget-s6-tab1-content">

                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Total Adjustment </span><span class="cod-text">{{$adj->sum('amount')}} </span></div>

                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Line-Chart-2 text-white bg-danger rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Adjustment Pending</span><span class="cod-text">{{$adj->where('status','1')->sum('amount')}} </span></div>
                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Money-2 text-white green-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Adjustment Approve</span><span class="cod-text">{{$adj->where('status','2')->sum('amount')}}</span></div>
                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Dollar-Sign-2 text-white blue-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Adjustment Rejected</span><span class="cod-text">{{$adj->where('status','3')->sum('amount')}}</span></div>
                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Euro text-white yellow-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Total Bank Issues</span><span class="cod-text">{{$cod->where('type','3')->sum('amount')}}</span></div>

                                        </div>
                                        <div class="tab-pane" id="__g-widget-s6-tab2-content">

                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Total Bank Issues</span><span class="cod-text">{{$cod->where('type','3')->sum('amount')}}</span></div>


                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Line-Chart-2 text-white red-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Bank Issues Pending</span><span class="cod-text">{{$cod->where('type','3')->where('status','0')->sum('amount')}}</span></div>



                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Money-2 text-white green-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Bank Issues Approve</span><span class="cod-text">{{$cod->where('type','3')->where('status','1')->sum('amount')}}</span></div>



                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Euro text-white red-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Bank Issues Rejected</span><span class="cod-text">{{$cod->where('type','3')->where('status','2')->sum('amount')}}
                                                        </span>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="__g-widget-s6-tab3-content">
                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Internet text-white green-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Total Paid By Cash</span><span class="cod-text">{{ $cod->where('type','0')->sum('amount') }}</span></div>


                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Financial text-white yellow-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Paid By Cash Pending</span><span class="cod-text">{{ $cod->where('type','0')->where('status','0')->sum('amount') }}</span></div>



                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Money-2 text-white green-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Paid By Cash Approve </span><span class="cod-text">{{ $cod->where('type','0')->where('status','1')->sum('amount') }}</span></div>


                                            <div class="ul-widget-app__browser-list-1 mb-4"><i class="i-Dollar-Sign-2 text-white red-500 rounded-circle p-2 mr-3"></i>
                                                <span class="text-15">Paid By Cash Rejected</span><span class="cod-text">{{  $cod->where('type','0')->where('status','2')->sum('amount') }}</span></div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


{{--                    </div>--}}
                </div>

            </div>
        </div>

        <div class="col-lg-6 col-md-12">

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Interview</div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-success btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Interview Batch</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{ count($interview_batches)}}</span>
                            </button>
                        </div>

                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-primary btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Sent Invitation</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{ count($create_interview)}}</span>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-info btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Acknowlegment</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{count($create_interview->where('acknowledge_status','1')->where('interview_status')) }}</span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">


                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-danger btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Not Accepted</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{ count($create_interview->where('acknowledge_status','1')->where('interview_status','1'))}}</span>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-success btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Pass</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{count($create_interview->where('acknowledge_status','2')->where('interview_status','0'))}}</span>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-danger btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Fail</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">{{count($create_interview->where('acknowledge_status','1')->where('interview_status','2'))}}</span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">


                        <div class="col-sm-4">
                            <button _ngcontent-wse-c14="" class="btn btn-warning btn-block mat-raised-button" mat-raised-button="">
                                <span class="mat-button-wrapper interview-text">Total Pending</span>
                                <br>
                                <span class="mat-button-wrapper interview-nbr">
                                                {{ count($create_interview->where('acknowledge_status','0')->where('interview_status','0'))}}
                                            </span>
                            </button>
                        </div>
                    </div>

                </div>





                <br>
                <hr>

                <table class="display table">
                    <thead style="background: #0a6aa1;color: #ffffff">
                    <tr>
                        <th scope="col" style="width: 100px">Platform</th>
                        <th scope="col" style="width: 100px">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($last_five_batches as $baches)
                        <tr>
                            <td> {{$baches->platform->name}}</td>
                            <td>
                                @if($baches->is_complete==0)
                                    Not Complete
                                @else
                                    Complete
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <br>





    <!----------------------row8 end------------------------>
    <!----------------------row9------------------------>

    <div class="row">
        <div class="col-lg-6 col-md-12">
{{--            <div class="col-lg-12 col-md-4 mb-4">--}}
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Performance</div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$counter_good}}</h3>
                            <div class="d-flex"><span class="text-muted text-15 font-weight-bold">Good</span>


                                <span class="t-font-boldest ml-auto">{{number_format($good_per,'2')}}%<i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width:{{$good_per}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$counter_bad}}</h3>
                            <div class="d-flex">
                                <span class="text-muted text-15 font-weight-bold">Bad</span>
                                <span class="t-font-boldest ml-auto">{{number_format($bad_per,'2')}}%<i class="i-Turn-Down-2 text-14 text-danger font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$bad_per_two}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$counter_criticle}}</h3>

                            <div class="d-flex"><span class="text-muted text-15 font-weight-bold">Criticle</span>
                                <span class="t-font-boldest ml-auto">{{number_format($cricticle_per,'2') }}%<i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$cricticle_per}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
{{--            </div>--}}

        </div>
        <br>
        <div class="col-lg-6 col-md-12">

{{--            <div class="col-lg-12 col-md-4 mb-4">--}}
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Performance  (Last Two Weeks)</div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$two_counter_good}}</h3>
                            <div class="d-flex"><span class="text-muted text-15 font-weight-bold">Good</span>


                                <span class="t-font-boldest ml-auto">{{number_format($good_per_two,'2')}}%<i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width:{{$good_per_two}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$two_counter_bad}}</h3>
                            <div class="d-flex">
                                <span class="text-muted text-15 font-weight-bold">Bad</span>
                                <span class="t-font-boldest ml-auto">{{number_format($bad_per_two,'2')}}%<i class="i-Turn-Down-2 text-14 text-danger font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$bad_per_two}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="ul-widget-app__poll-list mb-4">
                            <h3 class="heading mr-2">{{$two_counter_criticle}}</h3>

                            <div class="d-flex"><span class="text-muted text-15 font-weight-bold">Criticle</span>
                                <span class="t-font-boldest ml-auto">{{number_format($cricticle_per_two,'2') }}%<i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                            <div class="progress progress--height-2 mb-3">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$cricticle_per_two}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



{{--        </div>--}}
    </div>
    <br>

    <!----------------------row9 end------------------------>

    <div class="row">
{{--        <div class="card mb-4">--}}
{{--            <div class="card-body">--}}
{{--                <div class="card-title">Single Bar chart</div>--}}
{{--                <canvas id="echartBar6"></canvas>--}}
{{--            </div>--}}
{{--        </div>--}}


        <div class="col-md-12">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Employees by Company</div>
                    <div class="table-responsive table-emp">
                        <table class="table  text-15  text-center datatable-emp">
                            <thead>
                            <tr style="background: #f62d51" class="ticket-table-row">
                                <th>Company Name</th>
                                <th>Employees</th>
                            </tr>
                            </thead>
                            @foreach($employees_by_com as $emp)
                                <tbody>
                                <tr>
                                  <td>{{$emp['company_name']}}</td>
                                 <td>{{$emp['company_count']}}</td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
        </div>

{{----------------------row A/R Balance------------------------}}
    {{--------------------------------row4 stars--------------------}}
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="card mb-6">
                                    <div class="card-body">
                                        <div class="card-title">A/R Balance</div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <!-- ICON BG-->
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Add-File ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Agreed Amount</h5>
                                                            <button class="btn btn-tick-total_agreed">{{$ar_balance->sum('agreed_amount')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Money-Bag ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Cash Revceived</h5>
                                                            <button class="btn btn-tick-total_rec">{{$ar_balance->sum('cash_received')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Pound ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Discount</h5>
                                                            <button class="btn btn-tick-total_dis">{{$ar_balance->sum('discount')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                ----------------}}


                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Dollar-Sign ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Deduction</h5>
                                                            <button class="btn  btn-tick-pending_pound ">{{$total_deduction}}</button>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Money ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total  Addition</h5>
                                                            <button class="btn  btn-tick-process_add">{{$ar_balance_sheet->where('status','0')->sum('balance')}}</button>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Euro ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Balance</h5>
                                                            <button class="btn btn-tick-total">{{$ar_balance->sum('balance')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="card card-profile-1 mb-4">
                                                        <div class="card-body text-center">
                                                            <div class="avatar box-shadow-2 mb-3">
                                                                <i class="i-Euro ticket-icon"></i>
                                                            </div>
                                                            <h5 class="m-1">Total Riders Qty</h5>
                                                            <button class="btn btn-tick-total">{{count($ar_balance)}}</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-lg-6 col-md-12">

                                <div class="card mb-6">
                                    <div class="card-body">



                                        <div class="card-title">A/R Balance By Platform </div>
                                        <div class="table-responsive ar_platform">
                                            <table style='position: relative' class="table table-striped  table-dark text-15  text-center dataTable no-footer" role="grid" aria-describedby="sales_table_info">
                                                <thead class="table_head_ar" style="background: #8b0000">
                                                <tr>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Platform</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Agreed Amount</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Cash Received</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Discount</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Deduction</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Addition</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Balance</th>
                                                    <th style='position: sticky; top: -1px; background: #8b0000'>Qty</th>
                                                </tr>
                                                </thead>
                                                @foreach($platform_balance as $res)
                                                    <tr>
                                                        <td>{{$res['platform']}}</td>
                                                        <td>{{$res['agreed_amount']}}</td>
                                                        <td>{{$res['cash_received']}}</td>
                                                        <td>{{$res['discount']}}</td>
                                                        <td>{{$res['deduction']}}</td>
                                                        <td>{{$res['addition']}}</td>
                                                        <td>{{$res['balance']}}</td>
                                                        <td>{{$res['rider_qty']}}</td>


                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!----------------------row4 ends------------------------>
                    </div>
{{--                    2nd processor--}}
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                        <!----------------------row10------------------------>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">


                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title">COD Last Two Weeks</div>
                                        <div id="echartBar2" style="height: 300px;"></div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-lg-6 col-md-12">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title">COD Last Two Weeks by Cash</div>
                                        <div id="echartBar3" style="height: 300px;"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title">COD Last Two Weeks by Bank</div>
                                        <div id="echartBar4" style="height: 300px;"></div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-6 col-md-12">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="card-title">COD Generated Last Two Weeks</div>
                                            <div id="echartBar5" style="height: 300px;"></div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                            <div class="col-md-6">


                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title">COD Generated Last Two Weeks</div>
                                        <div id="echartBar6" style="height: 250px;"></div>
                                    </div>
                                </div>

                            </div>
                            <!----------------------row10 end------------------------>



                    </div>

                </div>
            </div>
        </div>




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


                <script>
                    $(document).ready(function () {
                        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                            var currentTab = $(e.target).attr('id'); // get current tab

                            var split_ab = currentTab;
                            // alert(split_ab[1]);

                            if(split_ab=="home-basic-tab"){



                            }

                            else if(split_ab=="profile-basic-tab"){
                                var echartElemBar = document.getElementById('echartBar2');

                                if (echartElemBar) {
                                    var echartBar = echarts.init(echartElemBar);
                                    echartBar.setOption({
                                        legend: {
                                            borderRadius: 0,
                                            orient: 'horizontal',
                                            x: 'right',
                                            data: ['COD Last Two Weeks']
                                        },
                                        grid: {
                                            left: '8px',
                                            right: '8px',
                                            bottom: '0',
                                            containLabel: true
                                        },
                                        tooltip: {
                                            show: true,
                                            backgroundColor: 'rgba(0, 0, 0, .8)'
                                        },
                                        xAxis: [{
                                            type: 'category',


                                            data: [<?php echo $data_label; ?>],
                                            axisTick: {
                                                alignWithLabel: true,
                                                fontSize: 40
                                            },
                                            splitLine: {
                                                show: false
                                            },
                                            axisLine: {
                                                show: true
                                            },
                                            axisLabel: {
                                                interval: 0,
                                                rotate: 0 //If the label names are too long you can manage this by rotating the label.
                                            }
                                        }],
                                        yAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                formatter: '{value}'
                                            },
                                            min: 0,
                                            max: 10000,
                                            interval: 500,
                                            dataMin:0,
                                            dataMax:1000,
                                            axisLine: {
                                                show: false
                                            },
                                            splitLine: {
                                                show: true,
                                                interval: 'auto'
                                            }

                                        }],
                                        series: [{
                                            name: 'Online',
                                            // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                                            label: {
                                                show: false,
                                                color: '#0168c1'
                                            },
                                            type: 'bar',
                                            barGap: 0,
                                            color: '#bcbbdd',
                                            smooth: true,
                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }, {
                                            name: 'COD Last Two Weeks',

                                            data: [<?php echo $data_label_values; ?>],
                                            label: {
                                                show: false,
                                                color: '#639'
                                            },
                                            type: 'bar',
                                            color: '#4caf50',
                                            smooth: true,

                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }

                                        }]
                                    });
                                    $(window).on('resize', function () {
                                        setTimeout(function () {
                                            echartBar.resize();
                                        }, 500);
                                    });
                                } // Chart in Dashboard version 1

                                // cart 2--------------
                                var echartElemBar = document.getElementById('echartBar3');

                                if (echartElemBar) {
                                    var echartBar = echarts.init(echartElemBar);
                                    echartBar.setOption({
                                        legend: {
                                            borderRadius: 0,
                                            orient: 'horizontal',
                                            x: 'right',
                                            data: ['COD Last Two Weeks By Cash']
                                        },
                                        grid: {
                                            left: '8px',
                                            right: '8px',
                                            bottom: '0',
                                            containLabel: true
                                        },
                                        tooltip: {
                                            show: true,
                                            backgroundColor: 'rgba(0, 0, 0, .8)'
                                        },
                                        xAxis: [{
                                            type: 'category',


                                            data: [<?php echo $data_label_cash; ?>],
                                            axisTick: {
                                                alignWithLabel: true,
                                                fontSize: 40
                                            },
                                            splitLine: {
                                                show: false
                                            },
                                            axisLine: {
                                                show: true
                                            },
                                            axisLabel: {
                                                interval: 0,
                                                rotate: 0 //If the label names are too long you can manage this by rotating the label.
                                            }
                                        }],
                                        yAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                formatter: '{value}'
                                            },
                                            min: 0,
                                            max: 10000,
                                            interval: 500,
                                            dataMin:0,
                                            dataMax:1000,
                                            axisLine: {
                                                show: false
                                            },
                                            splitLine: {
                                                show: true,
                                                interval: 'auto'
                                            }

                                        }],
                                        series: [{
                                            name: 'Online',
                                            // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                                            label: {
                                                show: false,
                                                color: '#0168c1'
                                            },
                                            type: 'bar',
                                            barGap: 0,
                                            color: '#bcbbdd',
                                            smooth: true,
                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }, {
                                            name: 'COD Last Two Weeks By Cash',

                                            data: [<?php echo $data_label_values_cash; ?>],
                                            label: {
                                                show: false,
                                                color: '#639'
                                            },
                                            type: 'bar',
                                            color: '#0a6aa1',
                                            smooth: true,

                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }

                                        }]
                                    });
                                    $(window).on('resize', function () {
                                        setTimeout(function () {
                                            echartBar.resize();
                                        }, 500);
                                    });
                                }
                                // chart3--------
                                var echartElemBar = document.getElementById('echartBar4');

                                if (echartElemBar) {
                                    var echartBar = echarts.init(echartElemBar);
                                    echartBar.setOption({
                                        legend: {
                                            borderRadius: 0,
                                            orient: 'horizontal',
                                            x: 'right',
                                            data: ['COD Last Two Weeks By Bank']
                                        },
                                        grid: {
                                            left: '8px',
                                            right: '8px',
                                            bottom: '0',
                                            containLabel: true
                                        },
                                        tooltip: {
                                            show: true,
                                            backgroundColor: 'rgba(0, 0, 0, .8)'
                                        },
                                        xAxis: [{
                                            type: 'category',


                                            data: [<?php echo $data_label_bank; ?>],
                                            axisTick: {
                                                alignWithLabel: true,
                                                fontSize: 40
                                            },
                                            splitLine: {
                                                show: false
                                            },
                                            axisLine: {
                                                show: true
                                            },
                                            axisLabel: {
                                                interval: 0,
                                                rotate: 0 //If the label names are too long you can manage this by rotating the label.
                                            }
                                        }],
                                        yAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                formatter: '{value}'
                                            },
                                            min: 0,
                                            max: 10000,
                                            interval: 500,
                                            dataMin:0,
                                            dataMax:1000,
                                            axisLine: {
                                                show: false
                                            },
                                            splitLine: {
                                                show: true,
                                                interval: 'auto'
                                            }

                                        }],
                                        series: [{
                                            name: 'Online',
                                            // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                                            label: {
                                                show: false,
                                                color: '#0168c1'
                                            },
                                            type: 'bar',
                                            barGap: 0,
                                            color: '#bcbbdd',
                                            smooth: true,
                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }, {
                                            name: 'COD Last Two Weeks By Bank',

                                            data: [<?php echo $data_label_values_bank; ?>],
                                            label: {
                                                show: false,
                                                color: '#639'
                                            },
                                            type: 'bar',
                                            color: '#e25a4e',
                                            smooth: true,

                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }

                                        }]
                                    });
                                    $(window).on('resize', function () {
                                        setTimeout(function () {
                                            echartBar.resize();
                                        }, 500);
                                    });
                                } // Chart in Dashboard version 1

                                //chart4-----------
                                var echartElemBar = document.getElementById('echartBar5');

                                if (echartElemBar) {
                                    var echartBar = echarts.init(echartElemBar);
                                    echartBar.setOption({
                                        legend: {
                                            borderRadius: 0,
                                            orient: 'horizontal',
                                            x: 'right',
                                            data: ['COD Generated Last Two Weeks']
                                        },
                                        grid: {
                                            left: '8px',
                                            right: '8px',
                                            bottom: '0',
                                            containLabel: true
                                        },
                                        tooltip: {
                                            show: true,
                                            backgroundColor: 'rgba(0, 0, 0, .8)'
                                        },
                                        xAxis: [{
                                            type: 'category',


                                            data: [<?php echo $data_label_gen; ?>],
                                            axisTick: {
                                                alignWithLabel: true,
                                                fontSize: 40
                                            },
                                            splitLine: {
                                                show: false
                                            },
                                            axisLine: {
                                                show: true
                                            },
                                            axisLabel: {
                                                interval: 0,
                                                rotate: 30
                                                //If the label names are too long you can manage this by rotating the label.
                                            }
                                        }],
                                        yAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                formatter: '{value}'
                                            },
                                            min: 0,
                                            max: 10000,
                                            interval: 1000,
                                            dataMin:0,
                                            dataMax:1000,
                                            axisLine: {
                                                show: false
                                            },
                                            splitLine: {
                                                show: true,
                                                interval: 'auto'
                                            }

                                        }],
                                        series: [{
                                            name: 'Online',
                                            // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                                            label: {
                                                show: false,
                                                color: '#0168c1'
                                            },
                                            type: 'bar',
                                            barGap: 0,
                                            color: '#bcbbdd',
                                            smooth: true,
                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }, {
                                            name: 'COD Generated Last Two Weeks',

                                            data: [<?php echo $data_label_values_gen; ?>],
                                            label: {
                                                show: false,
                                                color: '#639'
                                            },
                                            type: 'bar',
                                            color: '#003473',
                                            smooth: true,

                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }]
                                    });
                                    $(window).on('resize', function () {
                                        setTimeout(function () {
                                            echartBar.resize();
                                        }, 500);
                                    });
                                } // Chart in Dashboard version 1

                                var echartElemBar = document.getElementById('echartBar6');
                                if (echartElemBar) {
                                    var echartBar = echarts.init(echartElemBar);
                                    echartBar.setOption({
                                        legend: {
                                            borderRadius: 0,
                                            orient: 'horizontal',
                                            x: 'right',
                                            data: ['Labour card Type']
                                        },
                                        grid: {
                                            left: '0px',
                                            right: '8px',
                                            bottom: '0',
                                            containLabel: true
                                        },
                                        tooltip: {
                                            show: true,
                                            backgroundColor: 'rgba(0, 0, 0, .8)'
                                        },
                                        yAxis: [{
                                            type: 'category',
                                            data: ['Amount Less Than 500','Amounts Between 500 & 750','Amounts Between 750 & 1000','Amounts More Than 1000'],
                                            axisTick: {
                                                alignWithLabel: true,

                                            },

                                            splitLine: {
                                                show: false
                                            },
                                            axisLine: {
                                                show: true
                                            }
                                        }],
                                        xAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                formatter: '{value}'
                                            },

                                            min: 0,
                                            max: 10000,
                                            interval: 1000,
                                            dataMin:0,
                                            dataMax:1000,

                                            axisLine: {
                                                show: false
                                            },
                                            splitLine: {
                                                show: true,
                                                interval: 'auto'
                                            }
                                        }],
                                        series: [{
                                            name: 'Online',
                                            // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                                            label: {
                                                show: false,
                                                color: '#0168c1'
                                            },
                                            type: 'bar',
                                            barGap: 0,
                                            color: '#bcbbdd',
                                            smooth: true,
                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }
                                        }, {
                                            name: 'COD',

                                            data: [<?php echo $cod_counter1; ?>,<?php echo $cod_counter2; ?>,<?php echo $cod_counter3; ?>,<?php echo $cod_counter4; ?>],
                                            label: {
                                                show: false,
                                                color: '#639'
                                            },
                                            type: 'bar',
                                            color: '#7569b3',
                                            smooth: true,

                                            itemStyle: {
                                                emphasis: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowOffsetY: -2,
                                                    shadowColor: 'rgba(0, 0, 0, 0.3)'
                                                }
                                            }

                                        }]
                                    });
                                    $(window).on('resize', function () {
                                        setTimeout(function () {
                                            echartBar.resize();
                                        }, 500);
                                    });
                                } // Chart in Dashboard version 1



                            }

                        }) ;
                    });

                </script>






    <script type="text/javascript">

        /*Downloaded from https://www.codeseek.co/mahish/arrow-buttons-for-responsive-horizontal-scroll-menu-RajmQw */
        // duration of scroll animation
        var scrollDuration = 300;
        // paddles
        var leftPaddle = document.getElementsByClassName('left-paddle');
        var rightPaddle = document.getElementsByClassName('right-paddle');
        // get items dimensions
        var itemsLength = $('.item').length;
        var itemSize = $('.item').outerWidth(true);
        // get some relevant size for the paddle triggering point
        var paddleMargin = 50;

        // get wrapper width
        var getMenuWrapperSize = function() {
            return $('.menu-wrapper').outerWidth();
        }
        var menuWrapperSize = getMenuWrapperSize();
        // the wrapper is responsive
        $(window).on('resize', function() {
            menuWrapperSize = getMenuWrapperSize();
        });
        // size of the visible part of the menu is equal as the wrapper size
        var menuVisibleSize = menuWrapperSize;

        // get total width of all menu items
        var getMenuSize = function() {
            return itemsLength * itemSize;
        };
        var menuSize = getMenuSize();
        // get how much of menu is invisible
        var menuInvisibleSize = menuSize - menuWrapperSize;

        // get how much have we scrolled to the left
        var getMenuPosition = function() {
            return $('.menu').scrollLeft();
        };

        // finally, what happens when we are actually scrolling the menu
        $('.menu').on('scroll', function() {

            // get how much of menu is invisible
            menuInvisibleSize = menuSize - menuWrapperSize;
            // get how much have we scrolled so far
            var menuPosition = getMenuPosition();

            var menuEndOffset = menuInvisibleSize - paddleMargin;

            // show & hide the paddles
            // depending on scroll position
            if (menuPosition <= paddleMargin) {
                $(leftPaddle).addClass('hidden');
                $(rightPaddle).removeClass('hidden');
            } else if (menuPosition < menuEndOffset) {
                // show both paddles in the middle
                $(leftPaddle).removeClass('hidden');
                $(rightPaddle).removeClass('hidden');
            } else if (menuPosition >= menuEndOffset) {
                $(leftPaddle).removeClass('hidden');
                $(rightPaddle).addClass('hidden');
            }

            // print important values
            $('#print-wrapper-size span').text(menuWrapperSize);
            $('#print-menu-size span').text(menuSize);
            $('#print-menu-invisible-size span').text(menuInvisibleSize);
            $('#print-menu-position span').text(menuPosition);

        });

        // scroll to left
        $(rightPaddle).on('click', function() {
            $('.menu').animate( { scrollLeft: menuInvisibleSize}, scrollDuration);
        });

        // scroll to right
        $(leftPaddle).on('click', function() {
            $('.menu').animate( { scrollLeft: '0' }, scrollDuration);
        });
    </script>



@endsection
