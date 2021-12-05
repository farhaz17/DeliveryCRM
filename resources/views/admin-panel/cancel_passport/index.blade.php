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
            <li>View Passport Details</li>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Cancel passport</div>
                    <form method="post" enctype="multipart/form-data" id="update_form" aria-label="{{ __('Upload') }}" action="{{ route('cancel_passport.update',1) }}">
                        {!! csrf_field() !!}

                            {{ method_field('PUT') }}

                        <div class="row" id="outside_div"  >
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Passport No</label>
                                <select id="passport_number" name="passport_number" id="passport_number" class="form-control form-control-rounded" {{isset($pass_edit)?'disabled':""}}>
                                    <option value=""  >Select option</option>
                                    <?php $active_passport = $passport->where('is_cancel','=','0'); ?>
                                    @foreach($active_passport as $pas)

                                        <option value="{{ $pas->id }}" >{{ $pas->passport_no  }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3 name_div"  style="display: none">
                                <label for="repair_category">Name</label>
                                <h6 id="html_name">sfd</h6>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category" style="visibility: hidden">Name</label>
                                <button class="btn btn-primary btn-form">Save</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                {{--                <input type='button' id='btn' value='Print' onclick='printDiv();'>--}}
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 100px">ID</th>
                            <th scope="col" style="width: 100px">PP UID</th>
                            <th scope="col" style="width: 100px">Passport #</th>
                            <th scope="col" style="width: 100px">ZDS Code</th>
                            <th scope="col" style="width: 200px">Name</th>
                            <th scope="col" style="width: 100px" >Expiry Date</th>
                            <th scope="col">Cancel Date</th>
                            <th scope="col" style="width: 100px">Nationality</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $cancel_passport = $passport->where('is_cancel','=','1'); ?>
                        @foreach($cancel_passport as $row)

                            <tr>

                                <td> {{$row->id}}</td>
                                <td> {{$row->pp_uid}}</td>
                                <td> {{$row->passport_no}}</td>
                                @if(isset($row->zds_code))
                                    <td> {{$row->zds_code->zds_code}}</td>
                                @else
                                    <td> <span class="badge badge-info">No ZDS Code</span></td>
                                @endif

                                <td> {{isset($row->personal_info)?$row->personal_info->full_name:'' }}</td>
                                <td>{{$row->date_expiry}}</td>
                                <td>{{$row->updated_at}}</td>
                                <td>{{$row->nation->name}}</td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
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
                        <h5 class="modal-title" id="verifyModalContent_title">Renew Passport</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">


                        <form  action="{{ action('Passport\ViewPassportController@update',"1") }}" enctype="multipart/form-data" id="renew_modal_form" method="post">


                            <input type="hidden" id="renew_primary_id" name="primary_id_renew">

                            {!! csrf_field() !!}


                            {{ method_field('PUT') }}

                            <div  class="row">


                                <div class="col-md-6 form-group mb-3">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio" id="renewal" value="1" name="radio" checked><span>Renew</span><span class="checkmark"></span><br>
                                    </label>
                                </div>

                                <br>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="radio radio-outline-success">
                                        <input type="radio" id="wrong" value="2" name="radio"><span>Wrong Visa Typing Assinged</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 form-group mb-3" id="renew_passport_number">
                                <label for="repair_category">Renew Passport Number</label>

                                <input class="form-control form-control" id="renew_passport_number" name="renew_passport_number" placeholder=" Enter Renew Passport Number" type="text"   />
                            </div>



                            <div class="col-md-12 form-group mb-3" id="renew_passport_issue_date">
                                <label for="repair_category">Renew Passport Issue Date</label>

                                <input class="form-control form-control" id="renew_passport_issue_date" name="renew_passport_issue_date" type="date" placeholder=" Enter Renew Passport Issue Date"   />
                            </div>
                            <div class="col-md-12 form-group mb-3" id="renew_passport_expiry_date">
                                <label for="repair_category">Renew Passport Issue Date</label>

                                <input class="form-control form-control" id="renew_passport_expiry_date" name="renew_passport_expiry_date" type="date" placeholder=" Enter Renew Passport Issue Date"   />
                            </div>
                            <div class="col-md-12 form-group mb-3" id="file_name">
                                <label for="repair_category" id="copy_label">Attachment</label>
                                <div class="custom-file">
                                    <input class="form-control" id="file_name" type="file" name="file_name"/>
                                </div>
                            </div>




                            <div class="col-md-12 form-group mb-3" id="nation">
                                <label for="repair_category" id="copy_label">Nationality</label>
                                <select id="nation" name="nation" class="form-control  form-control">
                                    <option value=""  >Select option</option>

                                </select>

                            </div>



                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" > Save  </button>
                            </div>
                        </form>
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
        $('#passport_number').select2({
            placeholder: 'Select an option'
        });

        $("#passport_number").change(function(){
            var ids = $(this).val();

            var url  = "{{ route('cancel_passport.edit',12) }}";

            var abs = url.split("cancel_passport/");
            var abc_url =  abs[0]+"cancel_passport/"+ids+"/edit";

            $("#update_form").attr('action',abs[0]+"cancel_passport/"+ids);


            $.ajax({
                url: abc_url,
                method: 'get',
                data: {primary_id: ids},
                success: function (response) {
                    var arr = $.parseJSON(response);
                    if(arr !== null){
                        $("#html_name").html(arr['name']);
                        $(".name_div").show();
                    }

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
