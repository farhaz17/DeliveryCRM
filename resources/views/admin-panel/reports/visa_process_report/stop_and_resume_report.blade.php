@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr {
            white-space: nowrap;
            font-size: 12px;
        }
        #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 2px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process Report</a></li>
            <li>Stop and Reseume Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                            <h2>Stop and Resumes</h2>
                            <table class="display table table-striped" id="datatable1" style="width: 100%" >
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Stop at Process</th>
                                    <th scope="col">Stop at</th>
                                    <th scope="col">Resumed at</th>
                                    <th scope="col">Stopped By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stop_resume as $row)
                                    <tr>
                                        <td> {{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                        <td> {{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                        <td> {{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                        <td> {{isset($row->master->step_name)?$row->master->step_name:"N/A"}}</td>
                                        <td>
                                            {{isset($row->created_at)?$row->created_at:"N/A"}}</td>
                                        <td>
                                            @if($row->status=='2')
                                            {{$row->updated_at}}
                                            @else
                                            <span class="badge badge-success m-2">Not Resumed Yet</span>

                                            @endif
                                        </td>
                                        <td>
                                         {{isset($row->user_info->name)?$row->user_info->name:'N/A'}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



    @endsection
    @section('js')
        <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                'use strict';
                $('#datatable1').DataTable( {
                    "aaSorting": [[0, 'desc']],
                    "pageLength": 10,

                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'PPUID Detail',
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
