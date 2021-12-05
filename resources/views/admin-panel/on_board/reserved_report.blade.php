@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        /* .hide_cls{
            display: none;
        } */
        .modals-lg {
            max-width: 30% !important;
        }
        .chat-sidebar-container {
            height: auto;
            min-height: auto;
        .send_btn_cls{
            color: #004e92 !important;
            font-size: 12px;
        }
    </style>




@endsection

<style>

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

    .active_cls{
        border: 3px solid #ffa500f2;
    }

    .active_cls_visa{
        border: 3px solid #bb2a2a;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">On Boarding</a></li>
            <li>Reservation Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="checkin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Checkin</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('assigned_reserved_bikes') }}" method="POST">
                    @csrf

                    <input type="hidden" name="primary_id_selected" id="primary_id_selected" >

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="repair_category">Check IN</label>
                                <input class="form-control form-control" id="checkin" name="checkin" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" type="datetime-local" required  />
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
    </div><!-- end of note modal -->



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <button class="btn btn-success btn-icon m-1"  id="assign_now" type="button"><span class="ul-btn__icon"><i class="i-Note"></i></span><span class="ul-btn__text">Assigned Now</span></button>

                <form action="{{ route('assigned_reserved_bikes') }}" id="save_form" method="POST">
                    @csrf
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable_not_employee">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Reserved date</th>
                                    <th scope="col">Reserve Bike Plate Number</th>
                                    <th scope="col">Reserve Sim Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($reserves as $res)
                                    <tr>
                                        <th scope="row" >1</th>
                                        <td>{{ $res->passport->personal_info->full_name }}</td>
                                        <td>{{ $res->passport->passport_no }}</td>
                                        <td>{{ $res->passport->personal_info->personal_mob }}</td>
                                        <td>{{ $res->passport->nation->name }}</td>
                                        <td>{{ $res->created_at->todatestring() }}</td>
                                        <td>{{ $res->reserve_bike->plate_no }} @if($res->assign_status=="1") <h5 class="badge badge-success">Assigned</h5>  @endif</td>
                                        <td>{{ $res->reserve_sim->account_number }}  @if($res->sim_assign_status=="1") <h5 class="badge badge-success">Assigned</h5>  @endif</td>
                                        <td>
                                            @if($res->assign_status=="1" && $res->sim_assign_status=="1")
                                                <h5 class="badge badge-success">bike and sim assigned</h5>
                                             @else
                                            <a class="text-primary mr-2 edit_cls"  id="{{ $res->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
                                             @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>


                </form>








            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modals-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modals-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">


                        <div class="col-md-12">
                            <h6><b>Remarks</b></h6>
                            <div class="card chat-sidebar-container" data-sidebar-container="chat" style="background-color: #9de0f6">
                                <div class="chat-content-wrap" data-sidebar-content="chat">
                                    <div class="chat-content perfect-scrollbar remark" data-suppress-scroll-x="true">


                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}

    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $('.edit_cls').click(function() {

            var ids = $(this).attr('id');
            $("#primary_id_selected").val(ids);
            $("#checkin_modal").modal('show');
        });
    </script>

    <script>
        $('tbody').on('click', '.view_cls', function() {

            var ids  = $(this).attr('id');
            $("#detail_modal").modal('show');

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_career_remark') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    console.log(response);
                    if(response.length == 0){
                        data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-10 flex-grow-1"></p>
                </div>
                    <p class="m-0">No Remarks</p>
            </div><br>`;
                        $(".remark").append(data);
                    }

                    for (i = 0; i < response.length; i++) {
                        if(response[i].remarks != "sent to selected from frontdesk"){
                            data = `<div class="message flex-grow-1">
                <div class="d-flex">
                    <p class="mb-0 text-title text-12 flex-grow-1">${response[i].name}</p>
                    <span class="career_remark">${response[i].note_added_date}</span>
                </div>
                    <p class="m-0">${response[i].remarks}</p>
            </div><br>`;
                            $(".remark").append(data);
                        }}
                }
            });$(".remark").empty();


        });

    </script>



    <script>
        tail.DateTime("#submit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#submit_date_4pl",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
            dateStart:new Date(),
        });
    </script>
    <script>
        $("#checkAll").click(function () {
            $('.checkboxs').not(this).prop('checked', this.checked);
        });

        $("#four_pl_checkAll").click(function () {
            $('.fourpl_checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script>

        $(".send_to_traininig").click(function () {
            var id = $(this).attr('id');

            $.ajax({
                url: "{{ route('render_vehicle_free_for_reservation') }}",
                method: 'GET',
                success: function(response) {
                    $("#append_reservation").empty();
                    $("#append_reservation").append(response.html);

                    $('#reserve_sim_id').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });

                    $('#reserve_bike_id').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                    });
                }
            });




            $("#reservation_primary_id").val(id);
            $("#training_modal").modal('show');
        });
    </script>





    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#rejoin_datatable').DataTable( {

                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [6],"orderable": false},

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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');

                if(split_ab[1]=="homeBasic"){
                    var table = $('#datatable_not_employee').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    $("#datatable_not_employee").css("width","100%");

                }else if(split_ab[1]=="profileBasic"){

                    var table = $('#rejoin_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    $("#rejoin_datatable").css("width","100%");
                }


            }) ;
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

        //deleta and adding step amount

        var count_discount_ab = 50001
        $("#btn_add_discount_row").click(function () {
            count_discount_ab = parseInt(count_discount_ab)+1
            var id_now =  count_discount_ab;

            var html =  add_new_discount_row(id_now);
            $(".append_discount_row").append(html);

            $("#discount_amount-"+id_now).prop('required',true);
            $("#discount_name-"+id_now).prop('required',true);

        });

        $('.append_discount_row').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".discunt_div-"+now[1]).remove();
            var remain_val = calculate_others();
            $("#final_amount").val(remain_val);

            $.ajax({
                url: "{{ route('ajax_onboard_checkin') }}",
                method: 'GET',
                data: {id: ids},
                success: function(response) {

                }
            });


        });

        var count_doc_ab = 40001

        $("#btn_add_doc_row").click(function () {
            count_doc_ab = parseInt(count_doc_ab)+1
            var id_now =  count_doc_ab;

            var html =  add_new_document_row(id_now);
            $(".doc_row_append").append(html);

            $("#doc_name-"+id_now).prop('required',true);
            $("#doc_image-"+id_now).prop('required',true);

        });

        $('.doc_row_append').on('click', '.remove_discount_row', function() {

            var ids = $(this).attr('id');
            var now = ids.split("-");

            $(".doc_div-"+now[1]).remove();

            // var value_current = $("#image_array").val();
            // var now_value = value_current+","+id;
            // $("#image_array").val(now_value);


        });




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




@endsection
