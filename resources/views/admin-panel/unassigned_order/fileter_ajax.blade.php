@foreach($unassigned_orders as $order)
    <tr>
        <td>{{ $order->passport->personal_info->full_name }}</td>
        <td>{{ $order->passport->rider_zds_code->zds_code }}</td>
        <td>{{ $order->platform->name }}</td>
        <?php

        $rider_code = $order->passport->platform_codes->where('platform_id','=',$order->platform_id)->first();
        $platform_code =  isset($rider_code->platform_code) ?  $rider_code->platform_code : '';
        ?>
        <td>{{ isset($platform_code)?$platform_code:"N/A" }}</td>
        <td>{{ $order->order_date }}</td>
        <td>{{ $order->no_of_orders }}</td>
        <td><a href="{{ asset($order->image) }}" target="_blank">see image</td>
        <td> {{ $order->created_at->todatestring() }}</td>

    </tr>

@endforeach
