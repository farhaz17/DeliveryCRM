@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
        .select2-container{
            width: 100% !important;
        }
        </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Ticket</a></li>
            <li>Create Ticket</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Ticket</div>
                    <form method="post" action="{{ route('save_ticket') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}


                        <div class="row">

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Platform</label>
                                <select class="form-control" id="platform" name="platform">
                                    <option value="">pleas select platform</option>
                                    @foreach($platforms as $plat)
                                        <option value="{{ $plat->id }}">{{ $plat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Platform id</label>
                                <input class="form-control form-control-rounded" id="platform_id" name="platform_id" value="" type="text" placeholder="Enter platform code" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Message</label>
                                <textarea class="form-control" id="message" name="message"></textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Department</label>
                                <select class="form-control" id="department_id"  name="department_id">
                                    <option value="">pleas select platform</option>
                                    @foreach($departments as $dpt)
                                        <option value="{{ $dpt->id }}">{{ $dpt->name }}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Upload Recording File</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" id="record_file" type="file" name="voice" aria-describedby="inputGroupFileAddon01" />
                                    <label class="custom-file-label" for="select_file">Choose Record file</label>
                                </div>

                            </div>

                            <div class="col-md-6 form-group mb-3 " >
                                <label for="repair_category">Upload Image</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" id="image" type="file" name="image" aria-describedby="inputGroupFileAddon01" />
                                    <label class="custom-file-label" for="select_file">Choose image</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary">Add Ticket</button>
                            </div>
                        </div>
                    </form>
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

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#platform').select2({
                placeholder: 'Please Select PlatFrom'
            });

            $('#department_id').select2({
                placeholder: 'Please Select Department'
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
