@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>

        </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'reports-menu-items']) }}">Company Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ejari</li>
    </ol>
</nav>
    <div class="card col-md-12  mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Ejari</div>
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Ejari Details</th>
                            <th>Tenancy Contract Details</th>
                            <th>Leased Units</th>
                            <th>PDCs</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ejaris as $item)
                        <tr>
                            <td>1</td>
                            <td>Company: {{ $item->company->name ?? "" }} | Type: {{ $item->ejari_type == 0 ? "Residential" : "Commertial" }} | State: {{ $item->state_name }}</td>
                            <td>Issued on: {{ $item->issue_date }} | Expires on: {{ $item->expiry_date }} | Contract Amt: {{ $item->contract_amount }} | Security Deposit: {{ $item->security_deposit }} | Contract No: {{ $item->contract_no }}</td>
                            <td>Plot: {{ $item->plot_no }} | Land DM:{{ $item->land_dm_no }} | Makani: {{ $item->makani_no }} | Land Area: {{ $item->land_area }}
                            </td>
                            <td>
                                <a class="text-success mr-2 pdc-payments-button" data-toggle="modal" data-target="#PDCPaymentsModalCenter" data-ejari-id="{{ $item->id }}">
                                    <i class="nav-icon i-Eye-Visible font-weight-bold"></i>
                                </a>
                            </td>
                            <td>
                                <a class="text-success mr-2" href="{{ route('company_master_ejari_edit', $item->id) }}">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <p>No data data available!</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- <div class="card col-md-12  mb-2">
        <div class="card-title mb-3 col-12">Tenancy Contract Details</div>
        <div class="card-body">
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>

                        <tr>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Contract Amount</th>
                            <th>Security Deposit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ejaris as $item)
                        <tr>
                            <td>{{ $item->issue_date }}</td>
                            <td>{{ $item->expiry_date }}</td>
                            <td>{{ $item->contract_amount }}</td>
                            <td>{{ $item->security_deposit }}</td>
                            <td>
                                <a class="text-success mr-2" href="#">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <p>No data data available!</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card col-md-12  mb-2">
        <div class="card-title mb-3 col-12">Leased Unit</div>
        <div class="card-body">
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>Land Area</th>
                            <th>Plot No</th>
                            <th>Land DM No</th>
                            <th>Makani No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ejaris as $item)
                        <tr>
                            <td>{{ $item->land_area }}</td>
                            <td>{{ $item->plot_no }}</td>
                            <td>{{ $item->land_dm_no }}</td>
                            <td>{{ $item->makani_no }}</td>
                            <td>
                                <a class="text-success mr-2" href="#">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    {{-- <div class="card col-md-12  mb-2">
        <div class="card-title mb-3 col-12">PDC Payments</div>
        <div class="card-body" id="pdc-payments-list">
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Check no</th>
                            <th>PDC Company Account No</th>
                            <th>PDC Date</th>
                            <th>PDC Ammount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ejaris as $item)

                            <tr>
                                <td>{{ $item->pdc_check_no }}</td>
                                <td>{{ $item->pdc_company_account_no }}</td>
                                <td>{{ $item->pdc_date }}</td>
                                <td>{{ $item->pdc_amount }}</td>
                                <td>
                                    <a class="text-success mr-2" href="#">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                    <a class="text-danger mr-2" href="#">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </a>
                                </td>
                            </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</form>

{{-- Modal for PDC Payments --}}
<div class="modal fade" id="PDCPaymentsModalCenter" tabindex="-1" role="dialog" aria-labelledby="PDC-Payments-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PDC-Payments-2">PDC Payments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="pdc_payments_body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- Modal for PDC Payments --}}
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
    'use-strict'
    $('table.data_table_cls').DataTable( {
        "aaSorting": [[0, 'desc']],
        "pageLength": 10,
        "columnDefs": [
            {"targets": [0],"visible": false},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Ejari Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'Ejari Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'Ejari Summary',
                text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
        ],
        select: true,
        scrollY: 300,
        responsive: true,
        // scrollX: true,
        // scroller: true
    });
});
$(document).ready(function(){
    $('.pdc-payments-button').on('click', function(){
        var ejari_id = $(this).attr('data-ejari-id');
        $.ajax({
            method: "GET",
            url: "{{ route('ajax-get-pdc-payments') }}",
            dataType: "json",
            data: { ejari_id }
        })
        .done(function(response) {
            $('#pdc_payments_body').empty();
            $('#pdc_payments_body').append(response.html);
        });
    });
});
function tostr_display(type,message){
    switch(type){
        case 'info':
            toastr.info(message);
            break;
        case 'warning':
            toastr.warning(message);
            break;
        case 'success':
            toastr.success(message);
            break;
        case 'error':
            toastr.error(message);
            break;
    }
}
</script>
@endsection
