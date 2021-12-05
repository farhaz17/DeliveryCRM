
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        button.btn.btn-primary.save-btn {
            margin-top: 24px;
        }
        .license_heading{
            margin-top: -43px;
        }
        .hide_cls{
            display: none;
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
                    <div class="card-title mb-3">Personal Detail</div>

                    <form method="post" action="{{ route('career.update',$career->id) }}">
                        {!! csrf_field() !!}

                            {{ method_field('PUT') }}

                        <input type="hidden" id="id" name="id"  value="{{isset($userData)?$userData->id:""}}">
                        <div class="row">

                            <div class="col-md-6 form-group mb-3">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Name</label>
                                        <input class="form-control form-control-rounded" id="name" name="name" value="{{ $career->name }}" type="text" required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Email</label>
                                        <input class="form-control form-control-rounded" id="email" name="email" value="{{ $career->email }}" type="text"  required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Phone</label>
                                        <input class="form-control form-control-rounded" id="phone" name="phone" value="{{ $career->phone }}" type="text"  required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Date Of Birth</label>
                                        <input class="form-control form-control-rounded" id="dob" name="dob" value="{{ $career->dob }}" type="text"   />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Whats App</label>
                                        <input class="form-control form-control-rounded" id="whatsapp" name="whatsapp" value="{{ $career->whatsapp }}" type="text" required />
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Facebook</label>
                                        <input class="form-control form-control-rounded" id="facebook" name="facebook" value="{{ $career->facebook }}" type="text"  />
                                    </div>

                                    <div class="col-md-3 form-group mb-3">
                                        <label for="repair_category">year Experience</label>
                                        <select class="form-control" name="experience" id="experience" >
                                            <option value="" selected disabled>select year please</option>
                                            <option value="1" {{ ($career->experience=="1") ? 'selected' : ''   }}>1 year</option>
                                            <option value="2" {{ ($career->experience=="2") ? 'selected' : ''   }}>2 year</option>
                                            <option value="3" {{ ($career->experience=="3") ? 'selected' : ''   }}>3 year</option>
                                            <option value="4" {{ ($career->experience=="4") ? 'selected' : ''   }}>4 year</option>
                                            <option value="5" {{ ($career->experience=="5") ? 'selected' : ''   }}>5 year</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 form-group mb-3">
                                        <label for="repair_category">Month Experience</label>
                                        <select class="form-control" name="exp_month" id="exp_month" >
                                            <option value="" selected disabled>select month please</option>
                                            @foreach($exp_months as $month)
                                                <option value="1" {{ ($month->id==$career->experience_month) ? 'selected' : ''   }}>{{ $month->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="repair_category">Applying For</label>




                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-success">
                                                    <input type="radio" {{ ($career->vehicle_type=="1") ? 'checked' : '' }}  name="apply_for" value="1" ><span>Bike</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-success">
                                                    <input type="radio" {{ ($career->vehicle_type=="2") ? 'checked' : '' }}  name="apply_for" value="2"  ><span>Car</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-success">
                                                    <input type="radio" type="radio" {{ ($career->vehicle_type=="3") ? 'checked' : '' }}  name="apply_for" value="3"  ><span>Both</span><span class="checkmark"></span>
                                                </label>
                                            </div>


                                    </div>

                                    <div class="col-md-6 form-group mb-5">
                                        <label for="repair_category">CV Attached</label>
                                        <br>
                                        @if(!empty($career->cv))
                                            <a href="{{ url($career->cv) }}" target="_blank" >Attachment</a>
                                        @else
                                            <h5>Not Found</h5>
                                        @endif


                                    </div>

                                </div>


                                <div class="card-title mb-3">Passport Details</div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Nationality</label>
                                        <input class="form-control form-control-rounded" id="nationality" name="nationality" value="{{ $career->nationality   }}" type="text" required />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Passport Number</label>
                                        <input class="form-control form-control-rounded" id="passport_no" name="passport_no" value="{{ $career->passport_no   }}" type="text"  required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Passport Expiry</label>
                                        <input class="form-control form-control-rounded" id="passport_expiry" name="passport_expiry" value="{{ $career->passport_expiry   }}" type="text"  />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Passport Attached</label>
                                        <br>
                                        @if(!empty($career->passport_attach))
                                            <a href="{{ url($career->passport_attach) }}" target="_blank" >Attachment</a>
                                        @else
                                            <h5>Not Found</h5>
                                            @endif
                                    </div>

                                </div>



                            </div>



                            <div class="col-md-6 form-group mb-3" >
                                <div class="card-title mb-3  license_heading">License Detail</div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">License Status</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->licence_status=="1") ? 'checked' : '' }} class="license_status_cls"  value="1" name="license_status"><span>Yes</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_status_cls" {{ ($career->licence_status=="2") ? 'checked' : '' }} value="2" name="license_status"><span>No</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3  {{  ($career->licence_status=="2") ? 'hide_cls' :''  }} driving_licence_div_cls" >

                                        <label for="repair_category">Which License you Have.?</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->licence_status_vehicle=="1") ? 'checked' : '' }}  name="license_type" class="license_status_cls"  value="1" ><span>Bike</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->licence_status_vehicle=="2") ? 'checked' : '' }}  name="license_type" value="2" class="license_status_cls"  ><span>Car</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->licence_status_vehicle=="3") ? 'checked' : '' }}  name="license_type" value="3"  ><span>Both</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="row  {{  ($career->licence_status=="2") ? 'hide_cls' :''  }} driving_licence_div_cls">

                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">Licence issue Date</label>
                                        <input class="form-control form-control-rounded" id="licence_issue_date" name="licence_issue_date" value="{{ $career->licence_issue }}" type="text"  />
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">Licence number</label>
                                        <input class="form-control form-control-rounded" id="licence_no" name="licence_no" value="{{ $career->licence_no }}" type="text"   />
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">Traffic number</label>
                                        <input class="form-control form-control-rounded" id="traffic_no" name="traffic_no" value="{{ $career->traffic_file_no }}" type="text"   />
                                    </div>


                                </div>

                                <div class="row   {{  ($career->licence_status=="2") ? 'hide_cls' :''  }} driving_licence_div_cls ">
                                    <div class="col-md-12 mb-3">
                                        <label for="repair_category">Licence Expiry</label>
                                        <input class="form-control form-control-rounded" id="licence_expiry_date" name="licence_expiry_date" value="{{ $career->licence_expiry }}" type="text"   />
                                    </div>
                                </div>

                                <div class="row  {{  ($career->licence_status=="2") ? 'hide_cls' :''  }} driving_licence_div_cls">
                                    <div class="col-md-12 mb-5">
                                        <label for="repair_category">Licence Attached</label>
                                        <br>
                                        @if(!empty($career->licence_attach))
                                            <a href="{{ url($career->licence_attach) }}" target="_blank" >Attachment</a>
                                        @else
                                            <h5>Not Found</h5>
                                        @endif

                                    </div>
                                </div>



                                <div class="card-title mb-3">Visa Detail</div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Visa Status</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->visa_status=="1") ? 'checked' : '' }} class="license_type_cls"  value="1" name="visa_status"><span>Visit Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls" {{ ($career->visa_status=="2") ? 'checked' : '' }} value="2" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls" {{ ($career->visa_status=="3") ? 'checked' : '' }} value="3" name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                            </label>
                                        </div>


                                        <div class="visit_visa_status_cls {{  ($career->visa_status=="1") ? '' : 'hide_cls' }}">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_visit=="1") ? 'checked' : '' }} value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_visit=="2") ? 'checked' : '' }} value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded" id="visit_exit_date" name="visit_exit_date" value="{{ $career->exit_date }}" type="text"   />

                                        </div>

                                        <div class="cancel_visa_status_cls {{  ($career->visa_status=="2") ? '' : 'hide_cls' }} " >
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_cancel=="1") ? 'checked' : '' }} value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_cancel=="2") ? 'checked' : '' }} value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>



                                        <div class="own_visa_status_cls {{  ($career->visa_status=="3") ? '' : 'hide_cls' }}">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_own=="1") ? 'checked' : '' }} value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" {{ ($career->visa_status_own=="2") ? 'checked' : '' }} value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Are you willing to take company visa.?</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->company_visa=="1") ? 'checked' : '' }} class="license_type_cls"  value="1" name="company_visa"><span>Yes</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls" {{ ($career->company_visa=="2") ? 'checked' : '' }} value="2" name="company_visa"><span>No</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">What you prefer for in and out.?</label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-success">
                                                <input type="radio" {{ ($career->inout_transfer=="1") ? 'checked' : '' }} class="license_type_cls"  value="1" name="inout_transfer"><span>Here</span><span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="radio radio-outline-primary">
                                                <input type="radio" class="license_type_cls" {{ ($career->inout_transfer=="2") ? 'checked' : '' }} value="2" name="inout_transfer"><span>Home Country</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">PlatForm</label>

                                        <select class="form-control select multi-select" id="platform_id" name="platform_id[]" multiple="multiple">

                                            <?php
                                            $array_platform = array();

                                            if(is_array($career->platform_id)){
                                                $array_platform =  $career->platform_id;
                                            }else{
                                                $array_platform [] =$career->platform_id;
                                            }
                                            ?>


                                            @foreach($platform as $plat)

                                                @php
                                                    $isSelected=isset($career)?($career->platform_id?in_array($plat->id,$array_platform):false):false;
                                                @endphp

                                                <option value="{{$plat->id}}"@if($isSelected) selected @endif>{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Applied Cities</label>

                                        <select class="form-control select multi-select" id="cities" name="cities[]" multiple="multiple">

                                            <?php
                                            $array_cities = array();
                                            if(!empty($career->cities)){
                                                $array_cities =  $career->cities;
                                            }

                                            ?>


                                            @foreach($cities as $plat)


                                                <option value="{{$plat->id}}" @if(in_array($plat->id,$array_cities)) selected @endif>{{$plat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>

                            </div>


                        </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary save-btn">Update </button>
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
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



    <script>
        tail.DateTime("#licence_issue_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#licence_expiry_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#passport_expiry",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#dob",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#visit_exit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

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
            $('#platform_id').select2({
                placeholder: 'Select an option'
            });
            $('#department').select2({
                placeholder: 'Select an option'
            });
            $('#major_department_ids').select2({
                placeholder: 'Select an option'
            });

            $('#cities').select2({
                placeholder: 'Select an option'
            });

        });
    </script>

    <script>

        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".visit_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();
            }else if(selected=="2"){

                $(".cancel_visa_status_cls").show();
                $(".visit_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();

            }else{

                $(".own_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();

            }
        });

        $('input[type=radio][name=license_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".driving_licence_div_cls").css('display','block');
            }else{
                $(".driving_licence_div_cls").hide();
            }

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
