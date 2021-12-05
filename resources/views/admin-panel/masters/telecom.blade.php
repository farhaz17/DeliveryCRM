@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Telecomminication</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!------------------tabs--------->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Etisalat</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">DU</a></li>
                    <li class="nav-item"><a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">DEWA</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3">Etisalat</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Comany name</label>
                                                    <input class="form-control form-control-rounded" id="company_name" name="company_name"  type="text" placeholder="Enter Company Name" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Business Customer Name </label>
                                                    <input class="form-control form-control-rounded" id="time" name="business_customer_name" type="text" placeholder="Enter Business Custmer Name" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Customer TRN</label>
                                                    <input class="form-control form-control-rounded" id="customer_trn" name="customer_trn"  type="number" placeholder="Enter Customer TRN" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Account Number</label>
                                                    <input class="form-control form-control-rounded" id="account_number" name="account_number"  type="number" placeholder="Enter Account Number" />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Bill Number</label>
                                                    <input class="form-control form-control-rounded" id="bill_number" name="bill_number"  type="number" placeholder="Enter Bill Number" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Bill Issue Date</label>
                                                    <input class="form-control form-control-rounded" id="bill_issue_date" name="bill_issue_date"  type="number" placeholder="Enter Bill Issue Date " />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Bill Period</label>
                                                    <input class="form-control form-control-rounded" id="bill_period" name="bill_period"  type="number" placeholder="Enter Period" />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Service Rental</label>
                                                    <input class="form-control form-control-rounded" id="service_rental" name="service_rental"  type="number" placeholder="Enter Service Rental" />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Usage Charges</label>
                                                    <input class="form-control form-control-rounded" id="usage_charges" name="usage_charges"  type="number" placeholder="Enter Usage Charges " />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> One Time Charges</label>
                                                    <input class="form-control form-control-rounded" id="one_time_charges" name="one_time_charges"  type="number" placeholder="Enter One Time Charges" />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Other Credit and Charges</label>
                                                    <input class="form-control form-control-rounded" id="other_charges" name="other_charges"  type="number" placeholder="Enter Other Credit and Charges" />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">VAT on Taxable Service Current Period</label>
                                                    <input class="form-control form-control-rounded" id="vat" name="vat"  type="number" placeholder="Enter VAT" />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Previous Month Bill</label>
                                                    <input class="form-control form-control-rounded" id="previous_month_bill" name="previous_month_bill"  type="number" placeholder="Enter Previous Month Bill" />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Refund and Adjustment</label>
                                                    <input class="form-control form-control-rounded" id="refund" name="refund"  type="number" placeholder="Enter Amount" />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Vat Credits Previous Periods</label>
                                                    <input class="form-control form-control-rounded" id="vat_credit" name="vat_credit"  type="number" placeholder="Enter Refund and Adjustment" />
                                                </div>





                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Vat Debit Previous Periods</label>
                                                    <input class="form-control form-control-rounded" id="vat_debit" name="vat_debit"  type="number" placeholder="Enter Vat Debit Previous Periods" />
                                                </div>




                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Payment Received</label>
                                                    <input class="form-control form-control-rounded" id="payment_received" name="payment_received"  type="number" placeholder="Enter Payment Received" />
                                                </div>




                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Balance Carried Forward</label>
                                                    <input class="form-control form-control-rounded" id="balance_carried" name="balance_carried"  type="number" placeholder="Enter Balance Carried Forward" />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Total Amount Date </label>
                                                    <input class="form-control form-control-rounded" id="total_amount" name="total_amount"  type="number" placeholder="Enter Total Amount Date" />
                                                </div>






                                                <div class="col-md-12">
                                                    <button class="btn btn-primary">@if(isset($parts_data)) Edit @else   @endif Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Business Customer Number</th>
                                                <th scope="col">Customer TRN</th>
                                                <th scope="col">Account Number  </th>
                                                <th scope="col">Bill Number  </th>
                                                <th scope="col">Bill Issue Date  </th>
                                                <th scope="col">Bill Period  </th>
                                                <th scope="col">Service Rental  </th>
                                                <th scope="col">Usage Charges  </th>
                                                <th scope="col">One Time Charges  </th>
                                                <th scope="col">Other Creditd & Charges  </th>
                                                <th scope="col">Vat ON Taxable Service Current Period </th>
                                                <th scope="col">Previous Month Bill </th>
                                                <th scope="col">Refund & Adjustment </th>
                                                <th scope="col">VAT Credits Previous Periods </th>
                                                <th scope="col">VAT Debit Previous Periods </th>
                                                <th scope="col">Payment Received  </th>
                                                <th scope="col">Balance Carried Forward  </th>
                                                <th scope="col">Total Amount  </th>






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
                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3">DU</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Company Name</label>
                                                    <input class="form-control form-control-rounded" id="company_name" name="company_name"  type="text" placeholder="Enter Company Name" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Bill number </label>
                                                    <input class="form-control form-control-rounded" id="bill_number" name="bill_number" type="text" placeholder="Enter Bill number" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Bill Date</label>
                                                    <input class="form-control form-control-rounded" id="bill_date" name="bill_date"  type="number" placeholder="Bill Date" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Bill Period</label>
                                                    <input class="form-control form-control-rounded" id="bill_period" name="bill_period"  type="number" placeholder="Enter Bill Period" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Account Number</label>
                                                    <input class="form-control form-control-rounded" id="account_number" name="account_number" type="text" placeholder="Enter Account Number" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Previous Bill Amount </label>
                                                    <input class="form-control form-control-rounded" id="previous_bill_amount" name="previous_bill_amount" type="text" placeholder="Enter Previous Bill Amount" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Total Remaining </label>
                                                    <input class="form-control form-control-rounded" id="total_remaining" name="total_remaining" type="text" placeholder="Enter Total Remaining" required />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">SIM Number </label>
                                                    <input class="form-control form-control-rounded" id="sim_number" name="sim_number" type="text" placeholder="Enter SIM Number" required />
                                                </div>






                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Subtotal Of Texable Services </label>
                                                    <input class="form-control form-control-rounded" id="subtotal" name="subtotal" type="text" placeholder="Enter Subtotal Of Texable Services" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">VAT Ammount Payable </label>
                                                    <input class="form-control form-control-rounded" id="amount" name="vat_amount_payable" type="text" placeholder="Enter VAT Ammount Payable" required />
                                                </div>




                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Due Date  </label>
                                                    <input class="form-control form-control-rounded" id="due_date" name="due_date" type="text" placeholder="Enter Due Date" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Grand Total  </label>
                                                    <input class="form-control form-control-rounded" id="grand_total" name="grand_total" type="text" placeholder="Enter Grand Total" required />
                                                </div>



                                                <div class="col-md-12">
                                                    <button class="btn btn-primary">@if(isset($parts_data)) Edit @else   @endif Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col"> Bill Number</th>
                                                <th scope="col">Bill Date </th>
                                                <th scope="col">Bill Peroid </th>
                                                <th scope="col">Previous Bill Amount</th>
                                                <th scope="col">Payment Received</th>
                                                <th scope="col">Total Remaining</th>
                                                <th scope="col">SIM Number</th>
                                                <th scope="col">Subtotal of Taxable Services</th>
                                                <th scope="col">Vat Amount Payableat 5%</th>
                                                <th scope="col">Subtotal of Non Taxable Services</th>
                                                <th scope="col">due_date</th>
                                                <th scope="col">grand_bill</th>





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
                    <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-title mb-3">DEWA</div>
                                        <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                                            {!! csrf_field() !!}
                                            @if(isset($parts_data))
                                                {{ method_field('PUT') }}
                                            @endif
                                            <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Invoice</label>
                                                    <input class="form-control form-control-rounded" id="invoice" name="invoice"  type="text" placeholder="Enter Invoice" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Issue Date </label>
                                                    <input class="form-control form-control-rounded" id="issue_date" name="issue_date" type="text" placeholder="Issue Date" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Month</label>
                                                    <input class="form-control form-control-rounded" id="month" name="month"  type="text" placeholder="Enter Month" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category"> Period </label>
                                                    <input class="form-control form-control-rounded" id="period" name="period"  type="number" placeholder="Enter Period" />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Account Number</label>
                                                    <input class="form-control form-control-rounded" id="account_number" name="account_number" type="text" placeholder="EnterAccount Number" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Accont Type</label>
                                                    <input class="form-control form-control-rounded" id="account_type" name="account_type" type="text" placeholder="Enter Accont Type" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Business Partner</label>
                                                    <input class="form-control form-control-rounded" id="business_partner" name="business_partner" type="text" placeholder="Enter Accont Type" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Company Name</label>
                                                    <input class="form-control form-control-rounded" id="company_name" name="company_name" type="text" placeholder="Enter Business Partner" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Due Before</label>
                                                    <input class="form-control form-control-rounded" id="due_before" name="due_before" type="text" placeholder="Enter Reference Number" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Electricity</label>
                                                    <input class="form-control form-control-rounded" id="electricity" name="electricity" type="text" placeholder="Enter Due Before" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Water</label>
                                                    <input class="form-control form-control-rounded" id="water" name="water" type="text" placeholder="EnterWater" required />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Total</label>
                                                    <input class="form-control form-control-rounded" id="total" name="total" type="text" placeholder="Enter Total" required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Housing</label>
                                                    <input class="form-control form-control-rounded" id="housing" name="housing" type="text" placeholder="Enter Housing " required />
                                                </div>

                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Sewerage</label>
                                                    <input class="form-control form-control-rounded" id="sewerage" name="sewerage" type="text" placeholder="Enter Sewerage" required />
                                                </div>





                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Additional Charges</label>
                                                    <input class="form-control form-control-rounded" id="additional_charges" name="additional_charges" type="text" placeholder="Enter Additional Charges" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Current Month Total</label>
                                                    <input class="form-control form-control-rounded" id="current_month_total" name="current_month_total" type="text" placeholder="Enter Current Month Total" required />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Previous  Month Total</label>
                                                    <input class="form-control form-control-rounded" id="previous_month_total" name="previous_month_total" type="text" placeholder="Enter Previous  Month Total" required />
                                                </div>


                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Adjustments</label>
                                                    <input class="form-control form-control-rounded" id="adjustment" name="adjustment" type="text" placeholder="Enter Adjustments" required />
                                                </div>




                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Payment Recieved</label>
                                                    <input class="form-control form-control-rounded" id="payment_received" name="payment_received" type="text" placeholder="Enter Payment Recieved" required />
                                                </div>



                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="repair_category">Total Due</label>
                                                    <input class="form-control form-control-rounded" id="total_due" name="total_due" type="text" placeholder="Enter Total Due" required />
                                                </div>







                                                <div class="col-md-12">
                                                    <button class="btn btn-primary">@if(isset($parts_data)) Edit @else   @endif Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"> Invoice</th>
                                                <th scope="col"> Issue Date </th>
                                                <th scope="col"> Month </th>
                                                <th scope="col">Period </th>
                                                <th scope="col">Account Number</th>
                                                <th scope="col">Account Type</th>
                                                <th scope="col">Business Partner</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Due Before</th>
                                                <th scope="col">Electricity</th>
                                                <th scope="col">Electricity</th>
                                                <th scope="col">Water</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Additional Charges</th>
                                                <th scope="col">Current Month Total</th>
                                                <th scope="col">Previous Bill Balance</th>
                                                <th scope="col">Adjustments</th>
                                                <th scope="col">Payment Recieved</th>
                                                <th scope="col">Total Due</th>




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
                </div>
            </div>
        </div>
    </div>
    <!------------------tabs----->
    {{--<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-sm">--}}
    {{--<div class="modal-content">--}}
    {{--<form action="" id="deleteForm" method="post">--}}
    {{--<div class="modal-header">--}}
    {{--<h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>--}}
    {{--<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--{{ csrf_field() }}--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--Are you sure want to delete the data?--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
    {{--<button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

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
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

        });


        {{--function deleteData(id)--}}
        {{--{--}}
        {{--var id = id;--}}
        {{--var url = '{{ route('parts.destroy', ":id") }}';--}}
        {{--url = url.replace(':id', id);--}}
        {{--$("#deleteForm").attr('action', url);--}}
        {{--}--}}

        {{--function deleteSubmit()--}}
        {{--{--}}
        {{--$("#deleteForm").submit();--}}
        {{--}--}}
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
