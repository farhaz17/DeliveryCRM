<table class="table table-striped" id="datatable-bikes"  style="width: 100%">
    <thead style="background:rebeccapurple; color:#ffffff;  white-space: nowrap;">
    <tr>
        <th scope="col" style="width: 100px" >Bike Assigned To 4PL</th>
        <th scope="col" style="width: 100px;">Company Name</th>
        <th scope="col" style="width: 100px">Passport No</th>
        <th scope="col" style="width: 100px">PPUID</th>
        <th scope="col" style="width: 100px">ZDS Code</th>
    </tr>
    </thead>
    <tbody>
    @foreach($agreement as $row)
        @if(isset($row->passport->bike_checkin()->bike_plate_number->plate_no))
        <tr>

            <td  style="color:#000; font-weight:bold">
                {{isset($row->passport->bike_checkin()->bike_plate_number->plate_no)?
                ($row->passport->bike_checkin()->bike_plate_number->plate_no) : 'N/A'}}
            </td>
            <td style="color:rebeccapurple; font-weight:bold"> {{$row->fourpl_contractor->name}}</td>
            <td style="color:green; font-weight:bold"> {{isset($row->passport)?$row->passport->passport_no:"N/A"}}</td>
            <td style="color:darkblue; font-weight:bold"> {{isset($row->passport)?$row->passport->pp_uid:"N/A"}}</td>
            <td  style="color:darkred; font-weight:bold"> {{isset($row->passport)?$row->passport->zds_code->zds_code:"N/A"}}</td>


        </tr>
        @endif
    @endforeach


    </tbody>
</table>

<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable-bikes').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,


            "scrollY": true,
            "scrollX": true,

        });
        table.columns.adjust().draw();
    });
</script>
