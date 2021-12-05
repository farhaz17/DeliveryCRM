<table class="table table-striped" id="datatable-sim"  style="width: 100%">
    <thead style="background:#f44336; color:#ffffff;  white-space: nowrap;" >
    <tr>
        <th scope="col" style="width: 100px: white-space:no">SIM Assigned To 4PL</th>
        <th scope="col" style="width: 100px">Company Name</th>
        <th scope="col" style="width: 100px">Passport No</th>
        <th scope="col" style="width: 100px">PPUID</th>
        <th scope="col" style="width: 100px">ZDS Code</th>




    </tr>
    </thead>
    <tbody>
    @foreach($agreement as $row)
        @if(isset($row->passport->sim_checkin()->telecome->account_number))
            <tr>

                <td style="color:#000000; font-weight:bold">
                    {{isset($row->passport->sim_checkin()->telecome->account_number)?
                    ($row->passport->sim_checkin()->telecome->account_number) : 'N/A'}}
                </td>
                <td style="color:rebeccapurple; font-weight:bold"> {{$row->fourpl_contractor->name}}</td>
                <td style="color:green; font-weight:bold"> {{isset($row->passport)?$row->passport->passport_no:"N/A"}}</td>
                <td style="color:darkblue; font-weight:bold"> {{isset($row->passport)?$row->passport->pp_uid:"N/A"}}</td>
                <td style="color:darkred; font-weight:bold"> {{isset($row->passport)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                {{--                    <td>{{isset($row->passport->sim_checkin()->telecome->account_number) ? ($row->passport->sim_checkin()->telecome->account_number) : 'N/A'}}</td>--}}
                {{--                    --}}{{--------------------------------------------------------------------------------------}}



            </tr>
        @endif
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
