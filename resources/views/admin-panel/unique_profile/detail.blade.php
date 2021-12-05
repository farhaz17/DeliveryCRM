@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <style>
        .margin-top{
            margin-top:10px;
        }
        .dataTables_filter{
            display: none;
        }
        .dataTables_length{
            display: none;
        }
        .hide_cls{
            display: none;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
         .table th{
            padding: 2px;
            font-size: 12px;
        }
        .table td{
            padding: 2px;
            font-size: 12px;
        }
        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 600;
        }
        .user-profile .header-cover {
            background-position: center;
        }
        .download_btn{
            float:right;
            color: white;
        }
        .download_btn span{
            color: white;
        }
        .search-bar {
            display: flex;
            align-items: center;
            justify-content: left;
            background: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 20px;
            position: relative;
            width: 230px;
            height: 40px;
        }
        .search-bar input {
            background: transparent;
            border: 0;
            color: #212121;
            font-size: .8rem;
            line-height: 2;
            height: 100%;
            outline: initial !important;
            padding: .5rem 1rem;
            width: calc(100% - 32px);
        }
        .hidden {
            display: none;
        }



        </style>

        <div class="main-content">
            <div class="breadcrumb">
                <h1>Rider Profile</h1>
                <ul>
                    <li><a href="">Pages</a></li>
                    <li>Rider Profile</li>
                </ul>
            </div>




            {{--    view Detail Passport modal--}}
            <div class="modal fade bd-example-modal-lg" id="passport_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Passport Details</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="primary_id" name="id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive modal_table">
                                        <h6>Passport Detail</h6>
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Nationality</th>
                                                <td><span >{{ isset($user->passport->nation->name) ? $user->passport->nation->name : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Country Code</th>
                                                <td><span>{{ isset($user->passport->country_code) ? $user->passport->country_code : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Passport Number</th>
                                                <td><span>{{ isset($user->passport->passport_no) ? $user->passport->passport_no : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>SurName</th>
                                                <td><span>{{ isset($user->passport->sur_name) ? $user->passport->sur_name : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Given Name</th>
                                                <td><span>{{ isset($user->passport->given_names) ? $user->passport->given_names : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Sex</th>
                                                <td><span>{{ isset($user->passport->sex) ? $user->passport->sex : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Father Name</th>
                                                <td><span>{{ isset($user->passport->father_name) ? $user->passport->father_name : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Date Of Birth</th>
                                                <td><span>{{ isset($user->passport->dob) ? $user->passport->dob : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Place of Birth</th>
                                                <td><span>{{ isset($user->passport->place_birth) ? $user->passport->place_birth : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Place of Issue</th>
                                                <td>{{ isset($user->passport->place_issue) ? $user->passport->place_issue : 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Place of Issue</th>
                                                <td>{{ isset($user->passport->place_issue) ? $user->passport->place_issue : 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Date of Issue</th>
                                                <td>{{ isset($user->passport->date_issue) ? $user->passport->date_issue : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expiry Date</th>
                                                <td>{{ isset($user->passport->date_expiry) ? $user->passport->date_expiry : 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Passport Scan Copy</th>
                                                <td>
                                                     @if(isset($user->passport->passport_pic))
                                                        <a  href="{{ url($user->passport->passport_pic) }}"  target="_blank">See Attachment</a>
                                                    @else
                                                        <span>N/A</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            @if(!empty($user->passport->attach->attachment_name) && isset($user->passport->attachment_type->name))
                                                <tr>
                                                    <th>{{ $user->passport->attachment_type->name }} Picture</th>
                                                    <td><a  href="{{ url($user->passport->attach->attachment_name) }}" target="_blank">See Attachment</a></td>
                                                </tr>
                                            @endif





                                        </table>
                                    </div>


                                    <div class="table-responsive modal_table">
                                        <h6>National Detail</h6>
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Relation Name</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_name) ? $user->passport->personal_info->nat_name : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Relation</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_relation) ? $user->passport->personal_info->nat_relation : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>National Address</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_address) ? $user->passport->personal_info->nat_address : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>National Phone</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_phone) ? $user->passport->personal_info->nat_phone : 'N/A' }}</span></td>

                                            </tr>
                                            <tr>
                                                <th>National Whatsapp Number</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_whatsapp_no) ? $user->passport->personal_info->nat_whatsapp_no : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>National Email Address</th>
                                                <td><span>{{ isset($user->passport->personal_info->nat_email) ? $user->passport->personal_info->nat_email : 'N/A' }}</span></td>
                                            </tr>


                                        </table>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive modal_table">
                                        <h6>Passport Additional Detail</h6>
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Citizenship Number</th>
                                                <td><span>{{ isset($user->passport->citizenship_no) ? $user->passport->citizenship_no : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Personal Address</th>
                                                <td><span>{{ isset($user->passport->personal_address) ? $user->passport->personal_address : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Permanent Address</th>
                                                <td><span>{{ isset($user->passport->permanant_address) ? $user->passport->permanant_address : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Booklet Numebr</th>
                                                <td><span>{{ isset($user->passport->booklet_number) ? $user->passport->booklet_number : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Tracking Number</th>
                                                <td><span>{{ isset($user->passport->tracking_number) ? $user->passport->tracking_number : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Name of Mother</th>
                                                <td><span>{{ isset($user->passport->name_of_mother) ? $user->passport->name_of_mother : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Next Of Kind</th>
                                                <td><span>{{ isset($user->passport->next_of_kin) ? $user->passport->next_of_kin : 'N/A' }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Relationship</th>
                                                <td><span>{{ isset($user->passport->relationship) ? $user->passport->relationship : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Middle Name</th>
                                                <td><span>{{ isset($user->passport->middle_name) ? $user->passport->middle_name : 'N/A' }}</span></td>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="table-responsive modal_table">
                                        <h6>Personal Details</h6>
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Personal Mobile</th>
                                                <td><span>{{ isset($user->passport->personal_info->personal_mob) ? $user->passport->personal_info->personal_mob : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Personal Email</th>
                                                <td><span>{{ isset($user->passport->personal_info->personal_email) ? $user->passport->personal_info->personal_email : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>Personal Image</th>

                                                <td>
                                                    @if(isset($user->passport->personal_info->personal_image))
                                                        <a  href="{{ url($user->passport->personal_info->personal_image) }}" target="_blank">See Attachment</a>
                                                    @else
                                                        <span>N/A</span>
                                                    @endif

                                                </td>
                                            </tr>

                                        </table>
                                    </div>


                                    <div class="table-responsive modal_table">
                                        <h6>International Details</h6>
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>International Name</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_name) ? $user->passport->personal_info->inter_name : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>International Relation</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_relation) ? $user->passport->personal_info->inter_relation : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>International Address</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_address) ? $user->passport->personal_info->inter_address : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>International Phone</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_phone) ? $user->passport->personal_info->inter_phone : 'N/A' }}</span></td>

                                            </tr>
                                            <tr>
                                                <th>International Whatsapp Number</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_whatsapp_no) ? $user->passport->personal_info->inter_whatsapp_no : 'N/A' }}</span></td>
                                            </tr>

                                            <tr>
                                                <th>International Email Address</th>
                                                <td><span>{{ isset($user->passport->personal_info->inter_email) ? $user->passport->personal_info->inter_email : 'N/A' }}</span></td>
                                            </tr>


                                        </table>
                                    </div>


                                </div>




                            </div>




                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                        </div>

                    </div>
                </div>
            </div>

            {{--    view Detail passport modal end--}}




            <div class="separator-breadcrumb border-top"></div>
            <div class="card user-profile o-hidden mb-4">
                <div class="header-cover" style="background-image: url('{{ asset('assets/images/photo-wide-4.png') }}')"></div>
                <div class="user-info"><img class="profile-picture avatar-lg mb-2" src="{{ $user->image ? url($user->image) : asset('assets/images/user_avatar.jpg') }}" alt="" />
                    <p class="m-0 text-24">{{ $user->passport->personal_info->full_name }}</p>
                    <p class="text-muted m-0">Rider</p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Overview</a></li>
                        <li class="nav-item"><a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="false">Attachments</a></li>
{{--                        <li class="nav-item"><a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos" aria-selected="false">Photos</a></li>--}}
                    </ul>
                    <div class="tab-content" id="profileTabContent">
                        <div class="tab-pane fade active show" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-badge"><i class="badge-icon bg-primary text-white i-Cloud-Picture"></i></div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Passport Detail</strong></div>


{{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Passport #</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Expiry Date</th>
                                                        <th scope="col">Nationality</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">{{ $user->passport->passport_no }}</th>
                                                        <td>{{ $user->passport->personal_info->full_name }}</td>
                                                        <?php $abc = explode(' ',$user->passport->date_expiry); ?>
                                                        <td>{{ $abc[0] }}</td>
                                                        <td>{{ $user->passport->nation->name }}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-icon m-1" id="passport_detail" type="button">
                                                                <span class="ul-btn__icon"><i class="i-Magnifi-Glass-"></i></span>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Personal Information</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Whats App</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Address</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">{{ $user->contact_no }}</th>
                                                        <td>{{ $user->whatsapp }}</td>
                                                        <td>{{ $user->user->email }}</td>
                                                        <td>{{ $user->address }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Working Status</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Remakrs</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Labour Card</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Remakrs</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Visa Detail</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Visa Company</th>
                                                        <th scope="col">Visa Expire Date</th>
                                                        <th scope="col">Visa Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">COD Detail</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Visa Company</th>
                                                        <th scope="col">Visa Expire Date</th>
                                                        <th scope="col">Visa Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">penalty Detail</strong></div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Reason</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>




                                    @if(!empty($verified))
                                    <div class="timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Verification Form</strong></div>
                                            <div class="table-responsive" id="verify_order_responsive">
                                                <table class="table table-bordered " >

                                                    <tr style="border-top: 1px solid #DEE1E6;">
                                                        <th>PlatForm Name</th>
                                                        <td>{{ (isset($verified->platform_id)) ? $verified->platform->name : '' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>PlatFrom Code</th>
                                                        <td>{{ $verified->platform_code }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Sim Card Number</th>
                                                        <td>{{ $verified->simcard_no }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Plate Number</th>
                                                        <td>{{ $verified->plate_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>status</th>
                                                        <td>{{ 'Verified' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bike Picture</th>
                                                        <td>
                                                            <a id="bike_pic_html" href="{{ url($verified->bike_pic) }}" target="_blank">See Image</a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Mulkiya Front Picture</th>
                                                        <td>
                                                            <a id="mulkiya_front_pic_html" href="{{ url($verified->mulkiya_pic) }}" target="_blank">See Image</a>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Mulkiya Back Picture</th>
                                                        <td>
                                                            <a id="mulkiya_back_pic_html" href="{{ url($verified->mulkiya_back) }}" target="_blank">See Image</a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Emirates Id Front Picture</th>
                                                        <td>
                                                            <a id="emirate_front_pic_html"  href="{{ url($verified->emirates_pic) }}" target="_blank">See Image</a>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Emirates Id Back Picture</th>
                                                        <td>
                                                            <a id="emirate_back_pic_html" href="{{ url($verified->emirates_id_back)  }}" target="_blank">See Image</a>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Selfie Pic</th>
                                                        <td>
                                                            <a id="selfie_pic_html" href="{{ url($verified->selfie_pic) }}" target="_blank">See Image</a>
                                                            <span id="selfie_pic_html_not_found_html"></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Verified By</th>
                                                        <td>
                                                            {{ $verified->status_change_by->name }}
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </li>
                                <li class="timeline-item">
                                    <div class="timeline-badge"><img class="badge-img" src="{{ $user->image ? url($user->image) : asset('assets/images/user_avatar.jpg') }}" alt="" /></div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Bike Assign Detail</strong></div>

                                            {{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Plat #</th>
                                                        <th scope="col">Checkin</th>
                                                        <th scope="col">Check out</th>
                                                        <th scope="col">Remarks</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bike_assign as $assign)
                                                    <tr>
                                                        <th>{{ $assign->bike_plate_number->plate_no }}</th>
                                                        <td>{{ $assign->checkin }}</td>
                                                        <td>{{ $assign->checkout ? $assign->checkout : 'Checked In'  }}</td>
                                                        <td>{{ $assign->remarks }}</td>
                                                    </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class=" timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">Sim Assign Detail</strong></div>

                                            {{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Sim #</th>
                                                        <th scope="col">Checkin</th>
                                                        <th scope="col">Check out</th>
                                                        <th scope="col">Remarks</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bike_sim as $assign)
                                                        <tr>
                                                            <th>{{ $assign->telecome->account_number }}</th>
                                                            <td>{{ $assign->checkin }}</td>
                                                            <td>{{ $assign->checkout ? $assign->checkout : 'Checked In'  }}</td>
                                                            <td>{{ $assign->remarks }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class=" timeline-card card margin-top">
                                        <div class="card-body">
                                            <div class="mb-1"><strong class="mr-1">PlatForm Assign Detail</strong></div>
{{--                                            <img class="rounded mb-2" src="{{ asset('assets/dist-assets/images/photo-wide-1.jpg') }}" alt="" />--}}
                                            {{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">PlatForm</th>
                                                        <th scope="col">Checkin</th>
                                                        <th scope="col">Check out</th>
                                                        <th scope="col">Remarks</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($platform_assign as $assign)
                                                        <tr>
                                                            <th>{{ $assign->plateformdetail->name }}</th>
                                                            <td>{{ $assign->checkin }}</td>
                                                            <td>{{ $assign->checkout ? $assign->checkout : 'Checked In'  }}</td>
                                                            <td>{{ $assign->remarks }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </li>
                            </ul>
{{--                            <ul class="timeline clearfix">--}}
{{--                                <li class="timeline-line"></li>--}}
{{--                                <li class="timeline-group text-center">--}}
{{--                                    <button class="btn btn-icon-text btn-primary"><i class="i-Calendar-4"></i> 2018</button>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                            <ul class="timeline clearfix">--}}
{{--                                <li class="timeline-line"></li>--}}
{{--                                <li class="timeline-item">--}}
{{--                                    <div class="timeline-badge"><i class="badge-icon bg-danger text-white i-Love-User"></i></div>--}}
{{--                                    <div class="timeline-card card">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <div class="mb-1"><strong class="mr-1">New followers</strong>--}}
{{--                                                <p class="text-muted">2 days ago</p>--}}
{{--                                            </div>--}}
{{--                                            <p><a href="#">Henry krick</a> and 16 others followed you</p>--}}
{{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <input class="form-control" type="text" placeholder="Write comment" aria-label="comment" />--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                    <button class="btn btn-primary" id="button-comment3" type="button">Submit</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="timeline-item">--}}
{{--                                    <div class="timeline-badge"><i class="badge-icon bg-primary text-white i-Cloud-Picture"></i></div>--}}
{{--                                    <div class="timeline-card card">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <div class="mb-1"><strong class="mr-1">Timothy Carlson</strong> added a new photo--}}
{{--                                                <p class="text-muted">2 days ago</p>--}}
{{--                                            </div><img class="rounded mb-2" src="../../dist-assets/images/photo-wide-2.jpg" alt="" />--}}
{{--                                            <div class="mb-3"><a class="mr-1" href="#">Like</a><a href="#">Comment</a></div>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <input class="form-control" type="text" placeholder="Write comment" aria-label="comment" />--}}
{{--                                                <div class="input-group-append">--}}
{{--                                                    <button class="btn btn-primary" id="button-comment4" type="button">Submit</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                            <ul class="timeline clearfix">--}}
{{--                                <li class="timeline-line"></li>--}}
{{--                                <li class="timeline-group text-center">--}}
{{--                                    <button class="btn btn-icon-text btn-warning"><i class="i-Calendar-4"></i> Joined--}}
{{--                                        in 2013--}}
{{--                                    </button>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
                        </div>
                        <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">


                                <table class="table" id="datatable">
                                    <thead class="hide_cls">
                                    <tr>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                            @foreach($admin_tickets as $ticket)
                                <tr>
                                    <td>
                            <div class="card mb-4">
                                <div class="card-header"># {{ $ticket->ticket_id }}</div>
                                <div class="card-body">
                                    <p class="text-primary mb-1"><i class="i-Mail-Open text-16 mr-1"></i>Message
                                    <p class="card-text">{{ $ticket->message }}</p>
                                    <p class="text-primary mb-1"><i class="i-CMYK text-16 mr-1"></i>Raised For
                                    <p class="card-text">{{isset($ticket->department->name)?$ticket->department->name:""}}</p>
                                    <p class="text-primary mb-1"><i class="i-Calendar-3 text-16 mr-1"></i>Created At
                                    <p class="card-text">{{ $ticket->created_at }}</p>
                                    <p class="text-primary mb-1"><i class="i-Medal-2 text-16 mr-1"></i>Status
                                    <p class="card-text">
                                        <?php if($ticket->is_checked=="0"){ echo "Pending"; }
                                        elseif($ticket->is_checked=="1"){
                                            echo "Closed";
                                        }elseif($ticket->is_checked=="1"){
                                            echo "Process";
                                        }elseif($ticket->is_checked=="3"){
                                            echo "Rejected";
                                        } ?>
                                    </p>
                                </div>
                            </div>
                                    </td>
                                </tr>
                            @endforeach
                                </tbody>
                                </table>

                        </div>
                        <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <div class="search-bar">
                                        <input type="text" placeholder="Search" id="search_input" data-search>
                                        <i class="search-icon text-muted i-Magnifi-Glass1"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row items">

                                @if(!empty($user->passport->passport_pic))
                                <div class="col-md-3 mix" >
                                    <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->passport_pic) }}" alt="" />
                                        <div class="card-body">
                                            <h5 class="card-title text-left title" >Passport Picture</h5>
                                            <a class="card-link" href="{{ url($user->passport->passport_pic) }}" target="_blank">See Full Image</a>
                                            <a   href="{{ url($user->passport->passport_pic) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                        </div>
                                    </div>
                                </div>
                               @endif

                                    @if(!empty($user->passport->attach->attachment_name) && isset($user->passport->attachment_type->name))
                                        <div class="col-md-3 mix" >
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->attach->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title" >{{ $user->passport->attachment_type->name }} Picture</h5>
                                                    <a class="card-link" href="{{ url($user->passport->attach->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->attach->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->personal_info->personal_image))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->personal_info->personal_image) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Personal Picture</h5>
                                                    <a class="card-link" href="{{ url($user->passport->personal_info->personal_image) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->personal_info->personal_image) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    @if(!empty($user->passport->offer->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->offer->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Offer Letter Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->offer->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->offer->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->offer_letter_submission->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Offer Letter Submission</h5>
                                                    <a class="card-link" href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->offer_letter_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->elect_pre_approval->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Electronic Pre Approval</h5>
                                                    <a class="card-link" href="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->elect_pre_approval->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->elect_pre_approval_payment->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Electronic Pre Approval Payment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->elect_pre_approval_payment->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->print_visa_inside_outside->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Print Visa Inside/Outside</h5>
                                                    <a class="card-link" href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->print_visa_inside_outside->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->status_change->attachment->attachment_name))
                                        <div class="col-md-3 mix ">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->status_change->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Status Change Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->status_change->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->status_change->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->status_change->proof))
                                        <div class="col-md-3 mix" >
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->status_change->proof) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title ">Status Change Proof</h5>
                                                    <a class="card-link" href="{{ url($user->passport->status_change->proof) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->status_change->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->entry_date->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->entry_date->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Entry Date</h5>
                                                    <a class="card-link" href="{{ url($user->passport->entry_date->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->entry_date->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->medical_twnenty_four->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Medical 24 Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->medical_twnenty_four->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->medical_fourty_eight->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Medical 48 Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->medical_fourty_eight->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->medical_vip->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_vip->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Medical VIP Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->medical_vip->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->medical_normal->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->medical_normal->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Medical Normal Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->medical_normal->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->fit_unfit->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">FIT UnFit Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->fit_unfit->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->emitres_id_apply->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Emirates Id Apply Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->emitres_id_apply->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->contract_typing->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->contract_typing->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">New Contract Application Typing Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->contract_typing->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    @if(!empty($user->passport->contract_typing->proof))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->contract_typing->proof) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">New Contract Application Typing Proof</h5>
                                                    <a class="card-link" href="{{ url($user->passport->contract_typing->proof) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->contract_typing->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->new_contract_submission->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">New Contract Submission Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->new_contract_submission->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->labour_card_print->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Labour Card Print Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->labour_card_print->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->visa_stamping->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Visa Stamping Application Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->visa_stamping->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->visa_stamping->proof))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_stamping->proof) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Visa Stamping Application Proof</h5>
                                                    <a class="card-link" href="{{ url($user->passport->visa_stamping->proof) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->visa_stamping->proof) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->visa_pasted->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Visa Pasted Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->visa_pasted->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($user->passport->emirated_id_received->attachment->attachment_name))
                                        <div class="col-md-3 mix">
                                            <div class="card mb-4 o-hidden"><img  style="height: 202px;" class="card-img-top" src="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title text-left title">Unique Emirates ID Received Attachment</h5>
                                                    <a class="card-link" href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}" target="_blank">See Full Image</a>
                                                    <a   href="{{ url($user->passport->emirated_id_received->attachment->attachment_name) }}"  download class="btn btn-info btn-icon m-1 text-right download_btn" type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif







































                            </div>
                        </div>
                        <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/headphone-1.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/headphone-2.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/headphone-3.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/iphone-1.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/iphone-2.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3"><img class="card-img" src="../../dist-assets/images/products/watch-1.jpg" alt="" />
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex"><span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i> 12</span><span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span></div>
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
            'use strict';

            $('#datatable').DataTable( {
                // "aaSorting": [[0, 'desc']],
                "pageLength": 10,



                //
            });


        });
    </script>



    <script>


            $("#search_input").keyup(function() {

// Retrieve the input field text and reset the count to zero
                var filter = $(this).val(),
                    count = 0;

// Loop through the comment list
                $('.items div').each(function() {


                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).hide('slow');  // MY CHANGE

                        // Show the list item if the phrase matches and increase the count by 1
                    } else {
                        $(this).show('slow'); // MY CHANGE
                        count++;
                    }

                });

            });
  </script>
                <script>
                    $("#passport_detail").click(function(){

                        $("#passport_detail_modal").modal('show');
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
