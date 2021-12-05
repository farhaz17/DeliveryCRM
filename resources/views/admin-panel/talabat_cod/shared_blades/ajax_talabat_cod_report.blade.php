    <ul class="nav nav-tabs small" id="myTab" role="tablist">
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link active" id="AllSelectedDateCodsTab" data-toggle="tab" href="#AllSelectedDateCods" role="tab" aria-controls="AllSelectedDateCods" aria-selected="true">All Cods ( {{$cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="ActiveTalabatRiderCodsTab" data-toggle="tab" href="#ActiveTalabatRiderCods" role="tab" aria-controls="ActiveTalabatRiderCods" aria-selected="true">All Active Talabat Rider Cods ( {{$active_talabat_rider_cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="ExTalabatRiderCodsTab" data-toggle="tab" href="#ExTalabatRiderCods" role="tab" aria-controls="ExTalabatRiderCods" aria-selected="true">All Ex Talabat Rider Cods ( {{$ex_talabat_rider_cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="NoTalabatRiderCodsTab" data-toggle="tab" href="#NoTalabatRiderCods" role="tab" aria-controls="NoTalabatRiderCods" aria-selected="true">All No Talabat / No DC Rider Cods ( {{$no_talabat_rider_cods->count()}} )</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="AllSelectedDateCods" role="tabpanel" aria-labelledby="AllSelectedDateCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="AllSelectedDateCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                                <th class="text-right">Cash Received</th>
                                <th class="text-right">Bank Received</th>
                                <th class="text-right">Net Balance</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                                @php
                                    $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                    $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                    $net_balance = $cod->current_day_balance - ($cash + $bank);
                                @endphp
                                <td class="text-right" >{{ number_format($cash ,2) }}</td>
                                <td class="text-right" >{{ number_format($bank ,2) }}</td>
                                <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="ActiveTalabatRiderCods" role="tabpanel" aria-labelledby="ActiveTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="ActiveTalabatRiderCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left filtering_column">DC Name</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                                <th class="text-right">Cash Received</th>
                                <th class="text-right">Bank Received</th>
                                <th class="text-right">Net Balance</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($active_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >
                                {{
                                    $cod->passport->assign_to_dcs
                                    ->where('status', 1)
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                    ??
                                    $cod->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                }}
                            </td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                                @php
                                    $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                    $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                    $net_balance = $cod->current_day_balance - ($cash + $bank);
                                @endphp
                                <td class="text-right" >{{ number_format($cash ,2) }}</td>
                                <td class="text-right" >{{ number_format($bank ,2) }}</td>
                                <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="ExTalabatRiderCods" role="tabpanel" aria-labelledby="ExTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="ExTalabatRiderCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left filtering_column">DC</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ex_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >
                                {{
                                    $cod->passport->assign_to_dcs
                                    ->where('status', 1)
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                    ??
                                    $cod->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                }}
                            </td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="NoTalabatRiderCods" role="tabpanel" aria-labelledby="NoTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="NoTalabatRiderCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($no_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script>
    $('.follow_up_btn').click(function(){
        $('#rider_id').text($(this).attr('data-rider_id'))
        $('#rider_name').text($(this).attr('data-rider_name'))
        $('#rider_ppuid').text($(this).attr('data-rider_ppuid'))
        $('#rider_zds').text($(this).attr('data-rider_zds'))
        $('#rider_phone').text($(this).attr('data-rider_phone'))
        $('#passport_id').val($(this).attr('data-passport_id'))
        $('#talabat_cod_id').val($(this).attr('data-talabat_cod_id'))
    });
</script>
<script>
    $('#follow_up_save_btn').click(function(){
        // To be continued
    })
</script>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#AllSelectedDateCodsTable, #ActiveTalabatRiderCodsTable, #ExTalabatRiderCodsTable, #NoTalabatRiderCodsTable').DataTable({
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
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'City Wise Talabat COD Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
        });
    });
</script>
