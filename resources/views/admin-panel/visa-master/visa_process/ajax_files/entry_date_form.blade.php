{{-- <form action ="{{ route('entry_date.store') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <h5 class="modal-title" id="exampleModalCenterTitle"> Entry Date</h5>
    @if(isset($entry_date))
            <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif

    <form id='entry_date'>
    {!! csrf_field() !!}
    <div class="row">

        <div class="col-md-6">
            <label for="repair_category">Entry Date</label>
            <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->expiry_date:""}}"  @if(isset($entry_date)) readonly @endif
            id="entry_date_input" name="entry_date"  type="date" placeholder="Enter Expiry Date" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->expiry_date:""}}"  @if(isset($entry_date)) readonly @endif



            id="expiry_date" name="expiry_date"  type="date" placeholder="Enter Expiry Date" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($entry_date))
                @if($entry_date->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($entry_date->visa_attachment) as $visa_attach)

                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/EntryDate/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>

                        {{-- <a class="attachment_display" href="{{isset($entry_date->visa_attachment)?url('assets/upload/EntryDate/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}
                        <span>|</span>

                    @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>



        <div class="col-md-12">
            <br>
            <label class="checkbox checkbox-primary">
                <input type="checkbox" id="payment_option6" @if(isset($entry_date)?$entry_date=='0':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
            </label>

        </div>
    </div>
    <div class="row payment_row"  id="payment6" style="display: none">

        <div class="col-md-6">
            <label for="repair_category">Payment Amount</label>
            <input class="form-control form-control"  value="{{isset($payment_entry_date)?$payment_entry_date->payment_amount:""}}"
                   @if(isset($payment_entry_date)) readonly @endif id="payment_amount"

                   name="payment_amount"  type="number" step="0.01" placeholder="Enter Payment"  />
        </div>

        <div class="col-md-6">
            <label for="repair_category">Fine Amount</label>
                   <input class="form-control form-control" id="fine_amount" name="fine_amount"
                   type="number" step="0.01" @if ($payment_entry_date !=null) readonly
                          @endif  value="{{isset($payment_entry_date)?$payment_entry_date->payment_amount:""}}" placeholder="Fine Amount" />
               </div>




        <div class="col-md-6">
            <label for="repair_category">Payment Type</label>
            @if(isset($payment_entry_date))

                <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($payment_entry_date)?'disabled':""}} >

                    @php
                        $isSelected=(isset($payment_entry_date)?$payment_entry_date->payment_type:"")==$payment_entry_date->id;
                    @endphp
                    <option value="{{isset($payment_entry_date->payment_type)?$payment_entry_date->payment_type:""}}">{{isset($payment_entry_date->payment->payment_type)?$payment_entry_date->payment->payment_type:""}}</option>


                </select>
            @else
                <select id="payment_type" name="payment_type" class="form-control" >
                    <option selected disabled >Select option</option>
                    @foreach($payment_type as $pay_type)
                        <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                    @endforeach

                </select>
            @endif
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Number</label>
            <input class="form-control form-control"  value="{{isset($payment_entry_date)?$payment_entry_date->transaction_no:""}}"
                   @if(isset($payment_entry_date)) readonly @endif id="transaction_no" name="transaction_no"

                   type="text" placeholder="Enter Transaction Number"  />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Transaction Date</label>

            <input class="form-control form-control"  value="{{isset($payment_entry_date)?Carbon\Carbon::parse($payment_entry_date->transaction_date_time)->format('Y-m-d'):""}}"
                   @if(isset($payment_entry_date)) readonly @endif id="transaction_date_time" name="transaction_date_time"

                   value=""  type="date" placeholder="Transaction Date & Time"  />
            <div id="datetime-1-holder"></div>                                            </div>
        <div class="col-md-6">
            <label for="repair_category">Vat</label>
            <input class="form-control form-control"  value="{{isset($payment_entry_date)?$payment_entry_date->vat:""}}"
                   @if(isset($payment_entry_date)) readonly @endif  id="vat" name="vat"

                   type="number" step="0.01" min='0'  placeholder="Enter Vat"  />
        </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($payment_entry_date))
                @if($payment_entry_date->other_attachment!=null)
                    <br>
                    @foreach (json_decode($payment_entry_date->other_attachment) as $visa_attach2)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/EntryDate/other_attachments/'.$visa_attach2, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>
                        <span>|</span>
                    @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif
        </div>





        <input type="hidden" value=""  name="edit_status" id="edit_status">
            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />




    </div>
    <div class="col-md-6 mt-2 form-group">
            <input @if(isset($entry_date)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn9" data-toggle="modal" data-target="#confirm-submit9" class="btn btn-primary btn-save" />


    </div>
</form>

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
       $('#payment_option6').change(function() {
                                        if ($('#payment_option6').prop('checked')) {
                                            $('#payment6').show();
                                        } else {
                                            $('#payment6').hide();
                                        }
                                    });
</script>


<script>
    $(document).ready(function (e){
    $("#entry_date").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('entry_date.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,

   beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#entry_date").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Entry Date Added Successfully!", { timeOut:10000 , progressBar : true});
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
$('#entry_date_input').removeAttr('required');
$('#expiry_date').removeAttr('required');
$('#file_name').removeAttr('required');


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
