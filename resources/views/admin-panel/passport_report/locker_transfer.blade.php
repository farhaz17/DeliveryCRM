@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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

                .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
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
            /* width: 770px; */

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

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
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Transfer Passport</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#not_solved" role="tab" aria-controls="not_solved" aria-selected="true">Received ({{ $passports->count() }})</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#solved" role="tab" aria-controls="solved" aria-selected="false">Transferred ({{ $passports_status->count() }})</a></li> --}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="not_solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            {{-- <div class="m-2">
                                <a class="btn btn-primary mr-2 renew_btn_cls m-2" id="bulkTransferPopup" data-toggle="modal" data-target="#bulkTransfer" type="button" href="javascript:void(0)">Transfer</a>
                            </div> --}}
                            <table class="display table table-striped table-bordered" id="datatable_passport">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    {{-- <th></th> --}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Received From</th>
                                    <th scope="col" style="width: 100px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports as $row)

                                    <tr>
                                        {{-- <td>
                                        @if($row->status==1)
                                            <input id="selectTransfer" type="checkbox" name="checked[]" class="form-group transfer-checkbox" value="{{ $row->id }}">
                                        @endif
                                        </td> --}}
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{$row->reason}}</td>
                                        <td> {{$row->remarks}}
                                        <td> {{isset($row->user) ? $row->user->name: 'Rider'}}
                                        <td>
                                            <a class="text-success mr-2 renew_btn_cls" id="{{$row->id}}" data-toggle="modal" data-id="{{$row->id}}" data-item="{{ $row->passport->id }}" data-obj="{{ $row->request_from }}" data-target="#renew" type="button" href="javascript:void(0)">Remove From Locker</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            
                            <table class="display table table-striped table-bordered" id="datatable_passport_transferred" style="width:100%;">
                                <thead class="thead-dark">
                                <tr>
                                    {{--                            <th scope="col">#</th>--}}
                                    {{-- <th></th> --}}
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Send to</th>
                                    <th scope="col" style="width: 100px">Transferred Date</th>
                                    <th scope="col" style="width: 100px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_status as $row)

                                    <tr>
                                        {{-- <td>
                                        @if($row->status==1)
                                            <input id="selectTransfer" type="checkbox" name="checked[]" class="form-group transfer-checkbox" value="{{ $row->id }}">
                                        @endif
                                        </td> --}}
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{$row->reason}}</td>
                                        <td> {{$row->remarks}}</td>
                                        <td> {{isset($row->user) ? $row->receiving_user->name: 'Rider'}} </td>
                                        <td> {{ $row->created_at->format('jS F Y h:i:s A') }}
                                        <td>
                                            <form action="{{route('passport_collect.update',$row->id)}}"  method="post">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}
                                                @if($row->status == 0)
                                                <div class="row">
                                                    Transfer Pending
                                                </div>
                                                @elseif($row->status == 2)
                                                    Rejected
                                                @elseif($row->status == 1 || 3)
                                                    Accepted
                                                @endif
                                            </form>
                                        </td>
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

     <!---------Transfer Modal---------->
     <div class="modal fade" id="renew" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Transfer<h3>
                        </div>
                    </div>

                        <div class="renew">
                            <form   method="post" action="{{ route('request_passport.post_locker_transfer') }}">


                                <input type="hidden" id="renew_primary_id" name="primary_id_renew">

                                {!! csrf_field() !!}

                                {{-- <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Select User</label>
                                    <select class="form-control" name="user_id">
                                        @foreach($users as $row)
                                        <option value="{{ $row->id}}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                {{-- <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Select User</label>
                                    <select id="select2_user_id" name="user_id" class="form-control select">
                                        <option value="">Select User</option>
                                        @foreach($users as $row)
                                            <option value="{{ $row->id }}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <input type="hidden" id="passportid" name="passport_id" />
                                <input type="hidden" id="passportid" name="collection_id" />
                                <input type="hidden" id="request_from" name="request_from" />
                                <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Remark</label>
                                    <input class="form-control form-control" name="remark" type="text" placeholder="Remark (optional)"  />
                                </div>

                                <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Reason</label>
                                    <select class="form-control" name="reason">
                                        <option value="1">Reason 1</option>
                                        <option value="2">Reason 2</option>
                                        <option value="3">Reason 3</option>
                                        <option value="4">Reason 4</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary" value="Transfer">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!---------Bulk Transfer---------->
        <div class="modal fade" id="bulkTransfer" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">
    
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title"></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row container text-center">
                                <h3>Transfer<h3>
                            </div>
                        </div>
    
                            <div class="renew">
                                <form   method="post" action="{{ route('passport_collect.transfer') }}">
    
    
                                    <input type="hidden" id="renew_primary_id" name="primary_id_renew">
    
                                    {!! csrf_field() !!}
    
                                    {{-- <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Select User</label>
                                        <select class="form-control" name="user_id">
                                            @foreach($users as $row)
                                            <option value="{{ $row->id}}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Select User</label>
                                        <select id="bulk_user_id" name="user_id" class="form-control select">
                                            <option value="">Select User</option>
                                            @foreach($users as $row)
                                                <option value="{{ $row->id }}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="passport_ids">

                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Remark</label>
                                        <input class="form-control form-control" name="remark" type="text" placeholder="Remark (optional)"  />
                                    </div>
    
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Reason</label>
                                        <select class="form-control" name="reason">
                                            <option value="1">Reason 1</option>
                                            <option value="2">Reason 2</option>
                                            <option value="3">Reason 3</option>
                                            <option value="4">Reason 4</option>
                                        </select>
                                    </div>
    
                                    <div class="modal-footer">
                                        <div class="col-md-12">
                                            <input id="bulkTransferBtn" type="submit" name="bulk_transfer" class="btn btn-primary" value="Transfer">
                                        </div>
                                    </div>
                                </form>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>

        <!---------Send To Locker---------->
        <div class="modal fade" id="locker" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">
    
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title"></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row container text-center">
                                <h3>Locker<h3>
                            </div>
                        </div>
    
                            <div class="renew">
                                <form   method="post" action="{{ route('passport_collect.locker') }}">
    
                                    {!! csrf_field() !!}
    
                                    <input type="hidden" id="passportid" name="passport_id" />
                                    <input type="hidden" id="passportid" name="collection_id" />
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Remark</label>
                                        <input class="form-control form-control" name="remark" type="text" placeholder="Remark (optional)"  />
                                    </div>
    
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Reason</label>
                                        <select class="form-control" name="reason">
                                            <option value="1">Reason 1</option>
                                            <option value="2">Reason 2</option>
                                            <option value="3">Reason 3</option>
                                            <option value="4">Reason 4</option>
                                        </select>
                                    </div>
    
                                    <div class="modal-footer">
                                        <div class="col-md-12">
                                            <input type="submit" name="bulk_transfer" class="btn btn-primary" value="Send to Locker">
                                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('js/custom_js/passport_transfer.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

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
    $('#select2_user_id, #bulk_user_id').select2({
        placeholder: 'Select the state',
        width: '100%'
    });
        
</script>
<script>
    $(document).ready(function () {
        'use-strict'

        $('#datatable_passport_transferred, #datatable_passport').DataTable( {
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
</script>

{{-- <script>
    $(document).ready(function () {
        'use strict';

        $('#datatable_passport', '#datatable_passport_transferred').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
            ],
            // "scrollY": false,

        });
    });

</script> --}}


<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('href'); // get current tab

            var split_ab = currentTab.split('#');


            var table = $('#datatable_'+split_ab[1]).DataTable();
            $('#container').css( 'display', 'block' );
            $('#datatable_passport_transferred').css( 'width', '100%' );
            table.columns.adjust().draw();
        });
    });
</script>

<script>
    $(document).on("click", ".renew_btn_cls", function () {
        var itemid = $(this).attr('data-item');
        var pid = $(this).attr('data-id');
        var request_from = $(this).attr('data-obj');
        // console.log(pid);
        $("input[name='passport_id']").val(itemid);
        $("input[name='collection_id']").val(pid);
        $("input[name='request_from']").val(request_from);
        console.log(request_from)
    });

    $("#bulkTransferPopup").click(function(){
        console.log("hello")
        $(".transfer-checkbox").each(function(index){

        // if they are checked, add them to the modal
        var passport_id = $(this).val();
        // console.log(passport_id)

        if($(this).is(":checked")){

            // add a hidden input element to modal with article ID as value
            $("#passport_ids").append("<input name='collection_id[]' value='"+passport_id+"'  type='hidden' />")
        }
        });
    });
</script>
@endsection