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
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Food Permit</a></li>
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
<div class="overlay"></div>

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
                            <label for="remarks" class="d-block text-left">Upload Documents & Box Image</label>
                            <input class="form-control" type="file" multiple name="documents[]" id="documents" >
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
<div class="modal fade" id="UploadPermit"  role="dialog" aria-labelledby="UploadDocumentsTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="permit_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadDocumentsTitle">Upload Food Permit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Expiry Date</label>
                            <input class="form-control" type="date" name="date" id="date" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="remarks" class="d-block text-left">Upload Food Permit</label>
                            <input class="form-control" type="file" multiple name="permits[]" id="permits" >
                        </div>
                    </div>
                    <input type="hidden" name="id" id="select_ids">
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
            <form method="POST" enctype="multipart/form-data">
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

<div class="modal fade" id="ViewPermit"  role="dialog" aria-labelledby="ViewDocumentsTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadDocumentsTitle">Uploaded Permit</h5>
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
                url: "{{ route('food_process_details') }}",
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
        function UploadDocuments(id){
            var id=id;
            $('#ids').val(id);
            $('#UploadDocuments').modal('show');
        }
        function UploadFoodPermit(id){
            var id=id;
            $('#select_ids').val(id);
            $('#UploadPermit').modal('show');
        }
        function ViewDocuments(id){
            var id=id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_food_document_details') }}",
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
        function ViewFoodPermit(id){
            var id=id;
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('get_food_permit_details') }}",
                method: "get",
                data:{id:id,_token:token},
                success:function(response){
                    $('.append_doc').empty();
                    $("body").removeClass("loading");
                    $('.append_doc').append(response.html);
                    $('#ViewPermit').modal('show');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function (e){
            $("#upload_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('food_upload_documents') }}",
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
            $("#permit_form").on('submit',(function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('food_upload_permit') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function () {
                        $("body").addClass("loading");
                    },
                    success: function(response){
                        $("#permit_form").trigger("reset");
                        if(response.code == 100) {
                            toastr.success("Uploaded Successfully!", { timeOut:10000 , progressBar : true });
                            $('#UploadPermit').modal('hide');
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
