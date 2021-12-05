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
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">DC Wise Defaulter Riders List</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                        <li class="nav-item">
                            <a class="nav-link active" id="AllDCRidersTab" data-toggle="tab" href="#AllDCRiders" role="tab" aria-controls="AllDCRiders" aria-selected="false">All DC Riders ( {{$all_dc_riders->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="PendingDefaulterRiderRequestsTab" data-toggle="tab" href="#PendingDefaulterRiderRequests" role="tab" aria-controls="PendingDefaulterRiderRequests" aria-selected="true">Pending Defaulter Requests( {{ $defaulter_riders->where('accepted', 0)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="AcceptedDefaulterRiderRequestsTab" data-toggle="tab" href="#AcceptedDefaulterRiderRequests" role="tab" aria-controls="AcceptedDefaulterRiderRequests" aria-selected="true">Accepted Defaulter Requests( {{ $defaulter_riders->where('accepted', 1)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="RejectedDefaulterRiderRequestsTab" data-toggle="tab" href="#RejectedDefaulterRiderRequests" role="tab" aria-controls="RejectedDefaulterRiderRequests" aria-selected="true">Rejected Defaulter Requests( {{ $defaulter_riders->where('accepted', 2)->where('status', 0)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ReassignDefaulterRiderRequestsTab" data-toggle="tab" href="#ReassignDefaulterRiderRequests" role="tab" aria-controls="ReassignDefaulterRiderRequests" aria-selected="true">Reassign Defaulter Requests( {{ $reassign_requests->where('approval_status', 0)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="AllDCRiders" role="tabpanel" aria-labelledby="AllDCRidersTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="AllDCRidersTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th class="filtering_column">DC Name</th>
                                            <th class="filtering_column">Platform Name</th>
                                            <th class="">RiderID</th>
                                            <th>Defaulter Request</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($all_dc_riders as $rider)
                                        {{-- @dd($rider->passport->platform_codes); --}}
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ ucFirst($rider->passport->personal_info->full_name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->user_detail->name ?? "") }}</td>
                                            <td>{{ $rider->platform->name ?? "" }}</td>
                                            <td>
                                                @if(count($rider->passport->platform_codes->where('platform_id',$rider->platform_id)))
                                                    {{ $rider->passport->platform_codes->where('platform_id',$rider->platform_id)->first()->platform_code}}
                                                @else
                                                    Missing ID
                                                @endif
                                            </td>
                                            <td>
                                                <?php $g_defaulter = $rider->defaulter_rider_details ? $rider->check_defaulter_rider() : null;

                                                  $is_defaulter_now =  null;
                                                if(isset($g_defaulter)){
                                                    $is_defaulter_now = $g_defaulter[0]->check_defaulter_rider() ? $g_defaulter[0]->check_defaulter_rider() : null;
                                                }

                                                ?>
                                                @if(in_array($rider->passport->id, $defaulter_riders->whereNotIn('status',[0])->pluck(['passport_id'])->toArray()))
                                                <button class="btn btn-info btn-sm btn-icon m-1 text-white" type="button">
                                                    <span class="ul-btn__icon">
                                                        <i class="i-Post-Sign"></i>
                                                    </span>
                                                    <span class="ul-btn__text">Already Requested</span>
                                                </button>
                                                @elseif(isset($is_defaulter_now))
                                                <button class="btn btn-danger btn-sm btn-icon m-1 text-white" type="button">
                                                    <span class="ul-btn__icon">
                                                        <i class="i-Post-Sign"></i>
                                                    </span>
                                                    <span class="ul-btn__text">Defaulter Rider</span>
                                                </button>

                                                @else
                                                <button class="btn btn-success btn-sm btn-icon m-1 text-white PendingdefaulterRiderRequestStatusChangebutton" id="" data-passport_id = {{ $rider->passport->id }} data-target="#PendingdefaulterRiderRequestStatusChangeModal" data-toggle="modal" type="button">
                                                    <span class="ul-btn__icon">
                                                        <i class="i-Post-Sign"></i>
                                                    </span>
                                                    <span class="ul-btn__text">Send Defaulter Request</span>
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="PendingDefaulterRiderRequests" role="tabpanel" aria-labelledby="PendingDefaulterRiderRequestsTab">
                            <div class="table-responsive">
                                <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                                    @csrf
                                    <table class="table table-sm table-hover text-11" id="PendingDefaulterRiderRequestsTable">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>ppuid</th>
                                                <th>Rider Name</th>
                                                <th>Requested By</th>
                                                <th>Current DC</th>
                                                <th>Sent To</th>
                                                <th>Requested Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($defaulter_riders->where('accepted', 0) as $rider)
                                            <tr>
                                                <td>{{ $rider->id }}</td>
                                                <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                                <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                                                <td>{{ ucFirst($rider->creator->name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->passport->dc_detail->user_detail->name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
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
                                                @if(auth()->user()->hasRole(['Defaulter Rider Co-ordinator Managers']) && $rider->accepted == 0 && auth()->id() == $rider->drcm_id)
                                                    <button
                                                        class="btn btn-info btn-sm accpet_reject_btn"
                                                        data-defaulter_rider_id="{{ $rider->id }}"
                                                        data-defaulter_rider_ppuid="{{ $rider->passport->pp_uid ?? '' }}"
                                                        data-defaulter_rider_name="{{ $rider->passport->personal_info->full_name ?? '' }}"
                                                        data-toggle="modal"
                                                        data-target="#DefaulterRiderAcceptRejectModal"
                                                        type="button"
                                                        >Accept
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="AcceptedDefaulterRiderRequests" role="tabpanel" aria-labelledby="AcceptedDefaulterRiderRequestsTab">
                            <div class="table-responsive">
                                <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                                    @csrf
                                    <table class="table table-sm table-hover text-11" id="AcceptedDefaulterRiderRequestsTable">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>ppuid</th>
                                                <th>Rider Name</th>
                                                <th>Requested By</th>
                                                <th>Sent To</th>
                                                <th>Accepted By</th>
                                                <th>Accepted Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($defaulter_riders->where('accepted', 1)->where('status', 1) as $rider)
                                            <tr>
                                                <td>{{ $rider->id }}</td>
                                                <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                                <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                                                <td>{{ ucFirst($rider->creator->name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->drc->name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->acceptor->name ?? "") }}</td>
                                                <td>{{ $rider->updated_at }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                        data-defaulter_rider_id = "{{ $rider->id }}"
                                                        data-toggle="modal"
                                                        data-target="#DefaulterRiderCommentModal"
                                                        title="Click to see defaulter rider in details"
                                                        >Details
                                                    </button>
                                                    @if(in_array($rider->id, $reassign_requests->whereIn('status',[1])->pluck(['defaulter_rider_id'])->toArray()))
                                                    <button class="btn btn-success btn-sm" type="button">
                                                        Reassign Requested
                                                    </button>
                                                    @elseif(auth()->user()->hasRole(['Admin','defaulter_rider_manager']) && $rider->accepted == 1 && auth()->id() == $rider->drcm_id)
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
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="RejectedDefaulterRiderRequests" role="tabpanel" aria-labelledby="RejectedDefaulterRiderRequestsTab">
                            <div class="table-responsive">
                                <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                                    @csrf
                                    <table class="table table-sm table-hover text-11" id="RejectedDefaulterRiderRequestsTable">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>ppuid</th>
                                                <th>Rider Name</th>
                                                <th>Requested By</th>
                                                <th>Rejected By</th>
                                                <th>Rejected Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($defaulter_riders->where('accepted', 2)->where('status',0) as $rider)
                                            <tr>
                                                <td>{{ $rider->id }}</td>
                                                <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                                <td>{{ ucFirst($rider->passport->personal_info->full_name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->creator->name ?? "") }}</td>
                                                <td>{{ ucFirst($rider->acceptor->name ?? "") }}</td>
                                                <td>{{ $rider->updated_at }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                        data-defaulter_rider_id = "{{ $rider->id }}"
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
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="ReassignDefaulterRiderRequests" role="tabpanel" aria-labelledby="ReassignDefaulterRiderRequestsTab">
                            <div class="table-responsive">
                                <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                                    @csrf
                                    <table class="table table-sm table-hover text-11" id="ReassignDefaulterRiderRequestsTable">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>ppuid</th>
                                                <th>Rider Name</th>
                                                <th>Requested By</th>
                                                <th>Sent To</th>
                                                <th>Re Aassign Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($reassign_requests->where('approval_status', 0) as $reassign_request)
                                            <tr>
                                                <td>{{ $reassign_request->id }}</td>
                                                <td>{{ $reassign_request->defaulter_rider->passport->pp_uid ?? '' }}</td>
                                                <td>{{ ucFirst($reassign_request->defaulter_rider->passport->personal_info->full_name ?? "") }}</td>
                                                <td>{{ ucFirst($reassign_request->creator->name ?? "") }}</td>
                                                <td>{{ ucFirst($reassign_request->requested_to_dc->name ?? "") }}</td>
                                                <td>{{ $reassign_request->created_at }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                        data-defaulter_rider_id = "{{ isset($reassign_request->defaulter_rider) ? $reassign_request->defaulter_rider->id : '' }}"
                                                        data-toggle="modal"
                                                        data-target="#DefaulterRiderCommentModal"
                                                        title="Click to see defaulter rider in details"
                                                        >Details
                                                    </button>
                                                    @if(auth()->user()->hasRole(['DC_roll']) && auth()->id() == $reassign_request->requested_to_dc_id)
                                                    <button
                                                        class="btn btn-info btn-sm reassign_accpet_reject_btn"
                                                        data-defaulter_rider_id="{{ $reassign_request->id }}"
                                                        data-defaulter_rider_ppuid="{{ $reassign_request->defaulter_rider->passport->pp_uid ?? '' }}"
                                                        data-defaulter_rider_name="{{ $reassign_request->defaulter_rider->passport->personal_info->full_name ?? '' }}"
                                                        data-toggle="modal"
                                                        data-target="#DefaulterRiderAcceptRejectReassignRequestModal"
                                                        type="button"
                                                        >Accept
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="PendingdefaulterRiderRequestStatusChangeModal" role="dialog" aria-labelledby="PendingdefaulterRiderRequestStatusChangeModalTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="PendingdefaulterRiderRequestStatusChangeModalTitle-1">Rider Defaulter Request form</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('defaulter_riders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="passport_id" id="passport_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control-sm" id="subject" name="subject" value="" type="text" placeholder="Enter Subject" required/>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="ckeditor form-control form-control-sm" rows="4" id="defaulter_details" name="defaulter_details" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div>Defaulter Level</div>
                                <label class="switch pr-1 switch-success mr-3"><span>Low</span>
                                    <input type="radio" name="defaulter_level" value="1" required><span class="slider"></span>
                                </label>
                                <label class="switch pr-1 switch-warning mr-3"><span>Medium</span>
                                    <input type="radio" name="defaulter_level" value="2" required><span class="slider"></span>
                                </label>
                                <label class="switch pr-1 switch-danger mr-3"><span>High</span>
                                    <input type="radio" name="defaulter_level" value="3" required><span class="slider"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div>Defaulter Rider Co-ordinator Managers</div>
                                {{-- <div class="form-group"> --}}
                                    <select name="drcm_id" id="drcm_id" class="form-control form-control-sm" required>
                                        {{-- <option value="">Select DRC</option> --}}
                                        @foreach ($defaulter_ridrer_coordinator_managers as $user)
                                        <option value="{{ $user->id }}">{{ ucfirst($user->name ?? "") }}</option>
                                        @endforeach
                                    </select>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="image-upload" style="padding: 10px;">
                                    <label for="file-input">
                                        <i class="fa fa-paperclip" style="font-size:20px"></i>
                                    </label>
                                    <input id="file-input" type="file" name="attachments[]" multiple/>
                                </div>
                                <small class="text-danger">( jpeg, png, pdf, xls,xlsx only)</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Send Defaulter Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->
    @if(auth()->user()->hasRole(['Admin','defaulter_rider_manager']))
    <!-- defaulter rider details accept reject modal starts-->
    <div class="modal fade" id="DefaulterRiderAcceptRejectModal" tabindex="-1" role="dialog" aria-labelledby="DefaulterRiderAcceptRejectModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('defaulter_rider_accept_reject') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Defaulter Rider Approval Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rider-name: <b id="defaulter_rider_name"></b> <br> PPUID: <b id="defaulter_rider_ppuid"></b></p>
                        <hr class="p-1">
                        <input class="form-control form-control-sm" name="defaulter_rider_id" id="defaulter_rider_id" type="hidden"/>
                        <div class="form-group">
                            <label class="switch pr-1 switch-success mr-3"><span>Accept</span>
                                <input type="radio" name="accept_reject" value="1" required><span class="slider"></span>
                            </label>
                            <label class="switch pr-1 switch-danger mr-3"><span>Reject</span>
                                <input type="radio" name="accept_reject" value="2" required><span class="slider"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Defaulter Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- defaulter rider details modal ends-->
    @endif
    @if(auth()->user()->hasRole(['Admin','defaulter_rider_manager']))
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
    @endif
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
            $('#defaulter_rider_id').val($(this).attr('data-defaulter_rider_id'));
            $('#defaulter_rider_name').text($(this).attr('data-defaulter_rider_name'));
            $('#defaulter_rider_ppuid').text($(this).attr('data-defaulter_rider_ppuid'));
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
        $(document).ready(function () {
            'use-strict',
            $('#AllDCRidersTable, #PendingDefaulterRiderRequestsTable, #AcceptedDefaulterRiderRequestsTable').DataTable( {
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
@endsection
