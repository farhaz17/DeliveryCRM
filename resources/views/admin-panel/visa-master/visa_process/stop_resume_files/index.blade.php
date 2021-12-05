
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
    Visa Process Stop & Resume -
    @if($step=='2')
    Offer Letter
@elseif($step=='3')
Offer Letter Submission
@elseif($step=='4')
Electronic Pre Approval
@elseif($step=='5')
Electronic Pre Approval Payment
@elseif($step=='6')
Print Visa Inside/Outside
@elseif($step=='7')
Unique Emirates ID Received

@elseif($step=='8')
Status Change
@elseif($step=='9')
In-Out Status Change
@elseif($step=='10')
Entry Date
@elseif($step=='11')
Medical
@elseif($step=='12')
Medical
@elseif($step=='13')
Medical
@elseif($step=='14')
Medical
@elseif($step=='15')
Fit/Unfit
@elseif($step=='16')
Emirates ID Apply
@elseif($step=='17')
Emirates ID Finger Print(Yes/No)
@elseif($step=='18')
New Contract Application Typing
@elseif($step=='19')
Tawjeeh Class
@elseif($step=='20')
New Contract Submission
@elseif($step=='21')
Labour Card Print
@elseif($step=='22')
Visa Stamping Application(Urgent/Normal)
@elseif($step=='23')
Waiting For Approval(Urgent/Normal)
@elseif($step=='24')
aiting For Zajeel
@elseif($step=='25')
Visa Pasted
@elseif($step=='26')
Unique Emirates ID Received
@else
Unique Emirates ID Handover
    @endif

</h5>
{{-- <form  action="{{ route('elec_pre_app_payment') }}" method="POST" enctype="multipart/form-data"> --}}
    <form  id="stop_resume_form">
    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-12">

            <label for="repair_category">Remakrs</label>
            <textarea class="form-control form-control" required name="remarks" id="remarks" cols="30" rows="5"   @if(isset($stop_and_resume)) readonly @endif>{{isset($stop_and_resume)?$stop_and_resume->remarks:""}}</textarea>
        </div>


        <div class="col-md-12">
            <label for="repair_category">Time & Date</label>
            <input type="text" class="form-control  form-control" value="{{isset($stop_and_resume->time_and_date)?$stop_and_resume->time_and_date:''}}" @if(isset($stop_and_resume)) readonly @endif   id="time_and_date_stop" name="time_and_date" >

        </div>
            <input id="passport_id" name="passport_id" value="{{ $id  }}"  type="hidden"   />
            <input id="user_id" name="user_id" value="{{ $user_id  }}"  type="hidden"   />
            <input id="visa_process_step_id" name="visa_process_step_id" value="{{ $step  }}"  type="hidden"   />


    </div>
    <hr>


    <div class="row resume_row"
     @if(isset($stop_and_resume) && isset($stop_and_resume->status)=='1' || isset($stop_and_resume->status)=='2')
    @else
    style="display:none"
    @endif >
        <div class="col-md-12">
            <label for="repair_category">Resume Remakrs</label>
            <textarea class="form-control form-control" name="resume_remarks" id="remarks" cols="30" rows="5"   @if(isset($stop_and_resume) && $stop_and_resume->resume_remarks !=null ) readonly @endif>{{isset($stop_and_resume)?$stop_and_resume->resume_remarks:""}}</textarea>
        </div>


        <div class="col-md-12">
            <label for="repair_category">Resume Time & Date</label>

            <input class="form-control form-control" value="{{isset($stop_and_resume)?$stop_and_resume->resume_time_and_date:""}}"
            @if(isset($stop_and_resume) && $stop_and_resume->resume_time_and_date !=null ) readonly @endif  id="time_and_date" name="resume_time_and_date" type="text" placeholder="Enter Time & Date" />
            <input type="hidden" name="row_id" value="{{isset($stop_and_resume)?$stop_and_resume->id:""}}">
        </div>

    </div>

        <div class="col-md-6 mt-2 form-group">
            <input @if(isset($stop_and_resume) && $stop_and_resume->status=='2') disabled @endif  type="submit" name="btn" value="Save" id="submitBtn27" data-toggle="modal" data-target="#confirm-submit27" class="btn btn-primary btn-save" />
        </div>

</form>

<script>
     tail.DateTime("#time_and_date_stop",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: "HH-mm-ss",
                }).reload();

</script>
<script>
    tail.DateTime("#time_and_date",{
               dateFormat: "YYYY-mm-dd",
               timeFormat: "HH-mm-ss",
               }).reload();

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
    $("#stop_resume_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('stop_resume_save') }}",
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
                    toastr.success("Visa Process Has Been Stopped Successfully!", { timeOut:10000 , progressBar : true});
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

                else if(response.code==102){
                    toastr.error("Wrong date and time formate", { timeOut:10000 , progressBar : true});
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
