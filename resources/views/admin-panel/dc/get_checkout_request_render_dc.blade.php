@if($status!="0")
@foreach($requests as $ab)
    <tr>
        <td>{{ $ab->id }}</td>
        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
        <td>{{ $ab->rider_name->passport_no }}</td>
        <td>{{ $ab->checkout_date_time }}</td>
        <td>{{ $checkout_type_array[$ab->checkout_type] }}</td>
        <td>{{ $ab->rider_name->rider_zds_code->zds_code }}</td>
        <td>{{ $ab->rider_name->pp_uid }}</td>
        <?php
         if($ab->rider_name->assign_platforms_checkin()){
                $rider_platform = $ab->rider_name->assign_platforms_checkin();


                $platform_cod = $ab->rider_name->check_platform_code_exist_by_platform($rider_platform->plateform);
            }
             ?>

        <td>{{ isset($platform_cod) ? $platform_cod->platform_code : 'N/A'  }}</td>
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
        <td>{{ $ab->checkout_date_time }}</td>
        <td>{{ $checkout_type_array[$ab->checkout_type] }}</td>
        <td>{{ $ab->rider_name->rider_zds_code->zds_code }}</td>
        <td>{{ $ab->rider_name->pp_uid }}</td>
        <?php
         if($ab->rider_name->assign_platforms_checkin()){
                $rider_platform = $ab->rider_name->assign_platforms_checkin();


                $platform_cod = $ab->rider_name->check_platform_code_exist_by_platform($rider_platform->plateform);
            }
             ?>

        <td>{{ isset($platform_cod) ? $platform_cod->platform_code : 'N/A'  }}</td>
        <td>{{ $status_array[$ab->request_status] }}</td>
        <td>{{ isset($ab->request_by->name) ? $ab->request_by->name : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $ab->id }}"  data-status="{{ $ab->request_status }}"  href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        </td>
    </tr>
    @endforeach


@endif
