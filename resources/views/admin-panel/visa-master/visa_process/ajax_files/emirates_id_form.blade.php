{{-- <form action ="{{ route('emirates_app.store') }}" method="POST" enctype="multipart/form-data" > --}}
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
    @if(isset($emirates_app))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif
    <form id="emirates_id_form" >
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Emirates ID Application Date</label>
            <input class="form-control form-control"  value="{{isset($emirates_app)?$emirates_app->e_id_app_expiry:""}}"
                   @if(isset($emirates_app)) readonly @endif id="medical_date_time" name="e_id_app_expiry" type="date" placeholder="Enter Date" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($emirates_app))
                @if($emirates_app->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($emirates_app->visa_attachment) as $visa_attach)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/emirates_id_app/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
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
        <input type="hidden" name="request_id"  value="{{isset($emirates_app)?$emirates_app->id:""}}">
        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" value="1" name="payment_checkbox" id="payment_option11" @if(isset($payment_emirates_app))   checked   @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>

    <div class="row payment_row"  id="payment11" @if(isset($payment_emirates_app))   @else  style="display: none"   @endif >
        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control sum_amount"  @if(!isset($payment_emirates_app)) value="243.15" @else value="{{isset($payment_emirates_app)?$payment_emirates_app->payment_amount:""}}" @endif
                   @if(isset($payment_entry_date)) readonly @endif id="payment_amount"

                   name="payment_amount"  type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            <select id="payment_type" @if ($payment_emirates_app !=null) disabled @endif   name="payment_type" class="form-control">
                <option value=""  >Select option</option>
                @foreach($payment_type as $pay_type)
                @php
                $isSelected=(isset($payment_emirates_app)?$payment_emirates_app->payment_type:"")==$pay_type->id;
            @endphp
                    <option  value="{{$pay_type->id}}" {{ $isSelected ? 'selected': '' }} >{{ $pay_type->payment_type  }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control sum_amount" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_emirates_app !=null) readonly
                          @endif  value="{{isset($payment_emirates_app)?$payment_emirates_app->fine_amount:""}}" placeholder="Payment Amount" />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"  value="{{isset($payment_emirates_app)?$payment_emirates_app->transaction_no:""}}"
                   @if(isset($payment_emirates_app)) readonly @endif id="transaction_no" name="transaction_no"
                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control sum_amount"  value="{{isset($payment_emirates_app)?$payment_emirates_app->vat:""}}"
                   @if(isset($payment_emirates_appv)) readonly @endif id="vat" name="vat" type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>
            <input class="form-control form-control" id="transaction_date_time"

                   value="{{isset($payment_emirates_app)?Carbon\Carbon::parse($payment_emirates_app->transaction_date_time)->format('Y-m-d'):""}}"  @if(isset($payment_emirates_app)) readonly @endif

                   name="transaction_date_time" value=""  type="date" placeholder="Transaction Date"/>
            <div id="datetime-1-holder"></div>                                            </div>

            <div class="col-md-6">
                <label for="repair_category">Service Charges</label>
                <input class="form-control form-control sum_amount" @if(!isset($payment_emirates_app)) value="31.5" @else value="{{isset($payment_emirates_app)?$payment_emirates_app->service_charges:""}}" @endif
                  @if(isset($emirates_app)) readonly @endif id="service_charges" name="service_charges"  type="number" step="0.01" min='0'
                   placeholder="Enter Service Charges"  />
            </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_emirates_app))
                @if($payment_emirates_app->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_emirates_app->other_attachment) as $visa_attach2)
                        <a class="tn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/emirates_id_app/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>
                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif
            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
    </div>
    <div class="col-md-6">
        <label for="repair_category">Total</label>
        <input class="form-control form-control total"   value="" readonly type="text"/>
    </div>
</div>
    <div class="col-md-6 mt-2 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">
    <input   @if(isset($payment_emirates_app)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit15" class="btn btn-primary btn-save" />
    </div>
</form>
<script>

    $( "#edit_data" ).click(function(){
            $('#medical_date_time').removeAttr('readonly');
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
    $(document).on("change", ".sum_amount", function() {
    var sum = 0;
    $(".sum_amount").each(function(){
        sum += +$(this).val();
    });
    $(".total").val(sum);
});
</script>
<script>
    $('#payment_type').select2({
        placeholder: 'Select an option'
    });
    </script>
<script>
    $(document).ready(function (e){
    $("#emirates_id_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('emirates_app.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#emirates_id_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Emirates ID Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                     $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104){
                    toastr.success("Emirates ID Updated Successfully!", { timeOut:10000 , progressBar : true});
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
<script>
       $('#payment_option11').change(function() {
                                        if ($('#payment_option11').prop('checked')) {
                                            $('#payment_type').attr('required',true);
                                            $('#payment11').show();
                                        } else {
                                            $('#payment_type').removeAttr('required');
                                            $('#payment11').hide();
                                        }
                                    });
</script>
@if($req=='1')
<script>
$('#medical_date_time').removeAttr('required');
$('#payment_amount_main').removeAttr('required');
$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');

</script>

@endif

@if($req=='1' && !isset($payment_med_normal))
<script>
$('#payment_amount').removeAttr('value');

$('#service_charges').removeAttr('value');
</script>
@endif
