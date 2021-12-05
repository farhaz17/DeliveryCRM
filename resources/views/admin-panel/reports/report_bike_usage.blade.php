@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Reports</a></li>
            <li>Bike Usage</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Parts Details</div>
                    <form method="get" action="{{route('reports_bike_summary')}}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Plate Number</label>
                                <select id="plate_id" name="plate_id" class="form-control form-control-rounded">
                                    <option value="">Select the plate number</option>
                                    @foreach($bikes as $bike)
                                        <option value="{{$bike->id}}">{{$bike->plate_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Start Date</label>
                                <input class="form-control form-control-rounded" id="start_tail" name="start-date" type="text" placeholder="Select the start date" required />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">End Date</label>
                                <input class="form-control form-control-rounded" id="end_tail" name="end-date" type="text" placeholder="Select the end date" required />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Plate Number</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Repair Date</th>
                            <th scope="col">Repaired Parts</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($query))
                        @foreach($query as $data)
                            <tr>
                                <td>{{$data->bike->plate_no}}</td>
                                <td>{{$data->zds_code}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    @foreach($data->repairParts as $partData)
                                    {{$partData->part->part_number}}<br>
                                        @endforeach
                                </td>
                                <td>
                                    @foreach($data->repairParts as $partData)
                                        {{$partData->quantity}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @if(isset($data->discount))
                                        {{$data->repairParts->sum('amount')*1.05 - $data->discount }}
                                    @endif
                                    @if(empty($data->discount))
                                            {{$data->repairParts->sum('amount')*1.05}}
                                        @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
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
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "scrollY": false,
                "columnDefs": [
                    { "width": "10%", "targets": 0 },
                    { "width": "10%", "targets": 1 },
                    { "width": "30%", "targets": 2 },
                    { "width": "15%", "targets": 3 },
                    { "width": "15%", "targets": 4 },
                    { "width": "10%", "targets": 5 },
                    { "width": "10%", "targets": 6 },
                ],

                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'print',
                        title: 'Bike Repair Summary',
                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Bike Repair Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Bike Repair Summary',
                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                select: true
            });

            $('#plate_id').select2({
                placeholder: 'Select an option'
            });

            tail.DateTime("#start_tail",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,

            }).on("change", function(){
                tail.DateTime("#end_tail",{
                    dateStart: $('#start_tail').val(),
                    dateFormat: "YYYY-mm-dd",
                    timeFormat: false

                }).reload();

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
