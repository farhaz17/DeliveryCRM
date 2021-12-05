@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        button.btn.btn-primary.save-btn {
            margin-top: 24px;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manage Role</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">    
        <div class="col-md-12">
        </div>
        <div class="col-md-12">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Role</div>
                    <form method="POST" action="{{ route('roles.store') }}" >
                        @csrf
                        <input type="hidden" id="id" name="id"  value="">
                        <div class="row">
                            <div class="col-md-11 form-group mb-3">
                                <input class="form-control form-control-sm" id="name" name="name" value="" type="text" placeholder="Enter the name" required />
                            </div>
                            <div class="col-md-1 form-group mb-3">
                                <a class="btn btn-danger btn-block btn-sm pull-right" href="{{ route('roles.index') }}">Cancel</a>
                            </div>
                            @foreach($permissions->chunk(10) as $permission)
                            <div class="col-md-3 form-group mb-3">
                                @foreach($permission as $value)
                                    <label class="checkbox checkbox-outline-primary">
                                        <input type="checkbox" name="permission[]"  value="{{ $value->id }}"><span>{{ $value->name }}</span><span class="checkmark"></span>
                                    </label>
                                @endforeach
                            </div>
                            @endforeach
                            <div class="col-md-12">
                                <button class="btn btn-primary save-btn">Register Role</button>
                            </div>
                        </div>
                    </form>
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

                    $('#datatable').DataTable( {
                        "aaSorting": [[0, 'desc']],
                        "pageLength": 10,
                        "columnDefs": [
                            {"targets": [0],"visible": false},
                            {"targets": [1][2],"width": "30%"}
                        ],
                        "scrollY": false,
                    });

                    $('#role').select2({
                        placeholder: 'Select an option'
                    });
                    $('#platform').select2({
                        placeholder: 'Select an option'
                    });
                    $('#department').select2({
                        placeholder: 'Select an option'
                    });
                    $('#major_department_ids').select2({
                        placeholder: 'Select an option'
                    });



                });

                function deleteData(id)
                {
                    var id = id;
                    var url = '';
                    url = url.replace(':id', id);
                    $("#deleteForm").attr('action', url);
                }

                function deleteSubmit()
                {
                    $("#deleteForm").submit();
                }
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
