<option value="" selected disabled>select option of start and end date</option>
@foreach($dates_batch as $date)
    <option value="{{ $date->start_date }}">{{ $date->start_date }} / {{ $date->end_date }}</option>
@endforeach
