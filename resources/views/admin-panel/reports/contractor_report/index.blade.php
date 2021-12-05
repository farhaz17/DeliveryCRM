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

        a.btn.btn-primary.btn-sm.mr-2 {
            /* height: 21px; */
            padding: 1px;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>4 Pl Contractor Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>







    <!--------Passport Additional Information--------->

    <div class="card col-lg-9 offset-lg-1 mb-2">
        <div class="row">

            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a href="{{url('contractor_all')}}" target="_blank" class="btn btn-success m-1" type="button">View All Details</a>
            </div>
        </div>


                <table class="table tab-border mt-1" id="datatable" width="100%">

                    <thead class="thead-dark">
                    <tr>

                        <th scope="col">4 Pl Name</th>
                        <th scope="col" >Number of riders</th>
                        <th scope="col" >Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fourpl_names as $row)
                        <tr>
                            <td> {{isset($row->name)?$row->name:""}}</td>
                            <td class="font-weight-bold">{{count($agreemnt->where('four_pl_name',$row->id))}}</td>
                            <td>

                                <a class="btn btn-primary btn-sm mr-2" href="{{route('contractor_report.show',$row->id)}}" target="_blank">
                                  View Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td><span class="font-weight-bold">Total Riders={{$fourpl_names_all}}</span></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>

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
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>



@endsection
