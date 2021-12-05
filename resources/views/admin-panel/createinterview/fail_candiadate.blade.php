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
            <li><a href="">Fail Candidate</a></li>
            <li>All Fail Candidate</li>
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
                        <div class="accordion " id="accordionRightIcon" style="margin-bottom: 10px; display: none ">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                </div>
                                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                    <div class="card-body">

                                        <div class="col-md-3 form-group mb-3 " style="float: left;"  >
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- accordian end here--}}

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Status</th>

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
        function verify_load_data(from_date= '', end_date= ''){

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
                "scrollY": false,
                "processing": true,
                "serverSide": true,
                ajax:{
                    url : "{{ route('fail_candidate') }}",
                    data:{from_date:from_date, end_date:end_date,verify:"verify table"},
                },
                "deferRender": true,
                columns: [
                    {data: 'user_name', name: 'user_name'},
                    {data: 'passport_number', name: 'passport_number'},
                    {data: 'phone', name: 'phone'},
                    {data: 'platform', name: 'platform'},
                    {data: 'nationality', name: 'nationality'},
                    {data: 'remarks', name: 'remarks'},
                    {data: 'status', name: 'status'},
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

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable_not_employee').DataTable().destroy();
                    verify_load_data(start_date, end_date);
                }
                else
                {
                    tostr_display("error","Both date is required");
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
            var url =  "{{ route('create_interview') }}";

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
