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
        <li class="breadcrumb-item active" aria-current="page">Company Module</li>
    </ol>
</nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Company Master</p>
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
        <div class="col-2">
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
        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="reports-menu"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Dashboard  text-white"></i>
                    <p class="p-0">Reports</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-secondary text-16  main-menu" id="documents-menu" data-child-menu-items="documents-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Library header-icon text-white"></i>
                    <p class="p-0">Documents</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company-master-license-create') }}" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">License</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company-master-e-establishment-card') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">eEstablishment Card</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company_master_traffic_create') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Traffic</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company-master-utilities') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Utilities</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company-master-ejari') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">Ejari</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('company-master-moa') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Gear"></i>
                        <span class="item-name">MOA</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu"  id="operations-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">operations</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="submenu"  id="graphs-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
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
                    <a href="{{ route('company-master-expiry-reports') }}" class="card-body text-center p-2 text-white">
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
                    <a href="{{ route('company-master-license-list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">License Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company-master-e-establishment-card-list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">eEstablishment Card Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company_master_traffic_list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Traffic Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company-master-utilities-list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Utilities Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company-master-ejari-list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Ejari Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company-master-moa-list') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">MOA Reports</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('company-master-expiry-reports') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Expiry Reports</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu" id="documents-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{route('company-master-license-documents')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">License Documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{route('company-master-e-establishment-card-documents')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">e-Establishment Documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{route('company_master_traffic_documents')}}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Traffic documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-utilities-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Utilities Documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-ejari-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Ejari Documents</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="{{ route('company-master-moa-documents') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Moa Documents</span>
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
