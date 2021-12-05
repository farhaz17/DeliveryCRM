@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Emirates Id</a></li>
            <li>Renew Emirates Id Entry</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('emirates_id_card.update',1) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3 append_div " >
                                <label for="repair_category">Passport </label>
                                <input type="text" class="form-control" id="passport_id_edit" name="passport_id" readonly>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Id Number</label>
                                <input type="text" class="form-control" id="edit_id_number" name="edit_id_number" >
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Front Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="front_pic" id="front_pic" >
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Back Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="back_pic" id="back_id" >
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

    {{--    status update modal end--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Renew Emirates Id Entry</div>
                    <form method="post" action="{{ route('renew_store')  }}"  enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="row">

                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                <label class="radio-outline-success ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3 name_passport_cls"  ></h6>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" id="msg_div" style="display: none;" >
                                <div class="alert alert-card alert-danger" role="alert">
                                    Emirates ID has not been expired yet! Cannot be renewed!

                                </div>
                            </div>
                        </div>


                        <div class="row ">
                            <div class="col-md-6 form-group mb-3 append_div">
                                {{-- <label for="repair_category">Select Passport</label>
                                <select class="form-control  " name="passport_id" id="passport_id" required >
                                    <option value="">select an option</option>
                                    @foreach($all_passports as $pass)
                                        <option value="{{ $pass->id  }}">{{ $pass->passport_no  }}</option>
                                    @endforeach
                                </select> --}}
                                <label for="repair_category">Search Passport/PPUID/ZDS Code</label><br>
                                <div class="input-group ">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                    <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <div id="clear">
                                        X
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="user_passport_id" />

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Id Number</label>
                                <input type="text" class="form-control" required name="card_no"  maxlength="18" id="card_no">
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control"  autocomplete="off" name="expire_date" id="expire_date" required>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Emirates Id Front Pic</label>
                                <input type="file" class="form-control"  name="front_pic"  >
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Emirates Id Back Pic</label>
                                <input type="file" class="form-control"  name="back_pic"  >
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>








@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
     <script> var path = "{{ route('autocomplete_fetch_complete_passport') }}"; </script>
    <script> var passport_detail_path = "{{ route('eid_get_unique_passport') }}"; </script>

    <script src="{{ asset('js/custom_js/fetch_passport_emirates_id.js') }}"></script> --}}


    <script>

        // $(document).on('click', '.sugg-drop', function(){
        //     console.log("he");
        //     var token = $("input[name='_token']").val();
        //     var keyword  =   $(this).find('#drop-name').text();
        //
        //     $.ajax({
        //         url: passport_detail_path,
        //         method: 'POST',
        //         data:{passport_id:keyword,_token:token},
        //         success: function (response) {
        //
        //             var  array = response;
        //             $("input[name='user_passport_id']").val(array.id);
        //
        //             $("#name_div").show();
        //             $(".name_passport_cls").html(array.name);
        //
        //         }
        //     });
        // });
        </script>

    <script>
        $(".search_type_cls").change(function(){
            var select_v = $(this).val();
            $("#name_div").hide();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_render_cat_dropdown') }}",
                method: 'POST',
                data: {type: select_v, _token:token},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);

                    if(select_v=="1"){
                        $('.ppui_id').select2({
                            placeholder: 'Select an option'
                        });
                    }else if(select_v=="2"){
                        $('.zds_code').select2({
                            placeholder: 'Select an option'
                        });
                    }else{
                        $('.passport_id').select2({
                            placeholder: 'Select an option'
                        });
                    }

                }
            });

        });
    </script>

    <script>
        $(document).on('change', '#ppui_id', function(){
            var abs = $(this).val();

            console.log('adfdfdfdfdfdfdf');

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('eid_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");
                    if(ab[1]=='100'){
                        $("#msg_div").show();
                    }
                    else{
                        // $("#name_passport").html(ab[1]);
                    }


                }
            });
        });

        $(document).on('change', '#zds_code', function(){
            var abs = $(this).val();
            console.log('asdfasdf');

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('eid_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    if(ab[1]=='100'){
                        $("#msg_div").show();
                    }
                    else{
                        // $("#name_passport").html(ab[1]);
                    }
                }
            });
        });

        $(document).on('change', '#passport_id', function(){
            var abs = $(this).val();
            console.log("asdf");

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('eid_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    if(ab[1]=='100'){
                        $("#msg_div").show();
                    }
                    else{
                        // $("#name_passport").html(ab[1]);
                    }
                }
            });
        });

    </script>


    <script>
        // tail.DateTime("#issue_date",{
        //     dateFormat: "YYYY-mm-dd",
        //     timeFormat: false,
        //
        // }).on("change", function(){
        //     tail.DateTime("#expire_date",{
        //         dateStart: $('#issue_date').val(),
        //         dateFormat: "YYYY-mm-dd",
        //         timeFormat: false
        //
        //     }).reload();
        //
        // });

        tail.DateTime("#expire_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });



    </script>




    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Pending Tickets',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                scrollY: 300,
                responsive: true,
            });

            $('#passport_id').select2({
                placeholder: 'Select an option'
            });


            $("#passport_id").change(function () {


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_current_passport_status') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {
                        $("#status_id").val(response);
                    }
                });

            });

        });

    </script>



    <script>
        // $('#card_no').keydown(function(){
        //
        //     //allow  backspace, tab, ctrl+A, escape, carriage return
        //     if (event.keyCode == 8 || event.keyCode == 9
        //         || event.keyCode == 27 || event.keyCode == 13
        //         || (event.keyCode == 65 && event.ctrlKey === true) )
        //         return;
        //     if((event.keyCode < 48 || event.keyCode > 57))
        //         event.preventDefault();
        //
        //     var length = $(this).val().length;
        //
        //     if(length == 3 || length == 5 || length == 13)
        //         $(this).val($(this).val()+'-');
        //
        // });
    </script>


    <script>
        $(".edit_cls").click(function(){

            tail.DateTime("#edit_issue_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });

            tail.DateTime("#edit_expire_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });

            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);

            $(".select2-container").css('width','100%');

            var ab  = $("#edit_from").attr('action');

            var now = ab.split('emirates_id_card/');

            $("#edit_from").attr('action',now[0]+"emirates_id_card/"+ids);


            var edit_ab = "{{ route('emirates_id_card.edit',1) }}";

            var now_edit_ab = edit_ab.split("emirates_id_card/");

            var final_edit_url = now_edit_ab[0]+"emirates_id_card/"+ids+"/edit";

            console.log("edit ab="+final_edit_url);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: final_edit_url,
                method: 'GET',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var arr = $.parseJSON(response);
                    if(arr !== null){

                        $("#edit_id_number").val(arr['card_no']);
                        $("#passport_id_edit").val(arr['passport_number']);
                        $("#edit_issue_date").val(arr['expire_date']);


                    }

                }
            });

            $("#edit_modal").modal('show');
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <script>

        // $('#card_no').simpleMask({
        //     'mask': ['###-####-#######-#','#####-####']
        // });
        $(function() {
            $('#card_no').inputmask("***-****-*******-*",{
                placeholder:"X",
                clearMaskOnLostFocus: false
            });
        });


    </script>




    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>


@endsection
