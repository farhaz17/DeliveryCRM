<table class="display table table-sm table-striped text-10 table-bordered"  style="width: 100%;">
    <tbody>
    <tr>
        <th>Agreed Amount</th>
        <td>{{ $agreed_amoount->agreed_amount }}</td>
    </tr>
    <tr>
        <th>Discount Amount</th>
        <td>
        <?php
        $discount_total = 0;
        if($agreed_amoount->discount_details!= null){
            $array_discounts = json_decode($agreed_amoount->discount_details,true);

            $iterate = 0;
            foreach ($array_discounts["0"]["name"]  as $ab){
                echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";

                $discount_total = $discount_total+$array_discounts["0"]["amount"][$iterate];
                $iterate = $iterate+1;
            }
            echo "<br>total Discount(".$discount_total.")";
        }else{
            echo "0";
        } ?>

       </td>
    </tr>
    <tr>
        <th>Advance Amount</th>
        <td>{{  $agreed_amoount->advance_amount }}</td>
    </tr>
    <tr>
        <th>Payroll Deeduct Amount</th>
        <td>{{ $agreed_amoount->payroll_deduct_amount }}</td>
    </tr>

    <tr>
        <th>Final Ar Amount</th>
        <td>{{ $agreed_amoount->final_amount }}</td>
    </tr>


    </tbody>
</table>
