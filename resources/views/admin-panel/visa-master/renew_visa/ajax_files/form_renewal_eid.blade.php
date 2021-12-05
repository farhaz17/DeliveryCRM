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
<h5 class="modal-title" id="exampleModalCenterTitle">Emirates ID Apply</h5>

<form   id="eid_apply_form">
{!! csrf_field() !!}

<div class="row">
    <input type="hidden" name="action" value="add_form" />
    <div class="col-md-6">
        <label for="repair_category">Emirates ID App Expiry</label>

        <input class="form-control form-control" id="st_no" name="eid_exp" value="{{isset($eid_apply)?$eid_apply->e_id_app_expiry:""}}" @if ($eid_apply !=null) readonly @endif  type="date" placeholder="Enter Country Code" required />
    </div>



    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($eid_apply))
            @if($eid_apply->attachment!=null)
            <br>
            @foreach (json_decode($eid_apply->attachment) as $visa_attach)
            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/emirates_id_apply/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
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
            <input type="checkbox" id="payment_option"><span>Payment Options</span><span class="checkmark"></span>
        </label>
    </div>
</div>
<div class="row payment_row"  id="payment1" style="display: none">
    <div class="col-md-6">
        <label for="repair_category">Payment Amount</label>
        <input class="form-control form-control" id="payment_amount" name="payment_amount"
        type="number" step="0.01" @if ($eid_apply !=null) readonly

               @endif  value="{{isset($eid_apply)?$eid_apply->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Fine Amount</label>
        <input class="form-control form-control" id="fine_amount" name="fine_amount"
        type="number" step="0.01" @if ($eid_apply !=null) readonly

               @endif  value="{{isset($eid_apply)?$eid_apply->payment_amount:""}}" placeholder="Payment Amount" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Payment Type</label>
        @if(isset($eid_apply))
            <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($eid_apply)?'disabled':""}} >
                @php
                    $isSelected=(isset($eid_apply)?$eid_apply->payment_type:"")==$eid_apply->id;
                @endphp
                <option value="{{$eid_apply->payment_type}}">{{isset($eid_apply->payment->payment_type)?$eid_apply->payment->payment_type:""}}</option>
            </select>
        @else
            <select id="payment_type" @if ($eid_apply !=null) disabled

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
        <input class="form-control form-control" id="transaction_no" name="transaction_no" @if ($eid_apply !=null) readonly

        @endif
               type="text" value="{{isset($eid_apply)?$eid_apply->transaction_no:""}}" placeholder="Enter Country Code" />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Transaction Date</label>
        <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
        @if ($eid_apply !=null) readonly

        @endif  type="date" value="{{isset($eid_apply)?$eid_apply->transaction_date_time:""}}" placeholder="Enter Transaction Date"  />
        <div id="datetime-1-holder"></div>

                                                 </div>
    <div class="col-md-6">
        <label for="repair_category">Vat</label>
        <input class="form-control form-control" id="vat" name="vat"  type="number" step="0.01" value="{{isset($eid_apply)?$eid_apply->vat:""}}"
               @if(isset($eid_apply)) readonly @endif placeholder="Enter VAT"  />
    </div>


    <div class="col-md-6">
        <label for="repair_category"> Attachment</label>
        @if(isset($eid_apply))
        @if($eid_apply->other_attachment!=null)
            <br>
            @foreach (json_decode($eid_apply->other_attachment) as $visa_attach2)
            <a class="btn btn-success btn-file"  href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/emirates_id_apply/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}"
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

            <input @if(isset($eid_apply)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
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
$("#eid_apply_form").on('submit',(function(e){
    e.preventDefault();
    $.ajax({

        url: "{{ route('reneweid_apply_save') }}",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function () {
                        $("body").addClass("loading");
                },
        success: function(response){

            $("#eid_apply_form").trigger("reset");
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

