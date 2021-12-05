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
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'master-menu-items']) }}">Company Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Utilities</li>
    </ol>
</nav>
<div class="card col-md-8 offset-md-2 mb-2 pt-2 ">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Utilities</div>
        <hr>
        <h5>Electricity / Water</h5>
        <form action="{{route('company_master_utilities_water_electiricity_update', $electricity->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="">Company Name / License No</label>
                    <select class="form-control form-control-sm select2" name="company_id" >
                        <option value="">Select Company</option>
                        @forelse($electricity_companies as $company)
                            <option {{ $electricity->company_id == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty  
                            <p>No name available!</p>   
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="account_no">Account no.</label>
                    <input class="form-control form-control-sm" value="{{ $electricity->account_no ?? '' }}" type="text" placeholder="" name="account_no" id="account_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="account_type">Account types</label>
                    <select class="form-control form-control-sm" name="account_type" id="account_type">
                        <option value="">Select account Type</option>
                        <option  {{ $electricity->account_type == '1' ? 'selected' : '' }}  value="1">Commercial</option>
                        <option  {{ $electricity->account_type == '2' ? 'selected' : '' }}  value="2">Personal</option>
                    </select>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="business_partner">Business partner</label>
                    <input class="form-control form-control-sm" value="{{ $electricity->business_partner ?? '' }}" id="business_partner" type="text" placeholder="" name="business_partner">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="bill_name">Bill Name</label>
                    <input class="form-control form-control-sm" value="{{ $electricity->bill_name ?? '' }}" id="bill_name" type="text" placeholder="" name="bill_name">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="permise_number">Permise Number</label>
                    <input class="form-control form-control-sm" value="{{ $electricity->permise_number ?? '' }}" id="permise_number" type="text" placeholder="" name="permise_number">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="attachment">Attachment</label>
                    <input class="form-control-file form-control-sm" id="attachment" type="file" placeholder="" name="attachment">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('.select2').select2();
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