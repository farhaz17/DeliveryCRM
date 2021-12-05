@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .hide_cls{
            display:none;
        }
    </style>

<style>
    .col-lg-12.sugg-drop {
        width: 550px;
        line-height: 12px;
        font-size: 12px;
        /*border: 1px solid #775dd0;*/
        /*padding-top: 15px;*/
        /*padding-bottom: 15px;*/

    }
    .col-lg-12.sugg-drop_checkout {
        width: 550px;
        line-height: 12px;
        font-size: 12px;
        /*border: 1px solid #775dd0;*/
        /*padding-top: 15px;*/
        /*padding-bottom: 15px;*/

    }

    span#full_name_drop {
        font-size: 10px;
    }
    ul.typeahead.dropdown-menu {
        height: 400px;
        overflow: hidden;
        width: 770px;

    }
    ul.typeahead.dropdown-menu:hover {
        height: 400px;
        overflow: scroll;

    }
    #clear {
        position: relative;
        float: right;
        height: 20px;
        width: 21px;
        top: 7px;
        right: 28px;
        border-radius: 20px;
        background: #f1f1f1;
        color: white;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
    }
    #clear:hover {
        background: #ccc;
    }
    .input-group-prepend {
        border-left: none;
    }
    input#keyword {
        border-right: none;
        background: #ffffff;
        border-left: none;
    }
    span#basic-addon2 {
        border-left: none;
    }
    hr {
        margin-top: 0rem;
        margin-bottom: 0rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        height: 0;
    }
    #drop-full_name {
        font-weight: 700;
    }
    #drop-bike {
        font-weight: 700;
        color: #FF0000;
    }
    span#drop-name {
        color: #010165;
    }
</style>

@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Passport</a></li>
            <li class="breadcrumb-item"><a href="#">PPUID Cancel</a></li>

        </ol>
    </nav>



   {{--------------------Passport Handler model-----------------}}
   <div class="modal fade bd-example-modal-lg" id="passport_handle_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 9999; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="passport_handle_form" action="{{ route('save_passport_handle_with_ajax') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Handler Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ppuid_primary_id" id="ppuid_primary_id" value="">
                    <div class="row">


                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category">Reason</label>
                            <select class="form-control" name="reason">
                                <option value="1">Reason 1</option>
                                <option value="2">Reason 2</option>
                                <option value="3">Reason 3</option>
                                <option value="4">Reason 4</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category">Status</label>
                            <select id="passport_status" class="form-control" name="status">
                                <option value="1">Received</option>
                                <option value="0">Not Received</option>
                                <option value="2">Security Deposit</option>
                            </select>
                        </div>

                        <div id="submitDate_div" class="col-md-4 form-group mb-3 hide_cls" >
                            <label>Submitting Date</label>
                            <input class="form-control form-control" autocomplete="off" name="submit_date" type="text" id="submit_date" placeholder="Submiting Date">
                        </div>

                        <div id="security_div" class="col-md-4 form-group mb-3 hide_cls" >
                            <label>Security Deposit</label>
                            <input class="form-control form-control" name="security_deposit" type="number" id="security_deposit" placeholder="Security Deposit">
                        </div>

                        <div class="col-md-4 mb-3 hide_cls security_deposit_later_now_div" >
                            <label for="repair_category">Select Option</label>
                            <br>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-success">
                                    <input type="radio"  name="later_now" value="1" checked /><span>Now</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-success">
                                    <input type="radio"   name="later_now"  value="2"  /><span>Later</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category">Remark</label>
                            <textarea class="form-control form-control" name="remark" rows="4" type="text" placeholder="Remark (optional)"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
{{--                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
                    <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--------------------Passport  Handler model ends here-----------------}}


        <div class="card col-lg-8 offset-lg-2 mb-2">
            <div class="card-body">
                <div class="card-title mb-3">PPUID  Cancel</div>
                <div class="row">


                    <div class="col-md-12 form-group mb-3 "  style="float: left;"  >
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>

                            <input class="form-control typeahead" id="keyword" autocomplete="off" type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                            <div id="clear">
                                X
                            </div>

                        </div>
                        <input type="text" id="app_id" style="display: none" >
                        <button class="btn btn-info btn-icon m-1"  style="display: none" id="apply_filter" data="datatable"  type="button"></button>

                    </div>
                </div>
            </div>
            <div  style="display: none" id="all-row">


            </div>
        </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
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
                    html += '<div class="col-lg-12 sugg-drop">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
                    html += '<div class="col-lg-12 sugg-drop" >';
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
        $("#clear").click(function(){
            $("#keyword").val('');
        });
    </script>
    <script>
        $(document).on('click', '.sugg-drop', function(){
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();



            $.ajax({
                url: "{{ route('ppuid_show') }}",
                method: 'POST',
                dataType: 'json',
                data:{keyword:keyword,_token:token},
                success: function (response) {
                    $('#div_submit').remove();
                    $('#all-row').empty();
                    $('#div_submit').empty();
                    $('#all-row').append(response.html);
                    $('#all-row').show();

                }
            });
        });

        $(document).on('change', '#main_category', function(){
            var ids = $(this).val();

            $.ajax({
                url: "{{ route('ajax_append_subcategory_cancel') }}",
                method: 'GET',
                dataType: 'json',
                data:{id:ids},
                success: function (response) {

                    $('.subcategory_tab').html('');
                    $('.subcategory_tab').append(response.html);


                }
            });

        });


    </script>

    <script>
        $(document).ready(function(){
            $(document).on('click', '#passport_cancel', function(){


                var token = $("input[name='_token']").val();
                var passport_id = $("#passport_id").val();
                var keyword = $("#passport_number").val();
                var main_category  = $("#main_category option:selected").val();
                var sub_category  = $("#sub_category option:selected").val();

                    var cancel_remarks = $("#cancel_remarks").val();



                if (keyword==''){
                    toastr.error("Please select  user again");
                } else {

                        $.ajax({
                            url: "{{ route('ppuid_cancel_status') }}",
                            method: 'POST',
                            data: {
                                passport_id: passport_id,
                                keyword: keyword,
                                cancel_remarks: cancel_remarks,
                                main_category: main_category,
                                sub_category: sub_category,
                                _token: token
                            },
                            success: function (response) {

                            if($.trim(response)=="success"){
                                $("#exampleModal").modal('hide');
                                tostr_display("success","PPUID Updated Successfully");
                                    window.setTimeout(function(){
                                        location.reload(true)
                                    },1000);
                            }else{

                                tostr_display("error",response);
                            }

                            }
                        });

                }
            });
        });
    </script>

<script>

    // activation form submit
    $(document).on('submit', '#ppuid_activate_form', function(e){
        // $("#").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#ppuid_activate_form").attr('action');


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
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Status has been changed successfully");

                        // $("#exampleModal-2").modal('')
                        $('#no_btn_of_active').click();

                         var passport_id_activate = $("#passport_id_activate").val();
                        $("#passport_handle_modal").modal('show');
                        $("#ppuid_primary_id").val(passport_id_activate);


                        // window.setTimeout(function(){
                        //     location.reload(true)
                        // },1000);

                    }else{
                        tostr_display("error",response);
                    }

                }
            });
        });

        </script>

        {{-- passport handler start --}}

        <script>

        $('body').on('change', '#passport_status', function() {

                var gamer = $(this).val();

                if(gamer=="0"){
                    $("#submitDate_div").show();
                    $("#security_div").hide();
                    $("#submit_date").prop("required",true);
                    $("#security_deposit").prop("required",false);
                    $(".security_deposit_later_now_div").hide();

                }else if(gamer=="2"){

                    $("#submitDate_div").hide();
                    $("#security_div").show();
                    $(".security_deposit_later_now_div").show();
                    $("#security_deposit").prop("required",true);
                    $("#submit_date").prop("required",false);

                }else{
                    $("#submitDate_div").hide();
                    $("#security_div").hide();
                    $(".security_deposit_later_now_div").hide();
                    $("#submit_date").prop("required",false);
                    $("#security_deposit").prop("required",false);
                }

            });
         </script>

         <script>
               $("#passport_handle_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            // $('#phone').keydown();

            var url = $("#passport_handle_form").attr('action');


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
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Passport handler Submitted ");

                        $("#passport_handle_modal").modal("show");

                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });
   </script>


        {{-- passport handler end --}}




    <script>
        $(document).ready(function(){
            $(document).on('click', '#btn-activate', function(){

                $("#submit_from_button").click();

                // var token = $("input[name='_token']").val();
                // var passport_id_activate = $("#passport_id_activate").val();
                // var passport_number_activate = $("#passport_number_activate").val();
                // var active_remarks = $("#active_remarks").val();


                // if (active_remarks==''){
                //     toastr.error("Please enter activate remarks");
                // } else {


                //     $.ajax({
                //         url: "{{ route('ppuid_activate') }}",
                //         method: 'POST',
                //         data: {
                //             _token: token,
                //             passport_id_activate: passport_id_activate,
                //             passport_number_activate: passport_number_activate,
                //             active_remarks: active_remarks
                //         },
                //         success: function (response) {
                //             if(response=="success"){
                //                 $("#exampleModal-2").modal('hide');
                //                 tostr_display("success","PPUID Activated Successfully!!");
                //                     window.setTimeout(function(){
                //                         location.reload(true)
                //                     },1000);
                //             }else{

                //                 tostr_display("error",response);
                //             }

                //         }
                //     });
                // }


            });



            $(document).on('change', '#work_as', function(){
                 var ids = $(this).val();

                 if(ids=="1"){

                    $.ajax({
                        url: "{{ route('cancel_activate_agreed_amount') }}",
                        method: 'get',
                        dataType: 'json',
                        data:{id:ids},
                        success: function (response) {


                            $('#agreed_amount_div').html('');
                            $('#agreed_amount_div').append(response.html);


                        }
                    });

               }else{
                $('#agreed_amount_div').html('');
               }


            });

        });
    </script>


{{-- agreed amount work start --}}



<script>

    var medical_selected = 0;
    var evisa_selected = 0;

    $('.step_amount_row').on('change', '.select_amount_step_cls', function() {



        var selecteed_val = $(this).val();

        if(selecteed_val=="11" || selecteed_val=="12" || selecteed_val=="13" || selecteed_val=="14"){
            medical_selected = "1";
        }

        if(selecteed_val=="6" || selecteed_val=="7"){
            evisa_selected = "1";
        }


    });
</script>




<script>
    //deleta and adding step amount

    var count_discount_ab = 50001

    $('body').on('click', '#btn_add_discount_row', function() {
    // $("#btn_add_discount_row").click(function () {
        count_discount_ab = parseInt(count_discount_ab)+1
        var id_now =  count_discount_ab;

        var html =  add_new_discount_row(id_now);
        $(".append_discount_row").append(html);

        $("#discount_amount-"+id_now).prop('required',true);
        $("#discount_name-"+id_now).prop('required',true);

    });

    $('body').on('click', '.remove_discount_row', function() {

        var ids = $(this).attr('id');
        var now = ids.split("-");

        $(".discunt_div-"+now[1]).remove();
        var remain_val = calculate_others();
        $("#final_amount").val(remain_val);

        $("#final_amount_label_cls").html(now_remain);

    });

    var count_doc_ab = 40001


    $('body').on('click', '#btn_add_doc_row', function() {
    // $("#btn_add_doc_row").click(function () {
        count_doc_ab = parseInt(count_doc_ab)+1
        var id_now =  count_doc_ab;

        var html =  add_new_document_row(id_now);
        $(".doc_row_append").append(html);

        $("#doc_name-"+id_now).prop('required',true);
        $("#doc_image-"+id_now).prop('required',true);

    });

    $('body').on('click', '.remove_discount_row', function() {

        var ids = $(this).attr('id');
        var now = ids.split("-");

        $(".doc_div-"+now[1]).remove();

        // var value_current = $("#image_array").val();
        // var now_value = value_current+","+id;
        // $("#image_array").val(now_value);


    });



    function add_new_discount_row(id){
        var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $single_name)<option value="{{ $single_name->names }}">{{ $single_name->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

        return html;
    }

    function add_new_document_row(id){
        var html = '<div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Document Name</label><select class="form-control" name="physical_doc_name_'+id+'"><option value="" selected disabled>please select option</option> @foreach($career_doc_name as  $reason)<option value="{{$reason->id}}">{{ $reason->name }}</option>@endforeach</select></div><div class="col-md-5 doc_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Select Image</label><input type="file" name="physical_doc_image_'+id+'[]" id="doc_image-'+id+'"  multiple class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 doc_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_doc-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

        var value_current = $("#image_array").val();
        var now_value = value_current+","+id;
        $("#image_array").val(now_value);
        return html;
    }
</script>


<script>
    function append_form_amount_step(id){
        html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls" id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps) @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" ) <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>    @elseif($steps->id=="6" || $steps->id=="7") <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option> @else <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option> @endif  @endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
        return html;
    }
    var count_amount_step = 0;
    $('body').on('click', '.add_step_form_btn', function() {
    // $(".add_step_form_btn").click(function(){

        count_amount_step = parseInt(count_amount_step)+parseInt(count_amount_step)+1;

        $(".amount_step_row_cls").append(append_form_amount_step(count_amount_step));

        $('#select_amount_step-'+count_amount_step).select2({
            placeholder: 'Select an option'
        });

        var id_of_dropdown  = 'select_amount_step-'+count_amount_step;
        if(medical_selected=="1"){
            $("#"+id_of_dropdown+" option[value='11']").remove();
            $("#"+id_of_dropdown+" option[value='12']").remove();
            $("#"+id_of_dropdown+" option[value='13']").remove();
            $("#"+id_of_dropdown+" option[value='14']").remove();
        }

        if(evisa_selected=="1"){
            $("#"+id_of_dropdown+" option[value='6']").remove();
            $("#"+id_of_dropdown+" option[value='7']").remove();
        }



    });

    $('body').on('click', '.step_amount_delete_cls', function() {

        var ids = $(this).attr('id');

        $("."+ids).remove();
        var remain_val = calculate_others();
        $("#final_amount").val(remain_val);

        $("#final_amount_label_cls").html(now_remain);

    });

</script>

<script>

$('body').on('click', '#payroll_deduct', function() {

    // $("#payroll_deduct").click(function(){

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

{{-- agreed amount work end here --}}



<script>
    function tostr_display(type,message){
        switch(type){
            case 'info':
                toastr.info(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'success':
                toastr.success(message);
                break;
            case 'error':
                toastr.error(message);
                break;
        }

    }
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
