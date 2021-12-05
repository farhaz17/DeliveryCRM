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
        .hide_cls{
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Agreed</a></li>
            <li>Add Agreed Amount</li>
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
                    <div class="card-title mb-3">Add Agreed Amount</div>
                    <form method="post" action="{{ route('agreed_amount.store')  }}"  enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                <label class="radio-outline-success text-primary font-weight-bold ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3 "></h6>
                            </div>


                            <input type="hidden" name="passport_id_selected" id="passport_id_selected">
                        </div>

                        <div class="row">
                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                <label class="radio-outline-success ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
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

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Agreed Amount</label>
                                <input type="number" required class="form-control amount_cls" required name="agreed_amount"   id="agreed_amount">
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Advance Amount</label>
                                <input type="number" required class="form-control amount_cls" required name="advance_amount"   id="advance_amount">
                            </div>

                        </div>


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

                                <div class="row append_discount_row">
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-md-6">
                                    <label for="repair_category">Final Amount</label>
                                    <input type="number" required class="form-control" required name="final_amount"   readonly id="final_amount">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="repair_category">Select Agreement</label>
                                        <input type="file"  name="attchemnt" class="form-control" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 ">
                                    <label class="checkbox checkbox-outline-primary mt-2" >
                                        <input type="checkbox" value="1" name="payroll_deduct" id="payroll_deduct"><span>Is Payroll Deduct</span><span class="checkmark"></span>
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


                                <div class="row step_amount_row step_amount_cls_row" >
                                    <div class="col-md-6 form-group">
                                        <label for="visa_requirement">Select step Amount </label>
                                        <select name="select_amount_step[]" id="select_amount_step"  required class="form-control form-control-rounded select_amount_step_cls">
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

                                    <div class="col-md-6 form-group "  >
                                        <label for="visa_requirement">Amount</label>
                                        <input type="number" name="step_amount[]"  id="step_amount_first" required class="form-control step_amount_cls ">
                                        <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                            <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                    </div>

                                </div>
                                <div class="row amount_step_row_cls"></div>
                            </div>


                        </div>




                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-left" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Passport Number</th>
                                <th scope="col">Id Number</th>
                                <th scope="col">Expire Date</th>
                                <th scope="col">Emirates Front Pic</th>
                                <th scope="col">Emirates Back Pic</th>
                                <th scope="col">Enter By</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
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
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
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
        // onclick suggestion list
        $(document).on('click', '.sugg-drop', function(){
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();

            $.ajax({
                url: "{{ route('get_passport_name_detail') }}",
                method: 'POST',
                data:{passport_id:keyword,_token:token},
                success: function (response) {

                    var  array = JSON.parse(response);
                    $("#name_div").show();
                    $("#name_passport").html(array.name);
                    $("#passport_id_selected").val(array.id);

                }
            });
        });
    </script>


    <script>

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

            // var now_remain = parseFloat(final_amount)-parseFloat(sum);

            $("#final_amount_label_cls").html(now_remain);
        });

        function add_new_discount_row(id){
            var html = '<div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Name</label><select id="discount_name-'+id+'" name="discount_name[]" class="form-control discount_names" ><option value="" selected disabled >please select option</option>@foreach($discount_names as $names)<option value="{{ $names->names }}">{{ $names->names }}</option>@endforeach</select></div><div class="col-md-5 discunt_div-'+id+'" style="margin-bottom:05px;"><label for="visit_entry_date" >Discount Amount</label><input type="number" name="discount_amount[]" id="discount_amount-'+id+'"  class="form-control form-control-rounded discount_amount_cls amount_cls" ></div><div class="col-md-2 discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';

            return html;
        }
    </script>


    <script>
        function append_form_amount_step(id){
            html = '<div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Select step Amount </label><select name="select_amount_step[]" required="required"  class="form-control  form-control-rounded select_amount_step_cls " id="select_amount_step-'+id+'"  ><option value=""  >Select option</option>@foreach($master_steps as $steps) @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" ) <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>    @elseif($steps->id=="6" || $steps->id=="7") <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option> @else <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option> @endif  @endforeach</select></div><div class="col-md-6 form-group step_amount-'+id+' "  ><label for="visa_requirement">Amount</label><input type="number"  id="amount_step_ab='+id+'" required="required"  name="step_amount[]" class="form-control  step_amount_cls "><button  class="btn   btn-danger pull-right  add_btn_form  step_amount_delete_cls "  id="step_amount-'+id+'"  style="margin-bottom:10px;"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div>';
            return html;
        }
        var count_amount_step = 0;
        $(".add_step_form_btn").click(function(){

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

        $('.amount_step_row_cls').on('click', '.step_amount_delete_cls', function() {

            var ids = $(this).attr('id');

            $("."+ids).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);
            $("#final_amount_label_cls").html(now_remain);
        });

    </script>

    <script>
        $("#payroll_deduct").click(function(){

            if($("#payroll_deduct").prop('checked') == true){
                $(".step_amount_row").hide();
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

        var medical_selected = 0;
        var evisa_selected = 0;

        $('body').on('change', '.select_amount_step_cls', function() {



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
