<table class="table table-sm table-hover text-11" id="PerformancesTable">
    <thead>
        <tr>
            <th>SL</th>
            <th>Rider Name</th>
            <th>PPUID</th>
            @foreach ($performance_setting->column_settings as $column)
                @if (in_array($column['name'], request('columns')))
                <th class="text-right">{{ $column['label'] }} ( Actual Value )</th>
                <th class="filtering_column">{{ $column['label'] }} ( Result )</th>
                <th class="text-right">{{ $column['label'] }} ( Rating )</th>
                @endif
            @endforeach
            <th class="text-right">Average Rating</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($selected_date_wise_performances as $performance)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $performance->passport->personal_info->full_name ?? "NA" }}</td>
            <td>{{ $performance->passport->pp_uid ?? "NA" }}</td>
            @php
                $total_rating = 0;
                $total_columns = 0;
            @endphp
            @foreach ($performance_setting->column_settings as $column)
                @if (in_array($column['name'], request('columns')))
                <td class="text-right"> {{ $performance[$column['name']] }}</td>
                <td> {{ get_column_performace($column, $performance[$column['name']]) }}</td>
                <td class="text-right"> {{ get_column_result( $performance[$column['name']], $column['highest_value'], $column['lowest_value'])  . " %" }}</td>
                @php
                    $total_rating += get_column_result( $performance[$column['name']], $column['highest_value'], $column['lowest_value']);
                    $total_columns++;
                @endphp
                @endif
            @endforeach
            <td class="text-right">{{ number_format(($total_rating/$total_columns), 2)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function () {
        'use strict';
        $('#PerformancesTable, #RepairingAtGarageBikesTable, #WorkingBikesTable, #NotWorkingBikesTable, #HoldingBikesTable').DataTable( {
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
                // {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"} // last column width for all tables
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Rider Performance Report',
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
