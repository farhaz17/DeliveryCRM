
<div class="row">
    <div class="col-5">
        <div class="card card-profile-1 border border-secondary  mb-2">
            <div class="card-body text-left p-2">
                <div class="avatar box-shadow-2 mb-3" style="width: 140px; height:140px">
                    <img src=" {{ isset($request_dc->rider_name->profile_img) ? asset($request_dc->rider_name->profile_img->image) : asset('/assets/images/user_avatar.jpg') }} " alt="">
                </div>
                <h5 class="m-0 text-center">
                    <span id="full_name">
                        {{ isset($request_dc->rider_name->personal_info->full_name) ? $request_dc->rider_name->personal_info->full_name : 'N/A' }}
                    </span>
                </h5>
                <br/>
                <h5 class="text-center">Rider Driving Info</h5>
                <p class="m-0 border-bottom"><b>Driving License:  </b>
                    <span id="driving_license" class="float-right">
                        {{ isset($request_dc->rider_name->driving_license->license_number) ? $request_dc->rider_name->driving_license->license_number : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>City:  </b>
                    <span id="driving_license" class="float-right">
                        {{ isset( $request_dc->city->name) ? $request_dc->city->name : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>Passport: </b>
                    <span id="pp_uid" class="float-right">
                        {{ isset($request_dc->rider_name) ? $request_dc->rider_name->passport_no : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>PPUID: </b>
                    <span id="ppuid" class="float-right">
                        {{ isset($request_dc->rider_name ) ? $request_dc->rider_name->pp_uid : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>ZDS: </b>
                    <span id="zds_code" class="float-right">
                        {{ isset($request_dc->rider_name->rider_zds_code->zds_code) ? $request_dc->rider_name->rider_zds_code->zds_code : 'N/A' }}
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>Visa Type: </b>
                    <span id="visa_type" class="float-right"> {{ $visa_type }} </span>
                </p>
                @if($visa_type != "Company")
                <p class="m-0 border-bottom"><b>4PL Comapny: </b>
                    <span id="4pl_company" class="float-right">
                            {{ isset($four_pl_name) && !empty($four_pl_name) ? $four_pl_name : 'N/A' }}
                    </span>
                </p>
                @endif
                <p class="m-0 border-bottom"><b>Plateform: </b>
                    <span id="current_plate_form" class="float-right">{{ isset( $request_dc->platform) ? $request_dc->platform->name :'N/A' }}</span>
                </p>

                <p class="m-0 border-bottom"><b>Package Name:  </b>
                    @if(isset($request_dc->rider_name->career))
                        @if($request_dc->rider_name->career_id=="0")
                            <span class="float-right">N/A</span>
                        @else
                             <span class="float-right">{{ isset($request_dc->rider_name->career->pkg_detail) ? $request_dc->rider_name->career->pkg_detail->package_name : 'N/A'  }}
                            @if(isset($request_dc->rider_name->career->pkg_detail))
                            <input type="hidden" id="pkg_id" name="pkg_id" value="{{ $request_dc->rider_name->career->pkg_id }}">
                            <button class="btn btn-sm  m-1" type="button" data-toggle="tooltip" data-placement="top"
                            title="Package name: {{ $request_dc->rider_name->career->pkg_detail->package_name }},
                                Package platform: {{  $request_dc->rider_name->career->pkg_detail->platform_detail->name }},
                                Package State: {{  $request_dc->rider_name->career->pkg_detail->state_detail->name }},
                                Limitation: {{  $request_dc->rider_name->career->pkg_detail->qty }},
                                Package salary: {{  $request_dc->rider_name->career->pkg_detail->salary_package   }},
                                ">
                                                    <span class="ul-btn__icon"><i class="cls_icon i-Speach-Bubble-Asking"></i></span>
                                                </button>
                                            </span>
                                  @endif
                            @endif

                     @endif

                </p>


            </div>
        </div>
    </div>
    <div class="col-7">
        {{-- <div class="row">
            <div class="col-md-12 form-group mb-3 text-center" id="name_div"  >
                <label > Rider Name:</label>
                <h5 id="name_passport" class="text-dark ml-3">{{ isset($request_dc->rider_name->personal_info->full_name) ? $request_dc->rider_name->personal_info->full_name : 'N/A' }}</h5>
            </div>
        </div> --}}
        <div class="row ">
            <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
            <div class="col-md-12 form-group mb-3">
                <label for="">Checkin Date & Time <b>(Required)</b></label>
                <?php
                    $dt_min = date_create($request_dc->checkin_date_time);
                    $dt = $dt_min->format('Y-m-d\TH:i:s');
                ?>
                <input type="datetime-local" class="form-control" autocomplete="off" value="{{ $dt }}" name="checkin_date" id="checkin_date" required>
            </div>

            {{-- <div class="col-md-6 form-group mb-3  " >
                <label for="">platform</label>
                <h6>{{ $request_dc->platform->name }}</h6>
            </div> --}}
            <input type="hidden" name="platform_id" id="platform_id" value="{{ $request_dc->platform_id }}">

            {{-- <div class="col-md-6 form-group mb-3  " >
                <label for="">City</label>
                <h6>{{ $request_dc->city->name }}</h6>
            </div> --}}
            <input type="hidden" name="city_id" value="{{ $request_dc->city_id }}">

            <div class="col-md-12 form-group mb-3  " >
                <label for="">Enter Remarks <b>(Optional)</b></label>
                <textarea class="form-control" name="remarks">{{ $request_dc->remarks }}</textarea>
            </div>

            {{-- <div class="col-md-3 form-group mb-3">
                <label for="vist_type">Visa Type</label>
                <label class="checkbox checkbox-outline-primary">
                    <h6>{{ $visa_type }}</h6>
                </label>
            </div>

            @if($visa_type != "Company")
            <div class="col-md-5 form-group mb-3">
                <label for="vist_type">Four PL Company Name</label>
                <label class="checkbox checkbox-outline-primary">
                    <h6>{{ isset($four_pl_name) ? $four_pl_name : 'N/A' }}</h6>
                </label>
            </div>
            @endif --}}

            <?php
                $is_bike_sim_reserved= "";
                if(isset($request_dc->rider_name)){
                    $is_bike_sim_reserved =  $request_dc->rider_name->check_bike_sim_reserved_or_not();
                }
            ?>
            @if($is_bike_sim_reserved!=null)
                <div class="col-md-6 form-group mb-3">
                    <label for="rider_bike">Reserved Bike Plat Number</label>
                    <h5>{{ $is_bike_sim_reserved->reserve_bike->plate_no }}</h5>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="rider_sim">Reserved Sim Number</label>
                    <h5>{{  $is_bike_sim_reserved->reserve_sim->account_number  }}</h5>
                </div>
            @elseif($request_dc->rider_have_own_sim_and_bike=="0")
            <div class="col-md-6 form-group mb-3">
                <label for="rider_bike">Rider Have own Bike.?</label>
                <label class="checkbox checkbox-outline-primary">
                    <input type="checkbox" name="rider_bike" id="rider_bike" value="1"><span>Yes</span><span class="checkmark"></span>
                </label>
            </div>

            <div class="col-md-6 form-group mb-3">
                <label for="rider_sim">Rider have own sim.?</label>
                <label class="checkbox checkbox-outline-primary">
                    <input type="checkbox" name="rider_sim" id="rider_sim" value="1"><span>Yes</span><span class="checkmark"></span>
                </label>
            </div>
            @elseif($request_dc->rider_have_own_sim_and_bike=="1")
                {{--        only bike checkin--}}
                <div class="col-md-6 form-group mb-3">
                    <label for="rider_bike">Rider Have own Bike.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_bike" id="rider_bike"  checked value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="rider_sim">Rider have own sim.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_sim" id="rider_sim" value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

            @elseif($request_dc->rider_have_own_sim_and_bike=="2")
                {{--        only sim checkin --}}

                <div class="col-md-6 form-group mb-3">
                    <label for="rider_bike">Rider Have own Bike.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_bike" id="rider_bike"   value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="rider_sim">Rider have own sim.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_sim" id="rider_sim" checked value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

            @elseif($request_dc->rider_have_own_sim_and_bike=="3")
                {{--        both checkin sim and bike --}}

                <div class="col-md-6 form-group mb-3">
                    <label for="rider_bike">Rider Have own Bike.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_bike" id="rider_bike" checked  value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="rider_sim">Rider have own sim.?</label>
                    <label class="checkbox checkbox-outline-primary">
                        <input type="checkbox" name="rider_sim" id="rider_sim" checked value="1"><span>Yes</span><span class="checkmark"></span>
                    </label>
                </div>

            @endif
            <?php  ?>
            <div class="col-md-12 form-group mb-3 append_div">
                <label for="">Select DC</label>
                <select class="form-control" name="to_dc_id" id="to_dc_id" required >
                    <option value="" selected  >select an option</option>
                    @foreach($all_dc as $dc)
                        <option value="{{ $dc->id }}" >{{ $dc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12">
                <div class="row to_display_dc_remain_div" style="display: none;" >
                    <div class="col-md-6 form-group mb-3">
                        <label for="" class="font-weight-bold text-10">Total DC LIMIT</label>
                        <h5 class="text-primary font-weight-bold" id="to_total_dc_html">0</h5>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="" class="font-weight-bold text-10" >Total Rider Assigned TO DC</label>
                        <h5 class="text-info font-weight-bold" id="to_total_assigned_dc_html" >0</h5>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="" class="font-weight-bold text-10">Total Limit Remain of DC</label>
                        <h5 class="text-success font-weight-bold" id="to_total_remain_dc_html" >0</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 form-group mb-3 reject_resaon_div" style="display: none;">
                <label for="">Reject Reason <b>(Optional)</b></label>
                <textarea class="form-control" name="reject_reason"></textarea>
            </div>
        </div>
    </div>
    </div>
