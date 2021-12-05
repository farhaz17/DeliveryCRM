
<div class="row">
    <div class="col-5">
        <div class="card card-profile-1 border border-secondary  mb-2">
            <div class="card-body text-left p-2">
                <div class="avatar box-shadow-2 mb-3" style="width: 140px; height:140px">
                    <img src=" {{ isset($request_detail->rider_name->profile_img) ? asset($request_detail->rider_name->profile_img->image) : asset('/assets/images/user_avatar.jpg') }} " alt="">
                </div>
                <h5 class="m-0 text-center">
                    <span id="full_name">
                        {{ isset($request_detail->rider_name->personal_info->full_name) ? $request_detail->rider_name->personal_info->full_name : 'N/A' }}
                    </span>
                </h5>
                <br/>
                <h5 class="text-center">Rider Driving Info</h5>
                <p class="m-0 border-bottom"><b>Driving License:  </b>
                    <span id="driving_license" class="float-right">
                        {{ isset($request_detail->rider_name->driving_license->license_number) ? $request_detail->rider_name->driving_license->license_number : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>City:  </b>
                    <span id="driving_license" class="float-right">
                        {{ isset( $request_detail->city->name) ? $request_detail->city->name : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>Passport: </b>
                    <span id="pp_uid" class="float-right">
                        {{ isset($request_detail->rider_name) ? $request_detail->rider_name->passport_no : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>PPUID: </b>
                    <span id="ppuid" class="float-right">
                        {{ isset($request_detail->rider_name ) ? $request_detail->rider_name->pp_uid : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>ZDS: </b>
                    <span id="zds_code" class="float-right">
                        {{ isset($request_detail->rider_name->rider_zds_code->zds_code) ? $request_detail->rider_name->rider_zds_code->zds_code : 'N/A' }}
                    </span>
                </p>


                <p class="m-0 border-bottom"><b>Plateform: </b>
                    <?php

                if(!$request_detail->rider_name->platform_assign->isEmpty()) {
                         $ab = $request_detail->rider_name->platform_assign->where('status','1')->first();

                        $result = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                    }else{
                        $result = 'N/A';
                    }
                        ?>
                    <span id="current_plate_form" class="float-right">{{ isset($result) ? $result :'N/A' }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-7">
        {{-- <div class="row">
            <div class="col-md-12 form-group mb-3 text-center" id="name_div"  >
                <label > Rider Name:</label>
                <h5 id="name_passport" class="text-dark ml-3">{{ isset($request_detail->rider_name->personal_info->full_name) ? $request_detail->rider_name->personal_info->full_name : 'N/A' }}</h5>
            </div>
        </div> --}}
        <div class="row ">
            <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
            <div class="col-md-12 form-group mb-3">
                <label for="">Checkin Date & Time</label>
                  <h6>{{ $request_detail->checkout_date }}</h6>
            </div>
<input type="hidden" name="checkout_date" value="{{ $request_detail->checkout_date }}">
            <div class="col-md-12 form-group mb-3">
                <label for="">Request Type</label>
                  <h6>{{ $array_type[$request_detail->request_type] }}</h6>
            </div>


            <div class="col-md-12 form-group mb-3  " >
                <label for="">Enter Remarks <b>(Optional)</b></label>
                <textarea class="form-control" name="remarks">{{ $request_detail->remarks}}</textarea>
            </div>



            <div class="col-md-6 form-group mb-3 reject_resaon_div" style="display: none;">
                <label for="">Reject Reason <b>(Optional)</b></label>
                <textarea class="form-control" name="reject_reason"></textarea>
            </div>
        </div>
    </div>
    </div>
