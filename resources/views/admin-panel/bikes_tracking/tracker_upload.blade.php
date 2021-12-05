@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Tracker</a></li>
        <li>Upload Inventory</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-2 mb-3"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="card-title">Upload Tracking Inventory</div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width:100%;">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">LPO Number</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Tracker</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($lpos as $lpo)
                            <tr>
                                <td></td>
                                <td>{{ $lpo->lpo_no }}</td>
                                <td>{{ $lpo->quantity }}</td>
                                <td>{{ $lpo->count ?? 0 }}</td>
                                <td><a class="text-secondary mr-2 upload" id="{{ $lpo->id }}" href="javascript:void(0)"><i class="fa fa-upload" style="font-size:18px;cursor:pointer;"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('save_upload_tracker') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Upload Tracker</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="upload">Browse File</label>
                            <input type="file" name="select_file" id="select_files" class="form-control-file form-control-sm" >
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ asset('assets/sample/tracker.xlsx') }}" target="_blank">( Download Sample File )</a>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="lpo_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Upload</button>
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
            $('#lpo_id').val(id);
            $('#upload_modal').modal('show');
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
                "scrollY": false,
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
