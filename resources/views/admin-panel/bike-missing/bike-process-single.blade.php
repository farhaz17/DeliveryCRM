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
        <li><a href="">Box</a></li>
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
                    <select id="bike" name="bike" class="form-control bike">
                        <option value="">Select option</option>
                        @foreach ($bikes as $bike)
                        <option value="{{ $bike->id }}"
                            @if(Request::get("bike_id") && Request::get("bike_id") == $bike->id)
                                selected
                            @endif
                        >
                        {{ $bike->plate_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="details"></div>

        </div>
    </div>
</div>

<div class="modal fade" id="policeRequestModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
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
                    <form id="complaintForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Complaint Date</label>
                            <input id="" name="complaint_date" class="form-control" type="date">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Police Station</label>
                            <input name="police_station" class="form-control" type="text" autocomplete="on" id="policeStation">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Attachment</label>
                            <input id="" name="police_request_attachment[]" class="form-control" multiple type="file">
                        </div>
                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            <textarea name="complaint_remarks" id="complaintRemarks" class="form-control" rows="4" cols="50"></textarea>
                            {{-- <input id="" class="form-control" type="text"> --}}
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input id="complaintSubmit" type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="policeReportModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <label class="radio radio-outline-success">
                            <input type="radio"  class=""  value="1" name="police_report" checked><span>Found</span><span class="checkmark"></span>
                        </label>
                        <label class="radio radio-outline-success ml-2">
                            <input type="radio"  class=""  value="2" name="police_report" ><span>Proceed</span><span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="found">
                    <form id="foundForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            <textarea name="found_remarks" id="foundRemarks" class="form-control" rows="4" cols="50"></textarea>
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Attachment</label>
                            <input id="" name="found_attachment[]" class="form-control" multiple type="file">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" id="foundSubmit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="proceed" style="display: none">
                    <form id="proceedForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Report</label>
                            <input id="" name="police_report" class="form-control" type="text">
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Attachment</label>
                            <input id="" name="police_report_attachment[]" class="form-control" multiple type="file">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" id="reportSubmit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="insuranceClaimModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                </div>

                <div>
                    <form id="claimForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Remarks</label>
                            {{-- <input id="" name="claim_remarks" class="form-control" type="text"> --}}
                            <textarea name="claim_remarks" id="claimRemarks" class="form-control" rows="4" cols="50"></textarea>
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Documents</label>
                            <input id="" name="claim_documents[]" class="form-control" multiple type="file">
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Offer Letter</label>
                            <input id="" name="claim_offer[]" class="form-control" multiple type="file">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" id="claimSubmit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                </div>

                <div>
                    <form id="paymentForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Amount</label>
                            <input id="" name="payment_amount" class="form-control" type="text">
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Attachment</label>
                            <input id="" name="payment_attachment[]" class="form-control" multiple type="file">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" id="paymentSubmit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancellationModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                </div>

                <div>
                    <form id="cancellationForm">


                        <input type="hidden" id="bikeId" name="bike_id">

                        {!! csrf_field() !!}

                        <div class="m-2">
                            <label for="repair_category">Cancellation Date</label>
                            <input id="" name="cancellation_date" class="form-control" type="date" required>
                        </div>

                        <div class="m-2">
                            <label for="repair_category">Cancellation Remarks</label>
                            <input id="" name="cancellation_remarks" class="form-control" type="text">
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" id="cancellationSubmit" class="btn btn-primary" value="Submit">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
        $('#bike').select2({
            placeholder: 'Select a Bike'
        });
    </script>
    <script>
        $("#bike").change(function () {
            loadMissingProcess($("#bike").val())
        });

        if($("#bike").val() != '') {
            loadMissingProcess($("#bike").val())
        }

        $("#complaintSubmit").click(function (evt) {
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var formData = new FormData(document.getElementById("complaintForm"));
            $.ajax({
                url: "{{ route('store-police-complaint') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $("#policeRequestModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $("#reportSubmit").click(function (evt) {
            evt.preventDefault();
            var formData = new FormData(document.getElementById("proceedForm"));
            $(this).attr('disabled','disabled');
            $.ajax({
                url: "{{ route('store-police-report') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $("#policeReportModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $("#foundSubmit").click(function (evt) {
            evt.preventDefault();
            var formData = new FormData(document.getElementById("foundForm"));
            $(this).attr('disabled','disabled');
            $.ajax({
                url: "{{ route('store-found-remarks') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $("#policeReportModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $("#claimSubmit").click(function (evt) {
            evt.preventDefault();
            var formData = new FormData(document.getElementById("claimForm"));
            $(this).attr('disabled','disabled');
            $.ajax({
                url: "{{ route('store-insurance-claim') }}",
                method: 'POST',
                // dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $("#insuranceClaimModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $("#paymentSubmit").click(function (evt) {
            evt.preventDefault();
            var formData = new FormData(document.getElementById("paymentForm"));
            $(this).attr('disabled','disabled');
            $.ajax({
                url: "{{ route('store-payment-receive') }}",
                method: 'POST',
                // dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response) {
                    console.log(response)
                    $("#paymentModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $("#cancellationSubmit").click(function (evt) {
            console.log('response')
            evt.preventDefault();
            $(this).attr('disabled','disabled');
            var formData = new FormData(document.getElementById("cancellationForm"));
            $.ajax({
                url: "{{ route('store-vehicle-cancellation') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    console.log(response)
                    $("#cancellationModal").modal('hide');
                    loadMissingProcess($("#bike").val())
                    toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                }
            });
        });

        $(document).on("click", ".btn-view", function () {
            var id = $("#bike").val()
            var process = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('get-missing-process-details') }}",
                method: 'GET',
                dataType: 'json',
                data: {process: process, bike_id: id},
                success: function(response) {
                    $('.view-details').html(response);
                }
            });
        });

        function loadMissingProcess(bikeId) {
            var bikeId = bikeId;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax-missing-process') }}",
                method: 'POST',
                dataType: 'json',
                data: {bike_id: bikeId, _token:token},
                success: function(response) {
                    $('.details').html(response);
                }
            });
        }

        $(document).on("click", ".btn-start", function () {
            var id = $(this).attr('data-id');
            $("input[name='bike_id']").val(id);
        });

        $('input[name=police_report]').change(function() {
            if (this.value == 1) {
                $(".found").show();
                $(".proceed").hide();
            }
            else if (2) {
                $(".found").hide();
                $(".proceed").show();
            }
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

        var paths = "{{ url('station-autocomplete') }}";

        $('#policeStation').typeahead({
            source: function(query, process){
                return $.get(paths, {query:query}, function(data){
                    return process(data);
                });
            }
        });
    </script>
@endsection
