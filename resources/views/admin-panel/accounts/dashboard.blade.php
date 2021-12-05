@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
        .bg_color_cls{
            background-color: #343529 !important;
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
            <li class="breadcrumb-item active" aria-current="page">Accounts Module</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16 new_cls_process  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Gear text-white"></i>
                    <p class="p-0">Master</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-success text-16 new_cls_process  main-menu" id="operations-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Bar-Chart text-white"></i>
                    <p class="p-0">Operation</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-primary text-16 new_cls_process main-menu" id="reports-menu"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Dashboard  text-white"></i>
                    <p class="p-0">Reports</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-danger">
                    <a href="{{ route('create-cheque') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Cheque</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="submenu"  id="operations-menu-items">
        <div class="row">
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
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="bike-impound">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Bike Impounding</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row hide_cls process_div_cls mt-16" id="bike-impound_div" >
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{url('bike_impounding')}}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Impound/Fine Bike</span>
                </a>
            </div>
        </div>
    </div>

    <div class="submenu"  id="reports-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('report-lpo-contract') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Contract (LPO) Report</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('report-master-lpo') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">LPO Master Report</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('report-cheque') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">LPO Cheque Report</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('insurance-claim-report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Insurance Claim Report</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('bike-impound-report') }}" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Library header-icon"></i>
                        <span class="item-name">Bike Impound Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row hide_cls process_div_cls mt-16" id="lpo_div" >
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('create-lpo-contract') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Contract (LPO)</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('create-master-lpo') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">LPO</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('create-lpo-invoice') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Invoice (LPO)</span>
                </a>
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="card card-icon bg-success">
                <a href="{{ route('create-emi') }}" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Dashboard"></i>
                    <span class="item-name">Payment (LPO)</span>
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
