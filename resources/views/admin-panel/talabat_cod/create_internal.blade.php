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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cod_dashboard_new',['active'=>'operations-menu-items']) }}">COD Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Talabat COD Upload Internal</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            @if(Session::has('message'))
                <!-- Modal -->
                @php
                    $missing_courier_names = array_filter(explode(',',session()->get('missing_courier_names')));
                    $missing_rider_ids = array_filter(explode(',',session()->get('missing_rider_ids')));
                    $missing_cities = array_filter(explode(',',session()->get('missing_cities')));
                @endphp
                @if($missing_rider_ids)
                <div class="modal fade" id="TalabatMissingRiderIdModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
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
                                    <table class="table table-sm table-hover text-10" id="TalabatMissingRiderIddatatable" width='100%'>
                                        <thead>
                                            <tr>
                                                <td>Courier Name</td>
                                                <td>RiderID</td>
                                                <td>City</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ( $missing_rider_ids as $key => $missing_rider_id)
                                                <tr>
                                                    <td>{{ $missing_courier_names[$key] ?? "NA"}}</td>
                                                    <td>{{ $missing_rider_ids[$key] }}</td>
                                                    <td>{{ $missing_cities[$key] ?? "NA"}}</td>
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
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-md-12 row m-auto">

            {{-- talabat Cod form section starts --}}
            <div class="card col-md-12 border">
                <div class="card-body">
                    <div class="card-title">Talabat COD Upload Form ( Internal )</div>
                    <form method="post" enctype="multipart/form-data" action="{{ route('talabat_cod_internal') }}"  aria-label="{{ __('Upload') }}" >
                        @csrf
                        <div class="col-md-4 form-group mb-3 " style="float: left;"  >
                            <label for="start_date">Start Date</label>
                            <select class="form-control form-control-sm select2" name="start_date" id="start_date">
                                <option value="">Select Actual COD Date</option>
                                @foreach ($talabat_cod_dates as $talabat_cod_date)
                                    <option value="{{ $talabat_cod_date->start_date }}">{{ $talabat_cod_date->start_date }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-4 form-group mb-3 " style="float: left;"  >
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-sm" id="start_date" required>
                        </div> --}}
                        <div class="col-md-4 form-group"  style="float: left;" >
                            <label for="end_date">File for Cod Upload</label>
                            <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" />
                        </div>
                        <div class="col-md-2 form-group"  style="float: left;" >
                            <a href="{{ asset('assets/sample/Cod/talabat_cod/talabat_cod_internal_sample.xlsx') }}" class="float-right" target="_blank">( Download Sample File )</a>
                        </div>
                        <div class="col-md-4 form-group"  style="float: right;" >
                            &nbsp;
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <button class="btn btn-sm btn-info float-right" name="upload_or_delete" type="submit" value="upload">Upload</button>
                            <button class="btn btn-sm btn-danger float-right mr-2" onclick="return confirm('Are you sure to delete the date cod?')" name="upload_or_delete" type="submit" value="delete">Delete</button>
                        </div>
                    </form>
                </div>
                {{-- we will use this snipped if we need individual missing rider id list --}}
                {{-- @if(Session::has('message') && ($missing_rider_ids))
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button type ='button' class="btn btn-block btn-sm btn-danger mt-2 mr-3 float-right" data-toggle="modal" data-target="#TalabatMissingRiderIdModal">Show missing Rider Ids</button>
                        </div>
                    </div>
                </div>
                @endif --}}
            </div>
            {{-- talabat Cod form section ends --}}

            {{-- talabat Cod deduction form section starts --}}
            {{-- <div class="card col-md-6 border"> --}}
                {{-- <div class="card-body">
                    <div class="card-title">Talabat COD Deductions Upload Form</div>
                    <form method="post" enctype="multipart/form-data" action="{{ route('talabat_cod_deduction') }}"  aria-label="{{ __('Upload') }}" >
                        @csrf
                        <div class="col-md-4 form-group mb-3 " style="float: left;"  >
                            <label for="deduction_start_date">Start Date</label>
                            <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-sm" id="deduction_start_date" required>
                        </div>
                        <div class="col-md-4 form-group"  style="float: left;" >
                            <label for="end_date">File for deduction upload</label>
                            <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" />
                        </div>
                        <div class="col-md-4 form-group"  style="float: right;" >
                            &nbsp;
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <button class="btn btn-sm btn-info float-right" name="upload_or_delete" type="submit" value="upload">Upload</button>
                            <button class="btn btn-sm btn-danger float-right mr-2" onclick="return confirm('Are you sure to delete the date cod deductions ?')" name="upload_or_delete" type="submit" value="delete">Delete</button>
                        </div>
                    </form>
                </div> --}}
                 {{-- we will use this snipped if we need individual missing rider id list --}}
                {{-- @if(Session::has('message') && ($missing_rider_ids))
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button type ='button' class="btn btn-block btn-sm btn-danger mt-2 mr-3 float-right" data-toggle="modal" data-target="#TalabatMissingRiderIdModal">Show missing Rider Ids</button>
                        </div>
                    </div>
                </div>
                @endif --}}
            {{-- </div> --}}
            {{-- talabat Cod deduction form section ends --}}

        </div>
    </div>
    @if(Session::has('message') && ($missing_rider_ids))
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <button type ='button' class="btn btn-block btn-sm btn-danger mt-2 mr-3 float-right" data-toggle="modal" data-target="#TalabatMissingRiderIdModal">Show missing Rider Ids</button>
            </div>
        </div>
    </div>
    @endif
    <div class="row pb-2">
        <div class="col-md-12 card-title">Talabat Internal COD Calender</div>
        <div class="col-md-12" id="render_calender"></div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        // tail.DateTime("#start_date",{
        //     dateFormat: "YYYY-mm-dd",
        //     timeFormat: false,
        // }).on("change", function(){
        //     tail.DateTime("#end_date",{
        //         dateStart: $('#start_date').val(),
        //         dateFormat: "YYYY-mm-dd",
        //         timeFormat: false
        //     }).reload();
        // });
    </script>
    <script>
        tail.DateTime("#deduction_start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        });
    </script>
    <script>
        @if(Session::has('message') && ($missing_rider_ids))
            $(window).on('load', function() {
                $('#TalabatMissingRiderIdModal').modal('show');
                $('#TalabatMissingRiderIddatatable').DataTable( {
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
        $('.select2').select2({
            placeholder: 'Select an actual cod date'
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
        function  make_calender() {
            $("#render_calender").html("");
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('render_calender_talabat_internal_cod') }}",
                method: 'POST',
                data: {_token:token},
                success: function(response) {
                    $("#render_calender").html(response);
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

    <script>
        $(document).ready(function () {
            setTimeout( function(){
                $('.fc-rigid').css('height','70px !important');
                $('.fc-toolbar').css('height','70px !important');
            },1000);
            make_calender()
        });
    </script>
@endsection
