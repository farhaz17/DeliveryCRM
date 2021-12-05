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
            <li><a href="#">Upload Forms</a></li>
            <li>Upload Category</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{ url('/upload_category') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}
                        <div class="input-group mb-3">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Enter Category Name</label>
                                <input class="form-control form-control-rounded" id=name"  name="category_name"  type="text" placeholder="Enter Category Name">
                            </div>

                            <div class="custom-file">
                                <input class="custom-file-input" id="select_file" type="file" name="file_name" aria-describedby="inputGroupFileAddon01" />
                                <label class="custom-file-label" for="select_file">Choose Sample File</label>

                            </div>
                            <button class="btn btn-primary" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    <div class="row">--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="card mb-4">--}}
    {{--                <div class="card-body">--}}
    {{--                    <div class="card-title mb-3">Add New Parts Details</div>--}}
    {{--                    <form method="post" action="{{isset($inv_parts_data)?route('inv_parts.update',$inv_parts_data->id):route('inv_parts.store')}}">--}}
    {{--                        {!! csrf_field() !!}--}}
    {{--                        @if(isset($inv_parts_data))--}}
    {{--                            {{ method_field('PUT') }}--}}
    {{--                        @endif--}}
    {{--                        <input type="hidden" id="id" name="id"  value="{{isset($inv_parts_data)?$inv_parts_data->id:""}}">--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-md-12 form-group mb-3">--}}
    {{--                                <label for="repair_category">Part Number</label>--}}
    {{--                                @if(isset($inv_parts_data))--}}
    {{--                                    <input type="hidden" id="part_id" name="part_id" value="{{isset($inv_parts_data)?$inv_parts_data->parts_id:""}}">--}}
    {{--                                @endif--}}
    {{--                                <select id="part_id" name="part_id" class="form-control form-control-rounded" {{isset($inv_parts_data)?'disabled':""}}>--}}
    {{--                                    <option value="">Select the Part Number</option>--}}

    {{--                                </select>--}}
    {{--                            </div>--}}
    {{--                            --}}{{--<div class="col-md-12 form-group mb-3">--}}
    {{--                            --}}{{--<label for="repair_category">Part Name</label>--}}
    {{--                            --}}{{--<input class="form-control form-control-rounded" id="part_add_name" name="part_add_name" value="{{isset($inv_parts_data)?$inv_parts_data->part_add_name:""}}" type="text" placeholder="Enter the part name"  />--}}
    {{--                            --}}{{--</div>--}}
    {{--                            <div class="col-md-12 form-group mb-3">--}}
    {{--                                <label for="repair_category">Quantity</label>--}}
    {{--                                <input class="form-control form-control-rounded" id="quantity" name="quantity" value="{{isset($inv_parts_data)?$inv_parts_data->quantity:""}}" type="text" placeholder="Enter the quantity" required />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-12 form-group mb-3">--}}
    {{--                                <label for="repair_category">Amount</label>--}}
    {{--                                <input class="form-control form-control-rounded" id="price" name="price" value="{{isset($inv_parts_data)?$inv_parts_data->price:""}}" type="text" placeholder="Enter the amount" required />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-12">--}}
    {{--                                <button class="btn btn-primary">@if(isset($inv_parts_data)) Edit @else Add  @endif Inventory</button>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}



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
