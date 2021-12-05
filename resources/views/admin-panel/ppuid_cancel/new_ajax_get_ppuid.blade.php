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
                <span class="text-15">Assign Platform</span>
               <span class="cod-text font-weight-bold">
                   <?php
                   $assign_platform = $passport->assign_platforms_checkin();
                    ?>
                {{ isset($assign_platform) ? $assign_platform->plateformdetail->name : 'N/A' }}
               </span>


            </div>
            <hr>


        <div class="ul-widget-app__browser-list-1">
            <i class="i-Motorcycle text-white yellow-500 rounded-circle p-2 mr-3"></i>
            <span class="text-15">Assigned Bike</span>
            <span class="cod-text font-weight-bold">
                <?php
                   $assign_bike = $passport->assign_bike_check();
                 ?>
                {{ isset($assign_bike) ? $assign_bike->bike_plate_number->plate_no : 'N/A' }}
                    </span>
        </div>


            <hr>
            <div class="ul-widget-app__browser-list-1">
                <i class="i-Memory-Card text-white red-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Assigned Sim</span>
                <span class="cod-text font-weight-bold">
                    <?php
                   $assign_sim = $passport->assign_sim_check();
                 ?>
                {{ isset($assign_sim) ? $assign_sim->telecome->account_number : 'N/A' }}

                </span>
            </div>
            <hr>




            <div class="ul-widget-app__browser-list-1">
                <i class="i-Bar-Code text-white blue-500 rounded-circle p-2 mr-3"></i>
                <span class="text-15">Current Status</span>
                <span class="cod-text font-weight-bold">
                    @if($passport->cancel_status=='1')
                    <span class="badge badge-pill badge-danger p-2 m-1">Cancelled</span>
                    @else
                    <span class="badge badge-pill badge-primary p-2 m-1">Active</span>
                    @endif


                </span>

            </div>
            <hr>


            <div class="col-md-2">
            </div>

<div id="div_submit">
            <div class="input-group mb-3">
                <input type="hidden" value="{{$passport->id}}" name="passport_id" id="passport_id">
                <input type="hidden" value="{{$passport->passport_no}}" name="passport_number" id="passport_number">
                <input type="hidden" value="{{$current_status}}" name="current_status" id="current_status">
            </div>










{{--    <div class="input-group mb-3">--}}
{{--        <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="10" placeholder="Remarks" ></textarea>--}}
{{--    </div>--}}

    <div class="input-group mb-3">
        @if($passport->cancel_status=='1')
        <div class="input-group-append">
            <button class="btn  btn-success m-1" type="button" data-toggle="modal" data-target="#exampleModal-2">Activate</button>
        </div>
        @else

        <div class="input-group-append">
            <button id="passport_cancel" style="display: none" >Cancel</button>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Cancel</button>
        </div>

        @endif

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

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Select Category</label>
                       <select class="form-control" name="main_category"  id="main_category" required>
                        <option value="" selected disabled>select category</option>
                        @foreach($main_categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                       </select>
                    </div>

                    <div class="col-md-6 form-group subcategory_tab">

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Enter Cancel Remarks <b>(required)</b></label>
                      <textarea class="form-control" name="cancel_remarks" id=cancel_remarks></textarea>
                    </div>
                </div>
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
                    <form  id="ppuid_activate_form" action="{{ route('ppuid_activate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">PPUID Activate</h5>
                        <button class="close" id="close-btn" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="{{$passport->id}}" name="passport_id_activate" id="passport_id_activate">
                        <input type="hidden" value="{{$passport->passport_no}}" name="passport_number_activate" id="passport_number_activate">
                        company_now

                        <p class="font-weight-bold">Are Your sure want to Activate PPUID?</p>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Wants To Work As.?</label>
                                <select class="form-control" id="work_as" name="work_as">
                                    <option value="" selected disabled>select an option</option>
                                    <option value="1">Comapny</option>
                                    <option value="2">FourPL</option>
                                </select>
                            </div>
                        </div>


                        <div id="agreed_amount_div">

                        </div>



                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Enter Activate Remarks <b>(required)</b></label>
                              <textarea class="form-control" name="active_remarks" id=active_remarks></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" id="no_btn_of_active" data-dismiss="modal">No</button>
                        <button class="btn btn-primary ml-2 "  id="btn-activate" type="button">Yes</button>
                        <input type="submit" id="submit_from_button" style="display: none;" value="submit">
                    </div>
                    </div>
                  </form>

                </div>
            </div>
        </div>

<script>
    $(".btn-cancel").click(function(){

    var remarks = $("#cancel_remarks").val();

    if(remarks==""){
        tostr_display("error","please enter cancel remarks");
    }else{
        $("#passport_cancel").click();
    }



    });
</script>

