@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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
        .view_cls i{
            font-size: 15px !important;
        }

        .history_table th{
            font-weight:800 !important;
        }
        .font_size_cls{
            font-size: 17px !important;
            cursor: pointer;
        }


    </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Rejected</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    remarks modal--}}

    <div class="modal fade" id="remark_modal" style="z-index: 9999;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                <form method="post" id="PartsAddForm" action="{{ route('career.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
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
                                    <option value="2">Document Pending</option>
                                    <option value="3">Short Listed</option>
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

                                    <tr>
                                        <th>Facebook</th>
                                        <td><span id="facebook_html"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Experience</th>
                                        <td><span id="experiecne_html"></span></td>
                                    </tr>

                                    <tr>
                                        <th>CV Attached</th>
                                        <td>
                                            <a id="cv_attached_html" target="_blank"></a>
                                            <span id="cv_attached_not_found_html"></span>
                                        </td>
                                    </tr>


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

                                    <tr>
                                        <th>Passport Attached</th>
                                        <td>
                                            <a  href="" id="passport_attach_html" target="_blank"></a>
                                            <span id="passport_attach_not_found_html"></span>
                                        </td>
                                    </tr>

                                </table>
                            </div>

{{--                            <h6 class="remarks" >--}}
{{--                                Remarks--}}
{{--                            </h6>--}}
{{--                            <p  id="remarks_html"></p>--}}


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
                                        <th>Vehicle Type</th>
                                        <td><span id="vehicle_type_html"></span></td>
                                    </tr>



                                    <tr>
                                        <th>Licence number</th>
                                        <td><span id="license_no_html"></span></td>
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

                                    <tr>
                                        <th>Licence Attached</th>
                                        <td>
                                            <a  href="" id="license_attach_html" target="_blank"></a>
                                            <span id="license_attach_not_found_html"></span>
                                        </td>
                                    </tr>

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
                        </div>

                        <div class="col-md-12">
                            <h6 class="remarks" >
                                Remarks History
                            </h6>

                            <div class="table-responsive modal_table">
                                <table class="table table-bordered table-striped " id="table_history">
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



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Normal ({{ $short_list->count() ? $short_list->count()  : '0'   }})  </a></li>
                    <li class="nav-item"><a class="nav-link text-10 " id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Referal ({{ $referals->count() ? $referals->count()  : '0'   }}) </a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="row">
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ed6a07" class="badge badge-square-primary xl m-1 font_size_cls" id="first_priority_hours_24_block">0</span>
                                </li>
                                <label for="start_date"> > 24 hours AND <= 48 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span  style="background: #ff2a47"  class="badge badge-square-secondary xl m-1 font_size_cls" id="first_priority_hours_48_block">0</span>
                                </li>
                                <label   for="start_date"> > 48 hours AND <= 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #8b0000"  class="badge badge-square-success xl m-1 font_size_cls" id="first_priority_hours_72_block">0</span>
                                </li>
                                <label for="start_date"> > 72 hours</label>
                            </div>

                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span class="badge badge-square-light xl m-1 font_size_cls" id="first_priority_less_24_block">0</span>
                                </li>
                                <label for="start_date"> < 24 hours</label>
                                <br>
                                <br>
                                <button class="btn btn-outline-success btn-icon m-1 float-right" id="remove_apply_filter_two"  type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="display table table-striped table-sm text-10 table-bordered" id="datatable_career">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col" class="filtering_source_from">Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $total_first_priority_24 = 0; ?>
                                <?php $total_first_priority_48 = 0; ?>
                                <?php $total_first_priority_72 = 0; ?>
                                <?php $total_first_priority_less_24 = 0; ?>


                                @foreach($short_list as $career)

                                    <?php
                                    $from = \Carbon\Carbon::parse($career->updated_at);
                                    $to = \Carbon\Carbon::now();
                                    $hours_spend = $to->diffInHours($from);
                                    $color_code = "";
                                    $font_color = "";
                                    if($hours_spend < 24){
                                        $total_first_priority_less_24 = $total_first_priority_less_24+1;
                                    }elseif($hours_spend >= 24 && $hours_spend < 48){
                                        $color_code = "#ed6a07";
                                        $font_color = "black";
                                        $total_first_priority_24 = $total_first_priority_24+1;
                                    }elseif($hours_spend >= 48 && $hours_spend <= 72){
                                        $color_code = "#ff2a47";
                                        $font_color = "black";
                                        $total_first_priority_48 = $total_first_priority_48+1;
                                    }else if($hours_spend > 72){
                                        $color_code = "#8b0000";
                                        $font_color = "white";
                                        $total_first_priority_72 = $total_first_priority_72+1;
                                    }
                                    ?>
                                    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
                                        <th scope="row">{{ $career->id  }}</th>
                                        <td>{{ $career->name  }}</td>
                                        <td>{{ $career->email  }}</td>
                                        <td>{{ $career->phone  }}</td>
                                        <td>{{ $career->whatsapp }}</td>
                                        <?php $application_status = ""; ?>
                                        <?php if($career->applicant_status=="0"){
                                            $application_status  = "Not Verified";
                                        }elseif($career->applicant_status=="1"){
                                            $application_status  = "Rejected";
                                        }elseif($career->applicant_status=="2"){
                                            $application_status  = "Document Pending";
                                        }elseif($career->applicant_status=="3"){
                                            $application_status  = "Short Listed";
                                        } ?>

                                        <td>{{ $application_status }}</td>
                                        <?php  $created_at = explode(" ", $career->created_at);?>
                                        <td>{{ $created_at[0] }}</td>
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

                    </div>
                    <!---------------------tab1 ends here-------------->
                    <!---------------------tab2-------------->

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                        <div class="row">
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #ed6a07" class="badge badge-square-primary xl m-1 font_size_cls" id="referal_priority_hours_24_block">0</span>
                                </li>
                                <label for="start_date"> > 24 hours AND <= 48 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span  style="background: #ff2a47"  class="badge badge-square-secondary xl m-1 font_size_cls" id="referal_priority_hours_48_block">0</span>
                                </li>
                                <label   for="start_date"> > 48 hours AND <= 72 hours</label>
                            </div>
                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span style="background: #8b0000"  class="badge badge-square-success xl m-1 font_size_cls" id="referal_priority_hours_72_block">0</span>
                                </li>
                                <label for="start_date"> > 72 hours</label>
                            </div>

                            <div class="col-md-3 form-group mb-3 float-left text-center">
                                <li class="list-group-item border-0 ">
                                    <span class="badge badge-square-light xl m-1 font_size_cls" id="referal_priority_less_24_block">0</span>
                                </li>
                                <label for="start_date"> < 24 hours</label>
                                <br>
                                <br>
                                <button class="btn btn-outline-success btn-icon m-1 float-right" id="remove_apply_filter_referal"  type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="display table table-striped table-sm text-10 table-bordered" id="datatable_career_referals">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Refer By</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col" class="filtering_source_from">Heard About us</th>
                                    <th scope="col">Action</th>


                                </tr>
                                </thead>
                                <tbody>


                                <?php $total_referal_priority_24 = 0; ?>
                                <?php $total_referal_priority_48 = 0; ?>
                                <?php $total_referal_priority_72 = 0; ?>
                                <?php $total_referal_priority_less_24 = 0; ?>


                                @foreach($referals as $career)


                                    <?php
                                    $from = \Carbon\Carbon::parse($career->updated_at);
                                    $to = \Carbon\Carbon::now();
                                    $hours_spend = $to->diffInHours($from);
                                    $color_code = "";
                                    $font_color = "";
                                    if($hours_spend < 24){
                                        $total_referal_priority_less_24 = $total_referal_priority_less_24+1;
                                    }elseif($hours_spend >= 24 && $hours_spend < 48){
                                        $color_code = "#ed6a07";
                                        $font_color = "black";
                                        $total_referal_priority_24 = $total_referal_priority_24+1;
                                    }elseif($hours_spend >= 48 && $hours_spend <= 72){
                                        $color_code = "#ff2a47";
                                        $font_color = "black";
                                        $total_referal_priority_48 = $total_referal_priority_48+1;
                                    }else if($hours_spend > 72){
                                        $color_code = "#8b0000";
                                        $font_color = "white";
                                        $total_referal_priority_72 = $total_referal_priority_72+1;
                                    }
                                    ?>
                                    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
                                        <th scope="row">{{ $career->id  }}</th>
                                        <td>{{ $career->name  }}</td>
                                        <td>{{ $career->email  }}</td>
                                        <td>{{ $career->phone  }}</td>
                                        <td>{{ $career->whatsapp }}</td>
                                        <?php $application_status = ""; ?>
                                        <?php if($career->applicant_status=="0"){
                                            $application_status  = "Not Verified";
                                        }elseif($career->applicant_status=="1"){
                                            $application_status  = "Rejected";
                                        }elseif($career->applicant_status=="2"){
                                            $application_status  = "Document Pending";
                                        }elseif($career->applicant_status=="3"){
                                            $application_status  = "Short Listed";
                                        } ?>

                                        <td>{{ $application_status }}</td>
                                        <td>{{ $career->refer_by_user->personal_info->full_name ? $career->refer_by_user->personal_info->full_name  : 'N/A'  }}</td>
                                        <?php  $created_at = explode(" ", $career->created_at);?>
                                        <td>{{ $created_at[0] }}</td>
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

                    </div>
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

            $('#datatable_career, #datatable_career_referals').DataTable( {
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
                            $("#license_issue_html").html(response['data'][i].traffic_code_no);
                            $("#license_expiry_html").html(response['data'][i].licence_expiry);

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
        $("#search_status").change(function(){
            var value_s =  $(this).val();

            var driving_license = $("#search_driving_license option:selected").val();
            var visa_status = $("#search_visa_status option:selected").val();

            var token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                dataType: 'json',
                url: '{{ route('ajax_search_career_table') }}',
                success:function(response)
                {
                    var tableBody = $("#datatable_career tbody");
                    tableBody.empty();

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }else{
                        tableBody.empty();
                    }
                    var options = "";
                    var  contact_html = "";
                    if(len > 0){


                        for(var i=0; i<len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var email = response['data'][i].email;
                            var phone = response['data'][i].phone;
                            var whatsapp = response['data'][i].whatsapp;
                            var status = response['data'][i].status;
                            var requird = "";

                            var edit_button = "";
                            if (status!=="Rejected"){
                                edit_button = '<a class="text-success mr-2 edit_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                            }



                            var button_view = '<a class="text-primary mr-2 view_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                            var html = '<tr><td>'+name+'</td> <td>'+email+'</td> <td>'+phone+'</td> <td>'+whatsapp+'</td> <td>'+status+'</td><td>'+edit_button+' '+button_view+'</td></tr>';

                            contact_html += html;
                        }
                        tableBody.append(contact_html);
                    }


                }
            });

            $.ajax({
                type: "POST",
                data: {value_s:value_s,_token:token},
                url: '{{ route('ajax_search_license_count') }}',
                success:function(response)
                {
                    var ab = response.split('$');
                    var yes = "Yes ("+ab[0]+")";
                    var no = "No ("+ab[1]+")";
                    $("#license_yes").html(yes);
                    $("#license_no").html(no);
                }
            });





        });

        $("#search_driving_license").change(function(){

            var value_s = $("#search_status option:selected").val();

            var driving_license = $(this).val();
            var visa_status = $("#search_visa_status option:selected").val();

            var token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                dataType: 'json',
                url: '{{ route('ajax_search_career_table') }}',
                success:function(response)
                {
                    var tableBody = $("#datatable_career tbody");
                    tableBody.empty();

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }else{
                        tableBody.empty();
                    }
                    var options = "";
                    var  contact_html = "";
                    if(len > 0){


                        for(var i=0; i<len; i++){
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var email = response['data'][i].email;
                            var phone = response['data'][i].phone;
                            var whatsapp = response['data'][i].whatsapp;
                            var status = response['data'][i].status;
                            var requird = "";

                            var edit_button = "";
                            if (status!=="Rejected"){
                                edit_button = '<a class="text-success mr-2 edit_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                            }



                            var button_view = '<a class="text-primary mr-2 view_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                            var html = '<tr><td>'+name+'</td> <td>'+email+'</td> <td>'+phone+'</td> <td>'+whatsapp+'</td> <td>'+status+'</td><td>'+edit_button+' '+button_view+'</td></tr>';

                            contact_html += html;
                        }
                        tableBody.append(contact_html);
                    }


                }
            });


            $.ajax({
                type: "POST",
                data: {value_s:value_s, driving_license:driving_license, _token:token},
                url: '{{ route('ajax_search_visa_count') }}',
                success:function(response)
                {
                    var ab = response.split("$");

                    var all = "All ("+ab[0]+")";
                    var visit = "Visit ("+ab[1]+")";
                    var cancel_visa = "Cancel Visa ("+ab[2]+")";
                    var own_visa = "Own Visa ("+ab[3]+")";


                    $("#vist_status_all").html(all);
                    $("#vist_status_visit").html(visit);
                    $("#vist_status_cancel").html(cancel_visa);
                    $("#vist_status_own").html(own_visa);

                }
            });

        });


        $("#search_visa_status").change(function(){



            var value_s = $("#search_status option:selected").val();
            var driving_license = $("#search_driving_license option:selected").val();
            var visa_status = $(this).val();

            // var driving_license =


            var token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                dataType: 'json',
                url: '{{ route('ajax_search_career_table') }}',
                success:function(response)
                {
                    var tableBody = $("#datatable_career tbody");
                    tableBody.empty();
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }else{
                        tableBody.empty();
                    }
                    var options = "";
                    var  contact_html = "";
                    if(len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var email = response['data'][i].email;
                            var phone = response['data'][i].phone;
                            var whatsapp = response['data'][i].whatsapp;
                            var status = response['data'][i].status;
                            var requird = "";
                            var edit_button = "";
                            if (status !== "Rejected") {
                                edit_button = '<a class="text-success mr-2 edit_cls" id="' + id + '" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                            }

                            var button_view = '<a class="text-primary mr-2 view_cls" id="' + id + '" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                            var html = '<tr><td>' + name + '</td> <td>' + email + '</td> <td>' + phone + '</td> <td>' + whatsapp + '</td> <td>' + status + '</td><td>' + edit_button + ' ' + button_view + '</td></tr>';
                            contact_html += html;
                            // console.log(contact_html);
                        }

                        tableBody.append(contact_html);
                    }


                }
            });
        });

    </script>


    <script>
        function history_table_append(status,remarks,id,created_at,Name,readmore,company_remark,company_readmore){
            var html = '<tr><td>'+status+'</td><td>'+remarks+'<br> <a href="javascript:void(0)" id="'+id+'" class="remarks_readmore">'+readmore+'</a></td>  <td>'+company_remark+'<br> <a href="javascript:void(0)" id="'+id+'" class="company_readmore">'+company_readmore+'</a></td>     <td>'+created_at+'</td><td>'+Name+'</td></tr>';

            return html;
        }
    </script>


    <script>
        $(document).ready(function () {

            var total_first_24_tickets = "{{ $total_first_priority_24 }}";
            var total_first_48_tickets = "{{  $total_first_priority_48 }}";
            var total_first_72_tickets = "{{ $total_first_priority_72 }}";
            var total_first_less_24_tickets = "{{ $total_first_priority_less_24 }}";

            $("#first_priority_hours_24_block").html(total_first_24_tickets);
            $("#first_priority_hours_48_block").html(total_first_48_tickets);
            $("#first_priority_hours_72_block").html(total_first_72_tickets);
            $("#first_priority_less_24_block").html(total_first_less_24_tickets);

            var total_referal_24_tickets = "{{ $total_referal_priority_24 }}";
            var total_referal_48_tickets = "{{  $total_referal_priority_48 }}";
            var total_referal_72_tickets = "{{ $total_referal_priority_72 }}";
            var total_referal_less_24_tickets = "{{ $total_referal_priority_less_24 }}";

            $("#referal_priority_hours_24_block").html(total_referal_24_tickets);
            $("#referal_priority_hours_48_block").html(total_referal_48_tickets);
            $("#referal_priority_hours_72_block").html(total_referal_72_tickets);
            $("#referal_priority_less_24_block").html(total_referal_less_24_tickets);
        });
    </script>


    <script>

        $("#first_priority_hours_24_block").click(function () {

            first_priority_filter_color("rejected","orange");
        });

        $("#first_priority_hours_48_block").click(function () {

            first_priority_filter_color("rejected","pink");
        });

        $("#first_priority_hours_72_block").click(function () {

            first_priority_filter_color("rejected","red");
        });

        $("#first_priority_less_24_block").click(function () {

            first_priority_filter_color("rejected","white");
        });

        $("#remove_apply_filter_two").click(function () {

            first_priority_filter_color("rejected","");
            get_color_block_count("rejected","first_priority_hours_24_block","first_priority_hours_48_block","first_priority_hours_72_block","first_priority_less_24_block");
        });
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


        $("#referal_priority_hours_24_block").click(function () {

            referal_priority_filter_color("rejected_referal","orange");
        });

        $("#referal_priority_hours_48_block").click(function () {

            referal_priority_filter_color("rejected_referal","pink");
        });

        $("#referal_priority_hours_72_block").click(function () {

            referal_priority_filter_color("rejected_referal","red");
        });

        $("#referal_priority_less_24_block").click(function () {

            referal_priority_filter_color("rejected_referal","white");
        });
        $("#remove_apply_filter_referal").click(function () {

            referal_priority_filter_color("rejected_referal","");
            get_color_block_count("rejected_referal","referal_priority_hours_24_block","referal_priority_hours_48_block","referal_priority_hours_72_block","referal_priority_less_24_block");
        });

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

        function get_color_block_count(priority,orange_block_id, pink_block_id, red_block_id, white_block_id){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_ajax_filter_color_block_count') }}",
                method: 'POST',
                data: {priority: priority ,_token:token},
                success: function(response) {
                    var arr = response;
                    if(arr !== null){
                        // console.log(arr['orange']);
                        $("#"+orange_block_id).html(arr['orange']);
                        $("#"+pink_block_id).html(arr['pink']);
                        $("#"+red_block_id).html(arr['red']);
                        $("#"+white_block_id).html(arr['white']);
                    }
                }
            });
        }


    </script>




    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable_career').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{
                    var table = $('#datatable_career_referals').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
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
