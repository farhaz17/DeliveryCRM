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
<h5 class="modal-title" id="exampleModalCenterTitle">Emirates ID Receive</h5>

    <form  id='unique_form'>
    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Emirates ID Received</label>
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
        </div>
        <div class="col-md-6">
            <label for="repair_category">Issue Date</label>
            <input class="form-control form-control"   value="{{isset($unique)?$unique->issue_date:""}}"  @if(isset($unique)) readonly @endif  id="transaction_date_time" name="issue_date"  type="date" placeholder="Enter Payment" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Issue Date</label>
            <input class="form-control form-control"   value="{{isset($unique)?$unique->expiry_date:""}}"  @if(isset($unique)) readonly @endif  id="transaction_date_time" name="expiry_date"  type="date" placeholder="Enter Payment" required />
        </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($unique))
                @if($unique->visa_attachment!=null)
                <br>
                @foreach (json_decode($unique->visa_attachment) as $visa_attach)
                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/emirates_id_recive/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                    <strong style="color: #000000">  View Attachment</strong>
                </a>
                    <span>|</span>
                @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>







        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />

        <div class="row">
            <div class="col-md-6 form-group mb-3 ml-2">
            <h5 class="modal-title mt-4 font-weight-bold" id="exampleModalCenterTitle">Emirates ID Information </h5>
            </div>
            <div class="modal-body">



            <div class="row ml-2 mr-2">

                <div class="col-md-6">
                    <label for="repair_category">Enter Id Number</label>
                    <input type="text" class="form-control" value="{{isset($eid)?$eid->card_no:""}}" @if(isset($unique) || isset($eid)) readonly @endif id="edit_id_number" name="edit_id_number" >
                </div>

                <div class="col-md-6">
                    <label for="repair_category"> Date</label>
                    <input type="date" class="form-control" value="{{isset($eid)?$eid->expire_date:""}}" @if(isset($unique) || isset($eid)) readonly @endif autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>

                </div>





                    <div class="col-md-6">

                        @if (isset($eid))

                        <a class="btn btn-success btn-file2" href="{{Storage::temporaryUrl($eid->card_front_pic, now()->addMinutes(5))}}"  target="_blank">
                            <strong style="color: #000000"> View  Front Pic</strong>
                        </a>

                            @else
                            <label for="repair_category">Emirates Id Front Pic</label>
                            <input type="file" class="form-control" autocomplete="off"  value="{{isset($eid)?$eid->card_front_pic:""}}"name="front_pic" @if(isset($unique) || isset($eid)) readonly @endif id="front_pic" >

                        @endif
                    </div>



                    <div class="col-md-6">

                        @if (isset($eid))

                        <a class="btn btn-success btn-file2" href="{{Storage::temporaryUrl($eid->card_back_pic, now()->addMinutes(5))}}"  target="_blank">
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





                </div>






            </div>
        </div>
        </div>





        {{-- here-------------------------- --}}


    <div class="col-md-6 mt-2 form-group">
                <input  @if(isset($unique)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn25" data-toggle="modal" data-target="#confirm-submit25" class="btn btn-primary btn-save" />
    </div>
    </div>

</form>

<script>
    $(document).ready(function (e){
    $("#unique_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('renew_visa_eid_rec_save') }}",
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

