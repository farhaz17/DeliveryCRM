@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table#datatable {
            font-size: 13px;
        }
        tr.t-row {
            font-size: 12px;
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
            font-size: 12px;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-revoke {
    padding: 1px;
    font-size: 0px;
}
.submenu{
            display: none;
        }
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Replacement History</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">

        <div class="row">
        <div class="col-12">
        <div class="card text-left">
            <div class="card-body">



                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable" >
                                <thead>
                                <tr class="t-row">
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Replaced With Name</th>
                                    <th scope="col">Replace With Passport No</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Request Sent at</th>
                                    {{-- <th scope="col">Sent by</th> --}}



                                </tr>
                                </thead>
                                <tbody>
                                 @foreach($history as $res)
                                    <tr>
                                        <td>{{isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:""}}</td>
                                        <td>{{ isset($res->passport->passport_no)?$res->passport->passport_no:""}}</td>
                                        <td>{{ isset($res->passport->pp_uid)?$res->passport->pp_uid:""}}</td>
                                        <td>{{ isset($res->replace_passport->passport_no)?$res->replace_passport->passport_no:""}}</td>
                                        <td>{{ isset($res->replace_passport->personal_info->full_name)?$res->replace_passport->personal_info->full_name:""}}</td>
                                        <td>{{ isset($res->remarks)?$res->remarks:""}}</td>
                                        <td>{{ isset($res->created_at)?$res->created_at:""}}</td>
                                        {{-- <td>{{ isset($res->user_detail->name)?$res->user_detail->name:""}}</td> --}}

                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>


                    </div>

                </div>


            </div>
        </div>



        <div class="overlay"></div>


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
                    {"targets": [0],"visible": true},
                    {"targets": [0],"width": "25%"}
                ],
                "scrollY": false,
            });

        });

    </script>



@endsection

