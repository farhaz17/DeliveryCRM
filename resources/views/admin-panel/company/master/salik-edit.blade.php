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
<form action="{{ route('company_master_salik_update',$salik->id) }}" method="post" enctype="multipart/form-data" id="salik_form">
    @csrf
    @method('put')
    <div class="card col-md-8 mb-2 offset-md-2">
        <div class="card-title mb-3 col-12">Salik</div>
        <div class="card-body" id="add-more-salik-holder">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for=>Company Name / License No.</label>
                    <select class="form-control form-control-sm select2" name="company_id"  id="salik_company_id">
                        <option value="">Select Company</option>
                        @forelse($companies as $company)
                            <option  
                            data-state="{{ $company->state->name ?? '' }}"  
                            data-state-id="{{ $company->state->id ?? '' }}"   
                            value="{{ $company->id }}"
                            {{ $salik->company_id == $company->id ? 'selected' : ''}}
                            >{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty  
                            <p>No name available!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3 form-group mb-1" id="">
                    <label for="salik_state">State</label>
                    <input class="form-control form-control-sm" id="salik_state_list_block" value="{{ $salik->state->name ?? '' }}" type="text" disabled>
                    <input class="form-control form-control-sm" name="salik_state" value="{{ $salik->state_id ?? '' }}" id="salik_state_id" type="hidden">
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="salik_acc">Salik no.</label>
                    <input class="form-control form-control-sm" id="" type="text" value="{{ $salik->salik_acc ?? '' }}" placeholder="" name="salik_acc" id="salik_acc">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="salik_attachment">Salik Attachment</label>
                    <input class="form-control-file form-control-sm" name="salik_attachment" id="salik_attachment" type="file" placeholder="">
                </div>
                <div class="col-md-1">
                    {{-- <button class="btn btn-primary btn-sm" id="add_more_salik_btn" type="button">Add More</button> --}}
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
    $('#salik_company_id').change(function(){
        var state = $(this).find(':selected').attr('data-state');
        var state_id = $(this).find(':selected').attr('data-state-id');
        $('#salik_state_list_block').val(state);
        $('#salik_state_id').val(state_id);
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