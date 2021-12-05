{{-- <form  action ="{{ route('handover') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <form  id="handover_form">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Emirates ID Handover</label>
            @if(isset($handover))

                <select  required id="status" name="status" class="form-control form-control"  {{isset($unique)?'disabled':""}}  >

                    @php
                        $isSelected=(isset($handover)?$handover->status:"")==$handover->id;
                    @endphp
                    @if($handover->status=="1")
                        <option value="{{$handover->status}}">Yes</option>
                    @else
                        <option value="{{$handover->status}}">No</option>
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
            <label for="repair_category"> Attachment</label>

            @if(isset($handover))
                @if($handover->attachment!=null)
                    <br>
                    @foreach (json_decode($handover->attachment) as $visa_attach)

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/emirates_id_handover/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple

                       type="file"  />
            @endif
        </div>



        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />



    <div class="col-md-6 mt-2 form-group">



                <input @if(isset($handover)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn26" data-toggle="modal" data-target="#confirm-submit26" class="btn btn-primary btn-save" />



    </div>

    </div>
</form>
<script>
    $(document).ready(function (e){
    $("#handover_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('renew_eid_handover') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#handover_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Visa Pasted Added Successfully!", { timeOut:10000 , progressBar : true});
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
