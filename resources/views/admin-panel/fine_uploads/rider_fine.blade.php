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
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_amount">{{ $total_fess }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Motorcycle"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Bikes</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_rider">{{ $total_bikes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Computer-Secure"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Company</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_company">{{ $total_company }}</p>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="row">

                    <div class="col-md-3 form-group mb-3 "  style="float: left; "  >
                        <label for="batch_date">Select Company</label>
                        <select class="form-control" name="normal_platfrom_id" id="normal_platform_id" >
                            <option value="" selected disabled>select an option</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

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
                    <h5 class="modal-title" id="exampleModalLongTitle">Offense</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="remark_p" class="font-weight-bold text-center"></p>
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
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Plate number</th>
                                    <th scope="col">Ticket Number</th>
                                    <th scope="col">Ticket Date</th>
                                    <th scope="col">Ticket Time</th>
                                    <th scope="col">Fine Source</th>
                                    <th scope="col">Ticket Fee</th>
                                    <th scope="col">Offense</th>
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

                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },

                "aaSorting": [],
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
                    url : "{{ route('rider_fines') }}",
                    data:{from_date:from_date, end_date:end_date,verify:"verify table",type:type,platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'rider_name', name: 'rider_name'},
                    {data: 'fine_upload_traffic_code_id', name: 'fine_upload_traffic_code_id'},
                    {data: 'plate_number', name: 'plate_number'},
                    {data: 'ticket_number', name: 'ticket_number'},
                    {data: 'ticket_date', name: 'ticket_date'},
                    {data: 'ticket_time', name: 'ticket_time'},
                    {data: 'fines_source', name: 'fines_source'},
                    {data: 'ticket_fee', name: 'ticket_fee'},
                    {data: 'offense', name: 'offense'},
                ]
            });

        }

        function not_verify_load_data(from_date= '', end_date= ''){

            var table = $('#datatable_taking_visa').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },


                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                    url : "{{ route('cods') }}",
                    data:{from_date:from_date, end_date:end_date,not_verify:"not verify table"},
                },

                "deferRender": true,
                columns: [
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'rider_id', name: 'rider_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'platform', name: 'platform'},

                ]
            });

        }
    </script>

    <script>
        $(document).ready(function () {
            verify_load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var normal_platform_id  =   $("#normal_platform_id option:selected").val();



                if(start_date != '' &&  end_date != '' && normal_platform_id != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    verify_load_data(start_date, end_date,'',normal_platform_id);
                    get_main_digits(start_date,end_date,normal_platform_id);
                }
                else
                {
                    tostr_display("error","All field is required");
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
                var normal_platform_id  =   $("#batch_platform_id option:selected").val();

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

            $('#normal_platform_id').select2({
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

        function get_main_digits(start_date , end_date = '', platform=''){

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_get_rider_filter_counts') }}",
                method: 'POST',
                data: {start_date: start_date , end_date : end_date, platform:platform, _token:token},
                success: function(response) {
                    var  array = JSON.parse(response);


                    $("#total_rider").html(array.total_bikes);
                    $("#total_amount").html(array.total_fess);
                    $("#total_company").html(array.total_company);

                }
            });
        }

    </script>

    <script>
        $("#batch_platform_id").change(function(){

            var platform = $(this).val();

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
        $(document).on('click','.msg_dipslay',function(){

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_fine_offense') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

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
