<style>
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
    #datatable_platform{
        cursor: pointer;
    }
    #bike_days_div{
        cursor: pointer;
    }
    #sim_days_div{
        cursor: pointer;
    }
    #working_days_div{
        cursor: pointer;
    }
    </style>


{{--platform assgin--}}
<div class="modal fade bd-example-modal-lg" id="check_detail_modal_platform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Platform Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">


                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_platform">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Platform</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Checkout</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Total Days</th>

                        </tr>
                        </thead>

                        @foreach($platforms as $plat)

                            <tr>
                                <td>{{isset($plat->plateformdetail->name)?$plat->plateformdetail->name:"N/A"}} </td>
                                <td>{{isset($plat->checkin)?$plat->checkin:"N/A"}} </td>
                                <td>{{isset($plat->checkout)?$plat->checkout:"N/A"}} </td>
                                <td>{{isset($plat->remarks)?$plat->remarks:"N/A"}} </td>
                                <?php
                                $last_day_date = "";
                                $first_day_date = "";
                                if($plat->checkin != null){
                                    $f_dat = explode(" ",$plat->checkin);
                                    $first_day_date =  $f_dat[0];
                                }else{
                                    $first_day_date = date("Y-m-d");
                                }

                                if($plat->checkout != null){
                                    $l_dat = explode(" ",$plat->checkout);
                                    $last_day_date =  $l_dat[0];
                                }else{
                                    $last_day_date = date("Y-m-d");
                                }

                                $datetime1= new \DateTime($first_day_date);
                                $datetime2= new \DateTime($last_day_date);

                                 $difference = $datetime1->diff($datetime2);
                                ?>
                                <td>{{ $difference->days ? $difference->days+1 : '0'  }} </td>

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


{{--bike assign modal--}}

{{--    view Detail Passport modal--}}
<div class="modal fade bd-example-modal-lg bike_mdl" id="bike_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <table class="display table table-striped table-bordered" id="datatable_bikes" width="100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Plate No</th>
                        <th scope="col">Checkin</th>
                        <th scope="col">Checkout</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Total Days</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bikes as $bike)


                        <tr>
                            <td>{{isset($bike->bike_plate_number->plate_no)?$bike->bike_plate_number->plate_no:"N/A"}} </td>
                            <td>{{isset($bike->checkin)?$bike->checkin:"N/A"}} </td>
                            <td>{{isset($bike->checkout)?$bike->checkout:"N/A"}} </td>
                            <td>{{isset($bike->remarks)?$bike->remarks:"N/A"}} </td>
                            <?php
                            $last_day_date = "";
                            $first_day_date = "";
                            if($bike->checkin != null){
                                $f_dat = explode(" ",$bike->checkin);
                                $first_day_date =  $f_dat[0];
                            }else{
                                $first_day_date = date("Y-m-d");
                            }

                            if($bike->checkout != null){
                                $l_dat = explode(" ",$bike->checkout);
                                $last_day_date =  $l_dat[0];
                            }else{
                                $last_day_date = date("Y-m-d");
                            }

                            $datetime1= new \DateTime($first_day_date);
                            $datetime2= new \DateTime($last_day_date);

                            $difference = $datetime1->diff($datetime2);
                            ?>
                            <td>{{ $difference->days ? $difference->days+1 : '0'  }} </td>


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



{{--sim assign modal--}}
<div class="modal fade bd-example-modal-lg" id="check_detail_modal_sim" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">SIM Checkin Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable_sim">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">SIM No</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Checkout</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Total Days</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($telecom as $sim2)

                            <tr>
                                <td>{{isset($sim2->telecome->account_number)?$sim2->telecome->account_number:"N/A"}} </td>
                                <td>{{isset($sim2->checkin)?$sim2->checkin:"N/A"}} </td>
                                <td>{{$sim2->checkout}} </td>
                                <td>{{$sim2->remarks}} </td>
                                <?php
                                $last_day_date = "";
                                $first_day_date = "";
                                if($sim2->checkin != null){
                                    $f_dat = explode(" ",$sim2->checkin);
                                    $first_day_date =  $f_dat[0];
                                }else{
                                    $first_day_date = date("Y-m-d");
                                }

                                if($sim2->checkout != null){
                                    $l_dat = explode(" ",$sim2->checkout);
                                    $last_day_date =  $l_dat[0];
                                }else{
                                    $last_day_date = date("Y-m-d");
                                }

                                $datetime1= new \DateTime($first_day_date);
                                $datetime2= new \DateTime($last_day_date);

                                $difference = $datetime1->diff($datetime2);
                                ?>
                                <td>{{ $difference->days ? $difference->days+1 : '0'  }} </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



<div class="row">
    <!-- ICON BG-->
        <div class="col-lg-4 col-md-6 col-sm-6" id="working_days_div">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-User"></i>
                    <div class="content width_cls">
                        <p class="text-muted mt-2 mb-0">Total Working Days</p>
                        <p class="lead text-primary text-24 mb-2">{{ $total_working_days }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6" id="bike_days_div">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content width_cls">
                        <p class="text-muted mt-2 mb-0">Total Bike Used</p>
                        <p class="lead text-primary text-24 mb-2">{{ $total_bikes  }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6"  id="sim_days_div">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content width_cls">
                        <p class="text-muted mt-2 mb-0">Total Sim Used</p>
                        <p class="lead text-primary text-24 mb-2">{{ $total_sim }}</p>
                    </div>
                </div>
            </div>
        </div>


</div>
