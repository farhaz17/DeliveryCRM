
@foreach($passports as $passport)


    <tr>
        <td>
            {{--            <input class="append_elements" type="checkbox" id="user_ids" name="user_ids[]" value="{{ $career->id }}">--}}

            <label class="checkbox checkbox-outline-primary" >
                <input type="checkbox"  id="user_ids" name="user_ids[]" value="{{ $passport->id }}" ><span class="checkmark"></span>
            </label>
        </td>
        <td>{{ isset($passport->personal_info->full_name) ? $passport->personal_info->full_name : 'N/A' }}</td>
        <td>{{ $passport->passport_no }}</td>
        <td>{{ $passport->phone }}</td>
        <td>{{ $passport->nation->name }}</td>
    </tr>
@endforeach
@if(count($passports)>0)
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
