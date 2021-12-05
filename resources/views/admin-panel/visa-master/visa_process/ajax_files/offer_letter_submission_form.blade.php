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
@if(isset($offer_sub_letter))
@if($offer_sub_letter->replace_status=='1')

<a id="edit_data"  href="javascript:void(0)" style="float: right;"> <span class="badge badge-pill badge-danger m-2">Add New Dertail</span></a>

@endif
@endif

@if(isset($offer_sub_letter))
@if($offer_sub_letter->replace_status=='2')

 <span class="badge badge-pill badge-success m-2">Replaced Data</span>

@endif
@endif

@if(isset($offer_sub_letter))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" class="mt-2" style="float: right;">Edit</a>
@endhasanyrole
@endif
<h5 class="modal-title" id="exampleModalCenterTitle">Offer Letter Submission</h5>

{{-- <form action ="{{ route('offer_letter_sub.store') }}" method="POST" enctype="multipart/form-data"> --}}
    <form id="offer_letter_submit">
                            {!! csrf_field() !!}
        <div class="row">
                                <div class="col-md-6">
                                    <label for="repair_category">MB Number</label>
                                    <input class="form-control form-control" id="mb_no" name="mb_no" value="{{isset($offer_sub_letter)?$offer_sub_letter->mb_no:""}}"
                                           @if(isset($offer_sub_letter)) readonly @endif  type="text" placeholder="Enter MB Number" required />
                                           <input type="hidden" name="request_id"  value="{{isset($offer_sub_letter)?$offer_sub_letter->id:""}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Date</label>
                                    <input class="form-control form-control" id="offer_date_and_time" name="date_and_time" placeholder="Enter date and time"
                                    @if (!isset($offer_sub_letter))
                                    value="{{Carbon\Carbon::today()->format('Y-m-d')}}"
                                    @endif
                                    value="{{isset($offer_sub_letter)? Carbon\Carbon::parse($offer_sub_letter->date_and_time)->format('Y-m-d'):""}}"  @if(isset($offer_sub_letter)) readonly @endif
                                           type="date"   required />
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category"> Attachment</label>
                                    @if(isset($offer_sub_letter))
                                        @if($offer_sub_letter->visa_attachment!=null)
                                            <br>
                                            @foreach (json_decode($offer_sub_letter->visa_attachment) as $visa_attach)

                                            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/OfferLetterSubmission/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                                                <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                                            </a>

{{--
                                                <a class="attachment_display" href="{{isset($offer_sub_letter->visa_attachment)?url('assets/upload/OfferLetterSubmission/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                    <strong style="color: blue">View Attachment</strong>
                                                </a> --}}
                                                <span>|</span>

                                            @endforeach
                                        @endif
                                        <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />

                                    @else
                                        <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple

                                               type="file"  />
                                    @endif
                                </div>
                                <br><br><br>
                                <div class="col-md-12">
                                    <br>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox"  value="1" name="payment_checkbox" id="payment_option" @if(isset($payment_offer_sub_letter))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="row payment_row"  id="payment1" @if(isset($payment_offer_sub_letter))   @else  style="display: none"   @endif >
                                <div class="col-md-6">
                                    <label for="repair_category">Payment Amount</label>
                                    <input class="form-control form-control sum_amount" id="payment_amount"
                                           value="{{isset($payment_offer_sub_letter)?$payment_offer_sub_letter->payment_amount:""}}"  @if(isset($payment_offer_sub_letter)) readonly @endif
                                           name="payment_amount"  type="number" step="0.01"

                                           placeholder="Enter Country Code"  />
                            </div>

                            <div class="col-md-6">
                                <label for="repair_category">Payment Type</label>
                                <select id="payment_type" @if ($payment_offer_sub_letter !=null) disabled @endif    name="payment_type" class="form-control">
                                    <option value=""  >Select option</option>
                                    @foreach($payment_type as $pay_type)
                                    @php
                                    $isSelected=(isset($payment_offer_sub_letter)?$payment_offer_sub_letter->payment_type:"")==$pay_type->id;
                                @endphp
                                        <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                                    @endforeach
                                </select>
                            </div>

                                <div class="col-md-6">
                                    <label for="repair_category">Fine Amount</label>
                                           <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                                           type="number" step="0.01" @if ($payment_offer_sub_letter !=null) readonly
                                                  @endif  value="{{isset($payment_offer_sub_letter)?$payment_offer_sub_letter->fine_amount:""}}" placeholder="Payment Amount" />
                                 </div>


                                <div class="col-md-6">
                                    <label for="repair_category">Transaction Number</label>
                                    <input class="form-control form-control" id="transaction_no"
                                           value="{{isset($payment_offer_sub_letter)?$payment_offer_sub_letter->transaction_no:""}}"  @if(isset($payment_offer_sub_letter)) readonly @endif

                                           name="transaction_no"  type="text" placeholder="Enter Transaction Number"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Vat</label>
                                    <input class="form-control form-control sum_amount" id="vat" name="vat" value="{{isset($payment_offer_sub_letter)?$payment_offer_sub_letter->vat:""}}"
                                           @if(isset($payment_offer_sub_letter)) readonly @endif type="number" step="0.01" min='0'

                                           placeholder="Enter Country Code"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Transaction Date</label>
                                    <input class="form-control form-control" id="transaction_date_time"

                                           value="{{isset($payment_offer_sub_letter)?Carbon\Carbon::parse($payment_offer_sub_letter->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($payment_offer_sub_letter)) readonly @endif

                                           name="transaction_date_time" value=""  type="date" placeholder="Transaction Date & Time"/>
                                    <div id="datetime-1-holder"></div>
                                                                          </div>
                                    <div class="col-md-6">
                                        <label for="repair_category">Service Charges</label>
                                        <input class="form-control form-control sum_amount"   value="{{isset($payment_offer_sub_letter)?$payment_offer_sub_letter->service_charges:""}}"
                                          @if(isset($offer_sub_letter)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'
                                           placeholder="Enter Service Charges"  />
                                    </div>



                                <div class="col-md-6">
                                    <label for="repair_category"> Attachment</label>
                                    @if(isset($payment_offer_sub_letter))
                                        @if($payment_offer_sub_letter->other_attachment!=null)
                                            <br>
                                            @foreach (json_decode($payment_offer_sub_letter->other_attachment) as $visa_attach2)

                                            <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/OfferLetterSubmission/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                                                <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                                            </a>

                                                <span>|</span>

                                            @endforeach
                                        @endif
                                        <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />
                                    @else
                                        <input class="form-control form-control" id="file_name_attach"  name="file_name[]" multiple  type="file"  />
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="repair_category">Total</label>
                                    <input class="form-control form-control total"   value="" readonly type="text"/>
                                </div>



                                    <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden" placeholder="Enter  Amount" required />
                            </div>

                                <div class="col-md-6 mt-2 form-group">
                                    <input type="hidden" value=""  name="edit_status" id="edit_status">

                                    <input @if(isset($offer_sub_letter)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />

                                </div>

                        </form>
                        <script>

                            $( "#edit_data" ).click(function() {
                                $('#mb_no').removeAttr('readonly');
                                $('#offer_date_and_time').removeAttr('readonly');
                                $('#file_name').removeAttr('readonly');
                                $('#offer_date_and_time').removeAttr('readonly');
                                $('#file_name').removeAttr('readonly');

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
                             $(document).ready(function () {


                                 $('#payment_option').change(function() {
                                     if ($('#payment_option').prop('checked')) {
                                        $('#payment_type').attr('required',true);
                                         $('#payment1').show();
                                     } else {
                                         $('#payment1').hide();
                                         $('#payment_type').removeAttr('required');
                                     }
                                 });
                                 });
</script>


<script>
    $(document).ready(function (e){
    $("#offer_letter_submit").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('offer_letter_sub.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#offer_letter_submit").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Offer Letter Submission Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }

            else if(response.code == 102){
                    toastr.error("MB Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 103){
                    toastr.error("ST Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.success("Offer Letter Submission Updated Successfully!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    $('.bd-example-modal-lg').modal('hide');
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
$('#mb_no').removeAttr('required');
$('#offer_date_and_time').removeAttr('required');
$('#file_name').removeAttr('required');
$('#offer_date_and_time').removeAttr('required');
$('#file_name').removeAttr('required');
$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');

</script>
<script>
    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
</script>

@endif
