@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        i.fa.fa-check {
    color: green;
}
i.i-Restore-Window {
    font-weight: bold;
    font-size: 16px;
    color: blue;
}
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Purchase</a></li>
        <li class="breadcrumb-item"><a href="#">All  Returned Purhcases</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Rerturned Purchase  List</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12"></div>
            <div class="row">
                <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Purchase Number</th>
                            <th>Supplier</th>
                            <th>Purchase Date</th>
                            <th width="5%">Returned Date</th>
                            <th width="5%">View Invoice</th>
                            {{-- <th width="5%">Verify Purchase</th>
                            <th width="5%">Return Purchase</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchase as $row)

                        @php
                        $purchase_pdf_route = route('purchase_pdf',$row->id);
                    @endphp
                        <tr>
                            <td>&nbsp;</td>
                            <td> {{ $row->purchase_no ?? '' }} </td>
                            <td> {{ $row->suppliers->contact_name ?? '' }} </td>
                            <td> {{ $row->created_at->format('d-m-Y') ?? '' }} </td>
                            <td> {{ $row->updated_at->format('d-m-Y') ?? '' }} </td>
                            <td>
                                <a href="{{$purchase_pdf_route}}" target="_blank"><i class="fa fa-print"></i></a>
                            </td>
                            {{-- <td>
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
                            </td> --}}
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


</div>

{{-- ---------------modal strts--------------- --}}



<div class="modal fade bd-example-modal-lg-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="updateForm-1" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Verify Purchase</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="veri" style="display: none"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary" id="presentBulkSubmit" type="button">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ---------------modal ends--------------- --}}




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
                    title: 'All Purhcases Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'All Purhcases Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'All Purhcases Summary',
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
