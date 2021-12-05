<table class="table table-sm table-striped text-11">
    <thead>
      <tr>
          <th scope="col">Called By</th>
          <th scope="col">FeedBack</th>
          <th scope="col">Remarks</th>
          <th scope="col">Time</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($cod_follow_up_calls as $call)
        <tr>
            <th>{{ $call->creator->name ?? "" }}</th>
            <th>
                @if($call->feedback_id == 1) {{ 'Will deposit today' }} @endif
                @if($call->feedback_id == 2) {{ 'Will deposit tomorrow' }} @endif
                @if($call->feedback_id == 3) {{ 'N/A messaged on whatsapp' }} @endif
                @if($call->feedback_id == 4) {{ 'Paid' }} @endif
                @if($call->feedback_id == 5) {{ 'Others specify' }} @endif
            </th>
            <th>{{ $call->remarks ?? "" }}</th>
            <th>{{ $call->created_at->diffForHumans() ?? "" }}</th>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No call record found!</td>
        </tr>
        @endforelse
    </tbody>
  </table>
