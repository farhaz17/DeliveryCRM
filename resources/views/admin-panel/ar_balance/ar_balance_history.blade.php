@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /*.fc .fc-col-header-cell-cushion {*/
        /*    display: inline-block !important;*/
        /*    padding: 2px 4px !important;*/
        /*}*/
        /*.fc .fc-col-header-cell-cushion {*/
        /*    padding-top: 5px;*/
        /*    padding-bottom: 5px;*/
        /*}*/

        /*.fc-day .fc-widget-content  {*/
        /*    height: 2.5em !important;*/
        /*}*/
        /*.fc-agendaWeek-view tr {*/
        /*    height: 40px !important;*/
        /*}*/

        /*.fc-agendaDay-view tr {*/
        /*    height: 40px !important;*/
        /*}*/
        /*.fc-agenda-slots td div {*/
        /*    height: 40px !important;*/
        /*}*/
        /*.fc-event-vert {*/
        /*    min-height: 25px;*/
        /*}*/
        /*.calendar-parent {*/
        /*    height: 100vh;*/
        /*}*/

        /*.fc-toolbar {*/
        /*    padding: 15px 20px 10px;*/
        /*}*/
        /*.fc-title{*/
        /*    color :white;*/
        /*}*/
        /*.fc-rigid{*/
        /*    height: 70px !important;;*/
        /*}*/


        button.btn.btn-primary.btn-sub {
            height: 33px;
            margin-top: 28px;
        }
        a.dropdown-item {
            width: 1000px;
        }
        .card1 {
            height: 490px;
            margin-bottom: 25px;
        }
        .card.card2 {
            height: 380px;
            margin-bottom: 10px;
        }


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Ar Balance</a></li>
            <li>AR Balance  Sheet</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <!-----------------------------balance add and substract--------------->

    <div class="row pb-2" >
        <div class="col-md-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">A/R Balance Histroy Upload</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">A/R Balance  History Statement</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="card">
                        <div class="card-body">


                            <div>

                            </div>

                            <div class="row">

                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">

                                    <div class="card card1">
                                        <div class="card-body">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Upload A/R  Balance History</h5>

                                            </div>
                                            <form method="post" enctype="multipart/form-data" action="{{ url('/ar_balance_sheet_history') }}"  aria-label="{{ __('Upload') }}" >
                                                {!! csrf_field() !!}
                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <a href="{{ URL::to("assets/sample/Ar_Sample/ar_balance_add.xlsx")}}" target="_blank">
                                                            (Download Sample File)
                                                        </a>
                                                    </div>

{{--                                                    <div class="col-md-12   form-group mb-3">--}}
{{--                                                        <label for="repair_category">Platform </label>--}}
{{--                                                        <select id="platform_id-2" name="platform_id_name" class="form-control form-control" required>--}}
{{--                                                            <option value="" selected disabled>Select Platform</option>--}}

{{--                                                            @foreach($platforms as $res)--}}
{{--                                                                <option value="{{$res->id}}">{{$res->name}}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}
                                                    <div class="col-md-12  mb-3">
                                                    <label for="repair_category">Date From</label>
                                                    <input type="date" class="form-control" autocomplete="off" required=""  name="date_from" placeholder="dd-mm-YYYY" id="date_from_user">
                                                </div>
                                                <div class="col-md-12  mb-3">
                                                    <label for="repair_category">Date To</label>
                                                    <input type="date" class="form-control" autocomplete="off" required="" name="date_to" placeholder="dd-mm-YYYY" id="date_to_user">
                                                </div>

                                                    <div class="col-md-12   form-group mb-3">
                                                        <label for="repair_category">Choose File</label>
                                                        <input class="form-control" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" />
                                                    </div>

                                                    <div class="col-md-12 input-group  form-group mb-3">
                                                        <button class="btn btn-primary" type="submit">Upload</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <br><br>



                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                    <div class="col-sm-12 loading_msg" style="display: none">
                        <div class="row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="loader-spin">
                                    <div class="spinner spinner-success mr-3" style=" font-size: 30px"></div>
                                </div>


                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </div>




                    <div class="row pb-2" >

                        <div class="col-md-4">
                            <div class="card card2">
                                <div class="card-body">
                                    <div>
                                        <label for="repair_category">Search</label>
                                    </div>
                                    <div class="input-group ">


                                        <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                        <input class="form-control typeahead" id="keyword" autocomplete="off" type="text"  placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12  mb-3">

                                            <label for="repair_category">Platform </label>
                                            <select id="platform_id_search_hi" name="platform_id_search" class="form-control form-control" required>
                                                <option value="" selected disabled>Select Platform</option>

                                                @foreach($platforms as $res)
                                                    <option value="{{$res->name}}">{{$res->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-12  mb-3">
                                            <label for="repair_category">Date From</label>
                                            <input type="date" class="form-control" autocomplete="off" required=""  name="date_to_search" placeholder="dd-mm-YYYY" id="date_from_search_hi">
                                        </div>
                                        <div class="col-md-12  mb-3">
                                            <label for="repair_category">Date To</label>
                                            <input type="date" class="form-control" autocomplete="off" required="" name="date_from_search" placeholder="dd-mm-YYYY" id="date_to_search_hi">
                                        </div>
                                        <div class="col-md-12 input-group  form-group mb-3">
                                            <button class="btn btn-primary btn-sub" id="btn_date_search" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="repair_category">Select ZDS Code</label>
                                            <select id="zds_code_user3" name="zds_code_user" class="form-control">
                                                <option value="">Select Form</option>

                                                @foreach($zds_code as $res)
                                                    <option value="{{$res->zds_code}}">{{$res->zds_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12  mb-3">

                                            <label for="repair_category">Platform </label>
                                            <select id="platform_id_search_user" name="platform_id_search" class="form-control form-control" required>
                                                <option value="" selected disabled>Select Platform</option>

                                                @foreach($platforms as $res)
                                                    <option value="{{$res->name}}">{{$res->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-12  mb-3">
                                            <label for="repair_category">Date From</label>
                                            <input type="date" class="form-control" autocomplete="off" required=""  name="date_from" placeholder="dd-mm-YYYY" id="date_from_user3">
                                        </div>
                                        <div class="col-md-12  mb-3">
                                            <label for="repair_category">Date To</label>
                                            <input type="date" class="form-control" autocomplete="off" required="" name="date_from" placeholder="dd-mm-YYYY" id="date_to_user3">
                                        </div>
                                        <div class="col-md-12 input-group  form-group mb-3">
                                            <button class="btn btn-primary btn-sub" id="btn_date_user" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="col-md-12 form-group mb-3">
                                        <div  style="display: none" id="all-row">
                                        </div>
                                    </div>


                                    <div class="col-md-12 form-group mb-3">
                                        <div  style="display: none" id="search_between">
                                        </div>
                                    </div>


                                    <div class="col-md-12 form-group mb-3">
                                        <div  style="display: none" id="search_user">
                                        </div>
                                    </div>






                                    {{------------------------------------------table matched----------------------------------------}}




                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="modal fade ar_balance_edit" id="ar_balance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">AR Balance Details</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">

                                    <div class="edit-row">

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{--                                                tabl content ending div--}}
            </div>




        </div>




        <!-----------------------------Ends here-----------   balance add and substract Ends here--------------->


















        @endsection
        @section('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
            <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
            <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>



            <script type="text/javascript">
                var path = "{{ route('autocomplete') }}";
                $('input.typeahead').typeahead({
                    source:  function (query, process) {
                        return $.get(path, { query: query }, function (data) {

                            return process(data);
                        });
                    },
                    highlighter: function (item, data) {
                        var parts = item.split('#'),
                            html = '<div class="row drop-row">';
                        if (data.type == 0) {
                            html += '<div class="col-lg-12 sugg-drop">';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                            html += '<div><br></div>';
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if(data.type == 1){
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if(data.type==2){
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name">' +  data.name +  '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }  else if(data.type==2){
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name">' +  data.name +  '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==3){
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==4){
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==5)
                        {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==6) {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==7) {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==8) {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==9) {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }
                        else if (data.type==10) {
                            html += '<div class="col-lg-12 sugg-drop" >';
                            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                            html += '<div><br></div>';
                            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                            html += '<div><br></div>'
                            html += '<div><hr></div>';
                            html += '</div>';
                        }

                        return html;
                    }
                });
            </script>

            <script>


                $(document).ready(function () {
                    'use strict';

                    $('#datatable,#datatable3').DataTable( {
                        "aaSorting": [[0, 'desc']],
                        "pageLength": 10,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Date Between A/R Balance',
                                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                exportOptions: {
                                    modifier: {
                                        page : 'all'

                                    }

                                }
                            },
                            'pageLength',
                        ],
                        "columnDefs": [
                            {"targets": [0],"visible": true},
                        ],
                        "scrollY": true,
                        "scrollX": true,
                    });

                });

            </script>
            <script>
                $('#platform_id-1').select2({
                    placeholder: 'Select an option'
                });

                $('#platform_id-2').select2({
                    placeholder: 'Select an option'
                });

                $('#zds_code_balance_id').select2({
                    placeholder: 'Select an option'
                });

                $('#zds_code_user2').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_search').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_search_user').select2({
                    placeholder: 'Select an option'
                });
                $('#zds_code_user3').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_search_hi').select2({
                    placeholder: 'Select an option'
                });

            </script>

            <script>
                $(document).ready(function () {
                    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                        var currentTab = $(e.target).attr('id'); // get current tab

                        var split_ab = currentTab;
                        // alert(split_ab[1]);

                        if(split_ab=="home-basic-tab"){

                            var table = $('#datatable2').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();



                        }

                        else if(split_ab=="profile-basic-tab"){
                            var table = $('#datatable_ar_detail').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();

                            var table = $('#datatable').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();

                            var table = $('#datatable3').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();

                            $('#zds_code_user').select2({
                                placeholder: 'Select an option'
                            });


                            $('#zds_code_sub').select2({
                                placeholder: 'Select an option'
                            });
                            $('#zds_code_user2').select2({
                                placeholder: 'Select an option'
                            });

                            $('#platform_id_search').select2({
                                placeholder: 'Select an option'
                            });
                            $('#platform_id_search_user').select2({
                                placeholder: 'Select an option'
                            });
                            $('#zds_code_user3').select2({
                                placeholder: 'Select an option'
                            });

                            $('#platform_id_search_hi').select2({
                                placeholder: 'Select an option'
                            });

                        }
                        else if(split_ab=="zds-basic-tab"){
                            var table = $('#datatable5').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw();
                        }

                        else{
                            var table = $('#datatable3').DataTable();
                            $('#container').css( 'display', 'block' );
                            table.columns.adjust().draw()

                        }


                    }) ;
                });

            </script>
            <script>
                $(document).on('click', '.sugg-drop', function() {

                    var token = $("input[name='_token']").val();
                    var keyword  =   $(this).find('#drop-name').text();


                    $.ajax({
                        url: "{{ route('ar_balance_sheet_detail_history') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{_token:token,keyword:keyword},
                        beforeSend: function () {
                            $(".loading_msg").show();
                        },
                        success: function (response) {
                            $('#all-row').empty();
                            $('#search_between').empty();
                            $('#search_user').empty();
                            $('#all-row').append(response.html);
                            $('#all-row').show();
                            $(".loading_msg").hide();

                        }
                    });
                })
            </script>

            {{--    <script>--}}
            {{--        $(document).on('change','#zds_code_sub', function(){--}}
            {{--            var zds_code = $(this).val();--}}
            {{--            var token = $("input[name='_token']").val();--}}

            {{--            $.ajax({--}}
            {{--                url: "{{ route('ar_balance_sheet_detail') }}",--}}
            {{--                method: 'POST',--}}
            {{--                dataType: 'json',--}}
            {{--                data:{zds_code:zds_code,_token:token},--}}
            {{--                success: function (response) {--}}
            {{--                    $('#all-row').empty();--}}
            {{--                    $('#search_between').empty();--}}
            {{--                    $('#search_user').empty();--}}
            {{--                    $('#all-row').append(response.html);--}}
            {{--                    $('#all-row').show();--}}

            {{--                }--}}
            {{--            });--}}

            {{--        });--}}
            {{--    </script>--}}



            <script>
                $("#btn_date_search").click(function(){

                    var date_from_search = $("#date_from_search_hi").val();
                    var date_to_search = $("#date_to_search_hi").val();
                    var platform_id_search = $("#platform_id_search_hi").val();


                    var token = $("input[name='_token']").val();


                    // if (date_from_search != '' && date_to_search != ''){
                    $.ajax({
                        url: "{{ route('ar_balance_between_search_history') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{date_from_search:date_from_search,date_to_search:date_to_search,_token:token,platform_id_search:platform_id_search},
                        beforeSend: function () {
                            $(".loading_msg").show();
                        },
                        success: function (response) {
                            $('#search_suer').empty();
                            $('#all-row').empty();
                            $('#all-row').hide();
                            $('#search_user').hide();
                            $('#search_user').empty();
                            $('#search_between').empty();
                            $('#search_between').append(response.html);
                            $('#search_between').show();
                            $(".loading_msg").hide();
                        }
                    });
                    // }
                    // else{
                    //     toastr.error("Please select both options");
                    // }




                });
            </script>




            <script>
                $("#btn_date_user").click(function(){
                    var zds_code_user = $("#zds_code_user3").val();
                    var date_from_user = $("#date_from_user3").val();
                    var date_to_user = $("#date_to_user3").val();

                    var platform_id_search_user = $("#platform_id_search_user").val();




                    var token = $("input[name='_token']").val();



                    // if (date_from_user != '' && date_to_user != '' && zds_code_user != ''){

                        $.ajax({
                            url: "{{ route('ar_balance_between_user_history') }}",
                            method: 'POST',
                            dataType: 'json',
                            data:{date_from_user:date_from_user,date_to_user:date_to_user,_token:token,zds_code_user:zds_code_user,platform_id_search_user:platform_id_search_user},
                            beforeSend: function () {
                                $(".loading_msg").show();
                            },

                            success: function (response) {
                                $('#search_user').empty();
                                $('#all-row').empty();
                                $('#search_between').empty();
                                $('#search_user').append(response.html);
                                $('#search_user').show();
                                $(".loading_msg").hide();
                            }
                        });
                    // }
                    // else{
                    //     toastr.error("Please select all options");
                    // }
                });
            </script>




            <script>
                $(document).on('click','.edit_ar_bal', function(){
                    var id = $(this).attr('id');
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: "{{ route('ar_balance_sheet_edit') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{id:id,_token:token},
                        success: function (response) {
                            $('.edit-row').empty();
                            $("#bike_checkout").modal('hide')
                            $('.edit-row').append(response.html);
                            $('.edit-row').show();
                            $(".ar_balance_edit").modal('show')
                        }
                    });

                });
            </script>

            <script>
                $(document).ready(function(e) {
                    $("#zds_code_sub").change(function(){
                        var textval = $(":selected",this).val();

                        $('input[name=zds_code_balance]').val(textval);
                    })
                });


            </script>


            <script>
                $('#zds_code').select2({
                    placeholder: 'Select an option'
                });
                $('#zds_code_add').select2({
                    placeholder: 'Select an option'
                });



            </script>
            <script>
                $('#rider_id').select2({
                    placeholder: 'Select an option'
                });
            </script>

            <script>
                tail.DateTime("#date_save",{
                    dateFormat: "YYYY-mm-dd",
                    timeFormat: "HH:ii:ss",
                    position: "top"
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

@endsection
