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
        <li><a href="">Upload SALIK Sheets</a></li>
        <li>Upload SALIK</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" >
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <a href="{{ asset('assets/sample/Salik/1606811205_.xls') }}" download target="_blank">(Download Sample File)</a><br><br>
                <form method="post" enctype="multipart/form-data" action="{{ route('salik_uploads.store') }}" aria-label="{{ __('Upload') }}" >
                    @csrf
                    <div class="col-md-5 form-group" style="float: left;" >
                        <label for="end_date">Browse File</label>
                        <input class="form-control-file" id="select_file" type="file" name="select_file" />
                    </div>
                    <div class="co-md-7 form-group" style="float: left;">
                        @if(isset($salik_last_date->start_date))
                            <h5 class="text-center mb-3 font-weight-bold">Last Uploaded Sheet Dates: <span class="text-success" id="start_date_div" >{{ $salik_last_date->start_date }} </span><span id="div_to">TO</span><span class="text-success" id="end_date_div"> {{ $salik_last_date->end_date }}</span>
                            <br>
                            Company name: <span class="text-primary" id="company_name_div">{{ isset($salik_last_date->get_company_info->company_detail->name) ? $salik_last_date->get_company_info->company_detail->name : 'N/A' }}</span>
                            </h5>
                        @else
                            <h5 class="text-center mb-3 font-weight-bold" style="display: none;" >
                                Company name: <span class="text-primary" id="company_name_div"></span>
                            </h5>
                        @endif
                    </div>
                    <div class="col-md-12 form-group" style="float: left;">
                        <input class="btn btn-info btn-sm" type="submit" name="upload_or_delete" value="Upload">
                        <button class="btn btn-danger btn-sm" id="delete_btn" type="button">Delete</button>
                    </div>
                    <div class="row soft" style="display: none;">
                        <div class="col-md-4 form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" autocomplete="off" class="form-control form-control-sm" id="start_date" >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" autocomplete="off" class="form-control form-control-sm" id="end_date" >
                        </div>
                        <div class="col-md-4 form-group">
                            <button class="btn btn btn-danger btn-sm" name="upload_or_delete" type="submit" value="delete" style="margin-top: 20px;">Delete</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div><br>

<div class="row" >
    <div class="col-md-12" id="render_calender">
    </div>
</div>

<div class="row pb-2">
    <div class="col-md-12">
        @if(Session::has('message'))
            <!-- Modal -->
            @php
                $missing_plate = array_filter(explode(',',session()->get('missing_plate')));
            @endphp
            @if($missing_plate)
            <div class="modal fade" id="MissingBikeModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="ModalTitle">Upload Failed!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <p class="m-0 font-weight-bold">These Plate numbers are not available in the system. Kindly add following Plate numbers to upload bills</p>
                            </div>
                            <div class="responsive">
                                <table class="table table-sm table-hover text-10" id="MissingBikedatatable" width='100%'>
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Plate No</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ( $missing_plate as $key => $missing_plate)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td class='font-weight-bold'>{{ $missing_plate }}</td>
                                            </tr>
                                            @php
                                                $count++;
                                            @endphp
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
    <div class="col-md-12">
        @if(Session::has('message'))
            <!-- Modal -->
            @php
                $uploaded_sheets = array_filter(explode(',',session()->get('uploaded_sheet')));
                $id = array_filter(explode(',',session()->get('id')));
                $account = array_filter(explode(',',session()->get('account')));
            @endphp
            @if($uploaded_sheets)
            <div class="modal fade" id="UploadedSheetModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('delete_salik') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalTitle">Warning!</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger">
                                    <p class="m-0 font-weight-bold">There are multiple files uploaded in this date range. Select the file which you want to delete.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for=""><b>Account No</b></label>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for=""><b>Sheet</b></label>
                                    </div>
                                </div>
                                @foreach ( $uploaded_sheets as $key => $uploaded_sheet)
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-info">
                                                <input type="radio" name="sheet_id" id="id" value="{{ $id[$key] }}"><span>{{ $account[$key] }}</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <a href="{{ Storage::temporaryUrl($uploaded_sheets[$key], now()->addMinutes(5)) }}" id="download_btn" class="download_link">Download File</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" >Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
<div class="row pb-2">
    <div class="col-md-12">
        @if(Session::has('message'))
            <!-- Modal -->
            @php
                $duplicate_plate = session()->get('duplicate_plate');
            @endphp
            @if($duplicate_plate)
            <div class="modal fade" id="DuplicateModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('update_duplicate_salik') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalTitle">Warning!</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger">
                                    <p class="m-0 font-weight-bold">These plate number has multiple record. Select the plate which you want to upload.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for=""><b>Plate No</b></label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for=""><b>Chassis No</b></label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for=""><b>Engine No</b></label>
                                    </div>
                                </div>
                                @foreach ($duplicate_plate as $key => $duplicate)
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-info">
                                                <input type="checkbox" class="radio" value="{{ $duplicate->id }}" name="details[{{$duplicate->plate_no}}][bike_id]" />
                                                <span>{{ $duplicate->plate_no }}</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {{ isset($duplicate->chassis_no) ? $duplicate->chassis_no : '' }}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {{ isset($duplicate->engine_no) ? $duplicate->engine_no : '' }}
                                    </div>
                                    <input type="hidden" name="details[{{$duplicate->plate_no}}][transaction_id]" value="{{$duplicate['salik_details']['transaction_id']}}">
                                    <input type="hidden" name="details[{{$duplicate->plate_no}}][account_number]" value="{{$duplicate['salik_details']['account_number']}}">
                                    <input type="hidden" name="details[{{$duplicate->plate_no}}][transaction_post_date]" value="{{$duplicate['salik_details']['transaction_post_date']}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info" type="submit" >Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script>
        $("input:checkbox").on('click', function() {

        var $box = $(this);
        if ($box.is(":checked")) {
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
        });
    </script>
    <script>
        $('#DuplicateModal').modal({
            backdrop: 'static',
            keyboard: false
        })
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
    <script type="text/javascript">
        @if(Session::has('message') && ($missing_plate))
            $(window).on('load', function() {
                $('#MissingBikeModal').modal('show');
                $('#MissingBikedatatable').DataTable( {
                    "aaSorting": [[0, 'asc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Missing Plate',
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
    <script type="text/javascript">
        @if(Session::has('message') && ($duplicate_plate))
            $(window).on('load', function() {
                $('#DuplicateModal').modal('show');
            });
        @endif
    </script>
    @if(Session::has('message'))
    <script type="text/javascript">
            $(window).on('load', function() {
                $('#UploadedSheetModal').modal('show');
                $('#UploadedSheetdatatable').DataTable( {
                    "aaSorting": [[0, 'asc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Missing Plate',
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
    </script>
    @endif
    <script>
        $('#delete_btn').click(function(){
            $('.soft').show(500);
            $('#delete_btn').hide(500);
        });
    </script>
    <script>
        $(document).ready(function (){

            $("#render_calender").html("");
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('salik_render_calender') }}",
                method: 'POST',
                data: {_token:token},
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
