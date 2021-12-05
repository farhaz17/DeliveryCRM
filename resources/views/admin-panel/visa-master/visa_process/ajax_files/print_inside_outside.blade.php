{{-- <form action ="{{ route('entry_visa_outside') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <h5 class="modal-title" id="exampleModalCenterTitle">Print Inside/Outside </h5>
    @if(isset($print_inside))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif
    <form id='entry_visa_outside'>
    {!! csrf_field() !!}
    <div class="row">

            <div class="col-md-6">
            <label for="repair_category">Visa Number</label>
                <input class="form-control form-control" id="status_value" name="inside_out_status" hidden value="">


                <input class="form-control form-control" id="visa_number" name="visa_number" value="{{isset($print_inside)?$print_inside->visa_number:""}}"  @if(isset($print_inside)) readonly @endif

            type="text" placeholder="Enter Visa Number" required />
            <input type="hidden" name="request_id"  value="{{isset($print_inside)?$print_inside->id:""}}">
        </div>
        <div class="col-md-6">
            <label for="repair_category">UID No</label>
            <input class="form-control form-control" id="uid_no" name="uid_no" value="{{isset($print_inside)?$print_inside->uid_no:""}}"
                   @if(isset($print_inside)) readonly @endif    type="text" placeholder="Enter UID No" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Visa Issue Date</label>
            <input class="form-control form-control" id="visa_issue_date" value="{{isset($print_inside)?$print_inside->visa_issue_date:""}}"
                   @if(isset($print_inside)) readonly @endif name="visa_issue_date"

                   type="date" placeholder="Enter Visa Issue Date" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Visa Expiry Date</label>
            <input class="form-control form-control" id="visa_expiry_date" value="{{isset($print_inside)?$print_inside->visa_expiry_date:""}}"
                   @if(isset($print_inside)) readonly @endif name="visa_expiry_date"

                   type="date" placeholder="Enter Visa Expiry Date" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($print_inside))
                @if($print_inside->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($print_inside->visa_attachment) as $visa_attach)


                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/EntryPrintOutSide/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong  style="color: #000000">View Attachment</strong>
                    </a>

                        {{-- <a class="attachment_display" href="{{isset($print_inside->visa_attachment)?url('assets/upload/EntryPrintOutSide/'.$visa_attach):""}}" id="passport_image" target="_blank">
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

        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" value="1" name="payment_checkbox" id="payment_option" @if(isset($payment_print_inside))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>
        </div>
    </div>
    <div class="row payment_row"  id="payment1" @if(isset($payment_print_inside))   @else  style="display: none"   @endif>




        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_print_inside)) value="1070" @else value="{{isset($payment_print_inside)?$payment_print_inside->payment_amount:""}}" @endif id="payment_amount"   @if(isset($print_inside)) readonly @endif

            name="payment_amount"  type="number" step="0.01" placeholder="Enter Country Code"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_print_inside !=null) disabled @endif  required  name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_print_inside)?$payment_print_inside->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_print_inside !=null) readonly
                          @endif  value="{{isset($payment_print_inside)?$payment_print_inside->fine_amount:""}}" placeholder="Fine Amount" />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control" id="transaction_no" value="{{isset($payment_print_inside)?$payment_print_inside->transaction_no:""}}"
                   @if(isset($print_inside)) readonly @endif name="transaction_no"

                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount" @if(!isset($payment_print_inside)) value="2.5" @else value="{{isset($payment_print_inside)?$payment_print_inside->vat:""}}" @endif id="vat" name="vat"
                   @if(isset($print_inside)) readonly @endif

                   type="number" step="0.01" min='0'  placeholder="Enter Country Code"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>

            <input class="form-control form-control" id="visa_issue_date1" value="{{isset($payment_print_inside)?Carbon\Carbon::parse($payment_print_inside->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($print_inside)) readonly @endif

            name="transaction_date_time" value=""  type="date" placeholder="Transaction Date & Time"/>
            <div id="datetime-1-holder"></div>                                            </div>

            <div class="col-md-6">
                <label for="repair_category">Service Charges</label>
                <input class="form-control form-control sum_amount" @if(!isset($payment_print_inside)) value="3.15" @else value="{{isset($payment_print_inside)?$payment_print_inside->service_charges:""}}" @endif
                  @if(isset($payment_print_inside)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'
                   placeholder="Enter Service Charges"  />
            </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_print_inside))
                @if($payment_print_inside->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_print_inside->other_attachment) as $visa_attach2)


                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/EntryPrintOutSide/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}"
                        id="passport_image" target="_blank">
                        <strong  style="color: #000000">View Attachment</strong>
                    </a>

                        {{-- <a class="attachment_display" href="{{isset($print_inside->visa_attachment)?url('assets/upload/EntryPrintOutSide/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}
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








            <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden" placeholder="Enter  Amount"  />



    </div>

        <div class="col-md-6 mt-2 form-group">
            <input type="hidden" value=""  name="edit_status" id="edit_status">
            <input  @if(isset($print_inside)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit5" class="btn btn-primary btn-save" />

        </div>


</form>
<script>

    $( "#edit_data" ).click(function() {

            $('#visa_number').removeAttr('readonly');
            $('#uid_no').removeAttr('readonly');
            $('#visa_issue_date').removeAttr('readonly');
            $('#visa_issue_date1').removeAttr('readonly');
            $('#visa_expiry_date').removeAttr('readonly');
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
    $("#entry_visa_outside").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('entry_visa_outside') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,

   beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#entry_visa_outside").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Entry Visa Inside/Outside Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 102){
                    toastr.error("Visa Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }

                else if(response.code == 103){
                    toastr.error("Visa Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.error("UID Number already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 105){
                    toastr.success("Entry Visa Inside/Outside Update Successfully!", { timeOut:10000 , progressBar : true});
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

$('#visa_number').removeAttr('required');
$('#uid_no').removeAttr('required');
$('#visa_issue_date').removeAttr('required');
$('#visa_expiry_date').removeAttr('required');
$('#file_name').removeAttr('required');

$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');

</script>
@endif

@if($req=='1' && !isset($payment_print_inside))
<script>
$('#payment_amount').removeAttr('value');
$('#vat').removeAttr('value');
$('#service_charges').removeAttr('value');
</script>
@endif
<script>
    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
</script>

