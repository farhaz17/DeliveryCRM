@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <style>
        .add_btn{
            float:right;
            margin-top: 10px;
        }
    </style>

    <form action ="{{ route('agreement.store') }}" method="POST" >
        <div class="breadcrumb">
            <h1 class="mr-2">Agreement</h1>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">Passport Number</label>
                <select id="passport_number" name="passport_number" name="form_type" class="form-control form-control-rounded">
                    <option value=""  >Select option</option>
                    @foreach($passports as $pas)
                        <option value="{{ $pas->id }}"  >{{ $pas->passport_no  }}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-3 form-group mb-3 text-center" id="unique_div" style="display: none;">
                <label for="repair_category">Unique Id</label>
                <h4 id="unique_id"></h4>
            </div>

            <input type="hidden" name="agreement_no" value="{{  $agrement_no }}">
            <div class="col-md-3 form-group mb-3 text-center">
                <label for="repair_category">Agreement Id</label>
                <h4>{{  $agrement_no  }}</h4>
            </div>



        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row pb-2" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">



                        <h2 class="mr-2">Reference</h2>



                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-12 form-group mb-3"  >
                                <label for="repair_category">Select Reference</label>
                                <select id="ref_type" name="ref_type" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    <option value="0"  >Own Company Rider</option>
                                    <option value="1" >Out side</option>
                                </select>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12 form-group mb-3" id="own_company_div" style="display: none;"  >
                                <label for="firstName1">Enter Rider Name</label>
                                <select id="rider_name" name="rider_name" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    @foreach($riders as $rider)
                                        <option value="{{  $rider->user->id }}"  >{{  $rider->user->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>


                        <div class="row" id="outside_div" style="display: none;"  >

                            <div class="col-md-3 form-group mb-3"   >
                                <label for="refernce">Reference Name</label>
                                <input class="form-control" name="reference_name[]" type="text" placeholder="Enter Refernce Name" />
                            </div>

                            <div class="col-md-3 form-group mb-3"   >
                                <label for="contact_nubmer">Contact number</label>
                                <input class="form-control" name="contact_nubmer[]" type="text" placeholder="Enter Contact number" />
                            </div>

                            <div class="col-md-3 form-group mb-3"   >
                                <label for="contact_nubmer">what's App number</label>
                                <input class="form-control" name="whatsppnumber[]" type="text" placeholder="Enter whats app number" />
                            </div>

                            <div class="col-md-3 form-group mb-3"   >
                                <label for="contact_nubmer">Social media FB</label>
                                <input class="form-control" name="socialmedia[]" type="text" placeholder="Enter social media Link" />
                                <button class="btn btn-success pull-right text-right add_btn"  type="button" id="add_row">add</button>
                            </div>

                        </div>

                        <div class="separator-breadcrumb border-top"></div>
                        <h2 class="mr-2">Current Status</h2>
                        <div class="row">

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="repair_category">Select Current Status</label>
                                <select id="current_status" name="current_status" id="current_status" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>

                                    @foreach($person_statuses as $person_status)
                                        <option value="{{ $person_status->id  }}"  >{{ $person_status->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 transfer_exit"  style="display: none"  >
                                <label for="repair_category">Exit Date</label>
                                <input type="text" name="transer_exit_date" class="form-control form-control-rounded" id="transer_exit_date">

                            </div>

                            <div class="col-md-3 form-group mb-3 transfer_visit"  style="display: none"  >
                                <label for="visit_entry_date">Entry Date</label>
                                <input type="text" name="visit_entry_date" class="form-control form-control-rounded" id="visit_entry_date">

                            </div>

                            <div class="col-md-3 form-group mb-3 transfer_visit"  style="display: none"  >
                                <label for="visit_exit_date">Exit Date</label>
                                <input type="text" name="visit_exit_date" class="form-control form-control-rounded" id="visit_exit_date">

                            </div>

                            <div class="col-md-6 form-group mb-3 expected_date"  style="display: none"  >
                                <label for="repair_category">Expected Date</label>
                                <input type="text" name="expected_date" class="form-control form-control-rounded" id="expected_date">

                            </div>

                        </div>

                        <div class="separator-breadcrumb border-top"></div>
                        <h2 class="mr-2">Visa Requirements</h2>
                        <div class="row">

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="visa_requirement">Select Working Visa </label>
                                <select name="working_visa" id="working_visa" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id  }}"  >{{ $company->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="visa_applying">Select Visa Applying</label>
                                <select  name="visa_applying" id="visa_applying" class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id  }}"  >{{ $company->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="working_designation">Select Working Designation</label>
                                <select id="working_designation" name="working_designation"  class="form-control form-control-rounded">
                                    <option value=""  >Select option</option>
                                    @foreach($desingations as $des)
                                        <option value="{{ $des->id  }}"  >{{ $des->name  }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="visa_requirement">Select visa Designation</label>
                                <select id="visa_designation" name="visa_designation" id="visa_designation" class="form-control form-control-rounded">
                                    <option value=""  >select option</option>
                                    @foreach($desingations as $des)
                                        <option value="{{ $des->id  }}"  >{{ $des->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="separator-breadcrumb border-top"></div>
                        <h2 class="mr-2">Driving License</h2>
                        <div class="row">

                            <div class="col-md-3">

                                <div class="card-body">
                                    <div class="card-title">Driving License</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="0" name="driving_license"  class="driving_license"   /><span>Yes</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="1" name="driving_license"  class="driving_license"  /><span>no</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>

                            <div class="col-md-3 drive_license_source_cls" style="display: none">
                                <div class="card-body">
                                    <div class="card-title">&nbsp;</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="0" name="driving_license_source" class="driving_license_source"  /><span>Company</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="1" name="driving_license_source" class="driving_license_source" /><span>Own</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 drive_license_source_cls" style="display: none">
                                <div class="card-body">
                                    <div class="card-title">&nbsp;</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="0" name="driving_license_type" class="driving_license_type"  /><span>Car</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="1" name="driving_license_type" class="driving_license_type" /><span>Bike</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 driving_license_car_type_cls " style="display: none">
                                <div class="card-body">
                                    <div class="card-title">&nbsp;</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="0" name="driving_license_car_type" class="driving_license_car_type"  /><span>Manual</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="1" name="driving_license_car_type" class="driving_license_car_type" /><span>Automatic</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="separator-breadcrumb border-top"></div>
                        <h2 class="mr-2">Document Process</h2>

                        <div class="row">

                            <div class="col-md-6 form-group mb-3"  >
                                <label for="medical_type">Select Medical</label>
                                <select id="medical_type" name="medical_type" class="form-control form-control-rounded">
                                    <option value=""  >select option</option>
                                    <option value="1"  >Own</option>
                                    <option value="0"  >Company</option>

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 medial_company_div" style="display: none;"  >
                                <label for="medical_company">Select Medical Company</label>
                                <select id="medical_company" name="medical_company"  class="form-control form-control-rounded">
                                    <option value=""  >select option</option>

                                    @foreach($medical_categories as $cat)
                                        <option value="{{ $cat->id }}"  >{{ $cat->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12 ">

                                <div class="card-body">
                                    <div class="card-title">Emirates id</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="1" name="emirates_id"   /><span>Own</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="0" name="emirates_id"  /><span>Company</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card-body">
                                    <div class="card-title">Status Change</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="0" name="status_change" class="status_change"  /><span>Inside</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="1" name="status_change" class="status_change" /><span>In Out</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card-body">
                                    <div class="card-title">In Case of Fine</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="1" name="in_case_fine" class="in_case_fine"  /><span>Own</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="0" name="in_case_fine" class="in_case_fine" /><span>Company</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="card-body">
                                    <div class="card-title">RTA Permit</div>
                                    <label class="radio radio-outline-success">
                                        <input type="radio" value="1" name="rta_permit" class="rta_permit"  /><span>Own</span><span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" value="0" name="rta_permit" class="rta_permit" /><span>Company</span><span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
















                        <button class="btn btn-primary pull-right" type="submit">Save</button>

                    </div>
                </div>
            </div>
        </div>

    </form>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        tail.DateTime("#visit_entry_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#visit_exit_date",{
                dateStart: $('#visit_entry_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#transer_exit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#expected_date",{
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
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#passport_number').select2({
                placeholder: 'Select an option'
            });
            $('#rider_name').select2({
                placeholder: 'Select an option'
            });

            $('#working_visa').select2({
                placeholder: 'Select an option'
            });

            $('#visa_applying').select2({
                placeholder: 'Select an option'
            });

            $('#working_designation').select2({
                placeholder: 'Select an option'
            });

            $('#visa_designation').select2({
                placeholder: 'Select an option'
            });

            $('#medical_company').select2({
                placeholder: 'Select an option'
            });











            $(".select2-container").css('width','100%');

            $("#passport_number").change(function () {
                $("#unique_div").css('display','block');


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_unique_passport') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {

                        $("#unique_id").html(response);

                    }
                });

            });

            $("#ref_type").change(function(){

                var s_value = $(this).val();

                $(".select2-container").css('width','100%');

                if(s_value=="0"){
                    // $("#own_company_div").css('display','block');
                    $("#own_company_div").css('display','block');
                    $("#outside_div").css('display','none');

                }else{

                    $("#own_company_div").css('display','none');
                    $("#outside_div").css('display','flex');


                }

            });





            var count_row = 1;

            $("#add_row").click(function(){

                var html_apend = ' <div class="col-md-3 form-group mb-3 rowd-'+count_row+' "   >\n' +
                    '                                <label for="refernce">Reference Name</label>\n' +
                    '                                <input class="form-control" name="reference_name[]" type="text" placeholder="Enter Refernce Name" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-3 form-group mb-3 rowd-'+count_row+'"   >\n' +
                    '                                <label for="contact_nubmer">Contact number</label>\n' +
                    '                                <input class="form-control" name="contact_nubmer[]" type="text" placeholder="Enter Contact number" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-3 form-group mb-3 rowd-'+count_row+'"   >\n' +
                    '                                <label for="contact_nubmer">what\'s App number</label>\n' +
                    '                                <input class="form-control" name="whatsppnumber[]" type="text" placeholder="Enter whats app number" />\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-md-3 form-group mb-3 rowd-'+count_row+' "   >\n' +
                    '                                <label for="contact_nubmer">Social media FB</label>\n' +
                    '                                <input class="form-control" name="socialmedia[]" type="text" placeholder="Enter social media Link" />\n' +
                    '                                <button class="btn btn-danger pull-right text-right delete_btn add_btn rowd-'+count_row+' " id="'+count_row+'" type="button" >Delete</button>\n' +
                    '                            </div>  \n';

                $("#outside_div").append(html_apend);

                count_row = parseInt(count_row)+1;

            });



            $('#outside_div').on('click', '.delete_btn', function() {
                var ids = $(this).attr('id')

                $(".rowd-"+ids).remove();

            });





        });



        //current status things started


        $("#current_status").change(function(){

            var val_s = $(this).val();

            if(val_s=="1"){
                $(".transfer_exit").show();
                $(".transfer_visit").hide();
                $(".expected_date").hide();
            }else if(val_s=="2"){
                $(".transfer_exit").hide();
                $(".expected_date").hide();
                $(".transfer_visit").show();
            }else if(val_s=="6"){
                $(".expected_date").show();
                $(".transfer_exit").hide();
                $(".transfer_visit").hide();

            }else{

                $(".expected_date").hide();
                $(".transfer_exit").hide();
                $(".transfer_visit").hide();


            }

        });

        $(".driving_license").change(function(){
            var sel_v  = $(this).val();

            if(sel_v=="0"){
                $(".drive_license_source_cls").show();
            }else{
                $(".drive_license_source_cls").hide();
                $(".driving_license_car_type_cls").hide();
            }
        });


        $(".driving_license_source").change(function(){


        });

        $(".driving_license_type").change(function(){

            var select_var = $(this).val();

            if(select_var=="0"){
                $(".driving_license_car_type_cls").show();
            }else{
                $(".driving_license_car_type_cls").hide();
            }

        });

        $("#medical_type").change(function () {
            var select_v = $(this).val();

            if(select_v=="1"){

            }else{
                $(".medial_company_div").show();
            }

        })








        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
        //-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();


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
