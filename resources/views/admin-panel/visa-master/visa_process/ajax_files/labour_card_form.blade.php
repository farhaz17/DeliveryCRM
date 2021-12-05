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
<h5 class="modal-title" id="exampleModalCenterTitle">Labour Card</h5>
@if(isset($labour_card))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif
<form  id="labour_card_print" >
    {{-- <form  action ="{{ route('labour_card_print.store') }}" method="POST" enctype="multipart/form-data"> --}}
    {!! csrf_field() !!}

    <div class="row">
        {{-- <div class="col-md-6">
            <label for="repair_category">Labour Card Expiry Date</label>
            <input class="form-control form-control"
              value="{{isset($payment_labour_card)?Carbon\Carbon::parse($payment_labour_card->labour_card_expiry_date)->format('Y-m-d'):""}}"   @if(isset($labour_card)) readonly @endif
               id="labour_card_expiry_date" name="labour_card_expiry_date" value=""  type="date" placeholder="Date"  />
            <div id="datetime-1-holder"></div>
            </div> --}}



            <div class="col-md-6">
                <label for="repair_category">Person Code</label>
                <input class="form-control form-control"   value="{{isset($labour_card)?$labour_card->person_code:""}}"  @if(isset($labour_card)) readonly @endif id="person_code" name="person_code"  type="text" placeholder="Enter Person Code"  />
                <input type="hidden" name="request_id"  value="{{isset($labour_card)?$labour_card->id:""}}">
            </div>
            <div class="col-md-6">
                <label for="repair_category">Labour Card No</label>
                <input class="form-control form-control" id="labour_card_no" name="labour_card_no" value="{{isset($labour_card)?$labour_card->labour_card_no:""}}" @if(isset($labour_card)) readonly @endif    placeholder="Labour card no"  />
            </div>

            <div class="col-md-6">
                <label for="repair_category">Issue Date</label>
                <input class="form-control form-control"     value="{{isset($labour_card)?Carbon\Carbon::parse($labour_card->issue_date)->format('Y-m-d'):""}}"   @if(isset($labour_card)) readonly @endif id="issue_date" name="issue_date" value=""  type="date" placeholder="Date"  />
                <div id="datetime-1-holder"></div>
                </div>


            <div class="col-md-6">
                <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control"
            value="{{isset($labour_card)?Carbon\Carbon::parse($labour_card->labour_card_expiry_date)->format('Y-m-d'):""}}"

                   @if(isset($labour_card)) readonly @endif  id="labour_card_expiry_date" name="labour_card_expiry_date"
                   type="date" placeholder="Enter Payment" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($labour_card))
                @if($labour_card->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($labour_card->visa_attachment) as $visa_attach)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/LabourCardPrint/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
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
                <input type="checkbox" value="1" name="payment_checkbox" id="payment_option13" @if(isset($payment_labour_card))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>

    <div class="row payment_row"  id="payment13" @if(isset($payment_labour_card))   @else  style="display: none"   @endif >
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount"   value="{{isset($payment_labour_card)?$payment_labour_card->payment_amount:""}}"  @if(isset($labour_card)) readonly @endif id="payment_amount" name="payment_amount"  type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_labour_card !=null) disabled @endif    name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_labour_card)?$payment_labour_card->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_labour_card !=null) readonly
                          @endif  value="{{isset($payment_labour_card)?$payment_labour_card->fine_amount:""}}" placeholder="Fine Amount" />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"   value="{{isset($payment_labour_card)?$payment_labour_card->transaction_no:""}}"  @if(isset($labour_card)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount"   value="{{isset($payment_labour_card)?$payment_labour_card->vat:""}}"  @if(isset($labour_card)) readonly @endif id="vat" name="vat"  type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>
            <input class="form-control form-control"     value="{{isset($payment_labour_card)?Carbon\Carbon::parse($payment_labour_card->transaction_date_time)->format('Y-m-d'):""}}"   @if(isset($labour_card)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="date" placeholder="Transaction Date"  />
            <div id="datetime-1-holder"></div>
            </div>

            <div class="col-md-6">
                <label for="repair_category">Service Charges</label>
                <input class="form-control form-control sum_amount"   value="{{isset($payment_labour_card)?$payment_labour_card->service_charges:""}}"
                  @if(isset($payment_labour_card)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'
                   placeholder="Enter Service Charges"  />
            </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($payment_labour_card))
                @if($payment_labour_card->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_labour_card->other_attachment) as $visa_attach2)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/LabourCardPrint/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
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


            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
    </div><!-------row------>
    <div class="col-md-6 mt-2 form-group">

        <input type="hidden" value=""  name="edit_status" id="edit_status">
            {{-- <button  id="labour_card" class="btn btn-primary" style="display: none">Save</button> --}}
            <input  @if(isset($labour_card)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit20" class="btn btn-primary btn-save" />



    </div>
</form>
<script>

    $( "#edit_data" ).click(function() {
        $('#person_code').removeAttr('readonly');
        $('#labour_card_no').removeAttr('readonly');
        $('#issue_date').removeAttr('readonly');
        $('#labour_card_expiry_date').removeAttr('readonly');
        $('#labour_card_expiry_date').removeAttr('readonly');
        // labour_card_no

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
         $('#payment_option13').change(function() {
                                        if ($('#payment_option13').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment13').show();
                                        } else {
                                            $('#payment13').hide();
                                            $('#payment_type').removeAttr('required');
                                        }
                                    });
</script>
<script>
    $(document).ready(function (e){
    $("#labour_card_print").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('labour_card_print.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#labour_card_print").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Labour Card Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104){
                    toastr.success("Labour Card Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#transaction_date_time').removeAttr('required');
$('#file_name').removeAttr('required');
$('#labour_card_expiry_date').removeAttr('required');




</script>

@endif
