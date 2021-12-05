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
      <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>
<div class="card col-lg-12 mb-2">
    <div class="card-body">
            <div class="card-title mb-3">License Details</div>
            <div class="row">
                <table class="table table-sm table-hover text-10 data_table_cls">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>License Type</th>
                        <th>Category</th>
                        <th>State</th>
                        <th>Trade name</th>
                        <th>License No</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>D&B U-U-N-S R</th>
                        <th>Registration No</th>
                        <th>DCCI No</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($licenses as $license)
                        <tr>
                        <td>1</td>
                        <td>
                            {{ ($license->license_type === 'llc' ? 'LLC' : ($license->license_type === 'civil_agent' ? 'Civil Agent' :  'NA')) }}
                        </td>
                        <td>
                            {{ ($license->license_category === 0 ? 'Professional' : ($license->license_category === 1 ? 'Commercial' :  'NA')) }}
                        </td>
                        <td> {{ $license->state->name ?? "NA" }}</td>
                        <td> {{ $license->name ?? "NA" }}</td>
                        <td> {{ $license->trade_license_no ?? "NA"}} </td>
                        <td> {{ $license->issue_date ?? "NA" }} </td>
                        <td> {{ $license->expiry_date ?? "NA" }} </td>
                        <td> {{ $license->uuns ?? "NA"}}</td>
                        <td> {{ $license->registration_no ?? "NA"}}</td>
                        <td> {{ $license->dcci ?? "NA"}}</td>
                        <td>
                            <a class="text-success mr-2" href="{{ route('company-master-license-edit',$license->id) }}">
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

@endsection
@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>

</script>

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
                title: 'License Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'License Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'License Summary',
                text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
        ],
        scrollY: 300,
        responsive: true,
        // scrollX: true,
        // scroller: true
    });
});

function tostr_display(type,message){
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
}
</script>
@endsection
