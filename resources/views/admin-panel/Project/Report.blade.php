@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

<style>
    .card.mb-4 {
            border: 1px solid;
        }
        .submit-btn {
    margin-top: 24px;
        }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
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
        font-weight: 600;
    }


</style>


@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Master</a></li>
            <li>Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="loader-bubble loader-bubble-primary m-5"></div>
                <div class="loader-bubble loader-bubble-danger m-5" ></div>
                <div class="loader-bubble loader-bubble-success m-5" ></div>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="col-md-8 mb-3" style="margin:0 auto;"><br>
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Project Name</th>
                                <th scope="col">Total Invoice</th>
                                <th scope="col">Total Amount</th>
                                {{-- <th scope="col">Cash Credit</th>
                                <th scope="col">Amount</th> --}}
                                {{-- <th scope="col">Project</th> --}}
                                {{-- <th scope="col">Invoice</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project as $row)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$row->project_name}}</td>
                                    <td>{{count($invoice->where('project_id',$row->id))}}</td>
                                    <td>{{$invoice->where('project_id',$row->id)->sum('amount')}}</td>
                                    {{-- <td>{{$row->cash_credit}}</td>
                                    <td>{{$row->amount}}</td>
                                    {{-- <td>{{$row->project_names->project_name}}</td> --}}
                                    {{-- <td>  <a class="attachment_display" href="{{ isset($row->invoice_image) ? url($row->invoice_image) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Invoice</strong></a></td> --}}

                                    {{-- <td>
                                        <a class="text-success mr-2" href="{{route('project.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a> --}}
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


    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card mb-">
                <div class="card-body">
                    <div class="card-title mb-3">Project Report</div>
                    <div class="row">

                        @foreach($project as $row)

                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3"><b >Project Name:</b>&nbsp;{{$row->project_name}}</h5>

                                <h5 class="mb-3">
                                    <b>Total Invoice:</b> {{count($invoice->where('project_id',$row->id))}}<br>
                                    <b>Total Amount:</b><b style="color: red;"> {{$invoice->where('project_id',$row->id)->sum('amount')}}</b>
                                </h5>

                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>



                </div>
            </div>
        </div>
    </div> --}}




                        {{-- <div class="tab-content" id="myIconTabContent_passport"> --}}


{{--                            tab1 nested tab1--}}

                            {{-- <div class="tab-pane fade show active" id="passports" role="tabpanel" aria-labelledby="home-icon-tab"> --}}

{{--                                <div class="card mb-12">--}}
{{--                                    <div class="card-body">--}}
                                {{-- <div class="row">
                                    @if(count($passport_expiry)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Passport Expiring
                                                </span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($passport_expiry as $passport)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b >Passport No</b>:&nbsp;{{$passport->passport_no}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b >PPUID</b>:&nbsp;{{$passport->pp_uid}} </h6>

                                                    <h6 class="mb-3">
                                                        <b>ZDS Code</b>:&nbsp;{{isset($passport->zds_code->zds_code)?$passport->zds_code->zds_code:"N/A"}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Nationality</b>:&nbsp;{{isset($passport->nation->name)?$passport->nation->name:"N/A"}}
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        <i class="i-Calendar-4"></i> {{$passport->date_expiry}}
                                                    </p>
                                                    <small  style="color: #0a0d1e">{{isset($passport->personal_info)?$passport->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div> --}}




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

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
                "scrollY": false,
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
