



        <table class="display table" id="datatable">
            <thead class="thead-dark">
            <tr class="show-table">
                <th scope="col" >Rider ID</th>
                <th scope="col" >Rider Name</th>
                <th scope="col">Hours Scheduled</th>
                <th scope="col">Hours Worked</th>
                <th scope="col">Attendance</th>
                <th scope="col">No of orders delivered</th>
                <th scope="col">No of orders unassignedr</th>
                <th scope="col">Unassigned</th>
                <th scope="col">Wait time at customer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deliveroo as $del)
                <tr>
                    <td> {{$del->rider_id}}</td>
                    <td> {{$del->rider_name}}</td>
                    <td> {{$del->hours_scheduled}}</td>
                    <td> {{$del->hours_worked}}</td>
                    <td> {{$del->attendance}}</td>
                    <td> {{$del->no_of_orders_delivered}}</td>
                    <td> {{$del->no_of_orders_unassignedr}}</td>
                    <td> {{$del->unassigned}}</td>
                    <td> {{$del->wait_time_at_customer}}</td>

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
            "columnDefs": [

                {"targets": [0],"width": "30%"}
            ],
            "scrollY": false,
        });
    });

</script>
