@if($type=='1')
    <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">

        <table id="datatable-cod" style="width: 100%">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Slip Number</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Machine Number</th>
                <th scope="col">Machine Location</th>
                <th scope="col">Status</th>

            </tr>
            </thead>
            <tbody>
            @foreach($cod_full_history as $cod)
                <tr>
                    <td>{{ isset($cod->date) ? $cod->date : 'N/A' }}</td>
                    <td>{{ isset($cod->time) ? $cod->time : 'N/A' }}</td>
                    <td>{{ isset($cod->slip_number) ? $cod->slip_number : 'N/A' }}</td>
                    <td>
                        @if($cod->type=='0')

                            <span class="badge badge-info cod-content">Cash</span>
                        @else
                            <span class="badge badge-success cod-content">Bank</span>
                        @endif
                    </td>
                    <td>{{ isset($cod->amount) ? $cod->amount : 'N/A' }}</td>
                    <td>{{ isset($cod->machine_number) ? $cod->machine_number : 'N/A' }}</td>
                    <td>{{ isset($cod->location_at_machine) ? $cod->location_at_machine : 'N/A' }}</td>
                    <td> @if($cod->status=='0')
                            <span class="badge badge-danger cod-content">Pending</span>
                        @elseif($cod->status=='1')
                            <span class="badge badge-success cod-content">Approved</span>
                        @else
                            <span class="badge badge-info cod-content">Rejected</span>

                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="col-sm-2"></div>
    </div>

@else
    <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <table id="datatable-cod" style="width: 100%">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($adj_history as $adj)
                <tr>
                    <td>{{ isset($adj->order_id) ? $adj->order_id : 'N/A'}}</td>
                    <td>{{ isset($adj->amount) ? $adj->amount : 'N/A' }}</td>
                    <td>{{ isset($adj->order_date) ? $adj->order_date : 'N/A' }}</td>
                    <td>
                        @if($adj->status=='0')
                            <span class="badge badge-danger cod-content">Rejected</span>
                        @else
                            <span class="badge badge-success cod-content">Approved</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-2"></div>
    </div>



    @endif
    <script>


        $('#datatable-cod').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
        });
    </script>
