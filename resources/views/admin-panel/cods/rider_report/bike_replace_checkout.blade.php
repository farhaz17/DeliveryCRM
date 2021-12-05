<h4 class="text-center">Bike Replacement Checkouts Today</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="bikecheckin" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Old Bike</th>
                <th scope="col">New Bike</th>
                <th scope="col">Checkout</th>
                <th scope="col">Type</th>
            </thead>
            <tbody>
                @foreach ($bike_replace_checkouts as $bike_replace_checkout)
                    <tr>
                        <td></td>
                        <td>{{ $bike_replace_checkout->passport->personal_info->full_name}}</td>
                        <td>{{ $bike_replace_checkout->permanent_plate_number->plate_no}}</td>
                        <td>{{ $bike_replace_checkout->temporary_plate_number->plate_no}}</td>
                        <td>{{ $bike_replace_checkout->assigncheckout}}</td>
                        @if ($bike_replace_checkout->type == '1')
                            <td>Temporary</td>
                        @elseif ($bike_replace_checkout->type == '2')
                            <td>Permanent</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        'use strict';
        $('#bikecheckin').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Bike Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                'pageLength',
            ],
            "scrollY": false,
        });

    });
</script>
