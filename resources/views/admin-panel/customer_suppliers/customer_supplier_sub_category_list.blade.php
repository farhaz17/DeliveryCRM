@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer_supplier_wise_dashboard',['active'=>'reports-menu-items']) }}">Customer | Supplier Reports</a> / Sub Category List</li>
    </ol>
</nav>
<div class="card col-md-12  mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Customer Supplier Category List</div>
            <div class="row">
                <table class="table table-hover table-striped table-sm text-11 datatable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerSupplierSubCategory as $key => $item)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $item->name ?? "" }}</td>
                            <td>{{ $item->parent_category->name ?? ""  }}</td>
                            <td> Edit / Delete</td>
                        </tr>
                        @endforeach
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
    $('#payment_term').on('change', function(){
        if($(this).val() == 2){
            $("#days_of_credit_term_div").show(600)
        }else{
            $("#days_of_credit_term_div").hide(600)
        }
    })
</script>
<script>
        $(document).ready(function () {
        'use-strict'
        $('.datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'Customer Supplier Sub Categoty Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Customer Supplier Sub Categoty Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                // {
                //     extend: 'pdf',
                //     title: 'Customer Supplier Summary',
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