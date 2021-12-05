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
    .show-table{
        position: sticky;
    }
    /*.layout-sidebar-large .main-header {*/
    /*    position: fixed;*/
    /*    width: 100%;*/
    /*    height: 80px;*/
    /*    box-shadow: 0 1px 15px rgba(0, 0, 0, 0.04), 0 1px 6px rgba(0, 0, 0, 0.04);*/
    /*    display: flex;*/
    /*    align-items: center;*/
    /*    flex-wrap: wrap;*/
    /*    justify-content: space-between;*/
    /*    background: #fff;*/
    /*    z-index: -1;*/
    /*}*/
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
        <li>Talabat Salary Sheet Search</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>




<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <div class="talabat_table">
                    <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet</h4>
                    <table class="display table table-striped" id="example" width="100%">

                        <thead class="thead-dark">
                        <tr class="show-table">

                            <th scope="col" >Rider ID</th>
                            <th scope="col" >Rider Name</th>
                            <th scope="col">Vendor</th>
                            <th scope="col">City</th>
                            <th scope="col">Deliveries</th>
                            <th scope="col">Hour</th>
                            <th scope="col">Pay Hour</th>
                            <th scope="col">Pay Deliveries</th>
                            <th scope="col">Pay Per Hour Payment</th>
                            <th scope="col">Pay Per Order Payment</th>
                            <th scope="col">Total Pay</th>
                            <th scope="col">Zomato Tip</th>
                            <th scope="col">Talabat TIP</th>
                            <th scope="col">Total Tip</th>
                            <th scope="col">Incetive</th>
                            <th scope="col">Total Payment</th>
                            <th scope="col">Date From</th>
                            <th scope="col">Date To</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($talabat as $res)
                        <tr>
                            <td>{{ $res->rider_id}}</td>
                            <td> {{ $res->rider_name}}</td>
                            <td>{{ $res->vendor}}</td>
                            <td>{{ $res->city}}</td>
                            <td>{{ $res->deliveries}}</td>
                            <td>{{ $res->hours}}</td>
                            <td>{{ $res->pay_hour}}</td>
                            <td>{{ $res->pay_deliveries}}</td>
                            <td>{{ $res->pay_per_hour_payment}}</td>
                            <td>{{ $res->pay_per_order_payment}}</td>
                            <td>{{ $res->total_pay}}</td>
                            <td>{{ $res->zomato_tip}}</td>
                            <td>{{ $res->talabat_tip}}</td>
                            <td>{{ $res->total_tip}}</td>
                            <td>{{ $res->incetive}}</td>
                            <td>{{ $res->total_payment}}</td>
                            <td>{{ $res->date_from}}</td>
                            <td>{{ $res->date_to}}</td>
                        </tr>
                        @endforeach
                        </tbody>

                        <tfoot width="100%">
                        <tr>

                            <th scope="col" class="footer-text" >Rider ID</th>
                            <th scope="col" class="footer-text" >Rider Name</th>
                            <th scope="col" class="footer-text">Vendor</th>
                            <th scope="col" class="footer-text">City</th>
                            <th scope="col" class="footer-text">Deliveries</th>
                            <th scope="col"><b>Total</b>={{ round($talabat->sum('hours'), 2)}}</th>
                            <th scope="col"> <b>Total</b>={{ round($talabat->sum('pay_hour'))}}</th>
                            <th scope="col"> <b>Total</b>={{ round($talabat->sum('pay_deliveries'))}}</th>
                            <th scope="col"><b>Total</b>={{ round($talabat->sum('pay_per_hour_payment'))}}</th>
                            <th scope="col"> <b>Total</b>={{ round($talabat->sum('pay_per_order_payment'))}}</th>
                            <th scope="col"><b>Total</b>={{ round($talabat->sum('total_pay'))}}</th>
                            <th scope="col"> <b>Total</b>={{ round($talabat->sum('zomato_tip'))}}</th>
                            <th scope="col"><b>Total</b>={{ round($talabat->sum('talabat_tip'))}}</th>
                            <th scope="col"><b>Total</b>={{ round($talabat->sum('total_tip'))}}</th>
                            <th scope="col"> <b>Total</b>={{ round($talabat->sum('incentive'))}}</th>
                            <th scope="col" class="footer-text">Date From</th>
                            <th scope="col" class="footer-text">Date To</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>





                <br>




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
    $(window).scroll(function() {
        if ( $(window).scrollTop() >= 5 ) {
            $('.layout-sidebar-large .main-header').css('z-index', '-1');

        } else {
            $('.layout-sidebar-large .main-header').css('z-index', '100');
        }
    });

    $(document).ready(function() {
        var table = $('#example').DataTable( {


            fixedHeader: {
                header: true,
                footer: true

            }
        } );
    } );
    $(document).ready(function () {
        'use strict';

        $('#datatable').DataTable( {
            fixedHeader: {
                header: true,
                footer: true
            }
            // "fixedHeader": true,
        });
        $('#datatable-1').DataTable( {
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
