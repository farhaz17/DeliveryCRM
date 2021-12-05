@if($null_val=='1')
<h5 class="card-title">Persoanl Information</h5>
<div class="row personal_info_row">

    <div class="ul-widget1">
    <div class="ul-widget4__item ul-widget4__users">
        <div class="ul-widget4__img">
            <img class="avatar-md  img-responsive ml-3"  src="{{  $image ? url($image) : asset('assets/images/user_avatar.jpg') }}">
        </div>
        <div class="ul-widget2__info ul-widget4__users-info">
            <span class="ul-widget2__title" >{{$passport->personal_info->full_name}}</span>
            <input type="hidden" id="passport_id" value="{{$passport->id}}">

            <span class="ul-widget2__username" href="#"><b style="color: #000">Last Checkin Date:</b> {{$checkin}}</span>
        </div>

    </div>
   </div>



</div>
<hr>
<div class="row bike_info_row">
    <h5 class="card-title ml-3">Bike Information</h5>


    <div class="ul-widget1">
        <div class="ul-widget4__item ul-widget4__users">
            <div class="ul-widget4__img">

                <img class="avatar-md  img-responsive ml-3" alt="Image here"  src=" {{asset('assets/images/icons/drawable/bike.png') }}">
            </div>
            <div class="ul-widget2__info ul-widget4__users-info">
                <span class="ul-widget2__title" >Model: {{isset($bike_info->model_info->name)?$bike_info->model_info->name:"N/A"}}</span>


                <span class="ul-widget2__username" href="#"><b style="color: #000">Year:</b> {{isset( $bike_info->year->year)? $bike_info->year->year:"N/A"}}</span>
                <span class="ul-widget2__username" href="#"><b style="color: #000">Engine Number:</b> {{isset($bike_info->engine_no)?$bike_info->engine_no:"N/A"}}</span>
            </div>

        </div>
       </div>


</div>
@else

<div class="ul-widget1 mt-4 ml-4">
    {{-- <span style="color:red">Bike Is Not Assigned</span> --}}
    <div class="alert alert-danger font-weight-bold text-16 text-center bike-alert" style="position: relative; top:150px" role="alert"> Bike is not assigned
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"></button>
    </div>
    </div>


@endif

