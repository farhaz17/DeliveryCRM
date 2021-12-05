@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li><a href="">Passport Additional Information</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action ="{{ route('passport_addition_show') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-4 form-group mb-4">
                            </div>

                            <div class="col-md-4 form-group mb-4">
                                <h1 align="center">Search Passport Number</h1>


                                <select id="passport_no" name="passport_no" class="form-control" required>
                                    <option value=""  >Select option</option>
                                    @foreach($passport as $pas)
                                        @php

                                            @endphp
                                        <option value="{{ $pas->passport_no }}">{{$pas->passport_no}}</option>
                                    @endforeach

                                </select>
                                <div class="input-group-append"><button class="btn btn-primary"> Add</button></div>
                            </div>

                            <div class="col-md-4 form-group mb-4">
                            </div>
                        </div>
                    </form>


                    @endsection
                    @section('js')
                        <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
                        <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                        <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
                        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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
                            $('#passport_no').select2({
                                placeholder: 'Select an option'
                            });



                        </script>


@endsection
