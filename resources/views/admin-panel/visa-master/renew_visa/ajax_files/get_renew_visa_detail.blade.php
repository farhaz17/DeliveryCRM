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




            </div>
        </div>

    </div>
    <div class="col-md-2"> </div>
    <div class="col-md-12">
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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- offer letter process 1 --}}
                            <tr>
                               <td>1</td>
                               <td>Renew Contract Typing</td>
                               <td>@if($renewal_contract_typing!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                               <td>@if($renewal_contract_typing_amount==null)@else {{isset($renewal_contract_typing_amount->amount)?$renewal_contract_typing_amount->amount:"0"}} @endif</td>
                               <td>
                                @if($renewal_contract_typing_amount!=null)

                                @if (isset($renewal_contract_typing_amount->partial_amount_status) && $renewal_contract_typing_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$renewal_contract_typing_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$renewal_contract_typing_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($renewal_contract_typing_amount->partial_amount_status) && $renewal_contract_typing_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$renewal_contract_typing_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>




                                @elseif ($renewal_contract_typing_amount->pay_status=='1' )
                                    <span class="badge badge-success"> Paid  </span>
                                @elseif ($renewal_contract_typing_amount->pay_status=='2' )
                                            @if ($renewal_contract_typing_amount->unpaid_status=='1')
                                              <span class="badge badge-success"> Will be paid at {{$renewal_contract_typing_amount->pay_later->step_name}}  </span>
                                              @else
                                              <span class="badge badge-info"> Payroll Deduction </span>
                                            @endif
                                @else
                                <span class="badge badge-danger"> Unpaid  </span>
                                @endif
                                @else
                                @endif
                            </td>
                               <td>@if($renewal_contract_typing_amount==null) @else @if($renewal_contract_typing_amount->remarks == null)  @else {{$renewal_contract_typing_amount->remarks}} @endif @endif</td>
                               <td>

                                <button @if(isset($renewal_contract_typing_amount) && $renewal_contract_typing_amount->pay_status == null  )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="contractTyping({{$passport_id}})" type="button">
                                    @if($renewal_contract_typing==null &&  $next_status_id=='1')
                                    Start Process

                                    @else
                                    View
                                    @endif
                                </button></td>
                            </tr>

                                {{-- offer letter submission process 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td>Renewal Contract Submission</td>
                                    <td>@if($renewal_contract_sub!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($renewal_contract_sub_amount==null) @else @if($renewal_contract_sub_amount->amount==null) Pending @else  {{$renewal_contract_sub_amount->amount}}  @endif @endif</td>
                                    <td>@if($renewal_contract_sub_amount!=null)


                                        @if (isset($renewal_contract_sub_amount->partial_amount_status) && $renewal_contract_sub_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$renewal_contract_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$renewal_contract_sub_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($renewal_contract_sub_amount->partial_amount_status) && $renewal_contract_sub_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$renewal_contract_sub_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($renewal_contract_sub_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                          @elseif ($renewal_contract_sub_amount->pay_status=='2' )
                                                @if ($renewal_contract_sub_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$renewal_contract_sub_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else

                                         @endif</td>
                                    <td>@if($renewal_contract_sub_amount==null) @else @if($renewal_contract_sub_amount->remarks == null)  @else {{$renewal_contract_sub_amount->remarks}} @endif @endif</td>
                                    <td>
                                     <button @if( ($next_status_id<'2') || isset($renewal_contract_sub_amount) && $renewal_contract_sub_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="contract_submission({{$passport_id}})" type="button">
                                        @if( $renewal_contract_sub == null && $next_status_id=='2' )
                                         Start Process
                                         @elseif($renewal_contract_sub == null && $next_status_id<'2' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>

                                   {{-- Electronic Pre Approval process 3 --}}

                                   <tr>
                                    <td>3</td>
                                    <td>Medical</td>
                                    <td>@if($medical!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($medical_amount==null) @else {{isset( $medical_amount->amount)? $medical_amount->amount:'0'}} @endif</td>
                                    <td>
                                        @if($medical_amount!=null)
                                        @if (isset($medical_amount->partial_amount_status) && $medical_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$medical_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$medical_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($medical_amount->partial_amount_status) && $medical_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$medical_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($medical_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                    @elseif ($medical_amount->pay_status=='2' )
                                                @if ($medical_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$medical_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                         @else  @endif</td>
                                    <td>@if($medical_amount==null) @else @if($medical_amount->remarks == null)  @else {{$medical_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'3') ||  isset($medical_amount) && $medical_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="medical({{$passport_id}})" type="button">

                                            @if($medical==null && $next_status_id=='3')
                                         Start Process
                                         @elseif($medical == null && $next_status_id<'3' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>
                            {{-- Electronic Pre Approval payment process 4 --}}
                                 <tr>
                                    <td>4</td>
                                    <td>Emirates ID Apply</td>
                                    <td>@if($emirates_id_apply!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($emirates_id_apply_amount==null) @else {{isset( $emirates_id_apply_amount->amount)? $emirates_id_apply_amount->amount:'0'}} @endif</td>
                                    <td>@if($emirates_id_apply_amount!=null)

                                        @if (isset($emirates_id_apply_amount->partial_amount_status) && $emirates_id_apply_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$emirates_id_apply_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$emirates_id_apply_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($emirates_id_apply_amount->partial_amount_status) && $emirates_id_apply_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$emirates_id_apply_amount->partial_amount}}  </span>
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
                                        <button @if( ($next_status_id<'4') ||  isset($emirates_id_apply_amount) && $emirates_id_apply_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="emiratesIdApply({{$passport_id}})" type="button">


                                         @if($emirates_id_apply==null && $next_status_id=='4')
                                         Start Process
                                         @elseif($emirates_id_apply == null && $next_status_id<'4' )
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>
                                   {{-- Print Visa Inside/Outside process 6 --}}
                                   <tr>
                                    <td>5</td>
                                    <td>Visa Staming</td>
                                    <td>@if($visa_stamping!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($visa_stamping_amount==null) @else {{isset($visa_stamping_amount->amount)?$visa_stamping_amount->amount:'0'}} @endif</td>
                                    <td>@if($visa_stamping_amount!=null)

                                        @if (isset($visa_stamping_amount->partial_amount_status) && $visa_stamping_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$visa_stamping_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$visa_stamping_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($visa_stamping_amount->partial_amount_status) && $visa_stamping_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$visa_stamping_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($visa_stamping_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($visa_stamping_amount->pay_status=='2' )
                                                @if ($visa_stamping_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$visa_stamping_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif
                                        @else  @endif</td>
                                    <td>@if($visa_stamping_amount==null) @else @if($visa_stamping_amount->remarks == null)  @else {{$visa_stamping_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'5') || isset($visa_stamping_amount) && $visa_stamping_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="visaStamping({{$passport_id}})" type="button">

                                         @if($visa_stamping==null && $next_status_id=='5' )
                                         Start Process
                                         @elseif($visa_stamping == null && $next_status_id<'5')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>

                        {{-- process 6 --}}
                                 <tr>
                                    <td>6</td>
                                    <td>Renew Visa Pasting</td>
                                    <td>@if($emirates_id_typing!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($emirates_id_typing==null) @else {{ isset($emirates_id_typing->amount)?$emirates_id_typing->amount:''}} @endif</td>
                                    <td>
                                        @if($emirates_id_typing_amount!=null)

                                        @if (isset($emirates_id_typing_amount->partial_amount_status) && $emirates_id_typing_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$emirates_id_typing_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$emirates_id_typing_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($emirates_id_typing_amount->partial_amount_status) && $emirates_id_typing_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$emirates_id_typing_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($emirates_id_typing_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($emirates_id_typing_amount->pay_status=='2' )
                                                @if ($emirates_id_typing_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$emirates_id_typing_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else  @endif</td>
                                    <td>@if($emirates_id_typing_amount==null) @else @if($emirates_id_typing_amount->remarks == null)  @else {{$emirates_id_typing_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'6') ||  isset($emirates_id_typing_amount) && $emirates_id_typing_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="visaPasting({{$passport_id}})" type="button">

                                         @if($emirates_id_typing==null && $next_status_id=='6')
                                         Start Process
                                         @elseif($emirates_id_typing == null && $next_status_id<'6')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>
                                 {{-- process 7 --}}


                                 <tr>
                                    <td>7</td>
                                    <td>Emirates ID Receive</td>
                                    <td>@if($emirates_id_rec!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($emirates_id_rec_amount==null) @else {{ isset($emirates_id_rec_amount->amount)?$emirates_id_rec_amount->amount:'0'}} @endif</td>
                                    <td>
                                        @if($emirates_id_rec_amount!=null)

                                        @if (isset($emirates_id_rec_amount->partial_amount_status) && $emirates_id_rec_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$emirates_id_rec_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$emirates_id_rec_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($emirates_id_rec_amount->partial_amount_status) && $emirates_id_rec_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$emirates_id_rec_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($emirates_id_rec_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($emirates_id_rec_amount->pay_status=='2' )
                                                @if ($emirates_id_rec_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$emirates_id_rec_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else  @endif</td>
                                    <td>@if($emirates_id_rec_amount==null) @else @if($emirates_id_rec_amount->remarks == null)  @else {{$emirates_id_rec_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'7') ||  isset($emirates_id_rec_amount) && $emirates_id_rec_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="emiratesIDreceive({{$passport_id}})" type="button">

                                         @if($emirates_id_rec==null && $next_status_id=='7')
                                         Start Process
                                         @elseif($emirates_id_rec_amount == null && $next_status_id<'7')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>

{{-- emirates id handover --}}
                                 <tr>
                                    <td>8</td>
                                    <td>Emirates ID Handover</td>
                                    <td>@if($emirates_id_handover!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>@if($emirates_id_handover_amount==null) @else {{ isset($emirates_id_handover_amount->amount)?$emirates_id_handover_amount->amount:'0'}} @endif</td>
                                    <td>
                                        @if($emirates_id_typing_amount!=null)

                                        @if (isset($emirates_id_handover_amount->partial_amount_status) && $emirates_id_handover_amount->partial_amount_status=='1')

                                </span>
                                <span class="badge badge-info"> Amount Paid {{$emirates_id_handover_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> Remaining Amount be paid at <strong> {{$emirates_id_handover_amount->partial_amount_to_be->step_name}} </strong>

                                @elseif (isset($emirates_id_handover_amount->partial_amount_status) && $emirates_id_handover_amount->partial_amount_status=='2')


                                <span class="badge badge-info"> Amount Paid {{$emirates_id_handover_amount->partial_amount}}  </span>
                                <span class="badge badge-warning"> <strong> Payroll Deduction </strong>  </span>


                                        @elseif ($emirates_id_typing_amount->pay_status=='1' )
                                        <span class="badge badge-success"> Paid  </span>
                                         @elseif ($emirates_id_typing_amount->pay_status=='2' )
                                                @if ($emirates_id_typing_amount->unpaid_status=='1')
                                                  <span class="badge badge-success"> Will be paid at {{$emirates_id_handover_amount->pay_later->step_name}}  </span>
                                                  @else
                                                  <span class="badge badge-info"> Payroll Deduction </span>
                                                @endif
                                    @else
                                    <span class="badge badge-danger"> Unpaid  </span>
                                    @endif

                                        @else  @endif</td>
                                    <td>@if($emirates_id_typing_amount==null) @else @if($emirates_id_handover_amount->remarks == null)  @else {{$emirates_id_handover_amount->remarks}} @endif @endif</td>
                                    <td>
                                        <button @if( ($next_status_id<'8') ||  isset($emirates_id_handover_amount) && $emirates_id_handover_amount->pay_status == null )  disabled @endif class="btn btn-primary btn-sm btn-start" onclick="emiratesIDHandover({{$passport_id}})" type="button">

                                         @if($emirates_id_handover==null && $next_status_id=='8')
                                         Start Process
                                         @elseif($emirates_id_handover_amount == null && $next_status_id<'8')
                                         Process Pending
                                         @else
                                         View
                                         @endif
                                     </button></td>
                                 </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
            <div class="col-md-1"></div>
        </div>
</div>











