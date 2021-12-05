
@if($rider_data=='1')
<p style="color:red"><b>Bike is not assigned to rider</b></p>

     {{-- <label for="repair_category">Name</label>
     <input class="form-control form-control" id="name" name="name" value="{{isset($manage_repair_data)?$manage_repair_data->name:""}}" type="text" placeholder="Enter the name"/> --}}


@else

<div>
<span><b style="color: green">Name: </b><b>{{isset($rider_data->personal_info->full_name)?$rider_data->personal_info->full_name:"N/A"}}</b></span>
<input class="form-control form-control" id="passport_id" name="passport_id" value="{{isset($rider_data->id)?$rider_data->id:""}}" type="hidden"  />

<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>
    <b style="color:blue">
PPUID:
</b>
<b>
{{isset($rider_data->pp_uid)?$rider_data->pp_uid:"N/A"}}
</b>
</span>
<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

<span>
    <b style="color:red">
Platform:
</b>
<b>
{{$rider_data->assign_platforms_check() ? $rider_data->assign_platforms_check()->plateformdetail->name:"N/A"}}
</b>
</span>

</div>
@endif


{{-- else --}}


{{-- <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name" value="{{isset($manage_repair_data)?$manage_repair_data->name:""}}" type="text" placeholder="Enter the name" required />
                            </div> --}}
