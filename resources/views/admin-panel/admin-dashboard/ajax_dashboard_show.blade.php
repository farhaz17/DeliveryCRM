<div class="table2">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="card card-profile-1 mb-4 mr-1">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-sm-10">
                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Platform </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------------------->
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="card card-profile-1 mb-4 mr-1">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-sm-10">
                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Present </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------->
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="card card-profile-1 mb-4 mr-1">
                <div class="card-body text-left">
                    <div class="row">

                        <div class="col-sm-10">
                            <p class="text-attr-title ml-4 font-weight-bold mt-3">Absent </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------->
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="card card-profile-1 mb-4 mr-1">
                <div class="card-body text-left">
                    <div class="row">

                        <div class="col-sm-10">
                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @foreach($platform_att as $row)

        <div class="row">

            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body">
                        <div class="row">
                            {{--                                        style="background-image:url('assets/images/icons/drawable/careem.png')"--}}
                            <div class="col-sm-2 bg-left" >

                                <img class="title_imag-icon"
                                     @if($row['platform_id']=='1')
                                     src="assets/images/icons/drawable/careem.png"
                                     @elseif($row['platform_id']=='2')
                                     src="assets/images/icons/drawable/zomato.png"
                                     @elseif($row['platform_id']=='3')
                                     src="assets/images/icons/drawable/uber-eats.png"
                                     @elseif($row['platform_id']=='4')
                                     src="assets/images/icons/drawable/deliveroo.png"
                                     @elseif($row['platform_id']=='5')
                                     src="assets/images/icons/drawable/swan.png"
                                     @elseif($row['platform_id']=='6')
                                     src="assets/images/icons/drawable/bnk.png"
                                     @elseif($row['platform_id']=='7')
                                     src="assets/images/icons/drawable/somu_sushu.png"
                                     @elseif($row['platform_id']=='8')
                                     src="assets/images/icons/drawable/hey_karry.png"
                                     @elseif($row['platform_id']=='9')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='10')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='11')
                                     src="assets/images/icons/drawable/i-mile.png"
                                     @elseif($row['platform_id']=='12')
                                     src="assets/images/icons/drawable/spicy_klub.png"
                                     @elseif($row['platform_id']=='13')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='14')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='15')
                                     src="assets/images/icons/drawable/talabat.png"
                                     @elseif($row['platform_id']=='16')
                                     src="assets/images/icons/drawable/trot.png"
                                     @elseif($row['platform_id']=='17')
                                     src="assets/images/icons/drawable/chocomelt.png"
                                     @elseif($row['platform_id']=='18')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='19')
                                     src="assets/images/icons/drawable/kabab_shop.png"
                                     @elseif($row['platform_id']=='20')
                                     src="assets/images/icons/drawable/platform.png"
                                     @elseif($row['platform_id']=='21')
                                     src="assets/images/icons/drawable/thai-wok.png"
                                     @elseif($row['platform_id']=='22')
                                     src="assets/images/icons/drawable/aster.png"
                                     @elseif($row['platform_id']=='23')
                                     src="assets/images/icons/drawable/med-care.png"
                                     @elseif($row['platform_id']=='24')
                                     src="assets/images/icons/drawable/med-care.png"
                                     @elseif($row['platform_id']=='25')
                                     src="assets/images/icons/drawable/insta.png"
                                     @else
                                     src="assets/images/icons/drawable/platform.png"
                                     @endif
                                     alt="icon"></div>

                            <div class="col-sm-10">
                                {{--                                        <p class="text-attr-title font-weight-bold mt-3 ml-4">Platform </p>--}}
                                <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'
                        ||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
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
                                {{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Present </p>--}}
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
                                {{--                                            <p class="text-attr-title ml-4 font-weight-bold mt-3">Absent </p>--}}
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
                                {{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
                                <p class="text-attr-digit ml-4 mt-4">{{$row['orders']}} </p>
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
                                {{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
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
                                {{--                                            <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>--}}
                                <p class="text-attr-digit ml-4 mt-4">{{$row['leave']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    @endforeach
</div>
