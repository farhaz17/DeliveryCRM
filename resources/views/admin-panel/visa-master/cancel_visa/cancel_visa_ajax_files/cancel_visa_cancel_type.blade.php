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
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Cancellation Typing(MOL)</h5>
{{-- <form   role="form" action ="{{ route('cancel_typing.store') }}" id="cancel_typing_form" method="post"  enctype="multipart/form-data" onsubmit="return validateForm();"   enctype="multipart/form-data"> --}}

<form   id="cancel_typing_form">
{!! csrf_field() !!}

<div class="row">
    <input type="hidden" name="action" value="add_form" />
    <div class="col-md-12">
        <label for="repair_category">Date</label>
        <input class="form-control form-control" id="cancel_date" value="{{isset($cancel_typing)?Carbon\Carbon::parse($cancel_typing->cancel_date)->format('Y-m-d'):""}}"  name="cancel_date" multiple type="date"  />
    </div>



    <div class="col-md-12">
        <label for="repair_category"> Attachment</label>
        @if(isset($cancel_typing))
            @if($cancel_typing->attachment!=null)
            <br>
            @foreach (json_decode($cancel_typing->attachment) as $visa_attach)
            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/visa_cencel/contract_typing/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                <strong style="color: #000000">  View Attachment</strong>
            </a>
                <span>|</span>
            @endforeach
            @endif
        @else
            <input class="form-control form-control" id="file_name"  name="renew_visa_attachment[]" multiple type="file"  />
        @endif
    </div>

    <br><br><br><br>



    <!----------optional-Data-->

    <div class="col-md-12">
        <label class="checkbox checkbox-primary">
            <input type="checkbox" id="payment_option" name="payment_option" name="payment_option"><span>Payment Options (Optional)</span><span class="checkmark"></span>
        </label>
    </div>
</div>
<div class="row payment_row"  id="payment1" style="display: none">
    <div class="col-md-6">
        <label for="repair_category">Payment Amount</label>
        <input class="form-control form-control" id="payment_amount" name="payment_amount"
               type="text" @if ($cancel_typing_pay !=null) readonly

               @endif  value="{{isset($cancel_typing_pay)?$cancel_typing_pay->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Payment Type</label>
        @if(isset($cancel_typing_pay))
            <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($cancel_typing_pay)?'disabled':""}} >
                @php
                    $isSelected=(isset($cancel_typing_pay)?$cancel_typing_pay->payment_type:"")==$cancel_typing_pay->id;
                @endphp
                <option value="{{$cancel_typing_pay->payment_type}}">{{isset($cancel_typing_pay->payment->payment_type)?$cancel_typing_pay->payment->payment_type:""}}</option>
            </select>
        @else
            <select id="payment_type" @if ($cancel_typing !=null) disabled

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
        <input class="form-control form-control" id="transaction_no" name="transaction_no" @if ($cancel_typing_pay !=null) readonly

        @endif
               type="text" value="{{isset($cancel_typing_pay)?$cancel_typing_pay->transaction_no:""}}" placeholder="Enter Country Code" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Transaction Date</label>
        <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
        @if ($cancel_typing_pay !=null) readonly

        @endif  type="date" value="{{isset($cancel_typing_pay)?$cancel_typing_pay->transaction_date:""}}" placeholder="Enter Transaction Date"  />
        <div id="datetime-1-holder"></div>

                                                 </div>
    <div class="col-md-6">
        <label for="repair_category">Vat</label>
        <input class="form-control form-control" id="vat" name="vat"  type="number" value="{{isset($cancel_typing_pay)?$cancel_typing_pay->vat:""}}"
               @if(isset($cancel_typing_pay)) readonly @endif placeholder="Enter VAT"  />
    </div>


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($cancel_typing_pay))
        @if($cancel_typing_pay->other_attachment!=null)
            <br>
            @foreach (json_decode($cancel_typing_pay->other_attachment) as $visa_attach2)
            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/visa_cencel/contract_typing/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}"
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

            <input @if(isset($cancel_typing_pay)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
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
$("#cancel_typing_form").on('submit',(function(e){
    e.preventDefault();
    $.ajax({

        url: "{{ route('renewcancel_typing_save') }}",
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
