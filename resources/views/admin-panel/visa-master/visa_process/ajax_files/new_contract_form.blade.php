{{-- <form  action ="{{ route('new_contract.store') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <h5 class="modal-title" id="exampleModalCenterTitle">New Contract Application Typing </h5>
    @if(isset($new_contract))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif
    <form  id='new_contract_from'>
    {!! csrf_field() !!}
    <div class="row">


        <div class="col-md-6">
            <label for="repair_category">MB No.</label>
                   <input class="form-control form-control" id="mb_no" name="mb_no"   @if(isset($new_contract)) readonly @endif  value="{{isset($new_contract)?$new_contract->mb_no:""}}"  />
        </div>


        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($new_contract))
                <select id="status" name="status" class="form-control form-control"  required {{isset($new_contract)?'disabled':""}}>
                    <option value="1"  @if($new_contract->status=="1")  selected  @endif>Yes</option>
                    <option value="0" @if($new_contract->status=="0") selected @endif>No</option>
                </select>
            @else
            <select id="status" name="status" class="form-control form-control" required   >
                <option readonly="" >Select option</option>
                <option value="1" >Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div>


        <div class="col-md-6">
            <label for="repair_category">Date</label>
            <input class="form-control form-control" value="{{isset($new_contract)?$new_contract->new_contract_date:""}}"
            @if(isset($new_contract)) readonly @endif id="new_contract_date" name="new_contract_date"
             type="date" placeholder="Enter  Date" required />
            <input type="hidden" name="request_id"  value="{{isset($new_contract)?$new_contract->id:""}}">
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($new_contract))
                @if($new_contract->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($new_contract->visa_attachment) as $visa_attach)
{{--
                        <a class="attachment_display" href="{{isset($new_contract->visa_attachment)?url('assets/upload/NewContractAppTyping/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/NewContractAppTyping/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>

        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" value="1" name="payment_checkbox" id="payment_option12" @if(isset($payment_new_contract))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>
        </div>
    </div>




    <div class="row payment_row"  id="payment12" @if(isset($payment_new_contract))   @else  style="display: none"   @endif>
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount"  value="{{isset($payment_new_contract)?$payment_new_contract->payment_amount:""}}"
                   @if(isset($payment_new_contract)) readonly @endif id="payment_amount"

                   name="payment_amount"  type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_new_contract !=null) disabled @endif    name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_new_contract)?$payment_new_contract->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_new_contract !=null) readonly
                          @endif  value="{{isset($payment_new_contract)?$payment_new_contract->fine_amount:""}}" placeholder="Fine Amount" />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control" value="{{isset($payment_new_contract)?$payment_new_contract->transaction_no:""}}"
                   @if(isset($new_contract)) readonly @endif id="transaction_no" name="transaction_no"

                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount" value="{{isset($payment_new_contract)?$payment_new_contract->vat:""}}"
                   @if(isset($new_contract)) readonly @endif id="vat" name="vat"  type="number" step="0.01" min='0'

                   placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>
            <input class="form-control form-control" id="transaction_date_time"

                   value="{{isset($payment_new_contract)?Carbon\Carbon::parse($payment_new_contract->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($payment_new_contract)) readonly @endif

                   name="transaction_date_time"   type="date" placeholder="Transaction Date & Time"/>
            <div id="datetime-1-holder"></div>
                     </div>

                     <div class="col-md-6">
                        <label for="repair_category">Service Charges</label>
                        <input class="form-control form-control sum_amount"   value="{{isset($payment_new_contract)?$payment_new_contract->service_charges:""}}"  @if(isset($visa_stamp)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'  placeholder="Enter Service Charges"  />
                    </div>




        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_new_contract))
                @if($payment_new_contract->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_new_contract->other_attachment) as $visa_attach2)

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/NewContractAppTyping/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif
        </div>
        <div class="col-md-6">
            <label for="repair_category">Total</label>
            <input class="form-control form-control total"   value="" readonly type="text"/>
        </div>






    </div>
    <div class="col-md-6 mt-2 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">
        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
            <input  @if(isset($new_contract)) disabled @endif   type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit17" class="btn btn-primary btn-save" />
    </div>
</form>

<script>

    $( "#edit_data" ).click(function() {
        $('#payment_amount').removeAttr('readonly');
        $('#file_name').removeAttr('readonly');
        $('#new_contract_date').removeAttr('readonly');
        $('#mb_no').removeAttr('readonly');
        $('#status').removeAttr('disabled');


    $('#payment_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('disabled');
    $('#fine_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('readonly');
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
      $('#payment_option12').change(function() {
         if ($('#payment_option12').prop('checked')) {
            $('#payment_type').attr('required',true);
           $('#payment12').show();
             } else {
              $('#payment12').hide();
              $('#payment_type').removeAttr('required');
                 }
                  });
</script>

<script>
    $(document).ready(function (e){
    $("#new_contract_from").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('new_contract.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#new_contract_from").trigger("reset");
                if(response.code == 100) {
                    toastr.success("New Contract Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104){
                    toastr.success("New Contract Updated Successfully!", { timeOut:10000 , progressBar : true});
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
    $('#payment_amount').removeAttr('required');
    $('#file_name').removeAttr('required');
    $('#new_contract_date').removeAttr('required');
    $('#status').removeAttr('required');
    $('#status').removeAttr('required');
    $('#mb_no').removeAttr('required');


    </script>

@endif
