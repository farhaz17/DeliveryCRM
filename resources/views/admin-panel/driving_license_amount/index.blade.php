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
        </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Driving License Amount</a></li>
            <li>Add Drinvg License Amount</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_form" action="{{ route('driving_license_amount.update','1') }}">
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
                                                <label for="repair_category">Company Name</label>
                                                <h5 id="edit_company_name">N/A</h5>
                                            </div>

                                            <div class="col-md-4 form-group mb-3">
                                                <label for="repair_category">Current Status</label>
                                                <h5 id="edit_current_status">N/A</h5>
                                            </div>

                                        </div>

                                        <div class="row amount">

                                            <div class="col-md-4">
                                                <div class="card-title">License Type</div>
                                                <label class="radio radio-outline-success" id="bike_label">
                                                    <span id="edit_license_type">Bike</span>
                                                    <input type="radio" data="Yes" value="1"   name="edit_license_type"  id="edit_license" class="licens_type"  checked  /> <span class="checkmark"></span>
                                                </label>
                                            </div>

                                            <div class="col-md-4 edit_car_type_div" style="display: none">
                                                <div class="card-title">Car Tye</div>
                                                <label class="radio radio-outline-success" id="bike_label">
                                                    <span id="edit_car_type">Bike</span>
                                                    <input type="radio" data="Yes" value="1"   name="edit_cars_type"  id="edit_car_type" class="licens_type"  checked  /> <span class="checkmark"></span>
                                                </label>
                                            </div>

                                            <div class="col-md-4 ">
                                                    <label for="repair_category">Amount</label>
                                                    <input type="number" name="edit_amount" id="edit_amount" class="form-control" required >
                                            </div>

                                            <div class="col-md-4 ">
                                                <label for="repair_category">Admin Amount</label>
                                                <input type="number" name="admin_edit_amount" id="admin_edit_amount" class="form-control" required >
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
                <div class="card-body">
                    <div class="card-title mb-3">Add Selection For Master</div>
                    <form method="post"  id="amount_form" action="{{ route('driving_license_amount.store')  }}">
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
                                <label for="repair_category">Select Company</label>
                                <select class="form-control" required name="company_id" id="company_id" required >
                                    <option value="">select an option</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Current Status</label>
                                <select class="form-control" required name="current_status" id="current_status" required >
                                    <option value="">select an option</option>
                                    @foreach($current_status as $curent_ab)

                                        @if($curent_ab->get_parent_name->name_alt=="Renew")
                                        @else
                                            <option value="{{ $curent_ab->id  }}"  >{{ $curent_ab->get_parent_name->name_alt  }}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <div class="row ">
                            <div class="col-md-3" >
                                <div class="card-body">
                                    <div class="card-title">License Type</div>
                                    <label class="radio radio-outline-success" id="bike_label">
                                        <span>Bike</span>
                                        <input type="radio" data="Yes" value="1"   name="license_type"  id="bike" class="licens_type"  required  /> <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="car_label" >
                                        <input type="radio"  data="No" value="2"  name="license_type"  id="car" class="licens_type"   /><span>Car</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="both_label" >
                                        <input type="radio"  data="No" value="3"  name="license_type"  id="both" class="licens_type"   /><span>Both</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 car_type_div"  style="display:none;" >
                                <div class="card-body">
                                    <div class="card-title">Car Type</div>
                                    <label class="radio radio-outline-success" id="automatic_car_label">
                                        <span>Automatic Car</span>
                                        <input type="radio" data="Yes" value="1" id="automatic_car"  name="car_type"  class="car_type"  checked  /> <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary" id="manual_car_label">
                                        <input type="radio"  data="No" value="2" id="manual_car"  name="car_type"  class="car_type"   /><span>Manual Car</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                        <input type="hidden" name="option_label" id="option_label">


                        </div>

                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Amount For this Selection</label>
                                <input type="number" name="amount" id="amount" class="form-control" required >
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Admin Amount For this Selection</label>
                                <input type="number" name="admin_amount" id="admin_amount" class="form-control" required >
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


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Employee Type</th>
                            <th scope="col">Company</th>
                            <th scope="col">License Type</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Car Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Admin Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($license_amounts as $amounts)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $amounts->get_employee_type->name }}</td>
                                    <td>{{ $amounts->get_company->name }}</td>
                                    <td>{{ $amounts->option_label }}</td>
                                    <td>{{ isset($amounts->get_current_status->get_parent_name->name_alt) ? $amounts->get_current_status->get_parent_name->name_alt : 'N/A'  }}</td>
                                    <td>
                                      @if(isset($amounts->option_value))
                                          {{ ($amounts->option_value=="1") ? 'Automatic Car' : 'Manual Car'   }}
                                        @else
                                         N/A
                                        @endif
                                    </td>
                                    <td>{{ $amounts->amount }}</td>
                                    <td>{{ $amounts->admin_amount }}</td>
                                    <td>
                                        <a class="text-warning mr-2 edit_form_cls" id="{{ $amounts->id  }}" href="javascript:void(0)"><i class="nav-icon i-Edit font-weight-bold"></i></a>
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
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

            $('#company_id').select2({
                placeholder: 'Select an option'
            });

            $('#current_status').select2({
                placeholder: 'Select an option'
            });

            $('#employee_type_id').select2({
                placeholder: 'Select an option'
            });

        });



    </script>


    {{--    //edit jquery start from here--}}
    <script>



        $(".edit_form_cls").click(function(){

            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);

             var action_ab = $("#edit_form").attr('action');

             var ab = action_ab.split("driving_license_amount/");

             var now_action = ab[0]+"driving_license_amount/"+ids;

             $("#edit_form").attr('action',now_action);
            console.log(ab);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_driving_license_selection_amount') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    var arr = response;

                    if(arr !== null){
                        $("#edit_employee_type").html(arr['employee']);
                        $("#edit_company_name").html(arr['company_name']);
                        $("#edit_license_type").html(arr['option_label']);
                        $("#edit_current_status").html(arr['current_status']);
                        $("#edit_amount").val(arr['amount']);
                        $("#admin_edit_amount").val(arr['admin_amount']);


                        if(arr['car_type']!==""){
                            $(".edit_car_type_div").show();
                            $("#edit_car_type").html(arr['car_type']);;
                        }else{
                            $(".edit_car_type_div").hide();
                        }


                    }

                }
            });




            $("#edit_modal").modal('show');
        });


        $(".licens_type").change(function(){
            var ab = $(this).val();

            if(ab=="2"){
                $(".car_type_div").show();
                $("#option_label").val("Car");
            }else if(ab=="1"){
                $("#option_label").val("Bike");
                $(".car_type_div").hide();
            }else{
                $("#option_label").val("Both");
                $(".car_type_div").show();
            }

        });

    </script>

    {{--    edit jquery end here--}}


    {{--    jquery validation work start--}}

    <script sr="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script sr="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>

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

            $('.step_amount_cls').each(function() {
                $(this).rules('add', {
                    required: true,
                    number: true,
                    messages: {
                        required:  "your custom required message"
                    }
                });
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
