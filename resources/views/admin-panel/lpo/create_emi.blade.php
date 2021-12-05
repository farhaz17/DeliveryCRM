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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Emi</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-emi') }}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="row">
            <div class="col-md-4 purchase-type">
                <label for="repair_category">Select Purchase Type</label>
                <select id="purchaseType" class="form-control" name="purchase_type">
                    <option value="" disabled selected>Select Purchase Type</option>
                    <option value="1">Rental</option>
                    <option value="2">Lease to Own</option>
                    <option value="3">Company</option>
                </select>
            </div>
            <div class="col-md-4 rental-lpo">
                <label for="repair_category">Select LPO</label>
                <select id="lpoId" class="form-control" name="lpo_id">
                    <option value="" disabled selected>Select LPO</option>
                </select>
            </div>
            <div  id="paymentCheckbox" class="col-md-12 form-group mb-3 payment-method" style="display: none">
                <br>
                <div>Payment Method</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="money_transfer" type="checkbox" id="moneyTransferCheck" value="1">
                    <label class="form-check-label mt-2" for="inlineCheckbox1">Money Transfer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="cash" type="checkbox" id="cashCheck" value="2">
                    <label class="form-check-label mt-2" for="inlineCheckbox2">Cash</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="cheque" type="checkbox" id="chequeCheck" value="3">
                    <label class="form-check-label mt-2" for="inlineCheckbox2">Cheque</label>
                </div>
            </div>
            <div class="col-md-4 transfer-amount" style="display: none">
                <label for="repair_category">Money Transfer Amount</label>
                <input id="" name="money_transfer_amount" class="form-control" type="number" placeholder="Amount">
            </div>
            <div class="col-md-4 cash-amount" style="display: none">
                <label for="repair_category">Cash Amount</label>
                <input id="" name="cash_amount" class="form-control" type="number" placeholder="Amount">
            </div>
            <div class="col-md-4 cheque" style="display: none">
                <label for="repair_category">Select Cheque</label>
                <select id="selectCheque" class="form-control select" name="cheque_id[]" multiple="multiple">
                    @foreach ($cheques as $cheque)
                        <option class="" value="{{ $cheque->id }}">{{ $cheque->cheque_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="selected-cheque col-12 ml-2"><br>
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

    $(document).on("change", "#purchaseType", function(){
        var token = $("input[name='_token']").val();
        var purchaseType  =  $(this).val();
        $('.appended-lpo').remove('.appended-lpo')
        $.ajax({
            url: "{{ route('ajax-filter-lpo-emi') }}",
            method: 'POST',
            data:{purchase_type:purchaseType,_token:token},
            success: function (response) {
                $.each(response, function(key,value){
                    $("#lpoId").append('<option class="appended-lpo" value="'+value.id+'">'+value.lpo_no+'</option>');
                });
            }
        });
    })



    $(document).on("change", "#lpoId", function(){
        $(".payment-method").show()
        var token = $("input[name='_token']").val();
        var lpoId  =  $(this).val();
        $('.appended-cheque').remove('.appended-cheque')
        $.ajax({
            url: "{{ route('ajax-fetch-lpo-cheque') }}",
            method: 'POST',
            data:{lpo:lpoId,_token:token},
            success: function (response) {
                $.each(response, function(key,value){
                    if(key == 0) {
                        $(".selected-cheque").append('<div class="appended-cheque">Assigned Guaranty Cheque</div>');
                    }
                    $(".selected-cheque").append('<div class="appended-cheque">Cheque No : ' + value.cheque.cheque_no + '</div>');
                });
            }
        });
    })

    $("#moneyTransferCheck").click(function() {
        if($(this).is(":checked"))
            $(".transfer-amount").show()
        else
            $(".transfer-amount").hide()
    })

    $("#cashCheck").click(function() {
        if($(this).is(":checked"))
            $(".cash-amount").show()
        else
            $(".cash-amount").hide()
    })

    $("#chequeCheck").click(function() {
        if($(this).is(":checked"))
            $(".cheque").show()
        else
            $(".cheque").hide()
    })

    $(document).ready(function() {

        $('#selectCheque').select2({
            placeholder: 'Select the cheque',
            width: '100%'
        });

    });
</script>


@endsection
