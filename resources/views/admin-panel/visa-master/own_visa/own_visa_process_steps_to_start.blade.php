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
    font-size: 11px;
    font-weight: bold;
}
.btn-file {
    padding: 0px;
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
                                    <h4 class="card-title mb-3">Own Visa Pending Processes</h4>
                                    <ul class="nav nav-tabs" id="dropdwonTab">
                                        <li class="nav-item"><a  class="nav-link active show tab-btn" id="offerletter-tab" data-toggle="tab" href="#offerletter" aria-controls="offerletter" aria-expanded="true">Contract Typing</a></li>
                                        <li class="nav-item"><a class="nav-link tab-btn" id="offerlettersubmission-tab" data-toggle="tab" href="#offerlettersubmission" aria-controls="offerlettersubmission" aria-expanded="false">Contract Submission</a></li>
                                        <li class="nav-item"><a class="nav-link tab-btn" id="electronicpreapproval-tab" data-toggle="tab" href="#electronicpreapproval" aria-controls="electronicpreapproval" aria-expanded="false">Labour Card Approval</a></li>

                                    </ul>

                                    <div class="tab-content px-1 pt-1" id="dropdwonTabContent">

                                        <div class="tab-pane active show" id="offerletter" role="tabpanel" aria-labelledby="offerletter-tab" aria-expanded="true">
                                            <h5><span class="badge badge-primary m-2 font-weight-bold">Visa process to start</span></h5>

                                            <table class="table table-striped" id="datatable">
                                                <thead class="table-dark">
                                                <tr class="t-row">
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Passport No</th>
                                                    <th>PPUID</th>
                                                    <td>Action</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter=1?>
                                                    @foreach ($own_visa_to_start as $row)

                                                    <tr>
                                                        <td>{{$counter}}</td>
                                                        <td>{{$row->personal_info->full_name}}</td>
                                                        <td>{{$row->passport_no}}</td>
                                                        <td>{{isset($row->pp_uid)?$row->pp_uid:'N/A'}}</td>

                                                            <td><a class="btn btn-primary btn-sm start-visa" href="{{ url('own_visa') }}?passport_id={{ $row->passport_no }}" target="_blank">Start Own Visa Process</a></td>



                                                    </tr>
                                                        <?php $counter++?>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>








                                        <div class="tab-pane" id="offerlettersubmission" role="tabpanel" aria-labelledby="offerlettersubmission-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 font-weight-bold">Contract Submission</span></h5>

                                            <div class="offer_sub_div"></div>
                                        </div>

                                        {{---------------------- status change starts--------------- --}}
                                        <div class="tab-pane" id="electronicpreapproval" role="tabpanel" aria-labelledby="electronicpreapproval-tab" aria-expanded="false">
                                            <h5><span class="badge badge-primary m-2 font-weight-bold">Labour Card Approval</span></h5>
                                            <div class="elec_pre_div"></div>
                                        </div>


                                                {{---------------------- status change ends--------------- --}}



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

            });
        });
    </script>


<script>
  $(document).on('click', '#offerlettersubmission-tab', function(){
                   var master_id='2';
                   var token = $("input[name='_token']").val();
                    $.ajax({
                        url: "{{ route('own_visa_sub') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{master_id:master_id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('.offer_sub_div').empty();
                            $('.elec_pre_div').empty();
                            $('.offer_sub_div').append(response.html);
                            $('.offer_sub_div').show();
                            $("body").removeClass("loading");

                            var table1 = $('#datatable-2').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                        }
                    });
                });
    </script>


<script>
    $(document).on('click', '#electronicpreapproval-tab', function(){
                     var master_id='3';
                     var token = $("input[name='_token']").val();
                      $.ajax({
                          url: "{{ route('own_visa_sub') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{master_id:master_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.elec_pre_div').empty();
                              $('.offer_sub_div').empty();
                              $('.elec_pre_div').append(response.html);
                              $('.elec_pre_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-3').DataTable({
                                "autoWidth": true,
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
