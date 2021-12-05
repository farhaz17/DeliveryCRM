@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

    /* loading image css starts */
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    /* loading image css ends */
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA</a></li>
            <li class="breadcrumb-item active text-danger" aria-current="page">After Accepted Accident Requests</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>

    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal"   tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="checkout_form" action="{{ route('save_after_accepte_request') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Accident Request Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="append_div">
                        </div>

                    </div>
                    <input type="hidden" name="primary_id" id="primary_id">
                    <input type="hidden" name="request_type" id="request_type">
                    <input type="hidden" name="rejected_btn_counts" id="rejected_btn_counts" value="0">
                    <div class="modal-footer" style="display: flow-root;">
                        <input type="submit" id="form_submit_button" style="display: none;">
                        <button class="btn btn-secondary " type="button" data-dismiss="modal">Close</button>
                        {{-- <button class="btn btn-danger float-right ml-2" id="reject_btn" type="button">Reject</button> --}}
                        <button class="btn btn-success float-right ml-2"  id="accept_btn" type="button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport model ends here-----------------}}



    {{--------------------detail  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal_for_bike"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="checkout_form_for_bike" action="{{ route('save_after_accepte_request_for_bike_only') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Accident Request Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="append_div_bike">
                        </div>

                    </div>
                    <input type="hidden" name="primary_id" id="primary_id_for_bike">
                    <input type="hidden" name="request_type" id="request_type">
                    <input type="hidden" name="rejected_btn_counts" id="rejected_btn_counts" value="0">
                    <div class="modal-footer" style="display: flow-root;">
                        <input type="submit" id="form_submit_button" style="display: none;">
                        <button class="btn btn-secondary " type="button" data-dismiss="modal">Close</button>
                        {{-- <button class="btn btn-danger float-right ml-2" id="reject_btn" type="button">Reject</button> --}}
                        <button class="btn btn-success float-right ml-2"  id="accept_btn_for_bike" type="button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------deail model ends here-----------------}}




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Complete Checkout Accepted Requests ( {{ isset($complete_accepted_request) ? $complete_accepted_request->count() : '' }} )</a></li>
                    <li class="nav-item"><a class="nav-link text-10 " id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">Only Bike Replacement Accepted Requests ( {{ isset($only_bike_accpet_request) ? $only_bike_accpet_request->count() : '' }} )</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable_not_employee">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Checkout date</th>
                                    <th scope="col">Checkout type</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Current Sim no</th>
                                    <th scope="col">Current Bike no</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Requested Date</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Accepted By</th>
                                    <th scope="col">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($complete_accepted_request  as $ab)
                                    <tr>

                                        <td>{{ $ab->id }}</td>
                                        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
                                        <td>{{ $ab->rider_name->passport_no }}</td>
                                        <td>{{ $ab->checkout_date }}</td>
                                        <td>{{ $array_type[$ab->request_type] }}</td>
                                        <td>{{ isset($ab->rider_name->rider_zds_code) ? $ab->rider_name->rider_zds_code->zds_code : 'N/A' }}</td>
                                        <td>{{ $ab->rider_name->pp_uid }}</td>
                                        <?php

                                            $result_sim = "";
                                            if (!$ab->rider_name->sim_assign->isEmpty()) {
                                                $abs = $ab->rider_name->sim_assign->where('checkout','is',null)->first();
                                                $result_sim = isset($abs->telecome->account_number) ? $abs->telecome->account_number : 'N/A';
                                            } else{
                                                $result_sim = 'N/A';
                                            }
                                        ?>
                                        <td>{{ $result_sim }}</td>
                                        <?php
                                           $result_bike = "";
                                            if (!$ab->rider_name->bike_assign->isEmpty()) {
                                                $abs =  $ab->rider_name->bike_assign->where('checkout','is',null)->first();
                                                $result_bike  =  isset($abs->bike_plate_number->plate_no) ? $abs->bike_plate_number->plate_no : 'N/A';
                                            } else{
                                                $result_bike = 'N/A';
                                            }

                                        ?>
                                        <td>{{ $result_bike }}</td>
                                        <td>{{ $ab->remarks }}</td>
                                        <td>{{ date('d-m-Y', strtotime($ab->created_at)) }}</td>
                                        <td>{{ isset($ab->requested_by->name) ? $ab->requested_by->name : 'N/A' }}</td>
                                        <td>{{ isset($ab->accepted_by->name) ? $ab->accepted_by->name : 'N/A' }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_cls" id="{{ $ab->id }}" data-status="0" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>

                    </div>
{{--first tab work finished--}}
                    <div class="tab-pane fade show " id="new_taken" role="tabpanel" aria-labelledby="home-basic-new_taken">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable_accepted">
                                <thead >
                                    <tr>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Rider Name</th>
                                        <th scope="col">Passport No</th>
                                        <th scope="col">Checkout date</th>
                                        <th scope="col">Checkout type</th>
                                        <th scope="col">ZDS Code</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">Current Sim no</th>
                                        <th scope="col">Current Bike no</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Requested Date</th>
                                        <th scope="col">Requested By</th>
                                        <th scope="col">Accepted By</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($only_bike_accpet_request  as $ab)
                                    <tr>


                                        <td>{{ $ab->rider_name->personal_info->full_name }}</td>
                                        <td>{{ $ab->rider_name->passport_no }}</td>
                                        <td>{{ $ab->checkout_date }}</td>
                                        <td>{{ $array_type[$ab->request_type] }}</td>
                                        <td>{{ isset($ab->rider_name->rider_zds_code) ? $ab->rider_name->rider_zds_code->zds_code : 'N/A' }}</td>
                                        <td>{{ $ab->rider_name->pp_uid }}</td>
                                        <?php

                                            $result_sim = "";
                                            if (!$ab->rider_name->sim_assign->isEmpty()) {
                                                $abs = $ab->rider_name->sim_assign->where('checkout','is',null)->first();
                                                $result_sim = isset($abs->telecome->account_number) ? $abs->telecome->account_number : 'N/A';
                                            } else{
                                                $result_sim = 'N/A';
                                            }
                                        ?>
                                        <td>{{ $result_sim }}</td>
                                        <?php
                                           $result_bike = "";
                                            if (!$ab->rider_name->bike_assign->isEmpty()) {
                                                $abs =  $ab->rider_name->bike_assign->where('checkout','is',null)->first();
                                                $result_bike  =  isset($abs->bike_plate_number->plate_no) ? $abs->bike_plate_number->plate_no : 'N/A';
                                            } else{
                                                $result_bike = 'N/A';
                                            }

                                        ?>
                                        <td>{{ $result_bike }}</td>
                                        <td>{{ $ab->remarks }}</td>
                                        <td>{{ date('d-m-Y', strtotime($ab->created_at)) }}</td>
                                        <td>{{ isset($ab->requested_by->name) ? $ab->requested_by->name : 'N/A' }}</td>
                                        <td>{{ isset($ab->accepted_by->name) ? $ab->accepted_by->name : 'N/A' }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_cls_only_bike" id="{{ $ab->id }}" data-status="0" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                        </div>


                    </div>
{{--                    second tab work finished--}}


                </div>


            </div>
            <div class="overlay"></div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function () {

            $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

                var currentTab = $(e.target).attr('id'); // get current tab

                if(currentTab=="home-basic-tab"){
                    // make_table("datatable_not_employee","0");
                    var table = $('#datatable_not_employee').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }else if(currentTab=="home-basic-new_taken"){
                    // make_table("datatable_accepted","1");
                    var table = $('#datatable_accepted').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else{
                    // make_table("datatable_rejected","2");
                    var table = $('#datatable_rejected').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        });
    </script>

    <script>

        $('body').on('change','#repalce_bike_type',function () {

                if( $(this).is(":checked") ){ // check if the radio is checked
                    var val = $(this).val(); // retrieve the value

                   if(val=="1"){
                       $("#assign_bike_id").hide();
                       $("#new_bike_id").prop('required',false);
                   }else{
                    $("#assign_bike_id").show();
                    $("#new_bike_id").prop('required',true);
                   }
                }
            });
        </script>




    <script>
        function make_table(table_name,status,plat_id) {


            $.ajax({
                url: "{{ route('get_teamleader_request') }}",
                method: 'GET',
                data: {request_type:status},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
                    var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            "columnDefs": [
                                {"targets": [0],"visible": false},

                            ],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Pending Rider Fuel',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "sScrollX": "100%",
                            "scrollX": true
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }
    </script>

    <script>
        $('body').on('click','.view_cls',function () {

            $("#detail_modal").modal('show');
            var ids = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#rejected_btn_counts").val("0");
            var now_status = $(this).attr('data-status');

            if(now_status=='0'){
                $("#reject_btn").show();
                $("#accept_btn").show();
            }else{
                $("#reject_btn").hide();
                $("#accept_btn").hide();
            }

            $.ajax({
                url: "{{ route('after_accept_get_accident_request_ajax') }}",
                method: 'get',
                data: {id_primary: ids},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);
                }
            });


        });

        $('body').on('click','.view_cls_only_bike',function () {

                    $("#detail_modal_for_bike").modal('show');
                    var ids = $(this).attr('id');
                    $("#primary_id_for_bike").val(ids);
                    $("#rejected_btn_counts").val("0");
                    var now_status = $(this).attr('data-status');

                    if(now_status=='0'){
                        $("#reject_btn").show();
                        $("#accept_btn").show();
                    }else{
                        $("#reject_btn").hide();
                        $("#accept_btn").hide();
                    }

                    $.ajax({
                        url: "{{ route('after_accept_get_accident_request_ajax') }}",
                        method: 'get',
                        data: {id_primary: ids},
                        success: function(response) {
                            $(".append_div_bike").empty();
                            $(".append_div_bike").append(response.html);
                        }
                    });
        });


        $("#reject_btn").click(function(){
            $("#request_type").val("2");
            $(".reject_resaon_div").show(300);

            var reject_btn_count = $("#rejected_btn_counts").val();
            reject_btn_count = parseInt(reject_btn_count)+1;
            $("#rejected_btn_counts").val(reject_btn_count);
            var now_total = $("#rejected_btn_counts").val();
            if(parseInt(now_total)>1){
                $("#checkout_form").submit();
            }

        });

        $("#accept_btn").click(function(){
            $("#request_type").val("1");
            $("#checkout_form").submit();
        });

        $("#accept_btn_for_bike").click(function(){
            $("#request_type").val("1");
            $("#checkout_form_for_bike").submit();
        });

        $("#checkout_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#checkout_form").attr('action');



            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    console.log(response)
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Status Has been changed Successfully");
                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });

        $("#checkout_form_for_bike").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#checkout_form_for_bike").attr('action');



            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Status Has been changed Successfully");
                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });



    </script>

    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee').DataTable( {

                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},

                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
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


    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>






@endsection
