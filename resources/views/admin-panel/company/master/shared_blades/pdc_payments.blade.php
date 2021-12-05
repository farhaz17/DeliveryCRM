<table class="table table-sm table-hover text-11">
    <thead>
        <tr>
            <th>#SL</th>
            <th>Check No</th>
            <th>Account Name</th>
            <th>Account No</th>
            <th>PDC Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @php $pdc_payments = json_decode($ejari->pdc_check_no) @endphp
        @forelse ($pdc_payments as $key => $pdc_payment)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ json_decode($ejari->pdc_check_no)[$key] }}</td>
                <td>{{ json_decode($ejari->pdc_company_account_name)[$key] }}</td>
                <td>{{ json_decode($ejari->pdc_company_account_no)[$key] }}</td>
                <td>{{ json_decode($ejari->pdc_date)[$key] }}</td>
                <td>{{ json_decode($ejari->pdc_amount)[$key] }}</td>
            </tr>
        @empty

        @endforelse
    </tbody>
</table>