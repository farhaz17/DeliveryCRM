{{-- <form action ="{{ route('fit_unfit') }}" method="POST" enctype="multipart/form-data"> --}}
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
    <h5 class="modal-title" id="exampleModalCenterTitle">Fit/Unfit</h5>
    @if(isset($fit_unfit))
            <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
        @hasanyrole($roll_array)
        <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        @endif
    <form id="fit_unfit_form">
    {!! csrf_field() !!}
    <div class="row">
        {{-- <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($fit_unfit))
                <select id="status" name="status" class="form-control form-control"  required {{isset($fit_unfit)?'disabled':""}}>
                    @php
                        $isSelected=(isset($fit_unfit)?$fit_unfit->status:"")==$fit_unfit->id;
                    @endphp
                    @if($fit_unfit->status=="1")
                    <option value="{{$fit_unfit->status}}" selected disabled >Fit</option>
                    @else
                    <option value="{{$fit_unfit->status}}" selected disabled>Unfit</option>
                        @endif
                </select>
            @else
            <select id="status" name="status" class="form-control form-control"  required  >
                <option >Select option</option>
                <option value="1">Fit</option>
                <option value="0">Unfit</option>
            </select>
                @endif

        </div> --}}

        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($fit_unfit))
                <select id="status" name="status" class="form-control form-control"  required {{isset($fit_unfit)?'disabled':""}}>
                    <option value="1"  @if($fit_unfit->status=="1")  selected  @endif  >Fit</option>
                    <option value="0" @if($fit_unfit->status=="0") selected disabled @endif>Unfit</option>
                </select>
            @else
            <select id="status" name="status" class="form-control form-control"  required  >
                <option >Select option</option>
                <option value="1">Fit</option>
                <option value="0">Unfit</option>
            </select>
                @endif
        </div>

        <div class="col-md-6">
            <label for="repair_category">Date</label>
            <input class="form-control form-control" value="{{isset($fit_unfit)?$fit_unfit->fit_unfit_date:""}}"
            @if(isset($fit_unfit)) readonly @endif id="fit_unfit_date" name="fit_unfit_date" type="date" placeholder="Enter  Date" required />

            <input type="hidden" name="request_id"  value="{{isset($fit_unfit)?$fit_unfit->id:""}}">
        </div>



        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>

            @if(isset($fit_unfit))
                @if($fit_unfit->other_attachment!=null)
                    <br>
                    @foreach (json_decode($fit_unfit->other_attachment) as $visa_attach)
                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/fit_unfit/other_attachments/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong  style="color: #000000">View Attachment</strong>
                    </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="file_name[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="file_name[]" multiple type="file"  />
            @endif
        </div>



            <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />
        <div class="col-md-6 form-group">
                <div class="col-md-12 mt-3 form-group">
                    <input type="hidden" value=""  name="edit_status" id="edit_status">
                    <input @if(isset($fit_unfit)) disabled @endif type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit14" class="btn btn-primary btn-save" />
                </div>

        </div>
    </div>
</form>


<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');
        $('#file_name').removeAttr('readonly');
        $('#fit_unfit_date').removeAttr('readonly');
    $('#submitBtn').removeAttr('disabled');
    $('input[name=edit_status]').val('1');
    $('#file_name1').show();
$('#file_name3').show();


    });
    </script>
<script>
    $(document).ready(function (e){
    $("#fit_unfit_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('fit_unfit') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#fit_unfit").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Fit Unfit Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    refresh(response.passport_no)
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.success("Fit Unfit Updated Successfully!", { timeOut:10000 , progressBar : true});
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
$('#fit_unfit_date').removeAttr('required');


</script>

@endif
