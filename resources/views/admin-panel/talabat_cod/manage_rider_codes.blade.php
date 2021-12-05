@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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
        <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
        <li class="breadcrumb-item active" aria-current="page">DC Wise Rider List</li>
    </ol>
</nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                @if(!@auth()->user()->hasRole(['DC_roll']))
                <div class="card-body">
                    @foreach ($dcs->chunk(6) as $dc)
                    <div class="row m-auto pb-1 text-center">
                        @foreach ($dc as $c)
                        <div class="col-2">
                            <a class="btn btn-block btn-sm manage_rider_codes btn-info" href="{{ route('get_dc_rider_with_codes', ['dc_id' => $c->id]) }}">{{ ucFirst($c->name) }} ( {{$c->riders_count}} )</a>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @endif
                <div class="card-body" id="dc_riders_with_code">
                    <p class="text-center">Click any DC name to load Riders</p>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    @if(@auth()->user()->hasRole(['DC_roll']))
    {{-- @if (@auth()->user()->desination_type !== 3) --}}
    <script>
        $(document).ready(function(){
            $("body").addClass("loading");
            $.ajax({ url: "{{ route('get_dc_rider_with_codes', ['dc_id' => auth()->user()->id] ) }}",
                context: document.body,
                success: function(response){
                    $('#dc_riders_with_code').empty()
                    $('#dc_riders_with_code').append(response.html)
                    $("body").removeClass("loading");
                }});
        });
        </script>
        @endif
    <script>
        $('.manage_rider_codes').click(function(e){
            e.preventDefault();
            $("body").addClass("loading");
            url = $(this).attr('href');
            $.ajax({
                url,
                success: function(response){
                    $('#dc_riders_with_code').empty()
                    $('#dc_riders_with_code').append(response.html)
                }
            });
        });
    </script>

    <script>
        $('.rider_code_update_button').click(function(){
            $('#current_platform_code').val($(this).attr('data-platform_code'))
            $('#platform_code_id').val($(this).attr('data-platform_code_id'))
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
