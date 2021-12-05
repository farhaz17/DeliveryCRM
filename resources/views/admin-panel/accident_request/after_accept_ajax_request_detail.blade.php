
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
            <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id" value="{{ $request_detail->rider_passport_id }}">
            <div class="col-md-6 form-group mb-3">
                <label for="">Checkout Date & Time of Platform</label>
                  <h6>{{ $request_detail->checkout_date }}</h6>
            </div>


            <div class="col-md-6 form-group mb-3">
                <label for="">Request Type</label>
                  <h6>{{ $array_type[$request_detail->request_type] }}</h6>
            </div>


            <div class="col-md-12 form-group mb-3">
                <label for="checkout_date">Checkout Date <b>(Required)</b></label>
                <input type="datetime-local" class="form-control form-control-sm" autocomplete="off" name="checkout_date" id="checkout_date" required>
            </div>


            <?php

            $result_sim = "";
            if (!$request_detail->rider_name->sim_assign->isEmpty()) {
                $abs = $request_detail->rider_name->sim_assign->where('checkout','is',null)->first();
                $result_sim = isset($abs->telecome->account_number) ? $abs->telecome->account_number : 'N/A';
            } else{
                $result_sim = 'N/A';
            }
        ?>

            <div class="col-md-6 form-group mb-3">
                <label for="">Current Sim Number</label>
                  <h6>{{ $result_sim }}</h6>
            </div>

            <?php
            $result_sim_temp = null;


                  if(!$request_detail->rider_name->temporary_sim_replacement->isEmpty()) {
                    $abs =  $request_detail->rider_name->temporary_sim_replacement->where('status','1')->first();
                    $result_sim_temp  =  isset($abs->temporary_plate_number->account_number) ? $abs->temporary_plate_number->account_number : null;
                } else{
                    $result_sim_temp = null;
                }
            ?>

                @if(isset($result_sim_temp))
                 <div class="col-md-6 form-group mb-3">
                    <label for="">Temporary Sim Number</label>
                    <h6>{{ $result_sim_temp }}</h6>
                </div>
                @endif







            <div class="col-md-12 form-group mb-3">
                <label for="checkout_date">Please select which Bike Number Damaged.! <b>(Required)</b></label>
                 <br>

                 <?php
                 $result_bike = "";
                 $bike_id = "";
                  if (!$request_detail->rider_name->bike_assign->isEmpty()) {
                      $abs =  $request_detail->rider_name->bike_assign->where('checkout','is',null)->first();
                      $result_bike  =  isset($abs->bike_plate_number->plate_no) ? $abs->bike_plate_number->plate_no : 'N/A';
                      $bike_id  =  isset($abs->bike_plate_number->id) ? $abs->bike_plate_number->id : 'N/A';
                  } else{
                      $result_bike = 'N/A';
                  }

              ?>

              <?php
              $result_bike_temp = null;
              $bike_id_temp = null;

                    if(!$request_detail->rider_name->temporary_bike_replacement->isEmpty()) {
                      $abs =  $request_detail->rider_name->temporary_bike_replacement->where('status','1')->first();
                      $result_bike_temp  =  isset($abs->temporary_plate_number->plate_no) ? $abs->temporary_plate_number->plate_no : null;
                      $bike_id_temp  =  isset($abs->temporary_plate_number->id) ? $abs->temporary_plate_number->id : null;
                  } else{
                      $result_bike_temp = null;
                      $bike_id_temp = null;
                  }


              ?>


                <div class="form-check-inline">
                    <label class="radio radio-outline-success">
                        <input type="radio" name="bike_number" id="apply_for_bike" value="{{ $bike_id}}"><span>{{ $result_bike }} (Permanent) </span><span class="checkmark"></span>
                    </label>
                </div>

                @if(isset($result_bike_temp))
                <div class="form-check-inline">
                    <label class="radio radio-outline-success">
                        <input type="radio" name="bike_number" id="apply_for_car" value="{{ $bike_id_temp }}"><span>{{ $result_bike_temp }}  (Temporary)</span><span class="checkmark"></span>
                    </label>
                </div>
                @endif


            </div>


            <div class="col-md-12 form-group mb-3  " >
                <label for="">Enter Remarks <b>(Optional)</b></label>
                <textarea class="form-control"  name="remarks">{{ $request_detail->remarks}}</textarea>
            </div>



            <div class="col-md-6 form-group mb-3 reject_resaon_div" style="display: none;">
                <label for="">Reject Reason <b>(Optional)</b></label>
                <textarea class="form-control" name="reject_reason"></textarea>
            </div>
        </div>
    </div>
    </div>
