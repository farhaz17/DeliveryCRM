<table class="table" id="datatable_ab">
    <thead class="thead-dark">

    <tr style="display: none;">
        <th colspan="5"><b>{{ $full_name }}</b></th>
    </tr>
    <tr style="display: none;">
        <th colspan="5"></th>
    </tr>

    <tr>
        <th scope="col"><b>Date</b></th>
        <th scope="col"><b>Type</b></th>
        <th scope="col"><b>Debit</b></th>
        <th scope="col"><b>Credit</b></th>
        <th scope="col"><b>Balance</b></th>
    </tr>
    </thead>
    <tbody>
    <?php $balance = 0; ?>


    @if(!empty($prev_amount_date))
        <tr>
            <td>{{ $prev_amount_date }}</td>
            <td>{{ "Previous COD" }}</td>
            <td>&nbsp;</td>
            <td>{{ $prev_amount }}</td>
            <?php $balance = $balance+$prev_amount; ?>
            <td>{{ number_format($balance,2) }}</td>
        </tr>
    @endif

    @foreach($array_to_send as $cod)

        @if($cod['cod_type']=="uploads")
            <tr>
                <td>{{ $cod['cod_date'] }}</td>
                <td>{{ $cod['type'] }}</td>
                <td>&nbsp;</td>
                <td>{{ $cod['cod_amount'] }}</td>
                <?php $balance = $balance+$cod['cod_amount']; ?>
                <td>{{ number_format($balance,2) }}</td>
            </tr>
        @elseif($cod['cod_type']=="cods")
            <tr>
                <td>{{ $cod['cod_date'] }}</td>
                <td>{{ $cod['type'] }}</td>
                <td>{{  $cod['cod_amount'] }}</td>
                <td>&nbsp;</td>
                <?php $balance = $balance-$cod['cod_amount']; ?>
                <td>{{ number_format($balance,2) }}</td>
            </tr>
        @elseif($cod['cod_type']=="adjust")
            <tr>
                <td>{{ $cod['cod_date'] }}</td>
                <td>{{ $cod['type'] }}</td>
                <td>{{  $cod['cod_amount'] }}</td>
                <td>&nbsp;</td>
                <?php $balance = $balance-$cod['cod_amount']; ?>
                <td>{{ number_format($balance,2) }}</td>
            </tr>
        @elseif($cod['cod_type']=="close_month")
            <tr>
                <td>{{ $cod['cod_date'] }}</td>
                <td>{{ $cod['type'] }}</td>
                <td>{{  $cod['cod_amount'] }}</td>
                <td>&nbsp;</td>
                <?php $balance = $balance-$cod['cod_amount']; ?>
                <td>{{ number_format($balance,2) }}</td>
            </tr>

        @endif

    @endforeach
    </tbody>
</table>
