
@foreach($careers as $career)


    <tr>
        <td>
{{--            <input class="append_elements" type="checkbox" id="user_ids" name="user_ids[]" value="{{ $career->id }}">--}}

            <label class="checkbox checkbox-outline-primary" >
                <input type="checkbox"  id="user_ids" name="user_ids[]" value="{{ $career->passport_detail->id }}" ><span class="checkmark"></span>
            </label>
            </td>
        <td>{{ isset($career->passport_detail->personal_info->full_name) ? $career->passport_detail->personal_info->full_name : 'N/A' }}</td>
        <td>{{ $career->passport_detail->passport_no }}</td>
        <td>{{ $career->passport_detail->phone }}</td>
        <td>{{ $career->passport_detail->nation->name }}</td>
    </tr>
@endforeach
@if(count($careers)>0)
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <button class="btn btn-primary pull-right"  type="submit">Save</button>
    </td>
</tr>
   @endif
