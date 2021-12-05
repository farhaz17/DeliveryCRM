<table class="table" id="datatable-history" style="width:700px">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Chassis No</th>
        <th scope="col">Plate No</th>
        <th scope="col">Updated At</th>


    </tr>
    </thead>

@foreach($bike_history as $history)
    <tr>
        <td>{{$history->chassis_number->chassis_no}}</td>
        <td>{{$history->plate_no}}</td>
        <td>{{$history->created_at}}</td>


    </tr>
@endforeach
</table>


<script>
    'use strict';

    $('#datatable-history').DataTable( {

        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    });


    </script>
