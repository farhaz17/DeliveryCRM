
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

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manage User</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">@if(isset($userData)) Update ( {{ $userData->name }} ) @else Register  @endif User</div>
                    <form method="post" id="user_form" action="{{isset($userData) ? route('manage_user.update',$userData->id):route('manage_user.store')}}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($userData))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id"  value="{{isset($userData)?$userData->id:""}}">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Name</label>
                                <input class="form-control form-control-sm  " id="name" name="name" value="{{isset($userData)?$userData->name:""}}" type="text" placeholder="Enter the name" required />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email</label>
                                <input class="form-control form-control-sm  " id="email" name="email" value="{{isset($userData)?$userData->email:""}}" type="text" placeholder="Enter the email" required />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="role">User Role</label>
                                <select multiple="multiple" id="role" name="role[]" class="form-control form-control-sm  select multi-select ">
                                    <option value="">Select User Role</option>
                                    @foreach($userGroups as $role)
                                        @php
                                            $isSelected=isset($userData)?($userData->user_group_id?in_array($role->id,$userData->user_group_id):false):false;
                                        @endphp
                                        <option value="{{$role->id}}" @if($isSelected) selected @endif >{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="permission_role">User Permission Role</label>
                                <select multiple="multiple" id="permission_role" name="permission_role[]" class="form-control form-control-sm  select multi-select">
                                    <option value="">Select User Role</option>
                                    @foreach($roles as $roll)
                                        @php
                                            $isSelected=isset($userData)? ($userRole?in_array($roll->name,$userRole):false):false;
                                        @endphp
                                        <option value="{{ $roll->id }}" @if($isSelected) selected @endif >{{ $roll->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="major_department_ids">Major Department</label>
                                <select multiple="multiple" id="major_department_ids" name="major_department_ids[]" class="form-control form-control-sm  select multi-select ">
                                    <option value="">Select Department</option>
                                    @foreach($major_deps as $major_dep)
                                        @php
                                            $isSelected=isset($userData)?($userData->major_department_ids?in_array($major_dep->id,$userData->major_department_ids):false):false;
                                        @endphp
                                        <option value="{{$major_dep->id}}" @if($isSelected) selected @endif>{{$major_dep->major_department}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="">Platform</label>
                                {{-- <br> --}}
{{--                                <button >Select All</button>--}}
                                <label for="" class="font-weight-bold">Select All</label>
                                <input  type="radio" id="select_all" name="select_all" value="Select All">
{{--                                <input type="button" id="select_all" name="select_all" value="Select All">--}}
{{--                                <select name="countries" id="countries" MULTIPLE size="8">--}}
                                <select class="form-control form-control-sm  select multi-select " id="platform" name="platform[]" multiple="multiple">
{{--                                    <option id="select_all" name="select_all" value="Select All"> Select ALl</option>--}}
                                    @foreach($platform as $plat)
                                        @php
                                            $isSelected=isset($userData)?($userData->user_platform_id?in_array($plat->id,$userData->user_platform_id):false):false;
                                        @endphp

                                        <option   value="{{$plat->id}}"@if($isSelected) selected @endif>{{$plat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="password">Password</label>
                                <input class="form-control form-control-sm  " @if(isset($userData)) @else required @endif autocomplete="off"  id="password" name="password"  type="password" placeholder="Enter the password"  />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="designation_type">User Role</label>
                                <select  name="designation_type" id="designation_type" class="form-control form-control-sm  select ">
                                    <option value="" selected disabled>please select option</option>
                                    <option value="1" @if(isset($userData)) {{ ($userData->designation_type=="1") ? 'selected' : ''  }}  @endif >Manager</option>
                                    <option value="2" @if(isset($userData)) {{ ($userData->designation_type=="2") ? 'selected' : ''  }}  @endif >Team Leader</option>
                                    <option value="3" @if(isset($userData)) {{ ($userData->designation_type=="3") ? 'selected' : ''  }}  @endif >Delivery Coordinator</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3 limit_div" @if(isset($userData->designation_type)=="3")  @else  style="display: none;" @endif >
                                <label for="dc_limit">Enter Limit of DC</label>
                                <input class="form-control form-control-sm  "  id="dc_limit" name="dc_limit"   type="number" value="<?php  echo isset($userData->dc_limit_detail->limit) ? $userData->dc_limit_detail->limit : '';  ?>" placeholder="Enter the limitsdfds" @if(isset($userData->dc_limit_detail->limit)) {{ "required"  }}  @endif  />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="user_profile_picture">User Profile Picture</label>
                                <input type="file" class="form-control-file form-control-sm " style="height:auto" name="user_profile_picture" id="user_profile_picture" >
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-sm btn-primary save-btn">@if(isset($userData)) Update @else Register  @endif User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="card text-left col-md-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Email</th>
                            {{-- <th scope="col">Role</th> --}}
                            <th scope="col">User Permission</th>
                            {{-- <th scope="col">Major Department</th> --}}
{{--                            <th scope="col">Issue Department</th>--}}
                            {{-- <th scope="col">Platform</th> --}}
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @php
                                $userRoleName="";
                                $userDepartName="";
                                $userPlatName="";
                                $userMajDepartName="";
                            @endphp
                            @if($user->user_group_id)
                                @foreach($user->user_group_id as $userRole)
                                    @php
                                        $userRoleName.=$userGroupsAR[$userRole].", ";
                                    @endphp
                                @endforeach
                            @endif
                            @if($user->user_issue_dep_id)
                                @foreach($user->user_issue_dep_id as $userDept)

                                    @php
                                        $userDepartName.=$userDepartsAR[$userDept].", ";
                                    @endphp
                                @endforeach
                            @endif
                            @if($user->user_platform_id)
                                @foreach($user->user_platform_id as $userPlat)

                                    @php
                                        $userPlatName.= isset($userPlatsAR[$userPlat])  ?  $userPlatsAR[$userPlat].", " : ''
                                    @endphp
                                @endforeach
                            @endif


                            @if($user->major_department_ids)
                                @foreach($user->major_department_ids as $userMajDept)

                                    @php
                                        $userMajDepartName.=$userDepartmentAR[$userMajDept].", ";
                                    @endphp
                                @endforeach
                            @endif


                            <tr>
                                <th scope="row">1</th>
                                <td>{{$user->name}}</td>
                                <td class="text-center">
                                    <img class="profile_images_class" src="{{ $user->user_profile_picture ?  Storage::temporaryUrl($user->user_profile_picture, now()->addMinutes(5)) : 'assets/images/avatar.jpg'}}"
                                         alt="" width="25em" />
                                </td>
                                <td>{{$user->email}}</td>
                                <td>
                                    {{rtrim($userRoleName,", ")}}
                                </td>
                                {{-- <td> --}}
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="
                                    {{implode(', ', $user->getRoleNames()->toArray())}}
                                    ">
                                        Show Roles
                                      </button> --}}
                                    {{-- @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif --}}

                                {{-- </td> --}}
                                {{-- <td>
                                    <span type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="right" title="{{rtrim($userMajDepartName,", ")}}">
                                        Show Departments
                                      </span>
                                </td> --}}
{{--                                <td>{{$user->user_issue_dep_id?rtrim($userDepartName,", "):""}}</td>--}}
                                {{-- <td>
                                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="left" title=" {{$user->user_platform_id?rtrim($userPlatName,", "):""}}">Show Platforms</button>
                                </td> --}}
                                <td  style="white-space: nowrap">
                                    <button class="text-success mr-2 btn btn-link" type="button" onclick="getUserInfo({{$user->id}})" data-toggle="modal" data-target="#userInfoModal"><i class="nav-icon i-eye font-weight-bold"></i></button>
                                    <a class="text-success mr-2" href="{{route('manage_user.edit',$user->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                    <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$user->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
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
    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="platFormModalTitle">Platform List</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="userInfoBody"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>

        $('#select_all').click(function() {
            $('#platform option').prop('selected', true);
        });

        // function selectAll()
        // {
        //     // options = document.getElementById('#platforms');
        //     options = document.getElementsByTagName("option");
        //     alert('asdf')
        //
        //     for ( i=0; i<options.length; i++)
        //     {
        //         options[i].selected = "true";
        //     }
        // }


    </script>

    <script>
        $( document ).ready(function() {
            $('#user_form').trigger("reset");
        });
    </script>


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

    <script>
        function getUserInfo(userId){
            $.ajax({
                method: "GET",
                url: "{{route('getUserInfo')}}",
                dataType: "json",
                data: { user_id: userId }
            })
            .done(function(response) {
                $('#userInfoBody').empty();
                $('#userInfoBody').append(response.html);
            });
        }
    </script>

    <script>
        $("#designation_type").change(function () {
            var selected_ab = $(this).val();
            if(selected_ab=="3"){
                $(".limit_div").show();
                $("#dc_limit").prop("required",true);
            }else{

                $(".limit_div").hide();
                $("#dc_limit").prop("required",false);
            }
        });
    </script>
@endsection
