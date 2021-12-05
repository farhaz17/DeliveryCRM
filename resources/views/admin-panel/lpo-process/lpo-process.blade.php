@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Process</a></li>
        <li>All Process</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 form-group">
                    <label for="">Select Bike</label>
                    <select id="lpo" name="bike" class="form-control select">
                        <option value="">Select option</option>
                        @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}"
                            @if(Request::get("vehicle_id") && Request::get("vehicle_id") == $vehicle->id)
                                selected
                            @endif
                        >
                        {{ $vehicle->chassis_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="details"></div>

        </div>
    </div>
</div>

<div class="modal fade" id="deliveryNoteModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Checkout<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="deliveryNoteForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div>
                                <a href="{{asset('assets/docs/vehicle-info.xlsx')}}" class="btn btn-primary mb-2" download="vehicle-info.xlsx">Vehicle Sample</a>
                            </div>
                            <div class="row">
                                <input type="hidden" name="inventory_type" value="1">
                                <input type="hidden" name="lpo_id" value="">
                                <div class="col-md-12 vehicle">
                                    <label>Upload Vehicle Info</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="vehicle_info">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="deliveryNoteSubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachVccModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Checkout<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="attachVccForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div class="row">
                                <input type="hidden" name="vehicle_id" value="">
                                {{-- <div class="col-md-12" style="margin-bottom: 8px;">
                                    <label>Select Chassis No</label>
                                    <select name="chassis_no" class="form-control chassis" id="vccChassis">

                                    </select>
                                </div> --}}
                                <div class="col-md-12">
                                    <label>VCC Attachment</label>
                                    <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="attachment">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="attachVccSubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addInsuranceModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Add Insurance<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="addInsuranceForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div class="row">
                                <input type="hidden" name="lpo_id" value="">
                                    <input type="hidden" name="vehicle_id">
                                    <div class="col-md-12">
                                        <label for="repair_category">Insurance Name</label>
                                        <select id="inventoryType" class="form-control" name="insurance_id">
                                            <option value="" disabled selected>Select Insurance</option>
                                            @foreach ($insurance as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="col-md-12">
                                    <label for="repair_category">Inurance No</label>
                                    <input id="" name="insurance_no" class="form-control" type="text">
                                </div>
                                <div class="col-md-12">
                                    <label for="repair_category">Select Traffic File</label>
                                    <select id="inventoryType" class="form-control" name="traffic_file_id">
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($traffic_file as $item)
                                            <option value="{{ $item->id }}">{{ $item->traffic_file_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="addInsuranceSubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="plateModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Plate No<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="plateForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div class="row">
                                <input type="hidden" name="vehicle_id" value="">
                                <div class="col-12">
                                    <label for="repair_category">Plate No</label>
                                    <input id="" name="plate_no" class="form-control" type="text">
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="plateSubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="salikModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Salik Tags<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="salikForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div class="row">
                                <input type="hidden" name="vehicle_id" value="">
                                <div class="col-12">
                                    <label for="repair_category">Salik Tag</label>
                                    <select name="salik_tag" class="form-control">
                                        <option value="">Select option</option>
                                        @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">
                                        {{ $tag->tag_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="salikSubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="readyModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Ready<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="readyForm">
                        @csrf
                        <div class="container m-auto p-3">
                            <div class="row">
                                <input type="hidden" name="vehicle_id" value="">

                                <div class="col-md-12 mt-3 text-center">
                                    <input type="submit" id="readySubmit" class="btn btn-primary" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                </div>

                <div class="view-details">

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.select').select2({
            placeholder: 'Select Bike'
        });

        $("#lpo").change(function () {
            loadLpoProcess($("#lpo").val())
        });

        if($("#lpo").val() != '') {
            loadLpoProcess($("#lpo").val())
        }

        function loadLpoProcess(lpoId) {
            var lpoId = lpoId;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax-lpo-process') }}",
                method: 'POST',
                dataType: 'json',
                data: {lpo_id: lpoId, _token:token},
                success: function(response) {
                    $('.details').html(response);
                }
            });
        }

        $(document).on('click',"#deliveryNoteSubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-store-lpo-vehicle') }}"
            var modal = "#deliveryNoteModal"
            loadProcess('deliveryNoteForm', route, modal)
        });

        $(document).on('click',"#attachVccSubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-lpo-vcc-attachment') }}"
            var modal = "#attachVccModal"
            loadProcess('attachVccForm', route, modal)
        });

        $(document).on('click',"#addInsuranceSubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-lpo-add-insurance') }}"
            var modal = "#addInsuranceModal"
            loadProcess('addInsuranceForm', route, modal)
        });

        $(document).on('click',"#plateSubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-lpo-add-no-plate') }}"
            var modal = "#plateModal"
            loadProcess('plateForm', route, modal)
        });

        $(document).on('click',"#salikSubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-salik-tags') }}"
            var modal = "#salikModal"
            loadProcess('salikForm', route, modal)
        });

        $(document).on('click',"#readySubmit", function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var route = "{{ route('ajax-bike-ready') }}"
            var modal = "#readyModal"
            loadProcess('readyForm', route, modal)
        });

        // $(document).on("click", ".btn-start", function () {
        //     var id = $(this).attr('data-id');
        //     $("input[name='lpo_id']").val(id);
        //     var code = ''

        //     $.ajax({
        //         url: "{{ route('fetch-lpo-chassis') }}",
        //         method: 'GET',
        //         dataType: 'json',
        //         data: {lpo_id: id},
        //         success: function(response) {
        //             $.each(response, function(key,value){
        //             code += '<option class="appended-bike" value="'+value.chassis_no+'">'+value.chassis_no+'</option>';
        //         });
        //             $('.chassis').html(code);
        //         }
        //     });
        // });

        function loadProcess(id, route, modal) {
            var formData = new FormData(document.getElementById(id));
            var url = route;

            $.ajax({
                url: url,
                method: 'POST',
                // dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $(modal).modal('hide');
                    loadLpoProcess($("#lpo").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        }

        $(document).on("click", ".btn-view", function () {
            var id = $("#lpo").val()
            var process = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('get-lpo-process-details') }}",
                method: 'GET',
                dataType: 'json',
                data: {process: process, vehicle_id: id},
                success: function(response) {
                    $('.view-details').html(response);
                }
            });


        });

        $(document).on("click", ".btn-start", function () {
            var id = $("#lpo").val()
            $("input[name='vehicle_id']").val(id);

        });

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
