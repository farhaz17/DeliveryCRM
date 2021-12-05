@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <style>
        .modal_table .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }
        .modal_table h6{
            font-weight:800;
        }
        .remarks{
            font-weight:800;
        }
        .modal_table .table td{
            padding: 2px;
            font-size: 12px;
        }

        .active_cls{
            border: 3px solid #ffa500f2;
        }

        .active_cls_visa{
            border: 3px solid #bb2a2a;
        }

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        /*.dataTables_info{*/
        /*    display:none;*/
        /*}*/

        .history_table th{
            font-weight:800 !important;
        }
        .font_size_cls{
            font-size: 17px !important;
            cursor: pointer;
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
        .hide_cls{
            display: none;
        }

        .image-upload > input
        {
        display: none;
        }

        .image-upload i
        {
        cursor: pointer;
        }
        /* .hide_clss{
            display: none;
        } */
        .modals-lg {
        max-width: 70% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        }
        .backrgound_color{
            background-color: #3d576b;
        }
    </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Selected Candidate</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    remarks modal--}}

    <div class="modal fade" id="remark_modal"  style="z-index: 9999" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="remark_p"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{--remarks modal end--}}

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('update_after_short_list') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status For Rider</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <input type="hidden" name="from_shorlisted" value="1">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <input type="hidden" name="sending_status" value="1">
                                <label for="repair_category">Select Status</label>
                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Legal status</label>
                                <select id="legal_status" name="legal_status" class="form-control form-control-rounded" required  >
                                    <option value="" selected disabled>Select Option</option>

                                </select>
                            </div>


                            <div class="col-md-6 form-group mb-3 new_visa_dropdown" style="display: none;">
                                <label for="repair_category">Select visa status</label>
                                <select id="new_visa_status_one" name="new_visa_status_one" class="form-control form-control-rounded"  >
                                    <option value="" selected disabled>Select Option</option>

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 new_visa_dropdown" style="display: none;">
                                <label for="repair_category">Select visa status</label>
                                <select id="new_visa_status_two" name="new_visa_status_two" class="form-control form-control-rounded"  >
                                    <option value="" selected disabled>Select Option</option>

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 free_visa_dropdown" style="display: none;">
                                <label for="repair_category">Select visa status</label>
                                <select id="freelance_visa" name="freelance_visa" class="form-control form-control-rounded"  >
                                    <option value="" selected disabled>Select Option</option>

                                </select>
                            </div>



                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Remarks For Rider</label>
                                <textarea class="form-control" required name="remarks"></textarea>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Remarks For Company</label>
                                <textarea class="form-control" required name="company_remarks"></textarea>
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

    {{--    passport detail modal--}}

    <div class="modal fade bd-example-modals-lg" id="passport_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modals-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Passport Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="row">
                    <div class="col-md-8">
                <div class="modal-body modal_body_cls">
                    <input type="hidden" id="primary_id" name="id" value="">

                </div>
            </div>
            <div class="col-md-4">
                <h6><b>Remarks</b></h6>
                            <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6;margin-right: 15px;">
                                <div class="chat-content-wrap" data-sidebar-content="chat">
                                    <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


                                    </div>

                                </div>
                            </div>

            </div>
            </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--    passport detail modal end--}}


    {{--------------------remarks model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="remarks_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('career.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Rider Remarks</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_ids" name="id" value="">
                        <div class="row">

                            <input type="hidden" name="sending_status" value="2">

                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Remarks For Rider</label>
                                <textarea class="form-control" required name="remarks" rows="5"></textarea>
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
    {{--------------------remarks model ends here-----------------}}

    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('save_passport_passport') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="career_primary_id" id="primary_id_for_passport" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Nationality</label>
                                <select class="form-control" name="nation_id" id="nation_id" required>
                                    <option value="" selected disabled >Select nationality</option>
                                     @foreach($nations as $nation)
                                    <option value="{{ $nation->id }}"  >{{ $nation->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Passport Number</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control" required>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Sur Name</label>
                                <input class="form-control form-control" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Given Name</label>
                                <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required="">
                            </div>



                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Father Name</label>
                                <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name">
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
    {{--------------------remarks model ends here-----------------}}



    {{--    view Detail modal--}}
    <div class="modal fade bd-example-modals-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modals-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="table-responsive modal_table">
                                <h6>Personal Detail</h6>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <td><span id="name_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><span id="email_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td><span id="phone_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Date Of Birth</th>
                                        <td><span id="dob_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Whats App</th>
                                        <td><span id="whatsapp_html"></span></td>
                                    </tr>

{{--                                    <tr>--}}
{{--                                        <th>Facebook</th>--}}
{{--                                        <td><span id="facebook_html"></span></td>--}}
{{--                                    </tr>--}}
                                    <tr>
                                        <th>Experience</th>
                                        <td><span id="experiecne_html"></span></td>
                                    </tr>

{{--                                    <tr>--}}
{{--                                        <th>CV Attached</th>--}}
{{--                                        <td>--}}
{{--                                            <a id="cv_attached_html" target="_blank"></a>--}}
{{--                                            <span id="cv_attached_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}


                                    <tr>
                                        <th>Applicant status</th>
                                        <td><span id="applicant_status_html"></span></td>
                                    </tr>



                                </table>
                            </div>


                            <div class="table-responsive modal_table">
                                <h6>Passport Detail</h6>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Nationality</th>
                                        <td><span id="nationality_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Passport Number</th>
                                        <td><span id="passport_no_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Passport Expiry</th>
                                        <td><span id="passport_expiry_html"></span></td>
                                    </tr>

{{--                                    <tr>--}}
{{--                                        <th>Passport Attached</th>--}}
{{--                                        <td>--}}
{{--                                            <a  href="" id="passport_attach_html" target="_blank"></a>--}}
{{--                                            <span id="passport_attach_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

                                </table>
                            </div>



                            <p  style="display: none;" id="remarks_html"></p>


                        </div>

                        <div class="col-md-4">
                            <div class="table-responsive modal_table">
                                <h6>License Detail</h6>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>License Status</th>
                                        <td><span id="license_status_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Licence status vehicle</th>
                                        <td><span id="license_status_vehicle_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <td><span id="vehicle_type_html"></span></td>
                                    </tr>



                                    <tr>
                                        <th>Licence number</th>
                                        <td><span id="license_no_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Licence City Name</th>
                                        <td><span id="license_city_name"></span></td>
                                    </tr>


                                    {{--                                    <tr>--}}
                                    {{--                                        <th>Licence issue</th>--}}
                                    {{--                                        <td><span id="license_issue_html"></span></td>--}}
                                    {{--                                    </tr>--}}

                                    <tr>
                                        <th>Traffic code number</th>
                                        <td><span id="license_issue_html"></span></td>
                                    </tr>

                                    {{--                                    <tr>--}}
                                    {{--                                        <th>Licence Expiry</th>--}}
                                    {{--                                        <td><span id="license_expiry_html"></span></td>--}}
                                    {{--                                    </tr>--}}

{{--                                    <tr>--}}
{{--                                        <th>Licence Attached</th>--}}
{{--                                        <td>--}}
{{--                                            <a  href="" id="license_attach_html" target="_blank"></a>--}}
{{--                                            <span id="license_attach_not_found_html"></span>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

                                </table>
                            </div>


                            <div class="table-responsive modal_table">
                                <h6>Visa Detail</h6>
                                <table class="table table-bordered table-striped">


                                    <tr>
                                        <th>Visa Status</th>
                                        <td><span id="visa_status_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Visa status visit</th>
                                        <td><span id="visa_status_visit_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Visa status cancel</th>
                                        <td><span id="visa_status_cancel_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Visa status own</th>
                                        <td><span id="visa_status_own_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Exit date</th>
                                        <td><span id="exit_date_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Company visa</th>
                                        <td><span id="company_visa_html"></span></td>
                                    </tr>

{{--                                    <tr>--}}
{{--                                        <th>Inout transfer</th>--}}
{{--                                        <td><span id="inout_transfer_html"></span></td>--}}
{{--                                    </tr>--}}

                                    <tr>
                                        <th>PlatForm</th>
                                        <td><span id="platform_id_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Applied cities</th>
                                        <td><span id="applied_cities"></span></td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        {{-- <div class="col-md-12">
                            <h6 class="remarks" >
                                Remarks History
                            </h6>

                            <div class="table-responsive modal_table">
                                <table class="table table-bordered table-striped table-sm " id="table_history">
                                    <thead>
                                    <tr class="history_table">
                                        <th>Status</th>
                                        <th>Remarks For Rider</th>
                                        <th>Remarks For Company</th>
                                        <th>Created At</th>
                                        <th>Remarks By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <h6><b>Remarks</b></h6>
                            <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6">
                                <div class="chat-content-wrap" data-sidebar-content="chat">
                                    <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}


    <!--  interview detail Modal -->
    <div class="modal fade bd-example-modal-lg"  id="interview_modal" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Create Interview For Selected Interview</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('career_send_interview') }}" method="POST" id="sent_interview_form">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="remove_follow_up"  value="1">
                    <input type="hidden" name="checkbox_array" id="select_ids_interview" >
                    <input type="hidden" name="type_for_rejoin" id="type_for_rejoin" value="0">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-3 form-group mb-3 ">
                                <label for="repair_category">Please Select City</label>
                                <select class="form-control" name="search_city_id" id="search_city_id" required >
                                    <option value="">select an option</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3 ">
                                <label for="repair_category">Please Select Platform</label>
                                <select class="form-control" name="search_platform_id" id="search_platform_id" required >
                                    <option value="">select an option</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 ">
                                <label for="repair_category">Please Select Batch</label>
                                <select class="form-control" name="batch_id" id="batch_id" required >

                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3 batch_detial_cls hide_cls ">
                                <label for="repair_category">Platform Name</label>
                                <h5   id="platform_name" ></h5>
                            </div>

                            <div class="col-md-3 form-group mb-3  batch_detial_cls hide_cls ">
                                <label for="repair_category">Interview Date</label>
                                <h6 id="interview_date" ></h6>
                            </div>

                            <div class="col-md-3 form-group mb-3 batch_detial_cls hide_cls ">
                                <label for="repair_category" >Interview Start Time</label>
                                <h6 id="interview_start_time"></h6>
                            </div>

                            <div class="col-md-3 form-group mb-3 batch_detial_cls hide_cls ">
                                <label for="repair_category" >Interview End Time</label>
                                <h6 id="interview_end_time"></h6>
                            </div>

                            <div class="col-md-3 form-group mb-3 batch_detial_cls hide_cls ">
                                <label for="repair_category" >Candidate Quantity</label>
                                <h6 id="interview_quantity"></h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 message_div" style="display: none;" >
                                    <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">This User already in this Batch</strong>

                                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <p id="error_name">Lorem ipsum dolor sit amet.</p>
                                    </div>
                            </div>

                            <div class="col-md-12 message_div_exceed" style="display: none;" >
                                <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Batch Limit</strong>

                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <p id="error_exceed">Lorem ipsum dolor sit amet.</p>
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
    </div><!-- end of note modal -->




        <!--  interview detail single Modal -->
        <div class="modal fade bd-example-modal-lg"  id="interview_single_modal" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Create Interview For Selected Interview</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <form action="{{ route('career_send_interview') }}" method="POST" id="sent_interview_single_form">
                        @csrf
                        <input type="hidden" name="type"  value="3">
                        <input type="hidden" name="remove_follow_up"  value="1">
                        <input type="hidden" name="checkbox_array" id="select_ids_interview_single" >
                        <input type="hidden" name="type_for_rejoin" id="type_for_rejoin_single" value="0">
                        <div class="modal-body">

                            <div class="row"  id="append_single_interview">

                            </div>



                            <div class="row">


                                <div class="col-md-3 form-group mb-3 batch_detial_cls_single hide_cls ">
                                    <label for="repair_category">Platform Name</label>
                                    <h5 id="platform_name_single" ></h5>
                                </div>

                                <div class="col-md-3 form-group mb-3  batch_detial_cls_single hide_cls ">
                                    <label for="repair_category">Interview Date</label>
                                    <h6 id="interview_date_single" ></h6>
                                </div>

                                <div class="col-md-3 form-group mb-3 batch_detial_cls_single hide_cls ">
                                    <label for="repair_category" >Interview Start Time</label>
                                    <h6 id="interview_start_time_single"></h6>
                                </div>

                                <div class="col-md-3 form-group mb-3 batch_detial_cls_single hide_cls ">
                                    <label for="repair_category" >Interview End Time</label>
                                    <h6 id="interview_end_time_single"></h6>
                                </div>

                                <div class="col-md-3 form-group mb-3 batch_detial_cls_single hide_cls ">
                                    <label for="repair_category" >Candidate Quantity</label>
                                    <h6 id="interview_quantity_single"></h6>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 message_div" style="display: none;" >
                                        <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">This User already in this Batch</strong>

                                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <p id="error_name_single">Lorem ipsum dolor sit amet.</p>
                                        </div>
                                </div>

                                <div class="col-md-12 message_div_exceed" style="display: none;" >
                                    <div class="alert alert-card alert-danger" role="alert"><strong class="text-capitalize">Batch Limit</strong>

                                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <p id="error_exceed_single">Lorem ipsum dolor sit amet.</p>
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
        </div><!-- end of single interview  modal -->












    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="edit_email_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Send Email For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('career_frontdesk_save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type"  value="4">
                    {{-- <input type="hidden" name="checkbox_array" id="select_ids_email" > --}}
                    <input type="hidden" name="checkbox_array" id="select_ids"  value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control" id="select_ids_email" class="recipients" name="recipients" value="" type="text" readonly/>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control" id="subject" name="subject" value="" type="text" placeholder="Subject" required/>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="ckeditor form-control" rows="4" id="email_note" name="email_note" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="image-upload" style="padding: 10px;">
                                    <label for="file-input">
                                        <i class="fa fa-paperclip" style="font-size:20px"></i>
                                    </label>
                                    <input id="file-input" type="file" name="attachment"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="edit_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('career_frontdesk_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="category"  value="3">
                    <input type="hidden" name="checkbox_array" id="select_ids_note" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_selected as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_clss">
                                <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date" required />
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
    </div><!-- end of note modal -->

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-lg"  id="rejoin_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('rejoin_follow_up') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="category"  value="3">
                    <input type="hidden" name="checkbox_array" id="select_ids_notes" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_selected as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_clss">
                                <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date" required />
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
    </div><!-- end of note modal -->


    <!--  search modal -->
    <div class="modal fade bd-example-modal-lg"  id="seatch_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('search_result_career_selected') }}" method="POST" id="search_form" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Search name /phone /Whatsapp /Email</label>
                                <input class="form-control form-control" id="search_name"  name="search_name" type="text" />
                            </div>

                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input class="form-control form-control" id="start_created_date" name="start_created_date" autocomplete="off" type="text" />
                            </div>

                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input class="form-control form-control" id="end_created_date" name="end_created_date" autocomplete="off" type="text" />
                            </div>

                        </div>



                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of search modal -->

    <!--  search result modal -->
    <div class="modal fade bd-example-modal-lg"  id="search_result_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Result</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    {{--                        <div class="table-responsive">--}}
                    <table class="display table table-sm table-striped text-10 table-bordered" id="search_result_datatable" style="width: 100% !important;;">
                        <thead >
                        <tr>
                            <th scope="col" id="name_header">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col" class="filtering_source_from">Whats App</th>
                            <th scope="col">Status</th>
                            <th scope="col"  class="filtering_source_from" >Created At</th>
                            <th scope="col" class="filtering_source_from">Source type</th>
                            <th scope="col"  >Heard About us</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                    {{--                        </div>--}}

                </div>

            </div>
        </div>
    </div><!-- end of search modal -->


    <!--  add reject Modal -->
    <div class="modal fade bd-example-modal-sm"  id="reject_remarks_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Reject Reason</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
        <form action="{{ route('save_rejected_from_selected') }}" method="POST">
            @csrf
                <input type="hidden" name="primary_id_agreed" id="primary_id_agreed"  >
                <input type="hidden" name="checkbox_array" id="rejected_ids"  >
            <input type="hidden" name="which_tab_button_pressed" id="which_tab_button_pressed" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="select_image">Enter The Reject Reason</label>
                            <textarea class="form-control" id="reject_reason"  rows="6" name="reject_reason"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" id="save_reject_reason" type="submit">Save changes</button>
                </div>
        </form>

            </div>
        </div>
    </div><!-- end of reject modal -->


     <!--  rejoin career reject reason -->
     <div class="modal fade bd-example-modal-sm"  id="reject_remarks_rejoin_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('rejoin_reject_save') }}" method="POST">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Reject Reason</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <input type="hidden" name="primary_id_rejected" id="primary_id_rejected"  >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="select_image">Enter The Reject Reason</label>
                            <textarea class="form-control" id="reject_rejoin_reason"  rows="6" name="reject_rejoin_reason" required></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2"  type="submit">Save changes</button>
                </div>
                </form>

            </div>
        </div>
    </div><!-- end of rejoin career reject reason -->







    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <button class="btn btn-primary btn-icon m-1 text-white" id="search_btn" type="button"><span class="ul-btn__icon"><i class="i-Search-People"></i></span><span class="ul-btn__text">Search</span></button>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Company Rider ({{ $company_rider->count() ? $company_rider->count(): '0'  }})  </a></li>
                    <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Four PL Rider ({{ $four_pl_rider->count() ? $four_pl_rider->count(): '0'  }}) </a></li>
                    <li class="nav-item"><a class="nav-link text-10" id="rejoin-tab" data-toggle="tab" href="#rejoin" role="tab" aria-controls="rejoin" aria-selected="false">Rejoin Candidate ({{ $rejoin_candidate->count() ? $rejoin_candidate->count(): '0'  }}) </a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <form action="{{ route('career_send_interview') }}" id="save_form" method="POST">
                            @csrf
                            <button class="btn btn-info btn-icon m-1"  id="selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Interview</span></button>
                            <button class="btn btn-danger btn-icon m-1" id="rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                            <button class="btn btn-success btn-icon m-1 text-white" id="email_btn" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                            <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>

                            {{-- <a href="{{ route('view_selected_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                            <input type="hidden" name="type" id="type_first_tab" value="1">

                            <input type="hidden" name="reject_reason" id="reject_reason_in_form" value="">



                            {{--accordian start--}}
                            <div class="accordion mb-10" id="accordionRightIcon" >
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                        <div class="card-body">

                                            <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_bike_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Bike ( {{ $company_rider->where('vehicle_type','=','1')->count() }} )</span></button>
                                            <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_car_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Car ( {{ $company_rider->where('vehicle_type','=','2')->count() }} )</span></button>
                                            <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_both_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Both ( {{ $company_rider->where('vehicle_type','=','3')->count() }} )</span></button>
                                            <input type="hidden" name="action_btn_click_filter" id="action_btn_click_filter" value="">

                                            <div class="company_visa_cls_div" style="display: none;">
                                                <button class="btn btn-primary btn-icon m-1 company_visa_cls backrgound_color"  id="company_visit_visa" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Visit Visa (<span id="visit_visa_count">0</span>)</span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_visa_cls backrgound_color"  id="company_cancel_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Cancel Visa (<span id="cancel_visa_count">0</span>) </span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_visa_cls backrgound_color"  id="company_own_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Own Visa (<span id="own_visa_count">0</span>)</span></button>
                                            </div>
                                            <input type="hidden" name="action_btn_visa_filter" id="action_btn_visa_filter" value="">

                                            <div class="company_visit_visa_cls_div" style="display: none;">
                                                <button class="btn btn-primary btn-icon m-1 company_visit_visa_cls backrgound_color"  id="company_visit_one_month_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">One Month (<span id="one_month_count">0</span>)</span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_visit_visa_cls backrgound_color"  id="company_visit_three_month" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Three Month (<span id="three_month_count">0</span>)</span></button>
                                            </div>

                                            <div class="company_cancel_visa_cls_div" style="display: none;">
                                                <button class="btn btn-primary btn-icon m-1 company_cancel_visa_cls backrgound_color"  id="company_cancel_free_zone" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Free Zone (<span id="free_zone_count">0</span>)</span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_cancel_visa_cls backrgound_color"  id="company_cancel_company_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Company Visa (<span id="company_visa_count">0</span>)</span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_cancel_visa_cls backrgound_color"  id="company_cancel_waiting_cancel" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Waiting Cancellation  (<span id="waiting_cancellation_count">0</span>)</span></button>
                                            </div>

                                            <div class="company_own_visa_cls_div" style="display: none;">
                                                <button class="btn btn-primary btn-icon m-1 company_own_visa_cls backrgound_color"  id="company_own_noc" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">NOC  (<span id="noc_count">0</span>)</span></button>
                                                <button class="btn btn-primary btn-icon m-1 company_own_visa_cls backrgound_color"  id="company_own_without_no" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Without NOC  (<span id="without_noc_count">0</span>)</span></button>
                                            </div>

                                            <div class="row mt-10">
                                                 <div class="col-md-6">
                                                        <select class="form-control" name="first_pkg" id="first_pkg">
                                                            <option value="" selected>please select option</option>
                                                            @foreach ($company_pkg as  $company)
                                                                <option value="{{ $company->id }}">{{ $company->package_name }}</option>
                                                            @endforeach
                                                        </select>
                                                 </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--accordian end here--}}


                        <div class="table-responsive">
                            <table class="display table table-striped text-10 table-bordered table-sm" id="datatable_career">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="company_checkbox"  id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Whats App</th>
                                    <th scope="col" class="filtering_source_from">Status</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Interview Pass/Failed</th>
                                    <th scope="col">Training Pass/Rejected</th>
{{--                                    <th scope="col" class="filtering_source_from">Source type</th>--}}
{{--                                    <th scope="col" class="filtering_source_from">Heard About us</th>--}}
                                    <th scope="col" >Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($company_rider as $career)


                                    <?php
                                        $passport_detail = isset($career->passport_ppuid) ? $career->passport_ppuid->passport_no : '0';
                                    ?>

                                    <tr id="row-{{ $career->id }}" >
                                        <td>#</td>
                                        <td>

                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox" data-email="{{ $career->email }}"   class="company_checkbox original_company_checkbox" name="checkbox_array[]" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
                                        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
                                        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
                                        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
                                        <td>
                                            @if (isset($career->follow_up_status))
                                            @if ($career->follow_up_status == "0")
                                                N/A
                                                @else
                                                {{$career->follow_up_name_selected->name}}
                                            @endif
                                        @endif
                                            </td>
                                        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}

                                        <td id="created_at-{{ $career->id }}" >{{ $career->updated_at->toDateString() }}</td>
                                        <td><h5 class="badge badge-success">{{ $career->interview_pass() ? $career->interview_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->interview_failed() ? $career->interview_failed()  : '0'}}</h5></td>
                                        <td><h5 class="badge badge-success">{{ $career->training_pass() ? $career->training_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->training_fail() ? $career->training_fail()  : '0'}}</h5></td>

                                        <td>
                                            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            {{-- <a class="text-success mr-2 send_interview_btn" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Add-UserStar font-weight-bold"></i></a> --}}

                                            @if($passport_detail!="0")
                                                <h5 class="badge badge-info">PPUID Created</h5>
                                            @else
{{--                                                <a class="text-secondary mr-2 enter_passport" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>--}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        </form>

                    </div>
                    <!---------------------tab1 ends here-------------->
                    <!---------------------tab2-------------->

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="table-responsive">

                            <form action="{{ route('career_send_interview') }}" id="four_pl_save_form" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-icon m-1"  id="four_pl_selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Interview</span></button>
                                <button class="btn btn-danger btn-icon m-1" id="four_pl_rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                                <button class="btn btn-success btn-icon m-1 text-white" id="email_btnto" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                                <button class="btn btn-warning btn-icon m-1"  id="four_pl_note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                                {{-- <a href="{{ route('view_selected_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                                <input type="hidden" name="type" id="type" value="2">

                                {{--accordian start--}}
                                <div class="accordion mb-10" id="accordionRightIcon_two" >
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-two" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                        </div>
                                        <div class="collapse" id="accordion-item-icons-two" data-parent="#accordionRightIcon_two">
                                            <div class="card-body">


                                                <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_bike_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Bike <span>({{ $four_pl_rider->where('vehicle_type','=','1')->count() }})</span> </span></button>
                                                <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_car_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Car <span>({{ $four_pl_rider->where('vehicle_type','=','2')->count() }})</span> </span></button>
                                                <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_both_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Both <span>({{ $four_pl_rider->where('vehicle_type','=','3')->count() }})</span> </span></button>
                                                <input type="hidden" name="action_btn_click_filter_four_pl" id="action_btn_click_filter_four_pl" value="">

                                                <div class="row mt-10">
                                                    <div class="col-md-6">
                                                           <select class="form-control" name="second_pkg" id="second_pkg">
                                                               <option value="" selected>please select option</option>
                                                               @foreach ($fourpl_pkg as  $company)
                                                                   <option value="{{ $company->id }}">{{ $company->package_name }}</option>
                                                               @endforeach
                                                           </select>
                                                    </div>
                                               </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--accordian end here--}}



                            <table class="display table table-striped text-10 table-bordered table-sm" id="datatable_career_referals">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"    id="four_pl_checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Whats App</th>
                                    <th scope="col" class="filtering_source_from">Status</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Interview Pass/Failed</th>
                                    <th scope="col">Training Pass/Rejected</th>

                                    <th scope="col" >Action</th>

                                </tr>
                                </thead>
                                <tbody>


                                @foreach($four_pl_rider as $career)


                                    <?php
                                    $passport_detail = isset($career->passport_ppuid) ? $career->passport_ppuid->passport_no : '0';
                                    ?>

                                    <tr id="row-{{ $career->id }}">
                                        <td>#</td>
                                        <td>

                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox" data-email="{{ $career->email }}"    class="four_pl_checkbox four_pl_orignial_checkbox" name="checkbox_array[]" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
                                        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
                                        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
                                        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
                                        <td>
                                            @if (isset($career->follow_up_status))
                                            @if ($career->follow_up_status == "0")
                                                N/A
                                                @else
                                                {{$career->follow_up_name_selected->name}}
                                            @endif
                                        @endif
                                            </td>
                                        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}

                                        <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>
                                        <td><h5 class="badge badge-success">{{ $career->interview_pass() ? $career->interview_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->interview_failed() ? $career->interview_failed()  : '0'}}</h5></td>
                                        <td><h5 class="badge badge-success">{{ $career->training_pass() ? $career->training_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->training_fail() ? $career->training_fail()  : '0'}}</h5></td>

                                        <td>
                                            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>

                                            <a class="text-success mr-2 send_interview_btn" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Add-UserStar font-weight-bold"></i></a>
                                            @if($passport_detail!="0")
                                                <h6 class="badge badge-success">PPUID Created</h6>
                                            @else

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>


                    <!--------------------- tab three -------------->

                    <div class="tab-pane fade show" id="rejoin" role="tabpanel" aria-labelledby="rejoin-tab">
                        <div class="table-responsive">

                            <form action="{{ route('career_send_interview') }}" id="rejoin_save_form" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-icon m-1"  id="rejoin_selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Interview</span></button>
{{--                                <button class="btn btn-danger btn-icon m-1" id="rejoin_rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>--}}
                                <button class="btn btn-success btn-icon m-1 text-white" id="rejoin_email_btn" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
{{--                                <button class="btn btn-warning btn-icon m-1"  id="rejoin_note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>--}}
                                {{-- <a href="{{ route('view_selected_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                                <input type="hidden" name="type" id="rejoin_type" value="2">

                                <table class="display table table-striped text-10 table-bordered table-sm" id="rejoin_datatable">
                                    <thead >
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                                <input type="checkbox"    id="rejoin_checkAll"><span>All</span><span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Passport No</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Whats App</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Interview Pass/Failed</th>
                                        <th scope="col">Training Pass/Rejected</th>

                                        <th scope="col" >Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($rejoin_candidate as $career)
                                    <?php
                                    $check_defaulter  = isset($career->defaulter_rider_details) ? $career->defaulter_rider_details : null;
                                    $is_defaulte_now = null;

                                    if(isset($check_defaulter)){
                                            if(count($check_defaulter)>0){
                                                $is_defaulte_now  =  $check_defaulter[0]->check_defaulter_rider() ? $check_defaulter[0]->check_defaulter_rider() : null;

                                           }
                                    }
                                    ?>

                                        <tr
                                        @isset($is_defaulte_now)
                                        style="background-color: #ff18004a;"
                                    @endisset
                                        id="row-{{ $career->id }}">
                                            <td>#</td>
                                            <td>
                                                <label class="checkbox checkbox-outline-primary text-10">
                                                    <input type="checkbox" data-passport_id="{{ $career->passport_detail->personal_info->passport_id }}" data-email="{{ $career->passport_detail->personal_info->personal_email ?? $career->passport_detail->personal_info->personal_email  }}" name="checkbox_array[]" class="rejoin_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td id="name-{{ $career->id }}">{{ $career->passport_detail->personal_info->full_name ??  $career->passport_detail->personal_info->full_name   }}</td>
                                            <td id="passport_no-{{ $career->id }}">{{ $career->passport_detail->passport_no ??  $career->passport_detail->passport_no   }}</td>
                                            <td  id="email-{{ $career->id }}">{{ $career->passport_detail->personal_info->personal_email ?? $career->passport_detail->personal_info->personal_email  }}</td>
                                            <td id="phone-{{ $career->id }}" >{{ $career->passport_detail->personal_info->personal_mob }}</td>
                                            <td id="whatsapp-{{ $career->id }}" >{{ $career->passport_detail->personal_info->nat_whatsapp_no }}</td>


                                            <td>@if (isset($career->follow_up_status))
                                                @if ($career->follow_up_status == "0")
                                                    N/A
                                                    @else
                                                    {{$career->follow_up_name_selected->name}}
                                                @endif
                                            @endif</td>


                                            <td id="created_at-{{ $career->id }}" >{{  $career->created_at->toDateString() }}</td>
                                            <td><h5 class="badge badge-success">{{ $career->interview_pass() ? $career->interview_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->interview_failed() ? $career->interview_failed()  : '0'}}</h5></td>
                                            <td><h5 class="badge badge-success">{{ $career->training_pass() ? $career->training_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->training_fail() ? $career->training_fail()  : '0'}}</h5></td>

                                            <td>
                                                <a class="text-primary mr-2 view_passport_detail_btn" data-passport_id="{{ $career->passport_id  }}" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                                <a class="text-danger mr-2 reject_btn" data-passport_id="{{ $career->passport_id  }}" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>






                </div>

            </div>
            <div class="overlay"></div>
        </div>
    </div>


@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

    <script>
        $('tbody').on('click', '.reject_btn', function() {
            var ids = $(this).attr('id');
            $("#primary_id_rejected").val(ids);
            $("#reject_remarks_rejoin_modal").modal('show');
            // alert(ids);
        });
    </script>

    <script>
        tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),

        });

        $('#batch_id').select2({
            placeholder: 'Select an option'
        });

        $('#search_platform_id').select2({
            placeholder: 'Select an option'
        });

        $('#search_city_id').select2({
            placeholder: 'Select an option'
        });



    </script>

<script>
    function make_table_search_table(table_name,html_var) {


    $('#'+table_name+' tbody').empty();

    var table = $('#'+table_name).DataTable();
    table.destroy();
    $('#'+table_name+' tbody').html(html_var);
    var table = $('#'+table_name).DataTable(
    { "aaSorting": [],
      "lengthMenu": [[10, 25, 50, -1],
        ['10 Rows', '25 Rows', '50 Rows', 'Show all']
            ],
        "columnDefs": [
            {"targets": [0],"visible": false},
        ],
    dom: 'Bfrtip',

    buttons: [
    {
       extend: 'excel',
       title: 'Pending Rider Fuel',
       text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
       exportOptions: {
                modifier: {
                page : 'all',
                        }
         }
     },
            'pageLength',
     ],
            "sScrollX": "100%",
            "scrollX": true
      });

    $(".display").css("width","100%");
    $('#'+table_name+' tbody').css("width","100%");
    $('#container').css( 'display', 'block' );
    table.columns.adjust().draw();

    }


    </script>

    <script>
     var carer_filter_data = "{{ route('filter_data_career') }}";
     var filter_data_for_package = "{{ route('filter_data_by_package') }}";
     var carer_filter_data_count = "{{ route('filter_data_counts') }}";
     </script>
    <script src="{{ asset('js/custom_js/career_filter_data_selected_candidate.js') }}"></script>



    <script>

        $('#rejected_btn').click(function() {
            checked = $(".original_company_checkbox:checked").length;

            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];


                $(".original_company_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                    $("#rejected_ids").val(my_array);
                });


                $("#which_tab_button_pressed").val("1");
                $("#reject_remarks_modal").modal("show");

                // $("#save_form").submit();
            }
        });

        $("#four_pl_rejected_btn").click(function() {
            checked = $(".four_pl_orignial_checkbox:checked").length;

            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];


                $(".four_pl_orignial_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                    $("#rejected_ids").val(my_array);
                });


                $("#which_tab_button_pressed").val("2");
                $("#reject_remarks_modal").modal("show");

                // $("#save_form").submit();
            }
        });

        $("#rejoin_rejected_btn").click(function() {
            checked = $(".rejoin_checkbox:checked").length;

            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];


                $(".rejoin_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                    $("#rejected_ids").val(my_array);
                });


                $("#which_tab_button_pressed").val("3");
                $("#save_reject_reason").click();
                // $("#reject_remarks_modal").modal("show");

                // $("#save_form").submit();
            }
        });









    </script>


    <script>
        $("#search_btn").click(function () {

            $("#seatch_modal").modal("show");

            tail.DateTime("#start_created_date",{
                dateFormat: "dd-mm-YYYY",
                timeFormat: false,

            }).on("change", function(){
                tail.DateTime("#end_created_date",{
                    dateStart: $('#start_created_date').val(),
                    dateFormat: "dd-mm-YYYY",
                    timeFormat: false

                }).reload();

            });

        });

        $("#search_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = $("#search_form").attr('action');
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
                    if(response=="error"){
                        tostr_display("error","please fill at least one field");
                        // alert("agreement is submitted");
                    }else if(response=="error_two"){
                        tostr_display("error","please select the end date as well");
                    }else{
                        $("#search_result_modal").modal('show');
                        make_table_search_table("search_result_datatable",response.html);

                        var table = $('#search_result_datatable').DataTable();
                        $(".display").css("width","100%");
                        $('#search_result_datatable tbody').css("width","100%");
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();

                        $("#search_result_datatable thead").click();


                    }

                }
            });
        });


        // {{--function make_table_search_table(table_name,html_var) {--}}
        // {{--    console.log(table_name);--}}

        // {{--    $('#'+table_name+' tbody').empty();--}}

        // {{--    var table = $('#'+table_name).DataTable();--}}
        // {{--    table.destroy();--}}
        // {{--    $('#'+table_name+' tbody').html(html_var);--}}
        // {{--    var table = $('#'+table_name).DataTable(--}}
        // {{--        {--}}
        // {{--            "aaSorting": [],--}}
        // {{--            "lengthMenu": [--}}
        // {{--                [10, 25, 50, -1],--}}
        // {{--                ['10 Rows', '25 Rows', '50 Rows', 'Show all']--}}
        // {{--            ],--}}
        // {{--            dom: 'Bfrtip',--}}
        // {{--            buttons: [--}}
        // {{--                {--}}
        // {{--                    extend: 'excel',--}}
        // {{--                    title: 'Pending Rider Fuel',--}}
        // {{--                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',--}}
        // {{--                    exportOptions: {--}}
        // {{--                        modifier: {--}}
        // {{--                            page : 'all',--}}
        // {{--                        }--}}
        // {{--                    }--}}
        // {{--                },--}}
        // {{--                'pageLength',--}}
        // {{--            ],--}}
        // {{--            "sScrollX": "100%",--}}
        // {{--            "scrollX": true--}}
        // {{--        }--}}
        // {{--    );--}}
        // {{--    $(".display").css("width","100%");--}}
        // {{--    $('#'+table_name+' tbody').css("width","100%");--}}
        // {{--    $('#container').css( 'display', 'block' );--}}
        // {{--    table.columns.adjust().draw();--}}

        // {{--}--}}


    </script>

    <script>
         $('#note_btn').click(function() {
                checked = $(".company_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                    $(".company_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                    });

                    $("#select_ids_note").val(my_array);

                    $("#edit_note_modal").modal('show');

                }
            });

            $('#four_pl_note_btn').click(function() {
                checked = $(".four_pl_orignial_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                    $(".four_pl_orignial_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                    });

                    $("#select_ids_note").val(my_array);

                    $("#edit_note_modal").modal('show');

                }
            });

            $('#rejoin_note_btn').click(function() {
                checked = $(".rejoin_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var ab = $('.rejoin_checkbox:checked').data('passport_id');
                    var my_array = [];

                    $(".rejoin_checkbox:checked").each(function(){
                        my_array.push($(this).attr("data-passport_id"));
                    });
                    // console.log(my_array);

                    $("#select_ids_notes").val(my_array);

                    $("#rejoin_note_modal").modal('show');

                }
            });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable_career, #datatable_career_referals, #rejoin_datatable').DataTable({
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Already Exist Data',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
            });

            $('#category').select2({
                placeholder: 'Select an option'
            });

        });



        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });

        $('tbody').on('click', '.view_remarks', function() {
            var  ids  = $(this).attr('id');

            $("#primary_ids").val(ids);
            $("#remarks_modal").modal('show');
        });

        $('tbody').on('click', '.enter_passport', function() {
            var  ids  = $(this).attr('id');

            $("#primary_id_for_passport").val(ids);
            $("#passport_modal").modal('show');


        });


        //send interview btn now

        $('tbody').on('click', '.send_interview_btn', function() {

            var ids  = $(this).attr('id');

             $("#select_ids_interview_single").val(ids);

            $.ajax({
                url: "{{ route('get_single_interview_by_package') }}",
                method: 'GET',
                data: {primary_id: ids},
                success: function(response) {


                    $("#append_single_interview").html("");
                    $("#append_single_interview").html(response.html);

                    $("#interview_single_modal").modal('show');



                    $('#batch_id_single').select2({
                        placeholder: 'Select an option'
                    });

                    $(".select2-container").css("width","100%");

                }
            });

        });




            $('body').on('change', '#batch_id_single', function() {
            var keyword  =   $(this).val();

            if(keyword!=null){
                $.ajax({
                    url: "batch_detail",
                    method: 'get',
                    data:{batch_id:keyword},
                    dataType: 'json',
                    success: function (response) {

                        $(".batch_detial_cls_single").show();

                        var array_ab = response
                        $("#interview_date_single").html(array_ab.interview_date);
                        $("#platform_name_single").html(array_ab.platform_name);

                        $("#interview_start_time_single").html(array_ab.start_time);
                        $("#interview_end_time_single").html(array_ab.end_time);
                        $("#interview_quantity_single").html(array_ab.quantity);



                    }
                });

            }


            });

        //send interview end



        // view detail start

        $('tbody').on('click', '.view_cls', function() {

            var ids  = $(this).attr('id');
            $("#detail_modal").modal('show');

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var platform_code = response['data'][i].platform_code;

                            $("#name_html").html(response['data'][i].name);
                            $("#email_html").html(response['data'][i].email);
                            $("#phone_html").html(response['data'][i].phone);
                            $("#whatsapp_html").html(response['data'][i].whatsapp);
                            $("#facebook_html").html(response['data'][i].facebook);
                            $("#vehicle_type_html").html(response['data'][i].vehicle_type);
                            $("#experiecne_html").html(response['data'][i].experience);

                            // $("#cv_attached_html").html(response['data'][i].cv);

                            if(response['data'][i].cv=="Not Found"){
                                $("#cv_attached_html").html("");
                                $("#cv_attached_not_found_html").html(response['data'][i].cv);
                            }else{
                                $("#cv_attached_not_found_html").html("");
                                $("#cv_attached_html").attr('href',response['data'][i].cv);
                                $("#cv_attached_html").html("see Image");
                            }



                            $("#license_status_html").html(response['data'][i].licence_status);
                            $("#license_status_vehicle_html").html(response['data'][i].licence_status_vehicle);
                            $("#license_no_html").html(response['data'][i].licence_no);
                            // $("#license_issue_html").html(response['data'][i].licence_issue);
                            // $("#license_expiry_html").html(response['data'][i].licence_expiry);
                            $("#license_issue_html").html(response['data'][i].traffic_code_no);
                            $("#license_city_name").html(response['data'][i].licence_city_name);

                            if(response['data'][i].licence_attach=="Not Found"){
                                $("#license_attach_html").html("");
                                $("#license_attach_not_found_html").html(response['data'][i].licence_attach);
                            }else{
                                $("#license_attach_not_found_html").html("");
                                $("#license_attach_html").attr('href',response['data'][i].licence_attach);
                                $("#license_attach_html").html("see Image");
                            }


                            $("#nationality_html").html(response['data'][i].nationality);
                            $("#dob_html").html(response['data'][i].dob);
                            $("#passport_no_html").html(response['data'][i].passport_no);
                            $("#passport_expiry_html").html(response['data'][i].passport_expiry);
                            // $("#passport_attach_html").html(response['data'][i].passport_attach);

                            if(response['data'][i].passport_attach=="Not Found"){
                                $("#passport_attach_html").html("");
                                $("#passport_attach_not_found_html").html(response['data'][i].passport_attach);
                            }else{
                                $("#passport_attach_not_found_html").html("");
                                $("#passport_attach_html").attr('href',response['data'][i].passport_attach);
                                $("#passport_attach_html").html("see Image");
                            }



                            $("#visa_status_html").html(response['data'][i].visa_status);
                            $("#visa_status_visit_html").html(response['data'][i].visa_status_visit);
                            $("#visa_status_cancel_html").html(response['data'][i].visa_status_cancel);
                            $("#visa_status_own_html").html(response['data'][i].visa_status_own);
                            $("#exit_date_html").html(response['data'][i].exit_date);
                            $("#company_visa_html").html(response['data'][i].company_visa);
                            $("#inout_transfer_html").html(response['data'][i].inout_transfer);
                            $("#platform_id_html").html(response['data'][i].platform_id);
                            $("#applied_cities").html(response['data'][i].cities);
                            $("#applicant_status_html").html(response['data'][i].applicant_status);
                            $("#remarks_html").html(response['data'][i].remarks);


                            // remarks hisotry start
                            var history_length = 0;
                            var career_history_html = "";

                            var tableBody = $("#table_history tbody");
                            tableBody.empty();

                            if(response['data'][i].career_history != null){
                                history_length = response['data'][i].career_history.length;
                                var remarks_ab = response['data'][i].career_history;
                                var json = jQuery.parseJSON(remarks_ab);

                                if(json != null){

                                    history_length = json.length;
                                    for(var k=0; k<history_length; k++){
                                        console.log("sdfsd"+json[k].remarks+"\n");
                                        var status = json[k].status;
                                        var status_label = "";
                                        if(status=="0"){
                                            status_label = "Not Verified";
                                        }else if(status=="1"){
                                            status_label = "Rejected";
                                        }else if(status=="2"){
                                            status_label = "Document Pending";
                                        }else if(status=="3"){
                                            status_label = "Short Listed";
                                        }

                                        var remark = json[k].remark;
                                        var remark_company = json[k].company_remark;
                                        var created_at =  json[k].created_at;
                                        var id =  json[k].id;
                                        var user_name =  json[k].user_name;



                                        var readmore = "";
                                        var newStr = "";
                                        if(remark != null){
                                            var length =  remark.length;
                                            if(parseInt(length)>25){
                                                readmore = "read more";
                                            }else{
                                                readmore = "";
                                            }
                                            newStr = remark.substring(0, 25);
                                        }

                                        var company_readmore = "";
                                        var company_string = "";
                                        if(remark_company != null){
                                            var length =  remark_company.length;
                                            if(parseInt(length)>25){
                                                company_readmore = "read more";
                                            }else{
                                                company_readmore = "";
                                            }
                                            company_string = remark_company.substring(0, 25);
                                        }



                                        career_history_html += history_table_append(status_label,newStr,id,created_at,user_name,readmore,company_string,company_readmore);
                                    }
                                    $("#table_history").append(career_history_html);
                                }
                                //null if end here



                            }
                            //remarks history end

                        }
                    }

                }
            });

            $.ajax({
                url: "{{ route('ajax_career_remark') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    // console.log(response);
                    if(response.length == 0){
                        data = `<div class="message flex-grow-1">
                            <div class="d-flex">
                                <p class="mb-0 text-title text-10 flex-grow-1"></p>
                            </div>
                                <p class="m-0">No Remarks</p>
                        </div><br>`;
                    $(".remark").append(data);
                    }

                    for (i = 0; i < response.length; i++) {
                    if(response[i].remarks){
                        if(response[i].career_category == "1"){
                            $career_category = "Frontdesk"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "2"){
                            $career_category = "Waitlist"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "3"){
                            $career_category = "Selected"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "4"){
                            $career_category = "Onboard"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "0"){
                            $career_category = "Reject"
                            $followup = ""
                        }
                data = `<div class="message flex-grow-1">
                            <div class="d-flex">
                                <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                                <span class="career_remark">${response[i].note_added_date}</span>
                            </div>
                                <p class="m-0">${response[i].remarks}</p>
                                <span class="m-0">(${$career_category}  ${$followup})</span>
                        </div><br>`;
                $(".remark").append(data);
                }}
                }
            });$(".remark").empty();


        });

        // view detail end


        $(".remarks_cls").click(function () {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_remarks') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });

        $('.modal_table').on('click', '.remarks_readmore', function() {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_read_more_remark') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });

        $('.modal_table').on('click', '.company_readmore', function() {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_read_more_company_remark') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });

    </script>

    <script>
        $("#batch_id").change(function () {

            var keyword  =   $(this).val();

            if(keyword!=null){

                $.ajax({
                    url: "batch_detail",
                    method: 'get',
                    data:{batch_id:keyword},
                    dataType: 'json',
                    success: function (response) {

                        $(".batch_detial_cls").show();

                        var array_ab = response



                        $("#interview_date").html(array_ab.interview_date);
                        $("#platform_name").html(array_ab.platform_name);

                        $("#interview_start_time").html(array_ab.start_time);
                        $("#interview_end_time").html(array_ab.end_time);
                        $("#interview_quantity").html(array_ab.quantity);



                    }
                });

            }


        });
        </script>

    <script>
        $('#selected_btn').click(function() {
            checked = $(".company_checkbox:checked").length;
            var pkg_id = $('#first_pkg').find('option:selected').val();

            // if(pkg_id==""){
            //     tostr_display("error","please select the option from dropdown.!");
            //     return false
            // }

            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];

                $(".original_company_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });


                //  for package work start

                // $("#select_ids_interview").val(my_array);
                // $("#interview_modal_single").modal('show');
                // $(".message_div").hide();
                // $("#type_for_rejoin_single").val("0");
                // $("#select_ids_interview_single").val(my_array);

                //  for package work end



                // not for package work start
                $("#select_ids_interview").val(my_array);
                $("#interview_modal").modal('show');
                $(".select2-container").css("width","100%");
                // not for package end




              //  for package work start

                // $.ajax({
                //     url: "{{ route('get_single_interview_by_package') }}",
                //     method: 'GET',
                //     data: {pkg_id: pkg_id},
                //     success: function(response) {


                //         $("#append_single_interview").html("");
                //         $("#append_single_interview").html(response.html);

                //         $("#interview_single_modal").modal('show');



                //         $('#batch_id_single').select2({
                //             placeholder: 'Select an option'
                //         });

                //         $(".select2-container").css("width","100%");

                //     }
                // });

                  //  for package work start




            }
        });

        $('#four_pl_selected_btn').click(function() {

            // without package work start

            checked = $(".four_pl_checkbox:checked").length;
            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];

                $(".four_pl_orignial_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });

                $("#select_ids_interview").val(my_array);
                $(".message_div").hide();
                $("#type_for_rejoin").val("0");
                $("#interview_modal").modal('show');


            }

            // without package work end




            //for package work  start

            // var pkg_id = $('#second_pkg').find('option:selected').val();

            // if(pkg_id==""){
            //     tostr_display("error","please select the option from dropdown.!");
            //     return false
            // }
            // checked = $(".four_pl_checkbox:checked").length;
            // if(!checked) {
            //     tostr_display("error","You must check at least one checkbox.");
            //     return false;
            // }else{
            //     var my_array = [];

            //     $(".four_pl_orignial_checkbox:checked").each(function(){
            //         my_array.push($(this).val());
            //     });


            //     $("#select_ids_interview_single").val(my_array);

            //     $(".message_div").hide();
            //     $("#type_for_rejoin_single").val("0");

            //     $.ajax({
            //         url: "{{ route('get_single_interview_by_package') }}",
            //         method: 'GET',
            //         data: {pkg_id: pkg_id},
            //         success: function(response) {


            //             $("#append_single_interview").html("");
            //             $("#append_single_interview").html(response.html);

            //             $("#interview_single_modal").modal('show');
            //             $('#batch_id_single').select2({
            //                 placeholder: 'Select an option'
            //             });

            //             $(".select2-container").css("width","100%");

            //         }
            //     });
            // }


              //for package work end


        });

        $('#rejoin_selected_btn').click(function() {
            checked = $(".rejoin_checkbox:checked").length;
            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];

                $(".rejoin_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });

                $("#select_ids_interview").val(my_array);
                $(".message_div").hide();
                $("#type_for_rejoin").val("1");
                $("#interview_modal").modal('show');


            }
        });

        </script>

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
        function tabs_table(priority='',color='',table_id=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_filter_color') }}",
                method: 'POST',
                data: {color: color, priority :priority, _token:token},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#'+table_id).DataTable();
                    table.destroy();

                    // $("#datatable_first_priority .filtering_source_from select").remove();
                    $('#'+table_id+' .filtering_source_from select').remove();
                    $('#'+table_id+' tbody').empty();
                    $('#'+table_id+' tbody').append(response.html);

                    var table = $('#'+table_id).DataTable(
                        {
                            initComplete: function () {
                                let filtering_columns = []
                                $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                                    filtering_columns.push(v.cellIndex+1)
                                });
                                this.api().columns(filtering_columns).every( function () {
                                    var column = this;
                                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                                        .appendTo( $(column.header()) )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );

                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                } );
                            },
                            "aaSorting": [],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
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
                            "scrollY": false,
                            "scrollX": false,
                        }
                    );
                    $(".display").css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });

        }
    </script>


    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab



                if(currentTab=="home-basic-tab"){
                    // tabs_table("document_pending","","datatable_career");
                    // get_color_block_count("document_pending","first_priority_hours_24_block","first_priority_hours_48_block","first_priority_hours_72_block","first_priority_less_24_block");

                    var table_exist =  $('#datatable_career').DataTable();
                    table_exist.destroy();
                    $('#datatable_career select').remove();
                    // if( $.fn.DataTable.isDataTable( '#datatable_second_priority' ) ) {
                    //     $("#datatable_second_priority").dataTable().fnDestroy();
                    //     $('#datatable_second_priority').empty();
                    // }

                    var table = $('#datatable_career').DataTable(
                        {
                            initComplete: function () {
                                let filtering_columns = []
                                $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                                    filtering_columns.push(v.cellIndex+1)
                                });
                                this.api().columns(filtering_columns).every( function () {
                                    var column = this;
                                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                                        .appendTo( $(column.header()) )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );

                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                } );
                            },

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

                            "aaSorting": [],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                                { "width": 150, "targets": [8] },
                                { "width": 110, "targets": [7] },
                                { "width": 110, "targets": [6] },
                            ],

                            scrollY: false,
                            scrollX: true,

                        }

                    );
                    $('#container').css( 'display', 'block' );
                    $(".display").css("width","100%");
                    $("#datatable_career tbody").css("width","100%");
                    table.columns.adjust().draw();


                }else if(currentTab=="profile-basic-tab"){


                    var table_exist =  $('#datatable_career_referals').DataTable();
                    table_exist.destroy();
                    $('#datatable_career_referals select').remove();
                    // if( $.fn.DataTable.isDataTable( '#datatable_second_priority' ) ) {
                    //     $("#datatable_second_priority").dataTable().fnDestroy();
                    //     $('#datatable_second_priority').empty();
                    // }

                    var table = $('#datatable_career_referals').DataTable(
                        {
                            initComplete: function () {
                                let filtering_columns = []
                                $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                                    filtering_columns.push(v.cellIndex+1)
                                });
                                this.api().columns(filtering_columns).every( function () {
                                    var column = this;
                                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                                        .appendTo( $(column.header()) )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );

                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                } );
                            },

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

                            "aaSorting": [],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                                { "width": 150, "targets": [8] },
                                { "width": 110, "targets": [7] },
                                { "width": 110, "targets": [6] },
                            ],

                            scrollY: false,
                            scrollX: true,

                        }

                    );
                    $('#container').css( 'display', 'block' );
                    $(".display").css("width","100%");
                    $("#datatable_career_referals tbody").css("width","100%");
                    table.columns.adjust().draw();

                }else if(currentTab=="rejoin-tab"){


                    var table_exist =  $('#rejoin_datatable').DataTable();
                    table_exist.destroy();
                    $('#rejoin_datatable select').remove();
                    // if( $.fn.DataTable.isDataTable( '#datatable_second_priority' ) ) {
                    //     $("#datatable_second_priority").dataTable().fnDestroy();
                    //     $('#datatable_second_priority').empty();
                    // }

                    var table = $('#rejoin_datatable').DataTable(
                        {
                            initComplete: function () {
                                let filtering_columns = []
                                $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                                    filtering_columns.push(v.cellIndex+1)
                                });
                                this.api().columns(filtering_columns).every( function () {
                                    var column = this;
                                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                                        .appendTo( $(column.header()) )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );

                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                } );
                            },

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

                            "aaSorting": [],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                                { "width": 150, "targets": [8] },
                                { "width": 110, "targets": [7] },
                                { "width": 110, "targets": [6] },
                            ],

                            scrollY: false,
                            scrollX: true,

                        }

                    );
                    $('#container').css( 'display', 'block' );
                    $(".display").css("width","100%");
                    $("#rejoin_datatable tbody").css("width","100%");
                    table.columns.adjust().draw();

                }



            }) ;
        });

    </script>

    <script>
        $("#checkAll").click(function () {
            $('.company_checkbox').not(this).prop('checked', this.checked);
        });

        $("#four_pl_checkAll").click(function () {
            $('.four_pl_checkbox').not(this).prop('checked', this.checked);
        });
        $("#rejoin_checkAll").click(function () {
            $('.rejoin_checkbox').not(this).prop('checked', this.checked);
        });

    </script>


    <script>
        $('tbody').on('click', '.view_passport_detail_btn', function() {

            var ids  = $(this).attr('id');
            $("#passport_detail_modal").modal('show');

            var ids = $(this).attr('id');
            var passort_id = $(this).data("passport_id");
            console.log(passort_id);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('rejoin_ajax_passport_detail') }}",
                method: 'get',
                dataType: 'json',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    $('.modal_body_cls').html("");
                    $('.modal_body_cls').html(response.html);

                }
            });

            $.ajax({
                url: "{{ route('ajax_career_remark_rejoin') }}",
                method: 'POST',
                data: {primary_id: passort_id ,_token:token},
                success: function(response) {
                    // console.log(response);
                    if(response.length == 0){
                        data = `<div class="message flex-grow-1">
                            <div class="d-flex">
                                <p class="mb-0 text-title text-10 flex-grow-1"></p>
                            </div>
                                <p class="m-0">No Remarks</p>
                        </div><br>`;
                    $(".remark").append(data);
                    }

                    for (i = 0; i < response.length; i++) {
                    if(response[i].remarks){
                        if(response[i].career_category == "1"){
                            $career_category = "Frontdesk"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "2"){
                            $career_category = "Waitlist"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "3"){
                            $career_category = "Selected"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "4"){
                            $career_category = "Onboard"
                            $followup = response[i].followup_name
                        }else if(response[i].career_category == "0"){
                            $career_category = "Reject"
                            $followup = ""
                        }
                data = `<div class="message flex-grow-1">
                            <div class="d-flex">
                                <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                                <span class="career_remark">${response[i].note_added_date}</span>
                            </div>
                                <p class="m-0">${response[i].remarks}</p>
                                <span class="m-0">(${$career_category}  ${$followup})</span>
                        </div><br>`;
                $(".remark").append(data);
                }}
                }
            });$(".remark").empty();


        });
        </script>








    <script>
        function history_table_append(status,remarks,id,created_at,Name,readmore,company_remark,company_readmore){
            var html = '<tr><td>'+status+'</td><td>'+remarks+'<br> <a href="javascript:void(0)" id="'+id+'" class="remarks_readmore">'+readmore+'</a></td>  <td>'+company_remark+'<br> <a href="javascript:void(0)" id="'+id+'" class="company_readmore">'+company_readmore+'</a></td>     <td>'+created_at+'</td><td>'+Name+'</td></tr>';

            return html;
        }

    </script>




    <script>
        function first_priority_filter_color(priority='',color=''){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_filter_color') }}",
                method: 'POST',
                data: {color: color, priority :priority, _token:token},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#datatable_career').DataTable();
                    table.destroy();

                    $('#datatable_career tbody').empty();
                    $('#datatable_career tbody').append(response.html);

                    var table = $('#datatable_career').DataTable(
                        {

                            "aaSorting": [[0, 'desc']],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
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
                            "scrollY": false,
                            "scrollX": true,
                        }
                    );
                    $(".display").css("width","100%");
                    // $('#datatable_career tbody').css("width","100%");
                    // $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }


        function referal_priority_filter_color(priority='',color=''){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_filter_color') }}",
                method: 'POST',
                data: {color: color, priority :priority, _token:token},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#datatable_career_referals').DataTable();
                    table.destroy();

                    $('#datatable_career_referals tbody').empty();
                    $('#datatable_career_referals tbody').append(response.html);

                    var table = $('#datatable_career_referals').DataTable(
                        {

                            "aaSorting": [[0, 'desc']],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
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
                            "scrollY": false,
                            "scrollX": true,
                        }
                    );
                    $(".display").css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }


    </script>


    <script>
        // this is the id of the form
        $("#sent_interview_form").submit(function(e) {
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
                        tostr_display("success","interview sent Successfully");

                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);
                        // alert("agreement is submitted");
                    }else if(response=="Exceed"){
                        $(".message_div_exceed").show();
                        $("#error_exceed").html("Batch Range Exceeded");
                    }else{
                        $(".message_div").show();
                        $("#error_name").html(response);
                        // tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });


                // single form interview
                $("#sent_interview_single_form").submit(function(e) {
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
                                tostr_display("success","interview sent Successfully");

                                window.setTimeout(function(){
                                    location.reload(true)
                                },1000);
                                // alert("agreement is submitted");
                            }else if(response=="Exceed"){
                                $(".message_div_exceed").show();
                                $("#error_exceed_single").html("Batch Range Exceeded");
                            }else{
                                $(".message_div").show();
                                $("#error_name_single").html(response);
                                // tostr_display("error",response);
                                // alert(response);
                            }
                            // alert("form_submitted"); // show response from the php script.
                        }
                    });
                });





    </script>
    {{--    ajax form end--}}





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

                setTimeout(function () {
                    $("#name_header").click();
                    // alert("working");
                }, 500);
            }
        });
    </script>


    <script>
        $('#email_btn').click(function() {
                checked = $(".company_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    var my_arrays = [];

                    $(".original_company_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                        $("#select_ids").val(my_array);
                    });

                    $(".original_company_checkbox:checked").each(function(){
                        my_arrays.push($(this).attr("data-email"));
                    });

                    $("#select_ids_email").val(my_arrays);

                    $("#email_note").val("");

                    $("#edit_email_modal").modal('show');

                }
            });

            $('#email_btnto').click(function() {
                checked = $(".four_pl_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    var my_arrays = [];

                    $("input[type=checkbox]:checked").each(function(){
                        my_array.push($(this).val());
                        $("#select_ids").val(my_array);
                    });

                    $("input[type=checkbox]:checked").each(function(){
                        my_arrays.push($(this).attr("data-email"));
                    });

                    $("#select_ids_email").val(my_arrays);

                    $("#email_note").val("");

                    $("#edit_email_modal").modal('show');

                }
            });
    </script>

    <script>

        $("#search_city_id").change(function () {

            var city_id = $(this).val();
            var paltform_id = $( "#search_platform_id option:selected" ).val();
            var token = $("input[name='_token']").val();
            $("#batch_id").empty();
            $.ajax({
                url: "{{ route('get_city_wise_batch_interview') }}",
                method: 'POST',
                dataType: 'json',
                data: {platform_id: paltform_id,city_id: city_id, _token:token},
                success: function(response) {
                    // $("#status_id").val(response);

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            add_dynamic_opton(response[i].id,response[i].reference_number);
                        }
                    }
                }
            });

        });

        $("#search_platform_id").change(function () {

            var paltform_id = $(this).val();
            var city_id = $( "#search_city_id option:selected" ).val();
            var token = $("input[name='_token']").val();
            $("#batch_id").empty();
            $.ajax({
                url: "{{ route('get_city_wise_batch_interview') }}",
                method: 'POST',
                dataType: 'json',
                data: {platform_id: paltform_id,city_id: city_id, _token:token},
                success: function(response) {
                    // $("#status_id").val(response);

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            add_dynamic_opton(response[i].id,response[i].reference_number);
                        }
                    }
                }
            });

        });


        function add_dynamic_opton(id,text_ab){



            if ($('#platform_id').find("option[value='"+id+"']").length) {
                // $('#visa_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default
                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#batch_id').append(newOption);
            }
            $('#batch_id').val(null).trigger('change');
        }
    </script>

@endsection
