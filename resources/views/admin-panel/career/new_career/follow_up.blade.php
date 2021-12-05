@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        .hide_cls{
            display: none;
        }
        .wait_list{
            display: none;
        }
        .selected{
            display: none;
        }
        .onboard{
            display: none;
        }
        .buttons {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
        }
        .buttonss {
            background-color: grey;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
        }
        .modals-lg {
        max-width: 70% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        }
        .modal_table .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }
        .modal_table h6{
            font-weight:800;
        }
        .remarks{
            font-weight:800;
        }
        .modal_table .table td{
            padding: 2px;
            font-size: 12px;
        }

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        /*.dataTables_info{*/
        /*    display:none;*/
        /*}*/
        .font_size_cls{
            font-size: 17px !important;
            cursor: pointer;
        }
        .view_cls i{
            font-size: 15px !important;
        }
    </style>
@endsection
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Career</a></li>
        <li>Follow Up</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <button class="buttonss" id="not_verifieds" type="button"><span class="ul-btn__icon"></span><span class="ul-btn__text">Front Desk</span></button>
            <button class="buttons" id="wait_lists" type="button"><span class="ul-btn__icon"></span><span class="ul-btn__text">Wait List</span></button>
            <button class="buttons" id="selected" type="button"><span class="ul-btn__icon"></span><span class="ul-btn__text">Selected</span></button>
            <button class="buttons" id="onboard" type="button"><span class="ul-btn__icon"></span><span class="ul-btn__text">Onboard</span></button>

            <!--  Front Desk -->
            <div class="not_verified">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                <li class="nav-item">
                    <a class="nav-link active" id="NoActionTab" data-toggle="tab" href="#NoAction" role="tab" aria-controls="NoAction" aria-selected="true">No Action Yet
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="TodayTab" data-toggle="tab" href="#Today" role="tab" aria-controls="Today" aria-selected="true">Today
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="InterstedTab" data-toggle="tab" href="#Intersted" role="tab" aria-controls="Intersted" aria-selected="false">Intersted
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="CallMeTomorrowTab" data-toggle="tab" href="#CallMeTomorrow" role="tab" aria-controls="CallMeTomorrow" aria-selected="false">Call Me Later
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="NoResponseTab" data-toggle="tab" href="#NoResponse" role="tab" aria-controls="NoResponse" aria-selected="false">No Response
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="NotInterestedTab" data-toggle="tab" href="#NotInterested" role="tab" aria-controls="NotInterested" aria-selected="false">Not Interested
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="NoAction" role="tabpanel" aria-labelledby="NoActionTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="NoActionTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="filtering_source_from">Source Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($careers as $frontdesk)
                                <tr @if($frontdesk->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($frontdesk->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>{{ $frontdesk->name  }}</td>
                                    <td>{{ $frontdesk->email  }}</td>
                                    <td>{{ $frontdesk->phone  }}</td>
                                    <td>{{ $frontdesk->whatsapp }}</td>
                                    <?php  $created_at = explode(" ", $frontdesk->created_at);?>
                                    <td id="created_at-{{ $frontdesk->id }}" >{{ $created_at[0] }}</td>
                                    <td>{{ isset($source_type_array[$frontdesk->source_type]) ? $source_type_array[$frontdesk->source_type] : 'N/A' }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1" data-today="1"  id="{{ $frontdesk->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                                @foreach($careers1 as $frontdesk)
                                <tr @if($frontdesk->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($frontdesk->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>{{ $frontdesk->name  }}</td>
                                    <td>{{ $frontdesk->email  }}</td>
                                    <td>{{ $frontdesk->phone  }}</td>
                                    <td>{{ $frontdesk->whatsapp }}</td>
                                    <?php  $created_at = explode(" ", $frontdesk->created_at);?>
                                    <td id="created_at-{{ $frontdesk->id }}" >{{ $created_at[0] }}</td>
                                    <td>{{ isset($source_type_array[$frontdesk->source_type]) ? $source_type_array[$frontdesk->source_type] : 'N/A' }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1" data-today="1"  id="{{ $frontdesk->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="Today" role="tabpanel" aria-labelledby="TodayTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="TodayTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Calls</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($today as $todays)
                                <?php
                                    // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                    $ticketTime = strtotime($todays->follow_up_date);
                                    // This difference is in seconds.
                                    $difference = time() - $ticketTime;
                                 ?>
                                <tr @if($todays->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($todays->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>{{ $todays->career->name  }}</td>
                                    <td>{{ $todays->career->email  }}</td>
                                    <td>{{ $todays->career->phone  }}</td>
                                    <td>{{ $todays->career->whatsapp }}</td>
                                    <td>{{ $todays->remarks }}</td>
                                    <td>{{ $todays->follow_up_date }}</td>
                                    <td>{{count($history->where('career_id',$todays->career->id)->where('follow_up_status','!=','0'))}}</td>
                                    @if ((round($difference / 86400) )== "0")
                                    <td>Today</td>
                                    @else
                                    <td>{{ round($difference / 86400) }} days</td>
                                    @endif
                                    <td><a class="text-primary mr-2 follow_up" data-category="1" data-today="1"  id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="Intersted" role="tabpanel" aria-labelledby="InterstedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="InterstedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Calls</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($intersted as $interest)
                                @if($interest->career->follow_up_status == "1")
                                <tr @if($interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($interest->career->name)) {{ $interest->career->name  }} @endif</td>
                                    <td>@if(isset($interest->career->email)) {{ $interest->career->email  }} @endif</td>
                                    <td>@if(isset($interest->career->phone)) {{ $interest->career->phone  }} @endif</td>
                                    <td>@if(isset($interest->career->whatsapp)) {{ $interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $interest->remarks }}</td>
                                    <td>{{ $interest->follow_up_date }}</td>
                                    <td>{{count($history->where('career_id',$interest->career->id)->where('follow_up_status','!=','0'))}}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1"  id="{{ $interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        <a class="text-primary mr-2 view_cls" id="{{ $interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="CallMeTomorrow" role="tabpanel" aria-labelledby="CallMeTomorrowTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="CallMeTomorrowTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Calls</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($call_me_tomorrow as $call_me)
                                @if($call_me->career->follow_up_status == "2")
                                <tr @if($call_me->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($call_me->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($call_me->career->name)) {{ $call_me->career->name  }} @endif</td>
                                    <td>@if(isset($call_me->career->email)) {{ $call_me->career->email  }} @endif</td>
                                    <td>@if(isset($call_me->career->phone)) {{ $call_me->career->phone  }} @endif</td>
                                    <td>@if(isset($call_me->career->whatsapp)) {{ $call_me->career->whatsapp  }} @endif</td>
                                    <td>{{ $call_me->remarks }}</td>
                                    <td>{{ $call_me->follow_up_date }}</td>
                                    <td>{{count($history->where('career_id',$call_me->career->id)->where('follow_up_status','!=','0'))}}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1"  id="{{ $call_me->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        <a class="text-primary mr-2 view_cls" id="{{ $call_me->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="NoResponse" role="tabpanel" aria-labelledby="NoResponseTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="NoResponseTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Calls</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($no_response as $response)
                                @if($response->career->follow_up_status == "3")
                                <tr @if($response->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($response->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($response->career->name)) {{ $response->career->name  }} @endif</td>
                                    <td>@if(isset($response->career->email)) {{ $response->career->email  }} @endif</td>
                                    <td>@if(isset($response->career->phone)) {{ $response->career->phone  }} @endif</td>
                                    <td>@if(isset($response->career->whatsapp)) {{ $response->career->whatsapp  }} @endif</td>
                                    <td>{{ $response->remarks }}</td>
                                    <td>{{ $response->follow_up_date }}</td>
                                    <td>{{count($history->where('career_id',$response->career->id)->where('follow_up_status','!=','0'))}}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1"  id="{{ $response->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        <a class="text-primary mr-2 view_cls" id="{{ $response->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="NotInterested" role="tabpanel" aria-labelledby="NotInterestedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="NotInterestedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Calls</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($not_interested as $not_interest)
                                @if($not_interest->career->follow_up_status == "4")
                                <tr @if($not_interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($not_interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($not_interest->career->name)) {{ $not_interest->career->name  }} @endif</td>
                                    <td>@if(isset($not_interest->career->email)) {{ $not_interest->career->email  }} @endif</td>
                                    <td>@if(isset($not_interest->career->phone)) {{ $not_interest->career->phone  }} @endif</td>
                                    <td>@if(isset($not_interest->career->whatsapp)) {{ $not_interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $not_interest->remarks }}</td>
                                    <td>{{count($history->where('career_id',$not_interest->career->id)->where('follow_up_status','!=','0'))}}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="1"  id="{{ $not_interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        <a class="text-primary mr-2 view_cls" id="{{ $not_interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            </div>

            <!--  wait list -->
            <div class="wait_list">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                    <li class="nav-item">
                        <a class="nav-link active" id="wTodayTab" data-toggle="tab" href="#wToday" role="tab" aria-controls="wToday" aria-selected="true">Today
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wInterstedTab" data-toggle="tab" href="#wIntersted" role="tab" aria-controls="wIntersted" aria-selected="false">Intersted
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wCallMeTomorrowTab" data-toggle="tab" href="#wCallMeTomorrow" role="tab" aria-controls="wCallMeTomorrow" aria-selected="false">Call Me Later
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wNoResponseTab" data-toggle="tab" href="#wNoResponse" role="tab" aria-controls="wNoResponse" aria-selected="false">No Response
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wNotInterestedTab" data-toggle="tab" href="#wNotInterested" role="tab" aria-controls="wNotInterested" aria-selected="false">Not Interested
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="wToday" role="tabpanel" aria-labelledby="wTodayTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="wTodayTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Days</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wait_today as $todays)
                                    <?php
                                    // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                    $ticketTime = strtotime($todays->follow_up_date);
                                    // This difference is in seconds.
                                    $difference = time() - $ticketTime;
                                    ?>
                                    <tr @if($todays->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($todays->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                        <td>{{ $todays->career->name  }}</td>
                                        <td>{{ $todays->career->email  }}</td>
                                        <td>{{ $todays->career->phone  }}</td>
                                        <td>{{ $todays->career->whatsapp }}</td>
                                        <td>{{ $todays->remarks }}</td>
                                        <td>{{ $todays->follow_up_date }}</td>
                                        @if ((round($difference / 86400) )== "0")
                                        <td>Today</td>
                                        @else
                                        <td>{{ round($difference / 86400)  }} days</td>
                                        @endif
                                        <td><a class="text-primary mr-2 follow_up" data-category="2" data-today="1" id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="wIntersted" role="tabpanel" aria-labelledby="wInterstedTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="wInterstedTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wait_intersted as $interest)
                                    @if($interest->career->follow_up_status == "1")
                                    <tr @if($interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($interest->career->employee_type == "2") style="background-color: #ffc0c0;"  @endif>
                                        <th scope="row">1</th>
                                        <td>@if(isset($interest->career->name)) {{ $interest->career->name  }} @endif</td>
                                        <td>@if(isset($interest->career->email)) {{ $interest->career->email  }} @endif</td>
                                        <td>@if(isset($interest->career->phone)) {{ $interest->career->phone  }} @endif</td>
                                        <td>@if(isset($interest->career->whatsapp)) {{ $interest->career->whatsapp  }} @endif</td>
                                        <td>{{ $interest->remarks }}</td>
                                        <td>{{ $interest->follow_up_date }}</td>
                                        <td><a class="text-primary mr-2 follow_up" data-category="2" id="{{ $interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="wCallMeTomorrow" role="tabpanel" aria-labelledby="wCallMeTomorrowTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="wCallMeTomorrowTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wait_call_me_tomorrow as $call_me)
                                    @if($call_me->career->follow_up_status == "2")
                                    <tr @if($call_me->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($call_me->career->employee_type == "2") style="background-color: #ffc0c0;"  @endif>
                                        <th scope="row">1</th>
                                        <td>@if(isset($call_me->career->name)) {{ $call_me->career->name  }} @endif</td>
                                        <td>@if(isset($call_me->career->email)) {{ $call_me->career->email  }} @endif</td>
                                        <td>@if(isset($call_me->career->phone)) {{ $call_me->career->phone  }} @endif</td>
                                        <td>@if(isset($call_me->career->whatsapp)) {{ $call_me->career->whatsapp  }} @endif</td>
                                        <td>{{ $call_me->remarks }}</td>
                                        <td>{{ $call_me->follow_up_date }}</td>
                                        <td><a class="text-primary mr-2 follow_up" data-category="2" id="{{ $call_me->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="wNoResponse" role="tabpanel" aria-labelledby="wNoResponseTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="wNoResponseTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wait_no_response as $response)
                                    @if($response->career->follow_up_status == "3")
                                    <tr @if($response->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($response->career->employee_type == "2") style="background-color: #ffc0c0;"  @endif>
                                        <th scope="row">1</th>
                                        <td>@if(isset($response->career->name)) {{ $response->career->name  }} @endif</td>
                                        <td>@if(isset($response->career->email)) {{ $response->career->email  }} @endif</td>
                                        <td>@if(isset($response->career->phone)) {{ $response->career->phone  }} @endif</td>
                                        <td>@if(isset($response->career->whatsapp)) {{ $response->career->whatsapp  }} @endif</td>
                                        <td>{{ $response->remarks }}</td>
                                        <td>{{ $response->follow_up_date }}</td>
                                        <td><a class="text-primary mr-2 follow_up" data-category="2" id="{{ $response->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="wNotInterested" role="tabpanel" aria-labelledby="wNotInterestedTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="wNotInterestedTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wait_not_interested as $not_interest)
                                    @if($not_interest->career->follow_up_status == "4")
                                    <tr @if($not_interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($not_interest->career->employee_type == "2") style="background-color: #ffc0c0;"  @endif>
                                        <th scope="row">1</th>
                                        <td>@if(isset($not_interest->career->name)) {{ $not_interest->career->name  }} @endif</td>
                                        <td>@if(isset($not_interest->career->email)) {{ $not_interest->career->email  }} @endif</td>
                                        <td>@if(isset($not_interest->career->phone)) {{ $not_interest->career->phone  }} @endif</td>
                                        <td>@if(isset($not_interest->career->whatsapp)) {{ $not_interest->career->whatsapp  }} @endif</td>
                                        <td>{{ $not_interest->remarks }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                </div>

                <!--  selected -->
            <div class="selected">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                <li class="nav-item">
                    <a class="nav-link active" id="sTodayTab" data-toggle="tab" href="#sToday" role="tab" aria-controls="sToday" aria-selected="true">Today
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sInterstedTab" data-toggle="tab" href="#sIntersted" role="tab" aria-controls="sIntersted" aria-selected="false">Intersted
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sCallMeTomorrowTab" data-toggle="tab" href="#sCallMeTomorrow" role="tab" aria-controls="sCallMeTomorrow" aria-selected="false">Call Me Later
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sNoResponseTab" data-toggle="tab" href="#sNoResponse" role="tab" aria-controls="sNoResponse" aria-selected="false">No Response
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sNotInterestedTab" data-toggle="tab" href="#sNotInterested" role="tab" aria-controls="sNotInterested" aria-selected="false">Not Interested
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="sToday" role="tabpanel" aria-labelledby="sTodayTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="sTodayTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selected_today as $todays)
                                <?php
                                    // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                    $ticketTime = strtotime($todays->follow_up_date);
                                    // This difference is in seconds.
                                    $difference = time() - $ticketTime;
                                    ?>
                                <tr @if($todays->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($todays->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <td>{{ $todays->career->name  }}</td>
                                    <td>{{ $todays->career->email  }}</td>
                                    <td>{{ $todays->career->phone  }}</td>
                                    <td>{{ $todays->career->whatsapp }}</td>
                                    <td>{{ $todays->remarks }}</td>
                                    <td>{{ $todays->follow_up_date }}</td>
                                    @if ((round($difference / 86400) )== "0")
                                        <td>Today</td>
                                        @else
                                        <td>{{ round($difference / 86400)  }} days</td>
                                        @endif
                                    <td><a class="text-primary mr-2 follow_up" data-category="3" data-today="1" id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="sIntersted" role="tabpanel" aria-labelledby="sInterstedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="sInterstedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selected_intersted as $interest)
                                @if($interest->career->follow_up_status == "1")
                                <tr @if($interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($interest->career->name)) {{ $interest->career->name  }} @endif</td>
                                    <td>@if(isset($interest->career->email)) {{ $interest->career->email  }} @endif</td>
                                    <td>@if(isset($interest->career->phone)) {{ $interest->career->phone  }} @endif</td>
                                    <td>@if(isset($interest->career->whatsapp)) {{ $interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $interest->remarks }}</td>
                                    <td>{{ $interest->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="3" id="{{ $interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="sCallMeTomorrow" role="tabpanel" aria-labelledby="sCallMeTomorrowTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="sCallMeTomorrowTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selected_call_me_tomorrow as $call_me)
                                @if($call_me->career->follow_up_status == "2")
                                <tr @if($call_me->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($call_me->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($call_me->career->name)) {{ $call_me->career->name  }} @endif</td>
                                    <td>@if(isset($call_me->career->email)) {{ $call_me->career->email  }} @endif</td>
                                    <td>@if(isset($call_me->career->phone)) {{ $call_me->career->phone  }} @endif</td>
                                    <td>@if(isset($call_me->career->whatsapp)) {{ $call_me->career->whatsapp  }} @endif</td>
                                    <td>{{ $call_me->remarks }}</td>
                                    <td>{{ $call_me->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="3"  id="{{ $call_me->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="sNoResponse" role="tabpanel" aria-labelledby="sNoResponseTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="sNoResponseTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selected_no_response as $response)
                                @if($response->career->follow_up_status == "3")
                                <tr @if($response->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($response->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($response->career->name)) {{ $response->career->name  }} @endif</td>
                                    <td>@if(isset($response->career->email)) {{ $response->career->email  }} @endif</td>
                                    <td>@if(isset($response->career->phone)) {{ $response->career->phone  }} @endif</td>
                                    <td>@if(isset($response->career->whatsapp)) {{ $response->career->whatsapp  }} @endif</td>
                                    <td>{{ $response->remarks }}</td>
                                    <td>{{ $response->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="3" id="{{ $response->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="sNotInterested" role="tabpanel" aria-labelledby="sNotInterestedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="sNotInterestedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selected_not_interested as $not_interest)
                                @if($not_interest->career->follow_up_status == "4")
                                <tr @if($not_interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($not_interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($not_interest->career->name)) {{ $not_interest->career->name  }} @endif</td>
                                    <td>@if(isset($not_interest->career->email)) {{ $not_interest->career->email  }} @endif</td>
                                    <td>@if(isset($not_interest->career->phone)) {{ $not_interest->career->phone  }} @endif</td>
                                    <td>@if(isset($not_interest->career->whatsapp)) {{ $not_interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $not_interest->remarks }}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            </div>

            <!--  onboard -->
            <div class="onboard">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                <li class="nav-item">
                    <a class="nav-link active" id="oTodayTab" data-toggle="tab" href="#oToday" role="tab" aria-controls="oToday" aria-selected="true">Today
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="oInterstedTab" data-toggle="tab" href="#oIntersted" role="tab" aria-controls="oIntersted" aria-selected="false">Intersted
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="oCallMeTomorrowTab" data-toggle="tab" href="#oCallMeTomorrow" role="tab" aria-controls="oCallMeTomorrow" aria-selected="false">Call Me Later
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="oNoResponseTab" data-toggle="tab" href="#oNoResponse" role="tab" aria-controls="oNoResponse" aria-selected="false">No Response
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="oNotInterestedTab" data-toggle="tab" href="#oNotInterested" role="tab" aria-controls="oNotInterested" aria-selected="false">Not Interested
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="oToday" role="tabpanel" aria-labelledby="oTodayTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="oTodayTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onboard_today as $todays)
                                <?php
                                    // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                    $ticketTime = strtotime($todays->follow_up_date);
                                    // This difference is in seconds.
                                    $difference = time() - $ticketTime;
                                    ?>
                                <tr @if($todays->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($todays->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <td>{{ $todays->career->name  }}</td>
                                    <td>{{ $todays->career->email  }}</td>
                                    <td>{{ $todays->career->phone  }}</td>
                                    <td>{{ $todays->career->whatsapp }}</td>
                                    <td>{{ $todays->remarks }}</td>
                                    <td>{{ $todays->follow_up_date }}</td>
                                    @if ((round($difference / 86400))== "0")
                                        <td>Today</td>
                                        @else
                                        <td>{{ round($difference / 86400)  }} days</td>
                                        @endif
                                    <td><a class="text-primary mr-2 follow_up" data-category="4" data-today="1"  id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="oIntersted" role="tabpanel" aria-labelledby="oInterstedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="oInterstedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onboard_intersted as $interest)
                                @if($interest->career->follow_up_status == "1")
                                <tr @if($interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($interest->career->name)) {{ $interest->career->name  }} @endif</td>
                                    <td>@if(isset($interest->career->email)) {{ $interest->career->email  }} @endif</td>
                                    <td>@if(isset($interest->career->phone)) {{ $interest->career->phone  }} @endif</td>
                                    <td>@if(isset($interest->career->whatsapp)) {{ $interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $interest->remarks }}</td>
                                    <td>{{ $interest->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="4" id="{{ $interest->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="oCallMeTomorrow" role="tabpanel" aria-labelledby="oCallMeTomorrowTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="oCallMeTomorrowTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onboard_call_me_tomorrow as $call_me)
                                @if($call_me->career->follow_up_status == "2")
                                <tr @if($call_me->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($call_me->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($call_me->career->name)) {{ $call_me->career->name  }} @endif</td>
                                    <td>@if(isset($call_me->career->email)) {{ $call_me->career->email  }} @endif</td>
                                    <td>@if(isset($call_me->career->phone)) {{ $call_me->career->phone  }} @endif</td>
                                    <td>@if(isset($call_me->career->whatsapp)) {{ $call_me->career->whatsapp  }} @endif</td>
                                    <td>{{ $call_me->remarks }}</td>
                                    <td>{{ $call_me->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="4" id="{{ $call_me->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="oNoResponse" role="tabpanel" aria-labelledby="oNoResponseTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="oNoResponseTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onboard_no_response as $response)
                                @if($response->career->follow_up_status == "3")
                                <tr @if($response->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($response->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($response->career->name)) {{ $response->career->name  }} @endif</td>
                                    <td>@if(isset($response->career->email)) {{ $response->career->email  }} @endif</td>
                                    <td>@if(isset($response->career->phone)) {{ $response->career->phone  }} @endif</td>
                                    <td>@if(isset($response->career->whatsapp)) {{ $response->career->whatsapp  }} @endif</td>
                                    <td>{{ $response->remarks }}</td>
                                    <td>{{ $response->follow_up_date }}</td>
                                    <td><a class="text-primary mr-2 follow_up" data-category="4" id="{{ $response->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="oNotInterested" role="tabpanel" aria-labelledby="oNotInterestedTab">
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="oNotInterestedTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">WhatsApp</th>
                                    <th scope="col">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onboard_not_interested as $not_interest)
                                @if($not_interest->career->follow_up_status == "4")
                                <tr @if($not_interest->career->employee_type == "1") style="background-color: #b4e4f9;" @elseif ($not_interest->career->employee_type == "2") style="background-color: #ffc0c0;" @endif>
                                    <th scope="row">1</th>
                                    <td>@if(isset($not_interest->career->name)) {{ $not_interest->career->name  }} @endif</td>
                                    <td>@if(isset($not_interest->career->email)) {{ $not_interest->career->email  }} @endif</td>
                                    <td>@if(isset($not_interest->career->phone)) {{ $not_interest->career->phone  }} @endif</td>
                                    <td>@if(isset($not_interest->career->whatsapp)) {{ $not_interest->career->whatsapp  }} @endif</td>
                                    <td>{{ $not_interest->remarks }}</td>
                                </tr>
                                @endif
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

<!--  add note Modal-->
<div class="modal fade bd-example-modal-lg"  id="edit_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('career_follow_up') }}" method="POST">
                @csrf
                <input type="hidden" name="checkbox_array" id="select_ids_note" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="hidden" name="id"  value="" id="Id">
                            <input type="hidden" name="remove_today"  value="" id="remove">
                            <input type="hidden" name="category" class="category" value="">
                            <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" >
                                <option value="" selected disabled>select an option</option>
                                @foreach(follow_up_names() as $id => $label)
                                    <option value="{{ $id }}">{{ $label ?? "" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" rows="4" name="note" required></textarea>
                        </div>
                        <div class="col-md-12 form-group hide_cls">
                            <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date"  />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- end of note modal -->

{{--    view Detail modal--}}
<div class="modal fade bd-example-modals-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modals-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="table-responsive modal_table">
                            <h6>Personal Detail</h6>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Name</th>
                                    <td><span id="name_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><span id="email_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><span id="phone_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Date Of Birth</th>
                                    <td><span id="dob_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Whats App</th>
                                    <td><span id="whatsapp_html"></span></td>
                                </tr>

{{--                                    <tr>--}}
{{--                                        <th>Facebook</th>--}}
{{--                                        <td><span id="facebook_html"></span></td>--}}
{{--                                    </tr>--}}
                                <tr>
                                    <th>Experience</th>
                                    <td><span id="experiecne_html"></span></td>
                                </tr>

{{--                                    <tr>--}}
{{--                                        <th>CV Attached</th>--}}
{{--                                        <td>--}}
{{--                                            <a id="cv_attached_html" target="_blank"></a>--}}
{{--                                            <span id="cv_attached_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}


                                <tr>
                                    <th>Applicant status</th>
                                    <td><span id="applicant_status_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Employee Type</th>
                                    <td><span id="employee_type_html"></span></td>
                                </tr>

                                <tr class="fourpl_name_cls">
                                    <th>Four Pl Name</th>
                                    <td><span id="four_pl_name_html"></span></td>
                                </tr>

                                <tr style="display: none;" id="refer_by_row">
                                    <th>Referal By</th>
                                    <td><span id="refer_by"></span></td>
                                </tr>



                            </table>
                        </div>


                        <div class="table-responsive modal_table">
                            <h6>Passport Detail</h6>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Nationality</th>
                                    <td><span id="nationality_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Passport Number</th>
                                    <td><span id="passport_no_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Passport Expiry</th>
                                    <td><span id="passport_expiry_html"></span></td>
                                </tr>

{{--                                    <tr>--}}
{{--                                        <th>Passport Attached</th>--}}
{{--                                        <td>--}}
{{--                                            <a  href="" id="passport_attach_html" target="_blank"></a>--}}
{{--                                            <span id="passport_attach_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

                            </table>
                        </div>

                        <h6 class="remarks" >
                            Note
                        </h6>
                        <p  id="remarks_html"></p>


                    </div>

                    <div class="col-md-4">
                        <div class="table-responsive modal_table">
                            <h6>License Detail</h6>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>License Status</th>
                                    <td><span id="license_status_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Licence status vehicle</th>
                                    <td><span id="license_status_vehicle_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Applying For</th>
                                    <td><span id="vehicle_type_html"></span></td>
                                </tr>



                                <tr>
                                    <th>Licence number</th>
                                    <td><span id="license_no_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Traffic code number</th>
                                    <td><span id="license_issue_html"></span></td>
                                </tr>

                                {{--                                    <tr>--}}
                                {{--                                        <th>Licence Expiry</th>--}}
                                {{--                                        <td><span id="license_expiry_html"></span></td>--}}
                                {{--                                    </tr>--}}

{{--                                    <tr>--}}
{{--                                        <th>Licence Front Pic</th>--}}
{{--                                        <td>--}}
{{--                                            <a  href="" id="license_attach_html" target="_blank"></a>--}}
{{--                                            <span id="license_attach_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

{{--                                    <tr>--}}
{{--                                        <th>Licence Back Pic</th>--}}
{{--                                        <td>--}}
{{--                                            <a  href="" id="license_back_html" target="_blank"></a>--}}
{{--                                            <span id="license_back_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

                            </table>
                        </div>


                        <div class="table-responsive modal_table">
                            <h6>Visa Detail</h6>
                            <table class="table table-bordered table-striped">


                                <tr>
                                    <th>Visa Status</th>
                                    <td><span id="visa_status_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Visa status visit</th>
                                    <td><span id="visa_status_visit_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Visa status cancel</th>
                                    <td><span id="visa_status_cancel_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Visa status own</th>
                                    <td><span id="visa_status_own_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Exit date</th>
                                    <td><span id="exit_date_html"></span></td>
                                </tr>

{{--                                    <tr>--}}
{{--                                        <th>Company visa</th>--}}
{{--                                        <td><span id="company_visa_html"></span></td>--}}
{{--                                    </tr>--}}

{{--                                    <tr>--}}
{{--                                        <th>Inout transfer</th>--}}
{{--                                        <td><span id="inout_transfer_html"></span></td>--}}
{{--                                    </tr>--}}

                                <tr>
                                    <th>PlatForm</th>
                                    <td><span id="platform_id_html"></span></td>
                                </tr>

                                <tr>
                                    <th>Applied cities</th>
                                    <td><span id="applied_cities"></span></td>
                                </tr>



                            </table>
                        </div>



                        <div class="table-responsive modal_table">
                            <h6>Promotion Detail</h6>
                            <table class="table table-bordered table-striped">


                                <tr>
                                    <th>How Did He Heared About</th>
                                    <td><span id="promotion_type_html"></span></td>
                                </tr>
                                <tr>
                                    <th>Social Media Account Name</th>
                                    <td><span id="social_medial_id_name"></span></td>
                                </tr>

                                <tr id="other_source_name_row">
                                    <th>Other Source Name</th>
                                    <td><span id="other_source_name"></span></td>
                                </tr>

                                <tr>
                                    <th>Source Type</th>
                                    <td><span id="source_type"></span></td>
                                </tr>



                            </table>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <h6><b>Remarks</b></h6>
                        <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6">
                            <div class="chat-content-wrap" data-sidebar-content="chat">
                                <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


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

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href');
                $(currentTab +"Table").DataTable().columns.adjust().draw();
            });
        });
        var table = $('#sTodayTable, #wTodayTable, #oTodayTable').DataTable();
        table.columns.adjust().draw();
    </script>
    <script>
        $('tbody').on('click', '.follow_up', function() {

        var ids  = $(this).attr('id');
        var category  = $(this).data('category');
        var today  = $(this).data('today');
        $(".modal-body #Id").val( ids );
        $(".modal-body .category").val( category );
        $(".modal-body #remove").val( today );
        $("#edit_note_modal").modal('show');
        // console.log(category);
        });
    </script>

    <script>
         tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),

        });

        $('.follow_up_status').change(function() {

        var selected = $(this).val();

        if(selected=="1"){
            $(".hide_cls").css('display','block');
        }else if (selected=="2") {
            $(".hide_cls").css('display','block');
            // $(".hide_cls").hide();
            // var today = new Date();
            // var dd = String(today.getDate()+1).padStart(2, '0');
            // var mm = String(today.getMonth() + 1).padStart(2, '0');
            // var yyyy = today.getFullYear();
            // tomorrow =yyyy + '/' + mm + '/' + dd;
            // var today = new Date();
            // var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));
            // var dd = String(tomorrow.getDate()).padStart(2, '0');
            // var mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
            // var yyyy = tomorrow.getFullYear();
            // tomorrows =yyyy + '/' + mm + '/' + dd;
            // $('#date').val(tomorrows);
        }
        else if (selected=="3") {
            $(".hide_cls").css('display','block');
        }
        else{
            $(".hide_cls").hide();
        }

        });
    </script>
    <script>
        $('#wait_lists').on('click', function() {
            $(".not_verified").hide();
            $(".selected").hide();
            $(".onboard").hide();
            $(".wait_list").css('display','block');
            $(this).css('background-color', 'grey');
            $('#not_verifieds').css('background-color', '#008CBA');
            $('#selected').css('background-color', '#008CBA');
            $('#onboard').css('background-color', '#008CBA');
        });
        $('#not_verifieds').on('click', function() {
            $(".wait_list").hide();
            $(".selected").hide();
            $(".onboard").hide();
            $(".not_verified").css('display','block');
            $(this).css('background-color', 'grey');
            $('#wait_lists').css('background-color', '#008CBA');
            $('#selected').css('background-color', '#008CBA');
            $('#onboard').css('background-color', '#008CBA');
        });
        $('#selected').on('click', function() {
            $(".not_verified").hide();
            $(".wait_list").hide();
            $(".onboard").hide();
            $(".selected").css('display','block');
            $(this).css('background-color', 'grey');
            $('#wait_lists').css('background-color', '#008CBA');
            $('#not_verifieds').css('background-color', '#008CBA');
            $('#onboard').css('background-color', '#008CBA');
        });
        $('#onboard').on('click', function() {
            $(".not_verified").hide();
            $(".wait_list").hide();
            $(".selected").hide();
            $(".onboard").css('display','block');
            $(this).css('background-color', 'grey');
            $('#wait_lists').css('background-color', '#008CBA');
            $('#not_verifieds').css('background-color', '#008CBA');
            $('#selected').css('background-color', '#008CBA');
        });
    </script>

    <script>
          $('tbody').on('click', '.view_cls', function() {

    var ids  = $(this).attr('id');
    $("#detail_modal").modal('show');

    var ids = $(this).attr('id');

    var token = $("input[name='_token']").val();
    $.ajax({
        url: "{{ route('ajax_view_detail') }}",
        method: 'POST',
        dataType: 'json',
        data: {primary_id: ids ,_token:token},
        success: function(response) {
            // console.log(response);
            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            if(len > 0){
            for(var i=0; i<len; i++){
                var id = response['data'][i].id;
                var name = response['data'][i].name;
                var platform_code = response['data'][i].platform_code;

                $("#name_html").html(response['data'][i].name);
                $("#email_html").html(response['data'][i].email);
                $("#phone_html").html(response['data'][i].phone);
                $("#whatsapp_html").html(response['data'][i].whatsapp);
                $("#facebook_html").html(response['data'][i].facebook);
                $("#promotion_type_html").html(response['data'][i].promotion_type);
                if(response['data'][i].promotion_others==""){
                    $("#other_source_name").hide();
                    $("#other_source_name_row").hide();
                    $("#social_medial_id_name").show();
                    $("#social_medial_id_name").html(response['data'][i].social_media_id_name);
                }else{
                    $("#social_medial_id_name").hide();
                    $("#other_source_name_row").show();
                    $("#other_source_name").show();
                    $("#other_source_name").html(response['data'][i].promotion_others);
                }
                if(response['data'][i].refer_by!="0"){
                    $("#refer_by_row").show();
                    $("#refer_by").html(response['data'][i].refer_by);
                }else{
                    $("#refer_by_row").hide();
                }

                $("#source_type").html(response['data'][i].source_type);




                $("#vehicle_type_html").html(response['data'][i].vehicle_type);
                $("#experiecne_html").html(response['data'][i].experience);

                // $("#cv_attached_html").html(response['data'][i].cv);

                if(response['data'][i].cv=="Not Found"){
                    $("#cv_attached_html").html("");
                    $("#cv_attached_not_found_html").html(response['data'][i].cv);
                }else{
                    $("#cv_attached_not_found_html").html("");
                    $("#cv_attached_html").attr('href',response['data'][i].cv);
                    $("#cv_attached_html").html("see Image");
                }

                $("#employee_type_html").html(response['data'][i].employee_type);
                if(response['data'][i].four_pl_name=="0"){
                    $(".fourpl_name_cls").hide();
                }else{
                    $(".fourpl_name_cls").show();
                    $("#four_pl_name_html").html(response['data'][i].four_pl_name);
                }



                $("#license_status_html").html(response['data'][i].licence_status);
                $("#license_status_vehicle_html").html(response['data'][i].licence_status_vehicle);
                $("#license_no_html").html(response['data'][i].licence_no);
                $("#license_issue_html").html(response['data'][i].traffic_code_no);
                $("#license_expiry_html").html(response['data'][i].licence_expiry);

                if(response['data'][i].licence_attach=="Not Found"){
                    $("#license_attach_html").html("");
                    $("#license_attach_not_found_html").html(response['data'][i].licence_attach);

                    $("#license_back_html").html("");
                    $("#license_back_not_found_html").html(response['data'][i].licence_attach_back);
                }else{
                    $("#license_attach_not_found_html").html("");
                    $("#license_attach_html").attr('href',response['data'][i].licence_attach);
                    $("#license_attach_html").html("see Image");

                    $("#license_back_not_found_html").html("");
                    $("#license_back_html").attr('href',response['data'][i].licence_attach_back);
                    $("#license_back_html").html("see Image");
                }


                $("#nationality_html").html(response['data'][i].nationality);
                $("#dob_html").html(response['data'][i].dob);
                $("#passport_no_html").html(response['data'][i].passport_no);
                $("#passport_expiry_html").html(response['data'][i].passport_expiry);
                // $("#passport_attach_html").html(response['data'][i].passport_attach);

                if(response['data'][i].passport_attach=="Not Found"){
                    $("#passport_attach_html").html("");
                    $("#passport_attach_not_found_html").html(response['data'][i].passport_attach);
                }else{
                    $("#passport_attach_not_found_html").html("");
                    $("#passport_attach_html").attr('href',response['data'][i].passport_attach);
                    $("#passport_attach_html").html("see Image");
                }



                $("#visa_status_html").html(response['data'][i].visa_status);
                $("#visa_status_visit_html").html(response['data'][i].visa_status_visit);
                $("#visa_status_cancel_html").html(response['data'][i].visa_status_cancel);
                $("#visa_status_own_html").html(response['data'][i].visa_status_own);
                $("#exit_date_html").html(response['data'][i].exit_date);
                $("#company_visa_html").html(response['data'][i].company_visa);
                $("#inout_transfer_html").html(response['data'][i].inout_transfer);
                $("#platform_id_html").html(response['data'][i].platform_id);
                $("#applied_cities").html(response['data'][i].cities);
                $("#applicant_status_html").html(response['data'][i].applicant_status);
                $("#remarks_html").html(response['data'][i].remarks);


            }
        }

    }
    });

    $.ajax({
    url: "{{ route('ajax_career_remark') }}",
    method: 'POST',
    data: {primary_id: ids ,_token:token},
    success: function(response) {
        // console.log(response);
        if(response.length == 0){
            data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-10 flex-grow-1"></p>
                </div>
                    <p class="m-0">No Remarks</p>
            </div><br>`;
        $(".remark").append(data);
        }

        for (i = 0; i < response.length; i++) {
        if(response[i].remarks){
    data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                    <span class="career_remark">${response[i].note_added_date}</span>
                </div>
                    <p class="m-0">${response[i].remarks}</p>
            </div><br>`;
    $(".remark").append(data);
    }}
    }
    });$(".remark").empty();


});
    </script>

<script>
        $(document).ready(function () {
            'use strict';
            $('#TodayTable, #InterstedTable, #CallMeTomorrowTable, #NoResponseTable,#NotInterestedTable,  #wInterstedTable, #wCallMeTomorrowTable, #wNoResponseTable,#wNotInterestedTable,#sInterstedTable, #sCallMeTomorrowTable, #sNoResponseTable,#sNotInterestedTable, #oInterstedTable, #oCallMeTomorrowTable, #oNoResponseTable,#oNotInterestedTable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });
        });

        $(document).ready(function () {
            'use strict';
            $('#NoActionTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
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
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
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
