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
        <li class="breadcrumb-item active" aria-current="page">eEtablishment</li>
    </ol>
</nav>
{{-- E Establishment Card --}}
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">eEstablishment Card</div>
        <div class="row">
            <table class="table table-sm table-hover text-10 data_table_cls">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Company</th>
                        <th>MOI No</th>
                        <th>Expiry Date</th>
                        <th>Partners</th>
                        {{-- <th>Attachment</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($e_establishment_cards as $obj)
                    <tr>
                        <td>&nbsp;</td>
                        <td> {{ $obj->company->name ?? "NA" }}</td>
                        <td> {{ $obj->moi_no ?? "NA" }}</td>
                        <td> {{ $obj->expiry_date ?? "NA" }}</td>
                        <td>
                            @if($obj->partners)
                                @forelse($obj->partners as $partner)
                                    {{ $partner->sur_name . ' | ' ?? '' }}
                                @empty
                                    
                                @endforelse
                            @endif
                        </td>
                        {{-- <td> {{ $obj->attachment ?? "NA" }} </td> --}}
                        <td>
                            <a class="text-success mr-2" href="{{ route('company-master-e-establishment-card-edit', $obj->id) }}">
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
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Labour Card</div>
        <div class="row">
            <table class="table table-sm table-hover text-10 data_table_cls">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>MOL No</th>
                        <th>Company</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Partners</th>
                        {{-- <th>Attachment</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($labourCards as $obj)
                    <tr>
                        <td>&nbsp;</td>
                        <td> {{ $obj->company->name ?? "NA" }}</td>
                        <td> {{ $obj->mol_no ?? "NA" }}</td>
                        <td> {{ $obj->issue_date ?? "NA" }}</td>
                        <td> {{ $obj->expiry_date ?? "NA" }}</td>
                        <td>
                            @if($obj->partners)
                                @forelse($obj->partners as $partner)
                                    {{ $partner->sur_name . ' | ' ?? '' }}
                                @empty
                                    
                                @endforelse
                            @endif    
                        </td>
                        {{-- <td> {{ $obj->attachment ?? "NA" }} </td> --}}
                        <td>
                            <a class="text-success mr-2" href="{{ route('company-master-labour-card-card-edit', $obj->id) }}">
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
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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
                title: 'e-Establishment Card Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'e-Establishment Card Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'e-Establishment Card Summary',
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