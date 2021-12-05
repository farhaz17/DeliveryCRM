@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item active" aria-current="page">DC Manager Module</li>
    </ol>
</nav>
    <div class="row">
        {{-- <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Masters</p>
                </a>
            </div>
        </div> --}}
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
        </div> --}}
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
    <div class="submenu" id="master-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Master</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="operations-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('checkin_request_for_teamleader') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Requests For Checkin</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('request_for_teamleader') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Request For Checkout</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('all_cancel_requests_to_dc') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Visa Cancel Requests</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('checkout_type_report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Checkout Request</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('team_leader_request_sent_for_dc') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Team Leader Sent Request  to Dc for Accept Rider</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('manage_rider_codes') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Manage Rider Codes</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('talabat_rider_performances.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Talabat Rider Performance Upload</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{url('accident_request_for_teamleader')}}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Accident/Missing Bike Requests</span>
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
                        <span class="item-name">Graphs</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="reports-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('dc_manager_dashboard') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Manager Of DC</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('manager_user') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">All DC</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('dc_dashboard') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">DC Wise Charts</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('dc_leaderboard',['date_range' => 'today']) }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">DC Leaderboard</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('active_rider_report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Rider Report</span>
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
                    <a href="{{ route('talabat_rider_performances.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Talabat Rider Performances</span>
                    </a>
                </div>
            </div>
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
                        <span class="item-name">Documents</span>
                    </a>
                </div>
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
        }
    });
</script>
@endsection
