@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        /* .hide_cls{
            display: none;
        } */
        .modals-lg {
            max-width: 30% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        .send_btn_cls{
            color: #004e92 !important;
            font-size: 12px;
        }
    </style>




@endsection

<style>

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
</style>
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">On Boarding</a></li>
            <li>Rider Waiting for Delivery Coordinator</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="accept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Request Selection</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('rider_to_accept_request_save') }}" id="selection_form" method="POST">
                    @csrf

                    <input type="hidden" name="primary_id_selected" id="primary_id_selected" >
                    <input type="hidden" name="select_choice" id="select_choice" >

                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-danger ml-2 btn-md" id="reject_btn" type="button">Reject</button>
                                <button class="btn btn-success ml-2 btn-md" id=accept_btn type="button">Accept</button>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->


      <!--  defaulter accept Modal -->
      <div class="modal fade bd-example-modal-sm"  id="defaulter_accept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Request Selection For Defaulter</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('rider_to_accept_request_defaulter_save') }}" id="defautler_selection_form" method="POST">
                    @csrf

                    <input type="hidden" name="defaulter_primary_id_selected" id="defaulter_primary_id_selected" >
                    <input type="hidden" name="defaulter_select_choice" id="defaulter_select_choice" >

                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-danger ml-2 btn-md" id="defautler_reject_btn" type="button">Reject</button>
                                <button class="btn btn-success ml-2 btn-md" id="defaulter_accept_btn" type="button">Accept</button>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div><!-- end default accept modal -->


    <div class="card-body">
        <button class="btn btn-primary m-1 cls_type_riders" id="manger_send_rider" type="button">Manager Send Rider ({{ isset($riders) ? $riders->count() : '0' }})</button>
        <button class="btn btn-outline-primary m-1 cls_type_riders" id="defaulter_manger_send_rider" type="button">Defaulter Manger Send Rider ({{ isset($defaulder_rider) ? $defaulder_rider->count() : '0' }})</button>
    </div>



    <div class="col-md-12 mb-3 manager_send_cls">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active"  data-status="0" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Pending Requests </a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="1"  id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">Accepted Requests </a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="2" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejected Requests</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="pending_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($riders as $rider)
                                    <tr>
                                        <th scope="row">#</th>
                                        <td>{{ $rider->check_in_request->rider_name->personal_info->full_name  }}</td>
                                        <td>{{ $rider->check_in_request->rider_name->passport_no  }}</td>
                                        <td>{{ $rider->check_in_request->rider_name->personal_info->personal_mob  }}</td>
                                        <td>{{ $rider->check_in_request->rider_name->nation->name  }}</td>
                                        <td>{{ $rider->dc_detail->name  }}</td>
                                        <td>{{ $rider->created_at->toDateString()  }}</td>
                                        <?php  $assigned = $rider->checkin_assign_platform() ?>
                                        <td>{{ isset($assigned) ? $assigned->plateformdetail->name : 'N/A'  }}</td>
                                        <td>{{  $rider->check_in_request->request_approved_by->name }}</td>
                                        <td>
                                            @if($rider->request_status=="0")

                                                @if(isset($assigned))
                                                    <a class="text-primary mr-2 accept_request_cls" id="{{ $rider->id }}"  href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
                                                @else
                                                    <h5  class="badge badge-info">Rider Checked Out</h5>
                                                @endif
                                            @else

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
                            <table class="display table table-striped table-bordered table-sm text-10" id="accepted_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
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
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejected_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--                    third tab work finished--}}

                </div>



            </div>
        </div>
    </div>


    {{-- defaulter work start --}}

    <div class="col-md-12 mb-3 defaulter_manager_send_cls" style="display:none;">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="defaulter_myTab" role="tablist">
                    <li class="nav-item" id="first_defaulter_tab"><a class="nav-link text-10 active"  data-status="4" id="defaulter_home-basic-tab" data-toggle="tab" href="#defaulter_homeBasic" role="tab" aria-controls="defaulter_homeBasic" aria-selected="true">Defaulter Pending Requests </a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="5"  id="defaulter_home-basic-new_taken" data-toggle="tab" href="#defaulter_new_taken" role="tab" aria-controls="defaulter_new_taken" aria-selected="true">Defaulter Accepted Requests </a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="6" id="defaulter_profile-basic-tab" data-toggle="tab" href="#defaulter_profileBasic" role="tab" aria-controls="defaulter_profileBasic" aria-selected="false">Defaulter Rejected Requests</a></li>
                </ul>

                <div class="tab-content" id="defaulter_myTabContent">
                    <div class="tab-pane fade show active" id="defaulter_homeBasic" role="tabpanel" aria-labelledby="defaulter_home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="defaulter_pending_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>



                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--first tab work finished--}}
                    <div class="tab-pane fade show " id="defaulter_new_taken" role="tabpanel" aria-labelledby="defaulter_home-basic-new_taken">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="defaulter_accepted_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                    {{--                    second tab work finished--}}

                    <div class="tab-pane fade show" id="defaulter_profileBasic" role="tabpanel" aria-labelledby="defaulter_profile-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="defaulter_rejected_datatable">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Dc Name</th>
                                    <th scope="col">Assigned date</th>
                                    <th scope="col">Assign Platform</th>
                                    <th scope="col">Assigned By</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--                    third tab work finished--}}

                </div>



            </div>
        </div>
    </div>
    {{-- defaulter work end --}}




    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $('body').on('click', '.accept_request_cls', function() {

            var ids = $(this).attr('id');
            $("#primary_id_selected").val(ids);
            $("#accept_modal").modal('show');
        });

        $("#reject_btn").click(function (){
          $("#select_choice").val("2");
          $("#selection_form").submit();
        });

        $("#accept_btn").click(function (){
            $("#select_choice").val("1");
            $("#selection_form").submit();
        });

        //defaulter rider accpeting code
        $('body').on('click', '.defaulter_accept_request_cls', function() {

            var ids = $(this).attr('id');
            $("#defaulter_primary_id_selected").val(ids);
            $("#defaulter_accept_modal").modal('show');
         });

         $("#defautler_reject_btn").click(function (){
          $("#defaulter_select_choice").val("2");
          $("#defautler_selection_form").submit();
        });

        $("#defaulter_accept_btn").click(function (){
            $("#defaulter_select_choice").val("1");
            $("#defautler_selection_form").submit();
        });


    </script>

    <script>
        $(".cls_type_riders").click(function(){

            var ids = $(this).attr('id');
            if(ids=="defaulter_manger_send_rider"){

                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-primary');

                $("#manger_send_rider").removeClass('btn-primary');
                $("#manger_send_rider").addClass('btn-outline-primary');

                $(".defaulter_manager_send_cls").show();
                $(".manager_send_cls").hide();

                $(".display").css("width","100%");
                   $('#defaulter_pending_datatable tbody').css("width","100%");
                   $('#container').css( 'display', 'block' );


                   $("#defaulter_home-basic-tab").addClass('active');
                   $("#defaulter_home-basic-tab").addClass('show');

                   $("#defaulter_homeBasic").addClass('active');
                   $("#defaulter_homeBasic").addClass('show');


                   $("#defaulter_home-basic-new_taken").removeClass("active");
                   $("#defaulter_home-basic-new_taken").removeClass("show");
                   $("#defaulter_new_taken").removeClass("active");
                   $("#defaulter_new_taken").removeClass("show");


                   $("#defaulter_profile-basic-tab").removeClass("active");
                   $("#defaulter_profile-basic-tab").removeClass("show");
                   $("#defaulter_profileBasic").removeClass("show");
                   $("#defaulter_profileBasic").removeClass("active");


                   var data_table_name = "defaulter_pending_datatable";

                   make_table_defaulter("defaulter_pending_datatable","4");

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();


            }else{
                $("#manger_send_rider").removeClass('btn-outline-primary');
                $("#manger_send_rider").addClass('btn-primary');

                $("#defaulter_manger_send_rider").addClass('btn-outline-primary');
                $("#defaulter_manger_send_rider").removeClass('btn-primary');

                $(".manager_send_cls").show();
                $(".defaulter_manager_send_cls").hide();

                $(".display").css("width","100%");
                   $('#pending_datatable tbody').css("width","100%");
                   $('#container').css( 'display', 'block' );




            }


        });
        </script>


   <script>
       function make_table(table_name,tab_name) {
        //    console.log(table_name);

           $.ajax({
               url: "{{ route('get_dc_to_accept_rider_table') }}",
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



       function make_table_defaulter(table_name,tab_name) {
        //    console.log(table_name);

           $.ajax({
               url: "{{ route('get_dc_to_accept_rider_for_defautler_table') }}",
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
        $(document).ready(function () {
            'use-strict'

            $('#pending_datatable').DataTable( {

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
                    {"targets": [6],"orderable": false},

                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });









            $('#defaulter_pending_datatable').DataTable({

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
                    {"targets": [6],"orderable": false},

                    ],

                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                    ],

                    // scrollY: 300,
                    responsive: true,
                    // scrollX: true,
                    // scroller: true
                    });

        });
      </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab




                var split_ab = currentTab;

                var status = $(this).attr('data-status');

                var data_table_name = "";

                if(status=="0"){
                    data_table_name = "pending_datatable";
                    make_table(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

                }else if(status=="1"){
                    data_table_name = "accepted_datatable";
                    make_table(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

                }else if(status=="2"){
                   data_table_name = "rejected_datatable";

                   make_table(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();



                }else if(status=="4"){
                   data_table_name = "defaulter_pending_datatable";

                   make_table_defaulter(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

                }else if(status=="5"){
                   data_table_name = "defaulter_accepted_datatable";
                   make_table_defaulter(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

                }else if(status=="6"){
                   data_table_name = "defaulter_rejected_datatable";

                   make_table_defaulter(data_table_name,status);

                var table = $('#'+data_table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();


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
            }
        });
    </script>




@endsection
