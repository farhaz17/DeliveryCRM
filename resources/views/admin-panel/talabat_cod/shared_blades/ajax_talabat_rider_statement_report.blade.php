<link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
<div id="statement-holder">
    <div class="row">
        <div class="col-12">
            <div class="responsive">
                <table class="table table-sm text-11 table-hover table-bordered" id="RiderWiseTalabatStatement">
                    <thead>
                        <tr>
                            <th class="filtering_column">Date</th>
                            <th class="text-right">Previous Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Deductions --}}
                        @foreach ($talabat_rider_cod_deductions->sortBy('end_date') as $talabat_rider_cod_deduction)
                        <tr>
                            <td class="text-right">{{ !empty($talabat_rider_cod_deduction) ? dateToRead($talabat_rider_cod_deduction->end_date) : '' }}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right text-danger">Deductions</td>
                            <td class="text-right text-danger">{{ !empty($talabat_rider_cod_deduction) ? number_format($talabat_rider_cod_deduction->deduction , 2) : number_format( 0, 2 )}}</td>
                        </tr>
                        @endforeach
                        @forelse ($talabat_rider_cods->sortBy('end_date') as $talabat_cod)
                            <tr>
                                <td class="text-right">{{ dateToRead($talabat_cod->end_date) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->previous_day_pending ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->current_day_cash_deposit ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->previous_day_balance ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->current_day_adjustment ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->current_day_cod ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->tips ,2) }}</td>
                                <td class="text-right">{{ number_format($talabat_cod->current_day_balance ,2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center bolder">No Cod Record Found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="text-right">{{ count($talabat_rider_cods) > 0 ? dateToRead(\Carbon\Carbon::parse($talabat_rider_cods->first()->end_date)->endOfMonth()) : 'NA' }}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right">Net Balance:</td>
                            <td class="text-right">
                                @php
                                    $cod_balance = count($talabat_rider_cods) > 0 ? $talabat_rider_cods->first()->current_day_balance : 0;
                                    $cod_deductions = !empty($talabat_rider_cod_deduction) ? $talabat_rider_cod_deduction->deduction : 0;
                                    $cod_after_deduction =  number_format(($cod_balance), 2)
                                @endphp
                                {{ $cod_after_deduction }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        'use strict';
        $('#RiderWiseTalabatStatement').DataTable( {
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
            "pageLength": 30,
            "columnDefs": [
                // {"targets": [0],"visible": false},
                {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"} // last column width for all tables
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Rider Wise COD Statement',
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
