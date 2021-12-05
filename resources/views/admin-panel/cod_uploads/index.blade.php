@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
            <li><a href="">Upload COD Sheets</a></li>
            <li>Deliveroo COD Upload</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 form-group mb-3">
        <div class="card-title">
            <a href="{{ asset('assets/sample/Cod/cod_sample.xlsx') }}" target="_blank">
                (Download Sample File)
            </a>
        </div>
    </div>

    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" enctype="multipart/form-data" action="{{ route('cod_uploads.store') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}

                        {{-- <div class="col-md-3 form-group mb-3 float-left">
                            <label for="repair_category">Select Platform</label>
                            <select id="platform_id"  name="platform_id" class="form-control">
                              <option value="" selected disabled > Select Platform </option>
                                @foreach($platforms as $plt)
                              <option value="{{ $plt->id }}" >{{ $plt->name }}</option>
                                @endforeach

                            </select>
                        </div> --}}

                        <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date" required>
                        </div>

                        <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date" required>
                        </div>

                        <div class="col-md-3 form-group"  style="float: left;" >
                            <label for="end_date">Browse File</label>
                                <input class="form-control" id="select_file" type="file" name="select_file" />
                        </div>


                            <div class="col-md-12 form-group mb-3 "  style="float: left;"  >
                            <input  class="btn btn-primary" type="submit" value="Upload" name="upload_or_delete">
                            <button class="btn btn btn-danger mr-2" name="upload_or_delete" type="submit" value="delete" name="upload_or_delete">Delete</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="row pb-2" >--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row pb-2" >
        <div class="col-md-12" id="render_calender">

        </div>
    </div>

    @if(Session::has('message'))
    <!-- Modal -->
    @php
        $missing_rider_ids = array_filter(explode(',',session()->get('missing_rider_ids')));
    @endphp
    @if($missing_rider_ids)
    <div class="modal fade" id="DeliverooMissingRiderIdModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
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
                        <table class="table table-sm table-hover text-10" id="DeliverooMissingRiderIddatatable" width='100%'>
                            <thead>
                                <tr>
                                    <td>RiderID</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $missing_rider_ids as $key => $missing_rider_id)
                                    <tr>
                                        <td>{{ $missing_rider_ids[$key] }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        @if(Session::has('message') && ($missing_rider_ids))
            $(window).on('load', function() {
                $('#DeliverooMissingRiderIdModal').modal('show');
                $('#DeliverooMissingRiderIddatatable').DataTable( {
                    "aaSorting": [[0, 'desc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'DC Riders',
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
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });

        });


        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
        //-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();


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
        $(document).ready(function (){

            var ids = 4;

            $("#render_calender").html("");

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('render_calender') }}",
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
    {!! $calendar->script() !!}
    <script>
        $(document).ready(function () {
            setTimeout( function(){
                $('.fc-rigid').css('height','70px !important');
                $('.fc-toolbar').css('height','70px !important');

                console.log("we are here");
            },1000);
        });
    </script>


@endsection
