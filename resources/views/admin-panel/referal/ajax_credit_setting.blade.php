<style>

    /*input.form-control.att-input1 {*/
    /*    !* border: 1px solid red; *!*/
    /*    background: #f44336;*/
    /*    color: #ffffff;*/
    /*    width: 65px;*/
    /*    height: 50px;;*/
    /*    padding: 14px;*/
    /*    text-align: center;*/
    /*}*/
    /*input.form-control.att-input2 {*/
    /*    !* border: 1px solid red; *!*/
    /*    background: #bbbbbb;*/
    /*    color: #ffffff;*/
    /*    width: 65px;*/
    /*    height: 50px;;*/
    /*    padding: 14px;*/
    /*    text-align: center;*/
    /*}*/
    /*input.form-control.att-input3 {*/
    /*    !* border: 1px solid red; *!*/
    /*    background: #4caf50;*/
    /*    color: #ffffff;*/
    /*    width: 65px;*/
    /*    height: 50px;*/
    /*    padding: 14px;*/
    /*    text-align: center;*/
    /*}*/
    /*.attendance-one::after {*/
    /*    content: "Bad";*/
    /*    display: block;*/
    /*    position: absolute;*/
    /*    height: 3px;*/
    /*    background: #616d86;*/
    /*    width: 211px;*/
    /*    left: 38%;*/
    /*    top: calc(50% - 2px);*/
    /*    text-align: center;*/
    /*    color: #47404f;*/
    /*    font-weight: 800;*/

    /*}*/

    /*.attendance-two::after {*/
    /*    content: "Average";*/
    /*    display: block;*/
    /*    position: absolute;*/
    /*    height: 3px;*/
    /*    background: #616d86;*/
    /*    width: 211px;*/
    /*    left: 38%;*/
    /*    top: calc(50% - 2px);*/
    /*    text-align: center;*/
    /*    color: #ffc107;*/
    /*    font-weight: 800;*/

    /*}*/
    /*.attendance-three::after {*/
    /*    content: "Good";*/
    /*    display: block;*/
    /*    position: absolute;*/
    /*    height: 3px;*/
    /*    background: #616d86;*/
    /*    width: 107px;*/
    /*    left: 38%;*/
    /*    top: calc(50% - 2px);*/
    /*    text-align: center;*/

    /*    color: #4caf50;*/
    /*    font-weight: 800;*/
    /*}*/


    /*.attendance-before::after {*/
    /*    content: "Criticle";*/
    /*    display: block;*/
    /*    position: absolute;*/
    /*    height: 3px;*/
    /*    background: #616d86;*/
    /*    width: 211px;*/
    /*    left: 35%;*/
    /*    top: calc(50% - 2px);*/
    /*    color: red;*/
    /*    font-weight: 800;*/
    /*}*/

    /*@media only screen and (max-width: 991px) {*/
    /*    .attendance-one::after {*/
    /*        content: "Bad";*/
    /*        display: block;*/
    /*        position: absolute;*/
    /*        height: 3px;*/
    /*        background: #616d86;*/
    /*        width: 211px;*/
    /*        left: 60%;*/
    /*        top: calc(50% - 2px);*/
    /*        text-align:  start;*/
    /*        color: #47404f;*/
    /*        font-weight: 800;*/
    /*    }*/
    /*    .attendance-two::after {*/
    /*        content: "Average";*/
    /*        display: block;*/
    /*        position: absolute;*/
    /*        height: 3px;*/
    /*        background: #616d86;*/
    /*        width: 211px;*/
    /*        left: 60%;*/
    /*        top: calc(50% - 2px);*/
    /*        text-align:  start;*/
    /*        color: #ffc107;*/
    /*        font-weight: 800;*/
    /*    }*/
    /*    .attendance-three::after {*/
    /*        content: "Good";*/
    /*        display: block;*/
    /*        position: absolute;*/
    /*        height: 3px;*/
    /*        background: #616d86;*/
    /*        width: 81px;*/
    /*        left: 60%;*/
    /*        top: calc(50% - 2px);*/
    /*        text-align: center;*/
    /*        color: #4caf50;*/
    /*        font-weight: 800;*/
    /*    }*/
    /*}*/





</style>

<form method="post" enctype="multipart/form-data"
      action="{{isset($ref_settings)?route('referral_setting_update',$ref_settings->id):route('referral_settings_store')}}">
    {!! csrf_field() !!}
    @if(isset($ref_settings))
    {{ method_field('GET') }}
    @endif


    <div class="row">
        <div class="col-sm-12">
            <h5 class="modal-title" id="verifyModalContent_title2">Referral Credit Amount</h5><br><br></div>

        <div class="col-md-12 form-group mb-3">
            <input class="form-control" value="{{isset($ref_settings)?$ref_settings->amount:""}}" type="text" name="amount"  placeholder="Enter Referral Credit Amount" />
        </div>


        <div class="col-md-12 input-group  form-group mb-3">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>
<div>


</div>

