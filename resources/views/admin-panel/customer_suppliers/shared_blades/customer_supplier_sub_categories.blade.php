<label for="contact_sub_category_id">Sub-Category</label>
<select class="form-control form-control-sm select2" name="contact_sub_category_id" id="contact_sub_category_id" required>
    <option value="">Select Sub Category</option>
@foreach ($sub_categories as $sub_category)
    <option value="{{ $sub_category->id }}">{{ $sub_category->name ?? "" }}</option>
@endforeach
    
</select>