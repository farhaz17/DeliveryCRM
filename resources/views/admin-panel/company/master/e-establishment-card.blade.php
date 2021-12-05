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
        <li class="breadcrumb-item active" aria-current="page">eEtablishment</li>
    </ol>
</nav>
<form id="moi_form" action="{{ route('company_establishment_card_store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">eEstablishment Card</div>
            <div class="row">
                <div class="col-md-6 form-group mb-1">
                    <label for="">Company Name / Company No</label>
                    <select class="form-control form-control-sm" name="company_id">
                        <option value="">Select Company Name / Company No</option>
                        @forelse($establishment_companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty 
                        <p>No data Name available!</p> 
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="moi_no">MOI No.</label>
                    <input class="form-control form-control-sm" id="moi_no" type="text" placeholder="" name="moi_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="issue_date">Issue Date</label>
                    <input class="form-control form-control-sm" id="issue_date" type="date" placeholder="" name="issue_date">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="expiry_date">Expiry Date</label>
                    <input class="form-control form-control-sm" id="expiry_date" type="date" placeholder="" name="expiry_date">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="state_id">Partners / Signing Authority</label>
                    <select class="form-control form-control-sm select2" multiple name="moi_partners[]" id="moi_partners" required>
                        <option value="">Select Partner</option>
                        @forelse ($partners as $partner)
                            <option value="{{$partner->id}}">{{ $partner->sur_name ?? "Na" }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="moi_attachment">eEstablishment Attachment</label>
                    <input class="form-control-file form-control-sm" id="moi_attachment" type="file" placeholder="" name="attachment">
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="mol_form" action="{{ route('company_labour_card_store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-8 offset-md-2 mb-2 pt-2 ">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Ministry of Labour</div>
            <div class="row">
                <div class="col-md-6 form-group mb-1">
                    <label for="company_id">Company Name / License No</label>
                    <select class="form-control form-control-sm select2" name="company_id" id="company_id">
                        <option value="">Select Company Name / Company No</option>
                        @forelse($labour_card_companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty  
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="mol_no">MOL No</label>
                    <input type="text" class="form-control" name="mol_no" id="mol_no" />
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="issue_date">Issue date</label>
                    <input type="date" class="form-control" name="issue_date" id="issue_date" />
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="expiry_date">Expiry date</label>
                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" />
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="state_id">Partners / Signing Authority</label>
                    <select class="form-control form-control-sm select2" multiple name="mol_partners[]" id="mol_partners" required>
                        <option value="">Select Partner</option>
                        @forelse ($partners as $partner)
                            <option value="{{$partner->id}}">{{ $partner->sur_name ?? "Na" }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="labour_card_attachment">Labour Attachment</label>
                    <input type="file" class="form-control-file" name="labour_card_attachment" id="labour_card_attachment"/>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm">Submit</button>
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