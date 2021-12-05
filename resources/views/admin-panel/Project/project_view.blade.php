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
            <li>Projects</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


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

    <div class="col-md-12 mb-3">
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Project Number</th>
                            <th scope="col">Project Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $row)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$row->project_number}}</td>
                                <td>{{$row->project_name}}</td>
                                <td>{{$row->company_name->name}}</td>
                                <td>

                                    <label class="switch">
                                        <input id="{{$row->id}}" class="status"  type="checkbox"  @if($row->status==0) checked @else unchecked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('project.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
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
    $(".status").change(function(){
        if($(this).prop("checked") == true){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            var status = '0';
            $.ajax({
                url: "{{ route('project_update_status') }}",
                method: 'POST',
                data: {id: id, _token:token,status:status},
                success: function(response) {

                }
            });

        }else{
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            var status = '1';
            $.ajax({
                url: "{{ route('project_update_status') }}",
                method: 'POST',
                data: {id: id, _token:token,status:status},
                success: function(response) {

                }
            });

        }
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
