@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Passports Requests</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>






    <!--------Passport Additional Information--------->





    <div class="col-md-12 mb-3">
        <table class="display table table-striped table-bordered" id="datatable">
            <thead class="thead-dark">
            <tr>
                <th>Date Created</th>
                <th>Name</th>
                <th >Passports No</th>
                <th>ZDS Code</th>
                <th>PPUID</th>
                <th>Receive Date</th>
                <th>Return Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($pass_request as $row)
                <tr>
{{--                                format('Y-m-d')--}}
                    <td>{{$row->created_at}}</td>
                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                    <td>{{$row->receive_date}}</td>
                    <td>{{$row->return_date}}</td>
                    <td>{{$row->reason}}</td>
                    <td>

                        @if($row->status=='0')
                            <span class="badge badge-pill badge-primary m-2">  Passport Receive Request</span>

                        @elseif($row->status=='1')
                            <span class="badge badge-pill badge-warning m-2">Passport Hand Overed</span>

                        @else
                            <span class="badge badge-pill badge-success m-2">
                            Passport Returned
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($row->status=='0')
                            <a class="text-info mr-2 action-btn" id="{{$row->id}}"><i class="nav-icon i-Book font-weight-bold"></i></a>
                        @elseif($row->status=='1')
                            <a class="text-success mr-2 action-btn-2" id="{{$row->id}}"><i class="nav-icon i-Inbox-Into font-weight-bold"></i></a>
                        @else
                            Passport Returned
                        @endif



                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>

    </div>



    <div class="modal fade ref_modal" id="ref_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Passport Receive</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{route('passport_request.store')}}">
                                {!! csrf_field() !!}
                                <input  id="req_id" name="req_id"  type="hidden" required />
                                <input  id="update_status" name="update_status" value="1"  type="hidden" required />
                                <h4 style="color: #000000">Do you want to change status to Passport Received?</h4>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                    <button class="btn btn-primary">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div class="modal fade ref_modal-2" id="ref_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Passport Return </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{route('passport_request.store')}}">
                                {!! csrf_field() !!}
                                <input  id="req_id-2" name="req_id"  type="hidden" required />
                                <input  id="update_status" name="update_status"  value="2" type="hidden" required />
                                <h4 style="color: #000000">Do you want to change status to Passport Return</h4>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                    <button class="btn btn-primary">Yes</button>
                                </div>
                            </form>
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
        $('.action-btn').on('click', function() {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('id');
            $('#req_id').val(id);
            $('.ref_modal').modal('show');
        });
    </script>
    <script>
        $('.action-btn-2').on('click', function() {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('id');
            $('#req_id-2').val(id);
            $('.ref_modal-2').modal('show');
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"width": "5%"},
                    {"targets": [1],"width": "10%"},
                    {"targets": [7],"width": "20%"},

                ],
                "scrollY": false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'All Passport Details',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
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


    <?php
    if(isset($edit_passport)){ ?>
    <script>


        $( document ).ready(function() {
            $(".citizenship_number").hide();
            $(".personal_add").hide();
            $(".permanant_add").hide();
            $(".booklet_no").hide();
            $(".tracking_no").hide();
            $(".mother_name").hide();
            $(".next_kin").hide();
            $(".relation").hide();
            $(".name_middle").hide();
        });
    </script>
    @if($edit_passport->nation_id=='1')
        <script>
            $(function(){

                $('#passport_edit').modal('show')
                $(".citizenship_number").show();
                $(".personal_add").show();
                $(".permanant_add").show();
                $(".booklet_no").show();
                $(".tracking_no").show();
            });



        </script>


    @elseif($edit_passport->nation_id=='2')
        <script>
            $(function(){

                $(".personal_add").show();
                $(".mother_name").show();
                $('#passport_edit').modal('show')





            });



        </script>


    @elseif($edit_passport->nation_id=='3')
        <script>
            $(function(){
                $('#passport_edit').modal('show')
                $(".citizenship_number").show();
                $(".mother_name").show();
            });



        </script>
    @elseif($edit_passport->nation_id=='6')
        <script>
            $(function(){
                $('#passport_edit').modal('show')
                $(".name_middle").show();
            });



        </script>

    @else
        <script>
            $(function(){
                $('#passport_edit').modal('show')

            });



        </script>
    @endif



    <?php
    }
    ?>


    <script>


        $(".edit_cls").click(function () {



        });
    </script>




    <script>
        $(document).ready(function () {
            $('.edit_modal [data-dismiss="modal"]').click(function () {
                // console.log('Closed modal');
                var url = '{{ route('view_passport') }}';
                window.location.href = url;
            });
        })
    </script>
    <script>
        $(document).ready(function () {
            $('.info_modal [data-dismiss="modal"]').click(function () {
                // console.log('Closed modal');
                var url = '{{ route('view_passport') }}';
                window.location.href = url;
            });
        })
    </script>


    @if(isset($edit_additional))

        <script>
            $(function(){
                $('#edit_modal').modal('show')
            });
        </script>

    @endif


    <script>

        tail.DateTime("#dob",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#dob",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_issue",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_expiry",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>

@endsection

