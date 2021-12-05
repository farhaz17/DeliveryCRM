
@if($status=="0")
@foreach($agreed_amounts as $amount)
    <tr>
        <td>{{ $amount->id }}</td>
        <td>{{ $amount->passport->personal_info->full_name }}</td>
        <td>{{ $amount->passport->passport_no }}</td>
        <td>{{ $amount->agreed_amount }}</td>
        <td>{{ $amount->advance_amount }}</td>
        <td>
            <?php
            if($amount->discount_details!= null){
                $array_discounts = json_decode($amount->discount_details,true);
                $iterate = 0;
                foreach ($array_discounts["0"]["name"]  as $ab){
                    echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";
                    $iterate = $iterate+1;
                }

            } ?>

        </td>
        <td>{{ $amount->final_amount }}</td>
        <td>{{ $amount->created_at }}</td>


        <td>
            <a href="javacript:void(0)" class="action_btn_cls" id="{{ $amount->id }}">
                <i class="nav-icon i-Pen-3 font-weight-bold"></i>
            </a>
        </td>
    </tr>
@endforeach
@else

    @foreach($agreed_amounts as $amount)
        <tr>
            <td>{{ $amount->id }}</td>
            <td>{{ $amount->passport->personal_info->full_name }}</td>
            <td>{{ $amount->passport->passport_no }}</td>
            <td>{{ $amount->agreed_amount }}</td>
            <td>{{ $amount->advance_amount }}</td>
            <td>
                <?php
                if($amount->discount_details!= null){
                    $array_discounts = json_decode($amount->discount_details,true);
                    $iterate = 0;
                    foreach ($array_discounts["0"]["name"]  as $ab){
                        echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";
                        $iterate = $iterate+1;
                    }

                } ?>

            </td>
            <td>{{ $amount->final_amount }}</td>
            <td>{{ $amount->updated_status_time }}</td>
            

        </tr>
    @endforeach

@endif
