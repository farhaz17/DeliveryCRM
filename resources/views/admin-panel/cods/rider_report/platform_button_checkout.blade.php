<div class="row plat_class">
    <div class="col-md-12 text-center">
        @forelse ($platforms as $platform)
            <a class="btn btn-danger btn-sm get_cod_table mb-2" href="{{ route('get_platforms_checkouts',['platform'=>  $platform->plateform ,'city_id'=>$platform->city_id]) }}" id="">
                {{ $platform->plateformdetail->name }} ( {{ $platformss->where('plateform',$platform->plateform)->count() }} )
            </a>
        @empty
        @endforelse
    </div>
</div>

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
