<style>
    #datatable2 .table th, .table td{
        border-top : unset !important;
    }
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
    .mdl-btns {
        padding: 0px;
        font-size: 11px;
    }
    a.attachment_display.btn.btn-success.modal-btn {
        padding: 0px;
    }
</style>

<ul class="nav nav-tabs" id="myIconTab" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="all-tal-icon-tab" data-toggle="tab" href="#allTalIcon" role="tab" aria-controls="allTalIcon" aria-selected="true"><i class="nav-icon i-Split-Vertical-2 mr-1"></i>All Sheets</a></li>
    <li class="nav-item"><a class="nav-link" id="new-tal-icon-tab" data-toggle="tab" href="#newTalIcon" role="tab" aria-controls="newTalIcon" aria-selected="false"><i class="nav-icon i-New-Tab mr-1"></i>New Sheets</a></li>
    <li class="nav-item"><a class="nav-link" id="performa-tal-icon-tab" data-toggle="tab" href="#performaTalIcon" role="tab" aria-controls="performaTalIcon" aria-selected="false"><i class="nav-icon i-Block-Window mr-1"></i> Performa</a></li>
    <li class="nav-item"><a class="nav-link" id="invoice-ver-tal-icon-tab" data-toggle="tab" href="#invoiceVerTalIcon" role="tab" aria-controls="invoiceVerTalIcon" aria-selected="false"><i class="nav-icon i-Check mr-1"></i>Invoice Verifaction</a></li>
    <li class="nav-item"><a class="nav-link" id="invoice-con-tal-icon-tab" data-toggle="tab" href="#invoiceConTalIcon" role="tab" aria-controls="invoiceConTalIcon" aria-selected="false"><i class="nav-icon i-Approved-Window mr-1"></i>Confirmed Invoices</a></li>
    <li class="nav-item"><a class="nav-link" id="showing-slip-tal-icon-tab" data-toggle="tab" href="#showingSlipTalIcon" role="tab" aria-controls="showingSlipTalIcon" aria-selected="false"><i class="nav-icon i-Split-Horizontal-2-Window mr-1"></i>Showing Slip</a></li>
    <li class="nav-item"><a class="nav-link" id="slip-confirm-tal-icon-tab" data-toggle="tab" href="#slipConfirmTalIcon" role="tab" aria-controls="slipConfirmTalIcon" aria-selected="false"><i class="nav-icon i-Line-Chart mr-1"></i>Slip Confirmed</a></li>
    <li class="nav-item"><a class="nav-link" id="payment-tal-icon-tab" data-toggle="tab" href="#paymentTalIcon" role="tab" aria-controls="paymentTalIcon" aria-selected="false"><i class="nav-icon i-Money-2 mr-1"></i>Payment</a></li>
    <li class="nav-item"><a class="nav-link" id="ready-tal-icon-tab" data-toggle="tab" href="#readyTalIcon" role="tab" aria-controls="readyTalIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i>Ready </a></li>
</ul>
<div class="tab-content" id="myIconTabContent">
    <div class="tab-pane fade show active" id="allTalIcon" role="tabpanel" aria-labelledby="all-tal-icon-tab">
        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (All Sheets)</h4>
        <table class="display table" id="datatable_tal_1" style="width:100%" >
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
            @foreach($talabat_file as $res)
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="newTalIcon" role="tabpanel" aria-labelledby="new-tal-icon-tab">
        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (New Sheets)</h4>
        <table class="display table" id="datatable_tal_2" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '1')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>
                <td>
                    <a href="#" class="btn btn-primary new_sheet mdl-btns" id="new_sheet">Transfer To Performa</a>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="performaTalIcon" role="tabpanel" aria-labelledby="performa-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Performa)</h4>
        <table class="display table" id="datatable_tal_3" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '2')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>

                <td>
                    <a href="#" class="btn btn-primary performa-tal mdl-btns">Invoices</a>
<!--                                <a href="#" class="btn btn-primary performa-tal">For Rider</a>-->
<!--                                <a href="#" class="btn btn-info performa-tal">For Company</a>-->
<!--                                <a href="#" class="btn btn-success performa-tal">For 4PL Company</a>-->
<!--                                <a href="#" class="btn btn-warning performa-tal">For 4PL Rider</a>-->

                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="invoiceVerTalIcon" role="tabpanel" aria-labelledby="invoice-ver-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Invoice Verification)</h4>
        <table class="display table" id="datatable_tal_4" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '3')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                </td>
                <td>
                    <a href="#" class="btn btn-success confirm-invoice-tal mdl-btns">Confirm Invoice</a>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="invoiceConTalIcon" role="tabpanel" aria-labelledby="invoice-con-tal-icon-tab">
        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Confirmed Invoice)</h4>
        <table class="display table" id="datatable_tal_5" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '4')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>
                <td>
                    <a href="#" class="btn btn-success confirm-mdl mdl-btns">Transfer To Show Slip</a>
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="showingSlipTalIcon" role="tabpanel" aria-labelledby="showing-slip-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Showing Slip)</h4>
        <table class="display table" id="datatable_tal_6" width="100%" style='position: relative'>
            <thead class="thead-dark">
            <tr class="show-table">
                <th scope="col" >Dates</th>
                <th scope="col" >Salary ID</th>
                <th scope="col" >Total Riders</th>
                <th scope="col">Total Earning</th>
                <th scope="col">Download Orignal Sheet</th>
                <th scope="col">Transfer To Payment</th>

            </tr>
            </thead>
            <tbody>
            @foreach($talabat_file as $res)
            @if($res['status'] == '5')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>
                <td>
                    <a href="#" class="btn btn-success transfert_to_payment mdl-btns">Transfer To Payment</a>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="slipConfirmTalIcon" role="tabpanel" aria-labelledby="slip-confirm-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Slip Confirmed)</h4>
        <table class="display table" id="datatable_tal_7" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '6')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a href="#" class="btn btn-success generate_payment-tal mdl-btns">Show Detail</a>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="paymentTalIcon" role="tabpanel" aria-labelledby="payment-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Payment)</h4>
        <table class="display table" id="datatable_tal_8" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '7')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a href="#" class="btn btn-success payment-btn mdl-btns">Show Detail</a>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="readyTalIcon" role="tabpanel" aria-labelledby="ready-tal-icon-tab">

        <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Talabat</span> Salary Sheet (Ready)</h4>
        <table class="display table" id="datatable_tal_9" width="100%" style='position: relative'>
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
            @foreach($talabat_file as $res)
            @if($res['status'] == '8')
            <tr>
                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                <td>{{ $res['tal_sheet_id']}}</td>
                <td> {{ $res['total_riders']}}</td>
                <td>{{ $res['total_eaning']}}</td>
                <td>
                    <a class="attachment_display" href="{{ $res['path']  }}"target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>


                </td>
                <td>

                    <span class="badge badge-pill done_btn badge-success m-2">Completed</span>
                </td>
            </tr>
            @endif
            @endforeach

            </tbody>
        </table>
    </div>


    <!-----------------modal 1----->


    <div class="modal fade right" id="exampleModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content ">
                <div class=" modal-header-full-width   modal-header text-center">
                    <h5 class="modal-title w-100" id="exampleModalPreviewLabel">New Sheets</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card text-left">
                    <div class="card-body">
                    <table class="display table" id="datatable_tab1_modal" width="100%" style='position: relative'>
                        <thead class="thead-dark">
                        <tr class="show-table">
                            <th scope="col" >Dates</th>
                            <th scope="col" >Salary ID</th>
                            <th scope="col" >Total Riders</th>
                            <th scope="col">Total Earning</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($talabat_file as $res)
                        @if($res['status'] == '1')
                        <tr>
                            <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                            <td>{{ $res['tal_sheet_id']}}</td>
                            <td> {{ $res['total_riders']}}</td>
                            <td>{{ $res['total_eaning']}}</td>
                            <td>
                                <a class="attachment_display btn btn-success modal-btn text-white">Transfer To Performa</a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                </div>
                <div class="modal-footer-full-width  modal-footer">
                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-----------------modal 1 ends----->


    <!-----------------Modal 2 ----------------------->
    <!-----------------Modal 2 ----------------------->
    <!-----------------Modal 2 ends----------------------->
    <div class="modal fade right" id="talabat_performa" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content ">
                <div class=" modal-header-full-width   modal-header text-center">
                    <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Generate Invoices</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card text-left">
                        <div class="card-body">

                    <div class="col-md-12">
                        <ul class="nav nav-tabs justify-content-end mb-4" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="true">Invoice</a></li>
                            <li class="nav-item"><a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="false">Edit</a></li>
                        </ul>
                        <div class="card">
                            <table class="display table" id="datatable_tab2_modal" width="100%" style='position: relative'>
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Dates</th>
                                    <th scope="col" >Salary ID</th>
                                    <th scope="col" >Total Riders</th>
                                    <th scope="col">Total Earning</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($talabat_file as $res)
                                @if($res['status'] == '2')
                                <tr>
                                    <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                    <td>{{ $res['tal_sheet_id']}}</td>
                                    <td> {{ $res['total_riders']}}</td>
                                    <td>{{ $res['total_eaning']}}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary performa-tal mdl-btns">For Rider</a>
                                        <a href="#" class="btn btn-info performa-tal mdl-btns">For Company</a>
                                        <a href="#" class="btn btn-success performa-tal mdl-btns">For 4PL Company</a>
                                        <a href="#" class="btn btn-warning performa-tal mdl-btns">For 4PL Rider</a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                    </div>
<!--                    <div class="modal-footer-full-width  modal-footer">-->
<!--                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>-->
<!--                    </div>-->

                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>

</div>
</div>

<!-----------------Modal 2 ends----------------------->

<!-----------------Modal 3 ----------------------->
<!-----------------Modal 3----------------------->

<div class="modal fade right" id="talabal_invoice_confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">


                <table class="display table" id="datatable_tab3_modal" width="100%" style='position: relative'>
                    <thead class="thead-dark">
                    <tr class="show-table">
                        <th scope="col" >Dates</th>
                        <th scope="col" >Salary ID</th>
                        <th scope="col" >Total Riders</th>
                        <th scope="col">Total Earning</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($talabat_file as $res)
                    @if($res['status'] == '3')
                    <tr>
                        <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                        <td>{{ $res['tal_sheet_id']}}</td>
                        <td> {{ $res['total_riders']}}</td>
                        <td>{{ $res['total_eaning']}}</td>
                        <td>
                            <a href="#" class="btn btn-primary performa-tal mdl-btns">For Rider (Sent to Verification)</a>
                            <a href="#" class="btn btn-info performa-tal mdl-btns">For Company (Not Sent Verification)</a>

                        </td>
                        <td>
                            <a href="#" class="btn btn-success confirm-inv-tal mdl-btns">Confirm</a>

                        </td>
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-md">Save changes</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade right" id="talabal_invoice_confirm_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">


                        <table class="display table" id="datatable_tab3_con_modal" width="100%" style='position: relative'>
                            <thead class="thead-dark">
                            <tr class="show-table">
                                <th scope="col" >Rider Name</th>
                                <th scope="col" >Rider ID</th>
                                <th scope="col" >ZDS Code</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td>Ali Khan</td>
                                <td>1234</td>
                                <td>ZDS001</td>
                                <td>
                                    <a href="#" class="btn btn-primary  mdl-btns">Add Confirmation</a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!-----------------Modal 3 ends----------------------->
<!-----------------Modal 4 ----------------------->

<div class="modal fade right" id="talabal_confirmed" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">


                        <table class="display table" id="datatable_tab3_modal" width="100%" style='position: relative'>
                            <thead class="thead-dark">
                            <tr class="show-table">
                                <th scope="col" >Dates</th>
                                <th scope="col" >Salary ID</th>
                                <th scope="col" >Total Riders</th>
                                <th scope="col">Total Earning</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($talabat_file as $res)
                            @if($res['status'] == '4')
                            <tr>
                                <td>{{ $res['date_from']}}<b>&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp;{{$res['date_to']}}</td>
                                <td>{{ $res['tal_sheet_id']}}</td>
                                <td> {{ $res['total_riders']}}</td>
                                <td>{{ $res['total_eaning']}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary performa-tal mdl-btns">For Rider (Sent to Verification)</a>
                                    <a href="#" class="btn btn-info performa-tal mdl-btns">For Company (Not Sent Verification)</a>

                                </td>
                                <td>
                                    <a href="#" class="btn btn-success show-confirm-tal mdl-btns">Confirm</a>

                                </td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade right" id="talabal_show_confirm_inv_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">


                        <table class="display table" id="datatable_tab3_con_modal" width="100%" style='position: relative'>
                            <thead class="thead-dark">
                            <tr class="show-table">
                                <th scope="col" >Rider Name</th>
                                <th scope="col" >Rider ID</th>
                                <th scope="col" >ZDS Code</th>
                                <th scope="col" >Additional Values</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td>Ali Khan</td>
                                <td>1234</td>
                                <td>ZDS001</td>
                                <td>
                                    <input type="text" name="fine" placeholder="Fine">
                                    <input type="text" name="salik" placeholder="Salik">
                                    <input type="text" name="sim_bills" placeholder="Sim Bills">
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary  mdl-btns">Send</a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!-----------------Modal 4 ends----------------------->
<!-----------------Modal 5----------------------->
<div class="modal fade right" id="talabal_show_slips" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">

                <table class="display table" id="datatable_tab5_modal" width="100%" style='position: relative'>
                    <thead class="thead-dark">
                    <tr class="show-table">
                        <th scope="col" >Rider Name</th>
                        <th scope="col" >Rider ID</th>
                        <th scope="col" >ZDS Code</th>
                        <th scope="col">Action</th>

                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <td>Ali Khan</td>
                        <td>1234</td>
                        <td>ZDS001</td>

                        <td>
                            <a href="#" class="btn btn-success  mdl-btns">Confirmed</a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-----------------Modal 5 ends----------------------->
<!-----------------Modal 5----------------------->
<div class="modal fade right" id="generate_payment-tal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="modal-body">
                    <div class="card text-left">
                        <div class="card-body">
                            <table class="display table" id="datatable_tab6_modal" width="100%" style='position: relative'>
                                <thead class="thead-dark">
                                <tr class="show-table">
                                    <th scope="col" >Rider Name</th>
                                    <th scope="col" >Rider ID</th>
                                    <th scope="col" >ZDS Code</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>

                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>Ali Khan</td>
                                    <td>1234</td>
                                    <td>ZDS001</td>

                                    <td>
                                        <a href="#" class="btn btn-success  mdl-btns">Confirmed</a>
                                    </td><td>
                                        <a href="#" class="btn btn-info  mdl-btns">Pay</a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>




<div class="modal fade right" id="talabat_transfer_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">
                        <table class="display table" id="datatable_tab7_modal" width="100%" style='position: relative'>
                            <thead class="thead-dark">
                            <tr class="show-table">
                                <th scope="col" >Rider Name</th>
                                <th scope="col" >Rider ID</th>
                                <th scope="col" >ZDS Code</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Ali Khan</td>
                                <td>1234</td>
                                <td>ZDS001</td>
                                <td>
                                    <a href="#" class="btn btn-success  mdl-btns">Complete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            <div class="modal-footer-full-width  modal-footer">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<!-----------------Modal 6 ends----------------------->
<div class="modal fade right" id="talabat_transfer_payment_done" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width   modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalPreviewLabel">Process</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-left">
                    <div class="card-body">
                        <table class="display table" id="datatable_tab8_modal" width="100%" style='position: relative'>
                            <thead class="thead-dark">
                            <tr class="show-table">
                                <th scope="col" >Rider Name</th>
                                <th scope="col" >Rider ID</th>
                                <th scope="col" >ZDS Code</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Ali Khan</td>
                                <td>1234</td>
                                <td>ZDS001</td>
                                <td>
                                    <a href="#" class="btn btn-success  mdl-btns">Completed</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer-full-width  modal-footer">
                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>







    <script>
        $('#datatable_tab1_modal,#datatable_tab2_modal,#datatable_tab3_modal,datatable_tab3_con_modal,datatable_tab5_modal,datatable_tab6_modal,datatable_tab7_modal,datatable_tab8_modal').DataTable( {

        "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
            {"targets": [0],"visible": true},
            {"targets": [1][2][3][4],"width": "40%"}
        ],
            "scrollY": false,
        });

    $(document).ready(function () {
        $('#datatable_tal_1,datatable_tal_2,datatable_tal_3,datatable_tal_4,datatable_tal_5,datatable_tal_5,datatable_tal_6,datatable_tal_7,datatable_tal_8,datatable_tal_9,datatable_tal_10').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2][3][4],"width": "40%"}
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

            if(split_ab=="all-tal-icon-tab"){
                var table = $('#datatable_tal_1').DataTable();
                $('#container').css( 'display', 'block' )
                table.columns.adjust().draw();



            }

            else if(split_ab=="new-tal-icon-tab"){

                var table = $('#datatable_tal_2').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

            }
            else if(split_ab=="performa-tal-icon-tab"){
                var table = $('#datatable_tal_3').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }

            else if(split_ab=="invoice-ver-tal-icon-tab"){
                var table = $('#datatable_tal_4').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }


            else if(split_ab=="invoice-con-tal-icon-tab"){
                var table = $('#datatable_tal_5').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }


            else if(split_ab=="showing-slip-tal-icon-tab"){
                var table = $('#datatable_tal_6').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }



            else if(split_ab=="slip-confirm-tal-icon-tab"){
                var table = $('#datatable_tal_7').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }



            else if(split_ab=="payment-tal-icon-tab"){
                var table = $('#datatable_tal_8').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            else{
                var table = $('#datatable_tal_9').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw()

            }


        }) ;
    });

// </script>
