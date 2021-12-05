<div class="row">
    <div class="col-md-4">
        <div class="card-body">
            {{--            <div class="card-title">Ticket Information</div>--}}
            <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3" >
                <div class="flex-grow-1">
                    <h5><a href="">#{{ $ticke_info->ticket_id }}</a></h5>
                    <p class="m-0 text-small text-muted">{{ $ticke_info->message }}.</p>
                    <p class="text-small text-danger m-0">status
                        <span class="text-dark status_text">{{ $array_status[$ticke_info->is_checked] }}</span>
                    </p>
                    @if($ticke_info->voice_message)
                        <?php
                            $voice_message =  ltrim($ticke_info->voice_message, $ticke_info->voice_message[0]);
                        ?>
                        <p class="m-0">
                            <audio controls style="width: 235px;">
                                <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </p>
                        <br>
                    @endif
                    @if($ticke_info->image_url)
                        <?php
                            $image_url =  ltrim($ticke_info->image_url, $ticke_info->image_url[0]);
                        ?>
                        <p class="m-0">
                            <a href="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" target="_blank">
                                <img src="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" alt="" width="200" height="100">
                            </a>
                        </p>
                    @endif
                </div>
                <div>
                </div>
            </div>
        </div>

        {{--private chat start--}}
        <div class="accordion" id="accordionRightIcon">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-1" aria-expanded="false">Private Chat</a></h6>
                </div>
                <div class="collapse" id="accordion-item-icon-right-1" data-parent="#accordionRightIcon" style="">
                    <div class="card-body">
                        <div class="chat-content-wrap" data-sidebar-content="chat">
                            <div class="chat-content perfect-scrollbar" style="width: 100%; height: 300px; overflow-y: scroll; overflow-x: hidden; "  data-suppress-scroll-x="true" >
                                @foreach($ticket_messages_private as $ticket_message)
                                    @if($ticket_message->chat_message)
                                        <div class="d-flex mb-4">
                                            <div class="message flex-grow-1">
                                                <div class="d-flex">
                                                    <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p>
                                                    <span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                                </div>
                                                <p class="m-0">{{$ticket_message->chat_message}}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($ticket_message->voice_message)
                                    <?php
                                        $voice_message =  ltrim($ticket_message->voice_message, $$ticket_message->voice_message[0]);
                                    ?>
                                        <div class="d-flex mb-4">
                                            <div class="message flex-grow-1">
                                                <div class="d-flex">
                                                    <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                                </div>
                                                <p class="m-0">
                                                    <audio controls>
                                                        <source src="{{Storage::temporaryUrl($voice_message , now()->addMinutes(5)) }}" type="audio/ogg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($ticket_message->pdf_file)
                                    <?php
                                        $pdf =  ltrim($ticket_message->pdf_file, $ticket_message->pdf_file[0]);
                                    ?>
                                        <div class="d-flex mb-4">
                                            <div class="message flex-grow-1">
                                                <div class="d-flex">
                                                    <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                                </div>
                                                <p class="m-0">
                                                <div class="ul-widget4__item">
                                                    <div class="ul-widget4__pic-icon"><i
                                                            class="i-Folder-With-Document text-info"></i></div>
                                                    <a class="ul-widget4__title" href="{{Storage::temporaryUrl($pdf, now()->addMinutes(5)) }}" target="_blank">PDF File</a>
                                                </div>
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($ticket_message->image_file)
                                    <?php
                                        $image_url =  ltrim($ticket_message->image_file, $ticket_message->image_file[0]);
                                    ?>
                                        <div class="d-flex mb-4">
                                            <div class="message flex-grow-1">
                                                <div class="d-flex">
                                                    <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                                </div>
                                                <p class="m-0">
                                                    <a href="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" target="_blank">
                                                        <img src="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" alt="" width="200" height="100">
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
            </div>
        </div>
        {{--        private chat end here--}}

        @if($ticke_info->is_checked=="0" || $ticke_info->is_checked=="2" && $ticke_info->is_approved=="4")
            <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
                <form class="form-element" id="inputForm" method="post" action="{{route('send_ticket_message')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" id="ticket_id2" name="ticket_id2"  value="{{$ticke_info->id}}" >
                    <input type="hidden" id="category" name="category"  value="1" >
                    <div class="form-group">
                        <textarea class="form-control form-control-rounded" id="chat_message" name="chat_message" placeholder="Type your message" name="message" cols="30" rows="3" ></textarea>
                    </div>

                    <div class="d-flex">

                        <div class="flex-grow-1"></div>
                        <button type="submit" class="btn btn-icon btn-rounded btn-primary mr-2"><i class="i-Paper-Plane"></i>Send</button>
                    </div>
                </form>
            </div>
        @endif

    </div>


    <div class="col-md-8" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">

        <div class="chat-content-wrap" data-sidebar-content="chat">
            <div class="d-flex pl-3 pr-3 pt-2 pb-2 o-hidden box-shadow-1 chat-topbar"><a class="link-icon d-md-none" data-sidebar-toggle="chat"><i class="icon-regular  ml-0 mr-3"></i></a>
                <div class="d-flex align-items-center">
                    {{--                        <img class="avatar-sm rounded-circle mr-2" src="../../dist-assets/images/faces/13.jpg" alt="alt" />--}}
                    <p class="m-0 text-title text-16 flex-grow-1">{{$ticke_info->user->profile?$ticke_info->user->profile->passport->personal_info->full_name : $ticke_info->user->name }}</p>
                </div>
            </div>
            <div class="chat-content perfect-scrollbar" style="width: 100%; height: 400px; overflow-y: scroll; overflow-x: hidden"   data-perfect-scrollbar=""  data-suppress-scroll-x="true">

                @foreach($ticket_messages_public as $ticket_message)

                    @if($ticket_message->chat_message)
                        <div class="d-flex mb-4  ">
                            @if($ticket_message->user_type=="2")
                                <img class="avatar-sm rounded-circle mr-3" src="@if(!empty($ticket_message->user->profile->image))  {{ asset($ticket_message->user->profile->image) }} @else {{ asset('assets/images/user_avatar.jpg') }} @endif" alt="alt" />
                            @endif
                            <div class="message flex-grow-1 {{ ($ticket_message->user_type=="2") ? 'user_chat' : '' }}">
                                <div class="d-flex">
                                    <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                </div>
                                <p class="m-0">{{$ticket_message->chat_message}}</p>
                                <br>
                                @if($ticket_message->voice_message)
                                    <?php
                                        $voice_message =  ltrim($ticket_message->voice_message, $$ticket_message->voice_message[0]);
                                    ?>
                                    <p class="m-0">
                                        <audio controls>
                                            <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </p>
                                    <br>
                                @endif

                                @if($ticket_message->pdf_file)
                                    <?php
                                        $pdf =  ltrim($ticket_message->pdf_file, $ticket_message->pdf_file[0]);
                                    ?>
                                    <p class="m-0">
                                    <div class="ul-widget4__item">
                                        <div class="ul-widget4__pic-icon"><i
                                                class="i-Folder-With-Document text-info"></i></div>
                                        <a class="ul-widget4__title" href="{{Storage::temporaryUrl($pdf, now()->addMinutes(5)) }}" target="_blank">PDF File</a>
                                    </div>
                                    </p>
                                    <br>
                                @endif

                                @if($ticket_message->image_file)
                                <?php
                                    $image_url =  ltrim($ticket_message->image_file, $ticket_message->image_file[0]);
                                ?>
                                    <p class="m-0">
                                        <a href="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" target="_blank">
                                            <img src="{{Storage::temporaryUrl($image_url , now()->addMinutes(5)) }}" alt="" width="200" height="100">
                                        </a>
                                        {{--<img src="{{asset($ticket_message->image_file)}}" alt="Example" width="200" height="100">--}}
                                    </p>

                                @endif


                            </div>
                            @if(($ticket_message->user_type=="1"))
                                <img class="avatar-sm rounded-circle ml-3" src="{{ asset('assets/images/admin_avatar.png') }}" alt="alt" />
                            @endif
                        </div>
                    @endif

                @endforeach



            </div>

        </div>
        <!-- end of main-content -->
        @if($ticke_info->is_approved=="4")
            <div class="float-right">
                <form action="{{ route('approve_ticket_save') }}" id="form_management"  class="float-right" method="post">
                    @csrf
                    <input type="hidden" name="status" id="status_ab" value="5">
                    <input type="hidden" name="primary_id"  value="{{ $ticke_info->id  }}">
                    <button class="btn btn-success ml-2 status_btn" id="2" type="submit" >Approve</button>
                </form>

                <form action="{{ route('approve_ticket_save') }}" id="form_management" method="post" class="float-right">
                    @csrf
                    <input type="hidden" name="status" value="6">
                    <input type="hidden" name="primary_id"  value="{{ $ticke_info->id  }}">
                    <button class="btn btn-danger ml-2 status_btn" id="2" type="submit" >Reject</button>
                </form>

                <form action="{{ route('approve_ticket_save') }}" id="form_management" method="post" class="float-right">
                    @csrf
                    <input type="hidden" name="status" value="7">
                    <input type="hidden" name="primary_id"  value="{{ $ticke_info->id  }}">
                    <button class="btn btn-info ml-2 status_btn" id="2" type="submit" >Assign To Management</button>
                </form>

            </div>

        @endif

    </div>


</div>
