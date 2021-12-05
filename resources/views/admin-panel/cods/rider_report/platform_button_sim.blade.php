@if (isset($sims))
<div class="row">
    <div class="col-md-12 text-center sim_plat">
        @forelse ($sims as $sim)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'checkin']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $simss->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($sims_checkout))
<div class="row">
    <div class="col-md-12 text-center sim_plat">
        @forelse ($sims_checkout as $sim)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'checkout']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $sims_checkouts->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($sims_active))
<div class="row">
    <div class="col-md-12 text-center sim_plat">
        @forelse ($sims_active as $sim)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'active']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $sims_actives->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($sim_replace_checkin))
<div class="row">
    <div class="col-md-12 text-center sim_plat">
        @forelse ($sim_replace_checkin as $sim)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'replace_checkin']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $sim_replace_checkins->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($sim_replace_checkout))
<div class="row">
    <div class="col-md-12 text-center sim_plat">
        @forelse ($sim_replace_checkout as $sim)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'replace_checkout']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $sim_replace_checkouts->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($bike_checkins))
<div class="row">
    <div class="col-md-12 text-center bike_plat">
        @forelse ($bike_checkins as $sim)
            <a class="btn btn-info btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'bike_checkin']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $bike_checkinss->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($bike_checkouts))
<div class="row">
    <div class="col-md-12 text-center bike_plat">
        @forelse ($bike_checkouts as $sim)
            <a class="btn btn-info btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'bike_checkout']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $bike_checkoutss->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($bike_actives))
<div class="row">
    <div class="col-md-12 text-center bike_plat">
        @forelse ($bike_actives as $sim)
            <a class="btn btn-info btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'bike_active']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $bike_activess->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($bike_replace_checkins))
<div class="row">
    <div class="col-md-12 text-center bike_plat">
        @forelse ($bike_replace_checkins as $sim)
            <a class="btn btn-info btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'bike_replace_checkin']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $bike_replace_checkinss->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@elseif(isset($bike_replace_checkouts))
<div class="row">
    <div class="col-md-12 text-center bike_plat">
        @forelse ($bike_replace_checkouts as $sim)
            <a class="btn btn-info btn-sm get_cod_table mb-2" href="{{ route('get_platforms_sim',['platform'=>  $sim->plateform ,'city_id'=>$sim->city_id ,'type'=>'bike_replace_checkout']) }}" id="">
                {{ $sim->plateformdetail->name }} ( {{ $bike_replace_checkoutss->where('plateform',$sim->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>
@endif

<script>
    $('.get_cod_table').click(function(e){
        $("body").addClass("loading");
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url,
            success: function(response){
                $('.append_div').empty()
                $('.append_div').append(response.html)
                $("body").removeClass("loading");
            }
        });
    });
</script>

