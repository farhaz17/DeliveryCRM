@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table#datatable {
            font-size: 13px;
        }
        tr.t-row {
            font-size: 12px;
            white-space: nowrap;
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
        .btn-revoke {
    padding: 1px;
    font-size: 0px;
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

        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Cancelation</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">

        <div class="row">
        <div class="col-12">
        <div class="card text-left">
            <div class="card-body">


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">DC Requests</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">HR Requests</a></li>
                    <li class="nav-item"><a class="nav-link" id="all-basic-tab" data-toggle="tab" href="#allBasic" role="tab" aria-controls="allBasic" aria-selected="false">Accepted Requestes</a></li>
                    <li class="nav-item"><a class="nav-link" id="pro-basic-tab" data-toggle="tab" href="#proBasic" role="tab" aria-controls="proBasic" aria-selected="false">PRO Requestes</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable" >
                                <thead>
                                <tr class="t-row">
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Replace With Name</th>
                                    <th scope="col">Replace With Passport No</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Request Sent at</th>
                                    <th scope="col">Sent by</th>


                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                 @foreach($acc as $res)
                                    <tr>
                                        <td>{{isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:""}}</td>
                                        <td>{{ isset($res->passport->passport_no)?$res->passport->passport_no:""}}</td>
                                        <td>{{ isset($res->passport->pp_uid)?$res->passport->pp_uid:""}}</td>
                                        <td>{{ isset($res->passport_two->passport_no)?$res->passport_two->passport_no:""}}</td>
                                        <td>{{ isset($res->passport_two->personal_info->full_name)?$res->passport_two->personal_info->full_name:""}}</td>
                                        <td>{{ isset($res->remarks)?$res->remarks:""}}</td>
                                        <td>{{ isset($res->created_at)?$res->created_at:""}}</td>
                                        <td>{{ isset($res->user_detail->name)?$res->user_detail->name:""}}</td>
                                        <td>
                                            @if ($res->hr_reqest!='1')
                                            <button class="btn btn-success btn-icon m-1 btn-revoke" style="font-size: 12px" data-toggle="modal"
                                            data-target=".bd-example-modal-lg" onclick="accept_visa_cancel({{$res->id}})"
                                             type="button">
                                             Accept Cancel Request
                                           </button>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                               </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="elec_pre_pay_div"></div>
                    </div>

                    <div class="tab-pane fade" id="allBasic" role="tabpanel" aria-labelledby="pall-basic-tab">
                        <div class="accepted_div"></div>
                    </div>

                    <div class="tab-pane fade" id="proBasic" role="tabpanel" aria-labelledby="pro-basic-tab">
                        <div class="pro_div"></div>
                    </div>


                    




                    </div>


                    </div>

                </div>


            </div>
        </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="startForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Accept Visa  Replacement  Request</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    {{-- <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div> --}}
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('GET')}}
                      <strong>
                           <h5> Are you sure want to accept visa replacement  request?</h5>
                      </strong>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit" onclick="yesSubmit()">Yes</button>
                    </div>
                </form>
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
        $(document).on('click', '#profile-basic-tab', function(){

                         var token = $("input[name='_token']").val();
                         var url = '{{ route('hr_to_pro_replacement') }}';
                          $.ajax({
                            url: url,
                              method: 'POST',
                              dataType: 'json',
                              data:{_token:token},
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
                                });
                                table1.columns.adjust().draw();
                              }
                          });
                      });
          </script>

<script>
    $(document).on('click', '#all-basic-tab', function(){

                     var token = $("input[name='_token']").val();
                     var url = '{{ route('accpeted_replacement_requests') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.accepted_div').empty();
                              $('.accepted_div').append(response.html);
                              $('.accepted_div').show();
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
    $(document).on('click', '#pro-basic-tab', function(){

                     var token = $("input[name='_token']").val();
                     var url = '{{ route('pro_replacement_requests') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.pro_div').empty();
                              $('.pro_div').append(response.html);
                              $('.pro_div').show();
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
        function accept_visa_cancel(id)
                       {
                           var id = id;
                           var url = '{{ route('replacement_request_accept', ":id") }}';
                           url = url.replace(':id', id);
                           $("#startForm").attr('action', url);
                       }

                       function yesSubmit()
                       {
                           $("#startForm").submit();
                           // alert('Deleted!!!111 Chal band kar');
                       }
   </script>


<script>



        function approve(id)
        {
            var id = id;
            var url = '{{ route('cancal_approve_update', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function start_Submit()
        {
            $("#updateForm").submit();

        }
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
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





@endsection

