@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
        }
        .table td{
            padding: 2px;
            font-size: 13px;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
            font-weight: 600;
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

    </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Career Candidate Lists</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    {{--    view Detail modal--}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-6">
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
                                Remarks
                            </h6>
                            <p  id="remarks_html"></p>


                        </div>

                        <div class="col-md-6">
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




                    </div>




                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}



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


    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" data-status="pending" aria-selected="true">Pending</a></li>
                        <li class="nav-item"><a class="nav-link" id="wait-list-tab" data-toggle="tab" href="#waitlist" role="tab" aria-controls="waitlist" data-status="waitlist"  aria-selected="true">Wait List</a></li>
                        <li class="nav-item"><a class="nav-link" id="selected-list-tab" data-toggle="tab" href="#selectedlist" role="tab" aria-controls="selectedlist" data-status="selected"  data-status = "0" aria-selected="true">Selected List</a></li>
                        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic"  data-status="interview" aria-selected="false">Interview</a></li>
                        <li class="nav-item"><a class="nav-link" id="only_pass-tab" data-toggle="tab" href="#only_pass" role="tab" aria-controls="only_pass" data-status="only_pass" aria-selected="false">Only Pass</a></li>
                        <li class="nav-item"><a class="nav-link" id="onboard-tab" data-toggle="tab" href="#onboard" role="tab" aria-controls="onboard" data-status="onboard" aria-selected="false">OnBoard</a></li>

                        {{--                        <li class="nav-item"><a class="nav-link" id="absent-tab" data-toggle="tab" href="#absent" role="tab" aria-controls="absent" data-status="absent"  aria-selected="false">Absent</a></li>--}}
                        {{--                        <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" data-status="detail_collected" aria-selected="false">Detail Collected</a></li>--}}
                        <li class="nav-item"><a class="nav-link" id="zds-basic1-tab" data-toggle="tab" href="#zdsBasic1" role="tab" aria-controls="zdsBasic1" data-status="hired" aria-selected="false">Hired</a></li>
                    </ul>


                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                            <table class="display table table-striped table-bordered" id="datatable" style="width: 100%">
                                <thead >
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($referals as $career)

                                    <tr>
                                        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
                                        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
                                        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
                                        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
                                        <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td>
                                        <td id="created_at-{{ $career->created_at->toDateString()}}" >{{ $career->created_at->toDateString() }}</td>
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
                        <!-------tab1 ends here--------------->




                        <!-------wait--------------->
                        <div class="tab-pane fade show" id="waitlist" role="tabpanel" aria-labelledby="wait-list-tab">

                            <table class="display table table-striped table-bordered" id="wait_datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                        </div>
                        <!-------wait list ends here--------------->




                        <!-------selected--------------->
                        <div class="tab-pane fade show" id="selectedlist" role="tabpanel" aria-labelledby="selected-list-tab">

                            <table class="display table table-striped table-bordered" id="selected_datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                        </div>
                        <!-------selected ends here--------------->



                        <!-------tab2--------------->
                        <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                            <table class="display table table-striped table-bordered" id="datatable2" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                        </div>
                        <!-------tab2 ends here--------------->



                        <!-------pass--------------->
                        <div class="tab-pane fade show" id="onboard" role="tabpanel" aria-labelledby="onboard-tab">

                            <table class="display table table-striped table-bordered" id="pass_datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>


                        </div>
                        <!-------pass ends here--------------->



                        <!-------fail--------------->
                        <div class="tab-pane fade show" id="only_pass" role="tabpanel" aria-labelledby="only_pass-tab">

                            <table class="display table table-striped table-bordered" id="fail_datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                        </div>
                        <!-------fail ends here--------------->



                        <!-------absent--------------->
                        <div class="tab-pane fade show" id="absent" role="tabpanel" aria-labelledby="absent-tab">

                            <table class="display table table-striped table-bordered" id="absent_datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                        </div>


                        <!-------tab4--------------->
                        <div class="tab-pane fade show" id="zdsBasic1" role="tabpanel" aria-labelledby="zds-basic1-tab">
                            <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Whatsapp</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Source Type</th>
                                    <th>Heard About us</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-------tab4 ends here--------------->


                        <!---------------main tab------->
                    </div>


                </div>
            </div>
        </div>
    </div>





    {{--    varification modal--}}

    <div class="modal fade ref_modal" id="ref_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Change Reward Status to Reward Collected </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">

                            <form method="post" action="{{route('referal.store')}}">
                                {!! csrf_field() !!}

                                <input  id="referral_id" name="id"  type="hidden" required />


                                <h4 style="color: #000000">Are you sure want to add Reward status to Collected?</h4>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                    <button class="btn btn-primary">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    {{--    //-----------------}}



    <div class="modal fade view_modal" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Referal History</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="view_referal">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <div class="overlay"></div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                // "columnDefs": [
                //     {"targets": [0],"width": "5%"},
                //     {"targets": [1],"width": "10%"},
                //     {"targets": [2],"width": "4%"},
                //     {"targets": [12],"width": "6%"},
                // ],
                "sScrollX": "100%",
                "scrollX": true
            });
        });
    </script>

    <script>
        $('body').on('click', '.enter_passport', function() {
            var  ids  = $(this).attr('id');

            $("#primary_id_for_passport").val(ids);
            $("#passport_modal").modal('show');


        });
    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                var status = $(this).attr('data-status');

                if(split_ab=="home-basic-tab"){
                    make_table("datatable",status);

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="wait-list-tab"){
                    make_table("wait_datatable",status);

                    var table = $('#wait_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#wait_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="selected-list-tab"){
                    make_table("selected_datatable",status);

                    var table = $('#selected_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#selected_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="profile-basic-tab"){
                    make_table("datatable2",status);

                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="onboard-tab"){
                    make_table("pass_datatable",status);

                    var table = $('#pass_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#pass_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="only_pass-tab"){
                    make_table("fail_datatable",status);

                    var table = $('#fail_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#fail_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="absent-tab"){
                    make_table("absent_datatable",status);

                    var table = $('#absent_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#absent_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="zds-basic1-tab"){


                    make_table("datatable4",status);

                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }


            }) ;
        });
    </script>

    <script>
        function make_table(table_name,tab_name) {



            $.ajax({
                url: "{{ route('get_new_report_user_ajax') }}",
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
                            "scrollY": false,
                            "scrollX": true,
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
        $('.action-btn').on('click', function() {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('id');
            $('#referral_id').val(id);
            $('.ref_modal').modal('show');
        });
    </script>


    <script>
        $('body').on('click', '.view-btn', function() {
            // $("tbody .view-btn").click(function(){
            var token = $("input[name='_token']").val();
            var passport_id = $(this).attr('id');
            $.ajax({
                url: "{{ route('view_referal') }}",
                method: 'POST',
                dataType: 'json',
                data: {passport_id: passport_id, _token: token},
                success: function (response) {
                    $('.view_referal').empty();
                    $('.view_referal').append(response.html);
                    $(".view_modal").modal('show')
                    var table = $('#datatable2').DataTable({
                        paging: true,
                        info: true,
                        searching: true,
                        autoWidth: false,
                        retrieve: true
                    });
                }
            });
        });
    </script>

    <script>


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
