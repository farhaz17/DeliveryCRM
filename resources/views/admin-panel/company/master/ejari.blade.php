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
        <li class="breadcrumb-item active" aria-current="page">Ejari</li>
    </ol>
</nav>
<form action="{{ route('company-master-ejari-store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Ejari</div>
            <div class="row">
                <div class="col-md-4 form-group mb-1">
                    <label for="">Company Name / License No</label>
                    <select class="form-control form-control-sm select2" name="company_id" >
                        <option value="">Select Company</option>
                        @forelse($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty
                        <p>No data name available!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="">Ejari Type</label>
                    <select class="form-control form-control-sm" name="ejari_type">
                        <option value="">Select Type</option>
                        <option value="0">Residential</option>
                        <option value="1">Commertial</option>
                        <option value="2">Value 3</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="">State</label>
                    <select class="form-control form-control-sm" name="state" id="state">
                        <option value="">Select State</option>
                        @forelse ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @empty

                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-1">
                    <label for="contract_no">Contract No:</label>
                    <input class="form-control form-control-sm" id="contract_no" type="" placeholder="" name="contract_no">
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="registration_date">Registration Date.</label>
                    <input class="form-control form-control-sm" id="registration_date" type="date" placeholder="" name="registration_date">
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-title mb-3 col-12">Tenancy Contract Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="issue_date">Issue Date</label>
                    <input class="form-control form-control-sm" id="issue_date" type="date" placeholder="" name="issue_date">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="expiry_date">Expiry Date</label>
                    <input class="form-control form-control-sm" id="expiry_date" type="date" placeholder="" name="expiry_date">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="contract_amount">Contract Amount:</label>
                    <input class="form-control form-control-sm" id="contract_amount" type="number" placeholder="" name="contract_amount">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="security_deposit">Security Deposit</label>
                    <input class="form-control form-control-sm" id="security_deposit" type="number" placeholder="" name="security_deposit">
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-title mb-3 col-12">Leased Unit</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="land_area">Land Area</label>
                    <input class="form-control form-control-sm" id="land_area" type="text" placeholder="" name="land_area">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="plot_no">Plot No.</label>
                    <input class="form-control form-control-sm" id="plot_no" type="text" placeholder="" name="plot_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="land_dm_no">Land DM No.</label>
                    <input class="form-control form-control-sm" id="land_dm_no" type="text" placeholder="" name="land_dm_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="makani_no">Makani No</label>
                    <input class="form-control form-control-sm" id="makani_no" type="text" placeholder="" name="makani_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="size">Size</label>
                    <input class="form-control form-control-sm" id="size" type="text" placeholder="" name="size">
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-title mb-3 col-12">Shared Company</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 form-group mb-1">
                    <label for="">Company Name / License No</label>
                    <select class="form-control form-control-sm select2" multiple name="shared_company_ids[]" >
                        <option value="">Select Company</option>
                        @forelse($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
                        @empty
                        <p>No data name available!</p>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-title mb-3 col-12">PDC Payments</div>
        <div class="card-body" id="pdc-payments-list">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label for="">Check No</label>
                    <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_check_no[]">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="">Account Name.</label>
                    <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_company_account_name[]">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="">Account No.</label>
                    <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_company_account_no[]">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="">Date</label>
                    <input class="form-control form-control-sm" id="" type="date" placeholder="" name="pdc_date[]">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="">Amount</label>
                    <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_amount[]">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="">Upload Ejari Document</label>
                    <input class="form-control-file form-control-sm" id="" type="file" placeholder="" name="pdc_attachment[]">
                </div>
                <div class="col-md-1 form-group mb-1">
                    <label for=""></label>
                    <button class="btn btn-primary btn-sm" type="button" id="add-more-pdc-payments">Add more</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <button type="submit" class="btn btn-primary" id="">Submit</button>
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
    var pdc_payments_row_number = 1;
    $('#add-more-pdc-payments').click(function(){
        var new_pdc_payments_row = `<div class="row border-top m-10" id="row`+pdc_payments_row_number+`">
            <div class="col-md-3 form-group mb-1">
                <label for="">Check No</label>
                <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_check_no[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Account Name.</label>
                <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_company_account_name[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Account No.</label>
                <input class="form-control form-control-sm" id="" type="number" placeholder="" name="pdc_company_account_no[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Date</label>
                <input class="form-control form-control-sm" id="" type="date" placeholder="" name="pdc_date[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Amount</label>
                <input class="form-control form-control-sm" id="" type="number" placeholder=""  name="pdc_amount[]">
            </div>
            <div class="col-md-3 form-group mb-1">
                <label for="">Upload Ejari Document</label>
                <input class="form-control-file form-control-sm" id="" type="file" placeholder="" name="pdc_attachment[]">
            </div>
            <div class="col-md-1 form-group mb-1">
                <label for=""></label>
                <button class="btn btn-danger btn-sm delete_btn" data-row_id = "row`+pdc_payments_row_number+`">Delete Payment</button>
            </div>
        </div>`;
        $('#pdc-payments-list').append(new_pdc_payments_row);
        pdc_payments_row_number++
    });
    $(document).ready(function(){
        $('#pdc-payments-list').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
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
