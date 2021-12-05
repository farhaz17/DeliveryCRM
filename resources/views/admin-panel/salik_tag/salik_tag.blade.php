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
        <li><a href="">Salik Tag</a></li>
        <li>Salik Operation</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-1 mb-3"></div>
    <div class="col-md-10 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="card-title  mb-3">Add New Salik</div>
                <form action="{{ route('save_salik_operation') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="">Salik Free Bikes</label>
                            <select name="bike_id" id="" class="form-control bike" required>
                                <option value="">Select Option</option>
                                @foreach ($bikes as $bike)
                                    <option value="{{ $bike->id }}">{{ $bike->plate_no }} | {{ $bike->chassis_no  }} | {{ $bike->engine_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Unoccupaied Salik</label>
                            <select name="salik_tag" id="" class="form-control salik" required>
                                <option value="">Select Option</option>
                                @foreach ($saliks as $salik)
                                    <option value="{{ $salik->id }}">{{ $salik->tag_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Installation Date</label>
                            <input type="date" name="date" class="form-control form-control-sm" id="" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-12"><br>
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-1 mb-3"></div>
    <div class="col-md-10 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="card-title  mb-3">Salik Installed</div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered text-11" id="datas" style="width: 100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Salik Tag</th>
                                <th scope="col">Installed Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installs as $install)
                            <tr>
                                <td></td>
                                <td>{{ $install->bike->plate_no }}</td>
                                <td>{{ $install->salik->tag_no }}</td>
                                <td>{{ $install->checkin }}</td>
                                <td><a class="text-primary view_cls" id="{{ $install->id }}" data-bike_id="{{ $install->bike_id }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="remove_modal" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('remove_salik_tag') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Remove or Replace Salik</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Select Option</label><br>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="remove_replace" id="remove_salik" value="2"><span>Remove Salik</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="remove_replace" id="replace_salik" value="3"><span>Replace Salik</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group new_cls" style="display: none">
                            <label for="">Unoccupaied Saliks</label><br>
                            <select name="saliks" id="" class="form-control saliks" >
                                <option value="">Select Option</option>
                                @foreach ($saliks as $salik)
                                    <option value="{{ $salik->id }}">{{ $salik->tag_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Date</label>
                            <input type="date" name="date" id="" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Rermark</label>
                            <textarea name="remark" id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="bike_id" id="bike_id">
                <input type="hidden" name="new_bike_id" id="new_bike_id">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('input[name="remove_replace"]').on('change',function(){
            if($(this).val() == "2"){
                $(".new_cls").hide();
            }else if($(this).val() == "3"){
                $(".new_cls").show();
            }
        });
    </script>
    <script>
        $('.view_cls').click(function(){
            var id = $(this).attr('id');
            var bike_id = $(this).attr('data-bike_id');
            $('#bike_id').val(id);
            $('#new_bike_id').val(bike_id);
            $('#remove_modal').modal('show');
        });
    </script>
    <script>
        $('.bike').select2({
            placeholder: 'Select Bike'
        });
        $('.salik').select2({
            placeholder: 'Select Salik'
        });
        $('.saliks').select2({
            placeholder: 'Select Salik',width: '100%'
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datas').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollX": true,
            });
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
