@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<style>
    .radio {
        margin-bottom : 3px;
    }
    .card-title {
        font-size: 0.75rem;
        margin-bottom: 0.2rem;
    }
    .error{
        color: #ee2200 !important;
    }
</style>
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">All Reports</a></li>
        <li>Fuel Reports</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12">
    <div class="card">
        <div class="card-body">

            <form method="post" action="{{ url('/daily_fuel_report') }}" >
                {!! csrf_field() !!}
                <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label for="repair_category">Report By</label>
                    <select id="report_by" name="report_by" class="form-control form-control">
                        <option value="">Select</option>
                        <option value="1">Daily</option>
                        <option value="2">Weekly</option>
                        <option value="3">Monthly</option>
                        <option value="4">Date Search</option>
                    </select>
                </div>

                <div class="col-md-4 form-group mb-3" id="daily_date_input" style="display: inline">
                    <label for="repair_category">Date</label>
                    <input class="form-control" id="daily_date" type="date" name="daily_date"/>
                </div>

<!--                    for weekly-->
                    <div class="col-md-12 form-group mb-3">
                        <button class="btn btn-primary">Search</button>
                </div>



                </div>
            </form>
        </div>
    </div>
</div>
<!-----------------daily report Show----------------->
<!-----------------daily report Show----------------->
<!-----------------daily report Show----------------->
<div class="col-md-12 mb-3" id="daily_report"  style="display: none">
    <div class="card text-left">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Pending ({{isset($fuel_daily_report_pending) ? $fuel_daily_report_pending->count() : '0'  }})</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Approved ({{isset($fuel_daily_report_approve) ? $fuel_daily_report_approve->count() : '0'  }})</a></li>
                <li class="nav-item"><a class="nav-link" id="rejected-basic-tab" data-toggle="tab" href="#rejectedBasic" role="tab" aria-controls="rejectedBasic" aria-selected="false">Rejected ({{isset($fuel_daily_report_rejected) ? $fuel_daily_report_rejected->count() : '0'  }})</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable_career">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Amount</th>
                                <th scope="col">image</th>
                                <th scope="col">Rider Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($fuel_daily_report_pending))
                            @foreach($fuel_daily_report_pending as $fuel)
                            <tr>

                                <span style="display: none"  id="bike-{{$fuel->id}}">{{trim($fuel->passport->assign_bike_check()?$fuel->passport->assign_bike_check()->bike_plate_number->plate_no:"N/A")}}</span>
                                <span style="display: none"  id="sim-{{$fuel->id}}">{{$fuel->passport->assign_sim_check()?$fuel->passport->assign_sim_check()->telecome->account_number:"N/A"}}</span>

                                <th scope="row">{{ $fuel->id  }}</th>
                                <td>{{ $fuel->created_at->toDateString()  }}</td>
                                <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
                                <td><a  id="image-{{ $fuel->id }}" href="{{ url($fuel->image) }}" target="_blank">See Image</a></td>
                                <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
                                <td>Pending</td>
                                <td>
                                    <a class="text-success mr-2 edit_cls" id="{{ $fuel->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                </td>

                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                <!---------------------tab1 ends here-------------->
                <!---------------------tab2-------------->

                <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable_career_referals">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Amount</th>
                                <th scope="col">image</th>
                                <th scope="col">Rider Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Approved By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($fuel_daily_report_approve))
                            @foreach($fuel_daily_report_approve as $fuel)
                            <tr>
                                <th scope="row">{{ $fuel->id  }}</th>
                                <td>{{ $fuel->created_at->toDateString()  }}</td>
                                <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
                                <td><a href="{{ url($fuel->image) }}" target="_blank">See Image</a></td>
                                <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
                                <td>Approved</td>
                                <td>{{ isset($fuel->action_user_by->name) ? $fuel->action_user_by->name : 'N/A'  }}</td>

                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="rejectedBasic" role="tabpanel" aria-labelledby="rejected-basic-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable_rejected">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Amount</th>
                                <th scope="col">image</th>
                                <th scope="col">Rider Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Reject By</th>
                                <th scope="col">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($fuel_daily_report_rejected))
                            @foreach($fuel_daily_report_rejected as $fuel)
                            <tr>
                                <th scope="row">{{ $fuel->id  }}</th>
                                <td>{{ $fuel->created_at->toDateString()  }}</td>
                                <td id="amount-{{ $fuel->id }}">{{ $fuel->amount  }}</td>
                                <td><a href="{{ url($fuel->image) }}" target="_blank">See Image</a></td>
                                <td id="name-{{ $fuel->id }}">{{ $fuel->passport->personal_info->full_name }}</td>
                                <td>Rejected</td>
                                <td>{{ isset($fuel->action_user_by->name) ? $fuel->action_user_by->name : 'N/A'  }}</td>
                                <td>
                                    @if($fuel->remarks=='1')
                                    <span class="badge badge-danger m-2">Wrong Vehicle</span>
                                    @elseif($fuel->remarks=='2')
                                    @else
                                    <span class="badge badge-danger m-2">Wrong Date</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<!-----------------daily report ends here----------------->
<!-----------------daily report ends here----------------->
<!-----------------daily report ends here--------------->

<!-----------------weekly report----------------->


@if(isset($week1) )
<div class="col-md-12 mb-3" id="weekly_report" style="display: none">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-striped table-bordered" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Week</th>
                        <th scope="col">Number Of fuels</th>
                        <th scope="col">View</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>{{ $week1 }}- {{$week0}}</td>
                        <td>20</td>
                        <td>View</td>
                    </tr>
                    <tr>
                        <td>{{ $week2 }}- {{$week1}}</td>
                        <td>20</td>
                        <td>View</td>
                    </tr>
                    <tr>
                        <td>{{ $week2 }}- {{$week2}}</td>
                        <td>20</td>
                        <td>View</td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
<!-----------------weekly report ends here----------------->








@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
</script>
<script sr="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script sr="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>

<script>
    $("#report_by").change(function () {

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


@if(isset($week1) )
<script>
    $('#daily_report').hide();
    $('#weekly_report').show();

</script>
@endif

@if(isset($fuel_daily_report_pending))
<script>
    $('#weekly_report').hide();
    $('#daily_report').show();
</script>
@endif

<script>

    $(document).ready(function () {
        'use strict';

        $('#datatable_career, #datatable_career_referals, #datatable_rejected').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
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
        "scrollY": false,
    });

        $('#category').select2({
            placeholder: 'Select an option'
        });

    });

    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('id'); // get current tab

            var split_ab = currentTab;
            // alert(split_ab[1]);

            if(split_ab=="home-basic-tab"){

                var table = $('#datatable_career').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }else if(split_ab=="profile-basic-tab"){
                var table = $('#datatable_career_referals').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }else if(split_ab=="rejected-basic-tab"){
                var table = $('#datatable_rejected').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();

            }


        }) ;
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
