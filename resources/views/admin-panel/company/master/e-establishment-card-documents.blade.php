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
        <li class="breadcrumb-item active" aria-current="page">e-establishment</li>
    </ol>
</nav>
<div class="card col-lg-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3">License Documents</div>
        <div class="row">
            @forelse ($e_establishment_cards as $e_establishment_card)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{ $e_establishment_card->company->name }}</span>
                        <span class="text-primary">
                            <a href="{{ $e_establishment_card->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $e_establishment_card->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $e_establishment_card->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
            <p>No data attachment available!</p>
            @endforelse
        </div>
    </div>
</div>
<div class="card col-lg-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3">Ministry of Labour</div>
        <div class="row">
            @forelse ($labourCards as $labourCard)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{ $labourCard->company->name }}</span>
                        <span class="text-primary">
                            <a href="{{ $labourCard->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $labourCard->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $labourCard->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
                <p>No data attachment available!</p>
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