@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'master-menu-items']) }}">RTA Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tracking Inventory Register</li>
    </ol>
</nav>
<form action="{{ route('vehicle_tracking_inventory.store') }}" method="post" enctype="multipart/form-data">
@csrf
<div class="card col-md-8 offset-md-2 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Tracking Inventory</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1">
                <label for="tracking_no">Tracking Inventory</label>
                <input class="form-control form-control-sm" id="tracking_no" type="" placeholder="" name="tracking_no">
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="repair_category">Select LPO</label>
                <select id="lpo" class="form-control form-control-sm" name="lpo_id" required>
                    <option value="" disabled selected>Select LPO</option>
                    @foreach ($lpos as $lpo)
                        <option value="{{ $lpo->id }}">{{ $lpo->lpo_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="name">&nbsp;</label><br>
                <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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
