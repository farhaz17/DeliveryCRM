@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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
        /* loading image ends */
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Rider Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rider Activity Logs</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body pb-0">
                <form action="" id="bike_search_form" method="get">
                    <div class="col-12">
                        <label for="passport_id"></label>
                        <select class="form-control form-control-sm select2" id="passport_id" name="passport_id">
                            <option value="">Search Rider Name and Passport</option>
                            @foreach ($all_riders as $rider)
                                <option {{ $rider->id == request('passport_id') ? 'selected' : '' }} value="{{ $rider->id }}">
                                    {{ $rider->personal_info->full_name }} {{" | " .  $rider->passport_no ?? '' }} {{" | " .  $rider->pp_uid ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="tab-content" id="myTabContent">
                    <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped text-10" id="RunningBikesTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Date & Time</th>
                                        <th>Event Name</th>
                                        <th>Event Type</th>
                                        <th>Event Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_rider_histories as $history)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $history['date_time'] }}</td>
                                            <td>{{ $history['event_name'] }}</td>
                                            <td>{{ $history['event_type'] }}</td>
                                            <td>{!! $history['event_desctiption'] !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#RunningBikesTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [[0, 'desc']],
                "pageLength": 60,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [$(this).children('tr').children('td').length-1],"width": ""} // last column width for all tables
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Status wise vehicle summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                "scrollY": true,
            });
        });
    </script>
    <script>
        $('#passport_id').select2({
            placeholder: 'Search Rider Name and Passport'
        })
        $('#passport_id').change(function(){
            $("body").addClass("loading");
            $('#bike_search_form').submit();
        })
    </script>
    <script>
        $(window).load(function(){
            setTimeout(function(){
                $("body").removeClass("loading");
            },500);
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
