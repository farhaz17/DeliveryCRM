<label>Select SubCategory</label>
<select class="form-control" name="sub_category"  id="sub_category" required>
 <option value="" selected disabled>select category</option>
 @foreach($sub_categories as $cat)
 <option value="{{ $cat->id }}">{{ $cat->name }}</option>
 @endforeach
</select>
