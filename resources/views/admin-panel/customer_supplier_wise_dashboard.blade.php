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
        <li class="breadcrumb-item active" aria-current="page">Customer | Supplier Module</li>
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
       {{-- <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="operations-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Bar-Chart text-white"></i> 
                    <p class="p-0">Operation</p>
                </a>  
            </div>
        </div> --}}
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
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('customer_supplier_categories.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Customer|Supplier Category</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('customer_suppliers.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Customer | Supplier</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Active / Inactive</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_insurance.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Insurance</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('vehicle_mortgage.create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Mortgage</span>
                    </a>  
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="operations-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Operation</span>
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
                    <a href="{{ route('customer_supplier_categories.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Customer|Supplier Category Report</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('customer_supplier_sub_categories.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Customer|Supplier SubCategory Reports</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('customer_suppliers.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Customer | Supplier Reports</span>
                    </a>  
                </div>
            </div> 
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Active / Inactive Reports</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('vehicle_insurance.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Insurance Reports</span>
                    </a>  
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('vehicle_mortgage.index') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Mortgage Reports</span>
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