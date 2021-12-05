@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        .font_size_cls{
            font-size: 17px !important;
        }
        .list-group-item{
            padding: 0px !important;
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
        </style>


    {{-- auto complete search css start --}}

    <style>
        .col-lg-12.sugg-drop {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
    </style>

    {{-- auto complete search end  --}}
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Interview Batch Report</a></li>
            <li>Interview Batch Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
    <div class="col-md-12  float-right" >
        <button class="btn btn-primary btn-icon m-1 text-white float-right" id="search_btn" type="button"><span class="ul-btn__icon"><i class="i-Search-People"></i></span><span class="ul-btn__text">Search</span></button>
     </div>
    </div>



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

    <!--  interview detail Modal -->
    <div class="modal fade bd-example-modal-sm"  id="interview_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Change the Status For the Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('update_interview_status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type"  value="3">
                    <input type="hidden" name="checkbox_array" id="select_ids_interview" >
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 form-group mb-3 ">
                                <label for="repair_category">Select Platform</label>
                                <select class="form-control" name="interview_status" id="interview_status" required >
                                    <option value="">select an option</option>
                                    <option value="1">Pass</option>
                                    <option value="2">Fail</option>
                                    <option value="3">Absent</option>

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
    </div><!-- end of note modal -->



    <!--  search modal -->
    <div class="modal fade bd-example-modal-lg"  id="seatch_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('search_result_career_selected') }}" method="POST" id="search_form" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Search name /zds /Passport number /ppuid /Phone Number /Email</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                    <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <div id="clear">
                                        X
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_passport_id" />

                        <div class="row append_search_result mt-4">


                        </div>



                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of search modal -->


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-sm " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="update_status_form" action="{{ route('create_interview.update','0') }}">
                    {!! csrf_field() !!}
                    {{ @method_field('PUT') }}

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
                                    <option value="1">Pass</option>
                                    <option value="2">Fail</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Remarks</label>
                                <textarea class="form-control" name="remarks" required></textarea>
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


                        {{--accordian start--}}
                        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                   <div class="col-md-2 form-group mb-3 " style="float: left;"  >
                                        <label for="start_date">Select Batch</label>
                                        <select class="form-control " id="batch_id" name="batch_id">
                                            <option value="" required disabled selected>select option</option>
                                            @if(count($batches)>0)
                                            @foreach($batches as $batch)
                                                <?php  $date_ab = $batch->interviews->first(); ?>
                                                <option value="{{ $batch->id }}">  {{ isset($batch->platform->name) ? $batch->platform->name : '' }} | {{ $batch->reference_number }}  </option>
                                            @endforeach
                                                @endif
                                        </select>
{{--                                       <button class="btn btn-info btn-icon m-1 text-left" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>--}}
                                    </div>
                                        <div class="col-md-1 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                            <label for="end_date" style="display: none;">End</label>
                                            <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
{{--                                            <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>--}}
                                        </div>

                                        <div class="col-md-2 form-group mb-3 float-left text-center">
                                            <li class="list-group-item border-0 ">
                                                <span class="badge badge-square-primary xl m-1 font_size_cls" id="total_acknowledge">0</span>
                                            </li>
                                            <label for="start_date">Total Pending</label>
                                        </div>
{{--                                        <div class="col-md-2 form-group mb-3 float-left text-center">--}}
{{--                                            <li class="list-group-item border-0 ">--}}
{{--                                                <span class="badge badge-square-secondary xl m-1 font_size_cls" id="total_no_response">0</span>--}}
{{--                                            </li>--}}
{{--                                            <label for="start_date">Total Not Interested</label>--}}
{{--                                        </div>--}}
                                        <div class="col-md-1 form-group mb-3 float-left text-center">
                                            <li class="list-group-item border-0 ">
                                                <span class="badge badge-square-success xl m-1 font_size_cls" id="total_pass">0</span>
                                            </li>
                                            <label for="start_date">Total Pass</label>
                                        </div>

                                        <div class="col-md-2 form-group mb-3 float-left text-center">
                                            <li class="list-group-item border-0 ">
                                                <span class="badge badge-square-danger xl m-1 font_size_cls" id="total_fail">0</span>
                                            </li>
                                            <label for="start_date">Total Failed</label>
                                        </div>

                                        <div class="col-md-2 form-group mb-3 float-left text-center">
                                            <li class="list-group-item border-0 ">
                                                <span class="badge badge-square-info xl m-1 font_size_cls" id="total_pending">0</span>
                                            </li>
                                            <label for="start_date">Total Absent</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- accordian end here--}}


                        <button class="btn btn-info btn-icon m-1"  id="selected_btn" type="button"><span class="ul-btn__icon"><i class="i-RSS"></i></span><span class="ul-btn__text">Change the Status</span></button>

                        <div class="table-responsive">
                            <table class="display table table-striped table-sm text-15 table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Nationality</th>
{{--                                    <th scope="col">Status</th>--}}
                                    <th scope="col">Interview Remarks</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
            <div class="overlay"></div>
        </div>
    </div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script> var path = "{{ route('autocomplete_batch_report') }}"; </script>
    <script> var passport_detail_path = "{{ route('get_autocomplete_batch_report') }}"; </script>

    <script src="{{ asset('js/custom_js/batch_report.js') }}"></script>

    <script>

        $('#batch_id').select2({
            placeholder: 'Select an option'
        });
    </script>

    <script>
           $("#search_btn").click(function () {
                $("#seatch_modal").modal("show");

            });
     </script>




    <script type="text/javascript">
        function verify_load_data(from_date= '', end_date= '',batch_id=''){

            var table = $('#datatable_not_employee').DataTable({
                "aaSorting": [],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },
                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    // {"targets": [0][1],"width": "30%"}
                    {"targets": 0, "orderable": false}
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                    url : "{{ route('batch_report') }}",
                    data:{from_date:from_date, end_date:end_date,batch_id:batch_id},
                },

                "deferRender": true,
                columns: [
                    {data: 'checkbox_operation', name: 'checkbox_operation'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'passport_number', name: 'passport_number'},
                    {data: 'phone', name: 'phone'},
                    {data: 'platform', name: 'platform'},
                    {data: 'nationality', name: 'nationality'},
                    // {data: 'status', name: 'status'},
                    {data: 'interview_status', name: 'interview_status'},
                ]
            });

        }

        function ajax_load_number(batch){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_batch_log') }}",
                method: 'POST',
                data: {batch: batch ,_token:token},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        var myObject = JSON.parse(response);

                        $("#total_acknowledge").html(myObject.total_interview_pending);
                        $("#total_no_response").html(myObject.total_no_response);
                        $("#total_fail").html(myObject.total_fail);
                        $("#total_pass").html(myObject.total_pass);
                        $("#total_pending").html(myObject.total_pending);


                    }


                }
            });


        }


    </script>

    <script>
        $(document).ready(function () {


            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();
                var  batch_id = $("#batch_id").val();

                if(batch_id != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    verify_load_data(start_date, end_date,batch_id);

                    ajax_load_number(batch_id);
                }
                else
                {
                    tostr_display("error","Batch field is required");
                }

            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');


                $('#datatable_not_employee').DataTable().destroy();
                verify_load_data();

                // $('#datatable_not_employee').DataTable().destroy();
                // verify_load_data()
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

            $('#category').select2({
                placeholder: 'Select an option'
            });

        });


        $(document).on('click','.edit_cls',function(){
            // $(".edit_cls").click(function(){
            var  ids  = $(this).attr('id');
            var url =  "{{ route('create_interview.index') }}";

            var now_url = url+"/"+ids;

            $("#update_status_form").attr('action',now_url);

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
        $("#checkAll").click(function () {
            $('.company_checkbox').not(this).prop('checked', this.checked);
        });

        $("#four_pl_checkAll").click(function () {
            $('.four_pl_checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script>
        $('#selected_btn').click(function() {
            checked = $(".company_checkbox:checked").length;


            if(!checked) {
                tostr_display("error","You must check at least one checkbox.");
                return false;
            }else{

                var my_array = [];

                $(".company_checkbox:checked").each(function(){
                    my_array.push($(this).val());
                });

                $("#select_ids_interview").val(my_array);

                $("#interview_modal").modal('show');
            }
        });

        //search result action button
        $('body').on('click','.action_change_status',function () {

            var abs = $(this).attr('id');
            $("#select_ids_interview").val(abs);

            $("#interview_modal").css('z-index','99999');
            $("#interview_modal").modal('show');

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
