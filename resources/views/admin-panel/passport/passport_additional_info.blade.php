@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        form {
            margin: auto;
            width: 70%;
            padding: 10px;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Passport Additional Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


{{--    <div class="row">--}}

        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Passport Additional Details</h4>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">National Details</a></li>
                        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">International Details</a></li>
                        <li class="nav-item"><a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">Personal Details</a></li>
                    </ul>

                    <form method="post" enctype="multipart/form-data" action="{{route('passport_add.store')}}">

                        {!! csrf_field() !!}


                    <div class="tab-content" id="myTabContent">

                            @foreach($passport as $pass)
                                <input  id="passport_id" name="passport_id" value="{{$pass->id}}" type="hidden" />
                                <input  id="full_name" name="full_name" value="{{$pass->sur_name}} {{$pass->given_names}} {{$pass->father_name}} " type="hidden" />

                            @endforeach

                        <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                            <div class="col-md-8  mb-3">
                                <label for="repair_category">Relation Name</label>
                                <input class="form-control form-control" id="nat_name" name="nat_name"  type="text" placeholder="Enter Name"  />
                            </div>


                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">Relation</label>
                                <input class="form-control form-control" id="nat_relation" name="nat_relation"  type="text" placeholder="Enter Relation" />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">National Address</label>
                                <input class="form-control form-control" id="nat_address" name="nat_address" type="text" placeholder="Enter National Address"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">National Phone</label>
                                <input class="form-control form-control" id="nat_phone" name="nat_phone" type="text" placeholder="Enter National Phone"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">National Whatsapp Number</label>
                                <input class="form-control form-control" id="nat_whatsapp_no" name="nat_whatsapp_no" type="number" placeholder="Enter National Whatsapp Number"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">National Email Address</label>
                                <input class="form-control form-control" id="nat_email" name="nat_email" type="email" placeholder="Enter National Email Address"  />
                            </div>
                        </div>


                        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">International Name</label>
                                <input class="form-control form-control" id="inter_name" name="inter_name"  type="text" placeholder="Enter International Name"  />
                            </div>

                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category"> International Relation</label>
                                <input class="form-control form-control" id="inter_relation" name="inter_relation"  type="text" placeholder="Enter Passport Number" />
                            </div>


                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">International Address</label>
                                <input class="form-control form-control" id="inter_address" name="inter_address" type="text" placeholder="Enter International Relation"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">International Phone</label>
                                <input class="form-control form-control" id="inter_phone" name="inter_phone" type="number" placeholder="Enter Given Name"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">International Whatsapp Number</label>
                                <input class="form-control form-control" id="inter_whatsapp_no" name="inter_whatsapp_no" type="number" placeholder="Enter International Phone"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">International Email Address</label>
                                <input class="form-control form-control" id="inter_email" name="inter_email" type="email" placeholder="Enter International Email Address"  />
                            </div>
                        </div>

                        <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">

                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">Personal Mobile</label>
                                <input class="form-control form-control" id="personal_mob" name="personal_mob" type="number" placeholder="Enter Personal Mobile"  />
                            </div>

                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category">Personal Email</label>
                                <input class="form-control form-control" id="personal_email" name="personal_email" type="email" placeholder="Enter Personal Email"  />
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label for="repair_category" id="copy_label">Photo</label>
                                <div class="custom-file">
                                <input class="form-control form-control custom-file-input" id="file_name2" type="file" name="file_name2"/>
                                <label class="custom-file-label" for="select_file">Choose Image</label>
                                </div>
                            </div>

                        </div>


                       </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>

                </div>

            </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>

                            <th scope="col">National Relation Name</th>
                            <th scope="col">National Relation </th>
                            <th scope="col">National Address</th>
                            <th scope="col">National Phone </th>
                            <th scope="col">National WhatsApp No</th>
                            <th scope="col">Nantional Email Address </th>
                            <th scope="col">International Relation Name</th>
                            <th scope="col">International Relation </th>
                            <th scope="col">International Address</th>
                            <th scope="col">International Phone </th>
                            <th scope="col">International WhatsApp No</th>
                            <th scope="col">Internationa Email Address </th>
                            <th scope="col">Personal Mobile Phone </th>
                            <th scope="col">Personal Email Address </th>
                            <th scope="col">Photo </th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>

                                <td>{{$res->nat_name}}</td>
                                <td>{{$res->nat_relation}}</td>
                                <td>{{$res->nat_address}}</td>
                                <td>{{$res->nat_phone}}</td>
                                <td>{{$res->nat_whatsapp_no}}</td>
                                <td>{{$res->nat_email}}</td>
                                <td>{{$res->inter_name}}</td>
                                <td>{{$res->inter_relation}}</td>
                                <td>{{$res->inter_address}}</td>
                                <td>{{$res->inter_phone}}</td>
                                <td>{{$res->inter_whatsapp_no}}</td>
                                <td>{{$res->inter_email}}</td>
                                <td>{{$res->personal_mob}}</td>
                                <td>{{$res->personal_email}}</td>
                                <td>{{$res->personal_image}}</td>
{{--                                <td>  <a href="{{ url($res->work_permit_copy) }}" target="_blank">--}}
{{--                                        View--}}
{{--                                    </a></td>--}}

                                <td>
                                    <a class="text-success mr-2" href="{{route('work_permit.edit',$res->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
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

