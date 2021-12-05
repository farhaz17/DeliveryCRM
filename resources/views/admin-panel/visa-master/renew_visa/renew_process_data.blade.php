@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 12px;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 600;
        }

        a.btn.btn-primary.btn-sm.mr-2 {
            /* height: 21px; */
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
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .btn-icon.rounded-circle {
    width: 25px;
    height: 25px;
    padding: 0;
}
        .btn-s{
            padding: 1px;
            }
            .start-visa {
            padding: 0px;
                }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Visa Process Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!--------Passport Additional Information--------->

    <div class="card col-lg-12  mb-2">


        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Renew Visa Processes To Starts</h4>
                <ul class="nav nav-tabs" id="dropdwonTab">
                    <li class="nav-item"><a  class="nav-link active show tab-btn" id="renew_contract-tab" data-toggle="tab" href="#renew_contract" aria-controls="renew_contract" aria-expanded="true">Renew Contract Typing</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="rewnew_contract_sub-tab" data-toggle="tab" href="#rewnew_contract_sub" aria-controls="rewnew_contract_sub" aria-expanded="false">Renewal Contract Submission</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="medical-tab" data-toggle="tab" href="#medical" aria-controls="medical" aria-expanded="false">Medical</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="eid_apply-tab" data-toggle="tab" href="#eid_apply" aria-controls="eid_apply" aria-expanded="false">Emirates ID Apply</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="visa_stamp-tab" data-toggle="tab" href="#visa_stamp" aria-controls="visa_stamp" aria-expanded="false">Visa Stamping</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="visa_pending-tab" data-toggle="tab" href="#visa_pending" aria-controls="visa_pending" aria-expanded="false">Renew Visa Pasting</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="eid_receive-tab" data-toggle="tab" href="#eid_receive" aria-controls="eid_receive" aria-expanded="false">Emirates ID Receive</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="eid_handover-tab" data-toggle="tab" href="#eid_handover" aria-controls="eid_handover" aria-expanded="false">Emirates ID Handover</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn" id="complete-tab" data-toggle="tab" href="#complete" aria-controls="complete" aria-expanded="false">Complete</a></li>


                </ul>


                <div class="tab-content px-1 pt-1" id="dropdwonTabContent">
                    <div class="tab-pane active show" id="renew_contract" role="tabpanel" aria-labelledby="renew_contract-tab" aria-expanded="true">
                        <table class="table table-striped tab-border mt-1" id="datatable" width="100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">&nbsp</th>
                                <th scope="col">Name</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">Agreed Amount</th>
                                <th scope="col">Advance</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Final</th>
                                <th scope="col">Payrol Deduction</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)

                                <tr>
                                    <td class="details-control">
                                        <button class="btn btn-s btn-success btn-icon rounded-circle m-1 gone" style="font-size: 16px" id="go-{{ $row['passport_id'] }}"  type="button">
                                            <span class="ul-btn__icon"><i class="i-Add" id="ico-{{ $row['passport_id'] }}"></i></span>
                                        </button>
                                       </td>

                                    <td> {{$row['name']}}
                                        <div id='nested_table-{{$row['passport_id']}}'  style="display: none; margin-top:5px; margin-bottom:5px">

                                        </div>
                                    </td>
                                    <td> {{$row['pass_no']}}</td>
                                    <td> {{$row['pp_uid']}}</td>
                                    <td> {{$row['agreed_amount']}}</td>
                                    <td> {{$row['advance_amount']}}</td>
                                    <td> {{$row['discount_amount']}}</td>
                                    <td> {{$row['final_amount']}}</td>
                                    <td> {{$row['payroll_deduct_amount']}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm start-visa" href="{{ url('renew_visa_process') }}?passport_id={{$row['pass_no']}}" target="_blank">Start Visa Process</a>
                                        </td>
                                    </td>
                                </tr>

                            @endforeach



                            </tbody>
                        </table>
                    </div>










                    <div class="tab-pane" id="rewnew_contract_sub" role="tabpanel" aria-labelledby="rewnew_contract_sub-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Renewal Contract Submission</span></h5>

                        <div class="renew_contract_div"></div>
                    </div>

                    {{---------------------- status change starts--------------- --}}
                    <div class="tab-pane" id="medical" role="tabpanel" aria-labelledby="medical-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Medical</span></h5>
                        <div class="medical_div"></div>
                    </div>

                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="eid_apply" role="tabpanel" aria-labelledby="eid_apply-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Emirates ID Apply</span></h5>
                        <div class="eid_apply_div"></div>
                    </div>


                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="visa_stamp" role="tabpanel" aria-labelledby="visa_stamp-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Visa Staming</span></h5>
                        <div class="visa_stamp_div"></div>
                    </div>


                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="visa_pending" role="tabpanel" aria-labelledby="visa_pending-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Renew Visa Pasting</span></h5>
                        <div class="visa_pending_div"></div>
                    </div>


                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="eid_receive" role="tabpanel" aria-labelledby="eid_receive-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Emirates ID Receive</span></h5>
                        <div class="eid_rec_div"></div>
                    </div>

                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="eid_handover" role="tabpanel" aria-labelledby="eid_handover-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Emirates ID Handover</span></h5>
                        <div class="eid_handover_div"></div>
                    </div>

                     {{---------------------- status change starts--------------- --}}
                     <div class="tab-pane" id="complete" role="tabpanel" aria-labelledby="complete-tab" aria-expanded="false">
                        <h5><span class="badge badge-primary m-2 font-weight-bold">Complete</span></h5>
                        <div class="complete_div"></div>
                    </div>




                </div>


                </div>
            </div>
        </div>

    </div>





      {{-- --------------------------------------------------------- --}}

      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="startForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Start Renew Visa  Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    {{-- <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div> --}}
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('GET')}}
                      <strong>
                           <h5> Are you sure want to start Renew Visa Process? </h5>
                      </strong>
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit" onclick="visaSubmit()">Start it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    </div>
    <div class="overlay"></div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        function startVisa(id)
                       {
                           var id = id;
                           var url = '{{ route('start_renew_visa', ":id") }}';
                           url = url.replace(':id', id);
                           $("#startForm").attr('action', url);
                       }

                       function visaSubmit()
                       {
                           $("#startForm").submit();
                           // alert('Deleted!!!111 Chal band kar');
                       }
   </script>

    <script>
        $(document).on('click', '#rewnew_contract_sub-tab', function(){

                         var token = $("input[name='_token']").val();
                         var id = '2';
                         var url = '{{ route('renew_visa_pendings') }}';
                          $.ajax({
                            url: url,
                              method: 'POST',
                              dataType: 'json',
                              data:{_token:token ,id:id},
                              beforeSend: function () {
                                  $("body").addClass("loading");
                          },
                              success: function (response) {
                                  $('.renew_contract_div').empty();
                                  $('.renew_contract_div').append(response.html);
                                  $('.renew_contract_div').show();
                                  $("body").removeClass("loading");
                                  var table1 = $('#datatable-2').DataTable({
                                    "autoWidth": true,
                                     responsive: true,
                                });
                                table1.columns.adjust().draw();
                              }
                          });
                      });
          </script>

<script>
    $(document).on('click', '#medical-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '3';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.medical_div').empty();
                              $('.medical_div').append(response.html);
                              $('.medical_div').show();
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
    $(document).on('click', '#eid_apply-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '4';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token ,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.eid_apply_div').empty();
                              $('.eid_apply_div').append(response.html);
                              $('.eid_apply_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-4').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#visa_stamp-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '5';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token, id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.visa_stamp_div').empty();
                              $('.visa_stamp_div').append(response.html);
                              $('.visa_stamp_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-5').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#visa_pending-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '6';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token ,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.visa_pending_div').empty();
                              $('.visa_pending_div').append(response.html);
                              $('.visa_pending_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-6').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#eid_receive-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '7';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.eid_rec_div').empty();
                              $('.eid_rec_div').append(response.html);
                              $('.eid_rec_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-7').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#eid_handover-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '8';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.eid_handover_div').empty();
                              $('.eid_handover_div').append(response.html);
                              $('.eid_handover_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-8').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#complete-tab', function(){

                     var token = $("input[name='_token']").val();
                     var id = '9';
                     var url = '{{ route('renew_visa_pendings') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token,id:id},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.complete_div').empty();
                              $('.complete_div').append(response.html);
                              $('.complete_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-9').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>



    <script>
        $(document).ready(function(){

            $(".gone").button().click(function(){
            var data_id = $(this).attr('id');
            var splt_v = data_id.split("-");

            //  alert(splt_v[1]);

             if($("#nested_table-"+splt_v[1]).is(":visible")){
                $('#nested_table-'+splt_v[1]).empty();
                $("#nested_table-"+splt_v[1]).hide();
                $('#ico-'+splt_v[1]).addClass("i-Add");
                $('#go-'+splt_v[1]).removeClass("btn-danger");
                $('#go-'+splt_v[1]).addClass("btn-success");


             }
             else{
                var url = '{{ route('renew_nested', ":id") }}';
                var token = $("input[name='_token']").val();

            $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {id: splt_v[1], _token: token},
                        success: function (response) {
                            $('#nested_table-'+splt_v[1]).empty();
                            $('#nested_table-'+splt_v[1]).append(response.html);
                            $('#ico-'+splt_v[1]).addClass("i-Close");
                            $('#go-'+splt_v[1]).removeClass("btn-success");
                            $('#go-'+splt_v[1]).addClass("btn-danger");
                            $("#nested_table-"+splt_v[1]).show();
                        }
                    });
             }
    });

        });



    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="home-basic-tab"){
                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
               else{
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });
        });
    </script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>



@endsection



{{-- <table class="table table-striped tab-border mt-1" id="datatable" width="100%">
    <thead class="thead-dark">
    <tr>

        <th scope="col">Passport</th>
        <th scope="col">Old Passport Number</th>
        <th scope="col">Passport Expiry Date</th>
        <th scope="col">Name</th>
        <th scope="col">PPUID</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">Emirates ID</th>
{{--                <th scope="col">Platform</th>--}}
{{--                <th scope="col">Bike</th>--}}
{{--                <th scope="col">SIM</th>--}}
{{--                <th scope="col">Offer Letter No</th>--}}
        {{-- <th scope="col">Visa Company</th>
        <th scope="col">MB Number</th>
        <th scope="col">Person Code</th>
        <th scope="col">Labour Card No</th>
        <th scope="col">Labour Card Issue Date</th>
        <th scope="col">Visa Number</th>
        <th scope="col">Visa Issue Date</th>
        <th scope="col">Visa Expiry Date</th>
        <th scope="col">UID Number</th>
        <th scope="col">Offer Letter ST No</th>
        <th scope="col">Driving Linces</th>
        <th scope="col">Driving Linces Expiry</th>
        <th scope="col">PPUID Status</th> --}}




    {{-- </tr>
    </thead>
    <tbody>
    @foreach($passport as $row)
        <tr>
            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>
            @php
                $pass_ex=$row->date_expiry;
                $pass_ex_d = new DateTime($pass_ex);
            @endphp
            <td>{{$pass_ex_d->format('Y-m-d')}}</td>

            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
            <td> {{isset($row->emirates_id->card_no)?$row->emirates_id->card_no:"N/A"}}</td> --}}

{{--                    <td>{{$row->assign_platforms_check() ? $row->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>--}}
{{--                    <td>{{isset($row->bike_checkin()->bike_plate_number->plate_no) ? ($row->bike_checkin()->bike_plate_number->plate_no) : 'N/A'}}</td>--}}
{{--                    <td>{{isset($row->sim_checkin()->telecome->account_number) ? ($row->sim_checkin()->telecome->account_number) : 'N/A'}}</td>--}}
            {{-- <td> {{isset($row->offer->companies->name)?$row->offer->companies->name:"N/A"}}</td>
            <td> {{isset($row->offer_letter_submission->mb_no)?$row->offer_letter_submission->mb_no:"N/A"}}</td>
            <td> {{isset($row->elect_pre_approval->person_code)?$row->elect_pre_approval->person_code:"N/A"}}</td>
            <td> {{isset($row->elect_pre_approval->labour_card_no)?$row->elect_pre_approval->labour_card_no:"N/A"}}</td>
            <td> {{isset($row->elect_pre_approval->issue_date)?$row->elect_pre_approval->issue_date:"N/A"}}</td>
            <td> {{isset($row->print_visa_inside_outside->visa_number)?$row->print_visa_inside_outside->visa_number:"N/A"}}</td>

            @php
                $visa_issue_date=$row->visa_issue_date;
                $visa_issue_date_d = new DateTime($visa_issue_date);
            @endphp
            <td>{{$visa_issue_date_d->format('Y-m-d')}}</td>



            @php
                $visa_expiry_date=$row->visa_expiry_date;
                $visa_expiry_date_d = new DateTime($visa_expiry_date);
            @endphp
            <td>{{$visa_expiry_date_d->format('Y-m-d')}}</td>


            <td> {{isset($row->print_visa_inside_outside->uid_no)?$row->print_visa_inside_outside->uid_no:"N/A"}}</td>
            <td> {{isset($row->offer->st_no)?$row->offer->st_no:"N/A"}}</td>
            <td> {{isset($row->driving_license->license_number)?$row->driving_license->license_number:"N/A"}}</td>

            @php
                $driving_expire_date=$row->expire_date;
                $drving_expiry_date_d = new DateTime($driving_expire_date);
            @endphp
            <td>{{$drving_expiry_date_d->format('Y-m-d')}}</td>

            @if($row->cancel_status=='1')
                <td> Cancelled</td>
            @else
                <td>Active</td>
                @endif





        </tr>
    @endforeach


    </tbody>
</table> --}}
