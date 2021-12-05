{{-- <form action ="{{ route('electronic_pre_app.store') }}" method="POST" enctype="multipart/form-data"> --}}

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
@if(isset($elec_pre_app))
@if($elec_pre_app->replace_status=='1')
<a id="edit_data"  href="javascript:void(0)" style="float: right;"> <span class="badge badge-pill badge-danger m-2">Add New Dertail</span></a>
@endif
@endif

@if(isset($elec_pre_app))
@if($elec_pre_app->replace_status=='2')
 <span class="badge badge-pill badge-success m-2">Replaced Data</span>
@endif
@endif

    <h5 class="modal-title" id="exampleModalCenterTitle">Electronic Pre Approval</h5>
    @if(isset($elec_pre_app))
    <?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif
    <form id="elec_pre_app_form">
    {!! csrf_field() !!}

    <div class="row">

        <div class="col-md-6">
            <label for="repair_category">Labour Approval</label>
            @if(isset($elec_pre_app))
                <select id="labour_approval1" name="labour_approval" class="form-control form-control"  required {{isset($elec_pre_app)?'disabled':""}}>
                    <option value="1"  @if($elec_pre_app->labour_approval=="1")  selected  @endif selected disabled >Yes</option>
                    <option value="2" @if($elec_pre_app->labour_approval=="2") selected disabled @endif>No</option>
                </select>
            @else
            <select id="labour_approval" name="labour_approval" class="form-control form-control"  required  >
                <option >Select option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
                @endif
        </div>



        <div class="col-md-6">
            <label for="repair_category">Labour Card Number</label>
            <input type="hidden" name="request_id" value="{{isset($elec_pre_app)?$elec_pre_app->id:""}}" >
            <input class="form-control form-control" id="labour_card_no"
                   name="labour_card_no" value="{{isset($elec_pre_app)?$elec_pre_app->labour_card_no:""}}"  @if(isset($elec_pre_app)) readonly @endif  type="text" placeholder="Enter Labour Card"  required />
        </div>


        <div class="col-md-6">
            <label for="repair_category"> Attachment</label>
            @if(isset($elec_pre_app))
                @if($elec_pre_app->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($elec_pre_app->visa_attachment) as $visa_attach)

                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/electronic_pre_approval/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                        <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                    </a>


                        {{-- <a class="attachment_display" href="{{isset($elec_pre_app->visa_attachment)?url('assets/upload/electronic_pre_approval/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name1"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple type="file"  />
            @endif
        </div>
        <br><br><br>

            <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden" required />
            <div class="col-md-6 mt-2 form-group">
                <input type="hidden" value=""  name="edit_status" id="edit_status">
                <input type="submit" @if(isset($elec_pre_app)) disabled @endif name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />

            </div>



    </div>
</form>

<script>
$( "#edit_data" ).click(function() {
            $('#labour_approval1').removeAttr('disabled');
            $('#labour_card_no').removeAttr('readonly');
            $('#file_name').removeAttr('readonly');
            $('#submitBtn').removeAttr('disabled');
            $('input[name=edit_status]').val('1');
            $('#file_name1').show();
$('#file_name3').show();


    });
    </script>

    <script>
    $(document).ready(function (e){
    $("#elec_pre_app_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('electronic_pre_app.store') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#elec_pre_app_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Electronic Pre Approval Added Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    refresh(response.passport_no)
                    $("body").removeClass("loading");
                }
                else if(response.code == 102){
                    toastr.error("Person Code already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 103){
                    toastr.error("Person Code already exists !", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                else if(response.code == 104){
                    toastr.success("Offer Letter Updated Successfully!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    $('.bd-example-modal-lg').modal('hide');
                    $('#labour_approval1').removeAttr('disabled',true);
                    $('#labour_card_no').removeAttr('readonly',true);
                    $('#file_name').removeAttr('readonly',true);
                    $('#submitBtn').removeAttr('disabled',true);
                    $('input[name=edit_status]').val();
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
$('#labour_approval1').removeAttr('required');
$('#labour_card_no').removeAttr('required');

$('#file_name').removeAttr('required');
$('#payment_amount').removeAttr('required');
$('#fine_amount').removeAttr('required');
$('#payment_type').removeAttr('required');
$('#transaction_no').removeAttr('required');
$('#transaction_date_time').removeAttr('required');
$('#vat').removeAttr('required');
$('#file_name_attach').removeAttr('required');

</script>
@endif
