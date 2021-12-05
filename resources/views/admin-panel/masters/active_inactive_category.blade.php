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
            <li><a href="">Masters</a></li>
            <li>Active Inactive Category</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 bg-gray-400 border">
                <div class="card-body">
                    <div class="card-title mb-3">Register Main Category</div>
                    <form method="post" action="{{ url('active_main_category_store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="">Main Category</label>
                                <input class="form-control form-control-sm" id="main_category" name="name"  type="text" placeholder="Enter the main category name"  />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-dark float-right">Save Main Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4 bg-gray-300">
                <div class="card-body">
                    <div class="card-title mb-3">Register Sub Category</div>
                    <form method="post" action="{{url('active_sub_category_store')}}" class="row">
                        @csrf
                        <div class="col-md-6 form-group">
                            <label for="category_id">Main Category</label>
                            <select id="category_id" name="category_id" class="form-control form-control-sm select2" required>
                                <option value="">Select option</option>
                                @foreach($main_category as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sub_category">Sub Category</label>
                            <input class="form-control form-control-sm" id="sub_category" name="sub_category"  type="text" placeholder="Enter the part number" required/>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-info float-right">Save Sub Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($main_category as $main)
        <div class="col-md-3">
            <ul class="list-group mb-1 p-1">
                <li class="list-group-item bg-gray-400" style="height: 250px">
                    <span><i class="i-Diamond ic-w mx-1"></i>{{$main->name}}</span>
                    @if(isset($main->active_inactive_subcategories))
                    <ul class="nested list-group mb-1 p-1" style="max-height: 200px; overflow:auto;">
                        @foreach($main->active_inactive_subcategories as $sub)
                        <li class="list-group-item p-1 bg-gray-300"><i class="i-Coin ic-w mr-1"></i>{{ $sub->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            </ul>
        </div>
        @endforeach
    </div>
    {{ $main_category->links('vendor.pagination.bootstrap-4-custom') }}
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder:"Select main category"
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
