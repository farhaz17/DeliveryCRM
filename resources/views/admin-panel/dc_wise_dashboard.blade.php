@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
        .hide_cls{
            display: none;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item active" aria-current="page">DC Module</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Masters</p>
                </a>
            </div>
        </div>
       <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="operations-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Bar-Chart text-white"></i>
                    <p class="p-0">Operation</p>
                </a>
            </div>
        </div>
         {{-- <div class="col-2">
            <div class="card card-icon  bg-info text-16  main-menu" id="graphs-menu" data-child-menu-items="graphs-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Line-Chart-2 text-white"></i>
                    <p class="p-0">Graphs</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-warning text-16  main-menu" id="renewal-menu"  data-child-menu-items="renewal-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Arrow-Circle text-white"></i>
                    <p class="p-0">Renewal</p>
                </a>
            </div>
        </div>
        --}}
        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="reports-menu"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Dashboard  text-white"></i>
                    <p class="p-0">Reports</p>
                </a>
            </div>
        </div>
        {{-- <div class="col-2">
            <div class="card card-icon  bg-secondary text-16  main-menu" id="documents-menu" data-child-menu-items="documents-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Library header-icon text-white"></i>
                    <p class="p-0">Documents</p>
                </a>
            </div>
        </div> --}}
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">

            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Master</span>
                    </a>
                </div>
            </div> --}}

            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('add_rider_followup') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Add Rider Follow Up</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="operations-menu-items">
        <div class="row">
            {{-- <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('talabat_cod') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Talabat COD Upload</span>
                    </a>
                </div>
            </div> --}}
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('manage_rider_codes') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Manage Rider Code</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('defaulter_riders.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Deafulter Riders</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('rider_attendance') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Rider Attandance</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('rider_fuel') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Rider Fuel</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('dc_request.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Make Request For Checkout</span>
                    </a>
                </div>
            </div>



            <div class="col-2 mb-2 hide_cls">
                <div class="card card-icon bg-success">
                    <a href="{{ route('dc_sent_request_checkin') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">View Checkin request sent</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('dc_to_accept_rider') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Rider Waiting For DC</span>
                    </a>
                </div>
            </div>

            @if($user->hasRole(['Admin']))

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('talabat_rider_performances.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Talabat Performance Upload</span>
                    </a>
                </div>
            </div>

            @else
            {{-- talabat platform  --}}
                    @if(in_array(15,$user->user_platform_id))
                    {{-- <div class="col-2 mb-2">
                        <div class="card card-icon bg-success">
                            <a href="{{ route('talabat_rider_performances.create') }}" class="card-body text-center p-2 text-white">
                                <i class="nav-icon i-Dashboard"></i>
                                <span class="item-name">Talabat Performance Upload</span>
                            </a>
                        </div>
                    </div> --}}
                    @endif
            @endif

            @if($user->hasRole(['Admin']))
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-success">
                        <a href="{{ route('careem_rider_performances.create') }}" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Careem Performance Upload</span>
                        </a>
                    </div>
                </div>
            @elseif(in_array(1,$user->user_platform_id))

                <div class="col-2 mb-2">
                    <div class="card card-icon bg-success">
                        <a href="{{ route('careem_rider_performances.create') }}" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Careem Performance Upload</span>
                        </a>
                    </div>
                </div>

            @endif
            {{-- @if($user->hasRole(['Admin']))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('visa_cancel_request') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Visa Cancel Request</span>
                    </a>
                </div>
            </div>

            @else
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('visa_cancel_request') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Visa Cancel Request</span>
                    </a>
                </div>
            </div>
            @endif --}}

            @if($user->hasRole(['Admin']))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('all_cancel_requests') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">View Visa Cancel Requests</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('accident_rider_request') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Missing Request</span>
                    </a>
                </div>
            </div>
            @else
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('all_cancel_requests') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">View Visa Cancel Requests</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('accident_rider_request') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Bike Missing Request</span>
                    </a>
                </div>
            </div>
            @endif




            @if($user->hasRole(['Admin']))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('visa_replacement_request') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Visa Cancel Request</span>
                    </a>
                </div>
            </div>
            @else
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('visa_replacement_request') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Visa Cancel Request</span>
                    </a>
                </div>
            </div>
            @endif
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{url('accident_request')}}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Make Accident Request</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="graphs-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
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
                        <span class="item-name">Expiry Reports</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="reports-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('rider_wise_cod_statement') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Rider Wise COD Statement</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('talabat_user_wise_riders_cod_analysis') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">City Wise Talabat COD</span>
                    </a>
                </div>
            </div>

            @if($user->hasRole('Admin'))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('talabat_user_wise_riders_cod_follow_up') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Talabat COD Follow Ups</span>
                    </a>
                </div>
            </div>
            @else
                @if(in_array(15,$user->user_platform_id))
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-primary">
                        <a href="{{ route('talabat_user_wise_riders_cod_follow_up') }}" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Library header-icon"></i>
                            <span class="item-name">Talabat COD Follow Ups</span>
                        </a>
                    </div>
                </div>
                @endif
            @endif
            @if($user->hasRole('Admin'))
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-primary">
                        <a href="{{ route('view_balance_cod') }}" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Library header-icon"></i>
                            <span class="item-name">Deliveroo COD</span>
                        </a>
                    </div>
                </div>
            @else
                @if(in_array(4,$user->user_platform_id))
                    <div class="col-2 mb-2">
                        <div class="card card-icon bg-primary">
                            <a href="{{ route('view_balance_cod') }}" class="card-body text-center p-2 text-white">
                                <i class="nav-icon i-Library header-icon"></i>
                                <span class="item-name">Deliveroo COD</span>
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            @if($user->hasRole(['Admin','DC_roll']))
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-primary">
                        <a href="{{ route('talabat_rider_performances.index') }}" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Library header-icon"></i>
                            <span class="item-name">Talabat Rider Performance</span>
                        </a>
                    </div>
                </div>
             @else

                @if(in_array(15,$user->user_platform_id))
                    <div class="col-2 mb-2 hide_cls">
                        <div class="card card-icon bg-primary">
                            <a href="{{ route('talabat_rider_performances.index') }}" class="card-body text-center p-2 text-white">
                                <i class="nav-icon i-Library header-icon"></i>
                                <span class="item-name">Talabat Rider Performance</span>
                            </a>
                        </div>
                    </div>
                @endif

             @endif


             @if($user->hasRole('Admin'))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('careem_rider_performances.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Careem Rider Performance</span>
                    </a>
                </div>
            </div>
            @else
                @if(in_array(1,$user->user_platform_id))
                    <div class="col-2 mb-2 hide_cls">
                        <div class="card card-icon bg-primary">
                            <a href="{{ route('careem_rider_performances.index') }}" class="card-body text-center p-2 text-white">
                                <i class="nav-icon i-Library header-icon"></i>
                                <span class="item-name">Careem Rider Performance</span>
                            </a>
                        </div>
                    </div>
                    @endif
             @endif
             @if($user->hasRole(['Admin','DC_roll']))
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('active_rider_report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Rider Report</span>
                    </a>
                </div>
            </div>
            @endif
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('rider_performance_report_generate_create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Rider Performance Report Generate</span>
                    </a>
                </div>
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
        }
    });
</script>
@endsection
