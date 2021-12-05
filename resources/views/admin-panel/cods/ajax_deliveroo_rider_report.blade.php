@if ($record == 'no records')
<div id="statement-holder">
    <div class="row">
        <div class="col-12">
            <div class="responsive">
                <table class="table table-sm text-11 table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>Date</b></th>
                            <th scope="col"><b>Type</b></th>
                            <th scope="col"><b>Debit</b></th>
                            <th scope="col"><b>Credit</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center bolder">No Cod Record Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div id="statement-holder">
    <div class="row">
        <div class="col-12">
            <h4 class="text-center mt-3 font-weight-bold">{{ $plate->full_name }}</h4><br>
            <div class="responsive">
                <table class="table table-sm text-11 table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>Date</b></th>
                            <th scope="col"><b>Type</b></th>
                            <th scope="col"><b>Debit</b></th>
                            <th scope="col"><b>Credit</b></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                            @if (isset($transaction->start_date))
                                <td>Cod Upload</td>
                            @elseif (isset($transaction->order_date))
                                <td>Cod Adjustment</td>
                            @elseif (isset($transaction->close_month_amount))
                                <td>Close Month</td>
                            @elseif (isset($transaction->type))
                                @if ($transaction->type == '0')
                                    <td>Cash</td>
                                @elseif($transaction->type == '1')
                                    <td>Bank</td>
                                @endif
                            @else
                                <td></td>
                            @endif
                            @if (isset($transaction->order_date) )
                                <td>{{ $transaction->amount }}</td>
                            @elseif (isset($transaction->close_month_amount))
                                <td>{{ $transaction->close_month_amount }}</td>
                            @elseif (isset($transaction->type))
                                <td>{{ $transaction->amount }}</td>
                            @else
                                <td></td>
                            @endif
                            @if (isset($transaction->start_date))
                                <td>{{ $transaction->amount }}</td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"><b><span style="font-size: 15px">Balance</span></b></td>
                            <td class="text-left"><b><span style="font-size: 15px">{{ number_format($remain_amount,2) }}</span></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

