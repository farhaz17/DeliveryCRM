
        <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet</h4>


                    <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="all-uber-limo-icon-tab" data-toggle="tab" href="#allUberLimoIcon" role="tab" aria-controls="allTUberIcon" aria-selected="true"><i class="nav-icon i-Split-Vertical-2 mr-1"></i>All Sheets</a></li>
                        <li class="nav-item"><a class="nav-link" id="new-uber-limo-icon-tab" data-toggle="tab" href="#newUberLimoIcon" role="tab" aria-controls="newUberLimoIcon" aria-selected="false"><i class="nav-icon i-New-Tab mr-1"></i>New Sheets</a></li>
                        <li class="nav-item"><a class="nav-link" id="performa-uber-limo-icon-tab" data-toggle="tab" href="#performaUberLimoIcon" role="tab" aria-controls="performaUberLimoIcon" aria-selected="false"><i class="nav-icon i-Block-Window mr-1"></i> Performa</a></li>
                        <li class="nav-item"><a class="nav-link" id="invoice-ver-uber-limo-icon-tab" data-toggle="tab" href="#invoiceVerUberLimoIcon" role="tab" aria-controls="invoiceVerUberLimoIcon" aria-selected="false"><i class="nav-icon i-Check mr-1"></i>Invoice Verifaction</a></li>
                        <li class="nav-item"><a class="nav-link" id="invoice-con-uber-limo-icon-tab" data-toggle="tab" href="#invoiceConUberLimoIcon" role="tab" aria-controls="invoiceConUberLimoIcon" aria-selected="false"><i class="nav-icon i-Approved-Window mr-1"></i>Confirmed Invoices</a></li>
                        <li class="nav-item"><a class="nav-link" id="showing-slip-uber-limo-icon-tab" data-toggle="tab" href="#showingSlipUberLimoIcon" role="tab" aria-controls="showingSlipUberLimoIcon" aria-selected="false"><i class="nav-icon i-Split-Horizontal-2-Window mr-1"></i>Showing Slip</a></li>
                        <li class="nav-item"><a class="nav-link" id="slip-confirm-uber-limo-icon-tab" data-toggle="tab" href="#slipConfirmUberLimoIcon" role="tab" aria-controls="slipConfirmUberLimoIcon" aria-selected="false"><i class="nav-icon i-Line-Chart mr-1"></i>Slip Confirmed</a></li>
                        <li class="nav-item"><a class="nav-link" id="payment-uber-icon-limo-tab" data-toggle="tab" href="#paymentUberLimoIcon" role="tab" aria-controls="paymentUberLimoIcon" aria-selected="false"><i class="nav-icon i-Money-2 mr-1"></i>Payment</a></li>
                        <li class="nav-item"><a class="nav-link" id="ready-uber-limo-icon-tab" data-toggle="tab" href="#readyUberLimoIcon" role="tab" aria-controls="readyUberLimoIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i>Ready </a></li>
                    </ul>
                    <div class="tab-content" id="myIconTabContent">
                        <div class="tab-pane fade show active" id="allUberLimoIcon" role="tabpanel" aria-labelledby="all-car-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (All Sheets)</h4>

                            <table class="display table" id="datatable_uber-limo_1" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="newUberLimoIcon" role="tabpanel" aria-labelledby="all-Uber-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (New Sheets)</h4>

                            <table class="display table" id="datatable_uber-limo_2" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Transfer To Performa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '1')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary performa-tal">Transfer To Performa</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div class="tab-pane fade" id="performaUberLimoIcon" role="tabpanel" aria-labelledby="all-car-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Performa Sheets)</h4>

                            <table class="display table" id="datatable_uber-limo_3" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Generate Invoice</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '2')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary performa-tal">Invoices</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>





                        <div class="tab-pane fade" id="invoiceVerUberLimoIcon" role="tabpanel" aria-labelledby="all-car-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Invoice Verification)</h4>

                            <table class="display table" id="datatable_uber-limo_4" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '3')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success performa-tal">Confirm Invoice</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>





                        <div class="tab-pane fade" id="invoiceConUberLimoIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Invoice Confirmation)</h4>

                            <table class="display table" id="datatable_uber-limo_5" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '4')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success performa-tal">Transfer To Show Slip</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div class="tab-pane fade" id="showingSlipUberLimoIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Showing Slip)</h4>

                            <table class="display table" id="datatable_uber-limo_6" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '5')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>




                        <div class="tab-pane fade" id="slipConfirmUberLimoIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Slip Confirmation)</h4>

                            <table class="display table" id="datatable_uber-limo_7" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Generate Payment</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '6')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-success m-2">Confirmed By Rider</span>

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success performa-tal">Generate Payment</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>




                        <div class="tab-pane fade" id="paymentUberLimoIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Payment)</h4>

                            <table class="display table" id="datatable_uber-limo_8" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Download Orignal Sheet</th>
                                    <th scope="col">Transfer To Rider</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '7')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success performa-tal">Transfer To Rider</a>
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="tab-pane fade" id="readyUberLimoIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
                            <h4 class="card-title mb-3 text-center"> <span class="text-success font-weight-bold">Uber Limo</span> Salary Sheet (Ready)</h4>

                            <table class="display table" id="datatable_uber-limo_9" width="100%">
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($uber_file as $res)
                                @if($res['status'] == '8')

                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td> {{ $res['uber_limo_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                        <!--                        <a class="attachment_display" href="{{ $res['pdf_route']}}"target="_blank"><i class="fa fa-print"></i></a>-->

                                    </td>
                                    <td>

                                        <span class="badge badge-pill badge-success m-2">Completed</span>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div> 

  <script>
       $(document).ready(function () {

            $('#datatable_uber-limo_1,datatable_uber-limo_2,datatable_uber-limo_3,datatable_uber-limo_4,datatable_uber-limo_5,datatable_uber-limo_5,datatable_uber-limo_6,datatable_uber-limo_7,datatable_uber-limo_8,datatable_uber-limo_9,datatable_uber-limo_10').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('id'); // get current tab

            var split_ab = currentTab;
            // alert(split_ab[1]);

            if(split_ab=="all-uber-limo-icon-tab"){

                var table = $('#datatable_uber-limo_1').DataTable();
                table.columns.adjust().draw();

            }

            else if(split_ab=="new-car-limo--icon-tab"){

                var table = $('#datatable_uber-limo_2').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

            }
            else if(split_ab=="performa-car-limo-icon-tab"){
                var table = $('#datatable_uber-limo_3').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }

            else if(split_ab=="invoice-ver-uber-limo-icon-tab"){
                var table = $('#datatable_uber-limo_4').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }


            else if(split_ab=="invoice-con-uber-limo-icon-tab"){
                var table = $('#datatable_uber-limo_5').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }


            else if(split_ab=="showing-slip-uber-limo-icon-tab"){
                var table = $('#datatable_uber-limo_6').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }



            else if(split_ab=="slip-confirm-uber-limo-icon-tab"){
                var table = $('#datatable_uber-limo_7').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }



            else if(split_ab=="payment-uber-limo-icon-tab"){
                var table = $('#datatable_uber-limo_8').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            else{
                var table = $('#datatable_uber-limo_9').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw()

            }


        }) ;
    });

</script>
