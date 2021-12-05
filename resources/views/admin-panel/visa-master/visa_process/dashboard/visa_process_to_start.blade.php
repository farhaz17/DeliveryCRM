@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 700;
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
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .btn-start {
       padding: 1px;
        }

        .submenu{
            display: none;
        }
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
        tr:hover {background-color:#d8d6d6;}
        th{  pointer-events: none;}

        .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #f44336;
    border-color: #f44336;
}

.step_name-text {

/* white-space: nowrap; */

}

.card.mb-4.step-cards {
max-height: 100px;
border: 1px solid gainsboro;
}

.tab-btn{
    padding: 1px;
    font-size: 11px;
    font-weight: bold;
}
.start-visa {
    padding: 1px;
    font-size: 10px;

}
.btn-file {
    padding: 0px;
}
.fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 10px;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 700;
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
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .btn-start {
       padding: 1px;
        }

        .submenu{
            display: none;
        }
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
        tr:hover {background-color:#d8d6d6;}
        th{  pointer-events: none;}

        .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #f44336;
    border-color: #f44336;
}
#company-1-tab{
background: black;
}

.step_name-text {

/* white-space: nowrap; */

}

.card.mb-4.step-cards {
max-height: 100px;
border: 1px solid gainsboro;
}

.tab-btn{
    padding: 1px;
    font-size: 11px;
    font-weight: bold;
}

.btn-file {
    padding: 0px;
}
/* .nav{
    padding-left: 50;
    padding-right: 10;
} */



/* .tab-main {

  width: 250px;
  height: 36px;

} */
.containter{
    display: flex;
  justify-content: center;
}
.add{
    color: #FF0000
}
#first-tab{
background: red;
}
#offerletter-tab{
background: black;
}
.nav-tabs .nav-item .nav-link {
    border: 0;
    padding: 0rem;
}
.btn-primary {
    padding:1px;
}

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Process Pendings!</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Visa Process Pendings</h4>
                                    <div class="row ml-3 mr-3">
                                    <div class="col-md-2"></div>
                                    <?php
                                    $x=count($data);
                                    $y=count($current_status_count->where('current_process_id','!=','27'));
                                    $total=$x+$y;
                                    ?>
                                    <div class="col-md-2"><h3><span class="badge badge-info w-badge">Total : {{$total}}</span></h3></div>
                                    <div class="col-md-2"><h3><span class="badge badge-danger w-badge">To Start : {{count($data)}}</span></h3></div>
                                    <div class="col-md-2"><h3><span class="badge badge-warning w-badge text-dark">In Process : {{count($current_status_count->where('current_process_id','!=','27'))}}</span></h3></div>
                                    <div class="col-md-2"><h3><span class="badge badge-success w-badge">Completed : {{count($current_status_count->where('current_process_id','27'))}}</span></h3></div>
                                    <div class="col-md-2"></div>
                                    </div>

                                    <ul class="nav nav-tabs containter mt-4" id="dropdwonTab">
                                        <?php  $vp_array = ['Admin','VisaProcessManager','VisaProcess']; ?>
                                        @hasanyrole($vp_array)
                                        <li class="nav-item"><a  class="nav-link active show text-white btn-primary  tab-main ml-2 mb-2 " id="offerletter-tab" data-toggle="tab" href="#offerletter" aria-controls="offerletter" aria-expanded="true">Offer Letter ({{count($data)}})</a></li>
                                        <li class="nav-item"><a class="nav-link  text-white btn-primary   tab-main ml-2 mb-2" id="offerlettersubmission-tab" data-toggle="tab" href="#offerlettersubmission" aria-controls="offerlettersubmission" aria-expanded="false">Offer Letter Submission ({{count($current_status_count->where('current_process_id','2'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="electronicpreapproval-tab" data-toggle="tab" href="#electronicpreapproval" aria-controls="electronicpreapproval" aria-expanded="false">Electronic Pre Approval ({{count($current_status_count->where('current_process_id','3'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="labourinsurance-tab" data-toggle="tab" href="#labourinsurance" aria-controls="labourinsurance" aria-expanded="false">Labour Card Insurance({{count($current_status_count->where('current_process_id','28'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="electronicpreapprovalpayment-tab" data-toggle="tab" href="#electronicpreapprovalpayment" aria-controls="electronicpreapprovalpayment" aria-expanded="false">Electronic Pre Approval Payment ({{count($current_status_count->where('current_process_id','4'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="printvisa-tab" data-toggle="tab" href="#printvisa" aria-controls="printvisa" aria-expanded="false">Print Visa Inside/Outside ({{count($current_status_count->where('current_process_id','5'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="status_change-tab" data-toggle="tab" href="#status_change" aria-controls="status_change" aria-expanded="false">  Status Change / In-out Change ({{count($current_status_count->where('current_process_id','7'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="medical-tab" data-toggle="tab" href="#medical" aria-controls="medical" aria-expanded="false">Medical ({{count($current_status_count->where('current_process_id','10'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="fitunfit-tab" data-toggle="tab" href="#fitunfit" aria-controls="fitunfit" aria-expanded="false">Fit/Unfit ({{count($current_status_count->where('current_process_id','14'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="emiratesidapply-tab" data-toggle="tab" href="#emiratesidapply" aria-controls="emiratesidapply" aria-expanded="false">Emirates ID Apply ({{count($current_status_count->where('current_process_id','15'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="emiratesidfinger-tab" data-toggle="tab" href="#emiratesidfinger" aria-controls="emiratesidfinger" aria-expanded="false">Emirates ID Finger Print(Yes/No) ({{count($current_status_count->where('current_process_id','16'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="newcontract-tab" data-toggle="tab" href="#newcontract" aria-controls="newcontract" aria-expanded="false">New Contract Application Typing ({{count($current_status_count->where('current_process_id','17'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="tawjeeh-tab" data-toggle="tab" href="#tawjeeh" aria-controls="tawjeeh" aria-expanded="false">Tawjeeh Class ({{count($current_status_count->where('current_process_id','18'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="newcontract_sub-tab" data-toggle="tab" href="#newcontract_sub" aria-controls="newcontract_sub" aria-expanded="false">New Contract Submission ({{count($current_status_count->where('current_process_id','19'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="labourcard-tab" data-toggle="tab" href="#labourcard" aria-controls="labourcard" aria-expanded="false">Labour Card Print ({{count($current_status_count->where('current_process_id','20'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="visastamping-tab" data-toggle="tab" href="#visastamping" aria-controls="visastamping" aria-expanded="false">Visa Stamping Application(Urgent/Normal) ({{count($current_status_count->where('current_process_id','21'))}})	</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="waitingfor-tab" data-toggle="tab" href="#waitingfor" aria-controls="waitingfor" aria-expanded="false">Waiting For Approval(Urgent/Normal) ({{count($current_status_count->where('current_process_id','22'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="waitingforzajeel-tab" data-toggle="tab" href="#waitingforzajeel" aria-controls="waitingforzajeel" aria-expanded="false">Waiting For Zajeel ({{count($current_status_count->where('current_process_id','23'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="visapasted-tab" data-toggle="tab" href="#visapasted" aria-controls="visapasted" aria-expanded="false">Visa Pasted ({{count($current_status_count->where('current_process_id','24'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary   tab-main ml-2 mb-2" id="uniquerec-tab" data-toggle="tab" href="#uniquerec" aria-controls="uniquerec" aria-expanded="false">Unique Emirates ID Received ({{count($current_status_count->where('current_process_id','25'))}})</a></li>
                                        <li class="nav-item"><a class="nav-link text-white btn-primary  tab-main ml-2 mb-2" id="uniquehandover-tab" data-toggle="tab" href="#uniquehandover" aria-controls="uniquehandover" aria-expanded="false">Unique Emirates ID Handover (Complete) ({{count($current_status_count->where('current_process_id','26'))}})</a></li>
                                      @endhasallroles
                                      <?php  $vp_array_cr = ['VisaProcessEmiratesIdHandover','Admin','VisaProcessManager','VisaProcess']; ?>
                                      @hasanyrole($vp_array_cr)
                                        <li class="nav-item"><a class="nav-link text-white btn-primary  tab-main ml-2 mb-2" id="complete-tab" data-toggle="tab" href="#complete" aria-controls="complete" aria-expanded="false">Complete ({{count($current_status_count->where('current_process_id','27'))}})</a></li>
                                        @endhasallroles
                                    </ul>

                                    <div class="tab-content px-1 pt-1" id="dropdwonTabContent">

                                        <div class="tab-pane active show" id="offerletter" role="tabpanel" aria-labelledby="offerletter-tab" aria-expanded="true">
                                            <h5><span class="badge badge-primary m-2 ">Visa process to start</span></h5>

                                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable">
                                                <thead>
                                                <tr class="t-row">
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Passport No</th>
                                                    <th scope="col">PPUID</th>
                                                    <th scope="col">Payment Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($data as $res)
                                                    <?php $passport_no=$res['passport_id'] ?>
                                                    <tr>
                                                        <td>{{$res['name']}}</td>
                                                        <td>{{$res['pass_no']}}</td>
                                                        <td>{{$res['pp_uid']}}</td>
                                                        <td>
                                                            @if ($res['payment_status']=='Paid')
                                                            <span class="badge badge-success m-2 ">{{$res['payment_status']}}</span>
                                                            @elseif($res['payment_status']=='Payroll Deduction')
                                                            <span class="badge badge-warning m-2 ">{{$res['payment_status']}}</span>
                                                            @elseif($res['payment_status']=='Unpaid')
                                                            <span class="badge badge-danger m-2 ">{{$res['payment_status']}}</span>

                                                            @else
                                                            <span class="badge badge-primary m-2 ">{{$res['payment_status']}}</span>
                                                            @endif
                                                           </td>
                                                            <td>
                                                                <a class="btn btn-primary btn-sm start-visa" href="{{ url('visa_process') }}?passport_id={{ $passport_no }}" target="_blank">Start Visa Process</a></td>


                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>








                                        <div class="tab-pane" id="offerlettersubmission" role="tabpanel" aria-labelledby="offerlettersubmission-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Offer Letter Submission</span></h5>

                                            <div class="offer_sub_div"></div>
                                        </div>

                                        {{---------------------- status change starts--------------- --}}

                                        <div class="tab-pane" id="status_change" role="tabpanel" aria-labelledby="status_change-tab" aria-expanded="true">
                                            <h5><span class="badge badge-primary m-2 "> Change Status</span></h5>

                                            <div class="status_change_div"></div>
                                        </div>

                                                {{---------------------- status change ends--------------- --}}

                                                <div class="tab-pane" id="electronicpreapproval" role="tabpanel" aria-labelledby="electronicpreapproval-tab" aria-expanded="false">
                                                    <h5><span class="badge badge-primary m-2 ">Electronic Pre Approval</span></h5>
                                                    <div class="elec_pre_div"></div>
                                                </div>
                                                <div class="tab-pane" id="labourinsurance" role="tabpanel" aria-labelledby="labourinsurance-tab" aria-expanded="false">
                                                    <h5><span class="badge badge-primary m-2 ">Labour Insurance</span></h5>
                                                    <div class="labour_ins_div"></div>
                                                </div>



                                        <div class="tab-pane" id="electronicpreapprovalpayment" role="tabpanel" aria-labelledby="electronicpreapprovalpayment-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Electronic Pre Approval Payment</span></h5>

                                            <div class="elec_pre_pay_div"></div>
                                        </div>


                                        <div class="tab-pane" id="printvisa" role="tabpanel" aria-labelledby="printvisa-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Print Visa Inside/Outside</span></h5>

                                            <div class="printvisa_div"></div>
                                        </div>

                                        <div class="tab-pane" id="entrydate" role="tabpanel" aria-labelledby="entrydate-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Entry Date</span></h5>
                                            <div class="entry_date_div"></div>
                                        </div>




                                     <div class="tab-pane" id="medical" role="tabpanel" aria-labelledby="medical-tab" aria-expanded="false">
                                        <h5><span class="badge badge-primary m-2 ">Medical</span></h5>
                                        <div class="medical_div"></div>
                                    </div>


                                        <div class="tab-pane" id="fitunfit" role="tabpanel" aria-labelledby="fitunfit-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Fit/Unfit</span></h5>
                                            <div class="fitunfit_div"></div>
                                        </div>


                                        <div class="tab-pane" id="emiratesidapply" role="tabpanel" aria-labelledby="emiratesidapply-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Emirates ID Apply</span></h5>
                                            <div class="emiratesidapply_div"></div>
                                        </div>


                                        <div class="tab-pane" id="emiratesidfinger" role="tabpanel" aria-labelledby="emiratesidfinger-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Emirates ID Finger Print(Yes/No)</span></h5>
                                            <div class="emiratesidfinger_div"></div>
                                        </div>


                                        <div class="tab-pane" id="newcontract" role="tabpanel" aria-labelledby="newcontract-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">New Contract Application Typing</span></h5>
                                            <div class="newcontract_div"></div>
                                        </div>


                                        <div class="tab-pane" id="tawjeeh" role="tabpanel" aria-labelledby="tawjeeh-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Tawjeeh Class</span></h5>
                                            <div class="tawjeeh_div"></div>
                                        </div>


                                        <div class="tab-pane" id="newcontract_sub" role="tabpanel" aria-labelledby="newcontract_sub-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">New Contract Submission</span></h5>
                                            <div class="newcontract_sub_div"></div>
                                        </div>


                                        <div class="tab-pane" id="labourcard" role="tabpanel" aria-labelledby="labourcard-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Labour Card Print</span></h5>
                                            <div class="labourcard_div"></div>
                                        </div>


                                        <div class="tab-pane" id="visastamping" role="tabpanel" aria-labelledby="labourcard-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 ">Visa Stamping Application(Urgent/Normal)</span></h5>
                                            <div class="visastamping_div"></div>
                                        </div>



                                        <div class="tab-pane" id="waitingfor" role="tabpanel" aria-labelledby="labourcard-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Waiting For Approval(Urgent/Normal)</span></h5>
                                            <div class="waitingfor_div"></div>
                                        </div>




                                        <div class="tab-pane" id="waitingforzajeel" role="tabpanel" aria-labelledby="labourcard-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Waiting For Zajeel</span></h5>
                                            <div class="waitingforzajeel_div"></div>
                                        </div>




                                        <div class="tab-pane" id="visapasted" role="tabpanel" aria-labelledby="labourcard-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Visa Pasted</span></h5>
                                            <div class="visapasted_div"></div>
                                        </div>



                                        <div class="tab-pane" id="uniquerec" role="tabpanel" aria-labelledby="uniquerec-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Unique Emirates ID Received</span></h5>
                                            <div class="uniquerec_div"></div>
                                        </div>



                                        <div class="tab-pane" id="uniquehandover" role="tabpanel" aria-labelledby="uniquehandover-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Unique Emirates ID Handover</span></h5>
                                            <div class="uniquehandover_div"></div>
                                        </div>


                                          <div class="tab-pane" id="complete" role="tabpanel" aria-labelledby="complete-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 "> Complete Visa Process</span></h5>
                                            <div class="complete_div"></div>
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

            <div class="overlay"></div>
{{-- -------------- visa process modals----------------- --}}
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>




    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Offer Letter',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

            });
        });
    </script>


<script>
  $(document).on('click', '#offerlettersubmission-tab', function(){
                   var master_id='3';
                   var token = $("input[name='_token']").val();
                   $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "black");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                    $.ajax({
                        url: "{{ route('visa_process_get_remaining') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{master_id:master_id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('.offer_sub_div').empty();
                            $('.offer_sub_div').append(response.html);
                            $('.offer_sub_div').show();
                            $("body").removeClass("loading");

                            var table1 = $('#datatable-3').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Offer Letter Submission',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                        }
                    });
                });
    </script>



<script>
    $(document).on('click', '#offerletter-tab', function(){
                     var master_id='2';
                     var token = $("input[name='_token']").val();

                     $("#offerletter-tab").css("background-color", "black");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "#663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");

                  });
      </script>


<script>
    $(document).on('click', '#electronicpreapproval-tab', function(){
                     var master_id='4';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "black");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "#663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.elec_pre_div').empty();
                              $('.elec_pre_div').append(response.html);
                              $('.elec_pre_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-4').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Electronic Pre Approval',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#labourinsurance-tab', function(){
                     var master_id='28';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "black");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                   $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.labour_ins_div').empty();
                              $('.labour_ins_div').append(response.html);
                              $('.labour_ins_div').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-28').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Electronic Pre Approval',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>




<script>
    $(document).on('click', '#electronicpreapprovalpayment-tab', function(){
                     var master_id='5';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "black");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.elec_pre_pay_div').empty();
                              $('.elec_pre_pay_div').append(response.html);
                              $('.elec_pre_pay_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-5').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Electrinic Pre Approval Payment',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#printvisa-tab', function(){
                     var master_id='6';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "black");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.printvisa_div').empty();
                              $('.printvisa_div').append(response.html);
                              $('.printvisa_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-6').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Print Visa Inside Out Side',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>





<script>
    $(document).on('click', '#status_change-tab', function(){
                     var master_id='8';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "black");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.status_change_div').empty();
                              $('.status_change_div').append(response.html);
                              $('.status_change_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-8').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Status Change',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>






<script>
    $(document).on('click', '#entrydate-tab', function(){
                     var master_id='10';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "black");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.entry_date_div').empty();
                              $('.entry_date_div').append(response.html);
                              $('.entry_date_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-10').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Entry Date',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#medical-tab', function(){
                     var master_id='11';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "black");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.medical_div').empty();
                              $('.medical_div').append(response.html);
                              $('.medical_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-11').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Medical',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#fitunfit-tab', function(){
                     var master_id='15';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "black");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.fitunfit_div').empty();
                              $('.fitunfit_div').append(response.html);
                              $('.fitunfit_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-15').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Fit Unfit',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#emiratesidapply-tab', function(){
                     var master_id='16';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "black");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.emiratesidapply_div').empty();
                              $('.emiratesidapply_div').append(response.html);
                              $('.emiratesidapply_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-16').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Emirates ID Apply',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#emiratesidfinger-tab', function(){
                     var master_id='17';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "black");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.emiratesidfinger_div').empty();
                              $('.emiratesidfinger_div').append(response.html);
                              $('.emiratesidfinger_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-17').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Emirates ID Finger print',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#newcontract-tab', function(){
                     var master_id='18';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "black");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.newcontract_div').empty();
                              $('.newcontract_div').append(response.html);
                              $('.newcontract_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-18').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'New Contract',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#tawjeeh-tab', function(){
                     var master_id='19';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "black");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.tawjeeh_div').empty();
                              $('.tawjeeh_div').append(response.html);
                              $('.tawjeeh_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-19').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Tawjeeh',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#newcontract_sub-tab', function(){
                     var master_id='20';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "black");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.newcontract_sub_div').empty();
                              $('.newcontract_sub_div').append(response.html);
                              $('.newcontract_sub_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-20').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'New Contract Submission',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#labourcard-tab', function(){
                     var master_id='21';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "black");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.labourcard_div').empty();
                              $('.labourcard_div').append(response.html);
                              $('.labourcard_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-21').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Labour Card',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#visastamping-tab', function(){
                     var master_id='22';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "black");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.visastamping_div').empty();
                              $('.visastamping_div').append(response.html);
                              $('.visastamping_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-22').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Visa Stamping',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#waitingfor-tab', function(){
                     var master_id='23';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "black");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.waitingfor_div').empty();
                              $('.waitingfor_div').append(response.html);
                              $('.waitingfor_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-23').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Waiting for Approval',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#waitingforzajeel-tab', function(){
                     var master_id='24';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "black");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.waitingforzajeel_div').empty();
                              $('.waitingforzajeel_div').append(response.html);
                              $('.waitingforzajeel_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-24').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Waiting for Zajeel',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#visapasted-tab', function(){
                     var master_id='25';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "black");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.visapasted_div').empty();
                              $('.visapasted_div').append(response.html);
                              $('.visapasted_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-25').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Visa Pasted',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#uniquerec-tab', function(){
                     var master_id='26';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "black");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                     $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.uniquerec_div').empty();
                              $('.uniquerec_div').append(response.html);
                              $('.uniquerec_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-26').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Emirated ID Receive',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#uniquehandover-tab', function()
    {
                     var master_id='27';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "black");
                    $("#complete-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.uniquehandover_div').empty();
                              $('.uniquehandover_div').append(response.html);
                              $('.uniquehandover_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-27').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Emirates ID Handover',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


      <script>
    $(document).on('click', '#complete-tab', function()
    {
                     var master_id='29';
                     var token = $("input[name='_token']").val();
                     $("#offerletter-tab").css("background-color", "#663399");
                   $("#offerlettersubmission-tab").css("background-color", "#663399");
                   $("#electronicpreapproval-tab").css("background-color", "#663399");
                   $("#labourinsurance-tab").css("background-color", "#663399");
                   $("#electronicpreapprovalpayment-tab").css("background-color", "663399");
                   $("#printvisa-tab").css("background-color", "#663399");
                   $("#status_change-tab").css("background-color", "#663399");
                   $("#medical-tab").css("background-color", "#663399");
                   $("#fitunfit-tab").css("background-color", "#663399");
                   $("#emiratesidapply-tab").css("background-color", "#663399");
                   $("#emiratesidfinger-tab").css("background-color", "#663399");
                   $("#newcontract-tab").css("background-color", "#663399");
                   $("#tawjeeh-tab").css("background-color", "#663399");
                   $("#newcontract_sub-tab").css("background-color", "#663399");
                   $("#labourcard-tab").css("background-color", "#663399");
                   $("#visastamping-tab").css("background-color", "#663399");
                   $("#waitingfor-tab").css("background-color", "#663399");
                   $("#visapasted-tab").css("background-color", "#663399");
                   $("#waitingforzajeel-tab").css("background-color", "#663399");
                   $("#uniquerec-tab").css("background-color", "#663399");
                   $("#uniquehandover-tab").css("background-color", "#663399");
                   $("#complete-tab").css("background-color", "black");
                      $.ajax({
                          url: "{{ route('visa_process_get_remaining') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.complete_div').empty();
                              $('.complete_div').append(response.html);
                              $('.complete_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-29').DataTable({
                                "autoWidth": true,
                                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Visa Process Complete',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('id'); // get current tab
            var split_ab = currentTab;
            if(split_ab=="offerletter-tab"){
                var table = $('#datatable').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }  if(split_ab=="offerlettersubmission-tab"){
                var table = $('#datatable-3').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }if(split_ab=="electronicpreapproval-tab"){
                var table = $('#datatable-4').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="electronicpreapprovalpayment-tab"){
                var table = $('#datatable-6').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="printvisa-tab"){
                var table = $('#datatable-6').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="entrydate-tab"){
                var table = $('#datatable-10').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }

            if(split_ab=="medical-tab"){
                var table = $('#datatable-11').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }


            if(split_ab=="fitunfit-tab"){
                var table = $('#datatable-15').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="emiratesidapply-tab"){
                var table = $('#datatable-16').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="emiratesidfinger-tab"){
                var table = $('#datatable-17').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="newcontract-tab"){
                var table = $('#datatable-18').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="tawjeeh-tab"){
                var table = $('#datatable-19').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="newcontract_sub-tab"){
                var table = $('#datatable-20').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="labourcard-tab"){
                var table = $('#datatable-21').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="visastamping-tab"){
                var table = $('#datatable-22').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="waitingfor-tab"){
                var table = $('#datatable23').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="waitingforzajeel-tab"){
                var table = $('#datatable24').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="visapasted-tab"){
                var table = $('#datatable25').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            if(split_ab=="uniquerec-tab"){
                var table = $('#datatable26').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }

            else{
                var table = $('#datatable26').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw()

            }


        }) ;
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
