<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<ul class="nav nav-tabs small" id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="ActiveDCRiderPerformancesTab" data-toggle="tab" href="#ActiveDCRiderPerformances" role="tab" aria-controls="ActiveDCRiderPerformances" aria-selected="true">All Active DC Rider Performances ( {{$with_dc_assign_to_dc_rider_performances->count()}} )</a>
    </li>
    @if (request('dc_id'))
        @php
            $transfered_to_another_dc_count = 0;
        @endphp
        @foreach ($without_dc_assign_to_dc_rider_performances as $performances)
            @foreach ($performances as $performance)
                @if($loop->first  && $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->whereNotIn('user_id', request('user_id'))->where('status', 1)->first())
                    @php
                        $transfered_to_another_dc_count++
                    @endphp
                @endif
            @endforeach
    @endforeach
    <li class="nav-item">
        <a class="nav-link" id="TransferedToAnotherDCRiderPerformancesTab" data-toggle="tab" href="#TransferedToAnotherDCRiderPerformances" role="tab" aria-controls="TransferedToAnotherDCRiderPerformances" aria-selected="true">Tranfered To Another DC Rider Performances ( {{ $transfered_to_another_dc_count }} )</a>
    </li>
    @endif
    <li class="nav-item">
        @php $ExDcRiderPerformances = 0 @endphp
        @forelse ($without_dc_assign_to_dc_rider_performances as $performances)
            @forelse ($performances as $performance)
                @if($loop->first && $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status == 0)
                    @php $ExDcRiderPerformances++ @endphp
                @endif
            @empty
            @endforelse
            @empty
        @endforelse
        <a class="nav-link" id="ExDcRiderPerformancesTab" data-toggle="tab" href="#ExDcRiderPerformances" role="tab" aria-controls="ExDcRiderPerformances" aria-selected="true">No DC Rider Performances (
            {{ request('dc_id') ? $ExDcRiderPerformances : $without_dc_assign_to_dc_rider_performances->count() }} )</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="ActiveDCRiderPerformances" role="tabpanel" aria-labelledby="ActiveDCRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ActiveDCRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th class="filtering_column" style="width: 100px;">Date</th>
                        <th>Rider Id</th>
                        <th>ZDS</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Late Login < 5</th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th class="text-left filtering_column">Current DC</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($with_dc_assign_to_dc_rider_performances as $performances)
                        @forelse ($performances as $performance)
                            @if(request('result_type') == 'single')
                            @if($loop->first)
                                <tr>
                                    <td>{{ $performance->id }}</td>
                                    <td>{{ dateToRead($performance->start_date) }}</td>
                                    <td>{{ $performance->rider_platform_code }}</td>
                                    <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                    <td>{{ $performance->passport->personal_info->full_name }}</td>
                                    <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                    <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                    <td>{{ $performances->last()->late_login_grater_than_five ?? "NA" }}</td>
                                    <td>{{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}</td>
                                    <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                    <td class="text-left" >
                                        {{ $performance->passport->assign_to_dcs->where('status', 1)
                                        ->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                    </td>
                                    <td>{{ $performances->sum('completed_orders') }}</td>
                                    <td>{{ $performances->sum('cancelled_orders') }}</td>
                                    <td>{{ $performances->sum('completed_deliveries') }}</td>
                                </tr>
                                @endif
                            @elseif(request('result_type') == 'multiple')
                                <tr>
                                    <td>{{ $performance->id }}</td>
                                    <td>{{ dateToRead($performance->start_date) }}</td>
                                    <td>{{ $performance->rider_platform_code }}</td>
                                    <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                    <td>{{ $performance->passport->personal_info->full_name }}</td>
                                    <td>{{ $performance->shift_count ?? 0 }}</td>
                                    <td>{{ $performance->no_shows ?? 0 }}</td>
                                    <td>{{ $performance->late_login_grater_than_five ?? "NA" }}</td>
                                    <td>{{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}</td>
                                    <td>{{ $performance->total_working_hours ?? 0 }}</td>
                                    <td class="text-left" >
                                        {{ $performance->passport->assign_to_dcs->where('status', 1)
                                        ->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                    </td>
                                    <td>{{ $performance->completed_orders }}</td>
                                    <td>{{ $performance->cancelled_orders }}</td>
                                    <td>{{ $performance->completed_deliveries }}</td>
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
    <div class="tab-pane fade" id="TransferedToAnotherDCRiderPerformances" role="tabpanel" aria-labelledby="TransferedToAnotherDCRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="TransferedToAnotherDCRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th class="filtering_column" style="width: 100px;">Date</th>
                        <th>Rider Id</th>
                        <th>ZDS</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Late Login<5 </th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th class="text-left filtering_column">Transfered To DC</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($without_dc_assign_to_dc_rider_performances as $performances)
                        @forelse ($performances as $performance)
                            @if(request('result_type') == 'single')
                                @if($loop->first  && $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->whereNotIn('user_id', request('user_id'))->where('status', 1)->first())
                                <tr>
                                    <td>{{ $performance->passport_id }}</td>
                                    <td>{{ dateToRead($performance->start_date) }}</td>
                                    <td>{{ $performance->rider_platform_code }}</td>
                                    <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                    <td>{{ $performance->passport->personal_info->full_name }}</td>
                                    <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                    <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                    <td>{{ $performances->last()->late_login_grater_than_five ?? "NA" }}</td>
                                    <td>{{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}</td>
                                    <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                    <td class="text-left" >
                                        {{ $performance->passport->assign_to_dcs
                                        ->whereIn('platform_id', [15,34,41])
                                        ->whereNotIn('user_id', request('user_id'))
                                        ->where('status', 1)
                                        ->first()->user_detail->name ?? "NA" }}
                                    </td>
                                    <td>{{ $performances->sum('completed_orders') }}</td>
                                    <td>{{ $performances->sum('cancelled_orders') }}</td>
                                    <td>{{ $performances->sum('completed_deliveries') }}</td>
                                </tr>
                                @endif
                            @elseif(request('result_type') == 'multiple')
                            <tr>
                                <td>{{ $performance->passport_id }}</td>
                                <td>{{ dateToRead($performance->start_date) }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performance->shift_count ?? 0 }}</td>
                                <td>{{ $performance->no_shows ?? 0 }}</td>
                                <td>{{ $performance->late_login_grater_than_five ?? "NA" }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->total_working_hours ?? 0 }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->whereNotIn('user_id', request('user_id'))
                                    ->where('status', 1)
                                    ->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performance->completed_orders }}</td>
                                <td>{{ $performance->cancelled_orders }}</td>
                                <td>{{ $performance->completed_deliveries }}</td>
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
    <div class="tab-pane fade" id="ExDcRiderPerformances" role="tabpanel" aria-labelledby="ExDcRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ExDcRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th class="filtering_column" style="width: 100px;">Date</th>
                        <th>Rider Id</th>
                        <th>ZDS</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Late Login<5 </th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th class="text-left filtering_column">Previous DC</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($without_dc_assign_to_dc_rider_performances as $performances)
                        @forelse ($performances as $performance)
                        @if(request('result_type') == 'single')
                            @if($loop->first && $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status == 0)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ dateToRead($performance->start_date) }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                <td>{{ $performances->sum('late_login_grater_than_five') ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                <td class="text-left" >
                                    @if(request('dc_id'))
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->where('user_id', request('dc_id'))->where('status', 0)->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @else
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @endif
                                </td>
                                <td>{{ $performances->sum('completed_orders') }}</td>
                                <td>{{ $performances->sum('cancelled_orders') }}</td>
                                <td>{{ $performances->sum('completed_deliveries') }}</td>
                            </tr>
                            @endif
                        @elseif(request('result_type') == 'multiple')
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ dateToRead($performance->start_date) }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->zds_code->zds_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performance->shift_count ?? 0 }}</td>
                                <td>{{ $performance->no_shows ?? 0 }}</td>
                                <td>{{ $performance->late_login_grater_than_five ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->total_working_hours ?? 0 }}</td>
                                <td class="text-left" >
                                    @if(request('dc_id'))
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->where('user_id', request('dc_id'))->where('status', 0)->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @else
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                    {{-- {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->status ?? "NA" }} --}}
                                    @endif
                                </td>
                                <td>{{ $performance->completed_orders }}</td>
                                <td>{{ $performance->cancelled_orders }}</td>
                                <td>{{ $performance->completed_deliveries }}</td>
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
        $('#ActiveDCRiderPerformancesTable, #ExDcRiderPerformancesTable, #TransferedToAnotherDCRiderPerformancesTable').DataTable( {
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
                    title: 'Riders Performance',
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
