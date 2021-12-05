<div class="row">
    <div class="col-md-12 text-center" id="checkout">
        @forelse ($cities as $city)
            <a class="btn btn-danger btn-sm get_cod_table mb-2" style="color: white;" onclick="platfo_getid(this)" id="{{$city->id}}">
                {{ $city->city_code }} ( {{ $platforms->where('city_id',$city->id)->count() }} )
            </a>
        @empty
        @endforelse
        <a class="btn btn-danger btn-sm get_cod_table mb-2" style="color: white;" onclick="platfo_getid(this)" id="">
            No City ( {{ $platforms->where('city_id',null)->count() }} )
        </a>
    </div>
</div>

<script>
    function platfo_getid(value) {
        var btnValue = value.id;
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('get_platforms_checkout') }}",
            method: 'POST',
            data: {_token:token,btnValue:btnValue},
            success: function(response) {
                $('#platform_buttons').empty();
                $('#platform_buttons').append(response);
            }
        });
    }
</script>
