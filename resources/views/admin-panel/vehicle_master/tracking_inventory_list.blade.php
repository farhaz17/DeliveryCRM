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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">RTA Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tracking Inventory List</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
<div class="card-body">
    <div class="card-title mb-3 col-12">Vehicle Tracking Inventory Reports</div>
    <div class="row">
        <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Name:</th>
                    <th width="5%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tracking_inventories as $tracking_inventory)
                <tr>
                    <td>&nbsp;</td>
                    <td> {{ $tracking_inventory->tracking_no ?? '' }} </td>
                    <td>
                        <a class="text-success mr-2" href="{{ route('vehicle_tracking_inventory.edit', $tracking_inventory->id) }}">
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
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();
</script>
<script>
    $(document).ready(function () {
        'use-strict'
        $('.table.data_table_cls').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": {{defaultPaginate(20)}},
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'Tracking Inventory Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Tracking Inventory Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                // {
                //     extend: 'pdf',
                //     title: 'Tracking Inventory Summary',
                //     text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                //     exportOptions: {
                //         modifier: {
                //             page : 'all',
                //         }
                //     }
                // },
            ],
            select: true,
            scrollY: 300,
            responsive: true,
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