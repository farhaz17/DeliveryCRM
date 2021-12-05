<style>

    input.form-control.att-input1 {
        /* border: 1px solid red; */
        background: #f44336;
        color: #ffffff;
        width: 65px;
        height: 50px;;
        padding: 14px;
        text-align: center;
    }
    input.form-control.att-input2 {
        /* border: 1px solid red; */
        background: #bbbbbb;
        color: #ffffff;
        width: 65px;
        height: 50px;;
        padding: 14px;
        text-align: center;
    }
    input.form-control.att-input3 {
        /* border: 1px solid red; */
        background: #4caf50;
        color: #ffffff;
        width: 65px;
        height: 50px;
        padding: 14px;
        text-align: center;
    }
    .attendance-one::after {
        content: "Bad";
        display: block;
        position: absolute;
        height: 3px;
        background: #616d86;
        width: 211px;
        left: 38%;
        top: calc(50% - 2px);
        text-align: center;
        color: #47404f;
        font-weight: 800;

    }

    .attendance-two::after {
        content: "Average";
        display: block;
        position: absolute;
        height: 3px;
        background: #616d86;
        width: 211px;
        left: 38%;
        top: calc(50% - 2px);
        text-align: center;
        color: #ffc107;
        font-weight: 800;

    }
    .attendance-three::after {
        content: "Good";
        display: block;
        position: absolute;
        height: 3px;
        background: #616d86;
        width: 107px;
        left: 38%;
        top: calc(50% - 2px);
        text-align: center;

        color: #4caf50;
        font-weight: 800;
    }


    .attendance-before::after {
        content: "Criticle";
        display: block;
        position: absolute;
        height: 3px;
        background: #616d86;
        width: 211px;
        left: 35%;
        top: calc(50% - 2px);
        color: red;
        font-weight: 800;
    }

    @media only screen and (max-width: 991px) {
        .attendance-one::after {
            content: "Bad";
            display: block;
            position: absolute;
            height: 3px;
            background: #616d86;
            width: 211px;
            left: 60%;
            top: calc(50% - 2px);
            text-align:  start;
            color: #47404f;
            font-weight: 800;
        }
        .attendance-two::after {
            content: "Average";
            display: block;
            position: absolute;
            height: 3px;
            background: #616d86;
            width: 211px;
            left: 60%;
            top: calc(50% - 2px);
            text-align:  start;
            color: #ffc107;
            font-weight: 800;
        }
        .attendance-three::after {
            content: "Good";
            display: block;
            position: absolute;
            height: 3px;
            background: #616d86;
            width: 81px;
            left: 60%;
            top: calc(50% - 2px);
            text-align: center;
            color: #4caf50;
            font-weight: 800;
        }
    }





</style>

<form method="post" enctype="multipart/form-data"
      action="{{isset($delivroo_settings)?route('deliveroo_setting_update',$delivroo_settings->id):route('deliveroo_settings_store')}}">
    {!! csrf_field() !!}
    @if(isset($delivroo_settings))
        {{ method_field('GET') }}
    @endif




    </div>

    <div class="row">


        <div class="col-sm-12">    <h5 class="modal-title" id="verifyModalContent_title">Attendance (%)</h5><br><br></div>
        <div class="col-md-2 form-group mb-3 attendance-before">

        </div>
        <div class="col-md-3 form-group mb-3 attendance-one">
            <input class="form-control att-input1" value="{{isset($delivroo_settings)?$delivroo_settings->attendance_critical_value:""}}"
            type="text" name="attendance_critical_value"  />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-two">
            <input class="form-control att-input2" value="{{isset($delivroo_settings)?$delivroo_settings->attendance_bad_value:""}}"
            type="text" name="attendance_bad_value" />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-three">
            <input class="form-control att-input3" value="{{isset($delivroo_settings)?$delivroo_settings->attendance_good_value:""}}"
            type="text" name="attendance_good_value"  />
        </div>


    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h5 class="modal-title" id="verifyModalContent_title">Unassigned(%)</h5><br><br></div>
        <div class="col-md-2 form-group mb-3 attendance-before">

        </div>
        <div class="col-md-3 form-group mb-3 attendance-one">
            <input class="form-control att-input1" value="{{isset($delivroo_settings)?$delivroo_settings->unassigned_critical_value:""}}"
                   type="text" name="unassigned_critical_value"  />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-two">
            <input class="form-control att-input2" value="{{isset($delivroo_settings)?$delivroo_settings->unassigned_bad_value:""}}"
                   type="text" name="unassigned_bad_value" />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-three">
            <input class="form-control att-input3" value="{{isset($delivroo_settings)?$delivroo_settings->unassigned_good_value:""}}"
                   type="text" name="unassigned_good_value" />
        </div>


    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h5 class="modal-title" id="verifyModalContent_title">Wait Time at Customer</h5><br><br></div>
        <div class="col-md-2 form-group mb-3 attendance-before">

        </div>
        <div class="col-md-3 form-group mb-3 attendance-one">
            <input class="form-control att-input1" value="{{isset($delivroo_settings)?$delivroo_settings->wait_critical_value:""}}"
                   type="text" name="wait_critical_value" />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-two">
            <input class="form-control att-input2" value="{{isset($delivroo_settings)?$delivroo_settings->wait_bad_value:""}}"
                   type="text" name="wait_bad_value" />
        </div>

        <div class="col-md-3 form-group mb-3 attendance-three">
            <input class="form-control att-input3" value="{{isset($delivroo_settings)?$delivroo_settings->wait_good_value:""}}"
                   type="text" name="wait_good_value" />
        </div>



        <div class="col-md-12 input-group  form-group mb-3">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>

    </div>

</form>
<div>


</div>
<script type="text/javascript">



    $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function(){

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

//Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
            next_fs.show();
//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $(".previous").click(function(){

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

//Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
            previous_fs.show();

//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function(){
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function(){
            return false;
        })

    });
</script>
