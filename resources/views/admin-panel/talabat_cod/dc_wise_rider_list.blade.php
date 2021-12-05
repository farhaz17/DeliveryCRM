@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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
        <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
        <li class="breadcrumb-item active" aria-current="page">DC Wise Rider List</li>
    </ol>
</nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(in_array(1, @auth()->user()->user_group_id))
                        @foreach ($dcs->chunk(6) as $dc)
                        <div class="row m-auto pb-1 text-center">
                            @foreach ($dc as $c)
                            <div class="col">
                                <a class="btn btn-info btn-block btn-sm" href="{{ route('manage_rider_codes', ['dc_id' => $c->id]) }}">{{ $c->name }} ( {{$c->riders_count}} )</a>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">

                        <li class="nav-item">
                            <a class="nav-link" id="AllDCRidersTab" data-toggle="tab" href="#AllDCRiders" role="tab" aria-controls="AllDCRiders" aria-selected="false">All DC Riders ( {{$all_dc_riders->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="MissingIDRidersTab" data-toggle="tab" href="#MissingIDRiders" role="tab" aria-controls="MissingIDRiders" aria-selected="true">Missing ID Riders( {{ $id_missing_riders->count() ?? 0}} )
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="AllDCRiders" role="tabpanel" aria-labelledby="AllDCRidersTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="AllDCRidersTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Name</th>
                                            <th class="filtering_column">Platform Name</th>
                                            <th class="filtering_column">RiderID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($all_dc_riders as $rider)
                                        <tr>
                                            <td>{{ $rider->rider_passport_id }}</td>
                                            <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ $rider->platform->name ?? "" }}</td>
                                            <td>{{ $rider->passport->get_the_rider_id_by_platform($rider->platform_id)
                                                   ? $rider->passport->get_the_rider_id_by_platform($rider->platform_id)->platform_code
                                                   : "Missing ID" }}</td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane show active" id="MissingIDRiders" role="tabpanel" aria-labelledby="MissingIDRidersTab">
                            <div class="table-responsive">
                                <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                                    @csrf
                                    <table class="table table-sm table-hover text-11" id="MissingIDRidersTable">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>ppuid</th>
                                                <th>Name</th>
                                                <th class="filtering_column" >Platform Name</th>
                                                <th class="text-center">Add Talabat RiderID Below</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($id_missing_riders as $rider)
                                            <tr>
                                                <td>{{ $rider->rider_passport_id }}</td>
                                                <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                                                <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                                                <td>{{ $rider->platform->name ?? "" }}</td>
                                                <td>
                                                    <div class="row row-xs">
                                                        <div class="col-md-12">
                                                            <input type="number" name="platform_code[]"class="form-control form-control-sm platform_code" placeholder="Enter Rider ID">
                                                            <input type="hidden" name="passport_id[]" value="{{ $rider->rider_passport_id }}">
                                                            <input type="hidden" name="platform_id[]" value="{{ $rider->platform_id ?? "" }}">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse

                                        </tbody>
                                    </table>
                                    @if($id_missing_riders->count() > 0)
                                            <button class="btn btn-info btn-sm btn-block" type="submit">Add missing RiderId</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use-strict',
            $('#AllDCRidersTable, #MissingIDRidersTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex)
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
                "pageLength": 10,
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
