@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        /* css for type ahead only */
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        span#drop-full_name {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }

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
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            background: #ffffff;
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

    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="">LPO Master</a></li>
      <li class="breadcrumb-item active" aria-current="page">Bike Missing Request</li>
    </ol>
</nav>

<div class="p-4 m-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#missingBike" role="tab" aria-controls="not_solved" aria-selected="true">Missing Bike({{$bikes->count()}})</a></li>
        {{-- <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#checkoutBike" role="tab" aria-controls="solved" aria-selected="false">Checkout Bike</a></li> --}}
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#policeRequest" role="tab" aria-controls="solved" aria-selected="false">Police Request({{$bikes->where('process', 1)->count()}})</a></li>
        {{-- <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#policeNotification" role="tab" aria-controls="solved" aria-selected="false">Police Notification</a></li> --}}
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#policeReport" role="tab" aria-controls="solved" aria-selected="false">Police Report({{$bikes->where('process', 2)->count()}})</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#claimInsurance" role="tab" aria-controls="solved" aria-selected="false">Claim Insurance({{$bikes->where('process', 3)->count()}})</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#receivePayment" role="tab" aria-controls="solved" aria-selected="false">Receive Payment({{$bikes->where('process', 4)->count()}})</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#vehicleCancellation" role="tab" aria-controls="solved" aria-selected="false">Vehicle Cancellation({{$bikes->where('process', 5)->count()}})</a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="missingBike" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableMissingBike" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remarks</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="tab-pane fade" id="checkoutBike" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableCheckoutBike" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 1) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div> --}}

        <div class="tab-pane fade" id="policeRequest" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatablePoliceRequest" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 1) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="tab-pane fade" id="policeNotification" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatablePoliceNotification" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>

                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 2) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div> --}}

        <div class="tab-pane fade" id="policeReport" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatablePoliceReport" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 2) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="claimInsurance" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableClaimInsurance" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 3) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="receivePayment" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableReceivePayment" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 4) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="vehicleCancellation" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableVehicleCancellation" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Bike</th>
                        <th scope="col" style="width: 100px">Remark</th>
                        <th scope="col" style="width: 100px">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($bikes->where('process', 5) as $row)

                        <tr>
                            <td>{{ $row->bike->plate_no }}</td>
                            <td>{{ $row->remarks }}</td>
                            <td><a class="btn btn-primary" href="{{ route('bike-process-single', ['bike_id' => $row->bike_id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="policeRequestModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Checkout<h3>
                    </div>
                </div>

                <div class="renew">
                    <form method="post" action="">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Complaint Date</label>
                            <input id="" name="complaint_date" class="form-control" type="date">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Police Station</label>
                            <input id="" name="complaint_date" class="form-control" type="text">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            <input id="" name="remarks" class="form-control" type="text">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Checkout">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="policeNotificationModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Checkout<h3>
                    </div>
                </div>

                <div class="renew">
                    <form method="post" action="">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Complaint Date</label>
                            <input id="" name="complaint_date" class="form-control" type="date">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Police Station</label>
                            <input id="" name="complaint_date" class="form-control" type="text">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            <input id="" name="remarks" class="form-control" type="text">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Checkout">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="policeReportModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Checkout<h3>
                    </div>
                </div>

                <div class="renew">
                    {{-- <form method="post" action=""> --}}


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Complaint Date</label>
                            <input id="" name="complaint_date" class="form-control" type="date">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Police Station</label>
                            <input id="" name="complaint_date" class="form-control" type="text">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            <input id="" name="remarks" class="form-control" type="text">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Checkout">
                            </div>
                        </div>
                    {{-- </form> --}}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>

<script>

    $('#datatableMissingBike, #datatableCheckoutBike, #datatablePoliceRequest, #datatablePoliceNotification, #datatablePoliceReport, #datatableClaimInsurance, #datatableReceivePayment, #datatableVehicleCancellation').DataTable( {
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

    $('#selectBike').select2({
        placeholder: 'Select the state',
        width: '100%'
    });


</script>


@endsection
