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
        <li class="breadcrumb-item"><a href="">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create VCC Attachment</li>
    </ol>
</nav>

<div class="container mb-4">
    <button id="attachVccBtn" class="btn btn-primary p-2 steps-btn" value="1">Attach VCC (Step 1)</button>
    <button class="btn btn-success p-2 steps-btn" value="2">Add Insurance (Step 2)</button>
    <button class="btn btn-warning p-2 steps-btn" value="3">Plate Registration (Step 3)</button>
</div>
<div class="container card selected_passport p-3" style="">
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


    <!---------VCC Attachment---------->
    <div class="modal fade" id="attachVcc" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>VCC Attachment<h3>
                        </div>
                    </div>

                        <div class="renew p-3">
                            <form   method="post" action="{{ url('/lpo-vcc-attachment') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="vehicle_info">
                                <div class="">
                                    <label>VCC Attachment</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="attachment">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary" value="Add">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

         <!---------Assign Plate---------->
    <div class="modal fade" id="noPlate" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Plate<h3>
                        </div>
                    </div>

                    <div class="renew p-3">
                        <form   method="post" action="{{ url('/lpo-add-no-plate') }}">
                            @csrf
                            <input type="hidden" name="vehicle_info">
                            <div class="">
                                <label for="repair_category">Plate No</label>
                                <input id="" name="plate_no" class="form-control" type="text">
                            </div>

                            <div class="modal-footer">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

     <!---------Assign Insurance---------->
 <div class="modal fade" id="addInsurance" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Insurance<h3>
                    </div>
                </div>

                <div class="renew p-3">
                    <form   method="post" action="{{ url('/lpo-add-insurance') }}">
                        @csrf
                        <div class="">
                            <input type="hidden" name="vehicle_info">
                            <label for="repair_category">Insurance Name</label>
                            <select id="inventoryType" class="form-control" name="insurance_id">
                                <option value="" disabled selected>Select Insurance</option>
                                @foreach ($insurance as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">
                            <label for="repair_category">Inurance No</label>
                            <input id="" name="insurance_no" class="form-control" type="text">
                        </div>
                        <div class="">
                            <label for="repair_category">Select Traffic File</label>
                            <select id="inventoryType" class="form-control" name="traffic_file_id">
                                <option value="" disabled selected>Select Company</option>
                                @foreach ($traffic_file as $item)
                                    <option value="{{ $item->id }}">{{ $item->traffic_file_no }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Add">
                            </div>
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


    $(document).on("click", ".steps-btn", function(e){
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
                url : "{{ URL::to('lpo-filter-vcc-vehicle') }}",
                data:{val: val},
            },
            columns: [
                { data: 'lpo_id' },
                { data: 'model_id' },
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
    });

    $(document).on("click", ".vcc-modal", function () {
        var id = $(this).attr('data-id');
        console.log(id);
        $("input[name='vehicle_info']").val(id);
    });

</script>


@endsection
