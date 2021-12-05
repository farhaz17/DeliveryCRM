@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 400px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }

        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
        .payment-method-details{
            display: none;
        }
        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
        }
        table {
            position: relative;
        }
        .wait-loader-paginate {
            position: absolute;
            left: 35%;
            top: 30%;
        }
        #excelDownload {
            background:url(assets/images/file-excel.svg) no-repeat;
            color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
        }
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wps_dashboard',['active'=>'reports-menu-items']) }}">WPS Reports</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pay Master</li>
    </ol>
</nav>

<div class="container text-left mb-4">
    <div class="form-check-inline mb-4">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <label for="repair_category">Filter By Company</label>
        <select id="companyName" class="form-control" class="company_cls" name="company_name">
            <option value="" selected>Select Company</option>
            <option value="0">All Employees</option>
            @foreach($company as $com)
                <option value="{{$com->id}}">{{$com->name}} ({{ isset($com->total_employee) ? $com->total_employee : '0' }})</option>
            @endforeach
        </select>
    </div>

    <div class="wait-loader text-center" style="display: none"><img src="{{asset('assets/images/load-gif.gif')}}" width="400" /></div>
    <div class="container card wps-ajax-employee pt-3 pb-3" style="display: none">
        {{-- <div class="mt-3 font-weight-bold">Employee List</div>
        <div class="form-group table-search mt-2" style="display: none">
            <form class="w-50 float-left mt-2" method="POST" action="{{ route('wps-export') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="company_id" id="companyId" value="">
                <input type="image" src={{asset('assets/images/file-excel.svg')}} id="excelDownload"/>
            </form>
            <input type="text" name="search" id="search" class="form-control w-50 float-right" placeholder="Search" />
        </div>
        <div class="ajax-list-employee"></div> --}}
        <div class="row">
            <table class="table table-sm table-hover text-10 data_table_cls">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Full Name</th>
                        <th>Passport No</th>
                        <th>PPUID</th>
                        <th>ZDS Code</th>
                        <th>Labour card No</th>
                        <th>Person Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<div class="container">
    <div class="card col-lg-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3">Pay Master</div>

            <div class="container card selected_passport" style="display: none">
                <div class="mt-3 font-weight-bold">Selected Employee</div>
                <table class="display table table-striped table-bordered mt-3" id="datatable_passport">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 100px">PP UID</th>
                        <th scope="col" style="width: 100px">Passport No</th>
                        <th scope="col" style="width: 100px">Name</th>
                        <th scope="col" style="width: 100px">ZDS Code</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="pp_uid"></td>
                            <td id="passport_no"></td>
                            <td id="full_name"></td>
                            <td id="zds_code"></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <form method="post" action="{{ route('store-wps-pay-master') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="row m-4">
                    <div class="col-md-6 form-group  mb-3">
                        <label for="repair_category">Search Employee</label><br>
                        <div class="input-group ">
                            <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                            <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                            {{-- <div id="clear">
                                X
                            </div> --}}
                        </div>
                    </div>
                    <input type="hidden" name="passport_id" />
                    <div class="col-md-6 form-group mb-3">
                        <label for="repair_category">Payment Method</label>
                        <select id="paymentMethod" class="form-control" name="payment_method" required>
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="1">Exchange (Bank/Card)</option>
                            <option value="2">Office Cash</option>
                            <option value="3">Exchange Cash</option>
                        </select>
                    </div>
                    <div class="payment-details-span col-md-12 nopadding">
                        <div  id="paymentCheckbox" class="col-md-12 form-group mb-3 payment-method-details">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="c3_checkbox" type="checkbox" id="c3Checkbox" value="1">
                                <label class="form-check-label mt-2" for="inlineCheckbox1">C3 Card</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="lulu_checkbox" type="checkbox" id="luluCardCheckbox" value="2">
                                <label class="form-check-label mt-2" for="inlineCheckbox2">Lulu Card</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="bank_checkbox" type="checkbox" id="bankCheckbox" value="3">
                                <label class="form-check-label mt-2" for="inlineCheckbox2">Bank Details</label>
                            </div>
                        </div>
                        <div id="paymentMethodExchange" class="col-md-6 form-group mb-3 payment-method-details">
                            <label for="repair_category">Exchange</label>
                            <select id="exchangeMethod" class="form-control" name="exchange_method">
                                <option value="" disabled selected>Select Exchange</option>
                                <option value="1">Bank</option>
                                <option value="2">Card</option>
                                <option value="3">Exchange</option>
                            </select>
                        </div>
                        <div  id="paymentMethodCard" class="col-md-6 form-group mb-3 payment-method-details">
                            <div class="">
                                <label for="repair_category">Card</label>
                                <select id="cardMethod" class="form-control" name="exchange_method">
                                    <option value="" disabled selected>Select Card</option>
                                    <option value="1">C3</option>
                                    <option value="2">Lulu</option>
                                </select>
                            </div>
                        </div>
                    <div  id="paymentMethodBank" class="col-md-12 form-group mb-3 payment-method-details">
                        <div class="field-wrapper">
                            <h4>Bank Details</h4>
                            {{-- <span class="mt-4 ml-2 text-success font-weight-bold text-left">Active Account</span> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="bank_details[0][active]" value="bank_details[0]">
                                    <label for="repair_category">Bank Name</label>
                                    <input id="activeBankDetails" name="bank_details[0][bank_name]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">IBAN No</label>
                                    <input id="activeDetails" name="bank_details[0][iban_no]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label>Attachment</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="bank_details[0][attachment]">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Remarks</label>
                                    <input name="bank_details[0][bank_remarks]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bank_radio" value="bank_details[0]" required>
                                        <label class="form-check-label mt-2" for="inlineRadio1">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <a href="javascript:void(0);" class="btn btn-primary add-more-bank-button">Add more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  id="paymentMethodCardDetails" class="col-md-12 form-group mb-3 payment-method-details">
                        <div class="field-wrapper-card">
                            <h4>C3 Card Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="c_three_details[0][active]" value="c_three_details[0]">
                                    <label for="repair_category">Card No</label>
                                    <input name="c_three_details[0][card_no]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Code No</label>
                                    <input name="c_three_details[0][code_no]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Expiry</label>
                                    <input  name="c_three_details[0][expiry]" class="form-control" type="date">
                                </div>
                                <div class="col-md-6">
                                    <label>Attachment</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="c_three_details[0][attachment]">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Remarks</label>
                                    <input name="c_three_details[0][remarks]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bank_radio" value="c_three_details[0]">
                                        <label class="form-check-label mt-2" for="inlineRadio1">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <a href="javascript:void(0);" class="btn btn-primary add-more-card-button">Add more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  id="paymentMethodLuluCardDetails" class="col-md-12 form-group mb-3 payment-method-details">
                        <div class="field-wrapper-lulu">
                            <h4>Lulu Card Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="lulu_details[0][active]" value="lulu_details[0]">
                                    <label for="repair_category">Card No</label>
                                    <input name="lulu_details[0][card_no]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Code No</label>
                                    <input name="lulu_details[0][code_no]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Expiry</label>
                                    <input  name="lulu_details[0][expiry]" class="form-control" type="date">
                                </div>
                                <div class="col-md-6">
                                    <label>Attachment</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="lulu_details[0][attachment]">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Remarks</label>
                                    <input name="lulu_details[0][remarks]" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bank_radio" value="lulu_details[0]">
                                        <label class="form-check-label mt-2" for="inlineRadio1">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <a href="javascript:void(0);" class="btn btn-primary add-more-lulu-button">Add more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="paymentMethodBank" class="col-md-6 form-group mb-3 payment-method-details">
                        <label for="repair_category">Payment Method Bank</label>
                        <input name="payment_details_bank"  class="form-control" type="text">
                    </div> --}}
                    <div id="paymentMethodHand" class="col-md-6 form-group mb-3 payment-method-details">
                        <label for="repair_category">Payment Method Hand</label>
                        <select class="form-control" name="by_hand_id">
                            <option value="1">By Hand</option>
                            <option value="2">Lulu</option>
                        </select>
                    </div>
                </div>
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="Add">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="card mt-3">
        <div class="card-header">
            Import Excel
        </div>
        <div class="card-body">
            <a href="{{asset('assets/docs/wps-sample.xlsx')}}" class="btn btn-primary mb-2" download="wps-sample.xlsx">Download Sample</a>
            <form action="{{ route('wps-details-import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="excelFile" name="excel_file">
                <label class="custom-file-label" for="excelFile">Choose file</label>
                </div>
                <br>
                <button class="btn btn-success" type="submit">Import Bulk Data</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('js/custom_js/wps_pay_master.js') }}"></script>

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


<script>
    $('#paymentMethod').on('change',function(){
        if( $('#paymentMethod').val() == "1"){
            $("#paymentCheckbox").show()
            $(".payment-details-span").show()
        }
        else if( $('#paymentMethod').val() == "2" ) {
            // $("#paymentCheckbox").hide()
            $(".payment-details-span").hide()
            $("input[name=bank_radio]").prop('required', false);
        }
        else if( $('#paymentMethod').val() == "3" ) {
            // $("#paymentCheckbox").hide()
            $(".payment-details-span").hide()
            $("input[name=bank_radio]").prop('required', false);
        }
    });

    $("#c3Checkbox").click(function() {
        if($(this).is(":checked"))
            $("#paymentMethodCardDetails").show()
        else
            $("#paymentMethodCardDetails").hide()
    })

    $("#luluCardCheckbox").click(function() {
        if($(this).is(":checked"))
            $("#paymentMethodLuluCardDetails").show()
        else
            $("#paymentMethodLuluCardDetails").hide()
    })

    $("#bankCheckbox").click(function() {
        if($(this).is(":checked"))
            $("#paymentMethodBank").show()
        else
            $("#paymentMethodBank").hide()
    })

    var i = 1;
    var j = 1;
    var k = 1;

    var addButton = $('.add-more-bank-button');
    var wrapper = $('.field-wrapper');

    $(addButton).click(function(){

        var fieldHTML = '<span class="row">'
            fieldHTML += '<input type="hidden" name="bank_details['+i+'][active]" value="bank_details['+i+']">'
            fieldHTML += '<div class="col-md-6 mt-2"> <label for="repair_category">Bank Name</label><input name="bank_details['+i+'][bank_name]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-6 mt-2"> <label for="repair_category">IBAN No</label><input name="bank_details['+i+'][iban_no]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-6 mt-2"> <label>Attachment</label><div class="custom-file mb-3"><input type="file" class="custom-file-input" id="customFile" name="bank_details['+i+'][attachment]"><label class="custom-file-label" for="customFile">Choose file</label></div></div>'
            fieldHTML += '<div class="col-md-6 mt-2"> <label for="repair_category">Remarks</label><input name="bank_details['+i+'][bank_remarks]" class="form-control" type="text"></div>'
            fieldHTML += '<div class="col-md-6 mt-2"><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="bank_radio" value="bank_details['+i+']"><label class="form-check-label mt-2" for="inlineRadio1">Active</label></div></div>'
            fieldHTML += '<div class="col-md-4 mt-2"><a href="javascript:void(0);" class="btn btn-danger dlt-button">Delete</a></div>'
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

    //Add More Card
    var addButtonCard = $('.add-more-card-button');
    var wrapperCard = $('.field-wrapper-card');

    $(addButtonCard).click(function(){

        var fieldHTMLCard = '<span class="row">'
            fieldHTMLCard += '<input type="hidden" name="c_three_details['+j+'][active]" value="c_three_details['+j+']">'
            fieldHTMLCard += '<div class="col-md-6 mt-2"> <label for="repair_category">Card No</label><input id="cardTest" name="c_three_details['+j+'][card_no]" class="form-control" type="text"></div>'
            fieldHTMLCard += '<div class="col-md-6 mt-2"> <label for="repair_category">Code No</label><input name="c_three_details['+j+'][code_no]" class="form-control" type="text"></div>'
            fieldHTMLCard += '<div class="col-md-6 mt-2"> <label for="repair_category">Expiry</label><input name="c_three_details['+j+'][expiry]" class="form-control" type="date"></div>'
            fieldHTMLCard += '<div class="col-md-6 mt-2"> <label>Attachment</label><div class="custom-file mb-3"><input type="file" class="custom-file-input" id="customFile" name="c_three_details['+j+'][attachment]"><label class="custom-file-label" for="customFile">Choose file</label></div></div>'
            fieldHTMLCard += '<div class="col-md-6 mt-2"> <label for="repair_category">Remarks</label><input name="c_three_details['+j+'][remarks]" class="form-control" type="text"></div>'
            fieldHTMLCard += '<div class="col-md-6 mt-2"><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="bank_radio" value="c_three_details['+j+']"><label class="form-check-label mt-2" for="inlineRadio1">Active</label></div></div>'
            fieldHTMLCard += '<div class="col-md-4 mt-2"><a href="javascript:void(0);" class="btn btn-danger dlt-button-card">Delete</a></div>'
            fieldHTMLCard += '</span>';

        $(wrapperCard).append(fieldHTMLCard); //Add field html
        j++;
    });

    $(wrapperCard).on('click', '.dlt-button-card', function(e){
        e.preventDefault();
        $(this).parent().parent().remove(); //Remove field html
        j--;
    });


    var addButtonLulu = $('.add-more-lulu-button');
    var wrapperLulu = $('.field-wrapper-lulu');

    $(addButtonLulu).click(function(){
        var fieldHTMLLulu = '<span class="row">'
            fieldHTMLLulu += '<input type="hidden" name="lulu_details['+k+'][active]" value="lulu_details['+k+']">'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"> <label for="repair_category">Card No</label><input id="cardTest" name="lulu_details['+k+'][card_no]" class="form-control" type="text"></div>'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"> <label for="repair_category">Code No</label><input name="lulu_details['+k+'][code_no]" class="form-control" type="text"></div>'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"> <label for="repair_category">Expiry</label><input name="lulu_details['+k+'][expiry]" class="form-control" type="date"></div>'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"> <label>Attachment</label><div class="custom-file mb-3"><input type="file" class="custom-file-input" id="customFile" name="lulu_details['+k+'][attachment]"><label class="custom-file-label" for="customFile">Choose file</label></div></div>'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"> <label for="repair_category">Remarks</label><input name="lulu_details['+k+'][remarks]" class="form-control" type="text"></div>'
            fieldHTMLLulu += '<div class="col-md-6 mt-2"><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="bank_radio" value="c_three_details['+k+']"><label class="form-check-label mt-2" for="inlineRadio1">Active</label></div></div>'
            fieldHTMLLulu += '<div class="col-md-4 mt-2"><a href="javascript:void(0);" class="btn btn-danger dlt-button-card">Delete</a></div>'
            fieldHTMLLulu += '</span>';
        $(wrapperLulu).append(fieldHTMLLulu); //Add field html
        k++;
    });

    $(wrapperLulu).on('click', '.dlt-button-card', function(e){
        e.preventDefault();
        $(this).parent().parent().remove(); //Remove field html
        k--;
    });



    $('#companyName').change(function () {
        var id = $(this).val();
        $("input[name='company_id']").val(id);
        $('table.data_table_cls').DataTable().destroy();
        $('.wps-ajax-employee').show();
        all_load_data(id);
        // $('.wait-loader').show();
        // $.ajax({
        //     url: "{{ route('wps-ajax-employee-list') }}",
        //     data: {'id': id},
        //     success: function (data) {
        //         $('.ajax-list-employee').html(data);
        //         $('.wait-loader').hide();
        //         $('.table-search').show();
        //     },
        //     error: function(xhr, status, error) {
        //         alert(xhr.responseText);
        //     }
        // });

    });


    // $(document).on('click', '.pagination a', function(event){
    //     event.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     var query = $('#search').val();

    //     fetch_data_pagination(page, query);

    // });

    // $(document).on('keyup', '#search', function(){
    //     var query = $('#search').val();
    //     var page = $('#hidden_page').val();
    //     fetch_data_pagination(page=1, query);
    // });

    // function fetch_data_pagination(page, query){
    //     var id = $('#companyName').val();
    //     $('.wait-loader-paginate').show();
    //     $.ajax({
    //         url: "{{ URL::to('wps-ajax-employee-list?page=') }}" +page,
    //         data: {'id': id, search: query},
    //         success:function(data)
    //         {
    //             $('.ajax-list-employee').html(data);
    //             $('.wait-loader-paginate').hide();
    //         }
    //     });
    // }


    $(document).on('click', '.add-wps', function(){
        var token = $("input[name='_token']").val();
        var keyword  =  $(this).val();
        $.ajax({
            url: "passport_collect/get_full_passport_detail",
            method: 'POST',
            data:{passport_id:keyword,_token:token},
            success: function (response) {

                var  array = JSON.parse(response);
                $("input[name='passport_id']").val(array.id);

                $(".selected_passport").show();

                $("#pp_uid").html(array.pp_uid);
                $("#passport_no").html(array.passport_no);
                $("#full_name").html(array.name);
                $("#zds_code").html(array.zds_code);

            }
        });
    });


    function all_load_data(company_id) {
            $('table.data_table_cls').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('wps-ajax-employee-list') }}",
                data:{id: company_id},
            },
            columns: [
                { data: 'name' },
                { data: 'full_name' },
                { data: 'pp_uid' },
                { data: 'passport_no' },
                { data: 'zds_code' },
                { data: 'labour_card_no' },
                { data: 'person_code' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    // title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    // customize: function ( xlsx ) {
                    //     var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //     $('c[r=E2] t', sheet).text('Category');
                    // },
                    exportOptions: {
                        columns: [ 2, 3, 4, 5, 6],
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ]
            });
        }
    // });

</script>

@endsection
