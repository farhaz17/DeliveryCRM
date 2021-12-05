@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr {
            white-space: nowrap;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Status</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4" style="background: #dedede">
                <div class="card-body">
                    <div class="card-title mb-3">Update Status </div>

{{--                    <form method="post" action="{{isset($ppuid_edit)?route('ppuid_update',$ppuid_edit->id):route('ppuid_store')}}">--}}
{{--                        {!! csrf_field() !!}--}}
{{--                        @if(isset($ppuid_edit))--}}
{{--                            {{ method_field('GET') }}--}}
{{--                        @endif--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">PPUID</label>--}}



{{--                                @if(isset($ppuid_edit))--}}
{{--                                    <input type="hidden" id="ppuid" name="ppuid" value="{{isset($ppuid_edit)?$ppuid_edit->id:""}}">--}}
{{--                                @endif--}}

{{--                                <select id="ppuid" name="ppuid" class="form-control" @if(isset($ppuid_edit)) disabled @else @endif required>--}}
{{--                                    <option value=""  >Select option</option>--}}
{{--                                    @foreach($ppuid as $ppuid)--}}

{{--                                        @php--}}
{{--                                            $isSelected=(isset($ppuid_edit)?$ppuid_edit->passport_id:"")==$ppuid->id;--}}
{{--                                        @endphp--}}

{{--                                        <option value="{{ $ppuid->id }}" {{ $isSelected ? 'selected': '' }}>{{ $ppuid->pp_uid}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                            </div>--}}

{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">Status</label>--}}

{{--                                @if(isset($ppuid_edit))--}}
{{--                                    <input type="hidden" id="issue" name="ppuid_issue_id" value="{{isset($ppuid_edit)?$ppuid_edit->id:""}}">--}}
{{--                                @endif--}}

{{--                                <select id="issue" name="ppuid_issue_id" class="form-control"  required>--}}
{{--                                    <option value=""  >Select option</option>--}}
{{--                                    @foreach($issue as $iss)--}}
{{--                                        @php--}}
{{--                                            $isSelected2=(isset($ppuid_edit)?$ppuid_edit->ppuid_issue_id:"")==$iss->id;--}}
{{--                                        @endphp--}}

{{--                                        <option value="{{ $iss->id }}"  {{ $isSelected2 ? 'selected': '' }} >{{ $iss->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <button class="btn btn-primary">Add</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}



                    <form method="post" enctype="multipart/form-data" action="{{ url('/ppuid') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}

                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input class="custom-file-input" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" />
                                <label class="custom-file-label" for="select_file">Choose file</label>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Upload</button>

                    </form>


                </div>
            </div>
        </div>



    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">MAJOR ID</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">PPUID</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" aria-selected="false">ZDS Code</a></li>
                    <li class="nav-item"><a class="nav-link" id="passport-basic-tab" data-toggle="tab" href="#passportBasic" role="tab" aria-controls="passportBasic" aria-selected="false">Passport Number</a></li>
                    <li class="nav-item"><a class="nav-link" id="name-basic-tab" data-toggle="tab" href="#nameBasic" role="tab" aria-controls="passportBasic" aria-selected="false">Name</a></li>
                     <li class="nav-item"><a class="nav-link" id="platform-basic-tab" data-toggle="tab" href="#platformBasic" role="tab" aria-controls="platformBasic" aria-selected="false">Platform</a></li>
                    <li class="nav-item"><a class="nav-link" id="sim-basic-tab" data-toggle="tab" href="#simBasic" role="tab" aria-controls="simBasic" aria-selected="false">SIM </a></li>
                    <li class="nav-item"><a class="nav-link" id="bike-basic-tab" data-toggle="tab" href="#bikeBasic" role="tab" aria-controls="bikeBasic" aria-selected="false">Bike</a></li>
                    <li class="nav-item"><a class="nav-link" id="all-basic-tab" data-toggle="tab" href="#allBasic" role="tab" aria-controls="allBasic" aria-selected="false">All Matched</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                            <div class="row">

                            <div class="col-md-6 mb-3">
                            <h2>Major ID Not Matched</h2>
                            <table class="display table table-striped table-bordered" id="datatable1" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_missing_id as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                            </div>
                            <div class="col-md-6 mb-3">


                            <h2>Major ID Matched</h2>
                            <table class="display table table-striped table-bordered" id="datatable2" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_exist_id as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                            </div>
                            </div>

                    </div>

{{--                    tab2--}}
                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                            <div class="row">

                            <div class="col-md-6 mb-3">
                            <h2>Missing PPUID</h2>
                            <table class="display table table-striped table-bordered" id="datatable3" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_missing_ppuid as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                            </div>
                                <div class="col-md-6 mb-3">
                                    <h2>Existing PPUID</h2>
                            <table class="display table table-striped table-bordered" id="datatable33" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_exist_ppuid as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>




                        </div>
                            </div>

                    </div>

                    {{--                    tab3--}}
                    <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab">

                            <div class="row">
                             <div class="col-md-6 mb-3">
                            <h2>Missing ZDS Code</h2>
                            <table class="display table table-striped table-bordered" id="datatable4" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_missing_zdscode as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                             </div>
                                <div class="col-md-6 mb-3">

                            <h2>Existing ZDS Code</h2>
                            <table class="display table table-striped table-bordered" id="datatable44" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_exist_zdscode as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                                </div>
                            </div>

                    </div>


                    {{--                    tab4--}}
                    <div class="tab-pane fade show" id="passportBasic" role="tabpanel" aria-labelledby="passport-basic-tab">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                            <h2> Missing Passport Number</h2>
                            <table class="display table table-striped table-bordered" id="datatable5" >
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_missing_passportNum as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                                </div>
                                <div class="col-md-6 mb-3">


                            <h2> Existing Passport Number</h2>
                            <table class="display table table-striped table-bordered" id="datatable55" >
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sheet_exist_passportNum as $x)
                                    <tr>
                                        <td>{{$x->passport_id}}</td>
                                        <td>{{$x->ppuid}}</td>
                                        <td>{{$x->zds_code}}</td>
                                        <td>{{$x->passport_number}}</td>
                                        <td>{{$x->rider_name}}</td>
                                        <td>{{$x->platform}}</td>
                                        <td>{{$x->sim_number}}</td>
                                        <td>{{$x->bike_number}}</td>
                                        <td>{{$x->visa_status}}</td>
                                        <td>{{$x->control_status}}</td>
                                        <td>{{$x->msp_status}}</td>
                                        <td>{{$x->platform_rider_id}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                    </div>


                    {{--                    tab5--}}
                    <div class="tab-pane fade" id="nameBasic" role="tabpanel" aria-labelledby="name-basic-tab">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                            <h2>Missing Rider Name</h2>
                            <table class="display table table-striped table-bordered" id="datatable6" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_missing_riderName as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>
                                </div>

                                    <div class="col-md-6 mb-3">

                            <h2>Existing Rider Name</h2>
                            <table class="display table table-striped table-bordered" id="datatable66" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>

                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_exist_riderName as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                    </div>

                    {{--                    tab6--}}
                    <div class="tab-pane fade" id="platformBasic" role="tabpanel" aria-labelledby="platform--basic-tab">
                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <h2>Missing Platform</h2>

                                <table class="display table table-striped table-bordered" id="datatable7" >
                                    <thead class="thead-dark">
                                    <tr>


                                        <th scope="col">Major ID</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS</th>
                                        <th scope="col">Passport Number</th>
                                        <th scope="col">Rider Name</th>
                                        <th scope="col">Platform</th>
                                        <th scope="col">SIM Number</th>
                                        <th scope="col">Bike</th>
                                        <th scope="col">Visa Status</th>
                                        <th scope="col">Control Status</th>
                                        <th scope="col">MSP Status</th>
                                        <th scope="col">Platform Rider ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($sheet_missing_platform as $x)
                                        <tr>
                                            <td>{{$x->passport_id}}</td>
                                            <td>{{$x->ppuid}}</td>
                                            <td>{{$x->zds_code}}</td>
                                            <td>{{$x->passport_number}}</td>
                                            <td>{{$x->rider_name}}</td>
                                            <td>{{$x->platform}}</td>
                                            <td>{{$x->sim_number}}</td>
                                            <td>{{$x->bike_number}}</td>
                                            <td>{{$x->visa_status}}</td>
                                            <td>{{$x->control_status}}</td>
                                            <td>{{$x->msp_status}}</td>
                                            <td>{{$x->platform_rider_id}}</td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6 mb-3">


                                <h2>Existing Platform</h2>
                                <table class="display table table-striped table-bordered" id="datatable77" >
                                    <thead class="thead-dark">
                                    <tr>


                                        <th scope="col">Major ID</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">ZDS</th>
                                        <th scope="col">Passport Number</th>
                                        <th scope="col">Rider Name</th>
                                        <th scope="col">Platform</th>
                                        <th scope="col">SIM Number</th>
                                        <th scope="col">Bike</th>
                                        <th scope="col">Visa Status</th>
                                        <th scope="col">Control Status</th>
                                        <th scope="col">MSP Status</th>
                                        <th scope="col">Platform Rider ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($sheet_exist_platform as $x)
                                        <tr>
                                            <td>{{$x->passport_id}}</td>
                                            <td>{{$x->ppuid}}</td>
                                            <td>{{$x->zds_code}}</td>
                                            <td>{{$x->passport_number}}</td>
                                            <td>{{$x->rider_name}}</td>
                                            <td>{{$x->platform}}</td>
                                            <td>{{$x->sim_number}}</td>
                                            <td>{{$x->bike_number}}</td>
                                            <td>{{$x->visa_status}}</td>
                                            <td>{{$x->control_status}}</td>
                                            <td>{{$x->msp_status}}</td>
                                            <td>{{$x->platform_rider_id}}</td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>

                    {{--                    tab7--}}
                    <div class="tab-pane fade" id="simBasic" role="tabpanel" aria-labelledby="sim-basic-tab">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                            <h2>Missing SIM</h2>
                            <table class="display table table-striped table-bordered" id="datatable8" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_missing_sims as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>
                                </div>

                                <div class="col-md-6 mb-3">



                                    <h1>Existing SIM</h1>
                            <table class="display table table-striped table-bordered" id="datatable88" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_exist_sims as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>


                        </div>
                    </div>


                    </div>

                    {{--                    tab8--}}
                    <div class="tab-pane fade" id="bikeBasic" role="tabpanel" aria-labelledby="bike-basic-tab">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                            <h2>Missing Bike</h2>
                            <table class="display table table-striped table-bordered" id="datatable9" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_missing_bikes as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>
                                </div>

                                    <div class="col-md-6 mb-3">

                            <h2>Existing Bikes</h2>
                            <table class="display table table-striped table-bordered" id="datatable99" >
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_exist_bikes as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
                                                                    </tr>

                                                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                    </div>

                    {{--                    tab9--}}
                    <div class="tab-pane fade" id="allBasic" role="tabpanel" aria-labelledby="all-basic-tab">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                            <h2>All Matched</h2>
                            <table class="display table table-striped table-bordered" id="datatable10" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>


                                    <th scope="col">Major ID</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">ZDS</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike</th>
                                    <th scope="col">Visa Status</th>
                                    <th scope="col">Control Status</th>
                                    <th scope="col">MSP Status</th>
                                    <th scope="col">Platform Rider ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                                                @foreach($sheet_matched_all as $x)
                                                                    <tr>
                                                                        <td>{{$x->passport_id}}</td>
                                                                        <td>{{$x->ppuid}}</td>
                                                                        <td>{{$x->zds_code}}</td>
                                                                        <td>{{$x->passport_number}}</td>
                                                                        <td>{{$x->rider_name}}</td>
                                                                        <td>{{$x->platform}}</td>
                                                                        <td>{{$x->sim_number}}</td>
                                                                        <td>{{$x->bike_number}}</td>
                                                                        <td>{{$x->visa_status}}</td>
                                                                        <td>{{$x->control_status}}</td>
                                                                        <td>{{$x->msp_status}}</td>
                                                                        <td>{{$x->platform_rider_id}}</td>
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


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#ppuid').select2({
                placeholder: 'Select an option'
            });
            $('#issue').select2({
                placeholder: 'Select an option'
            });

            $('#datatable1,#datatable2,#datatable3,#datatable33,#datatable4,datatable44,#datatable6,#datatable66,#datatable5,#datatable7,#datatable77,#datatable8,#datatable88,#datatable9,#datatable99,#datatable10,#datatable55').DataTable( {
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

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable1').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable33').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable44').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="passport-basic-tab"){
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable55').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="name-basic-tab"){
                    var table = $('#datatable6').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable66').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
                else if(split_ab=="platform-basic-tab"){
                    var table = $('#datatable7').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable77').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="sim-basic-tab"){
                    var table = $('#datatable8').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable88').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="bike-basic-tab"){
                    var table = $('#datatable9').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable99').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }



                else{
                    var table = $('#datatable10').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
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
