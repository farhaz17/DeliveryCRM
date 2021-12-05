<div class="col-md-12 form-group mb-3">
    <label for="repair_category">Select Dc</label>
    <select class="form-control" name="dc_id" id="dc_id"  required >
        <option value="" selected disabled>select dc</option>
        @foreach ($userData as $row)
            <option value="{{ $row->id}}">{{ $row->name }}</option>
        @endforeach
    </select>
</div>
