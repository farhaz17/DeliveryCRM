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
            <li><a href="">Admin Fees</a></li>
            <li>Admin Fees</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_form" action="{{ route('admin_fee.update','1') }}">
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
                                                <h5 id="edit_company_name">N/A</h5>
                                            </div>

                                        </div>

                                        <div class="row amount">

                                            <div class="col-md-4 ">
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
                <div class="card-body">
                    <div class="card-title mb-3">Add Selection For Master</div>
                    <form method="post"  id="amount_form" action="{{ route('admin_fee.store')  }}">
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

                            <div class="col-md-4  form-group mb-3">
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

                            <div class="col-md-4  form-group mb-3">
                                <label for="repair_category">Select Applying Company</label>
                                <select class="form-control" required name="company_id" id="company_id" required >
                                    <option value="">select an option</option>
                                    @foreach($companies as $company)
                                            <option value="{{ $company->id  }}" >{{ $company->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>



                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Amount For this Selection</label>
                                <input type="number" name="amount" id="amount" class="form-control" required >
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
                            <th scope="col">Current Status</th>
                            <th scope="col">Company</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admin_fees as $amounts)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $amounts->get_employee_type->name }}</td>
                                <td>{{ $amounts->get_current_status->get_parent_name->name }}</td>
                                <td>{{ isset($amounts->get_company->name) ? $amounts->get_company->name : '' }}</td>
                                <td>{{ $amounts->amount }}</td>
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

            $('#current_staus_id').select2({
                placeholder: 'Select an option'
            });

            $('#employee_type_id').select2({
                placeholder: 'Select an option'
            });
            $('#company_id').select2({
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
            var ab = action_ab.split("admin_fee/");
            var now_action = ab[0]+"admin_fee/"+ids;
            $("#edit_form").attr('action',now_action);

            var url =  '{{ route('admin_fee') }}';
            var now_url = url+"/"+ids+"/edit";

            var token = $("input[name='_token']").val();
            $.ajax({
                url: now_url,
                method: 'get',
                data: {primary_id: ids },
                success: function(response) {
                    var arr = response;
                    if(arr !== null){
                        $("#edit_employee_type").html(arr['employee_name']);
                        $("#edit_current_status").html(arr['current_status_name']);
                        $("#edit_company_name").html(arr['company_name']);
                        $("#edit_amount").val(arr['amount']);

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
