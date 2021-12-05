{{--@extends('admin-panel.base.main')--}}
{{--@section('css')--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />--}}

{{--    <style>--}}
{{--        td.details-control {--}}
{{--            background: url('public/assets/icons/no-data.png') no-repeat center center;--}}
{{--            cursor: pointer;--}}
{{--        }--}}
{{--        tr.shown td.details-control {--}}
{{--            background: url('public/assets/icons/plus--v2.png') no-repeat center center;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <div class="breadcrumb">--}}
{{--        <h1 class="mr-2">Home</h1>--}}
{{--        <ul>--}}
{{--            <li><a href="">Reports</a></li>--}}
{{--            <li>Bike Usage</li>--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    <div class="separator-breadcrumb border-top"></div>--}}

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card mb-">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="card-title mb-3">Add Required Details</div>--}}
{{--                    <form method="post" action="{{url('report_purchase_value')}}">--}}
{{--                        {!! csrf_field() !!}--}}
{{--                        {{ method_field('POST') }}--}}

{{--                        <div class="row">--}}

{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                take dropdown vendor name--}}
{{--                                <label for="repair_category">Vendor Name</label>--}}
{{--                                <select id="vendor_name" name="vendor_name" class="form-control form-control-rounded">--}}
{{--                                    <option value="">--}}
{{--                                        Select Vendor Name--}}
{{--                                    </option>--}}
{{--                                    @foreach($bike_inv as $row)--}}

{{--                                        <option value="{{$row->vendor_name}}">{{$row->vendor_name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 form-group mb-3">--}}

{{--                                <label for="repair_category">Invoice Number</label>--}}
{{--                                <select id="invoice_number" name="invoice_number" class="form-control form-control-rounded"  required {{isset($inv_parts_data)?'disabled':""}}>--}}
{{--                                    <option value="">--}}
{{--                                        Select Invoice Number--}}
{{--                                    </option>--}}
{{--                                    @foreach($bike_inv as $row)--}}

{{--                                        <option value="{{$row->invoice_number}}">{{$row->invoice_number}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>                            </div>--}}

{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <button class="btn btn-primary">Generate</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                    <form method="post" action="{{url('report_purchase_date')}}">--}}
{{--                        {!! csrf_field() !!}--}}
{{--                        {{ method_field('POST') }}--}}

{{--                        <div class="row">--}}

{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">Start Date</label>--}}
{{--                                <input class="form-control form-control-rounded" id="start_tail" name="start-date" type="text" placeholder="Select the start date" required />--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">End Date</label>--}}
{{--                                <input class="form-control form-control-rounded" id="end_tail" name="end-date" type="text" placeholder="Select the end date" required />--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <button class="btn btn-primary">Generate</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}






{{--    <div class="col-md-12 mb-3">--}}
{{--        <div class="card text-left">--}}
{{--            <div class="card-body">--}}
{{--                <div class="table-responsive">--}}
{{--                    <table class="display table table-striped table-bordered" id="datatable">--}}
{{--                        <thead class="thead-dark">--}}
{{--                        <tr>--}}
{{--                            <th></th>--}}
{{--                            <th scope="col">Image</th>--}}
{{--                            <th scope="col">Upload Date</th>--}}
{{--                            <th scope="col">Vendor Name</th>--}}
{{--                            <th scope="col">Invoice Number</th>--}}


{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(isset($query))--}}
{{--                            @foreach($query as $data)--}}
{{--                                <tr>--}}
{{--                                    <td></td>--}}
{{--                                    <td>{{$data->image_path}}</td>--}}
{{--                                    <td>{{$data->upload_date}}</td>--}}
{{--                                    <td>{{$data->vendor_name}}</td>--}}
{{--                                    <td>{{$data->invoice_number}}</td>--}}

{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}
{{--@section('js')--}}
{{--    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            'use strict';--}}

{{--            $('#datatable').DataTable( {--}}
{{--                "aaSorting": [[0, 'desc']],--}}
{{--                "pageLength": 10,--}}
{{--                "scrollY": false,--}}
{{--                "columnDefs": [--}}
{{--                    { "width": "10%", "targets": 0 },--}}
{{--                    { "width": "10%", "targets": 1 },--}}
{{--                    { "width": "30%", "targets": 2 },--}}
{{--                    { "width": "15%", "targets": 3 },--}}
{{--                    { "width": "15%", "targets": 4 },--}}
{{--                    { "width": "10%", "targets": 5 },--}}
{{--                    { "width": "10%", "targets": 6 },--}}
{{--                ],--}}

{{--                dom: 'Bfrtip',--}}

{{--                buttons: [--}}
{{--                    {--}}
{{--                        extend: 'print',--}}
{{--                        title: 'Bike Repair Summary',--}}
{{--                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=20px;>',--}}
{{--                        exportOptions: {--}}
{{--                            modifier: {--}}
{{--                                page : 'all',--}}
{{--                            }--}}
{{--                        }--}}
{{--                    },--}}
{{--                    {--}}
{{--                        extend: 'excel',--}}
{{--                        title: 'Bike Repair Summary',--}}
{{--                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',--}}
{{--                        exportOptions: {--}}
{{--                            modifier: {--}}
{{--                                page : 'all',--}}
{{--                            }--}}
{{--                        }--}}
{{--                    },--}}
{{--                    {--}}
{{--                        extend: 'pdf',--}}
{{--                        title: 'Bike Repair Summary',--}}
{{--                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=20px;>',--}}
{{--                        exportOptions: {--}}
{{--                            modifier: {--}}
{{--                                page : 'all',--}}
{{--                            }--}}
{{--                        }--}}
{{--                    },--}}
{{--                ],--}}
{{--                select: true--}}
{{--            });--}}

{{--            $('#plate_id').select2({--}}
{{--                placeholder: 'Select an option'--}}
{{--            });--}}

{{--            tail.DateTime("#start_tail",{--}}
{{--                dateFormat: "YYYY-mm-dd",--}}
{{--                timeFormat: false,--}}

{{--            }).on("change", function(){--}}
{{--                tail.DateTime("#end_tail",{--}}
{{--                    dateStart: $('#start_tail').val(),--}}
{{--                    dateFormat: "YYYY-mm-dd",--}}
{{--                    timeFormat: false--}}

{{--                }).reload();--}}

{{--            });--}}

{{--        });--}}

{{--    </script>--}}
{{--    <script !src="">--}}

{{--        /* Formatting function for row details - modify as you need */--}}
{{--        function format ( d ) {--}}
{{--            // `d` is the original data object for the row--}}
{{--            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+--}}
{{--                '<tr>'+--}}
{{--                '<td>path:</td>'+--}}
{{--                '<td>'+d.image_path +'</td>'+--}}
{{--                '</tr>'+--}}
{{--                '<tr>'+--}}
{{--                '<td>Amount:</td>'+--}}
{{--                '<td>'+d.created_at+'</td>'+--}}
{{--                '</tr>'+--}}

{{--                '</table>';--}}
{{--        }--}}



{{--        function fetchRecords(id){--}}
{{--            $.ajax({--}}
{{--                url: 'showDetail/' + id,--}}
{{--                type: 'get',--}}
{{--                dataType: 'json',--}}
{{--                "columns": [--}}
{{--                    {--}}
{{--                        "className": 'details-control',--}}
{{--                        "orderable": false,--}}
{{--                        "data": null,--}}
{{--                        "defaultContent": ''--}}
{{--                    },--}}
{{--                    {"data": "Vendor Name"},--}}
{{--                    {"data": "Invoice Number"}--}}

{{--                ],--}}
{{--            }--}}
{{--        // $(document).ready(function() {--}}
{{--        //     var table = $('#example').DataTable( {--}}
{{--        //         "ajax"{}--}}
{{--        //         "columns": [--}}
{{--        //             {--}}
{{--        //                 "className":      'details-control',--}}
{{--        //                 "orderable":      false,--}}
{{--        //                 "data":           null,--}}
{{--        //                 "defaultContent": ''--}}
{{--        //             },--}}
{{--        //             { "data": "Vendor Name" },--}}
{{--        //             { "data": "Invoice Number" }--}}
{{--        //--}}
{{--        //         ],--}}
{{--        //         "order": [[1, 'asc']]--}}
{{--        //     } );--}}

{{--            // Add event listener for opening and closing details--}}
{{--            $('#example tbody').on('click', 'td.details-control', function () {--}}
{{--                var tr = $(this).closest('tr');--}}
{{--                var row = table.row( tr );--}}

{{--                if ( row.child.isShown() ) {--}}
{{--                    // This row is already open - close it--}}
{{--                    row.child.hide();--}}
{{--                    tr.removeClass('shown');--}}
{{--                }--}}
{{--                else {--}}
{{--                    // Open this row--}}
{{--                    row.child( format(row.data()) ).show();--}}
{{--                    tr.addClass('shown');--}}
{{--                }--}}
{{--            } );--}}
{{--        } );--}}
{{--    </script>--}}

{{--@endsection--}}
