
<div class="row">
    @if($menu_type=="master-menu")
        @foreach($total_dc as $dc)
    <div class="col-2 mb-2">
        <div class="card card-icon bg-danger">
            <a href="{{ route('dc_dashboard',$dc->id) }}" target="_blank" class="card-body text-center p-2 text-white text-white">
{{--                <i class="nav-icon i-Gear"></i>--}}

                <span class="item-name font-weight-bold">{{ $dc->name }}</span>
            </a>
        </div>
    </div>
        @endforeach
    @elseif($menu_type=="operations-menu")

        @foreach($total_dc as $dc)
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success">
                    <a href="{{ route('rider_master_list',['rider_order_by_dc',$dc->id]) }}" target="_blank" class="card-body text-center p-2 text-white text-white">
                        {{--                <i class="nav-icon i-Gear"></i>--}}
                        <h4 class="mb-0 text-white">{{ $dc->dc_today_order() }}</h4>
                        <span class="item-name font-weight-bold">{{ $dc->name }}</span>
                    </a>
                </div>
            </div>
        @endforeach

    @elseif($menu_type=="graphs-menu")

        @foreach($total_dc as $dc)
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="{{ route('rider_master_list',['dc_rider',$dc->id]) }}" target="_blank" class="card-body text-center p-2 text-white text-white">
                        {{--                <i class="nav-icon i-Gear"></i>--}}
                        <h4 class="mb-0 text-white">{{ $dc->dc_riders_count() }}</h4>
                        <span class="item-name font-weight-bold">{{ $dc->name }}</span>
                    </a>
                </div>
            </div>
        @endforeach

            <div class="col-2 mb-2">
                <div class="card card-icon bg-secondary">
                    <a href="javascript:void(0)" id="download_btn_rider_assigned_dc" class="card-body text-center p-2 text-white text-white">
                        <span class="item-name font-weight-bold">Download</span>
                    </a>
                </div>
            </div>

   @elseif($menu_type=="renewal-menu")

            @foreach($platforms as $dc)
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-warning">
                        <a href="{{ route('rider_master_list',['without_dc_rider',$dc->id]) }}" target="_blank" class="card-body text-center p-2 text-white text-white">
                            {{--                <i class="nav-icon i-Gear"></i>--}}
                            <h4 class="mb-0 text-white">{{ $dc->assign_platforms->where('status','=','1')->whereNotIn('passport_id',$total_rider_array)->count() }}</h4>
                            <span class="item-name font-weight-bold">{{ $dc->name }}</span>
                        </a>
                    </div>
                </div>
    @endforeach
    @elseif($menu_type=="reports-menu")

        @foreach($total_dc as $dc)
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('rider_master_list',['absent_dc_rider',$dc->id]) }}" target="_blank" class="card-body text-center p-2 text-white text-white">
                            <?php  $array_dc_rider = $dc->dc_riders_array_active(); ?>
                        {{--                <i class="nav-icon i-Gear"></i>--}}
                        <h4 class="mb-0 text-white">{{ $dc->today_absent_rider_by_dc($array_dc_rider) }}</h4>
                        <span class="item-name font-weight-bold">{{ $dc->name }}</span>
                    </a>
                </div>
            </div>
        @endforeach

     @elseif($menu_type=="documents-menu")

        @if(isset($manager_ab))
            @foreach($order_not_implement_array as $dc)
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-secondary">
                        <a href="{{ route('rider_not_implement_orders', $dc['user_id'] ) }}" target="_blank" class="card-body text-center p-2 text-white text-white">

                            {{--                <i class="nav-icon i-Gear"></i>--}}
                            <h4 class="mb-0 text-white">{{ $dc['total_order_not_implement'] }}</h4>
                            <span class="item-name font-weight-bold">{{ $dc['name'] }}</span>
                        </a>
                    </div>
                </div>
            @endforeach

        @else
            @foreach($total_dc as $dc)
                <div class="col-2 mb-2">
                    <div class="card card-icon bg-secondary">
                        <a href="{{ route('rider_master_list',['dc_report', $dc->id ]) }}" target="_blank" class="card-body text-center p-2 text-white text-white">

                            {{--                <i class="nav-icon i-Gear"></i>--}}
                            <h4 class="mb-0 text-white">{{ $dc->dc_riders_count() }}</h4>
                            <span class="item-name font-weight-bold">{{ $dc['name'] }} </span>
                        </a>
                    </div>
                </div>
            @endforeach


        @endif


        @endif



</div>
