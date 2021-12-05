@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

@endsection
@section('content')
    <style>
        .buttons-page-length{
            margin-left:20px !important;
        }
        .status_text{
            font-weight: bold;
        }
        .view_btn_cls{
            width: 70px;
            font-size: 9px;
        }


    </style>

{{--    approve ticket modal--}}
    <div class="modal fade bd-example2-modal-sm-3" tabindex="-1" style="z-index: 9999;"  role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('approve_ticket_save') }}" id="form_management" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to .?
                    </div>
                    <input type="hidden" name="primary_id" id="primary_id" value>
                    <input type="hidden" name="status" id="status_ab" value>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2 status_btn" id="3"  type="button" >Reject</button>
                        <button class="btn btn-success ml-2 status_btn" id="2" type="button" >Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--    approve ticket modal end--}}

{{--    assign To management modal--}}
    <div class="modal fade assign_modal" tabindex="-1" role="dialog"style="z-index: 9999;" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('approve_ticket_save') }}" id="assingn_management" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to .?
                    </div>
                    <input type="hidden" name="primary_id" id="primary_id_assign" value>
                    <input type="hidden" name="status" id="status_assign" value>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success ml-2 assign_btn" id="4" type="button" >Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{--    assing to management End--}}

{{--view chat history modal--}}
    <div class="modal fade bd-example-modal-lg-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Ticket Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="main_modal_now">


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>Queries</li>
        </ul>
    </div>

    <button style="display: none" id="modal_btn_show" class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".bd-example2-modal-sm-3"  style="background-color: #dddddd78 !important; " type="button">Assign To Management</button>
    <button style="display: none" id="modal_btn_show_assign" class="btn btn-raised btn-raised-secondary m-1" data-toggle="modal" data-target=".assign_modal"  style="background-color: #dddddd78 !important; " type="button">Assign To Management</button>

    <div class="modal fade bd-example2-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('approve_ticket_save') }}" id="form_management" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        Are you sure want to .?
                    </div>
                    <input type="hidden" name="primary_id" id="primary_id" value>
                    <input type="hidden" name="status" id="status_ab" value>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2 status_btn" id="9"  type="button" >Reject</button>
                        <button class="btn btn-success ml-2 status_btn" id="8" type="button" >Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <div class="card-body">
                    <div class="card-title">Pending Approval</div>
                    @foreach($pending_tickets as $ticket)
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3  border-bottom" >
                            <div class="flex-grow-1">
                                <a   href="javascript:void(0)" id="{{ $ticket->id }}" class="view_btn_cls btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm float-right">View details</a>
                                <h6><a href="">#{{ $ticket->ticket_id }}</a></h6>


               <?php if($pending_logs->contains('ticket_id', $ticket->id)){ ?>
                <?php  $log_collection  = $pending_logs->where('ticket_id', $ticket->id)->first(); ?>

                <p class="text-small text-danger m-0">{{ isset($log_collection->type) ?  $log_collection->type : 'N/A'}}
                    <span class="text-dark status_text">{{ isset($log_collection->user->name) ? $log_collection->user->name : 'N/A' }}</span>
                </p>
               <?php } ?>

                                <p class="text-small text-danger m-0">status
                                    <span class="text-dark status_text">{{ $array_status[$ticket->is_checked] }}</span>
                                </p>
                            </div>
                            <div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <div class="card-body">
                    <div class="card-title">Approved Tickets</div>

                    @foreach($aproved_tickets as $ticket)
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3  border-bottom" >
                            <div class="flex-grow-1">
                                <a   href="javascript:void(0)" id="{{ $ticket->id }}" class="view_btn_cls btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm float-right">View details</a>
                                <h6><a href="">#{{ $ticket->ticket_id }}</a></h6>

                                <?php if($approved_logs->contains('ticket_id', $ticket->id)){ ?>
                                <?php  $log_collection  = $approved_logs->where('ticket_id', $ticket->id)->first(); ?>

                                <p class="text-small text-danger m-0">{{ isset($log_collection->type) ?  $log_collection->type : 'N/A'}}
                                    <span class="text-dark status_text">{{ isset($log_collection->user->name) ? $log_collection->user->name : 'N/A' }}</span>
                                </p>
                                <?php } ?>

                                <p class="text-small text-danger m-0">status
                                    <span class="text-dark status_text">{{ $array_status[$ticket->is_checked] }}</span>
                                </p>
                            </div>
                            <div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <div class="card-body">
                    <div class="card-title">Assigned To Manager</div>
                    @foreach($assign_manager as $ticket)
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3  border-bottom" >
                            <div class="flex-grow-1">
                                <a   href="javascript:void(0)" id="{{ $ticket->id }}" class="view_btn_cls btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm float-right">View details</a>
                                <h6><a href="">#{{ $ticket->ticket_id }}</a></h6>

                                <?php if($assign_manager_logs->contains('ticket_id', $ticket->id)){ ?>
                                <?php  $log_collection  = $assign_manager_logs->where('ticket_id', $ticket->id)->first(); ?>

                                <p class="text-small text-danger m-0">{{ isset($log_collection->type) ?  $log_collection->type : 'N/A'}}
                                    <span class="text-dark status_text">{{ isset($log_collection->user->name) ? $log_collection->user->name : 'N/A' }}</span>
                                </p>
                                <?php } ?>

                                <p class="text-small text-danger m-0">status
                                    <span class="text-dark status_text">{{ $array_status[$ticket->is_checked] }}</span>
                                </p>
                            </div>
                            <div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <div class="card-body">
                    <div class="card-title">Rejected Ticket</div>

                    @foreach($rejected_tickets as $ticket)
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3  border-bottom" >
                            <div class="flex-grow-1">
                                <a   href="javascript:void(0)" id="{{ $ticket->id }}" class="view_btn_cls btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm float-right">View details</a>
                                <h6><a href="">#{{ $ticket->ticket_id }}</a></h6>

                                <?php if($rejected_logs->contains('ticket_id', $ticket->id)){ ?>
                                <?php  $log_collection  = $rejected_logs->where('ticket_id', $ticket->id)->first(); ?>

                                <p class="text-small text-danger m-0">{{ isset($log_collection->type) ?  $log_collection->type : 'N/A'}}
                                    <span class="text-dark status_text">{{ isset($log_collection->user->name) ? $log_collection->user->name : 'N/A' }}</span>
                                </p>
                                <?php } ?>

                                <p class="text-small text-danger m-0">status
                                    <span class="text-dark status_text">{{ $array_status[$ticket->is_checked] }}</span>
                                </p>
                            </div>
                            <div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>





    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Update Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        Are you sure want to Update the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="updateSubmit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#process_start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#process_end_date",{
                dateStart: $('#process_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();
        });

        tail.DateTime("#close_start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#close_end_date",{
                dateStart: $('#close_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();
        });

        tail.DateTime("#reject_start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#reject_end_date",{
                dateStart: $('#reject_start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();
        });
    </script>


    <script>
        $(".view_btn_cls").click(function(){
            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_ticket_chat') }}",
                method: 'POST',
                data: {ticket_id: ids, type:'team', _token:token},
                success: function(response) {

                    $('#main_modal_now').empty();
                    $('#main_modal_now').append(response.html);
                }
            });

$(".bd-example-modal-lg-history").modal('show');

        });
    </script>

{{--    reject and approve coding--}}
    <script>
        $(document).on('click', '.update_btn', function(){
            $("#modal_btn_show").click();
            var ids = $(this).attr('id');
            $("#primary_id").val(ids);

        });

        $(".status_btn").click(function(){
            var ids = $(this).attr('id');

            $("#status_ab").val(ids);

            $("#form_management").submit();
        });
    </script>




    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {

                    "pageLength": 10,

                    "lengthMenu": [
                        [10, 25, 50, -1],
                        ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                    ],

                    "columnDefs": [
                        {"targets": [0],"visible": false},
                        { "width": 600, "targets": [8] },

                    ],
                    "dom": 'Bfrtip',

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


        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_close').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    // {"targets": [2],"visible": false},
                    { "width": 600, "targets": [8] },

                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Closed Tickets',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                "scrollY": false,
                "scrollX": true,

                //
            });


        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_reject').DataTable({
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [2],"visible": false},
                    { "width": 600, "targets": [8] },

                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Rejected Tickets',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                "scrollY": false,
                "scrollX": true,

            });


        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
// alert(currentTab)
                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){
                    var ab_table = $('#datatable').DataTable();
                    ab_table.destroy();


                    var table = $('#datatable').DataTable(
                        {   "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                                { "width": 600, "targets": [9] },
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
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }

                else if(split_ab=="profile-basic-tab"){

                    var ab_table = $('#datatable_close').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable_close').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                        ],
                        "columnDefs": [
                            {"targets": [0],"visible": false},
                            // {"targets": [2],"visible": false},
                            { "width": 600, "targets": [9] },
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Closed Tickets',
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

                    });
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="process-basic-tab"){

                    var ab_table = $('#datatable_process').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable_process').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                        ],
                        "columnDefs": [
                            {"targets": [0],"visible": false},
                            { "width": 600, "targets": [9] },
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Process Tickets',
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
                    });
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{

                    var ab_table = $('#datatable_reject').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable_reject').DataTable(
                        {
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
                                // {"targets": [2],"visible": false},
                                { "width": 600, "targets": [9] },
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Rejected Tickets',
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
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
        });


        function updateData(id)
        {
            var id = id;
            var url = '{{ route('ticket.update', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function updateSubmit()
        {
            $("#updateForm").submit();
        }



    </script>


    <script>
        function pending_name_dropdown(){

            var ab_html = "";
            <?php //$data = array_map('unserialize', array_unique(array_map('serialize', $pending_name_array))); ?>
                <?php $data = array(); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach
                return ab_html;
        }

        function in_process_name_dropdown(){
            var ab_html = "";
            <?php //$data = array_map('unserialize', array_unique(array_map('serialize', $inprocess_name_array))); ?>
                <?php $data = array(); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach

                return ab_html;
        }

        function close_name_dropdown(){
            var ab_html = "";
            <?php // $data = array_map('unserialize', array_unique(array_map('serialize', $closed_name_array))); ?>
                <?php $data = array(); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach
                return ab_html;
        }

        function reject_name_dropdown(){
            var ab_html = "";
            <?php //$data = array_map('unserialize', array_unique(array_map('serialize', $reject_name_array))); ?>
                <?php $data = array(); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach
                return ab_html;
        }

        $(document).ready(function () {

            $(".collapse_cls_pending").click(function(){
                $("#name_id").empty();
                $("#name_id").append('<option value="">Select an option</option>');
                $("#name_id").append(pending_name_dropdown());
                $('#name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width','100%');
            });

            $(".collapse_cls_process").click(function(){
                $("#process_name_id").empty();
                $("#process_name_id").append('<option value="">Select an option</option>');
                $("#process_name_id").append(in_process_name_dropdown());
                $('#process_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width','100%');
            });

            $(".collapse_cls_close").click(function(){
                $("#close_name_id").empty();
                $("#close_name_id").append('<option value="">Select an option</option>');

                $("#close_name_id").append(close_name_dropdown());
                $('#close_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width','100%');
            });

            $(".collapse_cls_reject").click(function(){
                $("#reject_name_id").empty();
                $("#reject_name_id").append('<option value="">Select an option</option>');

                $("#reject_name_id").append(reject_name_dropdown());
                $('#reject_name_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width','100%');
            });




            $("#remove_apply_filter").click(function(){

                $('#name_id').val(null).trigger('change');
                $("#start_date").val("");
                $("#end_date").val("");
                $("#apply_filter").click();

            });


            $("#apply_filter").click(function(){
                var passport_id = $(this).val();
                var name_id  =   $("#name_id option:selected").val();
                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('approve_ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"0", type:"management", _token:token},
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable').DataTable();
                        ab_table.destroy();

                        $('#datatable tbody').empty();
                        $('#datatable tbody').append(response.html);

                        var table = $('#datatable').DataTable(
                            {   "pageLength": 10,
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                ],
                                "columnDefs": [
                                    {"targets": [0],"visible": false},
                                    { "width": 600, "targets": [9] },
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
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }
                });
            });

            //pending end here


            //process ticket filter start here

            $("#process_remove_apply_filter").click(function(){
                $('#process_name_id').val(null).trigger('change');
                $("#process_start_date").val("");
                $("#process_end_date").val("");
                $("#prcess_apply_filter").click();
            });

            $("#prcess_apply_filter").click(function(){
                var name_id  =   $("#process_name_id option:selected").val();
                var start_date  =   $("#process_start_date").val();
                var end_date  =   $("#process_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('approve_ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"2", type:'management', _token:token},
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_process').DataTable();
                        ab_table.destroy();

                        $('#datatable_process tbody').empty();
                        $('#datatable_process tbody').append(response.html);

                        var table = $('#datatable_process').DataTable(
                            {   "pageLength": 10,
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                ],
                                "columnDefs": [
                                    {"targets": [0],"visible": false},
                                    { "width": 600, "targets": [9]},
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
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }
                });
            });
            //process filter end here


            //Closed ticket filter start here

            $("#close_remove_apply_filter").click(function(){
                $('#close_name_id').val(null).trigger('change');
                $("#close_start_date").val("");
                $("#close_end_date").val("");
                $("#close_apply_filter").click();
            });

            $("#close_apply_filter").click(function(){

                var name_id  =   $("#close_name_id option:selected").val();
                var start_date  =   $("#close_start_date").val();
                var end_date  =   $("#close_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('approve_ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"1", type:"management", _token:token},
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_close').DataTable();
                        ab_table.destroy();

                        $('#datatable_close tbody').empty();
                        $('#datatable_close tbody').append(response.html);

                        var table = $('#datatable_close').DataTable(
                            {   "pageLength": 10,
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                ],
                                "columnDefs": [
                                    {"targets": [0],"visible": false},
                                    { "width": 600, "targets": [9]},
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
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }
                });
            });
            //Closed filter end here



            //Rejected ticket filter start here

            $("#reject_remove_apply_filter").click(function(){
                $('#reject_name_id').val(null).trigger('change');
                $("#reject_start_date").val("");
                $("#reject_end_date").val("");
                $("#reject_apply_filter").click();
            });

            $("#reject_apply_filter").click(function(){

                var name_id  =   $("#reject_name_id option:selected").val();
                var start_date  =   $("#reject_start_date").val();
                var end_date  =   $("#reject_end_date").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('approve_ajax_ticket_filter') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"3", type:'management', _token:token},
                    success: function(response) {
                        // $("#datatable").tbody.empty();
                        var ab_table = $('#datatable_reject').DataTable();
                        ab_table.destroy();

                        $('#datatable_reject tbody').empty();
                        $('#datatable_reject tbody').append(response.html);

                        var table = $('#datatable_reject').DataTable(
                            {   "pageLength": 10,
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                ],
                                "columnDefs": [
                                    {"targets": [0],"visible": false},
                                    { "width": 600, "targets": [9]},
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
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }
                });
            });

            //Closed filter end here
        });

    </script>

    {{--    //reject or approved script start--}}
    <script>
        $(document).on('click', '.update_btn', function(){
            $("#modal_btn_show").click();
            var ids = $(this).attr('id');
            $("#primary_id").val(ids);

        });



        $(document).on('click','.assingn_btn',function () {

            $("#modal_btn_show_assign").click();
            var ids = $(this).attr('id');
            $("#primary_id").val(ids);

            assign_modal

        });



        $(".assign_btn").click(function(){
            var ids = $(this).attr('id');
            $("#status_assign").val(ids);
            $("#assingn_management").submit();
        });

        $(".status_btn").click(function(){
            var ids = $(this).attr('id');

            $("#status_ab").val(ids);

            $("#form_management").submit();
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
