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
<h5 class="modal-title" id="exampleModalCenterTitle">Own Visa anas</h5>
{{-- <form   role="form" action ="{{ route('own_visa_sub.store') }}" id="own_visa_sub_form" method="post"  enctype="multipart/form-data" onsubmit="return validateForm();"   enctype="multipart/form-data"> --}}

<form   id="own_visa_sub_form">
{!! csrf_field() !!}

<div class="row">
    <input type="hidden" name="action" value="add_form" />


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($own_visa_sub))
            @if($own_visa_sub->attachment!=null)
            <br>
            @foreach (json_decode($own_visa_sub->attachment) as $visa_attach)
            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/own_visa/own_contract_sub/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                <strong style="color: #000000">  View Attachment</strong>
            </a>
                <span>|</span>
            @endforeach
            @endif
        @else
            <input class="form-control form-control" id="file_name"  name="attachment[]" multiple type="file"  />
        @endif
    </div>

    <div class="col-md-6">
        <label for="repair_category">MB No</label>
        <input class="form-control form-control" id="mb_no" name="mb_no" @if ($own_visa_sub !=null) readonly

        @endif
               type="text" value="{{isset($own_visa_sub)?$own_visa_sub->mb_no:""}}" placeholder="Enter Country Code" />
    </div>
    @if(isset($own_visa_sub))
    <div class="col-md-6">
        <label for="repair_category">Added By</label>
        <input class="form-control form-control" value="{{$own_visa_sub->user_detail->name}}" @if ($own_visa_sub !=null) readonly
        @endif
               type="text"  />
    </div>
    @endif

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
               type="text" @if ($own_visa_sub_pay !=null) readonly

               @endif  value="{{isset($own_visa_sub_pay)?$own_visa_sub_pay->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Payment Type</label>
        @if(isset($own_visa_sub_pay))
            <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($own_visa_sub_pay)?'disabled':""}} >
                @php
                    $isSelected=(isset($own_visa_sub_pay)?$own_visa_sub_pay->payment_type:"")==$own_visa_sub_pay->id;
                @endphp
                <option value="{{$own_visa_sub_pay->payment_type}}">{{isset($own_visa_sub_pay->payment->payment_type)?$own_visa_sub_pay->payment->payment_type:""}}</option>
            </select>
        @else
            <select id="payment_type" @if ($own_visa_sub !=null) disabled

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
        <input class="form-control form-control" id="transaction_no" name="transaction_no" @if ($own_visa_sub_pay !=null) readonly

        @endif
               type="text" value="{{isset($own_visa_sub_pay)?$own_visa_sub_pay->transaction_no:""}}" placeholder="Enter Country Code" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Transaction Date</label>
        <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
        @if ($own_visa_sub_pay !=null) readonly

        @endif  type="date" value="{{isset($own_visa_sub_pay)?$own_visa_sub_pay->transaction_date:""}}" placeholder="Enter Transaction Date"  />
        <div id="datetime-1-holder"></div>

                                                 </div>
    <div class="col-md-6">
        <label for="repair_category">Vat</label>
        <input class="form-control form-control" id="vat" name="vat"  type="number" value="{{isset($own_visa_sub_pay)?$own_visa_sub_pay->vat:""}}"
               @if(isset($own_visa_sub)) readonly @endif placeholder="Enter VAT"  />
    </div>


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($own_visa_sub_pay))
        @if($own_visa_sub_pay->other_attachment!=null)
            <br>
            @foreach (json_decode($own_visa_sub_pay->other_attachment) as $visa_attach2)
            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/own_visa/own_contract_sub/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}"
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

            <input @if(isset($own_visa_sub_pay)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
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
$("#own_visa_sub_form").on('submit',(function(e){
    e.preventDefault();
    $.ajax({

        url: "{{ route('own_contract_sub_save') }}",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function () {
                        $("body").addClass("loading");
                },
        success: function(response){
            $("#own_visa_sub_form").trigger("reset");
            if(response.code == 100) {
                toastr.success("Own Visa Contract Typing Added Successfully!", { timeOut:10000 , progressBar : true});
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
