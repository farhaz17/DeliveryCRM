@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Career</a></li>
        <li>Selected Follow Up</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-body">

            <div class="card-title mb-3">Follow Up</div>
            <form method="POST" action="{{isset($select)?route('selected_follow_up_update',$select->id):route('selected_follow_up_save')}}">
                @csrf
                @if(isset($select))
                    {{ method_field('PUT') }}
                @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="follow">Name</label>
                        <input class="form-control" name="name" value="{{isset($select)?$select->name:""}}" type="text" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary submit-btn">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="display table table-sm table-striped text-10 table-bordered" id="followup">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($names as $name)
                        <tr>
                            <td>#</td>
                            <td>{{ $name->name }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="" data-type="3" class="status" id="{{ $name->id }}" @if($name->status == "0") checked @else unchecked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td><a class="text-primary mr-2 follow_up" href="{{route('selected_follow_up_edit',$name->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

    <script>
        $('.status').change(function(){
            var id = $(this).attr('id');
            var type = $(this).data('type');
            var token = $("input[name='_token']").val();
            if($(this).prop("checked") == true){
                var status = "0";
                $.ajax({
                    url: "{{ route('active_followup') }}",
                    method: "POST",
                    data:{id:id, status:status, type:type, _token:token},
                    success(response){

                    }
                });
            }
            else{
                var status = "1";
                $.ajax({
                    url: "{{ route('active_followup') }}",
                    method: "POST",
                    data: {id:id, type:type, status:status, _token:token},
                    success(response){

                    }
                });
            }
        })
    </script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#followup').DataTable( {
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
