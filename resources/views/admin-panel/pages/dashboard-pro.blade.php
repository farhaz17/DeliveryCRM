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

    <div class="row row-first">


        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Book"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Passports</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{$pass}}</p>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center"><i class="i-Memory-Card-3"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">SIMs</p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2">{{$tel}}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center"><i class="i-Car-2"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">Vehicles</p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2">{{$vehicle}}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        --}}
{{--        <div class="col">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center"><i class="i-Car-2"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">Cancelled Vehicles</p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2">{{$cencel_vehicle}}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Align-Justify-All"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Agreements</p>
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

        {{--    <div class="col-lg-2 col-md-6 col-sm-6">--}}
        {{--          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
        {{--              <div class="card-body text-center"><i class="i-Add-User"></i>--}}
        {{--                  <div class="content">--}}
        {{--                      <p class="text-muted mt-2 mb-0">Data </p>--}}
        {{--                      <p class="text-primary text-24 line-height-1 mb-2">0</p>--}}
        {{--                  </div>--}}
        {{--              </div>--}}
        {{--          </div>--}}
        {{--       </div>--}}
    </div>


    <div class="row">


        <div class="col-md-3">
            @foreach($agreement as $agree)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="flex-grow-1">
                        <h5><a href="">{{$agree->agreement_no}}</a></h5>
                        @if(isset($agree->step_amounts))
                            @foreach($agree->step_amounts as $step)

                            <h5><a href="">{{$step->master_step_id}}</a></h5>
                            @endforeach
                        @endif

                    </div>
                    <p class="text-20 text-success line-height-1 mb-3"><i class="i-Arrow-Up-in-Circle"></i>Eligible</p>
                    <p class="text-20 text-danger line-height-1 mb-3"><i class="i-Arrow-Down-in-Circle"></i> Ineligible </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12" >
            <div class="card mb-4" style="height: 500px;" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <div class="card-body">
                    <div class="card-title">Offer Letter</div>
                                    @foreach($agreement as $agree)

                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3" >
                        <div class="flex-grow-1">
                            <h5><a href="">{{$agree->agreement_no}}</a></h5>
{{--                            <p class="m-0 text-small text-muted">Message</p>--}}
{{--                            <p class="text-small text-danger m-0">status--}}
{{--                                <span class="text-dark">Eligible/not</span>--}}
{{--                            </p>--}}
                        </div>
                        <div>
                            <a  href="{{route('agreement_pdf',$agree->id) }}" target="_blank" class="btn btn-outline-primary mt-3 mb-3 m-sm-0 btn-rounded btn-sm">
                                View
                                details
                            </a>
                        </div>
                    </div>
                                    @endforeach



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
                            <h5 class="modal-title" id="verifyModalContent_title">Complany Employees Detail</h5>
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

    {{--    <script>--}}
    {{--        $("#company_id").change(function () {--}}
    {{--            $("#unique_div").css('display','block');--}}
    {{--            var company_id = $(this).val();--}}
    {{--            var token = $("input[name='_token']").val();--}}



    {{--            $.ajax({--}}
    {{--                url: "{{ route('get_employee_detail') }}",--}}
    {{--                method: 'POST',--}}
    {{--                dataType: 'json',--}}
    {{--                data: {company_id: company_id, _token:token},--}}
    {{--                success: function(response) {--}}
    {{--                    $(".append_elements").remove();--}}
    {{--                    var len = 0;--}}
    {{--                    if(response['data'] != null){--}}
    {{--                        len = response['data'].length;--}}
    {{--                    }--}}
    {{--                    var options = "";--}}
    {{--                    if(len > 0){--}}
    {{--                        for(var i=0; i<len; i++){--}}
    {{--                            var company_name = response['data'][i].company_name;--}}
    {{--                            var emp_count = response['data'][i].emp_count;--}}
    {{--                            var id = response['data'][i].id;--}}
    {{--                            var url = '{{ route("dashboard.edit",":id") }}';--}}
    {{--                            url = url.replace(':id', id);--}}
    {{--                            var hreff="javascript:void(0)";--}}



    {{--                            // options += '<option value="'+id+'" data="'+plateform_count+'">'+given_name+'</option>';--}}


    {{--                          //  options +=  '<div class="append_elements"><input class="append_elements" type="checkbox" id="user_ids" name="user_ids[]" value="'+company_name+'">  <label class="append_elements"  for="vehicle1">'+company_name+'</label><br></div>';--}}
    {{--                            options +=  '<div class="append_elements">' +--}}
    {{--                                '<table  class="table com-table"> ' +--}}
    {{--                                '<thead class="thead-dark">' +--}}
    {{--                                '<tr>' +--}}
    {{--                                '<th scope="col">Company</th>' +--}}
    {{--                                '<th scope="col">Employees</th>' +--}}
    {{--                                '<th scope="col">View</th>' +--}}
    {{--                                '</tr>' +--}}
    {{--                                '</thead>' +--}}

    {{--                                '<tr class="data-row">' +--}}
    {{--                                '<td>'+company_name+'</td>' +--}}
    {{--                                '<td>'+emp_count+'</td>' +--}}
    {{--                                '<td><a class="view_cls" id='+id+' href='+hreff+'><i class="nav-icon i-eye font-weight-bold"></i></a></td>' +--}}
    {{--                                '<tr>' +--}}

    {{--                                '</table>' +--}}
    {{--                                '</div>';--}}

    {{--                        }--}}


    {{--                        $("#names_div").append(options);--}}
    {{--                        $(".all-check").show();--}}


    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}

    {{--        });--}}

    {{--    </script>--}}

    <script type="text/javascript">
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


    <script type="text/javascript">

        var echartElemPie = document.getElementById('echartPie1');



        if (echartElemPie) {
            var echartPie = echarts.init(echartElemPie);



            echartPie.setOption({
                color: ['#F15050', '#775dd0', '#008ffb', '#00e396', '#feb019', '#5A9CEE','#48D26B'],
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)',



                },
                series: [{
                    name: 'Employees By Company',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    data: [<?php echo $concat; ?>],
                    itemStyle: {
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
    <script type="text/javascript">
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
                        interval: 0,
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
        } // Chart in Dashboard version 1

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

        <script type="text/javascript">
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
                        data: [<?php echo isset($data_labour_card) ? $data_labour_card :''; ?>],
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

    <script type="text/javascript">

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
    <script type="text/javascript">

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
