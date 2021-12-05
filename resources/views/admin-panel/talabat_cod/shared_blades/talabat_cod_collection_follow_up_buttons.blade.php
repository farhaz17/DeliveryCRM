<hr class="m-2">
<div class="text-center" id="codCollectionSubButtonHolder" style="">
    @php
        $Codbelow300CodCityWiseCount = $cods->where('current_day_cod','<', 300)->count();
        $Codbelow300CodCityWise = $cods->where('current_day_cod','<', 300)->sum('current_day_cod');
        $Codbelow300CodCityWisePassportIds = $cods->where('current_day_cod','<', 300)->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $Codbelow300CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $Codbelow300CodCityWisePassportIds)->sum('bank');
        $Codbelow300CodCityWiseNet = $Codbelow300CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-success btn-sm mb-2" href="#" id="Codbelow300CodCityWise">
        Below AED 300 ( {{ number_format( $Codbelow300CodCityWiseNet, 2) }} AED / {{  $Codbelow300CodCityWiseCount }} )
    </a>
    @php
        $Codabove300CodCityWiseCount = $cods->where('current_day_cod','>=', 300)->count();
        $Codabove300CodCityWise = $cods->where('current_day_cod','>=', 300)->sum('current_day_cod');
        $Codabove300CodCityWisePassportIds = $cods->where('current_day_cod','>=', 300)->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $Codabove300CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $Codabove300CodCityWisePassportIds)->sum('bank');
        $Codabove300CodCityWiseNet = $Codabove300CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-danger btn-sm mb-2" href="#" id="Codabove300CodCityWise">
        Above AED 300 ( {{ number_format( $Codabove300CodCityWiseNet, 2) }} AED / {{ $Codabove300CodCityWiseCount }} )
    </a>
</div>
<hr class="m-2">
<div id="codCollectionbelow300CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codCollectionbelow300CityWiseSubButtonCount = $cods->where('current_day_cod','<', 300)->where('city_id',$city->id)->count();
            $codCollectionbelow300CityWiseSubButton = $cods->where('current_day_cod','<', 300)->where('city_id',$city->id)->sum('current_day_cod');
            $codCollectionbelow300CityWiseSubButtonPassportIds = $cods->where('current_day_cod','<', 300)->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codCollectionbelow300CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codCollectionbelow300CityWiseSubButtonPassportIds)->sum('bank');
            $codCollectionbelow300CityWiseSubButtonNet = $codCollectionbelow300CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-success btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_follow_up',['city_id'=>  $city->id ,'searchBy'=>'current_day_cod', 'starting_amount' => 0, 'ending_amount' => 300, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" id="">
            {{ $city->city_code }} ( {{ number_format( $codCollectionbelow300CityWiseSubButtonNet, 2) }} AED / {{ $codCollectionbelow300CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>
<div id="codCollectionAbove300CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
        $codCollectionAbove300CityWiseSubButtonCount = $cods->where('current_day_cod','>=', 300)->where('city_id',$city->id)->count();
        $codCollectionAbove300CityWiseSubButton = $cods->where('current_day_cod','>=', 300)->where('city_id',$city->id)->sum('current_day_cod');
        $codCollectionAbove300CityWiseSubButtonPassportIds = $cods->where('current_day_cod','>=', 300)->where('city_id',$city->id)->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codCollectionAbove300CityWiseSubButtonPassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codCollectionAbove300CityWiseSubButtonPassportIds)->sum('bank');
        $codCollectionAbove300CityWiseSubButtonNet = $codCollectionAbove300CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-danger btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_follow_up',['city_id'=>  $city->id ,'searchBy'=>'current_day_cod', 'starting_amount' => 300, 'ending_amount' => 10000, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" id="">
        {{ $city->city_code }} ( {{ number_format($codCollectionAbove300CityWiseSubButtonNet, 2) }} AED / {{ $codCollectionAbove300CityWiseSubButtonCount }} )
    </a>
    @empty

    @endforelse
</div>
<hr class="m-2">
<script>
    $('#Codbelow300CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('#codCollectionbelow300CityWiseSubButtonHolder').show(300)
        $('#codCollectionAbove300CityWiseSubButtonHolder').hide(300)
    })
    $('#Codabove300CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('#codCollectionAbove300CityWiseSubButtonHolder').show(300)
        $('#codCollectionbelow300CityWiseSubButtonHolder').hide(300)
    })
</script>


<script>
    $('.get_cod_table').click(function(e){
        $("body").addClass("loading");
        $('.get_cod_table').removeClass('active')
        $(this).addClass('active');
        e.preventDefault();
        var url = $(this).attr('href') + '&start_date=' + $("#start_date").val() + '&city_wise_button_id=' + $(this).attr('id');
        $.ajax({
            url,
            success: function(response){
                $('#codReportTableHolder').empty()
                $('#codReportTableHolder').append(response.html)
                $("body").removeClass("loading");
            }
        });
    });

</script>
