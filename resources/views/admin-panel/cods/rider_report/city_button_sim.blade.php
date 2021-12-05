@if (isset($sims))
<div class="row">
    <div class="col-md-12 text-center checkin">
        @forelse ($cities as $city)
            <a class="btn btn-primary btn-sm get_cod_table mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $sims->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-primary btn-sm get_cod_table mb-2" style="color: white;" id="0">
            No City ( {{ $sims->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($sims_checkout))
<div class="row">
    <div class="col-md-12 text-center checkin">
        @forelse ($cities as $city)
            <a class="btn btn-primary btn-sm get_cod_tables mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $sims_checkout->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-primary btn-sm get_cod_tables mb-2" style="color: white;" id="0">
            No City ( {{ $sims_checkout->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($sims_active))
<div class="row">
    <div class="col-md-12 text-center checkin">
        @forelse ($cities as $city)
            <a class="btn btn-primary btn-sm get_cod_tabl mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $sims_active->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-primary btn-sm get_cod_tabl mb-2" style="color: white;" id="0">
            No City ( {{ $sims_active->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($sim_replace_checkins))
<div class="row">
    <div class="col-md-12 text-center checkin">
        @forelse ($cities as $city)
            <a class="btn btn-primary btn-sm replace_checkin mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $sim_replace_checkins->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-primary btn-sm replace_checkin mb-2" style="color: white;" id="0">
            No City ( {{ $sim_replace_checkins->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($sim_replace_checkouts))
<div class="row">
    <div class="col-md-12 text-center checkin">
        @forelse ($cities as $city)
            <a class="btn btn-primary btn-sm replace_checkout mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $sim_replace_checkouts->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-primary btn-sm replace_checkout mb-2" style="color: white;" id="0">
            No City ( {{ $sim_replace_checkouts->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($bike_checkins))
<div class="row">
    <div class="col-md-12 text-center checkout">
        @forelse ($cities as $city)
            <a class="btn btn-info btn-sm bike_checkin mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $bike_checkins->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-info btn-sm bike_checkin mb-2" style="color: white;" id="0">
            No City ( {{ $bike_checkins->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($bike_checkouts))
<div class="row">
    <div class="col-md-12 text-center checkout">
        @forelse ($cities as $city)
            <a class="btn btn-info btn-sm bike_checkout mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $bike_checkouts->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-info btn-sm bike_checkout mb-2" style="color: white;" id="0">
            No City ( {{ $bike_checkouts->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($active_bike))
<div class="row">
    <div class="col-md-12 text-center checkout">
        @forelse ($cities as $city)
            <a class="btn btn-info btn-sm active_bike mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $active_bike->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-info btn-sm active_bike mb-2" style="color: white;" id="0">
            No City ( {{ $active_bike->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($bike_replace_checkin))
<div class="row">
    <div class="col-md-12 text-center checkout">
        @forelse ($cities as $city)
            <a class="btn btn-info btn-sm bike_replace_checkin mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $bike_replace_checkin->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-info btn-sm bike_replace_checkin mb-2" style="color: white;" id="0">
            No City ( {{ $bike_replace_checkin->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@elseif(isset($bike_replace_checkout))
<div class="row">
    <div class="col-md-12 text-center checkout">
        @forelse ($cities as $city)
            <a class="btn btn-info btn-sm bike_replace_checkout mb-2" style="color: white;" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $bike_replace_checkout->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-info btn-sm bike_replace_checkout mb-2" style="color: white;" id="0">
            No City ( {{ $bike_replace_checkout->where('city_id',null)->count() }} )
        </a>
    </div>
</div>
@endif

<script>
    $('.get_cod_table').click(function(){
        var btnValue = $(this).attr("id");
        var token = $("input[name='_token']").val();
        console.log(btnValue);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,btnValue:btnValue},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.get_cod_tables').click(function(){
        var btnValues = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(btnValues);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,btnValues:btnValues},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.get_cod_tabl').click(function(){
        var btnValu = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(btnValu);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,btnValu:btnValu},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.replace_checkin').click(function(){
        var btn = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(btn);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,btn:btn},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.replace_checkout').click(function(){
        var btns = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(btns);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,btns:btns},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.bike_checkin').click(function(){
        var bikecheckin = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(bikecheckin);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,bikecheckin:bikecheckin},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.bike_checkout').click(function(){
        var bikecheckout = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(bikecheckout);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,bikecheckout:bikecheckout},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.active_bike').click(function(){
        var bikeactive = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(bikeactive);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,bikeactive:bikeactive},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.bike_replace_checkin').click(function(){
        var bikereplacecheckin = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(bikereplacecheckin);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,bikereplacecheckin:bikereplacecheckin},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
<script>
    $('.bike_replace_checkout').click(function(){
        var bikereplacecheckout = $(this).attr("id");
        var token = $("input[name='_token']").val();
        // console.log(bikereplacecheckout);
        $.ajax({
            url: "{{ route('get_sim_checkin') }}",
            method: 'POST',
            data: {_token:token,bikereplacecheckout:bikereplacecheckout},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    });
</script>
