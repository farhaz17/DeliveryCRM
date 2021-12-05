<?php $total_pending_24_ticket = 0; ?>
<?php $total_pending_48_ticket = 0; ?>
<?php $total_pending_72_ticket = 0; ?>
@foreach($admin_tickets as $ticket)

    <?php
    $from = \Carbon\Carbon::parse($ticket->created_at);
    $to = \Carbon\Carbon::now();
    $hours_spend = $to->diffInHours($from);
    $color_code = "";
    $font_color = "";
    if($hours_spend >= 24 && $hours_spend < 48){
        $color_code = "#ed6a07";
        $font_color = "black";
        $total_pending_24_ticket = $total_pending_24_ticket+1;
    }elseif($hours_spend >= 48 && $hours_spend <= 72){
        $color_code = "#ff2a47";
        $font_color = "black";
        $total_pending_48_ticket = $total_pending_48_ticket+1;
    }else if($hours_spend > 72){
        $color_code = "#8b0000";
        $font_color = "white";
        $total_pending_72_ticket = $total_pending_72_ticket+1;
    }
    ?>

        <tr  style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
            <th>{{$ticket->is_checked}}</th>
            <td>{{$ticket->id}}</td>
            <td>
                <a class="text-success mr-2" href="{{route('manage_ticket.show',$ticket->id)}}"><i class="nav-icon i-Ticket font-weight-bold"></i></a>
            </td>
{{--            <td>--}}
{{--                <a class="text-success mr-2 update_btn" id="{{ $ticket->id }}" href="javascript:void(0)"><i class="nav-icon i-Ticket font-weight-bold"></i></a>--}}
{{--            </td>--}}
            <td>{{ $ticket->created_at }}</td>
            <th>{{$ticket->ticket_id}}</th>
            <td>{{$ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ""}}</td>
            <td>{{$ticket->platform_->name}}</td>
            <?php  $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ""; ?>
            <?php  $gamer = array(
                'name' =>  $name,
                'user_id' => $ticket->user_id
            );         ?>
            <?php $inprocess_name_array [] =  $gamer; ?>
            <td>{{$ticket->platform_id}}</td>
            <td>{{$ticket->message}}</td>
            <td>{{isset($ticket->department->name)?$ticket->department->name:""}}</td>
{{--            <td>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</td>--}}
            <?php
            $status = "";
            if($ticket->is_checked="0"){
                $status = "Pending";
            }elseif($ticket->is_checked="2"){
                $status = "In process";
            }elseif($ticket->is_checked="1"){
                $status = "Closed";
            }elseif($ticket->is_checked="3"){
                $status = "Rejected";
            }
            ?>
            <td>{{ $status }}</td>

            <td>
                @if(isset($ticket->image_url))
                    <a href="{{ url($ticket->image_url) }}" target="_blank">
                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($ticket->image_url) }}" alt="">
                    </a>
                @else
                    <span class="badge badge-info">No Image</span>
                @endif

            </td>
            <td>
                @if(isset($ticket->voice_message))
                    <audio controls>
                        <source src="{{ asset($ticket->voice_message) }}" type="audio/ogg">
                        Your browser does not support the audio element.
                    </audio>
                @else
                    <span class="badge badge-info">No Voice</span>
                @endif
            </td>
            <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A'   }}</td>
        </tr>


@endforeach
