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
    /* loading image css starts */
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
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    /* loading image css ends */
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>All Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <!--------Passport Additional Information--------->
    <div class="row">
        <form class="col-12" id="advance_filter_form">
            <div class="ul-widget__head">
                <div class="ul-widget__head-label">
                    <h3 class="ul-widget__head-title">Advance Filter</h3>
                </div>
                <div class="ul-widget__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line" role="tablist">
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#platform_info" role="tab" aria-selected="true">Platform Info</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact_info" role="tab" aria-selected="true">Contact Info</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#passport_info" role="tab" aria-selected="true">Passport Info</a></li>
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#visa_info" role="tab" aria-selected="false">Visa Info</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tra_info" role="tab" aria-selected="false">RTA Info</a></li>
                    </ul>
                </div>
            </div>
            <div class="ul-widget__body">
                <div class="tab-content">
                    <div class="tab-pane" id="platform_info">
                        <div class="ul-widget1 row">
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="platform_name" name="platform_name" value="assign_to_dcs.platform" checked>
                                    <span class="checkmark"></span>
                                    <label for="platform_name">Platform Name</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="platform_codes" name="platform_codes" value="check_platform_code_exist" checked>
                                    <span class="checkmark"></span>
                                    <label for="platform_codes">Platform Codes</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="platform_city" name="platform_city" value="assign_to_dcs.platform.city_name" checked>
                                    <span class="checkmark"></span>
                                    <label for="platform_city">Platform City</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="platform_changed" name="platform_changed" value="assign_to_dcs" checked>
                                    <span class="checkmark"></span>
                                    <label for="platform_changed">Platform Changed</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="current_dc" name="current_dc" value="assign_to_dcs.platform.user_detail">
                                    <span class="checkmark"></span>
                                    <label for="current_dc">Current DC</label>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="contact_info">
                        <div class="ul-widget1 row">
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="name" name="name" value="personal_info" checked>
                                    <span class="checkmark"></span>
                                    <label for="name">Name</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="personal_phone" value="personal_info" checked>
                                    <span class="checkmark"></span>
                                    <label for="personal_phone">Personal Phone</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="personal_email" value="personal_info" checked>
                                    <span class="checkmark"></span>
                                    <label for="personal_email">Personal Email</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="company_phone" value="sim_assign" checked>
                                    <span class="checkmark"></span>
                                    <label for="company_phone">Company Phone</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="sim_checkin_date" value="sim_assign" checked>
                                    <span class="checkmark"></span>
                                    <label for="sim_checkin_date">Sim Checkin Date</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="sim_card_changed" value="sim_assign" checked>
                                    <span class="checkmark"></span>
                                    <label for="sim_card_changed">Sim Card Changed</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="passport_info">
                        <div class="ul-widget1 row">
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="passport_no" name="passport_no" value="passport_no" checked>
                                    <span class="checkmark"></span>
                                    <label for="passport_no">Passport No</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="zds_code" name="zds_code" value="zds_code" checked>
                                    <span class="checkmark"></span>
                                    <label for="zds_code">ZDS Code</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="ppuid" name="ppuid" value="ppuid" checked>
                                    <span class="checkmark"></span>
                                    <label for="ppuid">PPUID</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="passport_handler" name="passport_handler" value="passport_handler">
                                    <span class="checkmark"></span>
                                    <label for="passport_handler">Passport Handler</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="renew_passport_number" name="renew_passport_number" value="renew_pass" checked>
                                    <span class="checkmark"></span>
                                    <label for="renew_passport_number">Passport Renew</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active show" id="visa_info">
                        <div class="ul-widget1 row">
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="visa_status"  value="career" checked>
                                    <span class="checkmark"></span>
                                    <label for="visa_status">Visa Status</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="visa_profession" value="offer.designation" checked>
                                    <span class="checkmark"></span>
                                    <label for="visa_profession">Visa Profession</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="visa_company" value="offer.companies">
                                    <span class="checkmark"></span>
                                    <label for="visa_company">Visa Company</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="assign_category" value="assign_category" checked>
                                    <span class="checkmark"></span>
                                    <label for="assign_category">Assign Category</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="common_status" value="common_status" checked>
                                    <span class="checkmark"></span>
                                    <label for="common_status">Common Status</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tra_info">
                        <div class="ul-widget1 row">
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="bike_plate_no" name="bike_plate_no" value="bike_assign.bike_plate_number" checked>
                                    <span class="checkmark"></span>
                                    <label for="bike_plate_no">Bike Plate no</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="bike_last_checkin_date" name="bike_last_checkin_date" value="assign_to_dcs" checked>
                                    <span class="checkmark"></span>
                                    <label for="bike_last_checkin_date">Bike Last checkin Date</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="emirates_id" name="emirates_id" value="emirates_id" checked>
                                    <span class="checkmark"></span>
                                    <label for="emirates_id">EmiratesId</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="temporary_bike" name="temporary_bike" value="bike_replacement.temporary_plate_number" checked>
                                    <span class="checkmark"></span>
                                    <label for="temporary_bike">Temporary Bike</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="driving_license" name="driving_license" value="driving_license" checked>
                                    <span class="checkmark"></span>
                                    <label for="driving_license">Driving License</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="driving_license_city" name="driving_license_city" value="driving_license.city" checked>
                                    <span class="checkmark"></span>
                                    <label for="driving_license_city">Driving City</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="passport_ticket_count" name="passport_ticket_count" value="profile" checked>
                                    <span class="checkmark"></span>
                                    <label for="passport_ticket_count">Tickets</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="bike_changed" name="bike_changed" value="bike_assign">
                                    <span class="checkmark"></span>
                                    <label for="bike_changed">Bike Changed</label>
                                </label>
                            </div>
                            <div class="ul-widget2__item col-2">
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" id="current_cod" name="current_cod" value="current_cod">
                                    <span class="checkmark"></span>
                                    <label for="current_cod">Current COD</label>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-info btn-sm float-right" id="advance_filter_btn">Apply Filter</button>
        </form>
        <div class="col-md-12 mb-3 p-1" id="allPassportInfoTableHolder"></div>
        <!---------CheckOut Model---------->
        <div class="modal fade" id="history_table_modal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="row">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Riders Category Assignment History</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body" id="history_table_holder"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--------checkout model ends--------->
    </div>
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(".history_btn").click(function(){
            $("body").removeClass("loading");
            var passport_id = $(this).attr('data-passport_id');
            $.ajax({
                url: "{{ route('ajax_rider_category_active_inactive_history') }}",
                method: 'GET',
                data:{ passport_id },
                success: function (response) {
                    $('#history_table_holder').empty();
                    $('#history_table_holder').append(response.html);
                    $("body").removeClass("loading");
                    $('#history_table_modal').modal('show');
                }
            });
        });
    </script>

    <script>
        $("#advance_filter_btn").click(function(e){
            var platform_name = $('#platform_name').is(':checked') ? $('#platform_name').val() : null
            var platform_codes = $('#platform_codes').is(':checked') ? $('#platform_codes').val() : null;
            var platform_city = $('#platform_city').is(':checked') ? $('#platform_city').val() : null;
            var platform_changed = $('#platform_changed').is(':checked') ? $('#platform_changed').val() : null;
            var current_dc = $('#current_dc').is(':checked') ? $('#current_dc').val() : null;
            var name = $('#name').is(':checked') ? $('#name').val() : null;
            var passport_no = $('#passport_no').is(':checked') ? $('#passport_no').val() : null;
            var zds_code = $('#zds_code').is(':checked') ? $('#zds_code').val() : null;
            var ppuid = $('#ppuid').is(':checked') ? $('#ppuid').val() : null;
            var passport_handler = $('#passport_handler').is(':checked') ? $('#passport_handler').val() : null;
            var renew_passport_number = $('#renew_passport_number').is(':checked') ? $('#renew_passport_number').val() : null;
            var personal_phone = $('#personal_phone').is(':checked') ? $('#personal_phone').val() : null;
            var personal_email = $('#personal_email').is(':checked') ? $('#personal_email').val() : null;
            var company_phone = $('#company_phone').is(':checked') ? $('#company_phone').val() : null;
            var sim_checkin_date = $('#sim_checkin_date').is(':checked') ? $('#sim_checkin_date').val() : null;
            var sim_card_changed = $('#sim_card_changed').is(':checked') ? $('#sim_card_changed').val() : null;
            var bike_plate_no = $('#bike_plate_no').is(':checked') ? $('#bike_last_checkin_date').val() : null;
            var bike_last_checkin_date = $('#bike_last_checkin_date').is(':checked') ? $('#bike_last_checkin_date').val() : null;
            var emirates_id = $('#emirates_id').is(':checked') ? $('#emirates_id').val() : null;
            var temporary_bike = $('#temporary_bike').is(':checked') ? $('#temporary_bike').val() : null;
            var driving_license = $('#driving_license').is(':checked') ? $('#driving_license').val() : null;
            var driving_license_city = $('#driving_license_city').is(':checked') ? $('#driving_license_city').val() : null;
            var passport_ticket_count = $('#passport_ticket_count').is(':checked') ? $('#passport_ticket_count').val() : null;
            var current_cod = $('#current_cod').is(':checked') ? $('#current_cod').val() : null;
            var bike_changed = $('#bike_changed').is(':checked') ? $('#bike_changed').val() : null;
            var visa_status = $('#visa_status').is(':checked') ? $('#visa_status').val() : null;
            var visa_company = $('#visa_company').is(':checked') ? $('#visa_company').val() : null;
            var visa_profession = $('#visa_profession').is(':checked') ? $('#visa_profession').val() : null;
            var assign_category = $('#assign_category').is(':checked') ? $('#assign_category').val() : null;
            var common_status = $('#common_status').is(':checked') ? $('#common_status').val() : null;
            $.ajax({
                url: "{{ route('assign_report') }}",
                method: 'GET',
                data:{
                    platform_name,platform_codes,platform_city,platform_changed,current_dc,name,passport_no,zds_code,ppuid,
                    passport_handler,renew_passport_number,personal_phone,personal_email,company_phone,sim_checkin_date,sim_card_changed,
                    bike_plate_no,bike_last_checkin_date,emirates_id,temporary_bike,driving_license,driving_license_city,
                    passport_ticket_count,current_cod,bike_changed,visa_profession,visa_status,visa_company,assign_category,
                    common_status
                },
                success: function (response) {
                    $('#allPassportInfoTableHolder').empty();
                    $('#allPassportInfoTableHolder').append(response.html);

                }
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
