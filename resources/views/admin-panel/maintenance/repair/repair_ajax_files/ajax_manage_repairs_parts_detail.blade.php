<table class="table table-striped text-11 table-condensed" id="datatable_parts">
    <thead>
        <tr>
            <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd;">Description</th>
            <th class="text-center" style="width: 12%; border-bottom: 2px solid #ddd;">Quantity</th>
            <th class="text-center" style="width: 24%; border-bottom: 2px solid #ddd;">Price</th>
            <th class="text-center" style="width: 26%; border-bottom: 2px solid #ddd;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gamer_array as $row )
        <tr>
            <td>{{$row['part_name']}}</td>
            <td style="text-align:center;">{{$row['qty']}}</td>
            <td class="text-right">{{$row['price']}}</td>
            <td class="text-right">{{$row['sub_total']}}</td>
        </tr>
    </tbody>
        @endforeach

    <tfoot>
        <tr>
            <th class="text-left" colspan="2">Total</th>
            <th class="text-left" colspan="2">&nbsp</th>
            <th colspan="2" class="text-right">{{$total}}</th>
        </tr>

        <tr>
            <th class="text-left" colspan="2">Discount</th>
            <th class="text-left" colspan="2">&nbsp</th>
            <th colspan="2" class="text-right">{{$discount}}</th>
        </tr>

            <tr>
                <th class="text-left" colspan="2">Grand Total</th>
                <th class="text-left" colspan="2">&nbsp</th>
                <th colspan="2" class="text-right">{{$grand_total}}</th>
            </tr>
             </tfoot>
 </table>


