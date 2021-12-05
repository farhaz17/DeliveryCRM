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
        <li class="breadcrumb-item"><a href="">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Contract</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-cheque') }}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="row">
            <div class="col-md-4">
                <label for="repair_category">Select Bank</label>
                <select id="supplierType" class="form-control" name="bank">
                    <option value="" disabled selected>Select Bank</option>
                    <option value="1">RAK Bank</option>
                    <option value="2">ADCB</option>
                    <option value="2">NBD</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select Account</label>
                <select id="supplierType" class="form-control" name="account_no">
                    <option value="" disabled selected>Select Account</option>
                    <option value="1">1461</option>
                    <option value="2">1225</option>
                    <option value="2">1717</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select Company</label>
                <select id="cardMethod" class="form-control" name="company_id">
                    <option value="" disabled selected>Select Company</option>
                    @foreach ($companies as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 rental-supplier">
                <label for="repair_category">Select Bearer</label>
                <select id="cardMethod" class="form-control" name="bearer_id">
                    <option value="" disabled selected>Select Bearer</option>
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Cheque No</label>
                <input id="" name="cheque_no" class="form-control" type="text">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Amount</label>
                <input id="" name="amount" class="form-control" type="number">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Cheque Type</label>
                <select id="chequeType" class="form-control" name="cheque_type">
                    <option value="" disabled selected>Check Type</option>
                    <option value="1">PDC</option>
                    <option value="2">CDC</option>
                    <option value="3">Guaranty</option>
                </select>
            </div>
            <div class="col-md-4 pdc-date" style="display: none">
                <label for="repair_category">PDC Date</label>
                <input id="" name="pdc_date" class="form-control" type="date">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Category</label>
                <select id="cardMethod" class="form-control" name="category">
                    <option value="" disabled selected>Category</option>
                    <option value="1">Purchase</option>
                    <option value="2">EMI</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Attachment</label>
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="attachment">
                <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-md-12 text-center mt-2">
                <input type="submit" class="btn btn-primary" value="Add">
            </div>
        </div>
    </div>
</form>

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

    $('#selectCheque').select2({
        placeholder: 'Select the state',
        width: '100%'
    });

    $(document).on("change", "#chequeType", function(){
        if( $(this).val() == "1"){
            // console.log("1")
            $(".pdc-date").show()
        }
        else if($(this).val() == "2") {
            $(".pdc-date").hide()
        }
        else if($(this).val() == "3") {
            $(".pdc-date").hide()
        }
    })

</script>


@endsection
