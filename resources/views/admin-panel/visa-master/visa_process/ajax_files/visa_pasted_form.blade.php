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
@if(isset($visa_pasted))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Pasted</h5>

@endif
<form  id="visa_pasted_form">
    {!! csrf_field() !!}
    <div class="card">
        <div class="card-body">
    <div class="row">


        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($visa_pasted))
                <select id="status" name="status" class="form-control form-control"  required {{isset($visa_pasted)?'disabled':""}}>
                    <option value="1"  @if($visa_pasted->status=="1")  selected  @endif>Yes</option>
                    <option value="0" @if($visa_pasted->status=="0") selected  @endif>No</option>
                </select>
            @else
            <select id="status" name="status" class="form-control form-control" required  >
                <option readonly="" >Select option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div>



        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($visa_pasted))
                @if($visa_pasted->visa_attachment!=null)
                <br>
                @foreach (json_decode($visa_pasted->visa_attachment) as $visa_attach)
                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/VisaPasted/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                    <strong style="color: #000000">  View Attachment</strong>
                </a>
                    <span>|</span>
                @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>
        <input type="hidden" name="request_id"  value="{{isset($visa_pasted)?$visa_pasted->id:""}}">

        <div class="col-md-6">
        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
      </div>
{{-- cards --}}
        </div>
        </div>
    </div>

    {{-- //row 2 --}}
    <div class="card">
        <div class="card-body">



<div class="row">




            <div class="col-md-6">
                    <label for="repair_category">UID Number</label>
                    <input class="form-control" id="uid_num" name="uid_num"
                     @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                     value="{{$visa_application_data->uid_number}}"
                     @else
                     value="{{isset($print_visa)?$print_visa->uid_no:""}}"
                     @endif
                       type="text" placeholder="Enter the UID Number" />
                </div>

                <div class="col-md-6">
                    <label for="repair_category">EID Number</label>
                    <input class="form-control" id="eid_num" name="eid_num"
                    @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                    value="{{$visa_application_data->eid_number}}"
                    @else
                    value="{{isset($emirates_id)?$emirates_id->card_no:""}}"
                    @endif type="text" placeholder="Enter the EID Number" />

                </div>
                <div class="col-md-6">
                    <label for="repair_category">File Number</label>
                    <input class="form-control" id="file_number" name="file_number"
                    @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                    value="{{$visa_application_data->file_number}}"
                    @else
                     value="{{isset($print_visa)?$print_visa->visa_number:""}}"
                     @endif
                       type="text"
                       placeholder="Enter the file number"  />
                </div>
                <div class="col-md-6">
                    <label for="repair_category">Date of Issue</label>
                    <input class="form-control form-control" id="date_issue2"

                    @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                    value="{{$visa_application_data->issue_date}}"
                    @else
                    value="{{isset($visa_pasted)?Carbon\Carbon::parse($visa_pasted->issue_date)->format('Y-m-d'):""}}"
                    @endif
                    name="date_issue" type="date" placeholder="Enter Date of Issue" required />
                </div>
                <div class="col-md-6">
                    <label for="repair_category">Expiry Date</label>
                    <input class="form-control form-control" id="date_expiry2"
                    @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                    value="{{$visa_application_data->expiry_date}}"
                    @else
                    value="{{isset($visa_pasted)?Carbon\Carbon::parse($visa_pasted->expiry_date)->format('Y-m-d'):""}}"
                    @endif
                          name="date_expiry" type="date" placeholder="Enter Expiry Date" required />
                </div>

                <div class="col-md-6">
                    <label for="repair_category">State</label>
                    <select id="state_id" name="state_id" class="form-control select">
                        <option value="" selected disabled>Select State</option>

                        @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                            @foreach($states as $state)
                            @php
                                $isSelected=(isset($visa_application_data->state_id)?$visa_application_data->state_id:"")==$state->id;
                            @endphp
                            <option value="{{$state->id}}" {{ $isSelected ? 'selected': '' }}>{{$state->name}}</option>
                            @endforeach
                        @else
                        @foreach($states as $state)
                            @php
                                $isSelected=(isset($offer_letter->offer_letter->companies)?$offer_letter->companies->state->id:"")==$state->id;
                            @endphp
                            <option value="{{$state->id}}" {{ $isSelected ? 'selected': '' }}>{{$state->name}}</option>
                        @endforeach
                        @endif

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="repair_category">Visa Profession</label>
                    <select id="visa_profession_id" name="visa_profession_id" class="form-control select">
                        <option value="" selected disabled>Select Profession</option>

                        @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                        @foreach($professions as $profession)
                            @php
                            $isSelected=(isset($visa_application_data->state_id)?$visa_application_data->visa_profession_id:"")==$profession->id;
                            @endphp
                         <option value="{{$profession->id}}" {{ $isSelected ? 'selected': '' }}>{{$profession->name}}</option>
                         @endforeach
                        @else
                        @foreach($professions as $profession)
                            @php
                                $isSelected=(isset($offer_letter->offer_letter->job)?$offer_letter->job:"")==$profession->id;
                            @endphp
                            <option value="{{$profession->id}}" {{ $isSelected ? 'selected': '' }}>{{$profession->name}}</option>
                        @endforeach

                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="repair_category">Visa Company</label>
                    <select id="visa_company" name="visa_company" class="form-control select">
                        <option value="" selected disabled>Select Company</option>
                        @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                        @foreach($companies as $company)
                        @php
                        $isSelected=(isset($visa_application_data->state_id)?$visa_application_data->visa_company_id:"")==$company->id;
                        @endphp
                        <option value="{{$company->id}}" {{ $isSelected ? 'selected': '' }}>{{$company->name}}</option>
                        @endforeach
                        @else
                        @foreach($companies as $company)
                            @php
                                $isSelected=(isset($offer_letter->company)?$offer_letter->company:"")==$company->id;
                            @endphp
                            <option value="{{$company->id}}" {{ $isSelected ? 'selected': '' }}>{{$company->name}}</option>
                        @endforeach

                        @endif
                    </select>
                </div>



</div>
</div>





            <div class="col-md-6">
                <input type="hidden" value=""  name="edit_status" id="edit_status">
            <input @if(isset($visa_pasted)) disabled @endif required  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit24" class="btn btn-primary btn-save" />
        </div>

    </div>
    </div>
</div>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<script>

    // $('#card_no').simpleMask({
    //     'mask': ['###-####-#######-#','#####-####']
    // });
    $(function() {
        $('#eid_num').inputmask("***-****-*******-*",{
            placeholder:"X",
            clearMaskOnLostFocus: false
        });
    });


    $(function() {
        $('#file_number').inputmask("***/****/*******",{
            placeholder:"X",
            clearMaskOnLostFocus: false
        });
    });


</script>

<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');
        $('#issue_date').removeAttr('readonly');
        $('#expiry_date').removeAttr('readonly');
        $('#file_name').removeAttr('readonly');

        $('#uid_num').removeAttr('required');
        $('#eid_num').removeAttr('required');
        $('#file_number').removeAttr('required');
        $('#date_issue2').removeAttr('required');
        $('#date_expiry2').removeAttr('required');
        $('#state_id').removeAttr('required');
        $('#visa_profession_id').removeAttr('required');
        $('#visa_company').removeAttr('required');

        $('#file_name1').show();
                        $('#file_name3').show();











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


    });
    </script>

<script>
    $(document).ready(function (e){
    $("#visa_pasted_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('visa_pasted') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#visa_pasted_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Visa Pasted Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }

                else if(response.code == 104) {
                    toastr.success("Visa Pasted Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#status').removeAttr('required');
$('#issue_date').removeAttr('required');
$('#expiry_date').removeAttr('required');
$('#file_name').removeAttr('required');
</script>


<script>
    $('#visa_profession_id').select2({
        placeholder: 'Select an option'
    });
    $('#visa_company').select2({
        placeholder: 'Select an option'
    });
    $('#state_id').select2({
        placeholder: 'Select an option'
    });


</script>

<script>
    $('#issue_date').change(function() {
    $('#date_issue2').val($(this).val());
});

$('#expiry_date').change(function() {
    $('#date_expiry2').val($(this).val());
});
</script>

@endif
