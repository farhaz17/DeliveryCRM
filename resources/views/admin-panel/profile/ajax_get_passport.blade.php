<style>
    .margin-top{
        margin-top:10px;
    }
    .dataTables_filter{
        display: none;
    }
    .dataTables_length{
        display: none;
    }
    .hide_cls{
        display: none;
    }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 2px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }
    .dataTableLayout {
        table-layout:fixed;
        width:100%;
    }
    .user-profile .header-cover {
        background-position: center;
    }
    .cod-img {
        height: 40px;
        width: 40px;
    }
    span.cod-content {
        font-weight: 800;
    }
    /*.col-sm-4 {*/
    /*    line-height: 13px;*/
    /*}*/
    p.cod-p {
        margin-bottom: 8px;
        font-size: 12px;
        text-align: justify;
    }
    .cod-data {
        overflow: hidden;
    }
    .adj-img {
        height: 40px;
        width: 40px;
        position: relative;
        top: 20%;
        left: 30%;
    }
    .col-sm-4.adj-div2 {
        position: relative;
        right: 6%;
    }
    .col-sm-4.adj-div3 {
        position: relative;
        right: 45px;
    }
    .cod-main-div1{
        overflow: hidden;
        height: 500px;
        overflow-x: hidden;
    }
    .cod-main-div1:hover{
        overflow: scroll;
        height: 500px;
        overflow-x: hidden;
    }
    .cod-main-div2{
        overflow: hidden;
        height: 500px;
        overflow-x: hidden;
    }
    .cod-main-div2:hover{
        overflow: scroll;
        height: 500px;
        overflow-x: hidden;
    }
    i.text-20.i-Calendar-4 {
        color: #4caf50;
    }
    .performance-content {
        font-size: 20px;
    }
    p.performance-p {
        margin-bottom: 8px;
        font-size: 12px;
        text-align: center;
        line-height: 45px;
        cursor: pointer;
    }
    .per-div2 {
        /*position: relative;*/
        /*top: 74px;*/
        left: 0%;
        /* right: 8%; */
    }
    .per-div3 {
        /*position: relative;*/
        /*top: 60px;*/
        left: 24%;
        line-height: 22px;
        font-weight: 800;

    }
    p.per-p {
        white-space: nowrap;
        line-height: 20px;
    }
    p.per-p2 {
        white-space: nowrap;
        line-height: 0px;
    }
    .icon-cls{
        font-size: 19px;
    }
    a.btn.btn-info {
        float: right;
        margin-bottom: 9px;
        padding: 0px;
        font-size: 12px;
        /* margin-top: 0px; */
        /* position: relative; */
        /* top: -10px; */
    }
    .cod_full_btn1 {
        font-size: 10px;
        float: right;
        padding: 0px;
        font-weight: 800;
        margin-bottom: 0px;
        position: relative;
        top: -42px;
    }
    .cod_full_btn {
        font-size: 10px;
        float: right;
        padding: 0px;
        font-weight: 800;
        margin-bottom: 0px;
        position: relative;
        top: -22px;
    }
    .cd_md {
        width: 1216px;
        position: absolute;
        left: 11%;
        top: 0px;
        /* height: 836px; */
    }
    thead.thead-dark {
        background: black;
        color: #fff;
    }
    .attachment-modal-div {
        overflow: scroll;
        overflow-x: hidden;
        height: 800px;
    }
    .card.mb-4.o-hidden {
        line-height: 12px;
        height: 75%;
        font-size: 10px;

    }
    .modal-dialog-full-width {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;

    }
    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
        background-color: #ffffff !important
    }
    .modal-header-full-width  {
        border-bottom: 1px solid #9ea2a2 !important;
    }
    .modal-footer-full-width  {
        border-top: 1px solid #9ea2a2 !important;
    }
    .row.cards-row {
        margin-right: 25px;
        margin-left: 0px;
        justify-content: space-between;
    }
    .row.ticket-row {
        position: relative;
        top: 20px;
        display: flex;
        flex-wrap: wrap;
        margin-right: 12px;
        margin-left: 6px;
        height: 10em;
    }
    .card.card-icon.mb-4.ticket-card {
        height: 120px;
        /* width: 199px; */
    }
    #attachment-text {
        position: relative;
        left: 50%;
        top: 100px;
        font-size: 20px;
    }
    @media (min-width: 576px) {
        .modal-xl {
            max-width: 1500px;
            margin: 1.75rem auto;
        }
    }
    .chat-sidebar-container {
        height: auto;
        min-height: unset;
    }
    .histroy-audio {
        width: 220px;
    }
    small, .small {
        font-size: 55%;
        font-weight: 400;
    }
    a.text-default {
        font-size: 13px;
    }
    .bik_btn_cls {
        cursor: pointer;
    }
    .sim_btn_cls {
        cursor: pointer;
    }
    .plat_btn_cls {
        cursor: pointer;
    }
    i.fa.fa-print {
        font-size: 15px;
    }
    i.i-Receipt-3 {
        font-size: 15px;
    }
    .btns-side {
        position: relative;
        left: 80%;
    }
    div.vertical-line{
        width: 1px; /* Line width */
        background-color: black; /* Line color */
        /*height: 100%; !* Override in-line if you want specific height. *!*/
        float: left; /* Causes the line to float to left of content.
        You can instead use position:absolute or display:inline-block
        if this fits better with your design */
    }
    i.i-Full-View-Window {
        font-size: 15px;
    }
    .card-body.cards_len {
        overflow: hidden;
    }
    .card-body.cards_len:hover {
        overflow: scroll;
    }

    .defaulter_stamp_image{
        margin-top: -103px;
        z-index: 99;
        width: 110px;
        height: 110px;
    }
    .after_defaulter_profile_image_cls{
        filter: grayscale(100%);
    }


</style>
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

{{--<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />--}}
 <div class="modal fade bd-example-modal-lg" id="performance_detail_modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tikcets Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                                        <div class="card-body cards_len">
                                            <div class="card-title"><h5>Pending Approval</h5></div>
                                            @if($pending_tickets1 !='null')
                                            @foreach($pending_tickets1 as $ticket)
                                                <span class="mt-4 ml-3 ">#{{  $ticket->ticket_id }}</span>
                                                <br>
                                                <small class="text-muted  ml-3">{{  $ticket->created_at }}</small>
                                                <div class="d-flex flex-column flex-sm-row  mb-3 ml-2  border-bottom" >
                                                    <a class="text-success mr-2" target="_blank" href="{{route('manage_ticket.show',$ticket->id)}}">View details</a>
                                                </div>
                                            @endforeach
                                            @else
                                                <span>No Data</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                                        <div class="card-body cards_len">
                                            <div class="card-title"> <h5>In Process Tickets</h5></div>
                                            @if($in_process_tickets1 != 'null' )
                                            @foreach($in_process_tickets1 as $ticket)
                                                <span  class="mt-4 ml-3 ">#{{  $ticket->ticket_id }}</span>
                                                <br>
                                                <small class="text-muted  ml-3">{{  $ticket->created_at }}</small>
                                                <div class="d-flex flex-column flex-sm-row  mb-3 ml-2  border-bottom" >
                                                    <a class="text-success mr-2" target="_blank" href="{{route('manage_ticket.show',$ticket->id)}}">View details</a>
                                                </div>
                                            @endforeach
                                            @else
                                                <span>No Data</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                                        <div class="card-body cards_len">
                                            <div class="card-title"> <h5>Closed Ticket</h5></div>
                                            @if($closed_tickets1 !='null')
                                            @foreach($closed_tickets1 as $ticket)
                                                <span  class="mt-4 ml-3 ">#{{  $ticket->ticket_id }}</span>
                                                <br>
                                                <small class="text-muted  ml-3">{{  $ticket->created_at }}</small>
                                                <div class="d-flex flex-column flex-sm-row  mb-3 ml-2  border-bottom" >
                                                    <a class="text-success mr-2" target="_blank" href="{{route('manage_ticket.show',$ticket->id)}}">View details</a>
                                                </div>
                                            @endforeach
                                            @else
                                                <span>No Data</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                                        <div class="card-body cards_len">
                                            <div class="card-title"> <h5>Rejected Ticket</h5></div>
                                            @if($rejected_tickets1 !='null')
                                            @foreach($rejected_tickets1 as $ticket)
                                                <span  class="mt-4 ml-3 ">#{{  $ticket->ticket_id }}</span>
                                                <br>
                                                <small class="text-muted  ml-3">{{  $ticket->created_at }}</small>
                                                <div class="d-flex flex-column flex-sm-row  mb-3 ml-2  border-bottom" >
                                                    <a class="text-success mr-2" target="_blank" href="{{route('manage_ticket.show',$ticket->id)}}">View details</a>
                                                </div>
                                            @endforeach
                                            @else
                                                <span>No Data</span>
                                            @endif
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
    </div>
</div>
<div class="card user-profile o-hidden mb-4">
    <div class="user-info">

        <?php
                                $check_defaulter  = isset($passport->defaulter_rider_details) ? $passport->defaulter_rider_details : null;
                                $is_defaulte_now = null;

                                if(isset($check_defaulter)){
                                        if(count($check_defaulter)>0){
                                            $is_defaulte_now  =  $check_defaulter[0]->check_defaulter_rider() ? $check_defaulter[0]->check_defaulter_rider() : null;

                                       }
                                }
                                ?>

        @if($user!="null")
            <img class="profile-picture avatar-lg mb-2 @isset($is_defaulte_now) after_defaulter_profile_image_cls @endisset" src="{{  $user->image ? url($user->image) : asset('assets/images/user_avatar.jpg') }}" alt="No image" />
            @isset($is_defaulte_now)
            <img class="profile-picture avatar-lg mb-2 defaulter_stamp_image "  style="margin-top:-102px;" src="{{ asset('assets/logos/defaulter_stamp_original.png')  }}" alt="No image" />
            @endisset

        @else
            <img class="profile-picture avatar-lg mb-2 @isset($is_defaulte_now) after_defaulter_profile_image_cls @endisset " src="{{ asset('assets/images/user_avatar.jpg') }}" alt="No image" />
            @isset($is_defaulte_now)
            <img class="profile-picture avatar-lg mb-2 defaulter_stamp_image "  style="margin-top:-102px;" src="{{ asset('assets/logos/defaulter_stamp_original.png')  }}" alt="No image" />
            @endisset
        @endif


        <?php
        $is_superviser = isset($passport->category_assign) ? $passport->category_assign : null;
        $now_superviser = null;

        if(isset($is_superviser)){
            $status_of_superviser = $passport->get_employee_type();

            $status  = isset($status_of_superviser) ? $status_of_superviser->sub_category2 : null;
            if($status=="11"){
                $now_superviser = "Supervisor";
            }
        }
            ?>

        @if($passport->cancel_status=="0")
        <p class="m-0 text-24">{{$full_name->full_name}}

            <span style="color: red">(
                @if(isset($now_superviser))
                {{ isset($now_superviser) ? $now_superviser : 'N/A' }}
                @else
                {{ isset($dc->user_detail->name) ? $dc->user_detail->name : 'N/A' }}
                @endif
            )
            </span>
        <span>{{ isset($vendor_rider->vendor) ? " 4PL - " . $vendor_rider->vendor->name : '' }}</span></p>
        @else
        <p class="m-0 text-24">
            <strike style="color:red;"><span style="color:#47404f">{{$full_name->full_name}} </span></strike>
            <span style="color: red">
                (
                    @if(isset($now_superviser))
                    {{ isset($now_superviser) ? $now_superviser : 'N/A' }}
                    @else
                    {{ isset($dc->user_detail->name) ? $dc->user_detail->name : 'N/A' }}
                    @endif

                )
                </span>
            <span style="color: red">(Cancellled)</span>
        </p>
        @endif


    </div>
    <div class="col-sm-12">
        <div class="row ticket-row">
            <div class="col-md-3">
                <div class="card card-icon ticket-card">
                    <div class="card-body text-center bg-info" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:20px 0">
                        <i class="i-Ticket text-white"></i>
                        <p class="text-white mt-2 mb-2">Pending Tickets</p>
                        @if($pending_tickets!='null')
                            <p class="lead text-22 m-0 text-white">{{$pending_tickets}}</p>
                        @else
                            <p class="lead text-22 m-0 text-white">0</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-icon ticket-card">
                    <div class="card-body text-center bg-warning" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:20px 0">
                        <i class="i-Ticket text-dark"></i>
                        <p class="text-dark mt-2 mb-2"> In-Process Tickets</p>
                        @if($in_process_tickets!='null')
                            <p class="lead text-22 m-0 text-dark">{{$in_process_tickets}}</p>
                        @else
                            <p class="lead text-22 m-0 text-dark">0</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-icon ticket-card">
                    <div class="card-body text-center bg-success" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:20px 0">
                        <i class="i-Ticket text-white"></i>
                        <p class="text-white mt-2 mb-2">Closed Tickets</p>
                        @if($closed_tickets!='null')
                            <p class="lead text-22 m-0 text-white">{{$closed_tickets}}</p>
                        @else
                            <p class="lead text-22 m-0 text-white">0</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-icon ticket-card">
                    <div class="card-body text-center bg-danger" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:20px 0">
                        <i class="i-Ticket text-white"></i>
                        <p class=" text-white mt-2 mb-2">Rejected Tickets</p>
                        @if($closed_tickets!='null')
                            <p class="lead text-22 m-0  text-white">{{$rejected_tickets}}</p>
                        @else
                            <p class="lead text-22 m-0  text-white">0</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row cards-row">
            <div class="media block-update-card bikes_checkin" id="bikes_checkdin">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/bike.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Bike</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Bike Number:<span id="bike_value">  {{isset($assign_bike->bike_plate_number->plate_no)?$assign_bike->bike_plate_number->plate_no:"N/A"}} </span></p>
                    @if($temporary_bike)
                        <p class="text-attr">Temporary Bike:<span id="temporary_bike_value">  {{isset($temporary_bike->temporary_plate_number->plate_no)?$temporary_bike->temporary_plate_number->plate_no:"N/A"}} </span></p>
                    @endif
                    <p class="text-attr">Checkin:<span id="bike_value2"> {{isset($assign_bike->checkin)?$assign_bike->checkin:"N/A"}} </span></p>

                </div>
            </div>
            <div class="media block-update-card sim_checkin" id="icon-sim">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/sim.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">SIM</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">SIM Number : {{isset($assign_sim->telecome->account_number)?$assign_sim->telecome->account_number:"N/A"}}</p>
                    @if($temporary_sim)
                        <p class="text-attr">Temporary Sim:<span id="temporary_bike_value">  {{isset($temporary_sim->temporary_plate_number->account_number)?$temporary_sim->temporary_plate_number->account_number:"N/A"}} </span></p>
                    @endif
                    <p class="text-attr">Checkin : {{isset($assign_sim->checkin)?$assign_sim->checkin:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card platform_checkin" id="platform-icon">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/platform.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Platform</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Platform : {{isset($assign_plat->plateformdetail->name)?$assign_plat->plateformdetail->name:"N/A"}}</p>
                    <p class="text-attr">Checkin : {{ isset($assign_plat->checkin)?$assign_plat->checkin:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card" id="passport_detail">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/passport.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Passport</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Passport Number : {{isset($passport->passport_no)?$passport->passport_no:"N/A"}}</p>
                    <p class="text-attr">Expiry Date : {{isset($passport->date_expiry)?$passport->date_expiry:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card" id="emirates_id">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/idcard.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="LH1175851">ID Card</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Card Number : {{isset($emirates_id->card_no)?$emirates_id->card_no:"N/A"}}</p>
                    <p class="text-attr">Expiry Date : {{isset($emirates_id->expire_date)?$emirates_id->expire_date:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card" id="driving_license">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/license.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">License</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Driving License : {{isset($driving_license->license_number)?$driving_license->license_number:"N/A"}}</p>
                    <p class="text-attr">Expiry Date : {{isset($driving_license->expire_date)?$driving_license->expire_date:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card" id="user_code">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/usercodes.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">User Codes</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">ZDS Code : {{isset($user_code->zds_code)?$user_code->zds_code:"N/A"}}</p>
                    <p class="text-attr">PPUID : {{isset($passport->pp_uid)?$passport->pp_uid:"N/A"}}</p>
                </div>
            </div>
            <div class="media block-update-card" id="cod_detail">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/cashondelivery.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">COD</h4>
                    <p id="passport_id" style="display: none">{{ $passport_id }}</p>
                    <input type="hidden" name="pass_val" value="{{ $passport_id}}" id="pass_val">
                    <p class="text-attr">Outstanding Balance : {{ number_format($cod_balances->sum('balance') ?? 0 , 2) }}</p>
                    {{-- <p class="text-attr">Outstanding Balance : {{ $remain_amount }}</p> --}}
                    {{--                <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>--}}
                </div>
            </div>

            <div class="media block-update-card" id="visa_det_btn">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/visa_process_icon.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Visa Details</h4>
                    <p id="passport_id" style="display: none">{{ $passport_id }}</p>
                    <input type="hidden" name="pass_val" value="{{ $passport_id}}" id="pass_val">
                    <p class="text-attr"> {{$visa_msg}}</p>
                    @if($visa_pasted!='0')

                    <p class="text-attr"> Expiry Date: {{date('d-m-Y', strtotime($visa_pasted->expiry_date))}}</p>
                    @else
                    <p class="text-attr">Expiry Date: N/A</p>
                    @endif
                     {{-- <p class="text-attr">Outstanding Balance : {{ $remain_amount }}</p> --}}
                    {{--                <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>--}}
                </div>
            </div>
            <div class="media block-update-card" id="performance_detail">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/performance.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Performance</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    @if(isset ($average_rating) != '6')
                        <p class="text-attr">Overall Rating: {{isset($average_rating)?number_format($average_rating,'2'):"N/A"}}</p>
                        @if(isset($average_rating))
                            @if($average_rating<='2')
                                <p class="text-attr"> <span class="badge badge-danger">Critcle</span></p>
                            @elseif($average_rating>'2' and $average_rating<'4')
                                <p class="text-attr"> <span class="badge badge-info">Bad</span></p>
                            @elseif($average_rating>='4')
                                <p class="text-attr"><span class="badge badge-success ">Good</span></p>
                            @else
                                <p class="text-attr"> <span class="badge badge-primary">N/A</span></p>
                            @endif
                        @endif
                    @else
                        <p class="text-attr">Overall Rating: Not Available</p>
                    @endif
                </div>
            </div>
            <div class="media block-update-card" id="attach_detail">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/attach.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Attachments</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">View Attachments</p>
                </div>
            </div>
            <div class="media block-update-card" id="tickets-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/ticket.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Tickets</h4>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    {{--                <button class="btn btn-info" data-toggle="modal" data-target=".ticket-model"  type="button">Tickets History</button>--}}
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">View Ticket</p>
                </div>
            </div>
            <div class="media block-update-card" id="agreement-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/contract.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Bike Handling Agreement</h4>
                    <div class="row">
                        <div class="col-lg-6 bike_hand_div">
                            <div>
                                <a id="agreement-history">Agreement History </a>
                            </div>
                            <div class="mt-2">
                                <a id="agreement-upload">Agreement Upload </a>
                            </div>
                            <div class="mt-2">
                                <a id="agreement-new">Add New Agreement</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-side">
                                @if($bike_handle_route=='null')
                                    <a disabled> <i class="fa fa-print"></i></a>
                                @else
                                    <a href="{{$bike_handle_route}}"  target="_blank"><i class="fa fa-print"></i></a>
                                @endif
                                <br>
                                <br>
                                <a  id="creat-agreement" ><i class="i-Receipt-3"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card" id="agreement-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/ar_balance.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">A/R Balance</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php $current_balance = isset($first_balance->balance) ? $first_balance->balance : 0; ?>
                            @if(count($bal_detail)>0)
                                @foreach($bal_detail as $ar_res)
                                    @if($ar_res->status=='0')
                                        @php
                                            $current_balance = $current_balance+$ar_res->balance;
                                        @endphp
                                    @else
                                        @php
                                            $current_balance = $current_balance-$ar_res->balance;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            <p class="text-attr"> Balance : {{isset($current_balance)?$current_balance:"N/A"}}</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-side">
                                <a  id="ar_bal_detail" ><i class="i-Full-View-Window"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card" id="agreement-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/order-food.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Rider Order Detail</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-attr"> Total Orders : {{isset($rider_orders)?$rider_orders->sum('total_order'):""}}</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-side">
                                <a  id="rider_order" ><i class="i-Full-View-Window"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card" id="agreement-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/yes_sir.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Attendance</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-attr"> Today Attendance  </p>
                            <p class="text-attr">
                                @if(isset($attendance))
                                    @if($attendance->status=='1')
                                        <span style="color: #008000">Present</span>
                                    @elseif($attendance->status=='2')
                                        <span style="color: #0000ff">On Leave</span>
                                    @else
                                        <span style="color: #ff0000">Absent</span>
                                    @endif
                                @else
                                    <span style="color: #ff0000">Absent</span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-side">
                                <a  id="rider_attendance" ><i class="i-Full-View-Window"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card" id="agreement-call">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/user_agreement.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Agreement</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            @if($agreement_route=='null')
                                <p class="text-attr">No Agreement Signed</p>
                            @else
                                <a href="{{$agreement_route}}"  target="_blank"><i class="fa fa-print"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card" >
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/referral.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading">Refferal</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            @if($referal=='null')
                                <p class="text-attr">No Referral Available</p>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-side">
                                @if($referal !='null')
                                    <a id="referral" ><i class="i-Full-View-Window"></i> </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media block-update-card">
                <a class="pull-left" href="#" target="_blank">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/history.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <a class="media-heading" href="{{ route('rider_life_cycle',['passport_id'=> $passport_id]) }}" target="_blank"><h6 class="">Rider Activity Logs</h6></a>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Lorum Ipsum : {{$passport->passport_no}}</p>
                    <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>
                </div>
            </div>
            <div class="media block-update-card">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/salik.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h6 class="media-heading">Carrer Info</h6>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Lorum Ipsum : {{$passport->passport_no}}</p>
                    <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>
                </div>
            </div>
            <div class="media block-update-card">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/salik.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h6 class="media-heading">Bio Info</h6>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Lorum Ipsum : {{$passport->passport_no}}</p>
                    <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>
                </div>
            </div>
            <div class="media block-update-card">
                <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions bike-img" src="assets/images/icons/drawable/salik.png" alt="icon">
                </a>
                <div class="media-body update-card-body">
                    <h6 class="media-heading">Financial Info</h6>
                    <p id="passport_id" style="display: none">{{$passport_id}}</p>
                    <input type="hidden" name="pass_val" value="{{$passport_id}}" id="pass_val">
                    <p class="text-attr">Lorum Ipsum : {{$passport->passport_no}}</p>
                    <p class="text-attr">Lorem Ipsum : {{$passport->pp_uid}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{--    view Detail Passport modal--}}
<div class="modal fade bd-example-modal-lg" id="passport_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Passport Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive modal_table">
                            <h2>Passport Detail</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Nationality</th>
                                    <td><span >{{ isset($passport->nation->name) ? $passport->nation->name : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Country Code</th>
                                    <td><span>{{ isset($passport->country_code) ? $passport->country_code : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Passport Number</th>
                                    <td><span>{{ isset($passport->passport_no)?$passport->passport_no:'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>SurName</th>
                                    <td><span>{{ isset($passport->sur_name) ? $passport->sur_name : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Given Name</th>
                                    <td><span>{{ isset($passport->given_names) ? $passport->given_names : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Sex</th>
                                    <td><span>{{ isset($passport->sex) ? $passport->sex : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Father Name</th>
                                    <td><span>{{ isset($passport->father_name) ? $passport->father_name : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Date Of Birth</th>
                                    <td><span>{{ isset($passport->dob) ? $passport->dob : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Place of Birth</th>
                                    <td><span>{{ isset($passport->place_birth) ? $passport->place_birth : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Place of Issue</th>
                                    <td>{{ isset($passport->place_issue) ? $passport->place_issue : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Place of Issue</th>
                                    <td>{{ isset($passport->place_issue) ? $passport->place_issue : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Date of Issue</th>
                                    <td>{{ isset($passport->date_issue) ? $passport->date_issue : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Expiry Date</th>
                                    <td>{{ isset($passport->date_expiry) ? $passport->date_expiry : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Passport Scan Copy</th>
                                    <td>
                                        @if(isset($passport->passport_pic))
                                            <a  href="{{ url($passport->passport_pic) }}"  target="_blank">See Attachment</a>
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($passport->attach->attachment_name) && isset($passport->attachment_type->name))
                                    <tr>
                                        <th>{{ $passport->attachment_type->name }} Picture</th>
                                        <td><a  href="{{ url($passport->attach->attachment_name) }}" target="_blank">See Attachment</a></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="table-responsive modal_table">
                            <h2>National Detail</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Relation Name</th>
                                    <td><span>{{ isset($passport->personal_info->nat_name) ? $passport->personal_info->nat_name : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Relation</th>
                                    <td><span>{{ isset($passport->personal_info->nat_relation) ? $passport->personal_info->nat_relation : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>National Address</th>
                                    <td><span>{{ isset($passport->personal_info->nat_address) ? $passport->personal_info->nat_address : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>National Phone</th>
                                    <td><span>{{ isset($passport->personal_info->nat_phone) ? $passport->personal_info->nat_phone : 'N/A' }}</span></td>

                                </tr>
                                <tr>
                                    <th>National Whatsapp Number</th>
                                    <td><span>{{ isset($passport->personal_info->nat_whatsapp_no) ? $passport->personal_info->nat_whatsapp_no : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>National Email Address</th>
                                    <td><span>{{ isset($passport->personal_info->nat_email) ? $passport->personal_info->nat_email : 'N/A' }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive modal_table">
                            <h2>Passport Additional Detail</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Citizenship Number</th>
                                    <td><span>{{ isset($passport->citizenship_no) ? $passport->citizenship_no : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Personal Address</th>
                                    <td><span>{{ isset($passport->personal_address) ? $passport->personal_address : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Permanent Address</th>
                                    <td><span>{{ isset($passport->permanant_address) ? $passport->permanant_address : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Booklet Numebr</th>
                                    <td><span>{{ isset($passport->booklet_number) ? $passport->booklet_number : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Tracking Number</th>
                                    <td><span>{{ isset($passport->tracking_number) ? $passport->tracking_number : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Name of Mother</th>
                                    <td><span>{{ isset($passport->name_of_mother) ? $passport->name_of_mother : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Next Of Kind</th>
                                    <td><span>{{ isset($passport->next_of_kin) ? $passport->next_of_kin : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Relationship</th>
                                    <td><span>{{ isset($passport->relationship) ? $passport->relationship : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Middle Name</th>
                                    <td><span>{{ isset($passport->middle_name) ? $passport->middle_name : 'N/A' }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive modal_table">
                            <h2>Personal Details</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Personal Mobile</th>
                                    <td><span>{{ isset($passport->personal_info->personal_mob) ? $passport->personal_info->personal_mob : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Personal Email</th>
                                    <td><span>{{ isset($passport->personal_info->personal_email) ? $passport->personal_info->personal_email : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Personal Image</th>
                                    <td>
                                        @if(isset($passport->personal_info->personal_image))
                                            <a  href="{{ url($passport->personal_info->personal_image) }}" target="_blank">See Attachment</a>
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive modal_table">
                            <h2>International Details</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>International Name</th>
                                    <td><span>{{ isset($passport->personal_info->inter_name) ? $passport->personal_info->inter_name : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>International Relation</th>
                                    <td><span>{{ isset($passport->personal_info->inter_relation) ? $passport->personal_info->inter_relation : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>International Address</th>
                                    <td><span>{{ isset($passport->personal_info->inter_address) ? $passport->personal_info->inter_address : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>International Phone</th>
                                    <td><span>{{ isset($passport->personal_info->inter_phone) ? $passport->personal_info->inter_phone : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>International Whatsapp Number</th>
                                    <td><span>{{ isset($passport->personal_info->inter_whatsapp_no) ? $passport->personal_info->inter_whatsapp_no : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>International Email Address</th>
                                    <td><span>{{ isset($passport->personal_info->inter_email) ? $passport->personal_info->inter_email : 'N/A' }}</span></td>
                                </tr>
                            </table>
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
{{--    view Detail ID card Detail modal--}}
<div class="modal fade bd-example-modal-lg" id="emirates_id_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">ID Card  Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive modal_table">
                            <h2>Emirates ID Detail</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Card Number</th>
                                    <td><span >{{ isset($emirates_id->card_no) ? $emirates_id->card_no : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Expiry Date</th>
                                    <td><span>{{ isset($emirates_id->expire_date) ? $emirates_id->expire_date : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Front Picture</th>
                                    <td>
                                        @if(isset($emirates_id->card_front_pic))
                                            <a  href="{{Storage::temporaryUrl($emirates_id->card_front_pic, now()->addMinutes(5))}}"  target="_blank">View Front Side</a>
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Front Picture</th>
                                    <td>
                                        @if(isset($emirates_id->card_back_pic))
                                            <a  href="{{Storage::temporaryUrl($emirates_id->card_back_pic, now()->addMinutes(5))}}"  target="_blank">View back Side</a>
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
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
<div class="modal fade bd-example-modal-lg" id="driving_license_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Driving license Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive modal_table">
                            <h2>Driving License Detail</h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Driving Lincense Number</th>
                                    <td><span >{{ isset($driving_license->license_number) ? $driving_license->license_number : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Issue Date Date</th>
                                    <td><span>{{ isset($driving_license->issue_date) ? $driving_license->issue_date : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Expiry  Date</th>
                                    <td><span>{{ isset($driving_license->expire_date) ? $driving_license->expire_date : 'N/A' }}</span></td>
                                </tr>

                                <tr>
                                    <th>Place of Issue</th>
                                    <td><span>{{ isset($driving_license->place_issue) ? $driving_license->place_issue : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Traffic Code</th>
                                    <td><span>{{ isset($driving_license->traffic_code) ? $driving_license->traffic_code : 'N/A' }}</span></td>
                                </tr>
                            </table>
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
<div class="modal fade bd-example-modal-lg" id="user_code_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">User Codes Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive modal_table">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>ZDS Code</th>
                                    <td><span >{{ isset($user_code->zds_code) ? $user_code->zds_code : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>PPUID</th>
                                    <td><span>{{ isset($passport->pp_uid) ? $passport->pp_uid : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Visa Number</th>
                                    <td><span>{{ isset($visa_number->visa_number) ? $visa_number->visa_number : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Labour Card Number</th>
                                    <td><span>{{ isset($labour_card_number->labour_card_no) ? $labour_card_number->labour_card_no : 'N/A' }}</span></td>
                                </tr>
                            </table>
                            <table class="table table-bordered table-striped table-hover">
                                <tr class="bg-secondary text-white" style="padding:10px">
                                    <th>Platform Name</th>
                                    <th>Platform Code</th>
                                </tr>
                                @if(count($user_codes) > 0)
                                    @foreach($user_codes as $usercode_ab)
                                    <tr class="bg-success platform-update-histrory-heading text-white" data-row-class="platform-update-histrory-data-{{$usercode_ab->id}}" style="cursor: pointer; padding:10px">
                                        <td>
                                            {{ isset($usercode_ab->platform_name->name) ? $usercode_ab->platform_name->name : 'N/A' }}
                                        </td>
                                        <td>
                                            <span>{{ isset($usercode_ab->platform_code) ? $usercode_ab->platform_code: 'N/A' }}</span>
                                        </td>
                                    </tr>

                                    @if ($usercode_ab->update_histories->count() > 0)
                                        <tr class="platform-update-histrory-data platform-update-histrory-data-{{$usercode_ab->id}} text-white" style="display: none; background: rgb(34, 32, 11); padding:10px">
                                            <th>Platform Code Update history details ( {{$usercode_ab->platform_name->name}} )</th>
                                            <th>Updated By</th>
                                        </tr>
                                        @foreach ($usercode_ab->update_histories as $history)
                                        <tr class="platform-update-histrory-data platform-update-histrory-data-{{$usercode_ab->id}}" style="display: none; background: palegoldenrod; padding:10px ">
                                            <td>
                                                {{ "Platform code changed from " . $history->from  . " to " . $history->to . " on " . $history->created_at }}
                                            </td>
                                            <td>
                                                {{ $history->user->name }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @endforeach
                                @endif
                            </table>
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
{{------------------------------  cod modal  ---------------}}
<div class="modal fade bd-example-modal-lg" id="cod_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">COD Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12 " style="border-right:1px solid #e5e5e5">
                        <table class="table table-sm table-hover table-striped table-bordered text-10">
                            <thead>
                                <tr>
                                    <th>Platform Name</th>
                                    <th>Cod Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cod_balances as $balance)
                                <tr>
                                    <td>{{ ucFirst($balance['name'] ?? "NA") }}</td>
                                    <td>{{ number_format($balance['balance'] ?? 0, 2)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer col-12">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{------------------------------  Performance Modal   ---------------}}
<div class="modal fade bd-example-modal-lg" id="performance_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Perfomance Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-6 cod-main-div1" style="border-right:1px solid #e5e5e5">
                        <div class="cod-data">
                            <h2> <b>Performance </b></h2> <br>
                            @if($user_performance_dates =='1')
                                <p class="performance-p">
                                    Not Available
                                </p>
                            @else
                                @if(isset($user_performance_dates))
                                    @foreach($user_performance_dates as $date_range)
                                        <p class="performance-p">
                                            <i class="text-20 i-Calendar-4"></i>
                                            <span class="performance-content performance_val" id="{{$date_range->date_from}}">
                                                      <input type="hidden" name="per_val" value="{{$passport_id}}" id="per_val">
                                                    {{ isset($date_range->date_from) ? $date_range->date_from : 'N/A' }}
                                                                    -
                                                     {{ isset($date_range->date_to) ? $date_range->date_to : 'N/A' }}
                                                </span>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No Data Available</p>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-4 per-div2" style="display: none" >
                                <p class="per-p2">  <i class="text-20 i-Stopwatch icon-cls"></i> Hours Scheduled </p>
                                <p class="per-p2">  <i class="text-20 i-Sand-watch-2 icon-cls"></i> Hours Worked </p>
                                <p class="per-p2"> <i class="text-20 i-Book icon-cls"> </i> Attendance</p>
                                <p class="per-p2"> <i class="text-20 i-Bicycle icon-cls"></i> No of Orders Delivered</p>
                                <p class="per-p2"> <i class="text-20 i-Pen-5 icon-cls"></i> No of Orders Unassignedr</p>
                                <p class="per-p2"> <i class="text-20 i-Close-Window icon-cls"></i> Unassigned</p>
                                <p class="per-p2"> <i class="text-20 i-Stopwatch icon-cls"></i> Wait Time At Customer</p>
                                <p class="per-p2"> <i class="text-20 i-Sand-watch-2 icon-cls"></i> Rating</p>
                            </div>
                            <div class="col-sm-4 per-div3" id="show_performance">
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
<div class="modal fade right" id="exampleModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Cod Full History</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="cod_det_show">
                </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--------------------------attachment----------------}}
<div class="modal fade bd-example-modal-lg attach-md" id="attach_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-attach">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Attachment Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12 attachment-modal-div" style="border-right:1px solid #e5e5e5">
                        <div class="row items">
                            <p class="text-center" id="attachment-text"></p>
                            @if(!empty($user->passport->passport_pic))
                                <div class="col-md-3 mix" >
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Passport Picture</p>
                                            <a class="card-link" href="{{ url($user->passport->passport_pic) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->passport_pic) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->attach->attachment_name) && isset($user->passport->attachment_type->name))
                                <div class="col-md-3 mix" >
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">{{ $user->passport->attachment_type->name }} Picture</p>
                                            <a class="card-link" href="{{ url($user->passport->attach->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->attach->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->personal_info->personal_image))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Personal Picture</p>
                                            <a class="card-link" href="{{ url($user->passport->personal_info->personal_image) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->personal_info->personal_image) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Offer Letter Attachments</p>
                                            @if($user->passport->offer->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->offer->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->offer->visa_attachment)?url('assets/upload/offerLetter/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->offer->visa_attachment)?url('assets/upload/offerLetter/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Offer Letter Attachment 1</p>
                                            <a class="card-link" href="{{ url($user->passport->offer->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->offer->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer->attachment2))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Offer Letter Attachment 2</p>
                                            <a class="card-link" href="{{ url($user->passport->offer->attachment2) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->offer->attachment2) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer->attachment3))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Offer Letter Attachment 3</p>
                                            <a class="card-link" href="{{ url($user->passport->offer->attachment3) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->offer->attachment3) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{------------offer letter submission------------}}
                            @if(!empty($user->passport->offer_letter_submission->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Offer Letter Submission Attachment</p>
                                            @if($user->passport->offer_letter_submission->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->offer_letter_submission->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->offer_letter_submission->visa_attachment)?url('assets/upload/OfferLetterSubmission/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->offer_letter_submission->visa_attachment)?url('assets/upload/OfferLetterSubmission/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download"></i></span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{------------offer letter submission------------}}
                            @if(!empty($user->passport->offer_letter_submission->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left ">Offer Letter Submission Attachment 2</p>
                                            <a class="card-link" href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer_letter_submission->attachment2))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left ">Offer Letter Submission Attachment 3</p>
                                            <a class="card-link" href="{{ url($user->passport->offer_letter_submission->attachment2) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->offer_letter_submission->attachment2) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->offer_letter_submission->attachment3))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left ">Offer Letter Submission Attachment 3</p>
                                            <a class="card-link" href="{{ url($user->passport->offer_letter_submission->attachment3) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->offer_letter_submission->attachment3) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{----------------electronic pre approval---------------}}
                            @if(!empty($user->passport->elect_pre_approval->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Electronic Pre Approval</p>
                                            @if($user->passport->elect_pre_approval->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->elect_pre_approval->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->elect_pre_approval->visa_attachment)?url('assets/upload/electronic_pre_approval/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->elect_pre_approval->visa_attachment)?url('assets/upload/electronic_pre_approval/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download"></i></span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-----Electronic Pre Approval Payment------------}}
                            @if(!empty($user->passport->elect_pre_approval_payment->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Electronic Pre Approval Payment</p>
                                            @if($user->passport->elect_pre_approval_payment->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->elect_pre_approval_payment->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->elect_pre_approval_payment->visa_attachment)?url('assets/upload/ElectronicPreAppPay/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->elect_pre_approval_payment->visa_attachment)?url('assets/upload/ElectronicPreAppPay/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download"></i></span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->elect_pre_approval_payment->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Electronic Pre Approval Payment 2</p>
                                            <a class="card-link" href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{--------------------print visa inside---------------------------}}
                            @if(!empty($user->passport->print_visa_inside_outside->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Print Visa Inside/Outside</p>
                                            @if($user->passport->print_visa_inside_outside->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->print_visa_inside_outside->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->print_visa_inside_outside->visa_attachment)?url('assets/upload/EntryPrintOutSide/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->print_visa_inside_outside->visa_attachment)?url('assets/upload/EntryPrintOutSide/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download"></i></span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->print_visa_inside_outside->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Print Visa Inside/Outside</p>
                                            <a class="card-link" href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{------------------------Status Change/In-Out Status Change----------------------}}
                            @if(!empty($user->passport->status_change->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Status Change/In-Out Status Change</p>
                                            @if($user->passport->status_change->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->status_change->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->status_change->visa_attachment)?url('assets/upload/StatusChange/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a   href="{{isset($user->passport->status_change->visa_attachment)?url('assets/upload/StatusChange/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->status_change->attachment_name))
                                <div class="col-md-3 mix" >
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Status Change Proof</p>
                                            <a class="card-link" href="{{ url($user->passport->status_change->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->status_change->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->status_change->proof))
                                <div class="col-md-3 mix" >
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Status Change Proof</p>
                                            <a class="card-link" href="{{ url($user->passport->status_change->proof) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->status_change->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_normal->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical Normal</p>
                                            @if($user->passport->medical_normal->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->medical_normal->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->medical_normal->visa_attachment)?url('assets/upload/MedicalNormal/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->medical_normal->visa_attachment)?url('assets/upload/MedicalNormal/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_normal->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical Normal Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{--------------------------------------------medical 24-------------------------------}}
                            @if(!empty($user->passport->medical_twnenty_four->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical Normal</p>
                                            @if($user->passport->medical_twnenty_four->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->medical_twnenty_four->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->medical_twnenty_four->visa_attachment)?url('assets/upload/Medical24/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->medical_twnenty_four->visa_attachment)?url('assets/upload/Medical24/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_twnenty_four->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical Normal Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_fourty_eight->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical 48</p>
                                            @if($user->passport->medical_fourty_eight->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->medical_fourty_eight->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->medical_fourty_eight->visa_attachment)?url('assets/upload/Medical48/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->medical_fourty_eight->visa_attachment)?url('assets/upload/Medical48/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_fourty_eight->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical 48 Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- medical vip--}}
                            @if(!empty($user->passport->medical_vip->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical VIP</p>
                                            @if($user->passport->medical_vip->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->medical_vip->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->medical_vip->visa_attachment)?url('assets/upload/MedicalVIP/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->medical_vip->visa_attachment)?url('assets/upload/Medical48/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->medical_vip->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Medical VIP Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{----------------fit unfit---------------}}

                            @if(!empty($user->passport->fit_unfit->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">FIT UnFit Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}" target="_blank">See Full Image</a><br>
                                            <a   href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download">
                                                    </i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{------------------------ Emirates ID Apply-------------------------------------}}
                            @if(!empty($user->passport->emitres_id_apply->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Emirates ID Apply</p>
                                            @if($user->passport->emitres_id_apply->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->emitres_id_apply->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->emitres_id_apply->visa_attachment)?url('assets/upload/emirates_id_app/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->emitres_id_apply->visa_attachment)?url('assets/upload/emirates_id_app/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->emitres_id_apply->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">

                                        <div class="card-body">
                                            <p class="text-left">Emirates Id Apply Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon">
                                                        <i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{---------------------------emirates id apply----------------------------}}

                            {{--finter print--}}
                            @if(!empty($user->passport->emitres_id_apply->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Emirates ID Apply</p>
                                            @if($user->passport->emitres_id_apply->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->emitres_id_apply->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->emitres_id_apply->visa_attachment)?url('assets/upload/emirates_id_app/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->emitres_id_apply->visa_attachment)?url('assets/upload/emirates_id_app/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($user->passport->emitres_id_apply->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Emirates Id Apply Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon">
                                                        <i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- finger print --}}
                            @if(!empty($user->passport->finger_print->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Emirates ID Finger Print</p>
                                            @if($user->passport->finger_print->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->finger_print->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->finger_print->visa_attachment)?url('assets/upload/finger_print/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->finger_print->visa_attachment)?url('assets/upload/finger_print/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- New Contract Application Typing --}}
                            @if(!empty($user->passport->contract_typing->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">New Contract Application Typing</p>
                                            @if($user->passport->contract_typing->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->contract_typing->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->contract_typing->visa_attachment)?url('assets/upload/NewContractAppTyping/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->contract_typing->visa_attachment)?url('assets/upload/NewContractAppTyping/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($user->passport->contract_typing->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">New Contract Application Typing</p>
                                            <a class="card-link" href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon">
                                                        <i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($user->passport->contract_typing->proof))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left ">New Contract Application Typing Proof</p>
                                            <a class="card-link" href="{{ url($user->passport->contract_typing->proof) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->contract_typing->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{------Tawjeeh Class-----}}
                            @if(!empty($user->passport->tawjeeh_class->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Tawjeeh Class</p>
                                            @if($user->passport->tawjeeh_class->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->tawjeeh_class->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->tawjeeh_class->visa_attachment)?url('assets/upload/TawjeehClass/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->tawjeeh_class->visa_attachment)?url('assets/upload/TawjeehClass/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{------Tawjeeh Class ends-----}}
                            {{----------------------------new contract submission----------------------------------------------}}
                            @if(!empty($user->passport->new_contract_submission->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">New Contract Submission Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{----------------------------new contract submission ends----------------------------------------------}}

                            {{----------------------labour card--}}
                            @if(!empty($user->passport->labour_card_print->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Labour Card Print</p>
                                            @if($user->passport->labour_card_print->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->labour_card_print->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->labour_card_print->visa_attachment)?url('assets/upload/LabourCardPrint/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->labour_card_print->visa_attachment)?url('assets/upload/LabourCardPrint/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->labour_card_print->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Labour Card Print</p>
                                            <a class="card-link" href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon">
                                                        <i class="i-Download"></i>
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{----------------------labour card ends--}}


                            {{-- ---------visa stamping----------------}}
                            @if(!empty($user->passport->visa_stamping->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Visa Stamping</p>
                                            @if($user->passport->visa_stamping->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->visa_stamping->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->visa_stamping->visa_attachment)?url('assets/upload/VisaStamping/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->visa_stamping->visa_attachment)?url('assets/upload/VisaStamping/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->visa_stamping->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">

                                        <div class="card-body">
                                            <p class="text-left">Visa Stamping</p>
                                            <a class="card-link" href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon">
                                                        <i class="i-Download"></i>
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- ---------visa stamping ends----------------}}


                            {{--waiting for approval--}}

                            @if(!empty($user->passport->visa_approval->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Waiting for Approval</p>
                                            @if($user->passport->visa_approval->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->visa_approval->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->visa_approval->visa_attachment)?url('assets/upload/approval/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->visa_approval->visa_attachment)?url('assets/upload/approval/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{--waiting for approval ends--}}


                            {{--Waiting For Zajeel--}}
                            @if(!empty($user->passport->zajeel->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Waiting for Zajeel</p>
                                            @if($user->passport->zajeel->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->zajeel->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->zajeel->visa_attachment)?url('assets/upload/zajeel/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->zajeel->visa_attachment)?url('assets/upload/zajeel/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Waiting For Zajeel ends--}}

            {{-- silder2 --}}

                            {{--  visa pasted--}}
                            @if(!empty($user->passport->zajeel->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Waiting for Zajeel</p>
                                            @if($user->passport->zajeel->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->zajeel->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->zajeel->visa_attachment)?url('assets/upload/zajeel/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->zajeel->visa_attachment)?url('assets/upload/zajeel/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->visa_pasted->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">

                                        <div class="card-body">
                                            <p class="text-left">Visa Pasted Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->emirated_id_received->attachment->attachment_name))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Unique Emirates ID Received Attachment</p>
                                            <a class="card-link" href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}" target="_blank">See Attachment</a><br>
                                            <a   href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($user->passport->emirates_id_handover->visa_attachment))
                                <div class="col-md-3 mix">
                                    <div class="card mb-4 o-hidden">
                                        <div class="card-body">
                                            <p class="text-left">Emirates ID Handover</p>
                                            @if($user->passport->emirates_id_handover->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($user->passport->emirates_id_handover->visa_attachment) as $visa_attach)
                                                    <a class="card-link" href="{{isset($user->passport->emirates_id_handover->visa_attachment)?url('assets/upload/handover/'.$visa_attach):""}}" target="_blank">See Attachment</a><br>
                                                    <a href="{{isset($user->passport->emirates_id_handover->visa_attachment)?url('assets/upload/handover/'.$visa_attach):""}}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button">
                                                            <span class="ul-btn__icon">
                                                                <i class="i-Download">
                                                                </i>
                                                            </span></a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary  close-btn" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--    Tickets History Model--}}
{{--    <div class="modal ticket-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">--}}

{{----------------checkin modal------------------}}

{{--    view Detail Passport modal--}}
<div class="modal fade bd-example-modal-lg bike_mdl" id="check_detail_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content row">
            <div class="modal-header col-12">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body col-12">
                @if(empty($assign_bike))
                <div class="row">
                    <div class="form-group row col-md-5">
                        <input type="hidden" value="{{$passport_id}}" name="passport_id" id="passport_bike" value="">
                        <label for="bike_number" class="col-md-4">Bike</label>
                        <select id="bike_number" name="bike" class="form-control form-control-sm col-md-8"  required>
                            <option value=""  >Select option</option>
                            @foreach($bike_checkout as $bike)
                                <option value="{{ $bike->id }}">{{ $bike->plate_no}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row col-md-5">
                        <label for="checkin" class="col-md-4">Check In</label>
                        <input class="form-control form-control-sm col-md-8" id="checkin" name="checkin" type="datetime-local" required  />
                    </div>
                    <div class="form-group row col-md-2 float-right">
                        <button class="btn btn-primary btn-sm float-right " id="bike_checkin_save">Save</button>
                    </div>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_bikes">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Replacement Type</th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Checkin</th>
                                <th scope="col">Checkout</th>
                                <th scope="col">Remakrs</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($bikes as $bike)
                            <tr>
                                <td>Permenent</td>
                                <td>{{isset($bike->bike_plate_number->plate_no)?$bike->bike_plate_number->plate_no:"N/A"}} </td>
                                <td>{{isset($bike->checkin)?$bike->checkin:"N/A"}} </td>
                                <td>{{isset($bike->checkout)?$bike->checkout:"N/A"}} </td>
                                <td>{{isset($bike->remarks)?$bike->remarks:"N/A"}} </td>
                            </tr>
                        @endforeach
                        @foreach($temp_bikes as $bike)
                            <tr>
                                <td>Temporary</td>
                                <td>{{isset($bike->temporary_plate_number->plate_no)?$bike->temporary_plate_number->plate_no:"N/A"}} </td>
                                <td>{{isset($bike->replace_checkin)?$bike->replace_checkin:"N/A"}} </td>
                                <td>{{isset($bike->replace_checkout)?$bike->replace_checkout:"N/A"}} </td>
                                <td>{{isset($bike->replace_remarks)?$bike->replace_remarks:"N/A"}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer col-12">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="check_detail_modal_sim" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content row">
            <div class="modal-header col-md-12">
                <h5 class="modal-title" id="exampleModalCenterTitle">SIM Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body col-md-12">
                @if(empty($assign_sim))
                    <div id="assign-div" class="row">
                        <div class="row form-group col-md-4">
                            <label for="sim_number" class="col-md-4">SIM</label>
                            <input type="hidden" value="{{$passport_id}}" name="passport_id" id="passport_sim_id" value="">
                            <select id="sim_number" name="sim" class="form-control form-control-sm col-md-8" required>
                                <option value=""  >Select option</option>
                                @foreach($sim_checkout as $tel)
                                    <option value="{{ $tel->id }}">{{ $tel->account_number}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row form-group col-md-4">
                            <label for="assigned_to" class="col-md-4">Assigned To</label>
                            <select id="assigned_to" name="assigned_to" class="form-control form-control-sm col-md-8"  required>
                                <option value=""  >Select option</option>
                                @foreach($assign_type as $as_type)
                                    <option value="{{$as_type->id}}">{{$as_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row form-group col-md-4">
                            <label for="checkin-sim" class="col-md-4">Check In</label>
                            <input class="form-control form-control-sm col-md-8" id="checkin-sim" name="checkin-sim" type="datetime-local" required  />
                        </div>
                        <div class="row form-group col-md-2 offset-10">
                            <button class="btn btn-primary btn-sm" id="btn_checkin_sim">Save</button>
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_sim">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">SIM No</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Checkout</th>
                            <th scope="col">Remakrs</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($telecom as $sim2)
                            <tr>
                                <td>Permenent</td>
                                <td>{{isset($sim2->telecome->account_number)?$sim2->telecome->account_number:"N/A"}} </td>
                                <td>{{isset($sim2->checkin)?$sim2->checkin:"N/A"}} </td>
                                <td>{{$sim2->checkout}} </td>
                                <td>{{$sim2->remarks}} </td>
                            </tr>
                        @endforeach
                        @foreach($temp_sims as $sim2)
                        <tr>
                            <td>Temporary</td>
                            <td>{{isset($sim2->temporary_plate_number->account_number)?$sim2->temporary_plate_number->account_number:"N/A"}} </td>
                            <td>{{isset($sim2->replace_checkin)?$sim2->replace_checkin:"N/A"}} </td>
                            <td>{{$sim2->replace_checkout}} </td>
                            <td>{{$sim2->replace_remarks}} </td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer col-md-12">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--platform assgin--}}
<div class="modal fade bd-example-modal-lg" id="check_detail_modal_platform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content row">
            <div class="modal-header col-md-12">
                <h5 class="modal-title" id="exampleModalCenterTitle">Platform Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body col-md-12">
                @if(empty($assign_plat))
                    <div id="assign-div" class="row">
                        <div class="row col-md-4 form-group">
                            <input type="hidden" value="{{$passport_id}}" name="passport_ids_plat" id="passport_ids_plat" value="">
                            <label for="plateform" class="col-md-4">Platform</label>
                            <select id="plateform" name="plateform" class="form-control form-control-sm col-md-8" required>
                                <option value="">Select option</option>
                                @foreach($platforms_names as $plt)
                                    <option value="{{ $plt->id }}">{{ $plt->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row col-md-4 form-group">
                            <label for="checkin-plat" class="col-md-4">Check In</label>
                            <input class="form-control form-control-sm col-md-8" id="checkin-plat" name="checkin-plat" type="datetime-local" required  />
                        </div>
                        <div class="row col-md-4 form-group">
                            <button class="btn btn-sm btn-primary" id="btn_checkin_platform">Save</button>
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_platform">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Platform</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Checkout</th>
                            <th scope="col">Remakrs</th>
                        </tr>
                        </thead>
                        @foreach($platforms as $plat)
                            <tr>
                                <td>{{isset($plat->plateformdetail->name)?$plat->plateformdetail->name:"N/A"}} </td>
                                <td>{{isset($plat->checkin)?$plat->checkin:"N/A"}} </td>
                                <td>{{isset($plat->checkout)?$plat->checkout:"N/A"}} </td>
                                <td>{{isset($plat->remarks)?$plat->remarks:"N/A"}} </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="modal-footer col-md-12">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bike_handling_agreement" id="emirates_id_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Handing Agreement</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        {!! csrf_field() !!}
                        {{ method_field('GET') }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-1">
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Name</label>
                                    <input class="form-control form-control" id="full_name" @if(isset($bike_handling)) value="{{$bike_handling->full_name}}"
                                           @else
                                           value="{{isset($passport)?$passport->personal_info->full_name:""}}" @endif
                                           name="full_name" type="text" placeholder="Enter name"/>
                                    <input class="form-control form-control" id="p_id" value="{{isset($passport)?$passport->id:""}}" name="passport_id" type="hidden"/>
                                    <input class="form-control form-control" id="handle_id"  value="{{isset($bike_handling)?$bike_handling->id:"hand_id"}}" name="handle_id" type="hidden"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Nationality</label>
                                    @if(isset($bike_handling))
                                        <input type="hidden" id="nationality" name="nationality" value="{{isset($bike_handling)?$bike_handling->id:""}}">
                                    @endif
                                    <select id="nationality" name="nationality" class="form-control">
                                        <option value="{{$passport->nation_id}}">{{$passport->nation->name}}</option>
                                        @foreach($nation as $nat)
                                            @php
                                                $isSelected=(isset($bike_handling)?$bike_handling->nationality:"")==$nat->id;
                                            @endphp
                                            <option value="{{$nat->id}}" {{ $isSelected ? 'selected': '' }}>{{$nat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">DOB</label>
                                    <input   autocomplete="off" class="form-control form-control" @if(isset($bike_handling)) value="{{$bike_handling->dob}}"
                                             @else   value="{{isset($passport)?$passport->dob:""}}" @endif id="dob" name="dob" type="text" placeholder="Enter Date of Birth"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Emirates ID</label>
                                    <input class="form-control form-control"  @if(isset($bike_handling)) value="{{$bike_handling->emirates_id}}"
                                           @else value="{{isset($emirates_id)?$emirates_id->card_no:""}}" @endif
                                           id="emirates_id_agreement" name="emirates_id" type="text" placeholder="Enter Emirates ID"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Issue Date</label>
                                    <input class="form-control form-control" autocomplete="off" value="{{isset($bike_handling)?$bike_handling->emirates_issue_date:""}}"
                                           id="emirates_issue_date" name="emirates_issue_date" type="text" placeholder="Enter Issue Date"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Expiry Date</label>
                                    <input class="form-control form-control" autocomplete="offf" @if(isset($bike_handling)) value="{{$bike_handling->expiry_date}}"
                                           @else value="{{isset($emirates_id)?$emirates_id->expire_date:""}}" @endif id="expiry_date" name="expiry_date" type="text" placeholder="Enter Expiry Date"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Mobile Number</label>

                                    <input class="form-control form-control" @if(isset($bike_handling)) value="{{$bike_handling->mobile_number}}"
                                           @else value="{{isset($passport)?$passport->personal_info->personal_mob:""}}" @endif id="mobile_number" name="mobile_number" type="text" placeholder="Enter Mobile Number"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Email</label>
                                    <input class="form-control form-control" @if(isset($bike_handling)) value="{{$bike_handling->email}}"
                                           @else value="{{isset($passport)?$passport->personal_info->personal_email:""}}" @endif id="email" name="email" type="email" placeholder="Enter Email Address.."/>
                                </div>
                            </div>
                            <div class="col-md-6 form-group mb-1">
                                <div class="col-md-12 form-group mb-1">
                                    <h5>Driving Linces</h5>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Driving Linces Number</label>
                                    <input class="form-control form-control" @if(isset($bike_handling)) value="{{$bike_handling->license_number}}"
                                           @else   value="{{isset($driving_license->license_number)?$driving_license->license_number:""}}" @endif id="license_number" name="license_number" type="text" placeholder="Enter Driving Lincense number.."/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Place of Issue</label>
                                    <input class="form-control form-control"  @if(isset($bike_handling)) value="{{$bike_handling->place_issue}}"
                                           @else  value="{{isset($driving_license->place_issue)?$driving_license->place_issue:""}}" @endif id="place_issue_agree" name="place_issue" type="text" placeholder="Enter place of issue..."/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Date of Issue</label>
                                    <input class="form-control form-control" autocomplete="off"
                                           @if(isset($bike_handling)) value="{{$bike_handling->issue_date}}"
                                           @else  value="{{isset($driving_license->expire_date )?$driving_license->issue_date :""}}" @endif id="issue_date_agree" name="issue_date" type="text" placeholder="Enter date of issue"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Expiry Date</label>
                                    <input class="form-control form-control" autocomplete="off" @if(isset($bike_handling)) value="{{$bike_handling->expire_date}}"
                                           @else  value="{{isset($driving_license->expire_date )?$driving_license->expire_date :""}}" @endif id="expire_date_agree" name="expire_date" type="text" placeholder="Enter expiry date.."/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-1 ml-1">
                                <div class="col-md-12 form-group mb-1">
                                    <h5 style="text-align: center">Driving Linces</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Company</label>
                                        <input class="form-control form-control"  value="{{isset($bike_handling)?$bike_handling->company:""}}" id="company" name="company" type="text" placeholder="Enter Company"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Model Year</label>
                                        <input class="form-control form-control"  value="{{isset($bike_handling)?$bike_handling->model_year:""}}"  id="model_year" name="model_year" type="text" placeholder="Enter model year"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Type</label>
                                        <input class="form-control form-control"  value="{{isset($bike_handling)?$bike_handling->type:""}}" id="type" name="type" type="text" placeholder="Enter Type"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Plate No</label>
                                        <input class="form-control form-control"
                                               @if(isset($bike_handling)) value="{{$bike_handling->plate_no}}"
                                               @else   value="{{isset($assign_bike->bike_plate_number->plate_no)?$assign_bike->bike_plate_number->plate_no:""}}"  @endif id="plate_no" name="plat_no" type="text" placeholder="Enter plate number..."/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Color</label>
                                        <input class="form-control form-control" value="{{isset($bike_handling)?$bike_handling->color:""}}" id="color" name="color" type="text" placeholder="Enter color"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Location</label>
                                        <input class="form-control form-control" value="{{isset($bike_handling)?$bike_handling->location:""}}" id="location" name="location" type="text" placeholder="Enter location"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Departure Date & Time</label>
                                        <input class="form-control form-control" value="{{isset($bike_handling)?$bike_handling->dep_date:""}}" id="dep_date" name="dep_date" type="text" placeholder="Enter departure date and time"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" id="bike_handing_save">Save</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- --------Add new agreement----------------}}
<div class="modal fade bike_handling_new" id="emirates_id_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Handing Agreement</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        {!! csrf_field() !!}
                        {{ method_field('GET') }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-1">
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Name</label>
                                    <input class="form-control form-control" id="full_name"
                                           value="{{isset($passport)?$passport->personal_info->full_name:""}}"
                                           name="full_name" type="text" placeholder="Enter name"/>
                                    <input class="form-control form-control" id="p_id" value="{{isset($passport)?$passport->id:""}}" name="passport_id" type="hidden"/>
                                    <input class="form-control form-control" id="handle_id"  value="{{isset($bike_handling)?$bike_handling->id:"hand_id"}}" name="handle_id" type="hidden"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Nationality</label>
                                    <select id="nationality" name="nationality" class="form-control">
                                        <option value="{{$passport->nation_id}}">{{$passport->nation->name}}</option>
                                        @foreach($nation as $nat)
                                            @php
                                                $isSelected=(isset($bike_handling)?$bike_handling->nationality:"")==$nat->id;
                                            @endphp
                                            <option value="{{$nat->id}}" {{ $isSelected ? 'selected': '' }}>{{$nat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">DOB</label>
                                    <input   autocomplete="off" class="form-control form-control"    value="{{isset($passport)?$passport->dob:""}}"  id="dob" name="dob" type="text" placeholder="Enter Date of Birth"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Emirates ID</label>
                                    <input class="form-control form-control"  value="{{isset($bike_handling)?$bike_handling->emirates_id:""}}"
                                           id="emirates_id" name="emirates_id_agreement" type="text" placeholder="Enter Emirates ID"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Issue Date</label>
                                    <input class="form-control form-control" autocomplete="off" value="{{isset($bike_handling)?$bike_handling->emirates_issue_date:""}}"
                                           id="emirates_issue_date" name="emirates_issue_date" type="text" placeholder="Enter Issue Date"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Expiry Date</label>
                                    <input class="form-control form-control" autocomplete="offf" value="{{isset($bike_handling)?$bike_handling->expiry_date:""}}" id="expiry_date" name="expiry_date" type="text" placeholder="Enter Expiry Date"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Mobile Number</label>

                                    <input class="form-control form-control" value="{{isset($passport)?$passport->personal_info->personal_mob:""}}" id="mobile_number" name="mobile_number" type="text" placeholder="Enter Mobile Number"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Email</label>
                                    <input class="form-control form-control"  value="{{isset($passport)?$passport->personal_info->personal_email:""}}"  id="email" name="email" type="email" placeholder="Enter Email Address.."/>
                                </div>
                            </div>
                            <div class="col-md-6 form-group mb-1">
                                <div class="col-md-12 form-group mb-1">
                                    <h5>Driving Linces</h5>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Driving Linces Number</label>
                                    <input class="form-control form-control"    value="{{isset($driving_license->license_number)?$driving_license->license_number:""}}" id="license_number" name="license_number" type="text" placeholder="Enter Driving Lincense number.."/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Place of Issue</label>
                                    <input class="form-control form-control"   value="{{isset($driving_license->place_issue)?$driving_license->place_issue:""}}" id="place_issue_agree" name="place_issue" type="text" placeholder="Enter place of issue..."/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Date of Issue</label>
                                    <input class="form-control form-control" autocomplete="off" value="{{isset($driving_license->issue_date )?$driving_license->issue_date :""}}" id="issue_date_agree" name="issue_date" type="text" placeholder="Enter date of issue"/>
                                </div>
                                <div class="col-md-12 form-group mb-1">
                                    <label for="repair_category">Expiry Date</label>
                                    <input class="form-control form-control" autocomplete="off"  value="{{isset($driving_license->expire_date )?$driving_license->expire_date :""}}"  id="expire_date_agree" name="expire_date" type="text" placeholder="Enter expiry date.."/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-1">
                                <div class="col-md-12 form-group mb-1">
                                    <h5>Driving Linces</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Company</label>
                                        <input class="form-control form-control"  id="company" name="company" type="text" placeholder="Enter Company"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Model Year</label>
                                        <input class="form-control form-control"   id="model_year" name="model_year" type="text" placeholder="Enter model year"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Type</label>
                                        <input class="form-control form-control"   id="type" name="type" type="text" placeholder="Enter Type"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Plate No</label>
                                        <input class="form-control form-control"   id="plate_no" name="plat_no" type="text" placeholder="Enter plate number..."/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Color</label>
                                        <input class="form-control form-control"  id="color" name="color" type="text" placeholder="Enter color"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Location</label>
                                        <input class="form-control form-control"  id="location" name="location" type="text" placeholder="Enter location"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Departure Date & Time</label>
                                        <input class="form-control form-control" id="dep_date" name="dep_date" type="text" placeholder="Enter departure date and time"/>
                                    </div>
                                    <div class="col-md-6 form-group mb-1">
                                        <label for="repair_category">Expected return date and time</label>
                                        <input class="form-control form-control"  id="exp_date" name="exp_date" type="text" placeholder="Enter expected return date and time.."/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary btn-sm" id="bike_handing_save_new">Save</button>
                                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-------------Agreement History------------------}}
<div class="modal fade bike_handling_history" id="emirates_id_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Handing Agreement History</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_handle">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Agreement</th>
                        </tr>
                        </thead>
                        @php $count=1; @endphp
                        <tbody>
                            @foreach($bike_handlings as $handle)
                                @php $bike_handle_route_history = route('bike_handle_pdf',$handle->id); @endphp
                                <tr>
                                    <td> {{$count}} </td>
                                    <td> {{$handle->created_at}} </td>
                                    <td>
                                        <a href="{{$bike_handle_route_history}}"  target="_blank"><i class="fa fa-print"></i></a>
                                    </td>
                                </tr>
                                @php $count++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-------------Agreement upload------------------}}
<div class="modal fade bike_handling_upload" id="emirates_id_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Handing Agreement Upload</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="agreement_form_upload"  action="{{ url('upload_bike_handle') }}" method="POST" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <label for="repair_category" id="copy_label">Choose Scanned  Copy</label>
                        <input class="form-control" id="file_name" type="file" name="file_name"/>
                        <input value="{{isset($passport)?$passport->id:""}}"  type="hidden" name="passport_id"/>
                    </div>
                    <div class="col-md-12">
                        <label for="repair_category" id="copy_label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" placeholder="Enter Remarks" rows="5"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                <table class="display table table-striped table-bordered" id="datatable_upload">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date Upload</th>
                        <th scope="col">File</th>
                    </tr>
                    </thead>
                    @php
                        $count=1;
                    @endphp
                    <tbody>
                    @foreach($bike_handling_upload as $upload)
                        <tr>
                            <td> {{$count}} </td>
                            <td> {{$upload->created_at}} </td>
                            <td>
                                <a  href="{{isset($upload->file_path)?url($upload->file_path):""}}"
                                    id="scanned_image" target="_blank"><strong style="color: blue">
                                        View Scanned Copy
                                    </strong>
                                </a>
                            </td>
                        </tr>
                        @php $count++; @endphp
                    @endforeach
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------- Bike CheckOut Model---------->
<div class="modal fade" id="bike_checkout" tabindex="1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">Bike Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="bike_primary_id" name="primary_id_bike">
                    {!! csrf_field() !!}
                    {{ method_field('GET') }}
                    <label for="repair_category">Check Out</label>
                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />
                    <label for="repair_category">Remarks</label>
                    <input class="form-control form-control" id="remarks" name="remarks" type="text"   />
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary"  id="bike_checkout_save"> Save  </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------checkout model ends--------->
<!--------- Sim CheckOut Model---------->
<div class="modal fade" id="sim_checkout" tabindex="1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">SIM Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="sim_primary_id" name="sim_primary_id">
                    {!! csrf_field() !!}
                    {{ method_field('GET') }}
                    <label for="repair_category">Check Out</label>
                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />
                    <label for="repair_category">Remarks</label>
                    <input class="form-control form-control" id="remarks" name="remarks" type="text"   />
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary"  id="sim_checkout_save"> Save  </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------SIM checkout model ends--------->

<!--------- Bike Checkin CModel---------->
<div class="modal fade" id="bike_checkin_model" tabindex="1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">SIM Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="assign-div">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Bike</label>
                                <br>
                                <input type="text" name="passport_id" id="passport_bike" value="">
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Check IN</label>
                                <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required  />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="bike_checkin_save">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary"  id="sim_checkout_save"> Save  </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------SIM checkout model ends--------->

<!--------- platform CheckOut Model---------->
<div class="modal fade" id="plat_checkout" tabindex="1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">Platform Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="plat_primary_id" name="plat_primary_id">
                    {!! csrf_field() !!}
                    {{ method_field('GET') }}
                    <label for="repair_category">Check Out</label>
                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />
                    <label for="repair_category">Remarks</label>
                    <input class="form-control form-control" id="remarks" name="remarks" type="text"   />
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary"  id="plat_checkout_save"> Save  </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--------------------------------platform checkout end----------------------------}}


{{---------------------------AR Balance--}}
{{--    view Detail Passport modal--}}
<div class="modal fade ar_balance_modal" id="ar_balance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">AR Balance Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive modal_table">
                            <h2></h2>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Agreed Amount</th>
                                    <td><span >{{ isset($first_balance->agreed_amount) ? $first_balance->agreed_amount : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Cash Received</th>
                                    <td><span>{{ isset($first_balance->cash_received) ? $first_balance->cash_received : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td><span>{{ isset($first_balance->discount)?$first_balance->discount:'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Deduction</th>
                                    <td><span>{{ isset($first_balance->deduction) ? $first_balance->deduction : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>First Balance</th>
                                    <td><span>{{ isset($first_balance->balance) ? $first_balance->balance : 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Current Balance</th>
                                    <td><span>{{isset($current_balance)?$current_balance:"N/A"}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive modal_table">
                            <h2>Ar balance Sheet</h2>
                            <table class="table table-bordered table-striped" id="datatable_ar_balance" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <td>Date</td>
                                    <td>Balance Type</td>
                                    <td>Amount</td>
                                    <td>status</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ar_balance_sheet as $ar_res)
                                    <tr>
                                        <td>{{$ar_res->date_saved}}</td>
                                        <td>{{$ar_res->balance_name ? $ar_res->balance_name->name : "NA"}}</td>
                                        <td>{{$ar_res->balance}}</td>
                                        <td>
                                            @if($ar_res->status=='0')
                                                Added
                                            @else
                                                Substracted
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
{{------------------------rider order detail modal----------------}}
<div class="modal fade rider_order_modal" id="ar_balance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Rider Orders Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @if(isset($rider_orders))
                                @foreach($rider_orders as $res)
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="text-muted  text-center mb-2"><b>Start</b> {{$res->start_date_time}}</p>
                                                <p class="text-center text-18 font-weight-bold   mb-2" style="color: #0b2e13">Order:  {{$res->total_order}}</p>
                                                <p class="text-muted  text-center mb-2"><b>End</b> {{$res->end_date_time}}</p>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                @endforeach
                            @else
                                <p>No Data Available</p>
                            @endif
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
{{------------------------rider Attendance modal----------------}}
<div class="modal fade rider_attendance_modal" id="rider_attendance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Rider Attendance Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="datatable_attendance"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Date</th>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">Platform</th>
                                <th scope="col" style="width: 100px">Rider Code</th>
                                <th scope="col" style="width: 100px">Attendance Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attendance_detail as $row)
                                <tr>
                                    <td>{{$row->created_at}}</td>
                                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:""}}</td>
                                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:""}}</td>
                                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:""}}</td>
                                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:""}}</td>
                                    <td>{{isset($row->passport->platform->plateformdetail->name)?$row->passport->platform->plateformdetail->name:"N/A"}}</td>
                                    <td>{{isset($row->passport->rider_id->platform_code)?$row->passport->rider_id->platform_code:""}}</td>
                                    <td>Present</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--//---------Referral modal---------}}
<div class="modal fade refferal_modal" id="refferal_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Referral Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <table class="display table table-striped table-bordered" id="datatable-ref">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Referral Date</th>
                                    <th>Name</th>
                                    <th>Passport Number</th>
                                    <th>Driving License Number</th>
                                    <th>Driving Copy</th>
                                    <th>Status</th>
                                    <th>Reward Amount</th>
                                    <th>Reward Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($referal as $row)
                                    <tr>
                                        <td>{{isset($row->created_at)?$row->created_at->format('Y-m-d'):"N/A"}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->passport_no}}</td>
                                        <td>{{$row->driving_license}}</td>
                                        <td>
                                        @if($row->driving_attachment==null)
                                            <span style="color: blue">No Driving License Image</span>
                                        @else
                                            <a class="attachment_display" href="{{ isset($row->driving_attachment) ? url($row->driving_attachment) : ''  }}"  target="_blank">
                                                <strong style="color: blue">View</strong></a>
                                        @endif
                                        <td>
                                            @if($row->status=='0')
                                                Pending
                                            @elseif($row->status=='1')
                                                Interview
                                            @elseif($row->status=='2')
                                                Detail Collected
                                            @elseif($row->status=='3')
                                                Hired
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            {{isset($row->credit_amount)?$row->credit_amount:"N/A"}}
                                        </td>
                                        <td>
                                            @if($row->credit_status=='0')
                                                <span style="color: darkred">No Reward Yet</span>
                                            @elseif($row->credit_status=='1')
                                                <span style="color: green">Reward Collectable</span>
                                            @else
                                                <span style="color: green">Reward Collected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->credit_status=='1')
                                                <a class="text-success mr-2 action-btn" id="{{$row->id}}"><i class="nav-icon i-Add-Window font-weight-bold"></i></a>
                                            @elseif($row->credit_status=='2')
                                                <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
                                            @else
                                                <span class="font-weight-bold" style="color: #0a6aa1">No Reward Yet</span>
                                            @endif
                                            <a class="text-primary mr-2 view-btn" id="{{$row->passport_id}}"><i class="nav-icon i-Full-View-Window font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                <span><strong>Total Amount Paid =</strong>{{$referal->where('credit_status','2')->sum('credit_amount')}} </span><br>
                                <span><strong>Total Amount Payble =</strong>{{$referal->where('credit_status','0')->sum('credit_amount')}} </span>
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
{{----------------------reward collect status--------------------------}}
<div class="modal fade ref_modal" id="ref_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Change Reward Status to Reward Collected </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        {!! csrf_field() !!}
                        <input  id="referral_id" name="id"  type="hidden" required />
                        <h4 style="color: #000000">Are you sure want to add Reward status to Collected?</h4>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                            <button class="btn btn-primary" id="ref_reward">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ticket Information</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="main_modal_now"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade bd-example-modal-lg-visa_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="visa_show">

                </div>
            </div>
            <div class="modal-body" id="main_modal_now"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{----------------------reward collect status ends----------------------}}
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>

$('.platform-update-histrory-heading').click(function(){
    $('.platform-update-histrory-data').hide();
    var row_to_shown = $('.'+$(this).attr('data-row-class')).show();
});

</script>
<script>
    $('.action-btn').on('click', function() {
        var token = $("input[name='_token']").val();
        var id = $(this).attr('id');
        $('#referral_id').val(id);
        $('.ref_modal').modal('show');
    });
</script>

<script>
    $('#ref_reward').on('click', function() {
        var token = $("input[name='_token']").val();
        var id = $('#referral_id').val();
    $.ajax({
        url: "{{ route('profile_reward_collect') }}",
        method: 'POST',
        data: {id: id,"_token": "{{ csrf_token() }}"},
        success: function(response) {
            if(response=="success"){
                $('.refferal_modal').modal('hide');
                $('.ref_modal').modal('hide');
                tostr_display("success"," 'Credit Amount Status Changed to Collected',");

                    $("#apply_filter").trigger("click");
                }else{
                    $('.refferal_modal').modal('hide');
                    $('.ref_modal').modal('hide');
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    $("#agreement_form_upload").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            cache: false,
            url: url,
            processData: false,
            contentType: false,
            data: formData, // serializes the form's elements.
            success: function(response)
            {
                if(response=="success"){
                    $(".bike_handling_upload").modal('hide')
                    tostr_display("success","Bike Handling Agreement Uploaded Successfully");
                    $("#apply_filter").trigger("click");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    $('#datatable-ticket').DataTable( {
        // "aaSorting": [[0, 'desc']],
        "pageLength": 5,
        "bInfo" : false,
        language: {
            search: "",
            sLengthMenu: "Show _MENU_",
            searchPlaceholder: "Search..."
        }
    });
</script>

<script>
    $('.bikes_checkin').on('click',function() {
        $('#check_detail_modal').modal('show');
        var table = $('#datatable_bikes').DataTable({
            "order": [[ 2, "desc" ]], //or asc
            "columnDefs" : [{"targets":2, "type":"date-eu"}],

            paging: true,
            info: true,
            searching: true,
            autoWidth: false,
            retrieve: true
        });

        table.columns.adjust().draw();
        $('#bike_number').select2({
            placeholder: 'Select an option', width: '50%'
        });
    });
</script>
<script>
    $('#plateform').select2({
        placeholder: 'Select an option', width: '50%'
    });
</script>
<script>
    $(".sim_checkin").click(function () {
        $('#check_detail_modal_sim').modal('show');
        var table1 = $('#datatable_sim').DataTable({
            "order": [[ 2, "desc" ]], //or asc
            "columnDefs" : [{"targets":2, "type":"date-eu"}],
            paging: true,
            info: true,
            searching: true,
            autoWidth: false,
            retrieve: true
        });

        table1.columns.adjust().draw();
        $('#sim_number').select2({
            placeholder: 'Select an option', width: '50%'
        });
    });
</script>
<script>
    $(".platform_checkin").click(function () {
        $('#check_detail_modal_platform').modal('show');
        var table2 = $('#datatable_platform').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: false,
            retrieve: true
        });
        table2.columns.adjust().draw();
    });
</script>

<script>
    $('#creat-agreement').on('click',function() {
        $('.bike_handling_agreement').modal('show');
    });
</script>
<script>
    $('#agreement-new').on('click',function() {
        $('.bike_handling_new').modal('show');
    });
</script>

<script>
    $('#referral').on('click',function() {
        $('.refferal_modal').modal('show');
         var table = $('#datatable-ref').DataTable({
            paging: true,
            info: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>

<script>
    $('#agreement-history').on('click',function() {
        $('.bike_handling_history').modal('show');
        var table = $('#datatable_handle').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });

</script>
<script>
    $('#agreement-upload').on('click',function() {
        $('.bike_handling_upload').modal('show');
        var table = $('#datatable_upload').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });

</script>

<script>
    $('#ar_bal_detail').on('click',function() {
        $('.ar_balance_modal').modal('show');
        var table = $('#datatable_ar_balance').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: true,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>

<script>
    $('#rider_order').on('click',function() {
        $('.rider_order_modal').modal('show');
        var table = $('#datatable_ar_balance').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: true,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>
<script>
    $('#rider_attendance').on('click',function() {
        $('.rider_attendance_modal').modal('show');
        var table = $('#datatable_attendance').DataTable({
            paging: true,
            info: true,
            searching: true,
            autoWidth: true,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>

{{--    bike checkout--}}
<script>
    // bik_btn_cls
    $('#bike_handing_save').on('click', function() {
        var token = $("input[name='_token']").val();
        var id = $('#handle_id').val();
        var passport_id = $('#p_id').val();
        var full_name = $('#full_name').val();
        var nationality = $('#nationality').val();
        var dob = $('#dob').val();
        var emirates_id = $('#emirates_id_agreement').val();
        var emirates_issue_date = $('#emirates_issue_date').val();
        var expiry_date = $('#expiry_date').val();
        var mobile_number = $('#mobile_number').val();
        var email = $('#email').val();
        var license_number = $('#license_number').val();
        var place_issue = $('#place_issue_agree').val();
        var issue_date = $('#issue_date_agree').val();
        var expire_date = $('#expire_date_agree').val();
        var company = $('#company').val();
        var model_year = $('#model_year').val();
        var type = $('#type').val();
        var plate_no = $('#plate_no').val();
        var color = $('#color').val();
        var location = $('#location').val();
        var dep_date = $('#dep_date').val();
        var exp_date = $('#exp_date').val();

        $.ajax({
            url: "{{ route('bike_handling') }}",
            method: 'POST',
            data: {
                full_name: full_name,
                passport_id: passport_id,
                nationality: nationality,
                _token:token,
                dob:dob,
                emirates_id:emirates_id,
                emirates_issue_date:emirates_issue_date,
                expiry_date:expiry_date,
                mobile_number:mobile_number,
                email:email,
                license_number:license_number,
                place_issue:place_issue,
                issue_date:issue_date,
                expire_date:expire_date,
                company:company,
                model_year:model_year,
                type:type,
                plate_no:plate_no,
                color:color,
                location:location,
                dep_date:dep_date,
                exp_date:exp_date,
                id:id,
            },
            success: function(response) {
                if(response=="success"){
                    $(".bike_handling_agreement").modal('hide')
                    tostr_display("success","Bike Handling Agreement Addedd sucessfully");
                    $("#apply_filter").trigger("click");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });

</script>

{{--//add new agreement--}}
<script>
    // bik_btn_cls
    $('#bike_handing_save_new').on('click', function() {
        var token = $("input[name='_token']").val();
        var id = $('#handle_id').val();
        var passport_id = $('#p_id').val();
        var full_name = $('#full_name').val();
        var nationality = $('#nationality').val();
        var dob = $('#dob').val();
        var emirates_id = $('#emirates_id_agreement').val();
        var emirates_issue_date = $('#emirates_issue_date').val();
        var expiry_date = $('#expiry_date').val();
        var mobile_number = $('#mobile_number').val();
        var email = $('#email').val();
        var license_number = $('#license_number').val();
        var place_issue = $('#place_issue_agree').val();
        var issue_date = $('#issue_date_agree').val();
        var expire_date = $('#expire_date_agree').val();
        var company = $('#company').val();
        var model_year = $('#model_year').val();
        var type = $('#type').val();
        var plate_no = $('#plate_no').val();
        var color = $('#color').val();
        var location = $('#location').val();
        var dep_date = $('#dep_date').val();
        var exp_date = $('#exp_date').val();

        $.ajax({
            url: "{{ route('bike_handling_new') }}",
            method: 'POST',
            data: {full_name: full_name,
                passport_id: passport_id,
                nationality: nationality,
                _token:token,
                dob:dob,
                emirates_id:emirates_id,
                emirates_issue_date:emirates_issue_date,
                expiry_date:expiry_date,
                mobile_number:mobile_number,
                email:email,
                license_number:license_number,
                place_issue:place_issue,
                issue_date:issue_date,
                expire_date:expire_date,
                company:company,
                model_year:model_year,
                type:type,
                plate_no:plate_no,
                color:color,
                location:location,
                dep_date:dep_date,
                exp_date:exp_date,
                id:id,
            },
            success: function(response) {
                if(response=="success"){
                    $(".bike_handling_new").modal('hide')
                    tostr_display("success"," New Bike Handling Agreement Saved sucessfully");
                    $("#apply_filter").trigger("click");

                }else{
                    tostr_display("error",response);
                }
            }
        });
    });

</script>

<script>
    // bik_btn_cls
    $('#bike_checkout_save').on('click', function() {
        var token = $("input[name='_token']").val();
        var bike_primary_id = $('#bike_primary_id').val();
        var checkout = $('#checkout').val();
        var remarks = $('#remarks').val();
        $.ajax({
            url: "{{ route('profile_bike_checkout') }}",
            method: 'POST',
            data: {bike_primary_id: bike_primary_id,checkout: checkout, _token:token,remarks:remarks},
            success: function(response) {
                if(response=="success"){
                    tostr_display("success","Checked out sucessfully");
                    $("#bike_checkout").modal('hide')
                    $('#check_detail_modal').modal('hide');
                    $("#apply_filter").trigger("click");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>
<script>
    //sim checkout performs here
    $('#sim_checkout_save').on('click', function() {
        var token = $("input[name='_token']").val();
        var sim_primary_id = $('#sim_primary_id').val();
        var checkout = $('#checkout').val();
        var remarks = $('#remarks').val();
        $.ajax({
            url: "{{ route('profile_sim_checkout') }}",
            method: 'POST',
            data: {sim_primary_id: sim_primary_id,checkout: checkout, _token:token,remarks:remarks},
            success: function(response) {
                if(response=="success"){
                    tostr_display("success","Checked out sucessfully");
                    $("#sim_checkout").modal('hide')
                    $("#check_detail_modal_sim").modal('hide')
                    $("#apply_filter").trigger("click");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    // bik_btn_cls
    $('#bike_checkin_save').on('click', function() {
        var token = $("input[name='_token']").val();
        var passport_id = $('#passport_bike').val();
        var bike = $('#bike_number').val();
        var checkin = $('#checkin').val();
        $.ajax({
            url: "{{ route('profile_bike_assign') }}",
            method: 'POST',
            data: {passport_id: passport_id,bike: bike, _token:token,checkin:checkin},
            success: function(response) {
                if(response=="success"){
                    $("#check_detail_modal").modal('hide')
                    tostr_display("success","Bike Checkin sucessfully");
                    $("#apply_filter").trigger("click");
                    tostr_display("success","Bike Checkin sucessfully");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    $('#btn_checkin_sim').on('click', function() {
        var token = $("input[name='_token']").val();
        var passport_ids = $('#passport_sim_id').val();
        var sim = $('#sim_number').val();
        var assigned_to = $('#assigned_to').val();
        var checkin = $('#checkin-sim').val();
        $.ajax({
            url: "{{ route('profile_sim_assign') }}",
            method: 'POST',
            data: {passport_id: passport_ids,sim: sim, _token:token, checkin:checkin, assigned_to:assigned_to},
            success: function(response) {
                if(response=="success"){
                    $("#check_detail_modal_sim").modal('hide')
                    tostr_display("success","SIM Checkin successfully");
                    $("#apply_filter").trigger("click");
                    tostr_display("success","SIM Checkin successfully");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    $('#btn_checkin_platform').on('click', function() {
        var token = $("input[name='_token']").val();
        var passport_ids = $('#passport_ids_plat').val();
        var plateform = $('#plateform').val();
        var checkin = $('#checkin-plat').val();
        $.ajax({
            url: "{{ route('profile_plateform_assign') }}",
            method: 'POST',
            data: {passport_id: passport_ids,plateform: plateform, _token:token, checkin:checkin},
            success: function(response) {
                if(response=="success"){
                    $("#check_detail_modal_platform").modal('hide')
                    tostr_display("success","SIM Checkin successfully");
                    $("#apply_filter").trigger("click");
                    tostr_display("success","SIM Checkin successfully");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });
</script>

<script>
    $('#plat_checkout_save').on('click', function() {
        var token = $("input[name='_token']").val();
        var plat_primary_id = $('#plat_primary_id').val();
        var checkout = $('#checkout').val();
        var remarks = $('#remarks').val();
        $.ajax({
            url: "{{ route('profile_plat_checkout') }}",
            method: 'POST',
            data: {id: plat_primary_id,checkout: checkout, _token:token,remarks:remarks},
            success: function(response) {
                if(response=="success"){
                    tostr_display("success","Checked out sucessfully");
                    $("#check_detail_modal_platform").modal('hide')
                    $("#plat_checkout").modal().hide()
                    $("#apply_filter").trigger("click");
                }else{
                    tostr_display("error",response);
                }
            }
        });
    });

</script>

<script>
    $(".performance_val").click(function () {
        var pass_id = $("#per_val").val();
        var token = $("input[name='_token']").val();
        var type='3'
        var date_from = $(this).attr('id');
        $.ajax({
            url: "{{ route('ajax_performance_info') }}",
            method: 'POST',
            dataType: 'json',
            data: {pass_id: pass_id, date_from: date_from, _token: token},
            order: [[1, 'desc']],
            pageLength: 10,
            success: function (response) {
                var len = 0;
                if (response['data'] != null) {
                    len = response['data'].length;
                }
                var options = "";

                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        var hours_scheduled = response['data'][i].hours_scheduled;
                        var hours_worked = response['data'][i].hours_worked;
                        var attendance = response['data'][i].attendance;
                        var no_of_orders_delivered = response['data'][i].no_of_orders_delivered;
                        var no_of_orders_unassignedr = response['data'][i].no_of_orders_unassignedr;
                        var unassigned = response['data'][i].unassigned;
                        var wait_time_at_customer = response['data'][i].wait_time_at_customer;
                        var rating = response['data'][i].rating;
                        options+='<p  class="cod-p" >'+'<span class="per-content">'+hours_scheduled+'</span>'+'</p>'+
                            '<p  class="per-p" >'+ '<span class="per-content">'+hours_worked+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+attendance+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+no_of_orders_delivered+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+no_of_orders_unassignedr+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+unassigned+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+wait_time_at_customer+'</span>'+'</p>'+
                            '<p  class="per-p" >'+'<span class="per-content">'+rating+'</span>'+'</p>';
                    }
                    $("#show_performance").empty();
                    $("#show_performance").append(options);
                    $(".per-div2").show();
                } else {
                    $("#show_performance").empty();
                    $(".per-div2").empty();
                }
            }
        });
    });
</script>
<script>
    $(".ticket-card").click(function(){
        $("#unique_div").css('display','block');
        var id = $(this).attr('id');
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('ajax_ticket_info2') }}",
            method: 'POST',
            dataType: 'json',
            data: {id: id, _token: token},
            success: function (response) {
                $('#all-check').empty();
                $('#all-check').append(response.html);
            }
        });
    });
</script>

<script>
    $(document).on('click', '#cod_id', function(e) {
        var pass_id = $("#cod_pass_id").val();
        var type = '1';
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('full_cod_history') }}",
            method: 'POST',
            dataType: 'json',
            data: {pass_id: pass_id, type: type, _token: token},
            order: [[1, 'desc']],
            pageLength: 10,
            success: function (response) {
                $('#cod_det_show').empty();
                $('#cod_det_show').append(response.html);
                $('#exampleModalPreview').modal('hide');
                $('#exampleModalPreview').modal('show');
            }});});

    $(document).on('click', '#adj_id', function(e) {
        var pass_id = $("#cod_pass_id").val();
        var type = '2';
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('full_cod_history') }}",
            method: 'POST',
            dataType: 'json',
            data: {pass_id: pass_id, type: type, _token: token},
            order: [[1, 'desc']],
            pageLength: 10,
            success: function (response) {
                $('#cod_det_show').empty();
                $('#cod_det_show').append(response.html);
                $('#exampleModalPreview').modal('hide');
                $('#exampleModalPreview').modal('show');
            }
        });
    });

</script>
{{--showing bike checkout modal with  --}}
<script>
    $(document).on('click','.bik_btn_cls',function(){
        // $(".bik_btn_cls").click(function(){
        var ids = $(this).attr('id');
        $("#bike_primary_id").val(ids);
        $('#bike_checkout').modal('show');
    });
</script>
<script>
    $(document).on('click','.sim_btn_cls',function(){
        $(".sim_btn_cls").click(function(){
            var ids = $(this).attr('id');
            $("#sim_primary_id").val(ids);
            $('#sim_checkout').modal('show');
        });
    });
</script>
<script>
    $(document).on('click','.plat_btn_cls',function(){
        $(".plat_btn_cls").click(function(){
            var ids = $(this).attr('id');
            $("#plat_primary_id").val(ids);
            $('#plat_checkout').modal('show');
        });
    });
</script>
<script>
    $("#passport_detail").click(function(){
        $("#passport_detail_modal").modal('show');
    });
</script>
<script>
    $("#emirates_id").click(function(){
        $("#emirates_id_detail").modal('show');
    });
</script>
<script>
    $("#driving_license").click(function(){
        $("#driving_license_detail").modal('show');
    });
</script>
<script>
    $("#user_code").click(function(){
        $("#user_code_detail").modal('show');
    });
</script>
<script>
    $("#cod_detail").click(function(){
        $("#cod_detail_modal").modal('show');
    });
</script>
<script>
    $("#performance_detail").click(function(){
        $("#performance_detail_modal").modal('show');
    });
</script>
<script>
    $("#tickets-call").click(function(){
        // alert("asdfasd")
        //
        $("#performance_detail_modal2").modal('show');
    });
</script>
<script>
    $("#attach_detail").click(function(){
        $("#attach_detail_modal").modal('show');
    });
    if ($('.items').text().trim().length == 0) {
        $("#attachment-text").text("Attachments Not Available");
        $(".close-btn").css({"position": "relative","top":"670px"});
    }
    if ($('.cod-data').text().trim().length == 0) {
        alert("asdfasdf")
        $("#attachment-text1").text("Data Not Available");
    }
    if ($('.cod-main-div2').text().trim().length == 0) {
        $("#attachment-text2").text("Data Not Available");
    }
</script>
<script>
    $(".view_btn_cls").click(function(){
        var ids = $(this).attr('id');

        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('get_ticket_chat') }}",
            method: 'POST',
            data: {ticket_id: ids,type:'management', _token:token},
            success: function(response) {

                $('#main_modal_now').empty();
                $('#main_modal_now').append(response.html);
            }
        });
        $(".bd-example-modal-lg-history").modal('show');
    });
</script>

<script>
    $("#visa_det_btn").click(function(){

        var token = $("input[name='_token']").val();
        var passport_id = $("input[name='pass_val']").val();
        // alert('hghghghghghghghghhghghghghghghghghg');
        $.ajax({
            url: "{{ route('get_visa_profile_detail') }}",
            method: 'POST',
            data: {passport_id: passport_id, _token:token},
            success: function(response) {

                $('.visa_show').empty();
                $('.visa_show').append(response.html);
            }
        });
        $(".bd-example-modal-lg-visa_detail").modal('show');
    });
</script>
<script>
    tail.DateTime("#dob",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    });
</script>
<script>
    tail.DateTime("#emirates_issue_date",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    });
</script>
<script>
    tail.DateTime("#expiry_date",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    });
</script>
<script>
    tail.DateTime("#issue_date_agree",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    });
</script>
<script>
    tail.DateTime("#expire_date_agree",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    });
</script>
<script>

    tail.DateTime("#exp_date",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: "HH:ii:ss",
        position: "top"
    });
</script>
<script>
    tail.DateTime("#dep_date",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: "HH:ii:ss",
        position: "top"
    });

</script>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
}
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
