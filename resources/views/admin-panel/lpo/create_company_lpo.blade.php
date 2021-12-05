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

<form method="post" action="" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="row">
            <div class="col-md-4">
                <label for="repair_category">Select Type</label>
                <select id="cardMethod" class="form-control" name="exchange_method">
                    <option value="" disabled selected>Select Type</option>
                    <option value="1">Company</option>
                    <option value="2">Lease to Own</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select Supplier</label>
                <select id="cardMethod" class="form-control" name="supplier">
                    <option value="" disabled selected>Select Supplier</option>
                    <option value="1">Supplier 1</option>
                    <option value="2">Supplier 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Select EMI</label>
                <select id="cardMethod" class="form-control" name="supplier">
                    <option value="" disabled selected>Select EMI</option>
                    <option value="1">EMI 1</option>
                    <option value="2">EMI 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="repair_category">Total Amount</label>
                <input id="" name="amount" class="form-control" type="number">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Start Date</label>
                <input id="" name="start_date" class="form-control" type="date">
            </div>
            <div class="col-md-4">
                <label for="repair_category">End Date</label>
                <input id="" name="end_date" class="form-control" type="date">
            </div>
            <div class="col-md-4">
                <label for="repair_category">LPO Number</label>
                <input id="" name="lpo_no" class="form-control" type="text">
            </div>
            <div class="col-md-4">
                <label>LPO Attachment</label>
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="attachment">
                <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="field-wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="repair_category">Model</label>
                            <input name="lulu_details[0][remarks]" class="form-control" type="text">
                        </div>
                        <div class="col-md-4">
                            <label for="repair_category">Quantity</label>
                            <input name="lulu_details[0][remarks]" class="form-control" type="text">
                        </div>
                        <div class="col-md-4 mt-4">
                            <a href="javascript:void(0);" class="btn btn-primary add-more-button">Add more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-4">
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

    var i = 0;
    var addButton = $('.add-more-button');
    var wrapper = $('.field-wrapper');

    $(addButton).click(function(){

        var fieldHTML = '<span class="row">'
            fieldHTML += '<div class="col-md-4"><label for="repair_category">Model</label><input name="lulu_details[0][remarks]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-4"><label for="repair_category">Quantity</label><input name="lulu_details[0][remarks]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-4 mt-4"><a href="javascript:void(0);" class="btn btn-danger dlt-button">Delete</a></div>'
            fieldHTML += '</span>';

        $(wrapper).append(fieldHTML);
        i++; //Add field html
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.dlt-button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove(); //Remove field html
        i--;
    });

</script>


@endsection
