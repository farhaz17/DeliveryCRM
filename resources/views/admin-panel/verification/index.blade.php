@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
     .modal_table .table th{
         padding: 2px;
         font-size: 12px;
         font-weight: 300;
     }
     .modal_table h6{
         font-weight:800;
     }
     .remarks{
         font-weight:800;
     }
     .modal_table .table td{
         padding: 2px;
         font-size: 12px;
     }

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        .hide_cls{
            display:none;
        }



        </style>

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Verification Form</a></li>
            <li>Verifications</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


{{--    remarks modal--}}

    <div class="modal fade" id="remark_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="remark_p"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


{{--remarks modal end--}}

{{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('verification.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select Status</label>
                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="0">Not Verified</option>
                                    <option value="1">Verified</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group mb-3 user_status_div" style="display: none">
                                <label>Select User Current Status</label>
                                <select id="user_current_status" name="user_current_status" class="form-control form-control-rounded"  >
                                    <option value="" selected disabled>Select Option</option>
                                    @foreach($user_current_statuses as $status)
                                        <option value="{{ $status->id }}">{{  $status->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Remarks</label>
                                <textarea class="form-control" required name="remarks"></textarea>
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



    {{--    Edit Form update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_form_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="update_form" action="{{ route('verification.update','1') }}">
                    {!! csrf_field() !!}


                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="update_primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input type="text"  style="background-color: #8e7e9d59;" disabled name="user_name" id="user_name" class="form-control">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Email</label>
                                <input type="text" disabled style="background-color: #8e7e9d59;" name="user_email" id="user_email" class="form-control">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Platform</label>
                                <select class="form-control" name="user_platform_id" id="user_platform_id">
                                    <option value="" disabled selected>Select an option</option>
                                    @foreach($platforms as $plt)
                                        <option value="{{ $plt->id  }}">{{ $plt->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Plate Form Code</label>
                                <input type="text" name="user_plate_from_code" id="user_plate_from_code" class="form-control">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Plate Number</label>
                                <input type="nummber" name="user_plate_number" id="user_plate_number" class="form-control">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Sim Card Number</label>
                                <input type="nummber" name="user_sim_number" id="user_sim_number" class="form-control">
                            </div>



                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Bike Picture</label>
                                <input type="file"   name="user_bike_picture" class="form-control hide_cls" id="user_bike_picture">
                                <a id="user_bike_pic_html" target="_blank">See Image</a>

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Mulkiya Front Picture</label>
                                <input type="file" class="form-control hide_cls" name="user_mulkliya_front_picture" id="user_mulkliya_front_picture">
                                <a id="user_mulkiya_front_pic_html" target="_blank">See Image</a>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Mulkiya Back Picture</label>
                                <input type="file"  class="form-control hide_cls" name="user_mulkliya_back_picture" id="user_mulkliya_back_picture">
                                <a id="user_mulkiya_back_pic_html" target="_blank">See Image</a>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Emirates Id Front </label>
                                <input type="file" class="form-control hide_cls" name="user_emirates_id_front" id="user_emirates_id_front">
                                <a id="user_emirates_id_front_pic_html" target="_blank">See Image</a>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Emirates Id Back</label>
                                <input type="file" class="form-control hide_cls" name="user_emirates_id_back" id="user_emirates_id_back">
                                <a id="user_emirates_id_back_pic_html" target="_blank">See Image</a>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Selfie Pic</label>
                                <input type="file" class="form-control hide_cls" name="user_selfie_pic" id="user_selfie_pic">
                                <a id="user_selfie_pic_html" target="_blank">See Image</a>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Status</label>
                                <select class="form-control" name="user_status" id="user_status">
                                    <option value="" selected disabled>select an option</option>
                                    <option value="0">Not Verified</option>
                                    <option value="1">Verified</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3 user_status_div" style="display: none">
                                <label>Select User Current Status</label>
                                <select id="user_c_status" name="user_c_status" class="form-control form-control-rounded"  >
                                    <option value="" selected disabled>Select Option</option>
                                    @foreach($user_current_statuses as $status)
                                        <option value="{{ $status->id }}">{{  $status->name }}</option>
                                    @endforeach
                                </select>

                            </div>


                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Remarks</label>
                                <textarea class="form-control" name="user_remarks" id="user_remarks"></textarea>
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

    {{--    Edit Form modal end--}}







    {{--    view Detail modal--}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive modal_table">
{{--                                    <h6>Personal Detail</h6>--}}
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <td><span id="name_html"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><span id="email_html"></span></td>
                                        </tr>
                                        <tr>
                                            <th>PlatForm Name</th>
                                            <td><span id="plat_form_name_html"></span></td>
                                        </tr>

                                        <tr>
                                            <th>PlatFrom Code</th>
                                            <td><span id="plat_from_code_html"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Sim Card Number</th>
                                            <td><span id="sim_card_number_html"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Plate Number</th>
                                            <td><span id="plate_number_html"></span></td>
                                        </tr>
                                        <tr>
                                            <th>status</th>
                                            <td><span id="status_html"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Bike Picture</th>
                                            <td>
                                                <a id="bike_pic_html" target="_blank">See Image</a>
                                                <span id="bike_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Mulkiya Front Picture</th>
                                            <td>
                                                <a id="mulkiya_front_pic_html" target="_blank">See Image</a>
                                                <span id="mulkiya_front_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Mulkiya Back Picture</th>
                                            <td>
                                                <a id="mulkiya_back_pic_html" target="_blank">See Image</a>
                                                <span id="mulkiya_back_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Emirates Id Front Picture</th>
                                            <td>
                                                <a id="emirate_front_pic_html" target="_blank">See Image</a>
                                                <span id="emirate_front_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Emirates Id Back Picture</th>
                                            <td>
                                                <a id="emirate_back_pic_html" target="_blank">See Image</a>
                                                <span id="emirate_back_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Selfie Pic</th>
                                            <td>
                                                <a id="selfie_pic_html" target="_blank">See Image</a>
                                                <span id="selfie_pic_html_not_found_html"></span>
                                            </td>
                                        </tr>



                                    </table>
                                </div>


                                <h6 class="remarks" >
                                    Remarks
                                </h6>
                                <p  id="remark_html"></p>


                            </div>





                        </div>




                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">


                <div class="card text-left">
                    <div class="card-body">
                        {{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                        <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#verified" role="tab" aria-controls="verified" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>Verified ({{ $verified->count()  }})</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#not_verified" role="tab" aria-controls="not_verified" aria-selected="false"><i class="nav-icon i-Visa mr-1"></i>Not Verified ({{ $not_verified->count()  }})</a></li>
                            <li class="nav-item"><a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false"><i class="nav-icon i-Over-Time-2 mr-1"></i>Rejected ({{ $rejected->count()  }})</a></li>
                        </ul>
                        <div class="tab-content" id="myIconTabContent">
                            <div class="tab-pane fade show active" id="verified" role="tabpanel" aria-labelledby="home-icon-tab">



                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="datatable_verified">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">PlatForm</th>
                                            <th scope="col">PlatForm Code</th>
                                            <th scope="col">Sim Card</th>
                                            <th scope="col">Plate No</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Live Status</th>
                                            <th scope="col">Status Change By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $counter = 1; ?>
                                        @foreach($verified as $verify)

                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{ $verify->user->profile? $verify->user->profile->passport->personal_info->full_name:""  }}</td>
                                                <td>{{ $verify->platform->name  }}</td>
                                                <td>{{ $verify->platform_code  }}</td>
                                                <td>{{ $verify->simcard_no }}</td>
                                                <td>{{ $verify->plate_no }}</td>
                                                <?php $application_status = ""; ?>
                                                <?php if($verify->status=="0"){
                                                    $application_status  = "Not verified";
                                                }elseif($verify->status=="2"){
                                                    $application_status  = "Rejected";
                                                }elseif($verify->status=="1"){
                                                    $application_status  = "verified";
                                                }?>



                                                <td>{{ $application_status }}</td>
                                                <td>
                                                    {{  $verify->user->live_user_status ?  $verify->user->live_user_status->live_status_name->name : '' }}
                                                </td>
                                                <td>{{ isset($verify->status_change_by->name) ? $verify->status_change_by->name: 'N/A'   }}</td>
                                                <td>
                                                    @if($application_status !="verified")
                                                        <a class="text-success mr-2 edit_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                    @endif

                                                    <a class="text-primary mr-2 view_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                                </td>
                                            </tr>
                                            <?php $counter = $counter+1; ?>

                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <div class="tab-pane fade" id="not_verified" role="tabpanel" aria-labelledby="profile-icon-tab">

                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="datatable_not_verified">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">PlatForm</th>
                                            <th scope="col">PlatForm Code</th>
                                            <th scope="col">Sim Card</th>
                                            <th scope="col">Plate No</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Live Status</th>
                                            <th scope="col">Status change By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($not_verified as $verify)
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{ $verify->user->profile? $verify->user->profile->passport->personal_info->full_name:""   }}</td>
                                                <td>{{ $verify->platform->name  }}</td>
                                                <td>{{ $verify->platform_code  }}</td>
                                                <td>{{ $verify->simcard_no }}</td>
                                                <td>{{ $verify->plate_no }}</td>
                                                <?php $application_status = ""; ?>
                                                <?php if($verify->status=="0"){
                                                    $application_status  = "Not verified";
                                                }elseif($verify->status=="2"){
                                                    $application_status  = "Rejected";
                                                }elseif($verify->status=="1"){
                                                    $application_status  = "verified";
                                                }?>

                                                <td>{{ $application_status }}</td>
                                                <td>{{  $verify->user->live_user_status ?  $verify->user->live_user_status->live_status_name->name : '' }}</td>
                                                <td>{{ isset($verify->status_change_by->name) ? $verify->status_change_by->name: 'N/A'   }}</td>
                                                <td>
                                                    @if($application_status !="verified")
                                                        <a class="text-success mr-2 edit_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                        <a class="text-warning mr-2 edit_form_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-Edit font-weight-bold"></i></a>
                                                    @endif

                                                    <a class="text-primary mr-2 view_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="contact-icon-tab">

                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="datatable_rejected">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">PlatForm</th>
                                            <th scope="col">PlatForm Code</th>
                                            <th scope="col">Sim Card</th>
                                            <th scope="col">Plate No</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Live Status</th>
                                            <th scope="col">Status Change By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($rejected as $verify)
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{  $verify->user->profile? $verify->user->profile->passport->personal_info->full_name:""  }}</td>
                                                <td>{{ $verify->platform->name  }}</td>
                                                <td>{{ $verify->platform_code  }}</td>
                                                <td>{{ $verify->simcard_no }}</td>
                                                <td>{{ $verify->plate_no }}</td>
                                                <?php $application_status = ""; ?>
                                                <?php if($verify->status=="0"){
                                                    $application_status  = "Not verified";
                                                }elseif($verify->status=="2"){
                                                    $application_status  = "Rejected";
                                                }elseif($verify->status=="1"){
                                                    $application_status  = "verified";
                                                }?>

                                                <td>{{ $application_status }}</td>
                                                <td>{{  $verify->user->live_user_status ?  $verify->user->live_user_status->live_status_name->name : '' }}</td>
                                                <td>{{ isset($verify->status_change_by->name) ? $verify->status_change_by->name: 'N/A'   }}</td>
                                                <td>
                                                    @if($application_status !="verified")
                                                            <a class="text-success mr-2 edit_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                    |
                                                        <a class="text-warning mr-2 edit_form_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-Edit font-weight-bold"></i></a>

                                                    @endif

                                                    <a class="text-primary mr-2 view_cls" id="{{ $verify->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach


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


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_verified ,#datatable_not_verified ,#datatable_rejected').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'print',
                        title: 'Status Summary',
                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Status Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Status Summary',
                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                select: true,


                scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }) ;
        });



        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });

        $('tbody').on('click', '.edit_form_cls', function() {
            var  ids  = $(this).attr('id');
            $("#update_primary_id").val(ids);


            var ab = $("#update_form").attr('action');

            var now =  ab.split("verification/");
            $("#update_form").attr('action',now[0]+"verification/"+ids);

            $("#edit_form_modal").modal('show');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_verification_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: ids ,_token:token,edit_form:'gamer'},
                success: function(response) {

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var name = response['data'][i].name;
                            $("#user_name").val(name);
                            $("#user_email").val(response['data'][i].email);
                            $("#user_platform_id").val(response['data'][i].platform_name);
                            $("#user_plate_from_code").val(response['data'][i].platform_code);
                            $("#user_plate_number").val(response['data'][i].plate_no);
                            $("#user_sim_number").val(response['data'][i].simcard_no);

                            $("#user_bike_pic_html").attr('href',response['data'][i].bike_pic);
                            $("#user_mulkiya_front_pic_html").attr('href',response['data'][i].mulkiya_pic);
                            $("#user_mulkiya_back_pic_html").attr('href',response['data'][i].mulkiya_back);

                            $("#user_emirates_id_front_pic_html").attr('href',response['data'][i].emirates_pic);
                            $("#user_emirates_id_back_pic_html").attr('href',response['data'][i].emirates_id_back);

                            $("#user_selfie_pic_html").attr('href',response['data'][i].selfie_pic);

                            $("#user_status").val(response['data'][i].status);

                            $("#user_remarks").val(response['data'][i].remark);



                        }
                    }

                }
            });






        });





            $('tbody').on('click', '.view_cls', function() {

            var ids  = $(this).attr('id');
            $("#detail_modal").modal('show');

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_verification_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {primary_id: ids ,_token:token},
                success: function(response) {

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var platform_code = response['data'][i].platform_code;

                            $("#name_html").html(response['data'][i].name);
                            $("#email_html").html(response['data'][i].email);
                            $("#plat_form_name_html").html(response['data'][i].platform_name);
                            $("#plat_from_code_html").html(response['data'][i].platform_code);
                            $("#sim_card_number_html").html(response['data'][i].simcard_no);
                            $("#plate_number_html").html(response['data'][i].plate_no);
                            $("#status_html").html(response['data'][i].status);

                            $("#bike_pic_html").attr('href',response['data'][i].bike_pic);

                            $("#mulkiya_front_pic_html").attr('href',response['data'][i].mulkiya_pic);
                            $("#mulkiya_back_pic_html").attr('href',response['data'][i].mulkiya_back);

                            $("#emirate_front_pic_html").attr('href',response['data'][i].emirates_pic);
                            $("#emirate_back_pic_html").attr('href',response['data'][i].emirates_id_back);

                            $("#selfie_pic_html").attr('href',response['data'][i].selfie_pic);

                            $("#remark_html").html(response['data'][i].remark);






                            $("#whatsapp_html").html(response['data'][i].whatsapp);
                            $("#facebook_html").html(response['data'][i].facebook);
                            $("#vehicle_type_html").html(response['data'][i].vehicle_type);
                            $("#experiecne_html").html(response['data'][i].experience);

                            // $("#cv_attached_html").html(response['data'][i].cv);

                            if(response['data'][i].cv=="Not Found"){
                                $("#cv_attached_html").html("");
                                $("#cv_attached_not_found_html").html(response['data'][i].cv);
                            }else{
                                $("#cv_attached_not_found_html").html("");
                                $("#cv_attached_html").attr('href',response['data'][i].cv);
                                $("#cv_attached_html").html("see Image");
                            }



                            $("#license_status_html").html(response['data'][i].licence_status);
                            $("#license_status_vehicle_html").html(response['data'][i].licence_status_vehicle);
                            $("#license_no_html").html(response['data'][i].licence_no);
                            $("#license_issue_html").html(response['data'][i].licence_issue);
                            $("#license_expiry_html").html(response['data'][i].licence_expiry);

                            if(response['data'][i].licence_attach=="Not Found"){
                                $("#license_attach_html").html("");
                                $("#license_attach_not_found_html").html(response['data'][i].licence_attach);
                            }else{
                                $("#license_attach_not_found_html").html("");
                                $("#license_attach_html").attr('href',response['data'][i].licence_attach);
                                $("#license_attach_html").html("see Image");
                            }


                            $("#nationality_html").html(response['data'][i].nationality);
                            $("#dob_html").html(response['data'][i].dob);
                            $("#passport_no_html").html(response['data'][i].passport_no);
                            $("#passport_expiry_html").html(response['data'][i].passport_expiry);
                            // $("#passport_attach_html").html(response['data'][i].passport_attach);

                            if(response['data'][i].passport_attach=="Not Found"){
                                $("#passport_attach_html").html("");
                                $("#passport_attach_not_found_html").html(response['data'][i].passport_attach);
                            }else{
                                $("#passport_attach_not_found_html").html("");
                                $("#passport_attach_html").attr('href',response['data'][i].passport_attach);
                                $("#passport_attach_html").html("see Image");
                            }



                            $("#visa_status_html").html(response['data'][i].visa_status);
                            $("#visa_status_visit_html").html(response['data'][i].visa_status_visit);
                            $("#visa_status_cancel_html").html(response['data'][i].visa_status_cancel);
                            $("#visa_status_own_html").html(response['data'][i].visa_status_own);
                            $("#exit_date_html").html(response['data'][i].exit_date);
                            $("#company_visa_html").html(response['data'][i].company_visa);
                            $("#inout_transfer_html").html(response['data'][i].inout_transfer);
                            $("#platform_id_html").html(response['data'][i].platform_id);
                            $("#applicant_status_html").html(response['data'][i].applicant_status);
                            $("#remarks_html").html(response['data'][i].remarks);


                        }
                    }

                }
            });


        });


        $(".remarks_cls").click(function () {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_remarks') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });
        </script>

{{--    jquery for status change verify--}}
    <script>
        $("#status").change(function(){
            var selected = $(this).val();
            if(selected=="1"){
                $("#user_current_status").val("");
                $(".user_status_div").show();
                $("#user_current_status").prop('required',true);
            }else{
                $(".user_status_div").hide();
                $("#user_current_status").prop('required',false);
            }
        });

        $("#user_status").change(function(){
            var selected = $(this).val();
            if(selected=="1"){
                $("#user_c_status").val("");
                $(".user_status_div").show();
                $("#user_c_status").prop('required',true);
            }else{
                $(".user_status_div").hide();
                $("#user_c_status").prop('required',false);
            }
        });

    </script>

{{--    jquery for status change verify End--}}



        <script>
            $("#search_status").change(function(){
                var value_s =  $(this).val();

                var driving_license = $("#search_driving_license option:selected").val();
                var visa_status = $("#search_visa_status option:selected").val();

                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                    dataType: 'json',
                    url: '{{ route('ajax_search_career_table') }}',
                    success:function(response)
                    {
                        var tableBody = $("#datatable_career tbody");
                        tableBody.empty();

                        var len = 0;
                        if(response['data'] != null){
                            len = response['data'].length;
                        }else{
                            tableBody.empty();
                        }
                        var options = "";
                        var  contact_html = "";
                        if(len > 0){


                            for(var i=0; i<len; i++) {
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;
                                var email = response['data'][i].email;
                                var phone = response['data'][i].phone;
                                var whatsapp = response['data'][i].whatsapp;
                                var status = response['data'][i].status;
                                var requird = "";

                                var edit_button = "";
                                if (status!=="Rejected"){
                                    edit_button = '<a class="text-success mr-2 edit_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                                    }



                                var button_view = '<a class="text-primary mr-2 view_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                                var html = '<tr><td>'+name+'</td> <td>'+email+'</td> <td>'+phone+'</td> <td>'+whatsapp+'</td> <td>'+status+'</td><td>'+edit_button+' '+button_view+'</td></tr>';

                                contact_html += html;
                            }
                            tableBody.append(contact_html);
                        }


                    }
                });

                $.ajax({
                    type: "POST",
                    data: {value_s:value_s,_token:token},
                    url: '{{ route('ajax_search_license_count') }}',
                    success:function(response)
                    {
                        var ab = response.split('$');
                        var yes = "Yes ("+ab[0]+")";
                        var no = "No ("+ab[1]+")";
                        $("#license_yes").html(yes);
                        $("#license_no").html(no);
                    }
                });





            });

            $("#search_driving_license").change(function(){

                var value_s = $("#search_status option:selected").val();

                var driving_license = $(this).val();
                var visa_status = $("#search_visa_status option:selected").val();

                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                    dataType: 'json',
                    url: '{{ route('ajax_search_career_table') }}',
                    success:function(response)
                    {
                        var tableBody = $("#datatable_career tbody");
                        tableBody.empty();

                        var len = 0;
                        if(response['data'] != null){
                            len = response['data'].length;
                        }else{
                            tableBody.empty();
                        }
                        var options = "";
                        var  contact_html = "";
                        if(len > 0){


                            for(var i=0; i<len; i++){
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;
                                var email = response['data'][i].email;
                                var phone = response['data'][i].phone;
                                var whatsapp = response['data'][i].whatsapp;
                                var status = response['data'][i].status;
                                var requird = "";

                                var edit_button = "";
                                if (status!=="Rejected"){
                                    edit_button = '<a class="text-success mr-2 edit_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                                }



                                var button_view = '<a class="text-primary mr-2 view_cls" id="'+id+'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                                var html = '<tr><td>'+name+'</td> <td>'+email+'</td> <td>'+phone+'</td> <td>'+whatsapp+'</td> <td>'+status+'</td><td>'+edit_button+' '+button_view+'</td></tr>';

                                contact_html += html;
                            }
                            tableBody.append(contact_html);
                        }


                    }
                });


                $.ajax({
                    type: "POST",
                    data: {value_s:value_s, driving_license:driving_license, _token:token},
                    url: '{{ route('ajax_search_visa_count') }}',
                    success:function(response)
                    {
                        var ab = response.split("$");

                        var all = "All ("+ab[0]+")";
                        var visit = "Visit ("+ab[1]+")";
                        var cancel_visa = "Cancel Visa ("+ab[2]+")";
                        var own_visa = "Own Visa ("+ab[3]+")";


                        $("#vist_status_all").html(all);
                        $("#vist_status_visit").html(visit);
                        $("#vist_status_cancel").html(cancel_visa);
                        $("#vist_status_own").html(own_visa);

                    }
                });

            });


            $("#search_visa_status").change(function(){



                var value_s = $("#search_status option:selected").val();
                var driving_license = $("#search_driving_license option:selected").val();
                var visa_status = $(this).val();

                // var driving_license =


                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    data: {value_s:value_s, driving_license:driving_license,visa_status:visa_status, _token:token},
                    dataType: 'json',
                    url: '{{ route('ajax_search_career_table') }}',
                    success:function(response)
                    {
                        var tableBody = $("#datatable_career tbody");
                        tableBody.empty();
                        var len = 0;
                        if(response['data'] != null){
                            len = response['data'].length;
                        }else{
                            tableBody.empty();
                        }
                        var options = "";
                        var  contact_html = "";
                        if(len > 0) {
                            for (var i = 0; i < len; i++) {
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;
                                var email = response['data'][i].email;
                                var phone = response['data'][i].phone;
                                var whatsapp = response['data'][i].whatsapp;
                                var status = response['data'][i].status;
                                var requird = "";
                                var edit_button = "";
                                if (status !== "Rejected") {
                                    edit_button = '<a class="text-success mr-2 edit_cls" id="' + id + '" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                                }

                                var button_view = '<a class="text-primary mr-2 view_cls" id="' + id + '" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>'
                                var html = '<tr><td>' + name + '</td> <td>' + email + '</td> <td>' + phone + '</td> <td>' + whatsapp + '</td> <td>' + status + '</td><td>' + edit_button + ' ' + button_view + '</td></tr>';
                                contact_html += html;
                              // console.log(contact_html);
                            }

                            tableBody.append(contact_html);
                        }


                    }
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
