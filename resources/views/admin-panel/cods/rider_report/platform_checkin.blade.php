<h4 class="text-center">Platform Checkins Today</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="platformcheckin" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Platform</th>
                <th scope="col">Checkin</th>
            </thead>
            <tbody>
                @foreach ($platform_checkins as $platform_checkin)
                    <tr>
                        <td></td>
                        <td>{{ $platform_checkin->passport->personal_info->full_name}}</td>
                        <td>{{ $platform_checkin->plateformdetail->name}}</td>
                        <td>{{ $platform_checkin->checkin}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        'use strict';
        $('#platformcheckin').DataTable( {
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
                    title: 'Platform Report',
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
