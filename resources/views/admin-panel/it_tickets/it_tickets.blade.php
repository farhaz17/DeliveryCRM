@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .modal-content {
            width: 700px;
        }
        .remarks {
            text-align: justify;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>IT Tickets</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">New</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false"> Accept</a></li>
        <li class="nav-item"><a class="nav-link" id="reject-basic-tab" data-toggle="tab" href="#rejectBasic" role="tab" aria-controls="rejectBasic" aria-selected="false">Reject</a></li>
        <li class="nav-item"><a class="nav-link" id="process-basic-tab" data-toggle="tab" href="#processBasic" role="tab" aria-controls="processBasic" aria-selected="true">Complete</a></li>
    </ul>
    <br><br><br>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="table" id="datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>

                                    <th>Sent By</th>
                                    <th>Message</th>
                                    <th>Image</th>
                                    <th>File</th>
                                    <th>Date & Time</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($it_tickets as $ticket)
                                   @if($ticket->status==0)

                                    <tr>

                                        <td>{{$ticket->user_name->name}}</td>
                                        <td class="remarks">{{$ticket->message}}</td>
                                        <td>
                                            @if(isset($ticket->img))
                                                <a href="{{ url($ticket->img) }}" target="_blank">
                                                    <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($ticket->img) }}" alt="">
                                                </a>
                                            @else
                                                <span class="badge badge-info">No Image</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if(isset($ticket->file))
                                                <a href="{{ url($ticket->file) }}" target="_blank">
                                                    <i class="text-20 i-Add-File"></i></a>
                                                </a>
                                            @else
                                                <span class="badge badge-info">No Image</span>
                                            @endif

                                        </td>
                                        <td>{{$ticket->created_at}}</td>
                                        <td class="remarks">{{$ticket->remarks}}</td>
                                        <td>
                                            <button class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="it_ticketStart({{$ticket->id}})" type="button">Accept</button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="it_ticketNot({{$ticket->id}})" type="button">Reject</button>
                                            <button class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-sm-2" onclick="it_ticketComplete({{$ticket->id}})" type="button">Complete</button>

                                        </td>



                                @endif
                                @endforeach
                                </tbody>


                            </table>
                        </div>



                    </div>
                    <!----tab2---------->

                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="table-responsive">

                                <table class="table" id="datatable_close" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>

                                        <th>Sent By</th>
                                        <th>Message</th>
                                        <th>Image</th>
                                        <th>File</th>
                                        <th>Date & Time</th>
                                        <th>Remarks</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($it_tickets as $ticket)
                                        @if($ticket->status==1)

                                        <tr>

                                            <td>{{$ticket->user_name->name}}</td>
                                            <td class="remarks">{{$ticket->message}}</td>
                                            <td>
                                                @if(isset($ticket->img))
                                                    <a href="{{ url($ticket->img) }}" target="_blank">
                                                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($ticket->img) }}" alt="">
                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No Image</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if(isset($ticket->file))
                                                    <a href="{{ url($ticket->file) }}" target="_blank">
                                                        <i class="text-20 i-Add-File"></i></a>
                                                @else
                                                    <span class="badge badge-info">No File</span>
                                                @endif

                                            </td>
                                            <td>{{$ticket->created_at}}</td>
                                            <td class="remarks">{{$ticket->remarks}}</td>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm-3" onclick="it_ticketNew({{$ticket->id}})" type="button">New</button>
                                                <button class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-sm-2" onclick="it_ticketComplete({{$ticket->id}})" type="button">Complete</button>
                                            </td>



                                    @endif
                                    @endforeach
                                    </tbody>


                                </table>
                        </div>







                    </div><!-------tab2----->

                    <div class="tab-pane fade" id="rejectBasic" role="tabpanel" aria-labelledby="reject-basic-tab">
                        <div class="table-responsive">

                                <table class="table" id="datatable_reject" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>

                                        <th>Sent By</th>
                                        <th>Message</th>
                                        <th>Image</th>
                                        <th>File</th>
                                        <th>Date & Time</th>
                                        <th>Remarks</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($it_tickets as $ticket)
                                        @if($ticket->status==2)

                                        <tr>

                                            <td>{{$ticket->user_name->name}}</td>
                                            <td class="remarks">{{$ticket->message}}</td>
                                            <td>
                                                @if(isset($ticket->img))
                                                    <a href="{{ url($ticket->img) }}" target="_blank">
                                                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($ticket->img) }}" alt="">
                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No Image</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if(isset($ticket->file))
                                                    <a href="{{ url($ticket->file) }}" target="_blank">
                                                        <i class="text-20 i-Add-File"></i>                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No File</span>
                                                @endif

                                            </td>
                                            <td>{{$ticket->created_at}}</td>
                                            <td class="remarks">{{$ticket->remarks}}</td>
                                            <td>

                                                <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm-3" onclick="it_ticketNew({{$ticket->id}})" type="button">New</button>


                                            </td>



                                    @endif
                                    @endforeach
                                    </tbody>


                                </table>
                        </div>







                    </div><!-------tab3----->

                    {{--                        <li class="nav-item"><a class="nav-link" id="process-basic-tab" data-toggle="tab" href="#processBasic" role="tab" aria-controls="processBasic" aria-selected="true">In Process</a></li>--}}


                    <div class="tab-pane fade" id="processBasic" role="tabpanel" aria-labelledby="process-basic-tab">
                        <div class="table-responsive">

                                <table class="table" id="datatable_process" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>

                                        <th>Sent By</th>
                                        <th>Message</th>
                                        <th>Image</th>
                                        <th>File</th>
                                        <th>Date & Time</th>
                                        <th>Remarks</th>
                                        <th>Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($it_tickets as $ticket)
                                        @if($ticket->status==3)

                                        <tr>

                                            <td>{{$ticket->user_name->name}}</td>
                                            <td class="remarks">{{$ticket->message}}</td>
                                            <td>
                                                @if(isset($ticket->img))
                                                    <a href="{{ url($ticket->img) }}" target="_blank">
                                                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($ticket->img) }}" alt="">
                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No Image</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if(isset($ticket->file))
                                                    <a href="{{ url($ticket->file) }}" target="_blank">
                                                        <i class="text-20 i-Add-File"></i>
                                                    </a>
                                                @else
                                                    <span class="badge badge-info">No File</span>
                                                @endif

                                            </td>
                                            <td>{{$ticket->created_at}}</td>

                                            <td class="remarks">{{$ticket->remarks}}</td>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm-3" onclick="it_ticketNew({{$ticket->id}})" type="button">New</button>

                                            </td>


                                    @endif
                                    @endforeach
                                    </tbody>


                                </table>
                        </div>



                    </div>



                </div>








            </div>
        </div>
    </div>
{{--    modals--}}
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket Start Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Remarks</label>
                            <textarea class="form-control" name="remarks" id="" cols="30" rows="5"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="start_Submit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="not_doing" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket Reject Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Remarks</label>
                            <textarea class="form-control" name="remarks" id="" cols="30" rows="5"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="notDoing_Submit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-sm-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="complete" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket Complete Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Remarks</label>
                            <textarea class="form-control" name="remarks" id="" cols="30" rows="5"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="complete_Submit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="new" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Ticket New Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Remarks</label>
                            <textarea class="form-control" name="remarks" id="" cols="30" rows="5"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="new_Submit()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    { "width": 300, "targets": [1] },
                    { "width": 300, "targets": [6] },
                    { "width": 300, "targets": [5] },


                ],
                "scrollY": false,
                "scrollX": true,

                //
            });


        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_close').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    { "width": 300, "targets": [1] },
                    { "width": 300, "targets": [6] },
                    { "width": 300, "targets": [5] },



                ],
                "scrollY": false,
                "scrollX": true,

                //
            });


        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_reject').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    { "width": 300, "targets": [1] },
                    { "width": 300, "targets": [6] },
                    { "width": 300, "targets": [5] },


                ],
                "scrollY": false,
                "scrollX": true,

                //
            });


        });
        $(document).ready(function () {
            'use strict';

            $('#datatable_process').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [6],"visible": false},
                    { "width": 300, "targets": [1] },
                    { "width": 300, "targets": [6] },
                    { "width": 300, "targets": [5] },



                ],
                "scrollY": false,
                "scrollX": true,

                //
            });


        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
// alert(currentTab)
                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable_close').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="process-basic-tab"){
                    var table = $('#datatable_process').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{
                    var table = $('#datatable_reject').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
        });


        function it_ticketStart(id)
        {
            var id = id;
            var url = '{{ route('it_ticket_start', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function start_Submit()
        {
            $("#updateForm").submit();

        }


        function it_ticketNot(id)
        {
            var id = id;
            var url = '{{ route('it_ticket_not_doing', ":id") }}';
            url = url.replace(':id', id);

            $("#not_doing").attr('action', url);
        }

        function notDoing_Submit()
        {
            $("#not_doing").submit();

        }


        function it_ticketComplete(id)
        {
            var id = id;
            var url = '{{ route('it_tickete_complete', ":id") }}';
            url = url.replace(':id', id);

            $("#complete").attr('action', url);
        }

        function complete_Submit()
        {
            $("#complete").submit();

        }


        function it_ticketNew(id)
        {
            var id = id;
            var url = '{{ route('it_ticket_new', ":id") }}';
            url = url.replace(':id', id);

            $("#new").attr('action', url);
        }

        function new_Submit()
        {
            $("#new").submit();

        }



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
