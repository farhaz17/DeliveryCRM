@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="card col-12"> {{-- DC Wise Rider Orders Analysis --}}
            <div class="card-header text-white text-11 bg-secondary p-2 m-0">DC Wise Rider Orders Analysis ( {{$dcs->where('id', request('id'))->first()->name ?? "Click DC to See attendance" }} )</div>
            <div class="card-body row">
            <div class="col-2 border">
                <div class="row">
                    <div class="card-body row m-auto pt-1">
                        <b class="item-name">DC List</b>
                        @foreach ($dcs->chunk(6) as $row)
                        <div class="row">
                            @foreach ($row as $dc)
                            <div class="col-12 mb-1">
                                <div class="bg-{{ $dc->id != request('id') ? 'info' : 'success' }}">
                                    <a href="{{ route('dc_dashboard',['id'=>$dc->id]) }}" class="btn btn-sm btn-block text-center text-white">
                                        <span class="item-name">{{ ucFirst($dc->name) }}</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col">
                <div>
                    <canvas id="DCWiseRiderOrdersAnalysis"></canvas>
                </div>
            </div>
            <div class="col-3">
                <b>Today's Orders</b>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i>
                                    Today's Rider Orders
                                    <span class="float-right">
                                        ( {{ $rider_order_chart_data['datasets'][0]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info" style="background: #663399 !important">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i>
                                    {{-- Today's Riders Joined
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][1]['data'][date('Y-m-d')] }} )
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info" style="background: #10163a !important">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i>
                                    {{-- Today's Riders Left
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][2]['data'][date('Y-m-d')] }} )
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-success">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Checked-User" style="font-size: 1rem;"></i>
                                    {{-- Today's Present Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][3]['data'][date('Y-m-d')] }} )
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-warning">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Remove-User" style="font-size: 1rem;"></i>
                                    {{-- Today's Leave Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][4]['data'][date('Y-m-d')] }} )
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-danger">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Geek" style="font-size: 1rem;"></i>
                                    {{-- Today's Absent Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][5]['data'][date('Y-m-d')] }} )
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="card col-12">  {{-- DC Wise Riders Attendance Analysis --}}
            <div class="card-header text-white text-11 bg-secondary p-2 m-0">DC Wise Riders Attendance Analysis ( {{$dcs->where('id', request('id'))->first()->name ?? "Click DC to See attendance" }} )</div>
            <div class="card-body row">
            <div class="col-2 border">
                <div class="row">
                    <div class="card-body row m-auto pt-1">
                        <b class="item-name">DC List</b>
                        @foreach ($dcs->chunk(6) as $row)
                        <div class="row">
                            @foreach ($row as $dc)
                            <div class="col-12 mb-1">
                                <div class="bg-{{ $dc->id != request('id') ? 'info' : 'success' }}">
                                    <a href="{{ route('dc_dashboard',['id'=>$dc->id]) }}" class="btn btn-sm btn-block text-center text-white">
                                        <span class="item-name">{{ ucFirst($dc->name) }}</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col">
                <div>
                    <canvas id="DCWiseRidersAnalysis"></canvas>
                </div>
            </div>
            <div class="col-3">
                <b>Today's Attendance Records</b>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i>
                                    Today's Riders Assigned
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][0]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info" style="background: #663399 !important">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    {{-- <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in text-20"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                    Today's Riders Joined
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][1]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-info" style="background: #10163a !important">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    {{-- <i class="text-white i-Business-Mens" style="font-size: 1rem;"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out text-20"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Today's Riders Left
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][2]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-success">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Checked-User" style="font-size: 1rem;"></i>
                                    Today's Present Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][3]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-warning">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Remove-User" style="font-size: 1rem;"></i>
                                    Today's Leave Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][4]['data'][date('Y-m-d')] }} )
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="btn btn-block o-hidden border">
                        <div class="text-center p-2 bg-danger">
                            <div class="content">
                                <p class="text-white text-left" style="margin: 0">
                                    <i class="text-white i-Geek" style="font-size: 1rem;"></i>
                                    Today's Absent Rider
                                    <span class="float-right">
                                        ( {{ $rider_attendance_chart_data['datasets'][5]['data'][date('Y-m-d')] }} )
                                    </span>
                                    </p>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function () {
            // basic line chart
            var ctx = document.getElementById('DCWiseRiderOrdersAnalysis').getContext('2d');
            var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',
                    // The data for our dataset
                    data: {
                        labels: {!! $rider_order_chart_data['labels'] !!},
                        datasets:{!! $rider_order_chart_data['datasets'] !!}
                    },
                    // Configuration options go here
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value, index, values) {
                                        return  value + ' Orders';
                                    }
                                }
                            }
                        }
                    }
                }); // line chart 2
            });
    </script>
    <script>
        $(document).ready(function () {
            // basic line chart
            var ctx = document.getElementById('DCWiseRidersAnalysis').getContext('2d');
            var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',
                    // The data for our dataset
                    data: {
                        labels: {!! $rider_attendance_chart_data['labels'] !!},
                        datasets:{!! $rider_attendance_chart_data['datasets'] !!}
                    },
                    // Configuration options go here
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value, index, values) {
                                        return  value + ' riders';
                                    }
                                }
                            }
                        }
                    }
                }); // line chart 2
            });
    </script>
@endsection
