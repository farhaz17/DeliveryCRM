@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />

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
            <li>Rider Don't have platform</li>

        </ul>
        <li class="list-group-item border-0  text-right" style="float: right;">
{{--            <span style="background: #8b0000" class="badge badge-square-success xl m-1 font_size_cls" id="first_priority_hours_72_block">{{ $remain_additional_info }}</span>--}}

        </li>
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


{{--    remain additional info modal--}}
    <div class="modal fade bd-example-modal-lg" id="additional_info_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <span id="process_please">Processing....please wait</span>
                   <div id="div_to_render">
                   </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="button">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{--    remain additional info modal emd--}}






    <div class="col-md-12 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                               <div class="table-responsive">

                                        <table class="table table-sm table-hover table-striped text-11 data_table_cls" id="datatable_not_employee" >
                                        <thead class="thead-dark">
                                        <tr>

                                            <th scope="col" style="width: 100px">ID</th>
                                            <th scope="col" style="width: 100px">PP UID</th>
                                            <th scope="col" style="width: 100px">Passport #</th>
                                            <th scope="col" style="width: 100px">ZDS Code</th>
                                            <th scope="col" style="width: 200px">Name</th>
                                            <th scope="col" style="width: 100px">Expiry Date</th>
                                            <th scope="col" style="width: 100px">Nationality</th>
                                            <th scope="col" style="width: 100px">Date of Birth</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($passport as $row)
                                            <tr>
                                                <td> {{$row->id}}</td>
                                                <td> {{$row->pp_uid}}</td>
                                                <td> {{$row->passport_no}}
                                                @if(isset($row->renew_pass))
                                                    <span>/N</span>
                                                    @elseif(isset($row->wrong_pass))
                                                        <span>/C</span>
                                                    @else
                                                    @endif
                                                </td>
                                                @if(isset($row->zds_code))
                                                    <td> {{$row->zds_code->zds_code}}</td>
                                                @else
                                                    <td> <span class="badge badge-info">No ZDS Code</span></td>
                                                @endif

                                                <td> {{isset($row->personal_info)?$row->personal_info->full_name:'' }}</td>
                                                <td>{{$row->date_expiry}}</td>
                                                <td>{{isset($row->nation->name)?$row->nation->name:'country'}}</td>
                                                <td>{{$row->dob}}</td>


                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>


                    </div>
                </div>

    </div>













@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": true},
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

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'

                            }

                        }
                    },
                    'pageLength',
                ],

                // scrollY: 500,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');

                var  table_name = "datatable_"+split_ab[1];



                var table = $('#'+table_name).DataTable();
                $(".display").css("width","100%");
                $('#'+table_name+' tbody').css("width","100%");
                $('#'+table_name).css("width","100%");
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

                // $(".display").css("width","100%");
                //     $('#'+table_name+' tbody').css("width","100%");
                //     $('#container').css( 'display', 'block' );
                //     table.columns.adjust().draw();

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
        $("#btn_additional_info").click(function () {

            $("#additional_info_modal").modal('show');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_additional_info_remains') }}",
                method: 'POST',
                dataType: 'json',
                data: {_token: token},
                success: function (response) {
                    $("#process_please").css("display","block");
                    $('#div_to_render').empty();
                    $('#div_to_render').append(response.html);

                    $('#datatable_additional_info').DataTable({
                        "aaSorting": [[0, 'desc']],
                        "pageLength": 10,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Report',
                                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                exportOptions: {
                                    modifier: {
                                        page : 'all'

                                    }

                                }
                            },
                            'pageLength',
                        ],
                        responsive: true,
                    });

                    $("#process_please").css("display","none");



                }
            });

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


    {{-- <script>

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
    </script> --}}

@endsection
