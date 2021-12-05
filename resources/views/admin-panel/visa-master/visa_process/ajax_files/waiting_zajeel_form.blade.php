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

<h5 class="modal-title" id="exampleModalCenterTitle">Passport Handover To Zajeel</h5>




<form  id="zajeel_form">
    {{-- <form  action ="{{ route('zajeel') }}" method="POST" enctype="multipart/form-data"> --}}
    {!! csrf_field() !!}
    <div class="card ">
    <div class="card-body">
        <h6 class="modal-title font-weight-bold">Handover Information</h6>
        @if(isset($zajeel))
        <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif

    <div class="row">
            <div class="col-md-6">
                <label for="repair_category">Status</label>
                @if(isset($zajeel))
                    <select id="status" name="send" class="form-control form-control"  required {{isset($zajeel)?'disabled':""}}>
                        <option value="1"  @if($zajeel->send=="1")  selected  @endif>Yes</option>
                        <option value="0" @if($zajeel->send=="0") selected disabled @endif>No</option>
                    </select>
                @else
                <select id="status2" name="send" class="form-control form-control" required  >
                    <option selected disabled >Select option</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                    @endif
            </div>
            <input type="hidden" name="request_id"  value="{{isset($zajeel)?$zajeel->id:""}}">

        <div class="col-md-6">
            <label for="repair_category">Handover Date</label>
            <input class="form-control form-control" value="{{isset($zajeel)?$zajeel->handover_date:""}}"
            @if(isset($zajeel)) readonly @endif id="handover_date" name="handover_date" type="date" placeholder="Enter  Date" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($zajeel))
                @if($zajeel->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($zajeel->visa_attachment) as $visa_attach)
                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/zajeel/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
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
    </div>
    {{-------row ends here --}}
    </div>
</div>


    {{-- ---------------------------------------------------- --}}
    {{-- -------------------------------------------------- --}}
    <div class="card mt-2">
        <div class="card-body">
            <h6 class="modal-title font-weight-bold">Receive Information</h6>
            <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data2" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
                <div class="row">
                    <div class="col-md-6">
                        <label for="repair_category">Status</label>
                        @if(isset($zajeel->receive))
                            <select id="status3" name="receive" class="form-control form-control"  required {{isset($zajeel)?'disabled':""}}>
                                <option value="1"  @if($zajeel->receive=="1")  selected  @endif>Yes</option>
                                <option value="0" @if($zajeel->receive=="0") selected  @endif>No</option>
                            </select>
                        @else
                        <select id="receive2" name="receive" class="form-control form-control" >
                            <option selected disabled >Select option</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>
                            @endif
                    </div>

                    <div class="col-md-6">
                        <label for="repair_category">Receive  Date</label>
                        <input class="form-control form-control"    value="{{isset($zajeel->receive_date)?$zajeel->receive_date:""}}"
                        @if(isset($zajeel->receive_date)) readonly @endif id="receive_date" name="receive_date" type="date" placeholder="Enter  Date" required />
                    </div>
                </div>
        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
</div>
</div>


<div class="card mt-2">
    <div class="card-body">
<div class="col-md-12 mt-2 form-group">
    <input type="hidden" value=""  name="edit_status" id="edit_status">
    <input type="hidden" value=""  name="edit_receive" id="edit_receive">
    <input  @if(isset($zajeel) && $zajeel->status=='2') disabled @endif required   type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit23" class="btn btn-primary btn-save" />
</div>
</div>
</div>

</form>


<script>
      $('#status2').change(function() {
        // $("#receive2").prop("selected", false)
        $("#receive2").val([]);
        $('#receive_date').removeAttr('required');
});

$('#receive2').change(function() {
    $("#status2").val([]);
        // $("#status2").prop("selected", false)
});

</script>
<script>
    $( "#edit_data" ).click(function(){
        $('#status').removeAttr('disabled');
        $('#handover_date').removeAttr('readonly');
        $('#file_name').removeAttr('readonly');
        $('#receive').removeAttr('readonly');
        $('#receive_date').removeAttr('required');
    $('#submitBtn').removeAttr('disabled');
    $('input[name=edit_status]').val('1');
    $('input[name=edit_receive]').val('');
    $('#file_name1').show();
                        $('#file_name3').show();
    });
    </script>

<script>

    $( "#edit_data2" ).click(function(){
        $('#status3').removeAttr('disabled');
        $('#receive_date').removeAttr('readonly');
    $('#submitBtn').removeAttr('disabled');
    $('input[name=edit_status]').val('1');
    $('input[name=edit_receive]').val('1');


    });
    </script>
<script>
    $(document).ready(function (e){
    $("#zajeel_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('zajeel') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#zajeel_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Zajeel Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }

                else if(response.code == 104) {
                    toastr.success("Zajeel Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#file_name').removeAttr('required');
$('#receive').removeAttr('required');
$('#handover_date').removeAttr('required');
$('#receive_date').removeAttr('required');







</script>

@endif
