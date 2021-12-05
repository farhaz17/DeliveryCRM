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
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Cancel Approval(Immigration)</h5>
{{-- <form   role="form" action ="{{ route('cancel_typing.store') }}" id="cancel_typing_form" method="post"  enctype="multipart/form-data" onsubmit="return validateForm();"   enctype="multipart/form-data"> --}}

<form   id="cancel_typing_form">
{!! csrf_field() !!}

<div class="row">

    <div class="col-md-12">
        <label for="repair_category">Date</label>
        <input class="form-control form-control" value="{{isset($cancel_approval)?Carbon\Carbon::parse($cancel_approval->cancel_date)->format('Y-m-d'):""}}"   id="cancel_date"  name="cancel_date" multiple type="date"  />
    </div>

        <div class="col-md-12">
            <label for="repair_category">Status</label>
            @if(isset($cancel_approval))
                <select id="decline_status" name="decline_status" class="form-control form-control"
                  required {{isset($cancel_approval)?'disabled':""}} >
                    @php
                        $isSelected= $cancel_approval->decline_status;
                    @endphp
                    @if($isSelected=='1')
                    <option value="1">Decline</option>
                    @else
                     <option value="2">Approved</option>
                     @endif
                </select>
            @else
                <select id="decline_status" @if ($cancel_approval !=null) disabled
                @endif   name="decline_status" class="form-control">
                    <option value=""  >Select option</option>
                   <option value="2">Approved</option>
                   <option value="1">Decline</option>
                </select>
            @endif
        </div>


        <div class="col-md-12" id="attachment" @if(isset($cancel_approval) && $cancel_approval->attachment)  @else style="display: none" @endif>
            <label for="repair_category"> Attachment</label>
            @if(isset($cancel_approval))
                @if($cancel_approval->attachment!=null)
                <br>
                @foreach (json_decode($cancel_approval->attachment) as $visa_attach)
                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/visa_cencel/visa_cancel_approval/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                    <strong style="color: #000000">  View Attachment</strong>
                </a>
                    <span>|</span>
                @endforeach
                @endif
            @else
                <input class="form-control form-control" id="attachment_file"  name="renew_visa_attachment[]" multiple type="file"  />
            @endif
        </div>


        <div class="col-md-12" id="remarks_div" @if(isset($cancel_approval) && $cancel_approval->decline_status == '1')  @else style="display: none" @endif >
            <label for="repair_category">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control form-control" cols="30" rows="5" type="text" @if ($cancel_approval !=null) readonly @endif  value="{{isset($cancel_approval)?$cancel_approval->remarks:""}}" placeholder="Add Remarks">{{isset($cancel_approval)?$cancel_approval->remarks:""}}</textarea>
        </div>

    <br><br><br><br>



    <!----------optional-Data-->

    <div class="col-md-12" id="payment_option_check" @if(isset($cancel_approval) && $cancel_approval->attachment)  @else style="display: none" @endif>
        <label class="checkbox checkbox-primary">
            <input type="checkbox" id="payment_option" name="payment_option"><span>Payment Options (Optional)</span><span class="checkmark"></span>
        </label>
    </div>
</div>
<div class="row payment_row"  id="payment1" style="display: none">
    <div class="col-md-6">
        <label for="repair_category">Payment Amount</label>
        <input class="form-control form-control" id="payment_amount" name="payment_amount"
               type="text" @if ($cancel_approval_pay !=null) readonly

               @endif  value="{{isset($cancel_approval_pay)?$cancel_approval_pay->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Payment Type</label>
        @if(isset($cancel_approval_pay))
            <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($cancel_approval_pay)?'disabled':""}} >
                @php
                    $isSelected=(isset($cancel_approval_pay)?$cancel_approval_pay->payment_type:"")==$cancel_approval_pay->id;
                @endphp
                <option value="{{$cancel_approval_pay->payment_type}}">{{isset($cancel_approval_pay->payment->payment_type)?$cancel_approval_pay->payment->payment_type:""}}</option>
            </select>
        @else
            <select id="payment_type" @if ($cancel_approval !=null) disabled

            @endif   name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                    <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                @endforeach
            </select>
        @endif
    </div>




    <div class="col-md-6">
        <label for="repair_category">Transaction Number</label>
        <input class="form-control form-control" id="transaction_no" name="transaction_no" @if ($cancel_approval_pay !=null) readonly

        @endif
               type="text" value="{{isset($cancel_approval_pay)?$cancel_approval_pay->transaction_no:""}}" placeholder="Enter Country Code" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Transaction Date</label>
        <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
        @if ($cancel_approval_pay !=null) readonly

        @endif  type="date" value="{{isset($cancel_approval_pay)?$cancel_approval_pay->transaction_date:""}}" placeholder="Enter Transaction Date"  />
        <div id="datetime-1-holder"></div>

                                                 </div>
    <div class="col-md-6">
        <label for="repair_category">Vat</label>
        <input class="form-control form-control" id="vat" name="vat"  type="number" value="{{isset($cancel_approval_pay)?$cancel_approval_pay->vat:""}}"
               @if(isset($cancel_approval_pay)) readonly @endif placeholder="Enter VAT"  />
    </div>


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($cancel_approval_pay))
        @if($cancel_approval_pay->other_attachment!=null)
            <br>
            @foreach (json_decode($cancel_approval_pay->other_attachment) as $visa_attach2)
            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/visa_cencel/visa_cancel_approval/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}"
                 target="_blank">
                 <strong style="color: #000000">  View Attachment</strong>
            </a>
                <span>|</span>
            @endforeach
            @endif
        @else


            <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
        @endif
    </div>



        <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"/>

</div>




        <div class="col-md-6 mt-2 form-group">

            <input @if(isset($cancel_approval_pay)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
        </div>
    {{-- @endif --}}
</form>






<script>
    $(document).ready(function(e) {
    $("#decline_status").change(function(){
        var decline_status = $(":selected",this).val();
        //2 means decline status is approved
        if(decline_status=='2'){
            $('#attachment').show();
            $('#payment_option_check').show();
            $('#remarks_div').hide();

            $("#attachment_file").prop('required',true);
            $("#remarks").prop('required',false);

        }
        else{
            $('#attachment').hide();
            $('#payment_option_check').hide();
            $('#remarks_div').show();

            $("#remarks").prop('required',true);
            $("#attachment_file").prop('required',false);
        }
    })
});
</script>



<script>
$(document).ready(function () {
                             $('.payment_row').hide();

                             $('#payment_option').change(function() {
                                 if ($('#payment_option').prop('checked')) {
                                     $('#payment1').show();
                                 } else {
                                     $('#payment1').hide();
                                 }
                             });
                             });
</script>


<script>
$(document).ready(function (e){
$("#cancel_typing_form").on('submit',(function(e){
    e.preventDefault();
    $.ajax({

        url: "{{ route('cancel_visa_approcal_save') }}",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function () {
                        $("body").addClass("loading");
                },
        success: function(response){

            $("#cancel_typing_form").trigger("reset");
            if(response.code == 100) {
                toastr.success("Contract Typing Added Successfully!", { timeOut:10000 , progressBar : true});

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
