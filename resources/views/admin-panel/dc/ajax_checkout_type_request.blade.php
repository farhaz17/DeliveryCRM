<style>
    h6{
        font-weight: 800;
    }
    </style>

<div class="row">
    <div class="col-md-12 form-check-inline mb-3 text-center" id="name_div"  >
        <label class="radio-outline-success "> Rider Name:</label>
        <h6 id="name_passport" class="text-dark ml-3">{{ isset($passport->personal_info->full_name) ? $passport->personal_info->full_name : 'N/A' }}</h6>
        <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">

        <label class="radio-outline-success   font-weight-bold mr-1 ml-1 ">Platform:</label>
        <h6 id="name_passport_checkout_platform_name" class="text-dark ml-3 ">{{ isset($passport->last_assign_platforms_checkout()->plateformdetail->name) ? ($passport->last_assign_platforms_checkout()->plateformdetail->name) : '' }}</h6>
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

        <label class="radio-outline-success   font-weight-bold ">Chekin Date & Time:</label>
        <h6 id="name_passport_checkout_checkin" class="text-dark ml-3 ">{{ isset($passport->last_assign_platforms_checkout()->checkin) ? ($passport->last_assign_platforms_checkout()->checkin) : 'N/A' }}</h6>
    </div>
</div>

<div class="row ">

    <div class="col-md-4 form-group mb-3">
        <label for="repair_category">Checkout Date <b>(Required)</b></label>
        <?php
        $dt_min = date_create($request_dc->checkout_date_time);
        $dt = $dt_min->format('Y-m-d\TH:i:s');
        ?>
        <h6  class="text-dark ml-3 ">{{ $dt }}</h6>
    </div>

    <div class="col-md-4 form-group mb-3  " >
        <label for="repair_category">Select Checkout type </label>
        <?php  $checkout_type_girl = get_checkout_type_names(); ?>
        <h6  class="text-dark ml-3 ">{{ $checkout_type_girl[$request_dc->checkout_type] }}</h6>
    </div>

    <div class="col-md-4 form-group mb-3  " >
        <label for="repair_category">Enter Remarks</label>
        <h6  class="text-dark ml-3 ">{{ $request_dc->remarks }}</h6>
    </div>

    @if($request_dc->checkout_type=="2" || $request_dc->checkout_type=="1" || $request_dc->checkout_type=="10" || $request_dc->checkout_type=="11" || $request_dc->checkout_type=="6" || $request_dc->checkout_type=="5")
        <div class="col-md-4 expected_div_cls mb-3" >
            <label for="repair_category">Expected Date To Return</label>
            <h6  class="text-dark ml-3 ">{{ $request_dc->return_date }}</h6>
        </div>
    @else
        <div class="col-md-4 expected_div_cls mb-3" style="display: none">
            <label for="repair_category">Expected Date To Return</label>
            <input type="text" autocomplete="off" id="expected_date" name="expected_date"  class="form-control">
        </div>
    @endif

    @if($request_dc->checkout_type=="1")
        <?php $array_ab = array('','Immediate Shuffle','Until Interview pass'); ?>
        <div class="col-md-4 form-group mb-3 shuffle_div_cls "  >
            <label for="repair_category">Select Shuffle type <b>(Required)</b></label>
            <h6  class="text-dark ml-3 ">{{ $array_ab[$request_dc->checkout_type] }}</h6>


        </div>
    @else
        <div class="col-md-4 form-group mb-3 shuffle_div_cls " style="display: none;" >
            <label for="repair_category">Select Shuffle type <b>(Required)</b></label>
            <select class="form-control  " name="shuffle_type" id="shuffle_type"  >
                <option value="" selected disabled >select an option</option>
                <option value="1">Immediate Shuffle</option>
                <option value="2" >Until Interview pass</option>
            </select>
        </div>
    @endif




</div>
