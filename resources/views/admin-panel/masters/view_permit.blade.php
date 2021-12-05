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
            <li>View Permit</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Working Permit  Details</div>
                    <form method="post" enctype="multipart/form-data" aria-label="{{ __('Upload') }}" action="{{isset($parts_data)?route('work_permit.update',$parts_data->id):route('work_permit.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
{{--                        @foreach($passport as $pass)--}}
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">User Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name"   type="text" placeholder="Enter the  name" readonly />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Message</label>
                                <input class="form-control form-control-rounded" id="nationality" name="nationality"   type="text" placeholder="Enter Nationality" readonly />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Image</label>
                                <input class="form-control form-control-rounded" id="passport_number"   name="passport_number" type="text" placeholder="Enter Visa Company" readonly />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Attach File</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" id="emirates_pic" type="file" name="file_name" aria-ribedby="inputGroupFileAddon01"
                                           required/>
                                    <label class="custom-file-label" for="select_file">Choose Scanned Copy</label>
                                </div>                        </div>




                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($parts_data)) Edit @else   @endif Add</button>
                            </div>
                        </div>
{{--                        @endforeach--}}
                    </form>
                </div>
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

                            <th scope="col">Name</th>
                            <th scope="col">Work Permit Issue Date </th>
                            <th scope="col">Work Permit Expiry Date</th>
                            <th scope="col">Personal  Number </th>
                            <th scope="col">Profession Visa </th>
                            <th scope="col">Working Visa </th>
                            <th scope="col">Nationality </th>
                            <th scope="col">Working Company</th>
                            <th scope="col">Visa Company</th>
                            <th scope="col">Offer Letter Number</th>
                            <th scope="col">Transaction Number</th>
                            <th scope="col">Passport Number</th>
                            <th scope="col">Labour Card Permit Number</th>
                            <th scope="col">Employement</th>
                            <th scope="col">Visa</th>
                            <th scope="col">Work Permit Copy</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>

                                <td>{{$res->name}}</td>
                                <td>{{$res->work_permit_issue_date}}</td>
                                <td>{{$res->work_permit_expiry_date}}</td>
                                <td>{{$res->personal_number}}</td>
                                <td>{{$res->profession_visa}}</td>
                                <td>{{$res->working_visa}}</td>
                                <td>{{$res->nationality}}</td>
                                <td>{{$res->working_company}}</td>
                                <td>{{$res->visa_company}}</td>
                                <td>{{$res->offer_letter_no}}</td>
                                <td>{{$res->transaction_no}}</td>
                                <td>{{$res->passport_number}}</td>
                                <td>{{$res->labour_card_permit_no}}</td>
                                <td>{{$res->employment}}</td>
                                <td>{{$res->visa}}</td>
                                <td>  <a href="{{ url($res->work_permit_copy) }}" target="_blank">
                                        View
                                    </a></td>

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
                "scrollX": true,
            });

        });


        $(document).ready(function() {
            $("#visa_print").hide();

        });
        $('#inside').change(function() {
            if ($("#inside").val() == "inside") {

                $("#visa_print").show();
            }
            if ($("#inside").val() == "outside") {
                $("#visa_print").hide();

            }

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
