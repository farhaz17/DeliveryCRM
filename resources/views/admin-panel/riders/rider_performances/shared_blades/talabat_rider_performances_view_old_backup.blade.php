<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<ul class="nav nav-tabs small" id="myTab" role="tablist">
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link active" id="TalabatRiderPerformancesTab" data-toggle="tab" href="#TalabatRiderPerformances" role="tab" aria-controls="TalabatRiderPerformances" aria-selected="true">All Performances ( {{$all_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="ActiveTalabatRiderPerformancesTab" data-toggle="tab" href="#ActiveTalabatRiderPerformances" role="tab" aria-controls="ActiveTalabatRiderPerformances" aria-selected="true">All Active Talabat Rider Performances ( {{$active_talabat_rider_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="ExTalabatRiderPerformancesTab" data-toggle="tab" href="#ExTalabatRiderPerformances" role="tab" aria-controls="ExTalabatRiderPerformances" aria-selected="true">All Ex Talabat Rider Performances ( {{$ex_talabat_rider_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="NoTalabatRiderPerformancesTab" data-toggle="tab" href="#NoTalabatRiderPerformances" role="tab" aria-controls="NoTalabatRiderPerformances" aria-selected="true">All No Talabat / No DC Rider Performances ( {{$no_talabat_rider_performances->count()}} )</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="TalabatRiderPerformances" role="tabpanel" aria-labelledby="TalabatRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="TalabatRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($all_performances as $performance)
                        <tr>
                            <td>{{ $performance->id }}</td>
                            <td>{{ $performance->rider_platform_code }}</td>
                            <td>{{ $performance->passport->personal_info->full_name }}</td>
                            <td>{{ $performance->shift_count ?? 0 }}</td>
                            <td>{{ $performance->no_shows ?? 0 }}</td>
                            <td>
                                {{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}
                            </td>
                            <td>{{ $performance->total_working_hours }}</td>
                            <td>{{ $performance->completed_orders }}</td>
                            <td>{{ $performance->cancelled_orders }}</td>
                            <td>{{ $performance->completed_deliveries }}</td>
                        </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($all_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                <td>
                                    {{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}
                                </td>
                                <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                <td>{{ $performances->sum('completed_orders') }}</td>
                                <td>{{ $performances->sum('cancelled_orders') }}</td>
                                <td>{{ $performances->sum('completed_deliveries') }}</td>
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
    <div class="tab-pane fade" id="ActiveTalabatRiderPerformances" role="tabpanel" aria-labelledby="ActiveTalabatRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ActiveTalabatRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th class="text-left filtering_column">DC</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($active_talabat_rider_performances as $performance)
                        <tr>
                            <td>{{ $performance->id }}</td>
                            <td>{{ $performance->rider_platform_code }}</td>
                            <td>{{ $performance->passport->personal_info->full_name }}</td>
                            <td>{{ $performance->shift_count ?? 0 }}</td>
                            <td>{{ $performance->no_shows ?? 0 }}</td>
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
                    @empty

                    @endforelse --}}
                    @forelse ($active_talabat_rider_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
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
                        @empty

                        @endforelse
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="ExTalabatRiderPerformances" role="tabpanel" aria-labelledby="ExTalabatRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ExTalabatRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th class="text-left filtering_column">DC</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($ex_talabat_rider_performances as $performance)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performance->shift_count ?? 0 }}</td>
                                <td>{{ $performance->no_shows ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->total_working_hours ?? 0 }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performance->completed_orders }}</td>
                                <td>{{ $performance->cancelled_orders }}</td>
                                <td>{{ $performance->completed_deliveries }}</td>
                            </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($ex_talabat_rider_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [15,34,41])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performances->sum('completed_orders') }}</td>
                                <td>{{ $performances->sum('cancelled_orders') }}</td>
                                <td>{{ $performances->sum('completed_deliveries') }}</td>
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
    <div class="tab-pane fade" id="NoTalabatRiderPerformances" role="tabpanel" aria-labelledby="NoTalabatRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="NoTalabatRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th>Shift Count</th>
                        <th>No Shows</th>
                        <th>Hrs Worked</th>
                        <th>Days Worked</th>
                        <th>Completed Orders</th>
                        <th>Cancelled Orders</th>
                        <th>Completed Deliveries</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($no_talabat_rider_performances as $performance)
                        <tr>
                            <td>{{ $performance->id }}</td>
                            <td>{{ $performance->rider_platform_code }}</td>
                            <td>{{ $performance->passport->personal_info->full_name }}</td>
                            <td>{{ $performance->shift_count ?? 0 }}</td>
                            <td>{{ $performance->no_shows ?? 0 }}</td>
                            <td>{{ gmdate('H:i:s', floor(($performance->total_working_hours ?? 0) * 3600)) }}</td>
                            <td>{{ $performance->total_working_hours ?? 0 }}</td>
                            <td>{{ $performance->completed_orders }}</td>
                            <td>{{ $performance->cancelled_orders }}</td>
                            <td>{{ $performance->completed_deliveries }}</td>
                        </tr>
                    @empty

                    @endforelse --}}
                    @forelse ($no_talabat_rider_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performances->sum('shift_count') ?? 0 }}</td>
                                <td>{{ $performances->sum('no_shows') ?? 0 }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('total_working_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performances->where('total_working_hours', '>', 0)->count('total_working_hours') ?? 0 }}</td>
                                <td>{{ $performances->sum('completed_orders') }}</td>
                                <td>{{ $performances->sum('cancelled_orders') }}</td>
                                <td>{{ $performances->sum('completed_deliveries') }}</td>
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
    .on("change", function(){
        tail.DateTime("#end_date",{
            dateStart: $('#start_date').val(),
            dateFormat: "YYYY-mm-dd",
            timeFormat: false
        }).reload();
    });
</script>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#TalabatRiderPerformancesTable, #ActiveTalabatRiderPerformancesTable, #ExTalabatRiderPerformancesTable, #NoTalabatRiderPerformancesTable').DataTable( {
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
