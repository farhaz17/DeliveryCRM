@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .list-body{
            height: 250px;
            overflow-y: auto;
        }
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">RTA Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vehicle Reports</li>
    </ol>
</nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Category Wise Bikes ( {{$vehicle_categories->sum('bikes_count')}} )</p>
                    <div class="card-body list-body list-body">
                        @foreach ($vehicle_categories as $vehicle_category)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $vehicle_category->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $vehicle_category->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div>  
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Model Wise Bikes ( {{$vehicle_models->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_models as $model)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $model->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $model->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div>        
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Plate Code Wise Bikes ( {{$vehicle_plate_codes->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_plate_codes as $plate_code)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $plate_code->plate_code ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $plate_code->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div>      
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Year Wise Bikes ( {{$vehicle_years->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_years as $year)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $year->year ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $year->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div>               
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Make Wise Bikes ( {{$vehicle_makes->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_makes as $make)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $make->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $make->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div> 
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Insurance Wise Bikes ( {{$vehicle_insurances->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_insurances as $insurance)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $insurance->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $insurance->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div>          
            <div class="col-md-6 col-lg-6 col-xl-3 mb-2" style="">
                <div class="card">
                    <p class="m-3">Mortgage Wise Bikes ( {{$vehicle_mortgages->sum('bikes_count')}} )</p>
                    <div class="card-body list-body">
                        @foreach ($vehicle_mortgages as $mortgage)
                            
                        <div class="ul-widget1">
                            <div class="ul-widget__item p-0">
                                <div class="ul-widget__info">
                                    <span class="small">{{ $mortgage->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="small">{{ $mortgage->bikes_count ?? 0 }}</span>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                </div>
            </div> 
        </div>
    </div>
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
</script>

@endsection