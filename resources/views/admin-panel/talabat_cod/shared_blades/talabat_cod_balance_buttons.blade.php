<hr class="m-2">
<div class="text-center" id="codBalanceSubButtonHolder">
    @php
        $Balancebelow500CodCityWiseCount = $cods->where('current_day_balance','<', 500)->count();
        $Balancebelow500CodCityWise = $cods->where('current_day_balance','<', 500)->sum('current_day_balance');
        $Balancebelow500CodCityWisePassportIds = $cods->where('current_day_balance','<', 500)->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $Balancebelow500CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $Balancebelow500CodCityWisePassportIds)->sum('bank');
        $Balancebelow500CodCityWiseNet = $Balancebelow500CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-success btn-sm mb-2 cod_amount_range_buttons" href="#"  id="Balancebelow500CodCityWise">
        Below AED 500 ( {{ number_format($Balancebelow500CodCityWiseNet, 2)}} AED / {{ $Balancebelow500CodCityWiseCount }} )
    </a>
    @php
        $BalanceAbove500CodCityWiseCount = $cods->whereBetween('current_day_balance', [500, 999])->count();
        $BalanceAbove500CodCityWise = $cods->whereBetween('current_day_balance', [500, 999])->sum('current_day_balance');
        $BalanceAbove500CodCityWisePassportIds = $cods->whereBetween('current_day_balance', [500, 999])->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove500CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove500CodCityWisePassportIds)->sum('bank');
        $BalanceAbove500CodCityWiseNet = $BalanceAbove500CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-success btn-sm mb-2 cod_amount_range_buttons" href="#"  id="BalanceAbove500CodCityWise">
        Above AED 500 ( {{ number_format( $BalanceAbove500CodCityWiseNet, 2) }} AED / {{ $BalanceAbove500CodCityWiseCount }} )
    </a>
    @php
        $BalanceAbove1000CodCityWiseCount = $cods->whereBetween('current_day_balance', [1000, 1499])->count();
        $BalanceAbove1000CodCityWise = $cods->whereBetween('current_day_balance', [1000, 1499])->sum('current_day_balance');
        $BalanceAbove1000CodCityWisePassportIds = $cods->whereBetween('current_day_balance', [1000, 1499])->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove1000CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove1000CodCityWisePassportIds)->sum('bank');
        $BalanceAbove1000CodCityWiseNet = $BalanceAbove1000CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-warning btn-sm mb-2 cod_amount_range_buttons" href="#"  id="BalanceAbove1000CodCityWise">
        Above AED 1000 ( {{ number_format( $BalanceAbove1000CodCityWiseNet, 2) }} AED / {{ $BalanceAbove1000CodCityWiseCount }} )
    </a>
    @php
        $BalanceAbove1500CodCityWiseCount = $cods->whereBetween('current_day_balance', [1500, 1999])->count();
        $BalanceAbove1500CodCityWise = $cods->whereBetween('current_day_balance', [1500, 1999])->sum('current_day_balance');
        $BalanceAbove1500CodCityWisePassportIds = $cods->whereBetween('current_day_balance', [1500, 1999])->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove1500CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove1500CodCityWisePassportIds)->sum('bank');
        $BalanceAbove1500CodCityWiseNet = $BalanceAbove1500CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-danger btn-sm mb-2 cod_amount_range_buttons" href="#"  id="BalanceAbove1500CodCityWise">
        Above AED 1500 ( {{ number_format( $BalanceAbove1500CodCityWiseNet, 2) }} AED / {{ $BalanceAbove1500CodCityWiseCount }} )
    </a>
    @php
        $BalanceAbove2000CodCityWiseCount = $cods->whereBetween('current_day_balance', [2000, 2499])->count();
        $BalanceAbove2000CodCityWise = $cods->whereBetween('current_day_balance', [2000, 2499])->sum('current_day_balance');
        $BalanceAbove2000CodCityWisePassportIds = $cods->whereBetween('current_day_balance', [2000, 2499])->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove2000CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove2000CodCityWisePassportIds)->sum('bank');
        $BalanceAbove2000CodCityWiseNet = $BalanceAbove2000CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-danger btn-sm mb-2 cod_amount_range_buttons" href="#"  id="BalanceAbove2000CodCityWise">
        Above AED 2000 ( {{ number_format( $BalanceAbove2000CodCityWiseNet, 2) }} AED / {{ $BalanceAbove2000CodCityWiseCount }} )
    </a>
    @php
        $BalanceAbove2500CodCityWiseCount = $cods->where('current_day_balance', '>', 2500)->count();
        $BalanceAbove2500CodCityWise = $cods->where('current_day_balance', '>', 2500)->sum('current_day_balance');
        $BalanceAbove2500CodCityWisePassportIds = $cods->where('current_day_balance', '>', 2500)->pluck('passport_id');
        $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove2500CodCityWisePassportIds)->sum('cash');
        $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $BalanceAbove2500CodCityWisePassportIds)->sum('bank');
        $BalanceAbove2500CodCityWiseNet = $BalanceAbove2500CodCityWise - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
    @endphp
    <a class="btn btn-danger btn-sm mb-2 cod_amount_range_buttons" href="#"  id="BalanceAbove2500CodCityWise">
        Above AED 2500 ( {{ number_format($BalanceAbove2500CodCityWiseNet, 2) }} AED / {{ $BalanceAbove2500CodCityWiseCount }} )
    </a>
</div>
<hr class="m-2">
<div class="cod_balance_button_holders text-center" id="codBalancebelow500CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalancebelow500CityWiseSubButtonCount = $cods->where('current_day_balance','<', 500)->where('city_id',$city->id)->count();
            $codBalancebelow500CityWiseSubButton = $cods->where('current_day_balance','<', 500)->where('city_id',$city->id)->sum('current_day_balance');
            $codBalancebelow500CityWiseSubButtonPassportIds = $cods->where('current_day_balance','<', 500)->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalancebelow500CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalancebelow500CityWiseSubButtonPassportIds)->sum('bank');
            $codBalancebelow500CityWiseSubButtonNet = $codBalancebelow500CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-success btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 0, 'ending_amount' => 499, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format( $codBalancebelow500CityWiseSubButtonNet , 2)}} AED / {{ $codBalancebelow500CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>

<div class="cod_balance_button_holders text-center" id="codBalanceAbove500CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalanceAbove500CityWiseSubButtonCount = $cods->whereBetween('current_day_balance', [500, 999])->where('city_id',$city->id)->count();
            $codBalanceAbove500CityWiseSubButton = $cods->whereBetween('current_day_balance', [500, 999])->where('city_id',$city->id)->sum('current_day_balance');
            $codBalanceAbove500CityWiseSubButtonPassportIds = $cods->whereBetween('current_day_balance', [500, 999])->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove500CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove500CityWiseSubButtonPassportIds)->sum('bank');
            $codBalanceAbove500CityWiseSubButtonNet = $codBalanceAbove500CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-success btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 500, 'ending_amount' => 999, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format($codBalanceAbove500CityWiseSubButtonNet , 2) }} AED / {{ $codBalanceAbove500CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>
<div class="cod_balance_button_holders text-center" id="codBalanceAbove1000CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalanceAbove1000CityWiseSubButtonCount = $cods->whereBetween('current_day_balance', [1000, 1499])->where('city_id',$city->id)->count();
            $codBalanceAbove1000CityWiseSubButton = $cods->whereBetween('current_day_balance', [1000, 1499])->where('city_id',$city->id)->sum('current_day_balance');
            $codBalanceAbove1000CityWiseSubButtonPassportIds = $cods->whereBetween('current_day_balance', [1000, 1499])->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1000CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1000CityWiseSubButtonPassportIds)->sum('bank');
            $codBalanceAbove1000CityWiseSubButtonNet = $codBalanceAbove1000CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-warning btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 1000, 'ending_amount' => 1499, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format($codBalanceAbove1000CityWiseSubButtonNet, 2) }} AED / {{ $codBalanceAbove1000CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>

<div class="cod_balance_button_holders text-center" id="codBalanceAbove1500CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalanceAbove1500CityWiseSubButtonCount = $cods->whereBetween('current_day_balance', [1500, 1999])->where('city_id',$city->id)->count();
            $codBalanceAbove1500CityWiseSubButton = $cods->whereBetween('current_day_balance', [1500, 1999])->where('city_id',$city->id)->sum('current_day_balance');
            $codBalanceAbove1500CityWiseSubButtonPassportIds = $cods->whereBetween('current_day_balance', [1500, 1999])->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1500CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1500CityWiseSubButtonPassportIds)->sum('bank');
            $codBalanceAbove1500CityWiseSubButtonNet = $codBalanceAbove1500CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-danger btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 1500, 'ending_amount' => 1999, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format($codBalanceAbove1500CityWiseSubButtonNet , 2) }} AED / {{ $codBalanceAbove1500CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>

<div class="cod_balance_button_holders text-center" id="codBalanceAbove2000CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalanceAbove1500CityWiseSubButtonCount = $cods->whereBetween('current_day_balance', [2000, 2499])->where('city_id',$city->id)->count();
            $codBalanceAbove1500CityWiseSubButton = $cods->whereBetween('current_day_balance', [2000, 2499])->where('city_id',$city->id)->sum('current_day_balance');
            $codBalanceAbove1500CityWiseSubButtonPassportIds = $cods->whereBetween('current_day_balance', [2000, 2499])->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1500CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove1500CityWiseSubButtonPassportIds)->sum('bank');
            $codBalanceAbove1500CityWiseSubButtonNet = $codBalanceAbove1500CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-danger btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 2000, 'ending_amount' => 2499, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format( $codBalanceAbove1500CityWiseSubButtonNet, 2) }} AED /  {{ $codBalanceAbove1500CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>

<div class="cod_balance_button_holders text-center" id="codBalanceAbove2500CityWiseSubButtonHolder" style="display:none">
    @forelse ($cities as $city)
        @php
            $codBalanceAbove2500CityWiseSubButtonCount = $cods->where('current_day_balance', '>', 2500)->where('city_id',$city->id)->count();
            $codBalanceAbove2500CityWiseSubButton = $cods->where('current_day_balance', '>', 2500)->where('city_id',$city->id)->sum('current_day_balance');
            $codBalanceAbove2500CityWiseSubButtonPassportIds = $cods->where('current_day_balance', '>', 2500)->where('city_id',$city->id)->pluck('passport_id');
            $internal_cod_adjustments_cash = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove2500CityWiseSubButtonPassportIds)->sum('cash');
            $internal_cod_adjustments_bank = $internal_cod_adjustments->whereIn('passport_id', $codBalanceAbove2500CityWiseSubButtonPassportIds)->sum('bank');
            $codBalanceAbove2500CityWiseSubButtonNet = $codBalanceAbove2500CityWiseSubButton - ($internal_cod_adjustments_cash + $internal_cod_adjustments_bank);
        @endphp
        <a class="btn btn-danger btn-sm get_cod_table mb-2 cod_amount_range_buttons" href="{{ route('ajax_talabat_user_wise_riders_cod_analysis',['city_id'=>  $city->id ,'searchBy'=>'current_day_balance', 'starting_amount' => 2500, 'ending_amount' => 10000, 'dc_id' => $dc_id, 'adjustment_type' => $adjustment_type]) }}" >
            {{ $city->city_code }} ( {{ number_format( $codBalanceAbove2500CityWiseSubButtonNet, 2 ) }} AED / {{ $codBalanceAbove2500CityWiseSubButtonCount }} )
        </a>
    @empty

    @endforelse
</div>
<hr class="m-2">
<script>
    $('#Balancebelow500CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalancebelow500CityWiseSubButtonHolder').show(300)
    });

    $('#BalanceAbove500CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalanceAbove500CityWiseSubButtonHolder').show(300)
    });

    $('#BalanceAbove1000CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalanceAbove1000CityWiseSubButtonHolder').show(300)
    });
    $('#BalanceAbove1500CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalanceAbove1500CityWiseSubButtonHolder').show(300)
    });

    $('#BalanceAbove2000CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalanceAbove2000CityWiseSubButtonHolder').show(300)
    });

    $('#BalanceAbove2500CodCityWise').click(function(){
        $('.cod_amount_range_buttons').removeClass('active');
        $(this).addClass('active')
        $('#codReportTable_wrapper').empty()
        $('.cod_balance_button_holders').hide(300);
        $('#codBalanceAbove2500CityWiseSubButtonHolder').show(300)
    });
</script>

<script>
    $('.get_cod_table').click(function(e){
        $("body").addClass("loading");
        $('.get_cod_table').removeClass('active')
        $(this).addClass('active');
        e.preventDefault();
        var url = $(this).attr('href') + '&start_date=' + $("#start_date").val();
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
