<style>

    .perfect-scrollbar1 {
        width: 350px;
        overflow: hidden;
        margin: auto;
        position: relative;
    }
    .perfect-scrollbar1:hover {
        overflow-y: scroll;
    }
    .chat-width {
        width: 350px;
    }
    .msg-table{
    margin-left: 37px;
    }
    .msg-card {
        width: 299px;
        margin-left: 46px;
    }
    .histroy-audio {
        width: 220px;
    }
    .m-sender {
        font-size: 11px;
        font-weight: 600;
        color: #7d41bb;
    }

</style>

<div class="align-items-center">
 <table class="msg-table">
    @foreach($all_ticket as $ticket)

            <tr>
                <td>
            @if(isset($ticket->voice_message))
                <audio controls class="files histroy-audio">
                    <source src="{{ asset($ticket->voice_message) }}" type="audio/ogg">
                    Your browser does not support the audio element.
                </audio>
            @else
                <span  class="badge badge-info files">No Voice</span>
            @endif
                </td>
                <td>

            @if(isset($ticket->image_url))
                <a href="{{ url($ticket->image_url) }}" target="_blank">
                    <img class="rounded-circle m-0 avatar-sm-table ticket-img" src="{{ url($ticket->image_url) }}" alt="">
                </a>
            @else
                <span  class="badge badge-info files">No Image</span>

            @endif
                </td>
            </tr>
         <br>

    @endforeach
</table>
    </div>
{{--chat history--}}

<br>
 <div class="col-md-6">
     <div class="card chat-sidebar-container chat-width" data-sidebar-container="chat">
        <div class="chat-content-wrap" data-sidebar-content="chat">
            <div class="chat-content perfect-scrollbar1" data-suppress-scroll-x="true">
                @foreach($ticket_chat as $ticket_message)
                    @if($ticket_message->chat_message)
                        <div class="d-flex mb-6">
                            <div class="message flex-grow-1">
                                <div class="d-flex">

                                    <span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                </div>
                                <div class="m-sender">
                                    <p class="mb-1 text-title text-16 flex-grow-1 m-sender">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p>

                                </div>

                                <p class="m-0">{{$ticket_message->chat_message}}</p>
                            </div>
                        </div>
                    @endif

                    @if($ticket_message->voice_message)
                        <div class="d-flex mb-6">
                            <div class="message flex-grow-1">
                                <div class="d-flex">
                                    <span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                </div>
                                <div class="m-sender">
                                    <p class="mb-1 text-title text-16 flex-grow-1 m-sender">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p>

                                </div>
                                <p class="m-0">
                                    <audio controls>
                                        <source src="{{ asset($ticket_message->voice_message) }}" type="audio/ogg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($ticket_message->pdf_file)
                        <div class="d-flex mb-6">
                            <div class="message flex-grow-1">
                                <div class="d-flex">
                                    <span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                </div>
                                <div class="m-sender">
                                    <p class="mb-1 text-title text-16 flex-grow-1 m-sender">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p>

                                </div>
                                <p class="m-0">
                                <div class="ul-widget4__item">
                                    <div class="ul-widget4__pic-icon"><i
                                            class="i-Folder-With-Document text-info"></i></div>
                                    <a class="ul-widget4__title" href="{{asset($ticket_message->pdf_file)}}" target="_blank">PDF File</a>
                                </div>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($ticket_message->image_file)
                        <div class="d-flex mb-6">
                            <div class="message flex-grow-1">
                                <div class="d-flex">
                                    <span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                </div>
                                <div class="m-sender">
                                    <p class="mb-1 text-title text-16 flex-grow-1 m-sender">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p>

                                </div>
                                <p class="m-0">
                                    <a href="{{ url($ticket_message->image_file) }}" target="_blank">
                                        <img src="{{ url($ticket_message->image_file) }}" alt="" width="200" height="100">
                                    </a>
                                    {{--<img src="{{asset($ticket_message->image_file)}}" alt="Example" width="200" height="100">--}}
                                </p>
                            </div>
                        </div>
                    @endif

                @endforeach

            </div>
        </div>
    </div>
</div>
<br>

<script>

    $(document).ready(function() {
        $('.perfect-scrollbar1').perfectScrollbar();
    })

</script>









