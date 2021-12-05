@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Close Month</a></li>
        <li>Close Month Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center"><i class="i-Financial"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Total Amount</p>
                                <p class="text-primary text-24 line-height-1 mb-2" id="total_amount">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center"><i class="i-Motorcycle"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Total Riders</p>
                                <p class="text-primary text-24 line-height-1 mb-2" id="total_rider">0</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="">Start Date</label>
                    <input type="text" name="" id="start_date" autocomplete="off" class="form-control form-control-rounded">
                </div>
                <div class="col-md-3">
                    <label for="">End Date</label>
                    <input type="text" name="" id="end_date" autocomplete="off" class="form-control form-control-rounded">
                </div>
                <div class="col-md-3"><br>
                    <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-3 form-group mb-3 ">
                    <label for="batch_date">Select batch Date</label>
                    <select class="form-control" name="batch_date" id="batch_date" >
                        <option value="" selected disabled>select option of start and end date</option>
                            @foreach($dates_batch as $date)
                                <option value="{{ $date->date }}">{{ $date->date }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group mb-3 "  style="margin-top: 20px;"  >
                    <button class="btn btn-info btn-icon m-1" id="apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="close_month" style="width: 100%;">
                            <thead>
                            <tr>
                                <th scope="col">Rider Name</th>
                                <th scope="col">Rider Id</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        tail.DateTime("#start_date,#end_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        });
        $('#batch_date').select2({
                placeholder: 'select option of start and end date'
            });

    </script>
    <script type="text/javascript">

        function load_data(start_date='',end_date=''){

            var table = $('#close_month').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },

                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Close Month Report',
                                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                            exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                    'pageLength',
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                    url : "{{ route('ajax_close_month_report') }}",
                    data:{start_date:start_date, end_date:end_date},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'platform_code', name: 'platform_code'},
                    {data: 'close_month_amount', name: 'close_month_amount'},
                    {data: 'date', name: 'date'},
                ]
            });
        }

        function verify_load_data(batch_date=''){

            var table = $('#close_month').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },

                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Close Month Report',
                                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                            exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                    'pageLength',
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                    url : "{{ route('ajax_close_month_report') }}",
                    data:{batch_date:batch_date},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'platform_code', name: 'platform_code'},
                    {data: 'close_month_amount', name: 'close_month_amount'},
                    {data: 'date', name: 'date'},
                ]
            });
        }

        function total(start_date='',end_date=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_total_close_month') }}",
                method:'POST',
                data:{start_date:start_date,end_date:end_date,_token:token},
                success:function(response){

                    var  array = JSON.parse(response);
                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);
                }
            });
        }

        function verify_total(batch_date=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_total_close_month') }}",
                method:'POST',
                data:{batch_date:batch_date,_token:token},
                success:function(response){

                    var  array = JSON.parse(response);
                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);
                }
            });
        }
    </script>
    <script>
        $('#apply_filter').on('click',function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            if(start_date != '' && end_date != '')
            {
                $('#close_month').DataTable().destroy();
                load_data(start_date,end_date);
                total(start_date,end_date);
            }
            else{
                tostr_display("error","All field is required");
            }
        });
        $('#remove_apply_filter').on('click',function(){
            $('#start_date').val('');
            $('#end_date').val('');
            $("#total_rider").html('0');
            $("#total_amount").html('0');
        });

        $("#apply_filter_two").click(function(){
            var batch_date  =   $("#batch_date").val();

            if(batch_date != null)
            {
                $('#close_month').DataTable().destroy();
                verify_load_data(batch_date);
                verify_total(batch_date);
            }
            else{
                tostr_display("error","Batch date is required");
            }
        });
        $('#remove_apply_filter_two').click(function(){
            $('#batch_date').val('');
            $("#total_rider").html('0');
            $("#total_amount").html('0');
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
@endsection
