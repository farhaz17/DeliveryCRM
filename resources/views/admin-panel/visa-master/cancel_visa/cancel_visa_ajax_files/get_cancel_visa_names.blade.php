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

                {{-- @if($visa_remarks=='1')
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa Process Cannot Be Cancelled!</strong>
                   Visa Process Has Not Been Completed Yet

                </div>
                @endif --}}

                @if ($request_can=='1')
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">No Visa Cancel request Sent!</strong>


                 </div>
                @endif




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

                    @if($request_can=='0')

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Process</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- offer letter process 1 --}}
                            <tr>
                               <td>1</td>
                               <td>Visa Cancellation Typing (MOL)</td>
                               <td>@if($visa_cancel_typing!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                               <td>


                                <button  class="btn btn-primary btn-sm btn-start"
                                onclick="visaCancelTyping({{$passport_id}})" type="button">
                                  @if($visa_cancel_typing!=null)
                                 View
                                  @else
                                  Start Process
                                  @endif
                                </button>

                            </td>
                            </tr>

                                {{-- offer letter submission process 2 --}}
                                <tr>
                                    <td>2</td>
                                    <td>Visa Cancellation Submission(MOL)</td>
                                    <td>@if($visa_cancel_sub!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>
                                        <button   @if($visa_cancel_sub==null && $next_status !='2') disabled @endif  class="btn btn-primary btn-sm btn-start" onclick="visaCancelSub({{$passport_id}})" type="button">
                                            @if($visa_cancel_sub!=null && $next_status >'2')
                                            View
                                            @else
                                            Start Process
                                            @endif
                                          </button>
                                    </td>
                                 </tr>

                                   {{-- Electronic Pre Approval process 3 --}}

                                   <tr>
                                    <td>3</td>
                                    <td>Visa Cancellation Application (Immigration)</td>
                                    <td>@if($visa_cancel!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>
                                        <button @if($visa_cancel==null && $next_status !='3') disabled @endif  class="btn btn-primary btn-sm btn-start" onclick="visaCancel({{$passport_id}})" type="button">
                                            @if($visa_cancel!=null && $next_status >'3')
                                            View
                                            @else
                                            Start Process
                                            @endif
                                          </button>
                                    </td>
                                 </tr>

                            {{-- Electronic Pre Approval payment process 4 --}}


                                 <tr>
                                    <td>4</td>
                                    <td>Visa Cancellation Approval (Immigration)</td>
                                    <td>@if($visa_cancel_approval!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>

                                    <td>
                                        <button @if($visa_cancel_approval==null && $next_status !='4') disabled @endif class="btn btn-primary btn-sm btn-start" onclick="visaCancelApproval({{$passport_id}})" type="button">
                                            @if($visa_cancel_approval!=null && $next_status >'4')
                                            View
                                            @else
                                            Start Process
                                            @endif
                                          </button>
                                    </td>
                                 </tr>
                                   {{-- Print Visa Inside/Outside process 6 --}}
                                   {{-- Show the decline only if it is declined else donot show --}}
                                   @if($visa_cancel_approval!=null && $visa_cancel_approval->decline_status=='1')
                                    <tr>
                                    <td>5</td>
                                    <td>Visa Cancellation Decline</td>
                                    <td>@if($visa_cancel_decline!=null) <span class="badge badge-success"> Completed </span>@else <span class="badge badge-danger"> Pending </span> @endif</td>
                                    <td>
                                        <button @if($visa_cancel_decline==null && $next_status !='5') disabled @endif  class="btn btn-primary btn-sm btn-start" onclick="visaCancelDecline({{$passport_id}})" type="button">
                                            @if($visa_cancel_decline!=null && $next_status >'5')
                                            View
                                            @else
                                            Start Process
                                            @endif
                                          </button>
                                    </td>
                                 </tr>
                                 @endif





                        </tbody>
                    </table>
                 
                    @endif
                </div>
            </div>
        </div>
            </div>
            <div class="col-md-1"></div>
        </div>
</div>











