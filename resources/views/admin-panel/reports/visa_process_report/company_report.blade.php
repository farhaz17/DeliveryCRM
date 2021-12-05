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
.containter{
    display: flex;
  justify-content: center;
}

#company-1-tab{
background: black;
}

#started-tab{
background: red;
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
    <div class="separator-breadcrumb border-top">

    </div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Visa Process Stages</h4>
                                    <ul class="nav nav-tabs" id="dropdwonTab">
                                        @foreach($companies as $res)
                                        <li class="nav-item">
                                            <a  class="nav-link @if($res->id=='1') active show  @else  @endif text-white btn-primary  ml-2 mb-2" style="padding:5px"  id="company-{{$res->id}}-tab" data-toggle="tab" href="#company-{{$res->id}}"
                                                 aria-controls="company-{{$res->id}}" aria-expanded="true">
                                               {{$res->name}}

                                            </a>
                                        </li>
                                                @endforeach
                                    </ul>

                                    <div class="tab-content px-1 pt-1" id="dropdwonTabContent">


                                        @foreach($companies as $res)

                                        <div class="tab-pane @if($res->id=='1') active show @else @endif" id="company-{{$res->id}}" role="tabpanel"
                                             aria-labelledby="company-{{$res->id}}-tab" aria-expanded="true">
                                            {{-- <h5><span class="badge badge-primary m-2 font-weight-bold">Visa process to start</span></h5> --}}
                                            <div class="company_div-{{$res->id}}">
                                            <ul class="nav nav-tabs  containter" id="dropdwonTab1">
                                                <li class="nav-item"><a  class="nav-link active show tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="started-tab" data-toggle="tab" href="#started" aria-controls="started" aria-expanded="true">Started {{count($started)}}</a></li>
                                                <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="in_process-tab" data-toggle="tab" href="#in_process" aria-controls="in_process" aria-expanded="false">In Process {{count($in_process)}}</a></li>
                                                <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="completed-tab" data-toggle="tab" href="#completed" aria-controls="completed" aria-expanded="false">Completed {{count($complete)}}</a></li>

                                            </ul>

                                            <div class="tab-content px-1 pt-1" id="dropdwonTabContent1">

                                                <div class="tab-pane active show" id="started" role="tabpanel" aria-labelledby="started-tab" aria-expanded="true">
                                                    <h5><span class="badge badge-primary m-2 font-weight-bold">Started</span></h5>

                                                    <table class="table table-striped" width='100%' id="datatable-1-{{$company_id}}">
                                                        <thead class="table-dark">
                                                        <tr class="t-row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Passport No</th>
                                                            <th>PPUID</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $counter=1?>
                                                            @foreach ($started as $row)

                                                            <tr>
                                                                <td>{{$counter}}</td>
                                                                <td>{{$row->passport->personal_info->full_name}}</td>
                                                                <td>{{$row->passport->passport_no}}</td>
                                                                <td>{{$row->passport->pp_uid}}</td>

                                                            </tr>
                                                                <?php $counter++?>

                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>








                                                <div class="tab-pane" id="in_process" role="tabpanel" aria-labelledby="in_process-tab" aria-expanded="false">
                                                    <h5><span class="badge badge-primary m-2 font-weight-bold">In Process</span></h5>

                                                    <table class="table table-striped"  width='100%' id="datatable-2-{{$company_id}}">
                                                        <thead class="table-dark">
                                                        <tr class="t-row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Passport No</th>
                                                            <th>PPUID</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $counter=1?>
                                                            @foreach ($in_process as $row)
                                                            <tr>
                                                                <td>{{$counter}}</td>
                                                                <td>{{$row->passport->personal_info->full_name}}</td>
                                                                <td>{{$row->passport->passport_no}}</td>
                                                                <td>{{$row->passport->pp_uid}}</td>

                                                            </tr>
                                                                <?php $counter++?>

                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                {{---------------------- status change starts--------------- --}}
                                                <div class="tab-pane" id="completed" role="tabpanel" aria-labelledby="completed-tab" aria-expanded="false">
                                                    <h5><span class="badge badge-primary m-2 font-weight-bold">Complete</span></h5>
                                                    <table class="table table-striped" width='100%' id="datatable-3-{{$company_id}}">
                                                        <thead class="table-dark">
                                                        <tr class="t-row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Passport No</th>
                                                            <th>PPUID</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $counter=1?>
                                                            @foreach ($complete as $row)
                                                            <tr>
                                                                <td>{{$counter}}</td>
                                                                <td>{{$row->passport->personal_info->full_name}}</td>
                                                                <td>{{$row->passport->passport_no}}</td>
                                                                <td>{{$row->passport->pp_uid}}</td>
                                                            </tr>
                                                                <?php $counter++?>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                        {{---------------------- status change ends--------------- --}}
                                            </div>
                                        </div>
                                        </div>
                                        @endforeach
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
            $('#datatable-1-1').DataTable( {
                "aaSorting": [],
                "pageLength": 10,

            });
        });
    </script>


<script>
  $(document).on('click', '#company-1-tab', function(){
                   var company_id='1';
                   var token = $("input[name='_token']").val();
                   $("#company-1-tab").css("background-color", "black");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                    $.ajax({
                        url: "{{ route('visa_company_detail') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{company_id:company_id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                              $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                            $('.company_div-1').append(response.html);
                            $('.company_div-1').show();
                            $("body").removeClass("loading");

                            var table1 = $('#datatable-1-1').DataTable({
                                "autoWidth": true,
                            });

                            table1.columns.adjust().draw();



                            var table2 = $('#datatable-2-1').DataTable({
                                "autoWidth": true,
                            });
                            table2.columns.adjust().draw()


                            var table3 = $('#datatable-3-1').DataTable({
                                "autoWidth": true,
                            });
                            table3.columns.adjust().draw()
                        }
                    });
                });
    </script>

<script>
    $(document).on('click', '#company-2-tab', function(){

                     var company_id='2';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "black");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-2').append(response.html);
                              $('.company_div-2').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-2').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-2').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();


                              var table3 = $('#datatable-3-2').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#company-3-tab', function(){
                     var company_id='3';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "black");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-3').append(response.html);
                              $('.company_div-3').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-3').DataTable({
                                  "autoWidth": true,
                              });
                              table.columns.adjust().draw();

                              var table2 = $('#datatable-2-3').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();


                              var table3 = $('#datatable-3-3').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#company-4-tab', function(){
                     var company_id='4';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "black");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-4').append(response.html);
                              $('.company_div-4').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-4').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();


                              var table2 = $('#datatable-2-4').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();

                              var table3 = $('#datatable-3-4').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-5-tab', function(){
                     var company_id='5';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "black");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-5').append(response.html);
                              $('.company_div-5').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-5').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-5').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-5').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-6-tab', function(){
                     var company_id='6';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "black");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();


                              $('.company_div-6').append(response.html);
                              $('.company_div-6').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-6').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-6').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-6').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-7-tab', function(){
                     var company_id='7';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "black");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-7').append(response.html);
                              $('.company_div-7').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-7').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-7').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-7').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-8-tab', function(){
                     var company_id='8';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "black");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-8').append(response.html);
                              $('.company_div-8').show();
                              $("body").removeClass("loading");


                              var table1 = $('#datatable-1-8').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-8').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-8').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-9-tab', function(){
                     var company_id='9';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "black");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-9').append(response.html);
                              $('.company_div-9').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-9').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-9').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-9').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-10-tab', function(){
                     var company_id='10';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "black");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();
                              $('.company_div-10').append(response.html);
                              $('.company_div-10').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-10').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-10').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-10').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();;
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-14-tab', function(){
                     var company_id='14';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "663399");
                   $("#company-14-tab").css("background-color", "black");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-14').append(response.html);
                              $('.company_div-14').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-14').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-14').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();
                              var table3 = $('#datatable-3-14').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#company-15-tab', function(){
                     var company_id='15';
                     var token = $("input[name='_token']").val();
                     $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "black");
                   $("#company-16-tab").css("background-color", "#663399");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();

                              $('.company_div-15').append(response.html);
                              $('.company_div-15').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-1-15').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();

                              var table2 = $('#datatable-2-15').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();



                              var table3 = $('#datatable-3-15').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>



<script>
    $(document).on('click', '#company-16-tab', function(){
                     var company_id='16';
                     var token = $("input[name='_token']").val();
                   $("#company-1-tab").css("background-color", "#663399");
                   $("#company-2-tab").css("background-color", "#663399");
                   $("#company-3-tab").css("background-color", "#663399");
                   $("#company-4-tab").css("background-color", "#663399");
                   $("#company-5-tab").css("background-color", "#663399");
                   $("#company-6-tab").css("background-color", "#663399");
                   $("#company-7-tab").css("background-color", "#663399");
                   $("#company-8-tab").css("background-color", "#663399");
                   $("#company-9-tab").css("background-color", "#663399");
                   $("#company-10-tab").css("background-color", "#663399");
                   $("#company-14-tab").css("background-color", "#663399");
                   $("#company-15-tab").css("background-color", "#663399");
                   $("#company-16-tab").css("background-color", "black");
                      $.ajax({
                          url: "{{ route('visa_company_detail') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                            $('.company_div-1').empty();
                              $('.company_div-2').empty();
                              $('.company_div-3').empty();
                              $('.company_div-4').empty();
                              $('.company_div-5').empty();
                              $('.company_div-6').empty();
                              $('.company_div-7').empty();
                              $('.company_div-8').empty();
                              $('.company_div-9').empty();
                              $('.company_div-10').empty();
                              $('.company_div-14').empty();
                              $('.company_div-15').empty();
                              $('.company_div-16').empty();
                              $('.company_div-16').append(response.html);
                              $('.company_div-16').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-1-16').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();
                              var table2 = $('#datatable-2-16').DataTable({
                                  "autoWidth": true,
                              });
                              table2.columns.adjust().draw();
                              var table3 = $('#datatable-3-16').DataTable({
                                  "autoWidth": true,
                              });
                              table3.columns.adjust().draw();
                          }
                      });
                  });
      </script>
<script>
    $(document).on('click', '#started-tab', function(){
                     $("#started-tab").css("background-color", "red");
                     $("#in_process-tab").css("background-color", "#003473");
                     $("#completed-tab").css("background-color", "#003473");
                  });
      </script>
      <script>
        $(document).on('click', '#in_process-tab', function(){
                         $("#started-tab").css("background-color", "003473");
                         $("#in_process-tab").css("background-color", "red");
                         $("#completed-tab").css("background-color", "#003473");
                      });
          </script>

<script>
    $(document).on('click', '#completed-tab', function(){
                     $("#started-tab").css("background-color", "#003473");
                     $("#in_process-tab").css("background-color", "#003473");
                     $("#completed-tab").css("background-color", "red");


                  });
      </script>
<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('id'); // get current tab
            var split_ab = currentTab;
            if(split_ab=="started-tab"){
                var table = $('#datatable-1-1').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            else if(split_ab=="in_process-tab"){
                var table = $('#datatable-2-1').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
           else{
                var table = $('#datatable-3-1').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

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
