@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'reports-menu-items']) }}">COD Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">City Wise Talabat COD</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top mb-2"></div>
    <div class="row card-body pb-2">
        <div class="col-12">
            <div class="form-group col-4 offset-4">
                <h4 class="text-center">
                    Talabat Riders' COD
                    {{-- {{ auth()->user()->hasRole(['Admin']) ? "All Ridiers COD" : " All " . auth()->user()->name . "'s Riders COD" }} --}}
                </h4>
            </div>
            <div class="form-group col-4 float-right">
                <label for="start_date">COD Date</label>
                <input name="start_date" id="start_date" class="form-control form-control-sm" type="date" value="{{ $last_cod !== null ? $last_cod->start_date : date('Y-m-d') }}"/>
                <a id="uploaded_file_path" href="{{ $last_cod->file_path }}" class="float-right" target="_blank">( Download uploded Sheet )</a>
            </div>
            @if(!auth()->user()->hasRole('DC_roll'))
            <div class="form-group col-4 float-right">
                <label for="dc_id">DC List</label>
                <select name="dc_id" id="dc_id" class="form-control form-control-sm select2">
                    <option value=""></option>
                    <option value="all">All</option>
                    @foreach ($dc_users as $user)
                        <option value="{{ $user->id }}">{{ ucFirst($user->name ?? "") }}</option>
                    @endforeach
                    {{-- <option value="no_dc">No DC</option> --}}
                </select>
            </div>
            @endif
            <div class="form-group col-4 float-right">
                <label for="adjustment_type">Internal COD Adjustments</label>
                <select name="adjustment_type" id="adjustment_type" class="form-control form-control-sm select2">
                    {{-- <option value=""></option> --}}
                    <option value="1">With Internal COD Adjustment</option>
                    <option value="2">Without Internal COD Adjustment</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 text-center" >
            <button class="btn btn-primary btn-sm ajax_talabat_user_wise_riders_cod_buttons"
                data-get_button_url="{{ route('ajax_talabat_user_wise_riders_cod_buttons',['type' =>'cod_collection_buttons'])}}" >
                Collections (
                <span id="cod_collection_sum">{{ number_format($selected_date_cods_sum, 2) }}</span> AED /
                <span id="cod_collection_count">{{ $selected_date_cods_count }}</span> )
            </button>
            <button class="btn btn-info btn-sm ajax_talabat_user_wise_riders_cod_buttons"
                data-get_button_url="{{ route('ajax_talabat_user_wise_riders_cod_buttons',['type' =>'cod_balance_buttons'])}}">
                Balances (
                <span id="cod_balance_sum">{{ number_format($selected_date_balance_sum, 2) }}</span> AED /
                <span id="cod_balance_count">{{ $selected_date_cods_count }}</span> )
            </button>
            <div id="cod_buttons_holder"></div>
            <div id="codReportTableHolder"></div>
        </div>
    </div>
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.ajax_talabat_user_wise_riders_cod_buttons').click(function(){
            $("body").addClass("loading");
            var url = $(this).attr('data-get_button_url') +
                '&start_date=' + $("#start_date").val() +
                '&adjustment_type=' + $("#adjustment_type").val() +
                '&dc_id=' + $('#dc_id').val();
            $.ajax({
                url,
                success: function(response){
                    $('#cod_buttons_holder').empty()
                    $('#codReportTableHolder').empty()
                    $('#cod_buttons_holder').append(response.html)
                    $('#cod_collection_count').text(response.cod_count)
                    $('#cod_balance_count').text(response.cod_count)
                    $('#cod_collection_sum').text(response.selected_date_cods_sum)
                    $('#cod_balance_sum').text(response.selected_date_balance_sum)
                    $('#uploaded_file_path').attr('href', response.uploaded_file_path)
                    $("body").removeClass("loading");
                }
            });
        });
        $('#start_date , #dc_id, #adjustment_type').change(function(){
            $('.ajax_talabat_user_wise_riders_cod_buttons')[0].click();
        });
    </script>
    <script>
        $('.select2').select2({
            placeholder: "Select to filter result"
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
