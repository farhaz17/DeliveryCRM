@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }
</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Salary Sheet</a></li>
        <li>Careem Salary Sheet Search</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>




<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Careem</span> Salary Sheet</h4>
                <table class="table table-striped" id="datatable-1" width="100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col 1" > Driver ID</th>
                        <th scope="col 2" >Driver Phone</th>
                        <th scope="col 3">Driver Name</th>
                        <th scope="col 4">Limo ID</th>
                        <th scope="col 5">Company Name</th>
                        <th scope="col 6">Payment Method</th>
                        <th scope="col 7">Total Driver Base Cost</th>
                        <th scope="col 8">Total Driver Other Cost</th>
                        <th scope="col 9">Total Driver Payment</th>
                        <th scope="col 10">Payable Amount</th>
                        <th scope="col 11">Combined Payment Company Part</th>
                        <th scope="col 13">Country</th>
                        <th scope="col 14">City Name</th>
                        <th scope="col 15">Currency</th>
                        <th scope="col 16">Pay Date</th>
                        <th scope="col 17">ADJ Trip Compensation</th>
                        <th scope="col 18">ADJ Device Payment</th>
                        <th scope="col 19">ADJ Salik</th>
                        <th scope="col 20">ADJ Lost Device</th>
                        <th scope="col 21">ADJ Bonus</th>
                        <th scope="col 22">ADJ SIM Excess</th>
                        <th scope="col 23">ADJ Last Month Adjustment</th>
                        <th scope="col 24">ADJ Late Arrival</th>
                        <th scope="col 25">ADJ Back Out</th>
                        <th scope="col 26">ADJ Arrived To Early</th>
                        <th scope="col 27">ADJ Cash Collection</th>
                        <th scope="col 28">ADJ Wrong Guest</th>
                        <th scope="col 29">ADJ Cash Per Trip Payment
                        </th>
                        <th scope="col 30">ADJ Driver Tip
                        </th>
                        <th scope="col 31">ADJ Wire Fees
                        </th>
                        <th scope="col 32">ADJ 4h Guarantee
                        </th>
                        <th scope="col 33">ADJ 6h Guarantee
                        </th>
                        <th scope="col 34">ADJ Trip Referred User
                        </th>
                        <th scope="col 35">ADJ Referred Driver Adjustment
                        </th>
                        <th scope="col 36">ADJ Referring Driver Adjustment
                        </th>
                        <th scope="col 37">ADJ Trip By Referred Driver
                        </th>
                        <th scope="col 38">ADJ Data Plan Fees
                        </th>
                        <th scope="col 38">ADJ Fines
                        </th>
                        <th scope="col 38">ADJ CASH Paid In From Captain

                        </th>
                        <th scope="col 38">ADJ Wrong Amount Entered

                        </th>
                        <th scope="col 38">ADJ Health Insurance

                        </th>
                        <th scope="col 38">ADJ Items Bought

                        </th>
                        <th scope="col 38">ADJ Guarantee

                        </th>
                        <th scope="col 38">Jordan Car Rental

                        </th>
                        <th scope="col 38">FAWRY
                        </th>
                        <th scope="col 38">Captain Bonus
                        </th>
                        <th scope="col 38">Referring driver trip target reward amount
                        </th>
                        <th scope="col 38">Referred driver trip target reward amount

                        </th>
                        <th scope="col 38">Cash Paid In By Captain from POS
                            Lease Deduction
                        </th>
                        <th scope="col 38">Limo Commissions</th>
                        <th scope="col 38">Trainer Payment</th>
                        <th scope="col 38">Traffic Violation</th>
                        <th scope="col 38">Captain Careem Card</th>
                        <th scope="col 38">One Time Card Payment</th>
                        <th scope="col 38">Rickshaw Adjustment</th>
                        <th scope="col 38">Card Operator Fees</th>
                        <th scope="col 38">One Card Commission Deduction</th>
                        <th scope="col 38">Emergency Fund Deduction</th>
                        <th scope="col 38">Vendor Bonus Tax</th>
                        <th scope="col 38">Captain Bonus Tax</th>
                        <th scope="col 38">Uncollected Cash For Trip</th>
                        <th scope="col 38">Past Trip Earning</th>
                        <th scope="col 38">Easypaisa Cash Collection</th>
                        <th scope="col 38">Captain Loyalty Program</th>
                        <th scope="col 38">Marketing Expenses</th>
                        <th scope="col 38">Packages cash collection</th>
                        <th scope="col 38">Madfooatcom payment</th>
                        <th scope="col 38">STC cash payment</th>
                        <th scope="col 38">Background check</th>
                        <th scope="col 38">Fine Reimbursement</th>
                        <th scope="col 38">Pooling Trip Earnings</th>
                        <th scope="col 38">SWITCH cash payment</th>
                        <th scope="col 38">top up commission</th>
                        <th scope="col 38">quality bonus</th>
                        <th scope="col 38">midweek paid amount</th>
                        <th scope="col 38">bonus for non cash trip</th>
                        <th scope="col 38">refundable deposit</th>
                        <th scope="col 38">intercity pooling bonus</th>
                        <th scope="col 38">captain loyalty trip peak bonus</th>
                        <th scope="col 38">careempay captain debt payment</th>
                        <th scope="col 38">transfer to careempay</th>
                        <th scope="col 38">now cash refusal</th>
                        <th scope="col 38">vat settlement adjustment</th>
                        <th scope="col 38">Number Of Bank Details</th>
                        <th scope="col 38">Bank Wire Possible</th>
                        <th scope="col 38">Document Number</th>


                    </tr>
                    </thead>
                    @foreach($careem_limo_file as $res)
                    <tr>
                        <td class="1">{{ $res->driver_id}}</td>
                        <td class="2"> {{ $res->driver_phone}}</td>
                        <td class="3">{{ $res->driver_name}}</td>
                        <td  class="4">{{ $res->limo_id}}</td>
                        <td class="5">{{ $res->company_name}}</td>
                        <td class="6">{{ $res->payment_method}}</td>
                        <td class="7">{{ $res->total_driver_base_cost}}</td>
                        <td class="8">{{ $res->total_driver_other_cost}}</td>
                        <td class="8">{{ $res->total_driver_payment}}</td>

                        <td class="9">{{ $res->payable_amount}}</td>
                        <td  class="10">{{ $res->combined_payment_company_part}}</td>

                        <td class="11">{{ $res->country}}</td>
                        <td class="12">{{ $res->city_name}}</td>
                        <td class="13">{{ $res->currency}}</td>
                        <td class="14">{{ $res->pay_date}}</td>

                        <td class="16">{{ $res->adj_device_payment}}</td>
                        <td class="17">{{ $res->adj_salik}}</td>
                        <td class="18">{{ $res->adj_lost_device}}</td>
                        <td class="19">{{ $res->adj_bonus}}</td>
                        <td class="20">{{ $res->adj_sim_excess}}</td>
                        <td class="21">{{ $res->adj_late_arrival}}</td>
                        <td class="22">{{ $res->adj_back_out}}</td>
                        <td class="23">{{ $res->adj_arrived_to_early}}</td>
                        <td class="24">{{ $res->adj_cash_collection}}</td>
                        <td class="25">{{ $res->adj_wrong_guest}}</td>
                        <td class="26">{{ $res->adj_cash_per_trip_payment}}</td>
                        <td class="27">{{ $res->adj_wire_fees}}</td>
                        <td class="28">{{ $res->adj_4h_guarantee}}</td>
                        <td class="29">{{ $res->adj_6h_guarantee}}</td>
                        <td class="30">{{ $res->adj_trip_referred_user}}</td>
                        <td class="31">{{ $res->adj_referred_driver_adjustment}}</td>
                        <td class="32">{{ $res->adj_referring_driver_adjustment}}</td>
                        <td class="33">{{ $res->adj_trip_by_referred_driver}}</td>
                        <td class="34">{{ $res->total_agency_earnings}}</td>
                        <td class="35">{{ $res->adj_data_plan_fees}}</td>
                        <td class="36">{{ $res->adj_fines}}</td>
                        <td class="37">{{ $res->adj_cash_paid_in_from_captain}}</td>
                        <td class="38">{{ $res->adj_wrong_amount_entered}}</td>
                        <td class="38">{{ $res->adj_health_insurance}}</td>
                        <td class="38">{{ $res->adj_items_bought}}</td>
                        <td class="38">{{ $res->adj_guarantee}}</td>
                        <td class="38">{{ $res->jordan_car_rental}}</td>
                        <td class="38">{{ $res->fawry}}</td>
                        <td class="38">{{ $res->captain_bonus}}</td>
                        <td class="38">{{ $res->referring_driver_trip_target_reward_amount}}</td>
                        <td class="38">{{ $res->referred_driver_trip_target_reward_amount}}</td>
                        <td class="38">{{ $res->cash_paid_in_by_captain_from_pos}}</td>
                        <td class="38">{{ $res->lease_deduction}}</td>
                        <td class="38">{{ $res->limo_commissions}}</td>
                        <td class="38">{{ $res->trainer_payment}}</td>
                        <td class="38">{{ $res->traffic_violation}}</td>
                        <td class="38">{{ $res->captain_careem_card}}</td>
                        <td class="38">{{ $res->one_time_card_payment}}</td>
                        <td class="38">{{ $res->rickshaw_adjustment}}</td>
                        <td class="38">{{ $res->card_operator_fees}}</td>
                        <td class="38">{{ $res->one_card_commission_deduction}}</td>
                        <td class="38">{{ $res->emergency_fund_deduction}}</td>
                        <td class="38">{{ $res->vendor_bonus_tax}}</td>
                        <td class="38">{{ $res->captain_bonus_tax}}</td>
                        <td class="38">{{ $res->uncollected_cash_for_trip}}</td>
                        <td class="38">{{ $res->past_trip_earning}}</td>
                        <td class="38">{{ $res->easypaisa_cash_collection}}</td>
                        <td class="38">{{ $res->captain_loyalty_program}}</td>
                        <td class="38">{{ $res->marketing_expenses}}</td>
                        <td class="38">{{ $res->packages_cash_collection}}</td>
                        <td class="38">{{ $res->madfooatcom_payment}}</td>
                        <td class="38">{{ $res->stc_cash_payment}}</td>
                        <td class="38">{{ $res->background_check}}</td>
                        <td class="38">{{ $res->fine_reimbursement}}</td>
                        <td class="38">{{ $res->pooling_trip_earnings}}</td>
                        <td class="38">{{ $res->switch_cash_payment}}</td>
                        <td class="38">{{ $res->top_up_commission}}</td>
                        <td class="38">{{ $res->quality_bonus}}</td>
                        <td class="38">{{ $res->midweek_paid_amount}}</td>
                        <td class="38">{{ $res->bonus_for_non_cash_trip}}</td>
                        <td class="38">{{ $res->refundable_deposit}}</td>
                        <td class="38">{{ $res->intercity_pooling_bonus}}</td>
                        <td class="38">{{ $res->captain_loyalty_trip_peak_bonus}}</td>
                        <td class="38">{{ $res->careempay_captain_debt_payment}}</td>
                        <td class="38">{{ $res->transfer_to_careempay}}</td>
                        <td class="38">{{ $res->now_cash_refusal}}</td>
                        <td class="38">{{ $res->vat_settlement_adjustment}}</td>
                        <td class="38">{{ $res->number_of_bank_details}}</td>
                        <td class="38">{{ $res->bank_wire_possible}}</td>
                        <td class="38">{{ $res->document_number}}</td>
                        <td class="38">{{ $res->date_from}}</td>
                        <td class="38">{{ $res->date_to}}</td>



                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>







@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>


    $('#datatable-1').DataTable( {
        "aaSorting": [[0, 'desc']],
        "pageLength": 10,
        "scrollY": true,
        "scrollX": true,
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
