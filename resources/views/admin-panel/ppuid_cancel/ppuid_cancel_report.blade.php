@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        div#total1 {
            background-color: #663399 !important;
            color: #ffffff;
        }
        div#total2 {
            background: green;
            color: #ffffff;
        }
        div#total3 {
            background: #d24a55;
            color: #ffffff;
        }
        .card-icon-bg-primary [class^="i-"] {
            color: #ffffff;
        }
        p.mt-2.mb-0 {
            white-space: nowrap;
        }
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
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
            font-weight: 600;
        }

        div#total4 {
            background: #0e0e63;
            color: #ffffff;
        }
        div#total5 {
            background: #004000;
            color: #ffffff;
        }
        div#total6 {
            background: #480909;
            color: #ffffff;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Passport</a></li>
            <li class="breadcrumb-item"><a href="#">PPUID Cancel</a></li>

        </ol>
    </nav>


    <div class="row">

    <div class="card col-lg-12  mb-2">
        <div class="card-body">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary  o-hidden mb-4" id="total1">
                        <div class="card-body text-center"><i class="i-Library"></i>
                            <div class="content">
                                <p class="mt-2 mb-0">Total PPUIDs</p>
                                <p class="lead text-24 mb-2 ml-2">{{$total_ppuid}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" id="total2">
                        <div class="card-body text-center"><i class="i-Yes"></i>
                            <div class="content">
                                <p class=" mt-2 mb-0">Total Active</p>
                                <p class="lead text-24 mb-2 ml-2">{{$active_ppuid}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" id="total3">
                        <div class="card-body text-center"><i class="i-Close"></i>
                            <div class="content">
                                <p class="mt-2 mb-0">Total Inactive</p>
                                <p class="lead  text-24 mb-2 ml-3">{{$inactive_ppuid}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


    </div>

    </div>

{{--    2nd row starts here--}}

    <div class="row">

        <div class="card col-lg-12  mb-2">
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary  o-hidden mb-4" id="total4">
                            <div class="card-body text-center"><i class="i-Add-Window"></i>
                                <div class="content">
                                    <p class="mt-2 mb-0">Total Agreements</p>
                                    <p class="lead text-24 mb-2 ml-2">{{$total_agreements}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" id="total5">
                            <div class="card-body text-center"><i class="i-Yes"></i>
                                <div class="content">
                                    <p class=" mt-2 mb-0">Total Active Agreements</p>
                                    <p class="lead text-24 mb-2 ml-2">{{$active_agreements}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" id="total6">
                            <div class="card-body text-center"><i class="i-Close"></i>
                                <div class="content">
                                    <p class="mt-2 mb-0">Total Inactive Agreements</p>
                                    <p class="lead  text-24 mb-2 ml-3">{{$inactive_agreements}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="row">
        <div class="card col-lg-4  mb-2">
            <div class="card-body">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">PPUIDs Graph</div>
                        <div id="echartPie1" style="height: 300px;"></div>
                    </div>
                </div>


            </div>
        </div>
            <div class="card col-lg-8  mb-2">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Active </a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Inactive</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <table class="table" id="datatable" style="width: 100%">
                            <div class="card-title">PPUIDs Detail</div>
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_active as $row)
                                    <tr>
                                        <td>{{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                        <td>{{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                        <td>{{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                        <td>{{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                        <td> <span class="font-weight-bold">Active</span></td>
                                    </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                        <table class="table" id="datatable2"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_inactive as $row)
                                    <tr>
                                        <td>{{isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                        <td>{{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                        <td>{{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:"N/A"}}</td>
                                        <td>{{isset($row->pp_uid)?$row->pp_uid:"N/A"}}</td>
                                        <td> <span class="font-weight-bold">Inctive</span></td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>




{{--row2--}}
    <div class="row">
        <div class="card col-lg-4  mb-2">
            <div class="card-body">
{{--                <div class="card mb-4">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="card-title">PPUIDs Graph</div>--}}
{{--                        <div id="echartPie1" style="height: 300px;"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}


            </div>
        </div>
        <div class="card col-lg-8  mb-2">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab2" data-toggle="tab" href="#homeBasic2" role="tab" aria-controls="homeBasic2" aria-selected="true">Working Status </a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab2" data-toggle="tab" href="#profileBasic2" role="tab" aria-controls="profileBasic2" aria-selected="false">Visa Status</a></li>
                    <li class="nav-item"><a class="nav-link" id="id-basic-tab2" data-toggle="tab" href="#idBasic2" role="tab" aria-controls="idBasic2" aria-selected="false">ID Status</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic2" role="tabpanel" aria-labelledby="home-basic-tab2">

                        <table class="table" id="datatable3" style="width: 100%">
                            <div class="card-title">PPUIDs Status</div>
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($working_status as $row)
                                <tr>
                                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                    <td> <span class="font-weight-bold">
                                            @if($row->working_status=='1')
                                                Shuffle Platform
                                            @elseif($row->working_status=='2')
                                                Vacation
                                            @elseif($row->working_status=='3')
                                                Terminate By Platform
                                            @elseif($row->working_status=='4')
                                                Terminate By Company
                                            @elseif($row->working_status=='5')
                                                Accident
                                            @elseif($row->working_status=='6')
                                                Absconded
                                            @elseif($row->working_status=='7')
                                                Demised
                                            @elseif($row->working_status=='8')
                                                Cancellation
                                            @elseif($row->working_statu=='9')
                                                4PL offboard
                                            @elseif($row->working_status=='10')
                                                Own Visa offboard
                                            @else
                                                None
                                            @endif
                                        </span></td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade" id="profileBasic2" role="tabpanel" aria-labelledby="profile-basic-tab2">


                        <table class="table" id="datatable4"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($visa_status as $row)
                                <tr>
                                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                    <td> <span class="font-weight-bold">
                                                   @if($row->visa_status=='5')
                                                Cancel
                                            @elseif($row->pvisa_status=='6')
                                                Terminated
                                            @elseif($row->visa_status=='7')
                                                Resign
                                            @elseif($row->visa_status=='8')
                                                Absconded
                                            @else

                                                N/A
                                        @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>





                    <div class="tab-pane fade" id="idBasic2" role="tabpanel" aria-labelledby="id-basic-tab2">


                        <table class="table" id="datatable5"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($id_status as $row)
                                <tr>
                                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                    <td> <span class="font-weight-bold">
                                            @if($row->id_status=='1')
                                                Active
                                            @elseif($row->id_status=='2')
                                                Inactive
                                            @elseif($row->id_status=='3')
                                                Wait Listed
                                            @elseif($row->id_status=='4')
                                                Hold
                                            @else
                                                None
                                        @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4').DataTable( {
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,

            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="home-basic-tab"){
                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
        });

    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="home-basic-tab2"){
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                if(split_ab=="profile-basic-tab2"){
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
        });

    </script>

        <script type="text/javascript">
            var echartElemPie = document.getElementById('echartPie1');



            if (echartElemPie) {
                var echartPie = echarts.init(echartElemPie);



                echartPie.setOption({
                    color: ['#F15050', '#775dd0'],
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)',



                    },
                    series: [{
                        name: 'Employees By Company',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],

                        data: [{
                            value: <?php echo $inactive_ppuid ?>,
                            name: 'Inactive PPUIDs'
                        }, {
                            value: <?php echo $active_ppuid ?>,
                            name: 'Active PPUIDs'
                        }],                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)',

                            }
                        }
                    }]
                });
                $(window).on('resize', function () {
                    setTimeout(function () {
                        echartPie.resize();
                    }, 500);
                });






            } // line charts

    </script>


    <script>
        var data = [{
            data: [50, 55, 60, 33],
            labels: ["India", "China", "US", "Canada"],
            backgroundColor: [
                "#4b77a9",
                "#5f255f",
                "#d21243",
                "#B27200"
            ],
            borderColor: "#fff"
        }];

        var options = {
            tooltips: {
                enabled: false
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {

                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2)+"%";
                        return percentage;


                    },
                    color: '#fff',
                }
            }
        };


        var ctx = document.getElementById("pie-chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: data
            },
            options: options
        });
    </script>







@endsection
