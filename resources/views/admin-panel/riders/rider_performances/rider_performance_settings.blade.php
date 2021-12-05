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
            <li class="breadcrumb-item"><a href="{{ route('performance_setting') }}">Performance Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rider Performance Settings</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-3 text-center">Rider Performance Settings</div>
                    <form action="{{ route('store_rider_performance_settings') }}" method="POST">
                        @csrf
                        <div class="row border-bottom mb-2">
                            <div class="col-md-3 offset-1 form-group">
                                <label for="setting_name">Setting name</label>
                                <input class="form-control form-control-sm" id="setting_name" name="setting_name" type="text" placeholder="Enter setting name"  required>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="platform_id">Select Platform</label>
                                <select class="form-control form-control-sm select2" id="platform_id" name="platform_id" required>
                                    <option value="">Select Platform</option>
                                    @foreach ($platforms as $platform)
                                        <option value="{{ $platform['platform_id'] }}">{{ $platform['platform_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3" id="selected_platform_columns_holder">
                                <label for="platform_columns">Selected Platform Columns</label>
                                <select
                                        class="form-control form-control-sm select2"
                                        {{-- name="platform_columns[]" --}}
                                        id="platform_columns"
                                        multiple
                                        required
                                    >
                                    <option value="">Select Columns</option>
                                </select>
                            </div>
                            <div class="col-md-1 form-group mb-3">
                                <br>
                                <button class="btn btn-info btn-sm ladda-button basic-ladda-button" disabled data-style="expand-right" id="load_column_settings_button">
                                    <span class="ladda-label">Load columns</span>
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
                        <div class="row">
                            <div class="col-md-10 offset-1" id="column_settings_holder">
                                <h1 class="font-weight-bold pt-2 text-15 text-center text-light">Click Load selected columns button to load columns settings</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1 form-group">
                                <label for="setting_description">Description</label>
                                <textarea
                                    class="form-control form-control-sm"
                                    aria-label="Enter Setting Description"
                                    placeholder="Enter Setting Description"
                                    id="setting_description"
                                    name="setting_description"
                                ></textarea>
                            </div>
                            <div class="col-md-10 offset-1 form-group mb-3">
                                <br>
                                <button class="btn btn-info btn-sm float-right">Register Performance Settings</button>
                            </div>
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
        $('#platform_id').change(function(){
            $('#column_settings_holder').empty();
            $('#column_settings_holder').append(`<h1 class="font-weight-bold pt-2 text-15 text-center text-light">Click Load selected columns button to load columns settings</h1>`);

            var platform_id = $(this).val();
            $.ajax({
                url: "{{ route('ajax_load_selected_platform_columns') }}",
                data: { platform_id },
                success: function(response){
                    $('#selected_platform_columns_holder').empty();
                    $('#selected_platform_columns_holder').append(response.html);
                    $('#load_column_settings_button').prop('disabled', true);
                    $('.select2').select2({
                        placeholder: "Select an option"
                    });

                }
            });
        });
        $('#load_column_settings_button').click(function(){
            var l = Ladda.create(this);
            l.start();
            var selected_platform_id = $('#selected_platform_id').val();
            var columns = $('#platform_columns').val();
            $.ajax({
                url: "{{ route('ajax_rider_performance_platform_columns_setting') }}",
                data: {selected_platform_id, columns},
                success: function(response){
                    $('#column_settings_holder').empty();
                    $('#column_settings_holder').append(response.html);
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
@endsection
