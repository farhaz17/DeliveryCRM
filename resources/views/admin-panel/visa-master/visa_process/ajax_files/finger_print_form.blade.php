{{-- <form  action ="{{ route('finger_print') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <h5 class="modal-title" id="exampleModalCenterTitle">Emirates ID Finger Print</h5>
    @if(isset($finger_print))
            <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif
    <form id="finger_print">
    {!! csrf_field() !!}
    <div class="row">
        {{-- <div class="col-md-6">
            <label for="repair_category">Finger Print</label>
            @if(isset($finger_print))

                <select id="status" name="status" class="form-control form-control"  required {{isset($finger_print)?'disabled':""}} >

                    @php
                        $isSelected=(isset($finger_print)?$finger_print->status:"")==$finger_print->id;
                    @endphp
                    @if($finger_print->status=="1")
                        <option value="{{$finger_print->status}}">Yes</option>
                    @else
                        <option value="{{$finger_print->status}}">No</option>
                    @endif

                </select>
            @else
            <select id="status" name="status" class="form-control form-control" required   >
                <option readonly="" >Select option</option>
                <option value="1" >Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div> --}}


        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($finger_print))
                <select id="status" name="status" class="form-control form-control"  required {{isset($finger_print)?'disabled':""}}>
                    <option value="1"  @if($finger_print->status=="1")  selected  @endif  >Yes</option>
                    <option value="0" @if($finger_print->status=="0") selected @endif>No</option>
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
            <input class="form-control form-control" value="{{isset($finger_print)?$finger_print->finger_print_date:""}}"
            @if(isset($finger_print)) readonly @endif id="finger_print_date" name="finger_print_date" type="date" placeholder="Enter  Date"  />

            <input type="hidden" name="request_id"  value="{{isset($finger_print)?$finger_print->id:""}}">
        </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($finger_print))
                @if($finger_print->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($finger_print->visa_attachment) as $visa_attach)
                        <a class="btn btn-success btn-file" href="{{isset($finger_print->visa_attachment)?url('assets/upload/finger_print/'.$visa_attach):""}}" id="passport_image" target="_blank">
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
                <input  @if(isset($finger_print)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit16" class="btn btn-primary btn-save" />

    </div>
    </div>
</form>
<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');
        $('#file_name').removeAttr('requireadonlyred');
        $('#finger_print_date').removeAttr('readonly');
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
    $("#finger_print").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('finger_print') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#finger_print").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Emirates ID Finger Print Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');

                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code == 104){
                    toastr.success("Emirates ID Finger Print Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#file_name').removeAttr('required');
$('#finger_print_date').removeAttr('required');


</script>

@endif
