{{-- <div class="col-md-3 " id="name">{{$name}}</div>
<div class="col-md-3" id="ppuid">{{$ppuid}}</div>
<div class="col-md-3" id="passport_no">{{$passport_no}}</div>
<div class="col-md-3" id="exp_days">{{$remain_days}}</div --}}


{{-- <div class="row"> --}}
    <div class="col-md-2"> </div>
    <div class="col-md-8">

        <div class="card card-profile-1 mb-4">
            <div class="card-body text-center">
                <div class="avatar box-shadow-2 mb-3">
                <img src="{{  $image ? url($image) : asset('assets/images/user_avatar.jpg') }}" alt=""></div>
                <h5 class="m-0">{{$name}}</h5>
                <p class="mt-0"><span class="badge badge-secondary m-2"> {{$ppuid}}</span></p>
                <p class="mt-0">{{$passport_no}}</p>
                <p><span class="badge badge-danger m-2">   {{$remain_days}}</span></p>
                @if ($fine_starts != 'null' && $offer_letter != null && $fine_starts !=null )
                <div class="alert alert-danger" role="alert">
                    <strong class="text-capitalize">Fine Starts From!</strong>
                      {{$fine_starts}}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                @endif
                @if($cancel_between != null)
                <div class="alert alert-danger" role="alert">
                <h5 class="m-0">
                    <strong class="text-capitalize"></strong>
                    Visa Has Been Cancelled
                </h5>
                </div>
                @endif
                <div>
                    <button
                    @if(isset($bypass))
                    class="btn btn-info btn-bypass"
                    disabled
                    @else
                    class="btn btn-info btn-bypass"
                    @endif
                    data-toggle="modal"
                     data-target=".bd-example-modal-sm-2" onclick="bypassData({{$passport_id}})"
                     type="button">
                     @if(isset($bypass))
                     Visa Process is "By Passed"
                     @else
                     By Pass Visa Process
                     @endif
                    </button>
                </div>

                {{-- viisa statatus validation message --}}
                @if ($rider_not_visas !=null )
                <div class="alert alert-danger" role="alert">
                    <strong class="text-capitalize">Visa Status Not Given!</strong>
                    Visa status has not been entered. Please enter visa status first   <a class="" href="{{ url('rider_dont_have_visa') }}" target="_blank">Add Visa Status Here</a>


                </div>
                @endif
                @if ($visa_start_status =='0' )
                <div class="alert alert-danger" role="alert">
                    <strong class="text-capitalize">Visa Process Has Not Been Intiated!</strong>
                    Visa process has not been intiated. Please please initiate visa process first   <a class="" href="{{ url('visa_process_report') }}" target="_blank">Start Visa Process Here</a>


                </div>

                @endif

            </div>

        </div>

    </div>
    <div class="col-md-2"> </div>



    <div class="col-md-12">
        @if($own_visa=='1' || $own_visa=='12')
        {{-- @if($rider_visa_status=='1') --}}


        <div class="alert alert-danger text-center" role="alert">
            <strong class="text-capitalize text-center">Own Visa Process Required!</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif($rider_visa_status=='0')
        <div class="alert alert-danger text-center" role="alert">
            <strong class="text-capitalize text-center">Visa Status Required!</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif($visa_start_status=='0')
        <div class="alert alert-danger text-center" role="alert">
            <strong class="text-capitalize text-center">Visa Process Has Not Been Initiated!</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"></button>
        </div>
        @else
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Process</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Amount Status</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Visa Process Actions</th>
                                <th scope="col">Cancel Visa</th>
                                <th scope="col">Replacement Visa</th>
                                <th scope="col">Cancel Visa</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- offer letter process 1 --}}
                            <?php  $vp_array = ['Admin','VisaProcessManager',"VisaProcess"]; ?>
                                        @hasanyrole($vp_array)
                            <tr>
                               <td>1</td>
                               <td>Offer Letter</td>
                               <td>@if($offer_letter!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                               <td>@if($offer_letter_amount==null)@else {{isset($offer_letter_amount->amount)?$offer_letter_amount->amount:"0"}} @endif</td>
                               <td>
                                @if($offer_letter_amount!=null)

                                @if (isset($offer_letter_amount->partial_amount_status) && $offer_letter_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$offer_letter_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$offer_letter_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($offer_letter_amount->partial_amount_status) && $offer_letter_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$offer_letter_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>




                                @elseif ($offer_letter_amount->pay_status=='1' )
                                    <span class="badge badge-success"> Paid  </span>
                                @elseif ($offer_letter_amount->pay_status=='2' )
                                            @if ($offer_letter_amount->unpaid_status=='1')
                                              <span class="badge badge-success"> Will be paid at {{$offer_letter_amount->pay_later->step_name}}  </span>
                                              @else
                                              <span class="badge badge-info"> Payroll Deduction </span>
                                            @endif
                                @else
                                <span class="badge badge-danger"> Unpaid  </span>
                                @endif
                                @else
                                @endif
                            </td>
                               <td>@if($offer_letter_amount==null) @else @if($offer_letter_amount->remarks == null)  @else {{$offer_letter_amount->remarks}} @endif @endif</td>
                               <td>
                                <button @if(isset($offer_letter_amount) && $offer_letter_amount->pay_status == null  )  disabled @endif
                                    @if(isset($cancel_between))
                                    @if($cancel_between->visa_process_id == '2' || $cancel_between->visa_process_id > '2')
                                    @else
                                    disabled
                                    @endif
                                    @endif
                                    class="btn btn-primary btn-sm btn-start" onclick="offertLetterStartProcess({{$passport_id}})" type="button">
                                    @if($offer_letter==null &&  $next_status_id=='2')
                                    Start Process
                                    @else
                                    View
                                    @endif
                                </button>
                                </td>

                                <td>
                                <button
                                @if($offer_letter == null && !isset($stop_resume_offer_letter))  disabled   @endif
                                @if($offer_letter != null && $offer_letter_sub != null && !isset($stop_resume_offer_letter))  disabled   @endif
                                @if(isset($stop_resume_offer_letter) && $stop_resume_offer_letter->visa_process_step_id=='2' &&  $stop_resume_offer_letter->status=='2')
                                class="btn btn-info btn-sm btn-start"
                                @elseif(isset($stop_resume_offer_letter) && $stop_resume_offer_letter->visa_process_step_id=='2' &&  $stop_resume_offer_letter->status=='1')
                                class="btn btn-success btn-sm btn-start"
                                @else class="btn btn-danger btn-sm btn-start"
                                @endif
                                 onclick="VisaProcessStopResume({{$passport_id}},'2')" type="button">
                                @if(isset($stop_resume_offer_letter) && $stop_resume_offer_letter->visa_process_step_id=='2' &&  $stop_resume_offer_letter->status=='2')
                                View
                                @elseif(isset($stop_resume_offer_letter) && $stop_resume_offer_letter->visa_process_step_id=='2' &&  $stop_resume_offer_letter->status=='1')
                                 Resume
                                @else
                                Stop
                                @endif
                                </button>



                            </td>
                            <td> &nbsp;</td>

                                {{-- cancel-visa --}}
                                 <td>

                                    <button
                                    @if($offer_letter == null)  disabled   @endif
                                    @if($req == null)  disabled   @endif
                                    @if($offer_letter_sub != null)  disabled   @endif
                                    @if(isset($offer_letter_amount) && $offer_letter_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'2')" type="button">
                                   Cancel
                                    </button>

                                </td>

                            </tr>

                                {{-- offer letter submission process 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td>Offer Letter Submission</td>
                                    <td>@if($offer_letter_sub!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($offer_letter_sub_amount==null) @else @if($offer_letter_sub_amount->amount==null) Pending @else  {{$offer_letter_sub_amount->amount}}  @endif @endif</td>
                                    <td>@if($offer_letter_sub_amount!=null)


                                        @if (isset($offer_letter_sub_amount->partial_amount_status) && $offer_letter_sub_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$offer_letter_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$offer_letter_sub_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($offer_letter_sub_amount->partial_amount_status) && $offer_letter_sub_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$offer_letter_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($offer_letter_sub_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                          @elseif ($offer_letter_sub_amount->pay_status=='2' )
                                                @if ($offer_letter_sub_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$offer_letter_sub_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else

                                         @endif</td>
                                    <td>@if($offer_letter_sub_amount==null) @else @if($offer_letter_sub_amount->remarks == null)  @else {{$offer_letter_sub_amount->remarks}} @endif @endif</td>
                                    <td>
                                     <button @if( ($next_status_id<'3') || isset($offer_letter_sub_amount) && $offer_letter_sub_amount->pay_status == null )  disabled @endif
                                        @if(isset($stop_resume_offer_letter) && $stop_resume_offer_letter->visa_process_step_id=='2' &&  $stop_resume_offer_letter->status=='1')
                                        disabled
                                        @endif
                                        @if(isset($cancel_between))
                                        @if($cancel_between->visa_process_id == '3' || $cancel_between->visa_process_id > '3')

                                        @else
                                        disabled
                                        @endif
                                        @endif

                                        class="btn btn-primary btn-sm btn-start" onclick="offertLetterSubStartProcess({{$passport_id}})" type="button">
                                        @if( $offer_letter_sub == null && $next_status_id=='3' )

                                         Start Process
                                         @elseif($offer_letter_sub == null && $next_status_id<'3' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                            {{---new button----}}
                                        </td>
                                        <td>

                                     <button
                                     @if($offer_letter_sub == null && !isset($stop_resume_offer_letter_sub))  disabled   @endif

                                     @if($offer_letter_sub != null && $electronic_pre_approval != null && !isset($stop_resume_offer_letter_sub))  disabled   @endif
                                     {{-- @if(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id =='3' && $stop_resume_offer_letter_sub->status =='2' ) disabled @endif --}}
                                     @if(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id=='3' &&  $stop_resume_offer_letter_sub->status=='2')
                                class="btn btn-info btn-sm btn-start"
                                @elseif(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id=='3' &&  $stop_resume_offer_letter_sub->status=='1')
                                class="btn btn-success btn-sm btn-start"
                                @else class="btn btn-danger btn-sm btn-start"
                                @endif
                                 onclick="VisaProcessStopResume({{$passport_id}},'3')" type="button">
                                @if(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id=='3' &&  $stop_resume_offer_letter_sub->status=='2')
                                View
                                @elseif(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id=='3' &&  $stop_resume_offer_letter_sub->status=='1')
                                 Resume
                                @else
                                Stop
                                @endif
                                </button>
                                    </td>
                                    <td> &nbsp;</td>

                                      {{-- cancel-visa --}}
                                <td>



                                    <button
                                    @if($electronic_pre_approval != null)  disabled   @endif
                                    @if($req == null)  disabled   @endif
                                    @if($offer_letter_sub == null)  disabled   @endif
                                    @if(isset($offer_letter_sub_amount) && $offer_letter_sub_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'3')" type="button">
                                   Cancel
                                    </button>

                                </td>
                                 </tr>

                                   {{-- Electronic Pre Approval process 3 --}}

                                   <tr>
                                    <td>3</td>
                                    <td>Labour/Electronic Pre Approval</td>
                                    <td>@if($electronic_pre_approval!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($electronic_pre_approval_amount==null) @else {{isset( $electronic_pre_approval_amount->amount)? $electronic_pre_approval_amount->amount:'0'}} @endif</td>
                                    <td>
                                        @if($electronic_pre_approval_amount!=null)
                                        @if (isset($electronic_pre_approval_amount->partial_amount_status) && $electronic_pre_approval_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$electronic_pre_approval_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$electronic_pre_approval_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($electronic_pre_approval_amount->partial_amount_status) && $electronic_pre_approval_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$electronic_pre_approval_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($electronic_pre_approval_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                    @elseif ($electronic_pre_approval_amount->pay_status=='2' )
                                                @if ($electronic_pre_approval_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$electronic_pre_approval_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                         @else  @endif</td>
                                    <td>@if($electronic_pre_approval_amount==null) @else @if($electronic_pre_approval_amount->remarks == null)  @else {{$electronic_pre_approval_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button
                                         @if( ($next_status_id<'4') ||  isset($electronic_pre_approval_amount) && $electronic_pre_approval_amount->pay_status == null )  disabled @endif
                                         @if(isset($stop_resume_offer_letter_sub) && $stop_resume_offer_letter_sub->visa_process_step_id=='3' &&  $stop_resume_offer_letter_sub->status=='1')
                                         disabled
                                         @endif
                                         @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '4' || $cancel_between->visa_process_id >'4')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         class="btn btn-primary btn-sm btn-start" onclick="electronicPreAppStartProcess({{$passport_id}})" type="button">

                                            @if($electronic_pre_approval==null && $next_status_id=='4')
                                         Start Process
                                         @elseif($electronic_pre_approval == null && $next_status_id<'4')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  {{-- stop_resume_insurance_amount --}}
                                                  {{-- @if($fit_unfit == null && $stop_resume_fit_unfit== null)  disabled   @endif
                                                  @if($fit_unfit != null && $emirates_id_apply != null && !isset($stop_resume_fit_unfit))  disabled   @endif
                                                  @if(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id !='15' ) disabled @endif --}}
                                                  <button
                                                  @if($electronic_pre_approval == null && !isset($stop_resume_electronic_pre_approval))  disabled   @endif
                                                  @if($electronic_pre_approval != null && $labour_insurance != null && !isset($stop_resume_electronic_pre_approval))  disabled   @endif

                                                  @if(isset($stop_resume_electronic_pre_approval) && $stop_resume_electronic_pre_approval->visa_process_step_id=='4' &&  $stop_resume_electronic_pre_approval->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_electronic_pre_approval) && $stop_resume_electronic_pre_approval->visa_process_step_id=='4' &&  $stop_resume_electronic_pre_approval->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'4')" type="button">
                                                  @if(isset($stop_resume_electronic_pre_approval) && $stop_resume_electronic_pre_approval->visa_process_step_id=='4' &&  $stop_resume_electronic_pre_approval->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_electronic_pre_approval) && $stop_resume_electronic_pre_approval->visa_process_step_id=='4' &&  $stop_resume_electronic_pre_approval->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <button
                                    @if($req == null)  disabled   @endif
                                    @if($electronic_pre_approval_pay != null)  disabled   @endif
                                    @if($electronic_pre_approval == null)  disabled   @endif
                                    @if($offer_letter_sub == null)  disabled   @endif

                                    @if(isset($electronic_pre_approval_amount) && $electronic_pre_approval_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'4')" type="button">
                                   Cancel
                                    </button>

                                </td>
                                 </tr>
{{-- labour insurance --}}

                                 <tr>
                                    <td>4</td>
                                    <td>Labour Insurance</td>
                                    <td>@if($labour_insurance!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($labour_insurance_amount==null) @else {{isset( $labour_insurance_amount->amount)? $labour_insurance_amount->amount:'0'}} @endif</td>
                                    <td>@if($labour_insurance_amount!=null)

                                        @if (isset($labour_insurance_amount->partial_amount_status) && $labour_insurance_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$labour_insurance_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$labour_insurance_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($labour_insurance_amount->partial_amount_status) && $labour_insurance_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$labour_insurance_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($labour_insurance_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($labour_insurance_amount->pay_status=='2' )
                                                @if ($labour_insurance_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$labour_insurance_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else  @endif</td>
                                    <td>@if($labour_insurance_amount==null) @else @if($labour_insurance_amount->remarks == null)  @else {{$labour_insurance_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button
                                        @if($electronic_pre_approval == null )  disabled   @endif
                                        {{-- @if( ($next_status_id<'29') ||  isset($labour_insurance_amount) && $labour_insurance_amount->pay_status == null )  disabled @endif --}}
                                            @if(isset($stop_resume_insurance_amount) && $stop_resume_insurance_amount->visa_process_step_id=='28'
                                             &&  $stop_resume_insurance_amount->status=='1')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                            @if($cancel_between->visa_process_id == '28' || $cancel_between > '29')
                                            @else
                                            disabled
                                            @endif
                                            @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="labourInsuranceStartProcess({{$passport_id}})" type="button">


                                         @if($labour_insurance==null && $next_status_id=='29')
                                         Start Process
                                         @elseif($labour_insurance == null && $next_status_id<'29' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>

                                    </td>
                                    <td>

                                                  {{---new button----}}
                                                  <button
                                                  @if($labour_insurance == null && $stop_resume_labour_insurance== null)  disabled   @endif
                                                  @if($labour_insurance != null && $electronic_pre_approval_pay != null && !isset($stop_resume_labour_insurance))  disabled   @endif


                                                  @if(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id !='28' ) disabled @endif

                                                  @if(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id !='28' &&  $stop_resume_labour_insurance->status=='2'  )  disabled @endif
                                                  @if(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id=='28' &&  $stop_resume_labour_insurance->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id=='28' &&  $stop_resume_labour_insurance->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'28')" type="button">
                                                  @if(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id=='28' &&  $stop_resume_labour_insurance->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_labour_insurance) && $stop_resume_labour_insurance->visa_process_step_id=='28' &&  $stop_resume_labour_insurance->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                                </td>
                                                <td> &nbsp;</td>
                                                 {{-- cancel-visa --}}
                                <td>

                                    <button
                                    @if($req == null)  disabled   @endif
                                    @if($electronic_pre_approval_pay!=null)  disabled   @endif
                                    @if($offer_letter_sub == null)  disabled   @endif
                                    @if($labour_insurance == null)  disabled   @endif
                                    @if(isset($labour_insurance_amount) && $labour_insurance_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'28')" type="button">
                                   Cancel
                                    </button>

                                </td>
                                 </tr>
{{-- labour card ends --}}

                            {{-- Electronic Pre Approval payment process 4 --}}
                                 <tr>
                                    <td>5</td>
                                    <td>Labour/Electronic Pre Approval Payment</td>
                                    <td>@if($electronic_pre_approval_pay!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($electronic_pre_approval_pay_amount==null) @else {{isset( $electronic_pre_approval_pay_amount->amount)? $electronic_pre_approval_pay_amount->amount:'0'}} @endif</td>
                                    <td>@if($electronic_pre_approval_pay_amount!=null)

                                        @if (isset($electronic_pre_approval_pay_amount->partial_amount_status) && $electronic_pre_approval_pay_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$electronic_pre_approval_pay_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$electronic_pre_approval_pay_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($electronic_pre_approval_pay_amount->partial_amount_status) && $electronic_pre_approval_pay_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$electronic_pre_approval_pay_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($electronic_pre_approval_pay_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($electronic_pre_approval_pay_amount->pay_status=='2' )
                                                @if ($electronic_pre_approval_pay_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$electronic_pre_approval_pay_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else  @endif</td>
                                    <td>@if($electronic_pre_approval_pay_amount==null) @else @if($electronic_pre_approval_pay_amount->remarks == null)  @else {{$electronic_pre_approval_pay_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'5')  ||  isset($electronic_pre_approval_pay_amount) && $electronic_pre_approval_pay_amount->pay_status == null )  disabled @endif
                                            @if(isset($stop_resume_electronic_pre_approval) && $stop_resume_electronic_pre_approval->visa_process_step_id=='4' &&  $stop_resume_electronic_pre_approval->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                            @if($cancel_between->visa_process_id == '5' || $cancel_between > '5')
                                            @else
                                            disabled
                                            @endif
                                            @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="electronicPrePayStartProcess({{$passport_id}})" type="button">


                                         @if($electronic_pre_approval_pay==null && $next_status_id=='5')
                                         Start Process
                                         @elseif($electronic_pre_approval_pay == null && $next_status_id<'5'  || $next_status_id=='29' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>

                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($electronic_pre_approval_pay == null && !isset($stop_resume_electronic_pre_approval_pay))  disabled   @endif
                                                  @if($electronic_pre_approval_pay != null && $print_inside_out_side != null && !isset($stop_resume_electronic_pre_approval_pay))  disabled   @endif

                                                  @if(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id !='5' &&  $stop_resume_electronic_pre_approval_pay->status=='2'  )  disabled @endif
                                                  @if(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id=='5' &&  $stop_resume_electronic_pre_approval_pay->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id=='5' &&  $stop_resume_electronic_pre_approval_pay->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'5')" type="button">
                                                  @if(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id=='5' &&  $stop_resume_electronic_pre_approval_pay->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id=='5' &&  $stop_resume_electronic_pre_approval_pay->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                                </td>
                                                <td>
                                                    <button

                                                     @if(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->status =='2' &&  $replacement_inside_out_side==null) disabled
                                                     @elseif(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->status =='1')
                                                     @elseif(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->status =='1' &&  $replacement_inside_out_side != null )
                                                     @else
                                                     @endif

                                                     @if(!isset($replacement_req))
                                                            disabled
                                                     @endif
                                                     onclick="VisaProcessReplacement({{$passport_id}},'5')" type="button"
                                                     class="btn btn-warning btn-sm btn-start">

                                                     Replacement
                                                     @if(!isset($replacement_req))
                                                        <span class="replace-btn">No Replacement Reqeuest</span>
                                                     @endif
                                                   </button>
                                                </td>
                                                 {{-- cancel-visa --}}
                                <td>

                                    <button
                                    @if($req == null)  disabled   @endif
                                    @if($print_inside_out_side!=null)  disabled   @endif
                                    @if($offer_letter_sub == null)  disabled   @endif
                                    @if($electronic_pre_approval_pay == null)  disabled   @endif
                                    @if(isset($electronic_pre_approval_pay_amount) && $electronic_pre_approval_pay_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'5')" type="button">
                                   Cancel
                                    </button>

                                </td>
                                 </tr>
                                   {{-- Print Visa Inside/Outside process 6 --}}
                                   <tr>
                                    <td>6</td>
                                    <td>Print Visa Inside/Outside</td>
                                    <td>@if($print_inside_out_side!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($print_inside_out_side_amount==null) @else {{isset($print_inside_out_side_amount->amount)?$print_inside_out_side_amount->amount:'0'}} @endif</td>
                                    <td>@if($print_inside_out_side_amount!=null)

                                        @if (isset($print_inside_out_side_amount->partial_amount_status) && $print_inside_out_side_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$print_inside_out_side_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$print_inside_out_side_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($print_inside_out_side_amount->partial_amount_status) && $print_inside_out_side_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$print_inside_out_side_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($print_inside_out_side_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($print_inside_out_side_amount->pay_status=='2' )
                                                @if ($print_inside_out_side_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$print_inside_out_side_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif
                                        @else  @endif</td>
                                    <td>@if($print_inside_out_side_amount==null) @else @if($print_inside_out_side_amount->remarks == null)  @else {{$print_inside_out_side_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'6')  || isset($print_inside_out_side_amount) && $print_inside_out_side_amount->pay_status == null )  disabled @endif
                                            @if(isset($stop_resume_electronic_pre_approval_pay) && $stop_resume_electronic_pre_approval_pay->visa_process_step_id=='5' &&  $stop_resume_electronic_pre_approval_pay->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '6' || $cancel_between->visa_process_id >'6')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $print_inside_out_side== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="printInsideOutsideStartProcess({{$passport_id}})" type="button">

                                         @if($print_inside_out_side==null && $next_status_id=='6' || $next_status_id=='7')
                                         Start Process
                                         @elseif($print_inside_out_side == null && $next_status_id<'6'  || $next_status_id=='29'  )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($print_inside_out_side == null && !isset($stop_resume_print_inside_out_side))  disabled   @endif
                                                  @if($print_inside_out_side != null && $status_change != null && !isset($stop_resume_print_inside_out_side))  disabled
                                                    @elseif($print_inside_out_side != null && $in_out_change != null && !isset($stop_resume_print_inside_out_side))
                                                      disabled
                                                  @endif
                                                  @if(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id !='6' &&  $stop_resume_print_inside_out_side->status=='2' ) disabled @endif
                                                  @if(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id=='6' &&  $stop_resume_print_inside_out_side->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id=='6' &&  $stop_resume_print_inside_out_side->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'6')" type="button">
                                                  @if(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id=='6' &&  $stop_resume_print_inside_out_side->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id=='6' &&  $stop_resume_print_inside_out_side->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                                  {{-- replace btn 1 --}}
                                                </td>
                                                <td>
                                                &nbsp;
                                    </td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <button
                                    @if($req == null)  disabled   @endif
                                    @if($status_change != null || $in_out_amount!=null)  disabled   @endif
                                    @if($electronic_pre_approval_pay == null)  disabled   @endif
                                    @if($print_inside_out_side == null)  disabled   @endif
                                    @if(isset($print_inside_out_side_amount) && $print_inside_out_side_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'6')" type="button">
                                   Cancel
                                    </button>

                                </td>

                                 </tr>

                        {{-- process 6 --}}
                                 <tr>
                                    <td>7</td>
                                    <td>Status Change / In-out Change</td>
                                    <td>@if($status_change!=null || $in_out_change !=null) <span class="badge badge-success"> Completed @else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>
                                        @if($status_change_amount==null && $in_out_amount ==null)

                                        @else
                                        @if($status_change_amount != null) {{isset($status_change_amount->amount)?$status_change_amount->amount:"0"}} @elseif($in_out_amount!=null)
                                        {{isset($in_out_amount->amount)?$in_out_amount->amount:'0'}}
                                        @else
                                        @endif
                                         @endif
                                        </td>


                                        <td>
                                            @if(isset($status_change_amount) && $status_change_amount!=null || isset($in_out_amount) && $in_out_amount !=null)
                                              @if (isset($status_change_amount->partial_amount_status) && $status_change_amount->partial_amount_status=='1' || isset($in_out_amount->partial_amount_status) && $in_out_amount->partial_amount_status=='1')

                                                  <span class="badge badge-info"> Amount Paid
                                                       @if(isset($status_change_amount->status_change_amount) && $status_change_amount->status_change_amount )
                                                            @else
                                                                {{$in_out_amount->partial_amount}}
                                                                   @endif
                                                    </span>

                                           <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$status_change_amount->partial_amount_to_be->step_name}} </strong>

                                             @elseif(isset($status_change_amount->status_change_amount) && $status_change_amount->partial_amount_status == '2'
                                                    || isset($in_out_amount->partial_amount_status) && $in_out_amount->partial_amount_status == '2')
                                <span class="badge badge-info"> Amount Paid @if(isset($status_change_amount->status_change_amount) && $status_change_amount->status_change_amount )
                                        @else {{$in_out_amount->partial_amount}}  @endif</span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                            @elseif (isset($status_change_amount->pay_status) && $status_change_amount->pay_status=='1' || isset($in_out_amount->pay_status) && $in_out_amount->pay_status=='1' )
                                            <span class="badge badge-success"> Paid  </span>
                                             @elseif (isset($status_change_amount->pay_status)&&$status_change_amount->pay_status=='2' ||  isset($in_out_amount->pay_status)&&$in_out_amount->pay_status=='2'  )
                                                    @if (isset($status_change_amount->unpaid_status) && $status_change_amount->unpaid_status=='1' ||  isset($in_out_amount->unpaid_status) && $in_out_amount->unpaid_status=='1')
                                                      <span class="badge badge-success"> Will be paid at

                                                        @if ( $status_change_amount !=null)
                                                        {{$status_change_amount->pay_later->step_name}}
                                                        @else
                                                          {{$status_change_amount->pay_later->step_name}}
                                                        @endif
                                                        </span>
                                                      @else
                                                      <span class="badge badge-info"> Payroll Deduction </span>
                                                    @endif
                                        @else
                                        <span class="badge badge-danger"> Unpaid  </span>
                                        @endif
                                            @else
                                             @endif
                                        </td>
                                        <td>
                                            @if($status_change_amount==null || $in_out_amount==null)
                                             @else
                                             @if($status_change_amount->remarks == null)  @else {{$status_change_amount->remarks}} @endif
                                             @if($in_out_amount->remarks == null)  @else {{$in_out_amount->remarks}} @endif

                                             @endif</td>
                                    <td>


                                        <button @if( ($next_status_id<'8') ||   isset($status_change_amount) && $status_change_amount->pay_status == null ||  isset($in_out_amount) && $in_out_amount->pay_status == null)  disabled @endif
                                            @if(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id=='6' &&  $stop_resume_print_inside_out_side->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '6' || $cancel_between->visa_process_id >'6')
                                         @else
                                         disabled
                                         @endif

                                         @endif
                                         @if($req != null && $status_change== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="statusChangeStartProcess({{$passport_id}})" type="button">

                                        @if( ($status_change==null || $in_out_change ==null) &&  ($next_status_id=='8' || $next_status_id=='9' ) )
                                        Start Process
                                         @elseif( ($status_change==null || $in_out_change == null) &&  ($next_status_id <'8') || $next_status_id=='29' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($status_change == null && $in_out_change == null  && !isset($stop_resume_status_change) && !isset($stop_resume_in_out_change))
                                                  disabled
                                                  @endif



                                                  @if($med_normal != null && $status_change != null && !isset($stop_resume_status_change))  disabled @endif




                                                  @if(isset($stop_resume_status_change) && $stop_resume_status_change->visa_process_step_id=='7' &&  $stop_resume_status_change->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_status_change) && $stop_resume_status_change->visa_process_step_id=='7' &&  $stop_resume_status_change->status=='1')
                                                  class="btn btn-success btn-sm btn-start"

                                                  @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->visa_process_step_id=='8' &&  $stop_resume_in_out_change->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->visa_process_step_id=='8' &&  $stop_resume_in_out_change->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'7')" type="button">
                                                  @if(isset($stop_resume_status_change) && $stop_resume_status_change->visa_process_step_id=='7'  &&  $stop_resume_status_change->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_status_change) && $stop_resume_status_change->visa_process_step_id=='7'  &&  $stop_resume_status_change->status=='1')
                                                   Resume
                                                   @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->visa_process_step_id=='8'  &&  $stop_resume_in_out_change->status=='2')
                                                   View
                                                   @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->visa_process_step_id=='8'  &&  $stop_resume_in_out_change->status=='1')
                                                    Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>




                                                </td>

                                                <td>


                                                  {{-- replacement_in_out_change --}}
                                                  @if(isset($stop_resume_status_change))
                                                    <button
                                                    @if(!isset($stop_resume_status_change) ) style="display: none"

                                                    @else
                                                    @endif
                                                    @if(isset($stop_resume_status_change) && $stop_resume_status_change->status =='2' &&  $replacement_status_change==null) disabled
                                                    @elseif(isset($stop_resume_status_change) && $stop_resume_status_change->status =='2' &&  $replacement_status_change==null) disabled
                                                    @elseif(isset($stop_resume_status_change) && $stop_resume_status_change->status =='1')
                                                    @elseif(isset($stop_resume_status_change) && $stop_resume_status_change->status =='1' &&  $replacement_status_change != null )
                                                    @else
                                                    @endif
                                                    onclick="VisaProcessReplacement({{$passport_id}},'7')" type="button"
                                                    class="btn btn-warning btn-sm btn-start">
                                                    Replacement
                                                    </button>
                                                    @elseif(isset($stop_resume_in_out_change))
                                                </td>
                                                <td>
                                                    <button
                                                    @if(!isset($stop_resume_in_out_change) ) style="display: none"

                                                    @else
                                                    @endif
                                                    @if(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->status =='2' &&  $replacement_in_out_change==null) disabled
                                                    @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->status =='2' &&  $replacement_in_out_change==null) disabled
                                                    @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->status =='1')
                                                    @elseif(isset($stop_resume_in_out_change) && $stop_resume_in_out_change->status =='1' &&  $replacement_in_out_change != null )
                                                    @else
                                                    @endif
                                                    onclick="VisaProcessReplacement({{$passport_id}},'8')" type="button"
                                                    class="btn btn-warning btn-sm btn-start">
                                                    Replacement
                                                    </button>
                                                    @else

                                                    @endif

                                    </td>
                                     {{-- cancel-visa --}}
                                <td>


                                    {{-- <button
                                    @if($status_change != null || $in_out_amount!=null)  disabled   @endif
                                    @if($electronic_pre_approval_pay == null)  disabled   @endif
                                    @if($print_inside_out_side == null)  disabled   @endif
                                    @if(isset($print_inside_out_side_amount) && $print_inside_out_side_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    data-toggle="modal" data-target=".bd-example-modal-sm"
                                    onclick="VisaProcessCancelBetween({{$passport_id}},'6')" type="button">
                                   Cancel
                                    </button> --}}

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($med_normal!=null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($print_inside_out_side == null )  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($status_change == null && $in_out_change==null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($status_change_amount) && $status_change_amount->pay_status == null  )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    target="_blank"

                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>

                                 </tr>
                                 {{-- process 7 --}}


                                 {{-- process 8 --}}


                                 <tr>
                                    <td>8</td>
                                    <td>Medical</td>
                                    <td>@if($med_normal!=null || $med_48 !=null  || $med_24 !=null  || $med_vip !=null)
                                        <span class="badge badge-success"> Completed @else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>
                                        @if($med_normal_amount==null && $med_48_amount ==null && $med_24_amount ==null && $med_vip_amount ==null) @else
                                        @if($med_normal_amount!=null) {{isset($med_normal_amount->amount)?$med_normal_amount->amount:'0'}}
                                        @elseif($med_48_amount!=null) {{isset($med_48_amount->amount)?$med_48_amount->amount:'0'}}
                                        @elseif($med_24_amount!=null) {{isset($med_24_amount->amount)?$med_24_amount->amount:'0'}}
                                        @else

                                        {{$med_vip_amount->amount}}
                                        @endif
                                         @endif
                                        </td>


                                        <td>
                                            @if($med_normal_amount!=null || $med_48_amount !=null || $med_24_amount !=null || $med_vip_amount !=null)

                                            @if (isset($med_normal_amount->partial_amount_status) && $med_normal_amount->partial_amount_status=='1'||
                                            isset($med_48_amount->partial_amount_status) && $med_48_amount->partial_amount_status=='1'||
                                            isset($med_24_amount->partial_amount_status) && $med_24_amount->partial_amount_status=='1'||
                                            isset($med_vip_amount->partial_amount_status) && $med_vip_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid

                                    @if (isset($med_normal_amount->partial_amount_status))
                                   {{$med_normal_amount->partial_amount}}

                                    @elseif (isset($med_48_amount->partial_amount_status))
                                    {{$med_48_amount->partial_amount }}


                                    @elseif (isset($med_24_amount->partial_amount_status))
                                    {{$med_24_amount->partial_amount}}


                                    @elseif (isset($med_vip_amount->partial_amount_status))
                                    {{$med_vip_amount->partial_amount}}
                                    @endif

                                     </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong>

                                    @if (isset($med_normal_amount->partial_amount_status))
                                    {{$med_normal_amount->partial_amount_to_be}}

                                     @elseif (isset($med_48_amount->partial_amount_to_be))
                                     {{$med_48_amount->partial_amount }}


                                     @elseif (isset($med_24_amount->partial_amount_to_be))
                                     {{$med_24_amount->partial_amount}}


                                     @elseif (isset($med_vip_amount->partial_amount_status))
                                     {{$med_vip_amount->partial_amount_to_be}}
                                     @endif


                                    @elseif (isset($med_normal_amount->partial_amount_status) && $med_normal_amount->partial_amount_status=='2'||
                                    isset($med_48_amount->partial_amount_status) && $med_48_amount->partial_amount_status=='2'||
                                    isset($med_24_amount->partial_amount_status) && $med_24_amount->partial_amount_status=='2'||
                                    isset($med_vip_amount->partial_amount_status) && $med_vip_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid

                                    @if (isset($med_normal_amount->partial_amount_status))
                                   {{$med_normal_amount->partial_amount}}

                                    @elseif (isset($med_48_amount->partial_amount_status))
                                    {{$med_48_amount->partial_amount }}


                                    @elseif (isset($med_24_amount->partial_amount_status))
                                    {{$med_24_amount->partial_amount}}


                                    @elseif (isset($med_vip_amount->partial_amount_status))
                                    {{$med_vip_amount->partial_amount}}
                                    @endif

                                     </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                            @elseif (isset($med_normal_amount->pay_status) && $med_normal_amount->pay_status=='1' || isset($med_48_amount->pay_status) && $med_48_amount->pay_status=='1'|| isset($med_24_amount->pay_status) && $med_24_amount->pay_status=='1' || isset($med_vip_amount->pay_status) && $med_vip_amount->pay_status=='1' )
                                            <span class="badge badge-success"> Paid  </span>
                                             @elseif (isset($med_normal_amount->pay_status) && $med_normal_amount->pay_status=='2' || isset($med_48_amount->pay_status) && $med_48_amount->pay_status=='2' || isset($med_24_amount->pay_status) && $med_24_amount->pay_status=='2' || isset( $med_vip_amount->pay_status) && $med_vip_amount->pay_status=='2' )
                                                    @if (isset($med_normal_amount->unpaid_status)&&$med_normal_amount->unpaid_status=='1' || isset($med_48_amount->unpaid_status)&&$med_48_amount->unpaid_status=='1' || isset($med_24_amount->unpaid_status) && $med_24_amount->unpaid_status=='1' || isset($med_24_amount->unpaid_status)&&$med_24_amount->unpaid_status=='1')
                                                      <span class="badge badge-success"> Will be paid at

                                                        @if ($med_normal_amount !=null)
                                                        {{$med_normal_amount->pay_later->step_name}}
                                                        @elseif( $med_48_amount !=null)
                                                        {{$med_48_amount->pay_later->step_name}}
                                                        @elseif( $med_24_amount !=null)
                                                        {{$med_24_amount->pay_later->step_name}}
                                                        @else
                                                          {{$med_vip_amount->pay_later->step_name}}
                                                        @endif
                                                        </span>
                                                      @else
                                                      <span class="badge badge-info"> Payroll Deduction </span>
                                                    @endif
                                        @else
                                        <span class="badge badge-danger"> Unpaid  </span>
                                        @endif
                                            @else
                                             @endif
                                        </td>

                                        <td>
                                            @if($med_normal_amount==null || $med_48_amount==null ||$med_24_amount==null ||$med_vip_amount==null)
                                            @else
                                             @if($med_normal_amount->remarks == null)  @else {{$med_normal_amount->remarks}} @endif
                                             @if($med_48_amount->remarks == null)  @else {{$med_48_amount->remarks}} @endif
                                             @if($med_24_amount->remarks == null)  @else {{$med_24_amount->remarks}} @endif
                                             @if($med_vip_amount->remarks == null)  @else {{$med_vip_amount->remarks}} @endif

                                             @endif
                                            </td>
                                              <td>


                <button
                @if( ($next_status_id<'11') || isset($med_normal_amount) && $med_normal_amount->pay_status == null ||  isset($med_48_amount) && $med_48_amount->pay_status == null  || isset($med_24_amount) && $med_24_amount->pay_status == null   || isset($med_vip_amount) && $med_vip_amount->pay_status == null  )   disabled @endif
                @if(isset($stop_resume_entry_date) && $stop_resume_entry_date->visa_process_step_id=='10' && $stop_resume_entry_date->status=='1')
                disabled
                @endif
                @if ($next_status_id=='29')
                                            disabled
                                            @endif
                @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '11' || $cancel_between->visa_process_id >'11')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $med_normal== null)  disabled   @endif

                class="btn btn-primary btn-sm btn-start" onclick="medStartProcess({{$passport_id}})" type="button">
                                        @if( ($med_normal==null || $med_48 ==null  || $med_24 ==null  || $med_vip ==null) &&
                                        ($next_status_id=='11' || $next_status_id=='12'||$next_status_id=='13'||$next_status_id=='14') )
                                        Start Process
                                         @elseif( ($med_normal==null && $med_48 ==null  && $med_24 ==null  && $med_vip ==null )
                                          &&
                                          ($next_status_id<'11') || $next_status_id=='29')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($med_normal == null && !isset($stop_resume_med_normal))  disabled   @endif

                                                  @if($med_normal != null && $fit_unfit != null && !isset($stop_resume_med_normal))  disabled   @endif
                                                  @if($med_48 != null && $fit_unfit != null  && !isset($stop_resume_med_48))  disabled   @endif
                                                  @if($med_24 != null && $fit_unfit != null && !isset($stop_resume_med_48))  disabled   @endif
                                                  @if($med_vip != null && $fit_unfit != null && !isset($stop_resume_med_48))  disabled   @endif



                                                  @if(isset($stop_resume_print_inside_out_side) && $stop_resume_print_inside_out_side->visa_process_step_id !='6' &&  $stop_resume_print_inside_out_side->status=='2' ) disabled @endif


                                                  @if(isset($stop_resume_med_normal) && $stop_resume_med_normal->visa_process_step_id=='11' &&  $stop_resume_med_normal->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_med_normal) && $stop_resume_med_normal->visa_process_step_id=='11' &&  $stop_resume_med_normal->status=='1')
                                                  class="btn btn-success btn-sm btn-start"

                                                  @elseif(isset($stop_resume_med_48) && $stop_resume_med_48->visa_process_step_id=='12' &&  $stop_resume_med_48->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_med_48) && $stop_resume_med_48->visa_process_step_id=='12' &&  $stop_resume_med_48->status=='1')
                                                  class="btn btn-success btn-sm btn-start"


                                                  @elseif(isset($stop_resume_med_24) && $stop_resume_med_24->visa_process_step_id=='13' &&  $stop_resume_med_24->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_med_24) && $stop_resume_med_24->visa_process_step_id=='13' &&  $stop_resume_med_24->status=='1')
                                                  class="btn btn-success btn-sm btn-start"


                                                  @elseif(isset($stop_resume_med_vip) && $stop_resume_med_vip->visa_process_step_id=='14' &&  $stop_resume_med_vip->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_med_vip) && $stop_resume_med_vip->visa_process_step_id=='14' &&  $stop_resume_med_vip->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else
                                                  class="btn btn-danger btn-sm btn-start"
                                                  @endif


                                                   onclick="VisaProcessStopResume({{$passport_id}},'12')" type="button">


                                                  @if(isset($stop_resume_med_normal) && $stop_resume_med_normal->visa_process_step_id=='11'  &&  $stop_resume_med_normal->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_med_normal) && $stop_resume_med_normal->visa_process_step_id=='11'  &&  $stop_resume_med_normal->status=='1')
                                                   Resume



                                                   @elseif(isset($stop_resume_med_48) && $stop_resume_med_48->visa_process_step_id=='12'  &&  $stop_resume_med_48->status=='2')
                                                   View
                                                   @elseif(isset($stop_resume_med_48) && $stop_resume_med_48->visa_process_step_id=='12'  &&  $stop_resume_med_48->status=='1')
                                                    Resume

                                                    @elseif(isset($stop_resume_med_24) && $stop_resume_med_24->visa_process_step_id=='13'  &&  $stop_resume_med_24->status=='2')
                                                    View
                                                    @elseif(isset($stop_resume_med_24) && $stop_resume_med_24->visa_process_step_id=='13'  &&  $stop_resume_med_24->status=='1')
                                                     Resume

                                                     @elseif(isset($stop_resume_med_vip) && $stop_resume_med_vip->visa_process_step_id=='14'  &&  $stop_resume_med_vip->status=='2')
                                                     View
                                                     @elseif(isset($stop_resume_med_vip) && $stop_resume_med_vip->visa_process_step_id=='14'  &&  $stop_resume_med_vip->status=='1')
                                                      Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}

                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($fit_unfit != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($entry_date == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($med_normal == null && $med_48== null && $med_24 == null && $med_vip == null )  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($med_normal_amount) && $med_normal_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                 </tr>
     {{-- process 9 --}}

                                 <tr>
                                    <td>9</td>
                                    <td>Fit/Unfit</td>
                                    <td>@if($fit_unfit!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($fit_unfit_amount==null) @else {{ isset($fit_unfit_amount->amount)?$fit_unfit_amount->amount:'0'}} @endif</td>





                                    <td>
                                        @if($fit_unfit_amount!=null)
                                        @if (isset($fit_unfit->partial_amount_status) && $fit_unfit->partial_amount_status=='1')


                                <span class="badge badge-info"> Amount Paid {{$fit_unfit->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$fit_unfit->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($fit_unfit->partial_amount_status) && $fit_unfit->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$fit_unfit->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($fit_unfit_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($fit_unfit_amount->pay_status=='2' )
                                                @if ($fit_unfit_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$fit_unfit_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif
                                        @else  @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <button @if( ($next_status_id<'15') ||    isset($fit_unfit_amount) && $fit_unfit_amount->pay_status == null )   disabled @endif
                                            @if(isset($stop_resume_med_normal) && $stop_resume_med_normal->visa_process_step_id=='14' && $stop_resume_med_normal->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '14' || $cancel_between->visa_process_id >'14')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $fit_unfit== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="fitUnfitStartProcess({{$passport_id}})" type="button">
                                         @if($fit_unfit==null && $next_status_id=='15' )
                                         Start Process
                                         @elseif($fit_unfit == null && $next_status_id<'15' || $next_status_id=='29')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($fit_unfit == null && $stop_resume_fit_unfit== null)  disabled   @endif
                                                  @if($fit_unfit != null && $emirates_id_apply != null && !isset($stop_resume_fit_unfit))  disabled   @endif
                                                  @if(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id !='15' ) disabled @endif
                                                  @if(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id=='15' &&  $stop_resume_fit_unfit->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id=='15' &&  $stop_resume_fit_unfit->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'15')" type="button">
                                                  @if(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id=='15' &&  $stop_resume_fit_unfit->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id=='15' &&  $stop_resume_fit_unfit->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>

                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}

                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($emirates_id_apply != null)  style="pointer-events: none; background:#f8857d"   @endif

                                    @if($med_normal==null && $med_48==null  && $med_24==null  && $med_vip==null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($fit_unfit==null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($fit_unfit_amount) && $fit_unfit_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                 </tr>

     {{-- process 10 --}}
                                 <tr>
                                    <td>10</td>
                                    <td>Emirates ID Apply</td>
                                    <td>@if($emirates_id_apply!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($emirates_id_apply_amount==null) @else {{isset($emirates_id_apply_amount->amount)?$emirates_id_apply_amount->amount:'0'}} @endif</td>
                                    <td>
                                        @if($emirates_id_apply_amount!=null)
                                        @if (isset($emirates_id_apply->partial_amount_status) && $emirates_id_apply->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$emirates_id_apply->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$emirates_id_apply->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($emirates_id_apply->partial_amount_status) && $emirates_id_apply->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$emirates_id_apply->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($emirates_id_apply_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($emirates_id_apply_amount->pay_status=='2' )
                                                @if ($emirates_id_apply_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$emirates_id_apply_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                        @else
                                        <span class="badge badge-danger"> Unpaid  </span>
                                       @endif


                                        @else  @endif</td>
                                    <td>@if($emirates_id_apply_amount==null) @else @if($emirates_id_apply_amount->remarks == null)  @else {{$emirates_id_apply_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'16') || isset($emirates_id_apply_amount) && $emirates_id_apply_amount->pay_status == null )   disabled @endif
                                            @if(isset($stop_resume_fit_unfit) && $stop_resume_fit_unfit->visa_process_step_id=='15' && $stop_resume_fit_unfit->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '16' || $cancel_between->visa_process_id >'16' || $next_status_id=='29')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $emirates_id_apply== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="emirateIdApplyStartProcess({{$passport_id}})" type="button">

                                            @if($emirates_id_apply==null && $next_status_id=='16')
                                         Start Process
                                         @elseif($emirates_id_apply == null && $next_status_id<'16'  || $next_status_id=='29')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>

                                                  {{---new button----}}
                                                  <button
                                                  @if($emirates_id_apply == null && !isset($stop_resume_emirates_id_apply))  disabled   @endif
                                                  @if($emirates_id_apply != null && $figer_print != null && !isset($stop_resume_emirates_id_apply))  disabled   @endif
                                                  @if(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id !='16' &&  $stop_resume_emirates_id_apply->status=='2' ) disabled @endif
                                                  @if(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id=='16' &&  $stop_resume_emirates_id_apply->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id=='16' &&  $stop_resume_emirates_id_apply->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'16')" type="button">
                                                  @if(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id=='16' &&  $stop_resume_emirates_id_apply->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id=='16' &&  $stop_resume_emirates_id_apply->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <button
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($figer_print != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($fit_unfit == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($emirates_id_apply == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($emirates_id_apply_amount) && $emirates_id_apply_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                    </button>

                                </td>
                                    </tr>

                                     {{-- process 11 --}}
                                 <tr>
                                    <td>11</td>
                                    <td>Emirates ID Finger Print(Yes/No)</td>

                                    <td>@if($figer_print!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>@if($figer_print_amount==null)@else {{ isset($figer_print_amount->amount)?$figer_print_amount->amount:'0'}} @endif</td>
                                    <td>@if($figer_print_amount!=null)
                                        @if (isset($figer_print->partial_amount_status) && $figer_print->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$figer_print->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$figer_print->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($offer_letter_amount->partial_amount_status) && $figer_print->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$figer_print->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($figer_print_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($figer_print_amount->pay_status=='2' )
                                                @if ($figer_print_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$figer_print_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif
                                        @else  @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <button @if( ($next_status_id<'17') || isset($figer_print_amount) && $figer_print_amount->pay_status == null )  disabled @endif
                                            @if(isset($stop_resume_emirates_id_apply) && $stop_resume_emirates_id_apply->visa_process_step_id=='16' && $stop_resume_emirates_id_apply->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '17' || $cancel_between->visa_process_id >'17' || $next_status_id=='29')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $figer_print== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="fingerPrintStartProcess({{$passport_id}})" type="button">
                                         @if($figer_print==null && $next_status_id=='17' )
                                         Start Process
                                         @elseif($figer_print == null && $next_status_id<'17' || $next_status_id=='29')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($figer_print == null && !isset($stop_resume_figer_print))  disabled   @endif
                                                  @if($figer_print != null && $new_contract != null && !isset($stop_resume_figer_print))  disabled   @endif
                                                  @if(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id !='17' &&  $stop_resume_figer_print->status=='2' ) disabled @endif
                                                  @if(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id=='17' &&  $stop_resume_figer_print->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id=='17' &&  $stop_resume_figer_print->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'17')" type="button">
                                                  @if(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id=='17' &&  $stop_resume_figer_print->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id=='17' &&  $stop_resume_figer_print->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($emirates_id_apply == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($figer_print == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($figer_print_amount) && $figer_print_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                    </tr>

                                     {{-- process 12 --}}
                                     <tr>
                                        <td>12</td>
                                        <td>New Contract Application Typing</td>

                                        <td>@if($new_contract!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>@if($new_contract_amount==null) @else {{isset($new_contract_amount->amount)?$new_contract_amount->amount:'0'}} @endif</td>
                                    <td>@if($new_contract_amount!=null)

                                        @if (isset($new_contract_amount->partial_amount_status) && $new_contract_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$new_contract_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$new_contract_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($new_contract_amount->partial_amount_status) && $new_contract_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$new_contract_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>



                                        @elseif ($new_contract_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($new_contract_amount->pay_status=='2' )
                                                @if ($new_contract_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$new_contract_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                        @else
                                        <span class="badge badge-danger"> Unpaid  </span>
                                       @endif


                                        @else  @endif</td>
                                    <td>@if($new_contract_amount==null) @else @if($new_contract_amount->remarks == null)  @else {{$new_contract_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'18') ||isset($new_contract_amount) && $new_contract_amount->pay_status == null )   disabled @endif
                                            @if(isset($stop_resume_figer_print) && $stop_resume_figer_print->visa_process_step_id=='17' && $stop_resume_figer_print->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '18' || $cancel_between->visa_process_id >'18')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $new_contract== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="newContractStartProcess({{$passport_id}})" type="button">


                                         @if($new_contract==null && $next_status_id=='18' )
                                         Start Process
                                         @elseif($new_contract == null && $next_status_id<'18' || $next_status_id=='29' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>

                                                  {{---new button----}}
                                                  <button
                                                  @if($new_contract == null && !isset($stop_resume_new_contract))  disabled   @endif
                                                  @if($new_contract != null && $tawjeeh != null  && !isset($stop_resume_new_contract))  disabled   @endif
                                                  @if(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id !='18' &&  $stop_resume_new_contract->status=='2' ) disabled @endif
                                                  @if(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id=='18' &&  $stop_resume_new_contract->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id=='18' &&  $stop_resume_new_contract->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'18')" type="button">
                                                  @if(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id=='18' &&  $stop_resume_new_contract->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id=='18' &&  $stop_resume_new_contract->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($tawjeeh != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($figer_print == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($new_contract_amount) && $new_contract_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                        </tr>
                                        {{-- process 13 --}}

                                        <tr>
                                            <td>13</td>
                                            <td>Tawjeeh Class</td>

                                            <td>@if($tawjeeh!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                            <td>@if($tawjeeh_amount==null) @else {{ isset($tawjeeh_amount->amount)?$tawjeeh_amount->amount:'0'}} @endif</td>
                                            <td>@if($tawjeeh_amount!=null)

                                                @if (isset($tawjeeh_amount->partial_amount_status) && $tawjeeh_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$tawjeeh_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$tawjeeh_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($tawjeeh_amount->partial_amount_status) && $tawjeeh_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$tawjeeh_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                                @elseif ($tawjeeh_amount->pay_status=='1' )
                                                <span class="badge badge-success"> Paid  </span>
                                                 @elseif ($tawjeeh_amount->pay_status=='2' )
                                                        @if ($tawjeeh_amount->unpaid_status=='1')
                                                          <span class="badge badge-success"> Will be paid at {{$tawjeeh_amount->pay_later->step_name}}  </span>
                                                          @else
                                                          <span class="badge badge-info"> Payroll Deduction </span>
                                                        @endif
                                            @else
                                            <span class="badge badge-danger"> Unpaid  </span>
                                            @endif
                                                @else  @endif
                                            </td>
                                            <td></td>
                                            <td>
                                                <button @if( ($next_status_id<'19') ||isset($tawjeeh_amount) && $tawjeeh_amount->pay_status == null )  disabled @endif
                                                    @if(isset($stop_resume_new_contract) && $stop_resume_new_contract->visa_process_step_id=='18' && $stop_resume_new_contract->status=='1')
                                                    disabled
                                                    @endif
                                                    @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                                    @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '19' || $cancel_between->visa_process_id >'19')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $tawjeeh== null)  disabled   @endif
                                                    class="btn btn-primary btn-sm btn-start" onclick="tawjeehStartProcess({{$passport_id}})" type="button">

                                                 @if($tawjeeh==null && $next_status_id=='19' )
                                                 Start Process
                                                 @elseif($tawjeeh == null && $next_status_id<'19' || $next_status_id=='29')
                                                 Process Pending
                                                 @else
                                                 View
                                                 @endif
                                             </button>
                                            </td>
                                            <td>
                                                          {{---new button----}}
                                     <button
                                     @if($tawjeeh == null && !isset($stop_resume_tawjeeh))  disabled   @endif
                                     @if($tawjeeh != null && $new_contract_sub != null && !isset($stop_resume_new_contract))  disabled   @endif
                                     @if(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id !='19' &&  $stop_resume_tawjeeh->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id=='19' &&  $stop_resume_tawjeeh->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id=='19' &&  $stop_resume_tawjeeh->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'19')" type="button">
                                     @if(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id=='19' &&  $stop_resume_tawjeeh->status=='2')
                                     View
                                     @elseif(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id=='19' &&  $stop_resume_tawjeeh->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                            </td>
                                            <td>&nbsp;</td>
                                             {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract_sub != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($tawjeeh == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($tawjeeh_amount) && $tawjeeh_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                            </tr>


                                            {{-- process 15 --}}
                                     <tr>
                                        <td>14</td>
                                        <td>New Contract Submission</td>

                                        <td>@if($new_contract_sub!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>@if($new_contract_sub_amount==null) @else {{isset($new_contract_sub_amount->amount)?$new_contract_sub_amount->amount:'0'}} @endif</td>
                                    <td>@if($new_contract_sub_amount!=null)

                                        @if (isset($new_contract_sub_amount->partial_amount_status) && $new_contract_sub_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$new_contract_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$new_contract_sub_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($new_contract_sub_amount->partial_amount_status) && $new_contract_sub_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$new_contract_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($new_contract_sub_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($new_contract_sub_amount->pay_status=='2' )
                                                @if ($new_contract_sub_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$new_contract_sub_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                        @else
                                        <span class="badge badge-danger"> Unpaid  </span>
                                       @endif

                                        @else  @endif</td>
                                    <td>@if($new_contract_sub_amount==null) @else @if($new_contract_sub_amount->remarks == null)  @else {{$new_contract_sub_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'20') || isset($new_contract_sub_amount) && $new_contract_sub_amount->pay_status == null )  disabled @endif
                                            @if(isset($stop_resume_tawjeeh) && $stop_resume_tawjeeh->visa_process_step_id=='19' && $stop_resume_tawjeeh->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '20' || $cancel_between->visa_process_id >'20' )
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $new_contract_sub== null)  disabled   @endif
                                            class="btn btn-primary btn-sm btn-start" onclick="new_contract_subStartProcess({{$passport_id}})" type="button">

                                         @if($new_contract_sub ==null && $next_status_id=='20' )
                                         Start Process
                                         @elseif($new_contract_sub == null && $next_status_id<'20' || $next_status_id=='29')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button>
                                    </td>
                                    <td>
                                                  {{---new button----}}
                                                  <button
                                                  @if($new_contract_sub == null && !isset($stop_resume_new_contract_sub))  disabled   @endif
                                                  @if($new_contract_sub != null && $labour_card != null && !isset($stop_resume_new_contract))  disabled   @endif
                                                  @if(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id !='20' &&  $stop_resume_new_contract_sub->status=='2' ) disabled @endif
                                                  @if(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id=='20' &&  $stop_resume_new_contract_sub->status=='2')
                                                  class="btn btn-info btn-sm btn-start"
                                                  @elseif(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id=='20' &&  $stop_resume_new_contract_sub->status=='1')
                                                  class="btn btn-success btn-sm btn-start"
                                                  @else class="btn btn-danger btn-sm btn-start"
                                                  @endif
                                                   onclick="VisaProcessStopResume({{$passport_id}},'20')" type="button">
                                                  @if(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id=='20' &&  $stop_resume_new_contract_sub->status=='2')
                                                  View
                                                  @elseif(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id=='20' &&  $stop_resume_new_contract_sub->status=='1')
                                                   Resume
                                                  @else
                                                  Stop
                                                  @endif
                                                  </button>
                                    </td>
                                    <td> &nbsp;</td>
                                     {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($labour_card != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($tawjeeh == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract_sub == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($new_contract_sub_amount) && $new_contract_sub_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                        </tr>


                                        <tr>
                                            <td>15</td>
                                            <td>Labour Card Print</td>

                                            <td>@if($labour_card!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                        <td>@if($labour_card_amount==null) @else {{isset($labour_card_amount->amount)?$labour_card_amount->amount:'0'}} @endif</td>
                                        <td>@if($labour_card_amount!=null)
                                            @if (isset($offer_letter_amount->partial_amount_status) && $offer_letter_amount->partial_amount_status=='1')

                                        </span>
                                        <span class="badge badge-info"> Amount Paid {{$labour_card_amount->partial_amount}}  </span>
                                        <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$labour_card_amount->partial_amount_to_be->step_name}} </strong>

                                        @elseif (isset($labour_card_amount->partial_amount_status) && $labour_card_amount->partial_amount_status=='2')


                                        <span class="badge badge-info"> Amount Paid {{$labour_card_amount->partial_amount}}  </span>
                                        <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                            @elseif ($labour_card_amount->pay_status=='1' )
                                            <span class="badge badge-success"> Paid  </span>
                                             @elseif ($labour_card_amount->pay_status=='2' )
                                                    @if ($labour_card_amount->unpaid_status=='1')
                                                      <span class="badge badge-success"> Will be paid at {{$labour_card_amount->pay_later->step_name}}  </span>
                                                      @else
                                                      <span class="badge badge-info"> Payroll Deduction </span>
                                                    @endif
                                            @else
                                            <span class="badge badge-danger"> Unpaid  </span>
                                           @endif

                                            @else  @endif</td>
                                        <td>@if($labour_card_amount==null) @else @if($labour_card_amount->remarks == null)  @else {{$labour_card_amount->remarks}} @endif @endif</td>
                                        <td>
                                            <button @if( ($next_status_id<'21') || isset($labour_card_amount) && $labour_card_amount->pay_status == null )  disabled @endif
                                                @if(isset($stop_resume_new_contract_sub) && $stop_resume_new_contract_sub->visa_process_step_id=='20' && $stop_resume_new_contract_sub->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '21' || $cancel_between->visa_process_id >'21')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $labour_card== null)  disabled   @endif
                                                class="btn btn-primary btn-sm btn-start" onclick="labourCardStartProcess({{$passport_id}})" type="button">

                                             @if($labour_card==null && $next_status_id=='21')
                                             Start Process
                                             @elseif($labour_card == null && $next_status_id<'21' || $next_status_id=='29')
                                             Process Pending
                                             @else
                                             View
                                             @endif
                                         </button>
                                        </td>
                                                <td>

                                                      {{---new button----}}
                                     <button
                                     @if($labour_card == null && !isset($stop_resume_labour_card))  disabled   @endif
                                     @if($labour_card != null && $visa_stamp != null && !isset($stop_resume_labour_card))  disabled   @endif
                                     @if(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id !='21' &&  $stop_resume_labour_card->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id=='21' &&  $stop_resume_labour_card->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id=='21' &&  $stop_resume_labour_card->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'21')" type="button">
                                     @if(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id=='21' &&  $stop_resume_labour_card->status=='2')
                                     View
                                     @elseif(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id=='21' &&  $stop_resume_labour_card->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                        </td>
                                        <td>&nbsp;</td>
                                         {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($visa_stamp != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($new_contract_sub == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($labour_card == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($labour_card_amount) && $labour_card_amount->pay_status == null )
                                    disabled
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                            </tr>


                                            <tr>
                                                <td>16</td>
                                                <td> Visa Stamping Application(Urgent/Normal)</td>

                                                <td>@if($visa_stamp!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                            <td>@if($visa_stamp_amount==null) @else {{isset($visa_stamp_amount->amount)?$visa_stamp_amount->amount:'0'}} @endif</td>
                                            <td>@if($visa_stamp_amount!=null)
                                                @if (isset($offer_letter_amount->partial_amount_status) && $offer_letter_amount->partial_amount_status=='1')

                                            </span>
                                            <span class="badge badge-info"> Amount Paid {{$visa_stamp_amount->partial_amount}}  </span>
                                            <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$visa_stamp_amount->partial_amount_to_be->step_name}} </strong>

                                            @elseif (isset($visa_stamp_amount->partial_amount_status) && $visa_stamp_amount->partial_amount_status=='2')


                                            <span class="badge badge-info"> Amount Paid {{$visa_stamp_amount->partial_amount}}  </span>
                                            <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                                @elseif ($visa_stamp_amount->pay_status=='1' )
                                                <span class="badge badge-success"> Paid  </span>
                                                 @elseif ($visa_stamp_amount->pay_status=='2' )
                                                        @if ($visa_stamp_amount->unpaid_status=='1')
                                                          <span class="badge badge-success"> Will be paid at {{$visa_stamp_amount->pay_later->step_name}}  </span>
                                                          @else
                                                          <span class="badge badge-info"> Payroll Deduction </span>
                                                        @endif
                                                @else
                                                <span class="badge badge-danger"> Unpaid  </span>
                                               @endif

                                                @else  @endif</td>
                                            <td>@if($visa_stamp_amount==null) @else @if($visa_stamp_amount->remarks == null)  @else {{$visa_stamp_amount->remarks}} @endif @endif</td>
                                            <td>
                                                <button @if( ($next_status_id<'22') || isset($visa_stamp_amount) && $visa_stamp_amount->pay_status == null )  disabled @endif
                                                    @if(isset($stop_resume_labour_card) && $stop_resume_labour_card->visa_process_step_id=='21' && $stop_resume_labour_card->status=='1')
                                            disabled
                                            @endif
                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '22' || $cancel_between->visa_process_id >'22' || $next_status_id=='29')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $visa_stamp== null)  disabled   @endif
                                                    class="btn btn-primary btn-sm btn-start" onclick="visaStampStartProcess({{$passport_id}})" type="button">

                                                 @if($visa_stamp==null && $next_status_id=='22')
                                                 Start Process
                                                 @elseif($visa_stamp == null && $next_status_id<'22' || $next_status_id=='29')
                                                 Process Pending
                                                 @else
                                                 View
                                                 @endif
                                             </button>

                                            </td>
                                            <td>             {{---new button----}}
                                     <button
                                     @if($visa_stamp == null && !isset($stop_resume_visa_stamp))  disabled   @endif
                                     @if($visa_stamp != null && $waiting != null && !isset($stop_resume_visa_stamp))  disabled   @endif
                                     @if(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id !='22' &&  $stop_resume_visa_stamp->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id=='22' &&  $stop_resume_visa_stamp->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id=='22' &&  $stop_resume_visa_stamp->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'22')" type="button">
                                     @if(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id=='22' &&  $stop_resume_visa_stamp->status=='2')
                                     View
                                     @elseif(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id=='22' &&  $stop_resume_visa_stamp->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                            </td>
                                            <td> &nbsp;</td>
                                             {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($waiting != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($labour_card == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($visa_stamp == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($visa_stamp_amount) && $visa_stamp_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                                </tr>


                                                <tr>
                                                    <td>17</td>
                                                    <td>Waiting For Approval(Urgent/Normal)</td>

                                                    <td>@if($waiting!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                                    <td>@if($waiting_amount==null) @else {{ isset($waiting_amount->amount)?$waiting_amount->amount:'0'}} @endif</td>
                                                    <td>@if($waiting_amount!=null)
                                                        @if (isset($waiting_amount->partial_amount_status) && $waiting_amount->partial_amount_status=='1')

                                                    </span>
                                                    <span class="badge badge-info"> Amount Paid {{$waiting_amount->partial_amount}}  </span>
                                                    <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$waiting_amount->partial_amount_to_be->step_name}} </strong>

                                                    @elseif (isset($waiting_amount->partial_amount_status) && $waiting_amount->partial_amount_status=='2')


                                                    <span class="badge badge-info"> Amount Paid {{$waiting_amount->partial_amount}}  </span>
                                                    <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                                        @elseif ($waiting_amount->pay_status=='1' )
                                                        <span class="badge badge-success"> Paid  </span>
                                                         @elseif ($waiting_amount->pay_status=='2' )
                                                                @if ($waiting_amount->unpaid_status=='1')
                                                                  <span class="badge badge-success"> Will be paid at {{$waiting_amount->pay_later->step_name}}  </span>
                                                                  @else
                                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                                @endif
                                                    @else
                                                    <span class="badge badge-danger"> Unpaid  </span>
                                                    @endif
                                                        @else  @endif
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <button @if( ($next_status_id<'23') || isset($waiting_amount) && $waiting_amount->pay_status == null )  disabled @endif
                                                            @if(isset($stop_resume_visa_stamp) && $stop_resume_visa_stamp->visa_process_step_id=='22' && $stop_resume_visa_stamp->status=='1')
                                                            disabled
                                                            @endif
                                                            @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                                            @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '23' || $cancel_between->visa_process_id >'23')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $waiting== null)  disabled   @endif
                                                            class="btn btn-primary btn-sm btn-start" onclick="waitingStartProcess({{$passport_id}})" type="button">

                                                         @if($waiting==null && $next_status_id=='23')
                                                         Start Process
                                                         @elseif($waiting == null && $next_status_id<'23' || $next_status_id=='29')
                                                         Process Pending
                                                         @else
                                                         View
                                                         @endif
                                                     </button>
                                                    </td>
                                                    <td>
                                                                  {{---new button----}}
                                     <button
                                     @if($waiting == null && !isset($stop_resume_waiting))  disabled   @endif
                                     @if($waiting != null && $zajeel != null && !isset($stop_resume_waiting))  disabled   @endif
                                     @if(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id !='23' &&  $stop_resume_waiting->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id=='23' &&  $stop_resume_waiting->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id=='23' &&  $stop_resume_waiting->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'23')" type="button">
                                     @if(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id=='23' &&  $stop_resume_waiting->status=='2')
                                     View
                                     @elseif(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id=='23' &&  $stop_resume_waiting->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>

                                                    </td>
                                                    <td> &nbsp;</td>
                                                     {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($zajeel != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($visa_stamp == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($waiting == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($waiting_amount) && $waiting_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                                    </tr>


                                                    <tr>
                                                        <td>18</td>
                                                        <td>Passport Receive & Handover To Zajeel</td>

                                                        <td>@if($zajeel!=null) <span class="badge badge-success"> Completed </span> @elseif(isset($visa_stamp) &&  $visa_stamp->types=='1') <span class="badge badge-warning"> Skipped</span> @else <span class="badge badge-danger"> Pending </span> @endif</td>
                                                        <td>@if($zajeel_amount==null) @else {{ isset($zajeel_amount->amount)?$zajeel_amount->amount:'0'}} @endif</td>
                                                        <td>@if($zajeel_amount!=null)

                                                            @if (isset($zajeel_amount->partial_amount_status) && $zajeel_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$zajeel_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$zajeel_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($zajeel_amount->partial_amount_status) && $zajeel_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$zajeel_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                                            @elseif ($zajeel_amount->pay_status=='1' )
                                                            <span class="badge badge-success"> Paid  </span>
                                                             @elseif ($zajeel_amount->pay_status=='2' )
                                                                    @if ($zajeel_amount->unpaid_status=='1')
                                                                      <span class="badge badge-success"> Will be paid at {{$zajeel_amount->pay_later->step_name}}  </span>
                                                                      @else
                                                                      <span class="badge badge-info"> Payroll Deduction </span>
                                                                    @endif
                                                        @else
                                                        <span class="badge badge-danger"> Unpaid  </span>
                                                        @endif
                                                            @else  @endif
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <button @if( ($next_status_id<'24') ||  isset($zajeel_amount) && $zajeel_amount->pay_status == null )  disabled @endif
                                                                @if(isset($stop_resume_waiting) && $stop_resume_waiting->visa_process_step_id=='23' && $stop_resume_waiting->status=='1')
                                                                    disabled
                                                                    @endif
                                                                    @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                                                    @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '24' || $cancel_between->visa_process_id >'24')
                                         @else
                                         disabled
                                         @endif

                                         @endif
                                         @if($req != null && $zajeel== null)  disabled   @endif

                                         @if (isset($visa_stamp) && $visa_stamp->types=='1')
                                            disabled
                                         @endif
                                                                class="btn btn-primary btn-sm btn-start" onclick="zajeelStartProcess({{$passport_id}})" type="button">

                                                             @if($zajeel==null && $next_status_id=='24')
                                                             Start Process
                                                             @elseif($zajeel == null && $next_status_id<'24' || $next_status_id=='29' )
                                                             Process Pending
                                                             @elseif(isset($visa_stamp) &&  $visa_stamp->types=='1')
                                                             Skipped
                                                             @else
                                                             View
                                                             @endif
                                                         </button>

                                                        </td>
                                                        <td>                    {{---new button----}}
                                     <button
                                     @if($zajeel == null && !isset($stop_resume_zajeel))  disabled   @endif
                                     @if($zajeel != null && $visa_pasted != null && !isset($stop_resume_zajeel))  disabled   @endif
                                     @if(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id !='24' &&  $stop_resume_zajeel->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id=='24' &&  $stop_resume_zajeel->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id=='24' &&  $stop_resume_zajeel->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'24')" type="button">
                                     @if(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id=='24' &&  $stop_resume_zajeel->status=='2')
                                     View
                                     @elseif(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id=='24' &&  $stop_resume_zajeel->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                                        </td>
                                                        <td> &nbsp;</td>
                                                         {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($visa_pasted != null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($waiting == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($zajeel == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($zajeel_amount) && $zajeel_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                                        </tr>


                                                        <tr>
                                                            <td>19</td>
                                                            <td>Visa Pasted</td>

                                                            <td>@if($visa_pasted!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                                            <td>@if($visa_pasted_amount==null) @else {{ isset($visa_pasted_amount->amount)?$visa_pasted_amount->amount:'0'}} @endif</td>
                                                            <td>@if($visa_pasted_amount!=null)

                                                                @if (isset($visa_pasted_amount->partial_amount_status) && $visa_pasted_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$visa_pasted_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$visa_pasted_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($visa_pasted_amount->partial_amount_status) && $visa_pasted_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$visa_pasted_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                                                @elseif ($visa_pasted_amount->pay_status=='1' )
                                                                <span class="badge badge-success"> Paid  </span>
                                                                 @elseif ($visa_pasted_amount->pay_status=='2' )
                                                                        @if ($visa_pasted_amount->unpaid_status=='1')
                                                                          <span class="badge badge-success"> Will be paid at {{$visa_pasted_amount->pay_later->step_name}}  </span>
                                                                          @else
                                                                          <span class="badge badge-info"> Payroll Deduction </span>
                                                                        @endif
                                                            @else
                                                            <span class="badge badge-danger"> Unpaid  </span>
                                                            @endif
                                                                @else  @endif
                                                            </td>
                                                            <td></td>
                                                            <td>

                                                            <button
                                                             @if( ($next_status_id<'25') || isset($visa_pasted_amount) && $visa_pasted_amount->pay_status == null )
                                                               disabled
                                                                @endif
                                                            @if(isset($stop_resume_zajeel) && $stop_resume_zajeel->visa_process_step_id=='25' && $stop_resume_zajeel->status=='1')
                                                                disabled
                                                            @endif
                                                            @if ($next_status_id=='29')
                                                              disabled
                                                            @endif
                                                            @if(isset($cancel_between))
                                                            @if($cancel_between->visa_process_id == '25'  || $cancel_between->visa_process_id >'25' )
                                                            @else
                                                            disabled
                                                            @endif
                                                            @endif
                                                            @if($req != null && $visa_pasted== null)  disabled   @endif
                                         {{-- @if($req != null )  disabled   @endif --}}
                                                                    class="btn btn-primary btn-sm btn-start" onclick="visaPastedStartProcess({{$passport_id}})" type="button">

                                                                 @if($visa_pasted==null && $next_status_id=='25')
                                                                 Start Process
                                                                 @elseif($visa_pasted == null && $next_status_id<'25' || $next_status_id=='29')
                                                                 Process Pending
                                                                 @else
                                                                 View
                                                                 @endif
                                                             </button>
                                                            </td>
                                                            <td>

                                                                          {{---new button----}}
                                     <button
                                     @if($visa_pasted == null && !isset($stop_resume_visa_pasted))  disabled   @endif
                                     @if($visa_pasted != null && $unique != null && !isset($stop_resume_visa_pasted))  disabled   @endif
                                     @if(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id !='25' &&  $stop_resume_visa_pasted->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id=='25' &&  $stop_resume_visa_pasted->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id=='25' &&  $stop_resume_visa_pasted->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'25')" type="button">
                                     @if(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id=='25' &&  $stop_resume_visa_pasted->status=='2')
                                     View
                                     @elseif(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id=='25' &&  $stop_resume_visa_pasted->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                                            </td>
                                                            <td> &nbsp;</td>
                                                             {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if($unique != null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if($zajeel == null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if($visa_pasted == null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if(isset($visa_pasted_amount) && $visa_pasted_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>20</td>
                                                                <td>Unique Emirates ID Received</td>
                                                                <td>@if($unique!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                                                <td>@if($unique_amount==null) @else {{ isset($unique_amount->amount)?$unique_amount->amount:'0'}} @endif</td>
                                                                <td>@if($unique_amount!=null)
                                                                    @if (isset($unique_amount->partial_amount_status) && $unique_amount->partial_amount_status=='1')

                                                                </span>
                                                                <span class="badge badge-info"> Amount Paid {{$unique_amount->partial_amount}}  </span>
                                                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$unique_amount->partial_amount_to_be->step_name}} </strong>

                                                                @elseif (isset($unique_amount->partial_amount_status) && $unique_amount->partial_amount_status=='2')


                                                                <span class="badge badge-info"> Amount Paid {{$unique_amount->partial_amount}}  </span>
                                                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                                                    @elseif ($unique_amount->pay_status=='1' )
                                                                    <span class="badge badge-success"> Paid  </span>
                                                                     @elseif ($unique_amount->pay_status=='2' )
                                                                            @if ($unique_amount->unpaid_status=='1')
                                                                              <span class="badge badge-success"> Will be paid at {{$unique_amount->pay_later->step_name}}  </span>
                                                                              @else
                                                                              <span class="badge badge-info"> Payroll Deduction </span>
                                                                            @endif
                                                                @else
                                                                <span class="badge badge-danger"> Unpaid  </span>
                                                                @endif
                                                                    @else  @endif
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <button @if( ($next_status_id<'26') || isset($unique_amount) && $unique_amount->pay_status == null )  disabled @endif
                                                                        @if(isset($stop_resume_visa_pasted) && $stop_resume_visa_pasted->visa_process_step_id=='24' && $stop_resume_visa_pasted->status=='1')
                                                                        disabled
                                                                        @endif
                                                                        @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                                                        @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '24' || $cancel_between->visa_process_id >'24')
                                         @else
                                         disabled
                                         @endif
                                         @endif
                                         @if($req != null && $unique== null)  disabled   @endif
                                                                        class="btn btn-primary btn-sm btn-start" onclick="uniqueStartProcess({{$passport_id}})" type="button">
                                                                     @if($unique==null && $next_status_id=='26')
                                                                     Start Process
                                                                     @elseif($unique == null && $next_status_id<'26' || $next_status_id=='29')
                                                                     Process Pending
                                                                     @else
                                                                     View
                                                                     @endif
                                                                 </button>
                                                                </td>
                                                                <td>

                                                                              {{---new button----}}
                                     <button
                                     @if($unique == null && !isset($stop_resume_unique))  disabled   @endif
                                     @if($unique != null && $unique_id != null && !isset($stop_resume_unique))  disabled   @endif
                                     @if(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id !='26' &&  $stop_resume_unique->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id=='26' &&  $stop_resume_unique->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id=='26' &&  $stop_resume_unique->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'26')" type="button">
                                     @if(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id=='26' &&  $stop_resume_unique->status=='2')
                                     View
                                     @elseif(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id=='26' &&  $stop_resume_unique->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                                                </td >
                                                                <td> &nbsp;</td>
                                                                 {{-- cancel-visa --}}
                                <td>

                                    <a
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"   @endif
                                    @if($unique_id != null)     style="pointer-events: none; background:#f8857d"    @endif
                                    @if($visa_pasted == null)     style="pointer-events: none; background:#f8857d"    @endif
                                    @if($unique == null)    style="pointer-events: none; background:#f8857d"   @endif
                                    @if(isset($unique_amount) && $unique_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                    href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}">
                                   Cancel
                                </a>

                                </td>
                                                                </tr>
                                                                @endhasanyrole

                                                                <?php  $vp_array_cr = ['VisaProcessEmiratesIdHandover','Admin',"VisaProcessManager","VisaProcess"]; ?>
                                                                    @hasanyrole($vp_array_cr)

                                                                <tr>
                                                                    <td>21</td>
                                                                    <td>     Unique Emirates ID Handover</td>
                                                                    <td>@if($unique_id!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                                                    <td>@if($unique_id_amount==null) @else {{ isset($unique_id_amount->amount)?$unique_id_amount->amount:'0'}} @endif</td>
                                                                    <td>@if($unique_id_amount!=null)
                                                                        @if (isset($unique_id_amount->partial_amount_status) && $unique_id_amount->partial_amount_status=='1')

                                                                    </span>
                                                                    <span class="badge badge-info"> Amount Paid {{$unique_id_amount->partial_amount}}  </span>
                                                                    <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$unique_id_amount->partial_amount_to_be->step_name}} </strong>

                                                                    @elseif (isset($unique_id_amount->partial_amount_status) && $unique_id_amount->partial_amount_status=='2')


                                                                    <span class="badge badge-info"> Amount Paid {{$unique_id_amount->partial_amount}}  </span>
                                                                    <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>

                                                                        @elseif ($unique_id_amount->pay_status=='1' )
                                                                        <span class="badge badge-success"> Paid  </span>
                                                                         @elseif ($unique_id_amount->pay_status=='2' )
                                                                                @if ($unique_id_amount->unpaid_status=='1')
                                                                                  <span class="badge badge-success"> Will be paid at {{$unique_id_amount->pay_later->step_name}}  </span>
                                                                                  @else
                                                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                                                @endif
                                                                    @else
                                                                    <span class="badge badge-danger"> Unpaid  </span>
                                                                    @endif
                                                                        @else  @endif
                                                                    </td>
                                                                    <td></td>
                                                                    <td>
                                                                        <button
                                                                         @if( ($next_status_id<'27') || isset($unique_id_amount) && $unique_id_amount->pay_status == null )
                                                                          disabled
                                                                           @endif
                                                                        @if(isset($stop_resume_unique) && $stop_resume_unique->visa_process_step_id=='26' && $stop_resume_unique->status=='1')
                                                                        disabled
                                                                        @if(isset($cancel_between))
                                         @if($cancel_between->visa_process_id == '27' || $cancel_between->visa_process_id >'27')
                                         @else
                                         disabled
                                         @endif
                                         @endif

                                                                        @endif
                                                                        @if($req != null && $unique_id== null)  disabled   @endif
                                                                        @if ($next_status_id=='29')
                                            disabled
                                            @endif
                                                                            class="btn btn-primary btn-sm btn-start" onclick="uniqueIdStartProcess({{$passport_id}})" type="button">
                                                                         @if($unique_id==null && $next_status_id=='27')
                                                                         Start Process
                                                                         @elseif($unique_id == null && $next_status_id<'27' || $next_status_id=='29' )
                                                                         Process Pending
                                                                         @else
                                                                         View
                                                                         @endif
                                                                     </button>
                                                                    </td>
                                                                    <td>
                                                                                  {{---new button----}}
                                     <button
                                     disabled
                                     @if($unique_id == null && !isset($stop_resume_unique_id))  disabled   @endif
                                     {{-- @if($unique_id != null && $stop_resume_unique_id== null)  disabled   @endif --}}
                                     @if(isset($stop_resume_unique_id) && $stop_resume_unique_id->visa_process_step_id !='27' &&  $stop_resume_unique_id->status=='2' ) disabled @endif
                                     @if(isset($stop_resume_unique_id) && $stop_resume_unique_id->visa_process_step_id=='27' &&  $stop_resume_unique_id->status=='2')
                                     class="btn btn-info btn-sm btn-start"
                                     @elseif(isset($stop_resume_unique_id) && $stop_resume_unique_id->visa_process_step_id=='27' &&  $stop_resume_unique_id->status=='1')
                                     class="btn btn-success btn-sm btn-start"
                                     @else class="btn btn-danger btn-sm btn-start"
                                     @endif
                                      onclick="VisaProcessStopResume({{$passport_id}},'27')" type="button">
                                     @if(isset($stop_resume_unique_id) && $stop_resume_unique_id->visa_process_step_id=='27' &&  $stop_resume_unique_id->status=='2')
                                     View
                                     @elseif(isset($stop_resume_unique_id) && $stop_resume_unique_id->visa_process_step_id=='27' &&  $stop_resume_unique_id->status=='1')
                                      Resume
                                     @else
                                     Stop
                                     @endif
                                     </button>
                                    </td>
                                     <td> &nbsp;</td>
                                      {{-- cancel-visa --}}
                                <td>

                                    <a
                                     @if($unique != null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if($unique_id == null)  style="pointer-events: none; background:#f8857d"     @endif
                                    @if(isset($unique_id_amount) && $unique_id_amount->pay_status == null )
                                    style="pointer-events: none; background:#f8857d"
                                    @endif
                                    @if($req == null)  style="pointer-events: none; background:#f8857d"     @endif
                                    class="btn btn-danger btn-sm btn-start btn-cancel"
                                     href="{{ url('cancel_visa') }}?passport_id={{ $passport_no }}" target="_blank">Cancel</a>

                                </td>

                                    </tr>
                                    @endhasanyrole

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
            <div class="col-md-1"></div>
        </div>
</div>
@endif

{{-- @endif --}}

<div class="modal fade bd-example-modal-sm-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="complete" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">By Pass Visa Process</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                                <div>
                                    Are you sure want to "<strong>by pass</strong> the visa Process?
                                </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="bypass_Submit()">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>







