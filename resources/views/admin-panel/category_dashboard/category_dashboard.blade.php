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
            <li class="breadcrumb-item active" aria-current="page">Category</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Vehicle</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon bg-success text-16  main-menu" id="master-menu" data-child-menu-items="company-master">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Employee</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon bg-primary text-16  main-menu" id="master-menu" data-child-menu-items="company-supplier">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Customer Supplier</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon bg-secondary text-16  main-menu" id="master-menu" data-child-menu-items="visa-category">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Visa Status</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon bg-info text-16  main-menu" id="master-menu" data-child-menu-items="active-inactive">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Active Inactive</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="working-category">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Working Category</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('create-vehicle-category') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="company-master">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ url('category_master') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category Master</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="company-supplier">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('create-supplier-category') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="visa-category">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ url('category_visa_status') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="active-inactive">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="{{ url('active_inactive_category_status') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="working-category">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ url('working_category_status') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Category</span>
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
