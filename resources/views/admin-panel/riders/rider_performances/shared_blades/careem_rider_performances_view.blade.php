<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<ul class="nav nav-tabs small" id="myTab" role="tablist">
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link active" id="CareemRiderPerformancesTab" data-toggle="tab" href="#CareemRiderPerformances" role="tab" aria-controls="CareemRiderPerformances" aria-selected="true">All Performances ( {{$all_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="ActiveCareemRiderPerformancesTab" data-toggle="tab" href="#ActiveCareemRiderPerformances" role="tab" aria-controls="ActiveCareemRiderPerformances" aria-selected="true">All Active Careem Rider Performances ( {{$active_careem_rider_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="ExCareemRiderPerformancesTab" data-toggle="tab" href="#ExCareemRiderPerformances" role="tab" aria-controls="ExCareemRiderPerformances" aria-selected="true">All Ex Careem Rider Performances ( {{$ex_careem_rider_performances->count()}} )</a>
    </li>
    <li class="nav-item">
        {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
        <a class="nav-link" id="NoCareemRiderPerformancesTab" data-toggle="tab" href="#NoCareemRiderPerformances" role="tab" aria-controls="NoCareemRiderPerformances" aria-selected="true">All No Careem / No DC Rider Performances ( {{$no_careem_rider_performances->count()}} )</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="CareemRiderPerformances" role="tabpanel" aria-labelledby="CareemRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="CareemRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">DC</th>
                        <th>Trips</th>
                        <th>Earnings</th>
                        <th>Available Hrs</th>
                        <th>Average Rate</th>
                        <th>Acceptance Rate</th>
                        <th>Completed Trips</th>
                        <th>Cash Collected</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs->where('status', 1)
                                    ->whereIn('platform_id', [1, 32])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performance->trips }}</td>
                                <td>{{ $performance->earnings }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('available_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->average_rating }}</td>
                                <td>{{ $performance->acceptance_rate }}</td>
                                <td>{{ $performance->completed_trips }}</td>
                                <td>{{ $performance->cash_collected }}</td>
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
    <div class="tab-pane fade" id="ActiveCareemRiderPerformances" role="tabpanel" aria-labelledby="ActiveCareemRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ActiveCareemRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">DC</th>
                        <th>Trips</th>
                        <th>Earnings</th>
                        <th>Available Hrs</th>
                        <th>Average Rate</th>
                        <th>Acceptance Rate</th>
                        <th>Completed Trips</th>
                        <th>Cash Collected</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs->where('status', 1)
                                    ->whereIn('platform_id', [1, 32])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performance->trips }}</td>
                                <td>{{ $performance->earnings }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('available_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->average_rating }}</td>
                                <td>{{ $performance->acceptance_rate }}</td>
                                <td>{{ $performance->completed_trips }}</td>
                                <td>{{ $performance->cash_collected }}</td>
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
    <div class="tab-pane fade" id="ExCareemRiderPerformances" role="tabpanel" aria-labelledby="ExCareemRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="ExCareemRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th class="text-left filtering_column">DC</th>
                        <th>Trips</th>
                        <th>Earnings</th>
                        <th>Available Hrs</th>
                        <th>Average Rate</th>
                        <th>Acceptance Rate</th>
                        <th>Completed Trips</th>
                        <th>Cash Collected</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td class="text-left" >
                                    {{ $performance->passport->assign_to_dcs->whereIn('platform_id', [32, 1])->first()->user_detail->name ?? "NA" }}
                                </td>
                                <td>{{ $performance->trips }}</td>
                                <td>{{ $performance->earnings }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('available_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->average_rating }}</td>
                                <td>{{ $performance->acceptance_rate }}</td>
                                <td>{{ $performance->completed_trips }}</td>
                                <td>{{ $performance->cash_collected }}</td>
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
    <div class="tab-pane fade" id="NoCareemRiderPerformances" role="tabpanel" aria-labelledby="NoCareemRiderPerformancesTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="NoCareemRiderPerformancesTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Rider Id</th>
                        <th>Rider Name</th>
                        <th>Trips</th>
                        <th>Earnings</th>
                        <th>Available Hrs</th>
                        <th>Average Rate</th>
                        <th>Acceptance Rate</th>
                        <th>Completed Trips</th>
                        <th>Cash Collected</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_performances as $performances)
                        @forelse ($performances as $performance)
                            @if($loop->first)
                            <tr>
                                <td>{{ $performance->id }}</td>
                                <td>{{ $performance->rider_platform_code }}</td>
                                <td>{{ $performance->passport->personal_info->full_name }}</td>
                                <td>{{ $performance->trips }}</td>
                                <td>{{ $performance->earnings }}</td>
                                <td>{{ gmdate('H:i:s', floor(($performances->sum('available_hours') ?? 0) * 3600)) }}</td>
                                <td>{{ $performance->average_rating }}</td>
                                <td>{{ $performance->acceptance_rate }}</td>
                                <td>{{ $performance->completed_trips }}</td>
                                <td>{{ $performance->cash_collected }}</td>
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
        $('#CareemRiderPerformancesTable, #ActiveCareemRiderPerformancesTable, #ExCareemRiderPerformancesTable, #NoCareemRiderPerformancesTable').DataTable( {
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
