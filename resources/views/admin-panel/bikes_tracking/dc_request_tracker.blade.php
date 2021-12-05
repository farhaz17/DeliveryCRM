@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Tracker</a></li>
        <li>DC Request</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card col-md-8 offset-md-2 mb-2">
    <div class="card-body">
        <div class="card-title">Tracker Installation Request
            <button class="btn btn-info btn-icon m-1" id="sent_tracker" type="button" style="float: right;"><span class="ul-btn__text">Send Request</span></button>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-11" id="requests" style="width:100%;">
                <thead>
                <tr>
                    <th></th>
                    <th scope="col">
                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                            <input type="checkbox" id="checkAll"><span>All</span><span class="checkmark"></span>
                        </label>
                    </th>
                    <th scope="col">Plate No</th>
                    <th scope="col">Chasis No</th>
                    <th scope="col">Engine No</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($tracker_free_bikes as $tracker)
                    <tr>
                        <td></td>
                        <td>
                            <label class="checkbox checkbox-outline-primary text-10">
                                <input type="checkbox" name="checkbox_array[]" class="checkboxs" value="{{ $tracker->id }}"><span></span><span class="checkmark"></span>
                            </label>
                        </td>
                        <td>{{ $tracker->plate_no }}</td>
                        <td>{{ $tracker->chassis_no }}</td>
                        <td>{{ $tracker->engine_no }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="tracker_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('save_dc_request_tracker') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Tracker Request</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    Are You Sure Want To Send Request
                    <input type="hidden" name="id" id="tracker_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-info ml-2" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $("#checkAll").click(function () {
            $('.checkboxs').not(this).prop('checked', this.checked);
        });

        $('#sent_tracker').click(function() {
            checked = $(".checkboxs:checked").length;

            if(!checked) {
                tostr_display("error","You must check at least one checkbox");
                return false;
            }else{
                var my_array = [];

                $(".checkboxs:checked").each(function(){
                    my_array.push($(this).val());
                });
                $("#tracker_id").val(my_array);
                $('#tracker_modal').modal('show');
            }
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
                "scrollY": false,
            });
        });
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
