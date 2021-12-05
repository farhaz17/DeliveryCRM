@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Box</a></li>
        <li>Box Removal</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-11" id="removal" style="width: 100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Bike</th>
                            <th scope="col">Box</th>
                            <th scope="col">Removed Date</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Removed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boxes as $box)
                        <tr>
                            <td></td>
                            <td>{{ $box->bikes->plate_no }}</td>
                            <td>@if(isset($box))
                                @if($box->box_image!=null)
                                    @foreach (json_decode($box->box_image) as $attach)
                                        <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Image</strong></a><span>|</span>
                                    @endforeach
                                @else
                                    <strong>NO Images Uploaded</strong>
                                @endif
                                @endif</td>
                            <td>{{ $box->remove_date }}</td>
                            <td>{{ $box->remove_remark }}</td>
                            <td>{{ isset($box->removed_user->name) ? $box->removed_user->name:''}}</td>
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
            $('#removal').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
        });
    </script>
@endsection
