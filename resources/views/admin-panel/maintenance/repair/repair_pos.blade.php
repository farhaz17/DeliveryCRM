@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }


        <style>



    input#search2 {
        width: 20px;
        height: 20px;
    }
    input#search3 {
        width: 20px;
        height: 20px;
    }
    input#att_platform {
        width: 20px;
        height: 20px;
    }


    .text-attr-platform2{
        font-size: 7px;
        font-weight: 800;
    }

    .block-update-card {
        /* height: 81%; */
        border: 1px #FFFFFF solid;
        width: 372px;
        float: left;
        margin-left: 25px;
        margin-top: 20px;
        padding: 0;
        box-shadow: 1px 1px 8px #d8d8d8;
        background-color: #FFFFFF;
        height: 60px;
    }
    .block-update-card .h-status {
        width: 100%;
        height: 7px;
        background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
    }
    .block-update-card .v-status {
        width: 5px;
        height: 80px;
        float: left;
        margin-right: 5px;
        background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
    }
    .block-update-card .update-card-MDimentions {
        width: 60px;
        height: 60px;
        position: relative;
        /* top: 10px; */
    }
    /*.block-update-card .update-card-body {*/
    /*    margin-top: 20px;*/
    /*    margin-left: 10px;*/
    /*    line-height: 6px;*/
    /*    cursor: pointer;*/
    /*}*/
    .block-update-card .update-card-body h4 {
        color: #737373;
        font-weight: bold;
        font-size: 13px;
    }
    .block-update-card .update-card-body p {
        color: #000000;
        font-size: 14px;
    }
    .block-update-card .card-action-pellet {
        padding: 5px;
    }
    .block-update-card .card-action-pellet div {
        margin-right: 10px;
        font-size: 15px;
        cursor: pointer;
        color: #dddddd;
    }
    .block-update-card .card-action-pellet div:hover {
        color: #999999;
    }
    .block-update-card .card-bottom-status {
        color: #a9a9aa;
        font-weight: bold;
        font-size: 14px;
        border-top: #e0e0e0 1px solid;
        padding-top: 5px;
        margin: 0px;
    }
    .block-update-card .card-bottom-status:hover {
        background-color: #dd4b39;
        color: #FFFFFF;
        cursor: pointer;
    }

    /*new*/
    img.title_imag-icon {
        height: 55px;
        width: 56px;
        max-width: 300px;
    }
    .card.card-profile-1.mb-4 {
        width: 180px;
        height: 59px;
        line-height: 5px;
        margin-left: 5px;
        margin-top: 3px;
        border-radius: 5px;
        border: 1px solid #bfbfbf;
    }
    p.text-attr-title.font-weight-bold {
        font-size: 11px;
    text-align: center;
    /* font-family: Roboto Slab; */
    white-space: nowrap;
    }
    p.text-attr {
        font-size: 16px;
        font-weight: 700;
        /*font-family: Redwing;*/
    }
    .main-content-wrap.d-flex.flex-column {
    background: #fdfeff;
}
span.qty-mt {
    /* margin-top: 7px; */
    position: relative;
    top: 5px;
    font-size: 12px;
    font-weight: bold;
}
.pos .font16 {
    font-size: 15px;
    margin-bottom: 10px;
}
.pos .modal-success .table-bordered>tbody>tr>td {
    background: #fff;
    color: #333;
    border: 1px solid #00a65a;
}
.total-table {
    width: 600px;
}
input#submit_btn_save {
    width: 600px;
}
input#submit_btn_payment {
    width: 275px;
}
</style>
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Manage Repair</a></li>
            <li>Point Of Sale</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>





     <div class="row">
        <div class="col-md-4">
         <div class="card ">
          <div class="card-body">
           {{-- <form action=""> --}}
            {{-- <form id="saleForm" action="{{ route('repair_sale_save') }}" > --}}
                {{-- <form method="post" id="saleForm" enctype="multipart/form-data" action="{{route('repair_sale_save')}}"> --}}
                    <form method="post" id="saleForm" enctype="multipart/form-data" action="#">
                    {!! csrf_field() !!}

            <div class="row">
             <div class="col-md-12 form-group mb-3">

                <p><span class="text-success font-weight-bold"> Bike Plate No : </span><span class="font-weight-bold"> {{isset($bike_no)?$bike_no:""}}</span> <span class="text-danger ml-4 font-weight-bold">Chassis No :  </span><span class="font-weight-bold">{{isset($chassis_no)?$chassis_no:""}}</span></p>
                 <input type="hidden" name="bike_id" id="bike_id" value="{{$repair_id}}">
                
                    {{-- <label for="repair_category">Repair Parts</label>


                    <select id="bike_id" name="bike_id" class="form-control" required >
                        <option selected="true" disabled="disabled">Select Option</option>
                    @foreach($manage_repair as $row)

                    <option value="{{$row->id}}">{{$row->bike->plate_no}} | {{$row->bike->chassis_no}}</option>
                    @endforeach
                    </select> --}}
             </div>
            </div>
            <div class="row">
              <table class="table table-striped text-11 table-condensed table-hover list-table" style="margin:0;">
                <thead class="table-dark">
                <tr class="success">
                  <th>Part</th>
                   {{-- <th style="width: 15%;text-align:center;">Price</th> --}}
                    <th style="width: 15%;text-align:center;">Qty</th>
                    {{-- <th style="width: 20%;text-align:center;">Subtotal</th> --}}
                    <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
                </tr>
             </thead>
                 <tbody class="result"></tbody>
            </table>

       </div>

          </div>

        </div>






        </div>
        <div class="col-md-8 mb-4" style="background: #f5f5f5">


            <div class="row">
            @foreach ( $parts as $row )
            <div class="col-lg-2 col-md-3 col-sm-3 div-part">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10" onclick="add_card({{$row->id}})" >

                                <div class="col-sm-12 part_name" >
                                    <p class="text-attr-title font-weight-bold">{{$row->part_name}} </p>
                                </div>
                                <div class="col-sm-12 part_number">
                                    <p class="font-weight-bold" style="text-align: center; color:red">{{$row->part_number}} </p>
                                </div>
                                {{-- <div class="col-sm-12 part_inv">
                                 <p class="font-weight-bold" data-id="current_qty-{{$row->id}}"  id="part_qty-{{$row->id}}" style="text-align: center;color:green">{{isset($row->inv->quantity_balance)?$row->inv->quantity_balance:"0"}} </p>
                                    <p class="font-weight-bold mt-1" style="display: none"  id="part_qtyy-{{$row->id}}" style="text-align: center;color:green">{{isset($row->inv->quantity_balance)?$row->inv->quantity_balance:"0"}} </p>

                                </div> --}}



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach



            {{-- <input type="hidden" value="{{$subtotal}}" class="subtotal_val" name="sub_total" id="subtotal-{{ $parts->id }}"> --}}

            {{-- <p><input type="text" name="g_total" placeholder="Type something..." class="myInput-2"></p> --}}
            {{-- <div id="result"></div> --}}




        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 ml-3">
            <div class="ajax_table_load"></div>
            <div class="total-table">
                {{-- <table id="totaltbl" class="table table-striped text-11 table-condensed table-hover list-table">
                    <tbody>
                        <tr class="info"> --}}
                            {{-- <td width="25%">Total Items</td>
                            <td class="text-right" style="padding-right:10px;"><span id="count">0 (0.00)</span></td> --}}
                            {{-- <td >Total</td>
                            <td class="text-right" colspan="4"><span id="grand_total_final">0.00</span></td>
                        </tr> --}}

                    {{-- </tbody>
                </table> --}}
                {{-- <input type="hidden" name="token" class="form-control"  value="p2lbgWkFrykA4QyUmpHihzmc5BNzIABq" />
                <input type="hidden" name="btn_status"  readonly="readonly"/> --}}
                {{-- <input type="submit" name="submit" value="submit" id="submit"> --}}
           <div class="row">
<div class="col-md-6">
    <input type="submit" name="btnSubmitSave" id="submit_btn_save" class="btn btn-info mt-2" value="Save " />
</div>

{{-- <div class="col-md-6">
    <input type="submit" name="btnSubmitPayment" id="submit_btn_payment" class="btn btn-success mt-2" value="Payment" />
</div> --}}
           </div>


        </div>

    </div>
</form>

        <div class="col-md-12 mb-3"></div>

    </div>


</div>
     </div>



   <!--  Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="font16">
                          <form method="post" id="paymentForm" enctype="multipart/form-data" action="{{route('repair_sale_payment')}}">
                            {!! csrf_field() !!}
                            <table class="table table-bordered table-condensed" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td width="25%" style="border-right-color: #FFF !important;">Total Items</td>
                                        <td width="25%" class="text-right"><span id="total_item"></span></td>
                                        <td width="25%" style="border-right-color: #FFF !important;">Total Amount</td>
                                        <td width="25%" class="text-right"><span id="total_amount">15.75 (0.00)</span></td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input name="repair_id" id="repair_id" type="hidden">
                                <input name="total_items" id="total_items_val" type="hidden">
                                <input name="total_amount" id="total_amount_val" type="hidden">

                                <div class="form-group">
                                    <label for="amount">Discount</label>
                                      <input name="discount" value="0" type="text" class="form-control" id="amount" placeholder="Enter Discount Amount">
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="paid_by">Paying by</label>
                                            <select id="paid_by" name="paid_by" class="form-control" required>
                                        <option selected="true" disabled="disabled">Select Option</option>                                            <option value="0">Cash</option>
                                        <option value="1">Card</option>
                                        <option value="2">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note"  class="pa form-control kb-text">
                                    </textarea>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success ml-2" type="submit">Add Payment</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--  Modal -->





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
 function cal_qty(){



 }


    </script>

    {{-- <script>
        function calculate_sum(){
            var total_now = 0;

                $(".sub_totals_cls").each(function() {
                var value = $(this).text();
                // onsole.log(value);
                total_now = parseFloat(total_now)+parseFloat(value);

                    });
                  return total_now;
        }

        </script> --}}

    <script>
        function add_card(id)
        {
        //     function calculate_qty(){
        //         var cur_qty = document.getElementById('part_qty-'+id).innerHTML;
        //       if(cur_qty=='0'){


        //         toastr.error("Part Quantity is 0", { timeOut:10000 , progressBar : true});

        //       }
        //       else{
        //         var updated_qty = document.getElementById('part_qty-'+id);
        //         var new_qty=cur_qty-qty;
        //         updated_qty.innerText =new_qty;

        //    }}





            var id = id;
            var qty='1';
            var if_exist_id = 1;

            $('.bill_row_cls').each(function() {
                if(this.id==id){
                    if_exist_id = 0;
                        // calculate_qty();
                        var cur_qty = $("#qty-"+id).val();


                        var total_qty = parseInt(cur_qty)+1;
                        $("#qty-"+id).val(total_qty);
                        var price = $("#price-"+id).html();
                        var c_total = $("#subtotal-"+id).html();

                        var x=$("input[name=g_total]").val();

                        var grand_total=parseFloat(c_total);

                        var sub_total_final= parseFloat(price)*parseFloat(total_qty);


                      $("#subtotal-"+id).html(sub_total_final);


                }

            });



            if(if_exist_id){
                var url = '{{ route('get_pos_product', ":id") }}';
                var token = $("input[name='_token']").val();
                // calculate_qty();
                 $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {id: id, qty:qty, _token: token},
                        success: function (response) {
                            $('.result').append(response.html);
                            $(this).parents('tr').remove();

                            // $("#grand_total_final").html(calculate_sum());

                        }

                    });

            }

            var total_now = 0;

                $(".sub_totals_cls").each(function() {
                var value = $(this).text();
                // onsole.log(value);
                total_now = parseFloat(total_now)+parseFloat(value);

                    });

            var g_total = total_now;

            $("#grand_total_final").html(g_total);

        }


        $('table').on('click','tr button',function(e){
         e.preventDefault();
         var del_id= $(this).attr('id');
         var spli_val = del_id.split("-");


         var final_id = spli_val[1];

         var quantity = $("#qty-"+final_id).val();

          var current_q= $("#part_qty-"+final_id).text();

          var g_toal_q = parseInt(quantity)+parseInt(current_q);



          $("#part_qty-"+final_id).text(g_toal_q);



        $(this).parents('tr').remove();

        $("#grand_total_final").html(calculate_sum());
      });

    </script>



<script>


</script>













    <script>
    $(document).ready(function(){
  $("#submit_btn").click(function(){
    var id = $("#id").val();
    var plate_no = $("#chassis_no_id").val();
    var name = $("#name").val();
    var passport_id = $("#passport_id").val();
    var company = $('input[name="company"]:checked').val();
    var token = $("input[name='_token']").val();


    $.ajax({
            url: "{{ route('manage_repair.store') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id,plate_no:plate_no,name:name, _token: token,name:name,passport_id:passport_id,company:company},
                    success: function (response) {
                        $(".ajax_table_load").empty();
                            $('.ajax_table_load').append(response.html);

                    }
                });



  });
});
</script>


<script>
   $('#submit_btn_save').click(function(){

    $('input[name=btn_status]').val('1');
});


$('#submit_btn_payment').click(function(){

$('input[name=btn_status]').val('2');
});
</script>

    <script>
          $(document).ready(function (e){


            // $("#btnSubmitSave").click(function(){
            //     $('input[name=butoon_status]').val('55555555523');
            // });

    $("#saleForm").on('submit',(function(e){
        e.preventDefault();



        $.ajax({

            url: "{{ route('repair_sale_save') }}",
            type: "POST",

            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#saleForm").trigger("reset");
                if(response.code == 100) {

                toastr.success("Saved Successfully", { timeOut:10000 , progressBar : true});

                }
                else {
                    $("#total_item").text(response.total_items)
                    $("#total_amount").text(response.total_amount)
                    $('input[name=total_items]').val(response.total_items);
                    $('input[name=total_amount]').val(response.total_amount);
                    $('input[name=repair_id]').val(response.repair_id);


                   $('#exampleModal').modal('show')
                }
            },
            error: function(){}
        });


    }));
});
    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>




@endsection
