@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <style>
        .add_btn{
            /*float:left;*/
            /*margin-top: 10px;*/
        }
        .add_btn_form{
            float:right;
            margin-top: 10px;
        }

        .hide_cls_six{
            display: none;
        }
        .main_bread_crumb{
            margin-top :-30px;
        }
        .breadcrumb{
            margin: 0 0 -0.75rem;
        }
        .separator-breadcrumb{
            margin-bottom : 3px;
        }
        .card-body{
            padding: 6px;
        }
        .form-group{
            margin-bottom: 0px;
        }
        .card-title {
            font-size: 0.75rem;
            margin-bottom: 0.2rem;
        }
        .radio {
            margin-bottom : 3px;
        }
        .col_4_formating{
            border: 1px solid;
            padding: 5px;
        }
        .amount_step_section{
            padding: 7px;
            margin-top: 7px !important;
            margin-bottom: 5px
        }
        table tr{
            font-size: 14px;
        }
        .table th{
            padding: 0px;
        }
        .table td{
            padding: 0px;
        }

        .amount_detail_label{
            margin-top: 10px;
        }

        .error{
            color: red !important;
        }

        .ar_fields_formate_cls{
            color: #390ba6;
            font-weight: 700;
        }

        .row_amount_cls{
            Auth::user()->major_department_ids))
                display: none !important;
            @endif
        }



    </style>

    <form id="agreement_form"  action ="{{ route('agreement_amendment.store') }}" method="POST" enctype="multipart/form-data" >
        {!! csrf_field() !!}

        <input type="hidden" name="agreement_id" value="{{ request()->segment(2) }}">

        <div class="row">
            <div class="col-md-8">
                <div class="breadcrumb main_bread_crumb">
                    <h6 class="mr-2">Agreement</h6>
                    <div class="col-md-3 form-group mb-3">
                        <label for="repair_category">Passport Number</label>

                        <input readonly type="text" class="form-control" id="passport_number" name="passport_number" value="{{ $pending_passports[0]['passport_number'] }}" >
                        <input readonly type="hidden" class="form-control" id="passport_primay_id" name="passport_id" value="{{ $pending_passports[0]['passport_id'] }}" >
                    </div>

                    <div class="col-md-3 form-group mb-3 text-center" id="unique_div" >
                        <label for="repair_category">Unique Id</label>
                        <h6 id="unique_id">{{ $pending_passports[0]['pp_uid'] }}</h6>
                    </div>

                    <input type="hidden" name="agreement_no" value="{{   $agreement->agreement_no  }}">
                    <div class="col-md-3 form-group mb-3 text-center">
                        <label for="repair_category">Agreement Id</label>
                        <h6>{{  $agreement->agreement_no  }} / {{ $next_amendment }} </h6>
                    </div>

                </div>

                <div class="separator-breadcrumb border-top"></div>
                {{--          agreement section end here--}}

                <div class="card">
                    <div class="card-body">
                        <h6 class="mr-2">Reference</h6>
                        <div class="row">
                            <div class="col-md-6 form-group "  >
                                <label for="repair_category">Select Reference</label>
                                <select id="ref_type" name="ref_type" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    <option value="1" {{ ($agreement->reference_type=="1") ? 'selected' : ''  }}  >Own Company Rider</option>
                                    <option value="2" {{ ($agreement->reference_type=="2") ? 'selected' : ''  }} >Out side</option>
                                    <option value="3" {{ ($agreement->reference_type=="3") ? 'selected' : ''  }} >Walk in Candidate</option>
                                </select>
                            </div>


                            <div class="col-md-6 form-group mb-3" id="own_company_div"
                                 @if(($agreement->reference_type=="1")) @else style="display: none;" @endif  >
                                <label for="firstName1">Select Reference Name</label>
                                <select id="rider_name" name="rider_name" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    @foreach($riders as $rider)
                                        <option value="{{  $rider->id }}"  {{ ($agreement->reference_type_own==$rider->id) ? 'selected' : ''  }} >{{  $rider->personal_info ?$rider->personal_info->full_name:"No Name"  }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row" id="outside_div"
                             @if(($agreement->reference_type=="2")) @else style="display: none;" @endif  >

                        <?php if(!empty($agreement->reference_type_own)){

                          }else{
                    $array_json = json_decode($agreement->reference_type_outside,true);
                    $count = 0;
                    $t_count = count((array)$array_json['name']);

                    foreach((array)$array_json['name'] as $values){ ?>
                            <div class="col-md-2 form-group mb-3"   >
                                <label for="refernce">Reference Name</label>
                                <input class="form-control" name="reference_name[]" value="{{ $values }}" type="text" placeholder="Enter Refernce Name" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">Contact number</label>
                                <input class="form-control" name="contact_nubmer[]" value="{{ $array_json['contact_nubmer'][$count] }}" type="text" placeholder="Enter Contact number" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">whats App number</label>
                                <input class="form-control" name="whatsppnumber[]" value="{{ $array_json['whatsppnumber'][$count] }}" type="text" placeholder="Enter whats app number" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">Social media FB</label>
                                <input class="form-control" name="socialmedia[]"  value="{{ $array_json['socialmedia'][$count] }}" type="text" placeholder="Enter social media Link" />

                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="wokring_place">Working Place</label>
                                <input class="form-control" name="wokring_place[]"  value="{{ $array_json['working_place'][$count] }}" type="text" placeholder="Enter Working Place" />

                            </div>


{{--                            <div class="col-md-2 form-group mb-3"   >--}}
{{--                                <button class="btn btn-primary btn-sm pull-right text-right add_btn"  type="button" >add</button>--}}
{{--                            </div>--}}

                <?php $count = $count+1;
                                  if($count==$t_count){ ?>
                                            <div class="col-md-2 form-group mb-3"   >
                                                <label style="visibility: hidden;" for="wokring_place">Working Place</label>
                                                <button class="btn btn-primary btn-sm pull-right text-right add_btn" id="add_row"  type="button" >add</button>
                                            </div>
                                  <?php }else{ ?>
                                        <div class="col-md-2 form-group mb-3"   >

                                        </div>
                                   <?php } ?>

                 <?php } ?>
                        <?php } ?>

                            @if(empty($agreement->reference_type_outside))

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="refernce">Reference Name</label>
                                <input class="form-control" name="reference_name[]" type="text" placeholder="Enter Refernce Name" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">Contact number</label>
                                <input class="form-control" name="contact_nubmer[]" type="text" placeholder="Enter Contact number" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">whats App number</label>
                                <input class="form-control" name="whatsppnumber[]" type="text" placeholder="Enter whats app number" />
                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="contact_nubmer">Social media FB</label>
                                <input class="form-control" name="socialmedia[]" type="text" placeholder="Enter social media Link" />

                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <label for="wokring_place">Working Place</label>
                                <input class="form-control" name="wokring_place[]" type="text" placeholder="Enter Working Place" />

                            </div>

                            <div class="col-md-2 form-group mb-3"   >
                                <button class="btn btn-primary btn-sm pull-right text-right add_btn"  type="button" id="add_row">add</button>
                            </div>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="separator-breadcrumb border-top"></div>
                <h6 class="mr-2">Employee Type</h6>
                <div class="row">
                    <div class="col-md-6 form-group mb-3"  >
                        <label for="repair_category">Select Employee Type</label>
                        <select  name="employee_type" id="employee_type" required class="form-control form-control-rounded">
                            <option value="" selected disabled  >Select option</option>
                            @foreach($employee_types as $employee)
                                <option value="{{ $employee->id  }}" {{ ($agreement->employee_type_id==$employee->id) ? 'selected' : ''  }}  >{{ $employee->name  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="separator-breadcrumb border-top"></div>
                {{--          reference serprator--}}
                <h6 class="mr-2 current-status_div" style="display: none;">Current Status</h6>

                <input type="hidden" name="current_status_amount_field" id="current_status_amount_field" value=" ">
                <input type="hidden" name="current_status_amount_primary_id" id="current_status_amount_primary_id" value=" ">

                <div class="row current-status_div" >
                    <div class="col-md-6 form-group mb-3"  >
                        <label for="repair_category">Select Current Status</label>
                        <select id="current_status" name="current_status" id="current_status" required class="form-control form-control-rounded">
                            <option value="" selected disabled  >Select option</option>

                            @if(!empty($current_status_child))
                                @foreach($current_status_child as $curent_ab)

                                    @if($curent_ab->get_parent_name->name_alt=="Renew")
                                    @else
                                        <option value="{{ $curent_ab->id  }}"  {{  ($agreement->current_status_id==$curent_ab->id) ?  'selected' :  '' }}  >{{ $curent_ab->get_parent_name->name_alt  }}</option>
                                    @endif

                                @endforeach
                            @endif
                        </select>
                    </div>

                    <?php
                    $start_date = null;
                    $end_date = null;

                    if(!empty($agreement->current_status_start_date)){
                        $gamer = explode(" ",$agreement->current_status_start_date);
                        $start_date = $gamer[0];
                    }

                    if(!empty($agreement->current_status_end_date)){
                        $gamer = explode(" ",$agreement->current_status_end_date);
                        $end_date = $gamer[0];
                    }

                    ?>

                    @if($agreement->current_status_id=="3" || $agreement->current_status_id=="4" || $agreement->current_status_id=="5")
                    <div class="col-md-6 form-group mb-3 transfer_exit"     >
                        <label for="repair_category">Exit Date</label>
                        <input type="text" name="transer_exit_date" value="{{ $end_date }}" autocomplete="off" class="form-control form-control-rounded" id="transer_exit_date">
                    </div>
                    @else
                        <div class="col-md-6 form-group mb-3 transfer_exit"  style="display: none"   >
                            <label for="repair_category">Exit Date</label>
                            <input type="text" name="transer_exit_date" autocomplete="off" class="form-control form-control-rounded" id="transer_exit_date">
                        </div>
                    @endif

                    @if($agreement->current_status_id=="2")
                    <div class="col-md-3 form-group mb-3 transfer_visit"  @if(empty($agreement->current_status_start_date)) style="display: none"  @endif >
                        <label for="visit_entry_date">Entry Date</label>
                        <input type="text" name="visit_entry_date" value="{{ $start_date }}" autocomplete="off" class="form-control form-control-rounded" id="visit_entry_date">

                    </div>

                    <div class="col-md-3 form-group mb-3 transfer_visit" @if(empty($agreement->current_status_end_date)) style="display: none"  @endif  >
                        <label for="visit_exit_date">Exit Date</label>
                        <input type="text" name="visit_exit_date" autocomplete="off" value="{{ $end_date }}" class="form-control form-control-rounded" id="visit_exit_date">
                    </div>
                    @else
                        <div class="col-md-3 form-group mb-3 transfer_visit"   style="display: none"  >
                            <label for="visit_entry_date">Entry Date</label>
                            <input type="text" name="visit_entry_date" value="" autocomplete="off" class="form-control form-control-rounded" id="visit_entry_date">

                        </div>

                        <div class="col-md-3 form-group mb-3 transfer_visit"  style="display: none"   >
                            <label for="visit_exit_date">Exit Date</label>
                            <input type="text" name="visit_exit_date" autocomplete="off" value="" class="form-control form-control-rounded" id="visit_exit_date">
                        </div>

                        @endif

                    <div class="col-md-6 form-group mb-3 expected_date"  style="display: none"  >
                        <label for="repair_category">Expected Date</label>
                        <input type="text" name="expected_date" autocomplete="off" class="form-control form-control-rounded" id="expected_date">

                    </div>

                </div>

                <div class="separator-breadcrumb border-top"></div>
                {{--          current status serparator--}}

                <h6 class="mr-2 visa_requirement_div" @if(empty($agreement->working_visa)) style="display: none;" @endif >Visa Requirements</h6>

                <div class="row visa_requirement_div" @if(empty($agreement->working_visa)) style="display: none;" @endif>
                    <div class="col-md-6 form-group "  >
                        <label for="visa_requirement">Select Working Visa </label>
                        <select name="working_visa" id="working_visa" required  class="form-control form-control-rounded">
                            <option value=""  >Select option</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id  }}" {{ ($company->id==$agreement->working_visa) ? 'selected' : '' }}  >{{ $company->name  }}</option>
                            @endforeach
                        </select>
                    </div>


                    @if(!empty($agreement->applying_visa))
                    <div class="col-md-6 form-group mb-3 visa_applying_div"  >
                        <label for="visa_applying">Select Visa Applying</label>
                        <select  name="visa_applying" id="visa_applying" required class="form-control form-control-rounded">
                            <option value=""  >Select option</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id  }}" {{ ($company->id==$agreement->applying_visa) ? 'selected' : '' }}  >{{ $company->name  }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else

                        <div class="col-md-6 form-group mb-3 visa_applying_div hide_cls_six"  >
                            <label for="visa_applying">Select Visa Applying</label>
                            <select  name="visa_applying" id="visa_applying"  class="form-control form-control-rounded">
                                <option value=""  >Select option</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id  }}" {{ ($company->id==$agreement->applying_visa) ? 'selected' : '' }}  >{{ $company->name  }}</option>
                                @endforeach
                            </select>
                        </div>

                    @endif
                </div>

                <div class="row visa_requirement_div" @if(empty($agreement->working_designation)) style="display: none;" @endif   >
                    <div class="col-md-4 form-group "  >
                        <label for="working_designation">Select Working Job Type</label>
                        <select id="working_designation" required name="working_designation"  class="form-control form-control-rounded">
                            <option value=""  >Select option</option>
                            <option value="2" {{ ($agreement->working_designation=="2") ? 'selected' : '' }}  >Rider</option>
                            <option value="3" {{ ($agreement->working_designation=="3") ? 'selected' : '' }} >Driver</option>
                            <option value="4" {{ ($agreement->working_designation=="4") ? 'selected' : '' }} >Service</option>
                            <option value="5" {{ ($agreement->working_designation=="5") ? 'selected' : '' }} >Body Shop</option>
                            <option value="6" {{ ($agreement->working_designation=="6") ? 'selected' : '' }} >Garage</option>
                            <option value="7" {{ ($agreement->working_designation=="7") ? 'selected' : '' }} >Office</option>
                            <option value="8" {{ ($agreement->working_designation=="8") ? 'selected' : '' }} >Bike Work shop</option>

                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3"  >
                        <label for="visa_requirement">Select Working Job</label>
                        <select id="visa_designation" required name="visa_designation" id="visa_designation" class="form-control form-control-rounded">
                            <option value=""  >select option</option>
                            @foreach($desginations as $des)
                                <option value="{{ $des->id }}" {{ ($agreement->visa_designation==$des->id) ? 'selected' : '' }}   >{{ $des->other_jobs }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4 form-group mb-3" style="display:none;"  >
                        <label for="visa_requirement">Visa Job Request</label>
                        <select  required name="visa_job_request" id="visa_job_request" class="form-control form-control-rounded">
                            <option value=""  >select option</option>
                            @foreach($visa_job_requests as $ab)
                                <option value="{{ $ab->id }}"  >{{ $ab->name }}</option>
                            @endforeach


                        </select>
                    </div>

                    <!--              visa_job_requests-->

                </div>


                <div class="separator-breadcrumb border-top"></div>
                {{--          visa requirement separator--}}

                <h6  class="mr-2 driving_license_div" style="display: none;" >Driving License</h6>

                <input type="hidden" name="driving_license_amount_field" id="driving_license_amount_field" value=" ">
                <input type="hidden" name="driving_license_amount_primary_id" id="driving_license_amount_primary_id" value=" ">

                <div class="render_main_cls driving_license_div" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card-body">

                                <div class="card-title">Driving License</div>
                                <label class="radio radio-outline-success" id="license_want_yes" >
                                    <input type="radio" data="Yes" value="1"  {{  ($agreement->driving_licence=="1") ? 'checked':'' }}  name="driving_license"  class="driving_license"  id="need_license_id"  /><span>Need New License</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary" id="already_have_label" >
                                    <input type="radio"  data="already" value="2" {{  ($agreement->driving_licence=="2") ? 'checked':'' }}  id="already_have"  name="driving_license"  class="driving_license"  id="already_license_id"  /><span>Already have</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary" id="not_required_license_label">
                                    <input type="radio"  data="No" value="3" {{  ($agreement->driving_licence=="3") ? 'checked':'' }} id="not_required_license"  name="driving_license"  class="driving_license"  id="not_required_license"  /><span>Not Required License</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 source_div" style="display:none;" >
                            <div class="card-body">
                                <div class="card-title">Source From</div>
                                <label class="radio radio-outline-success">
                                    <input type="radio"  value="1"  name="source_type"  class="source_from"   /><span>Company</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary">
                                    <input type="radio"   value="2"  name="source_type"  class="source_from"   /><span>Own</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>


                        <div class="col-md-3 license_type_div" <?php   if($agreement->driving_licence!="1"){  ?> style="display:none;" <?php  } ?> >
                            <div class="card-body">
                                <div class="card-title">License Type</div>
                                <label class="radio radio-outline-success" id="bike_label">
                                    <input type="radio" data="Yes" value="1"   {{  ($agreement->driving_licence_vehicle=="1") ?  'checked' :  '' }}  name="license_type"  id="bike" class="licens_type"    /><span>Bike</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary" id="car_label" >
                                    <input type="radio"  data="No" value="2" {{  ($agreement->driving_licence_vehicle=="2") ?  'checked' :  '' }}  name="license_type"  id="car" class="licens_type"   /><span>Car</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary" id="both_label" >
                                    <input type="radio"  data="No" value="3"  {{  ($agreement->driving_licence_vehicle=="3") ?  'checked' :  '' }} name="license_type"  id="both" class="licens_type"   /><span>Both</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 car_type_div" <?php   if($agreement->driving_licence_vehicle!="3" ){  ?> style="display:none;" <?php  } ?>   >
                            <div class="card-body">
                                <div class="card-title">Car Type</div>
                                <label class="radio radio-outline-success" id="automatic_car_label">
                                    <input type="radio" data="Yes" value="1" id="automatic_car"  name="car_type" {{  ($agreement->driving_licence_vehicle_type=="1") ?  'checked' :  '' }}  class="car_type"  checked  /><span>Automatic Car</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-outline-secondary" id="manual_car_label">
                                    <input type="radio"  data="No" value="2" id="manual_car"  name="car_type"  {{  ($agreement->driving_licence_vehicle_type=="2") ?  'checked' :  '' }} class="car_type"   /><span>Manual Car</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>


                    </div>

                    <div class="row drive_license_source_cls">

                    </div>

                </div>

                <div class="separator-breadcrumb border-top"></div>


                <input type="hidden" name="evisa_print_amount_field" id="evisa_print_amount_field" value=" ">
                <input type="hidden" name="evisa_print_amount_primary_id" id="evisa_print_amount_primary_id" value=" ">

                <div class="row full_type_inside only_full_time_employee {{  ($agreement->employee_type_id!="2") ?  'hide_cls_six' :  '' }} ">
                    <div class="col-md-6 ">
                        <div class="card-body">
                            <div class="card-title">E-visa Print</div>
                            <label class="radio radio-outline-success radio_inside_evisa_print">
                                <input type="radio" {{  ($agreement->e_visa_print=="1") ?  'checked' :  '' }}  value="1" name="evisa_print"   id="inside_evisa_print"  /><span>Inside E-visa Print</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success radio_outside_evisa_print">
                                <input type="radio" {{  ($agreement->e_visa_print=="2") ?  'checked' :  '' }} value="2" name="evisa_print"   id="inside_evisa_outside"   /><span>Outside E-visa Print</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 inside_visa_type_row " <?php  if($agreement->e_visa_print!="1"){ ?> style="display: none;" <?php } ?> >
                        <div class="card-body">
                            <div class="card-title">&nbsp;</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="inside_visa_type"  {{  ($agreement->inside_e_visa_type=="1") ?  'checked' :  '' }}   /><span>Inside Status Change</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="inside_visa_type"  {{  ($agreement->inside_e_visa_type=="2") ?  'checked' :  '' }}     /><span>OutSide Status Change</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="separator-breadcrumb border-top"></div>

                {{--          driving license separator--}}


                <input type="hidden" name="medical_process_amount_field" id="medical_process_amount_field" value=" ">
                <input type="hidden" name="medical_process_amount_primary_id" id="medical_process_amount_primary_id" value=" ">

                <div class="row medical_div_cls {{  ($agreement->employee_type_id!="2") ?  'hide_cls_six' :  '' }}   only_full_time_employee" >
                    <div class="col-md-6 form-group "  >
                        <h6 class="mr-2">Document Process</h6>
                        <label for="medical_type">Select Medical</label>
                        <select id="medical_type" name="medical_type" class="form-control form-control-rounded  ">
                            <option value=""  disabled  >select option</option>
                            <option value="1" {{ ($agreement->medical_ownership=="1") ? 'selected' : '' }} >Own</option>
                            <option value="2" {{ ($agreement->medical_ownership=="2") ? 'selected' : '' }} id="medical_company_option" >Company</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group medcial_category_div"  <?php  if($agreement->medical_ownership!="2"){ ?> style="display: none;" <?php  } ?> >
                        <h6 class="mr-2">&nbsp;</h6>
                        <label for="medical_type">Select Medical Type</label>
                        <select id="medical_category" name="medical_category" class="form-control form-control-rounded  ">
                            <option value=""  disabled  >select option</option>
                            <?php $med_counter = 0; ?>
                            @foreach($medical_categories as $medical)
                                <option value="{{ $medical->id }}" {{ ($agreement->medical_ownership_type==$medical->id) ? 'selected': '' }}   >{{ $medical->name }}</option>
                                <?php $med_counter = $med_counter+1; ?>
                            @endforeach
                        </select>
                    </div>



                </div>

                <div class="separator-breadcrumb border-top"></div>
                {{--          Document Process separator--}}

                <input type="hidden" name="emirate_id_amount_field" id="emirate_id_amount_field" value=" ">
                <input type="hidden" name="emirate_id_amount_primary_id" id="emirate_id_amount_primary_id" value=" ">




                <div class="row only_full_time_employee {{  ($agreement->employee_type_id!="2") ?  'hide_cls_six' :  '' }}">
                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">Emirates id</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="emirates_id" {{  ($agreement->emiratesid_ownership=="1") ?  'checked' :  '' }} id="own_of_emirates_id"  /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="emirates_id"  {{  ($agreement->emiratesid_ownership=="2") ?  'checked' :  '' }}  id="company_of_emirates_id"  /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>


                    <input type="hidden" name="visa_pasting_amount_field" id="visa_pasting_amount_field" value=" ">
                    <input type="hidden" name="visa_pasting_amount_primary_id" id="visa_pasting_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">Visa Pasting</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1"  {{  ($agreement->visa_pasting=="1") ?  'checked' :  '' }}  name="visa_pasting"  id="normal_visa_pasting"  /><span>Normal</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2"  {{  ($agreement->visa_pasting=="2") ?  'checked' :  '' }}  name="visa_pasting"  id="urgent_visa_pasting"   /><span>Urgent</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="case_fine_amount_field" id="case_fine_amount_field" value=" ">
                    <input type="hidden" name="case_fine_amount_primary_id" id="case_fine_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">In Case Fine</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="case_fine" {{  ($agreement->fine=="1") ?  'checked' :  '' }}  id="own_case_fine"   /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="case_fine" {{  ($agreement->fine=="2") ?  'checked' :  '' }}   id="company_case_fine"   /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="separator-breadcrumb border-top"></div>

                {{-- Emirates Id separator--}}



                <input type="hidden" name="english_test_amount_field" id="english_test_amount_field" value=" ">
                <input type="hidden" name="english_test_amount_primary_id" id="english_test_amount_primary_id" value=" ">



                <div class="row only_hey_vip_divs  {{  empty($agreement->english_test) ?  'hide_cls_six' :  '' }} ">
                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">English Language Test</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="english_test" {{  ($agreement->english_test=="1") ?  'checked' :  '' }}  id="own_english_test" /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="english_test" {{  ($agreement->english_test=="2") ?  'checked' :  '' }}  id="company_english_test"   /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="rta_permint_amount_field" id="rta_permint_amount_field" value=" ">
                    <input type="hidden" name="rta_permint_amount_primary_id" id="rta_permint_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">RTA Permit Training</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="rta_permit_training" {{  ($agreement->rta_permit_training=="1") ?  'checked' :  '' }}  id="own_permit_training"   /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="rta_permit_training"  {{  ($agreement->rta_permit_training=="2") ?  'checked' :  '' }}   id="company_permit_training"   /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="e_test_amount_field" id="e_test_amount_field" value=" ">
                    <input type="hidden" name="e_test_amount_primary_id" id="e_test_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">E Test</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="e_test"  {{  ($agreement->e_test=="1") ?  'checked' :  '' }}  id="own_e_test" /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="e_test"  {{  ($agreement->e_test=="2") ?  'checked' :  '' }} id="company_e_test"   /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                </div>


                <input type="hidden" name="rta_medical_amount_field" id="rta_medical_amount_field" value=" ">
                <input type="hidden" name="rta_medical_amount_primary_id" id="rta_medical_amount_primary_id" value=" ">

                <div class="row only_hey_vip_divs hide_cls_six">
                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">RTA Medical</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="rta_medical" id="own_rta_medical"  {{  ($agreement->rta_medical=="1") ?  'checked' :  '' }} /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="rta_medical"  id="company_rta_medical" {{  ($agreement->rta_medical=="2") ?  'checked' :  '' }}   /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>


                    <input type="hidden" name="cid_report_amount_field" id="cid_report_amount_field" value=" ">
                    <input type="hidden" name="cid_report_amount_primary_id" id="cid_report_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">CID Report</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="cid_report" id="own_cid_report" {{  ($agreement->cid_report=="1") ?  'checked' :  '' }}  /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="cid_report" id="company_cid_report" {{  ($agreement->cid_report=="2") ?  'checked' :  '' }}  /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="rta_print_amount_field" id="rta_print_amount_field" value=" ">
                    <input type="hidden" name="rta_print_amount_primary_id" id="rta_print_amount_primary_id" value=" ">

                    <div class="col-md-4 ">
                        <div class="card-body">
                            <div class="card-title">RTA Card Print</div>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="1" name="rta_card_print" id="rta_own_card_report"  {{  ($agreement->rta_card_print=="1") ?  'checked' :  '' }} /><span>Own</span><span class="checkmark"></span>
                            </label>
                            <label class="radio radio-outline-success">
                                <input type="radio" value="2" name="rta_card_print" id="rta_company_card_report"  {{  ($agreement->rta_card_print=="2") ?  'checked' :  '' }}  /><span>Company</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>


                </div>






                <input type="hidden" name="status_change_amount_field" id="status_change_amount_field" value=" ">
                <input type="hidden" name="status_change_amount_primary_id" id="status_change_amount_primary_id" value=" ">

                <div class="row hide_cls_six">
                    <div class="col-md-12 ">
                        <div class="card-body">
                            <div class="card-title">Status Change</div>
                            @if(!empty($parent_status_change->childs))

                                @foreach($parent_status_change->childs as $child)

                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="{{ $child->id  }}" name="status_change" class="status_change status_change_option_cls"  /><span>{{ $child->get_parent_name->name_alt  }}</span><span class="checkmark"></span>
                                    </label>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>

                <div class="separator-breadcrumb border-top"></div>
                {{-- Status Change separator--}}



                {{-- In Case Fine separator--}}
                <div class="row hide_cls_six ">
                    <div class="col-md-12 ">
                        <div class="card-body">
                            <div class="card-title">RTA Permit</div>

                            @if(!empty($parent_rta_permit->childs))
                                @foreach($parent_rta_permit->childs as $child)

                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="{{ $child->id }}" name="rta_permit" class="rta_permit_option"  /><span>{{ $child->get_parent_name->name_alt  }}</span><span class="checkmark"></span>
                                    </label>

                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row hide_cls_six">

                    <div class="col-md-6 form-group mb-3"  >
                        <label for="repair_category">Select Living Status</label>
                        <select id="living_status_id"  required name="living_status_id" id="living_status_id" class="form-control form-control-rounded">
                            <option value="" selected disabled  >Select option</option>

                            @foreach($living_statuses as $l_status)
                                <option value="{{ $l_status->id  }}"  >{{ $l_status->name  }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <input type="hidden" name="admin_amount_field" id="admin_amount_field">
                <input type="hidden" name="admin_amount_field_primary_id" id="admin_amount_field_primary_id">

                <input type="hidden" name="admin_driving_licnes_amount_field" id="admin_drivingl_icnes_amount_amount_field">
                <input type="hidden" name="admin_driving_license_amount_field_primary_id" id="admin_driving_license_amount_field_primary_id">








            </div>
            {{--      column 8 end here--}}


            {{--      col 4 start here--}}
            <div class="col-md-4 col_4_formating">

                <div class="row passport_detail_row">
                    <div class="col-md-5">
                        <img src="{{ url($pass->personal_info->personal_image) }}" id="passport_pic"  alt="image will come">
                    </div>

                    <div class="col-md-7">
                        <table class="table">
                            <tr >
                                <td scope="col">Given Name</td>
                                <th scope="col" id="given_name" >{{ $pass->personal_info->full_name }}</th>
                            </tr>
                            <tr>
                                <td scope="col">Email</td>
                                <th scope="col" id="country_code" >{{ $pass->personal_info->personal_email }}</th>
                            </tr>
                            <tr>
                                <td scope="col">Phone</td>
                                <th scope="col" id="phone_number" > {{ $pass->personal_info->personal_mob  }}</th>
                            </tr>
                            <tr>
                                <td scope="col">Remain Days</td>
                                <th scope="col" id="date_expiry" > {{ $remain_days }}</th>
                            </tr>

                        </table>
                    </div>

                </div>


                <div class="row driving_license_detail" style="display: none">
                    <div class="col-md-12">
                        <h6 style="text-align: center;color: #332e38; font-weight: 900;">Driving License Detail</h6>
                        <table class="table">
                            <tr >
                                <td scope="col">License Number</td>
                                <th scope="col" id="license_number_html" ></th>
                            </tr>
                            <tr>
                                <td scope="col">Issue Data</td>
                                <th scope="col" id="issue_data_html" ></th>
                            </tr>
                            <tr>
                                <td scope="col">Expire Date</td>
                                <th scope="col" id="expire_data_html" ></th>
                            </tr>
                            <tr>
                                <td scope="col">Traffic Code Number</td>
                                <th scope="col" id="traffic_code_html" ></th>
                            </tr>

                            <tr>
                                <td scope="col">Place Issue</td>
                                <th scope="col" id="place_issue_html" ></th>
                            </tr>
                            <tr>
                                <td scope="col">License Type</td>
                                <th scope="col" id="license_type_html" ></th>
                            </tr>
                            <tr id="car_type_row">
                                <td scope="col">Car Type</td>
                                <th scope="col" id="car_type_html" ></th>
                            </tr>

                            <tr id="car_type_row">
                                <td scope="col">Remain Days</td>
                                <th scope="col" id="remian_days_html" ></th>
                            </tr>

                        </table>
                    </div>

                </div>



                <h6 class="amount_detail_label">Amounts Detail</h6>
                <button style="float:right" id="generate_button" class="btn btn-info btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-Dollar-Sign"></i></span> Generate Amount</button>
                <input type="hidden" name="labour_fees_ids" id="labour_fees_ids">
                <input type="hidden" name="labour_fees_total" id="labour_fees_total" value="0" >
                <table class="table">
                    <thead class="thead-light labour_fees_table row_amount_cls ">


                    <?php $g_total = 0 ;?>
                    @if(isset($agreement->amounts))

                        @foreach($agreement->amounts as $ab)
                            @if($ab->get_fees_lebel->option_label=="Labor Fees")
                                <tr>
                                    <th scope="col">{{ isset($labour_fees_array[$ab->get_fees_lebel->option_value]) ? $labour_fees_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}</th>
                                    <th scope="col" class="amounts_labour_fees">{{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</th>
                                    <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                                </tr>
                            @endif
                        @endforeach
                     @endif


                    </thead>
                </table>

                <table class="table">
                    <thead class="thead-light">

                    <?php
                    $optio_evisa = "0";
                    $optio_medical = "0";
                    $optio_emirate_id = "0";
                    $optio_visa_pasting = "0";
                    $optio_case_fine = "0";
                    $optio_english_test = "0";
                    $optio_rta_permit_training = "0";
                    $optio_e_test = "0";
                    $optio_rta_medical = "0";
                    $optio_cid_report = "0";
                    $optio_rta_card_print = "0";
                    ?>



                    @if(isset($agreement->amounts))

                        @foreach($agreement->amounts as $ab)
                            @if($ab->get_fees_lebel->option_label=="Labor Fees")


                            @elseif($ab->get_fees_lebel->option_label=="Inside E-visa Print")
                                @if(!empty($ab->amount))
                                    <?php  $optio_evisa = "1";  ?>
                                    <tr class=" inside_status_evisa_print_div row_amount_cls">
                                        <th scope="col">E-visa Print Amount</th>
                                        <th scope="col" id="evisa_print_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                    </tr>
                                @endif
                       <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                            @elseif($ab->get_fees_lebel->option_label=="Medical")
                                @if(!empty($ab->amount))
                                    <?php  $optio_medical = "1";  ?>
                                    <tr class=" div_medical_process row_amount_cls">
                                        <th scope="col">Medical Process Amount</th>
                                        <th scope="col" id="medical_process_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                    </tr>
                                @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                            @elseif($ab->get_fees_lebel->option_label=="Emirates Id")

                                @if(!empty($ab->amount))
                                    <?php  $optio_emirate_id = "1";  ?>
                                    <tr class=" div_emirates_id row_amount_cls">
                                        <th scope="col">Emirates Id Amount</th>
                                        <th scope="col" id="emirate_id_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                    </tr>
                                @endif

                            <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="Visa Pasting")

                                @if(!empty($ab->amount))
                                    <?php  $optio_visa_pasting = "1";  ?>
                                <tr class=" div_visa_pasting_amount row_amount_cls">
                                    <th scope="col">Visa Pasting Amount</th>
                                    <th scope="col" id="visa_pasting_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                               @endif


                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="In Case Fine")

                                @if(!empty($ab->amount))
                                    <?php  $optio_case_fine = "1";  ?>
                                <tr class=" div_case_fine row_amount_cls">
                                    <th scope="col">In case Fine Amount</th>
                                    <th scope="col" id="case_fine_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                                @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                            @elseif($ab->get_fees_lebel->option_label=="English Language Test")

                                @if(!empty($ab->amount))
                                    <?php  $optio_english_test = "1";  ?>
                                    <tr class=" div_englist_test row_amount_cls">
                                        <th scope="col">English Language Test Amount</th>
                                        <th scope="col" id="english_test_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                    </tr>
                                @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="RTA Permit Training")

                                @if(!empty($ab->amount))
                                    <?php  $optio_rta_permit_training = "1";  ?>
                                <tr class=" div_rta_permit_training row_amount_cls">
                                    <th scope="col">RTA Permit Training Amount</th>
                                    <th scope="col" id="rta_permit_training_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                               @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                            @elseif($ab->get_fees_lebel->option_label=="E Test")

                                @if(!empty($ab->amount))
                                    <?php  $optio_e_test = "1";  ?>
                                <tr class=" div_e_test row_amount_cls">
                                    <th scope="col">E Test Amount</th>
                                    <th scope="col" id="e_test_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                                @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="RTA Medical")

                                @if(!empty($ab->amount))
                                    <?php  $optio_rta_medical = "1";  ?>
                                <tr class=" div_rta_medical row_amount_cls">
                                    <th scope="col">RTA Medical Amount</th>
                                    <th scope="col" id="rta_medical_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                                @endif

                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="CID Report")

                                @if(!empty($ab->amount))
                                    <?php  $optio_cid_report = "1";  ?>
                                <tr class=" div_cid_report row_amount_cls">
                                    <th scope="col">Cid Report Amount</th>
                                    <th scope="col" id="cid_report_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>

                                @endif
                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>

                            @elseif($ab->get_fees_lebel->option_label=="RTA Card Print")

                                @if(!empty($ab->amount))
                                    <?php  $optio_rta_card_print = "1";  ?>
                                <tr class=" div_card_print row_amount_cls">
                                    <th scope="col">RTA Card Print Amount</th>
                                    <th scope="col" id="card_print_amount" class="amounts_all">{{ isset($ab->amount) ? $ab->amount : '0'   }}</th>
                                </tr>
                                @endif
                                <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                            @endif

                        @endforeach

                        @if($optio_evisa=="0")
                        <tr class=" inside_status_evisa_print_div row_amount_cls hide_cls_six">
                            <th scope="col">E-visa Print Amount</th>
                            <th scope="col" id="evisa_print_amount" class="amounts_all"></th>
                        </tr>
                         @endif

                        @if($optio_medical=="0")
                            <tr class=" div_medical_process row_amount_cls hide_cls_six">
                                <th scope="col">Medical Process Amount</th>
                                <th scope="col" id="medical_process_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_emirate_id=="0")
                            <tr class=" div_emirates_id row_amount_cls hide_cls_six">
                                <th scope="col">Emirates Id Amount</th>
                                <th scope="col" id="emirate_id_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_visa_pasting=="0")
                            <tr class=" div_visa_pasting_amount row_amount_cls hide_cls_six">
                                <th scope="col">Visa Pasting Amount</th>
                                <th scope="col" id="visa_pasting_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_case_fine=="0")
                            <tr class=" div_case_fine row_amount_cls hide_cls_six">
                                <th scope="col">In case Fine Amount</th>
                                <th scope="col" id="case_fine_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_english_test=="0")
                            <tr class=" div_englist_test row_amount_cls hide_cls_six">
                                <th scope="col">English Language Test Amount</th>
                                <th scope="col" id="english_test_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_rta_permit_training=="0")
                            <tr class=" div_rta_permit_training row_amount_cls hide_cls_six">
                                <th scope="col">RTA Permit Training Amount</th>
                                <th scope="col" id="rta_permit_training_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_rta_medical=="0")
                            <tr class=" div_rta_medical row_amount_cls hide_cls_six">
                                <th scope="col">RTA Medical Amount</th>
                                <th scope="col" id="rta_medical_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_cid_report=="0")
                            <tr class=" div_cid_report row_amount_cls hide_cls_six">
                                <th scope="col">Cid Report Amount</th>
                                <th scope="col" id="cid_report_amount" class="amounts_all"></th>
                            </tr>
                        @endif

                        @if($optio_rta_card_print=="0")
                            <tr class=" div_card_print row_amount_cls hide_cls_six">
                                <th scope="col">RTA Card Print Amount</th>
                                <th scope="col" id="card_print_amount" class="amounts_all"></th>
                            </tr>
                        @endif




                        @if($agreement->driving_licence=="1")
                            @if(!empty($driving_license_amount))
                                <tr class=" driving_license_amount_div row_amount_cls">
                                    <th scope="col">Driving License Amount</th>
                                    <th scope="col" id="driving_license_amount" class="amounts_all">{{ isset($driving_license_amount->amount) ? $driving_license_amount->amount : '0'   }}</th>
                                    <?php  $g_total +=  isset($driving_license_amount->amount) ? $driving_license_amount->amount : '0' ?>
                                </tr>
                            @else
                                <tr class=" driving_license_amount_div row_amount_cls hide_cls_six">
                                    <th scope="col">Driving License Amount</th>
                                    <th scope="col" id="driving_license_amount" class="amounts_all"></th>
                                    <?php  $g_total +=  isset($driving_license_amount->amount) ? $driving_license_amount->amount : '0' ?>
                                </tr>

                            @endif
                        @endif

                        @if($agreement->driving_licence=="1")

                            @if(!empty($driving_license_amount->admin_amount))
                                <tr class="hide_cls_six admin_driving_license_amount_div row_amount_cls">
                                    <th scope="col">Admin Driving License Amount</th>
                                    <th scope="col" id="admin_driving_license_amount" class="amounts_all">{{ isset($driving_license_amount->admin_amount) ? $driving_license_amount->admin_amount : '0'   }}</th>
                                </tr>
                                <?php  $g_total +=  isset($driving_license_amount->admin_amount) ? $driving_license_amount->admin_amount : '0' ?>
                            @else
                                <tr class="hide_cls_six admin_driving_license_amount_div row_amount_cls hide_cls_six">
                                    <th scope="col">Admin Driving License Amount</th>
                                    <th scope="col" id="admin_driving_license_amount" class="amounts_all"></th>
                                </tr>
                                <?php  $g_total +=  isset($driving_license_amount->admin_amount) ? $driving_license_amount->admin_amount : '0' ?>

                            @endif
                        @endif

                        @if($agreement->admin_fee_id!="0")

                            @if(!empty($agreement->admin_fee_id))
                            <tr class=" div_admin_amount row_amount_cls">
                                <th scope="col">Admin Amount</th>
                                <th scope="col" id="admin_amount" class="amounts_all">{{ isset($agreement->admin_fee_id) ? $agreement->admin_fee_id : 'N/A'   }}</th>
                            </tr>
                            <?php  $g_total +=  isset($agreement->admin_fee_id) ? $agreement->admin_fee_id : '0' ?>
                            @else

                                <tr class=" div_admin_amount row_amount_cls hide_cls_six">
                                    <th scope="col">Admin Amount</th>
                                    <th scope="col" id="admin_amount" class="amounts_all"></th>
                                </tr>

                            @endif

                        @endif


                    @endif



{{--                    <tr class="hide_cls_six div_status_change row_amount_cls">--}}
{{--                        <th scope="col">Status Change Amount</th>--}}
{{--                        <th scope="col" id="status_change_amount" class="amounts_all"></th>--}}
{{--                    </tr>--}}





                    <tr class=" tota_amount_row ">
                        <th scope="col">Total Amount</th>
                        <th scope="col"  class="total_amount">{{ $g_total }}</th>
                    </tr>

                    <tr class="hide_cls_six tota_amount_row_ab ">
                        <th scope="col">Total Amount Second</th>
                        <th scope="col"  class="total_amount_ab">{{ $g_total }}</th>
                    </tr>


                    </thead>

                </table>

                <div class="row">
                    <?php $discount_amount = 0; ?>
                    @if(!empty($agreement->discount_details))
                        <?php
                        $array_json = json_decode($agreement->discount_details,true);

                       $t_count_d = count((array)$array_json['name']);
                        $count = 0;
                        foreach( (array) $array_json['name'] as $values){ ?>

                            <div class="col-md-5">
                                <label for="visit_entry_date" style="margin-bottom: 0px;">Discount Name</label>
                                <select name="discount_name[]" class="form-control" >
                                    <option value="" selected disabled >please select option</option>
                                    @foreach($discount_names as $names)
                                        <option value="{{ $names->names }}" {{ ($names->names==$array_json['name'][$count]) ? 'selected'  : '' }} >{{ $names->names }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label for="visit_entry_date" style="margin-bottom: 0px;">Discount Amount</label>
                                @if($count > 0)
                                    <input type="number" name="discount_amount[]"  value="{{ $array_json['amount'][$count] }}"  class="form-control discount_amount_cls " >
                                 @else
                                <input type="number" name="discount_amount[]" id="discount_offer" value="{{ $array_json['amount'][$count] }}"  class="form-control " >
                               @endif
                            </div>


                        <?php $discount_amount += $array_json['amount'][$count]; ?>
                        <?php
                        $count = $count+1;
                        }
                        ?>
                            @if($count==$t_count_d)
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-icon m-1 " id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                            </div>
                            @else
                                <div class="col-md-2">
                                </div>
                           @endif
                    @else


                            <div class="col-md-5">
                                <label for="visit_entry_date" style="margin-bottom: 0px;">Discount Name</label>
                                <select name="discount_name[]" class="form-control" >
                                    <option value="" selected disabled >please select option</option>
                                    @foreach($discount_names as $names)
                                        <option value="{{ $names->names }}"  >{{ $names->names }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label for="visit_entry_date" style="margin-bottom: 0px;">Discount Amount</label>
                                    <input type="number" name="discount_amount[]"  value=""  class="form-control discount_amount_cls " >
                            </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-icon m-1 " id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                </div>


                    @endif


                </div>

                <div class="row append_discount_row">

                </div>

                <div class="row">
                    <div class="col-md-5 ">
                        <label for="visit_entry_date" style="margin-bottom: 0px;">Advance Amount</label>
                        <input type="number" name="advance_amount" value="{{ isset($agreement->advance_amount) ? $agreement->advance_amount  : '' }}" id="advance_amount"  class="form-control " >
                    </div>
                </div>

                <div class="row" sytle="margin-top:5px;">
                    <div class="col-md-12 form-control-rounded">
                        <label for="visit_entry_date" style="margin-bottom: 0px;">Remark</label>
                        <textarea class="form-control" name="remark" ></textarea>
                    </div>
                </div>

                @if(!empty($ar_balance))
                <div class="row" style="margin-top:5px;" id="get_arr_balance_div" >
                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Agreed Amount</label>
                        <input type="text" readonly name="ar_agreed_amount" id="ar_agreed_amount" value="{{ $ar_balance['agreed_amount'] }}"  class="form-control" >
                    </div>
                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Cash Received</label>
                        <input type="text" readonly name="ar_cash_received_amount" id="ar_cash_received_amount"  value="{{ $ar_balance['cash_received'] }}"  class="form-control" >
                    </div>
                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Discount</label>
                        <input type="text" readonly name="ar_discount_amount" id="ar_discount_amount" value="{{ $ar_balance['discount'] }}"   class="form-control" >
                    </div>

                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Total Deduction</label>
                        <input type="text" readonly name="ar_deduction_amount" id="ar_deduction_amount" value="{{ $ar_balance['deduction'] }}"  class="form-control" >
                    </div>

                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Total Addition</label>
                        <input type="text" readonly name="ar_addition_amount" id="ar_addition_amount" value="{{ $ar_balance['total_addition'] }}"  class="form-control" >
                    </div>

                    <div class="col-md-4 form-control-rounded">
                        <label for="visit_entry_date" class="ar_fields_formate_cls" style="margin-bottom: 0px;">Current Balance</label>
                        <input type="text" readonly name="ar_balance_amount" id="ar_balance_amount"   value="{{ $ar_balance['balance'] }}" class="form-control" >
                    </div>
                </div>
                @endif





                <div class="row current_status_append_div">
                </div>

                <div class="row apend_div_driving_license_file">
                </div>

                <div class="row div_medical_process_file" ></div>
                <div class="row div_emirates_id_file"></div>

                <div class="row div_status_change_file"></div>

                <div class="row div_case_fine_file"></div>
                <div class="row div_rta_permit_file"></div>

                <div class="row amount_step_section">
                    <div class="col-md-12">
                        <label for="visa_requirement">Remain Agreement Amount</label>
                        <input type="text" class="form-control" readonly style="background-color: #80808045"  id="g_total_amount"  name="g_total_amount" value="">
                    </div>

                    <div class="col-md-12" style="margin-top: 5px; margin-bottom: 5px;">
                        <label for="adjustment_amount" style="margin-bottom: 0px;">Adjustment Amount</label>
                        <input type="text" class="form-control" id="adjustment_amount"  name="adjustment_amount" value="{{ isset($agreement->adjustment_amount) ? $agreement->adjustment_amount : ''  }}">
                    </div>

                    <div class="col-md-6 form-group "  >
                        <label for="visa_requirement">Select step Amount </label>
                        <select disabled selected required class="form-control form-control-rounded ">
                            <option value=""  >Payroll Deduct</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group "  >
                        <label for="visa_requirement">Amount</label>
                        <input type="number" name="payroll_deduct" id="payroll_deduct" value="{{ ($agreement->payroll_deduct!="0") ? $agreement->payroll_deduct : ''  }}" class="form-control step_amount_cls">
                    </div>

                    @if(count($agreement->step_amounts)>0)
                        <?php  $step_amount_t = count($agreement->step_amounts);
                         $t_count = 0;
                        ?>
                        @foreach($agreement->step_amounts as $ab)
                            <div class="col-md-6 form-group "  >
                                <label for="visa_requirement">Select step Amount </label>
                                <select name="select_amount_step[]" id="select_amount_step"  required class="form-control form-control-rounded select_amount_step_cls">
                                    <option value=""  >Select option</option>
                                    @foreach($master_steps as $steps)
                                        <option value="{{ $steps->id }}"  {{ ($ab->step_name==$steps->step_name) ? 'selected' : '' }}  >{{ $steps->step_name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <?php $t_count = $t_count+1; ?>

                            <div class="col-md-6 form-group "  >
                                <label for="visa_requirement">Amount</label>
                                <input type="number" name="step_amount[]" value="{{ $ab->amount }}" required class="form-control step_amount_cls">
                                @if($step_amount_t==$t_count)
                                <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                    <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                  @endif
                            </div>

                        @endforeach
                    @else

                        <div class="col-md-6 form-group "  >
                            <label for="visa_requirement">Select step Amount </label>
                            <select name="select_amount_step[]" id="select_amount_step"  required class="form-control form-control-rounded select_amount_step_cls">
                                <option value=""  >Select option</option>
                                @foreach($master_steps as $steps)
                                    <option value="{{ $steps->id }}"    >{{ $steps->step_name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6 form-group "  >
                            <label for="visa_requirement">Amount</label>
                            <input type="number" name="step_amount[]" value="" required class="form-control step_amount_cls">

                            <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                             <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                        </div>
                    @endif
                </div>

                <div class="row amount_step_row_cls"></div>



            </div>

        </div>
        {{--      col 4 ender here--}}


        <button class="btn btn-primary pull-right" type="submit">Save</button>
    </form>




    </div>

    </div>
    </div>
    </div>
    </div>
    </div>









@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        tail.DateTime("#visit_entry_date",{
            dateFormat: "dd-mm-YYYY",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#visit_exit_date",{
                dateStart: $('#visit_entry_date').val(),
                dateFormat: "dd-mm-YYYY",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#transer_exit_date",{
            dateFormat: "dd-mm-YYYY",
            timeFormat: false,

        });

        tail.DateTime("#expected_date",{
            dateFormat: "dd-mm-YYYY",
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


            $('#rider_name').select2({
                placeholder: 'Select an option'
            });

            $('#working_visa').select2({
                placeholder: 'Select an option'
            });

            $('#visa_applying').select2({
                placeholder: 'Select an option'
            });

            $('#working_designation').select2({
                placeholder: 'Select an option'
            });

            $('#visa_designation').select2({
                placeholder: 'Select an option'
            });

            $('#medical_company').select2({
                placeholder: 'Select an option'
            });

            $('.select_amount_step_cls').select2({
                placeholder: 'Select an option'
            });

            $('#visa_job_request').select2({
                placeholder: 'Select an option'
            });

            $('#current_status').select2({
                placeholder: 'Select an option'
            });


            $(".select2-container").css('width','100%');


            $("#passport_number").change(function () {
                $("#unique_div").css('display','block');


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_unique_passport') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {

                        var ab_response = response.split("$");

                        $("#unique_id").html(ab_response[0]);
                        $("#given_name").html(ab_response[1])
                        $("#passport_pic").attr('src',ab_response[2]);
                        $("#country_code").html(ab_response[3]);
                        $("#phone_number").html(ab_response[4])
                        $("#date_expiry").html(ab_response[5]);

                    }
                });

                $.ajax({
                    url: "{{ route('ajax_get_driving_license') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {
                        var ab = $.parseJSON(response);
                        console.log(ab);
                        if(ab !== null){

                            $(".driving_license_detail").show();
                            $("#license_number_html").html(ab['license_number']);
                            $("#issue_data_html").html(ab['issue_date']);
                            $("#expire_data_html").html(ab['expire_date']);
                            $("#traffic_code_html").html(ab['traffic_code']);
                            $("#place_issue_html").html(ab['place_issue']);

                            if(ab['license_type']=="2"){
                                $("#car_type_row").show();
                                $("#license_type_html").html("Car");
                                if(ab['car_type']=="1"){
                                    $("#car_type_html").html("Automatic Car");
                                }else{
                                    $("#car_type_html").html("Manual Car");
                                }

                            }else{
                                $("#license_type_html").html("Bike");
                                $("#car_type_row").hide();
                            }
                            $("#remian_days_html").html(ab['remain_days']);




                            $("#already_have_label").show();
                            $("#not_required_license_label").hide();
                            $("#both_label").hide();
                            $("#already_have").prop('checked',true);
                            $(".license_type_div").show();
                            $('#license_want_yes').hide();
                            if(ab['license_type']=="2"){
                                $("#bike_label").hide();

                                $("#car").prop('checked',true);
                                // $("#car").show();

                                $(".car_type_div").show();

                                $("#car_label").show();
                                if(ab['car_type']=="1"){
                                    $("#automatic_car").prop('checked',true);
                                    $("#manual_car_label").hide();
                                    $("#automatic_car_label").show();
                                }else{
                                    $("#manual_car").prop('checked',true);
                                    $("#manual_car_label").show();
                                    $("#automatic_car_label").hide();
                                }

                            }else{
                                $("#bike").prop('checked',true);
                                $("#bike_label").show();
                                $("#car_label").hide();
                                $(".car_type_div").hide();
                            }


                        }else{

                            $("#not_required_license_label").show();
                            $("#already_have_label").hide();
                            $("#automatic_car").prop('checked',false);
                            $("#bike_label").hide();
                            $(".license_type_div").hide();
                            $("#manual_car").prop('checked',false);
                            $("#bike").prop('checked',false);
                            $("#car").prop('checked',false);
                            $("#already_have").prop('checked',false);
                            $(".car_type_div").hide();
                            $('#license_want_yes').show();

                            $("#automatic_car_label").show();
                            $("#manual_car_label").show();

                            $("#car_label").show();
                            $("#bike_label").show();

                            $(".driving_license_detail").hide();

                        }



                    }
                });

            });

            $("#ref_type").change(function(){

                var s_value = $(this).val();

                $(".select2-container").css('width','100%');

                if(s_value=="1"){
                    // $("#own_company_div").css('display','block');
                    $("#own_company_div").css('display','block');
                    $("#outside_div").css('display','none');

                }else if(s_value=="2"){

                    $("#own_company_div").css('display','none');
                    $("#outside_div").css('display','flex');

                }else{

                    $("#own_company_div").css('display','none');
                    $("#outside_div").css('display','none');

                }

            });

            var count_row = 1;

            $("#add_row").click(function(){

                var html_apend = ' <div class="col-md-2 form-group mb-3 rowd-'+count_row+' "   >\n' +
                    '                                <label for="refernce">Reference Name</label>\n' +
                    '                                <input class="form-control" name="reference_name[]" type="text" placeholder="Enter Refernce Name" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-2 form-group mb-3 rowd-'+count_row+'"   >\n' +
                    '                                <label for="contact_nubmer">Contact number</label>\n' +
                    '                                <input class="form-control" name="contact_nubmer[]" type="text" placeholder="Enter Contact number" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-2 form-group mb-3 rowd-'+count_row+'"   >\n' +
                    '                                <label for="contact_nubmer">whats App number</label>\n' +
                    '                                <input class="form-control" name="whatsppnumber[]" type="text" placeholder="Enter whats app number" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-2 form-group mb-3 rowd-'+count_row+' "   >\n' +
                    '                                <label for="contact_nubmer">Social media FB</label>\n' +
                    '                                <input class="form-control" name="socialmedia[]" type="text" placeholder="Enter social media Link" />\n' +

                    '                            </div>  \n' +
                    '<div class="col-md-2 form-group mb-3 rowd-'+count_row+' "   >\n' +
                    '                                <label for="wokring_place">Working Place</label>\n' +
                    '                                <input class="form-control" name="wokring_place[]" type="text" placeholder="Enter Working Place" />\n' +
                    '\n' +
                    '                            </div>'+
                    '<div class="col-md-2 form-group mb-3  rowd-'+count_row+' "   >\n' +
                    '<label style="visibility: hidden;" for="wokring_place">Working Place</label>'+
                    '                                <button class="btn btn-danger  pull-right text-right delete_btn add_btn rowd-'+count_row+' " id="'+count_row+'" type="button" ><span class="ul-btn__icon"><i class="i-Remove"></i></span></button>\n' +
                    '\n' +
                    '                            </div>';

                $("#outside_div").append(html_apend);

                count_row = parseInt(count_row)+1;

            });



            $('#outside_div').on('click', '.delete_btn', function() {
                var ids = $(this).attr('id')

                $(".rowd-"+ids).remove();

            });

        });



        // employee type change start
        $("#employee_type").change(function(){

            $('#current_status').children().remove();

            $('#working_visa').val(null).trigger('change');
            $('#visa_applying').val(null).trigger('change');
            $('#working_designation').val(null).trigger('change');
            $('#visa_designation').val(null).trigger('change');
            $('#visa_job_request').val(null).trigger('change');



            $(".visa_requirement_div").hide();

            $(".current-status_div").show();
            $(".driving_license_div").show();
            var ids = $(this).val();

            if(ids=="1" ){




                $(".visa_applying_div").hide();
                $("#visa_applying").prop('required',false);
            }else if(ids=="3"){

                $(".visa_applying_div").show();
                $("#visa_applying").prop('required',true);

                console.log("we are in part time");

            }else{
                $(".visa_applying_div").show();
                $("#visa_applying").prop('required',true);
            }

            if(ids=="2"){
                $("#medical_company_option").prop('selected',true);
                $(".medcial_category_div").show();
                $(".only_full_time_employee").css('display','flex');

            }else{
                $(".only_full_time_employee").hide();
            }


            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_employee_type') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    var options = "";
                    var  contact_html = "";
                    if(len > 0){
                        options  += '<option value="" selected disabled >please Select an option</option>';
                        for(var i=0; i<len; i++){
                            var id_t =  response['data'][i].id;
                            var name=  response['data'][i].name;
                            options  += '<option value="'+id_t+'" >'+name+'</option>';
                        }
                        $('#current_status').append(options);
                    }


                }
            });


        });

        //emplpyee type change end



        //current status things started
        $("#current_status").change(function(){

            var val_s = $(this).find('option:selected').text();
            $(".file_current_status_appended").remove();

            $('#working_visa').val(null).trigger('change');
            $('#visa_applying').val(null).trigger('change');
            $('#working_designation').val(null).trigger('change');
            $('#visa_designation').val(null).trigger('change');
            $('#visa_job_request').val(null).trigger('change');


            $(".visa_requirement_div").show();
            if(val_s=="Transfer to transfer"){
                $(".transfer_exit").show();
                $(".transfer_visit").hide();
                $(".expected_date").hide();
                $("#visit_entry_date").val("");
                $("#visit_exit_date").val("");
                $("#transer_exit_date").prop('required',true);

                // $("input[type='radio'][name='evisa_print']").val("1").trigger('change');

                $("#inside_evisa_print").attr('checked', true).trigger('click');

                $(".inside_visa_type_row").show();

                $(".radio_inside_evisa_print").show();
                $(".radio_outside_evisa_print").hide();

            }else if(val_s=="Free Zone/Local Visa"){

                $(".transfer_exit").show();
                $(".transfer_visit").hide();
                $(".expected_date").hide();
                $("#visit_entry_date").val("");
                $("#visit_exit_date").val("");
                $("#transer_exit_date").prop('required',true);

            }else if(val_s=="Visit"){
                $(".transfer_exit").hide();
                $(".expected_date").hide();
                $(".transfer_visit").show();
                $("#transer_exit_date").val("");
                $("#visit_entry_date").prop('required',true);
                $("#visit_exit_date").prop('required',true);

                $(".inside_visa_type_row").show();
                $("#inside_evisa_print").attr('checked', true).trigger('click');

                $(".radio_inside_evisa_print").show();
                $(".radio_outside_evisa_print").hide();

            }else if(val_s=="Normal Standard Visa"){

                $(".inside_visa_type_row").hide();
                $("#inside_evisa_outside").attr('checked', true).trigger('click');

                $(".radio_inside_evisa_print").hide();
                $(".radio_outside_evisa_print").show();


            }else if(val_s=="Waiting for old sponsor cancellation"){
                $(".expected_date").show();
                $(".transfer_exit").hide();
                $(".transfer_visit").hide();

            }else{
                $(".expected_date").hide();
                $(".transfer_exit").hide();
                $(".transfer_visit").hide();

                $("#visit_entry_date").prop('required',false);
                $("#visit_exit_date").prop('required',false);
                $("#transer_exit_date").prop('required',false);

                $(".inside_visa_type_row").show();
                $("#inside_evisa_print").attr('checked', true).trigger('click');

                $(".radio_inside_evisa_print").show();
                $(".radio_outside_evisa_print").show();

            }

            var select_id = $(this).val();

        });

        $("#discount_offer").keyup(function () {
            var entered_val = $(this).val();

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });



            if(entered_val!=="") {
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{
                var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

            console.log(entered_val);
        });
        $("#discount_offer").keydown(function () {

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });

            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{
                var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }
        });

        $("#discount_offer").change(function () {

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });




            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

        });


        //advance text field start here


        //class change function discount_amount_cls class

        $(document).on('change','.discount_amount_cls',function(){

                var advance_amount = $("#advance_amount").val();
                if(advance_amount !== ""){
                    advance_amount =  $("#advance_amount").val();
                }else{
                    advance_amount = 0;
                }

                var discount_offer = $("#discount_offer").val();

            if(discount_offer !== ""){
                discount_offer =  $("#discount_offer").val();
            }else{
                discount_offer = 0;
            }

            if(discount_offer == undefined){
                discount_offer = 0;
            }


                var disocunt_sum = 0;
                $(".discount_amount_cls").each(function(){
                    disocunt_sum += +$(this).val();
                });




            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });


                var entered_val = $(this).val();
                if(entered_val!==""){
                    var now_sum = parseFloat(get_total_amount())-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount)-parseFloat(discount_offer);

                    now_sum = now_sum.toFixed(2);

                    // $(".total_amount").html(now_sum);
                    $("#g_total_amount").val(now_sum);
                }else{

                    var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(discount_offer);
                    now_sum = now_sum.toFixed(2);

                    // $(".total_amount").html(now_sum);
                    $("#g_total_amount").val(now_sum);
                }

                // alert(jQuery(this).val());
            });


        $(document).on('keyup','.discount_amount_cls',function(){

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var discount_offer = $("#discount_offer").val();

            if(discount_offer !== ""){
                discount_offer =  $("#discount_offer").val();
            }else{
                discount_offer = 0;
            }

            if(discount_offer == undefined){
                discount_offer = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });


            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount)-parseFloat(discount_offer);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(discount_offer);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

            // alert(jQuery(this).val());
        });

        $(document).on('keydown','.discount_amount_cls',function(){

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var discount_offer = $("#discount_offer").val();



            if(discount_offer !== ""){
                discount_offer =  $("#discount_offer").val();
            }else{
                discount_offer = 0;
            }

            if(discount_offer == undefined){
                discount_offer = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });


            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount)-parseFloat(discount_offer);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(advance_amount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(discount_offer);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

            // alert(jQuery(this).val());
        });

        //class change end amount



        //advance text field end

        $("#advance_amount").keyup(function () {

            var entered_val = $(this).val();
            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }



            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });

            var payroll = $("#payroll_deduct").val();
            if(payroll!==""){
                payroll =  $("#payroll_deduct").val();
            }else{
                payroll = 0;
            }

            payroll = 0;




            if(entered_val!=="") {
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{
                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

            console.log(entered_val);
        });
        $("#advance_amount").keydown(function () {

            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }

            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });


            var payroll = $("#payroll_deduct").val();
            if(payroll!==""){
                payroll =  $("#payroll_deduct").val();
            }else{
                payroll = 0;
            }
            payroll = 0;

            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);

            }
        });

        $("#advance_amount").change(function () {

            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });


            var payroll = $("#payroll_deduct").val();
            if(payroll!==""){
                payroll =  $("#payroll_deduct").val();
            }else{
                payroll = 0;
            }
            payroll = 0;

            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(sum_step_amount)-parseFloat(payroll);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

        });

        //advance end here

        //adjustment amount start

        $("#adjustment_amount").keyup(function () {

            var entered_val = $(this).val();
            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }

            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var advance_amount = $("#advance_amount").val();

            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }



            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });







            if(entered_val!=="") {
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);
                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{
                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

            console.log(entered_val);
        });
        $("#adjustment_amount").keydown(function () {

            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }

            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var advance_amount = $("#advance_amount").val();

            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });





            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);

            }
        });

        $("#adjustment_amount").change(function () {

            var discount = $("#discount_offer").val();
            if(discount !== ""){
                discount =  $("#discount_offer").val();
            }else{
                discount = 0;
            }

            if(discount == undefined){
                discount = 0;
            }


            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                disocunt_sum += +$(this).val();
            });

            var advance_amount = $("#advance_amount").val();

            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var sum_step_amount = 0;
            $(".step_amount_cls").each(function(){
                sum_step_amount += +$(this).val();
            });




            var entered_val = $(this).val();
            if(entered_val!==""){
                var now_sum = parseFloat(get_total_amount())-parseFloat(entered_val)-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);

                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }else{

                var now_sum = parseFloat(get_total_amount())-parseFloat(discount)-parseFloat(disocunt_sum)-parseFloat(advance_amount)-parseFloat(sum_step_amount);

                now_sum = now_sum.toFixed(2);


                // $(".total_amount").html(now_sum);
                $("#g_total_amount").val(now_sum);
            }

        });

        //adjustment end here



        //display total code start


        function get_total_amount(){


            var driving_license_amount = $("#driving_license_amount").html();
            var evisa_print_amount = $("#evisa_print_amount").html();
            var medical_process_amount = $("#medical_process_amount").html();
            var emirate_id_amount = $("#emirate_id_amount").html();
            var visa_pasting_amount = $("#visa_pasting_amount").html();
            var case_fine_amount = $("#case_fine_amount").html();
            var english_test_amount = $("#english_test_amount").html();
            var rta_permit_training_amount = $("#rta_permit_training_amount").html();
            var e_test_amount = $("#e_test_amount").html();
            var rta_medical_amount = $("#rta_medical_amount").html();
            var cid_report_amount = $("#cid_report_amount").html();
            var card_print_amount = $("#card_print_amount").html();
            var admin_amount = $("#admin_amount").html();
            var admin_license_amount = $("#admin_driving_license_amount").html();




            var g_total = "";

            if(driving_license_amount!=="" && $("#driving_license_amount") && $("#driving_license_amount").length){
                driving_license_amount =  $("#driving_license_amount").html()

            }else{

                driving_license_amount = 0;
            }



            if(evisa_print_amount!=="" && $("#evisa_print_amount") && $("#evisa_print_amount").length){
                evisa_print_amount =  $("#evisa_print_amount").html()
            }else{
                evisa_print_amount = 0;
            }
            if(medical_process_amount!=="" && $("#medical_process_amount") && $("#medical_process_amount").length){
                medical_process_amount =  $("#medical_process_amount").html();
            }else{
                medical_process_amount = 0;
            }

            if(emirate_id_amount!=="" && $("#emirate_id_amount") && $("#emirate_id_amount").length){
                emirate_id_amount = $("#emirate_id_amount").html();
            }else{
                emirate_id_amount = 0;
            }

            if(visa_pasting_amount!=="" && $("#visa_pasting_amount") && $("#visa_pasting_amount").length){
                visa_pasting_amount = $("#visa_pasting_amount").html();
            }else{
                visa_pasting_amount = 0;
            }

            if(case_fine_amount!=="" && $("#case_fine_amount") && $("#case_fine_amount").length){
                case_fine_amount = $("#case_fine_amount").html();
            }else{
                case_fine_amount = 0;
            }

            if(english_test_amount!=="" && $("#english_test_amount") && $("#english_test_amount").length){
                english_test_amount = $("#english_test_amount").html();
            }else{
                english_test_amount = 0;
            }

            if(rta_permit_training_amount!=="" && $("#rta_permit_training_amount") && $("#rta_permit_training_amount").length){
                rta_permit_training_amount = $("#rta_permit_training_amount").html();
            }else{
                rta_permit_training_amount = 0;
            }

            if(e_test_amount!=="" && $("#e_test_amount") && $("#e_test_amount").length){
                e_test_amount = $("#e_test_amount").html();
            }else{
                e_test_amount = 0;
            }

            if(rta_medical_amount!=="" && $("#rta_medical_amount") && $("#rta_medical_amount").length){
                rta_medical_amount = $("#rta_medical_amount").html();
            }else{
                rta_medical_amount = 0;
            }

            if(cid_report_amount!=="" && $("#cid_report_amount") && $("#cid_report_amount").length ){
                cid_report_amount = $("#cid_report_amount").html();
            }else{
                cid_report_amount = 0;
            }

            if(card_print_amount!==""  && $("#card_print_amount") && $("#card_print_amount").length){
                card_print_amount = $("#card_print_amount").html();
            }else{
                card_print_amount = 0;
            }



            var labour_fees_amount = $("#labour_fees_total").val();

            if(labour_fees_amount!==""  && $("#labour_fees_total") && $("#labour_fees_total").length){
                labour_fees_amount = $("#labour_fees_total").val();
            }else{
                labour_fees_amount = 0;
            }

            var admin_amount = $("#admin_amount").html();

            if(admin_amount!=="" && $("#admin_amount") && $("#admin_amount").length){
                admin_amount = $("#admin_amount").html();
            }else{
                admin_amount = 0;
            }


            var admin_license_amount = $("#admin_driving_license_amount").html();

            if(admin_license_amount!=="" && $("#admin_driving_license_amount") && $("#admin_driving_license_amount").length){
                admin_license_amount = $("#admin_driving_license_amount").html();
            }else{
                admin_license_amount = 0;
            }

            // console.log("Labour Fees Amount"+labour_fees_amount);
            console.log("driving_license_amount ="+driving_license_amount+"<br>");
            console.log("evisa_print_amount ="+evisa_print_amount+"<br>");
            console.log("medical_process_amount ="+medical_process_amount+"<br>");
            console.log("emirate_id_amount ="+emirate_id_amount+"<br>");
            console.log("medical_process_amount ="+medical_process_amount+"<br>");
            console.log("visa_pasting_amount ="+visa_pasting_amount+"<br>");
            console.log("case_fine_amount ="+case_fine_amount+"<br>");
            console.log("english_test_amount ="+english_test_amount+"<br>");
            console.log("rta_permit_training_amount ="+rta_permit_training_amount+"<br>");
            console.log("e_test_amount ="+e_test_amount+"<br>");
            console.log("rta_medical_amount ="+rta_medical_amount+"<br>");
            console.log("cid_report_amount ="+cid_report_amount+"<br>");
            console.log("card_print_amount ="+card_print_amount+"<br>");
            console.log("labour_fees_amount ="+labour_fees_amount+"<br>");
            console.log("admin_amount ="+admin_amount+"<br>");
            console.log("admin_license_amount ="+admin_license_amount+"<br>");

            g_total = parseFloat(driving_license_amount)+parseFloat(evisa_print_amount)+parseFloat(medical_process_amount)+parseFloat(emirate_id_amount)+parseFloat(visa_pasting_amount)+parseFloat(case_fine_amount)+parseFloat(english_test_amount)+parseFloat(rta_permit_training_amount)+parseFloat(e_test_amount)+parseFloat(rta_medical_amount)+parseFloat(cid_report_amount)+parseFloat(card_print_amount)+parseFloat(labour_fees_amount)+parseFloat(admin_amount)+parseFloat(admin_license_amount);
            console.log("grand Total ab="+g_total);
            return  g_total.toFixed(2);
        }

        // display total code end



        function render_driver_license_child(dynamic, ids){

            var html_render = '<div class="col-md-6 append_html rener_driver_licne-'+ids+' "  id="'+ids+'" style=""><div class="card-body"><div class="card-title">&nbsp;</div>'+dynamic+'</div></div>';

            return html_render;

        }

        function render_medical_child(options,ids){

            var  html = '<div class="col-md-6 form-group mb-3 medial_render_div  div_medical-'+ids+'"  id="'+ids+'"  ><label for="medical_company">Select option</label><select  name="medical_company"  class="form-control form-control-rounded medical_type_cls"><option value=""  >select option</option>'+options+'</select></div>';

            return html;

        }


        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
        //-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();


        });
    </script>


    {{--    document render functions--}}
    <script>
        function render_current_status_files(name,requird,primary_id){
            var html = '<div class="col-md-6 file_current_status_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+requird+' ></div>'

            return html;
        }

        function render_driving_license_files(name,requird,primary_id){
            var html = '<div class="col-md-6 file_driving_license_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+requird+' ></div>'

            return html;
        }

        function render_doument_process_files(name,required,primary_id){
            var html = '<div class="col-md-6 file_document_process_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+required+' ></div>'

            return html;
        }

        function render_emirates_id_files(name,required,primary_id){
            var html = '<div class="col-md-6 file_emirates_id_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+required+' ></div>'

            return html;
        }

        function render_status_change_files(name,required,primary_id){
            var html = '<div class="col-md-6 file_status_change_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+required+' ></div>'

            return html;
        }

        function render_case_fine_files(name,required,primary_id){
            var html = '<div class="col-md-6 file_case_fine_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+required+' ></div>'

            return html;
        }

        function render_rta_permit_files(name,required,primary_id){
            var html = '<div class="col-md-6 file_rta_permit_appended "><label for="repair_category">'+name+'</label><input type="file" name="agreement_file-'+primary_id+'" class="form-control" '+required+' ></div>'

            return html;
        }

    </script>


    {{--    form step jquery append  will come here --}}

    <script>
        function append_form_amount_step(id){
            html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps)<option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>@endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls"><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
            return html;
        }
        var count_amount_step = 0;
        $(".add_step_form_btn").click(function(){

            count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;

            $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));

            $('#select_amount_step-'+count_amount_step).rules('add', {
                required: true
            });

            $('#select_amount_step-'+count_amount_step).select2({
                placeholder: 'Select an option'
            });

        });



        $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {

            var ids = $(this).attr('id');

            $("."+ids).remove();

        });



    </script>


    {{--    jquery validation work start--}}

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>

    <script>
        $(document).ready(function() {


            $('.amount_step_section').on('click', '.step_amount_cls', function() {
                $("#agreement_form").valid();
            });

            $('.amount_step_section').on('click', '.select_amount_step_cls', function() {
                $("#agreement_form").valid();
            });




            var i = 1;
            $.validator.addMethod("depositsSum", function (value, element, params) {
                var amnts = 0;
                $(params[0]).each(function () {
                    amnts += parseFloat($(this).val());
                });

                return this.optional(element) || amnts == parseFloat(value);
            }, jQuery.format("Individual Amount must add up to the total!"));


            $("form#agreement_form").validate({
                onkeyup: function(element) {
                    $(element).valid();
                },

                rules: {
                    g_total_amount: {
                        depositsSum: [".step_amount_cls"]
                    },

                    'step_amount[]':
                        {
                            required:true,
                        }

                },
                messages: {

                }
            });

            $('.step_amount_cls').each(function() {
                $(this).rules('add', {
                    required: true,
                    number: true,
                    messages: {
                        required:  "Please Enter Amount"
                    }
                });
            });

            $('.select_amount_step_cls').each(function() {
                $(this).rules('add', {
                    required: true,
                    messages: {
                        required:  "Please Select Step"
                    }
                });
            });



        });
    </script>

    {{--    jquery validation work end--}}

    {{--    after modification jquer start here--}}

    <script>
        $(".append_discount_row").on("change", ".discount_amount_cls", function() {
            var sum = 0;
            $(".discount_amount_cls").each(function(){
                sum += +$(this).val();
            });
            console.log("now i have some"+sum);

            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!=="0"){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });


        $(".append_discount_row").on("keyup", ".discount_amount_cls", function() {
            var sum = 0;
            $(".discount_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var first_discount = $("#discount_offer").val();
            var advance_amount = $("#advance_amount").val();

            if(first_discount!=="0"){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }


            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });

        $(".append_discount_row").on("keydown", ".discount_amount_cls", function() {
            var sum = 0;
            $(".discount_amount_cls").each(function(){
                sum += +$(this).val();
            });


            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!=="0"){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }


            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });
    </script>


    {{--    step amount Total calculation--}}
    <script>
        $(".amount_step_section").on("change", ".step_amount_cls", function() {
            var sum = 0;
            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }

            });

            console.log("now i have some"+sum);

            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!==""){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }
            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });


        $(".amount_step_section").on("keyup", ".step_amount_cls", function() {
            var sum = 0;

            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }
            });

            var first_discount = $("#discount_offer").val();
            var advance_amount = $("#advance_amount").val();

            if(first_discount!==""){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }


            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }

            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });

        $(".amount_step_section").on("keydown", ".step_amount_cls", function() {
            var sum = 0;
            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }
            });


            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!==""){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }

            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });
    </script>


    <script>
        $(".amount_step_row_cls").on("change", ".step_amount_cls", function() {
            var sum = 0;
            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }
            });

            console.log("now i have some"+sum);

            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!=="0"){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }


            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }



            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });


        $(".amount_step_row_cls").on("keyup", ".step_amount_cls", function() {
            var sum = 0;

            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }
            });

            var first_discount = $("#discount_offer").val();
            var advance_amount = $("#advance_amount").val();

            if(first_discount!==""){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }


            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }

            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }



            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });

        $(".amount_step_row_cls").on("keydown", ".step_amount_cls", function() {
            var sum = 0;
            $(".step_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var sum_discount = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!==""){
                    sum_discount += +$(this).val();
                }
            });


            var first_discount = $("#discount_offer").val();
            var  advance_amount = $("#advance_amount").val();

            if(first_discount!==""){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!==""){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }

            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount!==""){
                adjustment_amount = $("#adjustment_amount").val();
            }else{
                adjustment_amount = "0";
            }


            var gamer = parseFloat(get_total_amount())-parseFloat(sum_discount)-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount)-parseFloat(adjustment_amount);
            // $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);
            $(".total_amount").show();
        });
    </script>


    {{--    step amount Total calculation end--}}



    <script>
        $(".driving_license").change(function(){
            var selected_now = $(this).val();
            if(selected_now=="1"){
                $(".license_type_div").show();
                $("#bike_label").show();
                $("#car_label").show();
                $("#both_label").show();
                $("#bike").prop('checked',true);
            }else{
                $(".license_type_div").hide();
                $(".car_type_div").hide();
                $("input[type='radio'][name='license_type']").prop('checked',false);
                $("#bike_label").hide();
                $("#car_label").hide();
                $("#both_label").hide();

                $(".driving_license_amount_div").hide();
                $("#driving_license_amount").html("");
                $("#driving_license_amount_field").val("");
                $("#driving_license_amount_primary_id").val("");


            }



        });

        $(".licens_type").change(function(){

            var ids = $(this).val();

            if(ids=="2" || ids=="3"){
                $(".car_type_div").show();
            }else{
                $(".car_type_div").hide();
            }

        });



        $("input[type='radio'][name='car_type']").change(function() {

            var working_visa = $("#visa_applying option:selected").val();
            var car_type = $('input:radio[name="car_type"]:checked').val();
            var employee_id =  $("#employee_type option:selected").val();

            var selected_now = $('input:radio[name="license_type"]:checked').val();

            if(selected_now=="1"){
                option_label = "Bike";
            }else if(selected_now=="2"){
                option_label = "Car";
            }else if(selected_now=="3"){
                option_label = "Both";
            }else{
                option_label = "Null";
            }

        });

        $("input[type='radio'][name='evisa_print']").change(function(){
            var selected_v = $(this).val();
            if(selected_v=="1"){
                $(".inside_visa_type_row").show();

            }else{
                $(".inside_visa_type_row").hide();
            }

        });


        $("input[type='radio'][name='inside_visa_type']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();

            var option_label = "Inside E-visa Print";

            var child_now = $('input:radio[name="inside_visa_type"]:checked').val();

            var selected_v = $('input:radio[name="evisa_print"]:checked').val();

            if(selected_v=="2"){
                child_now = null;
            }





        });



        $("#medical_type").change(function(){
            var selected_v = $(this).val();
            if(selected_v=="2"){
                $(".medcial_category_div").show();
            }else{
                $(".medcial_category_div").hide();
            }
            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "Medical";
            var child_now =  $('#medical_category :selected').val();

            if(selected_v=="1"){
                child_now = null;
            }



        });

        $("#medical_category").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "Medical";
            var child_now =  $('#medical_category :selected').val();
            var selected_v = $("#medical_type option:selected").val();
            if(selected_v=="1"){
                child_now = null;
            }



        });


        $("input[type='radio'][name='emirates_id']").change(function(){
            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "Emirates Id";
            var child_now = null;
            var selected_v = $(this).val();



        });

        function run_company_emirates(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "Emirates Id";
            var child_now = null;
            var selected_v = "2";


            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_amounts_agreement') }}",
                method: 'POST',
                data: {option_value: selected_v,employee_id:employee_id, current_status:current_status, child_now:child_now, company_id:visa_applying, option_label:option_label , _token:token},
                success: function(response) {

                    var ab = response.split("-");

                    if(ab[0]!=="0"){
                        $(".div_emirates_id").show();
                        $("#emirate_id_amount").html(ab[0]);

                        $("#emirate_id_amount_field").val(ab[0]);
                        $("#emirate_id_amount_primary_id").val(ab[1]);

                    }else{
                        $(".div_emirates_id").css('display','none');

                        $("#emirate_id_amount_field").val("");
                        $("#emirate_id_amount_primary_id").val("");


                    }
                }
            });


        }


        $("input[type='radio'][name='visa_pasting']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "Visa Pasting";
            var child_now = null;
            var selected_v = $(this).val();


        });



        $("input[type='radio'][name='case_fine']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "In Case Fine";
            var child_now = null;
            var selected_v = $(this).val();


        });


        $("input[type='radio'][name='english_test']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "English Language Test";
            var child_now = null;
            var selected_v = $('input:radio[name="english_test"]:checked').val();


        });


        $("input[type='radio'][name='rta_permit_training']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "RTA Permit Training";
            var child_now = null;
            var selected_v = $('input:radio[name="rta_permit_training"]:checked').val();


        });


        $("input[type='radio'][name='e_test']").change(function(){

            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "E Test";
            var child_now = null;
            var selected_v = $('input:radio[name="e_test"]:checked').val();




        });



        $("input[type='radio'][name='rta_medical']").change(function(){
            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "RTA Medical";
            var child_now = null;
            var selected_v = $(this).val();

            console.log("we are here"+selected_v);


        });



        $("input[type='radio'][name='cid_report']").change(function(){
            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "CID Report";
            var child_now = null;
            var selected_v = $('input:radio[name="cid_report"]:checked').val();




        });


        $("input[type='radio'][name='rta_card_print']").change(function(){
            var visa_applying = $("#visa_applying option:selected").val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label = "RTA Card Print";
            var child_now = null;
            var selected_v = $('input:radio[name="rta_card_print"]:checked').val();




        });



        function add_limo_option(){
            if ($('#working_designation').find("option[value='1']").length) {
                $('#working_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default
                var newOption = new Option('Limo Driver', '1', true, true);
                // Append it to the select
                $('#working_designation').append(newOption).trigger('change');
            }
            $('#working_designation').val('1').trigger('change');
        }

        function add_dynamic_opton(id,text_ab){



            if ($('#visa_designation').find("option[value='"+id+"']").length) {
                // $('#visa_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default
                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#visa_designation').append(newOption);
            }
            $('#visa_designation').val(null).trigger('change');
        }

        $("#working_visa").change(function(){


            $("#visa_designation").empty();
            $('#working_designation').val(null).trigger('change');
            var select = $(this).val();
            var apply_chat = $("#visa_applying option:selected").val();

            var employee_type = $("#employee_type option:selected").val();

            if(apply_chat !== null && select !== null ){
                if(apply_chat=="3" && select=="3" && employee_type !=="3" ){
                    add_limo_option();

                    $("#medical_company_option").prop('selected',false);
                    $(".medcial_category_div").hide();
                    $(".only_hey_vip_divs").css('display','flex');
                    $("#own_of_emirates_id").prop('checked',true);
                    $("#company_of_emirates_id").prop('checked',false);

                }else{
                    $("#working_designation option[value='1']").remove();
                    $(".only_hey_vip_divs").hide();
                    $("#own_of_emirates_id").prop('checked',false);
                    $("#company_of_emirates_id").prop('checked',true);

                }
            }else{
                $(".only_hey_vip_divs").hide();
                $("#working_designation option[value='1']").remove();

                $("#own_of_emirates_id").prop('checked',true);
                $("#company_of_emirates_id").prop('checked',false);
            }
        });

        $("#visa_applying").change(function(){

            $("#visa_designation").empty();
            $('#working_designation').val(null).trigger('change');
            var select = $(this).val();
            var apply_chat = $("#working_visa option:selected").val();

            var employee_type = $("#employee_type option:selected").val();



            if(apply_chat !== null && select !== null ){
                if(apply_chat=="3" && select=="3" && employee_type!=="3" ){
                    $("#medical_company_option").prop('selected',false);
                    $(".medcial_category_div").hide();
                    $(".only_hey_vip_divs").css('display','flex');
                    add_limo_option();



                    $("#own_of_emirates_id").prop('checked',true);
                    $("#company_of_emirates_id").prop('checked',false);



                }else{
                    $(".only_hey_vip_divs").hide();
                    $("#working_designation option[value='1']").remove();
                    // $("#own_of_emirates_id").prop('checked',false);
                    // $("#company_of_emirates_id").prop('checked',true);




                    $("input[type='radio'][name='case_fine']").val('1').trigger('change');
                    $("#company_case_fine").attr('value','2');


                }
            }else{
                $(".only_hey_vip_divs").hide();
                $("#working_designation option[value='1']").remove();

                $("#own_of_emirates_id").prop('checked',false);
                $("#company_of_emirates_id").prop('checked',true);
            }

            var employee_id = $("#employee_type option:selected").val();
            var company_id = $(this).val();
            var option_label = "Labor Fees";
            var current_status = $("#current_status option:selected").val();

            if(company_id==""){
                company_id = null;
            }

            $("#generate_button").click();




        });




        $("#working_designation").change(function(){
            $("#visa_designation").empty();

            var select_id = $(this).val();
            var employee_type = $("#employee_type option:selected").val();
            var token = $("input[name='_token']").val();
            var value_ab = "";
            $.ajax({
                url: "{{ route('get_agreement_designation') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: select_id, employee_type: employee_type, _token:token},
                success: function(response) {

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            value_ab = response[i].id;
                            if(select_id=="1"){
                                console.log(response[i].other_jobs)
                                add_dynamic_opton(response[i].id,response[i].limo_jobs);
                                $(".only_hey_vip_divs").css('display','flex');
                            }else{
                                $(".only_hey_vip_divs").hide();
                                add_dynamic_opton(response[i].id,response[i].other_jobs);
                            }

                        }
                        console.log(value_ab);
                        if(select_id=="2" || select_id=="3"){
                            $('#visa_designation').val(value_ab).trigger('change');
                        }else{
                            $('#visa_designation').val(null).trigger('change');
                        }

                    }
                }
            });




        });




    </script>

    {{--    discount row jquery start--}}
    <script>

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


            var sum = 0;
            $(".discount_amount_cls").each(function(){
                sum += +$(this).val();
            });

            var first_discount = $("#discount_offer").val();
            var advance_amount = $("#advance_amount").val();

            if(first_discount!=="0"){
                first_discount = $("#discount_offer").val();
            }else{
                first_discount = "0";
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            if(advance_amount!=="0"){
                advance_amount = $("#advance_amount").val();
            }else{
                advance_amount = "0";
            }

            var gamer = parseFloat(get_total_amount())-parseFloat(sum)-parseFloat(first_discount)-parseFloat(advance_amount);
            $(".total_amount").html(gamer);
            $("#g_total_amount").val(gamer);


        });




        function add_new_discount_row(id){
            var html = '<div class="col-md-5 discunt_div-'+id+'"><label for="visit_entry_date" style="margin-bottom: 0px;">Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $names)<option value="{{ $names->names }}">{{ $names->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'"><label for="visit_entry_date" style="margin-bottom: 0px;">Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            return html;
        }
    </script>

    {{--    discount row jquery end--}}


    {{--    generate amount part here--}}

    <script>

        $("#generate_button").click(function () {

            //$("#visa_applying option:selected").val();

            var visa_applying =  $('#visa_applying').find(":selected").val();
            var car_type = $('input:radio[name="car_type"]:checked').val();
            var license_type = $('input:radio[name="license_type"]:checked').val();
            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var license_label = "";
            if(license_type=="1"){
                license_label  = "Bike";
                car_type = null;
            }else if(license_type=="2"){
                license_label  = "Car";
            }else if(license_type=="3"){
                license_label  = "Both";
            }

            var selected_now = $(this).val();
            var token = $("input[name='_token']").val();


            var driving_license_ab = $('input:radio[name="driving_license"]:checked').val();

            // if(driving_license_ab!=="2" && driving_license_ab!=="3"){

            $.ajax({
                url: "{{ route('ajax_get_license_amount') }}",
                method: 'POST',
                data: {option_value: driving_license_ab,employee_id:employee_id, current_status: current_status, company_id:visa_applying, option_label:license_label, car_type:car_type , _token:token},
                success: function(response) {
                    var ab = response.split("-");
                    if(ab[0]!=="0"){
                        $(".driving_license_amount_div").show();
                        $("#driving_license_amount").html(ab[0]);
                        $("#driving_license_amount_field").val(ab[0]);
                        $("#driving_license_amount_primary_id").val(ab[1]);
                    }else{
                        $(".driving_license_amount_div").css('display','none');
                        $("#driving_license_amount_field").val("");
                        $("#driving_license_amount_primary_id").val("");
                        $("#driving_license_amount").html("0");
                    }
                }
            });


            //admin license Amount
            $.ajax({
                url: "{{ route('ajax_admin_license_amount') }}",
                method: 'POST',
                data: {option_value: driving_license_ab,employee_id:employee_id, current_status: current_status, company_id:visa_applying, option_label:license_label, car_type:car_type , _token:token},
                success: function(response) {
                    var ab = response.split("-");
                    if(ab[0]!=="0"){
                        $(".admin_driving_license_amount_div").show();
                        $("#admin_driving_license_amount").html(ab[0]);
                        $("#admin_driving_licnes_amount_field").val(ab[0]);
                        $("#admin_driving_license_amount_field_primary_id").val(ab[1]);
                    }else{
                        $(".admin_driving_license_amount_div").css('display','none');
                        $("#admin_driving_licnes_amount_field").val("");
                        $("#admin_driving_license_amount_field_primary_id").val("");
                        $("#admin_driving_license_amount").html("0");
                    }
                }
            });


            // }

            // license part end here




            var employee_id =  $("#employee_type option:selected").val();
            var current_status =  $("#current_status option:selected").val();
            var option_label_evisa = "Inside E-visa Print";
            var child_now_evisa = $('input:radio[name="inside_visa_type"]:checked').val();
            var evisa_print = $('input:radio[name="evisa_print"]:checked').val();
            if(evisa_print=="2"){
                child_now_evisa = null;
            }

            if(evisa_print!==null){

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {option_value: evisa_print,employee_id:employee_id, current_status:current_status, child_now:child_now_evisa, company_id:visa_applying, option_label:option_label_evisa , _token:token},
                    success: function(response) {
                        var ab = response.split("-");

                        if(ab[0]!=="0"){
                            $(".inside_status_evisa_print_div").show();
                            $("#evisa_print_amount").html(ab[0]);

                            $("#evisa_print_amount_field").val(ab[0]);
                            $("#evisa_print_amount_primary_id").val(ab[1]);


                        }else{
                            $(".inside_status_evisa_print_div").css('display','none');
                            $("#evisa_print_amount_field").val("");
                            $("#evisa_print_amount_primary_id").val("");
                            $("#evisa_print_amount").html("0");

                        }
                    }
                });

            }

            //evisa e print end here


            // var medical_option_value =  $("#medical_type option:selected").val();
            var medical_option_value =  $('#medical_type').find(":selected").val();

            console.log("option value gamer ="+medical_option_value);

            // var medical_category =  $("#medical_category option:selected").val();

            var medical_category =   $('#medical_category').find(":selected").val();

            if(medical_option_value=="1"){
                medical_category = null;
            }
            var option_label_medical = "Medical";
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_amounts_agreement') }}",
                method: 'POST',
                data: {option_value: medical_option_value,employee_id:employee_id, current_status:current_status, child_now:medical_category, company_id:visa_applying, option_label:option_label_medical , _token:token},
                success: function(response) {
                    var ab = response.split("-");

                    if(ab[0]!=="0"){
                        $(".div_medical_process").show();
                        $("#medical_process_amount").html(ab[0]);

                        $("#medical_process_amount_field").val(ab[0]);
                        $("#medical_process_amount_primary_id").val(ab[1]);

                    }else{
                        $(".div_medical_process").css('display','none');
                        $("#medical_process_amount_field").val("");
                        $("#medical_process_amount_primary_id").val("");
                        $("#medical_process_amount").html("0");
                    }
                }
            });

            // medical process end here




            var emirates_id = $('input:radio[name="emirates_id"]:checked').val();
            var option_label_emirates = "Emirates Id";

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_amounts_agreement') }}",
                method: 'POST',
                data: {option_value: emirates_id,employee_id:employee_id, current_status:current_status, company_id:visa_applying, option_label:option_label_emirates, _token:token},
                success: function(response) {
                    var ab = response.split("-");
                    if(ab[0]!=="0"){
                        $(".div_emirates_id").show();
                        $("#emirate_id_amount").html(ab[0]);
                        $("#emirate_id_amount_field").val(ab[0]);
                        $("#emirate_id_amount_primary_id").val(ab[1]);

                    }else{
                        $(".div_emirates_id").css('display','none');
                        $("#emirate_id_amount_field").val("");
                        $("#emirate_id_amount_primary_id").val("");
                        $("#emirate_id_amount").html("0");

                    }
                }
            });
            //emirates process end here


            var visa_pasting = $('input:radio[name="visa_pasting"]:checked').val();
            var option_label_visa_pasting = "Visa Pasting";

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_amounts_agreement') }}",
                method: 'POST',
                data: {option_value: visa_pasting,employee_id:employee_id, current_status:current_status, company_id:visa_applying, option_label:option_label_visa_pasting, _token:token},
                success: function(response) {
                    var ab = response.split("-");
                    if(ab[0]!=="0"){
                        $(".div_visa_pasting_amount").show();
                        $("#visa_pasting_amount").html(ab[0]);

                        $("#visa_pasting_amount_field").val(ab[0]);
                        $("#visa_pasting_amount_primary_id").val(ab[1]);

                    }else{
                        $(".div_visa_pasting_amount").css('display','none');

                        $("#visa_pasting_amount_field").val("");
                        $("#visa_pasting_amount_primary_id").val("");
                        $("#visa_pasting_amount").html("0");

                    }

                }
            });
            //visa pasting process end here


            var case_fine = $('input:radio[name="case_fine"]:checked').val();
            var option_label_case_fine = "In Case Fine";

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_amounts_agreement') }}",
                method: 'POST',
                data: {option_value: case_fine,employee_id:employee_id, current_status:current_status, company_id:visa_applying, option_label:option_label_case_fine, _token:token},
                success: function(response) {
                    var ab = response.split("-");
                    if(ab[0]!=="0"){
                        $(".div_case_fine").show();
                        $("#case_fine_amount").html(ab[0]);
                        $("#case_fine_amount_field").val(ab[0]);
                        $("#case_fine_amount_primary_id").val(ab[1]);

                    }else{
                        $(".div_case_fine").css('display','none');
                        $("#case_fine_amount_field").val("");
                        $("#case_fine_amount_primary_id").val("");
                        $("#case_fine_amount").html("0");

                    }

                }
            });
            //in case process end here



            // employee type condition



            // only limo option start



            var working_designation = $('#working_designation').find(":selected").val();
                // $("#working_designation option:selected").val();

            var working_visa = $('#working_visa').find(":selected").val();
                // $("#working_visa option:selected").val()

            if(visa_applying=="3" && working_visa=="3" && employee_id=="2" && working_designation=="1") {

                var english_test = $('input:radio[name="english_test"]:checked').val();
                var option_label_english_test = "English Language Test";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: english_test,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_english_test,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");

                        if (ab[0] !== "0") {
                            $(".div_englist_test").show();
                            $("#english_test_amount").html(ab[0]);

                            $("#english_test_amount_field").val(ab[0]);
                            $("#english_test_amount_primary_id").val(ab[1]);

                        } else {
                            $(".div_englist_test").css('display', 'none');
                            $("#english_test_amount_field").val("");
                            $("#english_test_amount_primary_id").val("");
                            $("#english_test_amount").html("0");

                        }
                    }
                });
                //English test end here

                var rta_permit_training = $('input:radio[name="rta_permit_training"]:checked').val();
                var option_label_rta_training = "RTA Permit Training";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: rta_permit_training,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_rta_training,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");

                        if (ab[0] !== "0") {
                            $(".div_rta_permit_training").show();
                            $("#rta_permit_training_amount").html(ab[0]);

                            $("#rta_permint_amount_field").val(ab[0]);
                            $("#rta_permint_amount_primary_id").val(ab[1]);

                        } else {
                            $(".div_rta_permit_training").css('display', 'none');
                            $("#rta_permint_amount_field").val("");
                            $("#rta_permint_amount_primary_id").val("");
                            $("#rta_permit_training_amount").html("0");

                        }
                    }
                });
                //rta permit traing end here

                var e_test = $('input:radio[name="e_test"]:checked').val();
                var option_label_e_test = "E Test";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: e_test,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_e_test,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");
                        if (ab[0] !== "0") {
                            $(".div_e_test").show();
                            $("#e_test_amount").html(ab[0]);

                            $("#e_test_amount_field").val(ab[0]);
                            $("#e_test_amount_primary_id").val(ab[1]);

                        } else {
                            $(".div_e_test").css('display', 'none');
                            $("#e_test_amount_field").val("");
                            $("#e_test_amount_primary_id").val("");
                            $("#e_test_amount").html("0");

                        }
                    }
                });
                //e test end here


                var rta_medical = $('input:radio[name="rta_medical"]:checked').val();
                var option_label_rta_medical = "RTA Medical";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: rta_medical,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_rta_medical,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");
                        if (ab[0] !== "0") {
                            $(".div_rta_medical").show();
                            $("#rta_medical_amount").html(ab[0]);
                            $("#rta_medical_amount_field").val(ab[0]);
                            $("#rta_medical_amount_primary_id").val(ab[1]);

                        } else {
                            $(".div_rta_medical").css('display', 'none');
                            $("#rta_medical_amount_field").val("");
                            $("#rta_medical_amount_primary_id").val("");
                            $("#rta_medical_amount").html("0");
                        }

                    }
                });
                //rta medical end here


                var cid_report = $('input:radio[name="cid_report"]:checked').val();
                var option_label_cid_report = "CID Report";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: cid_report,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_cid_report,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");
                        if (ab[0] !== "0") {
                            $(".div_cid_report").show();
                            $("#cid_report_amount").html(ab[0]);

                            $("#cid_report_amount_field").val(ab[0]);
                            $("#cid_report_amount_primary_id").val(ab[1]);
                        } else {
                            $(".div_cid_report").css('display', 'none');
                            $("#cid_report_amount_field").val("");
                            $("#cid_report_amount_primary_id").val("");
                            $("#cid_report_amount").html("0");

                        }
                    }
                });
                //cid report end here


                var rta_card_print = $('input:radio[name="rta_card_print"]:checked').val();
                var option_label_cid_report = "RTA Card Print";

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_amounts_agreement') }}",
                    method: 'POST',
                    data: {
                        option_value: rta_card_print,
                        employee_id: employee_id,
                        current_status: current_status,
                        company_id: visa_applying,
                        option_label: option_label_cid_report,
                        _token: token
                    },
                    success: function (response) {
                        var ab = response.split("-");
                        if (ab[0] !== "0") {
                            $(".div_card_print").show();
                            $("#card_print_amount").html(ab[0]);
                            $("#rta_print_amount_field").val(ab[0]);
                            $("#rta_print_amount_primary_id").val(ab[1]);

                        } else {
                            $(".div_card_print").css('display', 'none');

                            $("#rta_print_amount_field").val("");
                            $("#rta_print_amount_primary_id").val("");
                            $("#card_print_amount").html("0");

                        }
                    }
                });
                //rta card print end here


            }else{

                $(".div_englist_test").css('display', 'none');
                $("#english_test_amount_field").val("");
                $("#english_test_amount_primary_id").val("");
                $("#english_test_amount").html("0");

                $(".div_rta_permit_training").css('display', 'none');
                $("#rta_permint_amount_field").val("");
                $("#rta_permint_amount_primary_id").val("");
                $("#rta_permit_training_amount").html("0");


                $(".div_e_test").css('display', 'none');
                $("#e_test_amount_field").val("");
                $("#e_test_amount_primary_id").val("");
                $("#e_test_amount").html("0");

                $(".div_rta_medical").css('display', 'none');
                $("#rta_medical_amount_field").val("");
                $("#rta_medical_amount_primary_id").val("");
                $("#rta_medical_amount").html("0");

                $(".div_cid_report").css('display', 'none');
                $("#cid_report_amount_field").val("");
                $("#cid_report_amount_primary_id").val("");
                $("#cid_report_amount").html("0");

                $(".div_card_print").css('display', 'none');
                $("#rta_print_amount_field").val("");
                $("#rta_print_amount_primary_id").val("");
                $("#card_print_amount").html("0");

            }

            // only limo opton end here



            // labour Fees

            var arr_ids = new Array();
            var labour_fees_amount = 0;
            var option_label_fees= 'Labor Fees'

            $(".labour_fees_table").empty();
            var token = $("input[name='_token']").val();
            var value_ab = "";
            $.ajax({
                url: "{{ route('ajax_amounts_labour_fees') }}",
                method: 'POST',
                cache: false,
                dataType: 'json',
                data: {company_id: visa_applying, employee_id: employee_id, current_status:current_status, option_label:option_label_fees,  _token:token},
                success: function(response) {
                    $(".labour_fees_table").html('');
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }else{
                        arr_ids = [];
                    }
                    var options = "";
                    if(len > 0){

                        for(var i=0; i<len; i++){
                            var option_value = response[i].option_value;
                            var now_option = "";
                            if(option_value=="1"){
                                now_option = "Quota";
                            }else if(option_value=="2"){
                                now_option = "Offer Letter";
                            }else if(option_value=="3"){
                                now_option = "Offer Letter Submission";
                            }else if(option_value=="4"){
                                now_option = "Labor Fees";
                            }else if(option_value=="5"){
                                now_option = "New Contract Typing";
                            }else if(option_value=="6"){
                                now_option = "New Contract Submission";
                            }

                            var amount = response[i].amount;
                            var id = response[i].id;

                            labour_fees_amount += amount;

                            arr_ids.push(id);

                            var html = '<tr><th scope="col">'+now_option+'</th><th scope="col" class="amounts_labour_fees">'+amount+'</th></tr>'


                            $(".labour_fees_table").append(html);
                        }

                        $("#labour_fees_total").val(labour_fees_amount);
                        $("#labour_fees_ids").val(arr_ids);

                    }else{
                        $("#labour_fees_total").val("0");
                        $("#labour_fees_ids").val("0");
                    }
                }
            });

            //admin Fee ajax start
            var token = $("input[name='_token']").val();
            var admin_total = 0;
            $.ajax({
                url: '{{ route('admin_fees_ajax') }}',
                method: 'POST',
                data: {
                    employee_id: employee_id,
                    current_status: current_status,
                    company_id: visa_applying,
                    _token: token
                },
                success: function (response) {
                    var ab = response.split("-");
                    if (ab[0] !== "0") {
                        admin_total = ab[0];
                        $(".div_admin_amount").show();
                        $("#admin_amount").html(ab[0]);
                        $("#admin_amount_field").val(ab[0]);
                        $("#admin_amount_field_primary_id").val(ab[1]);

                    }else{
                        $(".div_admin_amount").css('display', 'none');
                        $("#admin_amount_field").val("");
                        $("#admin_amount_field_primary_id").val("");
                        $("#admin_amount").html("0");

                    }
                }
            });






            setTimeout(
                function()
                {
                    var now_sum = get_total_amount();

                    $(".tota_amount_row").show();
                    $(".total_amount").html(now_sum);
                    $("#g_total_amount").val(now_sum);

                    total_discount_now();

                }, 2000);



                // $(".").trigger("change");






        });
    </script>
    {{--    generte amount part end--}}

    {{--    ajax form start--}}
    <script>
        // this is the id of the form
        $("#agreement_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                cache: false,
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(response)
                {
                    if(response=="success"){
                        tostr_display("success","Agreement Created Successfully");

                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);
                        // alert("agreement is submitted");
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



    {{--     after modificaction jquery end here--}}

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
        $(document).ready(function(){

            setTimeout(function() {

                var advance_amount = $("#advance_amount").val();
                if(advance_amount !== ""){
                    advance_amount =  $("#advance_amount").val();
                }else{
                    advance_amount = 0;
                }


                var first_discount =  $("#discount_offer").val();

                if(first_discount !== ""){
                    first_discount =  $("#discount_offer").val();
                }else{
                    first_discount = 0;
                }

                if(first_discount == undefined){
                    first_discount = 0;
                }

                var disocunt_sum = 0;
                $(".discount_amount_cls").each(function(){
                    disocunt_sum += +$(this).val();
                });

                var step_amount = 0;
                $(".step_amount_cls").each(function(){
                    step_amount += +$(this).val();
                });

           var total_discount = parseFloat(advance_amount)+parseFloat(disocunt_sum)+parseFloat(step_amount)+parseFloat(first_discount);

                if(isNaN(total_discount)) {
                    total_discount = 0;
                }

           console.log("total_discount"+total_discount);

           var g_total = $(".total_amount").html();

           console.log("grand total="+g_total);

           var remain_total =  parseFloat(g_total)-parseFloat(total_discount);

           // var now_sum = get_total_amount();

                // $(".tota_amount_row").show();
                // $(".total_amount").html(remain_total);
                $("#g_total_amount").val(remain_total);

            }, 2000 );

        });
    </script>

    <script>
        function total_discount_now(){

            var advance_amount = $("#advance_amount").val();
            if(advance_amount !== ""){
                advance_amount =  $("#advance_amount").val();
            }else{
                advance_amount = 0;
            }

            var adjustment_amount =  $("#adjustment_amount").val();
            if(adjustment_amount !== ""){
                adjustment_amount =  $("#adjustment_amount").val();
            }else{
                adjustment_amount = 0;
            }


            var first_discount =  $("#discount_offer").val();

            if(first_discount !== ""){
                first_discount =  $("#discount_offer").val();
            }else{
                first_discount = 0;
            }

            if(first_discount == undefined){
                first_discount = 0;
            }

            var disocunt_sum = 0;
            $(".discount_amount_cls").each(function(){
                if($(this).val()!=""){
                    disocunt_sum += +$(this).val();
                }

            });

            var step_amount = 0;
            $(".step_amount_cls").each(function(){
                if($(this).val()!=""){
                    step_amount += +$(this).val();
                }

            });



            var total_discount = parseFloat(advance_amount)+parseFloat(disocunt_sum)+parseFloat(step_amount)+parseFloat(first_discount)-parseFloat(adjustment_amount);

            var g_total = $(".total_amount").html();

            if(isNaN(total_discount)) {
                total_discount = 0;
            }

            // console.log("Total Discount ="+total_discount);
            // console.log("Total Discount grand total ="+g_total);

            var remain_total =  parseFloat(g_total)-parseFloat(total_discount);

            $("#g_total_amount").val(remain_total);
        }
    </script>


    <script>
        setTimeout(
            function()
            {

            $("#generate_button").click();
            }, 2500);
    </script>



@endsection


