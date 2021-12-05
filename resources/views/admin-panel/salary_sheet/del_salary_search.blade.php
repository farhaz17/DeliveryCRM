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
        overflow: hidden;
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
    .footer-text{
        color:#ffffff;

    }


</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Salary Sheet</a></li>
        <li>Deliveroo Salary Sheet Search</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>




    <div class="row">







    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">


                    <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Deliveroo</span> Salary Sheet</h4>
                <div class="container"> </div>
                 <div class="table-responsive ar_platform">
                    <table class="table table-striped" id="datatable-1">
                        <thead class="thead-dark">
                        <tr>
                                        <th>Rider ID</th>
                                        <th>Rider Name</th>
                                        <th>Agency</th>
                                        <th>City</th>
                                        <th>Pay Group</th>
                                        <th>Email Address</th>
                                        <th>Total Orders Delivered</th>
                                        <th>Stacked Orders Delivered</th>
                                        <th>Hours Worked within Schedule</th>
                                        <th>Rider Drop Fees</th>
                                        <th>Rider Guarantee</th>
                                        <th>Tips</th>
                                        <th>Non Order Related Work 1</th>
                                        <th>Past Queries Adjustment 1</th>
                                        <th>Bonus</th>
                                        <th>Surge</th>
                                        <th>Fuel</th>
                                        <th>Rider Training Fees</th>
                                        <th>Total Rider Earnings</th>
                                        <th>Agency Drop Fees</th>
                                        <th>Agency Guarantees</th>
                                        <th>Rider Insurance</th>
                                        <th>Non Order Related Work 2</th>
                                        <th>Past Queries Adjustment 2</th>
                                        <th>Non-Order Related Work</th>
                                        <th>Agency Training Fees</th>
                                        <th>Past Queries Adjustment	</th>
                                        <th>Early Departure Fee</th>
                                        <th>Rider Kit</th>
                                        <th>Phone Installments</th>
                                        <th>Excessive Sim Plan Usage</th>
                                        <th>Salik Charges</th>
                                        <th>Bike Insurance</th>
                                        <th>Traffic Fines</th>
                                        <th>Bike Repair Charges</th>
                                        <th>Total Agency Earnings</th>
                                        <th>Rider Earnings</th>
                                        <th>Rider Tips</th>
                                        <th>Agency Earnings</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($del_file as $res)
                                    <tr>
                                        <td class="1">{{ $res->rider_id}}</td>
                                        <td class="2"> {{ $res->rider_name}}</td>
                                        <td class="3">{{ $res->agency}}</td>
                                        <td  class="4">{{ $res->city}}</td>
                                        <td class="5">{{ $res->pay_group}}</td>
                                        <td class="6">{{ $res->email_address}}</td>
                                        <td class="7">{{ $res->total_orders_delivered}}</td>
                                        <td class="8">{{ $res->stacked_orders_delivered}}</td>
                                        <td class="9">{{ $res->hours_worked_within_schedule}}</td>
                                        <td  class="10">{{ $res->rider_drop_fees}}</td>
                                        <td class="11">{{ $res->rider_guarantee}}</td>
                                        <td class="12">{{ $res->tips}}</td>
                                        <td class="13">{{ $res->non_order_related_work_1}}</td>
                                        <td class="14">{{ $res->past_queries_adjustmen_1}}</td>
                                        <td class="15">{{ $res->bonus}}</td>
                                        <td class="16">{{ $res->surge}}</td>
                                        <td class="17">{{ $res->fuel}}</td>
                                        <td class="18">{{ $res->rider_training_fees}}</td>
                                        <td class="19">{{ $res->total_rider_earnings}}</td>
                                        <td class="20">{{ $res->agency_drop_fees}}</td>
                                        <td class="21">{{ $res->agency_guarantees}}</td>
                                        <td class="22">{{ $res->rider_insurance}}</td>
                                        <td class="13">{{ $res->non_order_related_work_2}}</td>
                                        <td class="14">{{ $res->past_queries_adjustmen_2}}</td>
                                        <td class="23">{{ $res->non_order_related_work}}</td>
                                        <td class="24">{{ $res->agency_training_fees}}</td>
                                        <td class="25">{{ $res->past_queries_adjustment}}</td>
                                        <td class="26">{{ $res->early_departure_fee}}</td>
                                        <td class="27">{{ $res->rider_kit}}</td>
                                        <td class="28">{{ $res->phone_installments}}</td>
                                        <td class="29">{{ $res->excessive_sim_plan_usage}}</td>
                                        <td class="30">{{ $res->salik_charges}}</td>
                                        <td class="31">{{ $res->bike_insurance}}</td>
                                        <td class="32">{{ $res->traffic_fines}}</td>
                                        <td class="33">{{ $res->bike_repair_charges}}</td>
                                        <td class="34">{{ $res->total_agency_earnings}}</td>
                                        <td class="35">{{ $res->rider_earnings}}</td>
                                        <td class="36">{{ $res->rider_tips}}</td>
                                        <td class="37">{{ $res->agency_earnings}}</td>
                                        <td class="38">{{ $res->total}}</td>
                                    </tr>
                                    @endforeach
                        <tfoot width="100%">
                        <tr>
                            <th scope="col 1" class="footer-text"  >Rider ID</th>
                            <th scope="col 2"  class="footer-text" >Rider Name</th>
                            <th scope="col 3"  class="footer-text">Agency</th>
                            <th scope="col 4"  class="footer-text">City</th>
                            <th scope="col 5"  class="footer-text">Pay Group</th>
                            <th scope="col 6"  class="footer-text">Email Address</th>
                            <th scope="col 7"><b>Total</b>= {{$del_file->sum('total_orders_delivered')}}</th>
                            <th scope="col 8"><b>Total</b>= {{$del_file->sum('stacked_orders_delivered')}}</th>
                            <th scope="col 9"><b>Total</b>= {{$del_file->sum('hours_worked_within_schedule')}}</th>
                            <th scope="col 10"><b>Total</b>= {{$del_file->sum('rider_drop_fees')}}</th>
                            <th scope="col 11"><b>Total</b>= {{$del_file->sum('rider_guarantee')}}</th>
                            <th scope="col 12"><b>Total</b>= {{$del_file->sum('tips')}}</th>
                            <th scope="col 13"><b>Total</b>={{$del_file->sum('non_order_related_work')}}</th>
                            <th scope="col 14"><b>Total</b>= {{$del_file->sum('past_queries_adjustment')}}</th>
                            <th scope="col 15"><b>Total</b>= {{$del_file->sum('bonus')}}</th>
                            <th scope="col 16"><b>Total</b>={{$del_file->sum('surge')}}</th>
                            <th scope="col 17"><b>Total</b>={{$del_file->sum('fuel')}}</th>
                            <th scope="col 18"><b>Total</b>={{$del_file->sum('rider_training_fees')}}</th>
                            <th scope="col 19"><b>Total</b>={{$del_file->sum('total_rider_earning')}}</th>
                            <th scope="col 20"><b>Total</b>= {{$del_file->sum('agency_drop_fees')}}</th>
                            <th scope="col 21"><b>Total</b>= {{$del_file->sum('agency_guarantees')}}</th>
                            <th scope="col 22"><b>Total</b>= ={{$del_file->sum('rider_insurance')}}</th>
                            <th scope="col 23"><b>Total</b>= ={{$del_file->sum('non_order_related_work')}}</th>
                            <th scope="col 24"><b>Total</b>=  ={{$del_file->sum('agency_training_fees')}}</th>
                            <th scope="col 25"><b>Total</b>={{$del_file->sum('past_queries_adjustment')}}	</th>
                            <th scope="col 26"><b>Total</b>={{$del_file->sum('early_departure_fee')}}</th>
                            <th scope="col 27"><b>Total</b>={{$del_file->sum('rider_kit')}}</th>
                            <th scope="col 28"><b>Total</b>={{$del_file->sum('phone_installments')}}</th>
                            <th scope="col 29"><b>Total</b>={{$del_file->sum('excessive_sim_plan_usage')}}</th>
                            <th scope="col 30"><b>Total</b>={{$del_file->sum('salik_charges')}}</th>
                            <th scope="col 31"><b>Total</b>={{$del_file->sum('bike_insurance')}}</th>
                            <th scope="col 32"><b>Total</b>={{$del_file->sum('traffic_fines')}}</th>
                            <th scope="col 33"><b>Total</b>={{$del_file->sum('bike_repair_charges')}}</th>
                            <th scope="col 34"><b>Total</b>={{$del_file->sum('rider_earnings')}}</th>
                            <th scope="col 35"><b>Total</b>={{$del_file->sum('rider_earnings')}}</th>
                            <th scope="col 36"><b>Total</b>={{$del_file->sum('')}}</th>
                            <th scope="col 37"><b>Total</b>={{$del_file->sum('agency_earnings')}}</th>
                            <th scope="col 38"><b>Total</b>={{$del_file->sum('total')}}</th>
                        </tr>
                        </tfoot>
                                </table>
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
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>

    // $(window).scroll(function() {
    //     if ( $(window).scrollTop() >= 5 ) {
    //         $('.layout-sidebar-large .main-header').css('z-index', '-1');
    //
    //     } else {
    //         $('.layout-sidebar-large .main-header').css('z-index', '100');
    //     }
    // });
        $('#datatable-1').DataTable( {
            searching: true,
            paging: true,
            ordering: true,
            info: false,
            scrollY: 600,
            scrollX: true,
            // scroller: true

            // fixedHeader: true,

            // fixedHeader: {
            //     header: true,
            //     footer: true,
            //
            // }


        });

</script>

<!--"scrollY": "1050px",-->
<!--"sScrollX": "100%",-->
<!--"scrollCollapse": true,-->
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
