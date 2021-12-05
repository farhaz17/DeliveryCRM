@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr {
            white-space: nowrap;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Status</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Passport Report</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Visa & Emirate ID Report</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" aria-selected="false">Labour Card Report</a></li>
                    <li class="nav-item"><a class="nav-link" id="passport-basic-tab" data-toggle="tab" href="#passportBasic" role="tab" aria-controls="passportBasic" aria-selected="false">Driving License Report</a></li>
                    <li class="nav-item"><a class="nav-link" id="name-basic-tab" data-toggle="tab" href="#nameBasic" role="tab" aria-controls="passportBasic" aria-selected="false">Platform Report</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                                <h2>Passport Report</h2>
                                <table class="display table table-striped table-bordered" id="datatable1" style="width: 100%" >
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Old Passport Number</th>
                                        <th scope="col">Passport</th>
                                        <th scope="col">Passport Expiry Date</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS Code</th>





                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($passport as $row)
                                        <tr>
                                            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>
                                            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                            @php
                                                $pass_ex=$row->date_expiry;
                                                $pass_ex_d = new DateTime($pass_ex);
                                            @endphp
                                            <td>{{$pass_ex_d->format('Y-m-d')}}</td>

                                            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>



                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>


                    </div>

                    {{--                    tab2--}}
                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                                <h2>Visa & Emirate ID Report</h2>
                                <table class="display table table-striped table-bordered" id="datatable3" style="width: 100%" >
                                    <thead class="thead-dark">
                                    <tr>

                                        <th scope="col">Passport</th>
                                        <th scope="col">Old Passport Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS Code</th>
                                        <th scope="col">Emirates ID</th>
                                        <th scope="col">Emirates ID Expiry</th>
                                        <th scope="col">Visa Company</th>
                                        <th scope="col">Visa Issue Date</th>
                                        <th scope="col">Visa Expiry Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($passport as $row)
                                        <tr>
                                            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>


                                            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                            <td> {{isset($row->emirates_id->card_no)?$row->emirates_id->card_no:"N/A"}}</td>
                                            <td> {{isset($row->emirates_id->expire_date)?$row->emirates_id->expire_date:"N/A"}}</td>
                                            <td> {{isset($row->offer->companies->name)?$row->offer->companies->name:"N/A"}}</td>
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

                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>


                    </div>

                    {{--                    tab3--}}
                    <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab" >


                                <h2>Labour Card Report</h2>
                                <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%" >
                                    <thead class="thead-dark">
                                    <tr>

                                        <th scope="col">Passport</th>
                                        <th scope="col">Old Passport Number</th>

                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS Code</th>
                                        <th scope="col">ST No</th>
                                        <th scope="col">MB No</th>
                                        <th scope="col">Person Code</th>
                                        <th scope="col">Labour Card No</th>
                                        <th scope="col">Labour Card Issue Date</th>
                                        <th scope="col">Labour Card Expiry Date</th>
                                        {{--                                <th scope="col">Company Visa </th>--}}





                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($passport as $row)
                                        <tr>
                                            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>
                                            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                            <td> {{isset($row->offer->st_no)?$row->offer->st_no:"N/A"}}</td>
                                            <td> {{isset($row->elect_pre_approval->mb_no)?$row->elect_pre_approval->mb_no:"N/A"}}</td>

                                            <td> {{isset($row->elect_pre_approval->person_code)?$row->elect_pre_approval->person_code:"N/A"}}</td>
                                            <td> {{isset($row->elect_pre_approval->labour_card_no)?$row->elect_pre_approval->labour_card_no:"N/A"}}</td>
                                            <td> {{isset($row->elect_pre_approval->issue_date)?$row->elect_pre_approval->issue_date:"N/A"}}</td>
                                            <td> {{isset($row->elect_pre_approval->expiry_date)?$row->elect_pre_approval->expiry_date:"N/A"}}</td>




                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>


                    </div>


                    {{--                    tab4--}}
                    <div class="tab-pane fade show" id="passportBasic" role="tabpanel" aria-labelledby="passport-basic-tab">


                                <h2> Driving License Report</h2>
                                <table class="display table table-striped table-bordered" id="datatable5" style="width: 100%" >
                                    <thead class="thead-dark">
                                    <tr>

                                        <th scope="col">Passport</th>
                                        <th scope="col">Old Passport Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS Code</th>
                                        <th scope="col">Driving Linces</th>
                                        <th scope="col">Driving Linces Expiry</th>
                                        <th scope="col">Driving Linces Place Of Issue</th>
                                        <th scope="col">Traffic File No</th>




                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($passport as $row)
                                        <tr>
                                            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>
                                            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                            <td> {{isset($row->driving_license->license_number)?$row->driving_license->license_number:"N/A"}}</td>
                                            @php
                                                $driving_expire_date=$row->expire_date;
                                                $drving_expiry_date_d = new DateTime($driving_expire_date);
                                            @endphp
                                            <td>{{$drving_expiry_date_d->format('Y-m-d')}}</td>

                                            <td> {{isset($row->driving_license->place_issue)?$row->driving_license->place_issue:"N/A"}}</td>
                                            <td> {{isset($row->driving_license->traffic_code)?$row->driving_license->traffic_code:"N/A"}}</td>




                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>

                    </div>


                    {{--                    tab5--}}
                    <div class="tab-pane fade" id="nameBasic" role="tabpanel" aria-labelledby="name-basic-tab">


                                <h2>Platform Report</h2>
                                <table class="display table table-striped table-bordered" id="datatable6" style="width: 100%" >
                                    <thead class="thead-dark">
                                    <tr>

                                        <th scope="col">Passport</th>
                                        <th scope="col">Old Passport Number</th>

                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS Code</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Bike No</th>
                                        <th scope="col">SIM No</th>
                                        {{--                                <th scope="col">Agreement No</th>--}}

                                        {{--                                <th scope="col">Company Visa </th>--}}





                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($passport as $row)
                                        <tr>
                                            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                            <td> {{isset($row->renew_pass)?$row->renew_pass->renew_passport_number:"N/A"}}</td>
                                            <td> {{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                            <td> {{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{$row->assign_platforms_check() ? $row->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                                            <td>{{isset($row->bike_checkin()->bike_plate_number->plate_no) ? ($row->bike_checkin()->bike_plate_number->plate_no) : 'N/A'}}</td>
                                            <td>{{isset($row->sim_checkin()->telecome->account_number) ? ($row->sim_checkin()->telecome->account_number) : 'N/A'}}</td>
                                            {{--                                    <td>{{isset($row->agreeement) ? ($row->agreeement) : 'N/A'}}</td>--}}




                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>

                    </div>


                    </div>






                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';



            $('#datatable1,#datatable2,#datatable3,#datatable33,#datatable4,datatable44,#datatable6,#datatable66,#datatable5,#datatable7,#datatable77,#datatable8,#datatable88,#datatable9,#datatable99,#datatable10,#datatable55').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable1').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable33').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable44').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="passport-basic-tab"){
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable55').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="name-basic-tab"){
                    var table = $('#datatable6').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable66').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
                else if(split_ab=="platform-basic-tab"){
                    var table = $('#datatable7').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable77').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="sim-basic-tab"){
                    var table = $('#datatable8').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable88').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="bike-basic-tab"){
                    var table = $('#datatable9').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable99').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }



                else{
                    var table = $('#datatable10').DataTable();
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
