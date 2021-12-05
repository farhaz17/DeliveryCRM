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
            <li> COD</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!------------------tabs--------->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Cash Deposite</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">ATM Deposite</a></li>
                    <li class="nav-item"><a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">Account Transfer</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3">Cash Deposite</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Date</label>
                                                    <input class="form-control form-control-rounded" id="date" name="date"  type="text" placeholder="Enter Daate" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Time </label>
                                                    <input class="form-control form-control-rounded" id="time" name="time" type="time" placeholder="Enter Time" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Number</label>
                                                    <input class="form-control form-control-rounded" id="state" name="state"  type="number" placeholder="Enter Number" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Amount</label>
                                                    <input class="form-control form-control-rounded" id="amount" name="amount"  type="number" placeholder="Enter Amount" />
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
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Number</th>
                                                <th scope="col">Amount </th>





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
                    </div>
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3"> ATM Deposite</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Branch Name</label>
                                                    <input class="form-control form-control-rounded" id="branch_name" name="branch_name"  type="text" placeholder="Enter Branch Name" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Machince Code </label>
                                                    <input class="form-control form-control-rounded" id="machine_cod" name="machnice_cod" type="text" placeholder="Enter Machine Code" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Date</label>
                                                    <input class="form-control form-control-rounded" id="date" name="date"  type="number" placeholder="Date" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Time</label>
                                                    <input class="form-control form-control-rounded" id="time" name="time"  type="number" placeholder="Enter Time" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Number</label>
                                                    <input class="form-control form-control-rounded" id="number" name="number" type="text" placeholder="Enter Number" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Amount</label>
                                                    <input class="form-control form-control-rounded" id="amount" name="amount" type="text" placeholder="Enter Amount" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">COD Amount</label>
                                                    <select id="cod_amount" name="cod_amount" class="form-control form-control-rounded">



                                                        <option value="">Daily </option>
                                                        <option value="">Weakly </option>
                                                        <option value="">Monthly</option>

                                                    </select>                                                           </div>





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
                                                <th scope="col"> Branch Name</th>
                                                <th scope="col"> Machine COD </th>
                                                <th scope="col">Date </th>
                                                <th scope="col">Time </th>
                                                <th scope="col">No</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">COD</th>



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
                    </div>
                    <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3">Account Transfer</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Transfer Number</label>
                                                    <input class="form-control form-control-rounded" id="transfer_number" name="transfer_number"  type="text" placeholder="Enter Transfer" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Sender Name </label>
                                                    <input class="form-control form-control-rounded" id="sender_name" name="sender_name" type="text" placeholder="Enter Sender Name" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Sender Account or IBAN</label>
                                                    <input class="form-control form-control-rounded" id="sender_account" name="sender_account"  type="number" placeholder="Enter Sender Acount OR IBAN" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Amount </label>
                                                    <input class="form-control form-control-rounded" id="amount" name="amount"  type="number" placeholder="Enter Amount" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Benificiary Account or IBAN</label>
                                                    <input class="form-control form-control-rounded" id="benificary_account" name="benificary_account" type="text" placeholder="Enter Benificiary Account or IBAN" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Value Date</label>
                                                    <input class="form-control form-control-rounded" id="value_date" name="value_date" type="text" placeholder="Enter Value Date Date" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Reference Number</label>
                                                    <input class="form-control form-control-rounded" id="reference_number" name="reference_number" type="text" placeholder="Enter Reference Number" required />
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
                                                <th scope="col"> Transfer Number</th>
                                                <th scope="col"> Sender Name </th>
                                                <th scope="col">Sender Account or IBAN </th>
                                                <th scope="col">Amount </th>
                                                <th scope="col">Benificiary Account or IBAN</th>
                                                <th scope="col">Value Date</th>
                                                <th scope="col">Refernce Number</th>




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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------tabs----->
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
