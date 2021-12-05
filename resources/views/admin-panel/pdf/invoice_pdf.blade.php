<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <link rel="stylesheet" href="{{asset('assets/images/repair/style.css')}}" media="all" />
    <style>
        .footer_text {
        float: right;
        }
        thead{
            background:#000;
            color:#fff;
        }
        table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        }
        th, td {
        text-align: left;
        padding: 16px;
        }
        tbody  {
        background-color: #ccc;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <h1>Bike Repair Invoice</h1>
</header>
<main>

    <div class="row">
        <div class="col-md-12" id="detail_para" >
            <p>  Date: <b>{{date('d-m-Y')}} </b> </p>
            <p>  Bike Plate No: <b>{{$bike_no}}</b> </p>
            <p>  Bike Chassis No: <b>{{$chassis_no}}</b> </p>
            <p>  Added By: <b> Admin</span></p>
        </div>
    </div>
    <table  id="datatable_parts">
        <thead>
            <tr>
                <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd; color:#fff">Description</th>
                <th class="text-center" style="width: 12%; border-bottom: 2px solid #ddd;  color:#fff">Quantity</th>
                <th class="text-center" style="width: 24%; border-bottom: 2px solid #ddd;  color:#fff">Price</th>
                <th class="text-center" style="width: 26%; border-bottom: 2px solid #ddd; color:#fff">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gamer_array as $row )
            <tr>
                <td style="text-align:center;">{{$row['part_name']}}</td>
                <td style="text-align:center;">{{$row['qty']}}</td>
                <td style="text-align:center;">{{$row['price']}}</td>
                <td style="text-align:center;">{{$row['total']}}</td>
            </tr>

        </tbody>
            @endforeach

        {{-- <tfoot>
            <tr>
                <th>Total: {{$total}}</th>
            </tr>
            <tr>
                <th>Discount: {{$discount}} </th>
            </tr>
                <tr>
                    <th>Grand Total: {{$grand_total}}</th>
                </tr>
                 </tfoot> --}}
     </table>
     <div class="float-xl-right">

     <div class="footer_text">
          Grand Total = {{$total}}<br>
     </div>
     </div>
</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>
