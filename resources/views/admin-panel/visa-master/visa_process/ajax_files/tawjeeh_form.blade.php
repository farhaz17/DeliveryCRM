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
<h5 class="modal-title" id="exampleModalCenterTitle">Tawjeeh Class </h5>
@if(isset($tawjeeh))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif
    <form  id='tawjeeh_form'>
    {!! csrf_field() !!}
    <div class="row">
        {{-- <div class="col-md-6">
            <label for="repair_category">Tawjeeh Class</label>
            @if(isset($tawjeeh))

                <select id="status" name="status" class="form-control form-control"  required {{isset($tawjeeh)?'disabled':""}}>

                    @php
                        $isSelected=(isset($tawjeeh)?$tawjeeh->status:"")==$tawjeeh->id;
                    @endphp
                    @if($tawjeeh->status=="1")
                        <option value="{{$tawjeeh->status}}">Yes</option>
                    @else
                        <option value="{{$tawjeeh->status}}">No</option>
                    @endif

                </select>
            @else
            <select id="status" name="status" class="form-control form-control" required   >
                <option readonly="" >Select option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div> --}}


        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($tawjeeh))
                <select id="status" name="status" class="form-control form-control"  required {{isset($tawjeeh)?'disabled':""}}>
                    <option value="1"  @if($tawjeeh->status=="1")  selected  @endif  >Yes</option>
                    <option value="0" @if($tawjeeh->status=="0") selected @endif>No</option>
                </select>
            @else
            <select id="status" name="status" class="form-control form-control" required   >
                <option readonly="" >Select option</option>
                <option value="1" >Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div>

        <div class="col-md-6">
            <label for="repair_category">Date</label>
            <input class="form-control form-control" value="{{isset($tawjeeh)?$tawjeeh->tawjeeh_date:""}}"
            @if(isset($tawjeeh)) readonly @endif id="tawjeeh_date" name="tawjeeh_date" type="date" placeholder="Enter  Date" required />

            <input type="hidden" name="request_id"  value="{{isset($tawjeeh)?$tawjeeh->id:""}}">
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($tawjeeh))
                @if($tawjeeh->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($tawjeeh->visa_attachment) as $visa_attach)


                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/TawjeehClass/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>
            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />


        <div class="col-md-6 mt-2 form-group">
            <input type="hidden" value=""  name="edit_status" id="edit_status">
        <input @if(isset($tawjeeh)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit18" class="btn btn-primary btn-save" />
        </div>
    </div>


</form>

<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');
        $('#passport_id').removeAttr('readonly');
            $('#tawjeeh_date').removeAttr('readonly');

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
    $(document).ready(function (e){
    $("#tawjeeh_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('tawjeeh_class') }}",
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
                    toastr.success("Tawjeeh Class Added  Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104){
                    toastr.success("Tawjeeh Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#status').removeAttr('required');
$('#passport_id').removeAttr('required');
$('#tawjeeh_date').removeAttr('required');


</script>

@endif
