@if($status=="2")

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
                <h5  class="badge badge-info">{{ $rider->children_total_count() }}</h5>
            </td>
            <td>
                @if($rider->children_total_count()>0)
                    <?php  $last_status = $rider->get_the_latest_child(); ?>
                        @if($last_status->request_status=="2")
                            <a class="text-primary mr-2 reject_request_cls" id="{{ $rider->id }}"  href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
                        @elseif($last_status->request_status=="0")
                            <h5  class="badge badge-success">status Pending</h5>
                         @elseif($last_status->request_status=="1")
                            <h5  class="badge badge-success">status Accepted</h5>
                        @endif
                @else
                    <a class="text-primary mr-2 reject_request_cls" id="{{ $rider->id }}"  href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
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
