
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

        .active_cls{
            border: 3px solid #ffa500f2;
        }

        .active_cls_visa{
            border: 3px solid #bb2a2a;
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
        /* .hide_cls{
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
            <li>Wait List</li>
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
                    <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6;margin-right: 15px;">
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
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_waitlist as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_cls">
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
                    <input type="hidden" name="category"  value="2">
                    <input type="hidden" name="checkbox_array" id="select_ids_notes" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_waitlist as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <textarea class="form-control" rows="4" name="note" required></textarea>
                            </div>
                            <div class="col-md-12 form-group hide_cls">
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
                                <input placeholder="search..." class="form-control form-control" id="search_name"  name="search_name" type="text" />
                            </div>

                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input class="form-control form-control" id="start_created_date" name="start_created_date" autocomplete="off" type="text" />
                            </div>

                            <div class="col-md-3">
                                <label>End Date</label>
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

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="reject_remarks_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Reject Reason</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <input type="hidden" name="primary_id_agreed" id="primary_id_agreed"  >
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
                    <button class="btn btn-primary ml-2" id="save_reject_reason" type="button">Save changes</button>
                </div>

            </div>
        </div>
    </div><!-- end of note modal -->


       <!--  add note pkg Modal -->
       <div class="modal fade bd-example-modal-md"  id="pkg_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form action="{{ route('save_status_send_to_selected') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Select package</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <input type="hidden" name="pkg_agreed_id" id="pkg_agreed_id"  >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="select_image">Select package</label>
                            <select class="form-control" name="package_id" id="package_id"  required style="width: 100%;">
                                <option value="">select an option</option>
                            </select>
                        </div>
                    </div>

                    <div class="row pkg_detail_cls">
                        <div class="col-md-6 form-group">
                            <label for="select_image">package name</label>
                            <h4 id="package_name"></h4>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="select_image">Platform name</label>
                            <h4 id="platform_name"></h4>
                        </div>

                    </div>



                    <div class="row pkg_detail_cls">
                        <div class="col-md-6 form-group">
                            <label for="select_image">Salary Package</label>
                            <h4 id="salary_package"></h4>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="select_image">State</label>
                            <h4 id="package_state"></h4>
                        </div>

                    </div>


                    <div class="row pkg_detail_cls">
                        <div class="col-md-6 form-group">
                            <label for="limation">Limitation</label>
                            <h4 id="limitation"></h4>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" id="save_pkg" type="submit">Save changes</button>
                </div>

            </div>
            </form>
        </div>
    </div><!-- end of pkg modal -->



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
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Company Rider ( {{ $careers->count() ? $careers->count() : '0'  }} )</a></li>
                    <li class="nav-item"><a class="nav-link text-10 " id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">New Licence Taken ( {{ $new_taken_careers->count() ? $new_taken_careers->count() : '0'  }} )</a></li>
                  <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Four PL Rider ( {{ $four_pl->count() ? $four_pl->count() : '0'  }} )  </a></li>
                    <li class="nav-item"><a class="nav-link text-10 " id="rejoin-tab" data-toggle="tab" href="#rejoin" role="tab" aria-controls="rejoin" aria-selected="true">Rejoin Candidate ( {{ $rejoin_candidate->count() ? $rejoin_candidate->count() : '0'  }} )</a></li>
                </ul>




                 <div class="tab-content" id="myTabContent">
                       <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                           <form action="{{ route('career_frontdesk_save') }}" id="save_form" method="POST">
                               @csrf
                               {{--                    <a href="{{ route('career_by_office.create') }}" target="_blank" class="btn btn-primary btn-icon m-1" id="add_btn" type="button"><span class="ul-btn__icon"><i class="i-Gear-2"></i></span><span class="ul-btn__text">Add Candidate</span></a>--}}
                               <button class="btn btn-info btn-icon m-1"  id="selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Selected</span></button>
                               <button class="btn btn-danger btn-icon m-1" id="rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                                                  <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                               {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                               <button class="btn btn-success btn-icon m-1 text-white" id="email_btn" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                               {{-- <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button> --}}
                               {{-- <a href="{{ route('view_waitlist_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                               <input type="hidden" name="type" id="type" value="">

                               <input type="hidden" name="reject_reason" id="reject_reason_in_form" value="">
                               <input type="hidden" name="which_tab_button_pressed" id="which_tab_button_pressed" value="">




                               {{--accordian start--}}
                               <div class="accordion mb-10" id="accordionRightIcon" >
                                   <div class="card">
                                       <div class="card-header header-elements-inline">
                                           <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                       </div>
                                       <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                           <div class="card-body">

                                               <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_bike_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Bike ( {{ $careers->where('vehicle_type','=','1')->count() }} )</span></button>
                                               <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_car_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Car ( {{ $careers->where('vehicle_type','=','2')->count() }} )</span></button>
                                               <button class="btn btn-primary btn-icon m-1 company_apply_cls"  id="company_both_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Both ( {{ $careers->where('vehicle_type','=','3')->count() }} )</span></button>
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




                                           </div>
                                       </div>
                                   </div>
                               </div>
                               {{--accordian end here--}}



                    <div class="table-responsive">
                        <table class="display table table-sm table-striped text-10 table-bordered" id="datatable_first_priority" style="width: 100%;">
                            <thead >
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
                                            @if ($career->follow_up_status == "0")
                                                N/A
                                                @else
                                                {{$career->follow_up_name->name}}
                                            @endif
                                        @endif
                                        </td>

                                    {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


                                    <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>

                                    <td>
                                        <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        </div>
                       </form>
                       </div>


                     <div class="tab-pane fade show " id="new_taken" role="tabpanel" aria-labelledby="home-basic-new_taken">

                         <form action="{{ route('career_frontdesk_save') }}" id="new_taken_save_form" method="POST">
                             @csrf
                             {{--                    <a href="{{ route('career_by_office.create') }}" target="_blank" class="btn btn-primary btn-icon m-1" id="add_btn" type="button"><span class="ul-btn__icon"><i class="i-Gear-2"></i></span><span class="ul-btn__text">Add Candidate</span></a>--}}
                             <button class="btn btn-info btn-icon m-1"  id="selected_btn_new_taken" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Selected</span></button>
                              <button class="btn btn-danger btn-icon m-1" id="rejected_btn_new_taken"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                             <button class="btn btn-warning btn-icon m-1"  id="note_btn_new_taken" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                             {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                             <button class="btn btn-success btn-icon m-1 text-white" id="email_btn_new_taken" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                             {{-- <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button> --}}
                             {{-- <a href="{{ route('view_waitlist_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                             <input type="hidden" name="type" id="type_new_taken" value="">

                             {{--accordian start--}}
                             <div class="accordion mb-10" id="accordionRightIcon_two" >
                                 <div class="card">
                                     <div class="card-header header-elements-inline">
                                         <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-two" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                     </div>
                                     <div class="collapse" id="accordion-item-icons-two" data-parent="#accordionRightIcon_two">
                                         <div class="card-body">
                                             <button class="btn btn-primary btn-icon m-1 new_taken_apply_cls"  id="new_taken_bike_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Bike (<span>{{ $new_taken_careers->where('vehicle_type','=','1')->count()  }}</span>) </span></button>
                                             <button class="btn btn-primary btn-icon m-1 new_taken_apply_cls"  id="new_taken_car_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Car (<span>{{ $new_taken_careers->where('vehicle_type','=','2')->count()  }}</span>)</span></button>
                                             <button class="btn btn-primary btn-icon m-1 new_taken_apply_cls"  id="new_taken_both_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Both (<span>{{ $new_taken_careers->where('vehicle_type','=','3')->count()  }}</span>)</span></button>
                                             <input type="hidden" name="action_btn_click_filter_new_taken" id="action_btn_click_filter_new_taken" value="">
                                             <input type="hidden" name="new_taken_action_visit_field" id="new_taken_action_visit_field" value="">

                                             <div class="new_taken_visa_cls_div" style="display: none;">
                                                 <button class="btn btn-primary btn-icon m-1  new_taken_visa_cls backrgound_color"  id="new_taken_visit_visa" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Visit Visa (<span id="new_taken_visit_visa_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1  new_taken_visa_cls backrgound_color"  id="new_taken_cancel_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Cancel Visa (<span id="new_taken_cancel_visa_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1  new_taken_visa_cls backrgound_color"  id="new_taken_own_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Own Visa (<span id="new_taken_own_visa_count">0</span>)</span></button>
                                             </div>

                                             <div class="new_taken_visit_visa_cls_div" style="display: none;">
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_visit_visa_cls backrgound_color"  id="new_taken_visit_one_month_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">One Month (<span id="new_taken_one_month_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_visit_visa_cls backrgound_color"  id="new_taken_visit_three_month" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Three Month (<span id="new_taken_three_month_count">0</span>)</span></button>
                                             </div>

                                             <div class="new_taken_cancel_visa_cls_div" style="display: none;">
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_cancel_visa_cls backrgound_color"  id="new_taken_cancel_free_zone" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Free Zone (<span id="new_taken_free_zone_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_cancel_visa_cls backrgound_color"  id="new_taken_cancel_company_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Company Visa (<span id="new_taken_company_visa_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_cancel_visa_cls backrgound_color"  id="new_taken_cancel_waiting_cancel" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Waiting Cancellation  (<span id="new_taken_waiting_cancellation_count">0</span>)</span></button>
                                             </div>

                                             <div class="new_taken_own_visa_cls_div" style="display: none;">
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_own_visa_cls backrgound_color"  id="new_taken_own_noc" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">NOC  (<span id="new_taken_noc_count">0</span>)</span></button>
                                                 <button class="btn btn-primary btn-icon m-1 new_taken_own_visa_cls backrgound_color"  id="new_taken_own_without_no" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Without NOC  (<span id="new_taken_without_noc_count">0</span>)</span></button>
                                             </div>






                                         </div>
                                     </div>
                                 </div>
                             </div>
                             {{--accordian end here--}}



                             <div class="table-responsive">
                                 <table class="display table table-sm table-striped text-10 table-bordered" id="datatable_new_taken" style="width: 100%;">
                                     <thead >
                                     <tr>

                                         <th scope="col">
                                             <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                                 <input type="checkbox"   id="new_taken_checkAll"><span>All</span><span class="checkmark"></span>
                                             </label>
                                         </th>
                                         <th scope="col">Name</th>
                                         <th scope="col">Email</th>
                                         <th scope="col">Phone</th>
                                         <th scope="col" class="filtering_source_from">Whats App</th>
                                         <th scope="col">Status</th>
                                         <th scope="col"  class="filtering_source_from" >Created At</th>
                                         <th scope="col" >Action</th>
                                     </tr>
                                     </thead>
                                     <tbody>


                                     @foreach($new_taken_careers as $career)



                                         <tr id="row-{{ $career->id }}">
                                             <td>

                                                 <label class="checkbox checkbox-outline-primary text-10">
                                                     <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="new_taken_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
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
                                                    {{ isset($career->follow_up_name->name) ? $career->follow_up_name->name : 'N/A' }}
                                                @endif
                                            @endif
                                             </td>

                                             {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


                                             <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>
                                             <td>
                                                 <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                             </td>
                                         </tr>
                                     @endforeach


                                     </tbody>
                                 </table>
                             </div>
                         </form>
                     </div>
                     <!---------------------tab2-------------->

            <!---------------------tab3-------------->

            <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                <div class="table-responsive">

                    <form action="{{ route('career_frontdesk_save') }}" id="four_save_form" method="POST">
                        @csrf

                    <button class="btn btn-info btn-icon m-1"  id="fourpl_selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Selected</span></button>
                    <button class="btn btn-danger btn-icon m-1" id="fourpl_rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                  <button class="btn btn-warning btn-icon m-1"  id="four_pl_note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                    {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                    <button class="btn btn-success btn-icon m-1 text-white" id="email_btnto" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                    {{-- <a href="{{ route('view_waitlist_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                    <input type="hidden" name="type" id="fourpl_type" value="">


                        {{--accordian start--}}
                        <div class="accordion mb-10" id="accordionRightIcon_three" >
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-three" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-three" data-parent="#accordionRightIcon_two">
                                    <div class="card-body">
                                        <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_bike_btn" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Bike (<span>{{ $four_pl->where('vehicle_type','=','1')->count() }}</span>) </span></button>
                                        <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_car_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Car (<span>{{ $four_pl->where('vehicle_type','=','2')->count() }}</span>) </span></button>
                                        <button class="btn btn-primary btn-icon m-1 four_pl_apply_cls"  id="four_pl_both_btn" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Both (<span>{{ $four_pl->where('vehicle_type','=','3')->count() }}</span>) </span></button>
                                        <input type="hidden" name="action_btn_click_filter_four_pl" id="action_btn_click_filter_four_pl" value="">


                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--accordian end here--}}




                        <div class="fourpl_visa_cls_div" style="display: none;">
                            <button class="btn btn-primary btn-icon m-1 four_visa_cls backrgound_color"  id="four_pl_visit_visa" type="button"><span class="ul-btn__icon"><i class="i-Bicycle"></i></span><span class="ul-btn__text">Visit Visa</span></button>
                            <button class="btn btn-primary btn-icon m-1 four_visa_cls backrgound_color"  id="four_pl_cancel_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-2"></i></span><span class="ul-btn__text">Cancel Visa</span></button>
                            <button class="btn btn-primary btn-icon m-1 four_visa_cls backrgound_color"  id="four_pl_own_visa" type="button"><span class="ul-btn__icon"><i class="i-Car-Wheel"></i></span><span class="ul-btn__text">Own Visa</span></button>
                        </div>




                        <table class="display table table-striped text-10 table-bordered table-sm" id="datatable_career_referals">
                            <thead >
                            <tr>

                                <th scope="col">
                                    <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                        <input type="checkbox"    id="four_pl_checkAll"><span>All</span><span class="checkmark"></span>
                                    </label>
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col" class="filtering_source_from">Whats App</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col" >Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($four_pl as $career)



                                <tr id="row-{{ $career->id }}">
                                    <td>

                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" data-email="{{ $career->email }}" name="checkbox_array[]" class="fourpl_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
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
                                                {{$career->follow_up_name->name}}
                                            @endif
                                        @endif
                                        </td>

                                    {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


                                    <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>
                                    <td>
                                        <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

{{--                     third tab--}}

                     <div class="tab-pane fade show" id="rejoin" role="tabpanel" aria-labelledby="rejoin-tab">
                         <div class="table-responsive">

                             <form action="{{ route('career_frontdesk_save') }}" id="rejoin_save_form" method="POST">
                                 @csrf

                                 <button class="btn btn-info btn-icon m-1"  id="rejoin_selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Selected</span></button>
{{--                                 <button class="btn btn-danger btn-icon m-1" id="rejoin_rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>--}}
{{--                                                   <button class="btn btn-warning btn-icon m-1"  id="rejoin_note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>--}}
                                 {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                                 <button class="btn btn-success btn-icon m-1 text-white" id="rejoin_email_btn" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>
                                 {{-- <a href="{{ route('view_waitlist_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                                 <input type="hidden" name="type" id="rejoin_type" value="">

                                 <table class="display table table-striped text-10 table-bordered table-sm" id="datatable_career_rejoion">
                                     <thead >
                                     <tr>

                                         <th scope="col">
                                             <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                                 <input type="checkbox"    id="rejoin_checkAll"><span>All</span><span class="checkmark"></span>
                                             </label>
                                         </th>
                                         <th scope="col">Name</th>
                                         <th scope="col">Passport No</th>
                                         <th scope="col">Employee Type</th>
                                         <th scope="col">Email</th>
                                         <th scope="col">Phone</th>
                                         <th scope="col">Whats App</th>
                                         <th scope="col">Status</th>
                                         <th scope="col">Created At</th>
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
                                             <td>

                                                 <label class="checkbox checkbox-outline-primary text-10">
                                                     <input type="checkbox" data-passport_id="{{ $career->passport_detail->personal_info->passport_id }}" data-email="{{ $career->passport_detail->personal_info->personal_email ?? $career->passport_detail->personal_info->personal_email  }}" name="checkbox_array[]" class="rejoin_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                                 </label>
                                             </td>
                                             <td id="name-{{ $career->id }}">{{ $career->passport_detail->personal_info->full_name ??  $career->passport_detail->personal_info->full_name   }}</td>
                                             <td id="passport_no-{{ $career->id }}">{{ $career->passport_detail->passport_no ??  $career->passport_detail->passport_no   }}</td>
                                             <td id="employee_type-{{ $career->id }}">{{ "company"  }}</td>
                                             <td  id="email-{{ $career->id }}">{{ $career->passport_detail->personal_info->personal_email ?? $career->passport_detail->personal_info->personal_email  }}</td>
                                             <td id="phone-{{ $career->id }}" >{{ $career->passport_detail->personal_info->personal_mob }}</td>
                                             <td id="whatsapp-{{ $career->id }}" >{{ $career->passport_detail->personal_info->nat_whatsapp_no }}</td>


                                             <td>@if (isset($career->follow_up_status))
                                                @if ($career->follow_up_status == "0")
                                                    N/A
                                                    @else
                                                    {{$career->follow_up_name->name}}
                                                @endif
                                                @endif</td>
                                             <?php  $created_at = explode(" ", $career->created_at);?>

                                             <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>

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
    </div>







        <div class="overlay"></div>
    </div>
    </div>

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
        tail.DateTime("#edit_dob_html, #date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),

        });

    </script>


    {{--    display modal data jquery start--}}
    <script>
        $('#platform_id').select2({
            placeholder: 'Select an option'
        });

        $('#package_id').select2({
            placeholder: 'Select an option'
        });



        $('#cities').select2({
            placeholder: 'Select an option'
        });

    </script>

    <script>
        $('tbody').on('click', '.reject_btn', function() {
            var ids = $(this).attr('id');
            $("#primary_id_rejected").val(ids);
            $("#reject_remarks_rejoin_modal").modal('show');
            // alert(ids);
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


        function make_table_search_table(table_name,html_var) {
            console.log(table_name);

            $('#'+table_name+' tbody').empty();

            var table = $('#'+table_name).DataTable();
            table.destroy();
            $('#'+table_name+' tbody').html(html_var);
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


    </script>

    <script>
        $("#company_bike_btn").click(function () {
            $("#action_btn_click_filter").val("1");

            var action_btn =  $("#action_btn_click_filter").val();

            $(".company_visa_cls").removeClass('active_cls_visa');
            $(".company_apply_cls").removeClass('active_cls');
            $(this).addClass('active_cls');

            $(".company_visa_cls_div").hide(300);
            $(".company_visa_cls_div").show(500);


            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn, only_apply_type:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });

            $(".company_visit_visa_cls_div").hide(300);
            $(".company_cancel_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").hide(300);

            $(".company_visit_visa_cls").removeClass("active_cls_visa");
            $(".company_cancel_visa_cls").removeClass("active_cls_visa");
            $(".company_own_visa_cls").removeClass("active_cls_visa");

            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, only_apply_for:"1",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#visit_visa_count").html(array.visit_visa_count);
                    $("#cancel_visa_count").html(array.cancel_visa_count);
                    $("#own_visa_count").html(array.own_visa_count);

                }
            });


        });

        $("#company_car_btn").click(function () {

            $(".company_visa_cls").removeClass('active_cls_visa');
            $(".company_apply_cls").removeClass('active_cls');
            $(this).addClass('active_cls');

            $("#action_btn_click_filter").val("2");

            var action_btn =  $("#action_btn_click_filter").val();

            $(".company_visa_cls_div").hide(300);
            $(".company_visa_cls_div").show(500);

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn, only_apply_type:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });


            $(".company_visit_visa_cls_div").hide(300);
            $(".company_cancel_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").hide(300);

            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, only_apply_for:"1",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#visit_visa_count").html(array.visit_visa_count);
                    $("#cancel_visa_count").html(array.cancel_visa_count);
                    $("#own_visa_count").html(array.own_visa_count);

                }
            });

            $(".company_visit_visa_cls").removeClass("active_cls_visa");
            $(".company_cancel_visa_cls").removeClass("active_cls_visa");
            $(".company_own_visa_cls").removeClass("active_cls_visa");





        });

        $("#company_both_btn").click(function () {

            $(".company_visa_cls").removeClass('active_cls_visa');
            $(".company_apply_cls").removeClass('active_cls');
            $(this).addClass('active_cls');

            $("#action_btn_click_filter").val("3");

            var action_btn =  $("#action_btn_click_filter").val();

            $(".company_visa_cls_div").hide(300);
            $(".company_visa_cls_div").show(500);

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn, only_apply_type:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });

            $(".company_visit_visa_cls_div").hide(300);
            $(".company_cancel_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").hide(300);

            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, only_apply_for:"1",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#visit_visa_count").html(array.visit_visa_count);
                    $("#cancel_visa_count").html(array.cancel_visa_count);
                    $("#own_visa_count").html(array.own_visa_count);

                }
            });

            $(".company_visit_visa_cls").removeClass("active_cls_visa");
            $(".company_cancel_visa_cls").removeClass("active_cls_visa");
            $(".company_own_visa_cls").removeClass("active_cls_visa");
        });

        $("#company_visit_visa").click(function(){
            var action_btn = $("#action_btn_click_filter").val();

            $(".company_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"1",tab:"1"},
                success: function(response)
                {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("1");
            $(".company_cancel_visa_cls_div").hide();
            $(".company_own_visa_cls_div").hide();

            $(".company_visit_visa_cls_div").hide(300);
            $(".company_visit_visa_cls_div").show(500);


            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, visa_status:"1",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#one_month_count").html(array.one_month_count);
                    $("#three_month_count").html(array.three_month_count);


                }
            });


            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(".company_visit_visa_cls").removeClass('active_cls_visa');
            $(".company_own_visa_cls").removeClass('active_cls_visa');


        });


        $("#company_visit_one_month_btn").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_visit_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"1",visa_month:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("1");
            $(".company_visit_visa_cls_div").show(300);
            $(".company_visit_visa_cls_div").show(500);
            $(".company_cancel_visa_cls_div").hide();

        });


        $("#company_visit_three_month").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_visit_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"1", visa_month:"2", tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("1");
            $(".company_visit_visa_cls_div").show(300);
            $(".company_visit_visa_cls_div").show(500);
            $(".company_cancel_visa_cls_div").hide();


        });



        $("#company_cancel_visa").click(function (){

            var action_btn = $("#action_btn_click_filter").val();

            $(".company_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                dataType: 'json',
                data: {type:"wait_list", apply_for:action_btn,visa_status:"2",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });

            $("#action_btn_visa_filter").val("2");
            $(".company_visit_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").hide(300);

            $(".company_cancel_visa_cls_div").hide(300);
            $(".company_cancel_visa_cls_div").show(500);


            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, visa_status:"2",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#free_zone_count").html(array.free_zone_count);
                    $("#company_visa_count").html(array.company_visa_count);
                    $("#waiting_cancellation_count").html(array.waiting_cancellation_count);

                }
            });

            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(".company_visit_visa_cls").removeClass('active_cls_visa');
            $(".company_own_visa_cls").removeClass('active_cls_visa');


        });



        $("#company_cancel_free_zone").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"2",cancel_type:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("2");
            $(".company_cancel_visa_cls_div").show(300);
            $(".company_cancel_visa_cls_div").show(500);

        });

        $("#company_cancel_company_visa").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"2",cancel_type:"2",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("2");
            $(".company_cancel_visa_cls_div").show(300);
            $(".company_cancel_visa_cls_div").show(500);

        });

        $("#company_cancel_waiting_cancel").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"2",cancel_type:"3",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("2");
            $(".company_cancel_visa_cls_div").show(300);
            $(".company_cancel_visa_cls_div").show(500);

        });





        $("#company_own_visa").click(function(){


            var action_btn = $("#action_btn_click_filter").val();
            $(".company_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');


            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                data: { type:"wait_list",apply_for: action_btn,visa_status:"3",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });

            $("#action_btn_visa_filter").val("3");
            $(".company_visit_visa_cls_div").hide(300);
            $(".company_cancel_visa_cls_div").hide(300);

            $(".company_cancel_visa_cls").removeClass('active_cls_visa');
            $(".company_visit_visa_cls").removeClass('active_cls_visa');
            $(".company_own_visa_cls").removeClass('active_cls_visa');


            $.ajax({
                url: "{{ route('filter_data_counts') }}",
                method: 'get',
                data: {type:"wait_list",apply_for: action_btn, visa_status:"3",tab:"1"},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#noc_count").html(array.noc_count);
                    $("#without_noc_count").html(array.without_noc_count);


                }
            });

            $(".company_own_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").show(300);



        });

        $("#company_own_noc").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_own_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"3",own_visa_type:"1",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("3");

            $(".company_own_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").show(500);

        });

        $("#company_own_without_no").click(function(){
            var action_btn = $("#action_btn_click_filter").val();
            var action_btn_visa_filter = $("#action_btn_visa_filter").val();

            $(".company_own_visa_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                type: "GET",
                dataType: 'json',
                data: { type:"wait_list",apply_for: action_btn,visa_status:"3",own_visa_type:"2",tab:"1"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_first_priority",response.html);

                }
            });
            $("#action_btn_visa_filter").val("3");

            $(".company_own_visa_cls_div").hide(300);
            $(".company_own_visa_cls_div").show(500);

        });



        $("#four_pl_bike_btn").click(function (){

            $(".four_pl_apply_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                dataType: 'json',
                data: {type:"wait_list", apply_for:"1",visa_status:"2",tab:"2"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_career_referals",response.html);

                }
            });

        });

        $("#four_pl_car_btn").click(function (){



            $(".four_pl_apply_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                dataType: 'json',
                data: {type:"wait_list", apply_for:"2",visa_status:"2",tab:"2"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_career_referals",response.html);

                }
            });
        });

        $("#four_pl_both_btn").click(function (){

            $(".four_pl_apply_cls").removeClass('active_cls_visa');
            $(this).addClass('active_cls_visa');

            $.ajax({
                url: "{{ route('filter_data_career') }}",
                dataType: 'json',
                data: {type:"wait_list", apply_for:"3",visa_status:"2",tab:"2"},
                success: function(response)
                {
                    $("body").removeClass("loading");
                    make_table_search_table("datatable_career_referals",response.html);

                }
            });
        });


        </script>


    <script>
        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });


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




        $("#edit_btn").click(function () {


            var checked = $("input[type=checkbox]:checked").length;

            if(parseInt(checked)==1){
                // $("#edit_btn").attr('disabled',true);
            }else{
                tostr_display("error","please select one user");
                return false;
            }

            $("#edit_detail_modal").modal('show');

            var ids  =  $("input[type=checkbox]:checked").val();

            var form_url = $("#edit_from").attr('action');

            var split_url =  form_url.split("update_the_career/");

            var modify_form = split_url[0]+"update_the_career/"+ids;

            $("#edit_from").attr('action',modify_form);


            $("#edit_primary_id").val(ids);
            // $("#detail_modal").modal('show');

            // var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_edit_detail') }}",
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

                            $("#edit_name_html").val(response['data'][i].name);
                            $("#edit_email_html").val(response['data'][i].email);
                            $("#edit_phone_html").val(response['data'][i].phone);
                            $("#edit_whatsapp_html").val(response['data'][i].whatsapp);
                            $("#edit_facebook_html").val(response['data'][i].facebook);
                            $("#edit_dob_html").val(response['data'][i].dob);


                            $("#company_employee_type").prop("checked",false);
                            $("#four_pl_employee_type").prop("checked",false);



                            if(response['data'][i].employee_type==1){
                                $("#company_employee_type").prop("checked",true);
                            }else if(response['data'][i].employee_type==2){
                                $("#four_pl_employee_type").prop("checked",true);
                                $(".four_pl_cls").show();
                                $('#four_pl_name_id').select2({
                                    placeholder: 'Select an option'
                                });
                                $("#four_pl_name_id").val(response['data'][i].four_pl_name_id).trigger("change");
                            }else{
                                $(".four_pl_cls").hide();
                                $("#company_employee_type").prop("checked",false);
                                $("#four_pl_employee_type").prop("checked",false);
                                $("#four_pl_name_id").val(null).trigger("change");
                            }




                            // $("#cv_attached_html").html(response['data'][i].cv);

                            $("#license_status_yes").attr('checked',false);
                            $("#license_status_no").attr('checked',false);

                            if(response['data'][i].licence_status==1){
                                $("#license_status_yes").prop('checked',true);
                            }else{
                                $("#license_status_no").prop('checked',true);
                            }
                            $("#edit_bike_license").prop('checked',false);
                            $("#edit_car_license").prop('checked',false);
                            $("#edit_both_license").prop('checked',false);

                            if(response['data'][i].licence_status_vehicle==1){
                                $("#edit_bike_license").prop('checked',true);
                            }else if(response['data'][i].licence_status_vehicle==2){
                                $("#edit_car_license").prop('checked',true);
                            }else if(response['data'][i].licence_status_vehicle==3){
                                $("#edit_both_license").prop('checked',true);
                            }

                            $('#platform_id').select2({
                                placeholder: 'Select an option'
                            });

                            $('#cities').select2({
                                placeholder: 'Select an option'
                            });


                            $("#platform_id").val(null).trigger('change');
                            $("#cities").val(null).trigger('change');



                            $('#platform_id').val(response['data'][i].platform_id).trigger("change");
                            $('#cities').val(response['data'][i].cities).trigger("change");

                            $("#edit_nationality_html").val(response['data'][i].nationality);

                            $("#edit_passport_no_html").val(response['data'][i].passport_no);
                            $("#passport_expiry_html").val(response['data'][i].passport_expiry);
                            // $("#passport_attach_html").html(response['data'][i].passport_attach);


                            $("#edit_visit_visa").prop("checked",false);
                            $("#cancel_visit_visa").prop("checked",false);
                            $("#own_visit_visa").prop("checked",false);

                            $(".edit_visa_visit_block").hide();
                            $(".edit_own_visit_block").hide();
                            $(".edit_cancel_visit_block").hide()

                            $("#visa_status_html").html(response['data'][i].visa_status);
                            if(response['data'][i].visa_status==1){
                                $("#edit_visit_visa").prop('checked',true);
                                $(".edit_visa_visit_block").show();
                                $(".edit_own_visit_block").hide();
                                $(".edit_cancel_visit_block").hide();
                            }else if(response['data'][i].visa_status==2){
                                $("#cancel_visit_visa").prop('checked',true);
                                $(".edit_visa_visit_block").hide();
                                $(".edit_own_visit_block").hide();
                                $(".edit_cancel_visit_block").show();
                            }else if(response['data'][i].visa_status==3){
                                $("#own_visit_visa").prop('checked',true);
                                $(".edit_visa_visit_block").hide();
                                $(".edit_own_visit_block").show();
                                $(".edit_cancel_visit_block").hide();
                            }else{
                                $("#edit_visit_visa").prop("checked",false);
                                $("#cancel_visit_visa").prop("checked",false);
                                $("#own_visit_visa").prop("checked",false);
                            }

                            $("#shirt_size").val(response['data'][i].shirt_size).trigger("change");
                            $("#waist_size").val(response['data'][i].waist_size).trigger("change");





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



        });




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
        // this is the id of the form
        $("#edit_from").submit(function(e) {
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
                    if(response=="success"){
                        tostr_display("success","Updated Successfully");
                        var update_id = $("#edit_primary_id").val();
                        update_row(update_id);
                        $("#edit_form_modal").modal('close');

                        // alert("agreement is submitted");
                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });

        function  update_row(id) {


            var ids = id;

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


                            $("#name-"+id).html(response['data'][i].name);
                            $("#email-"+id).html(response['data'][i].email);
                            $("#phone-"+id).html(response['data'][i].phone);
                            $("#whatsapp-"+id).html(response['data'][i].whatsapp);
                            $("#create_at-"+id).html(response['data'][i].created_at);

                            // $("#first_priority").ajax.reload();
                            $("#datatable_first_priority").DataTable().destroy();
                            reinstialize_datatable();
                            // $('#datatable_first_priority').DataTable().ajax.reload();

                            // dt.row(trID).data(newCall).draw()

                        }
                    }

                }
            });
        }

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

        $("#four_pl_checkAll").click(function () {
            $('.fourpl_checkbox').not(this).prop('checked', this.checked);
        });

        $("#rejoin_checkAll").click(function () {
            $('.rejoin_checkbox').not(this).prop('checked', this.checked);
        });

        $("#new_taken_checkAll").click(function () {
            $('.new_taken_checkbox').not(this).prop('checked', this.checked);
        });


    </script>

    <script>
        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".edit_visa_visit_block").show();
                $(".edit_own_visit_block").hide();
                $(".edit_cancel_visit_block").hide();
            }else if(selected=="2"){
                $(".edit_cancel_visit_block").show();
                $(".edit_own_visit_block").hide();
                $(".edit_visa_visit_block").hide();
            }else{

                $(".edit_own_visit_block").show();
                $(".edit_visa_visit_block").hide();
                $(".edit_cancel_visit_block").hide();

            }
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
        $(".employe_type_cls").change(function () {

            var value = $(this).val();

            if(value=="1"){
                $(".four_pl_cls").hide();
                $(".visa_status_cls").show();
            }else{
                $(".four_pl_cls").show();
                $('#four_pl_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".visa_status_cls").hide();
                $(".edit_visa_visit_block").hide();
                $(".edit_cancel_visit_block").hide();
                $(".edit_own_visit_block").hide();
            }

        });
    </script>



    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_first_priority, #datatable_career_referals,#datatable_career_rejoion, #datatable_new_taken').DataTable( {
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

    <script type="text/javascript">

      function add_dynamic_opton(id,text_ab){



                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#package_id').append(newOption);

            $('#package_id').val(null).trigger('change');
        }

        $("#package_id").change(function () {

            var keyword  =   $(this).val();


            if(keyword!="" &&  keyword!=null){
                $.ajax({
                    url: "get_pacakges_ajax_detail",
                    method: 'get',
                    data:{primary_id:keyword},
                    dataType: 'json',
                    success: function (response) {

                        $(".pkg_detail_cls").show();

                        var array_ab = response;
                        if(array_ab.package_name!=""){
                            $("#package_name").html(array_ab.package_name);
                            $("#salary_package").html(array_ab.salary_package);
                            $("#platform_name").html(array_ab.platform);
                            $("#package_state").html(array_ab.state);
                            $("#limitation").html(array_ab.qty);

                        }
                    }
                });
            }
        });



        $(document).ready(function () {
            //work send to selected without pkg start
            $('#selected_btn').click(function() {
                checked = $(".company_checkbox:checked").length;

                if(!checked) {
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    $("#type").val("1");
                    $("#save_form").submit();
                }
            });

            //work send to selected without pkg start


            //send to selected work start for pkg
        //     $("#selected_btn").click(function(){

        //         $('#package_id').empty();

        //         checked = $(".company_checkbox:checked").length;

        //         if(!checked) {
        //             // alert("You must check at least one checkbox.");
        //             tostr_display("error","You must check at least one checkbox.");
        //             return false;
        //         }else{

        //             $.ajax({
        //             url: "{{ route('get_pacakges_ajax_list') }}",
        //             method: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 var len = 0;
        //                 if(response != null){
        //                     len = response.length;
        //                 }
        //                 var options = "";
        //                 if(len > 0){
        //                     for(var i=0; i<len; i++){
        //                         add_dynamic_opton(response[i].id,response[i].package_name);
        //                     }
        //                 }
        //             }
        //         });

        //             var my_array = [];
        //             $(".company_checkbox:checked").each(function(){
        //                 my_array.push($(this).val());
        //             });
        //             $("#pkg_agreed_id").val(my_array);
        //             $("#pkg_modal").modal('show');
        //         }

        //   });

            //End send to selected work start for pkg



            $('#rejected_btn').click(function() {
                checked = $(".company_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{

                    $("#type").val("2");
                    $("#which_tab_button_pressed").val("1");
                    $("#reject_remarks_modal").modal("show");

                    // $("#save_form").submit();
                }
            });

            $("#save_reject_reason").click(function (){
                var reason = $("#reject_reason").val();
                $("#reject_reason_in_form").val(reason);

                var button_pressed = $("#which_tab_button_pressed").val();

                if(button_pressed=="1"){
                    $("#save_form").submit();
                }else if(button_pressed=="2"){
                    $("#new_taken_save_form").submit();
                }else if(button_pressed=="3"){
                    $("#four_save_form").submit();
                }



            });

            $('#rejected_btn_new_taken').click(function() {
                checked = $(".new_taken_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    $("#type_new_taken").val("2");
                    $("#which_tab_button_pressed").val("2");
                    $("#reject_remarks_modal").modal("show");

                    // $("#save_form").submit();
                }
            });





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
                checked = $(".fourpl_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    // console.log(my_array);

                    $(".fourpl_checkbox:checked").each(function(){
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
                    $("input[type=checkbox]:checked").each(function(){
                        my_array.push($(this).attr("data-passport_id"));
                    });



                    // $(".rejoin_checkbox:checked").each(function(){
                    //     my_array.push($(this).val());
                    // });

                    $("#select_ids_notes").val(my_array);

                    $("#rejoin_note_modal").modal('show');

                }
            });

            $('#email_btn').click(function() {
                checked = $(".company_checkbox:checked").length;

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

            $('#email_btnto').click(function() {
                checked = $(".fourpl_checkbox:checked").length;

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



            // one tab button actions start
            $('#selected_btn_new_taken').click(function() {
                checked = $(".new_taken_checkbox:checked").length;

                //without package work start
                if(!checked) {
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    $("#type_new_taken").val("1");
                    $("#new_taken_save_form").submit();
                }
                //without package work end



                // package work start

                // $('#package_id').empty();

                // if(!checked) {
                //      alert("You must check at least one checkbox.");
                //     tostr_display("error","You must check at least one checkbox.");
                //     return false;
                // }else{

                //     $.ajax({
                //     url: "{{ route('get_pacakges_ajax_list') }}",
                //     method: 'GET',
                //     dataType: 'json',
                //     success: function(response) {
                //         var len = 0;
                //         if(response != null){
                //             len = response.length;
                //         }
                //         var options = "";
                //         if(len > 0){
                //             for(var i=0; i<len; i++){
                //                 add_dynamic_opton(response[i].id,response[i].package_name);
                //             }
                //         }
                //     }
                // });

                //     var my_array = [];
                //     $(".new_taken_checkbox:checked").each(function(){
                //         my_array.push($(this).val());
                //     });
                //     $("#pkg_agreed_id").val(my_array);
                //     $("#pkg_modal").modal('show');
                // }

                // package work end




            });

            $('#note_btn_new_taken').click(function() {
                checked = $(".new_taken_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                    $(".new_taken_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                    });

                    $("#select_ids_note").val(my_array);

                    $("#edit_note_modal").modal('show');

                }
            });

            $('#email_btn_new_taken').click(function() {
                checked = $(".new_taken_checkbox:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    var my_arrays = [];


                    $(".new_taken_checkbox:checked").each(function(){
                        my_array.push($(this).val());
                        $("#select_ids").val(my_array);

                        my_arrays.push($(this).attr("data-email"));
                    });



                    $("#select_ids_email").val(my_arrays);

                    $("#email_note").val("");

                    $("#edit_email_modal").modal('show');

                }
            });



            $("#new_taken_bike_btn").click(function () {
               $("#action_btn_click_filter_new_taken").val("1");
                var action_btn =    $("#action_btn_click_filter_new_taken").val();

                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(".new_taken_apply_cls").removeClass('active_cls');
                $(this).addClass('active_cls');



                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,only_apply_for_take:"1",tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });




                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  new_taken: "1", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);


                        $("#new_taken_visit_visa_count").html(array.visit_visa_count);
                        $("#new_taken_cancel_visa_count").html(array.cancel_visa_count);
                        $("#new_taken_own_visa_count").html(array.own_visa_count);

                    }
                });

                $(".new_taken_visa_cls_div").hide(300);
                $(".new_taken_visa_cls_div").show(500);

                $(".new_taken_visit_visa_cls_div").hide();
                $(".new_taken_cancel_visa_cls_div").hide();
                $(".new_taken_own_visa_cls_div").hide();


            });

            $("#new_taken_car_btn").click(function () {

                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(".new_taken_apply_cls").removeClass('active_cls');
                $(this).addClass('active_cls');

                $("#action_btn_click_filter_new_taken").val("2");

                var action_btn =  $("#action_btn_click_filter_new_taken").val();

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,only_apply_for_take:"1",tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });


                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  new_taken: "1", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);


                        $("#new_taken_visit_visa_count").html(array.visit_visa_count);
                        $("#new_taken_cancel_visa_count").html(array.cancel_visa_count);
                        $("#new_taken_own_visa_count").html(array.own_visa_count);

                    }
                });

                $(".new_taken_visa_cls_div").hide(300);
                $(".new_taken_visa_cls_div").show(500);

                $(".new_taken_visit_visa_cls_div").hide();
                $(".new_taken_cancel_visa_cls_div").hide();
                $(".new_taken_own_visa_cls_div").hide();



            });

            $("#new_taken_both_btn").click(function () {

                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(".new_taken_apply_cls").removeClass('active_cls');
                $(this).addClass('active_cls');

                $("#action_btn_click_filter_new_taken").val("3");
                var action_btn =    $("#action_btn_click_filter_new_taken").val();


                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,only_apply_for_take:"1",tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  new_taken: "1", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);


                        $("#new_taken_visit_visa_count").html(array.visit_visa_count);
                        $("#new_taken_cancel_visa_count").html(array.cancel_visa_count);
                        $("#new_taken_own_visa_count").html(array.own_visa_count);

                    }
                });


                $(".new_taken_visa_cls_div").hide(300);
                $(".new_taken_visa_cls_div").show(500);

                $(".new_taken_visit_visa_cls_div").hide();
                $(".new_taken_cancel_visa_cls_div").hide();
                $(".new_taken_own_visa_cls_div").hide();
            });

            $("#new_taken_visit_visa").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                 $("#new_taken_action_visit_field").val("1");

                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $('.new_taken_visit_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_cancel_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_own_visa_cls').removeClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"1",tab:"3"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $(".new_taken_visit_visa_cls_div").hide(200);
                $(".new_taken_visit_visa_cls_div").show(300);


                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  visa_status:"1", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);


                        $("#new_taken_one_month_count").html(array.one_month_count);
                        $("#new_taken_three_month_count").html(array.three_month_count);
                    }
                });


                $(".new_taken_own_visa_cls_div").hide();
                $(".new_taken_cancel_visa_cls_div").hide();


            });


            $("#new_taken_visit_one_month_btn").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_visit_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"1",visa_month:"1",tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });
                $("#new_taken_action_visit_field").val("1");

                $(".new_taken_visit_visa_cls_div").show(300);
                $(".new_taken_own_visa_cls_div").hide(500);
                $(".new_taken_cancel_visa_cls_div").hide();

            });


            $("#new_taken_visit_three_month").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_visit_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"1", visa_month:"2", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });
                $("#new_taken_action_visit_field").val("1");
                $(".new_taken_visit_visa_cls_div").show(300);
                $(".new_taken_visit_visa_cls_div").show(500);
                $(".company_cancel_visa_cls_div").hide();


            });






            $("#new_taken_cancel_visa").click(function (){

                var action_btn = $("#action_btn_click_filter_new_taken").val();
                $("#new_taken_action_visit_field").val("2");

                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $('.new_taken_visit_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_cancel_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_own_visa_cls').removeClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    dataType: 'json',
                    data: {type:"new_taken_wait_list", apply_for:action_btn,visa_status:"2",tab:"3"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $(".new_taken_cancel_visa_cls_div").hide(200);
                $(".new_taken_cancel_visa_cls_div").show(300);


                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  visa_status:"2", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);


                        $("#new_taken_free_zone_count").html(array.free_zone_count);
                        $("#new_taken_company_visa_count").html(array.company_visa_count);
                        $("#new_taken_waiting_cancellation_count").html(array.waiting_cancellation_count);
                    }
                });

                $(".new_taken_visit_visa_cls_div").hide();
                $(".new_taken_own_visa_cls_div").hide();

            });

            $("#new_taken_cancel_free_zone").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_cancel_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"2", cancel_visa_status:"1", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $("#new_taken_action_visit_field").val("2");
                $(".company_cancel_visa_cls_div").hide();


            });

            $("#new_taken_cancel_company_visa").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_cancel_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"2", cancel_visa_status:"1", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $("#new_taken_action_visit_field").val("2");
                $(".company_cancel_visa_cls_div").hide();


            });

            $("#new_taken_cancel_waiting_cancel").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_cancel_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"2", cancel_visa_status:"3", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $("#new_taken_action_visit_field").val("2");
                $(".company_cancel_visa_cls_div").hide();


            });



            $("#new_taken_own_visa").click(function(){


                var action_btn = $("#action_btn_click_filter_new_taken").val();
                $("#new_taken_action_visit_field").val("3");
                $(".new_taken_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $('.new_taken_visit_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_cancel_visa_cls').removeClass('active_cls_visa');
                $('.new_taken_own_visa_cls').removeClass('active_cls_visa');


                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"3",tab:"3"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });

                $(".new_taken_own_visa_cls_div").hide(200);
                $(".new_taken_own_visa_cls_div").show(300);

                $.ajax({
                    url: "{{ route('filter_data_counts') }}",
                    method: 'get',
                    data: {type:"new_taken",apply_for: action_btn,  visa_status:"3", tab:"1"},
                    success: function(response) {
                        var  array = JSON.parse(response);

                        $("#new_taken_own_visa_count").html(array.noc_count);
                        $("#new_taken_without_noc_count").html(array.without_noc_count);
                    }
                });

                $(".new_taken_visit_visa_cls_div").hide();
                $(".new_taken_cancel_visa_cls_div").hide();

            });



            $("#new_taken_own_noc").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_visit_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"3", own_visa_status:"1", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });
                $("#new_taken_action_visit_field").val("3");
                // $(".new_taken_visit_visa_cls_div").show(300);
                // $(".new_taken_visit_visa_cls_div").show(500);
                // $(".company_cancel_visa_cls_div").hide();


            });

            $("#new_taken_own_without_no").click(function(){
                var action_btn = $("#action_btn_click_filter_new_taken").val();
                var action_btn_visa_filter = $("#new_taken_action_visit_field").val();

                $(".new_taken_visit_visa_cls").removeClass('active_cls_visa');
                $(this).addClass('active_cls_visa');

                $.ajax({
                    url: "{{ route('filter_data_career') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { type:"new_taken_wait_list",apply_for: action_btn,visa_status:"3", own_visa_status:"2", tab:"2"},
                    success: function(response)
                    {
                        $("body").removeClass("loading");
                        make_table_search_table("datatable_new_taken",response.html);

                    }
                });
                $("#new_taken_action_visit_field").val("3");
                // $(".new_taken_visit_visa_cls_div").show(300);
                // $(".new_taken_visit_visa_cls_div").show(500);
                // $(".company_cancel_visa_cls_div").hide();


            });




            // one button action end

        });

    </script>

    <script>
        $('#fourpl_selected_btn').click(function() {



            // without package work start

            checked = $(".fourpl_checkbox:checked").length;
            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                $("#fourpl_type").val("1");
                $("#four_save_form").submit();
            }

            // without package work end




              // package work start here

                // if(!checked) {
                //     tostr_display("error","You must check at least one checkbox.");
                //     return false;
                // }else{


                //     $.ajax({
                //     url: "{{ route('get_pacakges_ajax_list') }}",
                //     method: 'GET',
                //     dataType: 'json',
                //     success: function(response) {
                //         var len = 0;
                //         if(response != null){
                //             len = response.length;
                //         }
                //         var options = "";
                //         if(len > 0){
                //             for(var i=0; i<len; i++){
                //                 add_dynamic_opton(response[i].id,response[i].package_name);
                //             }
                //         }
                //     }
                //   });

                //     var my_array = [];
                //     $(".fourpl_checkbox:checked").each(function(){
                //         my_array.push($(this).val());
                //     });
                //     $("#pkg_agreed_id").val(my_array);
                //     $("#pkg_modal").modal('show');

            // }
                    // package work end






        });

        $('#fourpl_rejected_btn').click(function() {

            checked = $(".fourpl_checkbox:checked").length;

            if(!checked) {
                // alert("You must check at least one checkbox.");
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                $("#fourpl_type").val("2");
                $("#which_tab_button_pressed").val("3");
                $("#reject_remarks_modal").modal("show");

            }
        });
     </script>

    <script>

        $('#rejoin_selected_btn').click(function() {
            checked = $(".rejoin_checkbox:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                $("#rejoin_type").val("5");
                $("#rejoin_save_form").submit();
            }
        });


        $('#rejoin_rejected_btn').click(function() {
            checked = $(".rejoin_checkbox:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                $("#rejoin_type").val("6");
                $("#rejoin_save_form").submit();
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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable_first_priority').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }else if(split_ab=="rejoin-tab"){


                    var table = $('#datatable_career_rejoion').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }else if(split_ab=="home-basic-new_taken"){


                    var table = $('#datatable_new_taken').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }
                else{
                    var table = $('#datatable_career_referals').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }



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

                setTimeout(function () {
                    $("#name_header").click();
                    // alert("working");
                }, 500);


                $("body").removeClass("loading");
            }
        });
    </script>

    <script>
        $("[data-toggle=popover]").popover();
    </script>



@endsection
