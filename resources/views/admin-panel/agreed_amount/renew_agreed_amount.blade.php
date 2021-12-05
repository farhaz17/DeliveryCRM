@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
        .border_cls{
            border-radius: inherit;
        }
        .hide_cls{
            display: none;
        }
        .active_cls{
            border: 2px solid #ffa500f2;
        }
        .bg_color_cls{
            background-color: #343529 !important;
        }
        .bg_color_clss{
            background-color: #f44336 !important;
        }
    </style>

    <style>

    /* loading image css starts */
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
    /* loading image css ends */

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Agreed Amount</a></li>
            <li>View Agreed Amount</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <!--  add note Modal -->
    <div class="modal fade bd-example-modal-sm"  id="accept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Request Selection</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('save_update_renew_status_taken') }}" id="selection_form" method="POST">
                    @csrf

                    <input type="hidden" name="primary_id_selected" id="primary_id_selected" >
                    <input type="hidden" name="select_choice" id="select_choice" >

                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-danger ml-2 btn-md" id="reject_btn" type="button">Reject</button>
                                <button class="btn btn-success ml-2 btn-md" id=accept_btn type="button">Accept</button>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of note modal -->

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('emirates_id_card.update',1) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3 append_div " >
                                <label for="repair_category">Passport </label>
                                <input type="text" class="form-control" id="passport_id_edit" name="passport_id" readonly>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Id Number</label>
                                <input type="text" class="form-control" id="edit_id_number" name="edit_id_number" >
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Front Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="front_pic" id="front_pic" >
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Back Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="back_pic" id="back_id" >
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

    {{--    status update modal end--}}



    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link text-10 active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Pending Requests</a></li>
                        <li class="nav-item"><a class="nav-link text-10 " id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">Accepted Requests</a></li>
                        <li class="nav-item"><a class="nav-link text-10" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejected Requests</a></li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                            <div class="row {{ $hide_class }}">
                                 <div class="col-md-3 text-center ">
                                     <h6>Total Agreed Amount</h6>
                                     <div class="card card-icon  bg-success">
                                         <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                             <i class="nav-icon   header-icon"></i>
                                             <span class="item-name" id="agreed_amount_block_0">{{ $total_agreed_amount }}</span>
                                         </a>
                                     </div>

                                 </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Advance Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name"  id="advance_amount_block_0">{{ $total_advance_amount }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Discount Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="discount_block_0">0</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <h6>Total Final Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="final_amount_block_0">{{ $total_final_amount }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            {{--accordian start--}}
                            <div class="accordion mb-10" id="accordionRightIcon_0" >
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon_0">
                                        <div class="card-body">
                                            <div class="row">



                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date_0">

                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date_0">
                                                </div>
                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                                <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1 apply_filter_cls" data-status="0"  data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1 remove_apply_filter_cls" data-status="0"  data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                                <div class="col-md-2 form-group" style="margin-top: 25px">
                                                    <div class="total">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--accordian end here--}}

                            <div class="table-responsive">
                                <table class="display table table-striped table-sm text-10 table-bordered" id="datatable">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Passport Number</th>
                                        <th scope="col">Agreed Amount</th>
                                        <th scope="col">Advance Amount</th>
                                        <th scope="col">Discount Amount</th>
                                        <th scope="col">Final Amount</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $discount_block_total = 0 ?>
                                    @foreach($agreed_amounts as $amount)
                                        <tr>
                                            <td>{{ $amount->id }}</td>
                                            <td>{{ $amount->passport->personal_info->full_name }}</td>
                                            <td>{{ $amount->passport->passport_no }}</td>
                                            <td>{{ $amount->agreed_amount }}</td>
                                            <td>{{ $amount->advance_amount }}</td>
                                            <td>
                                                <?php
                                                if($amount->discount_details!= null){
                                                    $array_discounts = json_decode($amount->discount_details,true);
                                                    $iterate = 0;
                                                    foreach ($array_discounts["0"]["name"]  as $ab){
                                                        echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";
                                                        $discount_block_total = $discount_block_total+$array_discounts["0"]["amount"][$iterate];
                                                        $iterate = $iterate+1;

                                                    }

                                                } ?>

                                            </td>
                                            <td>{{ $amount->final_amount }}</td>
                                            <td>{{ $amount->created_at }}</td>


                                            <td>
                                                <a href="javacript:void(0)" class="action_btn_cls" id="{{ $amount->id }}">
                                                    <i class="nav-icon i-Pen-3 font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach



                                    </tbody>
                                </table>
                            </div>

                        </div> {{-- first tab end here--}}

                        <div class="tab-pane fade show " id="new_taken" role="tabpanel" aria-labelledby="home-basic-new_taken">

                            <div class="row {{ $hide_class }}">
                                <div class="col-md-3 text-center ">
                                    <h6>Total Agreed Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="agreed_amount_block_1">0</span>
                                        </a>
                                    </div>

                                </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Advance Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name"  id="advance_amount_block_1">0</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Discount Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="discount_block_1">0</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <h6>Total Final Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="final_amount_block_1">0</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{--accordian start--}}
                            <div class="accordion mb-10" id="accordionRightIcon_1" >
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-2" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-2" data-parent="#accordionRightIcon_1">
                                        <div class="card-body">
                                            <div class="row">



                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date_1">

                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date_1">
                                                </div>
                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                                <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1 apply_filter_cls" data-status="1"  data="datatable_accepted"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1 remove_apply_filter_cls" data-status="1"  data="datatable_accepted"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                                <div class="col-md-2 form-group" style="margin-top: 25px">
                                                    <div class="total">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--accordian end here--}}

                            <div class="table-responsive">
                                <table class="display table table-striped table-sm text-10 table-bordered" id="datatable_accepted">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Passport Number</th>
                                        <th scope="col">Agreed Amount</th>
                                        <th scope="col">Advance Amount</th>
                                        <th scope="col">Discount Amount</th>
                                        <th scope="col">Final Amount</th>
                                        <th scope="col">Accepted Date</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div> {{-- second tab end here--}}

                        <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                            <div class="row {{ $hide_class }}">
                                <div class="col-md-3 text-center ">
                                    <h6>Total Agreed Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="agreed_amount_block_2">0</span>
                                        </a>
                                    </div>

                                </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Advance Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name"  id="advance_amount_block_2">0</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h6>Total Discount Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="discount_block_2">0</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <h6>Total Final Amount</h6>
                                    <div class="card card-icon  bg-success">
                                        <a href="javascript:void(0)"  class="card-body text-center p-2 text-white">
                                            <i class="nav-icon   header-icon"></i>
                                            <span class="item-name" id="final_amount_block_2">0</span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            {{--accordian start--}}
                            <div class="accordion mb-10" id="accordionRightIcon_2" >
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-3" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icons-3" data-parent="#accordionRightIcon_2">
                                        <div class="card-body">
                                            <div class="row">



                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date_2">

                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date_2">
                                                </div>
                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                                <div class="col-md-2 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1 apply_filter_cls" data-status="2"  data="datatable_rejected"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1 remove_apply_filter_cls" data-status="2"  data="datatable_rejected"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                                <div class="col-md-2 form-group" style="margin-top: 25px">
                                                    <div class="total">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--accordian end here--}}

                            <div class="table-responsive">
                                <table class="display table table-striped table-sm text-10 table-bordered" id="datatable_rejected">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Passport Number</th>
                                        <th scope="col">Agreed Amount</th>
                                        <th scope="col">Advance Amount</th>
                                        <th scope="col">Discount Amount</th>
                                        <th scope="col">Final Amount</th>
                                        <th scope="col">Rejected Date</th>
                                        >
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>  {{-- third tab end here--}}


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script> var passport_detail_path = "{{ route('get_passport_name_detail') }}"; </script>
    <script src="{{ asset('js/custom_js/fetch_passport.js') }}"></script>

    <script>
        tail.DateTime("#start_date_0",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date_0",{
                dateStart: $('#start_date_0').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#start_date_1",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date_1",{
                dateStart: $('#start_date_1').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#start_date_2",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date_2",{
                dateStart: $('#start_date_2').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

    </script>

    <script>
        $('body').on('click', '.action_btn_cls', function() {

            var ids = $(this).attr('id');
            $("#primary_id_selected").val(ids);
            $("#accept_modal").modal('show');
        });

        $("#reject_btn").click(function (){
            $("#select_choice").val("2");
            $("#selection_form").submit();
        });

        $("#accept_btn").click(function (){
            $("#select_choice").val("1");
            $("#selection_form").submit();
        });
    </script>


    <script>
        $(document).ready(function () {

            $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

                var currentTab = $(e.target).attr('id'); // get current tab

                if(currentTab=="home-basic-tab"){
                    make_table("datatable","0");
                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var total_agreed_amount_id = "agreed_amount_block_0";
                    var total_advance_amount_id = "advance_amount_block_0";
                    var total_discount_amount_id = "discount_block_0";
                    var total_final_amount_id = "final_amount_block_0";

                    get_blocks_count(total_agreed_amount_id,total_advance_amount_id,total_discount_amount_id,total_final_amount_id,"0");


                }else if(currentTab=="home-basic-new_taken"){
                    make_table("datatable_accepted","1");
                    var table = $('#datatable_accepted').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var total_agreed_amount_id = "agreed_amount_block_1";
                    var total_advance_amount_id = "advance_amount_block_1";
                    var total_discount_amount_id = "discount_block_1";
                    var total_final_amount_id = "final_amount_block_1";

                    get_blocks_count(total_agreed_amount_id,total_advance_amount_id,total_discount_amount_id,total_final_amount_id,"1");

                }else{
                    make_table("datatable_rejected","2");
                    var table = $('#datatable_rejected').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var total_agreed_amount_id = "agreed_amount_block_2";
                    var total_advance_amount_id = "advance_amount_block_2";
                    var total_discount_amount_id = "discount_block_2";
                    var total_final_amount_id = "final_amount_block_2";

                    get_blocks_count(total_agreed_amount_id,total_advance_amount_id,total_discount_amount_id,total_final_amount_id,"2");
                }
            });

            $("#discount_block_0").html({{ $discount_block_total }});
        });
    </script>

    <script>
        $(".apply_filter_cls").click(function () {
            var status = $(this).attr('data-status');
            var table_name = $(this).attr('data');

            var start_date  =   $("#start_date_"+status).val();
            var end_date  =   $("#end_date_"+status).val();
        if(start_date!="" && end_date!=""){

            make_table(table_name,status,start_date,end_date);
            var table = $('#'+table_name).DataTable();
            $('#container').css( 'display', 'block' );
            table.columns.adjust().draw();

            var total_agreed_amount_id = "agreed_amount_block_"+status;
            var total_advance_amount_id = "advance_amount_block_"+status;
            var total_discount_amount_id = "discount_block_"+status;
            var total_final_amount_id = "final_amount_block_"+status;

            get_blocks_count(total_agreed_amount_id,total_advance_amount_id,total_discount_amount_id,total_final_amount_id,status,start_date,end_date);

        }else
            {
                tostr_display("error","All field is required");
            }
        })
        $(".remove_apply_filter_cls").click(function () {
            var status = $(this).attr('data-status');
            var table_name = $(this).attr('data');

            var start_date  =   $("#start_date_"+status).val("");
            var end_date  =   $("#end_date_"+status).val("");

                make_table(table_name,status);
                var table = $('#'+table_name).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

        })
        </script>


    <script>
        function make_table(table_name,status,from_date="",end_date="") {


            $.ajax({
                url: "{{ route('render_view_renew_agreement_table') }}",
                method: 'GET',
                data: {request_type:status,from_date:from_date,end_date:end_date},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
                    var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            "columnDefs": [
                                {"targets": [0],"visible": false},

                            ],
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
                            "sScrollX": "100%",
                            "scrollX": true
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }

        function get_blocks_count(agreed_amount,advance_amount,total_discount, total_final_amount, request_status, start_date="",end_date=""){

            $.ajax({
                url: "{{ route('render_view_renew_agreement_count_block') }}",
                method: 'GET',
                data: {request_type: request_status,from_date:start_date,end_date:end_date},
                success: function(response) {
                    var arr = response;
                    if(arr !== null){
                        // console.log(arr['orange']);
                        $("#"+agreed_amount).html(arr['total_agreed_amount']);
                        $("#"+advance_amount).html(arr['total_advance_amount']);
                        $("#"+total_discount).html(arr['total_discount_amount']);
                        $("#"+total_final_amount).html(arr['total_final_amount']);

                    }
                }
            });
        }

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
                scrollY: 300,
                responsive: true,
            });

            $('#passport_id').select2({
                placeholder: 'Select an option'
            });


            $("#passport_id").change(function () {


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_current_passport_status') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {
                        $("#status_id").val(response);
                    }
                });

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
