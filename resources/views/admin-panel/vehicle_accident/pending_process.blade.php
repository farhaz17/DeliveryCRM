@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .action_btn{
            padding: 1px;
            font-size: 11px;
            font-weight: bold;
        }
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .btn-start {
            padding: 1px;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Vehicle Accident</a></li>
        <li>Pending Process</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true"> Upload Documents ({{$requests->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Claim Process ({{$uploaded->count()}}) </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ClaimTab" data-toggle="tab" href="#Claim" role="tab" aria-controls="Claim" aria-selected="true">Delivery To Garage ({{$claims->count()}}) </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="LossTab" data-toggle="tab" href="#Loss" role="tab" aria-controls="Loss" aria-selected="true">Total Loss Or Repairable ({{$delivery->count()}}) </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="LossUploadTab" data-toggle="tab" href="#LossUpload" role="tab" aria-controls="LossUpload" aria-selected="true">Total Loss Claim Submission ({{$loss_claim->count()}}) </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="CancelTab" data-toggle="tab" href="#Cancel" role="tab" aria-controls="Cancel" aria-selected="true">Total Loss Bike Cancellation ({{$loss_cancel->count()}}) </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="batchs" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Police Report</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                <tr>
                                    <td></td>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    <td>{{ $request->location }}</td>
                                    @if ($request->rider_condition == 1)
                                        <td>Normal</td>
                                    @elseif ($request->rider_condition == 2)
                                        <td>Serious</td>
                                    @elseif ($request->rider_condition == 3)
                                        <td>Death</td>
                                    @endif
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>@if(isset($request))
                                        @if($request->police_report_attachment!=null)
                                            @foreach (json_decode($request->police_report_attachment) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>{{ $request->remark }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Upload Documents</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="reject" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Police Report</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uploaded as $request)
                                <tr>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    <td>{{ $request->location }}</td>
                                    @if ($request->rider_condition == 1)
                                        <td>Normal</td>
                                    @elseif ($request->rider_condition == 2)
                                        <td>Serious</td>
                                    @elseif ($request->rider_condition == 3)
                                        <td>Death</td>
                                    @endif
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>@if(isset($request))
                                        @if($request->police_report_attachment!=null)
                                            @foreach (json_decode($request->police_report_attachment) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>{{ $request->remark }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Claim Registration</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Claim" role="tabpanel" aria-labelledby="ClaimTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="claim" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Claim Date</th>
                                    <th scope="col">Claim File</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claims as $request)
                                <tr>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    <td>{{ $request->location }}</td>
                                    @if ($request->rider_condition == 1)
                                        <td>Normal</td>
                                    @elseif ($request->rider_condition == 2)
                                        <td>Serious</td>
                                    @elseif ($request->rider_condition == 3)
                                        <td>Death</td>
                                    @endif
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>{{ $request->claim_date }}</td>
                                    <td>@if(isset($request))
                                        @if($request->claim_file!=null)
                                            @foreach (json_decode($request->claim_file) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>{{ $request->claim_remark }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Delivery to Garage</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Loss" role="tabpanel" aria-labelledby="LossTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="loss" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Claim Number</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Garage</th>
                                    <th scope="col">Concerned Person</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($delivery as $request)
                                <tr>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>{{ $request->claim_number }}</td>
                                    <td>{{ $request->delivery_date }}</td>
                                    <td>{{ $request->garage }}</td>
                                    <td>{{ $request->concerned_person }}</td>
                                    <td>{{ $request->contact }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Loss or Repair</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="LossUpload" role="tabpanel" aria-labelledby="LossUploadTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="lossupload" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Offer Letter</th>
                                    <th scope="col">Transfer Letter</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loss_claim as $request)
                                <tr>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    <td>{{ $request->location }}</td>
                                    @if ($request->rider_condition == 1)
                                        <td>Normal</td>
                                    @elseif ($request->rider_condition == 2)
                                        <td>Serious</td>
                                    @elseif ($request->rider_condition == 3)
                                        <td>Death</td>
                                    @endif
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>@if(isset($request))
                                        @if($request->offer_letter!=null)
                                            @foreach (json_decode($request->offer_letter) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>@if(isset($request))
                                        @if($request->transfer_letter!=null)
                                            @foreach (json_decode($request->transfer_letter) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Claim Submission</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Cancel" role="tabpanel" aria-labelledby="CancelTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="cancel" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Claim Submitted Date</th>
                                    <th scope="col">Documents</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loss_cancel as $request)
                                <tr>
                                    <td>{{ $request->passport->personal_info->full_name }}</td>
                                    <td>{{ $request->bikes->plate_no }}</td>
                                    <td>{{ $request->accident_date }}</td>
                                    <td>{{ $request->location }}</td>
                                    @if ($request->rider_condition == 1)
                                        <td>Normal</td>
                                    @elseif ($request->rider_condition == 2)
                                        <td>Serious</td>
                                    @elseif ($request->rider_condition == 3)
                                        <td>Death</td>
                                    @endif
                                    @if ($request->checkout_type == 1)
                                        <td>Complete Checkout</td>
                                    @elseif ($request->checkout_type == 2)
                                        <td>Only Bike Replacement</td>
                                    @endif
                                    <td>{{ $request->loss_claim_date }}</td>
                                    <td>@if(isset($request))
                                        @if($request->loss_claim_file!=null)
                                            @foreach (json_decode($request->loss_claim_file) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                        @endif
                                    @endif</td>
                                    <td>{{ $request->loss_claim_remark }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm action_btn" href="{{ url('accident_process') }}?id={{ $request->bike_id }}" target="_blank" >Bike Cancellation</a>
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
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#batchs').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
        });
        var tables = $('#reject').DataTable();
        tables.columns.adjust().draw();
        var tables = $('#claim').DataTable();
        tables.columns.adjust().draw();
        var tables = $('#loss').DataTable();
        tables.columns.adjust().draw();
        var tables = $('#lossupload').DataTable();
        tables.columns.adjust().draw();
        var tables = $('#cancel').DataTable();
        tables.columns.adjust().draw();
    </script>
    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
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
