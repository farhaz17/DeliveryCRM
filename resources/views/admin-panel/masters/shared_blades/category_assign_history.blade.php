<div class="responsive">
    <table class="table table-sm table-hover table-striped text-11">
        <thead>
            <tr>
                <td>SL</td>
                <td>Date</td>
                <td>Rider Name</td>
                <td>Updated By</td>
                <td>Main Category</td>
                <td>Sub Category</td>
                <td>Common Status</td>
                <td>Created</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($histories as $history)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ dateToRead($history->created_at) }}</td>
                <td>{{ $history->passport->personal_info->full_name }}</td>
                <td>{{ $history->user->name ?? "" }}</td>
                <td>{{ $history->main_cate->name ?? 'N/A' }}</td>
                <td>{{ $history->sub_cate1->name ?? 'N/A' }}</td>
                <td>{{ ucFirst(config('common_statuses')->where('id', $history->common_status_id)->first()['name'] ?? "NA")}}</td>
                <td>{{ $history->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No Record found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
