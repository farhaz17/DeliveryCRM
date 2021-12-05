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
      <li class="breadcrumb-item active" aria-current="page">MOA</li>
    </ol>
</nav>
<form action="{{route('company-master-moa-store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Memorandum of Association</div>
            <div class="row">
                <div class="col-md-6 form-group mb-1">
                    <label for="">Company Name / License No</label>
                    <select class="form-control form-control-sm select2" name="company_id">
                        <option value="">Select Company Name / Company No</option>
                        @forelse($moa_companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty  
                        <p>No name available!</p>
                        @endforelse
                    </select>
                </div>

            </div>
            <div id="moa-list-holder">
                <div class="row">
                    <div class="col-md-4 form-group mb-1">
                        <label for="">MOA Date</label>
                        <input class="form-control form-control-sm" id="" type="Date" placeholder="" name="moa_date[]">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="">MOA No.</label>
                        <input class="form-control form-control-sm" id="" type="Number" placeholder="" name="moa_no[]">
                    </div>
                    <div class="col-md-3 form-group mb-1">
                        <label for="">Attachment</label>
                        <input class="form-control-file form-control-sm" id="" type="file" placeholder="" name="moa_attachment[]">
                    </div>
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary btn-sm float-right" type="button" id="add-more-moa">Add Moa</button>
                    </div>
                </div>
            </div>
            <br>
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
    var moa_row_number = 1;
    $('#add-more-moa').click(function(){
        var new_activity_row = `<div class="row" id="moa_row`+moa_row_number+`">
            <div class="col-md-4 form-group mb-1">
                <label for="">MOA Date</label>
                <input class="form-control form-control-sm" type="Date" placeholder="" name="moa_date[]">
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="">MOA No.</label>
                <input class="form-control form-control-sm" type="Number" placeholder="" name="moa_no[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Attachment</label>
                <input class="form-control-file form-control-sm" id="" type="file" placeholder="" name="moa_attachment[]">
            </div>
            <div class="col-md-1 form-group mb-1">
                <label for="">&nbsp;</label>
                <button class="btn btn-danger btn-sm delete_moa" type="button" data-moa_row_id = "moa_row`+moa_row_number+`">Delete </button>
            </div>
        </div>`;
        $('#moa-list-holder').append(new_activity_row);
        moa_row_number++
    });
    $(document).ready(function(){
        $('#moa-list-holder').on('click', '.delete_moa', function() {
            var ids = $(this).attr('data-moa_row_id');
            $("#"+ids).remove();
        });
    });
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