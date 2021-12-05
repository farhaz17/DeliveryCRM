<style>
    button.btn.btn-primary.btn-sm {
        height: 27px;
    }
    button.btn.btn-primary {
        height: 27px;
    }
    button.btn.btn-primary.ml-2.btn-cancel {
        height: 33px;
        background: red;
    }
    p.alert-msg {
        text-align: center;
        color: red;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<div>
    <div class="tab-content">

        <div class="tab-pane active show" id="__g-widget-s6-tab1-content">
{{--            @if($agree_status=='5')--}}
{{--                <p class="alert-msg">Please Cancel the Agreement First</p>--}}
{{--            @endif--}}

            <div class="ul-widget-app__browser-list-1">
                <i class="i-Add-User text-white purple-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Name </span>
                <span class="cod-text font-weight-bold">{{$passport_info->full_name}} </span>
            </div>
            <hr>

            <div class="ul-widget-app__browser-list-1">
                <i class="i-Book text-white bg-danger rounded-circle p-2 mr-3"></i>
                <span class="text-15">Passport Number</span>
                <span class="cod-text font-weight-bold">{{$passport->passport_no}} </span>
            </div>
            <hr>
            <div class="ul-widget-app__browser-list-1">
                <i class="i-Coding text-white green-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">PPUID</span>
                <span class="cod-text font-weight-bold">{{$passport->pp_uid}}</span>
            </div>
            <hr>
            <div class="ul-widget-app__browser-list-1">
                <i class="i-Bar-Code text-white blue-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">ZDS Code</span>
                <span class="cod-text font-weight-bold">{{$zds_code->zds_code}}</span>
            </div>
            <hr>


            <div class="ul-widget-app__browser-list-1">

                <i class="i-Add-UserStar text-white blue-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Working Status</span>
                @if($ppuid_working!='100' && $platform_checkout_type=='100')
                    <span class="cod-text font-weight-bold">
                    @if($ppuid_working=='1')
                            Shuffle Platform
                        @elseif($ppuid_working=='2')
                            Vacation
                        @elseif($ppuid_working=='3')
                            Terminate By Platform
                        @elseif($ppuid_working=='4')
                            Terminate By Company
                        @elseif($ppuid_working=='5')
                            Accident
                        @elseif($ppuid_working=='6')
                            Absconded
                        @elseif($ppuid_working=='7')
                            Demised
                        @elseif($ppuid_working=='8')
                            Cancellation
                        @elseif($ppuid_working=='9')
                            4PL offboard
                        @elseif($ppuid_working=='10')
                            Own Visa offboard
                        @else
                            None
                        @endif

                        </span>
                @else
                    <span class="cod-text font-weight-bold">
                    @if($platform_checkout_type=='1')
                        Shuffle Platform
                    @elseif($platform_checkout_type=='2')
                        Vacation
                    @elseif($platform_checkout_type=='3')
                        Terminate By Platform
                    @elseif($platform_checkout_type=='4')
                        Terminate By Company
                    @elseif($platform_checkout_type=='5')
                        Accident
                    @elseif($platform_checkout_type=='6')
                      Absconded
                    @elseif($platform_checkout_type=='7')
                        Demised
                    @elseif($platform_checkout_type=='8')
                        Cancellation
                    @elseif($platform_checkout_type=='9')
                        4PL offboard
                     @elseif($platform_checkout_type=='10')
                        Own Visa offboard
                         @else
                        None
                    @endif
                    </span>
                @endif
            </div>
            <hr>


        <div class="ul-widget-app__browser-list-1">
            <i class="i-Add-UserStar text-white yellow-500 rounded-circle p-2 mr-3"></i>
            <span class="text-15">ID Status Status</span>
            <span class="cod-text font-weight-bold">
                      @if($ppuid_id_status=='1')
                    Active
                @elseif($ppuid_id_status=='2')
                    Inactive
                @elseif($ppuid_id_status=='3')
                    Wait Listed
                @elseif($ppuid_id_status=='4')
                    Hold
                @else
                    None
                @endif
                    </span>
        </div>


            <hr>
            <div class="ul-widget-app__browser-list-1">
                <i class="i-Checked-User text-white red-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Visa Status</span>

                <span class="cod-text font-weight-bold">
                      @if($ppuid_visa=='5')
                        Cancel
                    @elseif($ppuid_visa=='6')
                        Terminated
                    @elseif($ppuid_visa=='7')
                        Resign
                    @elseif($ppuid_visa=='8')
                        Absconded
                    @else
                        None
                    @endif
                                        </span>

            </div>
            <hr>



            @if($passport->cancel_status=='1')
            <div class="ul-widget-app__browser-list-1">
                <i class="i-Bar-Code text-white blue-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Activate</span>
{{--                <a href="{{url('contractor_all')}}" data-toggle="modal" data-target="#exampleModal-2" class="btn btn-success m-1" type="button">Activate</a>--}}

                <button class="btn  btn-success m-1" type="button" data-toggle="modal" data-target="#exampleModal-2">Activate</button>

            </div>
            <hr>
            @endif

            <div class="col-md-2">
            </div>

<div id="div_submit">
            <div class="input-group mb-3">
                <input type="hidden" value="{{$passport->id}}" name="passport_id" id="passport_id">
                <input type="hidden" value="{{$passport->passport_no}}" name="passport_number" id="passport_number">
{{--                <input type="hidden" value="{{$agree_status}}" name="agree_status" id="agree_status">--}}
                <input type="hidden" value="{{$current_status}}" name="current_status" id="current_status">




            </div>


{{--    <div class="input-group mb-3" id="status-1" style="display: none">--}}
{{--        <select class="form-control form-control-sm" name="cancel_status" id="cancel_status" required>--}}
{{--            <option value="">Select Status working status</option>--}}

{{--            <option value="1" id="active">Active</option>--}}
{{--            <option value="2" id="inactive">Inactive </option>--}}
{{--            <option value="3" id="wait_listed">Wait Listed </option>--}}
{{--            <option value="4" id="hold">Hold </option>--}}



{{--            <option value="5" id="cancel">Cancel</option>--}}
{{--            <option value="6" id="terminated">Terminated </option>--}}
{{--            <option value="7" id="resign">Resign</option>--}}
{{--            <option value="8" id="abconded">Absconded </option>--}}
{{--            <option value="9"id="criminal_case">Criminal Case </option>--}}
{{--        </select>--}}
{{--        --}}
{{--    </div>--}}


    <div class="input-group mb-3" id="status-1" >
{{--        <label for="repair_category">Select Working Status</label>--}}
        <select class="form-control form-control-sm" @if($passport->cancel_status=='1') disabled @endif  name="working_status" id="working_status" required>
            <option value="">Select Status working status</option>
                            <option value="1" @if($platform_checkout_type=='1') selected @endif >Shuffle Platform</option>
                            <option value="2" @if($platform_checkout_type=='2') selected @endif >Vacation</option>
                            <option value="3" @if($platform_checkout_type=='3') selected @endif>Terminate By Platform</option>
                            <option value="4" @if($platform_checkout_type=='4') selected @endif>Terminate By Company</option>
                            <option value="5" @if($platform_checkout_type=='5') selected @endif>Accident</option>
                            <option value="6" @if($platform_checkout_type=='6') selected @endif>Absconded</option>
                            <option value="7" @if($platform_checkout_type=='7') selected @endif>Demised</option>
                            <option value="8" @if($platform_checkout_type=='8') selected @endif>Cancellation</option>
                            <option value="9" @if($platform_checkout_type=='9') selected @endif>4PL offboard</option>
                            <option value="10" @if($platform_checkout_type=='10') selected @endif>Own Visa offboard</option>




        </select>
    </div>

    <div class="input-group mb-3">
{{--        <label for="repair_category">Working Status  Remarks</label><br>--}}
        <textarea name="remarks" class="form-control" id="working_status_remarks" cols="30" rows="10" placeholder="Working Status  Remarks" > @if($ppuid_working_remarks!='100'){{$ppuid_working_remarks}} @else {{$platform_checkout_remarks}}  @endif</textarea>
    </div>

    <div class="input-group mb-3" id="status-1" >
{{--        <label for="repair_category">Select Visa Status</label><br>--}}
        <select class="form-control form-control-sm" name="visa_status" id="visa_status" @if($passport->cancel_status=='1') disabled @endif required>
            <option value="">Select Status visa status</option>
            <option value="5" id="cancel">Cancel</option>
            <option value="6" id="terminated">Terminated </option>
            <option value="7" id="resign">Resign</option>
            <option value="8" id="abconded">Absconded </option>
            <option value="9"id="criminal_case">Criminal Case </option>
        </select>
    </div>
    <div class="input-group mb-3">
{{--        <label for="repair_category">Visa Status  Remarks</label>--}}
        <textarea name="remarks" class="form-control" id="visa_status_remarks" cols="30" rows="10" placeholder="Visa Status  Remarks" >@if($ppuid_visa_remakrs!='100'){{$ppuid_visa_remakrs}} @endif</textarea>
    </div>

    <div class="input-group mb-3" id="status-1" >
{{--        <label for="repair_category">Select ID Status</label>--}}
        <select class="form-control form-control-sm" name="visa_status" @if($passport->cancel_status=='1') disabled @endif id="id_status" required>
            <option value="">Select ID status</option>
            <option value="1" id="active">Active</option>
            <option value="2" id="inactive">Inactive </option>
            <option value="3" id="wait_listed">Wait Listed </option>
            <option value="4" id="hold">Hold </option>
        </select>
    </div>



    <div class="input-group mb-3">
{{--        <label for="repair_category">ID Status  Remarks</label>--}}
        <textarea name="remarks" class="form-control" id="id_status_remarks" cols="30" rows="10" placeholder="ID Status  Remarks" >@if($ppuid_visa_remakrs!='100'){{$ppuid_visa_remakrs}} @endif</textarea>
    </div>
{{--    <div class="input-group mb-3">--}}
{{--        <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="10" placeholder="Remarks" ></textarea>--}}
{{--    </div>--}}

    <div class="input-group mb-3">

        <div class="input-group-append">
            <button id="passport_cancel" style="display: none" >Cancel</button>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Cancel</button>
        </div>
    </div>
</div>



        </div>







<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PPUID Cancel</h5>
                <button class="close" id="close-btn" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p class="font-weight-bold">Are Your sure want to cancel PPUID?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button class="btn btn-primary ml-2 btn-cancel" type="button">Yes</button>
            </div>
        </div>
    </div>
</div>
{{------------------activate the modal--}}
        <div class="modal fade" id="exampleModal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">PPUID Activate</h5>
                        <button class="close" id="close-btn" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="{{$passport->id}}" name="passport_id_activate" id="passport_id_activate">
                        <input type="hidden" value="{{$passport->passport_no}}" name="passport_number_activate" id="passport_number_activate">

                        <div class="input-group mb-3" id="status-1" >
                            {{--        <label for="repair_category">Select Working Status</label>--}}
                            <select class="form-control form-control-sm"  name="working_status_activate" id="working_status_activate" required>
                                <option value="">Select Status working status</option>
                                <option value="1" @if($platform_checkout_type=='1') selected @endif >Shuffle Platform</option>
                                <option value="2" @if($platform_checkout_type=='2') selected @endif >Vacation</option>
                                <option value="3" @if($platform_checkout_type=='3') selected @endif>Terminate By Platform</option>
                                <option value="4" @if($platform_checkout_type=='4') selected @endif>Terminate By Company</option>
                                <option value="5" @if($platform_checkout_type=='5') selected @endif>Accident</option>
                                <option value="6" @if($platform_checkout_type=='6') selected @endif>Absconded</option>
                                <option value="7" @if($platform_checkout_type=='7') selected @endif>Demised</option>
                                <option value="8" @if($platform_checkout_type=='8') selected @endif>Cancellation</option>
                                <option value="9" @if($platform_checkout_type=='9') selected @endif>4PL offboard</option>
                                <option value="10" @if($platform_checkout_type=='10') selected @endif>Own Visa offboard</option>




                            </select>
                        </div>

                        <div class="input-group mb-3">
                            {{--        <label for="repair_category">Working Status  Remarks</label><br>--}}
                            <textarea name="remarks" class="form-control" id="working_status_remarks_activate" cols="30" rows="10" placeholder="Working Status  Remarks" ></textarea>
                        </div>

                        <div class="input-group mb-3" id="status-1" >
                            {{--        <label for="repair_category">Select Visa Status</label><br>--}}
                            <select class="form-control form-control-sm" name="visa_status_activate" id="visa_status_activate"  required>
                                <option value="">Select Status visa status</option>
                                <option value="5" id="cancel">Cancel</option>
                                <option value="6" id="terminated">Terminated </option>
                                <option value="7" id="resign">Resign</option>
                                <option value="8" id="abconded">Absconded </option>
                                <option value="9"id="criminal_case">Criminal Case </option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            {{--        <label for="repair_category">Visa Status  Remarks</label>--}}
                            <textarea name="remarks_activate" class="form-control" id="visa_status_remarks_activate" cols="30" rows="10" placeholder="Visa Status  Remarks" ></textarea>
                        </div>

                        <div class="input-group mb-3" id="status-1" >
                            {{--        <label for="repair_category">Select ID Status</label>--}}
                            <select class="form-control form-control-sm" name="visa_status"  id="id_status_activate" required>
                                <option value="">Select ID status</option>
                                <option value="1" id="active">Active</option>
                                <option value="2" id="inactive">Inactive </option>
                                <option value="3" id="wait_listed">Wait Listed </option>
                                <option value="4" id="hold">Hold </option>
                            </select>
                        </div>



                        <div class="input-group mb-3">
                            {{--        <label for="repair_category">ID Status  Remarks</label>--}}
                            <textarea name="remarks_activate" class="form-control" id="id_status_remarks_activate" cols="30" rows="10" placeholder="ID Status  Remarks" ></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                        <button class="btn btn-primary ml-2 "  id="btn-activate" type="button">Yes</button>
                    </div>
                    </div>

                </div>
            </div>
        </div>

<script>
    $(".btn-cancel").click(function(){
        $("#passport_cancel").click();

    });
</script>

