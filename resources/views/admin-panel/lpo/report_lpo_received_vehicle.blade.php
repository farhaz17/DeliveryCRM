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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Contract</li>
    </ol>
</nav>

<div class="container">
    <div class="col-md-4">
        <label for="repair_category">Select Inventory</label><br>
        <input type="radio" id="vehicle" name="inventory_type" value="1" required>
        <label for="vehicle">Vehicle</label><br>
        <input type="radio" id="spare" name="inventory_type" value="2" required>
        <label for="spare">Spare Parts</label><br>
    </div>
</div>
<div class="container card p-3 vehicle-info" style="display: none">
    <div class="col-md-4">
        <select id="" class="form-control purchase-type" name="">
            <option value="" disabled selected>Select Type</option>
            <option value="1">Rental</option>
            <option value="2">Lease To Own</option>
            <option value="3">Company</option>
        </select>
    </div>
    <div class="mt-3 font-weight-bold">Vehicle</div>
    <div class="container selected_passport p-3" style="">
        <div class="row">
            <table class="table table-sm table-hover text-12 data_table_cls">
                <thead>
                    <tr>
                        <th>LPO ID</th>
                        <th>Model</th>
                        <th>Make Year</th>
                        <th>Chassis No</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="container card selected_passport spare-info p-3" style="display: none">
    <div class="row">
        <table class="table table-sm table-hover text-12 data_table_spare">
            <thead>
                <tr>
                    <th>LPO ID</th>
                    <th>Model</th>
                    <th>Total Quantity</th>
                    <th>Quantity Received</th>
                    <th>Quantity Pending</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

     <!---------Vehicle Received---------->
    <div class="modal fade" id="receiveVehicle" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Are you sure<h3>
                        </div>
                    </div>

                    <div class="renew p-3">
                        <form   method="post" action="{{ url('/lpo-vehicle-received') }}">
                            @csrf
                            <input type="hidden" name="vehicle_info">
                            <div class="modal-footer">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Yes">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">No</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!---------Spare Received---------->
    <div class="modal fade" id="receiveSpare" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Are you sure<h3>
                        </div>
                    </div>

                    <div class="renew p-3">
                        <form   method="post" action="{{ url('/lpo-spare-received') }}">
                            @csrf
                            <input type="hidden" name="vehicle_info">
                            <div class="amount">
                                <label for="repair_category">Quantity Received</label>
                                <input id="" name="quantity" class="form-control" type="number" required>
                            </div>
                            <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
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

    $('#selectState').select2({
        placeholder: 'Select the state',
        width: '100%'
    });


    $(document).on("change", ".purchase-type", function(e){
        var val = ($(this).val());
        $('table.data_table_cls').DataTable().destroy();
        $('table.data_table_cls').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('report-lpo-filter-vehicle-receive') }}",
                data:{val: val},
            },
            columns: [
                { data: 'lpo_id' },
                { data: 'model.name' },
                { data: 'make_year' },
                { data: 'chassis_no' },
                { data: 'status' },
                // { data: 'actions', render:function (data, type, full, meta) {
                //                 return `<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success btn-sm" data-target="#attachVcc">Attach VCC</a>`;  }
                // }
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    // title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    // customize: function ( xlsx ) {
                    //     var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //     $('c[r=E2] t', sheet).text('Category');
                    // },
                    exportOptions: {
                        columns: [ 2, 3, 4, 5, 6],
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ]
            });
    });

    $(document).on("click", ".vcc-modal", function () {
        var id = $(this).attr('data-id');
        console.log(id);
        $("input[name='vehicle_info']").val(id);
    });

    $("input[name='inventory_type']").on('change',function(){
        if($(this).val() == 1) {
            $(".vehicle-info").show()
            $(".spare-info").hide()
        }
        if($(this).val() == 2) {
            $(".vehicle-info").hide()
            $(".spare-info").show()

            $('table.data_table_spare').DataTable().destroy();
            $('table.data_table_spare').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('report-lpo-spare-receive') }}",
                data:{val: 1},
            },
            columns: [
                { data: 'lpo_id' },
                { data: 'model.part_name' },
                { data: 'quantity' },
                { data: 'quantity_received' },
                { data: 'quantity_pending' },
                // { data: 'actions', render:function (data, type, full, meta) {
                //                 return `<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success btn-sm" data-target="#attachVcc">Attach VCC</a>`;  }
                // }
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    // title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    // customize: function ( xlsx ) {
                    //     var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //     $('c[r=E2] t', sheet).text('Category');
                    // },
                    exportOptions: {
                        columns: [ 2, 3, 4, 5, 6],
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ]
            });
        }

    })

</script>


@endsection
