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
            <li>Edit 4 Pl Vendor</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


      <div class="col-md-12">
       <div class="card text-left">
        <div class="card-body">
            {{-- <form id="careerForm" method="post" action="{{action('VendorRegistration\VendorRegistrationControllerr@update', $id)}}" enctype="multipart/form-data"> --}}
                <form action="{{action('VendorRegistration\VendorRegistrationController@update', $id)}}" enctype="multipart/form-data"  method="post">
                    {!! csrf_field() !!}
                    @if(isset($edit_fourpl))

                        {{ method_field('PUT') }}

                    @endif
                <h3>Vendor Registration Edit</h3>
               <div class="row">
                    <div class="col-md-6">
                        <fieldset class="border p-4">
                            <legend class="w-auto">General Information</legend>
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}"  name="company_name" class="form-control" placeholder="Company *" value=""  />
                                <input type="hidden" name="token" class="form-control"  value="p2lbgWkFrykA4QyUmpHihzmc5BNzIABq" />
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->address:""}}" name="address" class="form-control" placeholder="Address *" value="" />
                            </div>
                            <div class="form-group">
                                <label>Telephone Number</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->phone_no:""}}" name="telephone_number" class="form-control" placeholder="Telephone Number *"  value="" />
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" value="{{isset($edit_fourpl)?$edit_fourpl->email:""}}" name="company_email_address" class="form-control" placeholder="Email Address *"  value=""  />
                            </div>
                            <div class="form-group">
                                <label>Company Website</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->company_website:""}}" name="company_website" class="form-control" placeholder="Company Website *" value=""  />
                            </div>
                            <div class="form-group">
                                <label>City/State Zip Code</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->zip_code:""}}" name="zip_code" class="form-control" placeholder="City/State Zip Code *" value=""  />
                            </div>
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->company_address:""}}" name="company_address" class="form-control" placeholder="Company Address *" value=""  />
                            </div>


                        </fieldset>
                        <fieldset class="border p-4 mt-4">
                            <legend class="w-auto">Payment Information</legend>
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->bank_name:""}}" name="bank_name" class="form-control" placeholder="Bank Name" value="" />
                            </div>
                            <div class="form-group">
                                <label>Account Number </label>
                                <input type="text"  value="{{isset($edit_fourpl)?$edit_fourpl->account_number:""}}" name="account_number" class="form-control" placeholder="Account Number" value="" />
                            </div>
                            <div class="form-group">
                                <label>Beneficiary Name</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->benificiary_name:""}}" name="benificiary_name" class="form-control" placeholder="Beneficiary Name" value="" />
                            </div>
                            <div class="form-group">
                                <label>IBAN Number</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->iban_number:""}}" name="iban_number" class="form-control" placeholder="IBAN Number" value="" />
                            </div>

                            <div class="form-group">
                                <label>Bank Address</label>
                                <input type="text"  value="{{isset($edit_fourpl)?$edit_fourpl->bank_address:""}}" name="bank_address" class="form-control" placeholder="Bank Address" value="" />
                            </div>

                            <div class="form-group">
                                <label>Authorized Person Emirates ID No</label>
                                <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->aurtorized_eid:""}}" name="aurtorized_eid" class="form-control" placeholder="Enter Authorized Person EID No" value="" />
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">




                        <fieldset class="border p-4">
                            <legend class="w-auto">Contact Information</legend>



                            <div class="row">

                                <div class="col-md-6">
                                    <div class="key-div">

                                    <div>
                                        <div class="form-group">
                                            <label  style="white-space: nowrap">Company Representative Name</label>
                                            <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->company_rep_name:""}}"  name="company_rep_name" class="form-control input-rep" placeholder="Enter Company Representative Name" value="" />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" value="{{isset($edit_fourpl)?$edit_fourpl->email:""}}" name="contatcs_email" class="form-control input-rep" placeholder="Enter Email Address" value="" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            <input type="number" value="{{isset($edit_fourpl)?$edit_fourpl->mobile_no:""}}" name="mobile_no" class="form-control input-rep" placeholder="Enter Mobile No" value="" />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label>Telefone No</label>
                                            <input type="number" value="{{isset($edit_fourpl)?$edit_fourpl->contacts_telephone_number:""}}" name="contacts_telephone_number" class="form-control input-rep" placeholder="Enter Telefone No" value="" />
                                        </div>
                                    </div>
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <div class="key-div">

                                    <div>
                                        <div class="form-group">
                                            <label  style="white-space: nowrap">Key Accounts Representative</label>
                                            <input type="text" name="key_accounts_rep" value="{{isset($edit_fourpl)?$edit_fourpl->key_accounts_rep:""}}" class="form-control input-rep" placeholder="Enter Key Accounts Representative" value="" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" value="{{isset($edit_fourpl)?$edit_fourpl->key_account_email:""}}" name="key_account_email" class="form-control input-rep" placeholder="Enter Key Accounts Representative Email" value="" />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            <input type="number" value="{{isset($edit_fourpl)?$edit_fourpl->key_mobile:""}}" name="key_mobile" class="form-control input-rep" placeholder="Enter Key Accounts Representative Mobile No" value="" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label>Telefone No</label>
                                            <input type="number" value="{{isset($edit_fourpl)?$edit_fourpl->key_telefone:""}}" name="key_telefone" class="form-control input-rep" placeholder="Enter Key Accounts Representative Telefone No" value="" />
                                        </div>

                                    </div>
                                    </div>
                                </div>
                            </div>






                        </fieldset>
                        <br>
                        <fieldset class="border p-4">
                            <legend class="w-auto">Company Overview</legend>
                            <div>


                                <div>
                                    <div class="form-group">
                                        <label>Type Of Buisness</label>
                                        <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->type_of_business:""}}" name="type_of_business" class="form-control" placeholder="Enter Type Of Buisness" value="" />
                                    </div>
                                </div>

                                <div style="line-height:22px;" class="font-weight-bold">Company is : &nbsp</div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                    @php $isSelected=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='1')
                                    checked
                                    @endif
                                    type="radio" name="company_is" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Licensed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected2=='2')
                                    checked
                                    @endif type="radio" name="company_is" value="2">
                                    <label class="form-check-label"  for="inlineRadio2">Inssured</label>
                                </div>

                                <div>
                                    <div class="form-group">
                                        <label>Company Establishment Date</label>
                                        <input type="date" value="{{isset($edit_fourpl)?$edit_fourpl->compnany_est_date:""}}" name="compnany_est_date" class="form-control" placeholder="Enter Company Establishment Date" value="" />
                                    </div>
                                </div>

                                <div>
                                    <div class="form-group">
                                        <label>Establishment Code</label>
                                        <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->est_code:""}}" name="est_code" class="form-control" placeholder="Enter Establishment Code" value="" />
                                    </div>
                                </div>

                                <div>
                                    <div class="form-group">
                                        <label>Trade License No</label>
                                        <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->trade_linces_no:""}}" name="trade_linces_no" class="form-control" placeholder="Trade License No" value="" />
                                    </div>
                                </div>

                                <div>
                                    <div class="form-group">
                                        <label>Tax ID</label>
                                        <input type="text" value="{{isset($edit_fourpl)?$edit_fourpl->text_id:""}}" name="text_id" class="form-control" placeholder="Enter Tax ID" value="" />
                                    </div>
                                </div>



                                <div>
                                    <div class="form-group">
                                        <label>Trade License Expiry Date</label>
                                        <input type="date" value="{{isset($edit_fourpl)?$edit_fourpl->trad_license_exp_date:""}}" name="trad_license_exp_date" class="form-control" placeholder=" Enter Trade License Expiry Date" value="" />
                                    </div>
                                </div>


                                <div style="line-height:22px;" class="font-weight-bold">Legal Structure : &nbsp</div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"  @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='1')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="1">
                                    <label class="form-check-label"   for="inlineRadio1">Sole Proprietor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"  @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='2')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Partenership</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"  @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='3')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="3">
                                    <label class="form-check-label" for="inlineRadio2">Private Limited</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"  @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='4')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="4">
                                    <label class="form-check-label" for="inlineRadio2">Public Limited</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"   @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='5')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="5">
                                    <label class="form-check-label" for="inlineRadio2">Public Sector</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='6')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="6">
                                    <label class="form-check-label" for="inlineRadio2">LLC</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @php $isSelected2=(isset($edit_fourpl)?$edit_fourpl->company_is:""); @endphp
                                    @if ($isSelected=='7')
                                    checked
                                    @endif
                                    type="radio" name="legal_structure" value="7">
                                    <label class="form-check-label" for="inlineRadio2">Legal Agent</label>
                                </div>






                            </div>




                        </fieldset>

                        <br>
                        {{-- <fieldset class="border p-4">
                            <legend class="w-auto">Company Overview</legend>
                            <div>

                                <div>
                                    <div class="form-group">
                                        <label>Type Of Buisness</label>
                                        <input type="file" value="{{isset($edit_fourpl)?$edit_fourpl->type_of_business:""}}" name="type_of_business" class="form-control" placeholder="Enter Type Of Buisness" value="" />
                                    </div>
                                </div>


                            </div>

                        </fieldset> --}}






                        <fieldset class="border p-4">
                            <legend class="w-auto">Uploads <span style="font-size:14px;font-weight: bold"> (PDF only)</span></legend>
                            <div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Trade License *</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="trade_license" type="file" name="trade_license"/>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">VAT Certificate</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="vat_certificate" type="file" name="vat_certificate" />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Owner Passport Copy *</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="owener_passport_copy" type="file" name="owener_passport_copy" />
                                        </div>
                                    </div>


                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Owner Visa Copy *</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="owner_visa_copy" type="file" name="owner_visa_copy" />
                                        </div>
                                    </div>


                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Other</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="other_doc" type="file" name="other_doc"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Establishment Card</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="est_card" type="file" name="est_card"  />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">E Signatuure Card</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="e_signature_card" type="file" name="e_signature_card" />
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Company Labour Card *</label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="company_labour_card" type="file" name="company_labour_card"/>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="end_date">Owner Emirates ID Copy * </label>
                                            <input class="form-control" value="{{isset($edit_fourpl)?$edit_fourpl->name:""}}" id="owener_emirates_id_copy" type="file" name="owener_emirates_id_copy" />
                                        </div>
                                    </div>



                                </div>
                            </div>


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
