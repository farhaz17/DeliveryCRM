@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operation</a></li>
            <li>Manage Repair</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                    <tr>
                        <th>Repair No</th>
                        <th>Plate No</th>
                        <th>Chassis No</th>
                        <th>Date</th>
                        <th width="5%">Part</th>
                        <th width="5%">Quantity/th>
                        <th width="5%">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($repair_sales as $row)

                    @php
                    $purchase_pdf_route = route('purchase_pdf',$row->id);
                @endphp
                    <tr>
                        <td>&nbsp;</td>
                        <td> {{ $row->purchase_no ?? '' }} </td>
                        <td> {{ $row->suppliers->contact_name ?? '' }} </td>
                        <td> {{ $row->created_at->format('d-m-Y') ?? '' }} </td>
                        <td>
                            <a href="{{$purchase_pdf_route}}" target="_blank"><i class="fa fa-print"></i></a>
                        </td>
                        <td>
                            @if($row->status=='1')
                            <a class="badge badge-success m-2" href="#">Verified</a>
                            @else
                            <button class="btn text-success"  onclick="vendor_req_accept({{$row->id}})" type="button"><i class="fa fa-check"></i></button>
                                @endif

                        </td>
                        <td>
                            @if($row->return_status=='1')
                            <a class="badge badge-info m-2" href="#">Returned</a>
                            @else
                            <button class="btn text-success"  onclick="return_purchase({{$row->id}})" type="button"><i class="i-Restore-Window"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>







@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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
    </script>




@endsection
