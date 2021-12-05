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
<h5 class="modal-title" id="exampleModalCenterTitle">Visa Pasted</h5>
    <form  id="visa_pasted_form">
    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-6">
            <label for="repair_category">Visa Pasted</label>
            @if(isset($visa_pasted))

                <select id="status" name="status" class="form-control form-control"  required {{isset($visa_pasted)?'disabled':""}}  >

                    @php
                        $isSelected=(isset($visa_pasted)?$visa_pasted->status:"")==$visa_pasted->id;
                    @endphp
                    @if($visa_pasted->status=="1")
                        <option value="{{$visa_pasted->status}}">Yes</option>
                    @else
                        <option value="{{$visa_pasted->status}}">No</option>
                    @endif

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
            <label for="repair_category">Issue Date</label>
            <input class="form-control form-control"  value="{{isset($visa_pasted)?$visa_pasted->issue_date:""}}"  @if(isset($visa_pasted)) readonly @endif  id="transaction_date_time" name="issue_date"  type="date" placeholder="Enter Payment" required />
        </div>
        <div class="col-md-6">
            <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control" value="{{isset($visa_pasted)?$visa_pasted->expiry_date:""}}"  @if(isset($visa_pasted)) readonly @endif  id="transaction_date_time" name="expiry_date"  type="date" placeholder="Enter Payment" required />
        </div>

        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($visa_pasted))
                @if($visa_pasted->attachment!=null)
                <br>
                @foreach (json_decode($visa_pasted->attachment) as $visa_attach)
                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/renew_visa_process/visa_pasting/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                    <strong style="color: #000000">  View Attachment</strong>
                </a>
                    <span>|</span>
                @endforeach
                @endif
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>

        <div class="col-md-6">





        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />


    <div class="col-md-6 mt-2 form-group">
                <input @if(isset($visa_pasted)) disabled @endif required  type="submit" name="btn" value="Save" id="submitBtn24" data-toggle="modal" data-target="#confirm-submit24" class="btn btn-primary btn-save" />
    </div>
    </div>

</form>
<script>
    $(document).ready(function (e){
    $("#visa_pasted_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('renew_visa_pasted_save') }}",
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
