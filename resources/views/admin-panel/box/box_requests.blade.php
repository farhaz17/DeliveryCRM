@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .upload {
            padding: 1px;
            font-size: 11px;
            font-weight: bold;
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
        <li>All Requests </li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="AllRequestsTab" data-toggle="tab" href="#AllRequests" role="tab" aria-controls="AllRequests" aria-selected="true"> All Requests ({{$bikes->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="UploadedTab" data-toggle="tab" href="#Uploaded" role="tab" aria-controls="Uploaded" aria-selected="true">Document Uploaded ({{$sent_to_install->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="SendedTab" data-toggle="tab" href="#Sended" role="tab" aria-controls="Sended" aria-selected="true"> Bikes Sented ({{$sended->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="InstalledTab" data-toggle="tab" href="#Installed" role="tab" aria-controls="Installed" aria-selected="true">Box Installed ({{$installed->count()}})</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="AllRequests" role="tabpanel" aria-labelledby="AllRequestsTab">
                    <div class="card-title">Upload Documents</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Requested Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bikes as $bike)
                                <tr>
                                    <td></td>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->users->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($bike->created_at)) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('box_process') }}?id={{ $bike->bike_id }}" target="_blank">Upload Documents</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Uploaded" role="tabpanel" aria-labelledby="UploadedTab">
                    <button class="btn btn-info btn-icon m-1"  id="sent_batch" type="button"><span class="ul-btn__text">Send to Install</span></button>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="uploaded" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Uploaded Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sent_to_install as $bike)
                                <tr>
                                    <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkbox" name="checkbox_array[]" value="{{ $bike->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->remark }}</td>
                                    <td>{{ $bike->doc_date }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('box_process') }}?id={{ $bike->bike_id }}" target="_blank">Sent Bike To Install</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Sended" role="tabpanel" aria-labelledby="SendedTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="send" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Batch</th>
                                    <th scope="col">Sented Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sended as $bike)
                                <tr>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->batch->reference_number }}</td>
                                    <td>{{ $bike->sended_date }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('box_process') }}?id={{ $bike->bike_id }}" target="_blank">Upload Picture</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Installed" role="tabpanel" aria-labelledby="InstalledTab">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="installed" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Received Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installed as $bike)
                                <tr>
                                    <td>{{ $bike->bikes->plate_no }}</td>
                                    <td>{{ $bike->platformdetail->name }}</td>
                                    <td>{{ $bike->img_remark }}</td>
                                    <td>{{ $bike->img_date }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm upload" href="{{ url('box_process') }}?id={{ $bike->bike_id }}" target="_blank">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
            <form action="{{ route('send_bike_to_install') }}" method="POST" >
                @csrf
                <input type="hidden" name="arrays" id="select_ids">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 form-group mb-3 ">
                            <label for="">Select Platform</label><br>
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
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#platform').select2({
            placeholder: 'Select a Platform',width: '100%'
        });
        $('#batch_id').select2({
            placeholder: 'Select a Batch',width: '100%'
        });
    </script>
    <script>
        $("#checkAll").click(function () {
            $('.bike_checkbox').not(this).prop('checked', this.checked);
        });
        $('#sent_batch').click(function(){
            checked = $(".bike_checkbox:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#select_ids").val(my_array);
                $('#batch_modal').modal('show');
            }
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
        $(document).ready(function () {
            'use strict';
            $('#requests').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
        });
        var table = $('#uploaded').DataTable();
        table.columns.adjust().draw();
        var tables = $('#send').DataTable();
        tables.columns.adjust().draw();
        var tables = $('#installed').DataTable();
        tables.columns.adjust().draw();
    </script>
    <script>
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }
        }
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
