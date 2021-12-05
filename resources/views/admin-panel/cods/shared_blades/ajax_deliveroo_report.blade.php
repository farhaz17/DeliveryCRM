<div class="col-12">
    <div class="alert alert-card alert-info text-center mb-5" role="alert">
        <h4>{{request('date_range') == 'latest' ? "Current Deliveroo COD" : "Deliveroo COD Collection Report" }}</h4>
        <p class="mb-0">From {{ $start_date }} to {{ $end_date }}</p>
    </div>
</div>

<div class="col-md-2 {{ request('date_range') == 'latest' ? 'offset-1': '' }}">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-Dollar" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">Total COD</p>
                <p class="text-primary line-height-1 mb-2">{{ number_format($toal_cod, 2) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-Dollar" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">Cash Received</p>
                <p class="text-primary line-height-1 mb-2">{{ number_format($total_cash_received, 2) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-University1" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">Received in Bank</p>
                <p class="text-primary line-height-1 mb-2"> {{ number_format($total_bank_received, 2) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-Dollar" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">Adj. Received</p>
                <p class="text-primary line-height-1 mb-2"> {{ number_format($total_adjustment_received, 2) }}</p>
            </div>
        </div>
    </div>
</div>
@if(request('date_range') != 'latest')
<div class="col-md-2">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-Dollar" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">{{ request('date_range') == 'latest' ? "Previous Closing" : "Closing Amount" }}</p>
                <p class="text-primary line-height-1 mb-2"> {{ number_format($close_month, 2) }}</p>
            </div>
        </div>
    </div>
</div>
@endif
<div class="col-md-2">
    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-body text-center"><i class="i-Cash-Register" style="font-size: 40px"></i>
            <div class="content">
                <p class="text-muted mt-2 mb-0">Remain COD</p>
                <p class="text-primary line-height-1 mb-2">{{ number_format($total_remain, 2)}}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <ul class="nav nav-tabs small" id="myTab" role="tablist">
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link active" id="UploadedDeliverooCodTab" data-toggle="tab" href="#UploadedDeliverooCod" role="tab" aria-controls="UploadedDeliverooCod" aria-selected="true">All Uploaded COD ( AED. {{ number_format($uploaded_cods->sum('amount') ?? 0, 2) }} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="CashDeliverooCodTab" data-toggle="tab" href="#CashDeliverooCod" role="tab" aria-controls="CashDeliverooCod" aria-selected="true">Cash Received ( AED. {{ number_format($cods->where('type', 0)->sum('amount') ?? 0, 2) }} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="BankDeliverooCodTab" data-toggle="tab" href="#BankDeliverooCod" role="tab" aria-controls="BankDeliverooCod" aria-selected="true">Bank Received ( AED. {{ number_format($cods->where('type', 1)->sum('amount') ?? 0, 2) }} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="AdjustmentCodTab" data-toggle="tab" href="#AdjustmentCod" role="tab" aria-controls="AdjustmentCod" aria-selected="true">Adjustments ( AED. {{ number_format($all_adjustments->sum('amount') ?? 0, 2) }} )</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="UploadedDeliverooCod" role="tabpanel" aria-labelledby="UploadedDeliverooCodTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="UploadedDeliverooCodTable">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Rider Id</th>
                            <th>Rider Name</th>
                            <th>Started</th>
                            <th>Ended</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($uploaded_cods as $key => $cod)
                        <tr>
                            {{-- <td>{{ $cod->passport_id }}</td> --}}
                            {{-- <td>{{ $cod->rider_id ?? "NA" }}</td> --}}
                            @if (!$cod->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $cod->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                                @else
                                    <td>N/A</td>
                            @endif
                            <td>{{ $cod->passport->personal_info->full_name }}</td>
                            <td>{{ dateToRead($cod->start_date) }}</td>
                            <td>{{ dateToRead($cod->end_date) }}</td>
                            <td class="text-right">{{ number_format($cod->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="CashDeliverooCod" role="tabpanel" aria-labelledby="CashDeliverooCodTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="CashDeliverooCodTable">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>RiderID</th>
                            <th>Rider Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cods->where('type', 0) as $cod)
                        <tr>
                            {{-- <td>{{ $cod->passport_id ?? "NA" }}</td> --}}
                            @if (!$cod->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $cod->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                                @else
                                    <td>N/A</td>
                            @endif
                            <td>{{ $cod->passport->personal_info->full_name }}</td>
                            <td>{{ $cod->date ?? "NA" }}</td>
                            <td>{{ $cod->time ?? "NA" }}</td>
                            <td class="text-right">{{ number_format($cod->amount, 2) ?? "NA" }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="BankDeliverooCod" role="tabpanel" aria-labelledby="BankDeliverooCodTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="BankDeliverooCodTable">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Rider Id</th>
                            <th>Rider Name</th>
                            <th>Slip Number</th>
                            <th>Machine Number</th>
                            <th>Location At Machine</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cods->where('type', 1) as $cod)
                        <tr>
                            {{-- <td>{{ $cod->passport_id ?? "NA" }}</td> --}}
                            @if (!$cod->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $cod->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                                @else
                                    <td>N/A</td>
                            @endif
                            <td>{{ $cod->passport->personal_info->full_name }}</td>
                            <td>{{ $cod->slip_number ?? "NA" }}</td>
                            <td>{{ $cod->machine_number ?? "NA" }}</td>
                            <td>{{ $cod->location_at_machine ?? "NA" }}</td>
                            <td>{{ $cod->date ?? "NA" }}</td>
                            <td>{{ $cod->time ?? "NA" }}</td>
                            <td class="text-right">{{ number_format($cod->amount, 2) ?? "NA" }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="tab-pane fade" id="AdjustmentCod" role="tabpanel" aria-labelledby="AdjustmentCodTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="AdjustmentCodTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Rider Id</th>
                            <th>Rider Name</th>
                            <th>Message</th>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_adjustments as $adjustment)
                        <tr>
                            <td>{{ $adjustment->passport_id ?? "NA" }}</td>
                            <td>{{ $uploaded_cod->rider_id ?? "NA" }}</td>
                            <td>{{ $uploaded_cod->passport->personal_info->full_name }}</td>
                            <td>{{ $adjustment->message ?? "NA" }}</td>
                            <td>{{ $adjustment->order_id ?? "NA" }}</td>
                            <td>{{ $adjustment->order_date ?? "NA" }}</td>
                            <td class="text-right">{{ number_format($adjustment->amount, 2) ?? "NA" }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#UploadedDeliverooCodTable, #CashDeliverooCodTable, #BankDeliverooCodTable, #AdjustmentCodTable').DataTable( {
            initComplete: function () {
                let filtering_columns = []
                $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                    filtering_columns.push(v.cellIndex)
                });
                this.api().columns(filtering_columns).every( function () {
                    var column = this;
                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                        .appendTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            "aaSorting": [[0, 'asc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Deliveroo COD',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
        });
    });
    // for redraw table
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('href');
            $(currentTab +"Table").DataTable().columns.adjust().draw();
        });
    });
</script>
