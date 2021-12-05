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
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Contract</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-master-lpo') }}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="row">
            <div class="col-md-4">
                <label for="repair_category">Select Inventory</label><br>
                <input type="radio" id="vehicle" name="inventory_type" value="1" required>
                <label for="vehicle">Vehicle</label><br>
                <input type="radio" id="spare" name="inventory_type" value="2" required>
                <label for="spare">Spare Parts</label><br>
                <input type="radio" id="tracker" name="inventory_type" value="3" required>
                <label for="tracker">Tracker</label><br>
            </div>
            <div class="col-md-4">
                <div class="purchase-type" style="display: none">
                    <label for="repair_category">Select Purchase Type</label>
                    <select id="purchaseType" class="form-control" name="purchase_type">
                        <option value="" disabled selected>Select Purchase Type</option>
                        <option value="1">Rental</option>
                        <option value="2">Lease to Own</option>
                        <option value="3">Company</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4 company" style="display: none">
                <label for="repair_category">Select Company</label>
                <select id="inventoryType" class="form-control" name="company_id">
                    <option value="" disabled selected>Select Company</option>
                    @foreach ($companies as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 rental-supplier" style="display: none">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier_id">
                    <option value="" disabled selected>Select Supplier</option>
                    @foreach ($rental_supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 lease-to-own-supplier" style="display: none">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier_id">
                    <option value="" disabled selected>Select Supplier</option>
                    @foreach ($lease_supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 supplier" style="display: none">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier_id">
                    <option value="" disabled selected>Select Supplier</option>
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 rental-contract-no" style="display: none">
                <label for="repair_category">Select Contract Number</label>
                <select id="cardMethod" class="form-control" name="contract_id">
                    <option value="" disabled selected>Select Contract No</option>
                    @foreach ($rental_contract as $item)
                        <option value="{{ $item->id }}">{{ $item->contract_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 lease-to-own-contract-no" style="display: none">
                <label for="repair_category">Select Contract Number</label>
                <select id="cardMethod" class="form-control" name="contract_id">
                    <option value="" disabled selected>Select Contract No</option>
                    @foreach ($lease_contract as $item)
                        <option value="{{ $item->id }}">{{ $item->contract_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 quantity" style="display: none">
                <label for="repair_category">Quantity</label>
                <input id="" name="quantity" class="form-control" type="number">
            </div>
            <div class="col-md-4 amount" style="display: none">
                <label for="repair_category">Total Amount</label>
                <input id="" name="amount" class="form-control" type="number" required>
            </div>
            <div class="col-md-4 start-date" style="display: none">
                <label for="repair_category">Start Date</label>
                <input id="" name="start_date" class="form-control" type="date" required>
            </div>
            <div class="col-md-4 lpo-number" style="display: none">
                <label for="repair_category">LPO Number</label>
                <input id="" name="lpo_no" class="form-control" type="text" required>
            </div>
            <div class="col-md-4 cheque" style="display: none">
                <label for="repair_category">Select Cheque</label>
                <select id="selectCheque" class="form-control select" name="cheque_id[]" multiple="multiple">
                    @foreach ($cheques as $cheque)
                        <option class="" value="{{ $cheque->id }}">{{ $cheque->cheque_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 lpo-attachment" style="display: none">
                <label>LPO Attachment</label>
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="attachment">
                <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-md-12 mb-2 quantity-model-wrapper" style="display: none">
                <div class="field-wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="repair_category">Model</label>
                            <select id="model" class="form-control" name="inventory[0][model_id]">
                                <option value="" disabled selected>Select Model</option>
                                @foreach ($vehicle_models as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input name="inventory[0][vehicle_quantity]" class="form-control" type="text">
                        </div>
                        <div class="col-md-4 mt-4">
                            <a href="javascript:void(0);" class="btn btn-primary add-more-button">Add more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-2 spare-quantity-model" style="display: none">
                <div class="spare-field-wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="repair_category">Model</label>
                            <select id="model" class="form-control" name="inventory[0][model_id]">
                                <option value="" disabled selected>Select Model</option>
                                @foreach ($parts as $item)
                                    <option value="{{ $item->id }}">{{ $item->part_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input name="inventory[0][spare_quantity]" class="form-control" type="text">
                        </div>
                        <div class="col-md-4 mt-4">
                            <a href="javascript:void(0);" class="btn btn-primary add-more-button-spare">Add more</a>
                        </div>
                    </div>
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

    $('#selectState').select2({
        placeholder: 'Select the state',
        width: '100%'
    });

    var i = 1;
    var addButton = $('.add-more-button');
    var wrapper = $('.field-wrapper');

    $(addButton).click(function(){

        var fieldHTML = '<span class="row">'
            fieldHTML += '<div class="col-md-4"><label for="repair_category">Model</label><select id="model" class="form-control" name="inventory['+i+'][model_id]"><option value="" disabled selected>Select Model</option>'
            fieldHTML +=  '@foreach ($vehicle_models as $item)'
            fieldHTML +=     '<option value="{{ $item->id }}">{{ $item->name }}</option>'
            fieldHTML +=  '@endforeach'
            fieldHTML +=  '</select></div>'
            fieldHTML += '<div class="col-md-4"><label for="repair_category">Quantity</label><input name="inventory['+i+'][vehicle_quantity]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-4 mt-4"><a href="javascript:void(0);" class="btn btn-danger dlt-button">Delete</a></div>'
            fieldHTML += '</span>';

        $(wrapper).append(fieldHTML);
        i++; //Add field html
    });

    //Once remove button is clicked
    $(wrapperSpare).on('click', '.dlt-button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove(); //Remove field html
        i--;
    });


    var j = 1;
    var addButtonSpare = $('.add-more-button-spare');
    var wrapperSpare = $('.spare-field-wrapper');

    $(addButtonSpare).click(function(){

        var fieldHTMLSpare = '<span class="row">'
            fieldHTMLSpare += '<div class="col-md-4"><label for="repair_category">Model</label><select id="model" class="form-control" name="inventory['+j+'][model_id]"><option value="" disabled selected>Select Model</option>'
            fieldHTMLSpare +=  '@foreach ($parts as $items)'
            fieldHTMLSpare +=     '<option value="{{ $items->id }}">{{ $items->part_name }}</option>'
            fieldHTMLSpare +=  '@endforeach'
            fieldHTMLSpare +=  '</select></div>'
            fieldHTMLSpare += '<div class="col-md-4"><label for="repair_category">Quantity</label><input name="inventory['+j+'][spare_quantity]" class="form-control" type="text"></div>'
            fieldHTMLSpare += '<div class="col-md-4 mt-4"><a href="javascript:void(0);" class="btn btn-danger dlt-button-spare">Delete</a></div>'
            fieldHTMLSpare += '</span>';

        $(wrapperSpare).append(fieldHTMLSpare);
        j++; //Add field html
    });

    //Once remove button is clicked
    $(wrapperSpare).on('click', '.dlt-button-spare', function(e){
        e.preventDefault();
        $(this).parent().parent().remove(); //Remove field html
        j--;
    });

    $('input[name="inventory_type"]').on('change',function(){
        if( $(this).val() == "1"){
            $(".purchase-type").show()
            $(".quantity-model-wrapper").hide()
            $(".spare-quantity-model").hide()
            $(".rental-contract-no").hide()
            $(".lease-to-own-contract-no").hide()
            $(".supplier").hide()
            $(".rental-supplier").hide()
            $(".lease-to-own-supplier").hide()
            $(".quantity").hide()
            $(".amount").hide()
            $(".start-date").hide()
            $(".lpo-number").hide()
            $(".cheque").hide()
            $(".lpo-attachment").hide()
            $(".company").hide()
        }
        else if( $(this).val() == "2" ) {
            $(".quantity-model-wrapper").hide()
            $(".spare-quantity-model").show()
            $(".quantity").hide()
            $(".purchase-type").hide()
            $(".contract-no").hide()
            $("input[name='contract_id']").prop('required',false);
            $(".supplier").show()
            $(".rental-supplier").hide()
            $(".lease-to-own-supplier").hide()
            $(".rental-contract-no").hide()
            $(".lease-to-own-contract-no").hide()
            $(".amount").show()
            $(".start-date").show()
            $(".lpo-number").show()
            $(".cheque").show()
            $(".lpo-attachment").show()
            $(".company").show()
        }
        else if( $(this).val() == "3" ) {
            $(".quantity-model-wrapper").hide()
            $(".spare-quantity-model").hide()
            $(".quantity").show()
            $(".purchase-type").hide()
            $(".contract-no").hide()
            $("input[name='contract_id']").prop('required',false);
            $(".supplier").hide()
            $(".rental-supplier").hide()
            $(".lease-to-own-supplier").hide()
            $(".rental-contract-no").hide()
            $(".lease-to-own-contract-no").hide()
            $(".amount").show()
            $(".start-date").show()
            $(".lpo-number").show()
            $(".cheque").show()
            $(".lpo-attachment").show()
            $(".company").show()
        }
    });

    $(document).on("change", "#purchaseType", function(){
        if( $('#purchaseType').val() == "1"){
            $(".contract-no").show()
            $(".quantity-model-wrapper").hide()
            $(".spare-quantity-model").hide()
            $(".quantity").show()
            $("input[name='quantity']").prop('required',true);

            $(".supplier").hide()
            $(".rental-supplier").show()
            $(".lease-to-own-supplier").hide()

            $(".rental-contract-no").show()
            $(".lease-to-own-contract-no").hide()
            $(".company").hide()

            $(".amount").show()
            $(".start-date").show()
            $(".lpo-number").show()
            $(".cheque").show()
            $(".lpo-attachment").show()
        }
        else if( $('#purchaseType').val() == "2" ) {
            $(".contract-no").show()
            $(".quantity-model-wrapper").show()
            $(".spare-quantity-model").hide()
            $("input[name='quantity']").prop('required',false);
            $(".quantity").hide()

            $(".supplier").hide()
            $(".rental-supplier").hide()
            $(".lease-to-own-supplier").show()

            $(".rental-contract-no").hide()
            $(".lease-to-own-contract-no").show()

            $(".amount").show()
            $(".start-date").show()
            $(".lpo-number").show()
            $(".cheque").show()
            $(".lpo-attachment").show()
            $(".company").hide()
        }
        else if( $('#purchaseType').val() == "3" ) {
            $(".contract-no").hide()
            $(".quantity-model-wrapper").show()
            $(".spare-quantity-model").hide()
            $("input[name='quantity']").prop('required',false)
            $(".quantity").hide()
            $(".supplier").show()
            $(".rental-supplier").hide()
            $(".lease-to-own-supplier").hide()

            $(".rental-contract-no").hide()
            $(".lease-to-own-contract-no").hide()

            $(".amount").show()
            $(".start-date").show()
            $(".lpo-number").show()
            $(".cheque").show()
            $(".lpo-attachment").show()
            $(".company").show()
        }
    });

    $(document).ready(function() {

        $('#selectCheque').select2({
            placeholder: 'Select the cheque',
            width: '100%'
        });

    });

</script>


@endsection
