
<table id="datatable_parts_modal" class="table  table-striped text-11">
    <thead>
    <tr>
        <th>Serial No</th>
        <th>Part Name</th>
        <th>Part Number</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Qty Verified</th>
        <th>Qty Returned</th>
        <th>Company Or Own</th>
        <th>Commments</th>
        <th>Inventory Status</th>
         <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($gamer_array as $obj)
    <tr>
        <span id="repair_id" style="display: none">{{$obj['repair_sale_id']}} </span>
        <span id="part_name-{{$obj['part_name']}}"  style="display: none" >{{$obj['part_name']}} </span>
        <span id="part_no-{{$obj['part_no']}}" style="display: none">{{$obj['part_no']}} </span>
       {{-- <td style="display: none" id="json_data_id"> {{$obj['id']}}</td> --}}
       <td> <span> {{$obj['id']}} </span></td>
        <td>{{$obj['part_name']}}  </td>
        <td>{{$obj['part_no']}} </td>
        <td>{{$obj['qty']}} </td>
        <td>{{$obj['price']}} </td>
        <td>{{$obj['qty_verified']}} </td>
        <td>{{$obj['qty_return']}}</td>
        <td>{{$obj['compnay_own']}} </td>
        <td>{{$obj['comments']}} </td>
        <td>
            @if ($obj['verify_status']=='0')
            <span class="badge badge-danger m-2">Not Verified Yet</span>
            @else
            <span class="badge badge-success m-2">Verified</span>
            @endif
           </td>

           <td>
            @if ($obj['verify_status']=='0')
            <span class="badge badge-danger m-2">Not Verified Yet</span>
            @else
            <button class="btn btn-primary btn-sm m-1 return_qty_btn"  id="json_data_id-{{$obj['id']}}"   type="button">Retun Qty</button>
            @endif
        </td>

    </tr>

@endforeach
    </tbody>


</table>








<script>



    $(document).ready(function() {

            $(document).on('click', '.return_qty_btn', function(e) {
            var edit_id= $(this).attr('id');
            var spli_val = edit_id.split("-");
            var json_repair_id = spli_val[1];
            var repair_id = $("#repair_id").text();

            var url = '{{ route('get_return_parts') }}';
            var token = $("input[name='_token']").val();
            $('input[name=row_id]').val(repair_id);
            $('input[name=json_data_id]').val(json_repair_id);

            $('#return_part_modal').modal('show');
        });
        });

   </script>
<script>
    $(document).ready(function (e){
    $("#part_return_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('get_return_parts') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#checkupForm").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Return Added Successfully!", { timeOut:10000 , progressBar : true});

                }
                else if(response.code==101){
                    toastr.error("Return Quantity Cannot be More than Quantity", { timeOut:10000 , progressBar : true});

                }
                else {
                    toastr.error("Something Went Wrong! Try Again", { timeOut:10000 , progressBar : true});

                }
            },
            error: function(){}
        });
    }));
});
        </script>
