@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <style>
        .links_ticket_type .nav-link {
            padding: 7px;
        }
        .form-group label{
            color : #865eaf;
        }
        .form-group p{
            margin-bottom: -5px;
        }
     </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Tickets</a></li>
            <li>All Tickets</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    upload agreement signed modal--}}
    <div class="modal fade bd-example-modal-sm" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="edit_form" action="{{ route('upload_signed_agreement') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}



                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Upload Signed Agreement</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {!! csrf_field() !!}

                                        <div class="row ">
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="repair_category">Upload Signed Agreement</label>
                                                <input type="file" class="form-control" name="image" required>
                                            </div>

                                        </div>

                                    </div>
                                </div>
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

    {{--  end  upload agreement signed modal --}}




    <div class="col-md-12 mb-3">
        <div class="card mt-2 mb-4">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs links_ticket_type" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pending</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Process</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Closed</a>
                        <a class="nav-item nav-link" id="nav-rejected-tab" data-toggle="tab" href="#nav-rejected" role="tab" aria-controls="nav-contact" aria-selected="false">Rejected</a>
                    </div>
                </nav>
                <div class="tab-content ul-tab__content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


                                     @foreach($tickets_pending as $ticket)
                            <div class="card" style="margin-bottom: 9px">
                                <div class="card-body">
                                     <div class="form-group">
                                         <label>Ticket Number</label>
                                         <p>{{ $ticket->ticket_id }}</p>
                                     </div>
                                     <div class="form-group">
                                         <label>Created At</label>
                                         @php $date_c = explode(" ",$ticket->created_at) @endphp
                                         <p>{{ $date_c['0'] }}</p>
                                     </div>
                                     <div class="form-group">
                                         <label>Raised to</label>
                                         <p>{{isset($ticket->department->name)?$ticket->department->name:""}}</p>
                                     </div>

                                     <div class="form-group">
                                         <label>Process by</label>
                                         <p>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</p>
                                     </div>
                                </div>
                            </div>
                                   @endforeach




                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                                @foreach($tickets_process as $ticket)
                            <div class="card " style="margin-bottom: 9px">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Ticket Number</label>
                                        <p>{{ $ticket->ticket_id }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Created At</label>
                                        @php $date_c = explode(" ",$ticket->created_at) @endphp
                                        <p>{{ $date_c['0'] }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Raised to</label>
                                        <p>{{isset($ticket->department->name)?$ticket->department->name:""}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Process by</label>
                                        <p>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</p>
                                    </div>

                                    <div class="form-group text-right">
                                        <a href="{{ route('ticket_chat',$ticket->id) }}" class="btn btn-outline-success m-1" type="button">Chat</a>
                                    </div>

                                </div>
                            </div>
                                @endforeach


                    </div>

                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                        @foreach($tickets_closed as $ticket)
                            <div class="card " style="margin-bottom: 9px">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Ticket Number</label>
                                        <p>{{ $ticket->ticket_id }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Created At</label>
                                        @php $date_c = explode(" ",$ticket->created_at) @endphp
                                        <p>{{ $date_c['0'] }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Raised to</label>
                                        <p>{{isset($ticket->department->name)?$ticket->department->name:""}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Process by</label>
                                        <p>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">

                        @foreach($ticket_rejected as $ticket)
                            <div class="card  " style="margin-bottom: 9px">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Ticket Number</label>
                                        <p>{{ $ticket->ticket_id }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Created At</label>
                                        @php $date_c = explode(" ",$ticket->created_at) @endphp
                                        <p>{{ $date_c['0'] }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Raised to</label>
                                        <p>{{isset($ticket->department->name)?$ticket->department->name:""}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Process by</label>
                                        <p>{{isset($ticket->current_department->name)?$ticket->current_department->name:""}}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach


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
    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#datatable_part_time ,#datatable_taking_visa').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],

                scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });



        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }) ;
        });

        $(".upload_agreement_cls").click(function(){

            var ids = $(this).attr('id');

            $("#primary_id").val(ids);

            $("#edit_modal").modal('show');

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
