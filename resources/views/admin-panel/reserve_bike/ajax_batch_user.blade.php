@if(!empty($reserved_variable))

    @foreach($reserve_bikes as $bike)
    <tr>
        <td>{{ $bike->passport->personal_info->full_name }}</td>
        <td>{{ $bike->passport->passport_no }}</td>
        <td>{{ $bike->passport->nation->name }}</td>
        <td>{{ $bike->reserve_bike->plate_no }} </td>
        <td>{{ $bike->reserve_sim->account_number }} </td>
    </tr>
    @endforeach

@else

@foreach($create_interviews as $inter)
<tr>
    <td>{{ $inter->passport->personal_info->full_name }}</td>
    <td>{{ $inter->passport->passport_no }}</td>
    <td>{{ $inter->passport->nation->name }}</td>
    <td>
        @if(!empty($inter->passport->reserve_bike))
            <input type="text" class="form-control" readonly value="{{  $inter->passport->reserve_bike->reserve_bike->plate_no }}">
         @else
        <select class="form-control bike_select_cls" id="bike_select-{{ $inter->passport_id }}" >
            @foreach($checked_out as $bike)
                <option value="">select an option</option>
                @if($bike["cencel"]=="")
                    <option value="{{ $bike["id"] }}">{{ $bike["bike"]  }}</option>
                @else
                @endif
            @endforeach
        </select>
            @endif
    </td>
    <td>
        @if(!empty($inter->passport->reserve_bike))
            <input type="text" class="form-control" readonly value="{{  $inter->passport->reserve_bike->reserve_sim->account_number }}">
        @else
        <select class="form-control sim_select_cls" id="sim_select-{{ $inter->passport_id }}">
            <option value="">select an option</option>
            @foreach($checked_out_sim as $sim)
                    <option value="{{ $sim["id"] }}">{{ $sim["sim_number"]  }}</option>
            @endforeach
        </select>
        @endif
    </td>
    <td>
        @if(!empty($inter->passport->reserve_bike))
            <span class="badge badge-pill badge-success p-2 m-1">Reserved</span>
        @else
            <button id="{{ $inter->passport_id }}" class="btn btn-info btn-icon m-1 update_button_ab_zds update_button_formate" type="button"><span class="ul-btn__icon"><i class="i-Yes"></i></span></button>
            @endif

    </td>
</tr>
@endforeach

@endif
