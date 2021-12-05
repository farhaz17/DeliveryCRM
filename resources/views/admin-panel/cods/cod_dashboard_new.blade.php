@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
        .border_cls{
            border-radius: inherit;
        }
        .hide_cls{
            display: none;
        }
        .active_cls{
            border: 2px solid #ffa500f2;
        }
        .bg_color_cls{
            background-color: #343529 !important;
        }
        .bg_color_clss{
            background-color: #f44336 !important;
        }
        .bg_color_deliveroo{
            background-color: #02bdad;
        }
        .bg_color_talabat{
            background-color: #f05502;
        }
        .bg_color_careem{
            background-color: #499d3a;
        }
        .bg_color_carrefour{
            background-color: #0e5aa7;
        }
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cod Dashboard</li>
    </ol>
</nav>
<div class="row">
    <div class="col-2">
        <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
            <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                <i class="i-Conference text-white"></i>
                <p class="p-0">COD Master</p>
            </a>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-icon  bg-success text-16  main-menu" id="oparation-menu" data-child-menu-items="oparation-menu-items">
            <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                <i class="i-Checked-User text-white"></i>
                <p class="p-0">COD Operation</p>
            </a>
        </div>
    </div>

    <div class="col-2">
        <div class="card card-icon  bg-primary text-16  main-menu" id="agreed_amount"  data-child-menu-items="reports-menu-items">
            <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                <i class="i-Receipt-3  text-white"></i>
                <p class="p-0">COD Report</p>
            </a>
        </div>
    </div>


</div>
<hr>
<div class="submenu"  id="oparation-menu-items">
    <div class="row">

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="deliveroo_operations">
                    <i class="nav-icon i-Recycling-2 header-icon"></i>
                    <span class="item-name">Deliveroo</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="talabat_operations">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Talabat</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="careem_operations">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Careem</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="carrefour_operations">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Carrefour</span>
                </a>
            </div>
        </div>

    </div>
</div>
<div class="row hide_cls process_div_cls mt-16" id="deliveroo_operations_div" >

    <?php  $add_cod_cash = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($add_cod_cash)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('add_cod_cash_request') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Cash Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole


    <?php  $add_cod_adjustment = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($add_cod_adjustment)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('add_cod_adjust') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Cod Adjustment</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $add_bank_cod = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($add_bank_cod)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('add_cod_bank_request') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Bank Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cod_upload = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($cod_upload)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cod_uploads') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Cod Upload</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $close_month = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($close_month)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cod_close_month') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Close Month</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cod_delete = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($cod_delete)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('delete_cod_by_date') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Delete Cods</span>
            </a>
        </div>
    </div>
    @endhasanyrole

</div>
<div class="row hide_cls process_div_cls mt-16" id="talabat_operations_div" >

    <?php  $upload_talabat_cod_role = ['Admin','DC_roll','Cod','talabat_cod']; ?>

    @hasanyrole($upload_talabat_cod_role)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_talabat">
            <a href="{{ route('talabat_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Cod Upload</span>
            </a>
        </div>
    </div>
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_talabat">
            <a href="{{ route('talabat_cod_internal') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Cod Upload Internal</span>
            </a>
        </div>
    </div>
    @endhasanyrole
    <?php  $add_cod_cash = ['Admin']; ?>

    {{--
        @hasanyrole($add_cod_cash)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('defaulter_riders.index') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Deafulter Riders</span>
                </a>
            </div>
        </div>
        @endhasanyrole
    --}}

    <?php  $add_cod_cash = ['Admin']; ?>

    {{--
         @hasanyrole($add_cod_cash)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('rider_attendance') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Rider Attandance</span>
                </a>
            </div>
        </div>
        @endhasanyrole
    --}}

    <?php  $add_cod_cash = ['Admin']; ?>

    {{--
        @hasanyrole($add_cod_cash)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('rider_fuel') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Rider Fuel</span>
                </a>
            </div>
        </div>
        @endhasanyrole
    --}}

<?php  $add_cod_cash = ['Admin']; ?>
    {{--
        @hasanyrole($add_cod_cash)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('dc_request.create') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">DC Checkout Request</span>
                </a>
            </div>
        </div>
        @endhasanyrole
    --}}


</div>
<div class="row hide_cls process_div_cls mt-16" id="careem_operations_div" >

    <?php  $add_cod_cash = ['Admin','Cod','careem_cod']; ?>

    @hasanyrole($add_cod_cash)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_add_cash_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Cash Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $add_bank_cod = ['Admin','Cod','careem_cod']; ?>

    @hasanyrole($add_bank_cod)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_add_bank_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Bank Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cod_upload = ['Admin','Cod','careem_cod']; ?>
    @hasanyrole($cod_upload)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Cod Upload</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $close_month = ['Admin','Cod','careem_cod']; ?>
    @hasanyrole($close_month)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_close_month') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Close Month</span>
            </a>
        </div>
    </div>
    @endhasanyrole

</div>

<div class="row hide_cls process_div_cls mt-16" id="carrefour_operations_div" >

    <?php  $add_cod_cash = ['Admin','Cod','carrefour_cod']; ?>

    @hasanyrole($add_cod_cash)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_add_cash_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Add Cash Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cod_upload = ['Admin','Cod','carrefour_cod']; ?>
    @hasanyrole($cod_upload)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Cod Upload</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $close_month = ['Admin','Cod','carrefour_cod']; ?>
    @hasanyrole($close_month)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_close_month') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Close Month</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cash_cod_upload = ['Admin','Cod','carrefour_cod']; ?>
    @hasanyrole($cash_cod_upload)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_cash_cod_upload') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Cash Cod Upload</span>
            </a>
        </div>
    </div>
    @endhasanyrole

</div>
<div class="submenu"  id="reports-menu-items">
    <div class="row">

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="deliveroo_reports">
                    <i class="nav-icon i-Recycling-2 header-icon"></i>
                    <span class="item-name">Deliveroo</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="talabat_reports">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Talabat</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="careem_reports">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Careem</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="carrefour_reports">
                    <i class="nav-icon i-Cursor-Select header-icon"></i>
                    <span class="item-name">Carrefour</span>
                </a>
            </div>
        </div>

    </div>
</div>
<div class="row hide_cls process_div_cls mt-16" id="deliveroo_reports_div" >

    <?php  $deliveroo_dashboard = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($deliveroo_dashboard)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cod_dashboard') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Dashboard</span>
            </a>
        </div>
    </div>
    @endhasanyrole


    <?php  $cash_request = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($cash_request)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cods') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Cash Requests</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $bank_request = ['Admin','Cod','deliveroo_cod']; ?>

    @hasanyrole($bank_request)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cod_bank') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Bank Requests</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $rider_cod = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($rider_cod)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('rider_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Rider Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $cod_adjustment_request = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($cod_adjustment_request)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('cod_adjust') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Adjustment Request</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $uploaded_data = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($uploaded_data)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('uploaded_data') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Uploaded Data</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $balance_cod = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($balance_cod)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('view_balance_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Balance Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $close_month_report = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($close_month_report)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('close_month_report') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Close Month Report</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    <?php  $rider_wise_report = ['Admin','Cod','deliveroo_cod']; ?>
    @hasanyrole($rider_wise_report)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_deliveroo">
            <a href="{{ route('rider_wise_cod_deliveroo') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Recycling-2 header-icon"></i>
                <span class="item-name">Rider Wise Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

</div>

<div class="row hide_cls process_div_cls mt-16" id="talabat_reports_div" >

    <?php  $talabat_roles = ['Admin','Cod','talabat_cod']; ?>

    @hasanyrole($talabat_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_talabat">
            <a href="{{ route('rider_wise_cod_statement') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Rider Wise COD Statement</span>
            </a>
        </div>
    </div>
    @endhasanyrole
    <?php  $talabat_roles = ['Admin','Cod','talabat_cod']; ?>

    @hasanyrole($talabat_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_talabat">
            <a href="{{ route('talabat_user_wise_riders_cod_analysis') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">City Wise Talabat COD</span>
            </a>
        </div>
    </div>
    @endhasanyrole
    <?php  $talabat_roles = ['Admin','Cod','talabat_cod']; ?>

    @hasanyrole($talabat_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_talabat">
            <a href="#" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Talabat Cod Report</span>
            </a>
        </div>
    </div>
    @endhasanyrole
</div>

<div class="row hide_cls process_div_cls mt-16" id="careem_reports_div" >

    <?php  $careem_roles = ['Admin','Cod','careem_cod']; ?>

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_dashboard') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Dashboard</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_cash_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Cash Request</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_bank_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Bank Request</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_rider_wise_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Rider Wise Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_balance_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Balance Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($careem_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_careem">
            <a href="{{ route('careem_uploaded_data') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Uploaded Data</span>
            </a>
        </div>
    </div>
    @endhasanyrole
</div>

<div class="row hide_cls process_div_cls mt-16" id="carrefour_reports_div" >

    <?php  $carrefour_roles = ['Admin','Cod','carrefour_cod']; ?>

    @hasanyrole($carrefour_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_dashboard') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Dashboard</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($carrefour_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_cash_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Cash Request</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($carrefour_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_rider_wise_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Rider Wise Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($carrefour_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_balance_cod') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Balance Cod</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole($carrefour_roles)
    <div class="col-2 mb-2">
        <div class="card card-icon bg_color_carrefour">
            <a href="{{ route('carrefour_uploaded_data') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Cursor-Select header-icon"></i>
                <span class="item-name">Uploaded Data</span>
            </a>
        </div>
    </div>
    @endhasanyrole

</div>
@endsection

@section('js')
    <script>
        @if(request('active') != null)
            $("#{{request('active')}}" ).show(600);
        @endif
        var active_submenu = "";
        $('.main-menu').click(function(){
            var current_submenu = $(this).attr('data-child-menu-items');
            if(current_submenu !== active_submenu){
                $('.submenu').hide(600);
                $('#'+ current_submenu).show(600);
                active_submenu = current_submenu;

                $(".process_div_cls").hide();
                $(".new_cls_process").removeClass('active_cls');
            }
        });

        $(".new_cls_process").click(function () {
           var id = $(this).attr('id');
            var now_id = id+"_div";
            $(".process_div_cls").hide();
            $(".new_cls_process").removeClass('active_cls');
            $(this).addClass('active_cls');

            $("#"+now_id).show(600);
            $("#"+now_id).css("display","flex");

        });
    </script>
@endsection
