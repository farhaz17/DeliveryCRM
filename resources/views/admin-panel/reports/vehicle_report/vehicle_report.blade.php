@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">RTA</a></li>
        <li>Vehicle Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-11" id="report" style="width: 100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Plate No</th>
                            <th scope="col">Model</th>
                            <th scope="col">Chassis No</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub Category</th>
                            <th scope="col">Insurance Company</th>
                            <th scope="col">Insurance Issue Date</th>
                            <th scope="col">Insurance Expiry Date</th>
                            <th scope="col">Registration Issue Date</th>
                            <th scope="col">Registration Expiry Date</th>
                            <th scope="col">Rider Name</th>
                            <th scope="col">Rider Phone</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col" class="filtering_source_from">Platform</th>
                            <th>Rider ID</th>
                            <th scope="col">DC Name</th>
                            <th scope="col">Vehicle Status</th>
                            {{-- <th scope="col">Fine Impounding</th> --}}
                            <th scope="col">Box</th>
                            <th scope="col">Food Permit</th>
                            <th scope="col">FoodPermit Expiry</th>
                            <th scope="col">Salik Tag</th>
                            <th scope="col">Tracker</th>
                            <th scope="col">Traffic File No</th>
                            <th scope="col">Traffic Company Name</th>
                            <th scope="col">Image</th>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                        <tr>
                            <td></td>
                            <td>{{ $vehicle->plate_no }}</td>
                            <td>
                            @if(is_numeric($vehicle->model))
                                {{ $vehicle->model_info ? $vehicle->model_info->name : '' }}
                            @else
                                {{ $vehicle->model }}
                            @endif
                            </td>
                            <td>{{ $vehicle->chassis_no }}</td>
                            <td>{{ $vehicle->category ? $vehicle->category->name : '' }}</td>
                            <td>{{ $vehicle->sub_category ? $vehicle->sub_category->name : '' }}</td>
                            <td>
                            @if(is_numeric($vehicle->insurance_co))
                                {{ $vehicle->insurances ? $vehicle->insurances->name : '' }}
                            @else
                                {{ $vehicle->insurance_co }}
                            @endif
                            </td>
                            <td>{{ $vehicle->insurance_issue_date }}</td>
                            <td>{{ $vehicle->insurance_expiry_date }}</td>
                            <td>{{ $vehicle->issue_date }}</td>
                            <td>{{ $vehicle->expiry_date }}</td>
                            <td class="text-nowrap">{{ $vehicle->get_current_bike ? $vehicle->get_current_bike->passport->personal_info->full_name : '' }}</td>
                            <td>
                                {{ $vehicle->get_current_bike ? ($vehicle->get_current_bike->passport->rider_sim_assign ? "O: " . $vehicle->get_current_bike->passport->rider_sim_assign->telecome->account_number ." / " : "" ): ""  }}
                                {{ $vehicle->get_current_bike ? ($vehicle->get_current_bike->passport->personal_info->personal_mob ? "P: " . $vehicle->get_current_bike->passport->personal_info->personal_mob : ""  ): ""  }}
                            </td>
                            <td>{{ $vehicle->get_current_bike ? $vehicle->get_current_bike->passport->zds_code->zds_code : '' }}</td>
                            <td>
                                {{ isset($vehicle->get_current_bike->plateforms) ? $vehicle->get_current_bike->plateforms->plateformdetail->name : '' }}
                            </td>
                            <td>
                                @if(isset($vehicle->get_current_bike))
                                    @if(isset($vehicle->get_current_bike->plateforms))
                                        @php
                                            $plaform_id = $vehicle->get_current_bike->plateforms->plateformdetail->id
                                        @endphp
                                        {{ $vehicle->get_current_bike->passport->check_platform_code_exist->where('platform_id',$plaform_id )->first->platform_code->platform_code ?? "" }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ isset($vehicle->get_current_bike->passport->rider_dc_detail->user_detail) ? $vehicle->get_current_bike->passport->rider_dc_detail->user_detail->name : '' }}</td>
                            @if ($vehicle->status == 0)
                                <td>Not Working</td>
                            @elseif($vehicle->status == 1)
                                <td>Active</td>
                            @elseif($vehicle->status == 2)
                                <td>Working</td>
                            @elseif($vehicle->status == 3)
                                <td>Holding</td>
                            @else
                                <td></td>
                            @endif
                            {{-- <td></td> --}}
                            @if ($vehicle->current_box != null)
                            <td>Yes ({{ $vehicle->current_box->platformdetail->name }})</td>
                            @else
                            <td></td>
                            @endif
                            @if ($vehicle->food_permit != null)
                            <td>Yes ({{ $vehicle->food_permit->city->name }})</td>
                            @else
                            <td></td>
                            @endif
                            @if ($vehicle->food_permit != null)
                            <td>{{ $vehicle->food_permit->expiry_date }}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{ isset($vehicle->salik_tag) ? $vehicle->salik_tag->salik->tag_no : ''}}</td>
                            <td>{{ $vehicle->bike_tracking->tracker->tracking_no ?? '' }}</td>
                            <td>{{ $vehicle->traffic->traffic_file_no ?? '' }}</td>
                            <td class="text-nowrap">
                                @if(isset($vehicle->traffic) && $vehicle->traffic->traffic_for == 1)
                                    {{ $vehicle->traffic->company->name ?? "NA" }}
                                @elseif(isset($vehicle->traffic) && $vehicle->traffic->traffic_for == 2)
                                    {{ $vehicle->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                @elseif(isset($vehicle->traffic) && $vehicle->traffic->traffic_for == 3)
                                    {{ $vehicle->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                @endif
                            </td>
                            @if ($vehicle->current_box != null)
                                @if($vehicle->current_box->box_image!=null)
                                    <td>
                                        @foreach (json_decode($vehicle->current_box->box_image) as $attach)
                                            <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Image </strong></a><span>|</span>
                                        @endforeach
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @else
                                <td></td>
                            @endif
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
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#report').DataTable( {
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Vehicle Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollX": true,
            });
        });
    </script>
@endsection
