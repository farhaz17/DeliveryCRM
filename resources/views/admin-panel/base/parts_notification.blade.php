@foreach(auth()->user()->unreadNotifications_parts->take(100) as $notification3)

    <div class="dropdown-item d-flex">
        <div class="notification-icon">
            <i class="i-Empty-Box text-danger mr-1"></i>
        </div>
        <div class="notification-details flex-grow-1">

            <a onclick="updateNotification({{$notification3->idd}})">
                <p class="m-0 d-flex align-items-center">
                    <span>
                        {{-- {{$notification3->data['message']}} --}}
                        dabo dabo dabo
                    </span>
                    @if(!empty($notification3->data['repair_parts_request']['id']))
                    {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$invItem->quantity_balance}}</span>--}}
                    <span class="badge badge-pill badge-danger ml-1 mr-1">
                        {{-- {{isset($notification3->data['repair_parts_request']['id'])?$notification3->data['repair_parts_request']['id']:""}} --}}
                  dabo dabo dabo
                    </span>
                    @else
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
