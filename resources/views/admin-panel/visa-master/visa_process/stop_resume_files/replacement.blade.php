
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
<h5 class="modal-title" id="exampleModalCenterTitle">
    Visa Process Replacement
</h5>
{{-- <form  action="{{ route('elec_pre_app_payment') }}" method="POST" enctype="multipart/form-data"> --}}
    <form  id="replacement_form">
    {!! csrf_field() !!}

    <div class="row">

            <div class="col-md-12 form-group mb-3" @if(isset($repalancement)) style="display: none" @endif>
                <label for="repair_category">Search</label>
                <div class="input-group ">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent" id="basic-addon1">
                        <i class="i-Magnifi-Glass1"></i>
                    </span>
                </div>
                    <input class="form-control form-control-sm  typeahead2" id="keyword2" @if (isset($passport_no_to)) value="{{$passport_no_to}}" @endif  autocomplete="off" type="text" required  name="replaced_passport_id" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent" id="basic-addon2">
                            <i class="i-Search-People"></i>
                        </span>
                    </div>
                    <input class="form-control" id="replaced_passport_id2" name="replaced_passport_id2" @if (isset($passport_no_to)) value="{{$passport_id_to}}" @endif  type="hidden" value="" />
                </div>
            </div>



            @if(isset($repalancement))
            <div class="col-md-12">
                <br>
                <h4> <b>  Repalced With</b> </h4>
                <h5><b> Name : </b> {{$repalancement->replace_passport->personal_info->full_name}}</h5>
                <hr>
                <h5><b> Passport Number: </b> {{$repalancement->replace_passport->passport_no}}</h5>
            </div>
            @endif


        <div class="col-md-12">

            <label for="repair_category">Remakrs</label>
            <textarea class="form-control form-control" name="remarks" required id="remarks" cols="30" rows="5"   @if(isset($repalancement)) readonly @endif>{{isset($repalancement)?$repalancement->remarks:""}}</textarea>
        </div>
            <input id="passport_id" name="passport_id" value="{{ $passport_id  }}"  type="hidden"   />
            <input id="user_id" name="user_id" value="{{ $user_id  }}"  type="hidden"  />
            <input id="visa_process_id" name="visa_process_id" value="{{ $visa_process_step_id  }}"  type="hidden"   />
            <input id="stop_and_resume_id" name="stop_and_resume_id" value="{{ $stop_and_resume_id  }}"  type="hidden"   />


    </div>
    <hr>

        <div class="col-md-6 mt-2 form-group">
            <input @if(isset($repalancement) && $repalancement->status=='1') disabled @endif  type="submit" name="btn" value="Save" id="submitBtn27" data-toggle="modal" data-target="#confirm-submit27" class="btn btn-primary btn-save" />
        </div>

</form>

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead2').typeahead({
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {

                return process(data);
            });
        },
        highlighter: function (item, data) {
            var parts = item.split('#'),
                html = '<div class="row drop-row">';
            if (data.type == 0) {
                html += '<div class="col-lg-12 sugg-drop2">';
                html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                html += '<div><br></div>';
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type == 1){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }  else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==3){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==4){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==5)
            {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==6) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==7) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==8) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==9) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==10) {
                html += '<div class="col-lg-12 sugg-drop2" >';
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
    $(document).ready(function () {
                                  $('.payment1').hide();

                                  $('#payment_option_app').change(function() {
                                      if ($('#payment_option_app').prop('checked')) {
                                          $('#payment1').show();
                                      } else {
                                          $('#payment1').hide();
                                      }
                                  });
                                  });
 </script>

<script>
    $(document).ready(function (e){
    $("#replacement_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('visa_process_replacement_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#elec_pre_app_payment").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Visa Process Has Been Replaced Successfully!", { timeOut:10000 , progressBar : true});
                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)
                }
                else if(response.code==101){
                    toastr.success("Visa Process Has Been Resumed Successfully!", { timeOut:10000 , progressBar : true});
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


<script>
    $(document).on('click', '.sugg-drop2', function(){
                      var token = $("input[name='_token']").val();
                      var keyword  =   $(this).find('#drop-name').text();
                      $('input[name=replaced_passport_id2]').val(keyword);

                  });
      </script>
