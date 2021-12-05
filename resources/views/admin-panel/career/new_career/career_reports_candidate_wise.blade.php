
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
            <li>Creeer Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>





{{--    slider modal start--}}
    <div class="modal fade bd-example-modals-lg" id="slider_modal" role="dialog">
        <div class="modal-dialog modals-lg">
            <!--Modal Content-->
            <div class="modal-content">
                <div class="modal-header" id="apppend_modal_html">



                </div>
            </div>
        </div>
    </div>
{{--    slider modal end--}}

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="agreed_amount_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Agreed Amount Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>


                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group append_div">



                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>

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






    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Normal Rider ({{ $careers->count() ? $careers->count(): '0'  }})  </a></li>
                    <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejoin Rider ({{ $rejoins->count() ? $rejoins->count(): '0'  }}) </a></li>

                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-sm table-striped text-10 table-bordered" id="datatable_first_priority" style="width: 100%;">
                                <thead >
                                <tr>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Full name</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Whatsapp/phone</th>
                                    <th scope="col">Licence Status</th>
                                    <th scope="col">Applying For</th>
                                    <th scope="col">Passport Handover</th>
                                    {{-- <th scope="col">Visa Type</th> --}}
                                    {{-- <th scope="col">Visa Process</th> --}}
                                    <th scope="col">Career Process</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Ar Balance</th>
                                    <th scope="col">Date Agreement</th>
                                    <th scope="col">Visa Process Date</th>
                                    <th scope="col">Attachment</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($careers as $career)
                                    <tr>
                                        <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->passport_no :  $career->passport_no }}</td>
                                        <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->personal_info->full_name:  $career->name }}</td>
                                        <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->pp_uid:  'N/A' }}</td>
                                        <td>{{ isset($career->whatsapp) ? $career->whatsapp:  'N/A' }} / {{ isset($career->phone) ? $career->phone:  'N/A' }} </td>
                                        <td>{{ isset($career->licence_status) ? $licence_status_array[$career->licence_status]:  'N/A' }} </td>
                                        <td>{{ isset($career->vehicle_type) ? $applying_for_array[$career->vehicle_type]: 'N/A' }} </td>
                                        <td>
                                            @if(isset($career->passport_ppuid))
                                                <?php $passport_hold = $career->passport_ppuid->check_passport_hold(); ?>
                                                <?php $passport_locker = $career->passport_ppuid->check_passport_locker(); ?>
                                                    @if(isset($passport_hold))
                                                        Received
                                                     @elseif(isset($passport_locker))
                                                        Received in Locker
                                                     @endif
                                            @else
                                                Not Received
                                            @endif
                                        </td>

                                        <td>
                                            @if($career->applicant_status < 3)
                                                {{ isset($career->follow_status) ? $career->follow_status->name : '' }}
                                            @elseif($career->applicant_status=="5")
                                                Wait List
                                            @elseif($career->applicant_status=="4")
                                                    <?php $check_on_board = $career->check_on_board(); ?>
                                                    <?php $check_interview = $career->check_interview_or_not(); ?>
                                          <?php
                                            $assing_platform = "";
                                          if(isset($career->passport_ppuid)){
                                              $assing_platform = $career->passport_ppuid->assign_platforms_checkin();
                                          }
                                            ?>
                                                   @if(isset($assing_platform->plateformdetail))
                                                       Assigned Platform
                                                    @elseif(isset($check_on_board))
                                                        On Board
                                                     @elseif(isset($check_interview))
                                                        In Interview ({{ isset($check_interview->batch_info) ? $check_interview->batch_info->reference_number : ''   }})
                                                    @else
                                                       Selected
                                                     @endif

                                            @endif
                                        </td>
                                        <td id="{{ isset($career->passport_ppuid) ? $career->passport_ppuid->id :  $career->passport_no }}">
                                        {{ (isset($assing_platform->passport_ppuid) && isset($assing_platform))  ? $assing_platform->plateformdetail->name : 'N/A'  }}
                                        <td>
                                        @if(isset($career->passport_ppuid))
                                             @if($career->passport_ppuid->agree_amount)
                                                    <a href="javascript:void(0)" id="{{ $career->passport_ppuid->agree_amount->id }}" class="show_agreed_amount_cls">{{ $career->passport_ppuid->agree_amount->final_amount  }}</a>
                                              @else
                                                 N/A
                                             @endif
                                        @else
                                        N/A
                                        @endif
                                        </td>

                                        <td>
                                            @if(isset($career->passport_ppuid))
                                                {{  isset($career->passport_ppuid->agree_amount) ? $career->passport_ppuid->agree_amount->created_at->toDateString(): 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($career->passport_ppuid))
                                                {{  isset($career->passport_ppuid->offer) ? $career->passport_ppuid->offer->date_time: 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-primary mr-2 show_slider_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Letter-Sent font-weight-bold"></i></a>
                                        </td>

                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>


                    </div>
                    {{-- first tab end here --}}

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="table-responsive">

                            <div class="table-responsive">
                                <table class="display table table-sm table-striped text-10 table-bordered" id="rejoin_datatable" style="width: 100%;">
                                    <thead >
                                    <tr>
                                        <th scope="col">Passport No</th>
                                        <th scope="col">Full name</th>
                                        <th scope="col">passport no</th>
                                        <th scope="col">Whatsapp/phone</th>
                                        <th scope="col">Licence Status</th>
                                        <th scope="col">Applying For</th>
                                        <th scope="col">Passport Handover</th>
                                        {{-- <th scope="col">Visa Type</th> --}}
                                        {{-- <th scope="col">Visa Process</th> --}}
                                        <th scope="col">Career Process</th>
                                        <th scope="col">Platform</th>
                                        <th scope="col">Ar Balance</th>
                                        <th scope="col">Date Agreement</th>
                                        <th scope="col">Visa Process Date</th>
                                        <th scope="col">Attachment</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    {{-- second tab end here --}}




                </div>
                {{-- main tab end here --}}


        </div>
    </div>









        <div class="overlay"></div>
    </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
    {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    {{--    dist-assets/js/scripts/tooltip.script.min.js--}}

    <script>


$('body').on('click', '.show_slider_cls', function (e) {
        // $(".show_slider_cls").click(function (){
           $("#slider_modal").modal('show');
            var primary_id = $(this).attr('id');

            $.ajax({
                url: "{{ route('career_report_rnder_slider') }}",
                method: 'GET',
                data: {primary_id:primary_id,type:"1"},
                success: function(response) {
                    $("#apppend_modal_html").html("");
                    $("#apppend_modal_html").html(response.html);

                }
            });

        });

        $('body').on('click', '.rejoin_slider_cls', function (e) {
        // $(".show_slider_cls").click(function (){
           $("#slider_modal").modal('show');
            var primary_id = $(this).attr('id');

            $.ajax({
                url: "{{ route('career_report_rnder_slider') }}",
                method: 'GET',
                data: {primary_id:primary_id,type:"2"},
                success: function(response) {
                    $("#apppend_modal_html").html("");
                    $("#apppend_modal_html").html(response.html);

                }
            });

        });


        $(".show_agreed_amount_cls").click(function (){

            $("#agreed_amount_modal").modal('show');

            var primary_id = $(this).attr('id');
            $(".append_div").html("");
            $.ajax({
                url: "{{ route('get_creeer_wise_report_agreed_amount_detail') }}",
                method: 'GET',
                data: {primary_id:primary_id},
                success: function(response) {
                    $(".append_div").html("");
                    $(".append_div").html(response.html);

                }
            });

        });

    </script>



<script>

$(document).ready(function () {

$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

    var currentTab = $(e.target).attr('id'); // get current tab

    // alert(currentTab);

    if(currentTab=="profile-basic-tab"){

        make_table("rejoin_datatable","0");
        var table = $('#rejoin_datatable').DataTable();
        $('#container').css( 'display', 'block' );
        table.columns.adjust().draw();

    }else{

            make_table("datatable_first_priority","1");
        var table = $('#datatable_first_priority').DataTable();
        $('#container').css( 'display', 'block' );
        table.columns.adjust().draw();


    }

});


});

    </script>






    <script>
function make_table(table_name,status) {


$.ajax({
    url: "{{ route('career_report_ajax') }}",
    method: 'GET',
    data: {request_type:status},
    success: function(response) {

        $('#'+table_name+' tbody').empty();

        var table = $('#'+table_name).DataTable();
        table.destroy();
        $('#'+table_name+' tbody').html(response.html);
        var table = $('#'+table_name).DataTable(
            {
                "aaSorting": [],
                "columnDefs": [
                    {"targets": [0],"visible": false},

                ],
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
        $(document).ready(function () {
            'use-strict'

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
