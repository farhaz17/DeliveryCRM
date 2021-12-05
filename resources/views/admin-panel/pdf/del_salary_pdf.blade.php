<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Assiging Detail</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        /*body {*/
        /*    position: relative;*/
        /*    width: 18cm;*/
        /*    height: 29.7cm;*/
        /*    margin: 0 auto;*/
        /*    color: #001028;*/
        /*    background: #FFFFFF;*/
        /*    font-family: Arial, sans-serif;*/
        /*    font-size: 12px;*/
        /*    font-family: Arial;*/
        /*}*/

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
            vertical-align: bottom;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            border: 1px solid #C1CED9;
            font-size: 10px;

        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;

        }

        table th,
        table td {
            text-align: center;
            border: 1px solid #C1CED9;
        }

        table th {
            padding: 5px 05px;
            color: #5D6975;
            border: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
            text-align: left;
        }

        .heading_color{
            color:#001028;
        }

        /*table .service,*/
        /*table .desc {*/
        /*    text-align: right;*/
        /*}*/

        /*table td {*/
        /*    !*padding: 05px;*!*/
        /*    text-align: left;*/
        /*}*/

        table td.service,
        table td.desc {
            vertical-align: top;
            text-align: left;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
        /*.bike-detail{*/
        /*    background: #0b192b;*/
        /*    color: #ffffff;*/
        /*    padding: 5px;*/
        /*}*/

        .heading-4{
            background: #0b192b;
            color: #ffffff;
            padding: 5px;
            font-size: large;
        }
        .add-comments{
            border: 1px solid #000000;
            width: 700px;
            height: 100px;
        }

    </style>
</head>
<body>


<table class="display table" id="datatable">
    <thead class="thead-dark">
    <tr>
        <th scope="col" >Rider ID</th>
        <th scope="col" >Rider Name</th>
        <th scope="col">Agency</th>
        <th scope="col">City</th>
        <th scope="col">Pay Group</th>
        <th scope="col">Email Address</th>
        <th scope="col">Total Orders Delivered</th>
        <th scope="col">Stacked Orders Delivered</th>
        <th scope="col">Hours Worked within Schedule</th>
        <th scope="col">Rider Drop Fees</th>
        <th scope="col">Rider Guarantee</th>
        <th scope="col">Tips</th>
        <th scope="col">Non-Order Related Work</th>
        <th scope="col">Past Queries Adjustment</th>
        <th scope="col">Bonus</th>
        <th scope="col">Surge</th>
        <th scope="col">Fuel</th>
        <th scope="col">Rider Training Fees</th>
        <th scope="col">Total Rider Earnings</th>
        <th scope="col">Agency Drop Fees</th>
        <th scope="col">Agency Guarantees</th>
        <th scope="col">Rider Insurance</th>
        <th scope="col">Non-Order Related Work</th>
        <th scope="col">Agency Training Fees</th>
        <th scope="col">Past Queries Adjustment	Early Departure Fee</th>
        <th scope="col">Rider Kit</th>
        <th scope="col">Phone Installments</th>
        <th scope="col">Excessive Sim Plan Usage</th>
        <th scope="col">Salik Charges</th>
        <th scope="col">Bike Insurance</th>
        <th scope="col">Traffic Fines</th>
        <th scope="col">Bike Repair Charges</th>
        <th scope="col">Total Agency Earnings</th>
        <th scope="col">Rider Earnings</th>
        <th scope="col">Rider Tips</th>
        <th scope="col">Agency Earnings</th>
        <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>



    @foreach($del_file as $res)
    <tr>
        <td> {{ $res['sr']}}</td>
        <td>{{ $res['rider_id']}}</td>
        <td> {{ $res['rider_name']}}</td>
        <td>{{ $res['agency']}}</td>
        <td>{{ $res['city']}}</td>
        <td>{{ $res['pay_group']}}</td>
        <td>{{ $res['total_orders_delivered']}}</td>
        <td>{{ $res['stacked_orders_delivered']}}</td>
        <td>{{ $res['hours_worked_within_schedule']}}</td>
        <td>{{ $res['rider_drop_fees']}}</td>
        <td>{{ $res['rider_guarantee']}}</td>
        <td>{{ $res['tips']}}</td>
        <td>{{ $res['non_order_related_work']}}</td>
        <td>{{ $res['bonus']}}</td>
        <td>{{ $res['surge']}}</td>
        <td>{{ $res['fuel']}}</td>
        <td>{{ $res['rider_training_fees']}}</td>
        <td>{{ $res['total_rider_earnings']}}</td>
        <td>{{ $res['agency_drop_fees']}}</td>
        <td>{{ $res['agency_guarantees']}}</td>
        <td>{{ $res['rider_insurance']}}</td>
        <td>{{ $res['agency_training_fees']}}</td>
        <td>{{ $res['past_queries_adjustment']}}</td>
        <td>{{ $res['early_departure_fee']}}</td>
        <td>{{ $res['rider_kit']}}</td>
        <td>{{ $res['phone_installments']}}</td>
        <td>{{ $res['excessive_sim_plan_usage']}}</td>
        <td>{{ $res['salik_charges']}}</td>
        <td>{{ $res['bike_insurance']}}</td>
        <td>{{ $res['traffic_fines']}}</td>
        <td>{{ $res['bike_repair_charges']}}</td>
        <td>{{ $res['total_agency_earnings']}}</td>
        <td>{{ $res['rider_earnings']}}</td>
        <td>{{ $res['rider_tips']}}</td>
        <td>{{ $res['agency_earnings']}}</td>
        <td>{{ $res['total']}}</td>
    </tr>
    @endforeach


</table>


</body>
</html>
