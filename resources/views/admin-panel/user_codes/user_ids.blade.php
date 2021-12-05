@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        button#add_row {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">User IDs</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">User IDs</div>
                    <form method="post"  action="{{route('userids.store')}}">
                        {!! csrf_field() !!}
                        <input class="form-control" id="passport_id" name="passport_id" type="hidden" value="{{$passport_id}}" >
                        <div class="row" id="outside_div"  >
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">ZDS Code 1</label>
                                <input class="form-control" id="zds_id1" name="zds_id1" type="text" placeholder="Enter Plateform Code" required />

                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">ZDS Code 2</label>
                                <input class="form-control" id="zds_id2" name="zds_id2" type="text" placeholder="Enter Plateform Code" required />


                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Labour Card Number</label>
                                <input class="form-control" id="labour_card_no" name="labour_card_no" type="text" placeholder="Enter Plateform Code" required />

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <button class="btn btn-primary btn-form">Save</button>
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
                    <table class="display table table-striped table-bordered" style="width:100%" id="datatable">
                        <thead class="thead-dark" >
                        <tr>

                            <th scope="col">Passport Number</th>

                            <th scope="col">ZDS Code 1</th>
                            <th scope="col">ZDS Code 2</th>
                            <th scope="col">Labour Card Number</th>

{{--                            <th scope="col">Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($ids as $id)
                                <tr>
                                    <td>{{$id->passport_id}}</td>
                                    <td>{{$id->zds_id1}}</td>
                                    <td>{{$id->zds_id2}}</td>
                                    <td>{{$id->labour_card_no}}</td>

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
                    {"targets": [0][2],"width": "80%"}
                ],
                "scrollY": false,
                "scrollX": true,
            });

        });
        $('#passport_number').select2({
            placeholder: 'Select an option'
        });
        $('#plateform').select2({
            placeholder: 'Select an option'
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
