@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Bike Renewal</a></li>
        <li>Expired Bikes</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true">
                        <i class="nav-icon i-Calendar-4"></i> {{$current_month}} ({{$bike->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#first_month" role="tab" aria-controls="first_month" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i>{{$first_month}} ({{$bike_first->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#second_month" role="tab" aria-controls="second_month" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i>{{$second_month}} ({{$bike_sec->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#third_month" role="tab" aria-controls="third_month" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i>{{$third_month}} ({{$bike_third->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#fourth_month" role="tab" aria-controls="fourth_month" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i>{{$fourth_month}} ({{$bike_four->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#fifth_month" role="tab" aria-controls="taking_visa" aria-selected="false">
                        <i class="nav-icon i-Calendar-4 mr-1"></i>{{$fifth_month}} ({{$bike_five->count()}})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#before" role="tab" aria-controls="before" aria-selected="false">
                    <i class="nav-icon i-Calendar-4 mr-1"></i>Before {{$fifth_month}} ({{$before_bike->count()}})</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="not_employee" role="tabpanel" aria-labelledby="not_employeeTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewone" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike as $expiry)
                                <tr>
                                    <td></td>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkbox" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="first_month" role="tabpanel" aria-labelledby="first_monthTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewtwo" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="uploaded" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAllone"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike_first as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxone" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="second_month" role="tabpanel" aria-labelledby="second_monthTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewthree" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="permits" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAlltwo"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike_sec as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxtwo" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="third_month" role="tabpanel" aria-labelledby="third_monthTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewfour" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="permits_third" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAllthree"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike_third as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxthree" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="fourth_month" role="tabpanel" aria-labelledby="fourth_monthTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewfive" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="permits_four" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAllfour"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike_four as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxfour" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="fifth_month" role="tabpanel" aria-labelledby="fifth_monthTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewsix" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="permits_five" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAllfive"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bike_five as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxfive" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="before" role="tabpanel" aria-labelledby="beforeTab">
                    {{-- <button class="btn btn-info btn-icon m-1" id="renewseven" type="button"><span class="ul-btn__text">Renew Bike</span></button> --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="befores" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  class="checkboxs"  id="checkAllsix"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th> --}}
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Insurance Expiry Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($before_bike as $expiry)
                                <tr>
                                    {{-- <td>
                                        <label class="checkbox checkbox-outline-primary text-10">
                                            <input type="checkbox" class="bike_checkboxsix" name="checkbox_array[]" value="{{ $expiry->id }}"><span></span><span class="checkmark"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ $expiry->plate_no }}</td>
                                    <td>{{ $expiry->chassis_no }}</td>
                                    <td>{{ $expiry->expiry_date }}</td>
                                    <td>{{ $expiry->insurance_expiry_date }}</td>
                                    <td><a class="text-primary mr-2 edit" id="{{ $expiry->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a></td>
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

<div class="modal fade" id="token_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('renewal_token_save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Issue Token</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Token</label>
                            <input type="text" name="token_no" class="form-control form-control-sm" id="" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Attachment</label>
                            <input type="file" name="attachment[]" class="form-control-file form-control-sm" multiple id="" >
                        </div>
                    </div>
                    <input type="hidden" name="id" id="bike_id">
                </div>
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
    <script>
        $('.edit').click(function(){
            var id = $(this).attr('id');
            $('#bike_id').val(id);
            $('#token_modal').modal('show');
        });
    </script>
    {{-- <script>
        $("#checkAll").click(function () {
            $('.bike_checkbox').not(this).prop('checked', this.checked);
        });
        $('#renewone').click(function(){
            checked = $(".bike_checkbox:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAllone").click(function () {
            $('.bike_checkboxone').not(this).prop('checked', this.checked);
        });
        $('#renewtwo').click(function(){
            checked = $(".bike_checkboxone:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxone:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAlltwo").click(function () {
            $('.bike_checkboxtwo').not(this).prop('checked', this.checked);
        });
        $('#renewthree').click(function(){
            checked = $(".bike_checkboxtwo:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxtwo:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAllthree").click(function () {
            $('.bike_checkboxthree').not(this).prop('checked', this.checked);
        });
        $('#renewfour').click(function(){
            checked = $(".bike_checkboxthree:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxthree:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAllfour").click(function () {
            $('.bike_checkboxfour').not(this).prop('checked', this.checked);
        });
        $('#renewfive').click(function(){
            checked = $(".bike_checkboxfour:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxfour:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAllfive").click(function () {
            $('.bike_checkboxfive').not(this).prop('checked', this.checked);
        });
        $('#renewsix').click(function(){
            checked = $(".bike_checkboxfive:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxfive:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });

        $("#checkAllsix").click(function () {
            $('.bike_checkboxsix').not(this).prop('checked', this.checked);
        });
        $('#renewseven').click(function(){
            checked = $(".bike_checkboxsix:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".bike_checkboxsix:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#bike_id").val(my_array);
                $('#token_modal').modal('show');
            }
        });
    </script> --}}
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
        var table = $('#uploaded,#permits,#permits_third,#permits_four,#permits_five,#befores').DataTable();
        table.columns.adjust().draw();
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
