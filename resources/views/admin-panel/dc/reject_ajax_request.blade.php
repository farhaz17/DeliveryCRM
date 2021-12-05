

<div class="row">
    <div class="col-md-12 form-group mb-3 text-center" id="name_div"  >
        <label > Rider Name:</label>
        <h5 id="name_passport" class="text-dark ml-3">{{ isset($request_dc->rider_name->personal_info->full_name) ? $request_dc->rider_name->personal_info->full_name : 'N/A' }}</h5>
        <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
    </div>
</div>

<div class="row ">

    <div class="col-md-4 form-group mb-3">
        <label for="repair_category">Checkin Date & Time <b>(Required)</b></label>
        <?php
        $dt_min = date_create($request_dc->checkin_date_time);
        $dt = $dt_min->format('Y-m-d\TH:i:s');
        ?>
        <input type="datetime-local" readonly class="form-control" autocomplete="off" value="{{ $dt }}" name="checkin_date" id="checkin_date" required>
    </div>

    <div class="col-md-4 form-group mb-3  " >
        <label for="repair_category">platform</label>
        <h6>{{ $request_dc->platform->name }}</h6>
        <input type="hidden" name="platform_id" id="platform_id" value="{{ $request_dc->platform_id }}">
    </div>

    <div class="col-md-4 form-group mb-3  " >
        <label for="repair_category">City</label>
        <h6>{{ $request_dc->city->name }}</h6>
        <input type="hidden" name="city_id" value="{{ $request_dc->city_id }}">
    </div>

    <div class="col-md-4 form-group mb-3  " >
        <label for="repair_category">Enter Remarks <b>(Optional)</b></label>
        <textarea class="form-control" readonly name="remarks">{{ $request_dc->remarks }}</textarea>
    </div>

    @if($request_dc->rider_have_own_sim_and_bike=="0")
        <div class="col-md-4 form-group mb-3">
            <label for="rider_bike">Rider Have own Bike.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" disabled name="rider_bike" id="rider_bike" value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label for="rider_sim">Rider have own sim.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" disabled name="rider_sim" id="rider_sim" value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>
    @elseif($request_dc->rider_have_own_sim_and_bike=="1")
        {{--        only bike checkin--}}
        <div class="col-md-4 form-group mb-3">
            <label for="rider_bike">Rider Have own Bike.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox"  disabled name="rider_bike" id="rider_bike"  checked value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label for="rider_sim">Rider have own sim.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" disabled name="rider_sim" id="rider_sim" value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

    @elseif($request_dc->rider_have_own_sim_and_bike=="2")
        {{--        only sim checkin --}}

        <div class="col-md-4 form-group mb-3">
            <label for="rider_bike">Rider Have own Bike.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" disabled name="rider_bike" id="rider_bike"   value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label for="rider_sim">Rider have own sim.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" disabled name="rider_sim" id="rider_sim" checked value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

    @elseif($request_dc->rider_have_own_sim_and_bike=="3")
        {{--        both checkin sim and bike --}}

        <div class="col-md-4 form-group mb-3">
            <label for="rider_bike">Rider Have own Bike.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" name="rider_bike" disabled id="rider_bike" checked  value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label for="rider_sim">Rider have own sim.?</label>
            <label class="checkbox checkbox-outline-primary">
                <input type="checkbox" name="rider_sim" disabled  id="rider_sim" checked value="1"><span>Yes</span><span class="checkmark"></span>
            </label>
        </div>

    @endif
    <?php  ?>
    <div class="col-md-4 form-group mb-3 append_div">
        <label for="repair_category">Select DC</label>
        <select class="form-control" name="to_dc_id" id="to_dc_id" required >
            <option value="" selected  >select an option</option>
            @foreach($all_dc as $dc)
                <option value="{{ $dc->id }}" >{{ $dc->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-8">
        <div class="row to_display_dc_remain_div" style="display: none;" >
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category" class="font-weight-bold text-10">Total DC LIMIT</label>
                <h5 class="text-primary font-weight-bold" id="to_total_dc_html">0</h5>
            </div>
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category" class="font-weight-bold text-10" >Total Rider Assigned TO DC</label>
                <h5 class="text-info font-weight-bold" id="to_total_assigned_dc_html" >0</h5>
            </div>
            <div class="col-md-4 form-group mb-3">
                <label for="repair_category" class="font-weight-bold text-10">Total Limit Remain of DC</label>
                <h5 class="text-success font-weight-bold" id="to_total_remain_dc_html" >0</h5>
            </div>
        </div>
    </div>

</div>
