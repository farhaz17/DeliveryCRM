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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">Bike Impounding Report</a></li>
      <li class="breadcrumb-item active" aria-current="page">Fine Report</li>
    </ol>
</nav>

<div class="container row m-auto mb-4">
    <div class="col-4"></div>
    <div class="col-4 bg-success text-center p-2" style="color: white; font-weight: 700" >
        Total Fine Paid<br>
        {{$amount}}
    </div>
    <div class="col-4"></div>
</div>

<div class="container card selected_passport p-3 mt-3" style="">
    <table class="table table-sm table-hover text-14 datatable-contract" id="datatableContract">
        <thead class="">
        <tr>
            <th scope="col">Plate No</th>
            <th scope="col">Fine Amount</th>
            <th scope="col">Paid Date</th>
        </thead>
        <tbody>
            @foreach ($report as $row)
                <tr>
                    <td>{{$row->plate_number}}</td>
                    <td>{{ $row->value_instead_of_booking }}</td>
                    <td>{{$row->fine_date}}</td>
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
