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
    <div class="row">
        <div class="col-md-4">
            <select id="purchaseType" class="form-control purchase-type" name="">
                <option value="" disabled selected>Select Type</option>
                <option value="1">Rental</option>
                <option value="2">Lease To Own</option>
                <option value="3">Company</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="lpoId" class="form-control lpo-id" name="">
                <option value="" disabled selected>Select LPO</option>
            </select>
        </div>
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
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="container card selected_passport spare-info p-3" style="display: none">
    <div class="col-md-4 m-2">
        <select id="spareLpoId" class="form-control spare-lpo-id" name="">
            <option value="" disabled selected>Select LPO</option>
            @foreach ($lpos as $item)
                <option value="{{ $item->id }}">{{ $item->lpo_no }}</option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <table class="table table-sm table-hover text-12 data_table_spare">
            <thead>
                <tr>
                    <th>LPO ID</th>
                    <th>Model</th>
                    <th>Total Quantity</th>
                    <th>Quantity Received</th>
                    <th>Quantity Pending</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

     <!---------Vehicle Received---------->
    <div class="modal fade" id="receiveVehicle" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="verifyModalContent" aria-hidden="true">
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
                        <form>
                            @csrf
                            <input type="hidden" name="vehicle_info">
                            <div class="modal-footer">
                                <div class="col-md-12">
                                    <a type="submit" href="javascript:void(0)"  class="btn btn-primary received-submit">Yes</a>
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
    <div class="modal fade" id="receiveSpare"  tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="verifyModalContent" aria-hidden="true">
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
                        <form >
                            @csrf
                            <input type="hidden" name="vehicle_info">
                            <div class="amount">
                                <label for="repair_category">Quantity Received</label>
                                <input id="" name="quantity" class="form-control" type="number" required>
                            </div>
                            <div class="modal-footer">
                                <a type="submit" href="javascript:void(0)"  class="btn btn-primary spare-received-submit">Yes</a>
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

    $(document).on("change", "#lpoId", function(){
        var lpo = ($(this).val());
        var purchasType = ($('.purchase-type').val());
        loadDatatable(purchasType, lpo);
    })


    $(document).on("change", "#spareLpoId", function(){
        var lpo = ($(this).val());
        loadSpareDatatable(lpo);
    })


    $(document).on("change", ".purchase-type", function(e){
        var val = ($(this).val());

        var token = $("input[name='_token']").val();
        $('.appended-lpo').remove('.appended-lpo')
        $.ajax({
            url: "{{ route('ajax-filter-lpo-emi') }}",
            method: 'POST',
            data:{purchase_type:val,_token:token},
            success: function (response) {
                $.each(response, function(key,value){
                    $("#lpoId").append('<option class="appended-lpo" value="'+value.id+'">'+value.lpo_no+'</option>');
                });
            }
        });

        loadDatatable(val, 0);
    });

    $(document).on("click", ".received-submit", function(e){

        $('#receiveVehicle').hide()

        var val = ($('.purchase-type').val());
        var lpo = ($('.lpo-id').val());

        var vehicle_info = ($("input[name='vehicle_info']").val());
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('lpo-vehicle-received') }}",
            method: 'POST',
            data:{vehicle_info:vehicle_info,_token:token},
            success: function (response) {
                loadDatatable(val,lpo)
                if(response.code == 200) {
                    toastr.error("Failed", "Failed!", { timeOut:10000 , progressBar : true});
                }
                if(response.code == 201) {
                    toastr.success("Successfully received", "Success!", { timeOut:10000 , progressBar : true});
                }

            }
        });

    })

    $(document).on("click", ".spare-received-submit", function(e){

        $('#receiveSpare').hide()

        var lpo = ($('.spare-lpo-id').val());
        var vehicle_info = ($("input[name='vehicle_info']").val());
        var quantity = ($("input[name='quantity']").val());

        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('lpo-spare-received') }}",
            method: 'POST',
            data:{vehicle_info:vehicle_info, quantity: quantity, _token:token},
            success: function (response) {
                loadSpareDatatable(lpo)
                if(response.code == 200) {
                    toastr.error("Failed", "Failed!", { timeOut:10000 , progressBar : true});
                }
                if(response.code == 201) {
                    toastr.success("Successfully received", "Success!", { timeOut:10000 , progressBar : true});
                }
                if(response.code == 202) {
                    toastr.error("Quantity entered is more than quantity to be received", "Failed!", { timeOut:10000 , progressBar : true});

                }
            }
        });

    })

    function loadDatatable(val, lpo) {
        $('table.data_table_cls').DataTable().destroy();
        $('table.data_table_cls').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('lpo-filter-vehicle-receive') }}",
                data:{val: val, lpo_id:lpo},
            },
            columns: [
                { data: 'lpo_no' },
                { data: 'model.name' },
                { data: 'make_year' },
                { data: 'chassis_no' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
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

            loadSpareDatatable(0)
        }

    })

    function loadSpareDatatable(lpo) {
        $('table.data_table_spare').DataTable().destroy();
            $('table.data_table_spare').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('lpo-filter-spare-receive') }}",
                data:{val: 1, lpo_id: lpo},
            },
            columns: [
                { data: 'lpo_no' },
                { data: 'model.part_name' },
                { data: 'quantity' },
                { data: 'quantity_received' },
                { data: 'quantity_pending' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
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

</script>


@endsection
