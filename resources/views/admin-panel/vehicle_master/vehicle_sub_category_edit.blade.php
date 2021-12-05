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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'master-menu-items']) }}">RTA Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
</nav>
<form action="{{ route('vehicle_sub_category.update', $vehicleSubCategory->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('put')
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Vehicle Category</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1">
                <label for="vehicle_category_id">Category Name</label>
                <select class="form-control form-control-sm" name="vehicle_category_id" id="vehicle_category_id">
                    @foreach ($vehicle_categories as $category)
                    <option {{ $vehicleSubCategory->vehicle_category_id == $category->id ? "selected" : ""}} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="name">Category Name</label>
                <input class="form-control form-control-sm" id="name" type="" placeholder="" name="name" value="{{ $vehicleSubCategory->name ?? '' }}">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();
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