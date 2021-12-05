@foreach($rider_fuel  as $fuel)
<?php $image_url =  ltrim($fuel->image, $fuel->image[0]); ?>
    @if($status == 0)
    <tr id="row-{{ $fuel->id  }}">
        <span style="display: none"  id="bike-{{$fuel->id}}">{{trim($fuel->passport->assign_bike_check()?$fuel->passport->assign_bike_check()->bike_plate_number->plate_no:"N/A")}}</span>
        <span style="display: none"  id="sim-{{$fuel->id}}">{{$fuel->passport->assign_sim_check()?$fuel->passport->assign_sim_check()->telecome->account_number:"N/A"}}</span>
        <th scope="row">{{ $fuel->id  }}</th>
        <td>{{ $fuel->created_at->toDateString()  }}</td>
        <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
        <td><a  id="image-{{ $fuel->id }}" href="{{Storage::temporaryUrl($image_url, now()->addMinutes(120)) }}" target="_blank">See Image</a></td>
        <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
        <td>Pending</td>
        <?php
            $platform_g = $fuel->passport->get_the_rider_id_by_platform($fuel->platform_id);
        ?>
        <td>{{ isset($platform_g->platform_code) ? $platform_g->platform_code : 'N/A' }}</td>
        <td>{{ isset($fuel->passport->rider_zds_code->zds_code) ? $fuel->passport->rider_zds_code->zds_code : 'N/A'  }}</td>
        <td>{{ isset($fuel->platform->name) ? $fuel->platform->name : 'N/A' }}</td>
        <td>
            <a class="text-success mr-2 edit_cls" id="{{ $fuel->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
        </td>
    </tr>
    @elseif($status == 1)
    <tr>
        <th scope="row">{{ $fuel->id  }}</th>
        <td>{{ $fuel->created_at->toDateString()  }}</td>
        <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
        <td><a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(120)) }}" target="_blank">See Image</a></td>
        <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
        <td>Approved</td>
        <?php
        $platform_g = $fuel->passport->get_the_rider_id_by_platform($fuel->platform_id);
        ?>
        <td>{{ isset($platform_g->platform_code) ? $platform_g->platform_code : 'N/A' }}</td>
        <td>{{ isset($fuel->passport->rider_zds_code->zds_code) ? $fuel->passport->rider_zds_code->zds_code : 'N/A'  }}</td>
        <td>{{ isset($fuel->platform->name) ? $fuel->platform->name : 'N/A' }}</td>
        <td>{{ isset($fuel->action_user_by->name) ? $fuel->action_user_by->name : 'N/A'  }}</td>

    </tr>
    @elseif($status == 2)
    <tr>
        <th scope="row">{{ $fuel->id  }}</th>
        <td>{{ $fuel->created_at->toDateString()  }}</td>
        <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
        <td><a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(120)) }}" target="_blank">See Image</a></td>
        <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
        <td>Rejected</td>
        <?php

        $platform_g = $fuel->passport->get_the_rider_id_by_platform($fuel->platform_id);
        ?>
        <td>{{ isset($platform_g->platform_code) ? $platform_g->platform_code : 'N/A' }}</td>
        <td>{{ isset($fuel->passport->rider_zds_code->zds_code) ? $fuel->passport->rider_zds_code->zds_code : 'N/A'  }}</td>
        <td>{{ isset($fuel->platform->name) ? $fuel->platform->name : 'N/A' }}</td>
        <td>{{ isset($fuel->action_user_by->name) ? $fuel->action_user_by->name : 'N/A'  }}</td>
        <td>
            @if($fuel->remarks=='1')
            <span class="badge badge-danger m-2">Wrong Vehicle</span>
            @elseif($fuel->remarks=='2')
            @else
            <span class="badge badge-danger m-2">Wrong Date</span>
            @endif
          </td>

    </tr>
    @endif
@endforeach
