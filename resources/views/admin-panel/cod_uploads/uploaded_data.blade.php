@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')

{{--    <div class="separator-breadcrumb border-top"></div>--}}

<style>

    p.text-muted.mt-2.mb-0 {
        white-space: nowrap;
    }
    .download_link{
        white-space: nowrap;
    }
</style>


{{--accordian start--}}

<div class="col-md-12">
    <div class="card">
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

                    {{-- <div class="col-md-3 form-group mb-3 "  style="float: left; "  >
                        <label for="batch_date">Select Platform</label>
                        <select class="form-control" name="normal_platfrom_id" id="normal_platform_id" >
                            <option value="" selected disabled>select an option</option>
                            @foreach($platforms as $plt)
                                <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                            @endforeach

                        </select>
                    </div> --}}

                <div class="col-md-3 form-group mb-3 " style="float: left;" >
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">

                </div>

                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                    <label for="end_date">End Date</label>
                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">
                </div>
                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                    <label for="end_date" style="visibility: hidden;">End Date</label>
                    <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                </div>

{{--                <div class="col-md-2 form-group mb-3 " style="float: left;"  >--}}
{{--                    <label for="batch_date">Select batch Date</label>--}}
{{--                    <select class="form-control" name="batch_date" id="batch_date" >--}}
{{--                        <option value="">select option of start and end date</option>--}}
{{--                        @foreach($dates_batch as $date)--}}
{{--                            <option value="{{ $date->start_date }}">{{ $date->start_date }} / {{ $date->end_date }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <input type="hidden" name="table_name" id="table_name" value="datatable" >--}}
{{--                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >--}}
{{--                    <label for="end_date" style="visibility: hidden;">End Date</label>--}}
{{--                    <button class="btn btn-info btn-icon m-1" id="apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>--}}
{{--                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>--}}
{{--                </div>--}}
                </div>

                <div class="row">

                    {{-- <div class="col-md-3 form-group mb-3 "  style="float: left; "  >
                        <label for="batch_date">Select Platform</label>
                        <select class="form-control" name="batch_platfrom_id" id="batch_platform_id" >
                            <option value="" selected disabled>select an option</option>
                            @foreach($platforms as $plt)
                                <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                        <label for="batch_date">Select batch Date</label>
                        <select class="form-control" name="batch_date" id="batch_date" >

                        </select>
                    </div>

                    <input type="hidden" name="table_name" id="table_name" value="datatable" >
                    <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                        <label for="end_date" style="visibility: hidden;">End Date</label>
                        <button class="btn btn-info btn-icon m-1" id="apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                        <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter_two" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                    </div>
                </div>








            </div>

        </div>

    <div class="separator-breadcrumb border-top"></div>

</div>



{{-- accordian end here--}}


    {{--    remarks modal--}}

    <div class="modal fade" id="remark_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="remark_p"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{--remarks modal end--}}

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-sm " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('cods.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select Status</label>
                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class=" text-left">
            <div class="">



                <div class="card text-left">
                    <div class="card-body">



                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered text-11" id="datatable_not_employee">
                                <thead>
                                <tr>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Rider id</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Upload date</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
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




    <script type="text/javascript">

        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };

        function verify_load_data(from_date= '', end_date= '',type='',platform=''){

            var table = $('#datatable_not_employee').DataTable({
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
                    "action": newexportaction,
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
                    url : "{{ route('uploaded_data') }}",
                    data:{from_date:from_date, end_date:end_date,verify:"verify table",type:type,platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'rider_id', name: 'rider_id'},
                    {data: 'rider_name', name: 'rider_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'platform', name: 'platform'},
                    {data: 'upload_date', name: 'upload_date'},
                ]
            });

        }

        function not_verify_load_data(from_date= '', end_date= '',platform=''){

            var table = $('#datatable_not_employee').DataTable({
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
                    "action": newexportaction,
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
                    url : "{{ route('uploaded_data') }}",
                    data:{from_date:from_date, end_date:end_date,verify:"verify table",platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'rider_id', name: 'rider_id'},
                    {data: 'rider_name', name: 'rider_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'platform', name: 'platform'},
                    {data: 'upload_date', name: 'upload_date'},
                ]
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // verify_load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var normal_platform_id  =   4;



                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    not_verify_load_data(start_date, end_date,normal_platform_id);
                    get_digits(start_date,end_date,normal_platform_id);
                }
                else
                {
                    tostr_display("error","Both date is required");
                }
            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#normal_platform_id').val(null).trigger('change');


                $('#datatable_not_employee').DataTable().destroy();
                verify_load_data();
                get_main_digits('ab');
            });

            $("#apply_filter_two").click(function(){

                var batch_date  =   $("#batch_date").val();
                var normal_platform_id  =   4;

                if(batch_date != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    verify_load_data(batch_date, '','batch_data',normal_platform_id)

                    get_main_digits(batch_date,normal_platform_id);
                }
                else
                {
                    tostr_display("error","Batch date is required");
                }

            });

            $('#remove_apply_filter_two').click(function(){

                $('#batch_date').val(null).trigger("change");
                $('#batch_platform_id').val(null).trigger('change');

                $('#datatable_not_employee').DataTable().destroy();
                verify_load_data();
                get_main_digits('ab');
            });


            $("#not_verify_apply_filter").click(function(){

                var start_date  =   $("#start_date_not_verify").val();
                var end_date  =   $("#end_date_not_verify").val();

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    not_verify_load_data(start_date, end_date);
                }
                else
                {
                    verify_load_data("error","Both date is required");
                }
            });

            $("#not_verify_remove_apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable_taking_visa').DataTable().destroy();
                    not_verify_load_data(start_date, end_date);
                }
                else
                {
                    tostr_display("error","Both date is required");
                }
            });


        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }) ;
        });
    </script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });


            $('#batch_date').select2({
                placeholder: 'select option of start and end date'
            });


        });


        $(document).on('click','.edit_cls',function(){
            // $(".edit_cls").click(function(){
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });

        $(".remarks_cls").click(function () {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_remarks') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });

        });

        function get_main_digits(start_date , platform=''){

                var ids = $(this).attr('id');

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('get_cod_total_amount_ajax') }}",
                    method: 'POST',
                    data: {start_date: start_date ,platform:platform, _token:token},
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

        function get_digits(start_date,end_date,platform=''){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_total_amount') }}",
                method:'POST',
                data:{start_date:start_date,end_date:end_date,platform:platform,_token:token},
                success:function(response){

                    var  array = JSON.parse(response);
                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function(){

            var platform = 4;

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_plaform_batch_dates') }}",
                method: 'POST',
                data: {platform_id: platform , _token:token},
                success: function(response) {
                    $("#batch_date").html('');
                    $("#batch_date").append(response);

                }
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
