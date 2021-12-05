@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="post" action="{{isset($parts_data)?route('country.update',$parts_data->id):route('country.store')}}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                             <h1 align="center">Select Country</h1>
                                            <div class="input-group mb-3">

                                                <select id="nation_id" name="nation_id" class="form-control form-control">
                                                    <option>Select Nationality</option>

                                                    @foreach($nation as $nat)
                                                        <option value="{{$nat->id}}">{{$nat->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append"><button class="btn btn-primary"> Add</button></div>
                                            </div>
                               </div>
                            <div class="col-md-4">
                                <div class="card text-left">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Pending Passport Number</h4>
                                        @if(!empty($pending_passports))
                                        <ul class="list-group">
                                            @foreach($pending_passports as $passport)
                                            <li class="list-group-item">{{ $passport['passport_number'] }}</li>
                                            @endforeach
                                        </ul>
                                        @else
                                            <p>Record Not found</p>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>


                    </form>
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
                                                {"targets": [0],"visible": false},
                                                {"targets": [1][2],"width": "40%"}
                                            ],
                                            "scrollY": false,
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
