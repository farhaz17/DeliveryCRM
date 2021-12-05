<h4 class="text-center">Bike Checkouts Today</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="bikecheckout" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Bike</th>
                <th scope="col">Checkout</th>
            </thead>
            <tbody>
                @foreach ($bike_checkouts as $bike_checkout)
                    <tr>
                        <td></td>
                        <td>{{ $bike_checkout->passport->personal_info->full_name}}</td>
                        <td>{{ $bike_checkout->bike_plate_number->plate_no}}</td>
                        <td>{{ $bike_checkout->assigncheckout}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        'use strict';
        $('#bikecheckout').DataTable( {
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
