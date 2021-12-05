@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table#datatable {
            font-size: 13px;
        }
        tr.t-row {
            font-size: 12px;
            white-space: nowrap;
        }
        .text-span{
            color:#ffffff;
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
                        <tr class="t-row">
                            <th scope="col">Passport No</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Cancellation Type</th>
                            <th scope="col">Resignation Type</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Date Untill He Works</th>
                            <th scope="col">When To Start Cancellation </th>
                            <th scope="col">Visa Cancellation Sheet </th>
                            <th scope="col">Added By </th>
{{--                            <th scope="col">Payroll Remakrs</th>--}}
{{--                            <th scope="col">Maintenance Remakrs</th>--}}
{{--                            <th scope="col">Operation Remakrs</th>--}}
{{--                            <th scope="col">PRO Remakrs</th>--}}
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

{{--                        @foreach($result as $res)--}}
                            <tr>
                                <td>{{$result->passport->passport_no}}</td>
                                <td>{{$result->passport->zds_code->zds_code}}</td>
                                <td>{{$result->passport->personal_info->full_name}}</td>
                                @if ($result->cancallation_type =='1')
                                    <td> Resign</td>
                                @else
                                    <td>Termination</td>
                                @endif

                                @if ($result->resignation_type =='1')
                                    <td> Instant</td>
                                @elseif($result->resignation_type =='2')
                                    <td>Wait For Cancallation Until He Continues</td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td>{{$result->remarks}}</td>
                                <td>{{$result->date_until_works}}</td>
                                <td>{{$result->start_cancel_date}}</td>
                                <td>
                                    <a href="{{isset($res->upload_path)? url($res->upload_path):""}}"  target="_blank"><strong style="color: #ffffff">View Cancellation Sheet</strong></a>
                                </td>
                                <td>{{$result->user_name->name}}</td>
{{--                                <td>{{isset($result->payroll_remarks)?$result->payroll_remarks:"N/A" }}</td>--}}
{{--                                <td>{{isset($result->maintenance_remarks)?$result->maintenance_remarks:"N/A" }}</td>--}}
{{--                                <td>{{isset($result->operation_remarks)?$result->operation_remarks:"N/A" }}</td>--}}
{{--                                <td>{{isset($result->pro_status)?$result->pro_status:"N/A" }}</td>--}}
                                <td>
                                    @if($major_dep_id=='5')
                                        @if(isset($res->payroll_status)=='1' && isset($res->maintenance_status)=='1' && isset($res->operation_status)=='1' && isset($res->pro_status) != 1)
                                            <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                            <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">
                                            <button  class="btn btn-success btn-pro" type="button">Clear</button>
                                         @elseif(isset($res->pro_status)==1)
                                            <span class="badge badge-success">Cleared</span>
                                         @else

                                            <table>
                                                <tr>
                                                    @if(isset($res->payroll_status) ==1)
                                                        <th> <span class="text-span"> Payroll </span></th>
                                                        <td><i class="text-14 i-Yes text-success"></i></td>
                                                    @else
                                                        <th><span class="text-span"> Payroll </span></th>
                                                        <td><i class="text-14 i-Close-Window text-danger"></i></td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if(isset($res->maintenance_status)==1)
                                                        <th> <span class="text-span"> Maintenance </span></th>
                                                        <td><i class="text-14 i-Yes text-success"></i></td>
                                                    @else
                                                        <th><span class="text-span"> Maintenance </span></th>
                                                        <td> <i class="text-14 i-Close-Window text-danger"></i></td>

                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if(isset($res->operation_status)==1)
                                                        <th> <span class="text-span"> Opeations </span></th>
                                                        <td><i class="text-14 i-Yes text-success"></i></td>
                                                    @else
                                                        <th><span class="text-span"> Opeations </span></th>
                                                        <td> <i class="text-14 i-Close-Window text-danger"></i></td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if(isset($res->pro_status)==1)
                                                        <th> <span class="text-span"> PRO </span></th>
                                                        <td><i class="text-14 i-Yes text-success"></i></td>
                                                    @else
                                                        <th><span class="text-span"> PRO </span></th>
                                                        <td> <i class="text-14 i-Close-Window text-danger"></i></td>
                                                    @endif
                                                </tr>


                                            </table>

                                        {{--@if($res->payroll_status==1)
                                                    <span> Payroll </span>
                                                    <i class="text-20 i-Yes text-success"></i>
                                                <br>
                                                @else
                                                    <span> Payroll </span>
                                                    <i class="text-20 i-Close-Window text-danger"></i>
                                                <br>
                                                @endif
                                                    @if($res->maintenance_status==1)
                                                    <span>Maintenance</span>
                                                    <i class="text-20 i-Yes text-success"></i>
                                                        <br>
                                                @else
                                                    <span> Maintenance </span>
                                                    <i class="text-20 i-Close-Window text-danger"></i>
                                                        <br>
                                                @endif
                                                    @if($res->operation_status==1)
                                                    <span>Operation</span>
                                                    <i class="text-20 i-Yes text-success"></i>
                                                        <br>
                                                @else
                                                    <span> Operation </span>
                                                    <i class="text-20 i-Close-Window text-danger"></i>
                                                        <br>
                                                @endif--}}

                                   @endif


                                    @else


                                        <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                        <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">

                                        <button  class="btn btn-warning  btn-payroll" type="button"> Clear</button>
                                    @endif


                                </td>


                            </tr>
{{--                        @endforeach--}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{---------------pro visa cancellation modal starts------------}}
    <div class="modal fade bd-example-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <form action="{{url('clear_dep_visa')}}" id="updateForm" method="post">

                    <input type="hidden" name="department_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="clear_id" id="clear_id" value="">
                    <input type="hidden" name="passport_id" id="pass_id" value="">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Visa Cancallation Confirm</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <textarea id="myTextarea" name="remarks" class="form-control" placeholder="Your remarks.." rows="4" cols="50"></textarea>
                        <p><b>Are you  sure to Clear?</b></p>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--    pro--}}
    <div class="modal fade bd-example-modal-sm-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <form action="{{url('clear_pro_visa')}}" id="updateForm" method="post">

                    <input type="hidden" name="department_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="clear_id" id="clear_id" value="">
                    <input type="hidden" name="passport_id" id="pass_id" value="">
                    <br>
                    <select id="cancel_status"  name="cancel_status" class="form-control" required>
                        <option value="" selected disabled  >Select option</option>
                        @foreach($can_status as $can)
                            <option value="{{ $can->id }}">{{ $can->name  }}</option>
                        @endforeach
                    </select>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Visa Cancallation Confirm</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <p>Are you  sure to Clear?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Yes</button>
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
        $('.btn-payroll').on('click', function() {
            var passport_id = $('#passport_id').val();
            var clearance_id = $('#clearance_id').val();
            $('input[name="clear_id"]').val(clearance_id);
            $('input[name="passport_id"]').val(passport_id);
            $(".bd-example-modal-sm-3").modal('show')
        });
        $('.btn-pro').on('click', function() {
            var passport_id = $('#passport_id').val();
            var clearance_id = $('#clearance_id').val();
            $('input[name="clear_id"]').val(clearance_id);
            $('input[name="passport_id"]').val(passport_id);
            $(".bd-example-modal-sm-3").modal('show')
        });



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
        function myFunction() {
            document.getElementById("myTextarea").placeholder = "Where do you live?";
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
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
                "scrollX": false,
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

