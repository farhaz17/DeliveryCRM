<table class="table table-striped" id="datatable-sim"  style="width: 100%">
    <thead style="background:#f44336; color:#ffffff;  white-space: nowrap;" >
    <tr>
        <th scope="col" style="width: 100px: white-space:no">DC Name</th>
        <th scope="col" style="width: 100px">Number of 4 PL Riders</th>
    </tr>
    </thead>
    <tbody>
    @foreach($user_info as $row)

            <tr>
                <td style="color:rebeccapurple; font-weight:bold"> {{$row->user_detail->name}}</td>
                <td style="color:green; font-weight:bold"> {{isset($row->total)?$row->total:"N/A"}}</td>

            </tr>

    @endforeach


    </tbody>
</table>

<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable-sim').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,


            "scrollY": true,
            "scrollX": true,

        });
        table.columns.adjust().draw();
    });
</script>
