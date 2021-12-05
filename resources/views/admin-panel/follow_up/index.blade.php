@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

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

    <!--  Modal -->
    <div class="modal fade bd-example-modal-lg" id="remarks_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remakrs History</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>Name:<b id="rider_name_ab"></b></p>


                    <div class="row">
                        <table class="display table table-sm table-hover text-10 data_table_cls" id="datatable_remarks_history">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Company Remarks</th>
                                <th scope="col">Remakrs For Rider</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created at</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="button">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal -->



    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-md" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('follow_up.store') }}">
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
                                    @foreach($follow_up_statuses as $ab)
                                        @if($ab->id=="3")
                                        @else
                                            <option value="{{ $ab->id }}">{{ $ab->name }}</option>
                                            @endif

                                    @endforeach
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

                                    <tr>
                                        <th>Licence Front Pic</th>
                                        <td>
                                            <a  href="" id="license_attach_html" target="_blank"></a>
                                            <span id="license_attach_not_found_html"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Licence Back Pic</th>
                                        <td>
                                            <a  href="" id="license_back_html" target="_blank"></a>
                                            <span id="license_back_not_found_html"></span>
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

    <div class="card col-lg-12 mb-2">
        <div class="card-body">
<?php $all_total = $first_priority->count();  ?>
            <div class="row form-group mb-6">
                <div class="col-md-3 text-left mb-0 ">
                    <div class="form-check-inline">
                        <label class="radio radio-outline-primary">
                            <input type="radio" class="type_cls"  checked value="0" name="type_name"><span>All  ({{ isset($all_total) ? $all_total : '' }}) </span><span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                @foreach($source_types as $com)


                    <div class="col-md-3 text-left mb-0 ">
                        <div class="form-check-inline">
                            <label class="radio radio-outline-primary">
                                @php
                                     $count_type_wise = $first_priority->where('promotion_type','=',$com->id)->count();
                                    if($com->id=="7"){
                                       $count_type_wise_1 = $first_priority->where('promotion_type','=',$com->id)->count();
                                       $count_type_wise_2 = $first_priority->where('promotion_type','is',null)->count();
                                       $count_type_wise = $count_type_wise_1+$count_type_wise_2;
                                    }
                                    @endphp
                                <input type="radio" class="company_cls"  value="{{$com->id}}" name="type_name"><span>{{$com->name}}   ({{ $count_type_wise }}) </span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-title mb-0">Follow Up Reports</div>

    <div class="row">
        <div class="col-md-3 form-group   mb-0 float-left text-center">
            <li class="list-group-item border-0 ">
                <span style="background: #ed6a07" class="badge badge-square-primary xl m-1 font_size_cls" id="first_priority_hours_24_block">0</span>
            </li>
            <label for="start_date"> > 24 hours AND <= 48 hours</label>
        </div>
        <div class="col-md-3 form-group  mb-0 float-left text-center">
            <li class="list-group-item border-0 ">
                <span  style="background: #ff2a47"  class="badge badge-square-secondary xl m-1 font_size_cls" id="first_priority_hours_48_block">0</span>
            </li>
            <label   for="start_date"> > 48 hours AND <= 72 hours</label>
        </div>
        <div class="col-md-3 form-group mb-0  float-left text-center">
            <li class="list-group-item border-0 ">
                <span style="background: #8b0000"  class="badge badge-square-success xl m-1 font_size_cls" id="first_priority_hours_72_block">0</span>
            </li>
            <label for="start_date"> > 72 hours</label>
        </div>

        <div class="col-md-3 form-group mb-0 float-left text-center">
            <li class="list-group-item border-0 ">
                <span class="badge badge-square-light xl m-1 font_size_cls" id="first_priority_less_24_block">0</span>
            </li>
            <label for="start_date"> < 24 hours</label>
            <br>
            <br>
            <button class="btn btn-outline-success btn-icon m-1 float-right" id="remove_apply_filter_two"  type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
        </div>

    </div>

            <div class="row">
                <table class="display table table-sm table-hover text-10 data_table_cls" id="datatable_first_priority">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Whats App</th>
                        <th scope="col">Status</th>
                        <th scope="col">Source type</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $total_first_priority_24 = 0; ?>
                    <?php $total_first_priority_48 = 0; ?>
                    <?php $total_first_priority_72 = 0; ?>
                    <?php $total_first_priority_less_24 = 0; ?>


                    @foreach($first_priority as $career)

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
                            <th scope="row">{{ $career->id }}</th>
                            <td id="name_column-{{ $career->id }}">{{ $career->name  }}</td>
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
                            <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
                            <td>{{ $created_at[0] }}</td>
                            <td>
                                <a class="text-warning mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
{{--                                <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>--}}
                                <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
    <div class="overlay"></div>
        </div>
    </div>

@endsection
@section('js')

    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>

        $(document).ready(function () {
            'use-strict'
            $('table.data_table_cls').DataTable( {
                "aaSorting": [[0, 'desc']],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        title: 'Followup Summary',
                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Followup Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Followup Summary',
                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                select: true,
                scrollY: false,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
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
        $('input[type=radio][name=type_name]').change(function() {
            var ids = $(this).val();
            var token = $("input[name='_token']").val();

            filter_reports(ids);
        });
        </script>

    <script>
        function filter_reports(option,color=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_filter_report_follow_up') }}",
                method: 'POST',
                data: {option: option,color: color, _token:token},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#datatable_first_priority').DataTable();
                    table.destroy();

                    $('#datatable_first_priority tbody').empty();
                    $('#datatable_first_priority tbody').append(response.html);

                    var table = $('#datatable_first_priority').DataTable(
                        {
                            "aaSorting": [[0, 'desc']],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                            ],
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
                    $(".dataTables_scrollHeadInner").css("width","100%");
                    $('#datatable_first_priority tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    get_color_block_count(option,"first_priority_hours_24_block", "first_priority_hours_48_block", "first_priority_hours_72_block", "first_priority_less_24_block");
                }
            });


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

        });
    </script>

    <script>
        function get_color_block_count(option,orange_block_id, pink_block_id, red_block_id, white_block_id){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_color_block_count_ajax') }}",
                method: 'POST',
                data: {option: option ,_token:token},
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

        $("#first_priority_hours_24_block").click(function () {

           var option =  $('input[name="type_name"]:checked').val();

            filter_reports(option,"orange");
        });

        $("#first_priority_hours_48_block").click(function () {
            var option =  $('input[name="type_name"]:checked').val();
            filter_reports(option,"pink");
        });

        $("#first_priority_hours_72_block").click(function () {
            var option =  $('input[name="type_name"]:checked').val();
            filter_reports(option,"red");
        });

        $("#first_priority_less_24_block").click(function () {
            var option =  $('input[name="type_name"]:checked').val();
            filter_reports(option,"white");
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
            }
        });
    </script>

    <script>
        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });

        $('tbody').on('click', '.remarks_history_cls', function() {
            var  ids  = $(this).attr('id');
            var name = $("#name_column-"+ids).html();
            $("#rider_name_ab").html(name);

            make_career_history(ids);
            $("#remarks_history_modal").modal('show');
        });


        function make_career_history(option) {

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_career_history') }}",
                method: 'POST',
                data: {career_id: option, _token:token},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#datatable_remarks_history').DataTable();
                    table.destroy();

                    $('#datatable_remarks_history tbody').empty();
                    $('#datatable_remarks_history tbody').append(response.html);

                    var table = $('#datatable_remarks_history').DataTable(
                        {
                            "aaSorting": [[0, 'desc']],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                            ],
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
                    $(".dataTables_scrollHeadInner").css("width","100%");
                    $('#datatable_remarks_history tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
            });

        }

    </script>

    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>


@endsection
