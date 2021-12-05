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
        <div class="card-title mb-3">Vendor SIM</div>
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Financial"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Amount</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_amount"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Motorcycle"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Count</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_rider"></p>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div id="inline_content">
                            <form class="type">
                                <input type="radio" class="radio radio-outline-primary" name="type" value="1">All Companies</input>
                                <input type="radio" class="radio radio-outline-primary" name="type"  checked="checked" value="2">One Companies</input>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-3 form-group mb-3 "  style="float: left; " id="companies_oneby" >
                        <label for="batch_date">Select Company</label>
                        <select class="form-control" name="company_id" id="company_id" >
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
    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="spinner spinner-success mr-3" style=" font-size: 30px"></div>
                {{--                    <img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>--}}
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>



    <div class="col-md-12 mb-3">
        <div id="div_submit">
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


        function verify_load_data(from_date= '', end_date= '',type='',platform='',all_com=''){

            $.ajax({
                url: "{{ route('get_4pl_sim_detail') }}",
                method: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $(".loading_msg").show();
                },
                data:{from_date:from_date, end_date:end_date,verify:"verify table",type:type,all_com:all_com,company_id:platform,_token: "{{ csrf_token() }}"},
                success: function (response) {
                    $('#div_submit').empty();
                    $('#div_submit').append(response.html);
                    $('#div_submit').show();
                    $('.loading_msg').hide();

                }
            });
        }


    </script>

    <script>

        $('#company_id').select2({
            placeholder: 'select company'
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#inline_content input[name='type']").click(function(){

                if($('input:radio[name=type]:checked').val() == "1"){
                    $("#companies_oneby").hide();
                }
                else{
                    $("#companies_oneby").show();
                }
            });

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var normal_platform_id = $("#company_id option:selected").val();
                var all_com  =  $('input:radio[name=type]:checked').val();



                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    verify_load_data(start_date, end_date,'',normal_platform_id,all_com);
                    get_main_digits(start_date,end_date,normal_platform_id,all_com);
                }
                else
                {
                    tostr_display("error","Both date is required");
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



        function get_main_digits(start_date , end_date='',company_id='',all_com=''){

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('simget_sim_total_amount_ajax_4pl') }}",
                method: 'POST',
                data: {start_date: start_date ,end_date:end_date,company_id:company_id,all_com:all_com, _token:token},
                success: function(response) {
                    var  array = JSON.parse(response);
                    // if(array.original_path!=''){
                    //     $("#download_div").show();
                    //     $("#download_btn").attr('href',array.original_path);
                    // }else{
                    //     $("#download_div").hide();
                    // }

                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);

                }
            });
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
