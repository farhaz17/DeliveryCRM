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
<?php  $roll_array = ['Admin','VisaProcessManager']; ?>
@if(isset($handover))
@hasanyrole($roll_array)
<a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
@endhasanyrole
@endif
    <form  id="handover_form">
    {!! csrf_field() !!}
    <div class="row">

        <div class="col-md-6 form-group mb-3">
            <label for="repair_category">Handover To Person</label>
            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent" id="basic-addon1">
                    <i class="i-Magnifi-Glass1"></i>
                </span>
            </div>
                <input class="form-control form-control-sm typeahead"
                 value="{{isset($handover->handover_person->personal_info->full_name)?$handover->handover_person->personal_info->full_name:""}} "
                 id="keyword"  autocomplete="off" type="text"
                 required  name="name" placeholder="search..." aria-label="Username"
                 aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <span class="input-group-text bg-transparent" id="basic-addon2">
                        <i class="i-Search-People"></i>
                    </span>
                </div>
                <input class="form-control" id="passport_number" value="{{isset($handover->handover_person->passport_no)?$handover->handover_person->passport_no:""}}" name="passport_number"  type="hidden" value="" />
            </div>
        </div>

        <input type="hidden" name="request_id"  value="{{isset($handover)?$handover->id:""}}">

        <div class="col-md-6">
            <label for="repair_category">Handover Date</label>
            <input type="date" required class="form-control" value="{{isset($handover)?$handover->handover_date:""}}" @if(isset($handover)) readonly @endif id="handover_date" required name="handover_date" >
        </div>

        {{-- <div class="col-md-6">
            <label for="repair_category">Unique Emirates ID Handover</label>
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
        </div> --}}

        <div class="col-md-6">
            <label for="repair_category">Status</label>
            @if(isset($handover))
                <select id="status" name="status" class="form-control form-control"  required {{isset($handover)?'disabled':""}}>
                    <option value="1"  @if($handover->status=="1")  selected  @endif  >Yes</option>
                    <option value="0" @if($handover->status=="0") selected  @endif>No</option>
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
                @if($handover->visa_attachment!=null)
                    <br>
                    @foreach (json_decode($handover->visa_attachment) as $visa_attach)

                        {{-- <a class="attachment_display" href="{{isset($handover->visa_attachment)?url('assets/upload/handover/'.$visa_attach):""}}" id="passport_image" target="_blank">
                            <strong style="color: blue">View Attachment</strong>
                        </a> --}}

                        <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/handover/'.$visa_attach, now()->addMinutes(5))}}" id="passport_image" target="_blank">
                            <strong style="color: rgb(0, 0, 0)">View Attachment</strong>
                        </a>
                        <span>|</span>

                    @endforeach
                @endif
                <input class="form-control form-control mt-4 mb-4" style="display: none" id="file_name3"  name="visa_attachment[]" multiple type="file"  />
            @else
                <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple

                       type="file"  />
            @endif
        </div>



        <input  id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"  />



    <div class="col-md-6 mt-2 form-group">
        <input type="hidden" value=""  name="edit_status" id="edit_status">

                <input @if(isset($handover)) disabled @endif  type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit26" class="btn btn-primary btn-save" />



    </div>

    </div>
</form>
<script>

    $( "#edit_data" ).click(function() {
        $('#status').removeAttr('disabled');

        $('#file_name').removeAttr('readonly');
        $('#file_name').removeAttr('readonly');
        $('#handover_date').removeAttr('readonly');
        $('#keyword').removeAttr('readonly');

    $('#submitBtn').removeAttr('disabled');
    $('input[name=edit_status]').val('1');
    $('#file_name1').show();
                        $('#file_name3').show();


    });
    </script>

<script type="text/javascript">
    var path = "{{ route('autocomplete_eid_handover') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {

                return process(data);
            });
        },
        highlighter: function (item, data) {
            var parts = item.split('#'),
                html = '<div class="row drop-row">';
            if (data.type == 0) {
                html += '<div class="col-lg-12 sugg-drop_eid">';
                html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                html += '<div><br></div>';
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type == 1){
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }  else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==3){
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==4){
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==5)
            {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==6) {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==7) {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==8) {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==9) {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==10) {
                html += '<div class="col-lg-12 sugg-drop_eid" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }

            return html;
        }
    });
</script>

<script>
    $(document).on('click', '.sugg-drop_eid', function(){

                      var keyword  =   $(this).find('#drop-name').text();
                      $('input[name=passport_number]').val(keyword);

                  });
      </script>
<script>
    $(document).ready(function (e){
    $("#handover_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('handover') }}",
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
$('#file_name').removeAttr('required');
$('#handover_date').removeAttr('required');
$('#keyword').removeAttr('required');







</script>

@endif
