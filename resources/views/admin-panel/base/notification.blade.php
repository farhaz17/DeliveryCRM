@foreach(auth()->user()->unreadNotifications->take(100) as $notification)

    <div class="dropdown-item d-flex">
        <div class="notification-icon">

            <i class="i-Empty-Box text-danger mr-1"></i>
        </div>
        <div class="notification-details flex-grow-1">

            <a onclick="updateNotification({{$notification->idd}})">
                <p class="m-0 d-flex align-items-center">
                    <span>
                        {{$notification->data['message']}}
                        {{-- dabo dabo dabo --}}
                    </span>
                    @if(!empty($notification->data['ticket']['ticket_id']))
                    {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$invItem->quantity_balance}}</span>--}}
                    <span class="badge badge-pill badge-danger ml-1 mr-1">{{isset($notification->data['ticket']['ticket_id'])?$notification->data['ticket']['ticket_id']:""}}</span>
                    @elseif(!empty($notification->data['repair_parts_verified']['id']))
                    <span class="badge badge-pill badge-danger ml-1 mr-1">
                    {{isset($notification->data['repair_parts_verified']['entry_no'])?$notification->data['repair_parts_verified']['entry_no']:""}}
                    </span>
                    @else
                    <span class="badge badge-pill badge-danger ml-1 mr-1">
                        {{isset($notification->data['repair_parts_request']['entry_no'])?$notification->data['repair_parts_request']['entry_no']:""}}
                    </span>

                    @endif
                        <span class="flex-grow-1"></span>
                </p>
            </a>

            <form action="" id="notificationForm" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
            </form>
        </div>
    </div>


@endforeach
