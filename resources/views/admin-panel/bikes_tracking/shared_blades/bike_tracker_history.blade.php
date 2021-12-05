<table class="table table-striped table-hover table-sm text-10">
    <thead>
        <tr>
            <th>SL</th>
            <th>Tracker No</th>
            <th>Checked In</th>
            <th>Checked Out</th>
            <th>Type</th>
            <th>Suffled with Tracker</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bike_tracker_history as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->tracker->tracking_no ?? "" }}</td>
                <td>{{ $item->checkin ?? "" }}</td>
                <td>{{ $item->checkout ?? "" }}</td>
                <td>{{ $item->type == 1 ? "Installed" : ( $item->type == 2 ? "Removed" : ( $item->type == 3 ? "Suffled" : "") ) }}</td>
                <td>{{ $item->type == 1 ? "N/A" : ( $item->type == 2 ? "N/A" : ( $item->type == 3 ? $item->previous_tracker->tracking_no : "") ) }}</td>
                <td>{{ $item->remarks ?? "" }}</td>
            </tr>
        @endforeach
    </tbody>
</table>