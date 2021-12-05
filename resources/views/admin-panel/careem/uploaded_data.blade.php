@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
        .download_link{
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Careem</a></li>
        <li>Uploaded Data</li>
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

                <div class="col-lg-4 col-md-6 col-sm-6" id="download_div"  download style="display: none;">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center"><i class="i-Download"></i>
                            <div class="content">
                                <a href="#" id="download_btn" class="download_link">Orignal File Download</a>
                                <p class="text-primary text-24 line-height-1 mb-2"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                    <label for="batch_date">Select batch Date</label>
                    <select class="form-control" name="batch_date" id="batch_date" >
                        <option value="" selected disabled>select option of start and end date</option>
                        @foreach($batchs as $batch)
                            <option value="{{ $batch->start_date }}">{{ $batch->start_date }} / {{ $batch->end_date }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                    <button class="btn btn-info btn-icon m-1" id="apply" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                    <button class="btn btn-danger btn-icon m-1" id="remove_apply" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-11" id="data">
                    <thead>
                    <tr>
                        <th scope="col">Rider id</th>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#apply').on('click',function(){
            var date = $('#batch_date').val();

            if(date != null){
                $('#data').DataTable().destroy();
                load_data(date);
                get_details(date);
            }else
            {
                tostr_display("error","Batch date is required");
            }
        });
        $('#remove_apply').on('click',function(){
            $("#download_div").hide();
            $("#total_amount").html(0);
            $("#total_rider").html(0);
            $('#batch_date').val(null).trigger("change");
        });
    </script>
    <script>
        function load_data(date= ''){

            var table = $('#data').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0][1],"width": "30%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'excel',
                    title: 'Uploaded Data',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                            search: 'applied',
                            order: 'applied'
                         }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[25, 100, -1], [25, 100, "All"]],

                ajax:{
                    url : "{{ route('careem_uploaded_data') }}",
                    data:{start_date:date},
                },

                "deferRender": true,
                columns: [
                    {data: 'driver_id', name: 'driver_id'},
                    {data: 'rider_name', name: 'rider_name'},
                    {data: 'total_driver_other_cost', name: 'total_driver_other_cost'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                ]
            });
        }

        function get_details(date=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('careem_get_details') }}",
                method: 'POST',
                data: {start_date: date , _token:token},
                success: function(response) {
                    var  array = JSON.parse(response);
                    if(array.original_path!=''){
                        $("#download_div").show();
                        $("#download_btn").attr('href',array.original_path);
                    }else{
                        $("#download_div").hide();
                    }

                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);
                }
            });
        }
    </script>
    <script>
        $('#batch_date').select2({
            placeholder: 'select option of start and end date'
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
