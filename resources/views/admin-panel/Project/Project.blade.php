@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submit-btn {
    margin-top: 24px;
        }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Project</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Project</div>
                    <form method="post" action="{{isset($projects_data)?route('project.update',$projects_data->id):route('project.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($projects_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($projects_data)?$projects_data->id:""}}">

                        <div class="row">
                        <div class="col-md-4  mb-3">
                                        <label for="repair_category">Company</label>
                                        <select id="nation_id" name="company" class="form-control" required>
                                            <option value=""  >Select option</option>
                                            @foreach($company as $com)
                                            @php
                                            $isSelected=(isset($projects_data)?$projects_data->company:"")==$com->id;
                                        @endphp
                                                <option value="{{ $com->id }}" {{ $isSelected ? 'selected': '' }}>{{ $com->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            <div class="col-md-4 form-group mb-1">
                                <label for="repair_category">Project Name</label>
                                <input class="form-control" id="part_number"
                                 name="project_name" value="{{isset($projects_data)?$projects_data->project_name:""}}" type="text"
                                 placeholder="Enter the Project Name" required />
                            </div></div>
                            <div class="row">
                            <div class="col-md-4 form-group mb-1">
                                 <button class="btn btn-primary submit-btn">@if(isset($projects_data)) Edit @else Create  @endif Project</button>
                            </div></div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="loader-bubble loader-bubble-primary m-5"></div>
                <div class="loader-bubble loader-bubble-danger m-5" ></div>
                <div class="loader-bubble loader-bubble-success m-5" ></div>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
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
