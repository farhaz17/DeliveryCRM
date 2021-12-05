
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        button.btn.btn-primary.save-btn {
            margin-top: 24px;
        }
        th{
            white-space: nowrap;
            padding: 2px;
        }
        .profile_images_class{
            /* text-align: center; */
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manager User</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Update Manager User</div>
                    <form method="post" id="user_form" action="{{ route('manager_user.update',$manage_user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Manager</label>
                                <select  name="manager_id" class="form-control" required >
                                    <option value="" selected disabled>Select User</option>
                                    @foreach($managers as $user)
                                        <option value="{{ $user->id }}" {{   ($manage_user->manager_user_id==$user->id) ? 'selected' : ''  }}  >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Users</label>
                                <select multiple="multiple" id="role" name="users[]" class="form-control select multi-select " required>
                                    <option value="">Select User Role</option>
                                    <?php $user_array =  $manage_user->manager_user_detail->manager_users->pluck('member_user_id')->toArray(); ?>
                                    @foreach($users as $us)
                                        <option value="{{ $us->id }}" {{  (in_array($us->id,$user_array)) ? 'selected': '' }}>{{ $us->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary save-btn">Update User</button>
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
    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="platFormModalTitle">Platform List</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="userInfoBody">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-------------User Status-----------------}}

    <div class="modal fade bd-example-modal-md sim_shortage_mdl" id="sim_shortage_mdl_id" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">All Manager User</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" style="background-color: #8080808c;">
                        <div id="sim_shortage_detail">

                        </div>

                    </div>
                </div>
            </div>
            <div class="overlay"></div>
        </div>
    </div>

    {{------------------------------}}


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
            $('#major_department_ids').select2({
                placeholder: 'Select an option'
            });

            $('#permission_role').select2({
                placeholder: 'Select an option'
            });

            $('#manager_id').select2({
                placeholder: 'Select an option'
            });

        });
    </script>

    <script>
        $(".details_user").click(function () {
            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_user_member') }}",
                method: 'get',
                dataType: 'json',
                data: {primary_id:ids},
                success: function (response) {
                    $('#sim_shortage_detail').empty();
                    $('#sim_shortage_detail').append(response.html);
                    // $('.sim_shortage_mdl').modal('show');
                    $("#sim_shortage_mdl_id").modal('show');
                }
            });
        });

        $('#sim_shortage_detail').on('change', '.stats_user_manager', function() {

            var token = $("input[name='_token']").val();
            var selected_val = "";
            var ids = $(this).attr('id');

            console.log(ids);

            if($(this).prop("checked") == true){
                selected_val = 1;
            }else{
                selected_val = 0;
            }

            $.ajax({
                url: "{{ route('manager_user.update',1) }}",
                method: 'PUT',
                data: {_token: token,status:selected_val,id:ids},
                success: function (response) {

                }
            });


        });

    </script>

    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>


    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>





@endsection
