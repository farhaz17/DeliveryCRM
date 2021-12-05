<table class="table table-sm table-striped text-11">
    <thead>
      <tr>
          <th scope="col">Called By</th>
          <th scope="col">Status</th>
          <th scope="col">Remarks</th>
          <th scope="col">Time</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($follow as $call)
        <tr>
            <th>{{ $call->user->name ?? "" }}</th>
            <th>{{ $call->followup->name ?? "" }}</th>
            <th>{{ $call->remarks ?? "" }}</th>
            <th>{{ $call->created_at->diffForHumans() ?? "" }}</th>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No record found!</td>
        </tr>
        @endforelse
    </tbody>
</table>
