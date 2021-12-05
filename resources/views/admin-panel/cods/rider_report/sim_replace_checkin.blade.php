<h4 class="text-center">Sim Replacement Checkins Today</h4>
<div class="row">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="simreplacecheckin" style="width:100%;">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Name</th>
                <th scope="col">Old Sim</th>
                <th scope="col">New Sim</th>
                <th scope="col">Checkin</th>
                <th scope="col">Type</th>
            </thead>
            <tbody>
                @foreach ($sim_replace_checkins as $sim_replace_checkin)
                    <tr>
                        <td></td>
                        <td>{{ $sim_replace_checkin->passport->personal_info->full_name}}</td>
                        <td>{{ $sim_replace_checkin->permanent_plate_number->account_number}}</td>
                        <td>{{ $sim_replace_checkin->temporary_plate_number->account_number}}</td>
                        <td>{{ $sim_replace_checkin->replace_checkin}}</td>
                        @if ($sim_replace_checkin->type == '1')
                            <td>Temporary</td>
                        @elseif ($sim_replace_checkin->type == '2')
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
        $('#simreplacecheckin').DataTable( {
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
