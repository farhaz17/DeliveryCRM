<table class="display table table-striped table-bordered table-sm text-10" id="datatable-{{$master_id}}">
    <thead>
    <tr class="t-row">
        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
        <th scope="col">Payment Status</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>

        @foreach($data as $res)
        <?php $passport_no=$res['passport_id'] ?>
        <tr>
            <td>{{$res['name']}}</td>
            <td>{{$res['pass_no']}}</td>
            <td>{{$res['pp_uid']}}</td>
            <td>
                @if ($res['payment_status']=='Paid')
                <span class="badge badge-success m-2 font-weight-bold">{{$res['payment_status']}}</span>
                @elseif($res['payment_status']=='Payroll Deduction')
                <span class="badge badge-warning m-2 font-weight-bold">{{$res['payment_status']}}</span>
                @elseif($res['payment_status']=='Unpaid')
                <span class="badge badge-danger m-2 font-weight-bold">{{$res['payment_status']}}</span>

                @else
                <span class="badge badge-primary m-2 font-weight-bold">{{$res['payment_status']}}</span>
                @endif
               </td>

                <td><a class="btn btn-primary btn-sm start-visa" href="{{ url('visa_process') }}?passport_id={{ $passport_no }}" target="_blank">
                @if($res['current_status']=='27')
                View Complete Detail
                @else
                Start Visa Process
                @endif

                </a></td>

        </tr>
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

