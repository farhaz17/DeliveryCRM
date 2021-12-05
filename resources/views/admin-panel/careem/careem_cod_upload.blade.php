@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Careem</a></li>
        <li>Careem Upload</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 form-group mb-3">
    <div class="card-title">
        <a href="{{ asset('assets/sample/Careem_Sample/careem.xlsx') }}" target="_blank">
            (Download Sample File)
        </a>
    </div>
</div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="card-title">Careem COD Upload</div>

            <form method="post" enctype="multipart/form-data" action="{{ route('careem_cod.store') }}"  aria-label="{{ __('Upload') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="start_date">Start Date</label>
                        <input type="text" name="start_date"  autocomplete="off" class="form-control form-control" id="start_date" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="end_date">End Date</label>
                        <input type="text" name="end_date"  autocomplete="off" class="form-control form-control" id="end_date" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="file">File Upload</label>
                        <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input  class="btn btn-primary" type="submit" value="Upload" name="upload_or_delete">
                        <button class="btn btn btn-danger mr-2" name="upload_or_delete" type="submit" value="delete" name="upload_or_delete">Delete</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="row pb-2" >
    <div class="col-md-12" id="render_calender">

    </div>
</div>

@if(Session::has('message'))
    <!-- Modal -->
    @php
        $missing_rider_ids = array_filter(explode(',',session()->get('missing_rider_ids')));
        $missing_rider_names = array_filter(explode(',',session()->get('missing_rider_names')));
    @endphp
    @if($missing_rider_ids)
    <div class="modal fade" id="CareemMissingRiderIdModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="ModalTitle">Unregistered Rider IDs</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                    <p class="m-0">{{ count(explode(',',session()->get('missing_rider_ids'))) . " rider ids are requested to register first before upload the sheet after registering you can upload the sheet. "}}
                        If you have the authority to register click <a class="btn btn-link" target="_blank" href="{{ route('usercodes') }}">here</a> to go to the registration page.
                    </p>
                    </div>
                    <div class="responsive">
                        <table class="table table-sm table-hover text-10" id="CareemMissingRiderIddatatable" width='100%'>
                            <thead>
                                <tr>
                                    <td>RiderID</td>
                                    <td>Rider Name</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $missing_rider_ids as $key => $missing_rider_id)
                                    <tr>
                                        <td>{{ $missing_rider_ids[$key] }}</td>
                                        <td>{{ $missing_rider_names[$key] ?? "NA"}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script type="text/javascript">
        @if(Session::has('message') && ($missing_rider_ids))
            $(window).on('load', function() {
                $('#CareemMissingRiderIdModal').modal('show');
                $('#CareemMissingRiderIddatatable').DataTable( {
                    "aaSorting": [[0, 'desc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Missing Riders',
                            text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                            exportOptions: {
                                modifier: {
                                    page : 'all',
                                }
                            }
                        },
                    ],
                });
            });

        @endif
    </script>
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
    </script>
    <script>
        $(document).ready(function (){

            var ids = 4;
            $("#render_calender").html("");
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('careem_render_calender') }}",
                method: 'POST',
                data: {platform_id: ids ,_token:token},
                success: function(response) {
                    $("#render_calender").html(response);
                }
            });
        });
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function () {
            setTimeout( function(){
                $('.fc-rigid').css('height','70px !important');
                $('.fc-toolbar').css('height','70px !important');
                console.log("we are here");
            },1000);
            make_calender()
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
