{{-- <div class="col-md-3 " id="name">{{$name}}</div>
<div class="col-md-3" id="ppuid">{{$ppuid}}</div>
<div class="col-md-3" id="passport_no">{{$passport_no}}</div>
<div class="col-md-3" id="exp_days">{{$remain_days}}</div --}}


{{-- <div class="row"> --}}
<style>
        .center {
  margin: auto;
  width: 50%;
  padding: 10px;
}
    </style>
    <div class="col-md-2"> </div>
    <div class="col-md-8">

        <div class="card card-profile-1 mb-4">
            <div class="card-body text-center">
                <div class="avatar box-shadow-2 mb-3">

                    <img src="{{  $image ? url($image) : asset('assets/images/user_avatar.jpg') }}" alt=""></div>
                <h5 class="m-0">{{$name}}</h5>
                <p class="mt-0"><span class="badge badge-secondary m-2"> {{$ppuid}}</span></p>
                <p class="mt-0">{{$passport_no}}</p>
                <p><span class="badge badge-danger m-2"> <strong> Passport Expiry Date:</strong>    {{$remain_days}}</span></p>
                @if ($visa_renew_com == '2')
                    <p><span class="badge badge-danger m-2"><strong>Current visa expiring at: </strong>  {{$expiry_date_v}}</span></p>
                @elseif($visa_renew_com == '1' && $expiry_date_v !=null)
                <div class="alert alert-danger" role="alert">
                    @if ($expiry_date_v=="1970-01-01")
                    <strong>Expiry date not available:-</strong>
                    @elseif($renew_visa_started>='1' && $renew_expired!=null)
                    <strong >First visa was expired at:-</strong>
                       {{$expiry_date_v}}

                    @else
                    <strong class="text-capitalize">Current visa has already expired:-</strong>
                      Current visa has already expirted at:-   {{$expiry_date_v}}
                    @endif

                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @elseif($visa_renew_com=='3' && $by_pass=='0')
                <div class="alert alert-danger" role="alert">
                    <strong class="text-capitalize">Record not found in visa process!</strong>
                      Record not found in the visa process! Complete the <b>Visa Process</b> before starting <b>Rewnew Visa Process</b> !
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @endif
            </div>
        </div>

    </div>
    @if($renew_visa_started>='1' && $renew_expired==null)
    <div class="alert alert-danger center" role="alert">
        <strong class="text-capitalize">Renew Viswa Process Amount Detail Already Added!</strong>


    </div>
    @endif

    @if($renew_visa_started>='1' && $renew_expired!=null)
    <div class="alert alert-danger center text-center" role="alert">
        <strong class="text-capitalize">Renew Visa Has Been Expired at {{$renew_expired->expiry_date}}</strong>


    </div>
    @endif





    @if($renew_visa_started>='0' || $renew_expired!=null )

    <div class="col-md-12"  @if( $visa_renew_com =='3' && $by_pass=='0') style="display:none" @endif>
        <form method="post" id="passport_form" action="{{ route('visa_renew.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="card card-profile-1 mb-4">
            <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <div class="card card-profile-1 mb-4">
                <div class="card-body">


                <div class="row">
                    <input type="hidden" name="passport_id" value="{{$passport_id}}">
                <div class="col-md-5" style="margin-bottom:05px;">
                    <label for="visit_entry_date">Discount Name</label>
                    <select name="discount_name[]" id="discount_name" class="form-control" >
                        <option value="" selected disabled >please select option</option>
                        @foreach($discount_names as $names)
                            <option value="{{ $names->names }}">{{ $names->names }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5" style="margin-bottom:05px;">
                        <label for="visit_entry_date">Discount Amount</label>
                        <input type="number" name="discount_amount[]" id="discount_offer"  class="form-control amount_cls" >
                </div>

               <div class="col-md-2">
                    <button class="btn btn-primary btn-icon m-1" id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                </div>

                <div class="row append_discount_row"> </div>
              </div>

                </div>
            </div>

            </div>
            {{-- md-6 ends here --}}













            <div class="col-md-6">
                <div class="card card-profile-1 mb-4">
                    <div class="card-body">
                <div class="row ">
                    <div class="col-md-6 form-group mb-3">
                        <label for="repair_category">Agreed Amount</label>
                        <input type="number" required class="form-control amount_cls" required name="agreed_amount"   id="agreed_amount">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="repair_category">Advance Amount</label>
                        <input type="number" required class="form-control amount_cls" required name="advance_amount"   id="advance_amount">
                    </div>

                    <div class="col-md-6">
                        <label for="repair_category">Final Amount</label>
                        <input type="number" required class="form-control"  name="final_amount"   readonly id="final_amount">
                    </div>


                    <div class="col-md-6">
                        <label for="repair_category">Select Agreement</label>
                        <input type="file"  name="attchemnt" class="form-control" >
                    </div>


                    <div class="col-md-6 ">
                        <label class="checkbox checkbox-outline-primary  mt-4">
                            <input type="checkbox" class="form-control" value="1" name="payroll_deduct" id="payroll_deduct">Is Payroll Deduct
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-6 payroll_deduct_amount_div mt-4 hide_cls" style="display: none" >
                        <label for="repair_category">Payroll Deduct Amount</label>
                        <input type="number"    class="form-control step_amount_cls"  name="payroll_deduct_amount"    id="payroll_deduct_amount">
                    </div>
                    <div class="col-md-12 form-group ml-3">
                        <div class="row">
                            <label>
                                <span>Amount</span>
                                <h6 id="final_amount_label_cls">0</h6>
                            </label>
                            </div>
                    </div>




                    {{-- <div class="row step_amount_row"> --}}
                        <div class="col-md-6 form-group">
                            <label for="visa_requirement">Select step Amount </label>
                            <select name="select_amount_step[]" id="select_amount_step"   class="form-control form-control-rounded select_amount_step_cls">
                                <option value=""  selected disabled >Select option</option>

                                @foreach($master_steps as $steps)
                                    <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="visa_requirement">Amount</label>
                            <input type="number" name="step_amount[]"  id="step_amount_first"  class="form-control step_amount_cls">
                            <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                        </div>
                        <div class="row  step_amount_row amount_step_row_cls"></div>

                        <div class="col-md-6 form-group">
                            <button style="display: none" id="passport_cancel" type="submit">Save</button>

                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Save</button>


                         </div>


                    {{-- </div> --}}
                    {{-- //step amount row --}}

                </div>


            </div>
            </div>
        </div>
            {{-- md-6 ends here --}}


        </div>

    </div>

        </div>
    </form>
</div>
@endif




{{-- confirm modal --}}
{{-- confirm modal --}}
{{-- confirm modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Save Renew Visa Process Amount</h5>
                <button class="close" id="close-btn" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p class="font-weight-bold">Are Your sure want to save visa process amount?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button class="btn btn-primary ml-2 btn-cancel" type="button">Yes</button>
            </div>
        </div>
    </div>
</div>
{{-- confirm modal-ends --}}
{{-- confirm modal-ends --}}
{{-- confirm modal-ends --}}



<script>
    $(".btn-cancel").click(function(){
        $("#passport_cancel").click();

    });
</script>
<script>
//get the datail from form and send to controller

$("#passport_form").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#passport_form").attr('action');


            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("#passport_form").trigger("reset");
                    $("body").removeClass("loading");

                    if(response.code == 100) {
                    toastr.success("Renew Visa Process added Successfully!", { timeOut:10000 , progressBar : true});
                    $('#exampleModal').modal('hide');
                    $("body").removeClass("loading");

                }
                else {
                    $("#passport_form").trigger("reset");
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });
    </script>
      <script>

        //deleta and adding step amount

        var count_discount_ab = 50001
        $("#btn_add_discount_row").click(function () {
            count_discount_ab = parseInt(count_discount_ab)+1
            var id_now =  count_discount_ab;

            var html =  add_new_discount_row(id_now);
            $(".append_discount_row").append(html);

            $("#discount_amount-"+id_now).prop('required',true);
            $("#discount_name-"+id_now).prop('required',true);

        });

        $('.append_discount_row').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".discunt_div-"+now[1]).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

            $.ajax({
                url: "{{ route('ajax_onboard_checkin') }}",
                method: 'GET',
                data: {id: ids},
                success: function(response) {

                }
            });


        });

        var count_doc_ab = 40001

        $("#btn_add_doc_row").click(function () {
            count_doc_ab = parseInt(count_doc_ab)+1
            var id_now =  count_doc_ab;

            var html =  add_new_document_row(id_now);
            $(".doc_row_append").append(html);

            $("#doc_name-"+id_now).prop('required',true);
            $("#doc_image-"+id_now).prop('required',true);

        });

        $('.doc_row_append').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".doc_div-"+now[1]).remove();

            // var value_current = $("#image_array").val();
            // var now_value = value_current+","+id;
            // $("#image_array").val(now_value);


        });




    </script>

<script>
    $("#payroll_deduct").click(function(){

        if($("#payroll_deduct").prop('checked') == true){
            // $(".step_amount_row").hide();
            $(".amount_step_row_cls").html("");
            $("#select_amount_step").prop("required",false);
            $("#step_amount_first").prop("required",false);
            $("#step_amount_first").val("0");
            $(".payroll_deduct_amount_div").show();
            $("#payroll_deduct_amount").prop("required",true);

            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);
        }else{
            $(".payroll_deduct_amount_div").hide();
            $("#payroll_deduct_amount").prop("required",false);



            $(".step_amount_row").show();
            $("#select_amount_step").prop("required",true);
            $("#step_amount_first").prop("required",true);
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);
        }

    });
</script>

<script>

    function  calculate_others() {

        var agreed_amount = $("#agreed_amount").val();



        var sum = 0;
        $('.amount_cls').each(function(){
            if($(this).attr('id')=="agreed_amount"){

            }else{
                console.log($(this).val());
                if($(this).val()!=''){
                    sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                }
            }
        });
        var now_remain = parseFloat(agreed_amount)-parseFloat(sum);
        return now_remain

    }
    $('body').on('change', '.amount_cls', function() {
        var remain_val = calculate_others();
        $("#final_amount").val(remain_val);

        $("#final_amount_label_cls").html(remain_val);

    });
    $('body').on('change', '.step_amount_cls', function() {
        var remain_val = calculate_others();
        var sum = 0;
        $('.step_amount_cls').each(function(){

                console.log($(this).val());
                if($(this).val()!=''){
                    sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                }
        });

       var final_amount = $("#final_amount").val();

       var now_remain = parseFloat(final_amount)-parseFloat(sum);

        $("#final_amount_label_cls").html(now_remain);




    });




</script>


<script>
    function append_form_amount_step(id){
        html = '<div class="col-md-6 form-group step_amount-'+id+' "><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps)<option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>@endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
        return html;
    }
    var count_amount_step = 0;
    $(".add_step_form_btn").click(function(){
        count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;
        $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));
        $('#select_amount_step-'+count_amount_step).select2({
            placeholder: 'Select an option'
        });
    });

    $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {
        var ids = $(this).attr('id');
        $("."+ids).remove();
        var remain_val = calculate_others();
        $("#final_amount").val(remain_val);

    });

</script>



     <script>

//deleta and adding step amount

var count_discount_ab = 50001
$("#btn_add_discount_row").click(function () {
    count_discount_ab = parseInt(count_discount_ab)+1
    var id_now =  count_discount_ab;

    var html =  add_new_discount_row(id_now);
    $(".append_discount_row").append(html);

    $("#discount_amount-"+id_now).prop('required',true);
    $("#discount_name-"+id_now).prop('required',true);

});

$('.append_discount_row').on('click', '.remove_discount_row', function() {

    var ids = $(this).attr('id');
    var now = ids.split("-");

    $(".discunt_div-"+now[1]).remove();
    var remain_val = calculate_others();
    $("#final_amount").val(remain_val);

    $.ajax({
        url: "{{ route('ajax_onboard_checkin') }}",
        method: 'GET',
        data: {id: ids},
        success: function(response) {

        }
    });


});

var count_doc_ab = 40001

$("#btn_add_doc_row").click(function () {
    count_doc_ab = parseInt(count_doc_ab)+1
    var id_now =  count_doc_ab;

    var html =  add_new_document_row(id_now);
    $(".doc_row_append").append(html);

    $("#doc_name-"+id_now).prop('required',true);
    $("#doc_image-"+id_now).prop('required',true);

});

$('.doc_row_append').on('click', '.remove_discount_row', function() {
    var ids = $(this).attr('id');
    var now = ids.split("-");
    $(".doc_div-"+now[1]).remove();
    // var value_current = $("#image_array").val();
    // var now_value = value_current+","+id;
    // $("#image_array").val(now_value);
});



function add_new_discount_row(id){
    var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $name)<option value="{{ isset($name->names)?$name->names:"" }}">{{ isset($names->names)?$names->names:"" }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
    return html;
}

</script>


<script>
    function append_form_amount_step(id){
        html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps)<option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>@endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
        return html;
    }
    var count_amount_step = 0;
    $(".add_step_form_btn").click(function(){

        count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;

        $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));

        $('#select_amount_step-'+count_amount_step).select2({
            placeholder: 'Select an option'
        });

    });

    $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {

        var ids = $(this).attr('id');

        $("."+ids).remove();
        var remain_val = calculate_others();
        $("#final_amount").val(remain_val);

    });

</script>


<script>
          $('#select_amount_step').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });

                    $('#discount_name').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });
</script>











