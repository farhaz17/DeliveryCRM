@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .hide_cls{
            display: none;
        }
        </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Passport Details</h4>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Passport Details</a></li>
                        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Passport Additional Details</a></li>
                        <li class="nav-item"><a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">Additional Information</a></li>
                    </ul>

                   <!---------------tab1-------------------------->
                   <!---------------tab1-------------------------->
                   <!---------------tab1-------------------------->
                    <form method="post" enctype="multipart/form-data" aria-label="{{ __('Upload') }}" action="{{isset($parts_data)?route('passport.update',$parts_data->id):route('passport.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">


                                <div class="row">

                                    <div class="col-md-6  mb-3">
                                        <label for="repair_category">Nationality</label>
                                        <select id="nation_id" name="nation_id" class="form-control" required>
                                            <option value=""  >Select option</option>
                                            @foreach($nation as $nat)
                                                <option value="{{ $nat->id }}">{{ $nat->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6  mb-3">
                                        <label for="repair_category">Passport Category</label>
                                        <select id="passport_category" name="passport_category" class="form-control" required>
                                            <option value=""  >Select option</option>
                                            <option value="1"  >Management</option>
                                            <option value="2"  >Management Family</option>
                                            <option value="3"  >Staff</option>
                                            <option value="4"  >Staff Family</option>
                                            <option value="5"  >Worker</option>
                                        </select>
                                    </div>
{{--                                    <input class="form-control form-control" id="country_code" name="nation_id" value="{{$nation->id}}"  type="hidden" placeholder="Enter Country name" required />--}}
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Country Code</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Passport Number</label>
                                        <input class="form-control form-control" id="passport_no" name="passport_no"  type="text" placeholder="Enter Passport Number" required />
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Enter Sur Name</label>
                                        <input class="form-control form-control" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Given Name</label>
                                        <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Sex</label>

                                        <select id="sex" name="sex" class="form-control form-control">
                                            <option>Select Option</option>
                                            <option>Male</option>
                                            <option>Female</option>


                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Father Name</label>
                                        <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Date Of Birth</label>
                                        <input class="form-control form-control" id="dob" name="dob" type="text" placeholder="Enter Date of Birth" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Place of Birth</label>
                                        <input class="form-control form-control" id="place_birth" autocomplete="off" name="place_birth" type="text" placeholder="Enter Place Of Birth" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Place of Issue</label>
                                        <input class="form-control form-control" id="place_issue" name="place_issue" type="text" placeholder="Enter Place Of Issue" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Date of Issue</label>
                                        <input class="form-control form-control" id="date_issue" name="date_issue" type="text" placeholder="Enter Date of Issue" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Expiry Date</label>
                                        <input class="form-control form-control" id="date_expiry" name="date_expiry" type="text" placeholder="Enter Expiry Date" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category" id="copy_label">Choose Scanned Copy</label>

                                            <input class="form-control" id="emirates_pic" type="file" name="file_name" required/>

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                      <div class="row">
                                        <div class="col-md-6">
                                            <label for="repair_category">Attachment</label>

                                            <select id="attachment_name" name="attachment_name" class="form-control form-control">
                                                <option disabled selected>Select Option</option>
                                                @foreach($attachment as $attach)
                                                    <option value="{{$attach->id}}">{{$attach->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="repair_category" id="copy_label">Choose Attachment Copy</label>
                                            <input class="form-control" id="attachment_file" type="file" name="attachment_file"/>
                                        </div>
                                      </div>

                                    </div>



                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                    <label for="repair_category">Select the Designation Category</label>
                                                    <select id="designation_category" name="designation_category" class="form-control form-control" required>
                                                        <option disabled selected>Select Option</option>
                                                        @foreach($category_assigns as $attach)
                                                            <option value="{{$attach->id}}">{{$attach->name}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Select the Designation </label>
                                                <select id="designation_id" name="designation_id" class="form-control form-control" required>
                                                    <option disabled selected>Select Option</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 visa_status_div">
                                            <label for="repair_category" class="font-weight-bold visa_detail_cls">Visa Status</label>
                                            <br>
                                            <div class="form-check-inline visa_detail_cls">
                                                <label class="radio radio-outline-success">
                                                    <input type="radio"    value="1" id="visa_status_visit" name="visa_status"  ><span>Visit Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>

                                            <div class="form-check-inline visa_detail_cls">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"  value="2" id="visa_status_cancel" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>

                                            <div class="form-check-inline visa_detail_cls visa_status_own_div_cls">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"  value="3"  id="visa_status_own" name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>

                                        <div class="visit_visa_status_cls hide_cls visa_detail_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="visit_one_month" value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="visit_three_month"  value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded"  name="visit_exit_date"  id="visit_exit_date" value="" type="text"   />

                                        </div>



                                        <div class="cancel_visa_status_cls hide_cls visa_detail_cls " >
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"  id="cancel_free_zone" value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"   id="cancel_company_visa"  value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio"   id="cancel_waiting_cancel"  value="3" name="cancel_visa_status"><span>Waiting Cancellation</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <br>
                                            <label for="repair_category">Fine Start Date</label>
                                            <input class="form-control form-control-rounded"  name="cancel_fine_date"  autocomplete="off" id="cancel_fine_date" value="" type="text"   />
                                        </div>

                                        <div class="own_visa_status_cls hide_cls visa_detail_cls visa_status_own_div_cls">
                                            <br>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" id="own_visa_noc"    value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="radio radio-outline-primary">
                                                    <input type="radio" class="license_type_cls" id="own_visa_without_noc"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>






                                </div>

                            <a class="btn btn-info" style="color: #ffffff" id="next-btn">Next</a>

                        </div>

                        <!---------------tab2-------------------------->
                        <!---------------tab2-------------------------->
                        <!---------------tab2-------------------------->
                        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                                <div class="row">
{{--                                    <input class="form-control form-control" id="country_code" name="nation_id" value="{{$nation->id}}"  type="hidden" placeholder="Enter Country name" required />--}}
                                    <div class="col-md-6 form-group mb-3" id="citizenship_number">
                                        <label for="repair_category">Citizenship Number</label>
                                        <input class="form-control form-control" id="citizenship_no" name="citizenship_no"  type="text" placeholder="Enter Citizenship Number"  />
                                    </div>

                                    <div class="col-md-6 form-group mb-3" id="personal_add">
                                        <label for="repair_category">Personal Address</label>
                                        <input class="form-control form-control" id="personal_address" name="personal_address"  type="text" placeholder="Enter Personal Address"  />
                                    </div>

                                    <div class="col-md-6 form-group mb-3" id="permanant_add">
                                        <label for="repair_category">Permanant Address</label>
                                        <input class="form-control form-control" id="permanant_address" name="permanant_address"  type="text" placeholder="Enter Permanant Address" />
                                    </div>


                                    <div class="col-md-6 form-group mb-3"id="booklet_no">
                                        <label for="repair_category">Booklet Number</label>
                                        <input class="form-control form-control" id="booklet_number" name="booklet_number" type="text" placeholder="Enter Booklet Number"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3" id="tracking_no">
                                        <label for="repair_category">Tracking Number</label>
                                        <input class="form-control form-control" id="tracking_number" name="tracking_number" type="text" placeholder="Enter Tracking Number"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3" id="mother_name">
                                        <label for="repair_category">Name of Mother</label>
                                        <input class="form-control form-control" id="name_of_mother" name="name_of_mother" type="text" placeholder="Enter Father_name"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3" id="next_kin">
                                        <label for="repair_category">Next of Kin</label>
                                        <input class="form-control form-control" id="next_of_kin" name="next_of_kin" type="text" placeholder="Enter Next of Kin"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3" id="relation">
                                        <label for="repair_category">Relationship</label>
                                        <input class="form-control form-control" id="relationship" name="relationship" type="text" placeholder="Enter Relationship"  />
                                    </div>
                                    <div class="col-md-6 form-group mb-3" id="name_middle">
                                        <label for="repair_category">Middle Name</label>
                                        <input class="form-control form-control" id="middle_name" name="middle_name" type="text" placeholder="Middle Name" reqired />
                                    </div>
                                </div>
                            <a class="btn btn-info" style="color: #ffffff" id="next-btn-2">Next</a>
                        </div>

                        <!---------------tab3-------------------------->
                        <!---------------tab3-------------------------->
                        <!---------------tab3-------------------------->
                        <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                            <h5>National Details</h5>
                            <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Relation Name</label>
                                <input class="form-control form-control" id="nat_name" name="nat_name"  type="text" placeholder="Enter Name"  />
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Relation</label>
                                <input class="form-control form-control" id="nat_relation" name="nat_relation"  type="text" placeholder="Enter Relation" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">National Address</label>
                                <input class="form-control form-control" id="nat_address" name="nat_address" type="text" placeholder="Enter National Address"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">National Phone</label>
                                <input class="form-control form-control" id="nat_phone" name="nat_phone" type="text" placeholder="Enter National Phone"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">National Whatsapp Number</label>
                                <input class="form-control form-control" id="nat_whatsapp_no" name="nat_whatsapp_no" type="number" placeholder="Enter National Whatsapp Number"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">National Email Address</label>
                                <input class="form-control form-control" id="nat_email" name="nat_email" type="email" placeholder="Enter National Email Address"  />
                            </div>
                            </div>
                            <h5>International Details</h5>
                            <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">International Name</label>
                                <input class="form-control form-control" id="inter_name" name="inter_name"  type="text" placeholder="Enter International Name"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category"> International Relation</label>
                                <input class="form-control form-control" id="inter_relation" name="inter_relation"  type="text" placeholder="Enter Passport Number" />
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">International Address</label>
                                <input class="form-control form-control" id="inter_address" name="inter_address" type="text" placeholder="Enter International Relation"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">International Phone</label>
                                <input class="form-control form-control" id="inter_phone" name="inter_phone" type="number" placeholder="Enter Given Name"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">International Whatsapp Number</label>
                                <input class="form-control form-control" id="inter_whatsapp_no" name="inter_whatsapp_no" type="number" placeholder="Enter International Phone"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">International Email Address</label>
                                <input class="form-control form-control" id="inter_email" name="inter_email" type="email" placeholder="Enter International Email Address"  />
                            </div>
                            </div>
                            <h5>Personal Details</h5>
                            <div class="row">

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Personal Mobile</label>
                                <input class="form-control form-control" id="personal_mob" name="personal_mob" type="number" placeholder="Enter Personal Mobile"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Personal Email</label>
                                <input class="form-control form-control" id="personal_email" name="personal_email" type="email" placeholder="Enter Personal Email"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category" id="copy_label">Photo</label>
                                <div class="custom-file">
                                    <input class="form-control  " id="file_name2" type="file" name="file_name2"/>
{{--                                    <label class="custom-file-label" for="select_file">Choose Image</label>--}}
                                </div>
                            </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary">Save</button>
                                </div>

                            </div><!------row---->
                        </div>




                    </div>

                    </form>

                    </div>
                </div>
            </div>


        {{-- <div class="col-md-2 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-2">Pending Passport Number</h4>
                    @if(!empty($pending_passports))
                        <ul class="list-group">
                            @foreach($pending_passports as $passport)
                                <li class="list-group-item">{{ $passport['passport_number'] }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Record Not found</p>
                    @endif
                </div>
            </div>
        </div> --}}




        </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        tail.DateTime("#visit_exit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#cancel_fine_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });
    </script>

    <script>

        $( document ).ready(function() {
            $("#citizenship_number").hide();
            $("#personal_add").hide();
            $("#permanant_add").hide();
            $("#booklet_no").hide();
            $("#tracking_no").hide();
            $("#mother_name").hide();
            $("#next_kin").hide();
            $("#relation").hide();
            $("#name_middle").hide();
        });

        $("#nation_id").change(function () {
            $("#unique_div").css('display','block');
            var nation_id = $(this).val();
            if(nation_id=='1'){
                $("#citizenship_number").show();
                $("#personal_add").show();
                $("#permanant_add").show();
                $("#booklet_no").show();
                $("#tracking_no").show();
            }
            else if(nation_id=='2'){

                $("#personal_add").show();
                $("#mother_name").show();

                $("#permanant_add").hide();
                $("#booklet_no").hide();
                $("#citizenship_number").hide();
                $("#tracking_no").hide();
                $("#next_kin").hide();
                $("#relation").hide();
                $("#name_middle").hide();

            }
           else if(nation_id=='3'){

                $("#citizenship_number").show();
                $("#mother_name").show();

                $("#personal_add").hide();
                $("#permanant_add").hide();
                $("#booklet_no").hide();
                $("#tracking_no").hide();
                $("#next_kin").hide();
                $("#relation").hide();
                $("#name_middle").hide();

            }
          else if(nation_id=='6'){


                $("#name_middle").show();

                $("#citizenship_number").hide();
                $("#personal_add").hide();
                $("#permanant_add").hide();
                $("#booklet_no").hide();
                $("#tracking_no").hide();
                $("#mother_name").hide();
                $("#next_kin").hide();
                $("#relation").hide();


            }
          else{
                $("#citizenship_number").hide();
                $("#personal_add").hide();
                $("#permanant_add").hide();
                $("#booklet_no").hide();
                $("#tracking_no").hide();
                $("#mother_name").hide();
                $("#next_kin").hide();
                $("#relation").hide();
                $("#name_middle").hide();
            }



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

            }else if(selected=="3"){

                $(".own_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }else{
                $(".own_visa_status_cls").hide();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }
        });
    </script>

    <script>


        $("#designation_category").change(function(){


            var select_id = $(this).val();

            $.ajax({
                url: "{{ route('get_the_designation_by_subcategory') }}",
                method: 'GET',
                dataType: 'json',
                data: {primary_id: select_id},
                success: function(response) {

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = '<option value="" selected disabled>select an option</option>';
                    if(len > 0){
                        for(var i=0; i<len; i++){
                          options += '<option value='+response[i].id+'>'+response[i].name+'</option>'
                        }
                    }

                    $("#designation_id").html('');
                    $("#designation_id").html(options);
                }
            });




        });

    </script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });



            tail.DateTime("#dob",{
                dateFormat: "dd-mm-YYYY",
                timeFormat: false,

            }).on("change", function(){
                tail.DateTime("#dob",{
                    dateStart: $('#start_tail').val(),
                    dateFormat: "YYYY-mm-dd",
                    timeFormat: false

                }).reload();

            });


            tail.DateTime("#date_issue",{
                dateFormat: "dd-mm-YYYY",
                timeFormat: false,

            }).on("change", function(){
                tail.DateTime("#date_expiry",{
                    dateStart: $('#date_issue').val(),
                    dateFormat: "dd-mm-YYYY",
                    timeFormat: false

                }).reload();

            });

            tail.DateTime("#date_expiry",{
                dateFormat: "dd-mm-YYYY",
                timeFormat: false,

            }).on("change", function(){
                tail.DateTime("#date_expiry",{
                    dateStart: $('#date_issue').val(),
                    dateFormat: "dd-mm-YYYY",
                    timeFormat: false

                }).reload();

            });


        });


    </script>

    <script>
        $('#next-btn').click(function(){
            $("#profile-basic-tab").click();
        });


        $('#next-btn-2').click(function(){
            $("#contact-basic-tab").click();
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
