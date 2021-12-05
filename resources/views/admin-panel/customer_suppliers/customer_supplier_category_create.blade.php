@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer_supplier_wise_dashboard',['active'=>'master-menu-items']) }}">Customer | Supplier Category Masters</a> / Register</li>
    </ol>
</nav>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="card col-md-6">
            <div class="card-body">
                <form action="{{ route('customer_supplier_categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-title mb-0 row">Customer-Supplier Category Register</div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-1">
                            <label for="name">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Category Name" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-sm float-right">Register Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
        <div class="card col-md-6">
            <div class="card-body">
                <form action="{{ route('customer_supplier_sub_categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-title mb-0 row">Customer-Supplier Sub Category Register</div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label for="customer_supplier_category_id">Category</label>
                            <select class="form-control form-control-sm select2" name="customer_supplier_category_id" id="customer_supplier_category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($customerSupplierCategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->name ?? "" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-1">
                            <label for="name">Sub Category Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Category Name" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-sm float-right">Register Sub Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div class="card-body">
                <div class="card-title col-12">Customer Supplier Category List</div>
                <table class="table table-hover table-striped table-sm text-11 datatable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerSupplierCategory as $key => $item)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $item->name ?? "" }}</td>
                            <td>
                                <a class="text-success mr-2" href="#">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-md-6">
            <div class="card-body">
                <div class="card-title col-12">Customer Supplier Category List</div>
                <table class="table table-hover table-striped table-sm text-11 datatable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerSupplierSubCategory as $key => $item)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $item->name ?? "" }}</td>
                            <td>{{ $item->parent_category->name ?? ""  }}</td>
                            <td>
                                <a class="text-success mr-2" href="#">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        'use strict';

        $('.datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"}
            ],
            "scrollY": false,
        });

        $('#category').select2({
            placeholder: 'Select an option'
        });

    });
</script>
<script>
    $('.select2').select2({
        placeholder: 'Select One'
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