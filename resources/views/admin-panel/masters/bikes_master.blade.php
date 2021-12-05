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
            <li class="breadcrumb-item active" aria-current="page">Vehicles List</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs small" id="myTab" role="tablist">
                    <li class="nav-item">
                        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
                        <a class="nav-link active" id="TotalBikesTab" data-toggle="tab" href="#TotalBikes" role="tab" aria-controls="TotalBikes" aria-selected="true">Totlal Bikes ( {{$total_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="CancelledBikesTab" data-toggle="tab" href="#CancelledBikes" role="tab" aria-controls="CancelledBikes" aria-selected="false">Cancelled Bikes ( {{$cancelled_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="RegisteredBikesTab" data-toggle="tab" href="#RegisteredBikes" role="tab" aria-controls="RegisteredBikes" aria-selected="false">Registered Bikes ( {{$registered_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="CompanyBikesTab" data-toggle="tab" href="#CompanyBikes" role="tab" aria-controls="CompanyBikes" aria-selected="false">Company Bikes ( {{$company_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="OwnToLeaseBikesTab" data-toggle="tab" href="#OwnToLeaseBikes" role="tab" aria-controls="OwnToLeaseBikes" aria-selected="false">Own To Lease Bikes ( {{$own_to_lease_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="LeasedBikesTab" data-toggle="tab" href="#LeasedBikes" role="tab" aria-controls="LeasedBikes" aria-selected="false">Leased Bikes ( {{$leased_bikes->count()}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="PersonalBikesTab" data-toggle="tab" href="#PersonalBikes" role="tab" aria-controls="PersonalBikes" aria-selected="false">Personal Bikes ( {{$personal_bikes->count()}} )</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="TotalBikes" role="tabpanel" aria-labelledby="TotalBikesTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="TotalBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Traffic File No</th>

                                        <th class="filtering_column">State</th>

                                        <th class="filtering_column">Traffic Owner Name</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($total_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{$bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{$bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{$bike->plate_code ?? "" }}</td>
                                            @endif

                                            <td> {{ is_numeric($bike->model) ? $bike->model_info->name : $bike->model }}</td>
                                            <td>{{$bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? "" }}</td>
                                            <td>{{ $bike->sub_category->name ?? "" }} </td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{ dateToRead($bike->issue_date) }}</td>
                                            <td>{{ dateToRead($bike->expiry_date) }}</td>
                                            <td>{{ $bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="CancelledBikes" role="tabpanel" aria-labelledby="CancelledBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="CancelledBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>

                                        <th class="filtering_column">State</th>

                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cancelled_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $bike->plate_no}}</td>
                                            <td>{{ $bike->make->name ?? ''}}</td>
                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>
                                            <td>{{ $bike->chassis_no}}</td>
                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? ''}}</td>
                                            @if(is_numeric($bike->insurance_co))
                                            <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{ $bike->expiry_date}}</td>
                                            <td>{{ $bike->issue_date}}</td>

                                            <td>{{ $bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{ $bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="RegisteredBikes" role="tabpanel" aria-labelledby="RegisteredBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="RegisteredBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registered_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key  }}</td>
                                            <td>{{$bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{$bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{$bike->plate_code ?? "" }}</td>
                                            @endif

                                            @if(is_numeric($bike->model))
                                            <td>{{$bike->model_info->name ?? ""}}</td>
                                            @else
                                            <td>{{$bike->model ?? ""}}</td>
                                            @endif
                                            <td>{{$bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{$bike->expiry_date}}</td>
                                            <td>{{$bike->issue_date}}</td>

                                            <td>{{$bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="CompanyBikes" role="tabpanel" aria-labelledby="CompanyBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="CompanyBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($company_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{$bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{$bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{$bike->plate_code ?? "" }}</td>
                                            @endif

                                            @if(is_numeric($bike->model))
                                            <td>{{$bike->model_info->name ?? ""}}</td>
                                            @else
                                            <td>{{$bike->model ?? ""}}</td>
                                            @endif
                                            <td>{{$bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{$bike->expiry_date}}</td>
                                            <td>{{$bike->issue_date}}</td>

                                            <td>{{$bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="OwnToLeaseBikes" role="tabpanel" aria-labelledby="OwnToLeaseBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="OwnToLeaseBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>

                                        <th  class="filtering_column">State</th>

                                        <th  class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($own_to_lease_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{$bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{$bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{$bike->plate_code ?? "" }}</td>
                                            @endif

                                            @if(is_numeric($bike->model))
                                            <td>{{$bike->model_info->name ?? ""}}</td>
                                            @else
                                            <td>{{$bike->model ?? ""}}</td>
                                            @endif
                                            <td>{{$bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{$bike->expiry_date}}</td>
                                            <td>{{$bike->issue_date}}</td>

                                            <td>{{$bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="LeasedBikes" role="tabpanel" aria-labelledby="LeasedBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="LeasedBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>

                                        <th class="filtering_column">State</th>

                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leased_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{ $bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{ $bike->plate_code ?? "" }}</td>
                                            @endif

                                            @if(is_numeric($bike->model))
                                            <td>{{ $bike->model_info->name ?? ""}}</td>
                                            @else
                                            <td>{{ $bike->model ?? ""}}</td>
                                            @endif
                                            <td>{{ $bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{$bike->expiry_date}}</td>
                                            <td>{{$bike->issue_date}}</td>

                                            <td>{{$bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="PersonalBikes" role="tabpanel" aria-labelledby="PersonalBikeTab">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="PersonalBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Plate Number</th>
                                        <th>Plate Code</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Year</th>
                                        <th>Chassis no</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Insurance Company</th>
                                        <th>Expiry Date</th>
                                        <th>Issue Date</th>
                                        <th>Traffic File No</th>
                                        <th class="filtering_column">State</th>
                                        <th class="filtering_column">Traffic Owner Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($personal_bikes as $key => $bike)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $bike->plate_no}}</td>
                                            @if(is_numeric($bike->plate_code))
                                            <td>{{ $bike->plate_code->plate_code ?? "" }}</td>
                                            @else
                                            <td>{{ $bike->plate_code ?? "" }}</td>
                                            @endif

                                            @if(is_numeric($bike->model))
                                            <td>{{ $bike->model_info->name ?? ""}}</td>
                                            @else
                                            <td>{{ $bike->model ?? ""}}</td>
                                            @endif
                                            <td>{{$bike->make->name ?? ''}}</td>

                                            <td>{{ $bike->year ? $bike->year->year : ''  }}</td>

                                            <td>{{$bike->chassis_no}}</td>

                                            <td>{{ $bike->category->name ?? '' }}</td>
                                            <td>{{ $bike->sub_category->name ?? '' }}</td>

                                            @if(is_numeric($bike->insurance_co))
                                                <td>{{ $bike->insurance ? $bike->insurance->name : ""}}</td>
                                            @else
                                                <td>{{$bike->insurance_co}}</td>
                                            @endif
                                            <td>{{$bike->expiry_date}}</td>
                                            <td>{{$bike->issue_date}}</td>

                                            <td>{{$bike->traffic->traffic_file_no ?? ""}}</td>

                                            <td class="text-nowrap">{{$bike->traffic->state->name ?? ""}}</td>

                                            <td class="text-nowrap">
                                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                                    {{$bike->traffic->company->name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                                @else
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
            $('#TotalBikesTable, #CancelledBikesTable, #RegisteredBikesTable, #CompanyBikesTable, #OwnToLeaseBikesTable,#LeasedBikesTable, #PersonalBikesTable').DataTable( {
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
                        title: 'Bikes Summary',
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
