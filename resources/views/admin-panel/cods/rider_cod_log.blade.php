@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>

        .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }

         .table td{
            padding: 2px;
            font-size: 12px;
        }
     </style>

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
    <style>
        div.dataTables_wrapper div.dataTables_processing {

            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Dollar"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Debit</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_debit">{{ number_format($total_debit,2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Credit-Card"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Credit</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_credit">{{ number_format($total_credit,2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6" id="download_div"   >
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Financial"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Balance</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_balance">{{ number_format($total_balance,2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="row">
                    <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                        <label for="start_date">Start Date</label>
                        <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">

                    </div>

                    <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                        <label for="end_date">End Date</label>
                        <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">
                    </div>
                    <input type="hidden" name="table_name" id="table_name" value="datatable" >
                    <div class="col-md-4 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                        <label for="end_date" style="visibility: hidden;">End Date</label>
                        <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                        <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                    </div>

                    <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                        <a href="{{ route('download_rider_log') }}?rider_id={{ request()->id }}&start_date=clear_filter" class="btn btn-info btn-icon m-1" id="download" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Download"></i></span></a>
                    </div>

                </div>
            </div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>



    <div class="separator-breadcrumb border-top"></div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <h5 class="text-center mt-3 font-weight-bold">{{ $full_name }}</h5>
            <div class="card-body">
                <div class="table-responsive">
                        @include('admin-panel.cods.rider_cod_log_table')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
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
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>

    <script>
        $("#apply_filter").click(function(){

            var start_date  =   $("#start_date").val();
            var end_date  =   $("#end_date").val();

            if(start_date != '' &&  end_date != '')
            {
                load_date(start_date, end_date);
                load_data_balance(start_date,end_date);

                var download_link = "{{ route('download_rider_log') }}?rider_id={{ request()->id }}&start_date="+start_date+"&end_date="+end_date;

                $("#download").attr('href',download_link);
            }
            else
            {
                 tostr_display("error","Both date is required");
            }
        });

        $('#remove_apply_filter').click(function(){
            $('#start_date').val('');
            $('#end_date').val('');

            var download_link = "{{ route('download_rider_log') }}?rider_id={{ request()->id }}&start_date=clear_filter";

            $("#download").attr('href',download_link);

            load_date('clear_filter','');
            load_data_balance('clear_filter','');

        });
        </script>


    <script>

            function load_date(start_date='',end_date=''){

                var rider_id ="{{ request()->route('id') }}"

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('cod_rider_log_ajax') }}",
                method: 'POST',
                dataType: 'json',
                data: {_token: token,rider_id: rider_id,start_date:start_date,end_date:end_date},
                success: function (response) {
                    $("#datatable_ab tbody").empty();
                    $("#datatable_ab tbody").append(response.html);

                }});
            }
            function load_data_balance(start_date='',end_date=''){

                var rider_id ="{{ request()->route('id') }}"

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('cod_rider_log_balance_ajax') }}",
                    method: 'POST',
                    data: {_token: token,rider_id: rider_id,start_date:start_date,end_date:end_date},
                    success: function (response) {
                        var array = JSON.parse(response);
                            $("#total_debit").html(array.total_debit);
                            $("#total_credit").html(array.total_credit);
                            $("#total_balance").html(array.total_balance);

                    }});

            }

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
