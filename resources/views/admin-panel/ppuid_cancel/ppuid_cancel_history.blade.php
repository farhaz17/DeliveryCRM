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
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Passport</a></li>
            <li class="breadcrumb-item"><a href="#">PPUID Cancel</a></li>

        </ol>
    </nav>




    <div class="card col-lg-8 offset-lg-2 mb-2">
            <div class="card-body">

                        <table class="table" id="datatable" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 100px">Name</th>
                                <th scope="col" style="width: 100px">Passport No</th>
                                <th scope="col" style="width: 100px">ZDS Code</th>
                                <th scope="col" style="width: 100px">PPUID</th>
                                <th scope="col" style="width: 100px">Cancel Date</th>
                                <th scope="col" style="width: 100px">Remarks</th>
                                <th scope="col" style="width: 100px"> Working Status</th>
                                <th scope="col" style="width: 100px">Visa Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($history as $row)
                                <tr>
                                    <td>{{isset($row->passport->personal_info)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                    <td>{{$row->created_at->format('Y-m-d')}}</td>
                                    <td>{{$row->remarks}}</td>
                                    <td>
                                        @if($row->working_status=='1')
                                            Activated
                                            @elseif($row->working_status=='2')
                                            Inactive
                                            @elseif($row->working_status=='3')
                                            Wait Listed
                                            @elseif($row->working_status=='4')
                                            Hold
                                            @elseif($row->working_status=='5')
                                            Cancel
                                            @elseif($row->working_status=='6')
                                            Terminated
                                            @elseif($row->working_status=='7')
                                            Resign
                                            @elseif($row->working_status=='8')
                                            Absconded
                                            @else
                                        None
                                            @endif
                                    </td>
                                    <td>
                                        @if($row->visa_status=='1')
                                            Activated
                                            @elseif($row->visa_status=='2')
                                            Inactive
                                            @elseif($row->visa_status=='3')
                                            Wait Listed
                                            @elseif($row->visa_status=='4')
                                            Hold
                                            @elseif($row->visa_status=='5')
                                            Cancel
                                            @elseif($row->visa_status=='6')
                                            Terminated
                                            @elseif($row->visa_status=='7')
                                            Resign
                                            @elseif($row->visa_status=='8')
                                            Absconded
                                            @else
                                           None
                                            @endif
                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
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
            $('#datatable,#datatable2').DataTable( {
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
