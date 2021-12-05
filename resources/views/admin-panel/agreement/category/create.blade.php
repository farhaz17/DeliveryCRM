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
            <li><a href="">Category</a></li>
            <li>Add Category</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add Category For Master</div>
                    <form method="post" action="{{ route('save_category')  }}">
                        {!! csrf_field() !!}


                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Sub Category</label>

                                <select class="form-control" name="sub_category" id="sub_category" >
                                    <option value="">select an option</option>
                                    @foreach($main_categories as $cat)
                                        <option value="{{ $cat->id  }}">{{ $cat->name  }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Category</label>

                                <select class="form-control" name="category" id="category" >
                                    <option value="">select an option</option>
                                    @foreach($agreement_trees as $abcd)

                                        <option value="{{ $abcd->id  }}">{{ $abcd->get_parent_name->name  }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

            $('#category').select2({
                placeholder: 'Select an option'
            });

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
