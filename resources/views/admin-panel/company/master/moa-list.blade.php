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
      <li class="breadcrumb-item active" aria-current="page">MOA</li>
    </ol>
</nav>
<form action="{{route('company-master-moa-store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Memorandum of Association</div>
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>sl</th>
                            <th>Company</th>
                            <th>MOA Date</th>
                            <th>MOA No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($moas as $item)
                        <tr>
                            <td>&nbsp;</td>
                            <td>{{ $item->company->name }}</td>
                            <td>{{ $item->moa_date }}</td>
                            <td>{{ $item->moa_no }}</td>
                            <td>
                                <a class="text-success mr-2" href="{{ route('company-master-moa-edit',$item->id) }}">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                    <p>No data attachment available!</p>
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
                title: 'Moa Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'Moa Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'Moa Summary',
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