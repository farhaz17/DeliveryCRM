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
<table class="display table table-striped table-bordered" id="datatable-salik" style="width: 100px">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Company</th>
            <th scope="col">PPUID</th>
            <th scope="col">ZDS Code</th>
            <th scope="col">Transaction Id</th>
            <th scope="col">Trip Date</th>
            <th scope="col">Toll Gate</th>
            <th scope="col">Amount</th>
            <th scope="col">Plate No</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $row)
            <tr>

            <td>{{isset($row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name)?$row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name :"N/A"}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->pp_uid ?$row->bike_detail->get_current_bike->passport->pp_uid :""}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->zds_code->zds_code ?$row->bike_detail->get_current_bike->passport->zds_code->zds_code :""}}</td>
            <td>{{$row->transaction_id}}</td>
            <td>{{$row->trip_date}}</td>
            <td>{{$row->toll_gate}}</td>
            <td>{{$row->amount}}</td>
            <td>{{$row->plate}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>



<script>
    $(document).ready(function () {

        'use strict';

        $('#datatable-salik').DataTable( {
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
