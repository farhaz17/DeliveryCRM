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
<h5 class="modal-title" id="exampleModalCenterTitle">Medical </h5>

       {{-- medical normal --}}
   <div class="medical_normal card mb-4 card-hidden">
    <div class="card-body">
    <h5 class="modal-title mb-3" id="exampleModalCenterTitle" >Medical</h5>
    {{-- <form action ="{{ route('medical.store') }}" method="POST" enctype="multipart/form-data"> --}}
        <form id="medical_normal_form">
        {!! csrf_field() !!}




        <div class="row">
            <div class="col-md-12">
                @if(!isset($medical))
                <div class="row">
                    <div class="col-md-3">
                        <label class="radio radio-outline-primary">
                            <input type="radio" name="med_type" value="1" required><span>Medical (Normal)</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="radio radio-outline-primary">
                            <input type="radio" name="med_type" value="2" required><span>Medical (48 Hours)</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="radio radio-outline-primary">
                            <input type="radio" name="med_type" value="3" required><span>Medical (24 Hours)</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="radio radio-outline-primary">
                            <input type="radio" name="med_type" value="4"  required><span>Medical (VIP Hours)</span><span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                @else
                    @if ($medical->medical_type=='1')
                    <p><h4><b> Medical (Normal) </b></h4></p>
                    @elseif ($medical->medical_type=='2')
                    <p><h4><b> Medical (48 Hours)</b></h4></p>
                    @elseif($medical->medical_type=='3')
                    <p><h4><b>Medical (24 Hours)</b></h4></p>
                    @else
                    <p><h4><b>Medical (VIP)</b></h4></p>
                    @endif

            @endif




            </div>
            <div class="col-md-6">
                <label for="repair_category">Medical Transaction Number</label>
                <input class="form-control form-control"   value="{{isset($medical)?$medical->medical_tans_no:""}}"
                 @if(isset($medical)) readonly @endif
                  id="medical_tans_no" name="medical_tans_no"  type="number" placeholder="Medical Transaction Number" required />
            </div>

            <div class="col-md-6">
                <label for="repair_category">Medical Date</label>
                <input class="form-control form-control" value="{{isset($medical)?$medical->medical_date_time:""}}"
                @if(isset($medical)) readonly @endif id="transaction_date_time"
                       name="medical_date_time"  type="date" placeholder="Enter Expiry Date" required />
            </div>

            <div class="col-md-6">
                <label for="repair_category"> Attachment</label>

                @if(isset($medical))
                    @if($medical->attachment!=null)
                        <br>
                        @foreach (json_decode($medical->attachment) as $visa_attach)

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/medical/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                            <span>|</span>

                        @endforeach
                    @endif
                @else
                    <input class="form-control form-control" id="file_name"  name="renew_visa_attachment[]" multiple type="file"  />
                @endif
            </div>


            <div class="col-md-12">
                <br>
                <label class="checkbox checkbox-primary">
                    <input type="checkbox" id="payment_option7"><span>Payment Options</span><span class="checkmark"></span>
                </label>

            </div>
        </div>

        <div class="row payment_row"  id="payment7" style="display: none">


            <div class="col-md-3">
                <label for="repair_category">Payment Amount</label>
                <input class="form-control form-control" value="{{isset($medical)?$medical->payment_amount:""}}"
                @if(isset($medical)) readonly @endif  id="payment_amount" name="payment_amount"

                type="number" step="0.01" placeholder="Enter Payment"  />
            </div>
            <div class="col-md-6">
                <label for="repair_category">Fine Amount</label>
                <input class="form-control form-control" id="fine_amount" name="fine_amount"
                type="number" step="0.01" @if ($medical !=null) readonly

                       @endif  value="{{isset($medical)?$medical->payment_amount:""}}" placeholder="Payment Amount" />
            </div>
            <div class="col-md-3">
                <label for="repair_category">Payment Type</label>
                @if(isset($medical))

                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($medical)?'disabled':""}}  >

                        @php
                            $isSelected=(isset($medical)?$medical->payment_type:"")==$medical->id;
                        @endphp
                        <option value="{{isset($medical->payment_type)?$medical->payment_type:""}}">{{isset($medical->payment->payment_type)?$medical->payment->payment_type:""}}</option>


                    </select>
                @else
                    <select id="payment_type" name="payment_type" class="form-control" @if(isset($medical) || isset($med_48)|| isset($med_24)||isset($med_vip) ) disabled @endif>
                        <option value=""  >Select option</option>
                        @foreach($payment_type as $pay_type)
                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                        @endforeach

                    </select>
                @endif
            </div>
            <div class="col-md-3">
                <label for="repair_category">Transaction Number</label>
                <input class="form-control form-control" value="{{isset($medical)?$medical->transaction_no:""}}"
                @if(isset($medical)) readonly @endif  id="transaction_no" name="transaction_no"

                       type="text" placeholder="Enter Transaction Number"  />
            </div>
            <div class="col-md-3">
                <label for="repair_category">Transaction Date & Time</label>
                <input class="form-control form-control" value="{{isset($medical)?$medical->transaction_date_time:""}}"
                @if(isset($medical)) readonly @endif  id="transaction_date_time"

                       name="transaction_date_time" value=""  type="datetime-local" placeholder="Transaction Date & Time"  />
                <div id="datetime-1-holder"></div>                                            </div>
            <div class="col-md-3">
                <label for="repair_category">Vat</label>
                <input class="form-control form-control"  value="{{isset($medical)?$medical->vat:""}}"
                       @if(isset($medical)) readonly @endif id="vat" name="vat"  type="number"

                       placeholder="Enter Vat"  />
            </div>

            <div class="col-md-3">
                <label for="repair_category"> Attachment</label>

                @if(isset($medical))
                    @if($medical->other_attachments!=null)
                        <br>
                        @foreach (json_decode($medical->other_attachments) as $visa_attach2)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/medical/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                            <span>|</span>
                        @endforeach
                    @endif
                @else
                    <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
                @endif
            </div>
                <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
            </div>

        <div class="col-md-3  mt-2 form-group">
                <input  @if(isset($medical)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn10" data-toggle="modal" data-target="#confirm-submit10" class="btn btn-primary btn-save" />
        </div>
    </form>
</div>
   </div>

       {{-- medical vip ends here --}}


       {{-- <script>
             $("#medical").change(function () {
                        var med_val = ($('#medical').val());

                        if(med_val=='medical_normal'){
                            $(".medical_normal").show();
                            $(".medical_48").hide();
                            $(".medical_24").hide();
                            $(".medical_vip").hide();
                        }

                         else if(med_val=='medical_48'){
                            $(".medical_normal").hide();
                            $(".medical_48").show();
                            $(".medical_24").hide();
                            $(".medical_vip").hide();
                        }
                        else if(med_val=='medical_24'){
                            $(".medical_normal").hide();
                            $(".medical_48").hide();
                            $(".medical_24").show();
                            $(".medical_vip").hide();
                        }
                        else{
                            $(".medical_normal").hide();
                            $(".medical_48").hide();
                            $(".medical_24").hide();
                            $(".medical_vip").show();
                        }
                    }); --}}
       </script>


<script>
     $('#payment_option7').change(function() {
                                        if ($('#payment_option7').prop('checked')) {
                                            $('#payment7').show();
                                        } else {
                                            $('#payment7').hide();
                                        }
                                    });
                                    $('#payment_option8').change(function() {
                                        if ($('#payment_option8').prop('checked')) {
                                            $('#payment8').show();
                                        } else {
                                            $('#payment8').hide();
                                        }
                                    });

                                    $('#payment_option9').change(function() {
                                        if ($('#payment_option9').prop('checked')) {
                                            $('#payment9').show();
                                        } else {
                                            $('#payment9').hide();
                                        }
                                    });
                                    $('#payment_option10').change(function() {
                                        if ($('#payment_option10').prop('checked')) {
                                            $('#payment10').show();
                                        } else {
                                            $('#payment10').hide();
                                        }
                                    });
                                    $('#payment_option11').change(function() {
                                        if ($('#payment_option11').prop('checked')) {
                                            $('#payment11').show();
                                        } else {
                                            $('#payment11').hide();
                                        }
                                    });
</script>


<script>
    $(document).ready(function (e){
    $("#medical_normal_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('renewmedical_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#medical_normal_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("In-out Change Added Successfully!", { timeOut:10000 , progressBar : true});
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




