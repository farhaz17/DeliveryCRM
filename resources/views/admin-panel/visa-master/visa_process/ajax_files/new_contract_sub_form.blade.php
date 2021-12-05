{{-- <form  action ="{{ route('new_contract_sub') }}" method="POST" enctype="multipart/form-data"> --}}
    <style>
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .btn-file {
             padding: 0px;
                }
</style>
<div class="overlay"></div>
    <h5 class="modal-title" id="exampleModalCenterTitle">New Contract Submisson </h5>
    @if(isset($new_contract_sub))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
            @hasanyrole($roll_array)
            <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
            @endhasanyrole
            @endif
    <form  id='new_contract_sub_form'>
    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount sum_amount" @if(!isset($payment_new_contract_sub)) value="163" @else value="{{isset($payment_new_contract_sub)?$payment_new_contract_sub->payment_amount:""}}" @endif  id="payment_amount_main"     @if(isset($payment_new_contract_sub)) readonly @endif id="payment_amount" name="payment_amount"  type="text" placeholder="Enter Payment"  />

            <input type="hidden" name="request_id"  value="{{isset($new_contract_sub)?$new_contract_sub->id:""}}">
        </div>


        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_new_contract_sub !=null) disabled @endif  required  name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_new_contract_sub)?$payment_new_contract_sub->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                     type="number" step="0.01" min='0' @if ($payment_new_contract_sub !=null) readonly
                          @endif  value="{{isset($payment_new_contract_sub)?$payment_new_contract_sub->fine_amount:""}}" placeholder="Fine Amount" />
               </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"
              value="{{isset($payment_new_contract_sub)?$payment_new_contract_sub->transaction_no:""}}"
               @if(isset($payment_new_contract_sub)) readonly @endif
             id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount"   value="{{isset($payment_new_contract_sub)?$payment_new_contract_sub->vat:""}}"  @if(isset($payment_new_contract_sub)) readonly @endif id="vat" name="vat"  type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>
            <input class="form-control form-control"   value="{{isset($payment_new_contract_sub)?Carbon\Carbon::parse($payment_new_contract_sub->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($payment_new_contract_sub)) readonly @endif id="transaction_date_time" name="transaction" value=""  type="date" placeholder="Transaction Date"  />
            <div id="datetime-1-holder"></div>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Service Charges</label>
            <input class="form-control form-control sum_amount"   value="{{isset($payment_new_contract_sub)?$payment_new_contract_sub->service_charges:""}}"  @if(isset($new_contract_sub)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'  placeholder="Enter Service Charges"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_new_contract_sub))
                @if($payment_new_contract_sub->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_new_contract_sub->other_attachment) as $visa_attach)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/NewContractSubmission/'.$visa_attach,
                         now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>
                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif

        </div>
        <div class="col-md-6">
            <label for="repair_category">Total</label>
            <input class="form-control form-control total"   value="" readonly type="text"/>
        </div>

            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
        <div class="col-md-6 mt-2 form-group">
            <input type="hidden" value=""  name="edit_status" id="edit_status">
            <input @if(isset($payment_new_contract_sub)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit19" class="btn btn-primary btn-save" />
        </div>
    </div><!-----row----->
</form>
<script>

    $( "#edit_data" ).click(function() {
        $('#payment_amount_main').removeAttr('readonly');

    $('#payment_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('disabled');
    $('#fine_amount').removeAttr('readonly');

    $('#transaction_no').removeAttr('readonly');
    $('#transaction_date_time').removeAttr('readonly');
    $('#vat').removeAttr('readonly');
    $('#file_name_attach').removeAttr('readonly');
    $('#service_charges').removeAttr('readonly');
    $('#submitBtn').removeAttr('disabled');
    $('input[name=edit_status]').val('1');
    $('#file_name1').show();
$('#file_name3').show();


    });
    </script>
<script>
    $(document).on("change", ".sum_amount", function() {
    var sum = 0;
    $(".sum_amount").each(function(){
        sum += +$(this).val();
    });
    $(".total").val(sum);
});
</script>
<script>

    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
    </script>
<script>
    $(document).ready(function (e){
    $("#new_contract_sub_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('new_contract_sub') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,

   beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#new_contract_sub_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("New Contract Submission Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 102){
                    toastr.error("Transaction Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.success("New Contract Submission Updated Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no);
                }
                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
            },
            error: function(){}
        });
    }));
});
</script>
@if($req=='1')
<script>
$('#payment_amount_main').removeAttr('required');
$('#payment_type').removeAttr('required');

</script>

@endif

@if($req=='1' && !isset($payment_new_contract_sub))
<script>
$('#payment_amount_main').removeAttr('value');
$('#payment_type').removeAttr('required');


</script>
@endif
