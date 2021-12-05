@if (count($columns))
    @foreach ($columns as $column)
    <div class="row border-bottom mb-2">
        <div class="title col-12 text-uppercase">Column Settings <b>( {{ $column['label'] }} )</b> |  Values should be in between <b>( {{ $column['lowest_value'] }} </b> and  <b> {{ $column['highest_value'] }} )</b></div>
        <input type="hidden" name="column_settings[{{$column['name']}}][label]" value="{{ $column['label'] }}">
        <input type="hidden" name="column_settings[{{$column['name']}}][name]" value="{{ $column['name'] }}">
        <input type="hidden" name="column_settings[{{$column['name']}}][highest_value]" value="{{ $column['highest_value'] }}">
        <input type="hidden" name="column_settings[{{$column['name']}}][lowest_value]" value="{{ $column['lowest_value'] }}">
        <div class="col-md-2 form-group mb-3">
            <label for="profitability_indicator">Profitability Indicator</label>
            <select
                    class="form-control form-control-sm profitability_indicators"
                    name="column_settings[{{$column['name']}}][profitability_indicator]"
                    data-input_holder = "#{{$column['name']}}_profitability_indicator"
                    data-column_name = "{{$column['name']}}"
                >
                <option value="" disabled selected>Select Profitability Indicator</option>
                <option value="1">Highest is Profitable</option>
                <option value="2">Lowest is Profitable</option>
            </select>
        </div>
        <div
            class="col-md-10 row"
            style="display: grid; grid-template-columns: 8% 12% 8% 12% 8% 12% 8% 12% 8% 12%; grid-gap: 10px; text-align: center; margin-top: 20px;"
            id="{{$column['name']}}_profitability_indicator"
            >
        </div>
    </div>
    @endforeach
@endif
<script>
    $('.profitability_indicators').change(function(){
        var profitablity_indicator = $(this).val();
        var input_holder = $(this).attr('data-input_holder')
        var column_name = $(this).attr('data-column_name')
        $.ajax({
            url: "{{ route('ajax_profitablity_indicator_wise_setting_inputs') }}",
            data: { profitablity_indicator, column_name },
            success: function(response){
                $(input_holder).empty()
                $(input_holder).append(response.html)
            }
        });
    })
</script>
