@if($status=="0")

    @foreach($riders as $rider)
        <tr>
            <th scope="row">#</th>
            <td>{{ $rider->check_in_request->rider_name->personal_info->full_name  }}</td>
            <td>{{ $rider->check_in_request->rider_name->passport_no  }}</td>
            <td>{{ $rider->check_in_request->rider_name->personal_info->personal_mob  }}</td>
            <td>{{ $rider->check_in_request->rider_name->nation->name  }}</td>
            <td>{{ $rider->dc_detail->name  }}</td>
            <td>{{ $rider->created_at->toDateString()  }}</td>
            <?php  $assigned = $rider->checkin_assign_platform() ?>
            <td>{{ isset($assigned) ? $assigned->plateformdetail->name : 'N/A'  }}</td>
            <td>{{  $rider->check_in_request->request_approved_by->name }}</td>
            <td>
                @if($rider->request_status=="0")

                    @if(isset($assigned))
                        <a class="text-primary mr-2 accept_request_cls" id="{{ $rider->id }}" data-status="0" href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
                    @else
                        <h5  class="badge badge-info">Rider Checked Out</h5>
                    @endif
                @else

                @endif
            </td>

        </tr>

    @endforeach
@else
    @foreach($riders as $rider)
        <tr>
            <th scope="row">#</th>
            <td>{{ $rider->check_in_request->rider_name->personal_info->full_name  }}</td>
            <td>{{ $rider->check_in_request->rider_name->passport_no  }}</td>
            <td>{{ $rider->check_in_request->rider_name->personal_info->personal_mob  }}</td>
            <td>{{ $rider->check_in_request->rider_name->nation->name  }}</td>
            <td>{{ $rider->dc_detail->name  }}</td>
            <td>{{ $rider->created_at->toDateString()  }}</td>
            <?php  $assigned = $rider->checkin_assign_platform() ?>
            <td>{{ isset($assigned) ? $assigned->plateformdetail->name : 'N/A'  }}</td>
            <td>{{  $rider->check_in_request->request_approved_by->name }}</td>

        </tr>

    @endforeach



@endif
