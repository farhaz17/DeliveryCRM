<?php $balance = 0; ?>


@if(!empty($prev_amount_date))
    <tr>
        <td>{{ $prev_amount_date }}</td>
        <td>{{ "Previous COD" }}</td>
        <td>&nbsp;</td>
        <td>{{ $prev_amount }}</td>
        <?php $balance = $balance+$prev_amount; ?>
        <td>{{ $balance }}</td>
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
            <td>{{ $balance }}</td>
        </tr>
    @elseif($cod['cod_type']=="cods")
        <tr>
            <td>{{ $cod['cod_date'] }}</td>
            <td>{{ $cod['type'] }}</td>
            <td>{{  $cod['cod_amount'] }}</td>
            <td>&nbsp;</td>
            <?php $balance = $balance-$cod['cod_amount']; ?>
            <td>{{ $balance }}</td>
        </tr>
    @elseif($cod['cod_type']=="adjust")
        <tr>
            <td>{{ $cod['cod_date'] }}</td>
            <td>{{ $cod['type'] }}</td>
            <td>{{  $cod['cod_amount'] }}</td>
            <td>&nbsp;</td>
            <?php $balance = $balance-$cod['cod_amount']; ?>
            <td>{{ $balance }}</td>
        </tr>
    @elseif($cod['cod_type']=="close_month")
        <tr>
            <td>{{ $cod['cod_date'] }}</td>
            <td>{{ $cod['type'] }}</td>
            <td>{{  $cod['cod_amount'] }}</td>
            <td>&nbsp;</td>
            <?php $balance = $balance-$cod['cod_amount']; ?>
            <td>{{ $balance }}</td>
        </tr>

    @endif

@endforeach
