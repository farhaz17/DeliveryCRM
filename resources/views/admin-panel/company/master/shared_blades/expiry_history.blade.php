<div class="row">
    <table class="table table-sm table-hover text-11 m-3">
        <thead>
            <tr>
                <th>Updated On</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($renewals as $item)
            <tr>
                <td>{{ date( 'Y-d-m', strtotime($item->created_at))}}</td>
                <td>{{ $item->issue_date ?? '' }}</td>
                <td>{{ $item->expiry_date ?? '' }}</td>
                <td>{{ $item->remarks ?? '' }}</td>
            </tr>
            @empty
                
            @endforelse
        </tbody>
    </table>
</div>