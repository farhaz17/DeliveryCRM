{{-- form1 --}}
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
<h5 class="modal-title" id="exampleModalCenterTitle">Status Change/In-out Chaange </h5>

<div class="card mb-4 card-hidden" >
    <div class="card-body">
        <div class="col-md-6">

            <label class="radio radio-outline-success">
                <input type="radio" data="Yes"   id="status_change" name="status_change" @if(isset($status_change))   checked   @endif><span>Status Change</span><span class="checkmark"></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="radio radio-outline-success">
                <input type="radio" data="No"  id="in-out_status" name="status_change" @if(isset($in_out_status))   checked   @endif><span>In-out Change</span><span class="checkmark"></span>
            </label>


        </div>

    </div>
</div>
<div class="form1 card mb-4 card-hidde" @if(isset($status_change))   @else  style="display: none"   @endif>
    <div class="card-body">
    <h5 class="modal-title mb-3" id="exampleModalCenterTitle" >Status Change</h5>
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
            @hasanyrole($roll_array)
            <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
            @endhasanyrole
<form id='status_change_form'>
    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Submission Date</label>
            <input class="form-control form-control" value="{{isset($status_change)?$status_change->exit_date:""}}"
                   @if(isset($status_change) || isset($in_out_status)) readonly @endif id="visa_issue_date" name="exit_date"
                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                   type="date" placeholder="Enter Submission Date" required />

                   <input type="hidden" name="request_id"  value="{{isset($status_change)?$status_change->id:""}}">
        </div>
        <div class="col-md-6">
            <label for="repair_category">Approval Date</label>
            <input class="form-control form-control" value="{{isset($status_change)?$status_change->entry_date:""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="entry_date" name="entry_date"

                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                   type="date" placeholder="Enter Approval Date" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control" value="{{isset($status_change)?$status_change->expiry_date:""}}"

            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="expiry_date" name="expiry_date"
                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                   type="date" placeholder="Enter Expiry Date" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($status_change))
                @if($status_change->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($status_change->visa_attachment) as $visa_attach)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/StatusChange/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>
                        <span>|</span>
                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple

                       type="file"  />
            @endif
        </div>


        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" value="1" name="payment_checkbox" @if(isset($payment_status_change))   checked   @endif id="payment_option4"  @if(isset($status_inside_outside)?$status_inside_outside=='1':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>
    <div class="row payment_row"  id="payment4"  @if(isset($payment_status_change))   @else  style="display: none"   @endif   >

        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_status_change)) value="570" @else value="{{isset($payment_status_change)?$payment_status_change->payment_amount:""}}" @endif
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="payment_amount" name="payment_amount"

                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                   type="number" step="0.01" placeholder="Enter Payment" />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_status_change !=null) disabled @endif    name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_status_change)?$payment_status_change->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                     type="number" step="0.01" @if ($payment_status_change !=null) readonly
                          @endif  value="{{isset($payment_status_change)?$payment_status_change->fine_amount:""}}" placeholder="Fine Amount" />
       </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control" value="{{isset($payment_status_change)?$payment_status_change->transaction_no:""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="transaction_no" name="transaction_no"

                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_status_change)) value="2.5" @else value="{{isset($payment_status_change)?$payment_status_change->vat:""}}" @endif
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="vat" name="vat"

            type="number" step="0.01" min='0'  placeholder="Enter Vat"/>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>
            <input class="form-control form-control" value="{{isset($payment_status_change)?Carbon\Carbon::parse($payment_status_change->transaction_date_time)->format('Y-m-d'):""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""
                   type="date" placeholder="Transaction Date & Time"  />
            <div id="datetime-1-holder"></div>
             </div>

             <div class="col-md-6">
                <label for="repair_category">Service Charges</label>
                <input class="form-control form-control sum_amount"   @if(!isset($payment_status_change)) value="3.15" @else value="{{isset($payment_status_change)?$payment_status_change->service_charges:""}}" @endif    @if(isset($payment_status_change)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'  placeholder="Enter Service Charges"  />
            </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($payment_status_change))
                @if($payment_status_change->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_status_change->other_attachment) as $visa_attach2)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/StatusChange/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>
                        <span>|</span>
                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name_attach"  name="file_name[]" multiple type="file"  />
            @endif
        </div>
        <div class="col-md-6">
            <label for="repair_category">Total</label>
            <input class="form-control form-control total"   value="" readonly type="text"/>
        </div>
            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
</div>

    <div class="col-md-3  mt-2 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">
                <input  @if(isset($status_change)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit10" class="btn btn-primary btn-save" />
        </div>
</form>
</div>
</div>
{{-- form1 ends --}}

{{-- form2 --}}
<div class="form2 card mb-4 card-hidden"  @if(isset($in_out_status))   @else  style="display: none"   @endif>
    <div class="card-body">
    <h5 class="modal-title mb-3" id="exampleModalCenterTitle">In-out Status Change</h5>
    @if(isset($new_contract_sub))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
            @hasanyrole($roll_array)
            <a id="edit_data2" href="javascript:void(0)" style="float: right;">Edit</a>
            @endhasanyrole
            @endif
{{-- <form action ="{{ route('inout_status_change') }}" method="POST" enctype="multipart/form-data"> --}}
    <form id='inout_status_change_form'>
    {!! csrf_field() !!}

    <div class="row">

        <div class="col-md-6">
            <label for="repair_category">Out Side Entry Date</label>
            <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->outside_entry_date:""}}"

            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="outside_entry_date" name="outside_entry_date"


                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif


                   type="date" placeholder="Enter Exit Date" required />
                    <input type="hidden" name="request_id"  value="{{isset($in_out_status)?$in_out_status->id:""}}">
        </div>

        <div class="col-md-6">
            <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->expiry_date:""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="outside_expiry_date" name="expiry_date"


                   @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif


                   type="date" placeholder="Enter Expiry Date" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($in_out_status))
                @if($in_out_status->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($in_out_status->visa_attachment) as $visa_attach)

                        {{-- <a class="attachment_display" href="{{isset($in_out_status->visa_attachment)?url('assets/upload/InOutStatusChange/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}


                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/InOutStatusChange/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name2"  name="visa_attachment[]" multiple

                       type="file"  />
            @endif
        </div>


        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">

                <input type="checkbox" value="1" name="payment_checkbox2" @if(isset($payment_in_out_status))   checked   @endif id="payment_option5" @if(isset($status_inside_outside)?$status_inside_outside=='1':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>
    <div class="row payment_row"  id="payment5" style="display: none">

        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount2" @if(!isset($payment_in_out_status)) value="570" @else value="{{isset($payment_in_out_status)?$payment_in_out_status->payment_amount:""}}" @endif
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="payment_amount1" name="payment_amount"


            type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_in_out_status !=null) disabled @endif  required  name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_in_out_status)?$payment_in_out_status->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount2" id="fine_amount1" name="fine_amount"
                   type="number" step="0.01" @if ($payment_in_out_status !=null) readonly
                          @endif  value="{{isset($payment_in_out_status)?$payment_in_out_status->fine_amount:""}}" placeholder="Fine Amount" />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"  value="{{isset($payment_in_out_status)?$payment_in_out_status->transaction_no:""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="transaction_no1" name="transaction_no"


                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount2"  @if(!isset($payment_in_out_status)) value="2.5" @else value="{{isset($payment_in_out_status)?$payment_in_out_status->vat:""}}" @endif
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="vat1" name="vat"

            type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>


            <input class="form-control form-control"  value="{{isset($payment_in_out_status)?Carbon\Carbon::parse($payment_in_out_status->transaction_date_time)->format('Y-m-d'):""}}"
            @if(isset($status_change) || isset($in_out_status)) readonly @endif id="transaction_date_time1"


                   name="transaction_date_time" value=""  type="date" placeholder="Transaction Date & Time"/>
            <div id="datetime-1-holder"></div>                                            </div>

            <div class="col-md-6">
                <label for="repair_category">Service Charges</label>
                <input class="form-control form-control sum_amount2"   @if(!isset($payment_in_out_status)) value="3.15" @else value="{{isset($payment_status_change)?$payment_status_change->service_charges:""}}" @endif    @if(isset($payment_status_change)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'  placeholder="Enter Service Charges"  />
            </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_in_out_status))
                @if($payment_in_out_status->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_in_out_status->other_attachment) as $visa_attach2)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/InOutStatusChange/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>
                        <span>|</span>
                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name2"  name="file_name[]" multiple type="file"  />
            @endif


            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Total</label>
            <input class="form-control form-control total2"   value="" readonly type="text"/>
        </div>


    </div>
    <div class="col-md-6 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">
            <input   @if(isset($in_out_status) || isset($status_change)) disabled @endif  type="submit" name="submit" value="Save" id="submitBtn1" data-toggle="modal" data-target="#confirm-submit9" class="btn btn-primary btn-save" />

    </div>
</form>
</div>
</div>
<script>

    $( "#edit_data" ).click(function() {
        $('#visa_issue_date').removeAttr('readonly');
            $('#entry_date').removeAttr('readonly');
            $('#expiry_date').removeAttr('readonly');
            $('#visa_expiry_date').removeAttr('readonly');
            $('#file_name').removeAttr('readonly');
            $('#outside_entry_date').removeAttr('readonly');
            $('#outside_expiry_date').removeAttr('readonly');
            $('#file_name2').removeAttr('readonly');

    $('#payment_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('disabled');
    $('#fine_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('readonly');
    $('#transaction_no').removeAttr('readonly');
    $('#visa_issue_date').removeAttr('readonly');

    $('#transaction_date_time').removeAttr('readonly');
    $('#vat').removeAttr('readonly');
    $('#file_name_attach').removeAttr('readonly');
    $('#service_charges').removeAttr('readonly');
    $('#submitBtn').removeAttr('disabled');
    $('#submitBtn1').removeAttr('disabled');
    $('input[name=edit_status]').val('1');


    $('#payment_amount1').removeAttr('readonly');
    $('#payment_type2').removeAttr('disabled');
    $('#fine_amount1').removeAttr('readonly');

    $('#transaction_no1').removeAttr('readonly');
    $('#visa_issue_date1').removeAttr('readonly');

    $('#transaction_date_time1').removeAttr('readonly');
    $('#vat1').removeAttr('readonly');
    $('#file_name2').removeAttr('readonly');
    $('#service_charges1').removeAttr('readonly');

    $('#file_name1').show();
                        $('#file_name3').show();


    });
    </script>


<script>

    $( "#edit_data2" ).click(function() {
        $('#visa_issue_date').removeAttr('readonly');
            $('#entry_date').removeAttr('readonly');
            $('#expiry_date').removeAttr('readonly');
            $('#visa_expiry_date').removeAttr('readonly');
            $('#file_name').removeAttr('readonly');
            $('#outside_entry_date').removeAttr('readonly');
            $('#outside_expiry_date').removeAttr('readonly');
            $('#file_name2').removeAttr('readonly');

    $('#payment_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('disabled');
    $('#fine_amount').removeAttr('readonly');
    $('#payment_type').removeAttr('readonly');
    $('#transaction_no').removeAttr('readonly');
    $('#visa_issue_date').removeAttr('readonly');

    $('#transaction_date_time').removeAttr('readonly');
    $('#vat').removeAttr('readonly');
    $('#file_name_attach').removeAttr('readonly');
    $('#service_charges').removeAttr('readonly');
    $('#submitBtn').removeAttr('disabled');
    $('#submitBtn1').removeAttr('disabled');
    $('input[name=edit_status]').val('1');


    $('#payment_amount1').removeAttr('readonly');
    $('#payment_type2').removeAttr('disabled');
    $('#fine_amount1').removeAttr('readonly');

    $('#transaction_no1').removeAttr('readonly');
    $('#visa_issue_date1').removeAttr('readonly');

    $('#transaction_date_time1').removeAttr('readonly');
    $('#vat1').removeAttr('readonly');
    $('#file_name2').removeAttr('readonly');
    $('#service_charges1').removeAttr('readonly');


    });
    </script>
{{-- form2 ends --}}
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
    $(document).on("change", ".sum_amount2", function() {
    var sum = 0;
    $(".sum_amount2").each(function(){
        sum += +$(this).val();
    });
    $(".total2").val(sum);
});
</script>

<script>
    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
</script>
<script>
    $('#payment_type2').select2({
        placeholder: 'Select an option'
    });
</script>
<script>
    $(document).ready(function() {
                        // $(".form1").hide();
                        // $(".form2").hide();

                        $("#status_change").change(function () {
                        $(".form1").show();
                        $(".form2").hide();
                    });
                        $("#in-out_status").change(function () {
                            $(".form2").show();
                            $(".form1").hide();
                        });
                    });
</script>

<script>
       $('#payment_option4').change(function() {
                                        if ($('#payment_option4').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment4').show();
                                        } else {
                                            $('#payment4').hide();
                                            $('#payment_type').removeAttr('required');
                                        }
                                    });
                                    $('#payment_option5').change(function() {
                                        if ($('#payment_option5').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment5').show();
                                        } else {
                                            $('#payment5').hide();
                                            $('#payment_type').removeAttr('required');
                                        }
                                    });
</script>





<script>
    $(document).ready(function (e){
    $("#status_change_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('status_change.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#status_change_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Status Change  Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');

   $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 102) {
                    toastr.success("Status Change  Updated Successfully!", { timeOut:10000 , progressBar : true});
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
    $(document).ready(function (e){
    $("#inout_status_change_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('inout_status_change') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#inout_status_change_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("In-out Change Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 102) {
                    toastr.success("In-out Change Updated Successfully!", { timeOut:10000 , progressBar : true});
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
@if($req=='1')
<script>

$('#visa_issue_date').removeAttr('required');
$('#entry_date').removeAttr('required');
$('#expiry_date').removeAttr('required');
$('#visa_expiry_date').removeAttr('required');
$('#file_name').removeAttr('required');
$('#outside_entry_date').removeAttr('required');
$('#outside_expiry_date').removeAttr('required');
$('#file_name2').removeAttr('required');



$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');

</script>
@endif

@if($req=='1' && !isset($payment_status_change))
<script>
$('#payment_amount').removeAttr('value');
$('#vat').removeAttr('value');
$('#service_charges').removeAttr('value');
</script>
@endif

@if($req=='1' && !isset($payment_in_out_status))
<script>
$('#payment_amount1').removeAttr('value');
$('#vat1').removeAttr('value');
$('#service_charges').removeAttr('value');
</script>
@endif
