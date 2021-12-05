@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <style>
        .modal_table .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }
        .modal_table h6{
            font-weight:800;
        }
        .remarks{
            font-weight:800;
        }
        .modal_table .table td{
            padding: 2px;
            font-size: 12px;
        }

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        /* .dataTables_info{
            display:none;
        } */

        .history_table th{
            font-weight:800 !important;
        }
        .font_size_cls{
            font-size: 17px !important;
            cursor: pointer;
        }

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

        /* Zoom image start */
            /* [1] The container */
            .img-hover-zoom {
            height: 300px; /* [1.1] Set it as per your need */
            overflow: scroll; /* [1.2] Hide the overflowing of child elements */
            }

            /* [2] Transition property for smooth transformation of images */
            .img-hover-zoom img {
            transition: transform .5s ease;
            }

            /* [3] Finally, transforming the image when container gets hovered */
            .img-hover-zoom:hover img {
            transform: scale(2);
            }
        /* Zoom image end */

    </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Rider Fuel</a></li>
            <li>All Rider Fuel List</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-3 offset-2 form-group mb-3" style="float: left;" >
                <label for="start_date">Start Date</label>
                <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-sm" id="start_date" value="{{ $start_date ?? date('Y-m-01') }}">

            </div>

            <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                <label for="end_date">End Date</label>
                <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-sm" id="end_date" value="{{ $end_date ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                <label for="end_date" style="visibility: hidden;"></label>
                <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button">
                    <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span>
                </button>
            </div>
        </div>
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-basic-tab" data-toggle="tab" href="#pendingRiderFuels" role="tab" aria-controls="pendingRiderFuels" aria-selected="true">Pending
                            (<span id="reider_fuel_pending_span">{{isset($rider_fuel_pending) ? $rider_fuel_pending->count() : '0'  }} </span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="approved-basic-tab" data-toggle="tab" href="#approvedRiderFuel" role="tab" aria-controls="approvedRiderFuel" aria-selected="false">Approved
                            (<span id="reider_fuel_approved_span">{{isset($rider_fuel_approve) ? $rider_fuel_approve : '0'  }}</span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rejected-basic-tab" data-toggle="tab" href="#rejectedRiderFuel" role="tab" aria-controls="rejectedRiderFuel" aria-selected="false">Rejected
                            (<span id="reider_fuel_rejected_span">{{isset($rider_fuel_reject) ? $rider_fuel_reject : '0'  }} </span>)
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pendingRiderFuels" role="tabpanel" aria-labelledby="pending-basic-tab">
                        <button class="btn btn-outline-success btn-icon m-1 float-right datatable_career_reload_btn" id="pending_refresh_btn" data-status = "0" type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="pending_rider_fuel_tbl">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">image</th>
                                        <th scope="col">Rider Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Platform Code</th>
                                        <th scope="col">Zds code</th>
                                        <th scope="col">Platform Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rider_fuel_pending as $fuel)
                                <?php $image_url =  ltrim($fuel->image, $fuel->image[0]); ?>
                                    <tr id="row-{{ $fuel->id  }}">
                                        <span
                                            style="display: none"
                                            id="bike-{{$fuel->id}}">
                                            {{ trim($fuel->passport->assign_bike_check()?$fuel->passport->assign_bike_check()->bike_plate_number->plate_no:"N/A")}}
                                        </span>
                                        <span
                                            style="display: none"
                                            id="sim-{{$fuel->id}}">
                                            {{$fuel->passport->assign_sim_check()?$fuel->passport->assign_sim_check()->telecome->account_number:"N/A"}}
                                        </span>
                                        <th scope="row">{{ $fuel->id  }}</th>
                                        <td>{{ $fuel->created_at->toDateString()  }}</td>
                                        <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
                                        <td><a  id="image-{{ $fuel->id }}" href="{{Storage::temporaryUrl($image_url, now()->addMinutes(120)) }}" target="_blank">See Image</a></td>
                                        <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
                                        <td>Pending</td>
                                        <?php
                                            $platform_g = $fuel->passport->get_the_rider_id_by_platform($fuel->platform_id);
                                        ?>
                                        <td>{{ isset($platform_g->platform_code) ? $platform_g->platform_code : 'N/A' }}</td>
                                        <td>{{ isset($fuel->passport->rider_zds_code->zds_code) ? $fuel->passport->rider_zds_code->zds_code : 'N/A'  }}</td>
                                        <td>{{ isset($fuel->platform->name) ? $fuel->platform->name : 'N/A' }}</td>
                                        <td>
                                            <a class="text-success mr-2 edit_cls" id="{{ $fuel->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade show" id="approvedRiderFuel" role="tabpanel" aria-labelledby="approved-basic-tab">
                        <button class="btn btn-outline-success btn-icon m-1 float-right datatable_career_reload_btn" id="approved_refresh_btn" data-status = "1" type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="approved_rider_fuel_tbl">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">image</th>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Platform Code</th>
                                    <th scope="col">Zds code</th>
                                    <th scope="col">Platform Name</th>
                                    <th scope="col">Approved By</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="rejectedRiderFuel" role="tabpanel" aria-labelledby="rejected-basic-tab">
                        <button class="btn btn-outline-success btn-icon m-1 float-right datatable_career_reload_btn" id="rejected_refresh_btn" data-status = "2"type="button"><span class="ul-btn__icon"><i class="i-Reload"></i></span></button>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejected_rider_fuel_tbl">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">image</th>
                                        <th scope="col">Rider Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Platform Code</th>
                                        <th scope="col">Zds code</th>
                                        <th scope="col">Platform Name</th>
                                        <th scope="col">Reject By</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('rider_fuel.store') }}">
                    @csrf
                    <input type="hidden" id="row_id_to_be_updated"/>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="font-weight-bold">Rider name</label>
                                    <input id="rider_name" class="form-control" readonly >
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="font-weight-bold">Bike Number</label>
                                    <input id="bike_number_value" class="form-control" readonly >
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="font-weight-bold">SIM Number</label>
                                    <input id="sim_number_value" class="form-control" readonly >
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="font-weight-bold">Amount</label>
                                    <input id="Amount" class="form-control" readonly >
                                </div>
                                <div class="form-group mb-5">
                                    <label for="" class="font-weight-bold">Select Status</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="radio radio-outline-success font-weight-bold">
                                                <input type="radio" class="status-btn" name="status" value="1"><span>Approved</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="radio radio-outline-danger font-weight-bold">
                                                <input type="radio"  class="status-btn" name="status" value="2"><span>Rejected</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-5" style="display: none" id="remarks_div">
                                    <label for="" class="font-weight-bold">Remarks</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="radio radio-outline-warning font-weight-bold">
                                                <input type="radio" name="remarks" value="1"><span>Wrong Vehicle</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="radio radio-outline-danger font-weight-bold">
                                                <input type="radio" name="remarks" value="2"><span>Wrong Amount</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="radio radio-outline-info font-weight-bold">
                                                <input type="radio" name="remarks" value="3"><span>Wrong Date</span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-primary ml-2 float-left mt-3" id="fuel_button_submit" type="submit">Save changes</button>
                                </div>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="" class="font-weight-bold">Fuel Receipt</label>
                                <div class="card bg-dark text-white o-hidden mb-4 img-hover-zoom">
                                <script>
                                    var rotate_angle = 0;
                                </script>
                                    <img  onclick='rotate_angle = (rotate_angle + 180) % 360; $(this).rotate(rotate_angle);' id="image_fuel" style="height: 277px;" class="card-img" src="" alt="Card image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    status update modal end--}}

    <div class="overlay"></div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script>
        // -----------Date Input----------
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

        $('#clear').click(function() {
            $("input[name='user_passport_id']").val('')
            $("input[name='search_value']").val('')
        });
        // -----------Date Input End----------

        $("#apply_filter").click(function(){
            var start_date  =   $("#start_date").val();
            var end_date  =   $("#end_date").val();
            var table = $('#approved_rider_fuel_tbl').DataTable();
                table.destroy();
                if(start_date == '' &&  end_date == '') {
                    return false;
                }
            $.ajax({
                url: "{{ route('get_rider_fuel_list') }}",
                method: 'GET',
                data: {status:1, start_date, end_date},
                success: function(response) {
                    $('#reider_fuel_approved_span').text(response.total);
                    $('#approved_rider_fuel_tbl tbody').empty();

                    $('#approved_rider_fuel_tbl tbody').html(response.html)
                    var table = $('#approved_rider_fuel_tbl').DataTable(
                        {
                            "aaSorting": [[0, 'desc']],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0],"visible": false},
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
                            "scrollY": false,
                            "scrollX": true,
                        }
                    );
                    $(".display").css("width","100%");
                    $('#approved_rider_fuel_tbl tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    $("body").removeClass("loading");
                },
                error: function(xhr, textStatus, error){
                    console.log("fail");
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                }
            });
        });

        $(document).ready(function () {
            'use strict';
            $('#pending_rider_fuel_tbl, #approved_rider_fuel_tbl, #rejected_rider_fuel_tbl').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 20,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Rider Fuel Requests',
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
            });

            $('#category').select2({
                placeholder: 'Select an option'
            });
        });

        $(".status-btn").change(function(){
            var status_type=this.value;
            if (status_type=='2') {
                $('#remarks_div').show();
            }else{
                $('#remarks_div').hide();
                $('input[name=remarks]').prop('checked', false);
            }
        });
        $('tbody').on('click', '.edit_cls', function(e) {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $('#row_id_to_be_updated').val('row-'+ids);
            var rider_name = $("#name-"+ids).text();
            $("#rider_name").val(rider_name);

            var amount = $("#amount-"+ids).text();
            $("#Amount").val(amount);

            var bike = $("#bike-"+ids).text();
            $("#bike_number_value").val(bike);

            var sim = $("#sim-"+ids).text();
            $("#sim_number_value").val(sim);

            var image_url = $("#image-"+ids).attr('href');
            $("#image_fuel").attr('src',image_url);
            $("#edit_modal").modal('show');
            $('input[name=status]').prop('checked', false);
            $('input[name=remarks]').prop('checked', false);
            $('#remarks_div').hide()
        });

    </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab == "pending-basic-tab"){
                    $("#pending_refresh_btn").click();
                }else if(split_ab == "approved-basic-tab"){
                    $("#approved_refresh_btn").click();
                }else if(split_ab == "rejected-basic-tab"){
                    $("#rejected_refresh_btn").click();
                }
            }) ;
        });
    </script>

    <script>
        $("#PartsAddForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var pending_table = $('#pending_rider_fuel_tbl').DataTable();
            var form = $(this);
            var url = form.attr('action');
            var primary_id = $("#primary_id").val();
            var row_id = $('#row_id_to_be_updated').val();
            pending_table.row('#'+row_id).remove().draw( false );
            $.ajax({
                type: "POST",
                cache: false,
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(response)
                {
                    if(response['alert-type'] == "success" ){
                        tostr_display("success",response['message']);
                    }else{
                        tostr_display("error", response['message']);
                    }
                    $('#edit_modal').modal('hide');
                    $('#reider_fuel_pending_span').text(parseInt($('#reider_fuel_pending_span').text())-1)
                }
            });
        });
    </script>
    <script>
        $('.datatable_career_reload_btn').on('click', function(){
            var status = $(this).attr('data-status');
            var start_date  =   $("#start_date").val();
            var end_date  =   $("#end_date").val();
                $.ajax({
                    url: "{{ route('get_rider_fuel_list') }}",
                    method: 'GET',
                    data: {status, start_date, end_date},
                    success: function(response) {
                        if(status == '0'){
                            $('#pending_rider_fuel_tbl tbody').empty();

                            var table = $('#pending_rider_fuel_tbl').DataTable();
                            table.destroy();
                            $('#pending_rider_fuel_tbl tbody').html(response.html);
                            var table = $('#pending_rider_fuel_tbl').DataTable(
                                {
                                    "aaSorting": [[0, 'desc']],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                    ],
                                    "columnDefs": [
                                        {"targets": [0],"visible": false},
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
                                    "scrollY": false,
                                    "scrollX": true,
                                }
                            );
                            $(".display").css("width","100%");
                            $('#pending_rider_fuel_tbl tbody').css("width","100%");
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();
                        }else if(status == '1'){
                            $('#reider_fuel_approved_span').text(response.total);
                            $('#approved_rider_fuel_tbl tbody').empty();
                            var table = $('#approved_rider_fuel_tbl').DataTable();
                            table.destroy();
                            $('#approved_rider_fuel_tbl tbody').html(response.html)
                            var table = $('#approved_rider_fuel_tbl').DataTable(
                                {
                                    "aaSorting": [[0, 'desc']],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                    ],
                                    "columnDefs": [
                                        {"targets": [0],"visible": false},
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
                                    "scrollY": false,
                                    "scrollX": true,
                                }
                            );
                            $(".display").css("width","100%");
                            $('#approved_rider_fuel_tbl tbody').css("width","100%");
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();
                        }else if(status == '2'){
                            $('#reider_fuel_rejected_span').text(response.total);
                            $('#rejected_rider_fuel_tbl tbody').empty();
                            var table = $('#rejected_rider_fuel_tbl').DataTable();
                                  table.destroy();
                            $('#rejected_rider_fuel_tbl tbody').html(response.html);
                            var table = $('#rejected_rider_fuel_tbl').DataTable(
                                {
                                    "aaSorting": [[0, 'desc']],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                    ],
                                    "columnDefs": [
                                        {"targets": [0],"visible": false},
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
                                    "scrollY": false,
                                    "scrollX": true,
                                }
                            );
                            $(".display").css("width","100%");
                            $('#rejected_rider_fuel_tbl tbody').css("width","100%");
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();
                        }
                    }
                });
            })
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
                    toastr.info(message, "Succuss!", { timeOut:10000 , progressBar : true });
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true });
                    break;
                case 'success':
                    toastr.success(message, "Succuss!", { timeOut:10000 , progressBar : true });
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true });
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
