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
        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#vehicleInfo" role="tab" aria-controls="not_solved" aria-selected="true">Vehicle Info</a></li>
        {{-- <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#checkoutBike" role="tab" aria-controls="solved" aria-selected="false">Checkout Bike</a></li> --}}
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#attachVcc" role="tab" aria-controls="solved" aria-selected="false">Attach VCC</a></li>
        {{-- <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#policeNotification" role="tab" aria-controls="solved" aria-selected="false">Police Notification</a></li> --}}
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#addInsurance" role="tab" aria-controls="solved" aria-selected="false">Add Insurance</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#registration" role="tab" aria-controls="solved" aria-selected="false">Plate Registration</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#salik" role="tab" aria-controls="solved" aria-selected="false">Salik Tags</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#ready" role="tab" aria-controls="solved" aria-selected="false">Ready To Use</a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="vehicleInfo" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableVehicleInfo" style="width:100%;">
                    <thead class="thead-dark">
                    <tr>
                        {{--                            <th scope="col">#</th>--}}
                        <th scope="col" style="width: 100px">Chassis No</th>
                        <th scope="col" style="width: 100px">Make Year</th>
                        <th scope="col" style="width: 100px">LPO No</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="attachVcc" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableAttachVcc" style="width:100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Chassis No</th>
                            <th scope="col" style="width: 100px">Make Year</th>
                            <th scope="col" style="width: 100px">Action</th>
                            <th scope="col" style="width: 100px">LPO No</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos->where('process', 2) as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                            <td><a class="btn btn-primary" href="{{ route('lpo-process', ['vehicle_id' => $row->id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="addInsurance" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableAddInsurance" style="width:100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Chassis No</th>
                            <th scope="col" style="width: 100px">Make Year</th>
                            <th scope="col" style="width: 100px">LPO No</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos->where('process', 3) as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                            <td><a class="btn btn-primary" href="{{ route('lpo-process', ['vehicle_id' => $row->id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="registration" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableRegistration" style="width:100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Chassis No</th>
                            <th scope="col" style="width: 100px">Make Year</th>
                            <th scope="col" style="width: 100px">LPO No</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos->where('process', 4) as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                            <td><a class="btn btn-primary" href="{{ route('lpo-process', ['vehicle_id' => $row->id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="salik" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableSalik" style="width:100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Chassis No</th>
                            <th scope="col" style="width: 100px">Make Year</th>
                            <th scope="col" style="width: 100px">LPO No</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos->where('process', 4) as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                            <td><a class="btn btn-primary" href="{{ route('lpo-process', ['vehicle_id' => $row->id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="ready" role="tabpanel" aria-labelledby="home-basic-tab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-14 datatable-contract" id="datatableReady" style="width:100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Chassis No</th>
                            <th scope="col" style="width: 100px">Make Year</th>
                            <th scope="col" style="width: 100px">LPO No</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($lpos->where('process', 4) as $row)

                        <tr>
                            <td>{{ $row->chassis_no }}</td>
                            <td>{{ $row->make_year }}</td>
                            <td>{{ $row->lpo->lpo_no }}</td>
                            <td><a class="btn btn-primary" href="{{ route('lpo-process', ['vehicle_id' => $row->id])}}">Start Process</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
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

    $('#datatableVehicleInfo, #datatableAttachVcc, #datatableAddInsurance, #datatableRegistration, #datatableSalik, #datatableReady').DataTable( {
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
