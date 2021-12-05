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
            <li>Labour Approval Application</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Labour Approval Application Detail</div>
                    <form method="post" action="{{isset($parts_data)?route('labour_approval.update',$parts_data->id):route('labour_approval.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Application Number</label>
                                <input class="form-control form-control-rounded" id="app_number" name="app_number"  type="text" placeholder="Enter application number" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Company Name</label>
                                <input class="form-control form-control-rounded" id="company_name" name="company_name" type="text" placeholder="Enter Company Name" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name"  type="text" placeholder="Enter name" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Nationality</label>
                                <input class="form-control form-control-rounded" id="nationality" name="nationality"  type="text" placeholder="Enter name" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Labour Personal Number</label>
                                <input class="form-control form-control-rounded" id="labour_personal_no" name="labour_personal_no"  type="text" placeholder="Enter name" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Passport Number</label>
                                <input class="form-control form-control-rounded" id="passport_number" name="passport_number" type="text" placeholder="Enter Passport Number" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Offer latter Number</label>
                                <input class="form-control form-control-rounded" id="offer_latter" name="offer_latter"  type="text" placeholder="Enter Offer Latter Number" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Work Permit Number</label>
                                <input class="form-control form-control-rounded" id="work_permit_no" name="work_permit_no" type="text" placeholder="Enter Work Permit Number" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Issue Date</label>
                                <input class="form-control form-control-rounded" id="issue_date" name="issue_date" type="text" placeholder="Enter Issue Date" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Expiry Date</label>
                                <input class="form-control form-control-rounded" id="expiry_date" name="expiry_date" type="text" placeholder="Enter Expiry Date" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Profession Visa</label>
                                <input class="form-control form-control-rounded" id="profession_visa" name="profession_visa" type="text" placeholder="Enter Expiry Date" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Profession Working</label>
                                <input class="form-control form-control-rounded" id="profession_working" name="profession_working" type="text" placeholder="Enter Expiry Date" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Company Visa</label>
                                <input class="form-control form-control-rounded" id="company_visa" name="company_visa" type="text" placeholder="Enter Expiry Date" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Company Working</label>
                                <input class="form-control form-control-rounded" id="company_working" name="company_working" type="text" placeholder="Enter Expiry Date" required />
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
                            <th scope="col">Application Number</th>
                            <th scope="col">Company Name </th>
                            <th scope="col">Name </th>
                            <th scope="col">Nationality</th>
                            <th scope="col">Labour Personal Number</th>
                            <th scope="col">Passport Number </th>
                            <th scope="col">Offer Latter Number  </th>
                            <th scope="col">Work Permit Number </th>
                            <th scope="col">Issue Date  </th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Profession Visa</th>
                            <th scope="col">Profession Working</th>
                            <th scope="col">Company Visa</th>
                            <th scope="col">Company Working</th>


                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>
                                <th scope="col">#</th>
                                <td>{{$res->app_number}}</td>
                                <td>{{$res->company_name}}</td>
                                <td>{{$res->name}}</td>
                                <td>{{$res->nationality}}</td>
                                <td>{{$res->labour_personal_no}}</td>
                                <td>{{$res->passport_number}}</td>
                                <td>{{$res->offer_latter}}</td>
                                <td>{{$res->work_permit_no}}</td>
                                <td>{{$res->issue_date}}</td>
                                <td>{{$res->expiry_date}}</td>
                                <td>{{$res->profession_visa}}</td>
                                <td>{{$res->profession_working}}</td>
                                <td>{{$res->company_visa}}</td>
                                <td>{{$res->company_working}}</td>

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
