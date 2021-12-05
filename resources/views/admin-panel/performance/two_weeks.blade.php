@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li>Performance</li>
            <li>Deliveroo Performance</li>
            <li>Two Weeks Performance</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card text-left">
        <div class="card-body">

    <ul class="nav nav-tabs" id="myIconTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="criticle-icon-tab" data-toggle="tab" href="#criticle" role="tab" aria-controls="criticle" aria-selected="true">Criticle</a></li>
        <li class="nav-item"><a class="nav-link" id="bad-icon-tab" data-toggle="tab" href="#bad" role="tab" aria-controls="bad" aria-selected="false">Bad</a></li>
        <li class="nav-item"><a class="nav-link" id="good-icon-tab" data-toggle="tab" href="#good" role="tab" aria-controls="bad" aria-selected="false">Good</a></li>
    </ul>

            <div class="tab-content" id="myIconTabContent">

                <div class="tab-pane fade show active" id="criticle" role="tabpanel" aria-labelledby="criticle-icon-tab">
                    <table class="display table" id="datatable1" style="width: 100%">
                        <thead class="thead-dark">
                        <tr class="show-table">
                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col">Hours Scheduled</th>
                            <th scope="col">Hours Worked</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">No of orders delivered</th>
                            <th scope="col">Unassigned</th>
                            <th scope="col">Wait time at customer</th>
                            <th scope="col" >Rating</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($averrage_rating as $avg) {
                        ?>
                        <?php
                        if ($avg->attendance < $del_setting->attendance_critical_value) {
                            $att_rating = 1;
                        } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
                            $att_rating = 2;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
                            $att_rating = 3;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value) {
                            $att_rating = 4;
                        }
                        //unassigned
                        if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
                            $un_ass_rating = 1;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 2;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
                            $un_ass_rating = 3;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 4;
                        }
                        //wait at customer
                        if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
                            $wait_rating = 1;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
                            $wait_rating = 2;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
                            $wait_rating = 3;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value) {
                            $wait_rating = 4;
                        }
                        //-----------------rating calculation--------------
                        $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                        $final_avg = $avg_rating / 3;
                        $final_rating = ($final_avg / 4) * 5;
                        if ($avg->hours_scheduled>0 && $avg->attendance == 0) {
                            $rating = 0.00;
                        }
                        elseif($avg->hours_scheduled==0){
                            $rating = "N/A";
                        }
                        else {
                            $rating = number_format($final_rating, 2);
                        }
                        ?>
                        @if($rating < 2 && $rating=="N/A")
                            <tr>


                                <td> {{isset($avg->platform_code)?$avg->platform_code->platform_code:"N/A"}}</td>
                                <td> {{isset($avg->rider_name)?$avg->rider_name:"N/A"}}</td>
                                {{--                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"NA"}}</td>--}}
                                <td> {{isset($avg->hours_scheduled)?$avg->hours_scheduled:"N/A"}}</td>
                                <td> {{isset($avg->hours_worked)?$avg->hours_worked:""}}</td>
                                <td> {{isset($avg->attendance)?$avg->attendance:""}} %</td>
                                <td> {{ isset($avg->no_of_orders_delivered)?$avg->no_of_orders_delivered:"N/A"}}</td>
                                <td> {{isset($avg->unassigned)?$avg->unassigned:"N/A"}} %</td>
                                <td> {{isset($avg->wait_time_at_customer)?$avg->wait_time_at_customer:"N/A"}}</td>


                                <td>{{$rating}}</td>

                            </tr>
                        @endif
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="bad" role="tabpanel" aria-labelledby="home-icon-tab">
                    <table class="display table" id="datatable2" style="width: 100%">
                        <thead class="thead-dark">
                        <tr class="show-table">
                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col">Hours Scheduled</th>
                            <th scope="col">Hours Worked</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">No of orders delivered</th>
                            <th scope="col">Unassigned</th>
                            <th scope="col">Wait time at customer</th>
                            <th scope="col" >Rating</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($averrage_rating as $avg) {
                        ?>
                        <?php
                        if ($avg->attendance < $del_setting->attendance_critical_value) {
                            $att_rating = 1;
                        } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
                            $att_rating = 2;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
                            $att_rating = 3;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value) {
                            $att_rating = 4;
                        }
                        //unassigned
                        if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
                            $un_ass_rating = 1;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 2;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
                            $un_ass_rating = 3;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 4;
                        }
                        //wait at customer
                        if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
                            $wait_rating = 1;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
                            $wait_rating = 2;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
                            $wait_rating = 3;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value) {
                            $wait_rating = 4;
                        }
                        //-----------------rating calculation--------------
                        $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                        $final_avg = $avg_rating / 3;
                        $final_rating = ($final_avg / 4) * 5;
                        if ($avg->attendance == 0) {
                            $rating = 0.00;
                        } else {
                            $rating = number_format($final_rating, 2);
                        }
                        ?>
                        @if($rating >= 2 && $rating < 3)
                            <tr>
                                <td> {{isset($avg->platform_code)?$avg->platform_code->platform_code:"N/A"}}</td>
                                <td> {{isset($avg->rider_name)?$avg->rider_name:"N/A"}}</td>
                                {{--                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"NA"}}</td>--}}
                                <td> {{isset($avg->hours_scheduled)?$avg->hours_scheduled:"N/A"}}</td>
                                <td> {{isset($avg->hours_worked)?$avg->hours_worked:""}}</td>
                                <td> {{isset($avg->attendance)?$avg->attendance:""}} %</td>
                                <td> {{ isset($avg->no_of_orders_delivered)?$avg->no_of_orders_delivered:"N/A"}}</td>
                                <td> {{isset($avg->unassigned)?$avg->unassigned:"N/A"}} %</td>
                                <td> {{isset($avg->wait_time_at_customer)?$avg->wait_time_at_customer:"N/A"}}</td>
                                <td>{{$rating}}</td>

                            </tr>
                        @endif
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="good" role="tabpanel" aria-labelledby="home-icon-tab">
                    <table class="display table" id="datatable3" style="width: 100%">
                        <thead class="thead-dark">
                        <tr class="show-table">
                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col">Hours Scheduled</th>
                            <th scope="col">Hours Worked</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">No of orders delivered</th>
                            <th scope="col">Unassigned</th>
                            <th scope="col">Wait time at customer</th>
                            <th scope="col" >Rating</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($averrage_rating as $avg) {
                        ?>
                        <?php
                        if ($avg->attendance < $del_setting->attendance_critical_value) {
                            $att_rating = 1;
                        } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
                            $att_rating = 2;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
                            $att_rating = 3;
                        } elseif ($avg->attendance >= $del_setting->attendance_bad_value) {
                            $att_rating = 4;
                        }
                        //unassigned
                        if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
                            $un_ass_rating = 1;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 2;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
                            $un_ass_rating = 3;
                        } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 4;
                        }
                        //wait at customer

                        if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
                            $wait_rating = 1;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
                            $wait_rating = 2;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
                            $wait_rating = 3;
                        } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value) {
                            $wait_rating = 4;
                        }
                        //-----------------rating calculation--------------
                        $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                        $final_avg = $avg_rating / 3;
                        $final_rating = ($final_avg / 4) * 5;
                        if ($avg->attendance == 0) {
                            $rating = 0.00;
                        } else {
                            $rating = number_format($final_rating, 2);
                        }
                        ?>
                        @if($rating >= 3)
                            <tr>


                                <td> {{isset($avg->platform_code)?$avg->platform_code->platform_code:"N/A"}}</td>
                                <td> {{isset($avg->rider_name)?$avg->rider_name:"N/A"}}</td>
                                {{--                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"NA"}}</td>--}}
                                <td> {{isset($avg->hours_scheduled)?$avg->hours_scheduled:"N/A"}}</td>
                                <td> {{isset($avg->hours_worked)?$avg->hours_worked:""}}</td>
                                <td> {{isset($avg->attendance)?$avg->attendance:""}} %</td>
                                <td> {{ isset($avg->no_of_orders_delivered)?$avg->no_of_orders_delivered:"N/A"}}</td>
                                <td> {{isset($avg->unassigned)?$avg->unassigned:"N/A"}} %</td>
                                <td> {{isset($avg->wait_time_at_customer)?$avg->wait_time_at_customer:"N/A"}}</td>
                                <td>{{$rating}}</td>

                            </tr>
                        @endif
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



    <script>
        $(document).ready(function () {
            'use strict';


            $('#datatable1,#datatable2,#datatable3').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Two Weeks Rating',
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

            $('#platform').select2({
                placeholder: 'Select an option'
            });



        });

    </script>

    <script>

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;


                if(split_ab=="criticle-icon-tab"){

                    var table = $('#datatable1').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="bad-icon-tab"){
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
                else
                    {
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
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
