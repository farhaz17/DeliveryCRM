<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<ul class="nav nav-tabs small" id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="ActiveDCRiderTimeSheetsTab" data-toggle="tab" href="#ActiveDCRiderTimeSheets" role="tab" aria-controls="ActiveDCRiderTimeSheets" aria-selected="true">All Active DC Rider Time Sheets ( {{$with_dc_assign_to_dc_rider_time_sheets->count()}} )</a>
    </li>
    @if (request('dc_id'))
        @php
            $transfered_to_another_dc_count = 0;
        @endphp
        @foreach ($without_dc_assign_to_dc_rider_time_sheets as $time_sheets)
            @foreach ($time_sheets as $time_sheet)
                @if($loop->first  && $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->whereNotIn('user_id', request('user_id'))->where('status', 1)->first())
                    @php
                        $transfered_to_another_dc_count++
                    @endphp
                @endif
            @endforeach
    @endforeach
    <li class="nav-item">
        <a class="nav-link" id="TransferedToAnotherDCRiderTimeSheetsTab" data-toggle="tab" href="#TransferedToAnotherDCRiderTimeSheets" role="tab" aria-controls="TransferedToAnotherDCRiderTimeSheets" aria-selected="true">Tranfered To Another DC Rider Time Sheets ( {{ $transfered_to_another_dc_count }} )</a>
    </li>
    @endif
    <li class="nav-item">
        @php $ExDcRiderTimeSheets = 0 @endphp
        @forelse ($without_dc_assign_to_dc_rider_time_sheets as $time_sheets)
            @forelse ($time_sheets as $time_sheet)
                @if($loop->first && $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status == 0)
                    @php $ExDcRiderTimeSheets++ @endphp
                @endif
            @empty
            @endforelse
            @empty
        @endforelse
        <a class="nav-link" id="ExDcRiderTimeSheetsTab" data-toggle="tab" href="#ExDcRiderTimeSheets" role="tab" aria-controls="ExDcRiderTimeSheets" aria-selected="true">No DC Rider Time Sheets (
            {{ request('dc_id') ? $ExDcRiderTimeSheets : $without_dc_assign_to_dc_rider_time_sheets->count() }} )</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="ActiveDCRiderTimeSheets" role="tabpanel" aria-labelledby="ActiveDCRiderTimeSheetsTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ActiveDCRiderTimeSheetsTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">Current DC</th>

                        <th class="text-right">Orders</th>
                        <th class="text-right">Deliveries</th>
                        <th class="text-right">Distance</th>
                        <th class="text-right">Total Delivery Pay</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($active_talabat_rider_time_sheets as $time_sheet)
                        <tr>
                            <td>{{ $time_sheet->id }}</td>
                            <td>{{ $time_sheet->rider_platform_code }}</td>
                            <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                            <td>{{ $time_sheet->shift_count ?? 0 }}</td>
                            <td>{{ $time_sheet->no_shows ?? 0 }}</td>
                            <td>{{ gmdate('H:i:s', floor(($time_sheet->total_working_hours ?? 0) * 3600)) }}</td>
                            <td>{{ $time_sheet->total_working_hours ?? 0 }}</td>
                            <td class="text-left" >
                                {{ $time_sheet->passport->assign_to_dcs->where('status', 1)
                                ->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                            </td>
                            <td>{{ $time_sheet->completed_orders }}</td>
                            <td>{{ $time_sheet->cancelled_orders }}</td>
                            <td>{{ $time_sheet->completed_deliveries }}</td>
                        </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($with_dc_assign_to_dc_rider_time_sheets as $time_sheets)
                        @forelse ($time_sheets as $time_sheet)
                            @if($loop->first)
                            <tr>
                                <td>{{ $time_sheet->id }}</td>
                                <td>{{ $time_sheet->platform_code }}</td>
                                <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    {{ $time_sheet->passport->assign_to_dcs->where('status', 1)
                                    ->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                </td>

                                <td class="text-right">{{ $time_sheets->sum('orders') ?? 0 }}</td>
                                <td class="text-right">{{ $time_sheets->sum('deliveries') ?? 0 }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('distance') ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('total_delivery_pay') ?? 0, 2) }}</td>
                            </tr>
                            @endif
                        @empty

                        @endforelse
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(request('dc_id'))
    <div class="tab-pane fade" id="TransferedToAnotherDCRiderTimeSheets" role="tabpanel" aria-labelledby="TransferedToAnotherDCRiderTimeSheetsTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="TransferedToAnotherDCRiderTimeSheetsTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">Transfered To DC</th>

                        <th class="text-right">Orders</th>
                        <th class="text-right">Deliveries</th>
                        <th class="text-right">Distance</th>
                        <th class="text-right">Total Delivery Pay</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($ex_talabat_rider_time_sheets as $time_sheet)
                            <tr>
                                <td>{{ $time_sheet->id }}</td>
                                <td>{{ $time_sheet->rider_platform_code }}</td>
                                <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                                <td>{{ $time_sheet->shift_count ?? 0 }}</td>
                                <td>{{ $time_sheet->no_shows ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($time_sheet->total_working_hours ?? 0) * 3600)) }}</td>
                                <td>{{ $time_sheet->total_working_hours ?? 0 }}</td>
                                <td class="text-left" >
                                    {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $time_sheet->completed_orders }}</td>
                                <td>{{ $time_sheet->cancelled_orders }}</td>
                                <td>{{ $time_sheet->completed_deliveries }}</td>
                            </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($without_dc_assign_to_dc_rider_time_sheets as $time_sheets)
                        @forelse ($time_sheets as $time_sheet)
                            @if($loop->first  && $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->whereNotIn('user_id', request('user_id'))->where('status', 1)->first())
                            <tr>
                                <td>{{ $time_sheet->passport_id }}</td>
                                <td>{{ $time_sheet->platform_code }}</td>
                                <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    {{ $time_sheet->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->whereNotIn('user_id', request('user_id'))
                                    ->where('status', 1)
                                    ->first()->user_detail->name ?? "NA" }}
                                </td>

                                <td class="text-right">{{ $time_sheets->sum('orders') ?? 0 }}</td>
                                <td class="text-right">{{ $time_sheets->sum('deliveries') ?? 0 }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('distance') ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('total_delivery_pay') ?? 0, 2) }}</td>
                            </tr>
                            @endif
                        @empty

                        @endforelse
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="tab-pane fade" id="ExDcRiderTimeSheets" role="tabpanel" aria-labelledby="ExDcRiderTimeSheetsTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ExDcRiderTimeSheetsTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">Previous DC</th>

                        <th class="text-right">Orders</th>
                        <th class="text-right">Deliveries</th>
                        <th class="text-right">Distance</th>
                        <th class="text-right">Total Delivery Pay</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($ex_talabat_rider_time_sheets as $time_sheet)
                            <tr>
                                <td>{{ $time_sheet->id }}</td>
                                <td>{{ $time_sheet->rider_platform_code }}</td>
                                <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                                <td>{{ $time_sheet->shift_count ?? 0 }}</td>
                                <td>{{ $time_sheet->no_shows ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($time_sheet->total_working_hours ?? 0) * 3600)) }}</td>
                                <td>{{ $time_sheet->total_working_hours ?? 0 }}</td>
                                <td class="text-left" >
                                    {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $time_sheet->completed_orders }}</td>
                                <td>{{ $time_sheet->cancelled_orders }}</td>
                                <td>{{ $time_sheet->completed_deliveries }}</td>
                            </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($without_dc_assign_to_dc_rider_time_sheets as $time_sheets)
                        @forelse ($time_sheets as $time_sheet)
                            @if($loop->first && $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status == 0)
                            <tr>
                                <td>{{ $time_sheet->id }}</td>
                                <td>{{ $time_sheet->platform_code }}</td>
                                <td>{{ $time_sheet->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    @if(request('dc_id'))
                                    {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->where('user_id', request('dc_id'))->where('status', 0)->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @else
                                    {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $time_sheet->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @endif
                                </td>
                                <td class="text-right">{{ $time_sheets->sum('orders') ?? 0 }}</td>
                                <td class="text-right">{{ $time_sheets->sum('deliveries') ?? 0 }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('distance') ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($time_sheets->sum('total_delivery_pay') ?? 0, 2) }}</td>
                            </tr>
                            @endif
                        @empty

                        @endforelse
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script>
    tail.DateTime("#start_date",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,
    })
</script>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#ActiveDCRiderTimeSheetsTable, #ExDcRiderTimeSheetsTable, #TransferedToAnotherDCRiderTimeSheetsTable').DataTable( {
            initComplete: function () {
                let filtering_columns = []
                $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                    filtering_columns.push(v.cellIndex)
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
            "aaSorting": [[0, 'asc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'DC Riders',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
        });
    });
</script>
