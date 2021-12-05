@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 700;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
             margin-top: 0rem;
             margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .btn-start {
       padding: 1px;
        }

        .submenu{
            display: none;
        }
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
        tr:hover {background-color:#d8d6d6;}
        th{  pointer-events: none;}

        .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #f44336;
    border-color: #f44336;
}

.step_name-text {

/* white-space: nowrap; */

}

.card.mb-4.step-cards {
max-height: 100px;
border: 1px solid gainsboro;
}
.heading-card {
    white-space: nowrap;
    text-align: center;
}
.bg-primary-gradient {
    background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%) !important;
}
.bg-primary-gradient2 {
    background-image: linear-gradient(45deg, #f93a5a, #f7778c) !important;
}
.bg-primary-gradient3 {
    background-image: linear-gradient(to left, #48d6a8 0%, #029666 100%) !important;
}
.bg-primary-gradient4 {
    background-image: linear-gradient(to left, #efa65f, #f76a2d) !important;
}
.bg-primary-gradient5 {
    background-image: linear-gradient(to left, #1b2022 0%, #005bea 100%) !important;
}
.bg-primary-gradient6 {
    background-image: linear-gradient(to left, #8b0000 0%, #350003 100%) !important;
}


.text-step {
    white-space: nowrap;
    font-weight: 900;
}
.border-bottom{
  padding-left:0;
  padding-right:0;

}
.flex-grow-1 {
    flex-grow: 1 !important;
    padding-left: 10px;
}
.btn-view{
    color: green;
    font-weight: bolder;
    text-decoration:  underline;
}


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Process Dashboard!</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <!-- ICON BG-->
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Visa process to start</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$visa_process_to_start}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient2  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Visa Expired </p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$expired_visa}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient3  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Own visa process to start</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$own_visa_count}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card  bg-primary-gradient4 o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Cancelled visas</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$cancel_visa_count}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient5  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Replacement visas</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$replacement_history}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient6  card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Total Visa Porcess completed</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{$total_visa_process_completed}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

               <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> <span class="badge badge-primary">Current Visa Process </span></div>
                                <div id="echartBar2" style="height: 625px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                                <div class="card mb-4">
                                    <div class="card-body p-0">
                                        <div class="card-title border-bottom d-flex align-items-center m-0 p-3">
                                            <span>Process To Starts</span><span class="flex-grow-1"></span>
                                            <span class="badge badge-pill badge-warning">Process to start</span>
                                        </div>
                                        <div class="row">
                                        @foreach ($current_steps as $row)
                                        <div class="col-lg-4 border-bottom  col-md-3 col-sm-3">
                                            <div class="d-flex  justify-content-between p-3">
                                                <div class="flex-grow-1"><span class="text-small text-step text-muted">{{$row['step_name']}}</span>
                                                    <h5 class="m-0">{{$row['no']}}</h5>
                                                </div>
                                            </div>
                                        </div>


                                        @endforeach
                                    </div>
                                    </div>
                                </div>
                            </div>
                    </div>


                    <div class="row pb-2" >

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title"> <span class="badge badge-danger">Fine started already </span></div>
                                        <table class="table" id="datatable2">
                                            <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Passport No</th>
                                                <th>PPUID</th>
                                                <th>Fine Start Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter=1?>
                                            @foreach ($fine_already_passed as $row)
                                            @if(!isset($row->passports->offer))
                                            <tr>
                                                <td>{{$counter}}</td>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->passport_no}}</td>
                                                <td>{{isset($row->passport_detail->pp_uid)?$row->passport_detail->pp_uid:'N/A'}}</td>
                                                <td>
                                                    <span class="badge badge-danger font-weight-bold">
                                                        {{ date('d-m-Y', strtotime($row->exit_date))}}
                                                    </span>
                                                 </td>
                                            </tr>
                                                <?php $counter++?>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> <span class="badge badge-danger">Fine starts this week</span></div>
                                <table class="table" id="datatable">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Passport No</th>
                                        <th>PPUID</th>
                                        <th>Fine Start Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter=1?>
                                    @foreach ($fine_starts_next_week as $row)
                                    @if(!isset($row->passports->offer))
                                    <tr>
                                        <td>{{$counter}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->passport_no}}</td>
                                        <td>{{isset($row->passport_detail->pp_uid)?$row->passport_detail->pp_uid:'N/A'}}</td>
                                        <td>
                                            <span class="badge badge-danger font-weight-bold">
                                                {{ date('d-m-Y', strtotime($row->exit_date))}}
                                            </span>
                                         </td>
                                    </tr>
                                        <?php $counter++?>
                                        @endif
                                    @endforeach
                                </tbody>
                                </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">


                    <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"> <span class="badge badge-info">Visa process to start</span></div>
                            <table class="display table table-striped table-bordered table-sm text-10"  width="100%">
                                <thead>
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">PPUID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <tr>

                                        <td> {{$row['pass_no']}}</td>
                                        <td> {{$row['pp_uid']}}</td>
                                        <td> {{$row['fine_start']}}</td>

                                    </tr>

                                @endforeach



                                </tbody>
                            </table>
                    </div>
                    <a href="{{route('visa_process_report_show')}}" target="_blank" class="btn btn-view"> View full details</a>
                                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"> <span class="badge badge-info">Expired visa process</span></div>
                            <table class="table table-striped" id="datatable">
                                <thead class="thead-dark">
                                <tr class="t-row">
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Expired At</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($visa_pasted as $res)
                                        <tr>
                                            <td>{{$res->passport->passport_no}}</td>
                                            <td>{{$res->passport->personal_info->full_name}}</td>
                                            <td>{{$res->passport->pp_uid}}</td>
                                            <td>{{$res->expiry_date}}</td>

                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                    <a href="{{url('expired_visa')}}" target="_blank" class="btn btn-view"> View full details</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"> <span class="badge badge-success">Own visa process to start</span></div>
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable-6" width="100%">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">PPUID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($own_visa as $row)
                                    <tr>
                                        <td> {{$row['pass_no']}}</td>
                                        <td> {{$row['pp_uid']}}</td>
                                        <td> {{$row['fine_start']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                    <a href="{{route('visa_process_report_show')}}" target="_blank" class="btn btn-view"> View full details</a>


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"> <span class="badge badge-success">All cancel visa process to start</span></div>
                            <table class="table" id="datatable">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">&nbsp</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">PPUID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter=1?>
                                @foreach ($visa_can as $row)
                                @if(!isset($row->passports->offer))
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->passport->personal_info->full_name}}</td>
                                    <td>{{$row->passport->passport_no}}</td>
                                    <td>{{$row->passport->pp_uid}}</td>


                                </tr>
                                    <?php $counter++?>
                                    @endif
                                @endforeach
                            </tbody>
                            </table>
                    </div>
                    <a href="{{url('all_cancelled_visa')}}" target="_blank" class="btn btn-view"> View full details</a>
                    </div>
                </div>
            </div>















{{-- -------------- visa process modals----------------- --}}
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>




    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 10,

            });
        });
    </script>

<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable2').DataTable( {
            "aaSorting": [],
            "pageLength": 10,

        });
    });
</script>

<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable3').DataTable( {
            "aaSorting": [],
            "pageLength": 10,

        });
    });
</script>

    <script>
          var echartElemBar = document.getElementById('echartBar2');

if (echartElemBar)
 {
      var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Current Visa Process']
                },
                grid: {
                    left: '8px',
                    right: '8px',
                    bottom: '0',
                    containLabel: true

                },
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                xAxis: [{
                    type: 'category',


                    data: [<?php echo $data_label; ?>],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 20
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    },
                    axisLabel: {
                        // interval: 0,
                        rotate: 30 //If the label names are too long you can manage this by rotating the label.
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 1400,
                    interval: 200,
                    dataMin:0,
                    dataMax:1000,
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }

                }],
                series: [{
                    name: 'Online',
                    // data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
                    label: {
                        show: false,
                        color: '#0168c1'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#bcbbdd',
                    smooth: true,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: -2,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    }
                }, {
                    name: 'Current Visa Process',

                    data: [<?php echo $data_label_values; ?>],
                    label: {
                        show: false,
                        color: '#639'
                    },
                    type: 'bar',
                    color: '#7569b3',
                    smooth: true,

                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: -2,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    }

                }]
            });
        $(window).on('resize', function () {
            setTimeout(function () {
                echartBar.resize();
            }, 500);
        });
    }



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
