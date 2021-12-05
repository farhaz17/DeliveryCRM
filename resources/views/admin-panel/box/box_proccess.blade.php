@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            padding: 2px;
            font-size: 14px;
        }
        .table th{
            padding: 2px;
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
        .hide_cls{
            display: none;
        }
    </style>
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
                        <option value="{{ $bike->id }}" >{{ $bike->plate_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="details"></div>

        </div>
    </div>
</div>
<div class="modal fade" id="UploadDocuments"  role="dialog" aria-labelledby="UploadDocumentsTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="upload_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadDocumentsTitle">Upload Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Date</label>
                            <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Remarks</label>
                            <textarea class="form-control" placeholder="Enter remarks" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Upload Documents</label>
                            <input class="form-control" type="file" multiple name="documents[]" id="documents">
                        </div>
                    </div>
                    <input type="hidden" name="id" id="ids">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="upload_btn">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  Batch Modal -->
<div class="modal fade bd-example"  id="batch_modal" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Send Bike To Insall Box</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id="batch_form" method="POST" >
                @csrf
                <input type="hidden" name="arrays" id="select_ids">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 form-group mb-3 ">
                            <label for="">Platform</label><br>
                            <select class="form-control" name="platform" id="platform" required >
                                <option value="">select an option</option>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3 ">
                            <label for="">Select Batch</label><br>
                            <select class="form-control" name="batch_id" id="batch_id" required >

                            </select>
                        </div>

                        <div class="col-md-3 form-group mb-3 batch_detail_cls hide_cls ">
                            <label for="repair_category">Platform</label>
                            <h5   id="platform_name" ></h5>
                        </div>
                        <div class="col-md-3 form-group mb-3  batch_detail_cls hide_cls ">
                            <label for="repair_category">Date</label>
                            <h5 id="batch_date" ></h5>
                        </div>
                        <div class="col-md-3 form-group mb-3 batch_detail_cls hide_cls ">
                            <label for="repair_category" >Location</label>
                            <h5 id="batch_location"></h5>
                        </div>
                        <div class="col-md-3 form-group mb-3 batch_detail_cls hide_cls ">
                            <label for="repair_category" >Bike Quantity</label>
                            <h5 id="batch_quantity"></h5>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- end of modal -->
<!-- image upload -->
<div class="modal fade" id="UploadImage"  role="dialog" aria-labelledby="UploadImageTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="image_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadImageTitle">Upload Box Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Date</label>
                            <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Upload Image</label>
                            <input class="form-control" type="file" multiple name="image[]" id="image" >
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Remarks</label>
                            <textarea class="form-control" placeholder="Enter remarks" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="img_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="upload_btn">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ViewDocument"  role="dialog" aria-labelledby="ViewDocumentsTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="update_documents" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadDocumentsTitle">Uploaded Documents</h5>
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
<!--  Batch Modal -->
<div class="modal fade bd-example"  id="batch_modal_view" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Batch Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form  method="POST" >
                @csrf
                <div class="modal-body append_batch">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- end of modal -->
<div class="modal fade" id="ViewImage"  role="dialog" aria-labelledby="UploadImageTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="update_img" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadImageTitle">Uploaded Box Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body append_img">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" style="display: none;" id="box_img_btn">Save</button>
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
        $('#platform').select2({
            placeholder: 'Select a Platform',width:'100%',disabled:'readonly'
        });
        $('#batch_id').select2({
            placeholder: 'Select a Batch' ,width:'100%'
        });
    </script>
    <script>
        $("#platform").change(function () {

            var platform_id = $(this).val();
            var token = $("input[name='_token']").val();
            $("#batch_id").empty();
            $.ajax({
                url: "{{ route('get_box_batchs') }}",
                method: 'POST',
                dataType: 'json',
                data: {platform_id: platform_id, _token:token},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var newOption = new Option(response[i].reference_number, response[i].id, true, true);
                            $('#batch_id').append(newOption);
                            $('#batch_id').val(null);
                        }
                    }
                }
            });

        });
    </script>
    <script>
        $('#batch_id').change(function(){
            var id = $(this).val();

            $.ajax({
                url: "{{ route('get_batch_details') }}",
                method: "get",
                data: {id:id},
                success:function(response){
                    $(".batch_detail_cls").show();
                    $("#batch_date").html(response.date);
                    $("#platform_name").html(response.platform);
                    $("#batch_location").html(response.location);
                    $("#batch_quantity").html(response.quantity);
                }
            });
        });
    </script>
    <script>
        $('.bike').change(function(){
            var bike = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('box_process_details') }}",
                method: "post",
                data: {_token:token,bike:bike},
                success: function(response){
                    $('.details').empty();
                    $('.details').append(response.html);
                }
            });
        });
    </script>
    <script>
        function UploadDocuments(id){
            var id=id;
            $('#ids').val(id);
            $('#UploadDocuments').modal('show');
        }
        function SentBike(id){
            var id=id;
            $('#select_ids').val(id);
            $.ajax({
                url: "{{ route('get_box_platform') }}",
                method: "get",
                data: {id:id},
                success:function(response){
                    $("#platform").val(response.id).change();
                    $('#batch_modal').modal('show');
                }
            });
        }
        function UploadImage(id){
            var id=id;
            $('#img_id').val(id);
            $('#UploadImage').modal('show');
        }
        function ViewDocuments(id){
            var id=id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_box_document_details') }}",
                method: "get",
                data:{id:id,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#ViewDocument').modal('show');
                }
            });
        }
        function ViewSentBike(id){
            var id=id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_box_bike_details') }}",
                method: "get",
                data:{id:id,_token:token},
                success:function(response){
                    $('.append_batch').empty();
                    $("body").removeClass("loading");
                    $('.append_batch').append(response.html);
                    $('#batch_modal_view').modal('show');
                }
            });
        }
        function ViewImage(id){
            var id = id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_box_image') }}",
                method: "get",
                data:{id:id,_token:token},
                success:function(response){
                    $('.append_img').empty();
                    $("body").removeClass("loading");
                    $('.append_img').append(response.html);
                    $('#ViewImage').modal('show');
                }
            });
        }
    </script>
    <?php if(isset($_GET['id'])){ ?>
        <script>
            var id = "<?php echo  $_GET['id'] ?>";
            $(".bike").val(id).change();
        </script>
    <?php } ?>
    <script>
        $(document).ready(function (e){
            $("#upload_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('box_upload_documents') }}",
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
                            $('#UploadDocuments').modal('hide');
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
            $("#batch_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('ajax_send_bike_to_install') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#batch_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#batch_modal').modal('hide');
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
            $("#image_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('upload_box_image') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#image_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#UploadImage').modal('hide');
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
            $("#update_documents").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('update_box_documents') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#update_documents").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#ViewDocument').modal('hide');
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
            $("#update_img").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('update_box_image') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#update_img").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#ViewImage').modal('hide');
                            $('#box_img_btn').hide();
                            $("body").removeClass("loading");
                            $(".bike").val(response.id).change();
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
