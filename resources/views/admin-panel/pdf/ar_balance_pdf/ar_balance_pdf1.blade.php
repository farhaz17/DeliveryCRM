
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Assigning Detail</title>
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

        body {
            position: relative;
            width: 18cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

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
            font-size: 15px;

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
        .label_color{
            color: #5D6975;
            float:right
        }
        .heading_color{
            color:#001028;
        }

        /*table .service,*/
        /*table .desc {*/
        /*    text-align: right;*/
        /*}*/

        table td {
            padding: 05px;
            text-align: left;
        }

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

<header class="clearfix" style="line-height: 1.2;">
    <p>  <b> {{$name}} </b></p>
    <p><b>PPUID</b> : {{$ppuid}}</p>
    <p><b>Opening Balance</b> :{{$opening_balance}}</p>
    <p><b>Current Balance</b> : {{$current_bal}}</p>

</header>

<table>
    <tr style="font-size: 13px">
        <th scope="col">Platform </th>
        <th scope="col">Date </th>
        <th scope="col">Description</th>
        <th scope="col">Amount </th>
        <th scope="col">Addition</th>
        <th scope="col">Subtraction</th>
        <th scope="col">Balance</th>

    </tr>

    <tbody>
    @foreach($statement as $res)
        <tr style="font-size: 13px">
            <td>{{$res['platform']}}</td>
            <td>{{$res['date']}}</td>
            <td>{{$res['description']}}</td>
            <td>{{$res['amount']}}</td>
            <td>{{$res['addition']}}</td>
            <td>{{$res['subs']}}</td>
            <td>{{$res['balance']}}</td>

        </tr>
    @endforeach

</table>

<footer>
   This is compueter generated balance statement
</footer>
</body>
</html>








