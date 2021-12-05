
    <div class="col-md-2"> </div>
    <div class="col-md-8">

        <div class="card card-profile-1 mb-4">
            <div class="card-body text-center">
                <div class="avatar box-shadow-2 mb-3">

                    <img src="{{  $image ? url($image) : asset('assets/images/user_avatar.jpg') }}" alt=""></div>
                <h5 class="m-0">{{$name}}</h5>
                <p class="mt-0"><span class="badge badge-secondary m-2"> {{$ppuid}}</span></p>
                <p class="mt-0">{{$passport_no}}</p>
                <p><span class="badge badge-danger m-2">   {{$remain_days}}</span></p>
                <div class="alert-div">
                @if($visa_remarks=='2' || $visa_remarks=='4' )
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa process cannot be cancelled!</strong>
                   Visa process has already been cancelled!
                </div>
                @elseif($visa_remarks=='6')
                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa process cannot be cancelled!</strong>
                   Cancellation request has already been sent
                 </div>

                 @elseif($visa_remarks=='7')
                 <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Visa process cannot be cancelled!</strong>
                    Visa process has not been started yet
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
            @if($visa_remarks=='1' || $visa_remarks=='3' || $visa_remarks=='5')
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

<script>
    $(document).ready(function (e){
    $("#cancel_request_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('cancel_request_save') }}",
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
                    toastr.success("Cancellation Request Added Successfully!", { timeOut:10000 , progressBar : true});

                    $('.bd-example-modal-lg').modal('hide');
                    $("body").removeClass("loading");
                    refresh(response.passport_no)

                }
                else if(response.code == 102) {
                    toastr.error("Cencallation Request Has Already Be Sent!", { timeOut:10000 , progressBar : true});

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















