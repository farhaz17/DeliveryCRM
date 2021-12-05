@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wps_dashboard',['active'=>'reports-menu-items']) }}">WPS Reports</a></li>
      <li class="breadcrumb-item active" aria-current="page">Company Listed</li>
    </ol>
</nav>
<div class="card col-lg-12 mb-2">
    <div class="card-body">
            <div class="card-title mb-3">Company Details</div>
            <div class="row">
                <table class="table table-sm table-hover text-12 data_table_cls">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Trade License</th>
                        <th>MOL No</th>
                        <th>MOI No</th>
                        <th>No of Employees</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies as $obj)
                        <tr>
                            <td> {{ $obj->name ?? "NA" }}</td>
                            <td> {{ $obj->trade_license_no ?? "NA"}} </td>
                            <td> {{ $obj->mol_no->mol_no ?? "NA" }} </td>
                            <td> {{ $obj->moi_no->moi_no ?? "NA" }} </td>
                            <td> {{ $obj->total_employee ?? "NA"}}</td>
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
            {"targets": [0],"visible": true},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'WPS Company List',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'WPS Company List',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'WPS Company List',
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
</script>

@endsection
