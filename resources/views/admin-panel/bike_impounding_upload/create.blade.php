@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

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
            <li><a href="">Upload Bike Impounding Sheets</a></li>
            <li>Upload Forms</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a href="{{ asset('assets/sample/bike_impounding/bike_impounding.xlsx') }}" download target="_blank">(Download Sample File)</a>
                    </div>

                    @if(isset($salik_last_date->start_date))
                        <h5 class="text-center mb-3 font-weight-bold" id="div_complete">Last Uploaded Sheet Dates: <span class="text-success" id="start_date_div" >{{ $salik_last_date->start_date }}</span> <span id="div_to">TO</span> <span class="text-success" id="end_date_div">{{ $salik_last_date->end_date }}</span>
                            <br>
                            Company name: <span class="text-primary" id="company_name_div">{{ isset($salik_last_date->get_company_info->company_detail->name) ? $salik_last_date->get_company_info->company_detail->name : 'N/A' }}</span>
                        </h5>
                    @else
                        <h5 class="text-center mb-3 font-weight-bold" style="display: none;"  id="div_complete" >
                            Company name: <span class="text-primary" id="company_name_div"></span>
                        </h5>
                    @endif



                    <form method="post" enctype="multipart/form-data" action="{{ route('bike_impounding.store') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}



                        <div class="col-md-3 form-group"  style="float: left;" >
                            <label for="end_date">Browse File</label>
                            <input class="form-control" id="select_file" type="file" name="select_file" />
                        </div>


                        <div class="col-md-12 form-group mb-3 "  style="float: left;"  >
                            <input  class="btn btn-primary" type="submit" value="Upload">
                        </div>


                    </form>
                </div>
                <div style="font-weight:900; font-size:16px; margin-left:32px" class="mb-3">Or</div>
                    <div>
                        <form method="post" action="{{ route('single-bike-impounding') }}">
                            @csrf
                            <div class="row ml-4 mr-4">
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Plate Number</label>
                                    <select id="bike" name="plate_no" class="form-control bike">
                                        <option value="">Select option</option>
                                        @foreach ($plates as $bike)
                                        <option value="{{ $bike->plate_no }}">
                                        {{ $bike->plate_no }} | {{ $bike->chassis_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Plate Category</label>
                                    <select id="bike" name="plate_category" class="form-control bike">
                                        <option value="">Select option</option>
                                        @foreach ($vehicle_plate_codes as $bike)
                                        <option value="{{ $bike->plate_code }}">
                                        {{ $bike->plate_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Ticket Number</label>
                                    <input id="" name="ticket_number" class="form-control" type="text">
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Ticket Date</label>
                                    <input id="" name="ticket_date" class="form-control" type="date">
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Ticket Time</label>
                                    <input id="" name="ticket_time" class="form-control" type="time">
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Value Instead of Booking</label>
                                    <input id="" name="value" class="form-control" type="number">
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">No of Days</label>
                                    <input id="" name="no_days" class="form-control" type="number">
                                </div>
                                <div class="col-3 mt-2">
                                    <label for="repair_category">Text Violation</label>
                                    <textarea name="text_violation" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-3" style="margin-top:32px">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class=" text-left">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Upload Date</th>
                                    <th scope="col">Total value instead booking</th>
                                    <th scope="col">Total Count</th>
                                    <th scope="col">Uploaded File</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bike_uploads as $bike)
                                    <tr>
                                        <td>{{ $bike->created_at->toDateString() }}</td>
                                        <td>{{ $bike->total_bike_instead_booking() }}  </td>
                                        <td>{{ $bike->bike_impounding_count() }}  </td>
                                        <td>
                                            <a href="{{ isset($bike->file_path)  ? url($bike->file_path) : '#' }}"  class="font-weight-bold"  id="download-{{ $bike->id }}"  download  >download file</a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
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
    </script>



    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable_not_employee').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [1],"width": "25%"}
                ],
                "scrollY": false,
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });

            $('#account_number').select2({
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
        $("#platform_id").change(function (){

            var ids = $(this).val();

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

    <script>
        $("#account_number").change(function () {

            var ids = $(this).val();

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_company_name') }}",
                method: 'POST',
                data: {id: ids ,_token:token},
                success: function(response) {
                    var  array = JSON.parse(response);

                    $("#div_complete").show();
                    $("#company_name_div").html(array.name);
                    $("#start_date_div").html(array.start_date);
                    $("#end_date_div").html(array.end_date);
                }
            });

        });
        $('#bike').select2({
            placeholder: 'Select a Bike'
        });
    </script>





@endsection
