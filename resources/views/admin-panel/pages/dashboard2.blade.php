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
        <!-- ICON BG-->

        {{--      @foreach($careem as $caree)--}}

        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Book"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Passports</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$pass}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Memory-Card-3"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">SIMs</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$tel}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Car-2"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Vehicles</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$vehicle}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Align-Justify-All"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Agreements</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$agree}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" id="total_emp_div">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-User"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Employee </p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$cardTypeAssign}}</p>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center"><i class="i-Add-User"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">Data </p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2">0</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

{{-- --------------------tickets---------------------}}
    <div class="row">
        <!-- ICON BG-->

        {{--      @foreach($careem as $caree)--}}

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Ticket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Pending Tickets</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$pending_tickets}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Ticket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Closed Tickets</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$closed_tickets}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Ticket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">In Process Tickets</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$in_process_tickets}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Ticket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Rejected Tickets</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$rejected_tickets}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!--  --><?php //echo $data_plateform_values; ?>
    <!----------------------------row2------------------------------>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Current Visa Process</div>
                    <div id="echartBar2" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Employees By Company</div>
                    <div id="echartPie1" style="height: 300px;">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="card-title">Ticket</div>
                    <div id="echartBar4" style="height: 300px;"></div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Tickets Raised For</div>
                    <div id="echartBar5" style="height: 300px;"></div>
                </div>
            </div>
        </div>



    <div class="col-lg-4 col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title" style="white-space: nowrap;">Tickets Raised Percentage(%)</div>
                <div id="echartPie6" style="height: 300px;">

                </div>
            </div>
        </div>
    </div>

    </div>




    <div class="row">


        <div class="col-lg-8 col-md-12 Payment">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Payment Departments</div></div>

                    </div>
                    <div id="echartBar_dep1" style="height: 300px;"></div>
                </div>
            </div>


{{--    department2--}}
    <div class="col-lg-8 col-md-12 SalaryIssue">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-lg-3" style="white-space: nowrap;">Ticket In Salary Issue Departments</div></div>

            </div>
            <div id="echartBar_dep2" style="height: 300px;"></div>
        </div>
    </div>


        {{--    department3--}}
    <div class="col-lg-8 col-md-12 ARIssue">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-lg-3" style="white-space: nowrap;">Ticket In AR Issue</div></div>

            </div>
            <div id="echartBar_dep3" style="height: 300px;"></div>
        </div>
    </div>


        {{--    department4--}}
        <div class="col-lg-8 col-md-12 Advance">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Advance</div></div>

                </div>
                <div id="echartBar_dep4" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department5 --}}
        <div class="col-lg-8 col-md-12 VacationAdvance">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Vacation/Advance</div></div>

                </div>
                <div id="echartBar_dep5" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department6 --}}
        <div class="col-lg-8 col-md-12 PlatformIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Platform Issue</div></div>

                </div>
                <div id="echartBar_dep6" style="height: 300px;"></div>
            </div>
        </div>



        {{--    department7 --}}
        <div class="col-lg-8 col-md-12 MeetManagement">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Meet Management</div></div>

                </div>
                <div id="echartBar_dep7" style="height: 300px;"></div>
            </div>
        </div>


        <div class="col-lg-8 col-md-12 VisaStatus">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Visa Status</div></div>

                </div>
                <div id="echartBar_dep8" style="height: 300px;"></div>
            </div>
        </div>












        {{--    department9 --}}
        <div class="col-lg-8 col-md-12 BikeIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Bike Issue</div></div>

                </div>
                <div id="echartBar_dep9" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department10 --}}
        <div class="col-lg-8 col-md-12 SickLeave">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Sick Leave</div></div>

                </div>
                <div id="echartBar_dep10" style="height: 300px;"></div>
            </div>
        </div>

        {{--    department11 --}}
        <div class="col-lg-8 col-md-12 Accident">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Accident</div></div>

                </div>
                <div id="echartBar_dep11" style="height: 300px;"></div>
            </div>
        </div>

        {{--    department12 --}}
        <div class="col-lg-8 col-md-12 EmergencyLeave">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Emergency Leave</div></div>

                </div>
                <div id="echartBar_dep12" style="height: 300px;"></div>
            </div>
        </div>

        {{--    department13 --}}
        <div class="col-lg-8 col-md-12 PassportRenewal">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Passport Renewal</div></div>

                </div>
                <div id="echartBar_dep13" style="height: 300px;"></div>
            </div>
        </div>

        {{--    department14 --}}
        <div class="col-lg-8 col-md-12 SimIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Sim Issue</div></div>

                </div>
                <div id="echartBar_dep14" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department15 --}}
        <div class="col-lg-8 col-md-12 InsuranceIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Insurance Issue</div></div>

                </div>
                <div id="echartBar_dep15" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department16 --}}
        <div class="col-lg-8 col-md-12 HiringIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Hiring Issue</div></div>

                </div>
                <div id="echartBar_dep16" style="height: 300px;"></div>
            </div>
        </div>


        {{--    department17 --}}
        <div class="col-lg-8 col-md-12 TransferIssue">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <div class="col-lg-3" style="white-space: nowrap;">Ticket In Transfer Issue</div></div>

                </div>
                <div id="echartBar_dep17" style="height: 300px;"></div>
            </div>
        </div>





    </div>


    </div>


    @foreach($companies as $company)

        <?php $new_str = str_replace(' ', '', $company->name); ?>

        <div class="col-lg-8 col-md-12 hide_divs_graphs graphp_div-{{ $new_str }}"  id=" " >
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Labour Card Type Assign  , {{ $company->name }} </div>
                    <div id="{{$new_str}}" style="height: 300px; "></div>
                </div>
            </div>
        </div>

    @endforeach








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
        $('#total_emp_div').on('click', function(e) {
            var id =  $(this).attr("id");
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_employee_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token:token},
                success: function(response) {
                    $(".append_elements").remove();
                    var options = "";
                    options +=  '<div class="append_elements">' +
                        '<table  class="table com-table"> ' +
                        '<thead class="thead-dark">' +
                        '<tr>' +
                        '<th scope="col">Company Name</th>' +
                        '<th scope="col">Employee Name</th>' +
                        '<th scope="col">View</th>' +
                        '</tr>' +
                        '</thead>';
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var company_name = response['data'][i].company_name;
                            var company_count = response['data'][i].company_count;
                            var id = response['data'][i].id;
                            var hreff="javascript:void(0)";
                            options +='<tr class="data-row">' +
                                '<td>'+company_name+'</td>' +
                                '<td>'+company_count+'</td>' +
                                '<td><a class="view_cls" id='+id+' href='+hreff+'><i class="nav-icon i-eye font-weight-bold"></i></a></td>'+
                                '<tr>'
                        }
                        '</table>' +
                        '</div>';
                        $("#emp_div").append(options);
                        $('#emp_modal').modal('show');



                    }
                }
            });


        });

    </script>

    {{--    <script>--}}
    {{--        function render_graphp_detail(name_now){--}}

    {{--        }--}}
    {{--      </script>--}}


    <script>

        var echartElemPie = document.getElementById('echartPie1');



        if (echartElemPie) {
            var echartPie = echarts.init(echartElemPie);



            echartPie.setOption({
                color: ['#F15050', '#775dd0', '#008ffb', '#00e396', '#feb019', '#5A9CEE','#48D26B'],
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                series: [{
                    name: 'Employees By Company',
                    type: 'pie',
                    radius: '50%',
                    center: ['50%', '50%'],
                    data: [<?php echo $concat; ?>],
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



            echartPie.on('click', function (params) {
                var name_now = params['data']['name']

                var ids = name_now.replace(/\s/g, '');

                console.log(ids);
                $(".hide_divs_graphs").hide();
                $(".graphp_div-"+ids).hide();
                $("#"+ids).hide();
                $(".graphp_div-"+ids).show();
                $("#"+ids).show();



            });


        } // line charts

    </script>
    <script>
        var echartElemBar = document.getElementById('echartBar2');

        if (echartElemBar) {
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
                        fontSize: 40
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
                    max: 1000,
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
        // tickets graph
        var echartElemBar = document.getElementById('echartBar4');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                    max: 500,
                    interval: 100,
                    dataMin:0,
                    dataMax:10000,
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
                        color: '#F15050'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#F15050',
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
                    name: 'Tickets',

                    data: [<?php echo $pending_tickets; ?>,<?php echo $closed_tickets; ?>,<?php echo $in_process_tickets; ?>,<?php echo $rejected_tickets; ?>],
                    label: {
                        show: false,
                        color: '#F15050'
                    },
                    type: 'bar',
                    color: '#F15050',
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
        // tickets graph
        var echartElemBar = document.getElementById('echartBar5');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets Raised For']
                },
                grid: {
                    left: '4px',
                    right: '4px',
                    bottom: '0',
                    containLabel: true
                },
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                xAxis: [{
                    type: 'category',


                    //tickets names will come here
                    data: [<?php echo $data_label_tickets?>],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 30
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 45 //If the label names are too long you can manage this by rotating the label.
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets Raised For',

                    data: [<?php echo $data_label_values_tickets; ?>],
                    label: {
                        show: false,
                        color: '#5A9CEE'
                    },
                    type: 'bar',
                    color: '#48DFE1',
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

        var echartElemPie = document.getElementById('echartPie6');



        if (echartElemPie) {
            var echartPie2 = echarts.init(echartElemPie);



            echartPie2.setOption({
                color: ['#5A9CEE', '#775dd0', '#008ffb', '#00e396','#F15050', '#feb019', '#5A9CEE','#48D26B'],
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                series: [{
                    name: 'Tickets Raised Percentage(%)',
                    type: 'pie',
                    radius: '52%',
                    center: ['50%', '50%'],
                    data: [<?php echo $concat_depart; ?>],
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
                    echartPie2.resize();
                }, 500);
            });

        } // line charts

        // echartPie2.on('click', function (params) {
        //     var name_now = params['data']['name']
        //
        //     var ids = name_now.replace(/\s/g, '');
        //
        //
        //     alert(ids)
        //
        //     // console.log(ids);
        //     // $(".hide_divs_graphs").hide();
        //     // $(".graphp_div-"+ids).hide();
        //     // $("#"+ids).hide();
        //     // $(".graphp_div-"+ids).show();
        //     // $("#"+ids).show();
        //
        //
        //
        // });




    </script>




    <script>
        // tickets graph
        var echartElemBar = document.getElementById('echartBar_dep1');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                        color: '#000000'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#000000',
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart1; ?>,<?php echo $closed_depart1; ?>,<?php echo $in_process_depart1; ?>,<?php echo $rejected_depart1; ?>],
                    label: {
                        show: false,
                        color: '#000000'
                    },
                    type: 'bar',
                    color: '#000000',
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
        // depaertement2
        var echartElemBar = document.getElementById('echartBar_dep2');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart2; ?>,<?php echo $closed_depart2; ?>,<?php echo $in_process_depart2; ?>,<?php echo $rejected_depart2; ?>],
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
        // depaertement3
        var echartElemBar = document.getElementById('echartBar_dep3');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart3; ?>,<?php echo $closed_depart3; ?>,<?php echo $in_process_depart3; ?>,<?php echo $rejected_depart3; ?>],
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
        // depaertement4
        var echartElemBar = document.getElementById('echartBar_dep4');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                        color: '#000000'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#000000',
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart4; ?>,<?php echo $closed_depart4; ?>,<?php echo $in_process_depart4; ?>,<?php echo $rejected_depart4; ?>],
                    label: {
                        show: true,
                        color: '#000000'
                    },
                    type: 'bar',
                    color: '#000000',
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
        // depaertement5
        var echartElemBar = document.getElementById('echartBar_dep5');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    color: '#000000',
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart5; ?>,<?php echo $closed_depart5; ?>,<?php echo $in_process_depart5; ?>,<?php echo $rejected_depart5; ?>],
                    label: {
                        show: false,
                        color: '#000000'
                    },
                    type: 'bar',
                    color: '#000000',
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
        // depaertement7
        var echartElemBar = document.getElementById('echartBar_dep7');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart7; ?>,<?php echo $closed_depart7; ?>,<?php echo $in_process_depart7; ?>,<?php echo $rejected_depart7; ?>],
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
        // depaertement6
        var echartElemBar = document.getElementById('echartBar_dep6');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart6; ?>,<?php echo $closed_depart6; ?>,<?php echo $in_process_depart6; ?>,<?php echo $rejected_depart6; ?>],
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
        // depaertement8
        var echartElemBar = document.getElementById('echartBar_dep8');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart8; ?>,<?php echo $closed_depart8; ?>,<?php echo $in_process_depart8; ?>,<?php echo $rejected_depart8; ?>],
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
        // depaertement9
        var echartElemBar = document.getElementById('echartBar_dep9');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart9; ?>,<?php echo $closed_depart9; ?>,<?php echo $in_process_depart9; ?>,<?php echo $rejected_depart9; ?>],
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
        // depaertement6
        var echartElemBar = document.getElementById('echartBar_dep10');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart10; ?>,<?php echo $closed_depart10; ?>,<?php echo $in_process_depart10; ?>,<?php echo $rejected_depart10; ?>],
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
        // depaertement11
        var echartElemBar = document.getElementById('echartBar_dep11');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart11; ?>,<?php echo $closed_depart11; ?>,<?php echo $in_process_depart11; ?>,<?php echo $rejected_depart11; ?>],
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
        // depaertement12
        var echartElemBar = document.getElementById('echartBar_dep12');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart12; ?>,<?php echo $closed_depart12; ?>,<?php echo $in_process_depart12; ?>,<?php echo $rejected_depart12; ?>],
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
        // depaertement13
        var echartElemBar = document.getElementById('echartBar_dep13');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart13; ?>,<?php echo $closed_depart13; ?>,<?php echo $in_process_depart13; ?>,<?php echo $rejected_depart13; ?>],
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
        // depaertement14
        var echartElemBar = document.getElementById('echartBar_dep14');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart14; ?>,<?php echo $closed_depart14; ?>,<?php echo $in_process_depart14; ?>,<?php echo $rejected_depart14; ?>],
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
        // depaertement15
        var echartElemBar = document.getElementById('echartBar_dep15');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart15; ?>,<?php echo $closed_depart15; ?>,<?php echo $in_process_depart15; ?>,<?php echo $rejected_depart15; ?>],
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
        // depaertement15
        var echartElemBar = document.getElementById('echartBar_dep16');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart16; ?>,<?php echo $closed_depart16; ?>,<?php echo $in_process_depart16; ?>,<?php echo $rejected_depart16; ?>],
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
        // depaertement6
        var echartElemBar = document.getElementById('echartBar_dep17');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right',
                    data: ['Tickets']
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

                    //tickets names will come here
                    data: ['Pending Tickets','Closed Tickets','In Process Tickets','Rejected Tickets'],
                    axisTick: {
                        alignWithLabel: true,
                        fontSize: 40
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
                        formatter: '{value}'
                    },
                    min: 0,
                    max: 100,
                    interval: 10,
                    dataMin:0,
                    dataMax:10000,
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
                    name: 'Tickets',

                    data: [<?php echo $pending_depart17; ?>,<?php echo $closed_depart17; ?>,<?php echo $in_process_depart17; ?>,<?php echo $rejected_depart17; ?>],
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

        echartPie2.on('click', function (params) {
            var name_now = params['data']['name']

            var ids = name_now.replace(/\s/g, '');
            // alert(ids)

            if (ids == 'Payment'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();
                $(".Payment").show();
                }
            if (ids == 'SalaryIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();
                $(".SalaryIssue").show();

            }


            if (ids == 'ARIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".ARIssue").show();

            }


            if (ids == 'Advance'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".Advance").show();

            }



            if (ids == 'PlatformIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".PlatformIssue").show();

            }

            if (ids == 'MeetManagement'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".MeetManagement").show();

            }


            if (ids == 'Vacation/Advance'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".VacationAdvance").show();

            }



            if (ids == 'BikeIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".BikeIssue").show();

            }

            if (ids == 'SickLeave'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".SickLeave").show();

            }


            if (ids == 'Accident'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".Accident").show();

            }

            if (ids == 'EmergencyLeave'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".EmergencyLeave").show();

            }


            if (ids == 'PassportRenewal'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".PassportRenewal").show();

            }


            if (ids == 'SimIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".SimIssue").show();

            }


            if (ids == 'InsuranceIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".InsuranceIssue").show();

            }

            if (ids == 'HiringIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".HiringIssue").show();

            }

            if (ids == 'TransferIssue'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".TransferIssue").show();

            }
            if (ids == 'Visa Status'){

                $(".SalaryIssue").hide();
                $(".Payment").hide();
                $(".ARIssue").hide();
                $(".Advance").hide();
                $(".PlatformIssue").hide();
                $(".MeetManagement").hide();
                $(".VacationAdvance").hide();
                $(".BikeIssue").hide();
                $(".SickLeave").hide();
                $(".Accident").hide();
                $(".EmergencyLeave").hide();
                $(".PassportRenewal").hide();
                $(".SimIssue").hide();
                $(".InsuranceIssue").hide();
                $(".HiringIssue").hide();
                $(".TransferIssue").hide();
                $(".VisaStatus").hide();

                $(".VisaStatus").show();

            }




        });

        $(document).ready(function() {
            $(".SalaryIssue").hide();
            $(".Payment").hide();
            $(".ARIssue").hide();
            $(".Advance").hide();
            $(".PlatformIssue").hide();
            $(".MeetManagement").hide();
            $(".VacationAdvance").hide();
            $(".BikeIssue").hide();
            $(".SickLeave").hide();
            $(".Accident").hide();
            $(".EmergencyLeave").hide();
            $(".PassportRenewal").hide();
            $(".SimIssue").hide();
            $(".InsuranceIssue").hide();
            $(".HiringIssue").hide();
            $(".TransferIssue").hide();
            $(".VisaStatus").hide();




        });

    </script>



    <?php $counter =0 ?>
    @foreach($companies as $company)

        <?php $new_str = str_replace(' ', '', $company->name); ?>

        <?php $data_labour_card_values_ab = ""; ?>
        @foreach($companies_graphs[$counter] as $ab)
            <?php
            if(!empty($ab)){
                $data_labour_card_values_ab .= "{$ab->total}".",";
            }else{
                $zero = "0";
                $data_labour_card_values_ab .= "$zero".",";
            }
            ?>
        @endforeach
        <?php $data_labour_card_values_ab = trim($data_labour_card_values_ab,","); ?>

        <script>
            var echartElemBar = document.getElementById('{{ $new_str }}');
            if (echartElemBar) {
                var echartBar = echarts.init(echartElemBar);
                echartBar.setOption({
                    legend: {
                        borderRadius: 0,
                        orient: 'horizontal',
                        x: 'right',
                        data: ['Labour card Type']
                    },
                    grid: {
                        left: '0px',
                        right: '8px',
                        bottom: '0',
                        containLabel: true
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    yAxis: [{
                        type: 'category',
                        data: [<?php echo isset($data_labour_card) ?  $data_labour_card : ''; ?>],
                        axisTick: {
                            alignWithLabel: true,

                        },

                        splitLine: {
                            show: false
                        },
                        axisLine: {
                            show: true
                        }
                    }],
                    xAxis: [{
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        },

                        min: 0,
                        max: 1000,
                        interval: 50,
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
                        name: 'Labour card type',

                        data: [<?php echo $data_labour_card_values_ab; ?>],
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


        <?php $counter = $counter+1; ?>
    @endforeach

    <script>

        $(document).ready(function() {
            $(".graphp_div-").hide();
            $(".hide_divs_graphs").hide();
        });

    </script>








    {{--    <script>--}}
    {{--        $(document).ready(function(){--}}

    {{--            $('#total_emp_div').on('click', function(e) {--}}
    {{--                alert(1);--}}
    {{--            });--}}
    {{--        });--}}

    {{--    </script>--}}
    {{--    name:'ZONE DELIVERY SERVICES LLC'--}}
    {{--    <script>--}}
    {{--        $("#echartPie1").click(--}}
    {{--            function(evt){--}}
    {{--                var ab = $(this).attr('span');--}}
    {{--                alert(ab);--}}


    {{--            }--}}
    {{--        );--}}

    {{--    </script>--}}


    {{--<script>--}}
    {{--    $('#emp_div').on('click','.view_cls', function(e) {--}}
    {{--        var id =  $(this).attr("id");--}}


    {{--        var token = $("input[name='_token']").val();--}}
    {{--        $.ajax({--}}
    {{--            url: "{{ route('get_employee_company') }}",--}}
    {{--            method: 'POST',--}}
    {{--            dataType: 'json',--}}
    {{--            data: {id: id, _token:token},--}}
    {{--            success: function(response) {--}}


    {{--                var len = 0;--}}
    {{--                if(response['data'] != null){--}}
    {{--                    len = response['data'].length;--}}
    {{--                }--}}
    {{--                if(len > 0){--}}
    {{--                    for(var i=0; i<len; i++){--}}
    {{--                        var given_names = response['data'][i].given_names;--}}
    {{--                        var passport_number = response['data'][i].passport_number;--}}

    {{--                        var tr_str = "<tr>" +--}}
    {{--                            "<td align='center'>" + given_names + "</td>" +--}}
    {{--                            "<td align='center'>" + passport_number + "</td>" +--}}
    {{--                            "</tr>";--}}

    {{--                        $("#datatable tbody").append(tr_str);--}}
    {{--                        $('#emp_detail').modal('show');--}}



    {{--                }--}}

    {{--            }--}}


    {{--            }--}}
    {{--        });--}}

    {{--    });--}}

    {{--</script>--}}
    <script>

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });

    </script>

    {{--    '<td><a href="'+url+'">View</a></td>' +--}}
@endsection
