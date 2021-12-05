
@if($status!="0")
@foreach($requests as $ab)
        <tr>

            <td>{{ $ab->id }}</td>
            <td>{{ $ab->rider_name->personal_info->full_name }}</td>
            <td>{{ $ab->rider_name->passport_no }}</td>
            <td>{{ $ab->checkout_date }}</td>
            <td>{{ $array_type[$ab->request_type] }}</td>
            <td>{{ isset($ab->rider_name->rider_zds_code) ? $ab->rider_name->rider_zds_code->zds_code : 'N/A' }}</td>
            <td>{{ $ab->rider_name->pp_uid }}</td>
            <td>{{ $ab->bike->plate_no }}</td>
            <td>{{ $ab->remarks }}</td>
            <td>{{ isset($ab->requested_by->name) ? $ab->requested_by->name : 'N/A' }}</td>
            <td>{{ isset($ab->accepted_by->name) ? $ab->accepted_by->name : 'N/A' }}</td>


        </tr>
@endforeach
@else


    @foreach($requests  as $ab)
    <tr>

        <td>{{ $ab->id }}</td>
        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
        <td>{{ $ab->rider_name->passport_no }}</td>
        <td>{{ $ab->checkout_date }}</td>
        <td>{{ $array_type[$ab->request_type] }}</td>
        <td>{{ isset($ab->rider_name->rider_zds_code) ? $ab->rider_name->rider_zds_code->zds_code : 'N/A' }}</td>
        <td>{{ $ab->rider_name->pp_uid }}</td>
        <td>{{ $ab->bike->plate_no }}</td>
        <td>{{ $ab->remarks }}</td>
        <td>{{ date('d-m-Y', strtotime($ab->created_at)) }}</td>
        <td>{{ isset($ab->requested_by->name) ? $ab->requested_by->name : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $ab->id }}" data-status="0" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        </td>
    </tr>
@endforeach

@endif
