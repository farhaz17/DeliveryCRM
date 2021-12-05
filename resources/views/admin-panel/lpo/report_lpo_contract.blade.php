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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Report Lpo Contract</li>
    </ol>
</nav>


<div class="container card selected_passport p-3" style="">
    <table class="table table-sm table-hover text-14 datatable-contract" id="datatableContract">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Supplier Category</th>
            <th scope="col">Supplier Name</th>
            <th scope="col">Contract No</th>
            <th scope="col">Quantity</th>
            <th scope="col">State</th>
            <th scope="col">Create Date</th>
            <th scope="col">Attachment</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($report as $row)
                <tr>
                    <td>
                        @if ($row->supplier_category_id == 1 )
                            Rental
                        @endif
                        @if ($row->supplier_category_id == 2 )
                            Lease to Own
                        @endif
                    </td>
                    <td>{{ $row->supplier->contact_name }}</td>
                    <td>{{ $row->contract_no }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>
                        @if (!empty($row->state))
                            @foreach (json_decode($row->state) as $state)
                                @if ($state == 1)
                                    Dubai,
                                @endif
                                @if ($state == 2)
                                    Abu Dhabi,
                                @endif
                                @if ($state == 3)
                                    Sharjah,
                                @endif
                                @if ($state == 4)
                                    Ajman,
                                @endif
                                @if ($state == 5)
                                    Al Ain,
                                @endif
                                @if ($state == 6)
                                    Umm ul Quwain,
                                @endif
                                @if ($state == 7)
                                    Ras al Khaimah
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $row->create_date }}</td>
                    <td><a href="{{ asset('/assets/upload/lpo/' .$row->attachment) }}" target="_blank">Attachment</a></td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>


@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

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

    $('table.datatable-contract').DataTable( {
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


</script>


@endsection
