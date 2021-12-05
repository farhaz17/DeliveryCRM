<label class="col-form-label" for="vehicle_sub_category_id">Sub Category</label>
<select name="vehicle_sub_category_id" id="vehicle_sub_category_id" class="form-control form-control-sm">
    <option value="" disabled selected>Select One</option>
    @forelse ($vehicle_sub_categories as $vehicle_category)
        <option value="{{ $vehicle_category->id }}">{{ $vehicle_category->name ?? '' }}</option>
    @empty
        
    @endforelse
</select>