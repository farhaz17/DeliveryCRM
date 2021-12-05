@foreach($platform_att as $row)
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2 bg-left" >
                        <img class="title_imag-icon" src = "{{ get_platform_icon_url($row['platform_id']) }}" alt="icon">
                    </div>
                    <div class="col-sm-10">
                        <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
                            class="text-attr-platform ml-4 mt-4"
                            @elseif($row['platform_id']=='24'||$row['platform_id']=='17')
                            class="text-attr-platform2 ml-4 mt-4"
                            @else
                            class="text-attr ml-4 mt-4" @endif >{{$row['platform']}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------------->
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/yes_sir.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="text-attr-digit ml-4 mt-4" style="color: green">{{$row['present']}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------->
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body text-left">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/delete-user.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="text-attr-digit ml-4 mt-4" style="color: red">{{$row['absent']}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------->
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body text-left">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/order-food.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="text-attr-digit ml-4 mt-4" style="font-size: x-large;">{{$row['orders']}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------->
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body text-left">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/bike.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="text-attr-digit ml-4 mt-4">{{$row['total_rider']}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------->
    <div class="col-lg-2 col-md-3 col-sm-3">
        <div class="card card-profile-1 mb-4 mr-1">
            <div class="card-body text-left">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/day.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="text-attr-digit ml-4 mt-4">{{$row['as_per_system_total_rider']}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
