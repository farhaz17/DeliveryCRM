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
        .start-visa {
    padding: 1px;
}
a.btn.btn-success.btn-file {
    padding: 1px;
    font-size: 11px;
    font-weight: 100;

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
                <h4 class="card-title mb-3">All Cancelled Visa Processes</h4>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Between Cancel</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Complete Visa Cancel</a></li>
                </ul>


                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <table class="display table table-striped table-bordered table-sm text-10" id="datatable" width="100%">
                            <thead>
                            <tr>

                                <th scope="col">Name</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">Cancelled At</th>
                                <th scope="col">Cancellation Date & Time</th>
                                <th scope="col">Attachment</th>
                                <th scope="col">Other Attachments</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($between as $row)
                                <tr>
                                    <td> {{$row->passport->personal_info->full_name}}</td>
                                    <td> {{$row->passport->passport_no}}</td>
                                    <td> {{$row->passport->pp_uid}}</td>
                                    <td> {{isset($row->master->step_name)?$row->master->step_name:""}}</td>
                                    <td> {{$row->created_at}}</td>
                                    <td>
                                        @if(isset($between))
                                        @if($row->attachment!=null)
                                        <br>
                                        @foreach (json_decode($row->attachment) as $visa_attach)
                                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/visa_cencel/between_cancel/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                                            <strong style="color: #000000">  View Attachment</strong>
                                        </a>
                                            <span>|</span>
                                        @endforeach
                                        @endif
                                    @else
                                    N/A
                                    @endif
                                    </td>
                                    <td>

                                        @if($row->other_attachment!=null)
                                            <br>
                                            @foreach (json_decode($row->other_attachment) as $visa_attach2)
                                            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/visa_cencel/between_cancel/other_attachments//'.$visa_attach2, now()->addMinutes(5))}}"
                                                 target="_blank">
                                                 <strong style="color: #000000">  View Attachment</strong>
                                            </a>
                                                <span>|</span>
                                            @endforeach

                                        @else
                                        N/A
                                        @endif
                                    </td>
                                </tr>

                            @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="elec_pre_pay_div"></div>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Start Visa  Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    {{-- <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div> --}}
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('GET')}}
                      <strong>
                           <h5> Are you sure want to start Visa Process?
                           </h5>
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
        $(document).on('click', '#profile-basic-tab', function(){

                         var token = $("input[name='_token']").val();
                         var url = '{{ route('visa_cancel_complete') }}';
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
                var url = '{{ route('get_nested_info_visa_process_report', ":id") }}';
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
