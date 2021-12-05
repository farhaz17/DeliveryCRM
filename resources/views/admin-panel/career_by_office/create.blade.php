
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/international_js/build/css/intlTelInput.css')}}">
    <style>
        button.btn.btn-primary.save-btn {
            margin-top: 24px;
        }
        .license_heading{
            margin-top: -43px;
        }
        .iti { width: 100%; }

        .hide_cls{
            display: none;
        }

        .checkbox input[disabled] ~ *, .radio input[disabled] ~ * {
            color: #70657b;
        }


        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 99999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        .view_cls i{
            font-size: 15px !important;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }

        .color-overlay {
            background-color: #00000030;
            opacity: 0.6;
        }

        .select2-container{
         width: 100%;
        }
        .cls_icon{
            color: #000000;
            font-weight: 900;
        }

    </style>

    <style>
        /* css for type ahead only */
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.drop_only_passport {
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
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }

        ul.typeahead_passport.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead_passport.dropdown-menu:hover {
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
        .already_pics{
            margin-top: 5px;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manage User</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

        <!--  add note Modal -->
        <div class="modal fade bd-example-modal-md"  id="status_passport_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle-1">Passport Number Current Status</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                         <div class="row">
                             <div class="col-md-12 text-center">
                                <h5 id="msg_passport" class="text-primary"></h5>
                             </div>
                          </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div><!-- end of note modal -->



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
                                <label for="repair_category">Enter Sur Name</label>
                                <input class="form-control form-control" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name">
                            </div>


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
                                <label for="repair_category">Given Name</label>
                                <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required="">
                            </div>




                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Passport Number</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control" required>
                            </div>




                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Father Name</label>
                                <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name">
                            </div>

                            <div class="col-md-6 form-group mb-3 nic_number_div">
                                <label for="repair_category">Enter Nic Number</label>
                                <input class="form-control form-control" id="nic_number" name="nic_number" type="number" placeholder="Enter nic number">
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

                                <div class="col-md-6">

                                </div>

                             <div class="col-md-6">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <label for="repair_category">Final Due Amount</label>
                                         <input type="number" required class="form-control"  name="final_amount"   readonly id="final_amount">
                                     </div>

                                     <div class="col-md-6">
                                         <label for="repair_category">Select Agreement</label>
                                         <input type="file"  name="attchemnt" class="form-control" >
                                     </div>

                                     <div class="col-md-6">
                                             <label class="checkbox checkbox-outline-primary mt-2" >
                                                 <input type="checkbox" value="1" name="payroll_deduct" id="payroll_deduct"><span>Is Payroll Deduct.?</span><span class="checkmark"></span>
                                             </label>

                                         <label>
                                             <span>Amount</span>
                                         </label>
                                         <h6 id="final_amount_label_cls">0</h6>
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
                                             @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" )
                                                 <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>
                                             @elseif($steps->id=="6" || $steps->id=="7")
                                                 <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option>
                                             @else
                                                 <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>
                                             @endif

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

    <!--  Ask Modal Start -->
    <div class="modal fade bd-example-modal-sm"  id="ask_sm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Please select your button</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary mb-2"  id="ask_send_wait_list_and_ppuid" type="button">Send To Wait List And Create PPUID</button>
                            <button class="btn btn-success mt-2"  id="ask_send_wait_list" type="button">Send To Wait List Only</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="ask_modal_close_btn" type="button" data-dismiss="modal">Close</button>
{{--                    <button class="btn btn-primary ml-2" type="button">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Ask Modal End -->




    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Personal Detail</div>

                    <form method="post" id="update_form" action="{{ route('career.update',1) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @method('PUT')
                        <input type="hidden" id="career_id" name="career_id">

                        <div class="row">

                            <div class="col-md-6 form-group mb-3">
                                <div class="row">

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category" class="font-25"> <b>Search</b></label>
                                        <input class="form-control form-control-rounded "  id="keyword" autocomplete="off"  name="search" value="" type="text"  required />
                                        <div class="input-group-append"></div>
                                        <label class="checkbox checkbox-outline-primary mt-2" >
                                            <input type="checkbox" value="1" name="search_all_over" id="search_all_over"><span><b>Only to edit any information of candidate</b></span><span class="checkmark"></span>
                                            <button class="btn btn-sm  m-1" type="button" data-toggle="tooltip" data-placement="top" title="This option is using for only to editing purpose of any information of candidate,
Candidate's visa details can be changed if there is no PPUID for that candidate, Once PPUID created we wont be able to change visa details here, but other information can be changed">
                                                <span class="ul-btn__icon"><i class="cls_icon i-Speach-Bubble-Asking"></i></span>
                                            </button>
                                        </label>


                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Name <b>(required)</b></label>
                                        <input class="form-control form-control-rounded" id="name" name="name" value="" type="text" required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Email</label>
                                        <input class="form-control form-control-rounded" id="email" name="email" value="" type="text"  required  />
                                    </div>


                                    <div class="col-md-12 form-group mb-3 append_phone_now">

                                    </div>


                                </div>

                                <div class="row">

                                    <div class="col-md-12 form-group mb-3 append_whatsapp_now">

                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Date Of Birth</label>
                                        <input class="form-control form-control-rounded" id="dob" name="dob" value="" type="text" required  />
                                    </div>


                                </div>

                                <div class="row">


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">year Experience</label>
                                        <select class="form-control" name="experience" id="experience"  >
                                            <option value="" selected disabled>select year please</option>
                                            <option value="1">1 year</option>
                                            <option value="2" >2 year</option>
                                            <option value="3">3 year</option>
                                            <option value="4" >4 year</option>
                                            <option value="5" >5 year</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Month Experience</label>
                                        <select class="form-control" name="exp_month" id="exp_month"  >
                                            <option value="" selected disabled>select month please</option>
                                            @foreach($exp_months as $month)
                                                <option value="{{ $month->id }}"    >{{ $month->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="repair_category">Applying For</label>

                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="apply_for" id="apply_for_bike" value="1"  /><span>Bike</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"   name="apply_for"  id="apply_for_car" value="2"  /><span>Car</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="apply_for" id="apply_for_both" value="3"  /><span>Both</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                    </div>



                                </div>


                                <div class="card-title mb-3">Passport Details</div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Nationality <b>(required)</b></label>
                                        <select class="form-control" id="national_id" name="national_id" required>
                                            <option value="">select Nationality</option>
                                            @foreach($nationalities as $nation)
                                                <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-md-12 form-group mb-3 hide_cls nic_expiry_div">
                                        <label for="repair_category">Pakistan NIC Expiry</label>
                                        <input class="form-control form-control-rounded" id="nic_expiry" name="nic_expiry"  type="text"    />
                                    </div>

                                    {{-- <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Passport Number</label>
                                        <input class="form-control form-control-rounded" id="passport_no" name="passport_no"  type="text"  required  />
                                    </div> --}}

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category" class="font-25">Passport Number</label>
                                        <input class="form-control typeahead_passport"  id="passport_no" name="passport_no"   autocomplete="off"   value="" type="text"  required />
                                        <div class="input-group-append"></div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Passport Expiry</label>
                                        <input class="form-control form-control-rounded" id="passport_expiry" autocomplete="off" name="passport_expiry"  type="text" required  />
                                    </div>


                                </div>
                            </div>



                            <div class="col-md-6 form-group mb-3" >
                                <div class="card-title mb-3  license_heading">License Detail</div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="repair_category">License Status</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  class="license_status_cls"  value="1" id="licence_yes" name="license_status" required><span>Yes</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_status_cls"  value="2"  id="licence_no" name="license_status"><span>No</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3 refer_by_div hide_cls">
                                        <label for="repair_category">Refered By</label>
                                        <br>
                                        <h6> <a href="#"  target="_blank" id="refer_by_link">Gamer is on the move</a></h6>

                                    </div>

                                    <div class="col-md-12 hide_cls  driving_licence_div_cls" >

                                        <label for="repair_category">Which License you Have.?</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"   name="license_type" class="license_status_cls"   id="license_have_bike" value="1" ><span>Bike</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="license_type" value="2" class="license_status_cls"  id="license_have_car" ><span>Car</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="license_type" value="3"  id="license_have_both" ><span>Both</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="row  hide_cls driving_licence_div_cls">


                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">Licence number</label>
                                        <input class="form-control form-control-rounded" id="licence_number" name="licence_no" value="" type="text"   />
                                    </div>

                                    <div class="col-md-6 mb-3 float-left">
                                        <label for="repair_category">Licence issue Date</label>
                                        <input class="form-control form-control-rounded" id="licence_issue_date"  autocomplete="off"  name="licence_issue_date" value="" type="text"  />
                                    </div>

                                    <div class="col-md-6 mb-3 float-left">
                                        <label for="repair_category">Licence Expiry</label>
                                        <input class="form-control form-control-rounded" id="licence_expiry_date" autocomplete="off" name="licence_expiry_date" value="" type="text"   />
                                    </div>

                                </div>

                                <div class="row  hide_cls driving_licence_div_cls ">



                                    <div class="col-md-6 float-left">
                                    <label for="repair_category">Traffic number</label>
                                    <input class="form-control form-control-rounded" id="traffic_no" name="traffic_no" value="" type="text"   />
                                    </div>

                                    <div class="col-md-6 mb-3  float-left">
                                        <label for="repair_category">Licence City</label>
                                        <select class="form-control" id="licence_city" name="licence_city">

                                        </select>
                                    </div>

                                    <div class="col-md-6 float-left">
                                        <label for="repair_category">Licence Front Pic</label>
                                        <input class="form-control form-control-rounded" id="licence_front_pic" name="licence_front_pic"  type="file"   />
                                        <div class="already_pics" style="display: none;">

                                        <img id="thumbnil_front_pic" style="width:150px; height:150px;"  src="" alt="image"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6 float-left">
                                        <label for="repair_category">Licence Back Pic</label>
                                        <input class="form-control form-control-rounded" id="licence_back_pic" name="licence_back_pic"  type="file"   />
                                        <div class="already_pics"  style="display: none;">

                                        <img id="thumbnil_front_back" style="width:150px; height:150px;"  src="" alt="image"/>
                                        </div>
                                    </div>


                                </div>

{{--                                <div class="row  hide_cls driving_licence_div_cls">--}}
{{--                                    <div class="col-md-6 mb-3 float-left">--}}
{{--                                        <label for="repair_category">Licence Front Pic</label>--}}
{{--                                       <input type="file" class="form-control" name="licence_front_pic" id="licence_front_pic">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6 mb-3 float-left">--}}
{{--                                        <label for="repair_category">Licence Back Pic</label>--}}
{{--                                        <input type="file" class="form-control" name="licence_back_pic" id="licence_back_pic">--}}
{{--                                    </div>--}}

{{--                                </div>--}}



{{--                                <div class="card-title mb-3">Visa Detail</div>--}}

                                <div class="row ">
                                    <div class="form-check-inline hide_cls">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"  value="1" name="employee_type" checked id="company_employee_type" class="employee_type_cls"  ><span>Company</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 form-group mb-3 visa_status_div ">


                                        <br>
                                        <label for="repair_category" class="font-weight-bold visa_detail_cls">Visa Status</label>
                                        <br>
                                        <div class="form-check-inline visa_detail_cls">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"    value="1" id="visa_status_visit" name="visa_status"  ><span>Visit Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline visa_detail_cls">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio"  value="2" id="visa_status_cancel" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline visa_detail_cls visa_status_own_div_cls">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio"  value="3"  id="visa_status_own" name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

{{--                                        <div class="form-check-inline visa_detail_cls">--}}
{{--                                            <label class="radio radio-outline-primary">--}}
{{--                                                <input type="radio"  value="4"  id="waiting_cancellation" name="visa_status"><span>Waiting Cancellation</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}


                                        <div class="visit_visa_status_cls hide_cls visa_detail_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="visit_one_month" value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="visit_three_month"  value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded"  name="visit_exit_date"  id="visit_exit_date" value="" type="text"   />

                                        </div>

                                        <div class="cancel_visa_status_cls hide_cls visa_detail_cls " >
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"  id="cancel_free_zone" value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"   id="cancel_company_visa"  value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"   id="cancel_waiting_cancel"  value="3" name="cancel_visa_status"><span>Waiting Cancellation</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded"  name="cancel_fine_date"  autocomplete="off" id="cancel_fine_date" value="" type="text"   />
                                        </div>



                                        <div class="own_visa_status_cls hide_cls visa_detail_cls visa_status_own_div_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="own_visa_noc"    value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" id="own_visa_without_noc"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
{{--                                    <div class="col-md-6 form-group mb-3">--}}
{{--                                        <label for="repair_category">Are you willing to take company visa.?</label>--}}
{{--                                        <br>--}}
{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-success">--}}
{{--                                                <input type="radio" class="license_type_cls"  id="company_visa_yes" value="1" name="company_visa"><span>Yes</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}

{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-primary">--}}
{{--                                                <input type="radio" class="license_type_cls"  id="company_visa_no" value="2" name="company_visa"><span>No</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Medical Type.? <b>(required)</b></label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"   id="medical_company" value="1" checked  name="medical_type"><span>Company</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio"  id="medical_own" value="2" name="medical_type"><span>Own</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

{{--                                    <div class="col-md-6 form-group mb-3">--}}
{{--                                        <label for="repair_category">What you prefer for in and out.?</label>--}}
{{--                                        <br>--}}
{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-success">--}}
{{--                                                <input type="radio"  class="license_type_cls"  value="1" name="inout_transfer"><span>Here</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}

{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-primary">--}}
{{--                                                <input type="radio" class="license_type_cls"  value="2" name="inout_transfer"><span>Home Country</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">PlatForm <b>(required)</b></label>

                                        <select class="form-control select multi-select" id="platform_id" name="platform_id[]" multiple="multiple">

                                            @foreach($platform as $plat)

                                                <option value="{{$plat->id}}">{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Applied Cities <b>(required)</b></label>
                                        <select class="form-control select multi-select" id="cities" name="cities[]" multiple="multiple" required>

                                            @foreach($cities as $plat)
                                                <option value="{{$plat->id}}" >{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">From where you heard about us.?  <b>(required)</b></label>
                                        <select class="form-control select" id="promotion_type" name="promotion_type" required>
                                            <option value="" >select an option</option>
                                            @foreach($socials as $soc)
                                                <option value="{{$soc->id}}" >{{$soc->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3 hide_cls" id="other_source_name_div" >
                                        <label for="repair_category">Enter Other Source Name</label>
                                        <input type="text" name="other_source_name" id="other_source_name" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group mb-3 hide_cls" id="social_id_name_div" >
                                        <label for="repair_category">Social Media ID Name</label>
                                        <input type="text" name="social_id_name" id="social_id_name" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Care Of.?  <b>(optional)</b></label>
                                        <select class="form-control care_class_select " id="care_of" name="care_of" >

                                        </select>

                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Remarks <b>(Optional)</b></label>
                                        <textarea class="form-control" id="remarks" name="remarks" ></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-5" style="margin-bottom:05px;">
                                                <label for="visit_entry_date">Document Name <b>(Optional)</b></label>
                                                <select class="form-control" name="physical_doc_name_1">
                                                    <option value="" selected disabled>Select Option</option>
                                                @foreach ($career_doc_name as $reason)
                                                    <option value="{{$reason->id}}">{{ $reason->name }}</option>
                                                @endforeach
                                                </select>


                                            </div>
                                            <div class="col-md-5" style="margin-bottom:05px;">
                                                <label for="visit_entry_date">Select Image  <b>(Optional)</b></label>
                                                <input type="file" name="physical_doc_image_1[]" id="physical_doc_image"  multiple class="form-control" >
                                                <input type="hidden" name="image_array" id="image_array" value="1">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-icon m-1 " id="btn_add_doc_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                            </div>
                                        </div>
                                        <div class="row doc_row_append"> </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="row existing_physical_doc">

                                        </div>

                                    </div>





                                </div>

                            </div>


                        </div>
{{--                        <div class="col-md-12">--}}
{{--                            <button class="btn btn-primary save-btn">Update </button>--}}
{{--                        </div>--}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" id="update_wait_button" type="button">Update And Send To wait List</button>
                                            </div>
                                            <div class="col-md-4 text-center  hide_cls ">
                                                <button class="btn btn-info" id="update_only" type="button">Update Only</button>
                                            </div>
                                            <div class="col-md-4 hide_cls" >
                                                <button class="btn btn-success" id="update_and_create_ppuid" type="button">Update And Create PPUID</button>
                                            </div>
                                    <input type="hidden" name="button_type_click" id="button_type_click" value="">
                                    <input type="submit" id="submit_from_button" style="display: none" value="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>
                    <div class="modal-footer mr-3">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overlay"></div>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

    <script src="{{asset('assets/international_js/build/js/intlTelInput.js')}}"></script>



    <script>
        $("#national_id").change(function () {

            var ids  = $(this).val();
            if(ids=="1"){
                $("#nic_expiry").prop("required",true);
                $(".nic_expiry_div").show();
            }else{
                $("#nic_expiry").prop("required",false);
                $(".nic_expiry_div").hide();
            }

        });

        $("#nic_expiry").change(function () {

            var nic_expiry  = $(this).val();

            // var d = new Date(nic_expiry);
            // console.log(d.toLocaleDateString());

            const date1 = new Date();
            const date2 = new Date(nic_expiry);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            console.log(diffTime + " milliseconds");
            console.log(diffDays + " days");
            if(diffDays<=30){
                tostr_display("error","we can not process,expiry remain Less than one month");
            }



            var parameterDate = DateTime.ParseExact(date2, "yyyy/MM/dd", CultureInfo.InvariantCulture);
            var todaysDate = DateTime.Today;

            if(parameterDate < todaysDate)
            {
                tostr_display("error","we can not process,expiry remain Less than one month");
            }



        });


        </script>

    <script>

        function destroy_init(id_now) {

            var input = document.querySelector("#"+id_now);
            var iti = window.intlTelInput(input)
            iti.destroy();

        }


        function  make_phone_country_code(country_name) {
            var html = '<label for="repair_category">Phone <b>(required)</b></label>\n' +
                '<input class="form-control form-control-rounded "   autocomplete="off"  name="phone"  id="phone" value="" type="text"  required />';

            $(".append_phone_now").html('')
            $(".append_phone_now").append(html);


            var input = document.querySelector("#phone");
            window.intlTelInput(input, {
                autoPlaceholder: "on",
                formatOnDisplay: true,
                autoPlaceholder: "polite",
                hiddenInput: "full_number",
                initialCountry: country_name,
                onlyCountries: ['in', 'bd', 'ne', 'sd','np','ae','pk'],
                placeholderNumberType: "MOBILE",
                preferredCountries: ['ae', 'pk'],
                separateDialCode: true,
                utilsScript: "{{ asset('assets/international_js/build/js/utils.js') }}",
            });

            setTimeout(function(){
                var input = document.querySelector("#phone");
                var iti = window.intlTelInputGlobals.getInstance(input);
                var countryData = iti.getSelectedCountryData();
                console.log(countryData['dialCode']);
                var phone = $("#phone").val();
                var now_number = "+"+countryData['dialCode']+phone;
                $("input[name='full_number']").val(now_number);

                }, 1000);




            input.addEventListener("countrychange", function() {

                var iti = window.intlTelInputGlobals.getInstance(input);
                var abc = iti.getSelectedCountryData();

                 var phone = $("#phone").val();

                var final_number = "+"+abc['dialCode']+phone;

                $("input[name='full_number']").val(final_number)

            });
        }

        $('body').on('change','#phone', function(){
            var input = document.querySelector("#phone");

            var iti = window.intlTelInputGlobals.getInstance(input);
            var abc = iti.getSelectedCountryData();
            var phone = $("#phone").val();
            var final_number = "+"+abc['dialCode']+phone;
            $("input[name='full_number']").val(final_number);
        });




        function make_whatsapp_country_code(country_name) {

            var html = '<label for="repair_category">Whats App <b>(required)</b></label>\n' +
                '<input class="form-control form-control-rounded" id="whatsapp" name="whatsapp" value="" type="text" required />';

            $(".append_whatsapp_now").html('')
            $(".append_whatsapp_now").append(html);

            var input_whatsapp = document.querySelector("#whatsapp");


                window.intlTelInput(input_whatsapp, {
                    // dropdownContainer: document.body,
                    autoPlaceholder: "on",
                    formatOnDisplay: true,
                    autoPlaceholder: "polite",
                    hiddenInput: "whats_app_full_number",
                    initialCountry: country_name,
                    onlyCountries: ['ae','pk', 'in', 'bd', 'ne', 'sd','np'],
                    placeholderNumberType: "MOBILE",
                    preferredCountries: ['ae', 'pk'],
                    separateDialCode: true,
                    utilsScript: "build/js/utils.js",
                });



            setTimeout(function(){
                var input_whatsapp = document.querySelector("#whatsapp");
                var iti = window.intlTelInputGlobals.getInstance(input_whatsapp);
                var countryData = iti.getSelectedCountryData();
                console.log(countryData['dialCode']);
                var phone = $("#whatsapp").val();
                var now_number = "+"+countryData['dialCode']+phone;
                $("input[name='whats_app_full_number']").val(now_number);

            }, 1000);


            input_whatsapp.addEventListener("countrychange", function() {
                var iti = window.intlTelInputGlobals.getInstance(input_whatsapp);
                var abc = iti.getSelectedCountryData();

                var phone = $("#whatsapp").val();

                var final_number = "+"+abc['dialCode']+phone;

                $("input[name='whats_app_full_number']").val(final_number)
            });
        }

        $('body').on('change','#whatsapp', function(){
            var input = document.querySelector("#whatsapp");

            var iti = window.intlTelInputGlobals.getInstance(input);
            var abc = iti.getSelectedCountryData();
            var phone = $("#whatsapp").val();
            var final_number = "+"+abc['dialCode']+phone;
            $("input[name='whats_app_full_number']").val(final_number);
        });
    </script>

    <script>
        function make_physical_doc_name(name){
            var image_name  = [

                @foreach($career_doc_name as $reason)
                "{{ $reason->name }}",
                @endforeach
            ];
            var html = '<div class="col-md-4" >' +
                '<h5>'+image_name[name]+'</h5>' +
                '</div>'

            return html;
        }
        function make_div_physical_images(images){

            var html = '<div class="col-md-8" style="margin-bottom:05px;">'+images+'</div>'
            return html;
        }

        function make_physical_doc_image(image_url) {
            var html = '<a href="{{ url("/")."/" }}'+image_url+'"  class="mr-3" target="_blank">view Image</a>';

            return html;
        }
        </script>




    <script>
        $("#update_wait_button").click(function () {

            var visa_status = $('input[name="visa_status"]:checked').val();
            // $("#passport_modal").modal("show");


            if(visa_status=="1"){
                $("#update_and_create_ppuid").click();
            }else if(visa_status=="2"){


                var cancel_visa = $('input[name="cancel_visa_status"]:checked').val();
                if(cancel_visa=="3"){
                    $("#button_type_click").val("2");
                    $("#update_only").click();
                }else{
                    $("#button_type_click").val("2");
                    $("#submit_from_button").click();
                }

            }else if(visa_status=="3") {
                var own_visa = $('input[name="own_visa_status"]:checked').val();
                if (own_visa == "1") {
                    $("#update_and_create_ppuid").click();
                } else {
                    $("#button_type_click").val("1");
                    $("#submit_from_button").click();
                }
            }else{
                $("#button_type_click").val("1");
                $("#submit_from_button").click();
            }

        });

        $("#ask_send_wait_list").click(function(){
            $("#button_type_click").val("1");
            $("#submit_from_button").click();

            $("#ask_modal_close_btn").click();
        });

        $("#ask_send_wait_list_and_ppuid").click(function(){
            $("#button_type_click").val("1");
            $("#update_and_create_ppuid").click();
            $("#ask_modal_close_btn").click();
        });


        $("#update_only").click(function () {
            $("#button_type_click").val("2");
            $("#submit_from_button").click();
        });
        $("#update_and_create_ppuid").click(function () {
            $("#button_type_click").val("3");
            // $("#passport_modal").modal("show");
            $("#submit_from_button").click();
        });
        </script>

<script> var only_passport_suggest =  "{{ route('only_passport_suggest') }}"; </script>

    <script>
        var path_autocomplete = "{{ route('autocomplete_career') }}";
        var get_information_path = "{{ route('ajax_view_edit_detail') }}";
        var ajax_check_the_passport_info =  "{{ route('ajax_check_the_passport_info') }}"

     </script>



    <script src="{{ asset('js/custom_js/career_autofill.js') }}"></script>




    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>

{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>

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
     </script>



    <script>
        tail.DateTime("#licence_issue_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#licence_expiry_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#passport_expiry",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#dob",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#visit_exit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#cancel_fine_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#nic_expiry",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });
        tail.DateTime("#submit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });


    </script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#role').select2({
                placeholder: 'Select an option'
            });
            $('#platform_id').select2({
                placeholder: 'Select an option'
            });
            $('#department').select2({
                placeholder: 'Select an option'
            });
            $('#major_department_ids').select2({
                placeholder: 'Select an option'
            });

            $('#cities').select2({
                placeholder: 'Select an option'
            });

            $('#promotion_type').select2({
                placeholder: 'Select an option'
            });

            $('#national_id').select2({
                placeholder: 'Select an option'
            });

            // $('#care_of').select2({
            //     placeholder: 'Select an option'
            // });

            $('#select_amount_step').select2({
                placeholder: 'Select an option'
            });













        });
    </script>

    <script>
        $(".employee_type_cls").change(function () {

            var value = $(this).val();

            if(value=="1"){
                $(".visa_detail_cls").show();
                $(".four_pl_name_cls").hide();
                $("#four_pl_name").prop("required",false);

                $('input:radio[name=visa_status]').each(function () { $(this).prop('checked', false); })
                $('input:radio[name=visit_visa_status]').each(function () { $(this).prop('checked', false); })
                $('input:radio[name=cancel_visa_status]').each(function () { $(this).prop('checked', false); })
                $('input:radio[name=own_visa_status]').each(function () { $(this).prop('checked', false); })
            }else{
                $(".visa_detail_cls").hide();
                $(".four_pl_name_cls").show();
                $('#four_pl_name').select2({
                    placeholder: 'Select an option'
                });
                $("#four_pl_name").prop("required",true);
            }




        });
    </script>

    <script>

        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".visit_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();
            }else if(selected=="2"){

                $(".cancel_visa_status_cls").show();
                $(".visit_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();

            }else if(selected=="3"){

                $(".own_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }else{
                $(".own_visa_status_cls").hide();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }
        });

        $('input[type=radio][name=license_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".driving_licence_div_cls").css('display','block');
                $(".select2-container").css('width','100%');
                $(".visa_status_own_div_cls").show();



            }else{
                $(".visa_status_own_div_cls").hide();
                $("#visa_status_own").prop("checked",false);
                $("#own_visa_noc").prop("checked",false);
                $("#own_visa_without_noc").prop("checked",false);
                $(".driving_licence_div_cls").hide();
            }

        });
    </script>

    <script>
     $("#promotion_type").change(function () {
    var selected_ab = $(this).val();

    if(selected_ab=="7"){
    $("#other_source_name_div").show();
    $("#other_source_name").prop('required',false);

    $("#social_id_name_div").hide();
    $("#social_id_name").prop('required',false);

    }else{
        $("#other_source_name_div").hide();
        $("#other_source_name").prop('required',false);
    }

     if(selected_ab == "1" || selected_ab == "2" || selected_ab == "3"  || selected_ab == "5"){
         $("#social_id_name_div").show();
         $("#social_id_name").prop('required',false);
     }else{
         $("#social_id_name_div").hide();
         $("#social_id_name").prop('required',false);
     }

     });
     </script>


    <script>

            $(".care_class_select").select2({
            ajax: {
                url: "{{ route('search_passport_json') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for Passport',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'>"+repo.full_name+"</div>" +
                "<div class='select2-result-repository__description'>"+repo.passport_no+"</div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            return $container;
        }

        function formatRepoSelection (repo) {
            return repo.full_name || repo.text;
        }
    </script>

    <script>


        $("#licence_city").select2({
            ajax: {
                url: "{{ route('search_city_json') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for City',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'>"+repo.name+"</div>" +
                // "<div class='select2-result-repository__description'>"+repo.passport_no+"</div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            return $container;
        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }
    </script>





    {{--    ajax form start--}}
    <script>
        // this is the id of the form
        $("#update_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();
            var url = $("#update_form").attr('action');
            var button_type_click = $("#button_type_click").val();

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
                        tostr_display("success","Career Updated Successfully");

                        if(button_type_click=="3"){
                            var careeer_id = $("#career_id").val();
                            $("#career_primary_id").val(careeer_id);

                            var nation_id = $("#national_id option:selected").val();
                            var passport_no = $("#passport_no").val();

                            $("#nation_id").val(nation_id).trigger('change');
                            $("#passport_number").val(passport_no);

                            if(nation_id=="1"){
                                $(".nic_number_div").show();
                                $("#nic_number").prop('required',true);
                            }else{
                                $(".nic_number_div").hide();
                                $("#nic_number").prop('required',false);
                            }

                            $("#passport_modal").modal('show');
                        }else if(button_type_click=="2") {
                            $("#ask_sm_modal").modal('show');
                        }else{
                            window.setTimeout(function(){
                                location.reload(true)
                            },1000);
                        }

                        // alert("agreement is submitted");
                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });


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

                        // window.setTimeout(function(){
                        //     location.reload(true)
                        // },1000);

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
                    if($.trim(response)=="success"){
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

        var medical_selected = 0;
        var evisa_selected = 0;

        $('.step_amount_row').on('change', '.select_amount_step_cls', function() {



            var selecteed_val = $(this).val();

            if(selecteed_val=="11" || selecteed_val=="12" || selecteed_val=="13" || selecteed_val=="14"){
                medical_selected = "1";
            }

            if(selecteed_val=="6" || selecteed_val=="7"){
                evisa_selected = "1";
            }


        });
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

            $("#final_amount_label_cls").html(now_remain);

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
            var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $single_name)<option value="{{ $single_name->names }}">{{ $single_name->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            return html;
        }

        function add_new_document_row(id){
            var html = '<div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Document Name</label><select class="form-control" name="physical_doc_name_'+id+'"><option value="" selected disabled>please select option</option> @foreach($career_doc_name as  $reason)<option value="{{$reason->id}}">{{ $reason->name }}</option>@endforeach</select></div><div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Select Image</label><input type="file" name="physical_doc_image_'+id+'[]" id="doc_image-'+id+'"  multiple class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 doc_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_doc-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            var value_current = $("#image_array").val();
            var now_value = value_current+","+id;
            $("#image_array").val(now_value);
            return html;
        }
    </script>


    <script>
        function append_form_amount_step(id){
            html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps) @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" ) <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>    @elseif($steps->id=="6" || $steps->id=="7") <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option> @else <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option> @endif  @endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
            return html;
        }
        var count_amount_step = 0;
        $(".add_step_form_btn").click(function(){

            count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;

            $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));

            $('#select_amount_step-'+count_amount_step).select2({
                placeholder: 'Select an option'
            });

            var id_of_dropdown  = 'select_amount_step-'+count_amount_step;
            if(medical_selected=="1"){
                $("#"+id_of_dropdown+" option[value='11']").remove();
                $("#"+id_of_dropdown+" option[value='12']").remove();
                $("#"+id_of_dropdown+" option[value='13']").remove();
                $("#"+id_of_dropdown+" option[value='14']").remove();
            }

            if(evisa_selected=="1"){
                $("#"+id_of_dropdown+" option[value='6']").remove();
                $("#"+id_of_dropdown+" option[value='7']").remove();
            }



        });

        $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {

            var ids = $(this).attr('id');

            $("."+ids).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

            $("#final_amount_label_cls").html(now_remain);

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

            $("#final_amount_label_cls").html(remain_val);

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

           var now_remain = parseFloat(final_amount)-parseFloat(sum);

            $("#final_amount_label_cls").html(now_remain);




        });




    </script>

    <script>
        $("[data-toggle=popover]").popover();
    </script>


@endsection
