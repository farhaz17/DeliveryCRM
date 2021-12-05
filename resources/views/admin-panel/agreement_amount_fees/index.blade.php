@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
        .radio {
            margin-bottom : 3px;
        }
        .card-title {
            font-size: 0.75rem;
            margin-bottom: 0.2rem;
        }
        .error{
            color: #ee2200 !important;
        }
        .back_ground_color{
            background-color: #3f51b545;
        }
        .background_color_2{
            background-color: #aaddcc87;
        }
    </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Agreement Amount</a></li>
            <li>Add Agreement Selection Amount</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_form" action="{{ route('agreement_amount_fees.update',1) }}">
                    {!! csrf_field() !!}

                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Amount</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {!! csrf_field() !!}

                                        <div class="row ">
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Employee Type</label>
                                                <h5 id="edit_employee_type">N/a</h5>
                                            </div>

                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Current Status</label>
                                                <h5 id="edit_current_status">N/A</h5>
                                            </div>

                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Company</label>
                                                <h5 id="edit_company">N/A</h5>
                                            </div>

                                        </div>

                                        <div class="row ">
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Option Label</label>
                                                <h5 id="edit_option_label">N/a</h5>
                                            </div>

                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Option Label Type</label>
                                                <h5 id="edit_option_value">N/A</h5>
                                            </div>

                                            <div class="col-md-4 form-group mb-3 child_div_label">
                                                <label for="repair_category">Option Label Child</label>
                                                <h5 id="edit_option_child">N/A</h5>
                                            </div>
                                        </div>



                                        <div class="row amount">

                                            <div class="col-md-6 ">
                                                <label for="repair_category">Amount</label>
                                                <input type="number" name="edit_amount" id="edit_amount" class="form-control" required >
                                            </div>



                                        </div>



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

    {{--    status update modal end--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body background_color_2">
                    <div class="card-title mb-3">Add Selection For Agreement Amount</div>
                    <form method="post"  id="amount_form" action="{{ route('agreement_amount_fees.store')  }}">
                        {!! csrf_field() !!}


                        <div class="row ">

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Employee Type</label>
                                <select class="form-control" required name="employee_type_id" id="employee_type_id" required >
                                    <option value="">select an option</option>
                                    @foreach($employee_types as $types)
                                        <option value="{{ $types->id }}">{{ $types->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Current Status</label>
                                <select class="form-control" required name="current_staus_id" id="current_staus_id" required >
                                    <option value="">select an option</option>
                                    @foreach($current_status as $curent_ab)

                                        @if($curent_ab->get_parent_name->name_alt=="Renew")
                                        @else
                                            <option value="{{ $curent_ab->id  }}"  >{{ $curent_ab->get_parent_name->name_alt  }}</option>
                                        @endif

                                    @endforeach
                                    <option value="0">For Limo Driver</option>

                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3 applying_company_div">
                                <label for="repair_category">Select Applying Visa Company</label>
                                <select class="form-control" required name="working_company" id="working_company" required >
                                    <option value="">select an option</option>
                                    @foreach($companies as $company)
                                            <option value="{{ $company->id  }}"  >{{ $company->name  }}</option>
                                    @endforeach

                                </select>
                            </div>



                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Option Please</label>
                                <select class="form-control" required name="option_label" id="option_label" required >
                                    <option value="">select an option</option>

                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3 labour_option_div" style="display: none;">
                                <label for="repair_category">Select Labour Option</label>
                                <select class="form-control"  name="labour_option_id" id="labour_option_id" required >
                                    <option value="">select an option</option>
                                    @foreach($labour_options as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 option_radio_div"  style="display:none;" >
                                <div class="card-body">
                                    <div class="card-title">Options</div>
                                    <label class="radio radio-outline-success" id="automatic_car_label">
                                        <span id="first_radio_html">Own</span>
                                        <input type="radio" data="Yes" value="1"  id="first_option"  name="option_value"  class="car_type"  checked  /> <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="manual_car_label">
                                        <input type="radio"  data="No" value="2" id="second_option"  name="option_value"  class="car_type"   /><span id="second_radio_html">Company</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 inside_radio_div"  style="display:none;" >
                                <div class="card-body">
                                    <div class="card-title">Inside E-visa Options</div>
                                    <label class="radio radio-outline-success" id="automatic_car_label">
                                        <span id="first_radio_html">Inside Status Change</span>
                                        <input type="radio" data="Yes" value="1" id="inside_evisa_first"  name="inside_evisa"  class="car_type"  checked  /> <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="manual_car_label">
                                        <input type="radio"  data="No" value="2" id="inside_evisa_second"  name="inside_evisa"  class="car_type"   /><span id="second_radio_html">OutSide status change</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="col-md-4 form-group mb-3 medical_company_div" style="display: none;">
                                <label for="repair_category">Select Medical Company</label>
                                <select class="form-control"  name="medical_company_id" id="medical_company_id" required >
                                    <option value="">select an option</option>
                                    @foreach($medical_categories as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>





                        </div>

                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Amount For this Selection</label>
                                <input type="number" name="amount" id="amount" class="form-control" required >
                            </div>

{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">Admin Amount For this Selection</label>--}}
{{--                                <input type="number" name="admin_amount" id="admin_amount" class="form-control" required >--}}
{{--                            </div>--}}

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

{{--    add limo option Amount start--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body back_ground_color">
                    <div class="card-title mb-3">Add Selection For Limo Driver Agreement Amount</div>
                    <form method="post"  id="amount_form_limo" action="{{ route('agreement_amount_fees.store')  }}">
                        {!! csrf_field() !!}


                        <div class="row ">

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Employee Type</label>
                                <select class="form-control" required name="employee_type_id" id="limo_employee_type_id" required >
                                    <option value="2" selected >Full Time Employee</option>

                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Current Status</label>
                                <select class="form-control" required name="current_staus_id" id="limo_current_status_id" required >
                                    <option value="">select an option</option>
                                    <option value="2">Visit</option>
                                    <option value="4" >Transfer to transfer</option>
                                    <option value="50" >Normal Standard Visa</option>
                                    <option value="51">Free Zone/Local Visa</option>

                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Working Company</label>
                                <select class="form-control" required name="working_company" id="limo_working_company" required >
                                    <option value="3">HEY VIP LUXURY CAR TRANSPORT LLC</option>
                                </select>
                            </div>



                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Option Please</label>
                                <select class="form-control" required name="option_label" id="limo_option_label" required >
                                    <option value="">select an option</option>

                                </select>
                            </div>



                            <div class="col-md-3 limo_option_radio_div"  style="display:none;" >
                                <div class="card-body">
                                    <div class="card-title">Options</div>
                                    <label class="radio radio-outline-success" id="automatic_car_label">
                                        <span id="first_radio_html">Own</span>
                                        <input type="radio" data="Yes" value="1"  id="limo_first_option"  name="option_value"  class="car_type"  checked  /> <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="">
                                        <input type="radio"  data="No" value="2" id="limo_second_option"  name="option_value"  class="car_type"   /><span id="second_radio_html">Company</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>


                        </div>

                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Amount For this Selection</label>
                                <input type="number" name="amount" id="amount" class="form-control" required >
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Admin Amount For this Selection</label>
                                <input type="number" name="admin_amount" id="admin_amount_limo" class="form-control" required >
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

{{--    add limo noption amount end here--}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable"  style="width:100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Employee Type</th>
                            <th scope="col">Company</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Option Label</th>
                            <th scope="col">Option Type</th>
                            <th scope="col">Option Child</th>
                            <th scope="col">Amount</th>

                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($agreement_amounts as $amount)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $amount->get_employee_type->name }}</td>
                                <td>{{ isset($amount->get_company_name->name) ? $amount->get_company_name->name : 'N/A'  }}</td>
                                <td>{{ $amount->get_current_status->get_parent_name->name_alt }}</td>
                                <td>{{ $amount->option_label }}</td>
                                <td>
                                    <?php $child_option = ""; ?>
                                @if($amount->option_label=="Medical" && $amount->option_value=="1")
                                    Own
                                @elseif($amount->option_label=="Medical" && $amount->option_value=="2")
                                    <?php $child_option = "Medical"; ?>
                                   Company
                                 @elseif($amount->option_label=="Labor Fees")
                                    {{ $amount->get_labor_option->name }}
                                 @elseif($amount->option_label=="Inside E-visa Print" && $amount->option_value=="1")
                                            <?php $child_option = "inside_evisa"; ?>
                                        Inside E-visa Print
                                 @elseif($amount->option_label=="Inside E-visa Print" && $amount->option_value=="2")
                                            <?php $child_option = "outside_evisa"; ?>
                                        Outside E-visa Print
                                  @elseif($amount->option_label=="Visa Pasting")
                                            <?php $child_option = "else"; ?>
                                     {{ ($amount->option_value=="1") ? 'Normal':'Urgent' }}
                                  @elseif($amount->option_label=="Other Fee" || $amount->option_label=="Admin Fee")
                                            <?php $child_option = "else"; ?>
                                    N/A
                                  @else
                                            <?php $child_option = "else"; ?>
                                    {{ ($amount->option_value=="1") ? 'Own' : 'Company' }}
                                 @endif
                                </td>

                                <td>
                                    @if($child_option=="Medical")
                                        {{  $amount->get_medical_company->name }}
                                    @elseif($child_option=="inside_evisa")
                                        {{  ($amount->child_option_id=="1") ? 'Inside Status Change' : 'OutSide status change' }}
                                    @else
                                        N/A
                                     @endif

                                </td>
                                <td>{{ $amount->amount }}</td>

                                <td>
                                    <a class="text-warning mr-2 edit_form_cls" id="{{ $amount->id }}" href="javascript:void(0)"><i class="nav-icon i-Edit font-weight-bold"></i></a>
                                </td>
                            </tr>
                          @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {

            // Setup - add a text input to each footer cell
            $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
            $('#datatable thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            });

            // 'use strict';


            var table = $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
                'orderCellsTop': true,
                // 'fixedHeader': true
                "scrollCollapse": true,
                // "bPaginate": false,
                // "bFilter": false,
                "sScrollY": "600",
                "sScrollX": "100%",
                "sScrollXInner": "50%",
                "bScrollCollapse": true

            });

            $('#current_staus_id').select2({
                placeholder: 'Select an option'
            });

            $('#employee_type_id').select2({
                placeholder: 'Select an option'
            });

            $('#option_label').select2({
                placeholder: 'Select an option'
            });

            $('#working_company').select2({
                placeholder: 'Select an option'
            });

            $('#limo_current_status_id').select2({
                placeholder: 'Select an option'
            });

            $('#limo_option_label').select2({
                placeholder: 'Select an option'
            });







        });



    </script>


    {{--    //edit jquery start from here--}}
    <script>


        $("#employee_type_id").change(function () {
            var ids  = $(this).val();

            $('#current_staus_id').children().remove();

            if(ids=="1"){
                $(".applying_company_div").hide();
                $("#working_company").prop('required',false);
            }else{
                $(".applying_company_div").show();
                $("#working_company").prop('required',true);
            }

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_employee_type') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    var options = "";
                    var  contact_html = "";
                    if(len > 0){
                        options  += '<option value="" selected disabled >please Select an option</option>';
                        for(var i=0; i<len; i++){
                            var id_t =  response['data'][i].id;
                            var name=  response['data'][i].name;
                            options  += '<option value="'+id_t+'" >'+name+'</option>';
                        }
                        $('#current_staus_id').append(options);
                    }
                }
            });

        });

        $("#option_label").change(function(){
            var select_ab = $(this).val();

            if(select_ab !== null){

                $("#first_option").prop('checked',true);
                if(select_ab=="Labor Fees"){
                    $(".option_radio_div").hide();
                    $(".labour_option_div").show();
                    $(".medical_company_div").hide();

                    $('#labour_option_id').select2({
                        placeholder: 'Select an option'
                    });

                    $('#labour_option_id').val('1').trigger('change');

                    $(".inside_radio_div").hide();
                }else if(select_ab=="Inside E-visa Print"){

                    $(".labour_option_div").hide();
                    $(".medical_company_div").hide();

                    $(".option_radio_div").show();

                    $(".option_radio_div").show();
                    $("#first_radio_html").html("Inside E-visa Print");
                    $("#second_radio_html").html("Outside E-visa Print");

                    $(".inside_radio_div").show();

                }else if(select_ab=="Visa Pasting"){

                    $(".labour_option_div").hide();
                    $(".inside_radio_div").hide();
                    $(".option_radio_div").show();
                    $("#first_radio_html").html("Normal");
                    $("#second_radio_html").html("Urgent");

                }else if(select_ab=="Other Fee"){
                    $(".option_radio_div").hide();
                }else if(select_ab=="Admin Fee"){
                    $(".option_radio_div").hide();
                }else{
                    $(".labour_option_div").hide();
                    $(".inside_radio_div").hide();
                    $(".option_radio_div").show();
                    $("#first_radio_html").html("Own");
                    $("#second_radio_html").html("Company");
                }



            }


        });


        $("input[type='radio'][name='option_value']").change(function(){

              var selected = $(this).val();

              var option_label = $("#option_label option:selected").val();

              var text = $("#first_radio_html").html();
              var text_2 = $("#second_radio_html").html();



              if(text_2=="Outside E-visa Print" && selected=="2"){
                  $(".inside_radio_div").hide();
              }else if(text=="Inside E-visa Print" && selected=="1" ){
                  $(".inside_radio_div").show();
                }else{
                  $(".inside_radio_div").hide();
              }

              if(option_label=="Medical" && selected=="2"){

                  $(".medical_company_div").show();

                  $('#medical_company_id').select2({
                      placeholder: 'Select an option'
                  });

                  $("#medical_company_id").val('1').trigger('change')
              }else{
                  $(".medical_company_div").hide();
              }


        });



        $(".edit_form_cls").click(function(){

            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);

            var action_ab = $("#edit_form").attr('action');

            var ab = action_ab.split("agreement_amount_fees/");

            var now_action = ab[0]+"agreement_amount_fees/"+ids;



            $("#edit_form").attr('action',now_action);
            console.log(ab);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_edit_detail') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    var arr = response;



                    if(arr !== null){
                        $("#edit_employee_type").html(arr['employee_type']);
                        $("#edit_current_status").html(arr['current_status']);
                        $("#edit_company").html(arr['company_name']);
                        $("#edit_amount").val(arr['amount']);
                        $("#edit_admin_amount").val(arr['admin_amount']);
                        $("#edit_option_label").html(arr['option_label']);
                        $("#edit_option_value").html(arr['option_label_value']);

                        if(arr['child_option']!==""){
                            $(".child_div_label").show();
                            $("#edit_option_child").html(arr['child_option']);;
                        }else{
                            $(".child_div_label").hide();
                        }
                    }
                }
            });

            $("#edit_modal").modal('show');
        });


        $("#current_staus_id").change(function(){
            var ab = $(this).val();

            $("#option_label").empty();

            var newOption1 = new Option('English Language Test', 'English Language Test', true, true);
            var newOption2 = new Option('RTA Permit Training', 'RTA Permit Training', true, true);
            var newOption3 = new Option('E Test', 'E Test', true, true);
            var newOption4 = new Option('RTA Medical', 'RTA Medical', true, true);
            var newOption5 = new Option('RTA Card Print', 'RTA Card Print', true, true);
            var newOption6 = new Option('CID Report', 'CID Report', true, true);
            // Append it to the select

            var otherOption1 = new Option('Labor Fees', 'Labor Fees', true, true);
            var otherOption2 = new Option('Inside E-visa Print', 'Inside E-visa Print', true, true);
            var otherOption3 = new Option('Medical', 'Medical', true, true);
            var otherOption4 = new Option('Emirates Id', 'Emirates Id', true, true);
            var otherOption5 = new Option('Visa Pasting', 'Visa Pasting', true, true);
            var otherOption6 = new Option('In Case Fine', 'In Case Fine', true, true);
            var otherOption7 = new Option('Other Fee', 'Other Fee', true, true);
            var otherOption8 = new Option('Admin Fee', 'Admin Fee', true, true);





            if(ab=="0"){

                $('#option_label').append(newOption1);
                $('#option_label').append(newOption2);
                $('#option_label').append(newOption3);
                $('#option_label').append(newOption4);
                $('#option_label').append(newOption5);
                $('#option_label').append(newOption6);
                $('#option_label').val(null).trigger('change');

            }else{
                $('#option_label').append(otherOption1);
                $('#option_label').append(otherOption2);
                $('#option_label').append(otherOption3);
                $('#option_label').append(otherOption4);
                $('#option_label').append(otherOption5);
                $('#option_label').append(otherOption6);
                $('#option_label').append(otherOption7);
                $('#option_label').append(otherOption8);
                $('#option_label').val(null).trigger('change');

              }
        });

        $("#limo_current_status_id").change(function(){

            var newOption1 = new Option('English Language Test', 'English Language Test', true, true);
            var newOption2 = new Option('RTA Permit Training', 'RTA Permit Training', true, true);
            var newOption3 = new Option('E Test', 'E Test', true, true);
            var newOption4 = new Option('RTA Medical', 'RTA Medical', true, true);
            var newOption5 = new Option('RTA Card Print', 'RTA Card Print', true, true);
            var newOption6 = new Option('CID Report', 'CID Report', true, true);

            $('#limo_option_label').append(newOption1);
            $('#limo_option_label').append(newOption2);
            $('#limo_option_label').append(newOption3);
            $('#limo_option_label').append(newOption4);
            $('#limo_option_label').append(newOption5);
            $('#limo_option_label').append(newOption6);
            $('#limo_option_label').val(null).trigger('change');

        });

        $("#limo_option_label").change(function(){

                var gamer = $(this).val();

                if(gamer!==""){

                    $(".limo_option_radio_div").show();
                }else{
                    $(".limo_option_radio_div").hide();
                }


        });










    </script>

    {{--    edit jquery end here--}}


    {{--    jquery validation work start--}}

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>

    <script>
        $(document).ready(function() {



            $("form#amount_form").validate({
                onkeyup: function(element) {
                    $(element).valid();
                },

                rules: {
                    employee_type_id: {
                        required:true,
                    },
                    company_id: {
                        required:true,
                    },
                    license_type: {
                        required:true,
                    }

                },
                messages: {
                    employee_type_id:{
                        required: "Employee type is required"
                    },
                    employee_type_id:{
                        required: "Company is required"
                    },
                    license_type:{
                        required: "License type is required"
                    }

                }
            });

            $("form#amount_form_limo").validate({
                onkeyup: function(element) {
                    $(element).valid();
                },

                rules: {
                    employee_type_id: {
                        required:true,
                    },
                    company_id: {
                        required:true,
                    },
                    license_type: {
                        required:true,
                    }

                },
                messages: {
                    employee_type_id:{
                        required: "Employee type is required"
                    },
                    employee_type_id:{
                        required: "Company is required"
                    },
                    license_type:{
                        required: "License type is required"
                    }

                }
            });









        });
    </script>

    {{--    jquery validation work end--}}



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
