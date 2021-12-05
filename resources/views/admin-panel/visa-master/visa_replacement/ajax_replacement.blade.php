
    <div class="col-md-2"> </div>
    <div class="col-md-8">

        <div class="card card-profile-1 mb-4">
            <div class="card-body text-center">
                <div class="avatar box-shadow-2 mb-3">

                    <img src="{{  $image ? url($image) : asset('assets/images/user_avatar.jpg') }}" alt=""></div>
                <h5 class="m-0">{{$name}} </h5>
                <p class="mt-0"><span class="badge badge-secondary m-2"> {{$ppuid}}</span></p>
                <p class="mt-0">{{$passport_no}}</p>
                <p><span class="badge badge-danger m-2">   {{$remain_days}}</span></p>
                <div class="alert-div">

                @if($validation_remarks == '1')
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa process cannot cancelled!</strong>
                   Requesest has already sent !
                </div>
                @endif

                @if($validation_remarks=='3')
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa process cannot cancelled!</strong>
                    Visa Process has not been started yet!
                 </div>
                @endif
            </div>
        </div>
        </div>

    </div>
<div class="col-md-12">
    <div class="card">
        <div class="card-body ">
    <div class="row">

        <div class="col-md-1"></div>
        <div class="col-md-10">
            @if($validation_remarks == null || $validation_remarks == '2' )


            <form   id="cancel_request_form">
                {!! csrf_field() !!}
                   <div class="row">
                       <div class="col-md-12" id="remarks_div">
                       <label for="repair_category">Remarks</label>
                           <textarea name="remarks" id="remarks" class="form-control form-control" cols="30" rows="5"></textarea>
                       </div>
                       <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $passport_id  }}"  type="hidden"/>
                       <input class="form-control form-control" id="hr_reqest" name="hr_reqest" value="{{ $sent_from  }}"  type="hidden"/>

                   </div>
                   <div class="row">

                <input type="hidden" name="hr_req" value="{{$hr_reqs}}" id="hr_req">
                <input type="hidden" name="pro_req" value="{{$pro_req}}" id="pro_req">

                       <div class="col-md-12 mt-2 form-group">
                           <input type="submit" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
                       </div>
                   </div>
          </form>
          @endif


        </div>
        <div class="col-md-1"></div>

    </div>
    </div>
</div>
</div>
  <script type="text/javascript">
        var path = "{{ route('autocomplete_cancels') }}";
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
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop2">';
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
                    html += '<div class="col-lg-12 sugg-drop2">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop2">';
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
  $(document).on('click', '.sugg-drop2', function(){
                    var token = $("input[name='_token']").val();
                    var keywords  =   $(this).find('#drop-name').text();
                    var sent_from='0';

                    $('input[name=passport_numbers]').val(keywords);
                    // $.ajax({
                    //     url: "{{ route('cancel_visa_request_get_info') }}",
                    //     method: 'POST',
                    //     dataType: 'json',
                    //     data:{keyword:keyword,_token:token,sent_from:sent_from},
                    //     beforeSend: function () {
                    //         $("body").addClass("loading");
                    // },
                    //     success: function (response) {
                    //         $('.row_show').empty();

                    //          $("body").removeClass("loading");

                    //         $('.row_show').append(response.html);
                    //         $('.row_show').show();
                    //     }
                    // });
                });
    </script>
<script>
    $(document).ready(function (e){
    $("#cancel_request_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('repacement_request_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){

                $("#cancel_request_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Replacement Request Added Successfully!", { timeOut:10000 , progressBar : true});

                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)

                }
                else if(response.code == 102) {
                    toastr.error("Replacement Request Has Already Be Sent!", { timeOut:10000 , progressBar : true});

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















