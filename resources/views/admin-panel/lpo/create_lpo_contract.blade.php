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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Contract</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-lpo-contract') }}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="row">
            <div class="col-md-4">
                <label for="repair_category">Select Supplier Category</label>
                <select id="supplierType" class="form-control" name="supplier_category_id">
                    <option value="" disabled selected>Select Type</option>
                    <option value="1">Rental</option>
                    <option value="2">Lease to Own</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select Company</label>
                <select id="inventoryType" class="form-control" name="company_id">
                    <option value="" disabled selected>Select Company</option>
                    @foreach ($companies as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Contract Number</label>
                <input id="" name="contract_no" class="form-control" type="text">
            </div>
            <div class="col-md-4 rental-supplier">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier_id">
                    <option value="" disabled selected>Select Supplier</option>
                    @foreach ($rental_supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 lease-supplier" style="display: none">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier_id">
                    <option value="" disabled selected>Select Supplier</option>
                    @foreach ($lease_supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Quantity</label>
                <input id="" name="quantity" class="form-control" type="number">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select State</label>
                <select id="selectState" name="state_id[]" class="form-control select" multiple="multiple">
                    <option value="">Select State</option>
                    @foreach ($cities as $city)
                        <option value="{{$city->id}}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Create Date</label>
                <input id="" name="create_date" class="form-control" type="date">
            </div>
            <div class="col-md-4">
                <label>Attachment</label>
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="attachment">
                <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <input type="submit" class="btn btn-primary" value="Add">
            </div>
        </div>
    </div>
</form>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
            break;
    }
    @endif

    $('#selectState').select2({
        placeholder: 'Select the state',
        width: '100%'
    });

    $('#supplierType').on('change',function(){
        if( $('#supplierType').val() == "1"){
            $(".rental-supplier").show()
            $(".lease-supplier").hide()
        }
        else if( $('#supplierType').val() == "2" ) {
            $(".rental-supplier").hide()
            $(".lease-supplier").show()
        }
    });

</script>


@endsection
