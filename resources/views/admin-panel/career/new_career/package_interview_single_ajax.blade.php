<div class="col-md-3 form-group mb-3 ">
    <label for="repair_category">Please Select City</label>
    <h5 id="single_city_name">{{ $city_name }}</h5>
</div>

<div class="col-md-3 form-group mb-3 ">
    <label for="repair_category">Platform Name</label>
    <h5 id="platform_name_single_already">{{ $platform_name }}</h5>
</div>

<div class="col-md-6 form-group mb-3 ">
    <label for="repair_category">Please Select Batch</label>
    <select class="form-control" name="batch_id" id="batch_id_single" required >
        <option value="" selected>select an option</option>
        @foreach ($interview_batches as $batch )
        <option value="{{ $batch->id }}" >{{ $batch->reference_number }}</option>
        @endforeach
    </select>
</div>
