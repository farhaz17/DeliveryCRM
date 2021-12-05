@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .upload {
            padding: 1px;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Food Permit</a></li>
        <li>All Process</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true"> All Requests ({{$foods->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Document Uploaded ({{$doc_uploaded->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="PermitTab" data-toggle="tab" href="#Permit" role="tab" aria-controls="Permit" aria-selected="true">Food Permit Uploaded ({{$permit_uploaded->count()}})</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="card-title">Upload Documents</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Requested Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($foods as $bike)
                                <?php
                                if(in_array($bike->bike_id, $expired))  $renew = "renewal";
                                ?>
                                <tr @isset($renew) style="background-color: #ff18004a;" @endisset >
                                    <td></td>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->city->name }}</td>
                                    <td>{{ $bike->users->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($bike->created_at)) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('food_permit_process') }}?id={{ $bike->bike_id }}" target="_blank">Upload Documents</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <div class="card-title">Upload Permit</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="uploaded" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Uploaded Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doc_uploaded as $bike)
                                <?php
                                    if(in_array($bike->bike_id, $expired))  $renew = "renewal";
                                ?>
                                <tr @isset($renew) style="background-color: #ff18004a;" @endisset >
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->city->name }}</td>
                                    <td>{{ $bike->documents }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('food_permit_process') }}?id={{ $bike->bike_id }}" target="_blank">Upload Food Permit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Permit" role="tabpanel" aria-labelledby="PermitTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="permits" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Uploaded Date</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permit_uploaded as $bike)
                                <?php
                                    if(in_array($bike->bike_id, $expired))  $renew = "renewal";
                                ?>
                                <tr @isset($renew) style="background-color: #ff18004a;" @endisset >
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->city->name }}</td>
                                    <td>{{ $bike->permit_upload_date }}</td>
                                    <td>{{ $bike->expiry_date }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('food_permit_process') }}?id={{ $bike->bike_id }}" target="_blank">View Details</a>
                                    </td>
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#requests').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
        });
        var table = $('#uploaded').DataTable();
        table.columns.adjust().draw();
        var table = $('#permits').DataTable();
        table.columns.adjust().draw();
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
