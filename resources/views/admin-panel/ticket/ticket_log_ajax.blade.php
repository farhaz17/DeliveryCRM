<table class="table table_log" id="datatable_ab">
    <thead class="thead-dark">

    <tr style="display: none;">
        <th colspan="5"></th>
    </tr>

    <tr>
        <th scope="col"><b>Date</b></th>
        <th scope="col"><b>Type</b></th>
        <th scope="col"><b>From</b></th>
        <th scope="col"><b>To</b></th>
        <th scope="col"><b>Assigned/Share By</b></th>
    </tr>
    </thead>
    <tbody>

    @foreach($array_to_send as $ab)

        @if($ab['type']=="Department")
        <tr>
            <td>{{ $ab['date'] }}</td>
            <td>{{ $ab['type'] }}</td>
            <td>{{ $ab['from_department'] }}</td>
            <td>{{ $ab['to_department'] }}</td>
            <td>{{ $ab['assigned_by'] }}</td>
        </tr>
        @else

            <tr>
                <td>{{ $ab['date'] }}</td>
                <td>{{ $ab['type'] }}</td>
                <td>N/A</td>
                <td>{{ $ab['share_to'] }}</td>
                <td>{{ $ab['share_from'] }}</td>
            </tr>


        @endif

    @endforeach

    </tbody>
</table>
