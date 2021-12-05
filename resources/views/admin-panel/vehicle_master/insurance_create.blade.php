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
        <li class="breadcrumb-item"><a href="{{ route('customer_supplier_wise_dashboard',['active'=>'master-menu-items']) }}">Customer | Supplier Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Insurance Register</li>
    </ol>
</nav>
<form action="{{ route('vehicle_insurance.store') }}" method="post" enctype="multipart/form-data">
@csrf
<div class="card col-md-8 offset-md-2 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Insurance</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1">
                <label for="name">Insurance</label>
                <input class="form-control form-control-sm" id="name" type="" placeholder="" name="name">
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="type">Insurance Type</label>
                <select name="type" id="type" class="form-control form-control-sm multi-select select2">
                    <option value="1">Health</option>
                    <option value="2">WMC</option>
                    <option value="3">Damage</option>
                </select>
            </div>
            <div class="col-md-2 form-group mb-1">
                <label for="">&nbsp;</label><br>
                <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
            </div>
        </div>
    </div>
</form>

</div>
<form  action="{{ route('insurance_network_type_save') }}"  method="post" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-8 offset-md-2 mt-4">
        <div class="card-body mt-3">
            <div class="card-title mb-3 col-12">Insurance Network Type</div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="type">Insurance Company</label>

                    <select name="insurance_company" id="insurance_company" class="form-control form-control-sm multi-select select2">
                        <option selected disabled >Select Option</option>

                        @foreach($insurance_company as $ins)
                            <option  value="{{$ins->id}}">{{$ins->name}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4 form-group mb-1">
                    <label for="name">Insurance Network Type  </label>
                    <input class="form-control form-control-sm" id="network_type" type="" placeholder="Add Insurance Network Type" name="network_type">
                </div>

                <div class="col-md-2 form-group mb-1">
                    <label for="">&nbsp;</label><br>
                    <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>
</form>


@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2({
        placeholder: 'Select an option'
    });
</script>

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
</script>

@endsection
