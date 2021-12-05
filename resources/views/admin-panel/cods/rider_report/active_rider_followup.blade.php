@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Rider</a></li>
        <li>Rider FollowUp</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="card-title mb-3">Follow Up</div>
            <form action="{{ isset($edit)?route('rider_followup_update',$edit->id):route('save_followup_rider') }}" method="POST">
                @csrf
                @if(isset($edit))
                    {{ method_field('PUT') }}
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{isset($edit)?$edit->name:""}}" placeholder="Add Followup" required>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary submit-btn">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered text-11" id="follow" style="width:100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($followup as $follow)
                            <tr>
                                <td></td>
                                <td>{{ $follow->name }}</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="status" id="{{ $follow->id }}" @if($follow->status==0) checked @else unchecked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td><a class="text-primary mr-2 follow_up" href="{{ route('rider_followup_edit',$follow->id) }}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(".status").change(function(){
                var id = $(this).attr('id');
                var token = $("input[name='_token']").val();

            if($(this).prop("checked") == true){
                var status = '0';
            }else{
                var status = '1';
            }
            $.ajax({
                url:"{{ route('change_status_follow') }}",
                method: 'POST',
                data:{id: id, _token:token, status: status},
                success:function(reponse){

                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#follow').DataTable( {
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
