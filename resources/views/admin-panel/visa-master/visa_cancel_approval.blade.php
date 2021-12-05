@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table#datatable {
            font-size: 13px;
        }
        tr#t-row {
            font-size: 13px;
            /* white-space: nowrap; */
        }
        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Cancelation</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-dark" id="datatable">
                        <thead>
                        <tr id="t-row">
                            <th scope="col">Passport No</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Cancellation Type</th>
                            <th scope="col">Resignation Type</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Date Untill He Works</th>
                            <th scope="col">When To Start Cancellation </th>
                            <th scope="col">Added By</th>
                            <th scope="col">Approval Status</th>

                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $res)
                            <tr>
                                <td>{{$res->passport->passport_no}}</td>
                                <td>{{$res->passport->zds_code->zds_code}}</td>
                                <td>{{$res->passport->personal_info->full_name}}</td>
                                        @if ($res->cancallation_type =='1')
                                <td> Resign</td>
                                @else
                                <td>Termination</td>
                                @endif
                                @if ($res->resignation_type =='1')
                                <td> Instant</td>
                                @elseif($res->resignation_type =='2')
                                <td>Wait For Cancallation Until He Continues</td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td>{{$res->remarks}}</td>
                                <td>{{$res->date_until_works}}</td>
                                <td>{{$res->start_cancel_date}}</td>
                                <td>{{$res->user_name->name}}</td>

                                @if (isset($res->approval_status) =='1')
                                    <td> <span class="badge badge-success">Approved</span></td>
                                @else
                                    <td> <span class="badge badge-warning">Pending</span></td>
                                @endif
                                @if (isset($res->approval_status) =='1')
                                    <td>
                                        <button disabled class="btn btn-success btn-sm m-1 font-weight-bold" type="button">Appoved</button>
                                    </td>
                                @else
                                    <td>



                                        <form method="post" enctype="multipart/form-data" action="{{ url('/visa_cancel_sheet') }}"  aria-label="{{ __('Upload') }}" >
                                            {!! csrf_field() !!}

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="hidden" value="{{$res->id}}" name="id">
                                                    <div class="custom-file">
                                                        <input class="custom-file-input" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required/>
                                                        <label class="custom-file-label" for="select_file">Choose file</label>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-md-4 form-group mb-3">
                                                            <button class="btn btn-primary btn-upload" type="submit">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>




{{--                                        </div>--}}


{{--                                        <button class="btn btn-warning btn-sm m-1 font-weight-bold" data-toggle="modal" data-target=".bd-example-modal-sm-3" onclick="approve({{$res->id}})" type="button">Approve</button>--}}
                                        </form>
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Visa Cancallation Confirm</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}

                        <p>Are you  sure to approve this visa cancellation?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="start_Submit()">Yes</button>
                    </div>
                </form>
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



        function approve(id)
        {
            var id = id;
            var url = '{{ route('cancal_approve_update', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function start_Submit()
        {
            $("#updateForm").submit();

        }
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
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

