<table class="table table-sm table-striped text-11" id="auditsTable">
    <thead>
        <tr>
            <th class="filtering_column">Date</th>
            <th class="filtering_column">User Name</th>
            <th class="filtering_column">Model Name</th>
            <th class="filtering_column">Event Type</th>
            <th>Columns</th>
            <th>Values changed Form</th>
            <th>Values changed to</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($audits as $audit)
        <tr>
            <td>{{ dateToRead($audit->created_at) }}</td>
            <td>{{ $audit->user->name ?? "NA" }}</td>
            <td>{{ $audit->auditable_type ?? "NA" }}</td>
            <td>{{ $audit->event ?? "NA" }}</td>
            <td class="text-right">
                @foreach ($audit->new_values as $key => $value)
                {{ $key }} <br/>
                @endforeach
            </td>
            <td>
                @foreach ($audit->old_values as $key => $value)
                {{ $value }} <br/>
                @endforeach
            </td>
            <td>
                @foreach ($audit->new_values as $key => $value)
                {{ $value }} <br/>
                @endforeach
            </td>
            <td>
                {{ $audit->created_at->diffforhumans() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#auditsTable').DataTable( {
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
                    title: 'Users Activities Report',
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
