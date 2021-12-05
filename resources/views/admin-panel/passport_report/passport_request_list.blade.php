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
            <li><a href="">Requested Passport</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#not_solved" role="tab" aria-controls="not_solved" aria-selected="true">Passport Requests ({{ $passports->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#solved" role="tab" aria-controls="solved" aria-selected="false">Request Status ({{ $passports_status->count() }})</a></li>
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
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remark</th>
                                    <th>Request From</th>
                                    <th scope="col" style="width: 100px">Return date</th>
                                    <th scope="col" style="width: 100px">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{ $row->reason}}</td>
                                        <td> {{ $row->remarks}}</td>
                                        <td> 
                                            @if($row->request_from == 1)
                                                Rider
                                            @elseif($row->request_from == 2) 
                                                User
                                            @endif
                                        </td>
                                        <td> {{ isset($row->return_date) ? $row->return_date->format('d/m/Y'): 'No Return'}}</td>
                                        <td>
                                            <form action="{{route('request_passport.update',$row->id)}}"  method="post">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}
                                                <div class="row">
                                                    <input type="submit" name="accept" class="btn btn-success mr-2" value="Accept">
                                                    <input type="submit" name="reject" class="btn btn-danger mr-2" value="Reject">
                                                </div>
                                            </form>
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
                                    <th scope="col" style="width: 100px">PP ID</th>
                                    <th scope="col" style="width: 100px">Passport No</th>
                                    <th scope="col" style="width: 100px">ZDS Code</th>
                                    <th scope="col" style="width: 100px">Name</th>
                                    <th scope="col" style="width: 100px">Reason</th>
                                    <th scope="col" style="width: 100px">Remarks</th>
                                    <th scope="col" style="width: 100px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($passports_status as $row)

                                    <tr>
                                        <td> {{ isset($row->passport) ? $row->passport->pp_uid: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->passport_no: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->zds_code->zds_code: ''}}</td>
                                        <td> {{ isset($row->passport) ? $row->passport->personal_info->full_name: ''}}</td>
                                        <td> {{$row->reason}}</td>
                                        <td> {{$row->remarks}}
                                        <td>
                                            @if($row->status == 1)
                                                Accepted
                                            @else
                                                Rejected
                                            @endif
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


@endsection

@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

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