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
            <li>View Passport History</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="modal fade passport_edit" id="edit_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content passport_edit">
                {{--                <div class="modal-header">--}}
                {{--                    <h5 class="modal-title" id="exampleModalCenterTitle-2">Edit Passport</h5>--}}
                {{--                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                {{--                </div>--}}
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="row">
                                    <div id="names_div">
                                        <div id="all-check" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--------Passport Additional Information--------->





    <div class="col-md-12 mb-3">




        <div class="card text-left">
            <div class="card-body">
                {{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true"><i class="nav-icon i-File-Clipboard-Text--Image mr-1"></i>Renew Passports</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#taking_visa" role="tab" aria-controls="taking_visa" aria-selected="false"><i class="nav-icon i-Remove-Bag mr-1"></i>Correct Passports</a></li>
                </ul>
                <div class="tab-content" id="myIconTabContent">
                    <div class="tab-pane fade show active" id="not_employee" role="tabpanel" aria-labelledby="home-icon-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">ID</th>
                                    <th scope="col" style="width: 100px">PP UID</th>
                                    <th scope="col" style="width: 100px">Passport #</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 200px">Name</th>
                                    <th scope="col" style="width: 100px" >Expiry Date</th>
                                    <th scope="col" style="width: 100px">Nationality</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($renew as $row)

                                    <tr>

                                        <td> {{$row->passport->id}}</td>
                                        <td> {{$row->passport->pp_uid}}</td>
                                        <td> {{$row->renew_passport_number}}
                                        </td>
                                        @if(isset($row->passport->zds_code))
                                            <td> {{$row->passport->zds_code->zds_code}}</td>
                                        @else
                                            <td> <span class="badge badge-info">No ZDS Code</span></td>
                                        @endif



                                        <td> {{isset($row->passport->personal_info)?$row->passport->personal_info->full_name:'' }}</td>
                                        <td>{{$row->renew_passport_expiry_date}}</td>
                                        <td>{{$row->passport->nation->name}}</td>







                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="taking_visa" role="tabpanel" aria-labelledby="profile-icon-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_taking_visa" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    <th scope="col" style="width: 100px">ID</th>
                                    <th scope="col" style="width: 100px">PP UID</th>
                                    <th scope="col" style="width: 100px">Passport #</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 200px">Name</th>
                                    <th scope="col" style="width: 100px">Nationality</th>
                                    {{--                                            <th scope="col" style="width: 100px">Action</th>--}}

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($correct as $row)

                                    <tr>

                                        <td> {{$row->passport->id}}</td>
                                        <td> {{$row->passport->pp_uid}}</td>
                                        <td> {{$row->passport_number}}
                                        </td>
                                        @if(isset($row->passport->zds_code))
                                            <td> {{$row->passport->zds_code->zds_code}}</td>
                                        @else
                                            <td> <span class="badge badge-info">No ZDS Code</span></td>
                                        @endif



                                        <td> {{isset($row->passport->personal_info)?$row->passport->personal_info->full_name:'' }}</td>
                                        <td>{{$row->passport->nation->name}}</td>







                                    </tr>
                                @endforeach





                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>
            </div>
        </div>




    </div>


    <!---------Renew Model---------->
    <div class="modal fade" id="renew" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="radio radio-outline-primary">
                                    <input type="radio" id="renewal" value="1" name="radio" checked><span>Renew</span><span class="checkmark"></span><br>
                                </label>
                            </div>

                            <br>
                            <div class="col-md-4 form-group mb-3">
                                <label class="radio radio-outline-success">
                                    <input type="radio" id="wrong_passport" value="2" name="radio"><span style="white-space: nowrap">Wrong Passport Number </span><span class="checkmark"></span>
                                </label>
                            </div>

                        </div>



                    </div>

                    <div class="renew">
                        <form  action="{{ action('Passport\ViewPassportController@update',"1") }}" enctype="multipart/form-data" id="renew_modal_form" method="post">


                            <input type="hidden" id="renew_primary_id" name="primary_id_renew">

                            {!! csrf_field() !!}


                            {{ method_field('PUT') }}






                            <div class="col-md-12 form-group mb-3" id="renew_passport_number">
                                <label for="repair_category">Renew Passport Number</label>

                                <input class="form-control form-control" id="renew_passport_number" name="renew_passport_number" placeholder=" Enter Renew Passport Number" type="text" required   />
                            </div>



                            <div class="col-md-12 form-group mb-3" id="renew_passport_issue_date">
                                <label for="repair_category">Renew Passport Issue Date</label>

                                <input class="form-control form-control" id="renew_passport_issue_date" name="renew_passport_issue_date" type="date" placeholder=" Enter Renew Passport Issue Date"  required />
                            </div>
                            <div class="col-md-12 form-group mb-3" id="renew_passport_expiry_date">
                                <label for="repair_category">Renew Passport Issue Date</label>

                                <input class="form-control form-control" id="renew_passport_expiry_date" name="renew_passport_expiry_date" type="date" placeholder=" Enter Renew Passport Issue Date" required   />
                            </div>



                            <div class="col-md-12 form-group mb-3" id="file_name">
                                <label for="repair_category" id="copy_label">Attachment</label>
                                <div class="custom-file">
                                    <input class="form-control" id="file_name" type="file" name="file_name"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" > Save  </button>
                            </div>
                        </form>
                    </div>

                    <div class="wrong">

                        <form  action="{{ action('Passport\ViewPassportController@update',"1") }}" enctype="multipart/form-data" id="renew_modal_form2" method="post">


                            <input type="hidden" id="renew_primary_id2" name="primary_id_renew">

                            {!! csrf_field() !!}


                            {{ method_field('PUT') }}

                            <div class="col-md-12 form-group mb-3" id="correct_passport_number">
                                <label for="repair_category">Correct Passport Number</label>

                                <input class="form-control form-control" id="correct_passport_number" name="correct_passport_number" placeholder=" Enter New Passport Number" type="text" required   />
                            </div>



                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Save</button>
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
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "40%"}
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
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee ,#datatable_taking_visa').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],

                // scrollY: 500,
                responsive: true,
                // scrollX: true,
                // scroller: true
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Passport Details',
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


        $(".pass_btn_cls-1").click(function(){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();


            $.ajax({
                url: "{{ route('ajax_passport_edit') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token: token},
                success: function (response) {
                    $('#all-check').empty();
                    $('#all-check').append(response.html);
                    $('.passport_edit').modal('show');
                }


            });


        });

        $(document).ready(function () {
            $('.renew').show();
            $('.wrong').hide();
            $("#renewal").change(function () {
                $('.renew').hide();
                $('.wrong').hide();
                $('.renew').show();
            });
        });


        $("#wrong_passport").change(function () {

            $('.renew').hide();
            $('.wrong').hide();
            $('.wrong').show();


        });



    </script>



    <script>
        $(".renew_btn_cls").click(function(){
            var ids = $(this).attr('id');


            var  action = $("#renew_modal_form").attr("action");

            var ab = action.split("view_passport/");

            var action_now =  ab[0]+'view_passport/'+ids;
            $("#renew_modal_form").attr('action',action_now);
            $("#renew_primary_id").val(ids);

            // $("#renew_passport_number").val("0");
            $('#nation').hide();
            $('#renew').modal('show');
        });

        $(".renew_btn_cls").click(function(){
            var ids = $(this).attr('id');


            var  action = $("#renew_modal_form2").attr("action");

            var ab = action.split("view_passport/");

            var action_now =  ab[0]+'view_passport/'+ids;
            $("#renew_modal_form2").attr('action',action_now);
            $("#renew_primary_id2").val(ids);

            // $("#renew_passport_number").val("0");
            $('#nation').hide();
            $('#renew').modal('show');
        });



        //------------------------------------------------------------------------
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
