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
            <li>Category</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4" style="background: #dedede">
                <div class="card-body">
                    <div class="card-title mb-3">Categories</div>

                    <form method="post" action="{{url('category_store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Main Category</label>
                                <input class="form-control form-control-rounded" id="main_category" name="main_category"  type="text" placeholder="Enter the main category name"  />

                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card mb-4" style="background: skyblue;">
                <div class="card-body">
                    <div class="card-title mb-3">Sub Categories</div>


                    <form method="post" action="{{url('sub_category_store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif




                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Main Category</label>

                            <select id="category_id" name="category_id" class="form-control" >
                                <option value=""  >Select option</option>
                                @foreach($main_category as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name  }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Sub Category</label>
                            <input class="form-control form-control-rounded" id="sub_category" name="sub_category"  type="text" placeholder="Enter the part number"  />
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary">Add</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4" style="background: #dedede;">
                <div class="card-body">
                    <div class="card-title mb-3">Sub Categories 2</div>


                    <form method="post" action="{{url('sub_category_store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif

                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Sub Category </label>

                            <select id="sub_category_id" name="sub_category_id" class="form-control" >
                                <option value=""  >Select option</option>
                                @foreach($sub_category as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->name  }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Sub Category 2</label>
                            <input class="form-control form-control-rounded" id="sub_category" name="sub_category"  type="text" placeholder="Enter the part number"  />
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary">Add</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>




    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
{{--                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Main Category</a></li>--}}
{{--                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Sub Category</a></li>--}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
{{--                    tree start here--}}
                        <div class="treeview w-20 border">
{{--                            <h6 class="pt-3 pl-3">Folders</h6>--}}
{{--                            <hr>--}}
                            <ul class="mb-1 pl-3 pb-2">
                                @foreach($main_category as $main)

                                <li><i class="fas fa-angle-right rotate"></i>
                                    <span><i class="far fa-envelope-open ic-w mx-1"></i>{{$main->name}}</span>
                                    @if(isset($main->subcategories))
                                    <ul class="nested">
                                         @foreach($main->subcategories as $sub)
                                        <li><i class="far fa-bell ic-w mr-1"></i>{{ $sub->name }}</li>
                                            @if(isset($sub->subcate_two))
                                                <ul class="nested">
                                                @foreach($sub->subcate_two as $sub_two)
                                                            <li><i class="far fa-clock ic-w mr-1"></i>{{ $sub_two->name }}</li>
                                                @endforeach
                                                </ul>
                                             @endif
                                        @endforeach
                                    </ul>
                                      @endif

                                </li>

                                @endforeach

                            </ul>
                        </div>
{{--                        tree end here--}}

                    </div>
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
{{--                        <div class="table-responsive">--}}
{{--                            <table class="display table table-striped table-bordered" style="width: 100%" id="datatable2" >--}}
{{--                                <thead class="thead-dark" style="width: 100%">--}}
{{--                                <tr>--}}

{{--                                    <th scope="col">Sub Categogry</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($sub_category as $sub)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{$sub->name}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                    </div>--}}

                </div>


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

            });

            'use strict';

            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

            });
        });
    </script>

    <script>


        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;

                if(split_ab=="home-basic-tab"){
                    var ab_table = $('#datatable').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var ab_table = $('#datatale2').DataTable();
                    ab_table.destroy();
                    var table = $('#datatale2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
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
