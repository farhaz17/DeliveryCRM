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
                .btn-file2 {
    padding: 1px;
    height: 25px;
}
</style>
<div class="overlay"></div>
<h5 class="modal-title font-weight-bold" id="exampleModalCenterTitle">Unique Emirates ID</h5>
@if(isset($unique))
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif

    <form  id='unique_form'>
    {!! csrf_field() !!}

    <div class="row">
        {{-- <div class="col-md-6">
            <label for="repair_category">Unique Emirates ID Received</label>
            @if(isset($unique))

                <select id="status" name="status" class="form-control form-control"  required {{isset($unique)?'disabled':""}}>

                    @php
                        $isSelected=(isset($unique)?$unique->status:"")==$unique->id;
                    @endphp
                    @if($unique->status=="1")
                        <option value="{{$unique->status}}">Yes</option>
                    @else
                        <option value="{{$unique->status}}">No</option>
                    @endif

                </select>
            @else
            <select id="status" name="status" class="form-control form-control"   required>
                <option readonly="" >Select option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div> --}}

        <div class="col-md-6">
            <label for="repair_category">Unique Emirates ID Received</label>
            @if(isset($unique))
                <select id="status" name="status" class="form-control form-control"  required {{isset($unique)?'disabled':""}}>
                    <option value="1"  @if($unique->status=="1")  selected  @endif  >Yes</option>
                    <option value="0" @if($unique->status=="0") selected  @endif>No</option>
                </select>
            @else
            <select id="status" name="status" class="form-control form-control"   required>
                <option readonly="" >Select option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div>

        <input type="hidden" name="request_id"  value="{{isset($unique)?$unique->id:""}}">

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($unique))
                @if($unique->visa_attachment!=null)
                <br>
                @foreach (json_decode($unique->visa_attachment) as $visa_attach)
                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/UniqueEmailId/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
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


    </div>
    <div class="row">
        <div class="col-md-6 form-group mb-3">
        <h5 class="modal-title mt-4 font-weight-bold" id="exampleModalCenterTitle">Emirates ID Information </h5>
        </div>
        <div class="modal-body">





        <div class="row">

            <div class="col-md-6">
                <label for="repair_category">Date of Issue</label>
                <input class="form-control form-control" id="date_issue2"

                @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                value="{{$visa_application_data->issue_date}}"
                @else
                value="{{isset($visa_pasted)?Carbon\Carbon::parse($visa_pasted->issue_date)->format('Y-m-d'):""}}"
                @endif
                name="date_issue" type="date" placeholder="Enter Date of Issue" readonly />
            </div>
            <div class="col-md-6">
                <label for="repair_category">Expiry Date</label>
                <input class="form-control form-control" id="date_expiry2"
                @if(isset($visa_application_data) && $visa_application_data->data_status=='1')
                value="{{$visa_application_data->expiry_date}}"
                @else
                value="{{isset($visa_pasted)?Carbon\Carbon::parse($visa_pasted->expiry_date)->format('Y-m-d'):""}}"
                @endif
                      name="date_expiry" type="date" placeholder="Enter Expiry Date" readonly />
            </div>


            <div class="col-md-6">
                <label for="repair_category">Enter Id Number</label>
                <input type="text" class="form-control" value="{{isset($eid)?$eid->card_no:""}}" @if(isset($unique) || isset($eid)) readonly @endif id="edit_id_number" name="edit_id_number" >
            </div>

            <div class="col-md-6">
                <label for="repair_category"> Date</label>
                <input type="date" class="form-control" value="{{isset($eid)?$eid->expire_date:""}}" @if(isset($unique) || isset($eid)) readonly @endif autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>
            </div>
                <div class="col-md-6 mb-4">

                    @if (isset($eid))

                    <a class="btn btn-success btn-file2 mb-4" href="{{Storage::temporaryUrl('assets/upload/emirates_id_card/front/'.$eid->card_front_pic, now()->addMinutes(5))}}"  target="_blank">
                        <strong style="color: #000000"> View  Front Pic</strong>
                    </a>

                        @else
                        <label for="repair_category">Emirates Id Front Pic</label>
                        <input type="file" class="form-control" autocomplete="off"  value="{{isset($eid)?$eid->card_front_pic:""}}"name="front_pic" @if(isset($unique) || isset($eid)) readonly @endif id="front_pic" >

                    @endif
                </div>



                <div class="col-md-6 mb-4">

                    @if (isset($eid))

                    <a class="btn btn-success btn-file2 mb-4" href="{{Storage::temporaryUrl('assets/upload/emirates_id_card/back/'.$eid->card_back_pic, now()->addMinutes(5))}}"  target="_blank">
                        <strong style="color: #000000"> View Back Pic</strong>
                    </a>
                    @else
                    <label for="repair_category">Emirates Id Back Pic</label>
                    <input type="file" class="form-control" value="{{isset($eid)?$eid->card_back_pic:""}}" autocomplete="off" @if(isset($unique) || isset($eid)) readonly @endif name="back_pic" id="back_id" >

                    @endif
                </div>

            </div>
            <input type="hidden" name='eid_already' @if (isset($eid)) value="1" @else value="2" @endif>


            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />


            <div class="col-md-6 mt-2 form-group">
                <input type="hidden" value=""  name="edit_status" id="edit_status">
                <input  @if(isset($unique)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit25" class="btn btn-primary btn-save" />
            </div>


            </div>






        </div>
    </div>
    </div>





    {{-- here-------------------------- --}}


</form>
<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');

        $('#submitBtn').removeAttr('disabled');
        $('input[name=edit_status]').val('1');
        $('#file_name1').show();
                        $('#file_name3').show();


    });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>

    // $('#card_no').simpleMask({
    //     'mask': ['###-####-#######-#','#####-####']
    // });
    $(function() {
        $('#edit_id_number').inputmask("***-****-*******-*",{
            placeholder:"X",
            clearMaskOnLostFocus: false
        });
    });


</script>

<script>
    $(document).ready(function (e){
    $("#unique_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('unique') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#unique_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Unique Emirated ID Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
              else if(response.code == 104) {
                    toastr.success("Unique Emirated ID Updated Successfully!", { timeOut:10000 , progressBar : true});
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

@endif
