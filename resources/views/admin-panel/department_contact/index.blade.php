@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Deparement Contact Information</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="udpate_contact" action="{{ route('department_contact.update','1') }}">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Departement Name</label>
                                <input class="form-control form-control-rounded" id="update_name" name="name" value="" type="text" placeholder="Enter the name" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Email</label>
                                <input class="form-control form-control-rounded" id="update_email" name="email" value="" type="email" placeholder="Enter the email" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Phone Number</label>
                                <input class="form-control form-control-rounded" id="update_number" name="phone_number" value="" type="number" placeholder="Enter the Number" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">WhatsApp Number</label>
                                <input class="form-control form-control-rounded" id="update_whatsapp" name="whatsapp_number" value="" type="number" placeholder="Enter the  Whats App Number" required />
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    status update modal end--}}


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add New Contact Department</div>
                    <form method="post" action="{{ route('department_contact.store') }}">
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Departement Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name" value="" type="text" placeholder="Enter the name" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Email</label>
                                <input class="form-control form-control-rounded" id="email" name="email" value="" type="email" placeholder="Enter the email" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Phone Number</label>
                                <input class="form-control form-control-rounded" id="number" name="phone_number" value="" type="number" placeholder="Enter the Number" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">WhatsApp Number</label>
                                <input class="form-control form-control-rounded" id="number" name="whatsapp_number" value="" type="number" placeholder="Enter the  Whats App Number" required />
                            </div>



                            <div class="col-md-6">
                                <button class="btn btn-primary">Save</button>
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
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Department Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Whats App</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <th scope="row">1</th>
                                <td> {{ $contact->name  }}</td>
                                <td> {{ $contact->email  }}</td>
                                <td> {{ $contact->phone  }}</td>
                                <td> {{ $contact->whatsapp  }}</td>
                                <td><a class="text-success mr-2 edit_cls" id="{{ $contact->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
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

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#role').select2({
                placeholder: 'Select an option'
            });
            $('#platform').select2({
                placeholder: 'Select an option'
            });
            $('#department').select2({
                placeholder: 'Select an option'
            });



        });

        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            var ab = $("#udpate_contact").attr('action');

            var now =  ab.split("department_contact/");
            $("#udpate_contact").attr('action',now[0]+"department_contact/"+ids);


            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_edit_contact') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    var arr = $.parseJSON(response);

                    if(arr !== null){
                       $("#update_name").val(arr['name']);
                        $("#update_email").val(arr['email']);
                        $("#update_number").val(arr['phone']);
                        $("#update_whatsapp").val(arr['whatsapp']);
                    }

                }
            });



            $("#edit_modal").modal('show');
        });


        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('manage_user.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
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
