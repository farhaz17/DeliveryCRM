@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">RTA Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Status Wise Vehicles List</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs small" id="myTab" role="tablist">
                    {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="RunningBikesTab" data-toggle="tab" href="#RunningBikes" role="tab" aria-controls="RunningBikes" aria-selected="false">Running Bikes ( {{ $total_bikes_running->count() }} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="RepairingAtGarageBikesTab" data-toggle="tab" href="#RepairingAtGarageBikes" role="tab" aria-controls="RepairingAtGarageBikes" aria-selected="false">Repairing at Garage Bikes( {{ $repairing_at_garage_bikes->count() }} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="WorkingBikesTab" data-toggle="tab" href="#WorkingBikes" role="tab" aria-controls="WorkingBikes" aria-selected="false">Working Bikes (  {{ $working_vehicles->count() }}  )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="NotWorkingBikesTab" data-toggle="tab" href="#NotWorkingBikes" role="tab" aria-controls="NotWorkingBikes" aria-selected="false">Not Working Bikes (   {{ $not_working_vehicles->count() }}   )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="HoldingBikesTab" data-toggle="tab" href="#HoldingBikes" role="tab" aria-controls="HoldingBikes" aria-selected="false">Holding Bikes (   {{ $holding_vehicles->count() }}   )</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane show active fade" id="RunningBikes" role="tabpanel" aria-labelledby="RunningBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="RunningBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        {{-- <th>Vehicle State</th> --}}
                                        <th class="filtering_column">Plateform</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Rider Info</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_bikes_running as $bike)
                                        <tr>
                                            <td>{{ $bike->id }}</td>
                                            <td>{{ $bike->plate_no }}</td>
                                            <td>{{ $bike->model_info->name ?? '' }} </td>
                                            <td>{{ $bike->year->year ?? '' }} </td>
                                            <td>{{ $bike->chassis_no ?? '' }}</td>
                                            {{-- <td>
                                                @if($bike->get_current_bike)
                                                    @if($bike->get_current_bike->passport)
                                                        @if($bike->get_current_bike->passport->rider_platform)
                                                            @if($bike->get_current_bike->passport->rider_platform->whereStatus(1)->first()->city)
                                                                {{ $bike->get_current_bike->passport->rider_platform->whereStatus(1)->first()->city->name ?? ''}}
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if($bike->get_current_bike)
                                                    @if($bike->get_current_bike->passport)
                                                        @if($bike->get_current_bike->passport->rider_platform)
                                                            {{ $bike->get_current_bike->passport->platform_assign->where('status','=','1')->first()->plateformdetail->name ??  'Rider Plate form not found'}}
                                                        @else
                                                            Rider Plate form not found
                                                        @endif
                                                    @else
                                                        Passport not found
                                                    @endif
                                                @elseif($bike->get_temporaray_bike)
                                                    @if($bike->get_temporaray_bike->passport)
                                                        @if($bike->get_temporaray_bike->passport->rider_platform)
                                                            {{ $bike->get_temporaray_bike->passport->platform_assign->where('status','=','1')->first()->plateformdetail->name ??  'Rider Plate form not found'}}
                                                        @else
                                                            Rider Plate form not found
                                                        @endif
                                                    @else
                                                            Passport not found
                                                    @endif

                                                 @else
                                                    no relation found
                                                @endif
                                            </td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>
                                            <td>
                                                @if(isset($bike->get_current_bike->passport->personal_info))
                                                    <b>Name: </b> {{ $bike->get_current_bike->passport->personal_info->full_name }}
                                                    <b>PP UID: </b>  {{ $bike->get_current_bike->passport->pp_uid }}
                                                @elseif($bike->get_temporaray_bike)
                                                    <b>Name: </b> {{ $bike->get_temporaray_bike->passport->personal_info->full_name }}
                                                    <b>PP UID: </b>  {{ $bike->get_temporaray_bike->passport->pp_uid }}
                                                @else
                                                    <b>Name: </b> N/A
                                                    <b>PP UID: </b>  N/A
                                                @endif
                                            </td>
                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>
                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane show" id="RepairingAtGarageBikes" role="tabpanel" aria-labelledby="RepairingAtGarageBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="RepairingAtGarageBikesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th class="filtering_column">Plateform</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Rider Info</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($repairing_at_garage_bikes as $bike)
                                        <tr>
                                            <td>{{ $bike->id }}</td>
                                            <td>{{ $bike->plate_no }}</td>
                                            <td>{{ $bike->model_info->name ?? '' }} </td>
                                            <td>{{ $bike->year->year ?? '' }} </td>
                                            <td>{{ $bike->chassis_no ?? '' }}</td>
                                            <td>
                                                @if($bike->get_current_bike)
                                                    @if($bike->get_current_bike->passport)
                                                        @if($bike->get_current_bike->passport->rider_platform)
                                                            {{ $bike->get_current_bike->passport->platform_assign->where('status','=','1')->first()->plateformdetail->name ??  'Rider Plate form not found'}}
                                                        @else
                                                            Rider Plate form not found
                                                        @endif
                                                    @else
                                                        Passport not found
                                                    @endif
                                                @elseif($bike->get_temporaray_bike)
                                                    @if($bike->get_temporaray_bike->passport)
                                                        @if($bike->get_temporaray_bike->passport->rider_platform)
                                                            {{ $bike->get_temporaray_bike->passport->platform_assign->where('status','=','1')->first()->plateformdetail->name ??  'Rider Plate form not found'}}
                                                        @else
                                                            Rider Plate form not found
                                                        @endif
                                                    @else
                                                            Passport not found
                                                    @endif

                                                 @else
                                                    no relation found
                                                @endif
                                            </td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>
                                            <td>
                                                @if(isset($bike->get_current_bike->passport->personal_info))
                                                    <b>Name: </b> {{ $bike->get_current_bike->passport->personal_info->full_name }}
                                                    <b>PP UID: </b>  {{ $bike->get_current_bike->passport->pp_uid }}
                                                @else
                                                    <b>Name: </b> N/A
                                                    <b>PP UID: </b>  N/A
                                                @endif
                                            </td>
                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>
                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="WorkingBikes" role="tabpanel" aria-labelledby="WorkingBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="WorkingBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($working_vehicles as $bike)
                                        <tr>
                                            <td>{{ $bike->id }}</td>
                                            <td>{{ $bike->plate_no }}</td>
                                            <td>{{ $bike->model_info->name ?? '' }} </td>
                                            <td>{{ $bike->year->year ?? '' }} </td>
                                            <td>{{ $bike->chassis_no ?? '' }}</td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>
                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>
                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="NotWorkingBikes" role="tabpanel" aria-labelledby="NotWorkingBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="NotWorkingBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($not_working_vehicles as $bike)
                                        <tr>
                                            <td>{{ $bike->id }}</td>
                                            <td>{{ $bike->plate_no }}</td>
                                            <td>{{ $bike->model_info->name ?? '' }} </td>
                                            <td>{{ $bike->year->year ?? '' }} </td>
                                            <td>{{ $bike->chassis_no ?? '' }}</td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>
                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>
                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="HoldingBikes" role="tabpanel" aria-labelledby="HoldingBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="HoldingBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holding_vehicles as $bike)
                                        <tr>
                                            <td>{{ $bike->id }}</td>
                                            <td>{{ $bike->plate_no }}</td>
                                            <td>{{ $bike->model_info->name ?? '' }} </td>
                                            <td>{{ $bike->year->year ?? '' }} </td>
                                            <td>{{ $bike->chassis_no ?? '' }}</td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>
                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>
                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script>
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#RunningBikesTable, #RepairingAtGarageBikesTable, #WorkingBikesTable, #NotWorkingBikesTable, #HoldingBikesTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
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
                    {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"} // last column width for all tables
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Status wise vehicle summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                "scrollY": true,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href');
                $(currentTab +"Table").DataTable().columns.adjust().draw();
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
