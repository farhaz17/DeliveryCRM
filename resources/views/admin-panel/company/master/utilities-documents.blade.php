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
        <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>
<div class="card col-lg-12 mb-2">
    <div class="card-body">
        <h5>Electricity / Water</h5>
        <div class="row">
            @forelse ($electricity as $elect)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{$elect->company->name ?? "Na"}}</span>
                        <span class="text-primary">
                            <a href="{{ $elect->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $elect->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $elect->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
            <p>No attachment available!</p>
            @endforelse
        </div>
    </div>   
    <hr> 
    <div class="card-body">
        <h5>Etisalat</h5>
        <div class="row">
            @forelse ($etisalats as $etisalats)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{$etisalats->company->name ?? "Na"}}</span>
                        <span class="text-primary">
                            <a href="{{ $etisalats->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $etisalats->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $etisalats->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
            <p>No attachment available!</p>   
            @endforelse
        </div>
    </div>    
    <hr>
    <div class="card-body">
        <h5>Du</h5>
        <div class="row">
            @forelse ($dus as $du)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{ $du->company->name ?? "Na" }}</span>
                        <span class="text-primary">
                            <a href="{{ $du->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $du->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $elect->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
            <p>No attachment available!</p>       
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