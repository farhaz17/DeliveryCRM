@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('drcm_dashboard',['active'=>'operations-menu-items']) }}">DRCM Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">DRCM Rider Operations</li>
        </ol>
    </nav>



    <div class="separator-breadcrumb border-top"></div>


    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                        <li class="nav-item">
                            <a class="nav-link active" id="DefaulterRequestsFromDCTab" data-toggle="tab" href="#DefaulterRequestsFromDC" role="tab" aria-controls="DefaulterRequestsFromDC" aria-selected="true">Defaulter Request From DC( {{ $defaulter_riders->where('accepted', 0)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="DefaulterRequestsSentToDRCTab" data-toggle="tab" href="#DefaulterRequestsSentToDRC" role="tab" aria-controls="DefaulterRequestsSentToDRC" aria-selected="true">Defaulter Requests Sent to DRC ( {{ $defaulter_requests_sent_to_DRC->where('approval_status', 0)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="DefaulterRequestsAcceptedByDrcTab" data-toggle="tab" href="#DefaulterRequestsAcceptedByDrc" role="tab" aria-controls="DefaulterRequestsAcceptedByDrc" aria-selected="true">Accepted Requests By DRC( {{ $defaulter_requests_sent_to_DRC->where('approval_status', 1)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="DefaulterRequestsRejectedByDrcTab" data-toggle="tab" href="#DefaulterRequestsRejectedByDrc" role="tab" aria-controls="DefaulterRequestsRejectedByDrc" aria-selected="true">Rejected Requests By DRC( {{ $defaulter_requests_sent_to_DRC->where('approval_status', 2)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="current_defualterTab" data-toggle="tab" href="#current_defualter" role="tab" aria-controls="current_defualter" aria-selected="true">Current Default Riders( {{ $defaulter_requests_sent_to_DRC->where('is_defaulter_now', '0')->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                    </ul>
                    {{-- @dd($defaulter_requests_sent_to_DRC) --}}
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active show" id="DefaulterRequestsFromDC" role="tabpanel" aria-labelledby="DefaulterRequestsFromDCTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="DefaulterRequestsFromDCTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>Requested By</th>
                                            {{-- <th>Current DC</th> --}}
                                            <th>Sent To</th>
                                            <th>Requested Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_riders->where('accepted', 0)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ ucFirst($rider->creator->name ?? "") }}</td>
                                            {{-- <td>{{ ucFirst($rider->passport->dc_detail->user_detail->name ?? "") }}</td> --}}
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                            <td>{{ $rider->created_at }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                >Details
                                            </button>
                                            <button
                                                    class="btn btn-info btn-sm accpet_reject_btn"
                                                    data-defaulter_rider_id="{{ $rider->id }}"
                                                    data-defaulter_rider_ppuid="{{ $rider->passport->pp_uid ?? '' }}"
                                                    data-defaulter_rider_name="{{ $rider->passport->personal_info->full_name ?? '' }}"
                                                    data-toggle="modal"
                                                    data-target="#DrcmDefaulterRiderAcceptRejectModal"
                                                    type="button"
                                                >Approval
                                            </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="DefaulterRequestsSentToDRC" role="tabpanel" aria-labelledby="DefaulterRequestsSentToDRCTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="DefaulterRequestsSentToDRCTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>Requested By</th>
                                            <th>Sent To</th>
                                            <th>Send Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_sent_to_DRC->where('approval_status', 0)->where('status', 1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                            <td>{{ $rider->created_at }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->defaulter_rider_id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                    >Details
                                                </button>
                                                {{-- <button class="btn btn-success btn-sm" type="button">
                                                    Reassign Requested
                                                </button>
                                                <button
                                                    class="btn btn-info btn-sm reassign_rider_to_dc_btn"
                                                    data-reassign_rider_id = "{{ $rider->id }}"
                                                    data-reassign_platform_id = "{{ $rider->previous_dc->platform_id }}"
                                                    data-reassign_rider_ppuid = "{{ $rider->passport->pp_uid ?? '' }}"
                                                    data-reassign_rider_name = "{{ $rider->passport->personal_info->full_name ?? '' }}"
                                                    data-toggle="modal"
                                                    data-target="#ReassignToDcModal"
                                                    type="button"
                                                    >Reassign To Dc
                                                </button> --}}
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="DefaulterRequestsAcceptedByDrc" role="tabpanel" aria-labelledby="DefaulterRequestsAcceptedByDrcTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="DefaulterRequestsAcceptedByDrcTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>Requested By</th>
                                            <th>Accepted By</th>
                                            <th>Accepted Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_sent_to_DRC->where('approval_status', 1)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ ucFirst($rider->defaulter_rider->passport->personal_info->full_name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                            <th>{{ $rider->updated_at }}</th>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->defaulter_rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                    >Details
                                                </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="DefaulterRequestsRejectedByDrc" role="tabpanel" aria-labelledby="DefaulterRequestsRejectedByDrcTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="DefaulterRequestsRejectedByDrcTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>DRCM</th>
                                            <th>DRC</th>
                                            <th>Rejected Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_sent_to_DRC->where('approval_status', 2)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ ucFirst($rider->defaulter_rider->passport->personal_info->full_name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                            <th>{{ $rider->updated_at }}</th>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->defaulter_rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                    >Details
                                                </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="tab-pane" id="current_defualter" role="tabpanel" aria-labelledby="current_defualterTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="current_defualterTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>DRCM</th>
                                            <th>DRC</th>
                                            <th>Action</th>
                                            <th>Working Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($defaulter_requests_sent_to_DRC->where('status', 1)->where('is_defaulter_now',0) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ ucFirst($rider->defaulter_rider->passport->personal_info->full_name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->defaulter_rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                    >Details
                                                </button>

                                                <?php
                                                $already_exist_gamer = null;
                                                $request_exist = isset($rider->defaulter_reassign_request_remove) ?  $rider->defaulter_reassign_request_remove : null;
                                                if($request_exist!= null){
                                                        $already_exist_gamer = $request_exist->where('approval_status','=','0')->first();
                                                }
                                                ?>
                                                @if(isset($already_exist_gamer))
                                                <h4 class="badge badge-success">Request Sent</h4>
                                                @else
                                                     <button type="button"
                                                     class="btn btn-success btn-sm remove_defaulter_cls "
                                                     data-defaulter_rider_id = "{{ $rider->id }}"
                                                     title="Remvoe For Defaulater"
                                                     >Remove From Defaulter
                                                 </button>

                                              @endif

                                            </td>
                                            <td>

                                                <?php
                                                $checkin_ab = isset($rider->defaulter_rider->passport->platform_assign) ? $rider->defaulter_rider->passport->platform_assign : null;
                                                     ?>
                                                     @if(isset($checkin_ab))
                                                     <?php  $now_checkin =  $rider->defaulter_rider->passport->assign_platforms_check() ?? $rider->defaulter_rider->passport->assign_platforms_check();  ?>
                                                                @if(isset($now_checkin))
                                                                <h4 class="badge badge-success">Checkin</h4>
                                                                @else
                                                                <h3 class="badge badge-danger">Checked Out</h3>
                                                                @endif

                                                     @else
                                                     <h3 class="badge badge-danger">Checked Out</h3>
                                                     @endisset

                                            </td>
                                        </tr>


                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- defaulter rider details accept reject modal starts-->
    <div class="modal fade" id="DrcmDefaulterRiderAcceptRejectModal" tabindex="-1" role="dialog" aria-labelledby="DrcmDefaulterRiderAcceptRejectModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="DrcmDefaulterRiderAcceptRejectModalLongTitle">DRCM Rider Approval Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rider-name: <b id="defaulter_rider_name"></b> <br> PPUID: <b id="defaulter_rider_ppuid"></b></p>
                        <hr class="p-1">
                        <input type="hidden" id="drcm_defaulter_rider_id">
                        <div class="form-group">
                            <label for="drc_id">Defaulter Rider Co-ordinators</label>
                            <select name="drc_id" id="drc_id" class="form-control form-control-sm" required>
                                {{-- <option value="">Select DRC</option> --}}
                                @foreach ($defaulter_ridrer_coordinators as $user)
                                <option value="{{ $user->id }}">{{ ucfirst($user->name ?? "") }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea id="drcm_comment" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name = "drcm_accept_reject" class="btn btn-primary drcm_accept_reject" value="1">Accept</button>
                        <button type="submit" name = "drcm_accept_reject" class="btn btn-danger drcm_accept_reject" value="2">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- defaulter rider details modal ends-->

    <!-- defaulter rider reassign modal starts-->
    <div class="modal fade" id="ReassignToDcModal" tabindex="-1" role="dialog" aria-labelledby="DefaulterRiderAcceptRejectModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('defaulter_rider_reassign_request_to_dc') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reassign To DC Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rider-name: <b id="reassign_rider_name"></b></p>
                        <p>PPUID: <b id="reassign_rider_ppuid"></b></p>
                        <input name="reassign_rider_id" id="reassign_rider_id" type="hidden"/>
                        <div class="form-group" id="dc_user_id_div"></div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reassign Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- defaulter rider reassign modal ends-->

    <!-- defaulter rider details accept reject modal starts-->

    <div id="DefaulterRiderCommentModal" class="modal fade col-11 m-5" tabindex="-1" role="dialog" aria-labelledby="DefaulterRiderCommentModalTitle" style="display: none;" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered row" role="document" id="DefaulterRiderCommentModalBody"></div>
    </div><!-- defaulter rider details modal ends-->

    <!-- defaulter rider accept reject reassign request modal starts-->
    <div class="modal fade" id="DefaulterRiderAcceptRejectReassignRequestModal" tabindex="-1" role="dialog" aria-labelledby="DefaulterRiderAcceptRejectReassignRequestModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('reassign_rider_accept_reject') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reassign Rider Approval Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rider-name: <b id="reassign_defaulter_rider_name"></b> <br> PPUID: <b id="reassign_defaulter_rider_ppuid"></b></p>
                        <hr class="p-1">
                        <input class="form-control form-control-sm" name="reassign_defaulter_rider_id" id="reassign_defaulter_rider_id" type="hidden"/>
                        <div class="form-group">
                            <label class="switch pr-1 switch-success mr-3"><span>Accept</span>
                                <input type="radio" name="approval_status" value="1" required><span class="slider"></span>
                            </label>
                            <label class="switch pr-1 switch-danger mr-3"><span>Reject</span>
                                <input type="radio" name="approval_status" value="2" required><span class="slider"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Reassign Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- defaulter rider reassign request modal ends-->

    <!--  remove defaulter modal -->
 <div class="modal fade bd-example-modal-md"  id="remove_defaulter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form action="{{ route('save_remove_defaulter') }}" method="POST">
                @csrf
                <input type="hidden" name="primary_key_id" id="primary_key_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Remove From Defualter list</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body append_remove_modal">

                    </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" id="ask_modal_close_btn" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--remove defaulter modal -->


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        $('.PendingdefaulterRiderRequestStatusChangebutton').click(function(){
            $('#passport_id').val($(this).attr('data-passport_id'));
        });
    </script>
    <script>
        $('.defaulter_rider_comments_btn').click(function(){
            var defaulter_rider_id = $(this).data('defaulter_rider_id');
            $.ajax({
                url : "{{ route('get_ajax_defaulter_rider_comments') }}",
                data : { defaulter_rider_id },
                success: function(response){
                    $('#DefaulterRiderCommentModal').empty()
                    $('#DefaulterRiderCommentModal').append(response.html)
                }
            });
        });
    </script>
    <script>
        $('.accpet_reject_btn').click(function(){
            $('#drcm_defaulter_rider_id').val($(this).attr('data-defaulter_rider_id'));
            $('#defaulter_rider_name').text($(this).attr('data-defaulter_rider_name'));
            $('#defaulter_rider_ppuid').text($(this).attr('data-defaulter_rider_ppuid'));
        });
    </script>
    <script>
        $('.drcm_accept_reject').click(function(e){
            e.preventDefault();
            var drc_id = $('#drc_id').val()
            var defaulter_rider_id = $('#drcm_defaulter_rider_id').val()
            var comment = $('#drcm_comment').val()
            var accept_reject = $(this).val();
            var _token = "{{ csrf_token() }}"
            var url = "{{ route('drcm_rider_approval') }}"
            $.ajax({
                url,
                data:{ drc_id , _token, comment, accept_reject, defaulter_rider_id },
                method: "POST",
                success: function(response){
                    tostr_display(response['alert-type'],response['message']);
                    if(response['status'] == 200){
                        $('#DrcmDefaulterRiderAcceptRejectModal').modal('hide')
                        window.location.reload()
                    }
                    // $('#dc_user_id_div').empty();
                    // $('#dc_user_id_div').append(response.html);
                }
            });
        });
    </script>
    <script>
        $('.reassign_accpet_reject_btn').click(function(){
            $('#reassign_defaulter_rider_id').val($(this).attr('data-defaulter_rider_id'));
            $('#reassign_defaulter_rider_name').text($(this).attr('data-defaulter_rider_name'));
            $('#reassign_defaulter_rider_ppuid').text($(this).attr('data-defaulter_rider_ppuid'));
        });
    </script>
    <script>
        $('.reassign_rider_to_dc_btn').click(function(){
            $('#reassign_rider_id').val($(this).attr('data-reassign_platform_id'));
            $('#reassign_rider_name').text($(this).attr('data-reassign_rider_name'));
            $('#reassign_rider_ppuid').text($(this).attr('data-reassign_rider_ppuid'));
            var platform_id = $(this).attr('data-reassign_platform_id')
            var url = "{{ route('rider_platform_wise_dc_list') }}"
            $.ajax({
                url,
                data:{platform_id},
                success: function(response){
                    $('#dc_user_id_div').empty();
                    $('#dc_user_id_div').append(response.html);
                }
            });
        });
    </script>

    <script>
        $(".remove_defaulter_cls").click(function(){

                var ids  = $(this).attr('data-defaulter_rider_id');



             $.ajax({
                url:"{{ route('get_platforms_dcs') }}",
                data:{id:ids},
                success: function(response){
                    $('.append_remove_modal').empty();
                    $('.append_remove_modal').append(response.html);

                    $("#remove_defaulter_modal").modal('show');
                     $("#primary_key_id").val(ids);

                    $('#dc_id').select2({
                            placeholder: 'Select an option'
                        });

                        $(".select2-container").css("width","100%");

                }
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            'use-strict',
            $('#DefaulterRequestsFromDCTable, #DefaulterRequestsSentToDRCTable, #DefaulterRequestsAcceptedByDrcTable, #DefaulterRequestsRejectedByDrcTable, #current_defualterTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'DC Riders',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
            });
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
    <script>
        function tostr_display(type, message){
            switch(type){
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
            }
        }
    </script>
@endsection
