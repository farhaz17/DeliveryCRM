@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    @endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Vehicle Accident</a></li>
        <li>Process Completed Bikes</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true">Total Loss Cancelled Bikes ({{$loss->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Repairable Bikes ({{$repair->count()}})</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="loss" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Cancelled Date</th>
                                    <th scope="col">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loss as $request)
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
                                    <td>{{ $request->cancelled_date }}</td>
                                    <td>{{ $request->cancelled_remark }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="repair" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Accident Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Rider Condition</th>
                                    <th scope="col">Checkout Type</th>
                                    <th scope="col">Receive Date</th>
                                    <th scope="col">Person</th>
                                    <th scope="col">Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($repair as $request)
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
                                    <td>{{ $request->receive_date }}</td>
                                    <td>{{ $request->person }}</td>
                                    <td>{{ $request->condition }}</td>
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
    <script>
        $(document).ready(function () {
            'use strict';
            $('#loss').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
        });
        var tables = $('#repair').DataTable();
        tables.columns.adjust().draw();
    </script>
@endsection
