<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Purchase 1</title>
    <link rel="stylesheet" href="{{asset('assets/images/repair/style.css')}}" media="all" />
</head>
<body>
<header class="clearfix">
    {{--<div id="logo">--}}
        {{--<img src="{{asset('assets/images/repair/logo.png')}}">--}}
    {{--</div>--}}


   <br>
    <h1>Purchase</h1>
    <div id="company" class="clearfix">
        <div>Zone Delivery Services</div>
        <div>7-12, Opp. Emirates Driving School,<br /> Dubai</div>
        <div>(055) 889 3094</div>
        <div><a href="mailto:company@example.com">info@zonemsp.com</a></div>
   </div>

    <div id="project_puchase">
        <div><span>Purchase No</span>{{$purchase_detail->purchase_no}}</div>

        <div><span>Supplier NAME</span> {{$purchase_detail->suppliers->contact_name}}</div>
        <div><span>Date</span> {{$purchase_detail->created_at->format('d-m-Y') }}</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">Serial No</th>
            <th class="service">Part No</th>
            <th class="service">Part Name</th>
            <th class="desc">Qty</th>
            <th class="service">Price</th>
            <th class="service">Total</th>


        </tr>
        </thead>
        <tbody>


            @foreach ($gamer_array as $obj)
            <tr>
                <td class="service">

                    {{$obj['sn']}}
                </td>

        <td class="service">

            {{$obj['part_no']}}
        </td>
        <td class="desc">
            {{$obj['part_name']}}
        </td>
        <td class="desc">
            {{$obj['qty']}}
        </td>

        <td class="desc">
            {{$obj['price']}}
        </td>

        <td class="desc">
            {{$obj['total']}}
        </td>



    </tr>
@endforeach


        </tbody>

        <tfoot style="background:#ffffff">
            <tr style="background:#ffffff">
              <td class="desc" style="background:#ffffff"></td>
              <td class="desc" style="background:#ffffff"></td>
              <td class="desc" style="background:#ffffff"></td>
              <td class="desc" style="background:#ffffff"></td>
              <td class="desc" style="background:#ffffff; white-space:nowrap; font-weight:bold">Grand Total</td>
              <td class="desc" style="background:#ffffff; white-space:nowrap; font-weight:bold">{{$grand_total}}</td>

            </tr>
          </tfoot>
    </table>

</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>
