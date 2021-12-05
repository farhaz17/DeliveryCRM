<input type="hidden" value="{{ $selected_platform['performance_model'] }}" name="performance_model">
<input type="hidden" value="{{ $selected_platform['date_column_name'] }}" name="date_column_name">
<label for="platform_columns">Selected Platform Columns</label>
<select
    class="form-control form-control-sm select2"
    {{-- name="platform_columns[]" --}}
    id="platform_columns"
    multiple
    required
    >
    <option value="">Select Columns</option>
    @if($selected_platform != null)
        @foreach($selected_platform['columns'] as $columns)
            <option value="{{ $columns['name'] }}">{{ $columns['label'] }}</option>
        @endforeach
    @endif
</select>
<input type="hidden" id="selected_platform_id" value="{{ $selected_platform != null ? $selected_platform['platform_id'] : '' }}">
<script>
    $('#platform_columns, #platform_id').change(function(){
        $('#column_settings_holder').empty();
        $('#column_settings_holder').append(`<h1 class="font-weight-bold pt-2 text-15 text-center text-light">Click Load selected columns button to load columns settings</h1>`);
        if($(this).val().length > 0){
            $('#load_column_settings_button').prop('disabled', false);
        }else{
            $('#load_column_settings_button').prop('disabled', true);
        }
    });
</script>
