@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">

                        <form method="post" action="{{isset($result)?route('master_steps.update',$result->id):route('master_steps.store')}}">
                            {!! csrf_field() !!}
                            @if(isset($result))
                                {{ method_field('PUT') }}
                            @endif
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <h1 align="center">Master Steps</h1>
                                <div class="input-group mb-3">

                                    <input class="form-control form-control" id="step_name" name="step_name"  value="{{isset($offer_letter)?$offer_letter->st_name:""}}"  type="text" placeholder="Enter Step Name" />

                                    <div class="input-group-append"><button class="btn btn-primary"> Add</button></div>
                                </div>
                            </div>



                        </div>
                        <div class="col-md-4"></div>

                    </form>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            {{--                <input type='button' id='btn' value='Print' onclick='printDiv();'>--}}
                            <div class="table-responsive">
                                <table class="table" id="datatable">
                                    <thead class="thead-dark">
                                    <tr>
                                        {{--                            <th scope="col">#</th>--}}
                                        <th scope="col">Step Name</th>
                                        <th scope="col">Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($steps as $row)

                                        <tr>

                                            <td> {{$row->step_name}}</td>
                                            <td>
                                                <a class="text-success mr-2" href="{{route('master_steps.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$row->id}})" data-target=".bd-example-modal-sm" >
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                </a></td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <form action="" id="deleteForm" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    Are you sure want to delete the data?
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endsection
                @section('js')
                    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
                    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            'use strict';

                            $('#datatable').DataTable( {
                                "aaSorting": [[0, 'desc']],
                                "pageLength": 10,
                                "columnDefs": [
                                    {"targets": [0],"visible": true},
                                    {"targets": [1][2],"width": "40%"}
                                ],
                                "scrollY": false,
                            });


                        });
                        function deleteData(id)
                        {
                            var id = id;
                            var url = '{{ route('master_steps.destroy', ":id") }}';
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
