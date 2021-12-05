<style>

    .chat-sidebar-container {
        height: auto;
        min-height: unset;
    }

</style>

@foreach($chatData as $row)
    @if( $row->user_id== auth()->user()->id)
        <div class="d-flex mb-4">
            <div  class="message flex-grow-1" style="background: #f0e0ff">
                <div class="d-flex">
                    <p class="mb-1 text-title text-16 flex-grow-1">
                        {{$row->user->profile?$row->user->profile->passport->personal_info->full_name : $row->user->name }}
                    </p>
                    <span class="text-small text-muted">{{$row->created_at}}</span>
                </div>
                <p class="m-0">{{$row->chat_message}}</p>
                <br>
            </div>
            <img class="avatar-sm rounded-circle mr-3" src="@if(!empty($row->user->profile->image))  {{ asset($row->user->profile->image) }} @else {{ asset('assets/images/user_avatar.jpg') }} @endif" alt="alt" />

        </div>

    @else


        <div class="d-flex mb-4"  class="d-flex mb-4" >
            {{--            @if($ticket_message->user_type=="2")--}}
            <img class="avatar-sm rounded-circle mr-3" src="@if(!empty($row->user->profile->image))  {{ asset($row->user->profile->image) }} @else {{ asset('assets/images/user_avatar.jpg') }} @endif" alt="alt" />
            {{--            @endif--}}
            <div  class="message flex-grow-1"  >
                <div class="d-flex">
                    <p class="mb-1 text-title text-16 flex-grow-1">
                        {{$row->user->profile?$row->user->profile->passport->personal_info->full_name : $row->user->name }}
                    </p>
                    <span class="text-small text-muted">{{$row->created_at}}</span>
                </div>
                <p class="m-0">{{$row->chat_message}}</p>
                <br>


            </div>

        </div>



    @endif


@endforeach
