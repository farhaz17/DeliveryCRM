@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
        .checked {
            color: orange;
        }

    </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Performance</a></li>
            <li>Deliveroo Performance</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <h4 align="center"><i class="text-20 i-Calendar-4"></i>&nbsp;{{$range->date_from}}&nbsp;-&nbsp;{{$range->date_to}}</h4>
                <div class="card-body">

                    <table class="display table" id="datatable">
                        <thead class="thead-dark">
                        <tr class="show-table">
{{--                            <th scope="col" >Rider ID</th>--}}
                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col" >Status</th>
                            <th scope="col">Hours Scheduled</th>
                            <th scope="col">Hours Worked</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">No of orders delivered</th>
                            <th scope="col">No of orders unassignedr</th>
                            <th scope="col">Unassigned</th>
                            <th scope="col">Wait time at customer</th>
{{--                            <th scope="col">Rating 1</th>--}}
{{--                            <th scope="col">Rating 2</th>--}}
{{--                            <th scope="col">Rating 3</th>--}}
                            <th scope="col"> Rating </th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deliveroo as $del)
                            <tr>
{{--                                <td> {{isset($del->rider_id)?$del->rider_id:"N/A"}}</td>--}}
                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"N/A"}}</td>
                                <td> {{isset($del->rider_name)?$del->rider_name:"N/A"}}</td>
                                <td> {{isset($del->status)?$del->status:"N/A"}}</td>
{{--                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"NA"}}</td>--}}
                                <td> {{isset($del->hours_scheduled)?$del->hours_scheduled:"N/A"}}</td>
                                <td> {{isset($del->hours_worked)?$del->hours_worked:""}}</td>
                                <td> {{isset($del->attendance)?$del->attendance:""}} %</td>
                                <td> {{ isset($del->no_of_orders_delivered)?$del->no_of_orders_delivered:"N/A"}}</td>
                                <td> {{isset($del->no_of_orders_unassignedr)?$del->no_of_orders_unassignedr:"N/A"}}</td>
                                <td> {{isset($del->unassigned)?$del->unassigned:"N/A"}} %</td>
                                <td> {{isset($del->wait_time_at_customer)?$del->wait_time_at_customer:"N/A"}}</td>

{{--                                rating 1--------------}}

                                @if($del->attendance < $del_setting->attendance_critical_value)
                                    <span style="display: none">{{$att_rating=1}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_critical_value && $del->attendance < $del_setting->attendance_bad_value )
                                    <span style="display: none"> {{$att_rating=2}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_bad_value && $del->attendance < $del_setting->attendance_good_value)
                                    <span style="display: none">{{$att_rating=3}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_bad_value)
                                    <span style="display: none">{{$att_rating=4}}</span>
                                @endif


{{--                                rating 2--}}


                                @if($del->unassigned >= $del_setting->unassigned_critical_value)
                                    <span style="display: none">{{$un_ass_rating=1}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_critical_value && $del->unassigned > $del_setting->unassigned_bad_value )
                                    <span style="display: none"> {{$un_ass_rating=2}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_bad_value && $del->unassigned > $del_setting->unassigned_good_value)
                                    <span style="display: none">{{$un_ass_rating=3}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_bad_value)
                                    <span style="display: none">{{$un_ass_rating=4}}</span>
                                @endif

{{--3rd rating--}}

                                @if($del->wait_time_at_customer >= $del_setting->wait_critical_value)
                                    <span style="display: none">{{$wait_rating=1}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_critical_value && $del->wait_time_at_customer > $del_setting->wait_bad_value )
                                    <span style="display: none"> {{$wait_rating=2}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_bad_value && $del->wait_time_at_customer > $del_setting->wait_good_value)
                                    <span style="display: none">{{$wait_rating=3}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_bad_value)
                                    <span style="display: none">{{$wait_rating=4}}</span>
                                @endif

{{--                                <td>{{$wait_rating}}</td>--}}
                                <span style="display: none">
                                    {{$avg_rating=$att_rating+$un_ass_rating+$wait_rating}}
                                    {{$final_avg=$avg_rating/3}}
                                    {{ $final_rating=($final_avg/4)*5 }}
                                </span>

                                @if($del->hours_scheduled>0 && $del->attendance==0)
                                    <th>0.00/5</th>
                                 @elseif($del->hours_scheduled==0)
                                    <th>N/A</th>
                                @else
                                <th>{{number_format($final_rating,2) }}/5</th>
                                @endif


                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <h4 align="center"><i class="text-20 i-Calendar-4"></i>&nbsp;{{$range->date_from}}&nbsp;-&nbsp;{{$range->date_to}}</h4>
                <div class="card-body">
                    <h2 class="text-center" style="color:red">Missing Rider Ids</h2>

                    <table class="display table" id="datatable2">
                        <thead class="thead-dark">
                        <tr class="show-table">
                            {{--                            <th scope="col" >Rider ID</th>--}}
                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col" >Status</th>
                            <th scope="col">Hours Scheduled</th>
                            <th scope="col">Hours Worked</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">No of orders delivered</th>
                            <th scope="col">No of orders unassignedr</th>
                            <th scope="col">Unassigned</th>
                            <th scope="col">Wait time at customer</th>
                            {{--                            <th scope="col">Rating 1</th>--}}
                            {{--                            <th scope="col">Rating 2</th>--}}
                            {{--                            <th scope="col">Rating 3</th>--}}
                            <th scope="col"> Rating </th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deliveroo as $del)
                            @if(!isset($del->platform_code->platform_code))
                            <tr>
                                {{--                                <td> {{isset($del->rider_id)?$del->rider_id:"N/A"}}</td>--}}
                                <td> {{isset($del->rider_id)?$del->rider_id:"N/A"}}</td>
                                <td> {{isset($del->rider_name)?$del->rider_name:"N/A"}}</td>
                                <td> {{isset($del->status)?$del->status:"N/A"}}</td>
                                {{--                                <td> {{isset($del->platform_code)?$del->platform_code->platform_code:"NA"}}</td>--}}
                                <td> {{isset($del->hours_scheduled)?$del->hours_scheduled:"N/A"}}</td>
                                <td> {{isset($del->hours_worked)?$del->hours_worked:""}}</td>
                                <td> {{isset($del->attendance)?$del->attendance:""}} %</td>
                                <td> {{ isset($del->no_of_orders_delivered)?$del->no_of_orders_delivered:"N/A"}}</td>
                                <td> {{isset($del->no_of_orders_unassignedr)?$del->no_of_orders_unassignedr:"N/A"}}</td>
                                <td> {{isset($del->unassigned)?$del->unassigned:"N/A"}} %</td>
                                <td> {{isset($del->wait_time_at_customer)?$del->wait_time_at_customer:"N/A"}}</td>

                                {{--                                rating 1--------------}}

                                @if($del->attendance < $del_setting->attendance_critical_value)
                                    <span style="display: none">{{$att_rating=1}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_critical_value && $del->attendance < $del_setting->attendance_bad_value )
                                    <span style="display: none"> {{$att_rating=2}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_bad_value && $del->attendance < $del_setting->attendance_good_value)
                                    <span style="display: none">{{$att_rating=3}}</span>
                                @elseif($del->attendance >= $del_setting->attendance_bad_value)
                                    <span style="display: none">{{$att_rating=4}}</span>
                                @endif


                                {{--                                rating 2--}}


                                @if($del->unassigned >= $del_setting->unassigned_critical_value)
                                    <span style="display: none">{{$un_ass_rating=1}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_critical_value && $del->unassigned > $del_setting->unassigned_bad_value )
                                    <span style="display: none"> {{$un_ass_rating=2}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_bad_value && $del->unassigned > $del_setting->unassigned_good_value)
                                    <span style="display: none">{{$un_ass_rating=3}}</span>
                                @elseif($del->unassigned <= $del_setting->unassigned_bad_value)
                                    <span style="display: none">{{$un_ass_rating=4}}</span>
                                @endif

                                {{--3rd rating--}}

                                @if($del->wait_time_at_customer >= $del_setting->wait_critical_value)
                                    <span style="display: none">{{$wait_rating=1}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_critical_value && $del->wait_time_at_customer > $del_setting->wait_bad_value )
                                    <span style="display: none"> {{$wait_rating=2}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_bad_value && $del->wait_time_at_customer > $del_setting->wait_good_value)
                                    <span style="display: none">{{$wait_rating=3}}</span>
                                @elseif($del->wait_time_at_customer <= $del_setting->wait_bad_value)
                                    <span style="display: none">{{$wait_rating=4}}</span>
                                @endif

                                {{--                                <td>{{$wait_rating}}</td>--}}
                                <span style="display: none">
                                    {{$avg_rating=$att_rating+$un_ass_rating+$wait_rating}}
                                    {{$final_avg=$avg_rating/3}}
                                    {{ $final_rating=($final_avg/4)*5 }}
                                </span>

                                @if($del->hours_scheduled>0 && $del->attendance==0)
                                    <th>0.00/5</th>
                                @elseif($del->hours_scheduled==0)
                                    <th>N/A</th>
                                @else
                                    <th>{{number_format($final_rating,2) }}/5</th>
                                @endif


                            </tr>
                            @endif
                        @endforeach


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

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    {"targets": [0],"width": "10%"},
                    {"targets": [1],"width": "20%"}
                ],
                "scrollY": false,
                "scrollX": false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Deliveroo',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
            });
            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    {"targets": [0],"width": "10%"},
                    {"targets": [1],"width": "20%"}
                ],
                "scrollY": false,
                "scrollX": false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Deliveroo',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
            });

            $('#platform').select2({
                placeholder: 'Select an option'
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
