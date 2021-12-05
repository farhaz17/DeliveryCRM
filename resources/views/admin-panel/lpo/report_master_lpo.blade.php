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
            <th scope="col">Inventory Type</th>
            <th scope="col">Supplier Name</th>
            <th scope="col">LPO No</th>
            <th scope="col">Purchase Type</th>
            <th scope="col">Contract No</th>
            <th scope="col">Quantity</th>
            <th scope="col">Amount</th>
            <th scope="col">Create Date</th>
            <th scope="col">Attachment</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($lpo as $row)
                <tr>
                    <td>
                        @if ($row->inventory_type == 1 )
                            Vehicle
                        @endif
                        @if ($row->inventory_type == 2 )
                            Spare Parts
                        @endif
                    </td>
                    <td>{{ isset($row->supplier) ? $row->supplier->contact_name: '' }}</td>
                    <td>{{ $row->lpo_no }}</td>
                    <td>
                        @if ($row->purchase_type == 1 )
                            Rental
                        @endif
                        @if ($row->purchase_type == 2 )
                            Lease to Own
                        @endif
                        @if ($row->purchase_type == 3 )
                            Company
                        @endif
                    </td>
                    <td>{{ isset($row->contract) ? $row->contract->contract_no: '' }}</td>
                    <td>@if($row->quantity != 0) {{ $row->quantity }} @endif</td>
                    <td>{{ $row->amount }}</td>
                    <td>{{ $row->start_date }}</td>
                    <td><a href="{{ asset('/assets/upload/lpo/' .$row->lpo_attachment) }}" target="_blank">Attachment</a></td>
                    <td><a id="viewMore" href="javascript:void(0)" data-id="{{ $row->id }}" data-toggle="modal" data-target="#inventoryDetails"><i class="fa fa-eye" aria-hidden="true"></i></td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>


 <!---------View More---------->
 <div class="modal fade" id="inventoryDetails" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Details<h3>
                    </div>
                </div>

                <div class="renew p-3">
                    <table id="modelDetails" class="table table-bordered table-striped">
                        {{-- <caption class="text-center">Bank Account Details</caption> --}}
                        <tr>
                            <th>Model</th>
                            <th>Quantity</th>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
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


        $(document).on("click", "#viewMore", function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ URL::to('ajax-lpo-inventory-details') }}",
                data: {'id': id},
                success:function(response)
                {
                    // console.log(response)
                    $('.appendedRow').remove('.appendedRow')
                    var details = response;
                    details.forEach(element => {
                        console.log(element)
                        // $('#luluCardDetails').show()
                        var model_name = ''
                        if(element.model_type.includes("VehicleModel")){
                            var model_name = element.model.name
                        }
                        if(element.model_type.includes("Parts"))
                            var model_name = element.model.part_name
                        $('#modelDetails tr:last').after("<tr class='appendedRow'><td>"+model_name+"</td><td>"+element.quantity+"</td></tr>");
                    });
                }
            });
        });


</script>


@endsection
