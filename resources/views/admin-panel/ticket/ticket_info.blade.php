
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    {{--<link rel="stylesheet" href="{{asset('assets/css/plugins/smart.wizard/smart_wizard.min.css')}}" />--}}
    {{--<link rel="stylesheet" href="{{asset('assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css')}}" />--}}
    {{--<link rel="stylesheet" href="{{asset('assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css')}}" />--}}
    {{--<link rel="stylesheet" href="{{asset('assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css')}}" />--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .chat-sidebar-container {
            height: auto;
            min-height: unset;
        }
        .histroy-audio {
            width: 220px;
        }
        small, .small {
            font-size: 55%;
            font-weight: 400;
        }
        a.text-default {
            font-size: 13px;
        }
        /*.perfect-scrollbar2 {*/
        /*    width: 350px;*/
        /*    height: 1000px;*/
        /*    overflow: hidden;*/
        /*    margin: auto;*/
        /*    position: relative;*/

        /*}*/


        /*.perfect-scrollbar2:hover {*/
        /*    overflow-y: scroll;*/

        /*}*/

        .badge_ab{
                margin:0px !important;
        }

    </style>

    <style>

        .table_log th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }

        .table_log td{
            padding: 2px;
            font-size: 12px;
        }
    </style>

@endsection
@section('content')
    <div class="modal fade bd-example2-modal-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-m">Ticket Message</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>
                        {{$ticket_info->message}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    {{--  Assign Managment--}}
    <div class="modal fade bd-example2-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="assing_to_management" method="post">
                    <div class="modal-header">
{{--                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Assing Ticket To Management Confirmation</h5>--}}
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to <strong>Assign Ticket To Management</strong>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="assingn_Submit()">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
{{--    Assing End Managment--}}

    {{--  Assign  To Team Leader --}}
    <div class="modal fade team_leader_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="assing_to_teamleader" method="post">
                    <div class="modal-header">
                        {{--                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Assing Ticket To Management Confirmation</h5>--}}
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to <strong>Assign Ticket To Team Leader</strong>?
                    </div>
                    <input type="hidden" name="status" id="team_leader_status" value="1">
                    <input type="hidden" name="team_leader_id" id="team_leader_id">
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="assingn_team_lead_submit()">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{--    Assign Team Leader End--}}


    {{--  Assign To Manager --}}
    <div class="modal fade manger_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="assing_manager_teamleader" method="post">
                    <div class="modal-header">
                        {{--                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Assing Ticket To Management Confirmation</h5>--}}
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to <strong>Assign Ticket To Manager</strong>?
                    </div>
                    <input type="hidden" name="status" id="manager_status" value="7">
                    <input type="hidden" name="team_leader_id" id="team_leader_id">
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="assingn_Submit()">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{--    Assign Manager End --}}


    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>Ticket ID : {{$ticket_info->ticket_id}}</li>
            <li>Name : <strong>{{$ticket_info->user->profile ? $ticket_info->user->profile->passport->personal_info->full_name : ""}}</strong></li>
        </ul>

            @if($ticket_info->is_checked==0)
            <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="update_ticketSubmit({{$ticket_info->id}})" type="button">Start Ticket</button>
                            @if($ticket_info->is_approved=="0")
                              <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".bd-example2-modal-sm-2" onclick="reject_ticketSubmit({{$ticket_info->id}})" type="button">Reject Ticket</button>
                            @elseif($ticket_info->is_approved=="1")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Team Leader</h5>
                            @elseif($ticket_info->is_approved=="2")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Team Leader</h5>
                            @elseif($ticket_info->is_approved=="3")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Team Leader</h5>
                            @elseif($ticket_info->is_approved=="4")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Manager</h5>
                            @elseif($ticket_info->is_approved=="5")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Manager</h5>
                            @elseif($ticket_info->is_approved=="6")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Manager</h5>
                            @elseif($ticket_info->is_approved=="7")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Management</h5>
                            @elseif($ticket_info->is_approved=="8")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Management</h5>
                            @elseif($ticket_info->is_approved=="9")
                                <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Management</h5>
                            @endif

            @else
                    @if($ticket_info->is_approved=="0" || $ticket_info->is_approved=="2"
                        || $ticket_info->is_approved=="3" ||   $ticket_info->is_approved=="3"
                         ||  $ticket_info->is_approved=="5" ||  $ticket_info->is_approved=="6"
                           ||  $ticket_info->is_approved=="8" ||  $ticket_info->is_approved=="9" )
                        @if($ticket_info->is_checked==0 || $ticket_info->is_checked==2 )
                      <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="updateData({{$ticket_info->id}})" type="button">Close Ticket</button>
                         @elseif($ticket_info->is_checked==1)
                          <h5 class="badge badge-pill badge-outline-success p-2 m-1">Closed Ticket</h5>
                        @elseif($ticket_info->is_checked==3)
                        <h5 class="badge badge-pill badge-outline-danger p-2 m-1">Rejected Ticket</h5>
                         @endif
                  @endif

                    @if($ticket_info->is_approved=="1")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Team Leader</h5>
                    @elseif($ticket_info->is_approved=="2")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Team Leader</h5>
                    @elseif($ticket_info->is_approved=="3")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Team Leader</h5>
                    @elseif($ticket_info->is_approved=="4")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Manager</h5>
                    @elseif($ticket_info->is_approved=="5")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Manager</h5>
                    @elseif($ticket_info->is_approved=="6")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Manager</h5>
                    @elseif($ticket_info->is_approved=="7")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Assigned To Management</h5>
                    @elseif($ticket_info->is_approved=="8")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Approved By Management</h5>
                    @elseif($ticket_info->is_approved=="9")
                        <h5 class="badge badge-pill badge-outline-primary p-2 m-1">Rejected By Management</h5>
                    @endif
        @endif



        @if(Auth::user()->designation_type=="2" && $ticket_info->is_approved=="1")
            <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".manger_modal" onclick="assign_manager({{$ticket_info->id}})" style="background-color: #dddddd78 !important; " type="button">Assign To Manager</button>
        @elseif(Auth::user()->designation_type=="1" && $ticket_info->is_approved=="4")
            <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".manger_modal" onclick="assign_manager({{$ticket_info->id}})" style="background-color: #dddddd78 !important; " type="button">Assign To Management</button>
        @elseif(Auth::user()->designation_type=="0" && $ticket_info->is_approved=="0")
            @if($is_teamlead)
                <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".team_leader_modal" onclick="assign_teamlead({{$ticket_info->id}})" style="background-color: #dddddd78 !important; " type="button">Assign To Team Leader</button>
            @elseif($is_manager)
                <button class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".manger_modal" onclick="assign_manager({{$ticket_info->id}})" style="background-color: #dddddd78 !important; " type="button">Assign To Manager</button>
            @endif
        @endif

        @if(isset($ticket_info->voice_message))
        <?php
            $voice_message =  $ticket_info->voice_message ? ltrim($ticket_info->voice_message, $ticket_info->voice_message[0]) : '';
        ?>
                <audio controls class="files">
                    <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                    Your browser does not support the audio element.
                </audio>
                {{--<a class="text-success mr-2" href="{{route('download-voice',$ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a>--}}
                {{--<a download="Voice_note" class="text-success mr-2" href="{{asset($ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a>--}}
            @else
                <span  class="badge badge-info files">No Voice</span>          &nbsp;
            @endif
        @if(isset($ticket_info->image_url))
        <?php
            $image_url =  $ticket_info->image_url ? ltrim($ticket_info->image_url, $ticket_info->image_url[0]) : '';
        ?>
            <a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                <img class="rounded-circle m-0 avatar-sm-table ticket-img" src="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
            </a>
        @else
            <span  class="badge badge-info files">No Image</span>

        @endif
        @if(isset($ticket_info->message))
            &nbsp;
            &nbsp;
            &nbsp;
            <button class="btn btn-primary read-message" data-toggle="modal" data-target=".bd-example2-modal-message"  type="button">Read Message</button>

{{--            <span>{{$ticket_info->message}}</span>--}}
            @endif




    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-4">
           @if($ticket_info->is_checked=="0" || $ticket_info->is_checked=="2")
              @if(!isset($ticket_assigned))
                <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Assign Department</div>
                    <form method="post" action="{{route('manage_ticket.store')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" id="ticket_id" name="ticket_id"  value="{{$ticket_info->id}}">
                        <div class="row">
{{--                            <div class="col-md-12 form-group mb-3">--}}
{{--                                <label for="repair_category">Message Note</label>--}}
{{--                                <textarea class="form-control" aria-label="With textarea" id="message" name="message" @if($ticket_info->is_checked==0) disabled @endif></textarea>--}}
{{--                            </div>--}}
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Assigned Department</label>
                                <select  multiple="multiple" id="department_id" name="department_id[]" class="form-control form-control-rounded  multi-select" @if($ticket_info->is_checked==0) disabled @endif>
                                    <option value="">Select User Role</option>
                                    @foreach($major_departments as $department)
                                        <option value="{{$department->id}}">{{$department->major_department}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-12">
                                 <button class="btn btn-primary" @if($ticket_info->is_checked==0) disabled @endif>Assign Department</button>
                              </div>
                            <div class="department_name_div">
                            </div>
                          </div>
                      </form>
                  </div>


                  </div>
               @endif
          @endif

            <!------Assign internal deparements----->

                @if($ticket_info->is_checked=="0" || $ticket_info->is_checked=="2")
                   @if(!isset($ticket_assigned))
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Assign Inside Department</div>
                            <form method="post" action="{{route('internal_ticket_assign')}}">
                                {!! csrf_field() !!}
                                <input type="hidden" id="ticket_id" name="ticket_id"  value="{{$ticket_info->id}}">
                                <input type="hidden" id="sent_by" name="sent_by"  value="{{auth()->user()->id}}">
                                <div class="row">
{{--                                    <div class="col-md-12 form-group mb-3">--}}
{{--                                        <label for="repair_category">Message Note</label>--}}
{{--                                        <textarea class="form-control" aria-label="With textarea" id="message" name="message" @if($ticket_info->is_checked==0) disabled @endif></textarea>--}}

{{--                                    </div>--}}
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Users Department</label>
                                        <select  multiple="multiple" id="user_department_id" name="user_department_id[]" class="form-control form-control-rounded  multi-select" @if($ticket_info->is_checked==0) disabled @endif>
                                            <option value="">Select User Role</option>
                                            @foreach($major_departments as $department)
                                                <option value="{{$department->id}}">{{$department->major_department}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Users</label>
                                        <select  multiple="multiple" id="internal_dep_assign" name="internal_dep_assign[]" class="form-control form-control-rounded multi-select" @if($ticket_info->is_checked==0) disabled @endif>
                                            <option value="">Select User</option>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" @if($ticket_info->is_checked==0) disabled @endif>Share</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                       @endif
            @endif



            <div class="card">
                <div class="card-body">
                    <div class="ul-widget__head v-margin pb-20">
                        <div class="ul-widget__head-label">
                            <button class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"  type="button">Tickets History</button>
                            <button class="btn btn-success" id="ticket_log_btn" data-toggle="modal" data-target="#ticket_log_modal"  type="button">Ticket Log</button>

                        </div>
                    </div>


                </div>
            </div>



        </div>

        <div class="col-md-4">
            <div class="card-title mb-3">Private Chat</div>
            <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6">
                <div class="chat-content-wrap" data-sidebar-content="chat">
                    <div class="chat-content perfect-scrollbar" data-suppress-scroll-x="true">
                        @foreach($ticket_messages_private as $ticket_message)
                            <?php
                            $image_url =  $ticket_message->image_file ? ltrim($ticket_message->image_file, $ticket_message->image_file[0]) : '';
                            $pdf_file=  $ticket_message->pdf_file ? ltrim($ticket_message->pdf_file, $ticket_message->pdf_file[0]) : '';
                            $voice_message = $ticket_message->voice_message ? ltrim($ticket_message->voice_message, $ticket_message->voice_message[0]) : '';
                            ?>
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
                                <div class="d-flex mb-4">
                                    <div class="message flex-grow-1">
                                        <div class="d-flex">
                                            <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                        </div>
                                        <p class="m-0">
                                            <audio controls>
                                                <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </p>
                                    </div>
                                </div>
                            @endif

                                @if($ticket_message->pdf_file)
                                    <div class="d-flex mb-4">
                                        <div class="message flex-grow-1">
                                            <div class="d-flex">
                                                <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                            </div>
                                            <p class="m-0">
                                            <div class="ul-widget4__item">
                                                <div class="ul-widget4__pic-icon"><i
                                                            class="i-Folder-With-Document text-info"></i></div>
                                                <a class="ul-widget4__title" href="{{Storage::temporaryUrl($pdf_file, now()->addMinutes(5)) }}" target="_blank">PDF File</a>
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if($ticket_message->image_file)
                                    <div class="d-flex mb-4">
                                        <div class="message flex-grow-1">
                                            <div class="d-flex">
                                                <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->name}}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                            </div>
                                            <p class="m-0">
                                                <a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                    <img src="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="" width="200" height="100">
                                                </a>
                                                {{--<img src="{{asset($ticket_message->image_file)}}" alt="Example" width="200" height="100">--}}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                        @endforeach

                    </div>
                    @if($ticket_info->is_checked=="0" || $ticket_info->is_checked=="2")
                    <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
                        <form class="form-element" id="inputForm" method="post" action="{{route('send_ticket_message')}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" id="ticket_id2" name="ticket_id2"  value="{{$ticket_info->id}}" >
                            <input type="hidden" id="category" name="category"  value="1" >
                            <div class="form-group">
                                <textarea class="form-control form-control-rounded" id="chat_message" name="chat_message" placeholder="Type your message" name="message" cols="30" rows="3" ></textarea>
                            </div>

                            {{--<div class="form-group" hidden>--}}
                            {{--<input class="custom-file-input" id="recordedAudio_1" type="content" name="voice" />--}}
                            {{--</div>--}}

                            <label for="myfile">Pdf :</label>
                            <input type="file" id="pdf" name="pdf"  >
                            <br>
                            <label for="myfile">Image :</label>
                            <input type="file" id="image" name="image"  >
                            <br>
                            <label for="myfile">Voice : </label>
                            <input type="file" id="voice" name="voice" >
                            <div class="d-flex">

                                <div class="flex-grow-1"></div>
                                <button type="submit" class="btn btn-icon btn-rounded btn-primary mr-2"><i class="i-Paper-Plane"></i>Send</button>
                            </div>
                        </form>
                    </div>
                        @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-title mb-3">Public Chat</div>
           <div class="card chat-sidebar-container" data-sidebar-container="chat">
            <div class="chat-content-wrap" data-sidebar-content="chat">
                <div class="chat-content perfect-scrollbar" data-suppress-scroll-x="true">
                    @foreach($ticket_messages_public as $ticket_message)
                    <?php
                        $image_url =  $ticket_message->image_file ? ltrim($ticket_message->image_file, $ticket_message->image_file[0]) : '';
                        $pdf_file=  $ticket_message->pdf_file ? ltrim($ticket_message->pdf_file, $ticket_message->pdf_file[0]) : '';
                        $voice_message = $ticket_message->voice_message ? ltrim($ticket_message->voice_message, $ticket_message->voice_message[0]) : '';
                     ?>
                        @if($ticket_message->chat_message)
                            <div class="d-flex mb-4">
                                <div class="message flex-grow-1">
                                    <div class="d-flex">
                                        <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                    </div>
                                    <p class="m-0">{{$ticket_message->chat_message}}</p>
                                </div>
                            </div>
                        @endif

                         @if($ticket_message->voice_message)
                                <div class="d-flex mb-4">
                                    <div class="message flex-grow-1">
                                        <div class="d-flex">
                                            <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                        </div>
                                        <p class="m-0">
                                            <audio controls>
                                                <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </p>
                                    </div>
                                </div>
                          @endif

                            @if($ticket_message->pdf_file)
                                <div class="d-flex mb-4">
                                    <div class="message flex-grow-1">
                                        <div class="d-flex">
                                            <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                        </div>
                                        <p class="m-0">
                                        <div class="ul-widget4__item">
                                            <div class="ul-widget4__pic-icon"><i
                                                        class="i-Folder-With-Document text-info"></i></div>
                                            <a class="ul-widget4__title" href="{{Storage::temporaryUrl($pdf_file, now()->addMinutes(5)) }}" target="_blank">PDF File</a>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($ticket_message->image_file)
                                <div class="d-flex mb-4">
                                    <div class="message flex-grow-1">
                                        <div class="d-flex">
                                            <p class="mb-1 text-title text-16 flex-grow-1">{{$ticket_message->user->profile?$ticket_message->user->profile->passport->personal_info->full_name : $ticket_message->user->name }}</p><span class="text-small text-muted">{{$ticket_message->created_at}}</span>
                                        </div>
                                        <p class="m-0">
                                            <a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                <img src="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="" width="200" height="100">
                                            </a>
                                            {{--<img src="{{asset($ticket_message->image_file)}}" alt="Example" width="200" height="100">--}}
                                        </p>
                                    </div>
                                </div>
                            @endif

                    @endforeach

                </div>

                @if($ticket_info->is_checked=="0" || $ticket_info->is_checked=="2")
                <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
                    <form class="form-element" id="inputForm" method="post" action="{{route('send_ticket_message')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" id="ticket_id2" name="ticket_id2"  value="{{$ticket_info->id}}" >
                        <input type="hidden" id="category" name="category"  value="2" >
                        <div class="form-group">
                            <textarea class="form-control form-control-rounded" id="chat_message" name="chat_message" placeholder="Type your message" name="message" cols="30" rows="3"  @if($ticket_info->is_checked==0) disabled @endif @if(isset($ticket_assigned)) disabled @endif></textarea>
                        </div>

                        {{--<div class="form-group" hidden>--}}
                            {{--<input class="custom-file-input" id="recordedAudio_1" type="content" name="voice" />--}}
                        {{--</div>--}}
                        <label for="myfile">Pdf :</label>
                        <input type="file" id="pdf" name="pdf"  @if($ticket_info->is_checked==0) disabled @endif @if(isset($ticket_assigned)) disabled @endif>
                        <br>
                        <label for="myfile">Image :</label>
                        <input type="file" id="image" name="image"  @if($ticket_info->is_checked==0) disabled @endif @if(isset($ticket_assigned)) disabled @endif>
                        <br>
                        <label for="myfile">Voice : </label>
                        <input type="file" id="voice" name="voice"  @if($ticket_info->is_checked==0) disabled @endif @if(isset($ticket_assigned)) disabled @endif>
{{--
                        <div id="controls">
                            <button id="recordButton">Record</button>
                            <button id="pauseButton" disabled>Pause</button>
                            <button id="stopButton" disabled>Stop</button>
                         </div>
                         <div id="formats">Format: start recording to see sample rate</div>
                           <p><strong>Recordings:</strong></p>
                           <ol id="recordingsList"></ol> --}}


                        <div class="d-flex">
                            <div class="flex-grow-1"></div>
                            <button type="submit" class="btn btn-icon btn-rounded btn-primary mr-2"><i class="i-Paper-Plane"></i>Send</button>
                        </div>
                    </form>
                </div>
                    @endif
            </div>
        </div>
        </div>

    </div>

{{--close ticket modal--}}
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket Closing Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <span class="font-weight-412" style="font-size: 14px;"> Are you sure want to Close the Ticket?</span>
                        <br>
                        <br>
                        <label class="checkbox checkbox-outline-primary mt-1" style="font-size: 12px;">
                            <input type="checkbox" value="1" name="is_hide" ><span>Do you want to hide this ticket in app.?</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="updateSubmit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{--    Start ticket modal--}}
    <div class="modal fade bd-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="start_ticket" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket Starting Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        Are you sure want to <b> Start Ticket?</b>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="start_ticketSubmit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--   Reject Modal--}}
    <div class="modal fade bd-example2-modal-sm-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="reject_ticket" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Ticket Rejection Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <span style="font-size: 14px;"> Are you sure want to <strong>Reject Ticket</strong>?</span>

                        <br>
                        <br>
                        <label class="checkbox checkbox-outline-primary mt-1" style="font-size: 12px;">
                            <input type="checkbox" value="1" name="is_hide" ><span>Do you want to hide this ticket in app.?</span><span class="checkmark"></span>
                        </label>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="reject_Submit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{--    Tickets History Model--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ticket-history">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tickets History</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                <div class="modal-body">
                    <div class="col-md-12">
                       <div class="card mb-4">
                         <div class="card-body">
                          <div class="row">
                            <div class="col-md-6 mb-3  perfect-scrollbar2" data-suppress-scroll-x="true">
                                  <table class="table" id="datatable" style="width: 100%">
                                     <thead   style="display: none">
                                         <tr>
                                           <th>Ticket No</th>
                                         </tr>
                                     </thead>
                                      <tbody>
                                       @foreach($ticket_history as $history)
                                         <tr>
                                         <td style="border: none !important; padding: 0px">
                                         <div class="card mb-2 ticket-card" id={{$history->id}}>
                                            <div class="card-body">
                                              <a class="text-12"><b>{{$history->ticket_id}}</b></a><br>
                                                <a class="text-12">  {{isset($history->department->name)?$history->department->name:""}}</a><br>
                                                     <a class="text-12 text-success">
                                                     {{ isset($history->platform_->name) ? $history->platform_->name : '' }}
                                                     </a>
                                                @if($history->message)
                                                    <div class="accordion" id="accordionRightIcon">
                                                        <a class="text-12" data-toggle="collapse" href="#accordion-item-icon-right-{{$history->id}}" aria-expanded="false">
                                                            Read Message
                                                        </a>
                                                    <div class="card">

                                                        <div class="collapse" id="accordion-item-icon-right-{{$history->id}}" data-parent="#accordionRightIcon" style="">
                                                            <div class="card-body">
                                                                <a class="text-12">{{$history->message}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     </div>
                                                @endif
                                                <br>
                                                    <small class="text-muted">{{$history->created_at}}</small>
                                            </div>
                                          </div>
                                         </td>
                                         </tr>
                                        @endforeach
                                      </tbody>
                                                </table>
                            </div>

                              <div class="col-md-6 mb-3">
                               <div class="row">

                                   <div id="names_div">
                                    <div id="all-check" >
                                     </div>
                                    </div>
                              </div>

                           </div>
                          </div>
                       </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
        </div>
    </div>

{{--ticket message--}}


            {{--    Tickets Log Model--}}


            <div class="modal fade " id="ticket_log_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ticket Log</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                            <div class="card" id="ticket_log_div">
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary ml-2" type="button">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

                    {{--ticket message--}}






@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/ticket_js/app.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
    <script src="js/app.js"></script>
    <script>
        $(".ticket-card").click(function(){
            $("#unique_div").css('display','block');
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();


            $.ajax({
                url: "{{ route('ajax_ticket_info') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token: token},
                success: function (response) {
                    $('#all-check').empty();
                    $('#all-check').append(response.html);
                }
            });
        });

        $("#department_id").change(function(){
            var selectedValues = $(this).val();
            var token = $("input[name='_token']").val();
            var ticket_id = "{{ request()->segment(2) }}";


            $.ajax({
                url: "{{ route('get_user_department_wise') }}",
                method: 'POST',
                dataType: 'json',
                data: {department_id: selectedValues, ticket_id :ticket_id, _token: token},
                success:function(response){
                    $('.department_name_div').empty();
                    $('.department_name_div').append(response.html);
                }
            });

        });

        $("#user_department_id").change(function(){
            var selectedValues = $(this).val();
            var token = $("input[name='_token']").val();


            $('#internal_dep_assign').html("");
            $.ajax({
                url: "{{ route('get_user_internal_department_wise') }}",
                method: 'POST',
                dataType: 'json',
                data: {department_id: selectedValues, _token: token},
                success:function(response){

                    var len = 0;
                    if(response != null){
                        len = response.length;

                    }
                    var options = "";
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            console.log(response[i].name);
                            var newOption = new Option(response[i].name, response[i].id, true, true);

                            // Append it to the select
                            $('#internal_dep_assign').append(newOption);
                        }
                        $('#internal_dep_assign').val(null).trigger('change');
                    }
                }
            });

        });







        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 5,
                "bInfo" : false,
                language: {
                    search: "",
                    sLengthMenu: "Show _MENU_",
                    searchPlaceholder: "Search..."

                }
                //
            });



            $('#department_id').select2({
                placeholder: 'Select an option'
            });

            $('#user_department_id').select2({
                placeholder: 'Select an option'
            });

            $('#internal_dep_assign').select2({
                placeholder: 'Select an option'
            });




        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_msg').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "searching": false,
                "bInfo" : false


                //
            });


        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
// alert(currentTab)
                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{
                    var table = $('#datatable_msg').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
        });



        function updateData(id)
        {
            var id = id;
            var url = '{{ route('ticket.update', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function updateSubmit()
        {
            $("#updateForm").submit();
        }

//start ticket update
        function update_ticketSubmit(id)
        {
            var id = id;
            var url = '{{ route('ticket_start', ":id") }}';
            url = url.replace(':id', id);

            $("#start_ticket").attr('action', url);
        }

        function start_ticketSubmit()
        {
            $("#start_ticket").submit();

        }

        //reject ticket update

        function reject_ticketSubmit(id)
        {
            var id = id;
            var url = '{{ route('ticket_reject', ":id") }}';
            url = url.replace(':id', id);

            $("#reject_ticket").attr('action', url);
        }


        function reject_Submit()
        {
            $("#reject_ticket").submit();

        }

        function assign_management(id)
        {
            var id = id;
            var url = '{{ route('assign_to_management', ":id") }}';
            url = url.replace(':id', id);

            $("#assing_to_management").attr('action', url);

            // $("#assign_management").show('modal');
        }

        function assingn_Submit(){
            $("#assing_to_management").submit();
        }

        function assign_teamlead(id){

            var id = id;
            var url = '{{ route('assign_to_management', ":id") }}';
            url = url.replace(':id', id);

            $("#assing_to_teamleader").attr('action', url);

        }

       function assingn_team_lead_submit(){
           $("#assing_to_teamleader").submit();
       }

       function assign_manager(id){

            var id = id;
            var url = '{{ route('assign_to_management', ":id") }}';
            url = url.replace(':id', id);

            $("#assing_manager_teamleader").attr('action', url);

        }
    </script>

    <script>
        $("#ticket_log_btn").click(function () {

            var ticket_id = "{{ request()->segment(2) }}";
            var token = $("input[name='_token']").val();


            $.ajax({
                url: "{{ route('ajax_ticket_log') }}",
                method: 'POST',
                dataType: 'json',
                data: {ticket_id: ticket_id, _token: token},
                success: function (response) {

                    $("#ticket_log_div").html("");
                    $('#ticket_log_div').append(response.html);
                }
            });

        });
        </script>

       <script>
        $(document).ready(function() {
         $('.perfect-scrollbar1').perfectScrollbar();
          })

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

                <script>
                    $(document).ready(function() {
                        $('.perfect-scrollbar2').perfectScrollbar();
                    })
                </script>

@endsection
