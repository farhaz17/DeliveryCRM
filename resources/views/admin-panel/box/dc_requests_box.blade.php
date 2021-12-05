@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Box</a></li>
        <li>Dc Requests </li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true"> Pending Requests ({{$bikes->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Rejected Requests ({{$rejects->count()}})</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Requested Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bikes as $bike)
                                <tr>
                                    <td></td>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->users->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($bike->created_at)) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success accepts" type="button" data-toggle="modal" data-target="#accept_modal" data-id="{{ $bike->id }}">Accept</button>
                                        <button class="btn btn-sm btn-danger rejects" type="button" data-toggle="modal" data-target="#reject_modal" data-id="{{ $bike->id }}">Reject</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="reject" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Requested Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rejects as $bike)
                                <tr>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->users->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($bike->created_at)) }}</td>
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

<div class="modal fade" id="accept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('accept_box_request') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Accept Request</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    Are You Sure Want To Accept The Request
                    <input type="hidden" name="id" id="ids">
                    <input type="hidden" name="type" id="type" value="1">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success ml-2" type="submit">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('accept_box_request') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Reject Request</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    Are You Sure Want To Reject The Request
                    <input type="hidden" name="id" id="idss">
                    <input type="hidden" name="type" id="type" value="2">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger ml-2" type="submit">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $('.accepts').click(function(){
            var ids = $(this).attr('data-id');
            var id = $('#ids').val(ids);
            $('#accept_modal').show();
        });
        $('.rejects').click(function(){
            var ids = $(this).attr('data-id');
            var id = $('#idss').val(ids);
            $('#reject_modal').show();
        });
    </script>
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
        var tables = $('#reject').DataTable();
        tables.columns.adjust().draw();
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
