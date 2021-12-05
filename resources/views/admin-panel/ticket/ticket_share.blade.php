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


    </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>Queries</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

{{--                        --}}{{--accordian start--}}
{{--                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header header-elements-inline">--}}
{{--                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>--}}
{{--                                </div>--}}
{{--                                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">--}}
{{--                                    <div class="card-body">--}}

{{--                                        <div class="col-md-3 form-group mb-3 "  style="float: left;"  >--}}
{{--                                            <label for="end_date">Select Name</label>--}}
{{--                                            <select class="form-control ab_cls" name="name_id" id="name_id" >--}}
{{--                                                <option value="">select an option</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}


{{--                                        <div class="col-md-3 form-group mb-3 " style="float: left;"  >--}}
{{--                                            <label for="start_date">Start Date</label>--}}
{{--                                            <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">--}}

{{--                                        </div>--}}

{{--                                        <div class="col-md-3 form-group mb-3 "  style="float: left;"  >--}}
{{--                                            <label for="end_date">End Date</label>--}}
{{--                                            <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">--}}
{{--                                        </div>--}}

{{--                                        <input type="hidden" name="table_name" id="table_name" value="datatable" >--}}

{{--                                        <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >--}}
{{--                                            <label for="end_date" style="visibility: hidden;">End Date</label>--}}
{{--                                            <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>--}}
{{--                                            <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        {{--                      accordian end here--}}


                        <div class="table-responsive">
                            <table class="table" id="datatable">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Checked</th>
                                    <th>Sr. No</th>
                                    <th>More</th>
                                    <th>Created At</th>
                                    <th>Ticket No</th>
                                    <th>Name</th>
                                    <th>Platform</th>
                                    <th>Platform ID</th>
                                    <th>Message</th>
                                    <th>Raised for</th>
                                    <th>Processing By</th>
                                    <th>Image</th>
                                    <th>Voice</th>
                                    <th>Shared By</th>




                                </tr>
                                </thead>
                                <?php $pending_name_array = array(); ?>
                                <?php $inprocess_name_array = array(); ?>
                                <?php $closed_name_array = array(); ?>
                                <?php $reject_name_array = array(); ?>

                                    <tbody>

                                    @foreach($admin_tickets as $ticket)
                                            <tr>
                                                <th>{{$ticket->is_checked}}</th>
                                                <td>{{$ticket->id}}</td>
                                                <td>
                                                    <a class="text-success mr-2" href="{{route('show_shared',$ticket->id)}}"><i class="nav-icon i-Ticket font-weight-bold"></i></a>
                                                </td>
                                                <td>{{ $ticket->created_at }}</td>
                                                <th>{{$ticket->ticket_id}}</th>
                                                <td>{{$ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ""}}</td>
                                                <?php  $name = $ticket->user->profile ? $ticket->user->profile->passport->personal_info->full_name : ""; ?>
                                                <?php  $gamer = array(
                                                    'name' =>  $name,
                                                    'user_id' => $ticket->user_id
                                                );         ?>
                                                <?php $pending_name_array [] =  $gamer; ?>
                                                <td>{{ isset($ticket->platform_->name) ? $ticket->platform_->name : '' }}</td>
                                                <td>{{$ticket->platform_id}}</td>
                                                <td>{{$ticket->message}}</td>
                                                <td>{{isset($ticket->department->name)?$ticket->department->name:""}}</td>
                                                <td>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</td>
                                                <td>
                                                    @if(isset($ticket->image_url))
                                                    <?php
                                                        $image_url =  ltrim($ticket->image_url, $ticket->image_url[0]);
                                                    ?>
                                                        <a href="{{ url($ticket->image_url) }}" target="_blank">
                                                            <img class="rounded-circle m-0 avatar-sm-table" src="{{Storage::temporaryUrl($image_url, now()->addMinutes(5)) }}" alt="">
                                                        </a>
                                                    @else
                                                        <span class="badge badge-info">No Image</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if(isset($ticket->voice_message))
                                                    <?php
                                                        $voice_message =  ltrim($ticket->voice_message, $ticket->voice_message[0]);
                                                    ?>
                                                        <audio controls>
                                                            <source src="{{Storage::temporaryUrl($voice_message, now()->addMinutes(5)) }}" type="audio/ogg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                        {{--<a class="text-success mr-2" href="{{route('download-voice',$ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a>--}}
                                                        {{--<a download="Voice_note" class="text-success mr-2" href="{{asset($ticket->voice_message)}}" target="_blank"><i class="nav-icon i-Download font-weight-bold"></i></a>--}}
                                                    @else
                                                        <span class="badge badge-info">No Voice</span>
                                                    @endif


                                                </td>
                                                <td>{{$sent_by}}</td>


                                                {{--                                    <td>--}}
                                                {{--                                       --}}
                                                {{--                                        <a class="text-success mr-2" href="{{route('manage_ticket.show',$ticket->id)}}"><i class="nav-icon i-Ticket font-weight-bold"></i></a>--}}
                                                {{--                                    </td>--}}
                                            </tr>

                                    @endforeach
                                    </tbody>



                            </table>
                        </div>













                    </div><!-------tab3----->

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
                                { "width": 600, "targets": [8] },
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
                            { "width": 600, "targets": [8] },
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
                            { "width": 600, "targets": [8] },
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
                                { "width": 600, "targets": [8] },
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
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $pending_name_array))); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach
                return ab_html;
        }

        function in_process_name_dropdown(){
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $inprocess_name_array))); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach

                return ab_html;
        }

        function close_name_dropdown(){
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $closed_name_array))); ?>
                <?php // dd($data); ?>
                @foreach($data as $gamer)
                ab_html += '<option value="{{ $gamer['user_id']}}">{{ $gamer['name'] }}</option>';
            @endforeach
                return ab_html;
        }

        function reject_name_dropdown(){
            var ab_html = "";
            <?php $data = array_map('unserialize', array_unique(array_map('serialize', $reject_name_array))); ?>
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
                    url: "{{ route('ajax_ticket_filter_share') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"0", _token:token},
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
                                    { "width": 600, "targets": [8] },
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
                    url: "{{ route('ajax_ticket_filter_share') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"2", _token:token},
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
                                    { "width": 600, "targets": [8]},
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
                    url: "{{ route('ajax_ticket_filter_share') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"1", _token:token},
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
                                    { "width": 600, "targets": [8]},
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
                    url: "{{ route('ajax_ticket_filter_share') }}",
                    method: 'POST',
                    data: {name_id: name_id,start_date:start_date,end_date:end_date, table_checked :"3", _token:token},
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
                                    { "width": 600, "targets": [8]},
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
