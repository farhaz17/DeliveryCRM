@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
        }
        .table td{
            padding: 2px;
            font-size: 13px;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
            font-weight: 600;
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

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Referal</a></li>
            <li>Referal Lists</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="passport_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('save_passport_passport') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Passport Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="career_primary_id" id="primary_id_for_passport" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Nationality</label>
                                <select class="form-control" name="nation_id" id="nation_id" required>
                                    <option value="" selected disabled >Select nationality</option>
                                    @foreach($nations as $nation)
                                        <option value="{{ $nation->id }}"  >{{ $nation->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Passport Number</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control" required>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Sur Name</label>
                                <input class="form-control form-control" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Given Name</label>
                                <input class="form-control form-control" id="given_names" name="given_names" type="text" placeholder="Enter Given Name" required="">
                            </div>



                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Father Name</label>
                                <input class="form-control form-control" id="father_name" name="father_name" type="text" placeholder="Enter Father_name">
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
    {{--------------------remarks model ends here-----------------}}


    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" data-status="pending" aria-selected="true">Pending</a></li>
                        <li class="nav-item"><a class="nav-link" id="wait-list-tab" data-toggle="tab" href="#waitlist" role="tab" aria-controls="waitlist" data-status="waitlist"  aria-selected="true">Wait List</a></li>
                        <li class="nav-item"><a class="nav-link" id="selected-list-tab" data-toggle="tab" href="#selectedlist" role="tab" aria-controls="selectedlist" data-status="selected"  data-status = "0" aria-selected="true">Selected List</a></li>
                        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic"  data-status="interview" aria-selected="false">Interview</a></li>
                        <li class="nav-item"><a class="nav-link" id="only_pass-tab" data-toggle="tab" href="#only_pass" role="tab" aria-controls="only_pass" data-status="only_pass" aria-selected="false">Only Pass</a></li>
                        <li class="nav-item"><a class="nav-link" id="onboard-tab" data-toggle="tab" href="#onboard" role="tab" aria-controls="onboard" data-status="onboard" aria-selected="false">OnBoard</a></li>

{{--                        <li class="nav-item"><a class="nav-link" id="absent-tab" data-toggle="tab" href="#absent" role="tab" aria-controls="absent" data-status="absent"  aria-selected="false">Absent</a></li>--}}
{{--                        <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" data-status="detail_collected" aria-selected="false">Detail Collected</a></li>--}}
                        <li class="nav-item"><a class="nav-link" id="zds-basic1-tab" data-toggle="tab" href="#zdsBasic1" role="tab" aria-controls="zdsBasic1" data-status="hired" aria-selected="false">Hired</a></li>
                    </ul>


                 <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                    <table class="display table table-striped table-bordered" id="datatable" style="width: 100%">
                        <thead >
                        <tr>
                            <th>Referral Date</th>
                            <th>Referred By</th>
                            <th>Reference ZDS Code</th>
                            <th>Reference PPUID</th>
                            <th>Name</th>
                            <th>Phone No</th>
                            <th>Whatsapp</th>
                            <th>Passport Number</th>
                            <th>Driving Linces Number</th>
{{--                            <th>Driving Copy</th>--}}
                            <th>Status</th>
                            <th>Reward</th>
{{--                            <th>Reward Status</th>--}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referals as $row)

                            <tr>
                                <td>{{isset($row->created_at)?$row->created_at:"N/A"}}</td>
                                <td>{{isset($row->refer_by_user->personal_info->full_name)?$row->refer_by_user->personal_info->full_name:"N/A"}}</td>
                                <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
{{--                                <td>{{isset( $row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>--}}
                                <td>{{$row->name}}</td>
                                <td>{{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                                <td>{{isset($row->whatsapp_no)?$row->whatsapp_no:"N/A"}}</td>

                                <td>{{$row->passport_no ?? 'Gamers'}}</td>
                                <td>{{$row->driving_license}}</td>

                                <td>
                                    @if($row->status=='0')
                                        Pending
                                    @elseif($row->status=='1')
                                        Interview
                                    @elseif($row->status=='2')
                                        Detail Collected
                                    @elseif($row->status=='3')
                                        Hired
                                    @else
                                    @endif
                                </td>
                             <td>

                                 @if($row->referal_status_reward=='1')
                                     <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
                                 @else
                                     <span class="font-weight-bold" style="color: #0a6aa1">No Reward Yet</span>
                                 @endif
                             </td>

                                <td>

                                    <a class="text-primary mr-2 view-btn" id="{{$row->refer_by}}"><i class="nav-icon i-Full-View-Window font-weight-bold"></i></a>

                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                  </div>
                     <!-------tab1 ends here--------------->




                     <!-------wait--------------->
                     <div class="tab-pane fade show" id="waitlist" role="tabpanel" aria-labelledby="wait-list-tab">

                         <table class="display table table-striped table-bordered" id="wait_datatable" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                                                  <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>


                             </tbody>
                         </table>


                     </div>
                     <!-------wait list ends here--------------->




                     <!-------selected--------------->
                     <div class="tab-pane fade show" id="selectedlist" role="tabpanel" aria-labelledby="selected-list-tab">

                         <table class="display table table-striped table-bordered" id="selected_datatable" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                                                  <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>


                             </tbody>
                         </table>


                     </div>
                     <!-------selected ends here--------------->



                     <!-------tab2--------------->
                     <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                         <table class="display table table-striped table-bordered" id="datatable2" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                 <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>


                             </tbody>
                         </table>


                     </div>
                     <!-------tab2 ends here--------------->



                     <!-------pass--------------->
                     <div class="tab-pane fade show" id="onboard" role="tabpanel" aria-labelledby="onboard-tab">

                         <table class="display table table-striped table-bordered" id="pass_datatable" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                                                  <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>

                             </tbody>
                         </table>


                     </div>
                     <!-------pass ends here--------------->



                     <!-------fail--------------->
                     <div class="tab-pane fade show" id="only_pass" role="tabpanel" aria-labelledby="only_pass-tab">

                         <table class="display table table-striped table-bordered" id="fail_datatable" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                 <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>


                             </tbody>
                         </table>


                     </div>
                     <!-------fail ends here--------------->



                     <!-------absent--------------->
                     <div class="tab-pane fade show" id="absent" role="tabpanel" aria-labelledby="absent-tab">

                         <table class="display table table-striped table-bordered" id="absent_datatable" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
{{--                                 <th>Reference PPUID</th>--}}
                                 <th>Refernce Passport Number</th>
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                                                  <th>Reward</th>
{{--                                 <th>Reward Status</th>--}}
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>


                             </tbody>
                         </table>


                     </div>
                     <!-------absenet ends here--------------->






                     <!-------tab3--------------->
{{--                     <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab">--}}

{{--                         <table class="display table table-striped table-bordered" id="datatable3" style="width: 100%">--}}
{{--                             <thead class="thead-dark">--}}
{{--                             <tr>--}}
{{--                                 <th>Referral Date</th>--}}
{{--                                 <th>Referred By</th>--}}
{{--                                 <th>Reference ZDS Code</th>--}}
{{--                                 <th>Reference PPUID</th>--}}
{{--                                 <th>Refernce Passport Number</th>--}}
{{--                                 <th>Name</th>--}}
{{--                                 <th>Phone No</th>--}}
{{--                                 <th>Whatsapp</th>--}}
{{--                                 <th>Passport Number</th>--}}
{{--                                 <th>Driving Linces Number</th>--}}
{{--                                 <th>Driving Copy</th>--}}
{{--                                 <th>Status</th>--}}
{{--                                 <th>Reward</th>--}}
{{--                                 <th>Reward Status</th>--}}
{{--                                 <th>Action</th>--}}
{{--                             </tr>--}}
{{--                             </thead>--}}
{{--                             <tbody>--}}


{{--                             </tbody>--}}
{{--                         </table>--}}
{{--                     </div>--}}

                     <!-------interview ends here--------------->







                     <!-------tab4--------------->
                     <div class="tab-pane fade show" id="zdsBasic1" role="tabpanel" aria-labelledby="zds-basic1-tab">
                         <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%">
                             <thead >
                             <tr>
                                 <th>Referral Date</th>
                                 <th>Referred By</th>
                                 <th>Reference ZDS Code</th>
                                 <th>Reference PPUID</th>
{{--                                 <th>Refernce Passport Number</th>--}}
                                 <th>Name</th>
                                 <th>Phone No</th>
                                 <th>Whatsapp</th>
                                 <th>Passport Number</th>
                                 <th>Driving Linces Number</th>
{{--                                 <th>Driving Copy</th>--}}
                                 <th>Status</th>
                                 <th>Reward</th>
                                <th>Reward Date</th>
                                 <th>Action</th>
                             </tr>
                             </thead>
                             <tbody>

                             </tbody>
                         </table>
                     </div>
                     <!-------tab4 ends here--------------->


<!---------------main tab------->
                 </div>


    </div>
            </div>
        </div>
    </div>





{{--    varification modal--}}

    <div class="modal fade ref_modal" id="ref_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Change Reward Status to Reward Collected </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">

                            <form method="post" action="{{route('referal.store')}}">
                                {!! csrf_field() !!}

                                <input  id="referral_id" name="id"  type="hidden" required />


                          <h4 style="color: #000000">Are you sure want to add Reward status to Collected?</h4>
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


{{--    //-----------------}}



    <div class="modal fade view_modal" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Referal History</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="view_referal">

                        </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <div class="overlay"></div>

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
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                // "columnDefs": [
                //     {"targets": [0],"width": "5%"},
                //     {"targets": [1],"width": "10%"},
                //     {"targets": [2],"width": "4%"},
                //     {"targets": [12],"width": "6%"},
                // ],
                "sScrollX": "100%",
                "scrollX": true
            });
        });
    </script>

    <script>
        $('body').on('click', '.enter_passport', function() {
            var  ids  = $(this).attr('id');

            $("#primary_id_for_passport").val(ids);
            $("#passport_modal").modal('show');


        });
        </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                var status = $(this).attr('data-status');

                if(split_ab=="home-basic-tab"){
                    make_table("datatable",status);

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="wait-list-tab"){
                    make_table("wait_datatable",status);

                    var table = $('#wait_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#wait_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="selected-list-tab"){
                    make_table("selected_datatable",status);

                    var table = $('#selected_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#selected_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="profile-basic-tab"){
                    make_table("datatable2",status);

                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="onboard-tab"){
                    make_table("pass_datatable",status);

                    var table = $('#pass_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#pass_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="only_pass-tab"){
                    make_table("fail_datatable",status);

                    var table = $('#fail_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#fail_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="absent-tab"){
                    make_table("absent_datatable",status);

                    var table = $('#absent_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#absent_datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }else if(split_ab=="zds-basic1-tab"){


                    make_table("datatable4",status);

                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }


            }) ;
        });
    </script>

    <script>
        function make_table(table_name,tab_name) {

            $.ajax({
                url: "{{ route('get_referal_user_ajax') }}",
                method: 'GET',
                data: {tab_name:tab_name},
                success: function(response) {

                        $('#'+table_name+' tbody').empty();

                        var table = $('#'+table_name).DataTable();
                        table.destroy();
                        $('#'+table_name+' tbody').html(response.html);
                        var table = $('#'+table_name).DataTable(
                            {
                                "aaSorting": [],
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                                ],
                                dom: 'Bfrtip',
                                buttons: [
                                    {
                                        extend: 'excel',
                                        title: 'Pending Rider Fuel',
                                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                        exportOptions: {
                                            modifier: {
                                                page : 'all',
                                            }
                                        }
                                    },
                                    'pageLength',
                                ],
                                "scrollY": false,
                                "scrollX": true,
                            }
                        );
                        $(".display").css("width","100%");
                        $('#'+table_name+' tbody').css("width","100%");
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }
            });
        }
    </script>

    <script>


       $('body').on('click', '.reward_btn', function() {

           var id = $(this).attr('id');
           $('#referral_id').val(id);
           $('.ref_modal').modal('show');
        });

        </script>



    <script>
        $('.action-btn').on('click', function() {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('id');
            $('#referral_id').val(id);
            $('.ref_modal').modal('show');
        });
    </script>


    <script>
        $('body').on('click', '.view-btn', function() {
        // $("tbody .view-btn").click(function(){
            var token = $("input[name='_token']").val();
            var passport_id = $(this).attr('id');
            $.ajax({
                url: "{{ route('view_referal') }}",
                method: 'POST',
                dataType: 'json',
                data: {passport_id: passport_id, _token: token},
                success: function (response) {
                    $('.view_referal').empty();
                    $('.view_referal').append(response.html);
                    $(".view_modal").modal('show')
                    var table = $('#datatable2').DataTable({
                        paging: true,
                        info: true,
                        searching: true,
                        autoWidth: false,
                        retrieve: true
                    });
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
