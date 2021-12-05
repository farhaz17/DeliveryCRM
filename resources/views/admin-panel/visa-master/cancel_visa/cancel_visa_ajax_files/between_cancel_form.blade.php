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
<h5 class="modal-title" id="exampleModalCenterTitle">
    Visa Cancellation At -
    @if($visa_process_step_id=='2')
    Offer Letter
@elseif($visa_process_step_id=='3')
Offer Letter Submission
@elseif($visa_process_step_id=='4')
Electronic Pre Approval
@elseif($visa_process_step_id=='5')
Electronic Pre Approval Payment
@elseif($visa_process_step_id=='6')
Print Visa Inside/Outside
@elseif($visa_process_step_id=='7')
Unique Emirates ID Received

@elseif($visa_process_step_id=='8')
Status Change
@elseif($visa_process_step_id=='9')
In-Out Status Change
@elseif($visa_process_step_id=='10')
Entry Date
@elseif($visa_process_step_id=='11')
Medical
@elseif($visa_process_step_id=='12')
Medical
@elseif($visa_process_step_id=='13')
Medical
@elseif($visa_process_step_id=='14')
Medical
@elseif($visa_process_step_id=='15')
Fit/Unfit
@elseif($visa_process_step_id=='16')
Emirates ID Apply
@elseif($visa_process_step_id=='17')
Emirates ID Finger Print(Yes/No)
@elseif($visa_process_step_id=='18')
New Contract Application Typing
@elseif($visa_process_step_id=='19')
Tawjeeh Class
@elseif($visa_process_step_id=='20')
New Contract Submission
@elseif($visa_process_step_id=='21')
Labour Card Print
@elseif($visa_process_step_id=='22')
Visa Stamping Application(Urgent/Normal)
@elseif($visa_process_step_id=='23')
Waiting For Approval(Urgent/Normal)
@elseif($visa_process_step_id=='24')
aiting For Zajeel
@elseif($visa_process_step_id=='25')
Visa Pasted
@elseif($visa_process_step_id=='26')
Unique Emirates ID Received
@else
Unique Emirates ID Handover
    @endif

</h5>
{{-- <form   role="form" action ="{{ route('cancel_cancel.store') }}" id="cancel_cancel_form" method="post"  enctype="multipart/form-data" onsubmit="return validateForm();"   enctype="multipart/form-data"> --}}

    @if(isset($remarks))
  <div class="row">
    <div class="col-md-12">
        <label for="repair_category"> Cencellation Remarks</label>
        <textarea  class="form-control" name="" id="" cols="30" rows="4" readonly>{{$remarks->remarks}}</textarea>
    </div>
    <div class="col-md-12">
        <label for="repair_category"> Requested By</label>
        <input  class="form-control" value="{{$remarks->user_detail->name}}" id="" cols="30" rows="4" readonly>

  </div>
    @endif
<form   id="between_cancel_form">
{!! csrf_field() !!}
<div class="row">
    <input type="hidden" name="action" value="add_form" />


    <div class="col-md-12">
        <label for="repair_category"> Attachment</label>
        @if(isset($between))
            @if($between->attachment!=null)
            <br>
            @foreach (json_decode($between->attachment) as $visa_attach)
            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/visa_cencel/between_cancel/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                <strong style="color: #000000">  View Attachment</strong>
            </a>
                <span>|</span>
            @endforeach
            @endif
        @else
            <input class="form-control form-control" id="visa_cancel_attachment"  name="visa_cancel_attachment[]" multiple type="file"  />
        @endif
    </div>

    <br><br><br><br>



    <!----------optional-Data-->

    <div class="col-md-12">
        <label class="checkbox checkbox-primary">
            <input type="checkbox" id="payment_option"><span>Payment Options (Optional)</span><span class="checkmark"></span>
        </label>
    </div>
</div>
<div class="row payment_row"  id="payment1" style="display: none">
    <div class="col-md-6">
        <label for="repair_category">Payment Amount</label>
        <input class="form-control form-control" id="payment_amount" name="payment_amount"
        type="number" step="0.01" @if ($between !=null) readonly

               @endif  value="{{isset($between)?$between->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Payment Type</label>
        @if(isset($between))
            <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($between)?'disabled':""}} >
                @php
                    $isSelected=(isset($between)?$between->payment_type:"")==$between->id;
                @endphp
                <option value="{{$between->payment_type}}">{{isset($between->payment->payment_type)?$between->payment->payment_type:""}}</option>
            </select>
        @else
            <select id="payment_type" @if ($between !=null) disabled

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
        <input class="form-control form-control" id="transaction_no" name="transaction_no" @if ($between !=null) readonly

        @endif
               type="text" value="{{isset($between)?$between->transaction_number:""}}" placeholder="Enter Country Code" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Transaction Date</label>
        <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
        @if ($between !=null) readonly

        @endif  type="date" value="{{isset($between)?$between->transaction_date:""}}" placeholder="Enter Transaction Date"  />
        <div id="datetime-1-holder"></div>

                                                 </div>
    <div class="col-md-6">
        <label for="repair_category">Vat</label>
        <input class="form-control form-control" id="vat" name="vat"  type="number" value="{{isset($between)?$between->vat:""}}"
               @if(isset($between)) readonly @endif placeholder="Enter VAT"  />
    </div>


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($between))
        @if($between->other_attachment!=null)
            <br>
            @foreach (json_decode($between->other_attachment) as $visa_attach2)
            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/visa_cencel/between_cancel/other_attachments//'.$visa_attach2, now()->addMinutes(5))}}"
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



        <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $passport_id  }}"  type="hidden"/>
        <input class="form-control form-control" id="visa_process_id" name="visa_process_id" value="{{ $visa_process_step_id  }}"  type="hidden"/>


</div>




        <div class="col-md-6 mt-2 form-group">
            <input @if(isset($between)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
        </div>
    {{-- @endif --}}
</form>

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
    // between_cancel_save
$("#between_cancel_form").on('submit',(function(e){
    alert
    e.preventDefault();
            $.ajax({
        url: "{{ route('between_cancel_save') }}",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function ()
        {
         $("body").addClass("loading");
                },
        success: function(response){
            $("#between_cancel_form").trigger("reset");
            if(response.code == 100) {
                toastr.success("Waiting for Approval Added Successfully!", { timeOut:10000 , progressBar : true});
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
