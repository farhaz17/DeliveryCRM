@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <style>
        .user_chat{
            background: #3f536669 !important;
        }
        </style>

        <div class="card chat-sidebar-container" data-sidebar-container="chat">

            <div class="chat-content-wrap" data-sidebar-content="chat">
                <div class="d-flex pl-3 pr-3 pt-2 pb-2 o-hidden box-shadow-1 chat-topbar"><a class="link-icon d-md-none" data-sidebar-toggle="chat"><i class="icon-regular  ml-0 mr-3"></i></a>
                    <div class="d-flex align-items-center">
{{--                        <img class="avatar-sm rounded-circle mr-2" src="../../dist-assets/images/faces/13.jpg" alt="alt" />--}}
                        <p class="m-0 text-title text-16 flex-grow-1">Frank Powell</p>
                    </div>
                </div>
                <div class="chat-content perfect-scrollbar" data-suppress-scroll-x="true">

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
                                        <p class="m-0">
                                            <audio controls>
                                                <source src="{{ asset($ticket_message->voice_message) }}" type="audio/ogg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </p>
                                        <br>
                                     @endif

                                    @if($ticket_message->pdf_file)
                                        <p class="m-0">
                                        <div class="ul-widget4__item">
                                            <div class="ul-widget4__pic-icon"><i
                                                    class="i-Folder-With-Document text-info"></i></div>
                                            <a class="ul-widget4__title" href="{{asset($ticket_message->pdf_file)}}" target="_blank">PDF File</a>
                                        </div>
                                        </p>
                                        <br>
                                    @endif

                                    @if($ticket_message->image_file)

                                        <p class="m-0">
                                            <a href="{{ url($ticket_message->image_file) }}" target="_blank">
                                                <img src="{{ url($ticket_message->image_file) }}" alt="" width="200" height="100">
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
                <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
                    <form class="form-element" id="inputForm" method="post" action="{{route('send_ticket_message')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" id="ticket_id2" name="ticket_id2"  value="{{$ticket_info->id}}" >
                        <input type="hidden" id="category" name="category"  value="2" >
                        <div class="form-group">
                            <textarea class="form-control form-control-rounded" id="chat_message" name="chat_message" placeholder="Type your message" name="message" cols="30" rows="3"  @if($ticket_info->is_checked==0) disabled @endif></textarea>
                        </div>

                        <label for="myfile">Pdf :</label>
                        <input type="file" id="pdf" name="pdf"  @if($ticket_info->is_checked==0) disabled @endif>
                        <br>
                        <label for="myfile">Image :</label>
                        <input type="file" id="image" name="image"  @if($ticket_info->is_checked==0) disabled @endif>
                        <br>
                        <label for="myfile">Voice : </label>
                        <input type="file" id="voice" name="voice"  @if($ticket_info->is_checked==0) disabled @endif>
                        <div class="d-flex">
                            <div class="flex-grow-1"></div>
                            <button type="submit" class="btn btn-icon btn-rounded btn-primary mr-2"><i class="i-Paper-Plane"></i>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- end of main-content -->


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#datatable_part_time ,#datatable_taking_visa').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],

                scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });



        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }) ;
        });

        $(".upload_agreement_cls").click(function(){

            var ids = $(this).attr('id');

            $("#primary_id").val(ids);

            $("#edit_modal").modal('show');

        });



    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>


@endsection
