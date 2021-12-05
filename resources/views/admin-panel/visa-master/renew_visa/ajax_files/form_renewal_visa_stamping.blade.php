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
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Stamping</h5>
    <form  id='visa_stamp_form'>
    {!! csrf_field() !!}


    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control"   value="{{isset($visa_stamp)?$visa_stamp->visa_stamping_payment_option:""}}"  @if(isset($visa_stamp)) readonly @endif id="payment_amount" name="visa_stamping_payment_option"  type="text" placeholder="Enter Payment" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($visa_stamp))
                @if($visa_stamp->attachment!=null)
                    <br>
                    @foreach (json_decode($visa_stamp->attachment) as $visa_attach)

                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/renew_visa_stamping/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(13, 13, 15)">View Attachment</strong>
                    </a>

                        <span>|</span>




                    @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple

                       type="file"  />
            @endif
        </div>

        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" id="payment_option14"><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>

    <div class="row payment_row"  id="payment14" style="display: none">
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control" id="payment_amount" name="payment_amount"
            type="number" step="0.01" @if ($visa_stamp !=null) readonly
                   @endif  value="{{isset($visa_stamp)?$visa_stamp->payment_amount:""}}" placeholder="Payment Amount" />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
            <input class="form-control form-control" id="fine_amount" name="fine_amount"
            type="number" step="0.01" @if ($visa_stamp !=null) readonly

                   @endif  value="{{isset($visa_stamp)?$visa_stamp->payment_amount:""}}" placeholder="Payment Amount" />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            @if(isset($visa_stamp))

                <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($visa_stamp)?'disabled':""}}  @if($visa_stamp=='22')  @else disabled @endif>

                    @php
                        $isSelected=(isset($visa_stamp)?$visa_stamp->payment_type:"")==$visa_stamp->id;
                    @endphp
                    <option value="{{isset($visa_stamp->payment_type)?$visa_stamp->payment_type:""}}">{{isset($elec_pre_app->payment->payment_type)?$elec_pre_app->payment->payment_type:""}}</option>


                </select>
            @else
                <select id="payment_type" name="payment_type" class="form-control" >
                    <option value=""  >Select option</option>
                    @foreach($payment_type as $pay_type)
                        <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                    @endforeach

                </select>
            @endif
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"    value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date & Time</label>
            <input class="form-control form-control"    value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="datetime-local" placeholder="Transaction Date & Time"  />
            <div id="datetime-1-holder"></div>                                            </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control"   value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="vat" name="vat" type="number" step="0.01" placeholder="Enter Vat"  />
        </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($visa_stamp))
                @if($visa_stamp->other_attachment!=null)
                    <br>
                    @foreach(json_decode($visa_stamp->other_attachment) as $visa_attach2)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/renew_visa_stamping/other_attachments/'.$visa_attach2,
                    now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>
                        <span>|</span>
                    @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif
        </div>




        <div class="col-md-6">
            <label for="repair_category">Type</label>
            @if(isset($visa_stamp))
                <select id="type" name="type" class="form-control form-control"  required {{isset($visa_stamp)?'disabled':""}}>
                    @php
                        $isSelected=(isset($visa_stamp)?$visa_stamp->type:"")==$visa_stamp->id;
                    @endphp
                    @if($visa_stamp->type=="Cash")
                        <option value="{{$visa_stamp->type}}">Cash</option>
                    @else
                        <option value="{{$visa_stamp->type}}">Online</option>
                    @endif

                </select>
            @else
            <select id="type" name="type" class="form-control"  >
                <option value=""  >Select option</option>
                <option value="Cash">Cash</option>
                <option value="online">Online</option>
            </select>
                @endif
        </div>

            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />


         <!----row---------->

        </div>
    <div class="col-md-6 mt-2 form-group">
            <input @if(isset($visa_stamp)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn21" data-toggle="modal" data-target="#confirm-submit21" class="btn btn-primary btn-save" />
    </div>
</form>

<script>
    $(document).ready(function (e){
    $("#visa_stamp_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('renew_visa_stamp_save') }}",
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
                                            $('#payment14').show();
                                        } else {
                                            $('#payment14').hide();
                                        }
                                    });
</script>
