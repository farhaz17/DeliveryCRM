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
        <li class="breadcrumb-item active" aria-current="page">Traffic</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Traffic</div>
        <div class="row">
            <table class="table table-sm table-hover text-11 data_table_cls">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Company</th>
                        <th>Traffic Type</th>
                        <th>State</th>
                        <th>Traffic File No</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse( $traffics as $traffic)
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            @if($traffic->traffic_for == 1)
                                {{ $traffic->company->name ?? "" }}
                            @elseif($traffic->traffic_for == 2)
                                {{ $traffic->passport_info->personal_info->full_name ?? ""}}
                            @elseif($traffic->traffic_for == 3)
                                {{ $traffic->customer_supplier_info->contact_name ?? "" }}
                            @endif
                        </td>
                        <td>
                            @if($traffic->traffic_for == 1)
                                {{ "Zone Group" }}
                            @elseif($traffic->traffic_for == 2)
                                {{ "Personal" }}
                            @elseif($traffic->traffic_for == 3)
                                {{ "Customer | Supplier" }}
                            @endif
                        </td>
                        <td>{{ $traffic->state->name ?? "" }}</td>
                        <td>{{ $traffic->traffic_file_no }}</td>
                        <td>
                            <a class="text-success mr-2" href="{{ route('company_master_traffic_edit',$traffic->id) }}">
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
</div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Salik</div>
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Company</th>
                            <th>State</th>
                            <th>Salik Account No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $saliks as $salik)
                        <tr>
                            <td>&nbsp;</td>
                            <td>{{ $salik->company->name }}</td>
                            <td>{{ $salik->state->name ?? "" }}</td>
                            <td>{{ $salik->salik_acc }}</td>
                            <td>
                                <a class="text-success mr-2" href="{{ route('company_master_salik_edit',$salik->id) }}">
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
    </div>
</form>
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
                title: 'Traffic Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'Traffic Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'Traffic Summary',
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

<script>
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