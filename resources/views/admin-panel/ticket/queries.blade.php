@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/date/css/tail.datetime-default-orange.css') }}">

@endsection
@section('content')
    <style>
        .buttons-page-length {
            margin-left: 20px !important;
        }
        .font_size_cls {
            font-size: 17px !important;
            cursor: pointer;
        }
        .thead-dark {
            font-size: 12px !important;
        }
    </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>Queries</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic"
                role="tab" aria-controls="homeBasic" aria-selected="true">Pending
                <span>({{ auth()->user()->id == 1 ? count($admin_tickets->where('is_checked', '0')) : count($tickets->where('is_checked', '0')) }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="process-basic-tab" data-toggle="tab" href="#processBasic" role="tab"
                aria-controls="processBasic" aria-selected="true">In Process
                <span>({{ auth()->user()->id == 1 ? count($admin_tickets->where('is_checked', '2')) : count($tickets->where('is_checked', '2')) }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab"
                aria-controls="profileBasic" aria-selected="false">Closed
                <span>({{ auth()->user()->id == 1 ? count($admin_tickets->where('is_checked', '1')) : count($tickets->where('is_checked', '1')) }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="reject-basic-tab" data-toggle="tab" href="#rejectBasic" role="tab"
                aria-controls="rejectBasic" aria-selected="false">Rejected
                <span>({{ auth()->user()->id == 1 ? count($admin_tickets->where('is_checked', '3')) : count($tickets->where('is_checked', '3')) }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="shared-basic-tab" data-toggle="tab" href="#sharedBasic" role="tab"
                aria-controls="sharedBasic" aria-selected="false">Shared By You
                <span>({{ auth()->user()->id == 1 ? count($ticketshare) : count($ticketshare) }})</span>
            </a>
        </li>
    </ul>
    <br>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        {{-- accordian start --}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                        <a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false">
                                            <span><i class="i-Filter-2 ul-accordion__font"> </i></span>
                                               Filter
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">Select Name</label>
                                            <select class="form-control ab_cls" name="name_id" id="name_id">
                                                <option value="">select an option</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="start_date" autocomplete="off"
                                                class="form-control form-control-rounded" id="start_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="end_date" autocomplete="off"
                                                class="form-control form-control-rounded" id="end_date">
                                        </div>
                                        <input type="hidden" name="table_name" id="table_name" value="datatable">
                                        <div class="col-md-3 form-group mb-3 " style="float: left; margin-top: 20px;">
                                            <label for="end_date" style="visibility: hidden;">End Date</label>
                                            <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Magnifi-Glass1"></i>
                                                </span>
                                            </button>
                                            <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Close"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- accordian end here --}}
                        <div class="row">
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ed6a07" class="badge badge-square-primary xl m-1 font_size_cls" id="pending_hours_24_block">
                                        0
                                    </span>
                                </li>
                                <label for="start_date"> > 24 hours AND <= 48 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ff2a47" class="badge badge-square-secondary xl m-1 font_size_cls" id="pending_hours_48_block">0</span>
                                </li>
                                <label for="start_date"> > 48 hours AND <= 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #8b0000" class="badge badge-square-success xl m-1 font_size_cls" id="pending_hours_72_block">0</span>
                                </li>
                                <label for="start_date"> > 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span class="badge badge-square-light xl m-1 font_size_cls" id="pending_less_24_block">0</span>
                                </li>
                                <label for="start_date"> < 24 hours</label>
                                <button class="btn btn-outline-success btn-icon m-1 float-right" id="remove_apply_filter_two" type="button">
                                    <span class="ul-btn__icon">
                                        <i class="i-Reload"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover text-12" id="datatable">
                                <thead class="thead-dark text-12">
                                    <tr>
                                        <th>Checked</th>
                                        <th>Sr. No</th>
                                        <th>More</th>
                                        <th>Created At</th>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        <th>Platform</th>
                                        <th>Platform ID</th>
                                        <th>Message</th>
                                        <th>Raised for</th>
                                        {{-- <th>Processing By</th> --}}
                                        <th>Image</th>
                                        <th>Voice</th>
                                        <th>Close By</th>
                                    </tr>
                                </thead>
                                <?php $pending_name_array = []; ?>
                                <?php $inprocess_name_array = []; ?>
                                <?php $closed_name_array = []; ?>
                                <?php $reject_name_array = []; ?>
                                <?php $share_name_array = []; ?>
                                <?php $total_pending_24_ticket = 0; ?>
                                <?php $total_pending_48_ticket = 0; ?>
                                <?php $total_pending_72_ticket = 0; ?>
                                <?php $total_pending_less_24_ticket = 0; ?>
                                @if (auth()->user()->id == 1)
                                    <tbody>
                                        @foreach ($admin_tickets as $ticket)
                                            <?php
                                            $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                            $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 0)
                                                <?php
                                                    $from = \Carbon\Carbon::parse($ticket->created_at);
                                                    $to = \Carbon\Carbon::now();
                                                    $hours_spend = $to->diffInHours($from);
                                                    $color_code = '';
                                                    $font_color = '';
                                                    if ($hours_spend < 24) {
                                                        $total_pending_less_24_ticket = $total_pending_less_24_ticket + 1;
                                                    } elseif ($hours_spend >= 24 && $hours_spend < 48) {
                                                        $color_code = '#ed6a07';
                                                        $font_color = 'black';
                                                        $total_pending_24_ticket = $total_pending_24_ticket + 1;
                                                    } elseif ($hours_spend >= 48 && $hours_spend <= 72) {
                                                        $color_code = '#ff2a47';
                                                        $font_color = 'black';
                                                        $total_pending_48_ticket = $total_pending_48_ticket + 1;
                                                    } elseif ($hours_spend > 72) {
                                                        $color_code = '#8b0000';
                                                        $font_color = 'white';
                                                        $total_pending_72_ticket = $total_pending_72_ticket + 1;
                                                    }
                                                ?>
                                                <tr style="background-color: {{ $color_code . ';' }} color :{{ $font_color }} ">
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user_ticket->profile_ticket->passport_ticket->passport_no }}"
                                                            @if (!empty($color_code)) style="color:white;" @endif target="_blank">
                                                            {{ $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <?php $name = $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $pending_name_array[] = $gamer; ?>
                                                    <td>{{ isset($ticket->platform_->name) ? $ticket->platform_->name : '' }}</td>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}</td>
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="" />
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))
                                                            <audio controls>
                                                                <source
                                                                    src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}"
                                                                    type="audio/ogg">
                                                                    Your browser does not support the audio element.
                                                            </audio>
                                                        @else
                                                            <span class="badge bg-info">No Voice</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <span style="display: none;">total_pending_24_ticket = {{ $total_pending_24_ticket }}</span>
                                        <span style="display: none;">total_pending_48_ticket = {{ $total_pending_48_ticket }}</span>
                                        <span style="display: none;">total_pending_72_ticket = {{ $total_pending_72_ticket }}</span>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <?php
                                                $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                                $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 0)
                                                <?php
                                                    $from = \Carbon\Carbon::parse($ticket->created_at);
                                                    $to = \Carbon\Carbon::now();
                                                    $hours_spend = $to->diffInHours($from);
                                                    $color_code = '';
                                                    $font_color = '';
                                                    if ($hours_spend < 24) {
                                                        $total_pending_less_24_ticket = $total_pending_less_24_ticket + 1;
                                                    } elseif ($hours_spend >= 24 && $hours_spend < 48) {
                                                        $color_code = '#ed6a07';
                                                        $font_color = 'black';
                                                        $total_pending_24_ticket = $total_pending_24_ticket + 1;
                                                    } elseif ($hours_spend >= 48 && $hours_spend <= 72) {
                                                        $color_code = '#ff2a47';
                                                        $font_color = 'black';
                                                        $total_pending_48_ticket = $total_pending_48_ticket + 1;
                                                    } elseif ($hours_spend > 72) {
                                                        $color_code = '#8b0000';
                                                        $font_color = 'white';
                                                        $total_pending_72_ticket = $total_pending_72_ticket + 1;
                                                    }
                                                ?>
                                                <tr style="background-color: {{ $color_code . ';' }} color :{{ $font_color }} ">
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user->profile->passport->passport_no }}"
                                                            @if (!empty($color_code)) style="color:white;" @endif
                                                            target="_blank">{{ $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->platform_->name }}</td>
                                                    <?php $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $pending_name_array[] = $gamer; ?>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}</td>
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))
                                                            <audio controls>
                                                                <source src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    <!----tab2---------->
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        {{-- accordian start --}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                        <a class="text-default collapsed collapse_cls_close" data-toggle="collapse" href="#accordion-item-icons-3" aria-expanded="false">
                                            <span><i class="i-Filter-2 ul-accordion__font"> </i></span> Filter
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-3" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">Select Name</label>
                                            <select class="form-control ab_cls" name="close_name_id" id="close_name_id">
                                                <option value="">select an option</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="close_start_date" autocomplete="off" class="form-control form-control-rounded" id="close_start_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="close_end_date" autocomplete="off" class="form-control form-control-rounded" id="close_end_date">
                                        </div>
                                        <input type="hidden" name="table_name" id="table_name" value="datatable">
                                        <div class="col-md-3 form-group mb-3 " style="float: left; margin-top: 20px;">
                                            <label for="end_date" style="visibility: hidden;">End Date</label>
                                            <button class="btn btn-info btn-icon m-1" id="close_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Magnifi-Glass1"></i>
                                                </span>
                                            </button>
                                            <button class="btn btn-danger btn-icon m-1" id="close_remove_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon">
                                                    <i class="i-Close"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- accordian end here --}}
                        <div class="table-responsive">
                            <table class="table table-sm table-hover text-12" id="datatable_close">
                                <thead class="thead-dark ">
                                    <tr>
                                        <th>Checked</th>
                                        <th>Sr. No</th>
                                        <th>More</th>
                                        <th>Created At</th>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        {{-- <th>Email</th> --}}
                                        {{-- <th>Contact</th> --}}
                                        {{-- <th>Whatsapp</th> --}}
                                        <th>Platform</th>
                                        <th>Platform ID</th>
                                        <th>Message</th>
                                        <th>Raised for</th>
                                        {{-- <th>Processing By</th> --}}
                                        <th>Image</th>
                                        <th>Voice</th>
                                        <th>Closed By</th>
                                    </tr>
                                </thead>
                                @if(auth()->user()->id == 1)
                                    <tbody>
                                        @foreach ($admin_tickets as $ticket)
                                            <?php
                                                $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                                $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if($ticket->is_checked == 1)
                                                <tr>
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }} </td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user_ticket->profile_ticket->passport_ticket->passport_no }}"
                                                            target="_blank">{{ $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->platform_->name }}</td>
                                                    <?php $name = $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $closed_name_array[] = $gamer; ?>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))
                                                            {{-- <audio controls>
                                                            <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                            Your browser does not support the audio element.
                                                        </audio> --}}
                                                            {{-- <a class="text-success mr-2" href="{{route('download-voice',$ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a> --}}
                                                            {{-- <a download="Voice_note" class="text-success mr-2" href="{{asset($ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a> --}}
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <?php
                                                $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                                $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 1)
                                                <tr>
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user_ticket->profile_ticket->passport_ticket->passport_no }}"
                                                            target="_blank">{{ $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->platform_->name }}</td>
                                                    <?php $name = $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $closed_name_array[] = $gamer; ?>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}"
                                                                target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))
                                                            {{--
                                                                <audio controls>
                                                                    <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                            --}}
                                                            <a class="text-success mr-2" href="{{ route('download-voice', $ticket->voice_message) }}" target="_blank">
                                                                <i class="nav-icon i-Download font-weight-bold"></i>
                                                            </a>
                                                            <a download="Voice_note" class="text-success mr-2" href="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" target="_blank">
                                                                <i class="nav-icon i-Download font-weight-bold"></i>
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }} </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    <!-------tab2----->
                    <div class="tab-pane fade" id="rejectBasic" role="tabpanel" aria-labelledby="reject-basic-tab">
                        {{-- accordian start --}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                        <a class="text-default collapsed collapse_cls_reject" data-toggle="collapse" href="#accordion-item-icons-4" aria-expanded="false">
                                            <span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-4" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">Select Name</label>
                                            <select class="form-control " name="reject_name_id" id="reject_name_id">
                                                <option value="">select an option</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="reject_start_date" autocomplete="off" class="form-control form-control-rounded" id="reject_start_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="reject_end_date" autocomplete="off" class="form-control form-control-rounded" id="reject_end_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left; margin-top: 20px;">
                                            <label for="end_date" style="visibility: hidden;">End Date</label>
                                            <button class="btn btn-info btn-icon m-1" id="reject_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon">
                                                <i class="i-Magnifi-Glass1"></i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon m-1" id="reject_remove_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon"><i class="i-Close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- accordian end here --}}

                        <div class="table-responsive">
                            <table class="table table-sm table-hover text-12" id="datatable_reject">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Checked</th>
                                        <th>Sr. No</th>
                                        <th>More</th>
                                        <th>Created At</th>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        <th>Platform</th>
                                        <th>Platform ID</th>
                                        <th>Message</th>
                                        <th>Raised for</th>
                                        {{-- <th>Processing By</th> --}}
                                        <th>Image</th>
                                        <th>Voice</th>
                                        <th>Rejected By</th>

                                    </tr>
                                </thead>
                                @if (auth()->user()->id == 1)
                                    <tbody>

                                        @foreach ($admin_tickets as $ticket)
                                            <?php $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                            $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 3)
                                                <tr>
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td><a class="text-success mr-2"
                                                            href="{{ route('manage_ticket.show', $ticket->id) }}"><i
                                                                class="nav-icon i-Ticket font-weight-bold"></i></a></td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td><a href="{{ route('profile.index') }}?passport_id={{ $ticket->user->profile->passport->passport_no }}"
                                                            target="_blank">{{ $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : '' }}</a>
                                                    </td>
                                                    {{-- <td>{{$ticket->user->email}}</td> --}}
                                                    {{-- <td>{{$ticket->user->profile->contact_no}}</td> --}}
                                                    {{-- <td>{{$ticket->user->profile->whatsapp}}</td> --}}
                                                    <td>{{ $ticket->platform_->name }}</td>

                                                    <?php $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ''; ?>
                                                    <?php $gamer = [
                                                        'name' => $name,
                                                        'user_id' => $ticket->user_id,
                                                    ]; ?>
                                                    <?php $reject_name_array[] = $gamer; ?>

                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}
                                                    </td>
                                                    {{-- <td>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</td> --}}
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}"
                                                                target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table"
                                                                    src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}"
                                                                    alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))

                                                            <audio controls>
                                                                <source
                                                                    src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}"
                                                                    type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                            {{-- <a class="text-success mr-2" href="{{route('download-voice',$ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a> --}}
                                                            {{-- <a download="Voice_note" class="text-success mr-2" href="{{asset($ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a> --}}
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif

                                                    </td>

                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }}
                                                    </td>
                                                    {{-- <td> --}}
                                                    {{--  --}}{{-- <a class="text-success mr-2" href="{{route('manage_ticket.show',$ticket->id)}}"><i class="nav-icon i-Ticket font-weight-bold"></i></a> --}}
                                                    {{-- </td> --}}
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>

                                        @foreach ($tickets as $ticket)
                                            <?php $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                            $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 3)
                                                <tr>
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td><a class="text-success mr-2"
                                                            href="{{ route('manage_ticket.show', $ticket->id) }}"><i
                                                                class="nav-icon i-Ticket font-weight-bold"></i></a></td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td><a href="{{ route('profile.index') }}?passport_id={{ $ticket->user->profile->passport->passport_no }}"
                                                            target="_blank">{{ $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : '' }}</a>
                                                    </td>
                                                    {{-- <td>{{$ticket->user->email}}</td> --}}
                                                    {{-- <td>{{$ticket->user->profile->contact_no}}</td> --}}
                                                    {{-- <td>{{$ticket->user->profile->whatsapp}}</td> --}}
                                                    <td>{{ $ticket->platform_->name }}</td>

                                                    <?php $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ''; ?>
                                                    <?php $gamer = [
                                                        'name' => $name,
                                                        'user_id' => $ticket->user_id,
                                                    ]; ?>
                                                    <?php $reject_name_array[] = $gamer; ?>

                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}
                                                    </td>
                                                    {{-- <td>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</td> --}}
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}"
                                                                target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table"
                                                                    src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}"
                                                                    alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))

                                                            <audio controls>
                                                                <source
                                                                    src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}"
                                                                    type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                            <a class="text-success mr-2"
                                                                href="{{ route('download-voice', $ticket->voice_message) }}"
                                                                target="_blank"><i
                                                                    class="nav-icon i-Download font-weight-bold"></i></a>
                                                            <a download="Voice_note" class="text-success mr-2"
                                                                href="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}"
                                                                target="_blank"><i
                                                                    class="nav-icon i-Download font-weight-bold"></i></a>
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ $ticket->closed_name ? $ticket->closed_name->name : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @endif

                            </table>
                        </div>







                    </div>
                    <!-------tab3----->
                    <div class="tab-pane fade" id="processBasic" role="tabpanel" aria-labelledby="process-basic-tab">
                        {{-- accordian start --}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                        <a class="text-default collapsed collapse_cls_process" data-toggle="collapse" href="#accordion-item-icons-2" aria-expanded="false">
                                            <span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-2" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">Select Name</label>
                                            <select class="form-control " name="process_name_id" id="process_name_id">
                                                <option value="">select an option</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="process_start_date" autocomplete="off" class="form-control form-control-rounded" id="process_start_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="process_end_date" autocomplete="off" class="form-control form-control-rounded" id="process_end_date">
                                        </div>
                                        <input type="hidden" name="table_name" id="table_name" value="datatable">
                                        <div class="col-md-3 form-group mb-3 " style="float: left; margin-top: 20px;">
                                            <label for="end_date" style="visibility: hidden;">End Date</label>
                                            <button class="btn btn-info btn-icon m-1" id="prcess_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon m-1" id="process_remove_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon"><i class="i-Close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- accordian end here --}}
                        <div class="row">
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ed6a07;" class="badge badge-square-primary xl m-1 font_size_cls" id="process_hours_24_block">0</span>
                                </li>
                                <label for="start_date"> > 24 hours AND <= 48 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ff2a47;" class="badge badge-square-secondary xl m-1 font_size_cls" id="process_hours_48_block">0</span>
                                </li>
                                <label for="start_date"> > 48 hours AND <= 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #8b0000;" class="badge badge-square-success xl m-1 font_size_cls" id="process_hours_72_block">0</span>
                                </li>
                                <label for="start_date"> > 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span class="badge badge-square-light xl m-1 font_size_cls" id="process_less_24_block">0</span>
                                </li>
                                <label for="start_date"> < 24 hours</label>
                                <br>
                                <button class="btn btn-outline-success btn-icon m-1 float-right" id="process_remove_apply_filter_two" type="button">
                                    <span class="ul-btn__icon"><i class="i-Reload"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover text-12" id="datatable_process">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Checked</th>
                                        <th>Sr. No</th>
                                        <th>More</th>
                                        <th>Created At</th>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        <th>Platform</th>
                                        <th>Platform ID</th>
                                        <th>Message</th>
                                        <th>Raised for</th>
                                        {{-- <th>Processing By</th> --}}
                                        <th>Image</th>
                                        <th>Voice</th>
                                        <th>Process By</th>
                                    </tr>
                                </thead>
                                <?php $total_24_hours = 0; ?>
                                <?php $total_48_hours = 0; ?>
                                <?php $total_72_hours = 0; ?>
                                <?php $total_less_24_process_hours = 0; ?>
                                @if (auth()->user()->id == 1)
                                    <tbody>
                                        @foreach ($admin_tickets as $ticket)
                                            <?php
                                                $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                                $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if($ticket->is_checked == 2)
                                                <?php
                                                    $from = \Carbon\Carbon::parse($ticket->created_at);
                                                    $to = \Carbon\Carbon::now();
                                                    $hours_spend = $to->diffInHours($from);
                                                    $color_code = '';
                                                    $font_color = '';
                                                    if ($hours_spend < 24) {
                                                        $total_less_24_process_hours = $total_less_24_process_hours + 1;
                                                    } elseif ($hours_spend >= 24 && $hours_spend < 48) {
                                                        $color_code = '#ed6a07';
                                                        $font_color = 'black';
                                                        $total_24_hours = $total_24_hours + 1;
                                                    } elseif ($hours_spend >= 48 && $hours_spend <= 72) {
                                                        $color_code = '#ff2a47';
                                                        $font_color = 'black';
                                                        $total_48_hours = $total_48_hours + 1;
                                                    } elseif ($hours_spend > 72) {
                                                        $color_code = '#8b0000';
                                                        $font_color = 'white';
                                                        $total_72_hours = $total_72_hours + 1;
                                                    }
                                                ?>
                                                <tr style="background-color: {{ $color_code . ';' }} color :{{ $font_color }} ">
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user_ticket->profile_ticket->passport_ticket->passport_no }}"
                                                            @if (!empty($color_code)) style="color:white;" @endif
                                                            target="_blank">{{ $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->platform_->name }}</td>
                                                    <?php $name = $ticket->user_ticket->profile_ticket ? $ticket->user_ticket->profile_ticket->passport_ticket->personal_info_ticket->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $inprocess_name_array[] = $gamer; ?>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}</td>
                                                    <td>
                                                        @if(isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->voice_message))
                                                            <audio controls>
                                                                <source src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ isset($ticket->closed_name) ? $ticket->closed_name->name : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <span style="display: none;">total_process_24={{ $total_24_hours }}</span>
                                        <span style="display: none;">total_process_48={{ $total_48_hours }}</span>
                                        <span style="display: none;">total_process_72={{ $total_72_hours }}</span>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <?php
                                                $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                                $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                            ?>
                                            @if ($ticket->is_checked == 2)
                                                <?php
                                                    $from = \Carbon\Carbon::parse($ticket->created_at);
                                                    $to = \Carbon\Carbon::now();
                                                    $hours_spend = $to->diffInHours($from);
                                                    $color_code = '';
                                                    $font_color = '';
                                                    if ($hours_spend < 24) {
                                                        $total_less_24_process_hours = $total_less_24_process_hours + 1;
                                                    } elseif ($hours_spend >= 24 && $hours_spend < 48) {
                                                        $color_code = '#ed6a07';
                                                        $font_color = 'black';
                                                        $total_24_hours = $total_24_hours + 1;
                                                    } elseif ($hours_spend >= 48 && $hours_spend <= 72) {
                                                        $color_code = '#ff2a47';
                                                        $font_color = 'black';
                                                        $total_48_hours = $total_48_hours + 1;
                                                    } elseif ($hours_spend > 72) {
                                                        $color_code = '#8b0000';
                                                        $font_color = 'white';
                                                        $total_72_hours = $total_72_hours + 1;
                                                    }
                                                ?>
                                                <tr style="background-color: {{ $color_code . ';' }} color :{{ $font_color }} ">
                                                    <th>{{ $ticket->is_checked }}</th>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>
                                                        <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                            <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->created_at }}</td>
                                                    <th>{{ $ticket->ticket_id }}</th>
                                                    <td>
                                                        <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user->profile->passport->passport_no }}"
                                                            @if (!empty($color_code)) style="color:white;" @endif
                                                            target="_blank">{{ $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ticket->platform_->name }}</td>
                                                    <?php $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ''; ?>
                                                    <?php
                                                        $gamer = [
                                                            'name' => $name,
                                                            'user_id' => $ticket->user_id,
                                                        ];
                                                    ?>
                                                    <?php $inprocess_name_array[] = $gamer; ?>
                                                    <td>{{ $ticket->platform_id }}</td>
                                                    <td>{{ $ticket->message }}</td>
                                                    <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($ticket->image_url))
                                                            <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                                <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                            </a>
                                                        @else
                                                            <span class="badge badge-info">No Image</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if(isset($ticket->voice_message))
                                                            <audio controls>
                                                                <source src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        @else
                                                            <span class="badge badge-info">No Voice</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ isset($ticket->closed_name) ? $ticket->closed_name->name : 'N/A' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    {{-- share tab start --}}
                    <div class="tab-pane fade" id="sharedBasic" role="tabpanel" aria-labelledby="shared-basic-tab">
                        {{-- accordian start --}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 ">
                                        <a class="text-default collapsed collapse_cls_share" data-toggle="collapse" href="#accordion-item-icons-4" aria-expanded="false">
                                            <span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-4" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">Select Name</label>
                                            <select class="form-control " name="shared_name_id" id="shared_name_id">
                                                <option value="">select an option</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="shared_start_date" autocomplete="off" class="form-control form-control-rounded" id="shared_start_date">
                                        </div>
                                        <div class="col-md-3 form-group mb-3 " style="float: left;">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="shared_end_date" autocomplete="off" class="form-control form-control-rounded" id="shared_end_date">
                                        </div>
                                        <input type="hidden" name="table_name" id="table_name_shared" value="datatable">
                                        <div class="col-md-3 form-group mb-3 " style="float: left; margin-top: 20px;">
                                            <label for="end_date" style="visibility: hidden;">End Date</label>
                                            <button class="btn btn-info btn-icon m-1" id="shared_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon m-1" id="shared_remove_apply_filter" data="datatable" type="button">
                                                <span class="ul-btn__icon"><i class="i-Close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- accordian end here --}}
                        <div class="table-responsive">
                            <table class="table table-sm table-hover text-12" id="datatable_shared">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Checked</th>
                                        <th>Sr. No</th>
                                        <th>More</th>
                                        <th>Created At</th>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        <th>Platform</th>
                                        <th>Platform ID</th>
                                        <th>Message</th>
                                        <th>Raised for</th>
                                        <th>Status</th>
                                        {{-- <th>Processing By</th> --}}
                                        <th>Image</th>
                                        <th>Voice</th>
                                        <th>Process By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ticketshare as $ticket)
                                        <?php
                                            $image_url = $ticket->image_url ? ltrim($ticket->image_url, $ticket->image_url[0]) : '';
                                            $voice_message = $ticket->voice_message ? ltrim($ticket->voice_message, $ticket->voice_message[0]) : '';
                                        ?>
                                        <?php
                                            $from = \Carbon\Carbon::parse($ticket->created_at);
                                            $to = \Carbon\Carbon::now();
                                            $hours_spend = $to->diffInHours($from);
                                            $color_code = '';
                                            $font_color = '';
                                            if ($hours_spend >= 24 && $hours_spend < 48) {
                                                $color_code = '#ed6a07';
                                                $font_color = 'black';
                                            } elseif ($hours_spend >= 48 && $hours_spend <= 72) {
                                                $color_code = '#ff2a47';
                                                $font_color = 'black';
                                            } elseif ($hours_spend > 72) {
                                                $color_code = '#8b0000';
                                                $font_color = 'white';
                                            }
                                        ?>
                                        <tr style="background-color: {{ $color_code . ';' }} color :{{ $font_color }} ">
                                            <th>{{ $ticket->is_checked }}</th>
                                            <td>{{ $ticket->id }}</td>
                                            <td>
                                                <a class="text-success mr-2" href="{{ route('manage_ticket.show', $ticket->id) }}">
                                                    <i class="nav-icon i-Ticket font-weight-bold"></i>
                                                </a>
                                            </td>
                                            <td>{{ $ticket->created_at }}</td>
                                            <th>{{ $ticket->ticket_id }}</th>
                                            <td>
                                                <a href="{{ route('profile.index') }}?passport_id={{ $ticket->user->profile->passport->passport_no }}"
                                                    style="color:white;"
                                                    target="_blank">{{ $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : '' }}</a>
                                            </td>
                                            <td>{{ $ticket->platform_->name }}</td>
                                            <?php $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ''; ?>
                                            <?php
                                                $gamer = [
                                                    'name' => $name,
                                                    'user_id' => $ticket->user_id,
                                                ];
                                            ?>
                                            <?php $share_name_array[] = $gamer; ?>
                                            <td>{{ $ticket->platform_id }}</td>
                                            <td>{{ $ticket->message }}</td>
                                            <td>{{ isset($ticket->department->name) ? $ticket->department->name : '' }}</td>
                                            <?php
                                                $status = '';
                                                if ($ticket->is_checked = '0') {
                                                    $status = 'Pending';
                                                } elseif ($ticket->is_checked = '2') {
                                                    $status = 'In process';
                                                } elseif ($ticket->is_checked = '1') {
                                                    $status = 'Closed';
                                                } elseif ($ticket->is_checked = '3') {
                                                    $status = 'Rejected';
                                                }
                                            ?>
                                            <td>{{ $status }}</td>
                                            <td>
                                                @if (isset($ticket->image_url))
                                                    <a href="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" target="_blank">
                                                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No Image</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if (isset($ticket->voice_message))
                                                    <audio controls>
                                                        <source src="{{ Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    <span class="badge badge-info">No Voice</span>
                                                @endif
                                            </td>
                                            <td>{{ isset($ticket->closed_name) ? $ticket->closed_name->name : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- shared tab end --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Update Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        Are you sure want to Update the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="updateSubmit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/date/js/tail.datetime-full.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        tail.DateTime("#start_date", {
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function() {
            tail.DateTime("#end_date", {
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        tail.DateTime("#process_start_date", {
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function() {
            tail.DateTime("#process_end_date", {
                dateStart: $('#process_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        tail.DateTime("#close_start_date", {
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function() {
            tail.DateTime("#close_end_date", {
                dateStart: $('#close_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        tail.DateTime("#reject_start_date", {
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function() {
            tail.DateTime("#reject_end_date", {
                dateStart: $('#reject_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        tail.DateTime("#shared_start_date", {
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function() {
            tail.DateTime("#shared_end_date", {
                dateStart: $('#shared_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        //share date end here
    </script>

    <script>
        $(document).ready(function() {
            'use strict';
            $('#datatable ,#datatable_close ,#datatable_process ,#datatable_reject ,#datatable_shared').DataTable({
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false
                    },
                    {
                        "width": 600,
                        "targets": [8]
                    },
                ],
                "dom": 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Pending Tickets',
                        text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
                "scrollX": true,
            });
        });
        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                // alert(currentTab)
                var split_ab = currentTab;
                // alert(split_ab);
                if (split_ab == "home-basic-tab") {
                    var table = $('#datatable').DataTable();
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                } else if (split_ab == "profile-basic-tab") {
                    var table = $('#datatable_close').DataTable();
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                } else if (split_ab == "process-basic-tab") {
                    var table = $('#datatable_process').DataTable();
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                } else if (split_ab == "reject-basic-tab") {
                    var table = $('#datatable_reject').DataTable();
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                } else if (split_ab == "shared-basic-tab") {
                    var table = $('#datatable_shared').DataTable();
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                }
            });
        });
        function updateData(id) {
            var id = id;
            var url = '{{ route('ticket.update', ':id') }}';
            url = url.replace(':id', id);
            $("#updateForm").attr('action', url);
        }
        function updateSubmit() {
            $("#updateForm").submit();
        }
    </script>
    <script>
        function pending_name_dropdown() {
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $pending_name_array))); ?>
            @foreach ($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id'] }}">{{ $gamer['name'] }}</option>';
            @endforeach
            return ab_html;
        }
        function in_process_name_dropdown() {
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $inprocess_name_array))); ?>
            <?php // dd($data);
            ?>
            @foreach ($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id'] }}">{{ $gamer['name'] }}</option>';
            @endforeach
            return ab_html;
        }
        function close_name_dropdown() {
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $closed_name_array))); ?>
            <?php // dd($data);
            ?>
            @foreach ($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id'] }}">{{ $gamer['name'] }}</option>';
            @endforeach
            return ab_html;
        }
        function reject_name_dropdown() {
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $reject_name_array))); ?>
            <?php // dd($data);
            ?>
            @foreach ($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id'] }}">{{ $gamer['name'] }}</option>';
            @endforeach
            return ab_html;
        }
        function share_name_dropdown() {
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $share_name_array))); ?>
            <?php // dd($data);
            ?>
            @foreach ($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id'] }}">{{ $gamer['name'] }}</option>';
            @endforeach
            return ab_html;
        }
        $(document).ready(function() {
            $(".collapse_cls_pending").click(function() {
                $("#name_id").empty();
                $("#name_id").append('<option value="">Select an option</option>');
                $("#name_id").append(pending_name_dropdown());
                $('#name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width', '100%');
            });
            $(".collapse_cls_process").click(function() {
                $("#process_name_id").empty();
                $("#process_name_id").append('<option value="">Select an option</option>');
                $("#process_name_id").append(in_process_name_dropdown());
                $('#process_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width', '100%');
            });
            $(".collapse_cls_close").click(function() {
                $("#close_name_id").empty();
                $("#close_name_id").append('<option value="">Select an option</option>');

                $("#close_name_id").append(close_name_dropdown());
                $('#close_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width', '100%');
            });
            $(".collapse_cls_reject").click(function() {
                $("#reject_name_id").empty();
                $("#reject_name_id").append('<option value="">Select an option</option>');
                $("#reject_name_id").append(reject_name_dropdown());
                $('#reject_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width', '100%');
            });
            $(".collapse_cls_share").click(function() {
                $("#shared_name_id").empty();
                $("#shared_name_id").append('<option value="">Select an option</option>');
                $("#shared_name_id").append(share_name_dropdown());
                $('#shared_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width', '100%');
            });
            $("#remove_apply_filter").click(function() {
                $('#name_id').val(null).trigger('change');
                $("#start_date").val("");
                $("#end_date").val("");
                $("#apply_filter").click();
                pending_ticket_count_color();
            });
            $("#remove_apply_filter_two").click(function() {
                $('#name_id').val(null).trigger('change');
                $("#start_date").val("");
                $("#end_date").val("");
                $("#apply_filter").click();
                pending_ticket_count_color();
            });
            $("#apply_filter").click(function() {
                var passport_id = $(this).val();
                var name_id = $("#name_id option:selected").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {
                        name_id: name_id,
                        start_date: start_date,
                        end_date: end_date,
                        table_checked: "0",
                        _token: token
                    },
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable').DataTable();
                        ab_table.destroy();
                        $('#datatable tbody').empty();
                        $('#datatable tbody').append(response.html);
                        var table = $('#datatable').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [{
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    "width": 600,
                                    "targets": [8]
                                },
                            ],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page: 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#container').css('display', 'block');
                        table.columns.adjust().draw();
                        pending_ticket_count_color();
                    }
                });
            });
            //pending end here
            //process ticket filter start here
            $("#process_remove_apply_filter").click(function() {
                $('#process_name_id').val(null).trigger('change');
                $("#process_start_date").val("");
                $("#process_end_date").val("");
                $("#prcess_apply_filter").click();
                process_ticket_count_color();
            });
            $("#process_remove_apply_filter_two").click(function() {
                $('#process_name_id').val(null).trigger('change');
                $("#process_start_date").val("");
                $("#process_end_date").val("");
                $("#prcess_apply_filter").click();
                process_ticket_count_color();
            });
            $("#prcess_apply_filter").click(function() {
                var name_id = $("#process_name_id option:selected").val();
                var start_date = $("#process_start_date").val();
                var end_date = $("#process_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {
                        name_id: name_id,
                        start_date: start_date,
                        end_date: end_date,
                        table_checked: "2",
                        _token: token
                    },
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_process').DataTable();
                        ab_table.destroy();
                        $('#datatable_process tbody').empty();
                        $('#datatable_process tbody').append(response.html);
                        var table = $('#datatable_process').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [{
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    "width": 600,
                                    "targets": [8]
                                },
                            ],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page: 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#container').css('display', 'block');
                        table.columns.adjust().draw();
                        process_ticket_count_color();
                    }
                });
            });
            //process filter end here

            //Closed ticket filter start here
            $("#close_remove_apply_filter").click(function() {
                $('#close_name_id').val(null).trigger('change');
                $("#close_start_date").val("");
                $("#close_end_date").val("");
                $("#close_apply_filter").click();
            });
            $("#close_apply_filter").click(function() {
                var name_id = $("#close_name_id option:selected").val();
                var start_date = $("#close_start_date").val();
                var end_date = $("#close_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {
                        name_id: name_id,
                        start_date: start_date,
                        end_date: end_date,
                        table_checked: "1",
                        _token: token
                    },
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_close').DataTable();
                        ab_table.destroy();
                        $('#datatable_close tbody').empty();
                        $('#datatable_close tbody').append(response.html);
                        var table = $('#datatable_close').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [{
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    "width": 600,
                                    "targets": [8]
                                },
                            ],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page: 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#container').css('display', 'block');
                        table.columns.adjust().draw();
                    }
                });
            });
            //Closed filter end here

            //Reject ticket filter start here
            $("#reject_remove_apply_filter").click(function() {
                $('#reject_name_id').val(null).trigger('change');
                $("#reject_start_date").val("");
                $("#reject_end_date").val("");
                $("#reject_apply_filter").click();
            });
            $("#reject_apply_filter").click(function() {
                var name_id = $("#reject_name_id option:selected").val();
                var start_date = $("#reject_start_date").val();
                var end_date = $("#reject_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {
                        name_id: name_id,
                        start_date: start_date,
                        end_date: end_date,
                        table_checked: "3",
                        _token: token
                    },
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_reject').DataTable();
                        ab_table.destroy();
                        $('#datatable_reject tbody').empty();
                        $('#datatable_reject tbody').append(response.html);
                        var table = $('#datatable_reject').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [{
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    "width": 600,
                                    "targets": [8]
                                },
                            ],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page: 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#container').css('display', 'block');
                        table.columns.adjust().draw();
                    }
                });
            });
            //Reject filter end here

            //Shared ticket filter start here
            $("#shared_remove_apply_filter").click(function() {
                $('#shared_name_id').val(null).trigger('change');
                $("#shared_start_date").val("");
                $("#shared_end_date").val("");
                $("#shared_apply_filter").click();
            });
            $("#shared_apply_filter").click(function() {
                var name_id = $("#shared_name_id option:selected").val();
                var start_date = $("#shared_start_date").val();
                var end_date = $("#shared_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_ticket_share_filter') }}",
                    method: 'POST',
                    data: {
                        name_id: name_id,
                        start_date: start_date,
                        end_date: end_date,
                        table_checked: "shared",
                        _token: token
                    },
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_shared').DataTable();
                        ab_table.destroy();
                        $('#datatable_shared tbody').empty();
                        $('#datatable_shared tbody').append(response.html);
                        var table = $('#datatable_shared').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [{
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    "width": 600,
                                    "targets": [8]
                                },
                            ],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page: 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#container').css('display', 'block');
                        table.columns.adjust().draw();
                    }
                });
            });
            //Shared filter end here
        });
    </script>

    {{-- color block start here --}}
    <script>
        $(document).ready(function() {
            var pending_24_tickets = "{{ $total_pending_24_ticket }}";
            var pending_48_tickets = "{{ $total_pending_48_ticket }}";
            var pending_72_tickets = "{{ $total_pending_72_ticket }}";
            var pending_less_24_tickets = "{{ $total_pending_less_24_ticket }}";

            $("#pending_hours_24_block").html(pending_24_tickets);
            $("#pending_hours_48_block").html(pending_48_tickets);
            $("#pending_hours_72_block").html(pending_72_tickets);
            $("#pending_less_24_block").html(pending_less_24_tickets);

            var process_24_tickets = "{{ $total_24_hours }}";
            var process_48_tickets = "{{ $total_48_hours }}";
            var process_72_tickets = "{{ $total_72_hours }}";
            var process_less_24_tickets = "{{ $total_less_24_process_hours }}";

            $("#process_hours_24_block").html(process_24_tickets);
            $("#process_hours_48_block").html(process_48_tickets);
            $("#process_hours_72_block").html(process_72_tickets);
            $("#process_less_24_block").html(process_less_24_tickets);
        });
    </script>

    <script>
        $("#pending_hours_24_block").click(function() {
            only_24_hours_pending_color("orange");
        });

        $("#pending_hours_48_block").click(function() {
            only_24_hours_pending_color("pink");
        });

        $("#pending_hours_72_block").click(function() {
            only_24_hours_pending_color("red");
        });

        $("#pending_less_24_block").click(function() {
            only_24_hours_pending_color("white");
        });

        //process data

        $("#process_hours_24_block").click(function() {
            only_24_hours_process_color("orange");
        });
        $("#process_hours_48_block").click(function() {
            only_24_hours_process_color("pink");
        });

        $("#process_hours_72_block").click(function() {
            only_24_hours_process_color("red");
        });

        $("#process_less_24_block").click(function() {
            only_24_hours_process_color("white");
        });
    </script>

    <script>
        function pending_ticket_count_color() {
            var name_id = $("#name_id option:selected").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_ticket_filter_count_colors') }}",
                method: 'POST',
                data: {
                    name_id: name_id,
                    start_date: start_date,
                    end_date: end_date,
                    table_checked: "0",
                    _token: token
                },
                success: function(response) {
                    var array = JSON.parse(response);
                    $("#pending_hours_24_block").html(array.total_24_tickets);
                    $("#pending_hours_48_block").html(array.total_48_tickets);
                    $("#pending_hours_72_block").html(array.total_72_tickets);
                    $("#pending_less_24_block").html(array.total_less_24_ticket);
                }
            });
        }

        function process_ticket_count_color() {
            var name_id = $("#process_name_id option:selected").val();
            var start_date = $("#process_start_date").val();
            var end_date = $("#process_end_date").val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_ticket_filter_count_colors') }}",
                method: 'POST',

                data: {
                    name_id: name_id,
                    start_date: start_date,
                    end_date: end_date,
                    table_checked: "2",
                    _token: token
                },
                success: function(response) {
                    var array = JSON.parse(response);
                    $("#process_hours_24_block").html(array.total_24_tickets);
                    $("#process_hours_48_block").html(array.total_48_tickets);
                    $("#process_hours_72_block").html(array.total_72_tickets);
                    $("#process_less_24_block").html(array.total_less_24_ticket);
                }
            });
        }

        function only_24_hours_pending_color(color) {
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_tickets_color_wise') }}",
                method: 'POST',
                data: {
                    time: color,
                    table_checked: "0",
                    _token: token
                },
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var ab_table = $('#datatable').DataTable();
                    ab_table.destroy();
                    $('#datatable tbody').empty();
                    $('#datatable tbody').append(response.html);
                    var table = $('#datatable').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                        ],
                        "columnDefs": [{
                                "targets": [0],
                                "visible": false
                            },
                            {
                                "width": 600,
                                "targets": [8]
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'excel',
                                title: 'Pending Tickets',
                                text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                exportOptions: {
                                    modifier: {
                                        page: 'all',
                                    }
                                }
                            },
                            'pageLength',
                        ],
                        "scrollY": false,
                        "scrollX": true,
                    });
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                }
            });
        }

        function only_24_hours_process_color(color) {
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_tickets_color_wise') }}",
                method: 'POST',
                data: {
                    time: color,
                    table_checked: "2",
                    _token: token
                },
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var ab_table = $('#datatable_process').DataTable();
                    ab_table.destroy();

                    $('#datatable_process tbody').empty();
                    $('#datatable_process tbody').append(response.html);

                    var table = $('#datatable_process').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                        ],
                        "columnDefs": [{
                                "targets": [0],
                                "visible": false
                            },
                            {
                                "width": 600,
                                "targets": [8]
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'excel',
                                title: 'Pending Tickets',
                                text: '<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px;>',
                                exportOptions: {
                                    modifier: {
                                        page: 'all',
                                    }
                                }
                            },
                            'pageLength',
                        ],
                        "scrollY": false,
                        "scrollX": true,
                    });
                    $('#container').css('display', 'block');
                    table.columns.adjust().draw();
                }
            });
        }
    </script>

    <script>
        @if (Session::has('message'))
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
