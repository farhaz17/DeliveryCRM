@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 700;
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
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }




    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Ar Balance</a></li>
            <li>Upload Ar Balance  Sheet</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {{-- <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" enctype="multipart/form-data" action="{{ url('/ar_balance_upload') }}" >
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <div class="card-title">

                                    <a href="{{ URL::to("assets/sample/Ar_Sample/AR_Upload.xlsx")}}" target="_blank">
                                        (Download Sample File)
                                    </a>
                                </div>
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
    </div> --}}


    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">



                    <form method="post" enctype="multipart/form-data"   action="{{isset($ar_edit)?route('ar_balance.update',$ar_edit->id):route('ar_balance.store')}}"  >
                        {!! csrf_field() !!}
                        @if(isset($ar_edit))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            {{-- <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select ZDS Code</label>

                                @if(isset($ar_edit))
                                    <input type="hidden" id="zds_code1" name="zds_code" value="{{isset($ar_edit)?$ar_edit->id:""}}">
                                @endif
                                  <select id="zds_code" name="zds_code" class="form-control form-control">
                                  <option value="">Select Form</option>
                                      <option value="{{isset($ar_edit->zds_code)?$ar_edit->zds_code:""}}">{{isset($ar_edit->zds_code)?$ar_edit->zds_code:""}}</option>
                                    @foreach($zds_code as $res)
                                          @php
                                              $isSelected=(isset($ar_edit)?$ar_edit->zds_code:"")==$res->zds_code;
                                          @endphp


                                      <option value="{{$res->zds_code}}" {{ $isSelected ? 'selected': '' }}>{{$res->zds_code}}</option>
                                    @endforeach
                                    </select>
                            </div> --}}



{{--                            <div class="col-md-6   form-group mb-3">--}}
{{--                                <label for="repair_category">Rider ID</label>--}}
{{--                                <select id="rider_id" name="rider_id" class="form-control form-control">--}}
{{--                                    <option value="">Select Form</option>--}}

{{--                                    @foreach($rider_id as $res)--}}
{{--                                        <option value="{{$res->platform_code}}">{{$res->platform_code}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Search</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                    <input class="form-control form-control-sm  typeahead" id="keyword" autocomplete="off" type="text" required  name="name" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <input class="form-control" id="passport_number" name="passport_number" type="hidden" value="" />

                                </div>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Agreed Amount</label>
                                <input class="form-control form-control-sm" id="agreed_amount" name="agreed_amount" placeholder="Enter Agreed Amount..." type="number"
                                 value="{{isset($ar_edit)?$ar_edit->agreed_amount:""}}" required/>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Advance Amount</label>
                                <input class="form-control form-control-sm" id="advance_amount" type="number"
                                placeholder="Enter Cash Received" name="advance_amount"    value="{{isset($ar_edit)?$ar_edit->cash_received:""}}"/>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Discount Detail</label>
                                <input class="form-control form-control-sm" id="discount_details" type="number" name="discount_details" placeholder="Enter Discount Details...."  value="{{isset($ar_edit)?$ar_edit->discount:""}}" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Final Amount</label>
                                <input class="form-control form-control-sm" id="final_amount" type="numbrt" placeholder="Enter Final Amount" name="final_amount"   value="{{isset($ar_edit)?$ar_edit->deduction:""}}"/>
                            </div>

                            <div class="col-md-12 input-group  form-group mb-3">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

{{--    if data already in the table--}}
    {{-- @if(isset($gamer_array))
        <div class="row pb-2" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">

                                    <div class="alert alert-card alert-danger" role="alert">
                                        <strong class="text-capitalize">Data Already Exist!</strong>Folowing data is already available.
                                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    <table class="display table table-striped  table-bordered" id="datatable3" style="width: 100%">
                                        <thead class="thead-dark">
                                        <tr >
                                            <th scope="col">ZDS Code</th>
                                            <th scope="col">Rider ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Agreed Amount </th>
                                            <th scope="col">Cash Received</th>
                                            <th scope="col">Discount </th>
                                            <th scope="col">Deduction</th>
                                            <th scope="col">Balance </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($gamer_array as $res)
                                            <tr>
                                                <td>{{$res['zds_code']}}</td>
                                                <td>{{$res['rider_id']}}</td>
                                                <td>{{$res['name']}}</td>
                                                <td>{{$res['agreed_amount']}}</td>
                                                <td>{{$res['cash_received']}}</td>
                                                <td>{{$res['discount']}}</td>
                                                <td>{{$res['deduction']}}</td>
                                                <td>{{$res['balance']}}</td>
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
        </div>
    @endif --}}




    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-10 mr-3 ml-3">
                            <div class="table-responsive">
                                <h4 style="text-align: center">A/R Balance Sheet</h4>

                                <table class="display table table-bordered" id="datatable2" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr >

                                        <th scope="col">Name</th>
                                        <th scope="col">PPUID</th>
                                        <th scope="col">Passport No</th>
                                        <th scope="col">Agreed Amount </th>
                                        <th scope="col">Advance Amount</th>
                                        <th scope="col">Discount </th>
                                        <th scope="col">Final Amount</th>
                                        <th scope="col">Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($ar_balance as $res)

                                                <td>{{isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:"N/A"}}</td>
                                                <td>{{isset($res->passport->pp_uid)?$res->passport->pp_uid:"N/A"}}</td>
                                                <td>{{isset($res->passport->passport_no)?$res->passport->passport_no:"N/A"}}</td>
                                                <td>{{isset($res->agreed_amount)?$res->agreed_amount:"N/A"}}</td>
                                                <td>{{isset($res->advance_amount)?$res->advance_amount:"N/A"}}</td>
                                                <td>{{isset($res->discount_details)?$res->discount_details:"N/A"}}</td>
                                                <td style="font-weight: bold"> {{isset($res->final_amount)?$res->final_amount:"N/A"}}</td>
                                               <td>
                                                    <a  href="{{route('ar_balance.edit',$res->id)}}">
                                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                    @endforeach

                                    </tbody>
                                </table>



                            </div>
                        </div>
                        <div class="col-md-1">

                        </div>



                    </div>



{{------------------------------------------table matched----------------------------------------}}

{{--                        ----------------------edit modal--}}
{{--                        view Detail Passport modal--}}
                    <div class="modal fade ar_balance_edit" id="ar_balance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">AR Balance Details</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">

                                    <div class="ar_edit">

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                                </div>

                            </div>
                        </div>
                    </div>




{{-- --------------------old table starts here--------------------- --}}


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


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
    $(document).on('click', '.sugg-drop', function(){

        var passport_no  =   $(this).find('#drop-name').text();
        $('input[name=passport_number]').val(passport_no);


    });
    </script>

<script>

    $(function() {
    $("#agreed_amount,#advance_amount,#discount_details").on("keydown keyup", total_balance);
    function total_balance() {
    $("#final_amount").val(Number($("#agreed_amount").val()) - Number($("#advance_amount").val()) - Number($("#discount_details").val()) );
    }
    });
</script>




    <script>
        $(document).on('change','#zds_code', function(){
            var zds_code = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ar_balance_sheet_name') }}",
                method: 'POST',
                data: {zds_code: zds_code, _token:token},
                success: function(response) {

                    var res = response.split('$');
                    $("#sur_name1").show();
                    $(".sur_name1").show();
                    $("#sur_name1").html(res[0]);
                    $("#name").hide();
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
                            $(document).on('click','#non-edit', function(){
                                toastr.success('A/R balance cannot be edit');


                            });
                        </script>

    <script>





        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                // "columnDefs": [
                //     {"targets": [0],"visible": true},
                // ],

                "scrollY": true,
                "scrollX": true,
            });

            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Ar Balance',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'

                            }

                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });

            $('#datatable3').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                ],
                "scrollY": true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Already Exist Data',
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
        $('#zds_code').select2({
            placeholder: 'Select an option'
        });
        $('#zds_code_add').select2({
            placeholder: 'Select an option'
        });
        $('#zds_code_sub').select2({
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
