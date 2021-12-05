@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="">Category</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Category</li>
    </ol>
</nav>


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


<div class="container card mt-4 p-4">
    <h3 class="text-center">Category And Sub Category</h3>
    <ul class="mb-1 pl-3 pb-2">
        @foreach($customerSupplierCategory  as $main)

        <li>
            {{ $main->name }}
            <ul>
                @if ($main->sub_categories)
                @foreach ($main->sub_categories as $sub)
                    <li>{{ $sub->name }}</li>
                @endforeach
            @endif
            </ul>
        </li>

        @endforeach

    </ul>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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
