@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 12px;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 600;
        }

        a.btn.btn-primary.btn-sm.mr-2 {
            /* height: 21px; */
            padding: 1px;
        }
        .submenu{
            display: none;
        }
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
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .btn-icon.rounded-circle {
    width: 25px;
    height: 25px;
    padding: 0;
}
    .btn-s{
    padding: 1px;
            }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Visa Process Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>









    <div class="card col-lg-12  mb-2">


        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Pending Visa Processes</h4>


                <table class="table" id="datatable">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Passport No</th>
                        <th>PPUID</th>
                        <th>Change Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $counter=1?>
                    @foreach ($own_visa_to_start as $row)

                    <tr>
                        <td>{{$counter}}</td>
                        <td>{{$row->personal_info->full_name}}</td>
                        <td>{{$row->passport_no}}</td>
                        <td>{{isset($row->pp_uid)?$row->pp_uid:'N/A'}}</td>
                        <td>
                            <a class="text-primary mr-2 visa_add_cls" id="{{ $row->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
                        </td>

                    </tr>
                        <?php $counter++?>

                    @endforeach
                </tbody>
                </table>
                    </div>

                </div>
            </div>
    </div>



    <div class="overlay"></div>




    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="checkin_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="passport_form" action="{{ route('own_visa_change_save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Detail And Agreed Amount</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                       <input type="text" name="career_primary_id" id="career_primary_id" value="">

                    <div class="rowss">
                       <div class="card">
                         <div class="card-body">
                            <div class="col-md-12 visa_status_div">
                                <label for="repair_category" class="font-weight-bold visa_detail_cls">Visa Status</label>
                                <br>
                                <div class="form-check-inline visa_detail_cls">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"    value="1" id="visa_status_visit" name="visa_status" required  ><span>Visit Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline visa_detail_cls">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio"  value="2" id="visa_status_cancel" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline visa_detail_cls visa_status_own_div_cls">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio"  value="3"  id="visa_status_own"   name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="visit_visa_status_cls hide_cls visa_detail_cls" style="display: none">
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="visit_one_month" value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="visit_three_month"  value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <br>
                                    <label for="repair_category">Fine Start Date</label>
                                    <input class="form-control form-control-rounded"  autocomplete="off" name="visit_exit_date"  id="visit_exit_date" value="" type="date"   />

                                </div>



                                <div class="cancel_visa_status_cls hide_cls visa_detail_cls " style="display: none" >
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"  id="cancel_free_zone" value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"   id="cancel_company_visa"  value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"   id="cancel_waiting_cancel"  value="3" name="cancel_visa_status"><span>Waiting Cancellation</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <br>
                                    <label for="repair_category">Fine Start Date</label>
                                    <input class="form-control form-control-rounded"  name="cancel_fine_date"  autocomplete="off" id="cancel_fine_date" value="" type="date"   />
                                </div>

                                <div class="own_visa_status_cls hide_cls visa_detail_cls visa_status_own_div_cls" style="display: none">
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="own_visa_noc"    value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" class="license_type_cls" id="own_visa_without_noc"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>

                        </div>
                        </div>
                    </div>

                        {{-- row1---------------------ends here --}}
                        <div class="card-title mb-3">Agreed Amount</div>

                         <div class="card">
                            <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5" style="margin-bottom:05px;">
                                            <label for="visit_entry_date">Discount Name</label>
                                            <select name="discount_name[]" class="form-control" >
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
                                            <button class="btn btn-primary btn-icon m-1 " id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                        </div>
                                    </div>

                                    <div class="row append_discount_row"> </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="row ">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="repair_category">Agreed Amount</label>
                                            <input type="number" required class="form-control amount_cls" required name="agreed_amount"   id="agreed_amount">
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="repair_category">Advance Amount</label>
                                            <input type="number" required class="form-control amount_cls" required name="advance_amount"   id="advance_amount">
                                        </div>

                                    </div>

                                </div>
                            </div>

                         <div class="row">

                                <div class="col-md-6">

                                </div>

                             <div class="col-md-6">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <label for="repair_category">Final Due Amount</label>
                                         <input type="number" required class="form-control"  name="final_amount"   readonly id="final_amount">
                                     </div>

                                     <div class="col-md-6">
                                         <label for="repair_category">Select Agreement</label>
                                         <input type="file"  name="attchemnt" class="form-control" >
                                     </div>

                                     <div class="col-md-6">
                                             <label class="checkbox checkbox-outline-primary mt-2" >
                                                 <input type="checkbox" value="1" name="payroll_deduct" id="payroll_deduct"><span>Is Payroll Deduct.?</span><span class="checkmark"></span>
                                             </label>

                                         <label>
                                             <span>Amount</span>
                                         </label>
                                         <h6 id="final_amount_label_cls">0</h6>
                                     </div>
                                     <div class="col-md-6 payroll_deduct_amount_div hide_cls" >
                                         <label for="repair_category">Payroll Deduct Amount</label>
                                         <input type="number"    class="form-control step_amount_cls"  name="payroll_deduct_amount"    id="payroll_deduct_amount">
                                     </div>

                                 </div>




                                 <div class="row step_amount_row" >
                                     <div class="col-md-6 form-group ">
                                     <label for="visa_requirement">Select step Amount </label>
                                     <select name="select_amount_step[]" id="select_amount_step"   class="form-control form-control-rounded select_amount_step_cls">
                                         <option value=""  >Select option</option>
                                         @foreach($master_steps as $steps)
                                             @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" )
                                                 <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>
                                             @elseif($steps->id=="6" || $steps->id=="7")
                                                 <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option>
                                             @else
                                                 <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>
                                             @endif

                                         @endforeach
                                     </select>
                                     </div>

                                     <div class="col-md-6 form-group">
                                         <label for="visa_requirement">Amount</label>
                                         <input type="number" name="step_amount[]"  id="step_amount_first"  class="form-control step_amount_cls ">
                                         <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                             <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                     </div>


                                 </div>

                                 <div class="row  step_amount_row amount_step_row_cls"></div>

                             </div>

                        </div>
                        </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport model ends here-----------------}}
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        function ValidateForm(form){
            ErrorText= "";
            if ( ( form.visa_status[0].checked == false ) && (form.visa_status[1].checked == false)  && (form.visa_status[2].checked == false) )
            {
                tostr_display("error","please select visa status");
                return false;
            }
            if (ErrorText= "") { form.submit() }
        }

        $("#visa_status_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = $("#visa_status_form").attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                  if(response=="success"){
                      tostr_display("success","Visa status updated successfully");
                      window.setTimeout(function(){
                          location.reload(true)
                      },1000);
                  } else{
                      tostr_display("error",response);
                  }

                }
            });
        });
    </script>

    <script>

        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".visit_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();
            }else if(selected=="2"){

                $(".cancel_visa_status_cls").show();
                $(".visit_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();

            }else if(selected=="3"){

                $(".own_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }else{
                $(".own_visa_status_cls").hide();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }
        });
    </script>

    <script>
        $('tbody').on('click', '.visa_add_cls', function() {
        var selected_id = $(this).attr('id');

        $("#career_primary_id").val(selected_id);
        $("#checkin_modal").modal('show');


        });

    </script>



    <script>
        tail.DateTime("#submit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#submit_date_4pl",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),
        });
    </script>
    <script>
        $("#checkAll").click(function () {
            $('.checkboxs').not(this).prop('checked', this.checked);
        });

        $("#four_pl_checkAll").click(function () {
            $('.fourpl_checkbox').not(this).prop('checked', this.checked);
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
var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $name)<option value="{{ $name->names }}">{{ $names->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
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




    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                responsive: true,
            });
        });
    </script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>
@endsection
