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
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'documents-menu-items']) }}">Company Documents</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ejari</li>
    </ol>
</nav>
    <div class="card col-md-12  mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Ejari</div>
            <div class="row">
                @forelse ($ejaris as $ejari)
                <h4 class="t-font-bolder col-12">{{ $ejari->company->name ?? "No Title Avilable" }}</h4>
                    @forelse(json_decode($ejari->pdc_attachment) as $pdc_att)
                    <div class="col-md-4 text-left mb-3">
                        <div class="ul-widget-app__social-friends">
                            <div class="ul-widget-app__small-title">
                                <span class="t-font-bolder">
                                    <i class="nav-icon i-File-Horizontal-Text text-16"></i> 
                                    {{-- {{ $ejari->name }}</span>  --}}
                                <span class="text-primary">
                                    <a href="{{ $pdc_att ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $pdc_att ?? asset('assets/images/faces/3.jpg')}}" download="{{ $pdc_att }}">Download</a>
                                </span>
                            </div>
                        </div>
                    </div> 
                    @empty
                    <p>No data attachment available!</p>
                    @endforelse
                @empty
                <p>No data ejari available!</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
</script>

<script>
function tostr_display(type,message){
    switch(type){
        case 'info':
            toastr.info(message);
            break;
        case 'warning':
            toastr.warning(message);
            break;
        case 'success':
            toastr.success(message);
            break;
        case 'error':
            toastr.error(message);
            break;
    }
}
</script>
@endsection