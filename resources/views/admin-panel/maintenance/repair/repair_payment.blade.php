@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }
        div#detail_para {
    line-height: 1.5px;
    margin-top: 20px;
      }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Repair</a></li>
            <li>Payment Detail</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-4"> </div>
         <div class="col-md-4">
            <div class="row">
                <div class="col-md-12"  style="color:#ffffff;height: 65px; background:#008d4c">
                        <span class="payment_success" style="font-size:16px">
                            <br>
                            Payment Successfully Added!
                        </span>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12" id="detail_para" >
                    <p>  Date: 12-09-2021</p>
                    <p>  Bike Plate No: {{$bike_no}}</p>
                    <p>  Added By: Admin</p>

                </div>
            </div>



            <div class="row">
                <div class="col-md-12" >

             <table class="table table-striped text-11 table-condensed">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd;">Description</th>
                        <th class="text-center" style="width: 12%; border-bottom: 2px solid #ddd;">Quantity</th>
                        <th class="text-center" style="width: 24%; border-bottom: 2px solid #ddd;">Price</th>
                        <th class="text-center" style="width: 26%; border-bottom: 2px solid #ddd;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gamer_array as $row )
                    <tr>
                        <td>{{$row['part_name']}}</td>
                        <td style="text-align:center;">{{$row['qty']}}</td>
                        <td class="text-right">{{$row['price']}}</td>
                        <td class="text-right">{{$row['sub_total']}}</td>
                    </tr>
                </tbody>
                    @endforeach

                <tfoot>
                    <tr>
                        <th class="text-left" colspan="2">Total</th>
                        <th colspan="2" class="text-right">{{$total}}</th>
                    </tr>

                    <tr>
                        <th class="text-left" colspan="2">Discount</th>
                        <th colspan="2" class="text-right">{{$discount}}</th>
                    </tr>

                        <tr>
                            <th class="text-left" colspan="2">Grand Total</th>
                            <th colspan="2" class="text-right">{{$grand_total}}</th>
                        </tr>
                         </tfoot>
             </table>

                </div>
            </div>


            <div class="row">
                <div class="col-md-12" >
                    <span class="pull-right col-md-12">
                        <button onclick="window.print();" class="btn btn-block" style="background:#008d4c;color:#ffffff">Print</button>                            </span>
                    </span>

                </div>
            </div>

        </div>




        <div class="col-md-4">
        </div>

    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



@endsection
