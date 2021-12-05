@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_processing {
            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
    </style>




    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manage Rider</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Rider</div>
                    <form method="post" action="{{isset($riderProfileData)?route('rider_profile.update',$riderProfileData->id):route('rider_profile.store')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if(isset($riderProfileData))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id"  value="{{isset($riderProfileData)?$riderProfileData->id:""}}">
                        <div class="row">
                            @if(isset($riderProfileData->user->name))
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" readonly id="name" name="name" value="{{isset($riderProfileData)?$riderProfileData->user->name:""}}" type="text" placeholder="Enter the name" required />
                            </div>

{{--                                <div class="col-md-6 form-group mb-3">--}}
{{--                                    <label for="repair_category">ZDS Code</label>--}}
{{--                                    <input class="form-control form-control-rounded" id="zds_code" name="zds_code" value="{{isset($riderProfileData)?$riderProfileData->zds_code:""}}" type="text" placeholder="Enter the zds code" required />--}}
{{--                                </div>--}}

                           @endif

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Email</label>
                                    <input class="form-control form-control-rounded" id="email" name="email" value="{{isset($riderProfileData)?$riderProfileData->user->email:""}}" type="text" placeholder="Enter the email" required />
                                </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Passport</label>
                                <input class="form-control form-control-rounded" id="passport" name="passport" value="{{ isset($riderProfileData->passport->passport_no)? $riderProfileData->passport->passport_no:"" }}"  <?php echo isset($riderProfileData->passport->passport_no) ? "readonly":""; ?> type="text" placeholder="Enter the passport no" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Contact No</label>
                                <input class="form-control form-control-rounded" id="contact_no" name="contact_no" value="{{isset($riderProfileData)?$riderProfileData->contact_no:""}}" type="text" placeholder="Enter the contact no"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Whatsapp No</label>
                                <input class="form-control form-control-rounded" id="whatsapp" name="whatsapp" value="{{isset($riderProfileData)?$riderProfileData->whatsapp:""}}" type="text" placeholder="Enter the whatsapp no"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Address</label>
                                <input class="form-control form-control-rounded" id="address" name="address" value="{{isset($riderProfileData)?$riderProfileData->address:""}}" type="text" placeholder="Enter the address"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Password</label>
                                <input class="form-control form-control-rounded" id="password" name="password" type="password" placeholder="Enter the password"  />
                            </div>
                            {{-- @php
                                $imageAvailable=isset($riderProfileData)?($riderProfileData->image?true:false):false;
                            @endphp

                            <div class="col-md-6 form-group mb-3 passport-div" @if($imageAvailable) style="display: none" @endif>
                                <label for="repair_category">Upload Profile Picture</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" id="image" type="file" name="image" aria-describedby="inputGroupFileAddon01" />
                                    <label class="custom-file-label" for="select_file">Choose Profile Picture</label>
                                </div>
                            </div>

                            @if($imageAvailable)
                                <div id="passport-change" class="col-md-6 form-group mb-3">
                                    <a href="{{url($riderProfileData->image)}}" target="_blank">view <i
                                                class="fa fa-eye" aria-hidden="true"></i></a>
                                    <button class="btn btn-sm btn-primary pull-right" type="button"
                                            onclick="resetPassportFile()"> Change
                                    </button>
                                </div>
                            @endif --}}

                                @if(isset($riderProfileData->user->email))
                                  @else
                            {{-- <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Password</label>
                                <input class="form-control form-control-rounded" id="password" name="password" value="" type="password" placeholder="Enter the password" required />
                            </div> --}}
                                @endif

                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($riderProfileData)) Edit @else Add  @endif User</button>
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
                    <table class="table" id="datatable-profile">
                        <thead class="thead-dark">
                        <tr>

                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Passport</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Whatsapp</th>
                            <th scope="col">Address</th>
                            {{-- <th scope="col">Profile Pic</th> --}}
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                                @foreach($profile_data as $row)
                                <tr>
                                    <td> {{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                    <td> {{isset($row->user->email)?$row->user->email:"N/A"}}</td>
                                    <td> {{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                    <td> {{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                    <td> {{isset($row->contact_no)?$row->contact_no:"N/A"}}</td>
                                    <td> {{isset($row->whatsapp)?$row->whatsapp:"N/A"}}</td>
                                    <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                                    <td>
                                        <a class="text-success mr-2" href="{{route('rider_profile.edit',$row->id)}}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>

                                    </td>


                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';



            $('#datatable-profile').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });
        });



    </script>

        {{-- <script type="text/javascript">
            $(function () {

                var table = $('#datatable').DataTable({
                    "aaSorting": [[0, 'desc']],
                    "language": {
                        processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                    },


                    "pageLength": 10,
                    "columnDefs": [
                        // {"targets": [0],"visible": false},
                        {"targets": [0][1],"width": "30%"}
                    ],
                    "scrollY": false,
                    "processing": true,
                    "serverSide": true,

                    ajax: "{{ route('rider_profile') }}",
                    "deferRender": true,
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'zds_code', name: 'zds_code'},
                        {data: 'passport', name: 'passport'},
                        {data: 'contact_no', name: 'Contact No'},
                        {data: 'whatsapp', name: 'whatsapp'},
                        {data: 'address', name: 'address'},
                            {data: 'image', name: 'image', orderable: false, searchable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });

            });
    </script> --}}


    <script>
        $(document).ready(function () {
            // 'use strict';

            // $('#datatable').DataTable( {
            //     "aaSorting": [[0, 'desc']],
            //     "pageLength": 10,
            //     "columnDefs": [
            //         {"targets": [0],"visible": false},
            //         {"targets": [1][2],"width": "30%"}
            //     ],
            //     "scrollY": false,
            // });

            $('#role').select2({
                placeholder: 'Select an option'
            });

        });

        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('rider_profile.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }

        function resetPassportFile() {
            $('#passport-change').hide();
            $('.passport-div').show();
        }
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
