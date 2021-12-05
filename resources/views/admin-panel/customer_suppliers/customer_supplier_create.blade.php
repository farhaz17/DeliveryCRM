@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer_supplier_wise_dashboard',['active'=>'master-menu-items']) }}">Customer | Supplier Masters</a> / Contact Register</li>
    </ol>
</nav>
<form action="{{ route('customer_suppliers.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group mb-2">
                    <div class="row">
                        <span class="col-8">Zone Companies</span>
                        <label class="checkbox checkbox-outline-success col-4 text-right">
                            <input type="checkbox" id="select_all_companies"><span class="checkmark"></span><span>Select All</span>
                        </label>
                    </div>
                    <select class="form-control form-control-sm multi-select select2" name="zone_company_id[]" id="zone_company_id" multiple='true' required>
                        {{-- <option value="">Select Company</option> --}}
                        @foreach ($zone_companies as $company)
                            <option value="{{$company->id}}">{{ $company->name ?? "" }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4 form-group mb-2">
                    <label for="contact_type">Contact Type</label>
                    <select class="form-control form-control-sm select2" name="contact_type" id="contact_type" required>
                        {{-- <option value="">Select Type</option> --}}
                        <option value="1">Both</option>
                        <option value="2">Customer</option>
                        <option value="3">Supplier</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mb-2">
                    <label for="status">Status</label>
                    <select class="form-control form-control-sm select2" name="status" id="status">
                        {{-- <option value="">Select status</option> --}}
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                        <option value="3">Hold</option>
                        <option value="4">Terminated</option>
                        <option value="5">Suspended</option>
                        <option value="6">Verify</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group mb-2">
                    <label for="contact_category_id">Category</label>
                    <select class="form-control form-control-sm select2" name="contact_category_id" id="contact_category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name ?? "" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group mb-2" id="customer_supplier_sub_category_div"></div>
            </div>
        </div>
    </div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-0 row">
                Customer | Supplier Details
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_name">Company Name</label>
                    <input type="text" name="contact_name" id="contact_name" class="form-control form-control-sm" placeholder="Enter contact name" required />
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_licence_no">Company Licence No</label>
                    <input type="text" name="contact_licence_no" id="contact_licence_no" class="form-control form-control-sm" placeholder="Enter Licence No" />
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_trn">Company TRN</label>
                    <input type="text" name="contact_trn" id="contact_trn" class="form-control form-control-sm" placeholder="Enter TRN" />
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_whats_app_no">What's App No</label>
                    <input type="text" name="contact_whats_app_no" id="contact_whats_app_no" class="form-control form-control-sm" placeholder="Enter What's app no" required/>
                </div>                
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_telephone_no">Telephone No</label>
                    <input type="text" name="contact_telephone_no" id="contact_telephone_no" class="form-control form-control-sm" placeholder="Enter Mobile" required />
                </div>  
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_mobile_no">Mobile No</label>
                    <input type="text" name="contact_mobile_no" id="contact_mobile_no" class="form-control form-control-sm" placeholder="Enter Mobile" required />
                </div>             
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_website">Website</label>
                    <input type="text" name="contact_website" id="contact_website" class="form-control form-control-sm" placeholder="Enter Website" />
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="state_id">State</label>
                    <select class="form-control form-control-sm select2" name="state_id" id="state_id">
                        <option value="">Select State</option>
                        @forelse ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @empty

                        @endforelse
                    </select>
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="contact_address">Company Address</label>
                    <textarea name="contact_address" id="contact_address" cols="30" rows="2" class="form-control form-control-sm" placeholder="Enter Address"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-0 row">Transaction Details</div>
                <div class="row">
                    <div class="col-md-3 form-group mb-2">
                        <label for="payment_mode">Payment Mode</label>
                        <select class="form-control form-control-sm select2" name="payment_mode" id="payment_mode" required>
                            <option value="">Select Mode</option>
                            <option value="1">Cash</option>
                            <option value="2">Inward Transfer</option>
                            <option value="3">Cheque</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label for="invoicing_days">Invoicing Days</label>
                        <select class="form-control form-control-sm select2" name="invoicing_days" id="invoicing_days" required>
                            <option value="">Select Term</option>
                            <option value="1">Weekly</option>
                            <option value="2">15 days</option>
                            <option value="3">Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label for="payment_term">Payment Terms</label>
                        <select class="form-control form-control-sm select2" name="payment_term" id="payment_term" required>
                            <option value="">Select Term</option>
                            <option value="1">Cash</option>
                            <option value="2">Credit</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2" style="display: none" id="payment_term_days_div">
                        <label for="payment_term_days">Days of Credit Term</label>
                        <input type="text" name="payment_term_days" id="payment_term_days" placeholder="e.g. 10" class="form-control form-control-sm"/>
                    </div> 
                </div>
            </div>
    </div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-0 row">Departments Contact</div>
            <div id="department_contact_holder">
                <div class="row">
                    <div class="col-md-2 form-group mb-2">
                        <label for="department_name">Department Name</label>
                        <select class="form-control form-control-sm" name="department_name[]" id="department_name">
                            <option value="">Select Department</option>
                            @foreach (get_department_names() as $index => $label)
                                 <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-2">
                        <label for="contact_method">Contact Method</label>
                        <select class="form-control form-control-sm" name="contact_method[]" id="contact_method">
                            <option value="">Select Method</option>
                            @foreach (get_department_contact_methods() as $index => $label)
                                 <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_name">Contact Name</label>
                        <input type="text" name="employee_name[]" id="employee_name" class="form-control form-control-sm" placeholder="e.g. Jone Doe" />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_designation">Designation</label>
                        <select class="form-control form-control-sm" name="employee_designation[]" id="employee_designation">
                            <option value="">Select Type</option>
                            @foreach (get_department_employee_designations() as $index => $label)
                                <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_contact">Contact No / Link / Email</label>
                        <input type="text" name="employee_contact[]" id="employee_contact" class="form-control form-control-sm" placeholder="e.g. +971 5x XXX XXXX" />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for=" text-white">&nbsp;</label>
                        <input type="button" class="btn btn-info btn-sm btn-block" id="add_more_department_contact_btn" value="Add more+"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-0 row">Attachments</div>
            <div class="row">
                <div class="col-md-4 form-group mb-1">
                    <label for="license_attachment">License Attachment</label>
                    <input class="form-control-file form-control-sm" id="license_attachment" type="file" placeholder="" name="license_attachment">
                </div>
                <div class="col-md-4 form-group mb-1" id="tax_upload_block">
                    <label for="vat_attachment">VAT Attachment</label>
                    <input class="form-control-file form-control-sm" id="vat_attachment" type="file" placeholder="" name="vat_attachment">
                </div>
                <div class="col-md-4 form-group mb-1" id="contract_upload_block">
                    <label for="contract_attachment">Contract attachment</label>
                    <input class="form-control-file form-control-sm" id="contract_attachment" type="file" placeholder="" name="contract_attachment">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-right" type="submit">Registration Contact</button>
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
    $('#payment_term').on('change', function(){
        if($(this).val() == 2){
            $("#payment_term_days_div").show(600)
        }else{
            $("#payment_term_days_div").hide(600)
        }
    })
</script>
<script>
    $('#contact_category_id').change(function(){
        var category_id = $(this).val();
        $.ajax({
            url: "{{ route('get_customer_supplier_sub_category') }}?category_id="+category_id,
            success: function(response){
                $('#customer_supplier_sub_category_div').empty();
                $('#customer_supplier_sub_category_div').append(response.html);
                $('#customer_supplier_sub_category_div select').select2({
                    placeholder:'Select One Option'
                }); 
            }
        });
    });
</script>
<script>
    $('#zone_company_id').on('change', function(){
        var company_id = $(this).val()
        $.ajax({
            url: "{{ url('get_company_info') }}?company_id="+company_id,
            type : 'get',
            success: function(response){
                $('#zone_comany_name').text(response.name).css('text-transform','capitalize')
                $('#zone_comany_category').text(response.category).css('text-transform','capitalize')
                $('#zone_comany_sub_category').text(response.sub_category).css('text-transform','capitalize')
            }
        })
    })
</script>
<script>
    var department_contact_row_number = 1;
    $('#add_more_department_contact_btn').click(function(){
        var department_contact_row = `<div class="row" id="row`+department_contact_row_number+`">
            <div class="col-md-2 form-group mb-2">
                        <label for="department_name">Department Name</label>
                        <select class="form-control form-control-sm" name="department_name[]" id="department_name">
                            <option value="">Select Department</option>
                            @foreach (get_department_names() as $index => $label)
                                 <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-2">
                        <label for="contact_method">Contact Method</label>
                        <select class="form-control form-control-sm" name="contact_method[]" id="contact_method">
                            <option value="">Select Method</option>
                            @foreach (get_department_contact_methods() as $index => $label)
                                 <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_name">Contact Name</label>
                        <input type="text" name="employee_name[]" id="employee_name" class="form-control form-control-sm" placeholder="e.g. Jone Doe" />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_designation">Designation</label>
                        <select class="form-control form-control-sm" name="employee_designation[]" id="employee_designation">
                            <option value="">Select Type</option>
                            @foreach (get_department_employee_designations() as $index => $label)
                                <option value="{{ $index }}">{{ $label ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="employee_contact">Contact No / Link / Email</label>
                        <input type="text" name="employee_contact[]" id="employee_contact" class="form-control form-control-sm" placeholder="e.g. +971 5x XXX XXXX" />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for=" text-white">&nbsp;</label>
                        <input type="button" class="btn btn-danger btn-sm btn-block delete_btn" data-row_id = "row`+department_contact_row_number+`" id="add_more_department_contact_btn" value="Delete Contact"/>
                    </div>
                </div>`;
                $('#department_contact_holder').append(department_contact_row);
                department_contact_row_number++
            }); 

            $(document).ready(function(){
                $('#department_contact_holder').on('click', '.delete_btn', function() {
                    var ids = $(this).attr('data-row_id');
                    $("#"+ids).remove();
                });
            }); 
</script>
<script>
    $('.select2').select2({
        placeholder:'Select One Option'
    });
    $('#select_all_companies').change(function(){
        if($(this).is(':checked')){ 
            $('#zone_company_id option').each((index, option) => {
                option.selected = true
            });
        }else{
            $('#zone_company_id option').each((index, option) => {
                option.selected = false
            });
        }
        $('.select2').select2({ placeholder:'Select One Option'});
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