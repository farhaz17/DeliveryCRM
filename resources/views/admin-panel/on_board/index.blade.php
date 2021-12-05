@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/international_js/build/css/intlTelInput.css')}}">
    <style>
        /* .hide_cls{
            display: none;
        } */
        .modals-lg {
        max-width: 30% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        .send_btn_cls{
            color: #004e92 !important;
            font-size: 12px;
        }
    </style>

    <style>
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    </style>


@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">On Boarding</a></li>
            <li>All On Boarding</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>




    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="edit_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('onboard.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="change_status_id" id="change_status_id"  >
                    <input type="hidden" name="request_type" id="request_type"  >

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control" id="follow_up_status" name="follow_up_status" >
                                    <option value="" selected disabled>select an option</option>
                                    <option value="4">Selected</option>
                                    <option value="5">Wait List</option>
                                    <option value="1">Reject</option>
                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->


    <!--  add training Modal -->
    <div class="modal fade bd-example-modal-sm"  id="training_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Enter the Training Result</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('save_training_result') }}" method="POST">
                    @csrf

                    <input type="hidden" name="training_primary_id" id="training_primary_id"  >

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control" id="training_status" name="training_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    <option value="1">Pass</option>
                                    <option value="2">Rejected By Platform</option>
                                    <option value="3">Rejected By Rider</option>
                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of training modal -->

    {{--------------------Send To checkin  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="send_checkin_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="checkin_form" action="{{ route('dc_request_for_checkin_save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="checkin_primary_id" id="checkin_primary_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Send Checkin Request to TeamLeader</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body send_checkin_modal_body"></div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Send To checkin model ends here-----------------}}

    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="passport_form" action="{{ route('save_passport_id_ajax') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Detail And Agreed Amount</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="career_primary_id" id="career_primary_id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Nationality</label>
                                <select class="form-control" name="nation_id" id="nation_id" required>
                                    <option value="" selected disabled >Select nationality</option>
                                    @foreach($nationalities as $nation)
                                        <option value="{{ $nation->id }}"  >{{ $nation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Passport Number</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Sur Name</label>
                                <input class="form-control form-control" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Given Name</label>
                                <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required="">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Father Name</label>
                                <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name">
                            </div>
                            <div class="col-md-6 form-group mb-3 cnic_div_passport" style="display:none;">
                                <label for="repair_category">CNIC</label>
                                <input class="form-control form-control" id="cnic_passport" name="nic_number" type="number" placeholder="Enter Cnic Now">
                            </div>
                        </div>
                        <div class="card-title mb-3">Agreed Amount</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5" style="margin-bottom:05px;">
                                        <label for="visit_entry_date">Discount Name</label>
                                        <select name="discount_name[]" class="form-control" >
                                            <option value="" selected disabled >please select option</option>
                                            @foreach($discount_names as $names)
                                                <option value="{{ $names->names }}">{{ $names->names }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="margin-bottom:05px;">
                                        <label for="visit_entry_date">Discount Amount</label>
                                        <input type="number" name="discount_amount[]" id="discount_offer"  class="form-control amount_cls" >
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-icon m-1 " id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                    </div>
                                </div>
                                <div class="row append_discount_row"> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row ">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Agreed Amount</label>
                                        <input type="number" required class="form-control amount_cls" required name="agreed_amount"   id="agreed_amount">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Advance Amount</label>
                                        <input type="number" required class="form-control amount_cls" required name="advance_amount"   id="advance_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="repair_category">Final Amount</label>
                                        <input type="number" required class="form-control"  name="final_amount"   readonly id="final_amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="repair_category">Select Agreement</label>
                                        <input type="file"  name="attchemnt" class="form-control" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="checkbox checkbox-outline-primary mt-2" >
                                            <input type="checkbox" value="1" name="payroll_deduct" id="payroll_deduct"><span>Is Payroll Deduct</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 payroll_deduct_amount_div hide_cls" >
                                        <label for="repair_category">Payroll Deduct Amount</label>
                                        <input type="number"    class="form-control step_amount_cls"  name="payroll_deduct_amount"    id="payroll_deduct_amount">
                                    </div>
                                </div>
                                <div class="row step_amount_row" >
                                    <div class="col-md-6 form-group "  >
                                        <label for="visa_requirement">Select step Amount </label>
                                        <select name="select_amount_step[]" id="select_amount_step"   class="form-control form-control-rounded select_amount_step_cls">
                                            <option value=""  >Select option</option>
                                            @foreach($master_steps as $steps)
                                                <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group "  >
                                        <label for="visa_requirement">Amount</label>
                                        <input type="number" name="step_amount[]"  id="step_amount_first"  class="form-control step_amount_cls ">
                                        <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                        <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                    </div>
                                </div>
                                <div class="row  step_amount_row amount_step_row_cls"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport model ends here-----------------}}

    {{--------------------passport for 4pl only  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_modal_four_pl"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="passport_form_four_pl" action="{{ route('save_passport_id_four_pl_ajax') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="career_primary_id" id="career_primary_id_four_pl" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Nationality</label>
                                <select class="form-control" name="nation_id" id="nation_id_passport" required>
                                    <option value="" selected disabled >Select nationality</option>
                                    @foreach($nationalities as $nation)
                                        <option value="{{ $nation->id }}"  >{{ $nation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Passport Number</label>
                                <input type="text" name="passport_number" id="passport_number_four_pl" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Sur Name</label>
                                <input class="form-control form-control" id="sur_name_four_pl" name="sur_name" type="text" placeholder="Enter Sur Name">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Given Name</label>
                                <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required="">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Father Name</label>
                                <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name">
                            </div>
                            <div class="col-md-6 form-group mb-3 cnic_div" style="display:none;">
                                <label for="repair_category">CNIC</label>
                                <input class="form-control form-control" id="cnic" name="cnic" type="number" placeholder="Enter Cnic Now">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport model ends here-----------------}}


    {{--------------------Passport Handler model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_handle_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="passport_handle_form" action="{{ route('save_passport_handle_with_ajax') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Handler Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="ppuid_primary_id" id="ppuid_primary_id" value="">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Reason</label>
                                <select class="form-control" name="reason">
                                    <option value="1">Reason 1</option>
                                    <option value="2">Reason 2</option>
                                    <option value="3">Reason 3</option>
                                    <option value="4">Reason 4</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Status</label>
                                <select id="passport_status" class="form-control" name="status">
                                    <option value="1">Received</option>
                                    <option value="0">Not Received</option>
                                    <option value="2">Security Deposit</option>
                                </select>
                            </div>
                            <div id="submitDate_div" class="col-md-4 form-group mb-3 hide_cls" >
                                <label>Submitting Date</label>
                                <input class="form-control form-control" autocomplete="off" name="submit_date" type="text" id="submit_date" placeholder="Submiting Date">
                            </div>
                            <div id="security_div" class="col-md-4 form-group mb-3 hide_cls" >
                                <label>Security Deposit</label>
                                <input class="form-control form-control" name="security_deposit" type="number" id="security_deposit" placeholder="Security Deposit">
                            </div>
                            <div class="col-md-4 mb-3 hide_cls security_deposit_later_now_div" >
                                <label for="repair_category">Select Option</label>
                                <br>
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"  name="later_now" value="1" checked /><span>Now</span><span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"   name="later_now"  value="2"  /><span>Later</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Remark</label>
                                <textarea class="form-control form-control" name="remark" rows="4" type="text" placeholder="Remark (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport  Handler model ends here-----------------}}

    {{--------------------Passport Handler for 4pl model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_handle_4pl_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="passport_handle_4pl_form" action="{{ route('save_passport_handle_with_ajax') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Handler Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="ppuid_primary_id" id="ppuid_fourpl_primary_id" value="">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Reason</label>
                                <select class="form-control" name="reason">
                                    <option value="1">Reason 1</option>
                                    <option value="2">Reason 2</option>
                                    <option value="3">Reason 3</option>
                                    <option value="4">Reason 4</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Status</label>
                                <select id="passport_status_four_pl" class="form-control" name="status">
                                    <option value="1">Received</option>
                                    <option value="0">Not Received</option>
                                    <option value="2">Security Deposit</option>
                                    <option value="3">Vendor Responsibility</option>
                                </select>
                            </div>
                            <div id="submitDate_div_4pl" class="col-md-4 form-group mb-3 hide_cls" >
                                <label>Submitting Date</label>
                                <input class="form-control form-control" autocomplete="off" name="submit_date" type="text" id="submit_date_4pl" placeholder="Submiting Date">
                            </div>
                            <div id="security_div_4pl" class="col-md-4 form-group mb-3 hide_cls" >
                                <label>Security Deposit</label>
                                <input class="form-control form-control" name="security_deposit" type="number" id="security_deposit_4pl" placeholder="Security Deposit">
                            </div>
                            <div class="col-md-4 mb-3 hide_cls security_deposit_later_now_div" >
                                <label for="repair_category">Select Option</label>
                                <br>
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"  name="later_now" value="1" checked /><span>Now</span><span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"   name="later_now"  value="2"  /><span>Later</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Remark</label>
                                <textarea class="form-control form-control" name="remark" rows="4" type="text" placeholder="Remark (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport  Handler  for 4pl model ends here-----------------}}

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="edit_note_modals"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('career_frontdesk_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="category"  value="4">
                    <input type="hidden" name="checkbox_array" id="select_ids_note" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_onboard as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_cls">
                                <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="edit_note_modalss"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('rejoin_follow_up') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="category"  value="4">
                    <input type="hidden" name="checkbox_array" id="select_ids_notes" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_onboard as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_cls">
                                <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->

    {{-- <div class="card-body">
        <button class="btn btn-primary m-1 cls_type_riders" id="manger_send_rider" type="button">Normal Riders</button>
        <button class="btn btn-outline-primary m-1 cls_type_riders" id="defaulter_manger_send_rider" type="button">Defaulter Riders</button>
    </div> --}}

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Career Candidate ( {{ $onboards->count() ? $onboards->count() : '0' }} )</a></li>
                    <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejoin Candidate ( {{ $rejoins->count() ? $rejoins->count() : '0' }} )</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                        {{-- <a href="{{ route('view_onboard_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable_not_employee">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"    id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">For Platform</th>
                                    <th  scope="col" class="filtering_source_from">Employee Type</th>
                                    <th scope="col">Batch Reference Number</th>
                                    <th scope="col">Onboard date</th>
                                    <th scope="col">Total Request Counts</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($onboards as $onboard)
                                    <tr>
                                        <th scope="row" >1</th>
                                        <td>
                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox"  class="checkboxs" name="checkbox_array[]" value="{{ $onboard->career_id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{ isset($onboard->career_detail) ? $onboard->career_detail->name  :  isset($onboard->passport_detail) ?? $onboard->passport_detail->personal_info->full_name  }}</td>
                                        <td>{{ isset($onboard->career_detail->passport_no) ? $onboard->career_detail->passport_no : isset($onboard->passport_detail) ?? $onboard->passport_detail->passport_no     }}</td>
                                        <td>{{ isset($onboard->career_detail->phone) ?  $onboard->career_detail->phone :  isset($onboard->passport_detail) ?? $onboard->passport_detail->personal_info->personal_mob   }}</td>
                                        <td>{{ isset($onboard->career_detail->nationality) ?  $onboard->career_detail->nationality : '' }}
                                            {{  isset($onboard->passport_detail->nation) ? $onboard->passport_detail->nation->name : ''  }}
                                        </td>
                                        <td>{{ isset($onboard->career_batch_detail->batch_info->platform->name) ?  $onboard->career_batch_detail->batch_info->platform->name : ''}}

                                            <?php
                                             $required_training = isset($onboard->career_batch_detail->batch_info->platform->need_training) ?  $onboard->career_batch_detail->batch_info->platform->need_training : '0';
                                             $required_reservation = isset($onboard->career_batch_detail->batch_info->platform->need_reservation) ?  $onboard->career_batch_detail->batch_info->platform->need_reservation : '0';
                                           ?>

                                            <?php  $ids =  isset($onboard->on_board_status_type_detail->platform_id) ? $onboard->on_board_status_type_detail->platform_id : '' ?>
                                            <?php

                                            if(isset($ids) && !empty($ids)){
                                                $plaform_name =  $onboard->on_board_status_type_detail->get_the_platfom_names($ids);
                                                $names = implode(",",$plaform_name);
                                                echo $names;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $employee_type =   isset($onboard->career_detail) ? $onboard->career_detail->employee_type : '0';
                                            echo $employee_type_array[$employee_type];
                                            ?>
                                        </td>
                                        <td>{{ isset($onboard->career_batch_detail->batch_info->reference_number) ?  $onboard->career_batch_detail->batch_info->reference_number : 'Accident/Vacation'}}</td>
                                        <td>{{ $onboard->created_at->toDateString()  }}</td>



                                        <?php $total_rejected_request = isset($onboard->career_detail->passport_ppuid) ?  $onboard->career_detail->passport_ppuid->total_checkin_request_rejected($onboard->career_detail->passport_ppuid->id) : '0'; ?>
                                        <?php $total_accepted_request = isset($onboard->career_detail->passport_ppuid) ?  $onboard->career_detail->passport_ppuid->total_checkin_request_accepted($onboard->career_detail->passport_ppuid->id) : '0'; ?>

                                        <td><h5 class="badge badge-success">{{ $total_accepted_request }}</h5> | <h5 class="badge badge-danger">{{ $total_rejected_request }}</h5></td>
                                        <td>


                                            <?php $no_need_agreed_amount = false; ?>
                                            <?php $remove_change_status_btn = false; ?>
                                            @if(isset($onboard->career_detail))
                                            @endif

                                            @if($onboard->career_detail)

                                                @if($onboard->career_detail->visa_status=="3" && $onboard->career_detail->visa_status_own=="2")
                                                    <?php $no_need_agreed_amount = true; ?>
                                                @endif

                                                @if($onboard->career_detail->passport_ppuid)
                                                    <h5 id="created-{{ $onboard->career_id }}" class="badge badge-info">PPUID Created {{ $onboard->career_detail->passport_ppuid->pp_uid }}</h5>

                                                    |
                                                        <?php $is_pending = $onboard->career_detail->passport_ppuid->pending_request_for_checkin($onboard->career_detail->passport_ppuid->id) ?  $onboard->career_detail->passport_ppuid->pending_request_for_checkin($onboard->career_detail->passport_ppuid->id ) : ''; ?>

                                                    @if($required_training=="1" && $required_reservation!="1")

                                                            @if($onboard->is_training=="0")

                                                            @if($is_pending!=null)
                                                            <?php $remove_change_status_btn = true; ?>
                                                            <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                            @endif

                                                             @else

                                                                             @if($required_reservation!="1")
                                                                                        @if($is_pending!=null)
                                                                                            <?php $remove_change_status_btn = true; ?>
                                                                                            <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                                        @else
                                                                                            <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                                        @endif
                                                                             @endif

                                                             @endif


                                                    @elseif($required_reservation=="1"  && $required_training!="1" && $employee_type!="2")

                                                                @if($onboard->is_reservation=="0")
                                                                        @if($is_pending!=null)
                                                                        <?php $remove_change_status_btn = true; ?>
                                                                        <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                                        @endif

                                                                @else

                                                                    @if($required_training!="1"  && $employee_type!="2" )
                                                                        @if($is_pending!=null && $employee_type!="2")
                                                                            <?php $remove_change_status_btn = true; ?>
                                                                            <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                        @else
                                                                                @if($is_pending!=null)
                                                                                     <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                                @else
                                                                                     <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                                @endif
                                                                        @endif
                                                                    @endif

                                                                @endif

                                                     @elseif($required_reservation=="1"  && $required_training=="1")

                                                            @if(($onboard->is_reservation=="0" && $employee_type!="2") || $onboard->is_training=="0")

                                                            @if($is_pending!=null)
                                                            <?php $remove_change_status_btn = true; ?>
                                                            <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                            @endif

                                                            @else


                                                                    @if($is_pending!=null)
                                                                        <?php $remove_change_status_btn = true; ?>
                                                                        <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                    @else


                                                                                @if($onboard->is_training=="1" && $onboard->is_reservation=="1" && $employee_type!="2" )
                                                                                    <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                                @elseif($onboard->is_training=="1" && $employee_type=="2" )
                                                                                <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                                @endif


                                                                    @endif


                                                            @endif




                                                     @else
                                                                @if($is_pending!=null && $employee_type!="2")
                                                                    <?php $remove_change_status_btn = true; ?>
                                                                    <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                @else

                                                                @if($is_pending!=null)
                                                                    <h5 id="created-{{ $onboard->career_id }}" class="badge badge-secondary">Checkin Request Sent</h5>
                                                                @else
                                                                    <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                @endif

{{--                                                                    <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>--}}
                                                                @endif

                                                     @endif



                                                @else
                                                    @if($no_need_agreed_amount)
                                                        <a class="text-primary mr-2 enter_passport" id="{{ "FourPl"."-".$onboard->career_id }}" href="javascript:void(0)"><i class="nav-icon i-Safe-Box1 font-weight-bold"></i></a>
                                                    @else
                                                        <a class="text-primary mr-2 enter_passport" id="{{ $employee_type_array[$employee_type]."-".$onboard->career_id }}" href="javascript:void(0)"><i class="nav-icon i-Safe-Box1 font-weight-bold"></i></a>
                                                    @endif
                                                @endif
                                            @else

                                                <a class="text-primary mr-2 enter_passport" id="{{ $employee_type_array[$employee_type]."-".$onboard->career_id }}" href="javascript:void(0)"><i class="nav-icon i-Safe-Box1 font-weight-bold"></i></a>

                                            @endif
                                                @isset($onboard->career_detail)
                                                <a class="text-primary mr-2 view_cls" id="{{ isset($onboard->career_detail) ? $onboard->career_detail->id  : 'N/A' }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                                @else
                                                <a class="text-primary mr-2 view_cls" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i> Ashir</a>
                                                @endisset

                                                @if($remove_change_status_btn)
                                                @else
                                                    |
                                                   <a class="text-success mr-2 change_status_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                                @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade show " id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <button class="btn btn-warning btn-icon m-1"  id="four_pl_note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                        {{-- <a href="{{ route('view_onboard_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejoin_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"    id="four_pl_checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">For Platform</th>
                                    <th  scope="col" class="filtering_source_from">Employee Type</th>
                                    <th scope="col">Batch Reference Number</th>
                                    <th scope="col">Onboard date</th>
                                    <th scope="col">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rejoins as $onboard)

                                <?php
                                $check_defaulter  = isset($onboard->defaulter_rider_details) ? $onboard->defaulter_rider_details : null;
                                $is_defaulte_now = null;

                                if(isset($check_defaulter)){
                                        if(count($check_defaulter)>0){
                                            $is_defaulte_now  =  $check_defaulter[0]->check_defaulter_rider() ? $check_defaulter[0]->check_defaulter_rider() : null;

                                       }
                                }
                                ?>

                                    <tr
                                    @isset($is_defaulte_now)
                                    style="background-color: #ff18004a;"
                                @endisset
                                    >
                                        <th scope="row" >1</th>
                                        <td>

                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox" name="checkbox_array[]" class="fourpl_checkbox" value="{{ $onboard->passport_id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{  isset($onboard->passport_detail->personal_info->full_name) ? $onboard->passport_detail->personal_info->full_name : 'N/A'  }} </td>
                                        <td>{{ isset($onboard->passport_detail->passport_no) ? $onboard->passport_detail->passport_no : isset($onboard->passport_detail) ?? $onboard->passport_detail->passport_no     }}</td>
                                        <td>{{ isset($onboard->passport_detail->personal_info->personal_mob) ?  $onboard->passport_detail->personal_info->personal_mob : 'N/A'   }}</td>
                                        <td>{{ isset($onboard->passport_detail->nation->name) ? $onboard->passport_detail->nation->name : '' }}</td>
                                        <td>
                                            @if($onboard->career_id=="0")

                                            @if(isset($onboard->career_batch_detail))

                                            {{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}


                                                <?php  $plaform_id_now = isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0'; ?>

                                            @else

                                           {{ isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name :'N/A' }}


                                            @endif


                                        @else
                                       {{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}

                                        @endif
                                        </td>


                                        <td>
                                            <?php $employee_type =   isset($onboard->career_detail) ? $onboard->career_detail->employee_type : '0';
                                            echo $employee_type_array[$employee_type];
                                            ?>
<?php

$passport_id = $onboard->passport_id;
                // $passport_detail = Passport::find($passport_id);
                if($onboard->passport_detail->career_id!="0"){

                $rider = $vendor_onboard->where('passport_no', $onboard->passport_detail->passport_no)->where('status', 1)->where('cancel_status', 0)->first();
                    if($rider) {
                        $visa_type = "Four PL";
                        $employee_type = "2";
                        $four_pl_name = $fourpl->where('id',$rider->four_pls_id)->first();
                        if($four_pl_name) {
                           echo  $four_pl_name = $four_pl_name->name;
                        }else{
                          echo   $four_pl_name = "N/A";
                        }
                    }else{
                       echo  $visa_type = "N/A";
                    }
                }else{
                  echo  $visa_type = "Company";
                  $employee_type = "1";
                }
?>

                                        </td>
                                        <td>{{ isset($onboard->career_batch_detail->batch_info->reference_number) ?  $onboard->career_batch_detail->batch_info->reference_number : 'Accident/Vacation'}}</td>
                                        <td>{{ $onboard->created_at->toDateString()  }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_clss" id="{{ $onboard->passport_id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>

                                            <?php $is_pending = $onboard->passport_detail->pending_request_for_checkin_second($onboard->passport_detail->id) ?  $onboard->passport_detail->pending_request_for_checkin_second($onboard->passport_detail->id) : ''; ?>
                                                {{-- code related training and reservation start --}}

                                                <?php
                                                $required_training = isset($onboard->career_batch_detail->batch_info->platform->need_training) ?  $onboard->career_batch_detail->batch_info->platform->need_training : '0';
                                                $required_reservation = isset($onboard->career_batch_detail->batch_info->platform->need_reservation) ?  $onboard->career_batch_detail->batch_info->platform->need_reservation : '0';
                                                ?>

                                                @if($required_training=="1" && $required_reservation!="1")

                                                        @if($onboard->is_training=="0")

                                                                @if($is_pending!=null)
                                                                <?php $remove_change_status_btn = true; ?>
                                                                <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                                @endif

                                                         @else

                                                                         @if($required_reservation!="1")
                                                                                    @if($is_pending!=null)
                                                                                        <?php $remove_change_status_btn = true; ?>
                                                                                        <h5  class="badge badge-secondary">Checkin Request Sent</h5>
                                                                                    @else
                                                                                    {{-- <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a> --}}
                                                                                    |
                                                                                    <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                                    @endif
                                                                         @endif

                                                         @endif


                                                @elseif($required_reservation=="1"  && $required_training!="1" && $employee_type !="2")

                                                            @if($onboard->is_reservation=="0" )

                                                                        @if($is_pending!=null)
                                                                        <?php $remove_change_status_btn = true; ?>
                                                                        <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                                        @endif

                                                            @else

                                                                @if($required_training!="1"  && $employee_type!="2" )
                                                                    @if($is_pending!=null && $employee_type!="2")
                                                                        <?php $remove_change_status_btn = true; ?>
                                                                        <h5  class="badge badge-secondary">Checkin Request Sent</h5>
                                                                    @else
                                                                            @if($is_pending!=null)
                                                                                 <h5  class="badge badge-secondary">Checkin Request Sent</h5>
                                                                            @else
                                                                            {{-- <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a> --}}
                                                                            |
                                                                            <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                            @endif
                                                                    @endif
                                                                @endif

                                                            @endif

                                                 @elseif($required_reservation=="1"  && $required_training=="1")

                                                        @if(($onboard->is_reservation=="0" && $employee_type!="2") || $onboard->is_training=="0")
                                                                    @if($is_pending!=null)
                                                                    <?php $remove_change_status_btn = true; ?>
                                                                    <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                                    @endif

                                                        @else


                                                                @if($is_pending!=null)
                                                                    <?php $remove_change_status_btn = true; ?>
                                                                    <h5 class="badge badge-secondary">Checkin Request Sent</h5>
                                                                @else

                                                                            @if($is_pending!=null)
                                                                                <h5  class="badge badge-secondary">Checkin Request Sent</h5>
                                                                            @elseif($onboard->is_training=="1" && $employee_type=="2")

                                                                            {{-- <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a> --}}
                                                                            |
                                                                       <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>

                                                                            @elseif($onboard->is_training=="1" && $onboard->is_training=="1")

                                                                            {{-- <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a> --}}
                                                                            |
                                                                          <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>

                                                                            @endif


                                                                @endif


                                                        @endif




                                                 @else
                                                                @if($is_pending!=null)
                                                                <?php $remove_change_status_btn = true; ?>
                                                                <h5  class="badge badge-secondary">Checkin Request Sent</h5>
                                                                   @else
                                                                {{-- <a class="text-success mr-2 change_status_rejoin_cls" id="{{ "change_status-".$onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a> --}}
                                                                |
                                                                <a class="text-dark  send_btn_cls font-weight-bold mr-2 send_to_checkin" id="{{ $onboard->id }}" href="javascript:void(0)"><i class="nav-icon i-Checked-User font-weight-bold"></i></a>
                                                                @endif

                                                 @endif


                                                {{-- code related training and reservation end --}}




                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>



                    {{--                    second tab end here--}}
                </div>


            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modals-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modals-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">


                        <div class="col-md-12">
                            <h6><b>Remarks</b></h6>
                            <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6">
                                <div class="chat-content-wrap" data-sidebar-content="chat">
                                    <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}

    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>

    <script>
        $("#nation_id_passport").change(function(){
            var selected_id = $(this).val();

            if(selected_id=="1"){
                $(".cnic_div").show();
                $("#cnic").prop('required',true);
            }else{
                $(".cnic_div").hide();
                $("#cnic").prop('required',false);
            }

        });

        $("#nation_id").change(function(){
            var selected_id = $(this).val();

            if(selected_id=="1"){
                $(".cnic_div_passport").show();
                $("#cnic_passport").prop('required',true);
            }else{
                $(".cnic_div_passport").hide();
                $("#cnic_passport").prop('required',false);
            }

        });

        </script>

    <script>
        $('tbody').on('click', '.view_cls', function() {

var ids  = $(this).attr('id');
$("#detail_modal").modal('show');

var ids = $(this).attr('id');

var token = $("input[name='_token']").val();

$.ajax({
    url: "{{ route('ajax_career_remark') }}",
    method: 'POST',
    data: {primary_id: ids ,_token:token},
    success: function(response) {
        console.log(response);
        if(response.length == 0){
            data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-10 flex-grow-1"></p>
                </div>
                    <p class="m-0">No Remarks</p>
            </div><br>`;
        $(".remark").append(data);
        }

        for (i = 0; i < response.length; i++) {
        if(response[i].remarks){
            if(response[i].career_category == "1"){
                            $career_category = "Frontdesk"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "2"){
                            $career_category = "Waitlist"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "3"){
                            $career_category = "Selected"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "4"){
                            $career_category = "Onboard"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "0"){
                            $career_category = "Reject"
                            $followup = ""
                        }
    data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                    <span class="career_remark">${response[i].note_added_date}</span>
                </div>
                    <p class="m-0">${response[i].remarks}</p>
                    <span class="m-0">(${$career_category}  ${$followup})</span>
            </div><br>`;
    $(".remark").append(data);
    }}
    }
});$(".remark").empty();


});

    </script>

<script>
    $('tbody').on('click', '.view_clss', function() {

var ids  = $(this).attr('id');
console.log(ids);
$("#detail_modal").modal('show');

var ids = $(this).attr('id');

var token = $("input[name='_token']").val();

$.ajax({
url: "{{ route('ajax_career_remark_rejoin') }}",
method: 'POST',
data: {primary_id: ids ,_token:token},
success: function(response) {
    console.log(response);
    if(response.length == 0){
        data = `<div class="message flex-grow-1">
            <div class="d-flex">
                <p class="mb-0 text-title text-10 flex-grow-1"></p>
            </div>
                <p class="m-0">No Remarks</p>
        </div><br>`;
    $(".remark").append(data);
    }

    for (i = 0; i < response.length; i++) {
    if(response[i].remarks){
        if(response[i].career_category == "1"){
                            $career_category = "Frontdesk"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "2"){
                            $career_category = "Waitlist"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "3"){
                            $career_category = "Selected"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "4"){
                            $career_category = "Onboard"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "0"){
                            $career_category = "Reject"
                            $followup = ""
                        }
data = `<div class="message flex-grow-1">
            <div class="d-flex">
                <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                <span class="career_remark">${response[i].note_added_date}</span>
            </div>
                <p class="m-0">${response[i].remarks}</p>
                <span class="m-0">(${$career_category}  ${$followup})</span>
        </div><br>`;
$(".remark").append(data);
}}
}
});$(".remark").empty();


});

</script>

    <script>
        tail.DateTime("#submit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#submit_date_4pl",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),
        });
    </script>
    <script>
        $("#checkAll").click(function () {
            $('.checkboxs').not(this).prop('checked', this.checked);
        });

        $("#four_pl_checkAll").click(function () {
            $('.fourpl_checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script>

      $(".send_to_traininig").click(function () {
          var id = $(this).attr('id');

          $("#training_primary_id").val(id);
          $("#training_modal").modal('show');
      });
    </script>

    <script>
        $('#note_btn').click(function() {
            checked = $("input[type=checkbox]:checked").length;
            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                var my_array = [];
                $("input[type=checkbox]:checked").each(function(){
                    my_array.push($(this).val());
                });
                // console.log(my_array);
                $("#select_ids_note").val(my_array);
                $("#edit_note_modals").modal('show');
            }
        });
    </script>


    <script>
        $(".send_to_checkin").click(function () {
            // alert("sdfsd");
            var ids  = $(this).attr('id');
            $("#checkin_primary_id").val(ids);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_onboard_checkin') }}",
                method: 'GET',
                dataType: 'json',
                data: {id: ids, _token: token},
                success: function (response) {
                    $('.send_checkin_modal_body').html("");
                    $('.send_checkin_modal_body').append(response.html);
                    $("#send_checkin_modal").modal('show');

                    $('#checkin_city').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });

                    $('#checkin_platform').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });

                    // $("[data-toggle=popover]").popover();

                    $("rider_sim").prop('checked',false);
                    $("rider_bike").prop('checked',false);


                }
            });



        });

        $('#four_pl_note_btn').click(function() {
                checked = $(".fourpl_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                    $(".fourpl_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                    });
                    console.log(my_array);
                    $("#select_ids_notes").val(my_array);

                    $("#edit_note_modalss").modal('show');

                }
            });


    </script>

    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#rejoin_datatable').DataTable( {

                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [6],"orderable": false},

                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');

                if(split_ab[1]=="homeBasic"){
                    var table = $('#datatable_not_employee').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    $("#datatable_not_employee").css("width","100%");

                }else if(split_ab[1]=="profileBasic"){

                    var table = $('#rejoin_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    $("#rejoin_datatable").css("width","100%");
                }


            }) ;
        });
    </script>

    <script>
        $(".enter_passport").click(function () {

            var id = $(this).attr('id');

            var ids = id.split("-");

            if(parseInt(ids[1])>0){
                if(ids[0]=="FourPl"){

                    $("#career_primary_id_four_pl").val(ids[1]);
                    $("#passport_modal_four_pl").modal('show');
                }else{
                    $("#career_primary_id").val(ids[1]);

                    $("#passport_modal").modal('show');
                }
            }else{
                tostr_display("error","This user is not belongs to Company Either 4pl, please contact admin");
            }
        });

        $(".change_status_cls").click(function (){

            var ids = $(this).attr('id');
            var now_id = ids.split("-");

            $("#request_type").val("1");
            $("#change_status_id").val(now_id[1]);

            $("#edit_note_modal").modal("show");
        });

        $(".change_status_rejoin_cls").click(function (){

            var ids = $(this).attr('id');
            var now_id = ids.split("-");

            $("#request_type").val("2");
            $("#change_status_id").val(now_id[1]);

            $("#edit_note_modal").modal("show");
        });


    </script>

    <script>
        $("#passport_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#passport_form").attr('action');


            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    var gamer  = response.split(",");

                    if($.trim(gamer[0])=="success"){
                        tostr_display("success","PPUId And Agreed Amount Created");

                        console.log(gamer);

                        $("#ppuid_primary_id").val(gamer[1]);

                        $("#passport_handle_modal").modal("show");

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });


        $("#passport_form_four_pl").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#passport_form_four_pl").attr('action');


            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    var gamer  = response.split(",");

                    if($.trim(gamer[0])=="success"){
                        tostr_display("success","PPUId And Agreed Amount Created");

                        console.log(gamer);

                        $("#ppuid_fourpl_primary_id").val(gamer[1]);

                        $("#passport_handle_4pl_modal").modal("show");

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });
    </script>
    {{--    ajax form end--}}


    <script>

        // passport handler form
        $("#passport_handle_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#passport_handle_form").attr('action');


            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    if(response=="success"){
                        tostr_display("success","Passport handler Submitted ");

                        $("#passport_handle_modal").modal("show");

                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });


        $("#passport_handle_4pl_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#passport_handle_4pl_form").attr('action');


            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Passport handler Submitted ");


                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
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



    <script>
        $("#passport_status").change(function () {

            var gamer = $(this).val();

            if(gamer=="0"){
                $("#submitDate_div").show();
                $("#security_div").hide();
                $("#submit_date").prop("required",true);
                $("#security_deposit").prop("required",false);
                $(".security_deposit_later_now_div").hide();

            }else if(gamer=="2"){

                $("#submitDate_div").hide();
                $("#security_div").show();
                $(".security_deposit_later_now_div").show();
                $("#security_deposit").prop("required",true);
                $("#submit_date").prop("required",false);

            }else{
                $("#submitDate_div").hide();
                $("#security_div").hide();
                $(".security_deposit_later_now_div").hide();
                $("#submit_date").prop("required",false);
                $("#security_deposit").prop("required",false);
            }

        });

        $("#passport_status_four_pl").change(function () {

            var gamer = $(this).val();

            if(gamer=="0"){
                $("#submitDate_div_4pl").show();
                $("#security_div_4pl").hide();
                $("#submit_date_4pl").prop("required",true);
                $("#security_deposit_4pl").prop("required",false);
                $(".security_deposit_later_now_div").hide();

            }else if(gamer=="2"){

                $("#submitDate_div_4pl").hide();
                $("#security_div_4pl").show();
                $(".security_deposit_later_now_div").show();
                $("#security_deposit_4pl").prop("required",true);
                $("#submit_date").prop("required",false);

            }else if(gamer=="3"){
                $("#submitDate_div_4pl").hide();
                $("#security_div_4pl").hide();
                $(".security_deposit_later_now_div").hide();
                $("#submit_date_4pl").prop("required",false);
                $("#security_deposit_4pl").prop("required",false);

            }
            else{
                $("#submitDate_div_4pl").hide();
                $("#security_div_4pl").hide();
                $(".security_deposit_later_now_div").hide();
                $("#submit_date_4pl").prop("required",false);
                $("#security_deposit_4pl").prop("required",false);
            }

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

        //deleta and adding step amount

        var count_discount_ab = 50001
        $("#btn_add_discount_row").click(function () {
            count_discount_ab = parseInt(count_discount_ab)+1
            var id_now =  count_discount_ab;

            var html =  add_new_discount_row(id_now);
            $(".append_discount_row").append(html);

            $("#discount_amount-"+id_now).prop('required',true);
            $("#discount_name-"+id_now).prop('required',true);

        });

        $('.append_discount_row').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".discunt_div-"+now[1]).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

            $.ajax({
                url: "{{ route('ajax_onboard_checkin') }}",
                method: 'GET',
                data: {id: ids},
                success: function(response) {

                }
            });


        });

        var count_doc_ab = 40001

        $("#btn_add_doc_row").click(function () {
            count_doc_ab = parseInt(count_doc_ab)+1
            var id_now =  count_doc_ab;

            var html =  add_new_document_row(id_now);
            $(".doc_row_append").append(html);

            $("#doc_name-"+id_now).prop('required',true);
            $("#doc_image-"+id_now).prop('required',true);

        });

        $('.doc_row_append').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".doc_div-"+now[1]).remove();

            // var value_current = $("#image_array").val();
            // var now_value = value_current+","+id;
            // $("#image_array").val(now_value);


        });



        function add_new_discount_row(id){
            var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $name)<option value="{{ $name->names }}">{{ $names->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            return html;
        }

        function add_new_document_row(id){
            var html = '<div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Document Name</label><select class="form-control" name="physical_doc_name_'+id+'"><option value="" selected disabled>please select option</option> @foreach($dcouments_name as  $reason)<option value="{{$reason->id}}">{{ $reason->name }}</option>@endforeach</select></div><div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Select Image</label><input type="file" name="physical_doc_image_'+id+'[]" id="doc_image-'+id+'"  multiple class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 doc_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_doc-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            var value_current = $("#image_array").val();
            var now_value = value_current+","+id;
            $("#image_array").val(now_value);
            return html;
        }
    </script>


    <script>
        function append_form_amount_step(id){
            html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps)<option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>@endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
            return html;
        }
        var count_amount_step = 0;
        $(".add_step_form_btn").click(function(){

            count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;

            $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));

            $('#select_amount_step-'+count_amount_step).select2({
                placeholder: 'Select an option'
            });

        });

        $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {

            var ids = $(this).attr('id');

            $("."+ids).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

        });

    </script>

    <script>
        $("#payroll_deduct").click(function(){

            if($("#payroll_deduct").prop('checked') == true){
                // $(".step_amount_row").hide();
                $(".amount_step_row_cls").html("");
                $("#select_amount_step").prop("required",false);
                $("#step_amount_first").prop("required",false);
                $("#step_amount_first").val("0");
                $(".payroll_deduct_amount_div").show();
                $("#payroll_deduct_amount").prop("required",true);

                var remain_val = calculate_others();
                $("#final_amount").val(remain_val);
            }else{
                $(".payroll_deduct_amount_div").hide();
                $("#payroll_deduct_amount").prop("required",false);



                $(".step_amount_row").show();
                $("#select_amount_step").prop("required",true);
                $("#step_amount_first").prop("required",true);
                var remain_val = calculate_others();
                $("#final_amount").val(remain_val);
            }

        });
    </script>

    <script>

        function  calculate_others() {

            var agreed_amount = $("#agreed_amount").val();



            var sum = 0;
            $('.amount_cls').each(function(){
                if($(this).attr('id')=="agreed_amount"){

                }else{
                    console.log($(this).val());
                    if($(this).val()!=''){
                        sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                    }
                }
            });
            var now_remain = parseFloat(agreed_amount)-parseFloat(sum);
            return now_remain

        }
        $('body').on('change', '.amount_cls', function() {
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

        });
        $('body').on('change', '.step_amount_cls', function() {
            var remain_val = calculate_others();
            var sum = 0;
            $('.step_amount_cls').each(function(){

                console.log($(this).val());
                if($(this).val()!=''){
                    sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                }
            });

            var final_amount = $("#final_amount").val();

            if(parseFloat(final_amount)!=parseFloat(sum)){

            }


        });
    </script>

    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>



<script>
    // $("[data-toggle=popover]").popover();
</script>

@endsection
