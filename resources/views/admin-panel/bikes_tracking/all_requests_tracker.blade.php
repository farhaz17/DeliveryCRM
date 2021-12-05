@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Tracker</a></li>
        <li>All Requests</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-2 mb-3"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="card-title">Tracker Installation Requests</div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width:100%;">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Plate No</th>
                            <th scope="col">Requested Date</th>
                            <th scope="col">Requested By</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($trackers as $tracker)
                            <tr>
                                <td></td>
                                <td>{{ $tracker->bike->plate_no }}</td>
                                <td>{{ $tracker->date }}</td>
                                <td>{{ $tracker->user->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            $('#requests').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });
        });
    </script>
@endsection
