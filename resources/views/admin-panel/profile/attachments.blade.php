@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>



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
        /*@media only screen and (min-width: 960px) {*/

        /*    .block-update-card {*/
        /*        height: 100%;*/
        /*        border: 1px #FFFFFF solid;*/
        /*        width: 338px;*/
        /*        float: left;*/
        /*        margin-left: 25px;*/
        /*        margin-top: 20px;*/
        /*        padding: 0;*/
        /*        box-shadow: 1px 1px 8px #d8d8d8;*/
        /*        background-color: #FFFFFF;*/
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
    </style>

@endsection
@section('content')





        <div class="col-md-12 " style="border-right:1px solid #e5e5e5">
            <div class="row items">

                @if(!empty($user->passport->passport_pic))
                    <div class="col-md-3 mix" >
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <p class="text-left">Passport Picture</p>
                                <a class="card-link" href="{{ url($user->passport->passport_pic) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->passport_pic) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->attach->attachment_name) && isset($user->passport->attachment_type->name))
                    <div class="col-md-3 mix" >
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <p class="text-left">{{ $user->passport->attachment_type->name }} Picture</p>
                                <a class="card-link" href="{{ url($user->passport->attach->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->attach->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->personal_info->personal_image))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <p class="text-left">Personal Picture</p>
                                <a class="card-link" href="{{ url($user->passport->personal_info->personal_image) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->personal_info->personal_image) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif


                @if(!empty($user->passport->offer->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->offer->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Offer Letter Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->offer->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->offer->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->offer_letter_submission->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Offer Letter Submission</h5>
                                <a class="card-link" href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->elect_pre_approval->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Electronic Pre Approval</h5>
                                <a class="card-link" href="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->elect_pre_approval_payment->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden">
                            <div class="card-body">
                                <p class="text-left">Electronic Pre Approval Payment</p>
                                <a class="card-link" href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->print_visa_inside_outside->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden">

                            <div class="card-body">
                                <p class="text-left">Print Visa Inside/Outside</p>
                                <a class="card-link" href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->status_change->attachment->attachment_name))
                    <div class="col-md-3 mix ">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->status_change->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Status Change Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->status_change->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->status_change->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->status_change->proof))
                    <div class="col-md-3 mix" >
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->status_change->proof) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title ">Status Change Proof</h5>
                                <a class="card-link" href="{{ url($user->passport->status_change->proof) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->status_change->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->entry_date->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->entry_date->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Entry Date</h5>
                                <a class="card-link" href="{{ url($user->passport->entry_date->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->entry_date->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->medical_twnenty_four->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Medical 24 Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->medical_fourty_eight->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Medical 48 Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->medical_vip->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_vip->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Medical VIP Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->medical_normal->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_normal->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Medical Normal Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->fit_unfit->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">FIT UnFit Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->emitres_id_apply->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Emirates Id Apply Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->contract_typing->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->contract_typing->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">New Contract Application Typing Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif


                @if(!empty($user->passport->contract_typing->proof))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->contract_typing->proof) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">New Contract Application Typing Proof</h5>
                                <a class="card-link" href="{{ url($user->passport->contract_typing->proof) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->contract_typing->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->new_contract_submission->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">New Contract Submission Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->labour_card_print->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Labour Card Print Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->visa_stamping->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Visa Stamping Application Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->visa_stamping->proof))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_stamping->proof) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Visa Stamping Application Proof</h5>
                                <a class="card-link" href="{{ url($user->passport->visa_stamping->proof) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->visa_stamping->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->visa_pasted->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Visa Pasted Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($user->passport->emirated_id_received->attachment->attachment_name))
                    <div class="col-md-3 mix">
                        <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}" alt="" />
                            <div class="card-body">
                                <h5 class="card-title text-left title">Unique Emirates ID Received Attachment</h5>
                                <a class="card-link" href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                <a   href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endif

    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    {{--                <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>--}}



    <script>

        $("#apply_filter").click(function () {
            // function assign_load_data(keyword= '', filter_by= ''){
            var token = $("input[name='_token']").val();
            var keyword  =   $("#keyword").val();
            var filter_by  =   $("#filter_by").val();

            $.ajax({
                url: "{{ route('profile_show') }}",
                method: 'POST',
                dataType: 'json',
                data:{keyword:keyword, filter_by:filter_by,_token:token},
                success: function (response) {
                    $('#all-row').empty();
                    $('#all-row').append(response.html);
                    $('#all-row').show();

                }
            });
        });
    </script>
    <script>
        $("#apply_filter").click(function(){

            var keyword  =   $("#keyword").val();
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

            $("#keyword").val('');
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

    {{--    Cod History--}}

    <script>

        $("#cod_id").click(function () {
            // function assign_load_data(keyword= '', filter_by= ''){
            var token = $("input[name='_token']").val();
            var pass_id  =   $("#cod_val").val();

            alert(pass_id)

            {{--$.ajax({--}}
            {{--    url: "{{ route('profile_show') }}",--}}
            {{--    method: 'POST',--}}
            {{--    dataType: 'json',--}}
            {{--    data:{keyword:keyword, filter_by:filter_by,_token:token},--}}
            {{--    success: function (response) {--}}
            {{--        $('#all-row').empty();--}}
            {{--        $('#all-row').append(response.html);--}}
            {{--        $('#all-row').show();--}}

            {{--    }--}}
            {{--});--}}
        });


    </script>

    <script>
        function handleClick() {
            // var pass_id  =   $("#cod_history").val();
            var id = $(this).attr('id');
            var keyword  =   $(".cod_full").val();
            var token = $("input[name='_token']").val();
            alert(keyword)
        }
        $(".cod_full_detail").click(function () {
            // function assign_load_data(keyword= '', filter_by= ''){
            var token = $("input[name='_token']").val();
            var pass_id = $(this).attr('id');
            alert(pass_id)


            {{--$.ajax({--}}
            {{--    url: "{{ route('profile_show') }}",--}}
            {{--    method: 'POST',--}}
            {{--    dataType: 'json',--}}
            {{--    data:{keyword:keyword, filter_by:filter_by,_token:token},--}}
            {{--    success: function (response) {--}}
            {{--        $('#all-row').empty();--}}
            {{--        $('#all-row').append(response.html);--}}
            {{--        $('#all-row').show();--}}

            {{--    }--}}
            {{--});--}}
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
        var paddleMargin = 20;

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


    </script>

@endsection

