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
<div class="overlay"></div><h5 class="modal-title" id="exampleModalCenterTitle">Medical</h5>

        <form id="medical_normal_form">
            {!! csrf_field() !!}




       {{-- medical normal --}}

    <div class="card-body">
    <h5 class="modal-title mb-3" id="exampleModalCenterTitle" >Medical</h5>
    @if(isset($med_normal))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
    @hasanyrole($roll_array)
    <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
    @endhasanyrole
    @endif
    {{-- <form action ="{{ route('medical.store') }}" method="POST" enctype="multipart/form-data"> --}}


        <div class="row">

            <div class="col-md-12">
                <label for="repair_category">Medical (Normal,48 Hours,24 Hours,VIP Hours)</label>
                <select id="medical_type" name="medical_type" class="form-control" required>
                    <option   selected disabled  >Select option</option>
                    <option value="1" selected @if(isset($med_normal) && $med_normal->medical_type=='1') selected disabled     @endif>Medical (Normal)</option>
                    <option value="2" @if(isset($med_normal) && $med_normal->medical_type=='2') selected disabled    @endif >Medical (48 Hours)</option>
                    <option value="3" @if(isset($med_normal) && $med_normal->medical_type=='3') selected disabled    @endif  >Medical (24 Hours)</option>
                    <option value="4" @if(isset($med_normal) && $med_normal->medical_type=='4') selected disabled    @endif >Medical (VIP Hours)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="repair_category">Medical Application  ID</label>
                <input class="form-control form-control"   value="{{isset($med_normal)?$med_normal->medical_tans_no:""}}"
                 @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif
                  id="medical_tans_no1" name="medical_tans_no"  type="number" placeholder="Medical Application  ID" required />
                  <input type="hidden" name="request_id1"  value="{{isset($med_normal)?$med_normal->id:""}}">
            </div>

            <div class="col-md-6">
                <label for="repair_category">Medical Date</label>
                <input class="form-control form-control" value="{{isset($med_normal)?$med_normal->medical_date_time:""}}"
                @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif id="transaction_date_time"
                       name="medical_date_time"  type="date" placeholder="Enter Expiry Date" required />
            </div>

            <div class="col-md-6">
                <label for="repair_category"> Attachment</label>

                @if(isset($med_normal))
                    @if($med_normal->visa_attachment!=null)
                        <br>
                        @foreach (json_decode($med_normal->visa_attachment) as $visa_attach)

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/MedicalNormal/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                            <span>|</span>

                        @endforeach
                    @endif
                    <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
                @else
                    <input class="form-control form-control" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
                @endif
            </div>


            <div class="col-md-12">
                <br>
                <label class="checkbox checkbox-primary">
                    <input type="checkbox" value="1" name="payment_checkbox" id="payment_option7" @if(isset($payment_med_normal))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
                </label>

            </div>
        </div>

        <div class="row payment_row"  id="payment7" @if(isset($payment_med_normal))   @else  style="display: none"   @endif >


            <div class="col-md-6">
                <label for="repair_category">Payment Amount</label>
                <input class="form-control form-control sum_amount" @if(!isset($payment_med_normal)) value="250" @else value="{{isset($payment_med_normal)?$payment_med_normal->payment_amount:""}}" @endif
                @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif  id="payment_amount1" name="payment_amount"

                type="number" step="0.01" placeholder="Enter Payment"  />
            </div>
            <div class="col-md-6">
                <label for="repair_category">Payment Type</label>
                <select id="payment_type" @if ($payment_med_normal !=null) disabled @endif    name="payment_type" class="form-control">
                    <option value="" selected disabled >Select option</option>
                    @foreach($payment_type as $pay_type)
                    @php
                    $isSelected=(isset($payment_med_normal)?$payment_med_normal->payment_type:"")==$pay_type->id;
                @endphp
                        <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="repair_category">Fine Amount</label>
                       <input class="form-control form-control sum_amount" id="fine_amount1" name="fine_amount"
                       type="number" step="0.01" @if ($payment_med_normal !=null) readonly
                              @endif  value="{{isset($payment_med_normal)?$payment_med_normal->fine_amount:""}}" placeholder="Fine Amount" />
                   </div>




            <div class="col-md-6">
                <label for="repair_category">Transaction Number</label>
                <input class="form-control form-control" value="{{isset($payment_med_normal)?$payment_med_normal->transaction_no:""}}"
                @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif  id="transaction_no1" name="transaction_no"

                       type="text" placeholder="Enter Transaction Number"  />
            </div>
            <div class="col-md-6">
                <label for="repair_category">Vat</label>
                <input class="form-control form-control sum_amount"  value="{{isset($payment_med_normal)?$payment_med_normal->vat:""}}"
                       @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif id="vat1" name="vat"  type="number" step="0.01" min='0'

                       placeholder="Enter Vat"  />
            </div>
            <div class="col-md-6">
                <label for="repair_category">Transaction Date</label>


                <input class="form-control form-control"
                 value="{{isset($payment_med_normal)?Carbon\Carbon::parse($payment_med_normal->transaction_date_time)->format('Y-m-d'):""}}"
                @if(isset($med_normal) || isset($med_48)|| isset($med_24)||isset($med_vip) ) readonly @endif  id="transaction_date_time_payment"
                name="transaction_date_time" value=""  type="date" placeholder="Transaction Date"  />
                <div id="datetime-1-holder"></div>                                            </div>

                <div class="col-md-6">
                    <label for="repair_category">Service Charges</label>
                    <input class="form-control form-control sum_amount" @if(!isset($payment_med_normal)) value="3" @else value="{{isset($payment_med_normal)?$payment_med_normal->service_charges:""}}" @endif
                      @if(isset($med_normal)) readonly @endif id="service_charges1" name="service_charges"  type="number" step="0.01" min='0'
                       placeholder="Enter Service Charges"  />
                </div>


            <div class="col-md-6">
                <label for="repair_category"> Attachment</label>

                @if(isset($payment_med_normal))
                    @if($payment_med_normal->other_attachment!=null)
                        <br>
                        @foreach (json_decode($payment_med_normal->other_attachment) as $visa_attach2)

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/MedicalNormal/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>

                            <span>|</span>

                        @endforeach
                    @endif
                    <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />

                @else
                    <input class="form-control form-control" id="file_name1_1"  name="file_name[]" multiple type="file"  />
                @endif
            </div>

            <div class="col-md-6">
                <label for="repair_category">Total</label>
                <input class="form-control form-control total"   value="" readonly type="text"/>
            </div>
                <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
            </div>

        <div class="col-md-6  mt-2 form-group">
            <input type="hidden" value=""  name="edit_status1" id="edit_status1">
                <input  @if(isset($med_normal)|| isset($med_48)|| isset($med_24)||isset($med_vip)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit10" class="btn btn-primary btn-save" />
        </div>
    </form>
</div>
   </div>



    </div>
</div>
<script>

$( "#edit_data" ).click(function() {
                $('#medical_type').removeAttr('readonly');
                $('#medical_tans_no1').removeAttr('readonly');
                $('#transaction_date_time').removeAttr('readonly');
                $('#payment_amount1').removeAttr('readonly');
                $('#payment_type').removeAttr('disabled');
                $('#fine_amount1').removeAttr('readonly');
                $('#payment_type1_1').removeAttr('readonly');
                $('#transaction_no1').removeAttr('readonly');
                $('#vat1').removeAttr('readonly');
                $('#transaction_date_time_payment').removeAttr('readonly');
                $('#payment_type1_1').removeAttr('readonly');
                $('#service_charges1').removeAttr('readonly');
                     $('#submitBtn').removeAttr('disabled');
                        $('input[name=edit_status1]').val('1');
                        $('#file_name1').show();
$('#file_name3').show();
    });


    </script>
       {{-- medical vip ends here --}}
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
                    });
       </script>


<script>
     $('#payment_option7').change(function() {
                                        if ($('#payment_option7').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment7').show();
                                        } else {
                                            $('#payment_type').removeAttr('required');
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

            url: "{{ route('medical.store') }}",
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
                else if(response.code == 102){
                    toastr.error("Medical Application  ID already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 103){
                    toastr.error("Medical Application  ID already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.success("Meidcal Update Successfully!", { timeOut:10000 , progressBar : true});
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
$('#medical_tans_no').removeAttr('required');
$('#medical_date_time').removeAttr('required');
$('#file_name').removeAttr('required');
$('#payment_amount1').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#passport_image').removeAttr('required');
$('#medical_tans_no1').removeAttr('required');
$('#medical_date_time').removeAttr('required');
$('#medical_tans_no_24').removeAttr('required');
$('#medical_date_time24').removeAttr('required');
$('#file_name4').removeAttr('required');



$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');
$('#').removeAttr('required');
</script>

@endif


@if($req=='1' && !isset($payment_med_normal))
<script>
$('#payment_amount1').removeAttr('value');
$('#vat').removeAttr('value');
$('#service_charges1').removeAttr('value');
</script>
@endif

<script>
    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
    $('#payment_type1').select2({
        placeholder: 'Select an option'
    });
    $('#payment_type2').select2({
        placeholder: 'Select an option'
    });
    $('#payment_type3').select2({
        placeholder: 'Select an option'
    });
</script>
