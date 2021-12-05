@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .modal-content {
            width: 700px;
        }
        .remarks {
            text-align: justify;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Fuel Platform</a></li>
            <li><a href="{{ route('fuel_platform.create') }}" title="Click to add new Fuel Platform">Register new Fuel Platform </a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active show" id="newFuelPlatformTab" data-toggle="tab" href="#newFuelPlatform" role="tab" aria-controls="newFuelPlatform" aria-selected="true">Current Fuel Platforms ({{ count($fuelplatforms->where('checkout', null)) }})</a></li>
        <li class="nav-item"><a class="nav-link " id="checkedOutFuelPlatformTab" data-toggle="tab" href="#checkedOutFuelPlatform" role="tab" aria-controls="checkedOutFuelPlatform" aria-selected="true">Fuel Platforms History  ({{ count($fuelplatforms->where('checkout', !null)) }})</a></li>
    </ul>
    <br><br><br>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="newFuelPlatform" role="tabpanel" aria-labelledby="newFuelPlatformTab">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm text-10" id="newRegisteredFuelPlatformTable" style="">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Platform</th>
                                    <th>Status</th>
                                    <th>Cities</th>
                                    <th>Checkin</th>
                                    <th>Checkout</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fuelplatforms->where('checkout', null) as $fuelplatform)
                                    <tr>
                                        
                                        <td>{{ $fuelplatform->platform->name ?? "" }}</td>
                                        <td>{{ $fuelplatform->status == 1 ?  "Yes" : "No" }}</td>
                                        <td>
                                            @foreach ($fuelplatform->cities as $city)
                                                <span class="badge bg-success text-white">{{ $city->name ?? ", " }}</span>
                                            @endforeach    
                                        </td>
                                        <td>{{ $fuelplatform->checkin ?? "" }}</td>
                                        <td>{{ $fuelplatform->checkout ?? "" }} </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('fuel_platform.edit', $fuelplatform->id) }}"><i class="i-Pen-4"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="tab-pane fade" id="checkedOutFuelPlatform" role="tabpanel" aria-labelledby="checkedOutFuelPlatformTab">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm text-10" id="checkedOutFuelPlatformTable" style="">
                                <thead class="thead-dark">
                                <tr>
                                    
                                    <th>Platform</th>
                                    <th>Status</th>
                                    <th>Cities</th>
                                    <th>Checkin</th>
                                    <th>Checkout</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fuelplatforms->where('checkout', !null) as $fuelplatform)
                                    <tr>
                                       
                                        <td>{{ $fuelplatform->platform->name ?? "" }}</td>
                                        <td>{{ $fuelplatform->status == 1 ?  "Yes" : "No" }}</td>
                                        <td>
                                            @foreach ($fuelplatform->cities as $city)
                                                <span class="badge bg-success text-white">{{ $city->name ?? ", " }}</span>
                                            @endforeach    
                                        </td>
                                        <td>{{ $fuelplatform->checkin ?? "" }}</td>
                                        <td>{{ $fuelplatform->checkout ?? "" }} </td>
                                       
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            // $('#newRegisteredFuelPlatformTable').DataTable( {
            //     "aaSorting": [[0, 'desc']],
            //     "pageLength": 10,
            //     "columnDefs": [
            //         {"targets": [0],"visible": true},
            //         { "width": 300, "targets": [1] },
            //         { "width": 300, "targets": [6] },
            //         { "width": 300, "targets": [5] },
            //     ],
            //     "scrollY": false,
            //     "scrollX": true,
            // });


            var table = $('#newRegisteredFuelPlatformTable').DataTable();
                        table.DataTable().destroy();
                        $('#newRegisteredFuelPlatformTable').DataTable( {
                    // "aaSorting": [[0, 'desc']],
                    "pageLength": 10,
                    "columnDefs": [
                        {"targets": [0],"visible": true},
                        { "width": 300, "targets": [1] },
                        { "width": 300, "targets": [6] },
                        { "width": 300, "targets": [5] },
                    ],
                    "scrollY": false,
                    "scrollX": true,
                });
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id');

                if(currentTab== "newFuelPlatformTab"){
                    var table = $('#newRegisteredFuelPlatformTable').DataTable();
                        table.DataTable().destroy();
                        $('#newRegisteredFuelPlatformTable').DataTable( {
                    // "aaSorting": [[0, 'desc']],
                    "pageLength": 10,
                    "columnDefs": [
                        {"targets": [0],"visible": true},
                        { "width": 300, "targets": [1] },
                        { "width": 300, "targets": [6] },
                        { "width": 300, "targets": [5] },
                    ],
                    "scrollY": false,
                    "scrollX": true,
                });
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
                }
                else if(currentTab == "checkedOutFuelPlatformTab"){
                    var table = $('#checkedOutFuelPlatformTable').DataTable();
                        table.DataTable().destroy();
                            $('#checkedOutFuelPlatformTable').DataTable( {
                        // "aaSorting": [[0, 'desc']],
                        "pageLength": 10,
                        "columnDefs": [
                            {"targets": [0],"visible": true},
                            { "width": 300, "targets": [1] },
                            { "width": 300, "targets": [6] },
                            { "width": 300, "targets": [5] },
                        ],
                        "scrollY": false,
                        "scrollX": true,
                    });
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            }) ;
        });
    </script>
    <script>
        $(document).ready(function(){
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
        });
    </script>

@endsection
