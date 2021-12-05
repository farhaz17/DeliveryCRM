@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/ladda-themeless.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

         /* loading image css starts */
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

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        /* loading image css ends */

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
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">Operations (Need to modify)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rider Performance Settings</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-3 text-center">Generate Rider Performance</div>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- @dd($perdivance_settings) --}}
                                <div class="form-group">
                                    <label for="rider_performance_settings_id">Select Performance Setting</label>
                                    <select class="form-control form-control-sm select2" id="rider_performance_settings_id" name="rider_performance_settings_id" required>
                                        <option value="">Select settings</option>
                                        @foreach ($performance_settings as $performance_setting)
                                            <option value="{{ $performance_setting->id}}">
                                                Platform: {{ $performance_setting->platform->name ?? "NA" }} |
                                                Name: {{ $performance_setting->setting_name ?? "NA" }} |
                                                Description: {{ $performance_setting->setting_description ?? "NA" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control form-control-sm" autocomplete="off" type="text" name="start_date" id="start_date">
                                </div>
                            </div>
                            <div class="col-md-2" id="">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control form-control-sm" autocomplete="off" type="text" name="end_date" id="end_date">
                                </div>
                            </div>
                            {{-- <div class="col-md-2" id="rider_performance_date_holder">
                                <div class="form-group">
                                    <label for="platform_id">Select Performance Date</label>
                                    <select class="form-control form-control-sm select2" id="platform_id" name="platform_id" required>
                                        <option value="">Select Performance Date</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-info btn-sm ladda-button basic-ladda-button" data-style="expand-right" id="generate_performance" >
                                        <span class="ladda-label">Generate Performance</span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                        <span class="ladda-spinner"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2" id="generated_report_heading_holder"></div>
                            <div class="col-md-12 mt-2" id="generated_report_body_holder"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/ladda.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/ladda.script.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script>
        tail.DateTime("#end_date",{
           dateFormat: "YYYY-mm-dd",
           timeFormat: false
       })
        tail.DateTime("#start_date",{
           dateFormat: "YYYY-mm-dd",
           timeFormat: false,
            startOpen: true,
            dateRanges: [
            {
                start: new Date(2021, 09, 19),
                end: new Date(2021, 09, 20)
                /* days: true */                // This is the default
            },

            // Will Disable Each Sunday and Saturday in FEB
            // {
            // start: new Date(2018, 1, 1),
            // end: new Date(2018, 1, 28),
            // days: ["SUN", "SAT"]
            // },

            // Will Disable Each Sunday and Saturday in General
            // {
            // days: ["SUN", "SAT"]
            // }
        ]
       }).on("change", function(){
           tail.DateTime("#end_date",{
               dateStart: $('#start_date').val(),
               dateFormat: "YYYY-mm-dd",
               timeFormat: false
           }).reload();
       });
   </script>
    <script>
        $('#rider_performance_settings_id').change(function(){
            $('#generated_report_heading_holder').empty();
            $('#rider_performance_date_holder').empty();
            $('#generated_report_body_holder').empty();
            var rider_performance_settings_id = $(this).val();
            $.ajax({
                url: "{{ route('rider_performance_report_generate_details') }}",
                data: { rider_performance_settings_id },
                success: function(response){
                    $('#generated_report_heading_holder').append(response.column_settings);
                    $('#rider_performance_date_holder').append(response.performance_dropdowns);
                    $('.select2').select2({
                        placeholder: "Select an option"
                    });
                },
            });
        });

        $('#generate_performance').click(function(){
            $('#generated_report_body_holder').empty();
            var l = Ladda.create(this); l.start();
            var rider_performance_settings_id = $('#rider_performance_settings_id').val();
            var performance_id = $('#performance_id').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var columns = [];
            $('.column_checkboxes:checked').each(function(i, v){
                columns.push(v.value);
            });
            $.ajax({
                url: "{{ route('rider_performance_report_generate_load') }}",
                data: { rider_performance_settings_id, performance_id, columns, start_date, end_date},
                success: function(response){
                    if(response['status'] == '500'){
                        tostr_display(response['alert-type'], response['message'])
                    }
                    $('#generated_report_body_holder').append(response.performance_table);
                    $('.select2').select2({
                        placeholder: "Select an option"
                    });
                },
            })
            .always(function(){
                l.stop()
            });
        });
    </script>
    <script>
        $('.select2').select2({
            placeholder: "Select an option"
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
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
                }
            }
    </script>
@endsection
