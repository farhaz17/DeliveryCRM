<style>

    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }
</style>
<table class="display table table-striped table-bordered" id="datatable" style="width: 100px">
    <thead class="thead-dark">
    <tr>
{{--        <th scope="col">Company</th>--}}
        <th scope="col">Company</th>
        <th scope="col">PPUID</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">Plate number</th>
        <th scope="col">Ticket Number</th>
        <th scope="col">Ticket Date</th>
        <th scope="col">Ticket Time</th>
        <th scope="col">Fine Source</th>
        <th scope="col">Ticket Fee</th>
        <th scope="col">Offense</th>
        <th scope="col">Plate Category</th>
        <th scope="col">plate Code</th>
        <th scope="col">license number</th>
        <th scope="col">license from</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{isset($row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name)?$row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name :"N/A"}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->pp_uid ?$row->bike_detail->get_current_bike->passport->pp_uid :""}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->zds_code->zds_code ?$row->bike_detail->get_current_bike->passport->zds_code->zds_code :""}}</td>
            <td>{{isset($row->plate_number)?$row->plate_number:"N/A"}}</td>
            <td>{{isset($row->ticket_number)?$row->ticket_number:"N/A"}}</td>
            <td>{{isset($row->ticket_date)?$row->ticket_date:"N/A"}}</td>
            <td>{{isset($row->ticket_time)?$row->ticket_time:"N/A"}}</td>
            <td>{{isset($row->fines_source)?$row->fines_source:"N/A"}}</td>
            <td>{{isset($row->ticket_fee)?$row->ticket_fee:"N/A"}}</td>
            <td>{{isset($row->offense)?$row->offense:"N/A"}}</td>
            <td>{{isset($row->plate_cateogry)?$row->plate_cateogry:"N/A"}}</td>
            <td>{{isset($row->plate_code)?$row->plate_code:"N/A"}}</td>
            <td>{{isset($row->license_number)?$row->license_number:"N/A"}}</td>
            <td>{{isset($row->license_from)?$row->license_from:"N/A"}}</td>
        </tr>
    @endforeach

    </tbody>
</table>



<script>
    $(document).ready(function () {

        'use strict';

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all'

                        }

                    }
                },
                'pageLength',
            ],
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });

    });





</script>
