<table id="datatable_parts_modal" class="table  table-striped text-11">
    <thead>
    <tr>
        <th>Check</th>
        <th>Quantity Given</th>
        <th>Serial No</th>
        <th>Part Name</th>
        <th>Part No</th>
        <th>Quantity</th>
        <th>Quantity Returned</th>
        <th>Compnay Or Own</th>
        <th>Comments</th>

        {{-- <th>Action</th> --}}
    </tr>
    </thead>
    <tbody>

        <?php $count =0; ?>
    @foreach ($gamer_array as $obj)
    <tr>
        <td>
            <input  id="part-{{ $count }}" type="checkbox" name="checked[]" class="form-group checkbox-check part_checkbox" value="{{ $obj['part_id'] }}">
        </td>
      <td>
        <input   id="qty-{{ $count }}" type="number" name="checkeds[]" class="form-group qty-checkbox" min='1' max="{{ $obj['qty'] }}" value="{{$obj['qty_verified']}}">
        <input style="display: none"  id="repair_sale_id-{{ $count }}" type="text" name="repair_sale_id" class="form-group repair-checkbox" value="{{ $obj['repair_sale_id'] }}">
        <input style="display: none"  id="key-{{ $count }}" type="text" name="key[]" class="form-group repair-key" value="{{ $obj['id'] }}">
        <input style="display: none"  id="company_or_own-{{ $count }}" type="text" name="company_or_own[]" class="form-group repair-key" value="{{ $obj['compnay_own'] }}">
        <input style="display: none"  id="comments-{{ $count }}" type="text" name="comments[]" class="form-group repair-key" value="{{ $obj['comments'] }}">
        <input style="display: none"  id="qty_orignal-{{ $count }}" type="text" name="qty_orignal[]" class="form-group repair-key" value="{{ $obj['qty'] }}">
        <input style="display: none"  id="part_id-{{ $count }}" type="text" name="part_id[]" class="form-group repair-key" value="{{ $obj['part_id'] }}">
        {{-- <input style="display: none"  id="qty_return-{{ $count }}" type="text" name="qty_return[]" class="form-group repair-key" value="{{ $obj['qty_return'] }}"> --}}


      </td>
            <td id="sn-{{$obj['sn']}}" > {{$obj['sn']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['part_name']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['part_no']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['qty']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['qty_return']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['compnay_own']}}</td>
       <td id="sn-{{$obj['sn']}}" > {{$obj['comments']}}</td>
    </tr>
    <?php $count = $count+1; ?>
@endforeach
    </tbody>
</table>

<script>
    $('.qty-checkbox').on('input', function () {

            var edit_id= $(this).attr('id');
            var spli_val = edit_id.split("-");
            var id = spli_val[1];

            var qty_added = $("#qty-"+id).val();
            var qty_asked = $("#qty_orignal-"+id).val();

            // console.log(val);


    var value = $(this).val();


    if ((value !== '') && (value.indexOf('.') === -1)) {

        $(this).val(Math.max(Math.min(value, qty_asked), 0));
    }
});
</script>
<script>
    $('.veri').on('click', '.part_checkbox', function() {
        if($(this).prop("checked") == true){
            var data_id = $(this).attr('id');
            var splt_v = data_id.split("-");

            $("#qty-"+splt_v[1]).prop("checked",true);
        }
        else if($(this).prop("checked") == false){
            var data_id = $(this).attr('id');
            var splt_v = data_id.split("-");

            $("#qty-"+splt_v[1]).prop("checked",false);
        }

    });
</script>







