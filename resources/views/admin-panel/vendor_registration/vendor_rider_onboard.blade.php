@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

.overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }

    tr {
            white-space: nowrap;
            font-size: 12px;
        }
        #datatable .table th, .table td{
        border-top : unset !important;
    }
    /* .table th, .table td{
        padding: 0px !important;
    } */
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    .table td{
        padding: 6px;
        font-size: 12px;
        height: 20px;
        width: 20px;
        text-align: center;
        vertical-align: middle;
    }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Vendors</li>
            <li>Status</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">New Requests ({{count($vendor_new)}})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Accepted Requests({{count($vendor_accept)}})</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" aria-selected="false">Rejected Requests( {{count($vendor_reject)}} )</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-reapply-tab" data-toggle="tab" href="#zdsReapply" role="tab" aria-controls="zdsReapply" aria-selected="false">Reapplied Requests( {{count($vendor_reapply)}} )</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-rejoin-tab" data-toggle="tab" href="#zdsRejoin" role="tab" aria-controls="zdsRejoin" aria-selected="false">Rejoin Requests( {{count($vendor_rejoin)}} )</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <h2>New 4PL Riders</h2>
                        <table class="display table table-striped table-bordered" id="datatable1" style="width: 100%" >
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Date & Time Applied</th>
                                <th scope="col">Applying For</th>
                                <th scope="col">Rider First Name</th>
                                <th scope="col">Rider Last Name</th>
                                <th scope="col">Contact Official</th>
                                <th scope="col">Contact Personal</th>
                                <th scope="col">Contact Email</th>
                                <th scope="col">4 PL Name</th>
                                <th scope="col">4 PL Code</th>
                                <th scope="col">Emirates ID No</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Driving License Number</th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Bate Of Birth</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Covid-19 Vaccine</th>
                                <th scope="col">Previous Company</th>
                                <th scope="col">Previous Platform</th>
                                <th scope="col">Previous Rider ID</th>
                                <th scope="col">Passport Copy</th>
                                <th scope="col">Visa Copy</th>
                                <th scope="col">Emirates ID Front Side </th>
                                <th scope="col">Emirates ID Back End</th>
                                <th scope="col">Driving Lincense Front End</th>
                                <th scope="col">Driving Lincense Back End</th>
                                <th scope="col">Mulkiya Front End</th>
                                <th scope="col">Mulkiya Back End</th>
                                <th scope="col">Health Insurance Card Copy</th>
                                <th scope="col">Rider Photo</th>
                                <th scope="col">Vaccination card</th>
                                <th scope="col">Box Installation pic</th>


                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vendor_new as $row)
                                <tr>
                                    <td>{{$row->created_at}} </td>
                                    <td>
                                         @if (isset($row->applying_for) && $row->applying_for=='1')
                                        <span class="badge badge-primary m-2">Bike</span>
                                        @elseif(isset($row->applying_for) && $row->applying_for=='2')
                                        <span class="badge badge-success m-2">Car</span>
                                        @elseif(isset($row->applying_for) && $row->applying_for=='3')
                                        <span class="badge badge-info m-2">Both</span>

                                        @endif
                                </td>
                                    <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
                                    <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
                                    <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
                                    <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
                                    <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
                                    <td> {{ $row->vendor ? $row->vendor->name: $row->four_pl_name }}</td>
                                    <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
                                    <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
                                    <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                                    <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

                                    <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
                                    <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
                                    <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
                                    <td> {{isset($row->city)?$row->city:"N/A"}}</td>
                                    <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                                    <td>
                                        @if (isset($row->vaccine) && $row->vaccine=='1')
                                        <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
                                        @elseif(isset($row->vaccine) && $row->vaccine=='2')
                                        <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
                                        @elseif(isset($row->vaccine) && $row->vaccine=='3')
                                        <a class="badge badge-danger m-2" href="#">Not Yet</a>
                                        @else
                                                N/A
                                        @endif
                                        </td>

                                        <td> {{$row->previous_company?$row->previous_company:"N/A"}}</td>
                                        <td> {{$row->previous_platform?$row->previous_platform:"N/A"}}</td>
                                        <td> {{$row->previous_rider_id?$row->previous_rider_id:"N/A"}}</td>

                                    <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->vaccination_card ? Storage::temporaryUrl($row->vaccination_card, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Vaccination Card</strong></a></td>
                                    <td>  <a class="attachment_display" href="{{ $row->box_pic ? Storage::temporaryUrl($row->box_pic, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Box installation Pic</strong></a></td>
                                    <td>

                                        @if(isset($row->passport_detail))
                                            @if($row->passport_detail->cancel_status=="1")
                                            <button class="btn btn-success ven-btn"  onclick="vendor_req_accept_rejoin({{$row->id}})" type="button">Accept</button>
                                            @else
                                            <button class="btn btn-success ven-btn" data-toggle="modal" data-target=".register_modal" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
                                            @endif

                                        @else
                                        <button class="btn btn-success ven-btn" data-toggle="modal" data-target=".register_modal" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
                                        @endif

                                        <button class="btn btn-danger ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>


                    </div>

                    {{--                    tab2--}}
                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                        <h2>Accepted PL</h2>
                        <table class="display table table-striped table-bordered" id="datatable3" style="width: 100%" >
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Date & Time Applied</th>
                                    <th scope="col">Applying For</th>
                                    <th scope="col">Rider First Name</th>
                                    <th scope="col">Rider Last Name</th>
                                    <th scope="col">Contact Official</th>
                                    <th scope="col">Contact Personal</th>
                                    <th scope="col">Contact Email</th>
                                    <th scope="col">4 PL Name</th>
                                    <th scope="col">4 PL Code</th>
                                    <th scope="col">Emirates ID No</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Driving License Number</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Bate Of Birth</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Covid-19 Vaccine</th>
                                    <th scope="col">Passport Copy</th>
                                    <th scope="col">Visa Copy</th>
                                    <th scope="col">Emirates ID Front Side </th>
                                    <th scope="col">Emirates ID Back End</th>
                                    <th scope="col">Driving Lincense Front End</th>
                                    <th scope="col">Driving Lincense Back End</th>
                                    <th scope="col">Mulkiya Front End</th>
                                    <th scope="col">Mulkiya Back End</th>
                                    <th scope="col">Health Insurance Card Copy</th>
                                    <th scope="col">Rider Photo</th>
                                    <th scope="col">Vaccination card</th>
                                    <th scope="col">Box Installation pic</th>
                                    <th scope="col">Action</th>

                                    {{-- <th scope="col">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>


                    </div>

                    {{--                    tab3--}}
                    <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab" >


                        <h2>Rejected 4PL</h2>
                        <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%" >
                            <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Date & Time Applied</th>
                                    <th scope="col">Applying For</th>
                                    <th scope="col">Rider First Name</th>
                                    <th scope="col">Rider Last Name</th>
                                    <th scope="col">Contact Official</th>
                                    <th scope="col">Contact Personal</th>
                                    <th scope="col">Contact Email</th>
                                    <th scope="col">4 PL Name</th>
                                    <th scope="col">4 PL Code</th>
                                    <th scope="col">Emirates ID No</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Driving License Number</th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Bate Of Birth</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Covid-19 Vaccine</th>
                                    <th scope="col">Passport Copy</th>
                                    <th scope="col">Visa Copy</th>
                                    <th scope="col">Emirates ID Front Side </th>
                                    <th scope="col">Emirates ID Back End</th>
                                    <th scope="col">Driving Lincense Front End</th>
                                    <th scope="col">Driving Lincense Back End</th>
                                    <th scope="col">Mulkiya Front End</th>
                                    <th scope="col">Mulkiya Back End</th>
                                    <th scope="col">Health Insurance Card Copy</th>
                                    <th scope="col">Rider Photo</th>

                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    {{-- Reapplied --}}
                    <div class="tab-pane fade show" id="zdsReapply" role="tabpanel" aria-labelledby="zds-reapply-tab">

                        <h2>reapplied 4PL Riders</h2>
                        <table class="display table table-striped table-bordered" id="datatableReapply" style="width: 100%" >
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Date & Time Applied</th>
                                <th scope="col">Applying For</th>
                                <th scope="col">Rider First Name</th>
                                <th scope="col">Rider Last Name</th>
                                <th scope="col">Contact Official</th>
                                <th scope="col">Contact Personal</th>
                                <th scope="col">Contact Email</th>
                                <th scope="col">4 PL Name</th>
                                <th scope="col">4 PL Code</th>
                                <th scope="col">Emirates ID No</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Driving License Number</th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Bate Of Birth</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Covid-19 Vaccine</th>
                                <th scope="col">Passport Copy</th>
                                <th scope="col">Visa Copy</th>
                                <th scope="col">Emirates ID Front Side </th>
                                <th scope="col">Emirates ID Back End</th>
                                <th scope="col">Driving Lincense Front End</th>
                                <th scope="col">Driving Lincense Back End</th>
                                <th scope="col">Mulkiya Front End</th>
                                <th scope="col">Mulkiya Back End</th>
                                <th scope="col">Health Insurance Card Copy</th>
                                <th scope="col">Rider Photo</th>


                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>



                            </tbody>
                        </table>


                    </div>

                    {{-- Rejoin --}}
                    <div class="tab-pane fade show" id="zdsRejoin" role="tabpanel" aria-labelledby="zds-rejoin-tab">

                        <h2>rejoin 4PL Riders</h2>
                        <table class="display table table-striped table-bordered" id="datatableRejoin" style="width: 100%" >
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Date & Time Applied</th>
                                <th scope="col">Applying For</th>
                                <th scope="col">Rider First Name</th>
                                <th scope="col">Rider Last Name</th>
                                <th scope="col">Contact Official</th>
                                <th scope="col">Contact Personal</th>
                                <th scope="col">Contact Email</th>
                                <th scope="col">4 PL Name</th>
                                <th scope="col">4 PL Code</th>
                                <th scope="col">Emirates ID No</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Driving License Number</th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Bate Of Birth</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Covid-19 Vaccine</th>
                                <th scope="col">Passport Copy</th>
                                <th scope="col">Visa Copy</th>
                                <th scope="col">Emirates ID Front Side </th>
                                <th scope="col">Emirates ID Back End</th>
                                <th scope="col">Driving Lincense Front End</th>
                                <th scope="col">Driving Lincense Back End</th>
                                <th scope="col">Mulkiya Front End</th>
                                <th scope="col">Mulkiya Back End</th>
                                <th scope="col">Health Insurance Card Copy</th>
                                <th scope="col">Rider Photo</th>


                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>



                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        </div>
    </div>




    <div class="modal fade bd-example-modal-sm register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Vendor Request Accept</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Are You Sure Want To Accept The  Vendor Request</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success ml-2" type="submit" onclick="accept_vendor()">Accept</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-md rejion_modal" id="rejion_modal" tabindex="-1" role="dialog" aria-labelledby="rejon_modal-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="rejoin_modal_append">


            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('vendor_onboard_reject') }}" id="updateForm-1" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Vendor Request Rejection</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <label for="repair_category">Remarks</label>
                        <input type="hidden" name="vendor_id" value="" id="vendorId">
                        <input type="text" class="form-control" required name="remarks" >
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-sm-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">

        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm-2" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-2">Vendor Request Move To Pending</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Are You Sure Want To Move Vendor Request To Pending?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" onclick="pending_vendor()" type="submit" >Move To Pending</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            // $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {


                var currentTab = $(e.target).attr('id'); // get current tab


                if(currentTab=="home-basic-tab"){
                    make_table("datatable1","0");
                    var table = $('#datatable1').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }else if(currentTab=="profile-basic-tab"){
                    make_table("datatable3","1");
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(currentTab=="zds-basic-tab"){
                    make_table("datatable4","2");
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(currentTab=="zds-reapply-tab"){
                    make_table("datatableReapply","3");
                    var table = $('#datatableReapply').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(currentTab=="zds-rejoin-tab"){
                    make_table("datatableRejoin","4");
                    var table = $('#datatableRejoin').DataTable();
                    $('#container').css( 'display', 'block');
                    table.columns.adjust().draw();
                }
            });
        });
    </script>

<script>
    function make_table(table_name,status,plat_id="") {


        $.ajax({
            url: "{{ route('vendor_onboard_accept_recject') }}",
            method: 'GET',
            data: {request_type:status},
            success: function(response) {

                $('#'+table_name+' tbody').empty();

                var table = $('#'+table_name).DataTable();
                table.destroy();
                $('#'+table_name+' tbody').html(response.html);
                var table = $('#'+table_name).DataTable(
                    {
                        // "aaSorting": [],
                        "order": [[ 0, "desc" ]], //or asc
                        "columnDefs" : [{"targets":0, "type":"date-eu"}],
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                        ],
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
                        "sScrollX": "100%",
                        "scrollX": true
                    }
                );
                $(".display").css("width","100%");
                $('#'+table_name+' tbody').css("width","100%");
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
        });
    }
</script>

    <script>
        function vendor_req_accept(id)
        {
            var id = id;

            var url = '{{ route('vendor_onboard_accept', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);


        }

        function vendor_req_accept_rejoin(id)
        {
            var id = id;

            var url = '{{ route('vendor_onboard_accept', ":id") }}';
            url = url.replace(':id', id);


        $.ajax({
            url: "{{ route('cancellation_ppuid_ajax') }}",
            method: 'GET',
            data: {primary_id:id},
            success: function(response) {

                $("#rejoin_modal_append").html(response.html);

                $(".rejion_modal").modal("show");


            }
        });

            $("#updateForm").attr('action', url);

        }



        function accept_vendor()
        {
            $("#updateForm").submit();

        }

        function accept_vendor_rejoin()
        {
            $("#updateForm").submit();

        }

    </script>


    <script>
        function vendor_req_reject(id)
        {
            var id = id;
            var url = '{{ route('vendor_onboard_reject', ":id") }}';
            url = url.replace(':id', id);
            $("#updateForm-1").attr('action', url);

            $('#vendorId').val(id);

        }
        function reject_vendor()
        {
            $("#updateForm-1").submit();
        }
    </script>
    <script>
        function vendor_req_pending(id)
        {
            var id = id;


            var url = '{{ route('vendor_onboard_pending', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm-2").attr('action', url);
        }

        function pending_vendor()
        {
            $("#updateForm-2").submit();

        }
    </script>
    <script>
        $(document).ready(function () {
            'use strict';



            $('#datatable1').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                columnDefs: [{ 'targets': [0], type: 'date' }],
                // order: [2, 'asc'],

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
                fixedColumns:{
                    leftColumns: 7,
                },
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



@endsection
