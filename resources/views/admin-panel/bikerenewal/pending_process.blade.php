@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <style>
        .upload {
            padding: 1px;
            font-size: 11px;
            font-weight: bold;
        }
        .uploads {
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
        <li><a href="">Bike Renewal</a></li>
        <li>Pending Process</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true">Token Issued ({{$tokens->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Cash Approved ({{$cashs->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="SendedTab" data-toggle="tab" href="#Sended" role="tab" aria-controls="Sended" aria-selected="true">Expiry Updated ({{$finished->count()}})</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="card-title">Cash Requisition</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Token</th>
                                    <th scope="col">Attchment</th>
                                    <th scope="col">Registration Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tokens as $token)
                                <tr>
                                    <td></td>
                                    <td>{{ $token->bike->plate_no }}</td>
                                    <td>{{ $token->token }}</td>
                                    <td>@if(isset($token))
                                        @if($token->token_attachment!=null)
                                            @foreach (json_decode($token->token_attachment) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                            <strong></strong>
                                        @endif
                                    @endif</td>
                                    <td>{{ $token->bike->expiry_date }}</td>
                                    <td><a class="btn btn-primary btn-sm upload" id="{{ $token->id }}" href="javascript:void(0)">Cash Requisition</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <div class="card-title">Upload Renewed Details</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="uploaded" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Requested Date</th>
                                    <th scope="col">Registration Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cashs as $bike)
                                <tr>
                                    <td>{{ $bike->bike->plate_no }}</td>
                                    <td>{{ $bike->cash_amount }}</td>
                                    <td>{{ $bike->cash_date }}</td>
                                    <td>{{ $bike->bike->expiry_date }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm uploads" id="{{ $bike->id }}" href="javascript:void(0)">Upload Renewed Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Sended" role="tabpanel" aria-labelledby="SendedTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="send" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">New Issue Date</th>
                                    <th scope="col">New Expiry Date</th>
                                    <th scope="col">Mulkia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($finished as $bike)
                                <tr>
                                    <td>{{ $bike->bike->plate_no }}</td>
                                    <td>{{ $bike->new_issue_date }}</td>
                                    <td>{{ $bike->new_expiry_date }}</td>
                                    <td>@if(isset($bike))
                                        @if($bike->mulkia!=null)
                                            @foreach (json_decode($bike->mulkia) as $attach)
                                                <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                                            @endforeach
                                        @else
                                            <strong></strong>
                                        @endif
                                    @endif</td>
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

<div class="modal fade" id="cash_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('save_cash_requesition') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Cash Requisition</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Amount</label>
                            <input type="number" name="acc_amount" class="form-control form-control-sm" id="" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="acc_date" class="form-control form-control-sm" id="acc_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="bike_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="expiry_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('save_new_expiry') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Upload Renewed Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">New Issue Date</label>
                            <input type="date" name="issue_date" class="form-control form-control-sm" id="issue_date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">New Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control form-control-sm" id="expiry_date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Mulkia Front & Back Page</label>
                            <input type="file" name="mulkia[]" multiple class="form-control-file form-control-sm" id="" required>
                        </div>
                    </div>
                    <input type="hidden" name="ids" id="bikes">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $('.upload').click(function(){
            var id = $(this).attr('id');
            $('#bike_id').val(id);
            $('#cash_modal').modal('show');
        });
        $('.uploads').click(function(){
            var id = $(this).attr('id');
            $('#bikes').val(id);
            $('#expiry_modal').modal('show');
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
        var table = $('#uploaded').DataTable();
        table.columns.adjust().draw();
        var tables = $('#send').DataTable();
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
