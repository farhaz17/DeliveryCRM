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
            <li>Insurance</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Insurance Details</div>
                    <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category"> Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name"  type="text" placeholder="Enter Name" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Member ID</label>
                                <input class="form-control form-control-rounded" id="member_id" name="member_id" type="text" placeholder="Enter Member ID" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Staff ID </label>
                                <input class="form-control form-control-rounded" id="staff_id" name="staff_id"  type="number" placeholder="Enter Staff ID" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category"> Date Of Birth</label>
                                <input class="form-control form-control-rounded" id="date_of_birth" name="date_of_birth"  type="number" placeholder="Enter Date of Birth" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Benifits</label>
                                <input class="form-control form-control-rounded" id="benifits" name="benifits" type="text" placeholder="Enter Benifits" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Insurance Date </label>
                                <input class="form-control form-control-rounded" id="insurance_date" name="insurance_date"  type="text" placeholder="Enter Insurance Date " />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Expiry Date</label>
                                <input class="form-control form-control-rounded" id="expiry_date" name="expiry_date"  type="number" placeholder="Enter Expiry Date" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">CO Pay</label>
                                <input class="form-control form-control-rounded" id="co_pay" name="co_pay"  type="number" placeholder="Enter Co Pay" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Insurance Network</label>
                                <input class="form-control form-control-rounded" id="insurance_network" name="insurance_network"  type="text" placeholder="Enter Insurance Network" />
                            </div >
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Insurance Company</label>
                                <input class="form-control form-control-rounded" id="insurance_company" name="insurance_company"  type="text" placeholder="Enter Insurance Company" />
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
                            <th scope="col"> Name</th>
                            <th scope="col">Member ID </th>
                            <th scope="col">Staff ID </th>
                            <th scope="col">Date Of Birth </th>
                            <th scope="col">Benifits </th>
                            <th scope="col">Insurance Date </th>
                            <th scope="col">Expiry Date </th>
                            <th scope="col">CO Pay </th>
                            <th scope="col">Insurance Network </th>
                            <th scope="col">Insurance Company </th>



                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

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
