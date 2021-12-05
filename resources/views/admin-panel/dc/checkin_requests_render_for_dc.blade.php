
@if($status!="0")
@foreach($requests as $ab)
    <tr>
        <td>{{ $ab->id }}</td>
        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
        <td>{{ $ab->rider_name->passport_no }}</td>
        <td>{{ $ab->checkin_date_time }}</td>
        <td>{{ $ab->platform->name }}</td>
        <td>{{ $status_array[$ab->request_status] }}</td>
        <td>{{ isset($ab->request_approved_by->name) ? $ab->request_approved_by->name : 'N/A' }}</td>
        <td>{{ isset($ab->request_by->name) ? $ab->request_by->name : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $ab->id }}" data-status="{{ $ab->request_status }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        </td>
    </tr>
@endforeach
@else

@foreach($requests as $ab)
    <tr>
        <td>{{ $ab->id }}</td>
        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
        <td>{{ $ab->rider_name->passport_no }}</td>
        <td>{{ $ab->checkin_date_time }}</td>
        <td>{{ $ab->platform->name }}</td>
        <td>{{ $status_array[$ab->request_status] }}</td>
        <td>{{ isset($ab->request_by->name) ? $ab->request_by->name : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $ab->id }}" data-status="{{ $ab->request_status }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        </td>
    </tr>
@endforeach

@endif
