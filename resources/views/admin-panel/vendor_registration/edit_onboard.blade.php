@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">4 PL</a></li>
            <li>Edit 4 Pl Rider</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


      <div class="col-md-12">
       <div class="card text-left">
        <div class="card-body">
            {{-- <form id="careerForm" method="post" action="{{action('VendorRegistration\VendorRegistrationControllerr@update', $id)}}" enctype="multipart/form-data"> --}}
                <form action="{{route('vendor-onboard-update', $obj->id)}}" enctype="multipart/form-data"  method="post">
                    {!! csrf_field() !!}
                    @if(isset($edit_fourpl))

                        {{ method_field('PUT') }}

                    @endif
                <h3>Vendor Rider Edit</h3>
               <div class="row">
                    <div class="col-md-6">
                        <fieldset class="border p-4">
                            <legend class="w-auto">General Information</legend>
                            <div class="form-group">
                                <label>Rider First Name</label>
                                <input type="text" value="{{isset($obj->rider_first_name) ? $obj->rider_first_name : ""}}"  name="rider_first_name" class="form-control" placeholder="Rider First Name *" value=""  />
                            </div>
                            <div class="form-group">
                                <label>Rider Last Name</label>
                                <input type="text" value="{{isset($obj->rider_last_name) ? $obj->rider_last_name : ""}}" name="rider_last_name" class="form-control" placeholder="Rider Last Name *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Contact Official</label>
                                <input type="text" value="{{isset($obj->contact_official) ? $obj->contact_official : ""}}" name="contact_official" class="form-control" placeholder="Contact Official *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Contact Personal:</label>
                                <input type="number" value="{{isset($obj->contacts_personal) ? $obj->contacts_personal : ""}}" name="contacts_personal" class="form-control" placeholder="Contact Personal *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Contact Email:</label>
                                <input type="email" value="{{isset($obj->contacts_email) ? $obj->contacts_email : ""}}" name="contacts_email" class="form-control" placeholder="Contact Email *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Emirates ID No:</label>
                                <input type="text" value="{{isset($obj->emirates_id_no) ? $obj->emirates_id_no : ""}}" name="emirates_id_no" class="form-control" placeholder="Emirates ID No *" value="" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addressDetail">Vaccination:</label>
                                <div class="form-check">
                                    <span class="mr-30">
                                        <input type="radio" name="vaccine" id="radio1" value="1" {{ isset($obj->vaccine) && $obj->vaccine == 1 ? 'checked' : '' }}>
                                        <label for="radio1">
                                            1st Dose
                                        </label>
                                    </span>
                                    <span class="mr-30">
                                        <input type="radio" name="vaccine" id="radio2" value="2" {{ isset($obj->vaccine) && $obj->vaccine == 2 ? 'checked' : '' }}>
                                        <label for="radio2">
                                            2nd Dose
                                        </label>
                                    </span>
                                    <span class="mr-30">
                                        <input type="radio" name="vaccine" id="radio3" value="3" {{ isset($obj->vaccine) && $obj->vaccine == 3 ? 'checked' : '' }}>
                                        <label for="radio3">
                                            Not Taken Yet
                                        </label>
                                    </span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addressDetail">Applying For</label>
                                <div class="form-check">
                                    <span class="mr-30">
                                        <input type="radio" name="applying_for" id="bike" value="1" {{ isset($obj->applying_for) && $obj->applying_for == 1 ? 'checked' : '' }}>
                                        <label for="bike">
                                            Bike
                                        </label>
                                    </span>
                                    <span class="mr-30">
                                        <input type="radio" name="applying_for" id="car" value="2" {{ isset($obj->applying_for) && $obj->applying_for == 2 ? 'checked' : '' }}>
                                        <label for="car">
                                            Car
                                        </label>
                                    </span>
                                    <span class="mr-30">
                                        <input type="radio" name="applying_for" id="both" value="3" {{ isset($obj->applying_for) && $obj->applying_for == 3 ? 'checked' : '' }}>
                                        <label for="both">
                                            Both
                                        </label>
                                    </span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Passport No:</label>
                                <input type="text" value="{{isset($obj->passport_no) ? $obj->passport_no : ""}}"  name="passport_no" class="form-control" placeholder="Passport No *" value=""  />
                            </div>
                            <div class="form-group">
                                <label>Driving License Number:</label>
                                <input type="text" value="{{isset($obj->driving_license_no) ? $obj->driving_license_no : ""}}" name="driving_license_no" class="form-control" placeholder="Driving License Number *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Plate No:</label>
                                <input type="text" value="{{isset($obj->plate_no) ? $obj->plate_no : ""}}" name="plate_no" class="form-control" placeholder="Plate No *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Nationality:</label>
                                <select id="nationality" class="form-control form-control-rounded" name="nationality">
                                    <option value="" selected disabled>Select option</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{ $nationality->id  }}"
                                            @if ($nationality->id ==$obj->nationality)
                                                selected="selected"
                                            @endif >
                                            {{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input type="date" value="{{isset($obj->dob) ? $obj->dob : ""}}" name="dob" class="form-control" placeholder="Date Of Birth *" value="" />
                            </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" value="{{isset($obj->city) ? $obj->city : ""}}" name="city" class="form-control" placeholder="City *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <input type="text" value="{{isset($obj->address) ? $obj->address : ""}}" name="address" class="form-control" placeholder="Address *" value="" />
                            </div>

                        </fieldset>
                    </div>
                    <div class="col-md-6">

                        <fieldset class="border p-4">
                            <legend class="w-auto">General Information</legend>

                            <div class="form-group">
                                <label>Passport Copy</label>
                                <input class="form-control" id="passportCopy" type="file" name="passport_copy" />
                            </div>
                            <div class="form-group">
                                <label>Passport Expiry Date:</label>
                                <input type="date" name="passport_expiry" id="passportExpiry" placeholder="" value="{{ isset($obj->passport_expiry) ? $obj->passport_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Visa Copy</label>
                                <input class="form-control" id="VisaCopy" type="file" name="visa_copy" />
                            </div>
                            <div class="form-group">
                                <label>Visa Expiry Date:</label>
                                <input type="date" name="visa_expiry" id="VisaExpiry" placeholder="" value="{{ isset($obj->visa_expiry) ? $obj->visa_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Emirates ID Front Side</label>
                                <input class="form-control" type="file" name="emirates_id_front_side" />
                            </div>
                            <div class="form-group">
                                <label>Emirates ID Back End</label>
                                <input class="form-control" type="file" name="emirates_id_front_back" />
                            </div>
                            <div class="form-group">
                                <label>Emirates ID Expiry Date</label>
                                <input type="date" name="emirates_expiry" placeholder="" value="{{ isset($obj->emirates_expiry) ? $obj->emirates_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Driving Lincense Front End</label>
                                <input class="form-control" type="file" name="driving_license_front" />
                            </div>
                            <div class="form-group">
                                <label>Driving Lincense Back End</label>
                                <input class="form-control" type="file" name="driving_license_back" />
                            </div>
                            <div class="form-group">
                                <label>Driving License Expiry Date</label>
                                <input type="date" name="driving_license_expiry" placeholder="" value="{{ isset($obj->driving_license_expiry) ? $obj->driving_license_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Mulkiya Front End</label>
                                <input class="form-control" type="file" name="mulkiya_front" />
                            </div>
                            <div class="form-group">
                                <label>Mulkiya Back End</label>
                                <input class="form-control" type="file" name="mulkiya_back" />
                            </div>
                            <div class="form-group">
                                <label>Mulkiya Expiry Date</label>
                                <input type="date" name="mulkiya_expiry" placeholder="" value="{{ isset($obj->mulkiya_expiry) ? $obj->mulkiya_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Health Insurance Card Copy</label>
                                <input class="form-control" type="file" name="health_insurance_card_copy" />
                            </div>
                            <div class="form-group">
                                <label>Insurance Expiry Date</label>
                                <input type="date" name="insurance_expiry" placeholder="" value="{{ isset($obj->insurance_expiry) ? $obj->insurance_expiry : '' }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Rider Photo</label>
                                <input class="form-control" type="file" name="rider_photo" />
                            </div>

                        </fieldset>

                    </div>

                </div>





                <div class="col-md-12 mt-5">
                    <br>
                    <input type="submit" name="btnSubmit" class="btn btn-primary mt-2 p-1 pb-2" value="Save" />
                </div>
            </form>
       </div>
     </div>
     </div>
    <br><br>












@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'All Passport Details',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
            });

        });

    </script>
    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#datatable_taking_visa').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],

                // scrollY: 500,
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


    </script>

    <script>


        $(".pass_btn_cls-1").click(function(){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();


            $.ajax({
                url: "{{ route('ajax_passport_edit') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token: token},
                success: function (response) {
                    $('#all-check').empty();
                    $('#all-check').append(response.html);
                    $('.passport_edit').modal('show');
                }


            });


        });

        $(document).ready(function () {
            $('#correct_passport_number').hide();
            $("#renewal").change(function () {

                $('#renew_passport_issue_date').hide();
                $('#renew_passport_expiry_date').hide();
                $('#file_name').hide();
                $('#nation').hide();
                $('#correct_passport_number').hide();
                $('#renew_passport_issue_date').show();
                $('#renew_passport_expiry_date').show();
                $('#file_name').show();
                $('#renew_passport_number').show();


            });
        });


        $("#wrong").change(function () {

            $('#renew_passport_number').hide();
            $('#renew_passport_issue_date').hide();
            $('#renew_passport_expiry_date').hide();
            $('#file_name').hide();
            $('#nation').hide();
            $('#correct_passport_number').hide();
            $('#nation').show();


        });
        $("#wrong_passport").change(function () {

            $('#renew_passport_number').hide();
            $('#renew_passport_issue_date').hide();
            $('#renew_passport_expiry_date').hide();
            $('#file_name').hide();
            $('#nation').hide();
            $('#nation').hide();
            $('#correct_passport_number').hide();
            $('#correct_passport_number').show();


        });


    </script>



    <script>
        $(".renew_btn_cls").click(function(){
            var ids = $(this).attr('id');


            var  action = $("#renew_modal_form").attr("action");

            var ab = action.split("view_passport/");

            var action_now =  ab[0]+'view_passport/'+ids;
            $("#renew_modal_form").attr('action',action_now);
            $("#renew_primary_id").val(ids);

            // $("#renew_passport_number").val("0");
            $('#nation').hide();
            $('#renew').modal('show');
        });



        //------------------------------------------------------------------------
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

        tail.DateTime("#dob",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#dob",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_issue",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_expiry",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>

@endsection
