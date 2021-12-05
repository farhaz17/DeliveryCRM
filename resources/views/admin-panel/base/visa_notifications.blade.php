@if(is_array($notification2))
    @foreach(auth()->user()->unreadNotifications_visa as $notification2)
        <div class="dropdown-item d-flex">
            <div class="notification-icon">
                <i class="i-Empty-Box text-danger mr-1"></i>
            </div>
            <div class="notification-details flex-grow-1">


                <p class="m-0 d-flex align-items-center">
                    <a onclick="updateNotification2({{$notification2->idd}})">
                        <span>{{$notification2->data['message']}}</span>
                        {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$invItem->quantity_balance}}</span>--}}
                        @if(!empty($notification2->data['visa_cancel']['zds_code']))

                            <span class="badge badge-pill badge-danger ml-1 mr-1">
                            {{isset($notification2->data['visa_cancel']['zds_code'])?$notification2->data['visa_cancel']['zds_code']:""}}
                        </span>
                        @else
                        @endif
                        <span class="flex-grow-1"></span>
                    </a>
                </p>


                <form action="" id="notificationForm" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                </form>
            </div>
        </div>
    @endforeach


 @endif


