  <table id="datatable_ver" class="table  table-striped text-11">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkAll"></th>
            <th>Serial No</th>
            <th>Part No</th>
            <th>Part Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>


        </tr>
        </thead>
        <tbody>
            <?php $count =0; ?>
        @foreach ($gamer_array as $obj)
        <tr>
            {{-- id="parts`+ {{ $obj['id'] }}+` --}}
            <td><input  id="part-{{ $count }}" type="checkbox" name="checked[]" class="form-group checkbox-check part_checkbox" value="{{ $obj['id'] }}">
            <input  style="display: none"  id="qty-{{ $count }}" type="checkbox" name="checkeds[]" class="form-group qty-checkbox" value="{{ $obj['qty'] }}">
            <input style="display: none"  id="price-{{ $count }}" type="checkbox" name="checked-price[]" class="form-group price-checkbox" value="{{ $obj['price'] }}"></td>
            <input style="display: none"  id="purchase_id" type="text" name="purchase_id" class="form-group price-checkbox" value="{{ $obj['purchase_id'] }}"></td>
           <td> {{$obj['sn']}}</td>
        <td>{{$obj['part_no']}} </td>
        <td> {{$obj['part_name']}}</td>
        <td>{{$obj['qty']}}</td>
        <td>{{$obj['price']}}</td>
        <td>{{$obj['total']}}</td>
    </tr>
    <?php $count = $count+1; ?>
@endforeach

        </tbody>

        <tfoot style="background:#ffffff">
            <tr style="background:#ffffff">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td  style="background:#ffffff; white-space:nowrap; font-weight:bold">Grand Total</td>
              <td  style="background:#ffffff; white-space:nowrap; font-weight:bold">{{$grand_total}}</td>

            </tr>
          </tfoot>
    </table>

    <script>
          $("#checkAll").click(function () {
          $('input:checkbox').not(this).prop('checked', this.checked);
 });
    </script>






