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
        <li class="breadcrumb-item active" aria-current="page">Utilities</li>
    </ol>
</nav> 
<div class="card col-md-12 mb-2 pt-2 ">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Utilities</div>
        <h5>Electricity / Water</h5>
        <div class="row">
            <table class="table table-sm table-hover  text-11 data_table_cls">
                <thead>
                <tr>
                    <th>Company</th>
                    <th>Account No</th>
                    <th>Account Type</th>
                    <th>Business Partners</th>
                    <th>Bill Name</th>
                    <th>Premise No</th>
                    <th>Attachment</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($electricity as $item)
                    <tr>
                        <td>{{ $item->company_id ?? "Na"}}</td>
                        <td>{{ $item->account_no ?? "Na"}}</td>
                        <td>{{ $item->account_type == 1 ? "Commercial" : "Personal" }}</td>
                        <td>{{ $item->business_partner ?? "Na"}}</td>
                        <td>{{ $item->bill_name ?? "Na"}}</td>
                        <td>{{ $item->permise_number ?? "Na"}}</td>
                        <td>
                            <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $item->attachment }}">Download</a>
                        </td>
                        <td>
                            <a class="text-success mr-2" href="{{route('company_master_utilities_water_electiricity_edit', $item->id)}}">
                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                            </a>
                            <a class="text-danger mr-2" href="#">
                                <i class="nav-icon i-Close-Window font-weight-bold"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <p>No data available!</p>   
                @endforelse
                </tbody>
            </table>
        </div>
        <hr>
        <h5>Etisalat</h5>
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                    <tr>
                        <th>Company</th>
                        <th>Etisalat Party ID</th>
                        <th>Account No</th>
                        <th>Attachment</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($etisalats as $item)
                        <tr>
                            <td>{{$item->company_id ?? "Na"}}</td>
                            <td>{{$item->etisalat_party_id ?? "Na"}}</td>
                            <td>{{$item->account_no ?? "Na"}}</td>
                            <td>
                                <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $item->attachment }}">Download</a>
                            </td>
                            <td>
                                <a class="text-success mr-2" href="{{ route('company_master_utilities_etisalat_edit', $item->id) }}">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <a class="text-danger mr-2" href="#">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p>No attachment available!</p>   
                    @endforelse
                    </tbody>
                </table>
            </div>
        <hr>
        <h5>Du</h5>
        <div class="row">
            <table class="table table-sm table-hover text-11 data_table_cls">
                <thead>
                <tr>
                    <th>Company</th>
                    <th>Du Account No</th>
                    <th>Attachment</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($dus as $item)
                    <tr>
                        <td>{{$item->company_id ?? "Na"}}</td>
                        <td>{{$item->du_acc ?? "Na"}}</td>
                        <td>
                            <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $item->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $item->attachment }}">Download</a>
                        </td>
                        <td>
                            <a class="text-success mr-2" href="{{ route('company_master_utilities_dus_edit',$item->id) }}">
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
                title: 'Utilities Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'Utilities Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'Utilities Summary',
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
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
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
    @endif
</script>
@endsection