@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table th{
            padding: 3px;
            font-size: 14px;
        }
        .table td{
            padding: 3px;
            font-size: 14px;
        }
        .table th{
            padding: 3px;
            font-size: 14px;
            font-weight: 700;
        }
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
        .btn-start {
            padding: 1px;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Accident</a></li>
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
                        <option value="{{ $bike->id }}" >{{ $bike->plate_no }} | {{ $bike->chassis_no  }} | {{ $bike->engine_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="details"></div>

        </div>
    </div>
</div>
{{-- Documents Upload --}}
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="upload_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Upload Documents</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body upload_documents">

                </div>
                <input type="hidden" name="ids" id="ids">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Claim Process --}}
<div class="modal fade" id="claim_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="claim_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Claim Process</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="claim_date" class="form-control form-control-sm" id="claim_date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Documents</label>
                            <input type="file" name="claim_file[]" class="form-control-file form-control-sm" multiple id="">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Rermark</label>
                            <textarea name="claim_remark" id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="claim_id" id="claim_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Delivery Garage --}}
<div class="modal fade" id="delivery_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="delivery_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Delivery to Garage</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Claim Number</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Enter Claim Number" name="claim_no" id="">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="date" class="form-control form-control-sm" id="date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Garage</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Enter Garage" name="garage">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Concerned Person</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Enter Concerned Person" name="person">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Contact</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Enter Contact" name="contact">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="del_id" id="del_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Loss Repair --}}
<div class="modal fade" id="loss_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="loss_repair_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Loss Or Repair</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Bike Condition</label><br>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="loss_or_repair" id="loss_bike" value="1"><span>Total Loss</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="loss_or_repair" id="repair_bike" value="2"><span>Repairable</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group offer_letter" style="display: none">
                            <label for="">Upload Offer Letter</label>
                            <input type="file" name="offer_letter[]" class="form-control-file form-control-sm" multiple id="offer_letter">
                        </div>
                        <div class="col-md-12 form-group transfer_letter" style="display: none">
                            <label for="">Upload Transfer Letter</label>
                            <input type="file" name="transfer_letter[]" class="form-control-file form-control-sm" multiple id="transfer_letter">
                        </div>
                        <div class="col-md-12 form-group receive_date" style="display: none">
                            <label for="">Receiving Date</label>
                            <input type="date" class="form-control form-control-sm" name="date" >
                        </div>
                        <div class="col-md-12 form-group person" style="display: none">
                            <label for="">Person</label>
                            <input type="text" class="form-control form-control-sm" name="person" placeholder="Enter Person">
                        </div>
                        <div class="col-md-12 form-group condition" style="display: none">
                            <label for="">Bike Condition</label>
                            <textarea name="condition" id="" cols="5" rows="3" class="form-control" placeholder="Enter Bike Conditon"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="loss_id" id="loss_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Loss Claim --}}
<div class="modal fade" id="lossclaim_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="loss_claim_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Claim Submission</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="lossclaim_date" class="form-control form-control-sm" id="claim_date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Documents</label>
                            <input type="file" name="lossclaim_file[]" class="form-control-file form-control-sm" multiple id="">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Rermark</label>
                            <textarea name="lossclaim_remark" id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="lossclaim_id" id="lossclaim_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Bike Cancel --}}
<div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="loss_cancel_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Bike Cancellation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="cancel_date" class="form-control form-control-sm" id="cancel_date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Rermark</label>
                            <textarea name="cancel_remark" id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="cancel_id" id="cancel_id">
                <input type="hidden" name="cancel_bike_id" id="cancel_bike_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- View Documents --}}
<div class="modal fade" id="ViewDocument"  role="dialog" aria-labelledby="ViewDocumentsTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="DocumentsTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body append_doc">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.bike').select2({
            placeholder: 'Select a Bike'
        });
    </script>
    <script>
        $('.bike').change(function(){
            var bike = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('accident_process_details') }}",
                method: "post",
                data: {_token:token,bike:bike},
                success: function(response){
                    $('.details').empty();
                    $('.details').append(response.html);
                }
            });
        });
    </script>
    <?php if(isset($_GET['id'])){ ?>
        <script>
            var id = "<?php echo  $_GET['id'] ?>";
            $(".bike").val(id).change();
        </script>
    <?php } ?>
    <script>
        $('input[name="loss_or_repair"]').on('change',function(){
            if($(this).val() == "1"){
                $(".offer_letter").show();
                $(".transfer_letter").show();
                $(".receive_date").hide();
                $(".person").hide();
                $(".condition").hide();
            }else if($(this).val() == "2"){
                $(".offer_letter").hide();
                $(".transfer_letter").hide();
                $(".receive_date").show();
                $(".person").show();
                $(".condition").show();
            }
        });
    </script>
    <script>
        function UploadDocuments(id){
            var id=id;
            var token = $("input[name='_token']").val();
            $('#ids').val(id);

            $.ajax({
                url: "{{ route('get_upload_modal_accident') }}",
                method: 'post',
                data:{id:id,_token:token},
                success:function(response){
                    $('.upload_documents').empty();
                    $("body").removeClass("loading");
                    $('.upload_documents').append(response.html);
                    $('#upload_modal').modal('show');
                }
            });
        }
        function ClaimProcess(id){
            var id=id;
            $('#claim_id').val(id);
            $('#claim_modal').modal('show');
        }
        function DeliveryToGarage(id){
            var id=id;
            $('#del_id').val(id);
            $('#delivery_modal').modal('show');
        }
        function LossOrRepair(id){
            var id=id;
            $('#loss_id').val(id);
            $('#loss_modal').modal('show');
        }
        function LossClaim(id){
            var id=id;
            $('#lossclaim_id').val(id);
            $('#lossclaim_modal').modal('show');
        }
        function LossBikeCancel(id,bike_id){
            var id=id;
            var bike_id=bike_id;
            $('#cancel_id').val(id);
            $('#cancel_bike_id').val(bike_id);
            $('#cancel_modal').modal('show');
        }
        function ViewDocuments(id){
            var id=id;
            var type=1;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Uploaded Documents');
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewClaim(id){
            var id=id;
            var type=2;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Claim Details');
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewDelivery(id){
            var id=id;
            var type=3;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Delivery Details');
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewLossRepair(id){
            var id=id;
            var type=4;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Loss Or Repair');
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewLossClaim(id){
            var id=id;
            var type=5;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Claim Details');
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewCancel(id){
            var id=id;
            var type=6;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_accident_documents') }}",
                method: "get",
                data:{id:id,type:type,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $('#DocumentsTitle').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#DocumentsTitle').append('Bike Cancellation Details');
                    $('#ViewDocument').modal('show');
                }
            })
        }
    </script>
    <script>
        $(document).ready(function (e){
            $("#upload_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save_accident_documents') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#upload_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#upload_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        $(document).ready(function (e){
            $("#claim_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save_claim_process') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#claim_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Submitted Successfully!", { timeOut:10000 , progressBar : true });
                            $('#claim_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }else if(response.code == 101){
                            toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        $(document).ready(function (e){
            $("#delivery_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('bike_delivery_to_garage') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#delivery_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Submitted Successfully!", { timeOut:10000 , progressBar : true });
                            $('#delivery_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }else if(response.code == 101){
                            toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        $(document).ready(function (e){
            $("#loss_repair_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save_loss_repair') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#loss_repair_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Submitted Successfully!", { timeOut:10000 , progressBar : true });
                            $('#loss_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }else if(response.code == 101){
                            toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        $(document).ready(function (e){
            $("#loss_claim_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save_lossclaim_process') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#loss_claim_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Submitted Successfully!", { timeOut:10000 , progressBar : true });
                            $('#lossclaim_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }else if(response.code == 101){
                            toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        $(document).ready(function (e){
            $("#loss_cancel_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save_cancel_bike_process') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#loss_cancel_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Submitted Successfully!", { timeOut:10000 , progressBar : true });
                            $('#cancel_modal').modal('hide');
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
                        }else if(response.code == 101 || response.code == 102){
                            toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        }
                    }
                });
            }));
        });
    </script>
    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
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
