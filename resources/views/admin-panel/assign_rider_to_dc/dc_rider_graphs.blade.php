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


    {{-- --------------------tickets---------------------}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Received COD</p>
                        <p class="text-primary text-24 line-height-1 mb-2">00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Cash-Register"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Remain COD</p>
                        <p class="text-primary text-24 line-height-1 mb-2">00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Dollar"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Cash Received</p>
                        <p class="text-primary text-24 line-height-1 mb-2">00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-University1"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Received in Bank</p>
                        <p class="text-primary text-24 line-height-1 mb-2">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Last Fourteen Day Orders</div>
                    <div id="echartBar_year" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Last 12 Month</div>
                    <div id="echartPie_cod" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>



















    <!--------Companny employee detail modal------------->
    <div class="col-md-12">
        <div class="modal fade" id="emp_modal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Company Employees Detail</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12 form-group mb-3 " id="emp_div">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------Companny employee detail modal Ends------------->

    <!--------Companny employee detail modal------------->
    <div class="col-md-12">
        <div class="modal fade" id="emp_detail" style="z-index: 9999" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Employee Details</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12 form-group mb-3 " id="emp_det">

                                <table class="table mytable" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Passport Number</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------Companny employee detail modal Ends------------->


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>




    <script>
        var echartElemBar = document.getElementById('echartBar_year');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Cash', 'Bank']
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
                    data: [<?php echo $date_names; ?>],
                    axisTick: {
                        alignWithLabel: true
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '${value}'
                    },
                    min: 0,
                    max: 50000,
                    interval: 10000,
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }
                }],
                series: [{
                    name: 'Cash',
                    data: [<?php echo $date_values_cashs; ?>],
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
                    name: 'Bank',
                    data: [<?php echo $date_values_banks; ?>],
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
        } // Chart in Dashboard version 1
    </script>
    <script>

        var echartElemPie = document.getElementById('echartPie_cod');

        if (echartElemPie) {
            var echartPie = echarts.init(echartElemPie);
            echartPie.setOption({
                color: ['#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af','#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af'],
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                series: [{
                    name: 'Last 12 Month',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    data: [
                            <?php $counter = 0; ?>
                            @foreach($month_names as $name)
                        {
                            value: {{ $monthly_cash[$counter] }},
                            name: '{{ $name }}'
                        }
                        <?php $counter = $counter+1; ?>
                        @if($counter<=12) , @endif
                        @endforeach
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }]
            });
            $(window).on('resize', function () {
                setTimeout(function () {
                    echartPie.resize();
                }, 500);
            });
        } // Chart in Dashboard version 1

    </script>


@endsection
