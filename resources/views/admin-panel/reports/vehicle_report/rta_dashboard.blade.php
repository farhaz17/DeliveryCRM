@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .boxes:hover {
            background-color:#e2ecec;
        }
        h3 {
            position: relative;
            font-size: 25px;
            text-align: center;
        }
        h3:before, h3:after {
            position: absolute;
            top: 51%;
            width: 50%;
            height: 1px;
            content: '\a0';
            background-color: rgb(0, 0, 0);
        }
        h3:before {
            margin-left: -50%;
        }
        .btn-view {
            color: rgb(0, 34, 128);
            font-weight: bolder;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">RTA</a></li>
        <li>Dashboard</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-info fa-3x"></i>
                <p class="mt-2 mb-2"><b>Total Bikes</b></p>
                <p class="text-info text-24 line-height-1 m-0"><b>{{ $total_bike }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-success fa-3x"></i>
                <p class="mt-2 mb-2"><b>Active Bikes</b></p>
                <p class="text-success text-24 line-height-1 m-0"><b>{{ $active_bike }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-danger fa-3x"></i>
                <p class="mt-2 mb-2"><b>Cancelled Bikes</b></p>
                <p class="text-danger text-24 line-height-1 m-0"><b>{{ count($cancel_bike) }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-dark fa-3x"></i>
                <p class="mt-2 mb-2"><b>Working Bikes</b></p>
                <p class="text-dark text-24 line-height-1 m-0"><b>{{ $working_bike }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-primary fa-3x"></i>
                <p class="mt-2 mb-2"><b>Not Working Bikes</b></p>
                <p class="text-primary text-24 line-height-1 m-0"><b>{{ $not_work_bike }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card mb-4 boxes">
            <div class="card-body text-center" id="">
                <i class="fa fa-motorcycle text-secondary fa-3x"></i>
                <p class="mt-2 mb-2"><b>Reserved Bikes</b></p>
                <p class="text-secondary text-24 line-height-1 m-0"><b>{{ $holding_bike }}</b></p>
            </div>
        </div>
    </div>
</div>

<div><h3><b>Today's Activities</b></h3></div><br>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Bike Checkin ({{ $bike_checkins->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="bikecheckin" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Bike</th>
                    </thead>
                    <tbody>
                        @foreach ($bike_checkins as $bike_checkin)
                        <tr>
                            <td>{{ $bike_checkin->passport->personal_info->full_name }}</td>
                            <td>{{ $bike_checkin->bike_plate_number->plate_no }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: center;"><a href="javascript:void(0)" id="checkin_more" class="btn btn-view">View More</a></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Bike Checkout ({{ $bike_checkouts->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable2" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Bike</th>
                    </thead>
                    <tbody>
                        @foreach ($bike_checkouts as $bike_checkout)
                        <tr>
                            <td>{{ $bike_checkout->passport->personal_info->full_name }}</td>
                            <td>{{ $bike_checkout->bike_plate_number->plate_no }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: center;"><a href="javascript:void(0)" id="checkout_more" class="btn btn-view">View More</a></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Box Installed ({{ $boxes->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable3" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Bike</th>
                        <th scope="col">Box</th>
                    </thead>
                    <tbody>
                        @foreach ($boxes as $box)
                        <tr>
                            <td>{{ $box->bikes->plate_no }}</td>
                            <td>{{ $box->platformdetail->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Food Permit ({{ $permits->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable4" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Bike</th>
                        <th scope="col">City</th>
                    </thead>
                    <tbody>
                        @foreach ($permits as $permit)
                        <tr>
                            <td>{{ $permit->bikes->plate_no }}</td>
                            <td>{{ $permit->city->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Vehicle Accident ({{ $accidents->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable5" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Bike</th>
                    </thead>
                    <tbody>
                        @foreach ($accidents as $accident)
                        <tr>
                            <td>{{ $accident->passport->personal_info->full_name }}</td>
                            <td>{{ $accident->bikes->plate_no }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Bike Missing ({{ $missings->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable6" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Bike</th>
                        <th scope="col">Missing Date</th>
                    </thead>
                    <tbody>
                        @foreach ($missings as $missing)
                        <tr>
                            <td>{{ $missing->bike->plate_no }}</td>
                            <td>{{ $missing->missing_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title"> <span class="badge badge-info">Fine Impounding ({{ $impoundings->count() }})</span></div>
                <table class="table table-sm table-striped table-bordered text-11" id="datatable7" style="width:100%;">
                    <thead>
                    <tr>
                        <th scope="col">Bike</th>
                        <th scope="col">Ticket Number</th>
                        <th scope="col">Ticket Date</th>
                    </thead>
                    <tbody>
                        @foreach ($impoundings as $impounding)
                        <?php
                            // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                            $ticketTime = strtotime($impounding->ticket_date);
                            // This difference is in seconds.
                            $difference = time() - $ticketTime;
                        ?>
                        <tr @if((round($difference / 86400) - 1 ) > "10") style="background-color: #ff18004a;" @endif >
                            <td>{{ $impounding->plate_number }}</td>
                            <td>{{ $impounding->ticket_number }}</td>
                            <td>{{ $impounding->ticket_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: center;"><a href="javascript:void(0)" id="impounding_more" class="btn btn-view">View More</a></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="checkin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Last Seven Days Checkin ({{ $bike_checkin_more->count() }})</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-sm table-striped table-bordered text-11" id="bikecheckinmore" style="width:100%;">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Bike</th>
                            <th scope="col">CheckIn</th>
                        </thead>
                        <tbody>
                            @foreach ($bike_checkin_more as $bike_checkin)
                            <tr>
                                <td>{{ $bike_checkin->passport->personal_info->full_name }}</td>
                                <td>{{ $bike_checkin->bike_plate_number->plate_no }}</td>
                                <td>{{ date('d-m-Y', strtotime($bike_checkin->checkin)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="checkout_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Last Seven Days Checkout ({{ $bike_checkout_more->count() }})</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-sm table-striped table-bordered text-11" id="bikecheckoutmore" style="width:100%;">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Bike</th>
                            <th scope="col">Checkout</th>
                        </thead>
                        <tbody>
                            @foreach ($bike_checkout_more as $bike_checkout)
                            <tr>
                                <td>{{ $bike_checkout->passport->personal_info->full_name }}</td>
                                <td>{{ $bike_checkout->bike_plate_number->plate_no }}</td>
                                <td>{{ date('d-m-Y', strtotime($bike_checkout->checkout)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="impounding_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Last Seven Days Fine Impounding ({{ $impounding_more->count() }})</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-sm table-striped table-bordered text-11" id="impoundingmore" style="width:100%;">
                        <thead>
                        <tr>
                            <th scope="col">Bike</th>
                        <th scope="col">Ticket Number</th>
                        <th scope="col">Ticket Date</th>
                        <th scope="col">Created At</th>
                        </thead>
                        <tbody>
                            @foreach ($impounding_more as $impounding)
                            <?php
                                // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                $ticketTime = strtotime($impounding->ticket_date);
                                // This difference is in seconds.
                                $difference = time() - $ticketTime;
                            ?>
                            <tr @if((round($difference / 86400) - 1 ) > "10") style="background-color: #ff18004a;" @endif >
                                <td>{{ $impounding->plate_number }}</td>
                                <td>{{ $impounding->ticket_number }}</td>
                                <td>{{ $impounding->ticket_date }}</td>
                                <td>{{ $impounding->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script>
        $('#checkin_more').click(function(){
            $('#checkin_modal').modal('show');
        });
        $('#checkout_more').click(function(){
            $('#checkout_modal').modal('show');
        });
        $('#impounding_more').click(function(){
            $('#impounding_modal').modal('show');
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#bikecheckin').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable2').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable3').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable4').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable5').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable6').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable7').DataTable( {
                "pageLength": 10,
                "searching": false,
                "bLengthChange": false,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#bikecheckinmore').DataTable( {
                "pageLength": 10,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#bikecheckoutmore').DataTable( {
                "pageLength": 10,
            });
        });
        $(document).ready(function () {
            'use strict';
            $('#impoundingmore').DataTable( {
                "pageLength": 10,
            });
        });
    </script>
@endsection
