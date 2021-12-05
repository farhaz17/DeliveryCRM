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
    .btn-file
    {
    padding: 0px;
    }
</style>
<div class="overlay"></div>
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Stamping</h5>
@if(isset($visa_stamp))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif
    <form  id='visa_stamp_form'>
    {!! csrf_field() !!}
    <div class="row">
    {{-- <div class="col-md-6">
        <label for="repair_category">Type</label>
        @if(isset($visa_stamp))
            <select id="type" name="type" class="form-control form-control"  required {{isset($visa_stamp)?'disabled':""}}>
                @if($visa_stamp->status=="1")
                <option value="{{$visa_stamp->type}}" selected disabled >Urgent</option>
                @else
                <option value="{{$visa_stamp->type}}" selected disabled>Normal</option>
                    @endif
            </select>
        @else
        <select id="type" name="type" class="form-control form-control"  required  >
            <option >Select option</option>
            <option value="1">Urgent</option>
            <option value="0">Normal</option>
        </select>
            @endif

    </div> --}}
    <div class="col-md-6">
        <label for="repair_category">Status</label>
        @if(isset($visa_stamp))
            <select id="type" name="type" class="form-control form-control"  required {{isset($visa_stamp)?'disabled':""}}>
                <option value="1"  @if($visa_stamp->types=="1")  selected  @endif  >Urgent</option>
                <option value="0" @if($visa_stamp->types=="0") selected  @endif>Normal</option>
            </select>
        @else
        <select id="type" name="type" class="form-control form-control"  required  >
            <option >Select option</option>
            <option value="1">Urgent</option>
            <option value="0">Normal</option>
        </select>
            @endif
    </div>

    <input type="hidden" name="request_id"  value="{{isset($visa_stamp)?$visa_stamp->id:""}}">


        {{-- <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount" id="payment_amount"   value="{{isset($visa_stamp)?$visa_stamp->payment_amount:""}}"  @if(isset($visa_stamp)) readonly @endif  name="payment_amount"  type="text" placeholder="Enter Payment" required />
        </div> --}}

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($visa_stamp))
                @if($visa_stamp->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($visa_stamp->visa_attachment) as $visa_attach)

                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/VisaStamping/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(13, 13, 15)">View Attachment</strong>
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
                <input type="checkbox" value="1" name="payment_checkbox" id="payment_option14" @if(isset($payment_visa_stamp))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>

    <div class="row payment_row"  id="payment14" @if(isset($payment_visa_stamp))   @else  style="display: none"   @endif >
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_new_contract_sub)) value="390" @else value="{{isset($payment_visa_stamp)?$payment_visa_stamp->payment_amount:""}}" @endif
                   @if(isset($payment_entry_date)) readonly @endif id="payment_amount" name="payment_amount"  type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_visa_stamp !=null) disabled @endif    name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_visa_stamp)?$payment_visa_stamp->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">

            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_visa_stamp !=null) readonly
                          @endif  value="{{isset($payment_visa_stamp)?$payment_visa_stamp->fine_amount:""}}" placeholder="Fine Amount" />
         </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"    value="{{isset($payment_visa_stamp)?$payment_visa_stamp->transaction_no:""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_new_contract_sub)) value="3.5" @else value="{{isset($payment_visa_stamp)?$payment_visa_stamp->vat:""}}" @endif     @if(isset($visa_stamp)) readonly @endif id="vat" name="vat"  type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>

            <input class="form-control form-control"      value="{{isset($payment_visa_stamp)?Carbon\Carbon::parse($payment_visa_stamp->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="date" placeholder="Transaction Date "  />
            <div id="datetime-1-holder"></div>

        </div>


        <div class="col-md-6">
            <label for="repair_category">Service Charges</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_visa_stamp)) value="3.15" @else value="{{isset($payment_visa_stamp)?$payment_visa_stamp->service_charges:""}}" @endif     @if(isset($visa_stamp)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'  placeholder="Enter Service Charges"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($payment_visa_stamp))
                @if($payment_visa_stamp->other_attachment!=null)
                    <br>
                    @foreach(json_decode($payment_visa_stamp->other_attachment) as $visa_attach2)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/VisaStamping/other_attachments/'.$visa_attach2,
                    now()->addMinutes(5))}}" id="passport_image" target="_blank">
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


         <!----row---------->

        </div>
    <div class="col-md-6 mt-2 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">

            <input @if(isset($visa_stamp)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit21" class="btn btn-primary btn-save" />


    </div>
</form>
<script>

    $("#edit_data" ).click(function() {

        $('#type').removeAttr('disabled');
        $('#payment_amount').removeAttr('required');
        $('#file_name').removeAttr('required');

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
    $(document).ready(function (e){
    $("#visa_stamp_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('visa_stamp.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#visa_stamp_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Visa Stamp Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104) {
                    toastr.success("Visa Stamp Updated Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
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
<script>
          $('#payment_option14').change(function() {
                                        if ($('#payment_option14').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment14').show();
                                        } else {
                                            $('#payment_type').removeAttr('required');
                                            $('#payment14').hide();
                                        }
                                    });
</script>
@if($req=='1')
<script>
$('#payment_amount').removeAttr('required');
$('#file_name').removeAttr('required');



</script>

@endif

@if($req=='1' && !isset($payment_visa_stamp))
<script>
$('#payment_amount').removeAttr('value');
$('#vat').removeAttr('value');
$('#service_charges').removeAttr('value');



</script>
@endif
