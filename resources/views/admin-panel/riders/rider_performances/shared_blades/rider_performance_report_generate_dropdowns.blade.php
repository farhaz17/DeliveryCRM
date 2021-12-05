@if ($rider_performances->count())
<div class="form-group">
    <label for="performance_id">Select Performance Date</label>
    <select class="form-control form-control-sm select2" id="performance_id" name="performance_id" required>
        <option value="">Select Performance Date</option>
        @foreach ($rider_performances as $performance)
            <option value="{{ $performance->id }}">{{ dateToRead($performance->start_date) }}</option>
        @endforeach
    </select>
</div>
@else
<div class="form-group">
    <label for="performance_id">Select Performance Date</label>
    <select class="form-control form-control-sm select2" id="performance_id" name="performance_id" required>
        <option value="">Select Performance Date</option>
    </select>
</div>
@endif
