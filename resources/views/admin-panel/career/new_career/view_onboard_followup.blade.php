@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        /* .hide_cls{
            display: none;
        } */
        .buttons {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
        }
        .buttonss {
            background-color: grey;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
        }
        .modals-lg {
        max-width: 70% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        }
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
        .view_passport_detail_btn i{
            font-size: 15px !important;
        }
        .rejection i{
            font-size: 13px !important;
        }
        .rejection_rejoin i{
            font-size: 13px !important;
        }
    </style>
@endsection
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Career</a></li>
        <li>Onboard Follow Up</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <!--  onboard -->
            <div class="onboard">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                    <li class="nav-item">
                        <a class="nav-link active" id="oTodayTab" data-toggle="tab" href="#oToday" role="tab" aria-controls="oToday" aria-selected="true">Today
                        </a>
                    </li>
                    @foreach($followup_onboards as $follow)
                    <li class="nav-item">
                        <a class="nav-link followups" id="{{ $follow->name }}Tab" data-ids="{{ $follow->id }}" data-toggle="tab" href="#Intersted" role="tab" aria-controls="Intersted" aria-selected="false">{{ $follow->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="oToday" role="tabpanel" aria-labelledby="oTodayTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="oTodayTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" class="filtering_source_from">Days</th>
                                        <th scope="col" class="filtering_source_from">Employee Type</th>
                                        <th scope="col">Visa Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($onboard_today as $todays)
                                    <?php
                                        // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                        $ticketTime = strtotime($todays->career->followup_date);
                                        // This difference is in seconds.
                                        $difference = time() - $ticketTime;
                                        ?>
                                    <tr>
                                        <td>{{ $todays->career->name  }}</td>
                                        <td>{{ $todays->career->email  }}</td>
                                        <td>{{ $todays->career->phone  }}</td>
                                        <td>{{ $todays->career->whatsapp }}</td>
                                        <td>{{ $todays->remarks }}</td>
                                        <td>{{ $todays->career->followup_date }}</td>
                                        @if ((round($difference / 86400) - 1 )== "0")
                                            <td>Today</td>
                                            @else
                                            <td>{{ round($difference / 86400) - 1 }} days</td>
                                            @endif
                                            <td>@if($todays->career->employee_type == "1") Company @else Four PL @endif</td>
                                            <td>@if($todays->career->visa_status == "1") Visit Visa @elseif($todays->career->visa_status == "2") Cancel Visa @elseif($todays->career->visa_status == "3") Own Visa @endif</td>
                                        <td>
                                            <a class="text-primary mr-2 follow_up" data-category="4" data-today="1"  id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            <a class="text-primary mr-2 view_cls" id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            <a class="text-danger mr-2 rejection" id="{{ $todays->career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach($rejoin_today as $todays)
                                    <?php
                                        // Note, this gives you a timestamp, i.e. seconds since the Epoch.
                                        $ticketTime = strtotime($todays->followup_date);
                                        // This difference is in seconds.
                                        $difference = time() - $ticketTime;
                                        ?>
                                    <tr>
                                        <td>{{ $todays->passport_detail->personal_info->full_name  }}</td>
                                        <td>{{ $todays->passport_detail->personal_info->personal_email  }}</td>
                                        <td>{{ $todays->passport_detail->personal_info->personal_mob  }}</td>
                                        <td>{{ $todays->passport_detail->personal_info->nat_whatsapp_no }}</td>
                                        <td>{{ $todays->remarks }}</td>
                                        <td>{{ $todays->followup_date }}</td>
                                        @if ((round($difference / 86400) - 1 )== "0")
                                            <td>Today</td>
                                            @else
                                            <td>{{ round($difference / 86400) - 1 }} days</td>
                                            @endif
                                            <td>Rejoin</td>
                                            <td>N/A</td>
                                        <td>
                                            <a class="text-primary mr-2 rejoin_follow_up" data-category="4" data-today="1" id="{{ $todays->passport_id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            <a class="text-primary mr-2 view_passport_detail_btn" data-passport_id="{{ $todays->passport_id  }}" id="{{ $todays->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            <a class="text-danger mr-2 rejection_rejoin" id="{{ $todays->passport_id  }}" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="Intersted" role="tabpanel" aria-labelledby="InterstedTab">
                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered data_table_cls" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">WhatsApp</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col" class="filtering_source_from">Date</th>
                                        <th scope="col" class="filtering_source_from">Employee Type</th>
                                        <th scope="col">Visa Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                </div>

            </div>
        </div>
    </div>

    <!--  add note Modal-->
    <div class="modal fade bd-example-modal-lg"  id="edit_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('career_follow_up') }}" method="POST">
                    @csrf
                    <input type="hidden" name="checkbox_array" id="select_ids_note" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="id"  value="" id="Id">
                                <input type="hidden" name="remove_today"  value="" id="remove">
                                <input type="hidden" name="category" class="category" value="">
                                <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                    <option value="" selected disabled>select an option</option>
                                    @foreach($followup_onboard as $follow)
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

                 <!--  add note Modal-->
                 <div class="modal fade bd-example-modal-lg"  id="rejoin_note_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <form action="{{ route('rejoin_follow_up_save') }}" method="POST">
                                @csrf
                                <input type="hidden" name="checkbox_array" id="select_ids_note" >
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="hidden" name="id"  value="" id="Id">
                                            <input type="hidden" name="remove_today"  value="" id="remove">
                                            <input type="hidden" name="category" class="category" value="">
                                            <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                                <option value="" selected disabled>select an option</option>
                                                @foreach($followup_onboard as $follow)
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
    <div class="modal fade bd-example-modal-sm"  id="reject_remarks_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('onboard_reject_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="request_type" id="request_type"  >

                    <div class="modal-body">
                        <input type="hidden" name="change_status_id" id="change_status_id"  >
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control" id="follow_up_status" name="follow_up_status" >
                                    <option value="" selected disabled>select an option</option>
                                    <option value="4">Selected</option>
                                    <option value="5">Wait List</option>
                                    <option value="1">Reject</option>
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
    </div><!-- end of note modal -->

     <!--  add note Modal -->
     <div class="modal fade bd-example-modal-sm"  id="rejoin_reject_remarks_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Note For selected User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('onboard_rejoin_reject_save') }}" method="POST">
                    @csrf

                    <input type="hidden" name="request_type" id="request_type" value="2" >

                    <div class="modal-body">
                        <input type="hidden" name="change_status_id" id="change_status_id"  >
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select class="form-control" id="follow_up_status" name="follow_up_status" >
                                    <option value="" selected disabled>select an option</option>
                                    <option value="4">Selected</option>
                                    <option value="5">Wait List</option>
                                    <option value="1">Reject</option>
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
    </div><!-- end of note modal -->

    @endsection
    @section('js')
        <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
        <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

        <script>
            $(document).ready(function () {

                'use-strict'

                $('.followups').click(function(){

                    var id  =   $(this).data('ids');

                    $('table.data_table_cls').DataTable().destroy();
                    all_load_data(id);

                });

                function all_load_data(id){
                $('table.data_table_cls').DataTable({
                    initComplete: function () {
                        let filtering_columns = []
                        $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                            filtering_columns.push(v.cellIndex+1)
                        });
                        $(".filter-list").remove();
                        this.api().columns(filtering_columns).every( function () {
                            var column = this;
                            var select = $(`<select class='form-control form-control-sm filter-list'><option value="">All</option></select>`)
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
                processing: true,
                language:{
                    processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
                },
                serverSide: false,
                retrieve: true,
                ajax:{
                    url : "{{route('ajax_onboard_follow_up')}}",
                    data:{id: id},
                },
                columns: [
                    { data: 'career_name' },
                    { data: 'career_email' },
                    { data: 'career_phone' },
                    { data: 'career_whatsapp' },
                    { data: 'remarks' },
                    { data: 'follow_up_date' },
                    { data: 'employee_type' },
                    { data: 'visa_status' },
                    { data: 'action' },
                ],
                pageLength: 10,
                });
            }


            });
        </script>

        <script>
            $(document).ready(function () {
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    var currentTab = $(e.target).attr('href');
                    $(currentTab +"Table").DataTable().columns.adjust().draw();
                });
            });
            var table = $('#sTodayTable, #wTodayTable, #oTodayTable').DataTable({
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
            });
            table.columns.adjust().draw();
        </script>
         <script>
            $(document).on('click', '.rejoin_follow_up', function() {

            var ids  = $(this).attr('id');
            var category  = $(this).data('category');
            var today  = $(this).data('today');
            $(".modal-body #Id").val( ids );
            $(".modal-body .category").val( category );
            $(".modal-body #remove").val( today );
            $("#rejoin_note_modal").modal('show');
            // console.log(ids);
            });
        </script>
        <script>
            $(document).on('click','.rejection',function(){
                var ids  = $(this).attr('id');
                // console.log(ids)
                $(".modal-body #change_status_id").val( ids );
                $("#reject_remarks_modal").modal('show');
            });
            $(document).on('click','.rejection_rejoin',function(){
                        var ids  = $(this).attr('id');
                        // console.log(ids)
                        $(".modal-body #change_status_id").val( ids );
                        $("#rejoin_reject_remarks_modal").modal('show');
                    });
        </script>
              <script>
                $(document).on('click', '.view_passport_detail_btn', function() {

               var ids  = $(this).attr('id');
               $("#passport_detail_modal").modal('show');

               var ids = $(this).attr('id');
               var passort_id = $(this).data("passport_id");
               console.log(ids);
               var token = $("input[name='_token']").val();
               $.ajax({
                   url: "{{ route('rejoin_ajax_passport_detail') }}",
                   method: 'get',
                   dataType: 'json',
                   data: {primary_id: ids ,_token:token},
                   success: function(response) {
                       console.log(response);
                       $('.modal_body_cls').html("");
                       $('.modal_body_cls').html(response.html);

                   }
               });

               $.ajax({
                   url: "{{ route('ajax_career_remark_rejoin') }}",
                   method: 'POST',
                   data: {primary_id: passort_id ,_token:token},
                   success: function(response) {

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
            $(document).on('click', '.follow_up', function() {

            var ids  = $(this).attr('id');
            var category  = $(this).data('category');
            var today  = $(this).data('today');
            $(".modal-body #Id").val( ids );
            $(".modal-body .category").val( category );
            $(".modal-body #remove").val( today );
            $("#edit_note_modal").modal('show');
            // console.log(category);
            });
        </script>

        <script>
             tail.DateTime("#date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
                dateStart:new Date(),

            });

        </script>

    <script>
        $(document).on('click', '.view_cls', function() {

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
          // console.log(response);
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
    </script>

    <script>
        $(document).ready(function () {
            'use strict';
            $('#oInterstedTable, #oCallMeTomorrowTable, #oNoResponseTable,#oNotInterestedTable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
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
    @endsection

