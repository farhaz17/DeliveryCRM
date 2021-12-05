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
            <li>E-Visa</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">E-Visa Detail</div>
                    <form method="post" action="{{isset($parts_data)?route('e_visa.update',$parts_data->id):route('e_visa.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Employment</label>
                                <input class="form-control form-control-rounded" id="employment" name="employment"  type="text" placeholder="Enter Employment" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Entry Permit Number</label>
                                <input class="form-control form-control-rounded" id="" name="entry_permit_number" type="text" placeholder="Enter Entry Permit Number" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Date of Issue</label>
                                <input class="form-control form-control-rounded" id="date_of_issue" name="date_of_issue"  type="date" placeholder="Enter Date of Issue" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Place of Issue</label>
                                <input class="form-control form-control-rounded" id="place_of_issue" name="place_of_issue" type="text" placeholder="Enter Place of Issue" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Valid Until</label>
                                <input class="form-control form-control-rounded" id="valid_until" name="valid_until"  type="text" placeholder="Valid Until" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">UID No</label>
                                <input class="form-control form-control-rounded" id="uid_no" name="uid_no" type="text" placeholder="Enter UID Number" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Full Name</label>
                                <input class="form-control form-control-rounded" id="full_name" name="full_name" type="text" placeholder="Enter Full Name" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Nationality</label>
                                <input class="form-control form-control-rounded" id="nationality" name="nationality" type="text" placeholder="Enter Nationality" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Place of Birth</label>
                                <input class="form-control form-control-rounded" id="place_of_birth" name="place_of_birth" type="text" placeholder="Enter Place of Birth" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Passport Number</label>
                                <input class="form-control form-control-rounded" id="passport_number" name="passport_number" type="text" placeholder="Enter Passport Number" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Profession</label>
                                <input class="form-control form-control-rounded" id="profession" name="profession" type="text" placeholder="Enter Profession" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Sponser Name</label>
                                <input class="form-control form-control-rounded" id="sponser_name" name="sponser_name" type="text" placeholder="Enter Sponser Name" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Entry Date</label>
                                <input class="form-control form-control-rounded" id="entry_date" name="entry_date" type="date" placeholder="Enter Entry Date" required />
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
                            <th scope="col">Employement</th>
                            <th scope="col">Entry Permit number </th>
                            <th scope="col">Date of Issue</th>
                            <th scope="col">Place Of Issue </th>
                            <th scope="col">Valid Until</th>
                            <th scope="col">UID Number  </th>
                            <th scope="col">Full Name </th>
                            <th scope="col">Nationality </th>
                            <th scope="col">Place Of Birth</th>
                            <th scope="col">Passport Number </th>
                            <th scope="col">Profession</th>
                            <th scope="col">Sponser Name</th>
                            <th scope="col">Entry Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>
                                <th scope="col">#</th>
                                <td>{{$res->employment}}</td>
                                <td>{{$res->entry_permit_number}}</td>
                                <td>{{$res->date_of_issue}}</td>
                                <td>{{$res->place_of_issue}}</td>
                                <td>{{$res->valid_until}}</td>
                                <td>{{$res->uid_no}}</td>
                                <td>{{$res->full_name}}</td>
                                <td>{{$res->nationality}}</td>
                                <td>{{$res->place_of_birth}}</td>
                                <td>{{$res->passport_number}}</td>
                                <td>{{$res->profession}}</td>
                                <td>{{$res->sponser_name}}</td>
                                <td>{{$res->entry_date}}</td>

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
