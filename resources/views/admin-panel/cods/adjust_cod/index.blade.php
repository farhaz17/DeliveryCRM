@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Cash On Delivery Adjustment</a></li>
            <li>Cash on Delivery Adjustment Detail</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


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
                <form method="post" id="update_status_form" action="{{ route('cods.store') }}">
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
                                    <option value="2">Approved</option>
                                    <option value="3">Rejected</option>
                                </select>
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
    </div>

    <div class="col-md-12 mb-3">
        <div class=" text-left">
            <div class="">



                <div class="card text-left">
                    <div class="card-body">
                        {{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                        {{-- <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true"><i class="nav-icon i-Pen-4 mr-1"></i>Pending</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#taking_visa" role="tab" aria-controls="taking_visa" aria-selected="false" id="approved_count" ><i class="nav-icon i-Security-Check mr-1"></i>Approved</a></li>
                            <li class="nav-item"><a class="nav-link" id="rejected_tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false"><i class="nav-icon i-Close mr-1"></i>Rejected</a></li>
                        </ul> --}}
                        <div class="tab-content" id="myIconTabContent">


                            <div class="tab-pane fade show active" id="taking_visa" role="tabpanel" aria-labelledby="home-icon-tab">

                                {{--accordian start--}}
                                {{-- <div class="accordion" id="accordionRightIcon2" style="margin-bottom: 10px;">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-2" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                        </div>
                                        <div class="collapse" id="accordion-item-icons-2" data-parent="#accordionRightIcon2"> --}}
                                            <div class="row">

                                                <div class="col-md-2 form-group mb-3 " style="float: left;"  >
                                                    {{-- <label for="start_date_two">Select Platform</label>
                                                    <select class="form-control" name="platform_two" id="platform_two">
                                                        <option value="" selected disabled>select an option</option>
                                                        @foreach($platforms as $plt)
                                                            <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                                                        @endforeach
                                                    </select> --}}
                                                </div>

                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date_not_verify">

                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date_not_verify">
                                                </div>
                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                                <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1" id="not_verify_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1" id="not_verify_remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                                <div class="col-md-2 form-group" style="margin-top: 25px">
                                                    <div class="totals">

                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div>
                                    </div>
                                </div> --}}

                                {{-- accordian end here--}}

                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered text-11" id="datatable_taking_visa">
                                        <thead>
                                        <tr>
                                            {{--                                            <th scope="col">#</th>--}}

                                            <th scope="col">Rider Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Images</th>
                                            <th scope="col">Approved By</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>

                                    </table>
                                </div>


                            </div>


                            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected_tab">

                                {{--accordian start--}}
                                {{-- <div class="accordion" id="accordionRightIcon3" style="margin-bottom: 10px;">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-3" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                        </div>
                                        <div class="collapse" id="accordion-item-icons-3" data-parent="#accordionRightIcon3"> --}}
                                            <div class="row">

                                                <div class="col-md-2 form-group mb-3 " style="float: left;"  >
                                                    {{-- <label for="start_date">Select Platform</label>
                                                    <select class="form-control" name="platform_three" id="platform_three">
                                                        <option value="" selected disabled>select an option</option>
                                                        @foreach($platforms as $plt)
                                                            <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                                                        @endforeach
                                                    </select> --}}
                                                </div>

                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date_rejected">
                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date_rejected">
                                                </div>
                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                                <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1" id="reject_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1" id="reject_remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                                <div class="col-md-2 form-group" style="margin-top: 25px">
                                                    <div class="total">

                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div>
                                    </div>
                                </div> --}}

                                {{-- accordian end here--}}

                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered text-11" id="datatable_rejected">
                                        <thead>
                                        <tr>
                                           <th scope="col">Rider Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Images</th>
                                            <th scope="col">Rejected By</th>

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
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm " id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" action="{{ route('cod_adjust_amt_delete') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Warning</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="ids" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <h5>Are you sure to delete</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit">Delete</button>
                    </div>
                </form>
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

    <script>
        tail.DateTime("#start_date_not_verify",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date_not_verify",{
                dateStart: $('#start_date_not_verify').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>


    <script>
        tail.DateTime("#start_date_rejected",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date_rejected",{
                dateStart: $('#start_date_rejected').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>




    <script type="text/javascript">
        function pending_load_data(from_date= '', end_date= '',platform=''){

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
                                title: 'Cod Adjust',
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
                    url : "{{ route('cod_adjust') }}",
                    data:{from_date:from_date, end_date:end_date,pending:"pending table",platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'created_date', name: 'created at'},
                    {data: 'amount', name: 'amount'},
                    {data: 'message', name: 'message'},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'order_date', name: 'date'},
                    {data: 'status', name: 'status'},
                    {data: 'images', name: 'images'},
                    {data: 'action', name: 'action'},

                ]
            });

        }

        function approved_load_data(from_date= '', end_date= '',platform=''){

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
                dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Cod Adjust',
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
                "lengthMenu": [[25, 100, -1], [25, 100, "All"]],

                ajax:{
                    url : "{{ route('cod_adjust') }}",
                    data:{from_date:from_date, end_date:end_date,approved:"approved table",platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'created_date', name: 'created at'},
                    {data: 'amount', name: 'amount'},
                    {data: 'message', name: 'message'},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'order_date', name: 'date'},
                    {data: 'images', name: 'images'},
                    {data: 'approved_by', name: 'approved_by'},
                    {data: 'action', name: 'action'},

                ]
            });
        }

        function rejected_load_data(from_date= '', end_date= '',platform=''){

            var table = $('#datatable_rejected').DataTable({
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
                                title: 'Cod Adjust',
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
                    url : "{{ route('cod_adjust') }}",
                    data:{from_date:from_date, end_date:end_date,rejected:"Rejected table",platform:platform},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'created_date', name: 'created at'},
                    {data: 'amount', name: 'amount'},
                    {data: 'message', name: 'message'},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'order_date', name: 'date'},
                    {data: 'status', name: 'status'},
                    {data: 'images', name: 'images'},
                    {data: 'rejected_by', name: 'rejected_by'},

                ]
            });
        }

    </script>

    <script>
        $(document).ready(function () {
            approved_load_data();
            // not_verify_load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var platform  =   4;

                if(start_date != '' &&  end_date != '' &&  platform != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    pending_load_data(start_date, end_date, platform);

                    var token = $("input[name='_token']").val();
                        $.ajax({
                        url: "{{ route('ajax_total_cod_adjust_pend') }}",
                        method: 'POST',
                        data: {start_date: start_date,end_date: end_date,platform:platform ,_token:token},
                        success: function(response) {
                            // console.log(response);
                        $sum = 0;
                            for (i = 0; i < response.length; i++) {
                            if(response[i].amount){
                                $sum += response[i].amount
                        }}
                        data = `<h5><b> Total Amount: ${$sum} <span class="badge badge-success">AED</span></b></h5>`;
                        $(".totalk").append(data);
                        // console.log($sum);
                        }
                    });
                    $(".totalk").empty();
                }
                else
                {
                    tostr_display("error","All field is required");
                }

            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#platform').val(null).trigger('change');
                $('#datatable_not_employee').DataTable().destroy();
                $(".totalk").empty();
                var start_date  =   $("#start_date_not_verify").val();
                var end_date  =   $("#end_date_not_verify").val();
                var platform  =   $("#platform option:selected").val();
                pending_load_data(start_date, end_date,platform);
                // $('#datatable_not_employee tbody').empty();
                // pending_load_data()
            });


            $("#not_verify_apply_filter").click(function(){

                var start_date  =   $("#start_date_not_verify").val();
                var end_date  =   $("#end_date_not_verify").val();
                var platform  =   4;

                if(start_date != '' &&  end_date != '' && platform!='')
                {
                    $('#datatable_taking_visa').DataTable().destroy();
                    approved_load_data(start_date, end_date, platform);

                    var token = $("input[name='_token']").val();
                        $.ajax({
                        url: "{{ route('ajax_total_cod_adjust_approve') }}",
                        method: 'POST',
                        data: {start_date: start_date,end_date: end_date,platform:platform ,_token:token},
                        success: function(response) {
                            // console.log(response);
                        $sum = 0;
                            for (i = 0; i < response.length; i++) {
                            if(response[i].amount){
                                $sum += response[i].amount
                        }}
                        data = `<h5><b> Total Amount: ${$sum} <span class="badge badge-success">AED</span></b></h5>`;
                        $(".totals").append(data);
                        // console.log($sum);
                        }
                    });
                    $(".totals").empty();
                }
                else
                {
                    tostr_display("error","All field is required");
                }
            });

            $("#not_verify_remove_apply_filter").click(function(){
                $('#start_date_not_verify').val('');
                $('#end_date_not_verify').val('');
                $('#platform').val(null).trigger('change');
                $('#datatable_taking_visa').DataTable().destroy();
                // $('#datatable_taking_visa tbody').empty();
                $(".totals").empty();
                var start_date  =   $("#start_date_not_verify").val();
                var end_date  =   $("#end_date_not_verify").val();
                var platform  =   $("#platform option:selected").val();
                approved_load_data(start_date, end_date,platform);

            });






            $("#reject_apply_filter").click(function(){

                var start_date  =   $("#start_date_rejected").val();
                var end_date  =   $("#end_date_rejected").val();
                var platform  =   4;

                if(start_date != '' &&  end_date != '' && platform!='')
                {
                    $('#datatable_rejected').DataTable().destroy();
                    rejected_load_data(start_date, end_date, platform);

                    var token = $("input[name='_token']").val();
                        $.ajax({
                        url: "{{ route('ajax_total_cod_adjust_reject') }}",
                        method: 'POST',
                        data: {start_date: start_date,end_date: end_date,platform:platform ,_token:token},
                        success: function(response) {
                            // console.log(response);
                        $sum = 0;
                            for (i = 0; i < response.length; i++) {
                            if(response[i].amount){
                                $sum += response[i].amount
                        }}
                        data = `<h5><b> Total Amount: ${$sum} <span class="badge badge-success">AED</span></b></h5>`;
                        $(".total").append(data);
                        // console.log($sum);
                        }
                    });
                    $(".total").empty();
                }
                else
                {
                    tostr_display("error","All field is required");
                }
            });



            $("#reject_remove_apply_filter").click(function(){
                $('#start_date_rejected').val('');
                $('#end_date_rejected').val('');
                $('#platform_three').val(null).trigger('change');

                $('#datatable_rejected').DataTable().destroy();
                // $('#datatable_rejected tbody').empty();
                $(".total").empty();
                var start_date  =   $("#start_date_not_verify").val();
                var end_date  =   $("#end_date_not_verify").val();
                var platform  =   $("#platform option:selected").val();
                rejected_load_data(start_date, end_date, platform);
                // rejected_load_data()
            });






        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);
                if('datatable_'+split_ab[1]=="datatable_taking_visa"){
                    $('#datatable_taking_visa').DataTable().destroy();
                    approved_load_data();
                }else if('datatable_'+split_ab[1]=="datatable_rejected"){
                    $('#datatable_rejected').DataTable().destroy();
                    rejected_load_data();
                }else{
                    $('#datatable_not_employee').DataTable().destroy();
                    pending_load_data();
                }


            }) ;
        });
    </script>
    <script>
        $(document).on('click','.msg_dipslay',function(){

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_cod_message') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token,type:"adjustments" },
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });

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

            $('#category').select2({
                placeholder: 'Select an option'
            });

        });


        $(document).on('click','.edit_cls',function(){
            // $(".edit_cls").click(function(){
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
        });
    </script>

    {{--    ajax form start--}}
    <script>
        // this is the id of the form
        $("#update_status_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var ids = $("#primary_id").val();

            var form = $(this);
            var url = form.attr('action');
            var url_now =  "{{ url('cod_adjust')  }}";
            var final_url = url_now+"/"+ids;

            $.ajax({
                type: "PUT",
                cache: false,
                url: final_url,
                data: form.serialize(), // serializes the form's elements.
                success: function(response)
                {
                    if(response=="success"){
                        tostr_display("success","Status Has been Updated");
                        $("#edit_modal").modal('hide');

                        // alert("agreement is submitted");
                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });
    </script>
    {{--    ajax form end--}}

    <script>
        $(document).on('click','.delete_cls',function(){

            var  ids  = $(this).attr('id');
            $("#ids").val(ids);
            $("#delete_modal").modal('show');
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
