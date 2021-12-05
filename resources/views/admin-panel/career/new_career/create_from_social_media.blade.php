
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/international_js/build/css/intlTelInput.css')}}">
    <style>
        button.btn.btn-primary.save-btn {
            margin-top: 24px;
        }
        .license_heading{
            margin-top: -43px;
        }
        .hide_cls{
            display: none;
        }
        .iti { width: 100%; }


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
        .view_cls i{
            font-size: 15px !important;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Career For Social Media</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Candidate Detail</div>

                    <form method="post" action="{{ route('save_career_from_social_media') }}" enctype="multipart/form-data" id="new_form_save">
                        {!! csrf_field() !!}


                        <div class="row">

                            <div class="col-md-4 form-group mb-3">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Name <b>(required)</b></label>
                                        <input class="form-control form-control-sm" id="name" name="name" value="" type="text" required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Email</label>
                                        <input class="form-control form-control-sm" id="email" name="email" value="" type="text"   />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Phone Number <b>(required)</b></label>
                                        <input class="form-control form-control-sm" id="phone" name="phone" value="" type="phone"  required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Whats App <b>(required)</b> </label>
                                        <input class="form-control form-control-sm" id="whatsapp" name="whatsapp" value="" type="phone" required  />
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Select Nationality <b>(optional)</b></label>
                                        <select class="form-control select" id="country_id" name="country_id" >
                                            <option value="" >select an option</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" >{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 form-group mb-3 hide_cls">
                                        <label for="repair_category">Facebook</label>
                                        <input class="form-control form-control-rounded" id="facebook" name="facebook" value="" type="text"  />
                                    </div>


{{--                                    <div class="col-md-6 mb-3">--}}
{{--                                        <label for="repair_category">Applying For</label>--}}
{{--                                        <br>--}}
{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-success">--}}
{{--                                                <input type="radio"  name="apply_for" value="1" ><span>Bike</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-success">--}}
{{--                                                <input type="radio"   name="apply_for" value="2"  ><span>Car</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check-inline">--}}
{{--                                            <label class="radio radio-outline-success">--}}
{{--                                                <input type="radio" type="radio"   name="apply_for" value="3"  ><span>Both</span><span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}



                                </div>






                            </div>



                            <div class="col-md-4 form-group mb-3" >
                                <div class="card-title mb-3  license_heading">License Detail</div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">License Status <b>(required)</b></label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  class="license_status_cls"  value="1" name="license_status" ><span>Yes</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_status_cls"  value="2" name="license_status"><span>No</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 hide_cls  driving_licence_div_cls" >

                                        <label for="repair_category">Which License you Have.?</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"   name="license_type" class="license_status_cls"  value="1" ><span>Bike</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="license_type" value="2" class="license_status_cls"  ><span>Car</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  name="license_type" value="3"  ><span>Both</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                    </div>
                                </div>




                                <div class="card-title mb-3">Visa Detail</div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Visa Status <b>(required)</b></label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio"  class="license_type_cls"  value="1" name="visa_status" ><span>Visit Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls"  value="2" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls"  value="3" name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                        <div class="visit_visa_status_cls hide_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls"  value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded" id="visit_exit_date" name="visit_exit_date" value="" type="text"   />

                                        </div>

                                        <div class="cancel_visa_status_cls hide_cls " >
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls"  value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls"  value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>



                                        <div class="own_visa_status_cls hide_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls"  value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">PlatForm</label>

                                        <select class="form-control select multi-select" id="platform_id" name="platform_id[]" multiple="multiple">

                                            @foreach($platform as $plat)

                                                <option value="{{$plat->id}}">{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Applied Cities <b>(required)</b></label>
                                        <select class="form-control select multi-select" id="cities" name="cities[]" multiple="multiple" required>

                                            @foreach($cities as $plat)
                                                <option value="{{$plat->id}}" >{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">From where you heard about us.?  <b>(required)</b></label>
                                        <select class="form-control select" id="promotion_type" name="promotion_type" required>
                                            <option value="" >select an option</option>
                                            @foreach($socials as $soc)
                                                <option value="{{$soc->id}}" >{{$soc->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3 hide_cls" id="other_source_name_div" >
                                        <label for="repair_category">Enter Other Source Name</label>
                                        <input type="text" name="other_source_name" id="other_source_name" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group mb-3 hide_cls" id="social_id_name_div" >
                                        <label for="repair_category">Social Media ID Name <b>(Optional)</b></label>
                                        <input type="text" name="social_id_name" id="social_id_name" class="form-control">
                                    </div>



{{--                                    <div class="col-md-6 form-group mb-3 "  >--}}
{{--                                        <label for="repair_category">Source Type <b>(required)</b></label>--}}
{{--                                        <select class="form-control select" id="source_type" name="source_type" required>--}}
{{--                                            <option value=""  selected disabled>select an option</option>--}}
{{--                                            <option value="2">On Call</option>--}}
{{--                                            <option value="3">Walkin Candidate</option>--}}
{{--                                            <option value="5">Social Media</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <input type="hidden" name="source_type" value="5">


                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                        <table class="table table-sm table-hover text-10 data_table_cls" style="margin-top: -20px;">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($career as $row)
                                                <tr>
                                                    <td>{{$row->name}}</td>
                                                    <td>{{$row->email}}</td>
                                                    <td>{{$row->phone}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary save-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overlay"></div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>



    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



    <script>
        tail.DateTime("#licence_issue_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#licence_expiry_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#passport_expiry",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#dob",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#visit_exit_date",{
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

            $('#role').select2({
                placeholder: 'Select an option'
            });
            $('#platform_id').select2({
                placeholder: 'Select an option'
            });
            $('#department').select2({
                placeholder: 'Select an option'
            });
            $('#major_department_ids').select2({
                placeholder: 'Select an option'
            });

            $('#cities').select2({
                placeholder: 'Select an option'
            });

            $('#promotion_type').select2({
                placeholder: 'Select an option'
            });

            $('#country_id').select2({
                placeholder: 'Select an option'
            });





        });
    </script>

    <script>

        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            // if(selected=="1"){
            //     $(".visit_visa_status_cls").show();
            //     $(".cancel_visa_status_cls").hide();
            //     $(".own_visa_status_cls").hide();
            // }else if(selected=="2"){
            //
            //     $(".cancel_visa_status_cls").show();
            //     $(".visit_visa_status_cls").hide();
            //     $(".own_visa_status_cls").hide();
            //
            // }else{
            //
            //     $(".own_visa_status_cls").show();
            //     $(".cancel_visa_status_cls").hide();
            //     $(".visit_visa_status_cls").hide();
            //
            // }
        });

        $('input[type=radio][name=license_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".driving_licence_div_cls").css('display','block');
            }else{
                $(".driving_licence_div_cls").hide();
            }

        });
    </script>

    <script>
        $("#promotion_type").change(function () {
            var selected_ab = $(this).val();

            if(selected_ab=="7"){
                $("#other_source_name_div").show();
                $("#other_source_name").prop('required',false);

                $("#social_id_name_div").hide();
                $("#social_id_name").prop('required',false);

            }else{
                $("#other_source_name_div").hide();
                $("#other_source_name").prop('required',false);
            }

            if(selected_ab == "1" || selected_ab == "2" || selected_ab == "3"  || selected_ab == "5"){
                $("#social_id_name_div").show();
                $("#social_id_name").prop('required',false);
            }else{
                $("#social_id_name_div").hide();
                $("#social_id_name").prop('required',false);
            }

        });
    </script>

    <script src="{{asset('assets/international_js/build/js/intlTelInput.js')}}"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            // allowDropdown: false,
            // autoHideDialCode: false,
            autoPlaceholder: "on",
            // dropdownContainer: document.body,
            // excludeCountries: ["us"],
            formatOnDisplay: true,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            autoPlaceholder: "polite",
            hiddenInput: "full_number",
            initialCountry: "ae",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            onlyCountries: ['in', 'bd', 'ne', 'sd','np','ae','pk'],
            placeholderNumberType: "MOBILE",
            preferredCountries: ['ae', 'pk'],
            separateDialCode: true,
            utilsScript: "{{ asset('assets/international_js/build/js/utils.js') }}",
        });


        var input_whatsapp = document.querySelector("#whatsapp");
        window.intlTelInput(input_whatsapp, {
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            formatOnDisplay: true,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            hiddenInput: "whats_app_full_number",
            initialCountry: "ae",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            onlyCountries: ['ae','pk', 'in', 'bd', 'ne', 'sd','np'],
            placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            separateDialCode: true,
            utilsScript: "build/js/utils.js",
        });

    </script>

    {{--    ajax form start--}}
    <script>
        // this is the id of the form
        $("#new_form_save").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                cache: false,
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(response)
                {
                    if($.trim(response)=="success"){
                        tostr_display("success","Career Added Successfully");

                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);
                        // alert("agreement is submitted");
                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });
    </script>
    {{--    ajax form end--}}

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

    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>



@endsection
