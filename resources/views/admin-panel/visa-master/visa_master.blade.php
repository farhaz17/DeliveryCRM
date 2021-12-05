@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">


    <style>
        .title-heading {
            white-space: nowrap;
        }
        .card-icon-bg .card-body .content {
            margin: auto;
            display: block;
            flex-direction: column;
            align-items: flex-start;
            max-width: 123px;
        }
        a {
            color: inherit;
        }
        .odd-card {
            background: #e6e6e6;


        }
        label {
            color: #000;
        }

        .watermarked {
            position: relative;
        }

        .watermarked:after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            background-position: center;
            background-image:url('assets/images/verified_mark.png');
            /*background-size: 100px 100px;*/
            /*background-position: 30px 30px;*/
            background-repeat: no-repeat;
            opacity: 0.2;
            pointer-events: none;
        }
        .row.save-offer-letter {
            margin-top: 27px;
        }
        .row.save {
            margin-top: 26px;
            margin-left: 1px;
        }
        .btn-save {
            margin-top: 27px;
        }
        select#card_type {
            margin-top: 7px;
        }
        button#sb_btn {
            margin-top: 34px;
        }
        #sb_btn222 {
            margin-top: 33px;
        }


        /*form vizards css*/
        .stepwizard-step p {
            margin-top: 10px;
            display:inline-block;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 20%;
            position: relative;
            font-weight: 900;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            left: 12px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 5px;
            height: 125%;
            background-color: #ccc;
            z-order: 0;
        }

        .stepwizard-step {
            display: block;
            position: relative;
            font-weight: 900;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
        .checkbox .checkmark, .radio .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            border-radius: 4px;
            background-color: #777777;
        }
        /* five divs */
        .col-half-offset{
            margin-left:4.166666667%
        }



    </style>
@endsection
@section('content')

    <!------------------------------------------------>
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
             Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit2" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit3" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit5" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit6" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit7" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit8" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit9" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit10" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit11" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit12" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit13" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit13" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit14" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit14" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit15" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit15" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit16" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit16" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit17" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit17" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit18" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit18" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit19" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit19" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit20" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit20" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit21" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit21" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit22" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit22" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit23" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit23" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit24" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-body">
             Amount Paid
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit24" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit25" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit25" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="confirm-submit26" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit26" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="confirm-submit27" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Amount Paid<br>
                <strong>  Are You Sure This Step Is Complete</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a id="submit27" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<!---------------------------------------------------------->

    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>

        </ul>
        <div class="col-md-12 text-right" >

            <a href="{{ route('agreement_pdf',1) }}" target="_blank" class="btn btn-primary btn-sm">Agreement Detail</a>
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">



                        <div class="col-md-12">

    <div class="card mb-4">
        <div class="card-body">
            <h6 class="mb-3"><strong>Passport Details</strong></h6>

            <form  role="form" action ="{{ route('labour_card_type') }}" id="formfield" method="post"  >
                {!! csrf_field() !!}
                <div class="row">

                    <div class="col-md-2 form-group mb-3">
                        <label for="repair_category"> <strong>Passport Number</strong></label>
                        <h5><span id="sur_name1" >{{$passport_name->passport_no}}</span></h5>
                    </div>
                    <div class="col-md-2 form-group mb-3 text-center col-half-offset" >
                        <label for="repair_category"><strong>Name</strong></label>
                        <h5><span id="sur_name1" > {{isset($passport_name->personal_info->full_name) ? $passport_name->personal_info->full_name:'' }}</span>
                            </h5>
                    </div>

                    <div class="col-md-2 form-group mb-3 text-center col-half-offset">
                        <label for="repair_category"><strong>Picture</strong></label>
                        <h5>
                            <a href="{{$passport_name->passport_pic}}" id="passport_image" target="_blank">
                                <img src="{{$passport_name->passport_pic}}" class="img-circle" alt="Passport Copy" width="60" height="60">
                            </a>
                        </h5>
                    </div>

                    <div class="col-md-2 form-group mb-3 text-center col-half-offset">
                        <label for="repair_category"><strong>Expiry Days Left</strong></label>
                        <h5 id="exp_days">{{$remain_days}}</h5>
                    </div>
                    <div class="col-md-2 form-group mb-3 text-center col-half-offset">
                        <label for="repair_category"><strong>Fine Starts From</strong></label>

                        <h5 id="exp_days">
                            @if ($fine_start==null)
                            N/A
                            @else

                            {{ \Carbon\Carbon::parse($fine_start)->format('d-m-Y')}}
                          </h5>
                            @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

                            <div class="stepwizard" id='step1'>
                                <div class="stepwizard-row">
                                    <div class="stepwizard-step">
                                        <button type="button" @if($next_status_id=='2')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif >1</button>
                                        <p>Offer Letter</p>
                                    </div>
                                </div>
                            </div>

                          @if(isset($offer_letter))
                            <div class="card mb-4 watermarked" >
                                    @else

                                        <div class="card mb-4 odd-card" id="step1-div">
                                    @endif
                                <div class="card-body">
                                    @if(isset($amount))
                                    @foreach($amount as $am)
                                            @if($am->master_step_id == '2')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                    @endforeach
                                    @endif

                                    <form   role="form" action ="{{ route('offer_letter.store') }}" id="formfield" method="post"  enctype="multipart/form-data" onsubmit="return validateForm();"   enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <input type="hidden" name="action" value="add_form" />
                                            <div class="col-md-3">
                                                <label for="repair_category">ST No</label>
                                                <input class="form-control form-control" id="st_no" name="st_no"
                                                       value="{{isset($offer_letter)?$offer_letter->st_no:""}}"
                                                       @if(isset($offer_letter)) readonly @endif @if($next_status_id=='2')  @else readonly @endif
                                                type="text" placeholder="Enter Country Code" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Company</label>

                                                @if(isset($offer_letter))
                                                    <select id="company" name="company" class="form-control form-control"  required {{isset($offer_letter)?'disabled':""}}  @if($next_status_id=='2')  @else disabled @endif>
                                                        @php
                                                            $isSelected=(isset($offer_letter)?$offer_letter->company:"")==$offer_letter->id;
                                                        @endphp
                                                            <option value="{{$offer_letter->company}}">{{$offer_letter->companies->name}}</option>
                                                    </select>
                                                @else
                                                <select id="company" name="company" class="form-control">
                                                    <option value=""  >Select option</option>
                                                    @foreach($company as $com)
                                                        <option value="{{ $com->id }}">{{ $com->name  }}</option>
                                                    @endforeach

                                                </select>
                                                    @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Job</label>
                                                @if(isset($offer_letter))

                                                    <select id="job" name="job" class="form-control form-control"  required {{isset($offer_letter)?'disabled':""}}  @if($next_status_id=='2')  @else disabled @endif>
                                                        @php
                                                            $isSelected=(isset($offer_letter)?$offer_letter->job:"")==$offer_letter->id;
                                                        @endphp
                                                        <option value="{{isset($offer_letter->job)}}">{{isset($offer_letter->designation->name)?$offer_letter->designation->name:""}}</option>
                                                    </select>
                                                @else
                                                    <select id="job" name="job" class="form-control">
                                                        <option value=""  >Select option</option>
                                                        @foreach($job as $designation)
                                                            <option value="{{ $designation->id }}">{{ $designation->name  }}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                                <div id="datetime-2-holder"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Date</label>
                                                <input class="form-control form-control"  id="offer_date_and_time" name="date_and_time"  type="text" value="{{isset($offer_letter)?$offer_letter->date_and_time:""}}"
                                                       @if(isset($offer_letter)) readonly @endif  @if($next_status_id=='2')  @else readonly @endif
                                                       placeholder="Enter Date" required />
                                                <div id="datetime-2-holder"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($offer_letter))
                                                    @if($offer_letter->visa_attachment!=null)
                                                    <br>
                                                    @foreach (json_decode($offer_letter->visa_attachment) as $visa_attach)
                                                        <a class="attachment_display" href="{{isset($offer_letter->visa_attachment)?url('assets/upload/offerLetter/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                            <strong style="color: blue">View Attachment</strong>
                                                        </a>
                                                        <span>|</span>
                                                    @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='2')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <br><br><br><br>
                                            <div class="col-md-12">
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option1"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row payment_row"  id="payment1" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" id="payment_amount" name="payment_amount"
                                                       type="text" value="{{isset($offer_letter)?$offer_letter->payment_amount:""}}"  @if(isset($offer_letter)) readonly @endif
                                                       @if($next_status_id=='2') @else readonly @endif
                                                placeholder="Payment Amount" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($offer_letter))
                                                    <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($offer_letter)?'disabled':""}}  @if($next_status_id=='3')  @else disabled @endif>
                                                        @php
                                                            $isSelected=(isset($offer_letter)?$offer_letter->payment_type:"")==$offer_letter->id;
                                                        @endphp
                                                        <option value="{{$offer_letter->payment_type}}">{{isset($offer_letter->payment->payment_type)?$offer_letter->payment->payment_type:""}}</option>
                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control">
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>




                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" id="transaction_no" name="transaction_no"
                                                       type="text" value="{{isset($offer_letter)?$offer_letter->transaction_no:""}}"
                                                       @if(isset($offer_letter)) readonly @endif
                                                       @if($next_status_id=='2')  @else readonly @endif
                                                       placeholder="Enter Country Code" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" id="transaction_date_time" name="transaction_date"
                                                       type="text" value="{{isset($offer_letter)?$offer_letter->transaction_date_time:""}}"
                                                       @if(isset($offer_letter)) readonly @endif
                                                       @if($next_status_id=='2')  @else readonly @endif
                                                       placeholder="Enter Transaction Date"  />
                                                <div id="datetime-1-holder"></div>

                                                                                         </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" id="vat" name="vat"  type="number" value="{{isset($offer_letter)?$offer_letter->vat:""}}"
                                                       @if(isset($offer_letter)) readonly @endif
                                                       @if($next_status_id=='2')  @else readonly @endif
                                                       placeholder="Enter VAT"  />
                                            </div>


                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment1</label>
                                                @if(isset($offer_letter))
                                                    <br>

                                                    <a class="attachment_display" href="{{isset($offer_letter->attachment->attachment_name)?url($offer_letter->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="file_name"
                                                           @if($next_status_id=='2')  @else disabled @endif
                                                           type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>

                                            <div class="col-md-3">
                                            <label for="repair_category"> Attachment2</label>
                                            @if(isset($offer_letter))
                                                <br>

                                                <a class="attachment_display" href="{{isset($offer_letter->attachment1)?url($offer_letter->attachment1):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                            @else
                                                <input class="form-control form-control" id="file_name2"  name="file_name2"
                                                       @if($next_status_id=='2')  @else disabled @endif
                                                       type="file" placeholder="Enter Country Code"  />
                                            @endif
                                         </div>
                                            <div class="col-md-3">
                                            <label for="repair_category"> Attachment3</label>
                                            @if(isset($offer_letter))
                                                <br>

                                                <a class="attachment_display" href="{{isset($offer_letter->attachment2)?url($offer_letter->attachment2):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                            @else
                                                <input class="form-control form-control" id="file_name3"  name="file_name3"
                                                       @if($next_status_id=='2')  @else disabled @endif
                                                       type="file" placeholder="Enter Country Code"  />
                                            @endif
                                         </div>

                                            @foreach($pass as $ps)
                                                <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden" placeholder="Enter  Amount" required />
                                            @endforeach
                                        </div>
                                            @if(isset($offer_letter))
                                                @else
                                                <div class="col-md-3 form-group">
                                                    <button  id="sb_btn" class="btn btn-primary" style="display: none" >Save</button>
                                                    <input type="button" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-save" />
                                                </div>
                                            @endif
                                    </form>
                                                    </div>

                            </div>

                                    <div class="stepwizard" id='step2'>
                                        <div class="stepwizard-row">
                                            <div class="stepwizard-step">
                                                <button type="button" @if($next_status_id=='3')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>2</button>
                                                <p>Offer Letter Submission</p>
                                            </div>

                                        </div>
                                    </div>

        @if(isset($offer_sub_letter))
            <div class="card mb-4 watermarked" >

                @else
                    <div class="card mb-4 odd-card" id="step2-div">
                        @endif
                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Offer Letter Submission</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '3')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('offer_letter_sub.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">MB Number</label>
                                                <input class="form-control form-control" id="mb_no" name="mb_no" value="{{isset($offer_sub_letter)?$offer_sub_letter->mb_no:""}}"
                                                       @if(isset($offer_sub_letter)) readonly @endif  type="text"
                                                       @if($next_status_id=='3')  @else readonly @endif
                                                       placeholder="Enter MB Number" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category">Date & Time</label>
                                                <input class="form-control form-control" id="offer_date_and_time" name="date_and_time" placeholder="Enter date and time"
                                                       value="{{isset($offer_sub_letter)?$offer_sub_letter->date_and_time:""}}"  @if(isset($offer_sub_letter)) readonly @endif
                                                       type="text" @if($next_status_id=='3')  @else readonly @endif  required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($offer_sub_letter))
                                                    @if($offer_sub_letter->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($offer_sub_letter->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($offer_sub_letter->visa_attachment)?url('assets/upload/OfferLetterSubmission/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='3')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option2"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment2" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" id="payment_amount"
                                                       value="{{isset($offer_sub_letter)?$offer_sub_letter->payment_amount:""}}"  @if(isset($offer_sub_letter)) readonly @endif
                                                       name="payment_amount"  type="text"
                                                       @if($next_status_id=='3')  @else readonly @endif
                                                       placeholder="Enter Country Code"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>

                                                @if(isset($offer_sub_letter))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($offer_letter)?'disabled':""}}  @if($next_status_id=='3')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($offer_sub_letter)?$offer_sub_letter->payment_type:"")==$offer_sub_letter->id;
                                                        @endphp
                                                        <option value="{{isset($offer_sub_letter->payment_type)?$offer_sub_letter->payment_type:""}}">{{isset($offer_sub_letter->payment->payment_type)?:""}}</option>

                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='3')  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

{{--                                                <input class="form-control form-control" id="payment_type" value="{{isset($offer_sub_letter)?$offer_sub_letter->payment_type:""}}"  @if(isset($offer_sub_letter)) readonly @endif--}}
{{--                                                name="payment_type"  type="text"--}}
{{--                                                       @if($next_status_id=='3')  @else readonly @endif--}}
{{--                                                       placeholder="Enter Country Code" required />--}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" id="transaction_no"
                                                       value="{{isset($offer_sub_letter)?$offer_sub_letter->transaction_no:""}}"  @if(isset($offer_sub_letter)) readonly @endif
                                                       @if($next_status_id=='3')  @else readonly @endif
                                                       name="transaction_no"  type="text" placeholder="Enter Transaction Number"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control" id="transaction_date_time"
                                                       value="{{isset($offer_sub_letter)?$offer_sub_letter->transaction_date_time:""}}"  @if(isset($offer_sub_letter)) readonly @endif
                                                       @if($next_status_id=='3')  @else readonly @endif
                                                       name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"/>
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" id="vat" name="vat" value="{{isset($offer_sub_letter)?$offer_sub_letter->vat:""}}"
                                                       @if(isset($offer_sub_letter)) readonly @endif  type="number"
                                                       @if($next_status_id=='3')  @else readonly @endif
                                                       placeholder="Enter Country Code"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($offer_sub_letter))
                                                    <br>
                                                    <a href="{{isset($offer_sub_letter->attachment->attachment_name)? url($offer_sub_letter->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                <input class="form-control form-control" id="file_name"  name="file_name"
                                                       @if($next_status_id=='3')  @else disabled @endif
                                                       type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>



                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment2</label>
                                                @if(isset($offer_sub_letter))
                                                    <br>

                                                    <a class="attachment_display" href="{{isset($offer_sub_letter->attachment2)?url($offer_sub_letter->attachment2):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name2"  name="file_name2"
                                                           @if($next_status_id=='3')  @else disabled @endif
                                                           type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment3</label>
                                                @if(isset($offer_sub_letter))
                                                    <br>

                                                    <a class="attachment_display" href="{{isset($offer_sub_letter->attachment3)?url($offer_sub_letter->attachment3):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name3"  name="file_name3"
                                                           @if($next_status_id=='3')  @else disabled @endif
                                                           type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)


                                                <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden" placeholder="Enter  Amount" required />

                                            @endforeach





                                        </div>
                                        @if(isset($offer_sub_letter))

                                        @else
                                            <div class="col-md-3 form-group">
                                                <button  id="offer_letter_sub" class="btn btn-primary" style="display: none"  >Save</button>
                                                <input type="button" name="btn" value="Save" id="submitBtn2" data-toggle="modal"   @if($next_status_id=='3')  @else disabled @endif data-target="#confirm-submit2" class="btn btn-primary btn-save" />

                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>

                    <div class="stepwizard" id='step3'>
                        <div class="stepwizard-row">
                            <div class="stepwizard-step">
                                <button type="button" @if($next_status_id=='4')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>3</button>
                                <p>Electronic Pre Approval</p>
                            </div>

                        </div>
                    </div>

                    @if(isset($elec_pre_app))
                        <div class="card mb-4 watermarked" >

                            @else
                                <div class="card mb-4 odd-card" id="step3-div">
                                    @endif
                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Electronic Pre Approval</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '4')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('electronic_pre_app.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">


                                            <div class="col-md-3">
                                                <label for="repair_category">Person Code</label>
                                                <input class="form-control form-control" id="person_code" name="person_code"
                                                       value="{{isset($elec_pre_app)?$elec_pre_app->person_code:""}}"  @if(isset($elec_pre_app)) readonly @endif type="text"
                                                       @if($next_status_id=='4')  @else readonly @endif
                                                       placeholder="Enter Person Code" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Labour Card Number</label>
                                                <input class="form-control form-control" id="labour_card_no"
                                                       name="labour_card_no" value="{{isset($elec_pre_app)?$elec_pre_app->labour_card_no:""}}"  @if(isset($elec_pre_app)) readonly @endif  type="text"
                                                       @if($next_status_id=='4')  @else readonly @endif
                                                       placeholder="Enter Labour Card"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" id="offer_date_and_time" name="issue_date" placeholder="Enter Issue Date"
                                                       value="{{isset($elec_pre_app)?$elec_pre_app->issue_date:""}}"  @if(isset($elec_pre_app)) readonly @endif
                                                       @if($next_status_id=='4')  @else readonly @endif
                                                       type="text"  required />

                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control" id="offer_date_and_time" name="expiry_date" placeholder="Enter Expiry Date"
                                                       value="{{isset($elec_pre_app)?$elec_pre_app->expiry_date:""}}"  @if(isset($elec_pre_app)) readonly @endif
                                                       @if($next_status_id=='4')  @else readonly @endif
                                                       type="text"  required />
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($elec_pre_app))
                                                    @if($elec_pre_app->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($elec_pre_app->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($elec_pre_app->visa_attachment)?url('assets/upload/electronic_pre_approval/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='4')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <br><br><br>

                                            @foreach($pass as $ps)

                                                <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden" required />

                                            @endforeach


                                            @if(isset($elec_pre_app))

                                            @else
                                                <div class="col-md-3 form-group">
                                                    <button  id="elec_pre_approval" class="btn btn-primary" style="display: none">Save</button>
                                                    <input  @if($next_status_id=='4')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn" data-toggle="modal" data-target="#confirm-submit3" class="btn btn-primary btn-save" />

                                                </div>
                                            @endif


                                        </div>
                                    </form>
                                </div>
                            </div>
                                <div class="stepwizard" id='step4'>
                                    <div class="stepwizard-row">
                                        <div class="stepwizard-step">
                                            <button type="button" @if($next_status_id=='5')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>4</button>
                                            <p>Electronic Pre Approval Payment</p>
                                        </div>

                                    </div>
                                </div>
                                @if(isset($elec_pre_app_pay))
                                    <div class="card mb-4 watermarked" >

                                        @else
                                            <div class="card mb-4 odd-card" id="step4-div">
                                                @endif
                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Electronic Pre Approval Payment</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '5')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action="{{ route('elec_pre_app_payment') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}


                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">MB Number</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->mb_no:""}}"  @if(isset($elec_pre_app_pay)) readonly @endif
                                                id="mb_no" name="mb_no"  type="text"
                                                       @if($next_status_id=='5')  @else readonly @endif
                                                       placeholder="Enter Payment" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($elec_pre_app_pay))
                                                    @if($elec_pre_app_pay->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($elec_pre_app_pay->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($elec_pre_app_pay->visa_attachment)?url('assets/upload/ElectronicPreAppPay/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='5')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>




                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option_app"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment_app" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->payment_amount:""}}"
                                                       @if(isset($elec_pre_app_pay)) readonly @endif  id="payment_amount" name="payment_amount" @if($next_status_id=='5')  @else readonly @endif  type="text" placeholder="Enter Payment Type"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($elec_pre_app_pay))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($elec_pre_app_pay)?'disabled':""}}  @if($next_status_id=='5')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($elec_pre_app_pay)?$elec_pre_app_pay->payment_type:"")==$elec_pre_app_pay->id;
                                                        @endphp
                                                        <option value="{{isset($elec_pre_app_pay->payment_type)?$elec_pre_app_pay->payment_type:""}}">{{isset($elec_pre_app_pay->payment->payment_type)?$elec_pre_app_pay->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='5')  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->transaction_no:""}}"
                                                       @if(isset($elec_pre_app_pay)) readonly @endif  id="transaction_no"
                                                       name="transaction_no"  type="text"
                                                       @if($next_status_id=='5')  @else readonly @endif
                                                       placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->transaction_date_time:""}}"
                                                       @if(isset($elec_pre_app_pay)) readonly @endif  @if($next_status_id=='5')  @else readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->vat:""}}"
                                                       @if(isset($elec_pre_app_pay)) readonly @endif  id="vat" name="vat"
                                                       @if($next_status_id=='5')  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Final Amount</label>
                                                <input class="form-control form-control" value="{{isset($elec_pre_app_pay)?$elec_pre_app_pay->final_amount:""}}"
                                                       @if(isset($elec_pre_app_pay)) readonly @endif  id="final_amount" name="final_amount"
                                                       @if($next_status_id=='5')  @else readonly @endif
                                                       type="text" placeholder="Enter Final Amount"  />
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($elec_pre_app_pay))
                                                    <br>
                                                    <a href="{{isset($elec_pre_app_pay->attachment->attachment_name)?url($elec_pre_app_pay->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="file_name" @if($next_status_id=='5')  @else disabled @endif  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden" placeholder="Enter  Amount"  />

                                            @endforeach




                                        </div>
                                        @if(isset($elec_pre_app_pay))

                                        @else
                                            <div class="col-md-3 form-group">
                                                <button  id="elec_pre_approval_pay" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='5')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn27" data-toggle="modal" data-target="#confirm-submit27" class="btn btn-primary btn-save" />

                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            <div id="hide_if_own">
                    <div class="card mb-4 card-hidden" >
                        <div class="card-body">
{{--                            <h6 class="mb-3"><strong>Entry Print Visa Inside</strong></h6>--}}
                            <div class="col-md-6">
                                <form action ="{{ route('entry_visa_outside') }}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                <label class="radio radio-outline-success">
                                    <input type="radio" data="Yes" value="0"  id="print_inside_click" @if(isset($print_inside)) disabled @endif name="visa_print"><span>Entry Print Visa Inside</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="radio radio-outline-success">
                                    <input type="radio" data="No" value="1" id="print_outside_click" @if(isset($print_inside)) disabled @endif name="visa_print"><span>Entry Print Visa Outside</span><span class="checkmark"></span>
                                </label>


                            </div>

                        </div>
                    </div>

                                            <div class="stepwizard" id='step5'>
                                                <div class="stepwizard-row">
                                                    <div class="stepwizard-step">
                                                        <button type="button" @if($next_status_id=='6')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>5</button>
                                                        <p>Print Visa <span id='inside_value'></span>

                                                            @if(isset($print_inside)?$print_inside->inside_out_status=='0':"")
                                                                <span>Inside</span>
                                                                @elseif(isset($print_inside)?$print_inside->inside_out_status=='1':"")
                                                                <span>Outside</span>
                                                            @else
                                                                <span></span>
                                                                @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(isset($print_inside))
                                                <div class="card mb-4 watermarked card-hidden" >

                                                    @else
                                                        <div class="card mb-4 odd-card card-hidden" id="step5-div">
                                                            @endif
                        <div class="card-body">
{{--                            <h6 class="mb-3"><strong>Print Visa Inside/Outside</strong></h6>--}}
                            @if(isset($amount))
                                @foreach($amount as $am)
                                    @if($am->master_step_id == '6')
                                        <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                    @endif
                                @endforeach
                            @endif
{{--                            <form action ="{{ route('entry_visa_inside.store') }}" method="POST" enctype="multipart/form-data">--}}
                            <form action ="{{ route('entry_visa_outside') }}" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="row">

                                        <div class="col-md-3">
                                        <label for="repair_category">Visa Number</label>
                                            <input class="form-control form-control" id="status_value" name="inside_out_status" hidden value="">


                                            <input class="form-control form-control" id="visa_number" name="visa_number" value="{{isset($print_inside)?$print_inside->visa_number:""}}"  @if(isset($print_inside)) readonly @endif
                                        @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                        type="text" placeholder="Enter Visa Number" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">UID No</label>
                                        <input class="form-control form-control" id="uid_no" name="uid_no" value="{{isset($print_inside)?$print_inside->uid_no:""}}"
                                               @if(isset($print_inside)) readonly @endif   @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif type="text" placeholder="Enter UID No" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Visa Issue Date</label>
                                        <input class="form-control form-control" id="visa_issue_date" value="{{isset($print_inside)?$print_inside->visa_issue_date:""}}"
                                               @if(isset($print_inside)) readonly @endif name="visa_issue_date"
                                               @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                               type="text" placeholder="Enter Visa Issue Date" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Visa Expiry Date</label>
                                        <input class="form-control form-control" id="visa_expiry_date" value="{{isset($print_inside)?$print_inside->visa_expiry_date:""}}"
                                               @if(isset($print_inside)) readonly @endif name="visa_expiry_date"
                                               @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                               type="text" placeholder="Enter Visa Expiry Date" required />
                                    </div>

                                    <div class="col-md-3">
                                        <label for="repair_category"> Attachment</label>

                                        @if(isset($print_inside))
                                            @if($print_inside->visa_attachment!=null)
                                                <br>
                                                @foreach (json_decode($print_inside->visa_attachment) as $visa_attach)

                                                    <a class="attachment_display" href="{{isset($print_inside->visa_attachment)?url('assets/upload/EntryPrintOutSide/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                        <strong style="color: blue">View Attachment</strong>
                                                    </a>
                                                    <span>|</span>

                                                @endforeach
                                            @endif
                                        @else
                                            <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                   @if($next_status_id=='6')  @else disabled @endif
                                                   type="file"  />
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <br>
                                        <label class="checkbox checkbox-primary">
                                            <input type="checkbox" id="payment_option3"><span>Payment Options</span><span class="checkmark"></span>
                                        </label>

                                    </div>
                                </div>
                                <div class="row payment_row"  id="payment3" style="display: none">




                                    <div class="col-md-3">
                                        <label for="repair_category">Payment Amount</label>
                                        <input class="form-control form-control" id="payment_amount" value="{{isset($print_inside)?$print_inside->payment_amount:""}}"  @if(isset($print_inside)) readonly @endif
                                        @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                        name="payment_amount"  type="text" placeholder="Enter Country Code"  />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Payment Type</label>
                                        @if(isset($print_inside))

                                            <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($print_inside)?'disabled':""}}  @if($next_status_id=='7')  @else disabled @endif>

                                                @php
                                                    $isSelected=(isset($print_inside)?$print_inside->payment_type:"")==$print_inside->id;
                                                @endphp
                                                <option value="{{isset($print_inside->payment_type)?$print_inside->payment_type:""}}">{{isset($print_inside->payment->payment_type)?$print_inside->payment->payment_type:""}}</option>


                                            </select>
                                        @else
                                            <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif>
                                                <option value=""  >Select option</option>
                                                @foreach($payment_type as $pay_type)
                                                    <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                @endforeach

                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Transaction Number</label>
                                        <input class="form-control form-control" id="transaction_no" value="{{isset($print_inside)?$print_inside->transaction_no:""}}"
                                               @if(isset($print_inside)) readonly @endif name="transaction_no"
                                               @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                               type="text" placeholder="Enter Transaction Number"  />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Transaction Date</label>
                                        <input class="form-control form-control" id="visa_issue_date" value="{{isset($print_inside)?$print_inside->transaction_date_time:""}}"  @if(isset($print_inside)) readonly @endif
                                        @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                        name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"/>
                                        <div id="datetime-1-holder"></div>                                            </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Vat</label>
                                        <input class="form-control form-control" id="vat" name="vat" value="{{isset($print_inside)?$print_inside->vat:""}}"
                                               @if(isset($print_inside)) readonly @endif
                                               @if($next_status_id=='6' or $next_status_id=='7')  @else readonly @endif
                                               type="number" placeholder="Enter Country Code"  />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category"> Attachment</label>
                                        @if(isset($print_inside))
                                            <br>
                                            <a href="{{isset($print_inside->attachment->attachment_name)?url($print_inside->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                        @else
                                            <input class="form-control form-control" id="file_name"   @if($next_status_id=='6' or $next_status_id=='7')  @else disabled @endif  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                        @endif
                                    </div>
                                    @foreach($pass as $ps)

                                        <input class="form-control form-control" id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden" placeholder="Enter  Amount"  />

                                    @endforeach

                                </div>
                                @if(isset($print_inside))

                                @else
                                    <div class="col-md-3 form-group">
                                        <button  id="visa_print_inside" class="btn btn-primary" style="display: none">Save</button>
                                        <input  @if($next_status_id=='6' or $next_status_id=='7')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn5" data-toggle="modal" data-target="#confirm-submit5" class="btn btn-primary btn-save" />

                                    </div>
                                @endif

                            </form>
                        </div>
                    </div>

                    <div class="card mb-4 card-hidden" >
                        <div class="card-body">
                            <div class="col-md-6">

                                <label class="radio radio-outline-success">
                                    <input type="radio" data="Yes"  id="status_change" name="status_change"><span>Status Change</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="radio radio-outline-success">
                                    <input type="radio" data="No"  id="in-out_status" name="status_change"><span>In-out Change</span><span class="checkmark"></span>
                                </label>


                            </div>

                        </div>
                    </div>

                                                        <div class="stepwizard" id='step6'>
                                                            <div class="stepwizard-row">
                                                                <div class="stepwizard-step">
                                                                    <button type="button" @if($next_status_id=='8')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>6</button>
                                                                    <p>Status Change/In-Out Status Change</p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        @if(isset($status_change))
                                                            <div class="card mb-4 watermarked" >

                                                                @else
                                                                    <div class="card mb-4 odd-card card-hidden status_change1"  id="step6-div">
                                                                        @endif


                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Status Change</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '8')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('status_change.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="repair_category">Exit Date</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->exit_date:""}}"
                                                       @if(isset($status_change)) readonly @endif id="visa_issue_date" name="exit_date"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                                                       type="text" placeholder="Enter Exit Date" required />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="repair_category">Entry Date</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->entry_date:""}}"
                                                       @if(isset($status_change)) readonly @endif id="visa_issue_date" name="entry_date"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                                                       type="text" placeholder="Enter Entry Date" required />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->expiry_date:""}}"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       @if(isset($status_change)) readonly @endif id="visa_issue_date" name="expiry_date"
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                                                       type="text" placeholder="Enter Expiry Date" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($status_change))
                                                    @if($status_change->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($status_change->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($status_change->visa_attachment)?url('assets/upload/StatusChange/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='8')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>


                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option4"  @if(isset($status_inside_outside)?$status_inside_outside=='1':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="row payment_row"  id="payment4" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->payment_amount:""}}"
                                                       @if(isset($status_change)) readonly @endif id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif
                                                       type="text" placeholder="Enter Payment" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($status_change))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"  {{isset($status_change)?'disabled':""}}  @if($next_status_id=='8')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($status_change)?$status_change->payment_type:"")==$status_change->id;
                                                        @endphp
                                                        <option value="{{isset($status_change->payment_type)?$status_change->payment_type:""}}">{{isset($status_change->payment->payment_type)?$status_change->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control"  @if($next_status_id=='8')  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->transaction_no:""}}"
                                                       @if(isset($status_change)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->transaction_date_time:""}}"
                                                       @if(isset($status_change)) readonly @endif id="visa_issue_date" name="transaction_date_time" value=""
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->vat:""}}"
                                                       @if(isset($status_change)) readonly @endif id="vat" name="vat"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($status_change))
                                                    <br>
                                                    <a href="{{isset($status_change->attachment->attachment_name)?url($status_change->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name" @if($next_status_id=='8')  @else disabled @endif name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>


                                            <div class="col-md-3">
                                                <label for="repair_category">Fine</label>
                                                <input class="form-control form-control" value="{{isset($status_change)?$status_change->fine:""}}"
                                                       @if($next_status_id=='8')  @else readonly @endif
                                                       @if(isset($status_change)) readonly @endif id="fine" name="fine"  type="text" placeholder="Enter Fine"  />
                                            </div>
                                            <div class="col-md-3">
                                            <label for="repair_category">Type</label>
                                                @if(isset($status_change))

                                                    <select id="type" name="type" class="form-control form-control"   {{isset($status_change)?'disabled':""}} @if($next_status_id=='8')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($status_change)?$status_change->type:"")==$status_change->id;
                                                        @endphp
                                                        @if($status_change->type=="Cash")
                                                            <option value="{{$status_change->type}}">Cash</option>
                                                        @else
                                                            <option value="{{$status_change->type}}">Online</option>
                                                        @endif

                                                    </select>
                                                @else
                                            <select id="type" name="type" class="form-control">
                                                <option value=""  >Select option</option>
                                                <option value="Cash">Cash</option>
                                                <option value="online">Online</option>
                                            </select>
                                                    @endif
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Proof</label>
                                                @if(isset($status_change))
                                                    <br>
                                                    <a href="{{isset($status_change->proof)?url($status_change->proof):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Proof</strong></a>
                                                @else
                                                    <input class="form-control form-control"  @if($next_status_id=='8')  @else disabled @endif id="file_name1"  name="file_name1"  type="file"  />
                                                @endif
                                            </div>






                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach








                                </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($status_change))

                                            @else

                                                <button  id="status_change_form" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='8')  @else disabled @endif  type="button" name="btn" value="Save" id="submitBtn7" data-toggle="modal" data-target="#confirm-submit7" class="btn btn-primary btn-save" />
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                              @if(isset($in_out_status))

                               <div class="card mb-4 watermarked" >
                                        @else
                                       <div class="card mb-4 card-hidden in-out_status1"  id="card">
                                        @endif

                                <div class="card-body">
                                    <h6 class="mb-3"><strong>In-Out Status Change</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '9')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('inout_status_change') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">

                                            <div class="col-md-6">
                                                <label for="repair_category">Out Side Entry Date</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->outside_entry_date:""}}"

                                                       @if(isset($in_out_status)) readonly @endif id="outside_entry_date" name="outside_entry_date"

                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif


                                                       type="text" placeholder="Enter Exit Date" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->expiry_date:""}}"
                                                       @if(isset($in_out_status)) readonly @endif id="outside_entry_date" name="expiry_date"

                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif
                                                       @if(isset($status_inside_outside)?$status_inside_outside=='1':"") readonly @endif


                                                       type="text" placeholder="Enter Expiry Date" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($in_out_status))
                                                    @if($in_out_status->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($in_out_status->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($in_out_status->visa_attachment)?url('assets/upload/InOutStatusChange/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='8')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>


                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">

                                                    <input type="checkbox" id="payment_option5" @if(isset($status_inside_outside)?$status_inside_outside=='1':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="row payment_row"  id="payment5" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->payment_amount:""}}"
                                                       @if(isset($in_out_status)) readonly @endif id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif

                                                       type="text" placeholder="Enter Payment"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($in_out_status))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($in_out_status)?'disabled':""}}  @if($next_status_id=='9')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($in_out_status)?$in_out_status->payment_type:"")==$in_out_status->id;
                                                        @endphp
                                                        <option value="{{isset($in_out_status->payment_type)?$in_out_status->payment_type:""}}">{{isset($in_out_status->payment->payment_type)?$in_out_status->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='8' or $next_status_id=='9' )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->transaction_no:""}}"
                                                       @if(isset($in_out_status)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif

                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->transaction_date_time:""}}"
                                                       @if(isset($in_out_status)) readonly @endif id="transaction_date_time"
                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif

                                                       name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"/>
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control"  value="{{isset($in_out_status)?$in_out_status->vat:""}}"
                                                       @if(isset($in_out_status)) readonly @endif id="vat" name="vat"
                                                       @if($next_status_id=='8' or $next_status_id=='9' )  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                            <label for="repair_category"> Attachment</label>
                                            @if(isset($in_out_status))
                                                <br>
                                                <a href="{{isset($in_out_status->attachment->attachment_name)? url($in_out_status->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                            @else
                                                <input class="form-control form-control" id="file_name" @if($next_status_id=='8' or $next_status_id=='9' )  @else disabled @endif name="file_name"  type="file" placeholder="Enter Country Code"  />
                                            @endif


                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach
                                            </div>


                                        </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($in_out_status))

                                            @else

                                                <button  id="inout_status" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='8' or $next_status_id=='9' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn8" data-toggle="modal" data-target="#confirm-submit8" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                       <div class="stepwizard" id='step7'>
                                           <div class="stepwizard-row">
                                               <div class="stepwizard-step">
                                                   <button type="button" @if($next_status_id=='10')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>7</button>
                                                   <p>Entry Date</p>
                                               </div>

                                           </div>
                                       </div>
                                       @if(isset($entry_date))
                                           <div class="card mb-4 watermarked" >
                                               @else
                                                   <div class="card mb-4 odd-card  card-hidden" id="step7-div">
                                                       @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Entry Date</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '10')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('entry_date.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">



                                            <div class="col-md-6">
                                                <label for="repair_category">Entry Date</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->expiry_date:""}}"  @if(isset($entry_date)) readonly @endif
                                                @if(isset($entry_date)?$entry_date=='0':"") readonly @endif
                                                @if($next_status_id=='10' )  @else readonly @endif

                                                id="transaction_date_time" name="entry_date"  type="text" placeholder="Enter Expiry Date" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->expiry_date:""}}"  @if(isset($entry_date)) readonly @endif
                                                @if($next_status_id=='10' )  @else readonly @endif
                                                @if(isset($entry_date)=='0') readonly @endif
                                                @if(isset($entry_date)?$entry_date=='0':"") readonly @endif
                                                id="transaction_date_time" name="expiry_date"  type="text" placeholder="Enter Expiry Date" required />
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($entry_date))
                                                    @if($entry_date->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($entry_date->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($entry_date->visa_attachment)?url('assets/upload/EntryDate/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='10')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>



                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option6" @if(isset($entry_date)?$entry_date=='0':"") disabled @endif><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="row payment_row"  id="payment6" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->payment_amount:""}}"
                                                       @if(isset($entry_date)) readonly @endif id="payment_amount"
                                                       @if($next_status_id=='10' )  @else readonly @endif
                                                       name="payment_amount"  type="text" placeholder="Enter Payment"  />
                                            </div>




                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($entry_date))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($entry_date)?'disabled':""}}  @if($next_status_id=='10')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($entry_date)?$entry_date->payment_type:"")==$entry_date->id;
                                                        @endphp
                                                        <option value="{{isset($entry_date->payment_type)?$entry_date->payment_type:""}}">{{isset($entry_date->payment->payment_type)?$entry_date->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='10'  )  @else disabled @endif >
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->transaction_no:""}}"
                                                       @if(isset($entry_date)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='10' )  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->transaction_date_time:""}}"
                                                       @if(isset($entry_date)) readonly @endif id="transaction_date_time" name="transaction_date_time"
                                                       @if($next_status_id=='10' )  @else readonly @endif
                                                       value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control"  value="{{isset($entry_date)?$entry_date->vat:""}}"
                                                       @if(isset($entry_date)) readonly @endif  id="vat" name="vat"
                                                       @if($next_status_id=='10' )  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($entry_date))
                                                    <br>
                                                    <a href="{{isset($entry_date->attachment->attachment_name)? url($entry_date->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control"  @if($next_status_id=='10' )  @else disabled @endif id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($entry_date))

                                            @else

                                                <button  id="entry_date_form" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='10' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn9" data-toggle="modal" data-target="#confirm-submit9" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>




                    <div class="card mb-4 card-hidden" >
                        <div class="card-body">
                            <div class="col-md-6">
                                <label for="repair_category">Medical (Normal,48 Hours,24 Hours,VIP Hours)</label>
                                <select id="medical" name="medical" class="form-control">
                                    <option value=""  selected disabled >Select option</option>
                                    <option value="medical_normal">Medical (Normal)</option>
                                    <option value="medical_48">Medical (48 Hours)</option>
                                    <option value="medical_24">Medical (24 Hours)</option>
                                    <option value="medical_vip">Medical (VIP Hours)</option>
                                </select>
                            </div>

                        </div>
                           </div>
                                                   <div class="stepwizard" id='step8'>
                                                       <div class="stepwizard-row">
                                                           <div class="stepwizard-step">
                                                               <button type="button" @if($next_status_id=='11')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>8</button>
                                                               <p>Medical</p>
                                                           </div>

                                                       </div>
                                                   </div>
                                                   @if(isset($med_normal))
                                                       <div class="card mb-4 watermarked" >
                                                           @else
                                                               <div class="card mb-4  card-hidden medical_normal" id="card medical_normal step8-div">
                                                                   @endif

                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (Normal)</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '11')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('medical.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Transaction Number</label>
                                                <input class="form-control form-control"   value="{{isset($med_normal)?$med_normal->medical_tans_no:""}}"  @if(isset($med_normal)) readonly @endif id="medical_tans_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="medical_tans_no"  type="number" placeholder="Medical Transaction Number" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Date</label>
                                                <input class="form-control form-control" value="{{isset($med_normal)?$med_normal->medical_date_time:""}}"
                                                       @if(isset($med_normal)) readonly @endif  id="transaction_date_time"
                                                       name="medical_date_time"  type="text"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       placeholder="Enter Expiry Date" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($med_normal))
                                                    @if($med_normal->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($med_normal->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($med_normal->visa_attachment)?url('assets/upload/MedicalNormal/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='11')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>


                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option7"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment7" style="display: none">


                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" value="{{isset($med_normal)?$med_normal->payment_amount:""}}"
                                                       @if(isset($med_normal)) readonly @endif  id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Payment"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($med_normal))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($med_normal)?'disabled':""}}  @if($next_status_id=='11')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($med_normal)?$med_normal->payment_type:"")==$med_normal->id;
                                                        @endphp
                                                        <option value="{{isset($med_normal->payment_type)?$med_normal->payment_type:""}}">{{isset($med_normal->payment->payment_type)?$med_normal->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='11'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($med_normal)?$med_normal->transaction_no:""}}"
                                                       @if(isset($med_normal)) readonly @endif  id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control" value="{{isset($med_normal)?$med_normal->transaction_date_time:""}}"
                                                       @if(isset($med_normal)) readonly @endif  id="transaction_date_time"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control"  value="{{isset($med_normal)?$med_normal->vat:""}}"
                                                       @if(isset($med_normal)) readonly @endif id="vat" name="vat"  type="number"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($med_normal))
                                                    <br>
                                                    <a href="{{isset($med_normal->attachment->attachment_name)?url($med_normal->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"  @if($next_status_id=='11' )  @else disabled @endif  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                            </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($med_normal))

                                            @else

                                                <button  id="med_normal" class="btn btn-primary" style="display: none">Save</button>
                                                <input  @if($next_status_id=='11' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn10" data-toggle="modal" data-target="#confirm-submit10" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                @if(isset($med_48))
                <div class="card mb-4 watermarked" >
             @else
                        <div class="card mb-4 odd-card  card-hidden medical_48" id="card medical_48">
                  @endif

                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (48 Hours)</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '12')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('medical48') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="transaction_no" name="medical_tans_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Medical Transaction Number" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Date</label>
                                                <input class="form-control form-control"  value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="transaction_date_time" name="medical_date_time"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Expiry Date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($med_48))
                                                    @if($med_48->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($med_48->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($med_48->visa_attachment)?url('assets/upload/Medical48/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='11')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option8"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment8" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"  value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Payment"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($med_48))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($med_48)?'disabled':""}}  @if($next_status_id=='11')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($med_48)?$med_48->payment_type:"")==$med_48->id;
                                                        @endphp
                                                        <option value="{{isset($med_48->payment_type)?$med_48->payment_type:""}}">{{isset($med_48->payment->payment_type)?$med_48->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='11'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control"  value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="transaction_date_time" name="transaction_date_time"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control"   value="{{isset($med_48)?$med_48->medical_tans_no:""}}"
                                                       @if(isset($med_48)) readonly @endif id="vat" name="vat"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($med_48))
                                                    <br>
                                                    <a href="{{isset($med_48->attachment->attachment_name)? url($med_48->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"  @if($next_status_id=='11' )  @else disabled @endif name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                        </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($med_48))

                                            @else

                                                <button  id="med_48" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='11' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn11" data-toggle="modal" data-target="#confirm-submit11" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if(isset($med_24))
                                <div class="card mb-4 watermarked" >
                                    @else
                             <div class="card mb-4  card-hidden medical_24" id="card medical_24">
                                            @endif


                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (24 Hours)</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '13')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif





                                    <form action ="{{ route('medical24') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($med_24)?$med_24->medical_tans_no:""}}"
                                                       @if(isset($med_24)) readonly @endif id="medical_tans_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="medical_tans_no"  type="text" placeholder="Medical Transaction Number" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Date</label>
                                                <input class="form-control form-control" value="{{isset($med_24)?$med_24->medical_date_time:""}}"
                                                       @if(isset($med_24)) readonly @endif id="medical_date_time"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="medical_date_time"  type="text" placeholder="Enter Expiry Date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($med_24))
                                                    @if($med_24->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($med_24->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($med_24->visa_attachment)?url('assets/upload/Medical24/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='11')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option9"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment9" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" value="{{isset($med_24)?$med_24->payment_amount:""}}"
                                                       @if(isset($med_24)) readonly @endif id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Payment" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($med_24))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($med_24)?'disabled':""}}  @if($next_status_id=='11')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($med_24)?$med_24->payment_type:"")==$med_24->id;
                                                        @endphp
                                                        <option value="{{isset($med_24->payment_type)?$med_24->payment_type:""}}">{{isset($med_24->payment->payment_type)?$med_24->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='11'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($med_24)?$med_24->transaction_no:""}}"
                                                       @if(isset($med_24)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" value="{{isset($med_24)?$med_24->transaction_date_time:""}}"
                                                       @if(isset($med_24)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Country Code"  />
                                                <div id="datetime-1-holder">

                                                </div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" value="{{isset($med_24)?$med_24->vat:""}}"
                                                       @if(isset($med_24)) readonly @endif id="vat" name="vat"  type="number"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($med_24))
                                                    <br>
                                                    <a href="{{isset($med_24->attachment->attachment_name)? url($med_24->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"  @if($next_status_id=='11' )  @else disabled @endif name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div>
                                        <div class="col-md-12 form-group">

                                            @if(isset($med_24))

                                            @else

                                                <button  id="med_24" class="btn btn-primary" style="display: none">Save</button>
                                                <input  @if($next_status_id=='11' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn12" data-toggle="modal" data-target="#confirm-submit12" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>


                                            @if(isset($med_vip))
                                                <div class="card mb-4 watermarked" >
                                                    @else
                                        <div class="card mb-4 odd-card  card-hidden medical_vip" id="card medical_vip">
                                          @endif

                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (VIP)</strong></h6>
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '14')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif



                                    
                                    <form action ="{{ route('medicalvip') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($med_vip)?$med_vip->medical_tans_no:""}}"
                                                       @if(isset($med_vip)) readonly @endif id="medical_tans_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="medical_tans_no"  type="text" placeholder="Medical Transaction Number" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category">Medical Date & Time</label>
                                                <input class="form-control form-control" value="{{isset($med_vip)?$med_vip->medical_date_time:""}}"
                                                       @if(isset($med_vip)) readonly @endif id="medical_date_time" name="medical_date_time"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Expiry Date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($med_vip))
                                                    @if($med_vip->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($med_vip->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($med_vip->visa_attachment)?url('assets/upload/MedicalVIP/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='11')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option10"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment10" style="display: none">

                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" id="payment_amount" name="payment_amount"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Enter Payment"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($med_vip))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($med_vip)?'disabled':""}}  @if($next_status_id=='11')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($med_vip)?$med_vip->payment_type:"")==$med_vip->id;
                                                        @endphp
                                                        <option value="{{isset($med_vip->payment_type)?$med_vip->payment_type:""}}">{{isset($med_vip->payment->payment_type)?$med_vip->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='11'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($med_vip)?$med_vip->transaction_no:""}}"
                                                       @if(isset($med_vip)) readonly @endif  id="transaction_no"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       name="transaction_no"  type="text" placeholder="Enter Transaction Number" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" value="{{isset($med_vip)?$med_vip->transaction_date_time:""}}"
                                                       @if(isset($med_vip)) readonly @endif id="medical_date_time" name="transaction_date_time" value=""
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="text" placeholder="Transaction Date" />
                                                <div id="datetime-1-holder"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" value="{{isset($med_vip)?$med_vip->vat:""}}"
                                                       @if(isset($med_vip)) readonly @endif id="vat" name="vat"
                                                       @if($next_status_id=='11' )  @else readonly @endif
                                                       type="number" placeholder="Enter Vat"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($med_vip))
                                                    <br>
                                                    <a href="{{isset($med_vip->attachment->attachment_name)?url($med_vip->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control"  @if($next_status_id=='11' )  @else disabled @endif id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code" />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($med_vip))

                                            @else

                                                <button  id="med_vip" class="btn btn-primary" style="display: none">Save</button>
                                                <input  @if($next_status_id=='11' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn13" data-toggle="modal" data-target="#confirm-submit13" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                                        <div class="stepwizard" id='step8'>
                                                            <div class="stepwizard-row">
                                                                <div class="stepwizard-step">
                                                                    <button type="button" @if($next_status_id=='15')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>9</button>
                                                                    <p>Fit - Unfit</p>
                                                                </div>

                                                            </div>
                                                        </div>
                           @if(isset($fit_unfit))
                           <div class="card mb-4 watermarked" >
                            @else
                                   <div class="card mb-4  card-hidden" id="card">
                             @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Fit - Unfit</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '15')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('fit_unfit') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-4">

                                                <label for="repair_category">Status</label>

                                                @if(isset($fit_unfit))

                                                    <select id="status" name="status" class="form-control form-control"  required {{isset($fit_unfit)?'disabled':""}}  @if($next_status_id=='15' )  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($fit_unfit)?$fit_unfit->status:"")==$fit_unfit->id;
                                                        @endphp
                                                        @if($fit_unfit->status=="1")
                                                        <option value="{{$fit_unfit->status}}">Fit</option>
                                                        @else
                                                        <option value="{{$fit_unfit->status}}">Unfit</option>
                                                            @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control"  required  @if($next_status_id=='15' )  @else disabled @endif>



                                                    <option >Select option</option>
                                                    <option value="1">Fit</option>
                                                    <option value="0">Unfit</option>
                                                </select>
                                                    @endif

                                            </div>


{{--                                            <div class="col-md-6">--}}
{{--                                                <label for="repair_category"> Attachment</label>--}}

{{--                                                @if(isset($fit_unfit))--}}
{{--                                                    @if($fit_unfit->attachment->attachment_name !=null)--}}
{{--                                                        <br>--}}
{{--                                                        @foreach (json_decode($fit_unfit->attachment->attachment_name) as $visa_attach)--}}

{{--                                                            <a class="attachment_display" href="{{isset($fit_unfit->attachment->attachment_name)?url('assets/upload/fit_unfit/'.$visa_attach):""}}" id="passport_image" target="_blank">--}}
{{--                                                                <strong style="color: blue">View Attachment</strong>--}}
{{--                                                            </a>--}}
{{--                                                            <span>|</span>--}}

{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple--}}
{{--                                                           @if($next_status_id=='15')  @else disabled @endif--}}
{{--                                                           type="file"  />--}}
{{--                                                @endif--}}
{{--                                            </div>--}}

                                            <div class="col-md-4">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($fit_unfit))
                                                    <br>
                                                    <a href="{{isset($fit_unfit->attachment->attachment_name)?url($fit_unfit->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control"  @if($next_status_id=='15' )  @else disabled @endif id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code" required />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                            <div class="col-md-4 form-group">

                                                @if(isset($fit_unfit))

                                                @else
                                                    <div class="col-md-12 form-group">
                                                        <button  id="fit_unfit" class="btn btn-primary" style="display: none">Save</button>
                                                        <input @if($next_status_id=='15' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn14" data-toggle="modal" data-target="#confirm-submit14" class="btn btn-primary btn-save" />

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                                   <div class="stepwizard" id='step9'>
                                       <div class="stepwizard-row">
                                           <div class="stepwizard-step">
                                               <button type="button" @if($next_status_id=='16')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>10</button>
                                               <p>Emirates ID Apply</p>
                                           </div>

                                       </div>
                                   </div>
                             @if(isset($emirates_app))
                              <div class="card mb-4 watermarked" >
                               @else
                                  <div class="card mb-4 odd-card  card-hidden" id="card step9-div">
                                    @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Emirates ID Apply</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '16')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form action ="{{ route('emirates_app.store') }}" method="POST" enctype="multipart/form-data" >
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Emirates ID Application Expiry</label>
                                                <input class="form-control form-control"  value="{{isset($emirates_app)?$emirates_app->e_id_app_expiry:""}}"
                                                       @if(isset($emirates_app)) readonly @endif id="medical_date_time" name="e_id_app_expiry"
                                                       @if($next_status_id=='16' )  @else readonly @endif
                                                       type="text" placeholder="Enter Date" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"  value="{{isset($emirates_app)?$emirates_app->payment_amount:""}}"  @if(isset($emirates_app)) readonly @endif
                                                id="payment_amount" name="payment_amount"  type="text"
                                                       @if($next_status_id=='16' )  @else readonly @endif
                                                       placeholder="Enter Payment" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($emirates_app))
                                                    @if($emirates_app->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($emirates_app->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($emirates_app->visa_attachment)?url('assets/upload/emirates_id_app/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='16')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option11"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment11" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($emirates_app))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"  required {{isset($emirates_app)?'disabled':""}}  @if($next_status_id=='16')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($emirates_app)?$emirates_app->payment_type:"")==$emirates_app->id;
                                                        @endphp
                                                        <option value="{{isset($emirates_app->payment_type)?$emirates_app->payment_type:""}}">{{isset($emirates_app->payment->payment_type)?$emirates_app->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='16'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control"  value="{{isset($emirates_app)?$emirates_app->transaction_no:""}}"
                                                       @if(isset($emirates_app)) readonly @endif id="transaction_no" name="transaction_no"
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control"   @if($next_status_id=='16' )
                                                @else readonly @endif value="{{isset($emirates_app)?$emirates_app->transaction_date_time:""}}"
                                                       @if(isset($emirates_app)) readonly @endif id="medical_date_time" name="transaction_date_time" value=""
                                                       type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control"   @if($next_status_id=='16' )
                                                @else readonly @endif value="{{isset($emirates_app)?$emirates_app->vat:""}}"
                                                       @if(isset($emirates_app)) readonly @endif id="vat" name="vat"  type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($emirates_app))
                                                    <br>
                                                    <a href="{{isset($emirates_app->attachment->attachment_name)?url($emirates_app->attachment->attachment_name):""}}"
                                                       id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='16' )
                                                    @else disabled @endif id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($emirates_app))

                                            @else

                                                <button  id="e_app" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='16' )  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn15" data-toggle="modal" data-target="#confirm-submit15" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                      <div class="stepwizard" id='step10'>
                                          <div class="stepwizard-row">
                                              <div class="stepwizard-step">
                                                  <button type="button" @if($next_status_id=='17')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>11</button>
                                                  <p>Emirates ID Finger Print(Yes/No)</p>
                                              </div>

                                          </div>
                                      </div>
                                      @if(isset($finger_print))
                                          <div class="card mb-4 watermarked" >
                                              @else
                                                  <div class="card mb-4  card-hidden" id="card step10-div">
                                                      @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Emirates ID Finger Print(Yes/No)</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '17')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('finger_print') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Finger Print</label>
                                                @if(isset($finger_print))

                                                    <select id="status" name="status" class="form-control form-control"  required {{isset($finger_print)?'disabled':""}} >

                                                        @php
                                                            $isSelected=(isset($finger_print)?$finger_print->status:"")==$finger_print->id;
                                                        @endphp
                                                        @if($finger_print->status=="1")
                                                            <option value="{{$finger_print->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$finger_print->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" required  @if($next_status_id=='17')  @else disabled @endif >
                                                    <option readonly="" >Select option</option>
                                                    <option value="1" >Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>


                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($finger_print))
                                                    @if($finger_print->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($finger_print->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($finger_print->visa_attachment)?url('assets/upload/finger_print/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='17')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                           @foreach($pass as $ps)

                                            <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                          <div class="col-md-6 form-group">

                                            @if(isset($finger_print))

                                            @else

                                                    <button  id="e_finger_print" class="btn btn-primary" style="display: none">Save</button>
                                                    <input  @if($next_status_id=='17')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn16" data-toggle="modal" data-target="#confirm-submit16" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                        </div>
                                </form>
                                </div>
                            </div>
                                                  <div class="stepwizard" id='step11'>
                                                      <div class="stepwizard-row">
                                                          <div class="stepwizard-step">
                                                              <button type="button" @if($next_status_id=='18')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>12</button>
                                                              <p>New Contract Application Typing</p>
                                                          </div>

                                                      </div>
                                                  </div>

                            @if(isset($new_contract))
                            <div class="card mb-4 watermarked" >
                             @else
                              <div class="card mb-4 odd-card  card-hidden" id="card step12-div">
                               @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>New Contract Application Typing</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '18')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('new_contract.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"
                                                       value="{{isset($new_contract)?$new_contract->payment_amount:""}}"  @if(isset($new_contract)) readonly @endif
                                                       id="payment_amount" name="payment_amount"  type="text"
                                                       @if($next_status_id=='18')  @else readonly @endif
                                                       placeholder="Enter Payment" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($new_contract))
                                                    @if($new_contract->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($new_contract->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($new_contract->visa_attachment)?url('assets/upload/NewContractAppTyping/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='18')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option12"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>




                                        <div class="row payment_row"  id="payment12" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($new_contract))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($new_contract)?'disabled':""}}  @if($next_status_id=='2')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($new_contract)?$new_contract->payment_type:"")==$new_contract->id;
                                                        @endphp
                                                        <option value="{{isset($new_contract->payment_type)?$new_contract->payment_type:""}}">{{isset($new_contract->payment->payment_type)?$new_contract->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='18'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" value="{{isset($new_contract)?$new_contract->transaction_no:""}}"
                                                       @if(isset($new_contract)) readonly @endif id="transaction_no" name="transaction_no"
                                                       @if($next_status_id=='18')  @else readonly @endif
                                                       type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control" value="{{isset($new_contract)?$new_contract->transaction_date_time:""}}"
                                                       @if(isset($new_contract)) readonly @endif id="transaction_date_time"
                                                       @if($next_status_id=='18')  @else readonly @endif
                                                       name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" value="{{isset($new_contract)?$new_contract->vat:""}}"
                                                       @if(isset($new_contract)) readonly @endif id="vat" name="vat"  type="number"
                                                       @if($next_status_id=='18')  @else readonly @endif
                                                       placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($new_contract))
                                                    <br>
                                                    <a href="{{isset($new_contract->attachment->attachment_name)?url($new_contract->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name"   @if($next_status_id=='18')  @else disabled @endif name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category">Fine</label>
                                                <input class="form-control form-control"   @if($next_status_id=='18')  @else readonly @endif value="{{isset($new_contract)?$new_contract->fine:""}}"  @if(isset($new_contract)) readonly @endif id="fine" name="fine"  type="text" placeholder="Enter Fine" />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Type</label>

                                                @if(isset($new_contract))

                                                    <select id="type" name="type" class="form-control form-control"   {{isset($new_contract)?'disabled':""}}>

                                                        @php
                                                            $isSelected=(isset($new_contract)?$new_contract->type:"")==$new_contract->id;
                                                        @endphp
                                                        @if($new_contract->type=="Cash")
                                                            <option value="{{$new_contract->type}}">Cash</option>
                                                        @else
                                                            <option value="{{$new_contract->type}}">Online</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="type" name="type" class="form-control"   @if($next_status_id=='18')  @else disabled @endif>
                                                    <option value=""  >Select option</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="online">Online</option>
                                                </select>
                                                    @endif
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Proof</label>
                                                @if(isset($new_contract))
                                                    <br>
                                                    <a href="{{isset($new_contract->proof)?url($new_contract->proof):""}}"
                                                       id="passport_image" target="_blank"><strong style="color: blue">View Proof</strong></a>
                                                @else
                                                    <input class="form-control form-control"   @if($next_status_id=='18')
                                                    @else disabled @endif id="file_name1"  name="file_name1"  type="file"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div>
                                        <div class="col-md-6 form-group">

                                            @if(isset($new_contract))

                                            @else

                                                <button  id="new_contract" class="btn btn-primary" style="display: none">Save</button>
                                                <input  @if($next_status_id=='18')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn17" data-toggle="modal" data-target="#confirm-submit17" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                    <div class="stepwizard" id='step12'>
                                        <div class="stepwizard-row">
                                            <div class="stepwizard-step">
                                                <button type="button" @if($next_status_id=='19')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>13</button>
                                                <p>Tawjeeh Class</p>
                                            </div>

                                        </div>
                                    </div>
                              @if(isset($tawjeeh))
                                        <div class="card mb-4 watermarked" >
                                            @else
                                                <div class="card mb-4  card-hidden" id="card step12-div">
                                                    @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Tawjeeh Class</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '19')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('tawjeeh_class') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Tawjeeh Class</label>
                                                @if(isset($tawjeeh))

                                                    <select id="status" name="status" class="form-control form-control"  required {{isset($tawjeeh)?'disabled':""}}>

                                                        @php
                                                            $isSelected=(isset($tawjeeh)?$tawjeeh->status:"")==$tawjeeh->id;
                                                        @endphp
                                                        @if($tawjeeh->status=="1")
                                                            <option value="{{$tawjeeh->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$tawjeeh->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" required   @if($next_status_id=='19')  @else disabled @endif>
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($tawjeeh))
                                                    @if($tawjeeh->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($tawjeeh->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($tawjeeh->visa_attachment)?url('assets/upload/TawjeehClass/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='19')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                            <div class="col-md-6 form-group">

                                                @if(isset($tawjeeh))

                                                @else

                                                        <button  id="tawjeeh" class="btn btn-primary" style="display: none">Save</button>
                                                        <input @if($next_status_id=='19')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn18" data-toggle="modal" data-target="#confirm-submit18" class="btn btn-primary btn-save" />


                                                @endif
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                                                <div class="stepwizard" id='step13'>
                                                    <div class="stepwizard-row">
                                                        <div class="stepwizard-step">
                                                            <button type="button" @if($next_status_id=='20')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>14</button>
                                                            <p>New Contract Submission</p>
                                                        </div>

                                                    </div>
                                                </div>
                            @if(isset($new_contract_sub))
                            <div class="card mb-4 watermarked" >
                               @else
                                    <div class="card mb-4 odd-card  card-hidden" id="card step13-div">
                                   @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>New Contract Submission</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '20')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('new_contract_sub') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control"   @if($next_status_id=='20')  @else readonly @endif value="{{isset($new_contract_sub)?$new_contract_sub->payment_amount:""}}"  @if(isset($new_contract_sub)) readonly @endif id="payment_amount" name="payment_amount"  type="text" placeholder="Enter Payment"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>

                                                @if(isset($new_contract_sub))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($new_contract_sub)?'disabled':""}}  @if($next_status_id=='20')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($new_contract_sub)?$new_contract_sub->payment_type:"")==$new_contract_sub->id;
                                                        @endphp
                                                        <option value="{{$new_contract_sub->payment_type}}">{{$new_contract_sub->payment->payment_type}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='20'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" @if($next_status_id=='20')  @else readonly @endif  value="{{isset($new_contract_sub)?$new_contract_sub->transaction_no:""}}"  @if(isset($new_contract_sub)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='20')  @else readonly @endif  value="{{isset($new_contract_sub)?$new_contract_sub->transaction_date_time:""}}"  @if(isset($new_contract_sub)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" @if($next_status_id=='20')  @else readonly @endif  value="{{isset($new_contract_sub)?$new_contract_sub->vat:""}}"  @if(isset($new_contract_sub)) readonly @endif id="vat" name="vat"  type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($new_contract_sub))
                                                    <br>
                                                    <a href="{{isset($new_contract_sub->attachment->attachment_name)? url($new_contract_sub->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='20')  @else disabled @endif  id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                            <div class="col-md-6 form-group">

                                                @if(isset($new_contract_sub))

                                                @else

                                                        <button  id="new_contract_sub" class="btn btn-primary" style="display: none">Save</button>
                                                        <input @if($next_status_id=='20')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn19" data-toggle="modal" data-target="#confirm-submit19" class="btn btn-primary btn-save" />


                                                @endif
                                            </div>
                                        </div><!-----row----->
                                    </form>
                                </div>
                            </div>
                                    <div class="stepwizard" id='step14'>
                                        <div class="stepwizard-row">
                                            <div class="stepwizard-step">
                                                <button type="button" @if($next_status_id=='21')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>15</button>
                                                <p>Labour Card Print</p>
                                            </div>

                                        </div>
                                    </div>
                                    @if(isset($labour_card))
                                        <div class="card mb-4 watermarked" >
                                        @else
                                         <div class="card mb-4  card-hidden" id="card step14-div">
                                        @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Labour Card Print</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '21')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('labour_card_print.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Labour Card Expiry Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='21')  @else readonly @endif
                                                value="{{isset($labour_card)?$labour_card->labour_card_expiry_date:""}}"
                                                       @if(isset($labour_card)) readonly @endif  id="transaction_date_time" name="labour_card_expiry_date"
                                                       type="text" placeholder="Enter Payment" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($labour_card))
                                                    @if($labour_card->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($labour_card->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($labour_card->visa_attachment)?url('assets/upload/LabourCardPrint/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='21')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option13"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment13" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" @if($next_status_id=='21')  @else readonly @endif  value="{{isset($labour_card)?$labour_card->payment_amount:""}}"  @if(isset($labour_card)) readonly @endif id="payment_amount" name="payment_amount"  type="text" placeholder="Enter Payment"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($labour_card))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($labour_card)?'disabled':""}}  @if($next_status_id=='21')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($labour_card)?$labour_card->payment_type:"")==$labour_card->id;
                                                        @endphp
                                                        <option value="{{isset($labour_card->payment_type)?$labour_card->payment_type:""}}">{{isset($labour_card->payment->payment_type)?$labour_card->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='21'  )  @else disabled @endif >
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" @if($next_status_id=='21')  @else readonly @endif  value="{{isset($labour_card)?$labour_card->transaction_no:""}}"  @if(isset($labour_card)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control"  @if($next_status_id=='21')  @else readonly @endif  value="{{isset($labour_card)?$labour_card->transaction_date_time:""}}"  @if(isset($labour_card)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" @if($next_status_id=='21')  @else readonly @endif  value="{{isset($labour_card)?$labour_card->vat:""}}"  @if(isset($labour_card)) readonly @endif id="vat" name="vat"  type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($labour_card))
                                                    <br>
                                                    <a href="{{isset($labour_card->attachment->attachment_name)?url($labour_card->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='21')  @else disabled @endif  id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach


                                        </div><!-------row------>
                                        <div class="col-md-3 form-group">

                                            @if(isset($labour_card))

                                            @else

                                                <button  id="labour_card" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='21')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn20" data-toggle="modal" data-target="#confirm-submit20" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                                <div class="stepwizard" id='step15'>
                                                    <div class="stepwizard-row">
                                                        <div class="stepwizard-step">
                                                            <button type="button" @if($next_status_id=='22')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>16</button>
                                                            <p>Visa Stamping Application(Urgent/Normal)</p>
                                                        </div>

                                                    </div>
                                                </div>

                             @if(isset($visa_stamp))
                              <div class="card mb-4 watermarked" >
                               @else





                                      <div class="card mb-4 odd-card  card-hidden" id="card step15-div">
                                  @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Visa Stamping Application(Urgent/Normal)</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '22')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('visa_stamp.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}


                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Payment Amount</label>
                                                <input class="form-control form-control" @if($next_status_id=='22')  @else readonly @endif  value="{{isset($visa_stamp)?$visa_stamp->payment_amount:""}}"  @if(isset($visa_stamp)) readonly @endif id="payment_amount" name="payment_amount"  type="text" placeholder="Enter Payment" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($visa_stamp))
                                                    @if($visa_stamp->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($visa_stamp->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($visa_stamp->visa_attachment)?url('assets/upload/VisaStamping/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='22')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" id="payment_option14"><span>Payment Options</span><span class="checkmark"></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="row payment_row"  id="payment14" style="display: none">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Type</label>
                                                @if(isset($visa_stamp))

                                                    <select id="payment_type" name="payment_type" class="form-control form-control"   {{isset($visa_stamp)?'disabled':""}}  @if($visa_stamp=='22')  @else disabled @endif>

                                                        @php
                                                            $isSelected=(isset($visa_stamp)?$visa_stamp->payment_type:"")==$visa_stamp->id;
                                                        @endphp
                                                        <option value="{{isset($visa_stamp->payment_type)?$visa_stamp->payment_type:""}}">{{isset($elec_pre_app->payment->payment_type)?$elec_pre_app->payment->payment_type:""}}</option>


                                                    </select>
                                                @else
                                                    <select id="payment_type" name="payment_type" class="form-control" @if($next_status_id=='22'  )  @else disabled @endif>
                                                        <option value=""  >Select option</option>
                                                        @foreach($payment_type as $pay_type)
                                                            <option value="{{ $pay_type->id }}">{{$pay_type->payment_type}}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control"  @if($next_status_id=='22')  @else readonly @endif  value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Transaction Number"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control"  @if($next_status_id=='22')  @else readonly @endif  value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="transaction_date_time" name="transaction_date_time" value=""  type="text" placeholder="Transaction Date & Time"  />
                                                <div id="datetime-1-holder"></div>                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" @if($next_status_id=='22')  @else readonly @endif  value="{{isset($visa_stamp)?$visa_stamp->vat:""}}"  @if(isset($visa_stamp)) readonly @endif id="vat" name="vat"  type="number" placeholder="Enter Vat"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($visa_stamp))
                                                    <br>
                                                    <a href="{{isset($visa_stamp->attachment->attachment_name)?url($visa_stamp->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='22')  @else readonly @endif  id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code"  />
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Fine</label>
                                                <input class="form-control form-control" @if($next_status_id=='22')  @else readonly @endif  value="{{isset($visa_stamp)?$visa_stamp->fine:""}}"  @if(isset($visa_stamp)) readonly @endif id="fine" name="fine"  type="text" placeholder="Enter Fine"  />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Type</label>

                                                @if(isset($visa_stamp))

                                                    <select id="type" name="type" class="form-control form-control"  required {{isset($visa_stamp)?'disabled':""}}>

                                                        @php
                                                            $isSelected=(isset($visa_stamp)?$visa_stamp->type:"")==$visa_stamp->id;
                                                        @endphp
                                                        @if($visa_stamp->type=="Cash")
                                                            <option value="{{$visa_stamp->type}}">Cash</option>
                                                        @else
                                                            <option value="{{$visa_stamp->type}}">Online</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="type" name="type" class="form-control"@if($next_status_id=='22')  @else disabled @endif >
                                                    <option value=""  >Select option</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="online">Online</option>
                                                </select>
                                                    @endif
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Proof</label>
                                                @if(isset($visa_stamp))
                                                    <br>
                                                    <a href="{{isset($visa_stamp->proof)?url($visa_stamp->proof):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Proof</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='22')  @else disabled @endif  id="file_name1"  name="file_name1"  type="file"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                             <!----row---------->

                                            </div>
                                        <div class="col-md-3 form-group">

                                            @if(isset($visa_stamp))

                                            @else

                                                <button  id="visa_stamp" class="btn btn-primary" style="display: none">Save</button>
                                                <input @if($next_status_id=='22')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn21" data-toggle="modal" data-target="#confirm-submit21" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                                      <div class="stepwizard" id='step16'>
                                          <div class="stepwizard-row">
                                              <div class="stepwizard-step">
                                                  <button type="button" @if($next_status_id=='23')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>17</button>
                                                  <p>Waiting For Approval(Urgent/Normal)</p>
                                              </div>

                                          </div>
                                      </div>
                                      @if(isset($approval))
                                          <div class="card mb-4 watermarked" >
                                              @else
                                                  <div class="card mb-4  card-hidden" id="card step16-div">
                                                      @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Waiting For Approval(Urgent/Normal)</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '23')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('approval') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Waiting For Approval</label>
                                                @if(isset($approval))

                                                    <select id="status" name="status" class="form-control form-control" @if($next_status_id=='23')  @else readonly @endif   required {{isset($approval)?'disabled':""}}>

                                                        @php
                                                            $isSelected=(isset($approval)?$approval->status:"")==$approval->id;
                                                        @endphp
                                                        @if($approval->status=="1")
                                                            <option value="{{$approval->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$approval->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" required @if($next_status_id=='23')  @else disabled @endif >
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($approval))
                                                    @if($approval->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($approval->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($approval->visa_attachment)?url('assets/upload/approval/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='23')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                            @foreach($pass as $ps)

                                                <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                            @endforeach

                                            <div class="col-md-6 form-group">

                                                @if(isset($approval))

                                                @else

                                                        <button  id="approval" class="btn btn-primary" style="display: none">Save</button>
                                                        <input @if($next_status_id=='23')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn22" data-toggle="modal" data-target="#confirm-submit22" class="btn btn-primary btn-save" />


                                                @endif
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                                                  <div class="stepwizard" id='step17'>
                                                      <div class="stepwizard-row">
                                                          <div class="stepwizard-step">
                                                              <button type="button" @if($next_status_id=='24')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>18</button>
                                                              <p>Waiting For Zajeel</p>
                                                          </div>

                                                      </div>
                                                  </div>
                            @if(isset($zajeel))
                             <div class="card mb-4 watermarked" >
                                @else
                                     <div class="card mb-4 odd-card  card-hidden" id="card step17-div">
                                @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Waiting For Zajeel</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '24')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif

{{--                                    action="{{isset($zajeel)?route('zajeel_update',$zajeel->id):route('zajeel')}}"--}}
                                    <form  action ="{{ route('zajeel') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Send</label>
                                                @if(isset($zajeel) and $zajeel->send=='1')

                                                    <select id="status" name="send" class="form-control form-control"  required {{isset($zajeel)?'disabled':""}} @if($next_status_id=='24')  @else disabled @endif >

                                                        @php
                                                            $isSelected=(isset($zajeel)?$zajeel->send:"")==$zajeel->id;
                                                        @endphp
                                                        @if($zajeel->send=="1")
                                                            <option value="{{$zajeel->send}}">Yes</option>
                                                        @else
                                                            <option value="{{$zajeel->send}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="send" class="form-control form-control" required @if($next_status_id=='24')  @else disabled @endif >
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($zajeel))
                                                    @if($zajeel->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($zajeel->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($zajeel->visa_attachment)?url('assets/upload/zajeel/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='24')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="repair_category">Receive</label>
                                                @if(isset($zajeel)and $zajeel->receive=='2')

                                                    <select id="status" name="receive" class="form-control form-control"  required  >

                                                        @php
                                                            $isSelected=(isset($zajeel)?$zajeel->receive:"")==$zajeel->id;
                                                        @endphp
                                                        @if($zajeel->receive=="2")
                                                            <option value="{{$zajeel->receive}}">Yes</option>
                                                        @else
                                                            <option value="{{$zajeel->receive}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="receive" class="form-control form-control" >
                                                    <option readonly="" >Select option</option>
                                                    <option value="2">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>

                                        @foreach($pass as $ps)

                                            <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                        @endforeach

                                        <div class="col-md-12 form-group">

                                            @if(isset($zajeel) ?$zajeel->receive=='2' and  $zajeel->send=='1' :"")

                                            @else

                                                    <button  id="zajeel" class="btn btn-primary" style="display: none">Save</button>
                                                    <input required   type="button" name="btn" value="Save" id="submitBtn23" data-toggle="modal" data-target="#confirm-submit23" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                                     <div class="stepwizard" id='step18'>
                                         <div class="stepwizard-row">
                                             <div class="stepwizard-step">
                                                 <button type="button" @if($next_status_id=='25')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>19</button>
                                                 <p>Visa Pasted</p>
                                             </div>

                                         </div>
                                     </div>
                                     @if(isset($visa_pasted))
                                         <div class="card mb-4 watermarked" >
                                             @else
                                                 <div class="card mb-4  card-hidden" id="card step18-div">
                                                     @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Visa Pasted</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '25')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif

                                    <form  action ="{{ route('visa_pasted') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="repair_category">Visa Pasted</label>
                                                @if(isset($visa_pasted))

                                                    <select id="status" name="status" class="form-control form-control"  required {{isset($visa_pasted)?'disabled':""}} @if($next_status_id=='25')  @else disabled @endif >

                                                        @php
                                                            $isSelected=(isset($visa_pasted)?$visa_pasted->status:"")==$visa_pasted->id;
                                                        @endphp
                                                        @if($visa_pasted->status=="1")
                                                            <option value="{{$visa_pasted->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$visa_pasted->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" required @if($next_status_id=='25')  @else disabled @endif >
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='25')  @else readonly @endif  value="{{isset($visa_pasted)?$visa_pasted->issue_date:""}}"  @if(isset($visa_pasted)) readonly @endif  id="transaction_date_time" name="issue_date"  type="text" placeholder="Enter Payment" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='25')  @else readonly @endif value="{{isset($visa_pasted)?$visa_pasted->expiry_date:""}}"  @if(isset($visa_pasted)) readonly @endif  id="transaction_date_time" name="expiry_date"  type="text" placeholder="Enter Payment" required />
                                            </div>

                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($visa_pasted))
                                                    <br>
                                                    <a href="{{isset($visa_pasted->attachment->attachment_name)?url($visa_pasted->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" id="file_name" @if($next_status_id=='25')  @else disabled @endif   name="file_name"  type="file" placeholder="Enter Country Code" required />
                                                @endif
                                            </div>



                                        @foreach($pass as $ps)

                                            <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                        @endforeach

                                        <div class="col-md-3 form-group">

                                            @if(isset($visa_pasted))

                                            @else

                                                    <button  id="visa_pasted" class="btn btn-primary" style="display: none">Save</button>
                                                    <input required @if($next_status_id=='25')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn24" data-toggle="modal" data-target="#confirm-submit24" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                                                 <div class="stepwizard" id='step19'>
                                                     <div class="stepwizard-row">
                                                         <div class="stepwizard-step">
                                                             <button type="button" @if($next_status_id=='26')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>20</button>
                                                             <p>Unique Emirates ID Received</p>
                                                         </div>

                                                     </div>
                                                 </div>

                                                 @if(isset($unique))
                                                     <div class="card mb-4 watermarked" >
                                                         @else
                                                             <div class="card mb-4 odd-card  card-hidden" id="card step19-div">
                                                                 @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Unique Emirates ID Received</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '26')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif

                                    <form  action ="{{ route('unique') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="repair_category">Unique Emirates ID Received</label>
                                                @if(isset($unique))

                                                    <select id="status" name="status" class="form-control form-control"  required {{isset($unique)?'disabled':""}}>

                                                        @php
                                                            $isSelected=(isset($unique)?$unique->status:"")==$unique->id;
                                                        @endphp
                                                        @if($unique->status=="1")
                                                            <option value="{{$unique->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$unique->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" @if($next_status_id=='26')  @else disabled @endif  required>
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='26')  @else readonly @endif  value="{{isset($unique)?$unique->issue_date:""}}"  @if(isset($unique)) readonly @endif  id="transaction_date_time" name="issue_date"  type="text" placeholder="Enter Payment" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" @if($next_status_id=='26')  @else readonly @endif  value="{{isset($unique)?$unique->expiry_date:""}}"  @if(isset($unique)) readonly @endif  id="transaction_date_time" name="expiry_date"  type="text" placeholder="Enter Payment" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"> Attachment</label>
                                                @if(isset($unique))
                                                    <br>
                                                    <a href="{{isset($unique->attachment->attachment_name)?url($unique->attachment->attachment_name):""}}" id="passport_image" target="_blank"><strong style="color: blue">View Attachment</strong></a>
                                                @else
                                                    <input class="form-control form-control" @if($next_status_id=='26')  @else disabled @endif  id="file_name"  name="file_name"  type="file" placeholder="Enter Country Code" required />
                                                @endif
                                            </div>



                                        @foreach($pass as $ps)

                                            <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                        @endforeach

                                        <div class="col-md-3 form-group">

                                            @if(isset($unique))

                                            @else

                                                    <button  id="unique" class="btn btn-primary" style="display: none">Save</button>
                                                    <input @if($next_status_id=='26')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn25" data-toggle="modal" data-target="#confirm-submit25" class="btn btn-primary btn-save" />


                                            @endif
                                        </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                                                             <div class="stepwizard" id='step20'>
                                                                 <div class="stepwizard-row">
                                                                     <div class="stepwizard-step">
                                                                         <button type="button" @if($next_status_id=='27')class="btn btn-primary btn-circle" @else class="btn btn-default btn-circle" @endif>21</button>
                                                                         <p>Unique Emirates ID Handover</p>
                                                                     </div>

                                                                 </div>
                                                             </div>

                                    @if(isset($handover))
                                        <div class="card mb-4 watermarked" >
                                         @else
                                                <div class="card mb-4  card-hidden" id="card step20-div">
                                            @endif

                                <div class="card-body">
{{--                                    <h6 class="mb-3"><strong>Unique Emirates ID Handover</strong></h6>--}}
                                    @if(isset($amount))
                                        @foreach($amount as $am)
                                            @if($am->master_step_id == '27')
                                                <p style="color: red"><strong>Amount=<span>{{ $am->amount  }}</span></strong></p>
                                            @endif
                                        @endforeach
                                    @endif
                                    <form  action ="{{ route('handover') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="repair_category">Unique Emirates ID Handover</label>
                                                @if(isset($handover))

                                                    <select  required id="status" name="status" class="form-control form-control"  {{isset($unique)?'disabled':""}} @if($next_status_id=='27')  @else disabled @endif >

                                                        @php
                                                            $isSelected=(isset($handover)?$handover->status:"")==$handover->id;
                                                        @endphp
                                                        @if($handover->status=="1")
                                                            <option value="{{$handover->status}}">Yes</option>
                                                        @else
                                                            <option value="{{$handover->status}}">No</option>
                                                        @endif

                                                    </select>
                                                @else
                                                <select id="status" name="status" class="form-control form-control" @if($next_status_id=='27')  @else disabled @endif  required>
                                                    <option readonly="" >Select option</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                    @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label for="repair_category"> Attachment</label>

                                                @if(isset($handover))
                                                    @if($handover->visa_attachment!=null)
                                                        <br>
                                                        @foreach (json_decode($handover->visa_attachment) as $visa_attach)

                                                            <a class="attachment_display" href="{{isset($handover->visa_attachment)?url('assets/upload/handover/'.$visa_attach):""}}" id="passport_image" target="_blank">
                                                                <strong style="color: blue">View Attachment</strong>
                                                            </a>
                                                            <span>|</span>

                                                        @endforeach
                                                    @endif
                                                @else
                                                    <input class="form-control form-control" id="file_name"  name="visa_attachment[]" multiple
                                                           @if($next_status_id=='27')  @else disabled @endif
                                                           type="file"  />
                                                @endif
                                            </div>

                                        @foreach($pass as $ps)

                                            <input  id="passport_id" name="passport_id" value="{{ $ps->id  }}"  type="hidden"  />

                                        @endforeach

                                        <div class="col-md-6 form-group">

                                            @if(isset($handover))

                                            @else

                                                    <button  id="handover" class="btn btn-primary" style="display: none">Save</button>
                                                    <input @if($next_status_id=='27')  @else disabled @endif type="button" name="btn" value="Save" id="submitBtn26" data-toggle="modal" data-target="#confirm-submit26" class="btn btn-primary btn-save" />


                                            @endif
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
                            <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                            <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                            <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
                            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
                            <script>

                                // $(".select2-container").css('width','100%');

                                //payment options hide and show
                                $(document).ready(function () {
                                    $('.payment_row').hide();

                                    $('#payment_option1').change(function() {
                                        if ($('#payment_option1').prop('checked')) {
                                            $('#payment1').show();
                                        } else {
                                            $('#payment1').hide();
                                        }
                                    });

                                    $('#payment_option2').change(function() {
                                        if ($('#payment_option2').prop('checked')) {
                                            $('#payment2').show();
                                        } else {
                                            $('#payment2').hide();
                                        }
                                    });

                                    $('#payment_option3').change(function() {
                                        if ($('#payment_option3').prop('checked')) {
                                            $('#payment3').show();
                                        } else {
                                            $('#payment3').hide();
                                        }
                                    });
                                    $('#payment_option4').change(function() {
                                        if ($('#payment_option4').prop('checked')) {
                                            $('#payment4').show();
                                        } else {
                                            $('#payment4').hide();
                                        }
                                    });
                                    $('#payment_option5').change(function() {
                                        if ($('#payment_option5').prop('checked')) {
                                            $('#payment5').show();
                                        } else {
                                            $('#payment5').hide();
                                        }
                                    });
                                    $('#payment_option6').change(function() {
                                        if ($('#payment_option6').prop('checked')) {
                                            $('#payment6').show();
                                        } else {
                                            $('#payment6').hide();
                                        }
                                    });
                                    $('#payment_option7').change(function() {
                                        if ($('#payment_option7').prop('checked')) {
                                            $('#payment7').show();
                                        } else {
                                            $('#payment7').hide();
                                        }
                                    });
                                    $('#payment_option8').change(function() {
                                        if ($('#payment_option8').prop('checked')) {
                                            $('#payment8').show();
                                        } else {
                                            $('#payment8').hide();
                                        }
                                    });

                                    $('#payment_option9').change(function() {
                                        if ($('#payment_option9').prop('checked')) {
                                            $('#payment9').show();
                                        } else {
                                            $('#payment9').hide();
                                        }
                                    });
                                    $('#payment_option10').change(function() {
                                        if ($('#payment_option10').prop('checked')) {
                                            $('#payment10').show();
                                        } else {
                                            $('#payment10').hide();
                                        }
                                    });
                                    $('#payment_option11').change(function() {
                                        if ($('#payment_option11').prop('checked')) {
                                            $('#payment11').show();
                                        } else {
                                            $('#payment11').hide();
                                        }
                                    });

                                    $('#payment_option12').change(function() {
                                        if ($('#payment_option12').prop('checked')) {
                                            $('#payment12').show();
                                        } else {
                                            $('#payment12').hide();
                                        }
                                    });
                                    $('#payment_option13').change(function() {
                                        if ($('#payment_option13').prop('checked')) {
                                            $('#payment13').show();
                                        } else {
                                            $('#payment13').hide();
                                        }
                                    });
                                    $('#payment_option14').change(function() {
                                        if ($('#payment_option14').prop('checked')) {
                                            $('#payment14').show();
                                        } else {
                                            $('#payment14').hide();
                                        }
                                    });
                                    $('#payment_option_app').change(function() {
                                        if ($('#payment_option_app').prop('checked')) {

                                            $('#payment_app').show();
                                        } else {
                                            $('#payment_app').hide();
                                        }
                                    });

                                });







                                $("#passport_number").change(function () {
                                    $("#unique_div").css('display','block');
                                    var passport_id = $(this).val();

                                    var token = $("input[name='_token']").val();
                                    $.ajax({
                                        url: "{{ route('ajax_get_passport') }}",
                                        method: 'POST',
                                        data: {passport_id: passport_id, _token:token},
                                        success: function(response) {

                                            var res = response.split('$');
                                            $("#sur_name").html(res[0]);
                                            $("#given_names").html(res[1]);
                                            $("#passport_image").attr('href',res[2]);
                                            $("#exp_days").html(res[3]);

                                            $("#pic_div").show();
                                            $("#exp_div").show();


                                        }
                                    });

                                });
                            </script>

                        <script>
                            $(document).on('click', '#submit-btn', function() {
                                var comment = $("#comment").val();
                                var data = $('#mainForm').serialize()+ "&comment="+comment;
                                console.log(data);
                            });
                        </script>



                            <script>



                                    $('#passport_number').select2({
                                        placeholder: 'Select an option'
                                    });
                                    $('#company').select2({
                                        placeholder: 'Select an option'
                                    });

                                    tail.Date("#date_and_time",{
                                        dateFormat: "YYYY-mm-dd",
                                        timeFormat: false,

                                    }).on("change", function(){
                                        tail.Date("#date_and_time",{
                                            dateStart: $('#date_and_time').val(),
                                            dateFormat: "YYYY-mm-dd",
                                            timeFormat: false

                                        }).reload();

                                    });
                                    </script>
                    <script>

                                    tail.Date("#elec_issue_date",{
                                        dateFormat: "YYYY-mm-dd",
                                        timeFormat: false,

                                    }).on("change", function(){
                                        tail.Date("#elec_issue_date",{
                                            dateStart: $('#elec_expiry_date').val(),
                                            dateFormat: "YYYY-mm-dd",
                                            timeFormat: false

                                        }).reload();

                                    });

                                    tail.Date("#elec_expiry_date",{
                                        dateFormat: "YYYY-mm-dd",
                                        timeFormat: false,

                                    }).on("change", function(){
                                        tail.DateTime("#elec_expiry_date",{
                                            dateStart: $('#elec_issue_date').val(),
                                            dateFormat: "YYYY-mm-dd",
                                            timeFormat: false

                                        }).reload();

                                    });
                                </script>

                    <script>
                        tail.DateTime("#visa_issue_date",{
                            dateFormat: "YYYY-mm-dd",
                            timeFormat: false,

                        }).on("change", function(){
                            tail.DateTime("#visa_issue_date",{
                                dateStart: $('#visa_issue_date').val(),
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false

                            }).reload();

                        });
                    </script>
                        <script>
                        tail.DateTime("#visa_expiry_date",{
                            dateFormat: "YYYY-mm-dd",
                            timeFormat: false,

                        }).on("change", function(){
                            tail.DateTime("#visa_expiry_date",{
                                dateStart: $('#visa_expiry_date').val(),
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false

                            }).reload();

                        });
                        </script>
                        <script>
                            tail.DateTime("#transaction_date_time", {
                                static: "#datetime-1-holder",
                                classNames: "theme-default",
                                startOpen: false,
                                stayOpen: false,
                                timeFormat: false
                            });
                            tail.DateTime("#offer_date_and_time", {
                                static: "#datetime-2-holder",
                                classNames: "theme-default",
                                startOpen: false,
                                stayOpen: false,
                                timeFormat: false
                            });

                        </script>


                        <script>
                            //electronic pre approval


                            //status change
                            tail.DateTime("#entry_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#entry_date",{
                                    dateStart: $('#entry_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });
                            tail.DateTime("#expiry_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#expiry_date",{
                                    dateStart: $('#expiry_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });

                        </script>
                        <script>

                            // Entry Print Visa Inside
                            tail.DateTime("#outside_entry_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#outside_entry_date",{
                                    dateStart: $('#outside_entry_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });
                        </script>

                        <script>

                            // Entry Print Visa Inside
                            tail.DateTime("#visa_outside_entry_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#visa_outside_entry_date",{
                                    dateStart: $('#visa_outside_entry_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });
                        </script>

                        <script>

                            // Medical
                            tail.DateTime("#medical_date_time",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#medical_date_time",{
                                    dateStart: $('#medical_date_time').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });
                        </script>

                        <script>
                            $('#submit').click(function(){
                                $("#sb_btn").click();
                            });
                            $('#submit2').click(function(){
                                $("#offer_letter_sub").click();
                            });
                            $('#submit3').click(function(){
                                $("#elec_pre_approval").click();
                            });
                            $('#submit5').click(function(){
                                $("#visa_print_inside").click();
                            });
                            $('#submit6').click(function(){
                                $("#visa_print_outside").click();
                            });
                            $('#submit7').click(function(){
                                $("#status_change_form").click();
                            });
                            $('#submit8').click(function(){
                                $("#inout_status").click();
                            });
                            $('#submit9').click(function(){
                                $("#entry_date_form").click();
                            });
                            $('#submit10').click(function(){
                                $("#med_normal").click();
                            });
                            $('#submit11').click(function(){
                                $("#med_48").click();
                            });
                            $('#submit12').click(function(){
                                $("#med_24").click();
                            });
                            $('#submit13').click(function(){
                                $("#med_vip").click();
                            });
                            $('#submit14').click(function(){
                                $("#fit_unfit").click();
                            });
                            $('#submit15').click(function(){
                                $("#e_app").click();
                            });
                            $('#submit16').click(function(){
                                $("#e_finger_print").click();
                            });
                            $('#submit17').click(function(){
                                $("#new_contract").click();
                            });
                            $('#submit18').click(function(){
                                $("#tawjeeh").click();
                            });
                            $('#submit19').click(function(){
                                $("#new_contract_sub").click();
                            });
                            $('#submit20').click(function(){
                                $("#labour_card").click();
                            });
                            $('#submit21').click(function(){
                                $("#visa_stamp").click();
                            });
                            $('#submit22').click(function(){
                                $("#approval").click();
                            });
                            $('#submit23').click(function(){
                                $("#zajeel").click();
                            });
                            $('#submit24').click(function(){
                                $("#visa_pasted").click();
                            });
                            $('#submit25').click(function(){
                                $("#unique").click();
                            });
                            $('#submit26').click(function(){
                                $("#handover").click();
                            });
                            $('#submit27').click(function(){
                                $("#elec_pre_approval_pay").click();
                            });
                        </script>

                    {{-- @if($employee_type == '3')
                        <script>
                            $(document).ready(function() {
                                $(".card-hidden").hide();
                            });
                        </script>
                    @endif --}}
                <script>
                    $(document).ready(function() {
                        $(".entry_print_inside").show();
                        $(".entry_print_outside").hide();
                    });

                    $("#print_inside").change(function () {
                        $(".entry_print_inside").show();
                        $(".entry_print_outside").hide();
                    });


                        $("#print_outside").change(function () {
                            $(".entry_print_inside").hide();
                            $(".entry_print_outside").show();
                        });

                        //---------------------------------------

                    $(document).ready(function() {
                        $(".status_change1").hide();
                        $(".in-out_status1").hide();
                    });
                        $("#status_change").change(function () {
                        $(".status_change1").show();
                        $(".in-out_status1").hide();
                    });


                        $("#in-out_status").change(function () {
                            $(".in-out_status1").show();
                            $(".status_change1").hide();
                        });
                    //-----------------------------------------------
                    $(document).ready(function() {
                        $(".medical_normal").hide();
                        $(".medical_48").hide();
                        $(".medical_24").hide();
                        $(".medical_vip").hide();
                    });


                    $("#medical").change(function () {
                        var med_val = ($('#medical').val());

                        if(med_val=='medical_normal'){
                            $(".medical_normal").show();
                            $(".medical_48").hide();
                            $(".medical_24").hide();
                            $(".medical_vip").hide();
                        }

                         else if(med_val=='medical_48'){
                            $(".medical_normal").hide();
                            $(".medical_48").show();
                            $(".medical_24").hide();
                            $(".medical_vip").hide();
                        }
                        else if(med_val=='medical_24'){
                            $(".medical_normal").hide();
                            $(".medical_48").hide();
                            $(".medical_24").show();
                            $(".medical_vip").hide();
                        }
                        else{
                            $(".medical_normal").hide();
                            $(".medical_48").hide();
                            $(".medical_24").hide();
                            $(".medical_vip").show();
                        }
                    });
                </script>

                                                     <script>
                                                         $(document).ready(function(){
                                                             $("#print_inside_click").change(function(){
                                                                 //

                                                                 $("#inside_value").text("Inside");

                                                                 $("#status_value").val("0");

                                                             });
                                                             $("#print_outside_click").change(function(){
                                                                 //
                                                                 $("#inside_value").text("Outside");
                                                                 $("#status_value").val("1");
                                                             });
                                                         });

                                                     </script>
                                                     <?php
                                                    if(isset($visa_status_own)=='1'){
                                                        ?>
                                                        <script>


                                                    $("#hide_if_own").hide();
                                                    // $("#step6").hide();
                                                    // $("#step7").hide();
                                                    // $("#step8").hide();
                                                    // $("#step9").hide();
                                                    // $("#step10").hide();
                                                    // $("#step11").hide();
                                                    // $("#step12").hide();
                                                    // $("#step13").hide();
                                                    // $("#step14").hide();
                                                    // $("#step15").hide();
                                                    // $("#step16").hide();
                                                    // $("#step17").hide();
                                                    // $("#step18").hide();
                                                    // $("#step19").hide();
                                                    // $("#step20").hide();

                                                    // $("#step5-div").hide();
                                                    // $("#step6-div").hide();
                                                    // $("#step7-div").hide();
                                                    // $("#step9-div").hide();
                                                    // $("#step10-div").hide();
                                                    // $("#step11-div").hide();
                                                    // $("#step12-div").hide();
                                                    // $("#step13-div").hide();
                                                    // $("#step14-div").hide();
                                                    // $("#step15-div").hide();
                                                    // $("#step16-div").hide();
                                                    // $("#step17-div").hide();
                                                    // $("#step18-div").hide();
                                                    // $("#step19-div").hide();
                                                    // $("#step20-div").hide();






                                                        </script>

                                                        <?php
                                                    }

                                                     ?>



                            <script type="text/javascript">
                                function submitform() {   document.myform.submit(); }
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
