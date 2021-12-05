@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Report Lpo Dashboard</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-6 card p-4">
        <div class="row container p-2 mt-4 mb-4">
            <div class="col-md-4">
                <div>Filter By Purchase Type</div>
                <select id="purchaseType" class="form-control purchase-type" name="">
                    <option value="0" selected>Select Type</option>
                    <option value="1">Rental</option>
                    <option value="2">Lease To Own</option>
                    <option value="3">Company</option>
                </select>
            </div>
            <div class="col-md-4 supplier">
                <div>Filter By Supplier</div>
                <select id="supplierId" class="form-control" name="supplier_id">
                    <option value="0" selected>Select Supplier</option>
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-handshake-o text-warning p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="contractsCreated"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Contracts Created</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-file p-2 mr-0 text-success fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="lposCreated"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total LPO's Created</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-phone text-danger p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="bikesRequested"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Bikes Requested</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-info-circle text-primary p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="bikesInfoUpload"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Bikes Info Uploaded</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-bicycle text-primary p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="bikesReceived"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Bikes Received</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-money p-2 mr-0 text-secondory fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="lpoAmount"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Amount (LPO)</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Spare Dashboard --}}
    <div class="col-md-6 card p-4">
        <div class="row container p-2 mt-4 mb-4">
            <div class="col-md-4 supplier">
                <div>Filter By Supplier</div>
                <select id="spareSupplierId" class="form-control" name="spare_supplier_id">
                    <option value="0" selected>Select Supplier</option>
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-file p-2 mr-0 text-success fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="spareLpos"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total LPO's Created</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-phone text-danger p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="partsRequested"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Parts Requested</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-bicycle text-primary p-2 mr-0 fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="partsReceived"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Parts Received</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="card sim-card o-hidden">
                    <div class="card-body">
                        <div class="ul-widget__row-v2" style="position: relative;">

                            <div class="ul-widget__content-v2">
                                <i class="fa fa-money p-2 mr-0 text-secondory fa-2x" aria-hidden="true"></i>
                                <h4 class="heading mt-3 ml-0" id="spareLpoAmount"></h4>
                                <p class="text-muted m-0 font-weight-bold">Total Amount (LPO)</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js')

<script>
    $( document ).ready(function() {
        loadDashboardReport()
    });

    function loadDashboardReport(inventoryType, purchaseType, supplierId) {

        var purchaseType = $("#purchaseType").val();
        var supplierId = $("#supplierId").val();
        var spareSupplierId = $("#spareSupplierId").val();

        $.ajax({
            url: "{{ route('lpo-ajax-dashboard-report') }}",
            method: 'POST',
            data:{purchaseType: purchaseType, supplierId: supplierId, spareSupplierId: spareSupplierId, _token: "{{csrf_token()}}"},
            success: function (response) {
                console.log(response)
                $('#contractsCreated').html(response.contracts);
                $('#lposCreated').html(response.lpos);
                $('#bikesReceived').html(response.bikes_received);
                $('#bikesInfoUpload').html(response.bikes_info);
                $('#bikesRequested').html(response.bikes_requested);
                $('#lpoAmount').html(response.lpo_amount);

                $('#spareLpos').html(response.spare_lpos);
                $('#partsReceived').html(response.parts_received);
                $('#partsRequested').html(response.parts_requested);
                $('#spareLpoAmount').html(response.spare_lpo_amount);
            }
        });

    }

    $("#purchaseType").on('change',function(){
        loadDashboardReport()
    })

    $("#supplierId").on('change',function(){
        loadDashboardReport()
    })
    $("#spareSupplierId").on('change',function(){
        loadDashboardReport()
    })
</script>

@endsection
