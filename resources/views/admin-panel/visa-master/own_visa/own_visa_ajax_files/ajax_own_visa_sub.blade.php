<table class="table table-striped" id="datatable-{{$current_status}}">
    <thead class="table-dark">
        <tr class="t-row">
            <th>#</th>
            <th>Name</th>
            <th>Passport No</th>
            <th>PPUID</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php $counter=1?>
            @foreach ($own_visa_to_start as $row)

            <tr>
                <td>{{$counter}}</td>
                <td>{{$row->personal_info->full_name}}</td>
                <td>{{$row->passport_no}}</td>
                <td>{{isset($row->pp_uid)?$row->pp_uid:'N/A'}}</td>
                <td><a class="btn btn-primary btn-sm start-visa" href="{{ url('own_visa') }}?passport_id={{ $row->passport_no }}" target="_blank">Start Own Visa Process</a></td>


            </tr>
                <?php $counter++?>

            @endforeach
        </tbody>
</table>
</div>


    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable2').DataTable( {
                "aaSorting": [],
                "pageLength": 10,

            });
        });
    </script>

