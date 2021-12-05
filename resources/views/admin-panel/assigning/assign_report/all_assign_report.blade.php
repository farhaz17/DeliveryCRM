@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
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
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Assigning Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>







    <!--------Passport Additional Information--------->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">All Checkin</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Free Bikes</a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
     <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">


                        <table class="table table-striped" id="datatable"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Passport Number</th>
                                <th scope="col">ZDS Code</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">Platform</th>
                                <th scope="col">SIM Number</th>
                                <th scope="col">Bike Plate Number</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($passport as $row)
{{--                                @if (!$row->sim_assign->isEmpty())--}}
{{--                                    @if (!$row->bike_assign->isEmpty())--}}
                                        @if (!$row->platform_assign->isEmpty())


                                    <tr>
                                        <td style="font-size: 13px; white-space: nowrap"> {{ isset($row->personal_info->full_name)?$row->personal_info->full_name:"N/A"}}</td>
                                        <td> {{isset($row->passport_no)?$row->passport_no:""}}</td>
                                        <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:""}}</td>
                                        <td> {{ $row->pp_uid}}</td>
                                        @if (!$row->platform_assign->isEmpty())
                                            @foreach($row->platform_assign as $rw)
                                                <td>{{$rw->plateformdetail->name}}</td>
                                            @endforeach
                                        @else
                                            <td>N/A</td>
                                        @endif

                                        @if (!$row->sim_assign->isEmpty())
                                            @foreach($row->sim_assign as $rw)
                                                <td>{{$rw->telecome->account_number}}</td>
                                            @endforeach
                                        @else
                                            <td>N/A</td>
                                        @endif

                                        @if (!$row->bike_assign->isEmpty())
                                            @foreach($row->bike_assign as $rw)
                                                <td>{{$rw->bike_plate_number->plate_no}}</td>
                                            @endforeach
                                        @else
                                            <td>N/A</td>
                                        @endif



                                    </tr>
                                        @endif
{{--                                    @endif--}}
{{--                                @endif--}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>
     </div>
        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
            2
        </div>
    </div>




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    { "width": 600, "targets": [0] }


                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'

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
