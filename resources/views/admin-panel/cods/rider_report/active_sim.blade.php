<h4 class="text-center">Actively Working Sim</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="activesim" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Sim</th>
                <th scope="col">Checkin</th>
            </thead>
            <tbody>
                @foreach ($actives as $active)
                    <tr>
                        <td></td>
                        <td>{{ $active->passport->personal_info->full_name}}</td>
                        <td>{{ $active->telecomes->account_number}}</td>
                        <td>{{ $active->assigncheckin}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        'use strict';
        $('#activesim').DataTable( {
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
                    title: 'Sim Report',
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
