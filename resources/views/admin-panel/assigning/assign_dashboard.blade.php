@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>

        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
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
    </style>
    <link rel="stylesheet" href="{{asset('assets/tree-view/css/hierarchy-view.css')}}">
    <link rel="stylesheet" href="{{asset('assets/tree-view/css/main.css')}}">


@endsection
@section('content')


    {{-- --------------------tickets---------------------}}

    <div class="row">
        <div class="col-md-12">
            <!--Basic style-->
            <section class="basic-style">

                <h3 class="text-center font-weight-bold">BIKE DETAIL</h3>

                <div class="hv-container">
                    <div class="hv-wrapper">

                        <!-- Key component -->
                        <div class="hv-item">
                            <a href="{{ route('download_total_bikes') }}" target="_blank">
                            <div class="hv-item-parent" >
                                <p class="simple-card">
                                    Total Bikes
                                    <br>
                                    <span>{{  $all_bike  }}</span>
                                </p>

                            </div>
                            </a>

                            <div class="hv-item-children">
                                <div class="hv-item-child">
                                    <div class="hv-item">

                                        <div class="hv-item-parent">
                                            <a href="{{ route('download_lease_bikes') }}" target="_blank">
                                            <p class="simple-card"> Lease Bike
                                                <br>
                                                <span>{{  $lease_bike  }}</span></p>
                                            </a>
                                        </div>

                                        <div class="hv-item-children">

                                            <div class="hv-item-child">
                                                <a href="{{ route('download_used_bikes') }}" target="_blank">
                                                <p class="simple-card">USED BIKE <br>
                                                    <span><b>{{ $lease_used_bike }}</b></span>
                                                </p>
                                                </a>
                                            </div>

                                            <div class="hv-item-child">
                                                <a href="{{ route('download_lease_free_bikes') }}" target="_blank">
                                                <p class="simple-card"> FREE BIKE

                                                    <br>
                                                    <span><b>{{ $lease_free_bike }}</b></span>

                                                </p>
                                                </a>
                                            </div>
                                            <div class="hv-item-child">
                                                <a href="{{ route('download_lease_cancel_bikes') }}" target="_blank">
                                                <p class="simple-card"> CANCEL BIKE
                                                    <br>
                                                    <span><b>{{ $lease_cancel_bike }}</b></span>
                                                </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="hv-item-child">
                                    <div class="hv-item">
                                        <div class="hv-item-parent">
                                            <a href="{{ route('download_company_bikes') }}" target="_blank">
                                            <p class="simple-card"> Company Bike
                                                <br>
                                                <span>{{  $company_bike  }}</span></p>
                                            </a>
                                        </div>
                                        <div class="hv-item-children">

                                            <div class="hv-item-child">
                                                <a href="{{ route('download_company_used_bikes') }}" target="_blank">
                                                <p class="simple-card">USED BIKE <br>
                                                    <span><b>{{ $company_used_bike }}</b></span></p>
                                                </a>
                                            </div>

                                            <div class="hv-item-child">
                                                <a href="{{ route('download_company_free_bikes') }}" target="_blank">
                                                <p class="simple-card"> FREE BIKE
                                                    <br>
                                                    <span><b>{{ $company_free_bike }}</b></span> </p>
                                                </a>

                                            </div>
                                            <div class="hv-item-child">
                                                <a href="{{ route('download_company_cancel_bikes') }}" target="_blank">
                                                <p class="simple-card"> CANCEL BIKE
                                                    <br>
                                                    <span><b>{{ $company_cancel_bike }}</b></span></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <!--Basic style-->
            <section class="basic-style">

                <h3 class="text-center font-weight-bold">SIM DETAIL</h3>

                <div class="hv-container">
                    <div class="hv-wrapper">

                        <div class="hv-item">

                            <div class="hv-item-parent">
                                <a href="{{ route('download_total_sims') }}" target="_blank">
                                <p class="simple-card"> Total Sim
                                    <br>
                                    <span><b>{{ $total_sim }}</b>
                                    </span>

                                </p>
                                </a>
                            </div>

                            <div class="hv-item-children">
                                <div class="hv-item-child">
                                    <a href="{{ route('download_total_rider_sims') }}" target="_blank">
                                    <p class="simple-card"> RIDER SIM
                                        <br>
                                        <span><b>{{ $rider_sim }}</b>
                                    </p>
                                    </a>
                                </div>
                                <div class="hv-item-child">
                                    <a href="{{ route('download_total_office_sims') }}" target="_blank">
                                    <p class="simple-card"> OFFICE SIM
                                        <br>
                                        <span><b>{{ $office_sim }}</b>
                                    </p>
                                    </a>
                                </div>

                                <div class="hv-item-child">
                                    <a href="{{ route('download_total_free_sims') }}" target="_blank">
                                    <p class="simple-card"> FREE SIM
                                        <br>
                                        <span><b>{{ $free_sim }}</b>
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </section>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- CARD ICON-->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center" id="platform_checkout"><i class="i-Home1"></i>
                            <p class="text-muted mt-2 mb-2">Today PlatForm <b>Checkout</b></p>
                            <p class="text-primary text-24 line-height-1 m-0">{{ $total_today_platform_checkout }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center" id="sim_checkout"><i class="i-Memory-Card"></i>
                            <p class="text-muted mt-2 mb-2">Today Sim <b>Checkout</b></p>
                            <p class="text-primary text-24 line-height-1 m-0">{{ $total_today_sim_checkout }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center" id="bike_checkout"><i class="i-Motorcycle"></i>
                            <p class="text-muted mt-2 mb-2">Total Bike <b>Checkout</b></p>
                            <p class="text-primary text-24 line-height-1 m-0">{{ $total_today_bike_checkout }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center" id="platform_checkin"><i class="i-Home-4"></i>
                            <p class="text-muted mt-2 mb-2">Today PlatForm <b>Checkin</b></p>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">{{ $total_today_platform }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center" id="sim_checkin"><i class="i-Memory-Card-3"></i>
                            <p class="text-muted mt-2 mb-2">Today Sim <b>Checkin</b></p>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">{{ $total_today_sim }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center" id="bike_checkin"><i class="i-Motorcycle"></i>
                            <p class="text-muted mt-2 mb-2">Today Bike <b>Checkin</b></p>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">{{ $total_today_bike }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end of row-->
    <div class="row">
        <!-- travel-different-countries-->
        <div class="col-lg-6 col-md-6 mb-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Today Platform <b>Checkin</b> Detail</div>

                    @foreach($platforms as $plt)
                        @if($plt->total_check_in_today() > 0)
                            <div class="ul-widget-app__poll-list mb-4">
                                <h3 class="heading mr-2">{{ $plt->total_check_in_today() ? $plt->total_check_in_today() : '0'   }}</h3>
                                <div class="d-flex"><span class="text-muted text-12">{{ $plt->name }}</span><span class="t-font-boldest ml-auto"><i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                                <div class="progress progress--height-2 mb-3">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach


                </div>
            </div>
        </div>
        <!-- mutual-friend-->

        <div class="col-lg-6 col-md-6 mb-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Today Platform <b>Checkout</b> Detail</div>

                    @foreach($platforms as $plt)
                        @if($plt->total_check_out_today() > 0)
                            <div class="ul-widget-app__poll-list mb-4">
                                <h3 class="heading mr-2">{{ $plt->total_check_out_today() ? $plt->total_check_out_today() : '0'   }}</h3>
                                <div class="d-flex"><span class="text-muted text-12">{{ $plt->name }}</span><span class="t-font-boldest ml-auto"><i class="i-Turn-Up-2 text-14 text-success font-weight-700"></i></span></div>
                                <div class="progress progress--height-2 mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach


                </div>
            </div>
        </div>



    </div>

    <!-- end of row-->
    <!-- end of main-content -->
















    <div class="modal fade rider_order_modal" id="platform_checkout_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today PlatForm <b>Checkout</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id=datatable1" style="width: 100%">
                                    <thead class="thead-dark">
                    <th scope="col">Passport Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Plateform</th>
                    <th scope="col">Zds Code</th>
                    <th scope="col">Checkin</th>
                    <th scope="col">Checkout</th>
                    <th scope="col">Remarks</th>
                                    </thead>

                    @foreach($total_today_platform_checkout_detail as $row)
                        <tr>
                        <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                        <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                        <td>{{isset($row->plateformdetail->name)?$row->plateformdetail->name:"N/A"}}</td>
                        <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                        <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                        <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                        <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                        </tr>
                    @endforeach
                </table>
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




    <div class="modal fade rider_order_modal" id="sim_checkout_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today PlatForm <b>Checkout</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id="datatable2" style="width: 100%">
                                    <thead class="thead-dark">
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">SIM</th>
                                    <th scope="col">PlatForm</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Checkin</th>
                                    <th scope="col">Checkout</th>
                                    </thead>

                                    @foreach($today_sim_checkout_get as $row)
                                        <tr>
                                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                            <td>{{isset($row->telecome->account_number)?$row->telecome->account_number:"N/A"}}</td>
{{--                                            <td>{{isset($row->passport->plateform->plateformdetail->name)?$row->passport->plateform->plateformdetail->name:"N/A"}}</td>--}}
                                            <td>{{isset($row->passport->plateformdetail->name)?$row->passport->plateformdetail->name:"N/A"}}</td>

                                            <td>{{isset($row->assign_to->name)?$row->assign_to->name:"N/A"}}</td>
                                            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                                            <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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




    <div class="modal fade rider_order_modal" id="bike_checkout_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today Bike <b>Checkout</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id="datatable3" style="width: 100%">
                                    <thead class="thead-dark">
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">PlatForm</th>
                                    <th scope="col">Checkin</th>
                                    <th scope="col">Checkout</th>
                                    <th scope="col">Remakrs</th>
                                    </thead>

                                    @foreach($total_today_bike_checkout_detail as $row)
                                        <tr>
                                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                            <td>{{isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->rider_platform->plateformdetail->name)?$row->passport->rider_platform->plateformdetail->name:"N/A"}}</td>
                                            <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                                            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                                            <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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








    <div class="modal fade rider_order_modal" id="platform_checkin_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today PlatForm <b>Check-in</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%">
                                    <thead class="thead-dark">
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Plateform</th>
                                    <th scope="col">Zds Code</th>
                                    <th scope="col">Checkin</th>
                                    <th scope="col">Checkout</th>
                                    <th scope="col">Remarks</th>
                                    </thead>

                                    @foreach($total_today_platform_checkin_detail as $row)
                                        <tr>
                                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                            <td>{{isset($row->plateformdetail->name)?$row->plateformdetail->name:"N/A"}}</td>
                                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                                            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                                            <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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



    <div class="modal fade rider_order_modal" id="sim_checkin_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today SIM <b>Check-IN</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id="datatable5" style="width: 100%">
                                    <thead class="thead-dark">
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">SIM</th>
                                    <th scope="col">PlatForm</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Checkin</th>
                                    <th scope="col">Checkout</th>
                                    </thead>

                                    @foreach($today_sim_checkin_detail as $row)
                                        <tr>
                                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                            <td>{{isset($row->telecome->account_number)?$row->telecome->account_number:"N/A"}}</td>

                                            <td>{{isset($row->passport->rider_platform->plateformdetail->name)?$row->passport->rider_platform->plateformdetail->name:"N/A"}}</td>


                                            <td>{{isset($row->assign_to->name)?$row->assign_to->name:"N/A"}}</td>
                                            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                                            <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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






    <div class="modal fade rider_order_modal" id="bike_checkin_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Today Bike <b>Check-IN</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <table class="display table table-striped table-bordered" id="datatable6" style="width: 100%">
                                    <thead class="thead-dark">
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">PlatForm</th>
                                    <th scope="col">Checkin</th>
                                    <th scope="col">Checkout</th>
                                    <th scope="col">Images</th>
                                    <th scope="col">Remakrs</th>
                                    </thead>

                                    @foreach($total_today_bike_detail as $row)
                                        <tr>
                                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                            <td>{{isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A"}}</td>
                                            <td>{{isset($row->passport->rider_platform->plateformdetail->name)?$row->passport->rider_platform->plateformdetail->name:"N/A"}}</td>

                                            <td>{{isset($row->assign_to->name)?$row->assign_to->name:"N/A"}}</td>
                                            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                                            <td>{{isset($row->remakrs)?$row->remakrs:"N/A"}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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






@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

    <script>
        $('#platform_checkout').on('click', function() {
            $("#platform_checkout_mdl").modal('show')
            var table = $('#datatable1').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });

        $('#sim_checkout').on('click', function() {
            $("#sim_checkout_mdl").modal('show')

            var table = $('#datatable2').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });
        $('#bike_checkout').on('click', function() {
            $("#bike_checkout_mdl").modal('show')
            var table = $('#datatable3').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });
        $('#platform_checkin').on('click', function() {
            $("#platform_checkin_mdl").modal('show')
            var table = $('#datatable4').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });
        $('#sim_checkin').on('click', function() {
            $("#sim_checkin_mdl").modal('show')
            var table = $('#datatable5').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });
        $('#bike_checkin').on('click', function() {
            $("#bike_checkin_mdl").modal('show')
            var table = $('#datatable6').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
        });
    </script>




@endsection
