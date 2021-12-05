@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Agreement</a></li>
            <li>Discount Name</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="modal fade bd-example-modal-md edit_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="" id="edit_form" method="POST">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Edit Discount Name</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="edit_name" name="edit_name" value="{{isset($designation_data)?$designation_data->name:""}}" type="text" placeholder="Enter the Discount Name" />

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Discount Names</div>
                    <form method="post" action="{{ route('discount_name.store') }}">
                     @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name" value="{{isset($designation_data)?$designation_data->name:""}}" type="text" placeholder="Enter the Discount Name" />

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
                            <th scope="col">Discount Name</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($discount_names as $name)
                                <tr>
                                    <td>#</td>
                                    <td>{{ $name->names }}</td>
                                    <td>
                                        <a class="text-success mr-2 edit_btn" href="javascript:void(0)" id="{{ $name->id }}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
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
                ],
                "scrollY": false,
            });

        });
    </script>

    <script>
        $(".edit_btn").click(function(){

            var ids = $(this).attr('id');
            var url =  '{{ route('discount_name') }}';


            var now_url = url+"/"+ids+"/edit";

            var update_url  = url+"/"+ids+"";

                $("#edit_form").attr('action',update_url);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: now_url,
                method: 'GET',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var arr = response;
                    if(arr !== null){
                        $("#edit_name").val(arr['name']);
                    }
                }
            });

           $(".edit_modal").modal('show');

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
