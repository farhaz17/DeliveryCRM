@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .view_cls i{
            font-size: 15px !important;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Deliveroo</a></li>
        <li>Rider COD</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-11" id="datatable">
                    <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Name</th>
                        <th scope="col">Rider Id</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">Remain Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($riders as $rider)
                        <?php
                        $total_pending_amount = 0;
                        $total_paid_amount = 0;
                        $total_pending_amount = $rider->total;

                        if(isset($rider->cods)){
                            $now_cod = $rider->cods->cod_total;
                        }else {
                            $now_cod = 0;
                        }
                        if(isset($rider->codadjust)){
                            $adj_req_t = $rider->codadjust->adj_req_total;
                        }else {
                            $adj_req_t = 0;
                        }
                        if(isset($rider->close_month)){
                            $close_m = $rider->close_month->close_total;
                        }else {
                            $close_m = 0;
                        }
                        if($now_cod != null){
                            $total_paid_amount = $now_cod;
                        }
                        if($close_m != null){
                            $total_paid_amount = $total_paid_amount+$close_m;
                        }
                        if($adj_req_t != null){
                            $total_paid_amount = $total_paid_amount+$adj_req_t;
                        }
                        $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                        ?>
                        <tr>
                            <td></td>
                            <td>{{ $rider->passport->personal_info->full_name }}</td>
                            @if (!$rider->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                            @else
                                <td>N/A</td>
                            @endif
                            <td> {{ isset($rider->rider_profile->contact_no) ? $rider->rider_profile->contact_no : '' }}</td>
                            <td>{{ isset($remain_amount) ? $remain_amount : 'N/A' }}</td>
                            <td><a class="text-primary mr-2 view_cls" href="{{ url('rider_wise_cod_deliveroo') }}?passport_id={{ $rider->passport_id }}" target="_blank"><i class="nav-icon i-eye font-weight-bold"></i></a></td>
                        </tr>
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
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Deliveroo Cod',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
            });
        });
    </script>
@endsection
