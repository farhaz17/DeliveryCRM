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
            <li>Emirates ID</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Emirates ID  Details</div>
                    <form method="post" action="{{isset($parts_data)?route('eid_reg.update',$parts_data->id):route('eid_reg.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">ID Number</label>
                                <input class="form-control form-control-rounded" id="id_number" name="id_number"  type="text" placeholder="Enter ID Number" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name" type="text" placeholder="Enter Name" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Nationality </label>
                                <input class="form-control form-control-rounded" id="nationality" name="nationality"  type="number" placeholder="Enter Nationality" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Date of Birth</label>
                                <input class="form-control form-control-rounded" id="date_of_birth" name="date_of_birth"  type="text" placeholder="Enter Date Of Birth" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Card Number</label>
                                <input class="form-control form-control-rounded" id="card_number" name="card_number" type="text" placeholder="Enter Card Number" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Expiry Date</label>
                                <input class="form-control form-control-rounded" id="expiry_date" name="expiry_date"  type="text" placeholder="Enter Expiry Date " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Receipt No</label>
                                <input class="form-control form-control-rounded" id="receipt_no" name="receipt_no"  type="text" placeholder="EnterReceipt No " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Application No</label>
                                <input class="form-control form-control-rounded" id="app_no" name="app_no"  type="text" placeholder="Enter Application No " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Registered Mobile No</label>
                                <input class="form-control form-control-rounded" id="registered_mob_no" name="registered_mob_no"  type="text" placeholder="Enter Registered Mobile No " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Emirates ID</label>
                                <input class="form-control form-control-rounded" id="emirates_id" name="emirates_id"  type="text" placeholder="Enter Emirates ID< " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Residency No</label>
                                <input class="form-control form-control-rounded" id="residency_no" name="residency_no"  type="text" placeholder="Enter Residency No" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">UID No</label>
                                <input class="form-control form-control-rounded" id="uid_no" name="uid_no"  type="text" placeholder="Enter UID No" />
                            </div>





                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($parts_data)) Edit @else   @endif Add</button>
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
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Number</th>
                            <th scope="col">Name </th>
                            <th scope="col">Nationality </th>
                            <th scope="col">Date of Birth </th>
                            <th scope="col">Card Number </th>
                            <th scope="col">Expiry Date </th>
                            <th scope="col">Receipt No </th>
                            <th scope="col">Application No </th>
                            <th scope="col">Registered Mobile No</th>
                            <th scope="col">Emirates ID</th>
                            <th scope="col">Residency No</th>
                            <th scope="col">UID No</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>
                                <th scope="col">#</th>
                                <td>{{$res->id_number}}</td>
                                <td>{{$res->name}}</td>
                                <td>{{$res->nationality}}</td>
                                <td>{{$res->date_of_birth}}</td>
                                <td>{{$res->card_number}}</td>
                                <td>{{$res->expiry_date}}</td>
                                <td>{{$res->receipt_no}}</td>
                                <td>{{$res->app_no}}</td>
                                <td>{{$res->registered_mob_no}}</td>
                                <td>{{$res->emirates_id}}</td>
                                <td>{{$res->residency_no}}</td>
                                <td>{{$res->uid_no}}</td>

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
    {{--<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-sm">--}}
    {{--<div class="modal-content">--}}
    {{--<form action="" id="deleteForm" method="post">--}}
    {{--<div class="modal-header">--}}
    {{--<h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>--}}
    {{--<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--{{ csrf_field() }}--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--Are you sure want to delete the data?--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
    {{--<button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

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


        {{--function deleteData(id)--}}
        {{--{--}}
        {{--var id = id;--}}
        {{--var url = '{{ route('parts.destroy', ":id") }}';--}}
        {{--url = url.replace(':id', id);--}}
        {{--$("#deleteForm").attr('action', url);--}}
        {{--}--}}

        {{--function deleteSubmit()--}}
        {{--{--}}
        {{--$("#deleteForm").submit();--}}
        {{--}--}}
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
