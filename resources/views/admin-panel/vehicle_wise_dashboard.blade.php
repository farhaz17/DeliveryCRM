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
            <li class="breadcrumb-item active" aria-current="page">RTA Module</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">RTA Master</p>
                </a>
            </div>
        </div>
       <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="operations-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Bar-Chart text-white"></i>
                    <p class="p-0">RTA Operation</p>
                </a>
            </div>
        </div>
         <div class="col-2">
            <div class="card card-icon  bg-info text-16  main-menu" id="graphs-menu" data-child-menu-items="graphs-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Line-Chart-2 text-white"></i>
                    <p class="p-0">RTA Graphs</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-warning text-16  main-menu" id="renewal-menu"  data-child-menu-items="renewal-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Arrow-Circle text-white"></i>
                    <p class="p-0">RTA Renewal</p>
                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="reports-menu"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Dashboard  text-white"></i>
                    <p class="p-0">RTA Reports</p>
                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-secondary text-16  main-menu" id="documents-menu" data-child-menu-items="documents-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Library header-icon text-white"></i>
                    <p class="p-0">RTA Documents</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_category.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Vehicle Category</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_sub_category.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Vehicle Sub Category</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_make.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Make</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{route('vehicle_model.create')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Model</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_year.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Year</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_plate_code.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Plate Code</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_master_create')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Vehicle</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('attachmentLabel.create')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Attachment Labels</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_tracking_inventory.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Tracking Inventory</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('create-cheque') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Cheque</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('create-salik-tags') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Salik Tags</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu"  id="operations-menu-items">
        <div class="row">

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="other_operations">
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">All Operations</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="box_operations">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Box Installation</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="permit_operations">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Food Permit</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="bike_missing">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Bike Missing/Stolen</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="accident_operations">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Vehicle Accident</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="lpo">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">LPO</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="tracker_operations">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Tracker</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="bike_impounding">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Bike Impounding</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="other_operations_div" >

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle_master_edit') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike info Update</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('bike_tracking') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Tracker Operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle_plate_replace.create')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Plate Replace Request</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle_cancel_create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Cancellation</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle_working_status_form') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Working Status</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('assign_bike') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Assign</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('bike_replacement.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Replacement</span>
                    </a>
                </div>
            </div>

            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('create-company-lpo') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Company LPO</span>
                    </a>
                </div>
            </div> --}}

            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle-receive') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Vehicle Receivement</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('create-vcc-attachment') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">VCC/Insurance/Plate</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle-assignment-company') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Vehicle Assignment to Company</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('vehicle-assignment-insurance') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Vehicle Assignment Insurance</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('plate-registration') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Plate Registration</span>
                    </a>
                </div>
            </div> --}}

            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-dark">
                    <a href="{{ route('bike-missing-request') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Missing Request</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-dark">
                    <a href="{{ route('checkout-missing-bike') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Checkout Missing Bike</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-dark">
                    <a href="{{ route('missing-bike-process') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Missing Bike Process</span>
                    </a>
                </div>
            </div> --}}

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('reserved_report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Reservation Assignment</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('salik_operation') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Salik Opertion</span>
                    </a>
                </div>
            </div>

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="box_operations_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_install_request') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Box Install Request DC</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('dc_box_install_requests') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Box Request From DC</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_request_rta') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Box Install Request RTA</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_requests') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Pending Box Process</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Box Process</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_create_batch') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Create Batch</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('box_removal') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Box Removal</span>
                </a>
            </div>
        </div>

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="permit_operations_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('dc_request_food') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Permit Request DC</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('food_process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Pending Process</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('food_permit_process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Permit Process</span>
                </a>
            </div>
        </div>

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="accident_operations_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('accident_request') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Make Accident Request</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('accident_process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Accident Process</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('accident_pending_process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Pending Process</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('after_approved_requests') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Accident Approved Requests</span>
                </a>
            </div>
        </div>

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="tracker_operations_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('dc_request_for_tracker') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Tracker Request DC</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('rta_request_for_tracker') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Tracker Request RTA</span>
                </a>
            </div>
        </div>

        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('tracker_upload') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Tracker Upload</span>
                </a>
            </div>
        </div>

    </div>

    <div class="submenu"  id="graphs-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Graphs</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="submenu" id="renewal-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-warning">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Renewal</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="reports-menu-items">

        <div class="row">

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="other_reports">
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">All Reports</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="box_reports">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Box Installation</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="permit_reports">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Food Permit</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="accident_reports">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Vehicle Accident</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="tracker_reports">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Tracker</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <div class="row hide_cls process_div_cls mt-16" id="other_reports_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('rta_dashboard') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Dashboard</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_category.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Category Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_sub_category.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Sub Category Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_make.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Make Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_model.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Model Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_year.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Year Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_plate_code.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Plate Code Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('bikes_master') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('attachmentLabel.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Attachment Label Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_tracking_inventory.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Tracking Inventory Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_salik_tag.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Salik Tags Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_plate_replace.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Plate Replace Request Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('bike_tracking_history') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Trackers Reports</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_report') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Category Wise Report</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('status_wise_vehicle_report') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Status Wise Vehicle Report</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_life_cycle') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle life-Cycle</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('report-lpo-received-vehicle') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">LPO Received Vehicle Report</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('report-lpo-dashboard') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">LPO Report Dashboard</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('report-salik-tags') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">LPO Salik tags</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('vehicle_upload_history.index') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Vehicle Upload History</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('rider_sim_bike_report') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Inventory Report</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('all_vehicle_report') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">All In One Report</span>
                </a>
            </div>
        </div>

    </div>
    <div class="row hide_cls process_div_cls mt-16" id="box_reports_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('removed_boxes') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Removed Boxes</span>
                </a>
            </div>
        </div>

    </div>
    <div class="row hide_cls process_div_cls mt-16" id="permit_reports_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('food_permit_expiry') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Month Wise Expiry</span>
                </a>
            </div>
        </div>

    </div>
    <div class="row hide_cls process_div_cls mt-16" id="accident_reports_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('accident_pending_request') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Waiting For Checkout</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('loss_repair_bikes') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">Process Completed Bikes</span>
                </a>
            </div>
        </div>

    </div>
    <div class="row hide_cls process_div_cls mt-16" id="tracker_reports_div" >

        <div class="col-2 mb-2">
            <div class="card card-icon bg-primary">
                <a href="{{ route('tracker_requests') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Library header-icon"></i>
                    <span class="item-name">All Tracker Requests</span>
                </a>
            </div>
        </div>

    </div>
    <div class="submenu" id="documents-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Bike Documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{route('vehicle_plate_replace_documents')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Vehicle Plate Replace Documents</span>
                    </a>
                </div>
            </div>
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{route('company_master_traffic_documents')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Traffic documents</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-utilities-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Utilities Documents</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-ejari-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Ejari Documents</span>
                    </a>
                </div>
            </div> --}}
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-moa-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Moa Documents</span>
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="row hide_cls process_div_cls mt-16" id="bike_missing_div" >
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('bike-missing-request') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Bike Missing Request</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{url('after_approved_requests')}}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Approved Requests</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('missing-bike-process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Missing Bike Process</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row hide_cls process_div_cls mt-16" id="bike_impounding_div" >
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('bike_impounding.create') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Create Bike Impounding</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{url('impounded-bike')}}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Impounded Bike</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row hide_cls process_div_cls mt-16" id="lpo_div" >
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('create-lpo-vehicle') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Delivery Note</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('lpo-vehicle-info') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Vehicle Info</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('lpo-process') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">LPO Process</span>
                </a>
            </div>
        </div>

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
