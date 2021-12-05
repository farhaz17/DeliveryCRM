<tr id="{{ $parts->id }}" class="bill_row_cls">
    <td>{{$parts->part_name}}
        <input type="hidden" value="{{$parts->id}}" name="parts_id[]" id="parts_id">
    </td>
    {{-- <td id="price-{{ $parts->id }}">{{$parts->inv->price}}</td> --}}


    <td>

        <p class="partQty-"{{$parts->id}} style="display:none" > </p>
        <input type="hidden" value="{{$parts->inv->price}}" class="price_val" name="price_val[]" id="price_val-{{ $parts->id }}">

        <input type="number"  min="0" value="{{$qty}}" class="myInput" name="qty[]" id="qty-{{ $parts->id }}"></td>

    {{-- <td id="subtotal-{{  $parts->id }}" class="sub_totals_cls">
        
            // $subtotal=$parts->inv->price*$qty;


        {{$subtotal}}
        <input type="hidden" value="{{$subtotal}}" class="subtotal_val" name="sub_total[]" id="subtotal-{{ $parts->id }}">

    </td> --}}
    <td>
        <button id="delet-{{ $parts->id }}" class="btn">  <i class="fa fa-trash-o"></i></button>
    </td>

</tr>




<script>
//     $("#myTextBox").on("input", function() {
//    alert($(this).val());
// });
    $(".myInput").on("input", function(){

       var price=  $("input[name='price_val']").val();
        var value= $(this).val();
        id=this.id;

        var splt_v =id.split("-");
        ids=splt_v[1];

        var sub_total_final= parseFloat(price)*parseFloat(value);


            var quantity = $("#qty-"+ids).val();

            var current_q= $("#part_qtyy-"+ids).text();

            // console.log(current_q);



            var g_toal_q = parseInt(current_q)-parseInt(quantity);
            $("#part_qty-"+ids).text(g_toal_q);

         $("#subtotal-"+ids).html(sub_total_final);
         $("#grand_total_final").html(calculate_sum());





    });



</script>


