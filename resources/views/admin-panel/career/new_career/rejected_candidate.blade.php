
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        /*.dataTables_info{*/
        /*    display:none;*/
        /*}*/
        .font_size_cls{
            font-size: 17px !important;
            cursor: pointer;
        }
        .view_cls i{
            font-size: 15px !important;
        }
        .enter_driving_licence i{
            font-size: 13px !important;
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

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }

        .image-upload > input
        {
            display: none;
        }

        .image-upload i
        {
            cursor: pointer;
        }
        .hide_cls{
            display: none;
        }
        .modals-lg {
            max-width: 70% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        }
    </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Rejected Candidate</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



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

                        </div></div>
                    <div class="col-md-4">
                        <h6><b>Remarks</b></h6>
                        <div class="card chat-sidebar-container" data-sidebar-container="chat"   style="background-color: #9de0f6;margin-right: 15px;">
                            <div class="chat-content-wrap" data-sidebar-content="chat">
                                <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


                                </div>

                            </div>
                        </div>
                    </div></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--    passport detail modal end--}}


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('career.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status For Rider</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select Status</label>

                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="0">Not Verified</option>
                                    <option value="1">Rejected</option>

                                    <option value="2">Short Listed</option>
                                    {{--                                    <option value="2">Document Pending</option>--}}
                                    {{--                                    <option value="3">Short Listed</option>--}}
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

    <!-- change the status Modal -->
    <div class="modal fade bd-example-modal-sm"  id="edit_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Change Status</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('update_career_status_from_rejected') }}" method="POST">
                    @csrf
                    <input type="hidden" name="change_status_id" id="change_status_id"  >
                    <input type="hidden" name="request_type" id="request_type"  >
                    <input type="hidden" name="from_rejected" id="from_rejected" value="1" >
                    <input type="hidden" name="select_ids_career" id="select_ids_career" value="1" >

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control" id="follow_up_status" name="follow_up_status" >
                                    <option value="" selected disabled>select an option</option>
                                    <option id="selected_option" value="4">Selected</option>
                                    <option  id="waitlist_option" value="5">Wait List</option>
                                    <option  id="front_end_option" value="0">Front Desk</option>
{{--                                    <option value="1">Reject</option>--}}
                                </select>
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
    </div><!-- end changes status modal -->



        <!-- change the status rejoin Modal -->
        <div class="modal fade bd-example-modal-sm"  id="edit_note_modal_rejoin"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Change Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <form action="{{ route('update_career_status_from_rejected_for_rejoin') }}" method="POST">
                        @csrf
                        <input type="hidden" name="change_status_id" id="change_status_id_rejoin"  >
                        <input type="hidden" name="request_type" id="request_type_rejoin"  >
                        <input type="hidden" name="from_rejected" id="from_rejected_rejoin" value="1" >
                        <input type="hidden" name="select_ids_career" id="select_ids_career_rejoin" value="1" >

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <select class="form-control" id="follow_up_status_rejoin" name="follow_up_status" >
                                        <option value="" selected disabled>select an option</option>
                                        <option id="selected_option_rejoin" value="4">Selected</option>
                                        <option  id="waitlist_option_rejoin" value="5">Wait List</option>
                                        <option  id="front_end_option_rejoin" value="0">Front Desk</option>
    {{--                                    <option value="1">Reject</option>--}}
                                    </select>
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
        </div><!-- end changes status rejoin modal -->




    {{--    view Detail modal--}}
    <div class="modal fade bd-example-modals-lg" id="detail_modal"   tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    <tr>
                                        <th>Employee Type</th>
                                        <td><span id="employee_type_html"></span></td>
                                    </tr>

                                    <tr class="fourpl_name_cls">
                                        <th>Four Pl Name</th>
                                        <td><span id="four_pl_name_html"></span></td>
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

                            <h6 class="remarks" >
                                Remarks
                            </h6>
                            <p  id="remarks_html"></p>


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
                                        <th>Applying For</th>
                                        <td><span id="vehicle_type_html"></span></td>
                                    </tr>



                                    <tr>
                                        <th>Licence number</th>
                                        <td><span id="license_no_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Traffic code number</th>
                                        <td><span id="license_issue_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Licence City Name</th>
                                        <td><span id="license_city_name"></span></td>
                                    </tr>

                                    {{--                                    <tr>--}}
                                    {{--                                        <th>Licence Expiry</th>--}}
                                    {{--                                        <td><span id="license_expiry_html"></span></td>--}}
                                    {{--                                    </tr>--}}

                                    {{--                                    <tr>--}}
                                    {{--                                        <th>Licence Front Pic</th>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <a  href="" id="license_attach_html" target="_blank"></a>--}}
                                    {{--                                            <span id="license_attach_not_found_html"></span>--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}

                                    {{--                                    <tr>--}}
                                    {{--                                        <th>Licence Back Pic</th>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <a  href="" id="license_back_html" target="_blank"></a>--}}
                                    {{--                                            <span id="license_back_not_found_html"></span>--}}
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

                                    <tr>
                                        <th>Inout transfer</th>
                                        <td><span id="inout_transfer_html"></span></td>
                                    </tr>

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



                            <div class="table-responsive modal_table">
                                <h6>Promotion Detail</h6>
                                <table class="table table-bordered table-striped">


                                    <tr>
                                        <th>How Did He Heared About</th>
                                        <td><span id="promotion_type_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Social Media Account Name</th>
                                        <td><span id="social_medial_id_name"></span></td>
                                    </tr>

                                    <tr id="other_source_name_row">
                                        <th>Other Source Name</th>
                                        <td><span id="other_source_name"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Source Type</th>
                                        <td><span id="source_type"></span></td>
                                    </tr>



                                </table>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <h6><b>Remarks Gamer</b></h6>
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


    {{--    edit Detail modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('update_the_career',1) }}" method="POST" id="edit_from">
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" id="edit_primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive modal_table">
                                    <h6>Personal Detail</h6>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <td><input type="text" name="edit_name" class="w-100" id="edit_name_html"></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><input type="email" name="edit_email" class="w-100"  id="edit_email_html"></td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td><input type="text" name="edit_phone"  id="edit_phone_html" class="w-100" ></td>
                                        </tr>

                                        <tr>
                                            <th>Date Of Birth</th>
                                            <td><input type="text" name="edit_dob" class="w-100"  id="edit_dob_html"></td>
                                        </tr>

                                        <tr>
                                            <th>Whats App</th>
                                            <td><input type="text" name="edit_whatsapp" id="edit_whatsapp_html" class="w-100"></td>
                                        </tr>

                                        <tr>
                                            <th>Social media Id</th>
                                            <td><input type="text" name="edit_social_media_id" id="edit_facebook_html" class="w-100" ></td>
                                        </tr>


                                    </table>
                                </div>


                                <div class="table-responsive modal_table">
                                    <h6>Passport Detail</h6>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Nationality</th>
                                            <td><input type="text" name="edit_nation" class="w-100" id="edit_nationality_html"></td>
                                        </tr>

                                        <tr>
                                            <th>Passport Number</th>
                                            <td><input  class="w-100"  name="edit_passport" id="edit_passport_no_html"></td>
                                        </tr>

                                        <tr>
                                            <th>Passport Expiry</th>
                                            <td><input class="w-100" name="edit_passport_expiry" id="passport_expiry_html"></td>
                                        </tr>


                                    </table>
                                </div>


                            </div>

                            <div class="col-md-6">
                                <div class="table-responsive modal_table">
                                    <h6>License Detail</h6>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>License Status</th>
                                            <td>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-success">
                                                        <input type="radio"  class="license_status_cls"  id="license_status_yes" value="1" name="license_status"><span>Yes</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio" class="license_status_cls"   id="license_status_no"  value="2" name="license_status"><span>No</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Which License you have.?</th>
                                            <td>

                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-success">
                                                        <input type="radio"  id="edit_bike_license" name="license_type" class="license_status_cls"  value="1" ><span>Bike</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-success">
                                                        <input type="radio" id="edit_car_license"  name="license_type" value="2" class="license_status_cls"  ><span>Car</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-success">
                                                        <input type="radio" id="edit_both_license"  name="license_type" value="3"  ><span>Both</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                                <div class="table-responsive modal_table">
                                    <h6>Visa Detail</h6>
                                    <table class="table table-bordered table-striped">


                                        <tr>
                                            <br>
                                            <th>Employee Type</th>
                                            <td>
                                                <br>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  value="1" name="employee_type"  class="employe_type_cls"  id="company_employee_type" ><span>Company</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  value="2" name="employee_type"    class="employe_type_cls"   id="four_pl_employee_type"><span>Four PL</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                            </td>
                                        </tr>


                                        <tr class="four_pl_cls ">
                                            <th>Four Pl Name</th>
                                            <td>
                                                <select class="form-control select" id="four_pl_name_id" name="four_pl_name_id" >
                                                    <option value="" disabled selected>select an option</option>
                                                    @foreach($fourpls as $four)
                                                        <option value="{{ $four->id }}">{{ $four->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>



                                        <tr class="visa_status_cls">
                                            <th>Visa Status</th>
                                            <td>

                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-success">
                                                        <input type="radio" class="license_type_cls"  id="edit_visit_visa" value="1" name="visa_status"><span>Visit Visa</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"   value="2" id="cancel_visit_visa" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  value="3"  id="own_visit_visa" name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <br>
                                            </td>
                                        </tr>

                                        <tr class="edit_visa_visit_block">
                                            <th>Visa Status</th>
                                            <td>
                                                <div class="form-check-inline edit_visa_visit_block ">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio" class="license_type_cls"  value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline edit_visa_visit_block ">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio" class="license_type_cls" value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="edit_cancel_visit_block">
                                            <th>Cancel Visa</th>
                                            <td>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  id="visa_free_zone"  value="1" name="edit_cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"   id="visa_company_visa"  value="2" name="edit_cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr  class="edit_own_visit_block">
                                            <th>Own Visa</th>
                                            <td>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="radio radio-outline-primary">
                                                        <input type="radio"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                                    </label>
                                                </div>

                                            </td>
                                        </tr>


                                        <tr>
                                            <th>PlatForm</th>
                                            <td>
                                                <select class="form-control select multi-select" id="platform_id" name="platform_id[]" multiple="multiple">
                                                    @foreach($platforms as $plat)
                                                        <option value="{{ $plat->id }}">{{ $plat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Applied cities</th>
                                            <td>
                                                <select class="form-control select multi-select" id="cities" name="cities[]" multiple="multiple">
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Shirt Size</th>
                                            <td>
                                                <select class="form-control" id="shirt_size" name="shirt_size" >
                                                    <option value="" selected disabled>select an option</option>
                                                    @foreach($shirt_size as $size)
                                                        <option value="{{ $size }}">{{ $size }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Waist Size</th>
                                            <td>
                                                <select class="form-control" id="waist_size" name="waist_size" >
                                                    <option value="" selected disabled>select an option</option>
                                                    @foreach($waist_size as $size)
                                                        <option value="{{ $size }}">{{ $size }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>



                                    </table>
                                </div>

                            </div>
                        </div>
                        <input  class="btn btn-secondary" type="submit" value="Update">

                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    edit Detail modal end--}}

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
                    <input type="hidden" name="category"  value="2">
                    <input type="hidden" name="checkbox_array" id="select_ids_note" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" >
                                    <option value="" selected disabled>select an option</option>
                                    @foreach(follow_up_names() as $id => $label)
                                        <option value="{{ $id }}">{{ $label ?? "" }}</</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_cls">
                                <input class="form-control" id="date" name="date" value="" type="text" placeholder="Next Follow up Date"  />
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

    <!--  search modal -->
    <div class="modal fade bd-example-modal-lg"  id="seatch_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('search_result_career_wait_list') }}" method="POST" id="search_form" enctype="multipart/form-data">
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

    <div class="col-md-12">
        <button class="btn btn-dark btn-icon m-1 text-white btn_category active" id="normal_candidate" type="button"><span class="ul-btn__icon"><i class="i-Search-People"></i></span><span class="ul-btn__text">Normal Candidate</span></button>
        <button class="btn btn-dark btn-icon m-1 text-white btn_category" id="rejoin_candidate" type="button"><span class="ul-btn__icon"><i class="i-Find-User"></i></span><span class="ul-btn__text">Rejoin Candidate</span></button>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body append_main_div">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active"  data-status="0" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Rejected From Front Desk</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="5"  id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">Rejected From Wait List</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="4" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejected From Selected</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="333" id="onboard-basic-tab" data-toggle="tab" href="#onboardTab" role="tab" aria-controls="onboardTab" aria-selected="false">Rejected From Onboard</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="other" id="other-basic-tab" data-toggle="tab" href="#otherTab" role="tab" aria-controls="otherTab" aria-selected="false">Rejected From Other Area</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="forntdesk_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>

                                </thead>
                                <tbody>


                                @foreach($careers as $career)
                                    <tr id="row-{{ $career->id }}">
                                        <td>
                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="company_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
                                        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
                                        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
                                        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

                                        <td>
                                            @if (isset($career->follow_up_status))
                                                @if ($career->follow_up_status == "1")
                                                    Interested
                                                @elseif ($career->follow_up_status == "2")
                                                    Call Me Tomorrow
                                                @elseif ($career->follow_up_status == "3")
                                                    No Response
                                                @elseif ($career->follow_up_status == "4")
                                                    Not Interested
                                                @elseif ($career->follow_up_status == "0")
                                                    Not Verified
                                                @endif
                                            @endif
                                        </td>

                                        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}
                                        <?php  $created_at = explode(" ", $career->created_at);?>

                                        <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
                                        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
                                        <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
                                        <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            |

                                            @if(isset($career->passport_ppuid))
                                                        @if($career->cancel_status=="1")
                                                        <h4 class="badge badge-danger">PPUID Cancelled</h4>
                                                        @else
                                                        <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                                        @endif
                                             @else
                                             <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                             @endif


                                        </td>
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--first tab work finished--}}
                    <div class="tab-pane fade show " id="new_taken" role="tabpanel" aria-labelledby="home-basic-new_taken">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="waitlist_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_waitlist"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                    {{--                    second tab work finished--}}

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="selected_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_selected"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--                    third tab work finished--}}

                    <div class="tab-pane fade show" id="onboardTab" role="tabpanel" aria-labelledby="onboard-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="onboard_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_onboard"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>   {{-- fourth tab work finished--}}

                    <div class="tab-pane fade show" id="otherTab" role="tabpanel" aria-labelledby="other-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="other_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_other"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>   {{-- fourth tab work finished--}}

                </div>



            </div>
        </div>
    </div>

    <div class="overlay"></div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    {{--    dist-assets/js/scripts/tooltip.script.min.js--}}

    <script>

        function licence_city_function(){

            $("#licence_city").select2({
                ajax: {
                    url: "{{ route('search_city_json') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for City',
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

        }


        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'>"+repo.name+"</div>" +
                // "<div class='select2-result-repository__description'>"+repo.passport_no+"</div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            return $container;
        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }
    </script>

   <script>
       $('body').on('click', '.change_status_cls', function() {

           var ids = $(this).attr('id');
           var now_id = ids.split("-");

           var past_status = $(this).attr('data-status');

           if(past_status=="0"){
               $("#front_end_option").show();
            $("#selected_option").hide();
            $("#waitlist_option").hide();
          }else if(past_status=="4") {
               $("#selected_option").show();
               $("#waitlist_option").hide();
               $("#front_end_option").hide();
           }else if(past_status=="5"){
               $("#waitlist_option").show();
               $("#selected_option").hide();
               $("#front_end_option").hide();
           }else if(past_status=="333") {
               $("#selected_option").show();
               $("#waitlist_option").hide();
               $("#front_end_option").hide();
           }else if(past_status=="other") {
               $("#front_end_option").show();
               $("#selected_option").hide();
               $("#waitlist_option").hide();
           }
           else{
               $("#front_end_option").show();
               $("#selected_option").hide();
               $("#waitlist_option").hide();
           }


           $("#request_type").val("1");
           $("#change_status_id").val(now_id[1]);

           $("#from_rejected").val("1");

           $("#edit_note_modal").modal("show");
       });

       $('body').on('click', '.change_status_cls_rejoin', function() {

                var ids = $(this).attr('id');
                var now_id = ids.split("-");

                var past_status = $(this).attr('data-status');

                if(past_status=="0"){
                    $("#front_end_option_rejoin").show();
                $("#selected_option_rejoin").hide();
                $("#waitlist_option_rejoin").hide();
                }else if(past_status=="4") {
                    $("#selected_option_rejoin").show();
                    $("#waitlist_option_rejoin").hide();
                    $("#front_end_option_rejoin").hide();
                }else if(past_status=="5"){
                    $("#waitlist_option_rejoin").show();
                    $("#selected_option_rejoin").hide();
                    $("#front_end_option_rejoin").hide();
                }else if(past_status=="333") {
                    $("#selected_option_rejoin").show();
                    $("#waitlist_option_rejoin").hide();
                    $("#front_end_option_rejoin").hide();
                }else if(past_status=="other") {
                    $("#front_end_option_rejoin").show();
                    $("#selected_option_rejoin").hide();
                    $("#waitlist_option_rejoin").hide();
                }
                else{
                    $("#front_end_option_rejoin").hide();
                    $("#selected_option_rejoin").hide();
                    $("#waitlist_option_rejoin").show();
                }


                $("#request_type_rejoin").val("1");
                $("#change_status_id_rejoin").val(now_id[1]);

                $("#from_rejected_rejoin").val("1");

                $("#edit_note_modal_rejoin").modal("show");
        });


       </script>


    <script>
        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });


        $('body').on('click', '.view_cls', function() {

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
                            $("#promotion_type_html").html(response['data'][i].promotion_type);
                            if(response['data'][i].promotion_others==""){
                                $("#other_source_name").hide();
                                $("#other_source_name_row").hide();
                                $("#social_medial_id_name").show();
                                $("#social_medial_id_name").html(response['data'][i].social_media_id_name);
                            }else{
                                $("#social_medial_id_name").hide();
                                $("#other_source_name_row").show();
                                $("#other_source_name").show();
                                $("#other_source_name").html(response['data'][i].promotion_others);
                            }
                            $("#source_type").html(response['data'][i].source_type);




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

                            $("#employee_type_html").html(response['data'][i].employee_type);
                            if(response['data'][i].four_pl_name=="0"){
                                $(".fourpl_name_cls").hide();
                            }else{
                                $(".fourpl_name_cls").show();
                                $("#four_pl_name_html").html(response['data'][i].four_pl_name);
                            }



                            $("#license_status_html").html(response['data'][i].licence_status);
                            $("#license_status_vehicle_html").html(response['data'][i].licence_status_vehicle);
                            $("#license_no_html").html(response['data'][i].licence_no);
                            $("#license_issue_html").html(response['data'][i].traffic_code_no);
                            $("#license_expiry_html").html(response['data'][i].licence_expiry);
                            $("#license_city_name").html(response['data'][i].licence_city_name);

                            if(response['data'][i].licence_attach=="Not Found"){
                                $("#license_attach_html").html("");
                                $("#license_attach_not_found_html").html(response['data'][i].licence_attach);

                                $("#license_back_html").html("");
                                $("#license_back_not_found_html").html(response['data'][i].licence_attach_back);
                            }else{
                                $("#license_attach_not_found_html").html("");
                                $("#license_attach_html").attr('href',response['data'][i].licence_attach);
                                $("#license_attach_html").html("see Image");

                                $("#license_back_not_found_html").html("");
                                $("#license_back_html").attr('href',response['data'][i].licence_attach_back);
                                $("#license_back_html").html("see Image");
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

                        if(response[i].remarks !== "sent to selected from frontdesk"){

                            data = `<div class="message flex-grow-1">
                            <div class="d-flex">
                                <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                                <span class="career_remark">${response[i].note_added_date}</span>
                            </div>
                                <p class="m-0">${response[i].remarks}</p>
                                <span class="m-0">(${$career_category}  ${$followup})</span>
                        </div><br>`;
                            $(".remark").append(data);

                        }



                        }}
                }
            });$(".remark").empty();


        });



        //rejoin candidate



        $('body').on('click', '.view_cls_rejoin', function() {

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
                                $("#promotion_type_html").html(response['data'][i].promotion_type);
                                if(response['data'][i].promotion_others==""){
                                    $("#other_source_name").hide();
                                    $("#other_source_name_row").hide();
                                    $("#social_medial_id_name").show();
                                    $("#social_medial_id_name").html(response['data'][i].social_media_id_name);
                                }else{
                                    $("#social_medial_id_name").hide();
                                    $("#other_source_name_row").show();
                                    $("#other_source_name").show();
                                    $("#other_source_name").html(response['data'][i].promotion_others);
                                }
                                $("#source_type").html(response['data'][i].source_type);




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

                                $("#employee_type_html").html(response['data'][i].employee_type);
                                if(response['data'][i].four_pl_name=="0"){
                                    $(".fourpl_name_cls").hide();
                                }else{
                                    $(".fourpl_name_cls").show();
                                    $("#four_pl_name_html").html(response['data'][i].four_pl_name);
                                }



                                $("#license_status_html").html(response['data'][i].licence_status);
                                $("#license_status_vehicle_html").html(response['data'][i].licence_status_vehicle);
                                $("#license_no_html").html(response['data'][i].licence_no);
                                $("#license_issue_html").html(response['data'][i].traffic_code_no);
                                $("#license_expiry_html").html(response['data'][i].licence_expiry);
                                $("#license_city_name").html(response['data'][i].licence_city_name);

                                if(response['data'][i].licence_attach=="Not Found"){
                                    $("#license_attach_html").html("");
                                    $("#license_attach_not_found_html").html(response['data'][i].licence_attach);

                                    $("#license_back_html").html("");
                                    $("#license_back_not_found_html").html(response['data'][i].licence_attach_back);
                                }else{
                                    $("#license_attach_not_found_html").html("");
                                    $("#license_attach_html").attr('href',response['data'][i].licence_attach);
                                    $("#license_attach_html").html("see Image");

                                    $("#license_back_not_found_html").html("");
                                    $("#license_back_html").attr('href',response['data'][i].licence_attach_back);
                                    $("#license_back_html").html("see Image");
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


                            }
                        }

                    }
                });

                $.ajax({
                    url: "{{ route('ajax_career_remark_rejon_remarks') }}",
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
                            if(response[i].remakrs){
                            if(response[i].status == "0"){
                                $career_category = "Frontdesk"
                                // $followup = response[i].followup_name
                            }else if(response[i].status == "5"){
                                $career_category = "Waitlist"
                                // $followup = response[i].followup_name
                            }else if(response[i].status == "3"){
                                $career_category = "Selected"
                                // $followup = response[i].followup_name
                            }else if(response[i].status == "4"){
                                $career_category = "Selected"
                                // $followup = response[i].followup_name
                            }else if(response[i].status == "1"){
                                $career_category = "Reject"
                                $followup = ""
                            }

                            if(response[i].remakrs !== "sent to selected from frontdesk"){

                                data = `<div class="message flex-grow-1">
                                <div class="d-flex">
                                    <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                                    <span class="career_remark">(${response[i].created_at})</span>
                                </div>
                                    <p class="m-0">${response[i].remakrs}</p>
                                    <span class="m-0">(${$career_category}  )</span>
                            </div><br>`;
                                $(".remark").append(data);

                            }



                            }}
                    }
                });$(".remark").empty();


});

//rejoin candidate end








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
    </script>
    {{--    display modal date jquery end--}}


    <script>
        function reinstialize_datatable() {

            $("#datatable_first_priority .filtering_source_from select").remove();
            $("#datatable_first_priority select").remove();
            $('#datatable_first_priority').DataTable( {
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
                    { "orderable": false, "targets": [0] }

                ],

                scrollY: false,
                scrollX: true,

            });

            var table = $('#datatable_first_priority').DataTable();
            $('#container').css( 'display', 'block' );
            $(".display").css("width","100%");
            $("#datatable_first_priority tbody").css("width","100%");
            table.columns.adjust().draw();

        }
    </script>





    <script>
        $("#checkAll").click(function () {
            $('.company_checkbox').not(this).prop('checked', this.checked);
        });
    </script>


    <script>
        $(document).ready(function () {

            $('input:checkbox').change(function () {

                var checked = $("input[type=checkbox]:checked").length;

                if(parseInt(checked)>1){
                    $("#edit_btn").attr('disabled',true);
                }else{
                    $("#edit_btn").attr('disabled',false);
                }


            });

        });
    </script>





    <script>
        $(document).ready(function () {
            'use-strict'

            $('#forntdesk_datatable').DataTable( {
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
                    { "orderable": false, "targets": [0] }

                ],

                scrollY: false,
                scrollX: true,

            });

            var table = $('#datatable_first_priority').DataTable();
            $('#container').css( 'display', 'block' );
            $(".display").css("width","100%");
            $("#datatable_first_priority tbody").css("width","100%");
            table.columns.adjust().draw();
        });


    </script>

    {{--    search jquery start--}}

    <script>
        function make_table(table_name,tab_name) {
            console.log(table_name);

            $.ajax({
                url: "{{ route('get_reject_career_table') }}",
                method: 'GET',
                data: {status:tab_name},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
                    var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            // "columnDefs": [
                            //     {"targets": [0],"visible": false},
                            // ],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
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
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }

        function make_table_rejoin(table_name,tab_name) {
            console.log(table_name);

            $.ajax({
                url: "{{ route('get_reject_rejoin_career_table') }}",
                method: 'GET',
                data: {status:tab_name},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
                    var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            // "columnDefs": [
                            //     {"targets": [0],"visible": false},
                            // ],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
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
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }


    </script>

    <script>
        //btn category function
        $(".btn_category").click(function(){

            var ids = $(this).attr('id');
            var status = "";

            if(ids=="rejoin_candidate"){
                $("#rejoin_candidate").addClass("active");
                $("#normal_candidate").removeClass("active");

                status ="2";
            }else{
                status ="1";
                $("#normal_candidate").addClass("active");
                $("#rejoin_candidate").removeClass("active");
            }



            $.ajax({
                url: "{{ route('get_rejoin_candidate_rejected') }}",
                method: 'GET',
                data: {request_type:status},
                success: function(response) {

                    $('.append_main_div').empty();
                    $('.append_main_div').html(response.html);


                    if(status=="1"){
                        var table_name= "forntdesk_datatable";
                    }else{
                        var table_name= "rejoin_forntdesk_datatable";
                    }

                        var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
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
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
            });

        });
        </script>





    {{--    search jquery end--}}
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
        $(document).ready(function () {
            // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                var currentTab = $(e.target).attr('id'); // get current tab


                var status = $(this).attr('data-status');

                var data_table_name = "";

                if(status=="0"){
                    data_table_name = "forntdesk_datatable";
                    make_table(data_table_name,status);
                }else if(status=="5"){
                    data_table_name = "waitlist_datatable";
                    make_table(data_table_name,status);
                }else if(status=="4"){
                    data_table_name = "selected_datatable";
                    make_table(data_table_name,status);
                }else if(status=="333"){
                    data_table_name = "onboard_datatable";
                    make_table(data_table_name,status);
                }else if(status=="8"){
                    data_table_name = "rejoin_forntdesk_datatable";
                    make_table_rejoin(data_table_name,status);
                }else if(status=="9"){
                    data_table_name = "rejoin_waitlist_datatable";
                    make_table_rejoin(data_table_name,status);
                }else if(status=="10"){
                    data_table_name = "rejoin_selected_datatable";
                    make_table_rejoin(data_table_name,status);
                }
                else{
                    data_table_name = "other_datatable";
                    make_table(data_table_name,status);
                }




                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();


            }) ;
        });

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





@endsection
