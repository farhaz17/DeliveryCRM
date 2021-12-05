@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }

                .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            /* width: 770px; */

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }

        tr.ticket-table-row {
            background: rebeccapurple;
            color: #fff;
            /* height: 1px; */
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Collect Passport</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Passports</div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $passports->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">in Locker</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 ">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2 ">
                                            <h4 class="heading ml-0">{{ $passports_with_riders->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">With Rider</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $passports_transferred->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">with Users</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $passports_not_returned->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">Not Returned By Riders</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $passports_with_controller->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">with Passport Controller</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 ">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2 ">
                                            <h4 class="heading ml-0">{{ $remaining_passports}}</h4>
                                            <p class="text-muted m-0 font-weight-bold">Passports Remaining</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card mb-6 mt-2">
                <div class="card-body">
                    <div class="card-title">Passports</div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $inlocker_today }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">in Locker (Today)</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 ">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2 ">
                                            <h4 class="heading ml-0">{{ $with_rider_today}}</h4>
                                            <p class="text-muted m-0 font-weight-bold">With Rider (Today)</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card mb-6 mt-2">
                <div class="card-body">
                    <div class="card-title">4PL Passports</div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{$fourpl_in_locker->count()}}</h4>
                                            <p class="text-muted m-0 font-weight-bold">In Locker</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{$fourpl_with_rider->count()}}</h4>
                                            <p class="text-muted m-0 font-weight-bold">With Rider</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 ">
                            <div class="card mb-4 sim-card o-hidden">
                                <div class="card-body">
                                    <div class="ul-widget__row-v2" style="position: relative;">

                                        <div class="ul-widget__content-v2">
                                            <h4 class="heading ml-0">{{ $fourpl_delayed->count() }}</h4>
                                            <p class="text-muted m-0 font-weight-bold">Not Received (Or Delayed)</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-title">Passports With Users</div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table ticket-table text-15  text-center dataTable no-footer" id="ticket-table-dep" role="grid" aria-describedby="sales_table_info">
                                <tr class="ticket-table-row">
                                    <th>User</th>
                                    <th>Total Passports</th>
                                </tr>
                                @foreach($passports_with_users as $row)
                                    <tr>
                                        <td>{{$row->receiving_user->name}}</td>
                                        <td>{{$row->total}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 mb-6">
                <div class="card-body">
                    <div class="card-title">Passports With Riders</div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table ticket-table text-15  text-center dataTable no-footer" id="ticket-table-dep" role="grid" aria-describedby="sales_table_info">
                                <tr class="ticket-table-row">
                                    <th>Reason</th>
                                    <th>Total Passports</th>
                                </tr>
                                @foreach($passports_with_riders_reason as $row)
                                    <tr>
                                        <td>{{$row->reason}}</td>
                                        <td>{{$row->total}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center m-2">
        <button class="btn btn-success company">Company</button>
        <button class="btn btn-warning fourpl">4 PL</button>
    </div>

    <div class="col-md-12 mb-3 company-list">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#not_solved" role="tab" aria-controls="not_solved" aria-selected="true">In Locker ({{ $passports->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#solved" role="tab" aria-controls="solved" aria-selected="false">with User ({{ $passports_transferred->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#with_controller" role="tab" aria-controls="solved" aria-selected="false">Passports with Controller ({{ $passports_with_controller->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#with_rider" role="tab" aria-controls="solved" aria-selected="false">With Riders ({{ $passports_with_riders->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#not_returned" role="tab" aria-controls="solved" aria-selected="false">Not returned by riders ({{ $passports_not_returned->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#delayed" role="tab" aria-controls="solved" aria-selected="false">Passport Delayed ({{ $passports_delayed->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#active_request" role="tab" aria-controls="solved" aria-selected="false">Passport Requested(Active) ({{ $requested_passports->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#accepted_request" role="tab" aria-controls="solved" aria-selected="false">Pasport Requested(Accepted) ({{ $accepted_passports->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#rejected_request" role="tab" aria-controls="solved" aria-selected="false">Pasport Requested(Rejected) ({{ $rejected_passports->count() }})</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="not_solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Received From</th>
                                    <th scope="col" style="width: 100px">Date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}} </td>
                                        <td> {{isset($row->user) ? $row->user->name: 'Rider'}}</td>
                                        <td> {{ isset($row->created_at) ? $row->created_at->format('d/m/Y'): '' }}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">

                            <table class="display table table-striped table-bordered" id="datatable_passport_transferred" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Holding User</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_transferred as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{$row->reason}}</td>
                                        <td> {{$row->remarks}}
                                        <td> {{isset($row->receiving_user) ? $row->receiving_user->name: ''}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="with_controller" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">

                            <table class="display table table-striped table-bordered" id="datatable_passport_controller" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Holding User</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_with_controller as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->reason}}</td>
                                        <td> {{$row->remarks}}
                                        <td> {{isset($row->receiving_user) ? $row->receiving_user->name: ''}}
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="with_rider" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_rider" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Received From</th>
                                    <th scope="col" style="width: 100px">Give date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_with_riders as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}}</td>
                                        <td> {{isset($row->user) ? $row->user->name: ''}}</td>
                                        <td> {{isset($row->created_at) ? $row->created_at->format('d-m-Y'): ''}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="not_returned" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_not_returned" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Return date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_not_returned as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->with_riders ? $row->with_riders->rider_remarks : ''}}</td>
                                        <td> {{ isset($row->return_date) ? $row->return_date->format('d/m/Y'): '' }}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="delayed" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_delayed" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_delayed as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}}</td>
                                        <td>
                                            @if($row->status == 0)
                                                Not Received
                                            @elseif($row->status == 2)
                                                Security Deposit {{$row->security_deposit_amount}}
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="active_request" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_requested" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Return date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($requested_passports as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{ isset($row->return_date) ? $row->return_date->format('d/m/Y'): '' }}
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="accepted_request" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_rejected" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Return date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($accepted_passports as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{ isset($row->return_date) ? $row->return_date->format('d/m/Y'): '' }}
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rejected_request" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_passport_rejected" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Return date</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rejected_passports as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{ isset($row->return_date) ? $row->return_date->format('d/m/Y'): '' }}
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

    <div class="col-md-12 mb-3 fourpl-list">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#fourpl_not_solved" role="tab" aria-controls="not_solved" aria-selected="true">In Locker ({{ $fourpl_in_locker->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#fourpl_with_rider" role="tab" aria-controls="solved" aria-selected="false">With Riders ({{ $fourpl_with_rider->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab-three" data-toggle="tab" href="#fourpl_delayed" role="tab" aria-controls="solved" aria-selected="false">Passport Delayed ({{ $fourpl_delayed->count() }})</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="fourpl_not_solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_fourpl_locker" style="width:100%">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Received From</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($fourpl_in_locker as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}} </td>
                                        <td> {{isset($row->user) ? $row->user->name: 'Rider'}}
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fourpl_with_rider" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_fourpl_rider" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Received From</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($fourpl_with_rider as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}}</td>
                                        <td> {{isset($row->user) ? $row->user->name: ''}}
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fourpl_delayed" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_fourpl_delayed" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($fourpl_delayed as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->personal_info) ? $row->personal_info->full_name: ''}}</td>
                                        <td> {{$row->remarks}}</td>
                                        <td>
                                            @if($row->status == 0)
                                                Not Received
                                            @elseif($row->status == 2)
                                                Security Deposit {{$row->security_deposit_amount}}
                                            @endif
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

@endsection

@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script>
    $(document).ready(function () {
        $(".fourpl-list").hide();
        'use-strict'

        $('#datatable_passport_transferred, #datatable_passport, #datatable_passport_rider, #datatable_passport_controller, #datatable_passport_not_returned,  #datatable_passport_requested, #datatable_passport_accepted, #datatable_passport_rejected, #datatable_passport_delayed,  #datatable_fourpl_locker,  #datatable_fourpl_rider,  #datatable_fourpl_delayed').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,

            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all'

                        }

                    }
                },
                'pageLength',
            ],

            // scrollY: 500,
            responsive: true,
            // scrollX: true,
            // scroller: true
        });
    });

    $(".company").click(function(){
        $(".company-list").show();
        $(".fourpl-list").hide();
    });
    $(".fourpl").click(function(){
        $(".company-list").hide();
        $(".fourpl-list").show();
    });
</script>


@endsection
