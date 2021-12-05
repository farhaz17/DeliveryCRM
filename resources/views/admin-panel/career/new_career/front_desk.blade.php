
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Front Desk</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


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

                                    <tr style="display: none;" id="refer_by_row">
                                        <th>Referal By</th>
                                        <td><span id="refer_by"></span></td>
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
                                Note
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

{{--                                    <tr>--}}
{{--                                        <th>Company visa</th>--}}
{{--                                        <td><span id="company_visa_html"></span></td>--}}
{{--                                    </tr>--}}

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
                    <input type="hidden" name="category"  value="1">
                    <input type="hidden" name="checkbox_array" id="select_ids_note" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                <option value="" selected disabled>select an option</option>
                                @foreach($followup_front as $follow)
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


    <!--  add email Modal -->
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
                    <input type="hidden" name="checkbox_array" id="select_ids"  value="">
                    {{-- <input type="text" name="checkbox_array" id="select_ids_email" > --}}
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
    </div><!-- end of email modal -->



    <!--  search modal -->
    <div class="modal fade bd-example-modal-lg"  id="seatch_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('search_result_career') }}" method="POST" id="search_form" enctype="multipart/form-data">
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







    <div class="col-md-12 mb-3">

        <div class="card text-left">
            <div class="card-body">
                <a href="{{ route('career_by_office.create') }}" target="_blank" class="btn btn-dark btn-icon m-1" id="add_btn" type="button"><span class="ul-btn__icon"><i class="i-Find-User"></i></span><span class="ul-btn__text">Update the candidate</span></a>
                {{-- <a href="{{ route('view_frontdesk_follow_up') }}" target="_blank" class="btn btn-info btn-icon m-1 text-white" id="followup_btn" type="button" style="float: right;"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">View Followup</span></a> --}}
                <button class="btn btn-secondary btn-icon m-1 text-white" id="search_btn" type="button"><span class="ul-btn__icon"><i class="i-Search-People"></i></span><span class="ul-btn__text">Search</span></button>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" data-status="walkin" role="tab" aria-controls="homeBasic" aria-selected="true">Today Walkin Candidate</a></li>
                    <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" data-status="referal" role="tab" aria-controls="profileBasic" aria-selected="false">Today Referal</a></li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <form action="{{ route('career_frontdesk_save') }}" id="save_form" method="POST">
                            @csrf


                            {{--                    <button class="btn btn-info btn-icon m-1"  id="selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Send to Selected</span></button>--}}
                                                <button class="btn btn-danger btn-icon m-1" id="rejected_btn"  type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text">Send to Rejected</span></button>
                            <button class="btn btn-warning btn-icon m-1"  id="note_btn" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                            {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                            <button class="btn btn-success btn-icon m-1 text-white" id="email_btn" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>


                            <input type="hidden" name="type" id="type" value="">
                            <input type="hidden" name="reject_reason" id="reject_reason_in_form" value="">

                            <div class="table-responsive">
                                <table class="display table table-sm table-striped text-10 table-bordered" id="walkin_datatable">
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
                                        <th scope="col" class="filtering_source_from">Source type</th>
                                        <th scope="col"  >Heard About us</th>
                                        <th scope="col" >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($careers as $career)



                                        <tr id="row-{{ $career->id }}" @if(isset($career->refer_by)) style="background-color: #43b343;" @endif>
                                            <td>

                                                <label class="checkbox checkbox-outline-primary text-10">
                                                    <input type="checkbox" data-email="{{ $career->email }}" name="checkbox_array[]" value="{{ $career->id }}" class="checks walkin_checkbox_cls"><span></span><span class="checkmark"></span>
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
                                                {{$career->follow_up_frontdesk->name}}
                                                @endif
                                                @endif
                                            </td>
                                            {{-- <td>{{ isset($career->follow_up_status) ? $career->follow_up_status : 'Not Verified' }}</td> --}}
                                            <?php  $created_at = explode(" ", $career->created_at);?>

                                            <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
                                            <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
                                            <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
                                            <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
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

                    <div class="tab-pane fade show " id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <form action="{{ route('career_frontdesk_save') }}" id="save_referal_form" method="POST">
                            @csrf
                            <button class="btn btn-warning btn-icon m-1"  id="note_btn_referal" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Add Note</span></button>
                            {{--                    <button class="btn btn-dark btn-icon m-1 text-white" id="edit_btn" type="button"><span class="ul-btn__icon"><i class="i-Atom"></i></span><span class="ul-btn__text">Edit</span></button>--}}
                            <button class="btn btn-success btn-icon m-1 text-white" id="email_btn_refaral" type="button"><span class="ul-btn__icon"><i class="i-Email"></i></span><span class="ul-btn__text">Send Email</span></button>


                            <input type="hidden" name="type" id="type" value="">

                            <div class="table-responsive">
                                <table class="display table table-sm table-striped text-10 table-bordered" id="referal_datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                                <input type="checkbox"   id="checkAll_referal"><span>All</span><span class="checkmark"></span>
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
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>



    <script>
        tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),

        });

    </script>


    <script>
        tail.DateTime("#edit_dob_html",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

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
    </script>


    {{--    display modal data jquery start--}}
    <script>
        $('#platform_id').select2({
            placeholder: 'Select an option'
        });

        $('#cities').select2({
            placeholder: 'Select an option'
        });
    </script>


    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;

                var status = $(this).attr('data-status');

                var data_table_name = status+"_datatable";

                make_table(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();


            });
        });
    </script>

    <script>
        function make_table(table_name,tab_name) {
            console.log(table_name);

            $.ajax({
                url: "{{ route('get_front_desk_table') }}",
                method: 'GET',
                data: {tab_name:tab_name},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
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
        }

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
                    console.log(response);
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
                            if(response['data'][i].refer_by!="0"){
                                $("#refer_by_row").show();
                                $("#refer_by").html(response['data'][i].refer_by);
                            }else{
                                $("#refer_by_row").hide();
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
                    console.log(response);
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

            $("#walkin_datatable .filtering_source_from select").remove();
            $("#walkin_datatable select").remove();
            $('#walkin_datatable').DataTable( {
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

            var table = $('#walkin_datatable').DataTable();
            $('#container').css( 'display', 'block' );
            $(".display").css("width","100%");
            $("#walkin_datatable tbody").css("width","100%");
            table.columns.adjust().draw();

        }
    </script>





    <script>
        $("#checkAll").click(function () {
            $('.walkin_checkbox_cls').not(this).prop('checked', this.checked);
        });

        $("#checkAll_referal").click(function () {
            $('.referal_checkin_cls').not(this).prop('checked', this.checked);
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

            $('#walkin_datatable').DataTable( {
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

            var table = $('#walkin_datatable').DataTable();
            $('#container').css( 'display', 'block' );
            $(".display").css("width","100%");
            $("#walkin_datatable tbody").css("width","100%");
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
        $(document).ready(function () {
            $('#selected_btn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    $("#type").val("1");
                    $("#save_form").submit();
                }
            });
            $('#rejected_btn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    $("#type").val("2");
                    $("#reject_remarks_modal").modal("show");

                    // $("#save_form").submit();
                }
            });

            $("#save_reject_reason").click(function (){
                var reason = $("#reject_reason").val();
                $("#reject_reason_in_form").val(reason);

                $("#save_form").submit();


            });


            $('#note_btn').click(function() {
                checked = $(".walkin_checkbox_cls:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                        $(".walkin_checkbox_cls:checked").each(function(){
                            my_array.push($(this).val());
                        });

                        $("#select_ids_note").val(my_array);

                    $("#edit_note_modal").modal('show');

                }
            });

            $('#email_btn').click(function() {
                checked = $(".walkin_checkbox_cls:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    var my_arrays = [];

                    $(".walkin_checkbox_cls:checked").each(function(){
                        my_array.push($(this).val());
                        $("#select_ids").val(my_array);
                    });

                    $(".walkin_checkbox_cls:checked").each(function(){
                        my_arrays.push($(this).attr("data-email"));
                    });

                    $("#select_ids_email").val(my_arrays);

                    $("#email_note").val("");

                    $("#edit_email_modal").modal('show');

                }
            });

            $('#note_btn_referal').click(function() {
                checked = $(".referal_checkin_cls:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];

                    $(".referal_checkin_cls:checked").each(function(){
                        my_array.push($(this).val());
                    });

                    $("#select_ids_note").val(my_array);

                    $("#edit_note_modal").modal('show');

                }
            });

            $('#email_btn_refaral').click(function() {
                checked = $(".referal_checkin_cls:checked").length;

                if(!checked) {
                    // alert("You must check at least one checkbox.");
                    tostr_display("error","You must check at least one checkbox.");
                    return false;
                }else{
                    var my_array = [];
                    var my_arrays = [];

                    $(".referal_checkin_cls:checked").each(function(){
                        my_array.push($(this).val());
                        $("#select_ids").val(my_array);
                    });

                    $(".referal_checkin_cls:checked").each(function(){
                        my_arrays.push($(this).attr("data-email"));
                    });

                    $("#select_ids_email").val(my_arrays);

                    $("#email_note").val("");

                    $("#edit_email_modal").modal('show');

                }
            });



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
        $("[data-toggle=popover]").popover();
    </script>



@endsection
