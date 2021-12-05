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
        <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>
<form action="{{ route('company_master_traffic_update',$traffic->id) }}" method="post" enctype="multipart/form-data" id="traffic_form">
    @csrf
    @method('put')
    <div class="card col-md-8 mb-2 offset-md-2">
        <div class="card-title mb-3 col-12">Traffic</div>
        <div class="card-body" id="add-more-traffic-holder">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="company_id">Company Name / License No.</label>
                    <select class="form-control form-control-sm select2" name="company_id" id="traffic_company_id"> 
                        <option value="" >Select Company</option>
                        @forelse($companies as $company)
                            <option 
                            data-state="{{ $company->state->name ?? '' }}"
                            data-state-id="{{ $company->state->id ?? '' }}" 
                            value="{{ $company->id }}"
                            {{ $company->id == $traffic->company_id ? 'selected' : ''}}
                            >{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty  
                        <p>No name available!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_state">State</label>
                    <input class="form-control form-control-sm" id="traffic_state_list_block" value="{{ $traffic->state->name ?? '' }}" disabled>
                    <input class="form-control form-control-sm" type="hidden" value="{{ $traffic->state_id ?? '' }}" name="traffic_state" id="traffic_state_id">
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="traffic_fle_no">Trafic file no.</label>
                    <input class="form-control form-control-sm" id="" value="{{ $traffic->traffic_file_no ?? '' }}" type="text" placeholder="" name="traffic_file_no" id="traffic_file_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_attachment">Traffic Attachment</label>
                    <input class="form-control-file form-control-sm" name="traffic_attachment" id="traffic_attachment" type="file" placeholder="">
                </div>
                <div class="col-md-1">
                    {{-- <button class="btn btn-primary btn-sm" id="add_more_traffic_btn" type="button">Add more</button> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
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
    $('.select2').select2();
</script>
<script>
    
    $('#traffic_company_id').change(function(){
        var state = $(this).find(':selected').attr('data-state');
        var state_id = $(this).find(':selected').attr('data-state-id');
        $('#traffic_state_list_block').val(state);
        $('#traffic_state_id').val(state_id);
    });

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