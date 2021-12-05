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
        }
        .send_btn_cls{
            color: #004e92 !important;
            font-size: 12px;
        }
        .hide_cls{
        display: none;
        }


        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 99999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        .view_cls i{
            font-size: 15px !important;
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
            <li><a href="">Passport</a></li>
            <li>Rider don't have visa status</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-md"  id="checkin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Enter Visa Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('passport_update_only_visa_status') }}" id="visa_status_form" method="POST">
                    @csrf

                    <input type="hidden" name="primary_id_selected" id="primary_id_selected" >

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 visa_status_div">
                                <label for="repair_category" class="font-weight-bold visa_detail_cls">Visa Status</label>
                                <br>
                                <div class="form-check-inline visa_detail_cls">
                                    <label class="radio radio-outline-success">
                                        <input type="radio"    value="1" id="visa_status_visit" name="visa_status" required  ><span>Visit Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline visa_detail_cls">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio"  value="2" id="visa_status_cancel" name="visa_status"><span>Cancel Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline visa_detail_cls visa_status_own_div_cls">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio"  value="3"  id="visa_status_own"   name="visa_status"><span>Own Visa</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="visit_visa_status_cls hide_cls visa_detail_cls">
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="visit_one_month" value="1" name="visit_visa_status"><span>One Month</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="visit_three_month"  value="2" name="visit_visa_status"><span>Three Month</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <br>
                                    <label for="repair_category">Fine Start Date</label>
                                    <input class="form-control form-control-rounded"  autocomplete="off" name="visit_exit_date"  id="visit_exit_date" value="" type="text"   />

                                </div>



                                <div class="cancel_visa_status_cls hide_cls visa_detail_cls " >
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"  id="cancel_free_zone" value="1" name="cancel_visa_status"><span>Free Zone</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"   id="cancel_company_visa"  value="2" name="cancel_visa_status"><span>Company Visa</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio"   id="cancel_waiting_cancel"  value="3" name="cancel_visa_status"><span>Waiting Cancellation</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <br>
                                    <label for="repair_category">Fine Start Date</label>
                                    <input class="form-control form-control-rounded"  name="cancel_fine_date"  autocomplete="off" id="cancel_fine_date" value="" type="text"   />
                                </div>

                                <div class="own_visa_status_cls hide_cls visa_detail_cls visa_status_own_div_cls">
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" id="own_visa_noc"    value="1" name="own_visa_status"><span>NOC</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" class="license_type_cls" id="own_visa_without_noc"  value="2" name="own_visa_status"><span>Without NOC</span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onClick="ValidateForm(this.form)">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">



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
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rider_not_visas as $visa)
                                <tr>
                                    <td>{{ $visa->id }}</td>
                                    <td>{{ $visa->personal_info->full_name }}</td>
                                    <td>{{ $visa->passport_no }}</td>
                                    <td>{{ $visa->personal_mob }}</td>
                                    <td>{{ isset($visa->nation->name) ? $visa->nation->name : 'N/A'   }}</td>
                                    <td>{{ isset($visa->created_at) ? $visa->created_at->toDateString() : '' }}</td>
                                    <td>
                                        <a class="text-primary mr-2 visa_add_cls" id="{{ $visa->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-3 font-weight-bold"></i></a>
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
        tail.DateTime("#visit_exit_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });

        tail.DateTime("#cancel_fine_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });
    </script>

    <script type="text/javascript">
        function ValidateForm(form){
            ErrorText= "";
            if ( ( form.visa_status[0].checked == false ) && (form.visa_status[1].checked == false)  && (form.visa_status[2].checked == false) )
            {
                tostr_display("error","please select visa status");
                return false;
            }
            if (ErrorText= "") { form.submit() }
        }

        $("#visa_status_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = $("#visa_status_form").attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                  if($.trim(response)=="success"){
                      tostr_display("success","Visa status updated successfully");
                      window.setTimeout(function(){
                          location.reload(true)
                      },1000);
                  } else{
                      tostr_display("error",response);
                  }

                }
            });
        });
    </script>




    <script>

        $('input[type=radio][name=visa_status]').change(function() {

            var selected = $(this).val();

            if(selected=="1"){
                $(".visit_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();
            }else if(selected=="2"){

                $(".cancel_visa_status_cls").show();
                $(".visit_visa_status_cls").hide();
                $(".own_visa_status_cls").hide();

            }else if(selected=="3"){

                $(".own_visa_status_cls").show();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }else{
                $(".own_visa_status_cls").hide();
                $(".cancel_visa_status_cls").hide();
                $(".visit_visa_status_cls").hide();
            }
        });
    </script>

    <script>
        $('tbody').on('click', '.visa_add_cls', function() {
        var selected_id = $(this).attr('id');
        $("#primary_id_selected").val(selected_id);
        $("#checkin_modal").modal('show');


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
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ').DataTable( {

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
                // responsive: true,
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
    </script>



@endsection
