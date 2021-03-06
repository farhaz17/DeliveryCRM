@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Inventory</a></li>
            <li>Manage Parts</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Upload the data <a href="{{ URL::to( '/assets/sample/inv_sample.xlsx')}}" target="_blank">(Download Sample File)</a></div>
                    <form method="post" enctype="multipart/form-data" action="{{ url('/import_parts') }}">
                        {!! csrf_field() !!}
                    <div class="input-group mb-3">
                        {{--<div class="input-group-prepend">--}}
                            {{--<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>--}}
                        {{--</div>--}}

                        <div class="custom-file">
                            <input class="custom-file-input" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" />
                            <label class="custom-file-label" for="select_file">Choose file</label>

                        </div>
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Parts Details</div>
                    <form method="post" action="{{isset($inv_parts_data)?route('inv_parts.update',$inv_parts_data->id):route('inv_parts.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($inv_parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id"  value="{{isset($inv_parts_data)?$inv_parts_data->id:""}}">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Part Number</label>
                                @if(isset($inv_parts_data))
                                <input type="hidden" id="part_id" name="part_id" value="{{isset($inv_parts_data)?$inv_parts_data->parts_id:""}}">
                                @endif
                                <select id="part_id" name="part_id" class="form-control form-control-rounded" {{isset($inv_parts_data)?'disabled':""}}>
                                    <option value="">Select the Part Number</option>
                                    @foreach($parts as $part)
                                        @php
                                            $isSelected=(isset($inv_parts_data)?$inv_parts_data->parts_id:"")==$part->id;
                                        @endphp
                                        <option value="{{$part->id}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--<div class="col-md-12 form-group mb-3">--}}
                                {{--<label for="repair_category">Part Name</label>--}}
                                {{--<input class="form-control form-control-rounded" id="part_add_name" name="part_add_name" value="{{isset($inv_parts_data)?$inv_parts_data->part_add_name:""}}" type="text" placeholder="Enter the part name"  />--}}
                            {{--</div>--}}
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Quantity</label>
                                <input class="form-control form-control-rounded" id="quantity" name="quantity" value="{{isset($inv_parts_data)?$inv_parts_data->quantity:""}}" type="text" placeholder="Enter the quantity" required />
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Amount</label>
                                <input class="form-control form-control-rounded" id="price" name="price" value="{{isset($inv_parts_data)?$inv_parts_data->price:""}}" type="text" placeholder="Enter the amount" required />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($inv_parts_data)) Edit @else Add  @endif Inventory</button>
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
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Part Number</th>
                            <th scope="col">Part Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Quantity Balance</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parts_inv as $part_inv)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$part_inv->part->part_number}}</td>
                                <td>{{$part_inv->part->part_name}}</td>
                                <td>{{$part_inv->quantity}}</td>
                                <td>{{$part_inv->quantity_balance}}</td>
                                <td>{{$part_inv->price}}</td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('inv_parts.edit',$part_inv->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                    <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$part_inv->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>
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
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
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

            $('#part_id').select2({
                placeholder: 'Select an option'
            });



        });




        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
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
