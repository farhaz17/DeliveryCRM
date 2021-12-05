@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Issue Department</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Issue Department Details</div>
                    <form method="post" action="{{isset($departments_data)?route('missue_department.update',$departments_data->id):route('missue_department.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($departments_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($departments_data)?$departments_data->id:""}}">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Platform Name</label>
                                <input class="form-control form-control-rounded" id="department_name" name="department_name" value="{{isset($departments_data)?$departments_data->name:""}}" type="text" placeholder="Enter the department name" />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Department Name</th>
                            <th scope="col">Major Department Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($issueDepartments as $issueDepartment)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$issueDepartment->name}}</td>
                                <td>{{$issueDepartment->major_dep->major_department}}</td>
                                <td>

                                    <label class="switch">
                                        <input id="{{$issueDepartment->id}}" class="status"  type="checkbox"  @if($issueDepartment->status==0) checked @else unchecked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('missue_department.edit',$issueDepartment->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                </td>
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

    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {


            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
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
                    url: "{{ route('update_issue_dep') }}",
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
                    url: "{{ route('update_issue_dep') }}",
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
