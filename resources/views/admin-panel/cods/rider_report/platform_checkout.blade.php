<h4 class="text-center">Platform Checkouts Today</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="platformcheckout" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Platform</th>
                <th scope="col">Checkout</th>
            </thead>
            <tbody>
                @foreach ($platform_checkouts as $platform_checkout)
                    <tr>
                        <td></td>
                        <td>{{ $platform_checkout->passport->personal_info->full_name}}</td>
                        <td>{{ $platform_checkout->plateformdetail->name}}</td>
                        <td>{{ $platform_checkout->checkout}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        'use strict';
        $('#platformcheckout').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });

    });
</script>
