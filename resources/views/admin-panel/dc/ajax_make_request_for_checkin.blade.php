<div class="row">
    <div class="col-5">
        <div class="card card-profile-1 border border-secondary  mb-2">
            <div class="card-body text-left p-2">
                <div class="avatar box-shadow-2 mb-3" style="width: 140px; height:140px">

                    @if($onboard->career_id!="0")
                            @if(isset($onboard->career_detail))
                                <img src=" {{ isset($onboard->career_detail->passport_ppuid->profile_img) ? asset($onboard->career_detail->passport_ppuid->profile_img->image) : asset('/assets/images/user_avatar.jpg') }} " alt="">
                            @endif
                    @else
                        <img src=" {{ isset($onboard->passport_detail->profile_img) ? asset($onboard->passport_detail->profile_img->image) : asset('/assets/images/user_avatar.jpg') }} " alt="">
                    @endif

                </div>
                <h5 class="m-0 text-center">
                    <span id="full_name">
                        @if($onboard->career_id=="0")
                            <h6 id="name_passport" class="text-dark ml-3">{{  $onboard->passport_detail->personal_info->full_name }}</h6>
                        @else
                            <h6 id="name_passport" class="text-dark ml-3">{{ $onboard->career_detail->name }}</h6>
                        @endif
                    </span>
                </h5>
                <br/>
                <h5 class="text-center">Rider Driving Info</h5>
                <p class="m-0 border-bottom"><b>Driving License:  </b>

                    <span id="driving_license" class="float-right">
                        @if($onboard->career_id!="0")
                            @if(isset($onboard->career_detail))
                                {{ isset($onboard->career_detail->passport_ppuid->driving_license->license_number) ?$onboard->career_detail->passport_ppuid->driving_license->license_number : 'N/A' }}
                            @else
                                {{ isset($onboard->career_detail->passport_ppuid->driving_license->license_number) ? $onboard->career_detail->passport_ppuid->driving_license->license_number  : 'N/A' }}
                            @endif
                        @else
                                {{ isset($onboard->passport_detail->driving_license->license_number) ? $onboard->passport_detail->driving_license->license_number  : 'N/A' }}
                        @endif
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>Passport: </b>
                    <span id="pp_uid" class="float-right">
                        @if($onboard->career_id!="0")
                            @if(isset($onboard->career_detail))
                                {{ isset($onboard->career_detail->passport_ppuid) ? $onboard->career_detail->passport_ppuid->passport_no : 'N/A' }}
                            @endif
                        @else
                                {{ isset($onboard->passport_detail) ? $onboard->passport_detail->passport_no  : 'N/A' }}
                        @endif
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>PPUID: </b>
                    <span id="ppuid" class="float-right">
                        @if($onboard->career_id!="0")
                            @if(isset($onboard->career_detail))
                                {{ isset($onboard->career_detail->passport_ppuid ) ? $onboard->career_detail->passport_ppuid->pp_uid : 'N/A' }}
                            @endif
                        @else
                                {{ isset($onboard->passport_detail) ? $onboard->passport_detail->pp_uid  : 'N/A' }}
                        @endif
                    </span>
                </p>
                <p class="m-0 border-bottom"><b>ZDS: </b>
                    <span id="zds_code" class="float-right">
                        @if($onboard->career_id!="0")
                            @if(isset($onboard->career_detail))
                                {{ isset($onboard->career_detail->passport_ppuid->rider_zds_code->zds_code) ? $onboard->career_detail->passport_ppuid->rider_zds_code->zds_code : 'N/A' }}
                            @else
                                {{ isset($onboard->career_detail->passport_ppuid->rider_zds_code->zds_code) ? $onboard->career_detail->passport_ppuid->rider_zds_code->zds_code  : 'N/A' }}
                            @endif
                        @else
                                {{ isset($onboard->passport_detail->rider_zds_code->zds_code) ? $onboard->passport_detail->rider_zds_code->zds_code  : 'N/A' }}
                        @endif
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
                <p class="m-0 border-bottom"><b>Platform:  </b>
                    <?php $plaform_id_now = 0 ;?>
                    @if($onboard->career_id=="0")
                        @if(isset($onboard->career_batch_detail))
                            <span id="current_plate_form" class="float-right">{{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}</span>
                            <?php  $plaform_id_now = isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0'; ?>
                        @else
                            <span id="current_plate_form" class="float-right">{{ isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name :'N/A' }}</span>
                            <?php  $plaform_id_now = isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id: '0'; ?>
                        @endif
                    @else
                        <span id="current_plate_form" class="float-right">{{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}</span>
                        <?php  $plaform_id_now = isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0'; ?>
                    @endif
                </p>
                <p class="m-0 border-bottom"><b>Package Name:  </b>
                    @if($onboard->career_id=="0")
                        <span class="float-right">N/A</span>
                     @else
                     <span class="float-right">{{ isset($onboard->career_detail->pkg_detail) ? $onboard->career_detail->pkg_detail->package_name : 'N/A'  }}
                        @if(isset($onboard->career_detail->pkg_detail))
                        <button class="btn btn-sm  m-1" type="button" data-toggle="tooltip" data-placement="top"
                        title="Package name: {{  $onboard->career_detail->pkg_detail->package_name }},
                            Package platform: {{  $onboard->career_detail->pkg_detail->platform_detail->name }},
                            Package State: {{  $onboard->career_detail->pkg_detail->state_detail->name }},
                            Limitation: {{  $onboard->career_detail->pkg_detail->qty }},
                            Package salary: {{  $onboard->career_detail->pkg_detail->salary_package   }},
                            ">
                                                <span class="ul-btn__icon"><i class="cls_icon i-Speach-Bubble-Asking"></i></span>
                                            </button>
                                        </span>
                        @endif

                     @endif

                </p>

            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="row">
            {{-- <div class="col-md-6 form-group mb-3"> --}}
                {{-- <label class="radio-outline-success ">Name:</label> --}}
                {{-- @if($onboard->career_id=="0")
                    <h6 id="name_passport" class="text-dark ml-3">{{  $onboard->passport_detail->personal_info->full_name }}</h6>
                @else
                    <h6 id="name_passport" class="text-dark ml-3">{{ $onboard->career_detail->name }}</h6>
                @endif --}}
                <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id" >
            {{-- </div> --}}
            {{-- <div class="col-md-6 form-group mb-3"> --}}
                {{-- <label for="visit_entry_date">Platform Name </label> --}}
                <?php $plaform_id_now = 0 ;?>
                @if($onboard->career_id=="0")
                    @if(isset($onboard->career_batch_detail))
                        {{-- <h6>{{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}</h6> --}}
                        <input type="hidden" name="platform_id" value="{{  isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0' }}">
                        <?php  $plaform_id_now = isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0'; ?>
                    @else
                        {{-- <h6>{{ isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->name :'N/A' }}</h6> --}}
                        <input type="hidden" name="platform_id" value="{{  isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id: '0' }}">
                        <?php  $plaform_id_now = isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->id: '0'; ?>
                    @endif
                @else
                    {{-- <h6>{{ isset($onboard->career_batch_detail->batch_info->platform->name) ? $onboard->career_batch_detail->batch_info->platform->name :'N/A' }}</h6> --}}
                    <input type="hidden" name="platform_id" value="{{  isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0' }}">
                    <?php  $plaform_id_now = isset($onboard->career_batch_detail) ? $onboard->career_batch_detail->batch_info->platform_id: '0'; ?>
                @endif
            {{-- </div> --}}
            <div class="col-md-6 form-group mb-3">
                <label for="checkin_city">City Name<b>(required)</b></label>
                <select name="city_id" id="checkin_city" class="form-control form-control-sm"  required>
                    <option value="" selected disabled >Please select option</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" >{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group mb-3">
                <label for="date_and_time">Checkin Date &amp; Time <b>(Required)</b></label>
                <input type="datetime-local" class="form-control form-control-sm" autocomplete="off" name="checking_date" id="checking_date"  value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" required="">
            </div>
            <div class="col-md-12 form-group mb-3">
                <label for="remarks">Enter Remarks <b>(Optional)</b></label>
                <textarea class="form-control form-control-sm" name="remarks"></textarea>
            </div>
                @if($onboard->career_id=="0")
                    <?php
                        $need_platform_code = isset($onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->need_platform_code) ? $onboard->passport_detail->last_assign_platforms_checkout()->plateformdetail->need_platform_code : '';
                    ?>
                    <?php $paltform_code_exist = isset($onboard->passport_detail->check_platform_code_exist) ? $onboard->passport_detail->check_platform_code_exist_by_platform($plaform_id_now) : '';  ?>
                    @if(!isset($paltform_code_exist) && $need_platform_code=="1")
                    <div class="col-md-12 form-group mb-3">
                        <label for="rider_bike">Enter PlatformCode <b>(Required)</b></label>
                        <input type="text" class="form-control form-control-sm" name="platform_code" required>
                    </div>
                    @elseif (!isset($paltform_code_exist))
                    <div class="col-md-12 form-group mb-3">
                        <label for="rider_bike">Enter PlatformCode <b>(Required)</b></label>
                        <input type="text" class="form-control form-control-sm" value=""  name="platform_code" required>
                    </div>
                    @elseif(isset($paltform_code_exist->platform_code))
                    <div class="col-md-12 form-group mb-3">
                        <label for="rider_bike">Enter PlatformCode <b>(Required)</b></label>
                        <input type="text" class="form-control form-control-sm" value="{{ $paltform_code_exist->platform_code }}" style="background: #cbd0d4bf;" readonly name="platform_code_already" required>
                    </div>
                    @endif
                @else
                <?php $paltform_code_exist = isset($onboard->career_detail->passport_ppuid->check_platform_code_exist) ? $onboard->career_detail->passport_ppuid->check_platform_code_exist_by_platform($plaform_id_now) : null;  ?>
                <?php $need_platform_code = isset($onboard->career_batch_detail->batch_info->platform->need_platform_code) ? $onboard->career_batch_detail->batch_info->platform->need_platform_code : null; ?>
                @if(!isset($paltform_code_exist) && $need_platform_code=="1")
            <div class="col-md-12 form-group mb-3">
                <label for="rider_bike">Enter PlatformCode <b>(Required) {{ $paltform_code_exist }}</b></label>
                <input type="text" class="form-control form-control-sm" name="platform_code" required>
            </div>
                @elseif (!isset($paltform_code_exist))
            <div class="col-md-12 form-group mb-3">
                <label for="rider_bike">Enter PlatformCode <b>(Required)</b></label>
                <input type="text" class="form-control form-control-sm" value=""  name="platform_code" required>
            </div>
                @elseif(isset($paltform_code_exist->platform_code))
            <div class="col-md-12 form-group mb-3">
                <label for="rider_bike">Enter PlatformCode <b>(Required)</b></label>
                <input type="text" class="form-control form-control-sm" value="{{ $paltform_code_exist->platform_code }}" style="background: #cbd0d4bf;" readonly name="platform_code_already" required>
            </div>
                @endif
            @endif
            {{-- <div class="col-md-6 form-group mb-3">
                <label for="vist_type">Visa Type</label>
                <label class="checkbox checkbox-outline-primary">
                    <h6>{{ $visa_type }}</h6>
                </label>
            </div>
            @if($visa_type != "Company")
            <div class="col-md-6 form-group mb-3">
                <label for="vist_type">Four PL Company Name</label>
                <label class="checkbox checkbox-outline-primary">
                    <h6>{{ isset($four_pl_name) ? $four_pl_name : 'N/A' }}</h6>
                </label>
            </div>
            @endif --}}
            <?php
                if(isset($onboard->passport_detail)){
                    $is_bike_sim_reserved =  $onboard->passport_detail->check_bike_sim_reserved_or_not();
                }elseif(isset($onboard->career_detail->passport_ppuid)){
                    $is_bike_sim_reserved =  $onboard->career_detail->passport_ppuid->check_bike_sim_reserved_or_not();
                }
            ?>
            @if($is_bike_sim_reserved==null)
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
            @else
                <div class="col-md-4 form-group mb-3">
                    <label for="rider_bike">Reserved Bike Plat Number</label>
                    <h5>{{ $is_bike_sim_reserved->reserve_bike->plate_no }}</h5>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="rider_sim">Reserved Sim Number</label>
                    <h5>{{  $is_bike_sim_reserved->reserve_sim->account_number  }}</h5>
                </div>
            @endif
            @if($onboard->career_id=="0")
                @if(!isset($onboard->passport_detail->driving_license))
                    <div class="col-md-12 form-group ">
                        <h6 class="text-danger font-weight-bold">Rider Don't have Driving Licence Please Enter Driving Licence.!</h6>
                    </div>
                @endif
            @else
                @if(!isset($onboard->career_detail->passport_ppuid->driving_license))
                    <div class="col-md-12 form-group ">
                        <h6 class="text-danger font-weight-bold">Rider Don't have Driving Licence Please Enter Driving Licence.!</h6>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
