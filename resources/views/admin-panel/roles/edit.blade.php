
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
            <li><a href="">Roles</a></li>
            <li>Edit Role</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Edit Role <a class="btn btn-sm btn-danger pull-right" href="{{ route('roles.index') }}">Cancel Edit</a></h2>
            </div>
        </div>
    </div>
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

    <form method="POST" action="{{ route('roles.update',$role->id) }}" >
        @csrf
        @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name"  class="form-control" value="{{ $role->name }}">
            </div>
        </div>
        <strong class="col-xs-12 col-sm-12 col-md-12">Permission:</strong>
        <div class="col-xs-12 col-sm-12 col-md-12">
            {{-- <div class="row"> --}} 
                @foreach($permissions->chunk(10) as $permission)
                @foreach($permission as $value)
                <div class="form-check form-check-inline col-md-3">
                    <input class="form-check-input" type="checkbox" name="permission[]" id="parmission{{ $value->id }}"  value="{{ $value->id }}"  {{ in_array($value->id, $rolePermissions) ? 'checked' : false }}>
                    <label class="form-check-label" for="parmission{{ $value->id }}">{{ $value->name }}</label>
                  </div>
                @endforeach
                @endforeach
            {{-- </div> --}}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
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
