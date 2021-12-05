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


<div class="row">
    <div class="card col-md-6 mb-2">
        <form action="{{ route('vehicle_category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    <div class="card-title mb-3 col-12">Vehicle Category</div>
                    <div class="row">
                        <div class="col-md-4 form-group mb-1">
                            <label for="name">Category Name</label>
                            <input class="form-control form-control-sm" id="name" type="" placeholder="" name="name">
                        </div>
                        <div class="col-md-4 form-group mb-1">
                            <label for="name">&nbsp;</label><br>
                            <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <div class="col-md-6">
        <form action="{{ route('vehicle_sub_category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card col-md-12 mb-2">
                <div class="card-body">
                    <div class="card-title mb-3 col-12">Vehicle Category</div>
                    <div class="row">
                        <div class="col-md-4 form-group mb-1">
                            <label for="vehicle_category_id">Parent category Name</label>
                            <select class="form-control form-control-sm" name="vehicle_category_id" id="vehicle_category_id">
                                @foreach ($vehicle_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-1">
                            <label for="name">Sub Category Name</label>
                            <input class="form-control form-control-sm" id="name" type="text" placeholder="" name="name">
                        </div>
                        <div class="col-md-4 form-group mb-1">
                            <label for="name">&nbsp;</label><br>
                            <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container card mt-4 p-4">
    <h3 class="text-center">Category And Sub Category</h3>
    <ul class="mb-1 pl-3 pb-2">
        @foreach($vehicle_categories as $main)

        <li>
            {{ $main->name }}
            <ul>
                @if ($main->sub_category)
                    @foreach ($main->sub_category as $sub)
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
