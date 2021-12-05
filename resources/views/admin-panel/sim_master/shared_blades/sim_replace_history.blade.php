<table class="table table-sm table-hover table-striped text-11 data_table_cls" >
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Replaced On</th>
            <th>Sim No</th>
            <th>Serial</th>
            <th>Reason of Replacement</th>
            <th>Paid By</th>
            <th>Paid Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sim_card_history as $history)
        <tr>
            <td>&nbsp;</td>
            <td> {{ $history->created_at ? dateToRead($history->created_at) : '' }} </td>
            <td> {{ $history->sim->account_number ?? '' }} </td>
            <td> {{ $history->sim_sl_no ?? 'N/A' }} </td>
            <td> {{ $history->reason ? get_sim_replace_reason($history->reason) : '' }} </td>
            <td> {{ $history->paid_by ? get_paid_by($history->paid_by) : '' }} </td>
            <td> {{ $history->amount ?? '' }} </td>
        </tr>
        @empty

        @endforelse
    </tbody>
</table>