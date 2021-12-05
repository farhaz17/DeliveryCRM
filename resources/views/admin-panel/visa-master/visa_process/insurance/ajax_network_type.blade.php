{{-- <label for="repair_category">Network Type </label>
<input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->network_type:""}}"
id="network_type" name="network_type" type="text" placeholder="Enter Network Type" /> --}}


<select id="network_type"  name="network_type" class="form-control">
    <option value=""  >Select option</option>
    @foreach($network_type as $row)
    @php
    $isSelected=(isset($edit_takaful)?$edit_takaful->network_type:"")==$row->id;
@endphp


        <option  value="{{$row->id}}" {{ $isSelected ? 'selected': '' }} >{{ $row->network_type  }}</option>
    @endforeach
</select>
<script>
     $('#network_type').select2({
        placeholder: 'Select an option'
    });
</script>
