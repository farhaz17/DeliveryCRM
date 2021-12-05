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
        <li class="breadcrumb-item"><a href="{{ route('sim_wise_dashboard',['active'=>'master-menu-items']) }}">SIM Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sim Package Register</li>
    </ol>
</nav>
<form action="{{ route('sim_card_replace.store') }}" method="post" enctype="multipart/form-data">
@csrf
<div class="card col-md-8 offset-md-2 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Sim Package</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1">
                <label for="sim_id">Sim No</label>
                <select name="sim_id" id="" class="form-control form-control-sm">
                    <option value="">Select One</option>
                    @forelse ($sims as $sim)
                        <option value="{{ $sim->id }}">{{ $sim->account_number ?? '' }}</option>
                    @empty
                        
                    @endforelse
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="sim_sl_no">New Sim Serial No</label>
                <input class="form-control form-control-sm" id="sim_sl_no" type="text" placeholder="" name="sim_sl_no">
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="type">Reason of Replacement</label>
                <select name="reason" id="" class="form-control form-control-sm">
                    <option value="">Select One</option>
                   @foreach(get_sim_replace_reasons() as $index => $resons)
                    <option value="{{$index}}">{{ $resons }}</option>
                   @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="type">Paid By</label>
                <select name="paid_by" id="" class="form-control form-control-sm">
                    <option value="">Select One</option>
                    @foreach(get_paid_bys() as $index => $paid_by)
                    <option value="{{$index}}">{{ $paid_by }}</option>
                   @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="name">Amount</label>
                <input class="form-control form-control-sm" id="" type="number" placeholder="" name="amount">
            </div>
            <div class="col-md-2 form-group mb-1">
                <label for="">&nbsp;</label><br>
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
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@endsection