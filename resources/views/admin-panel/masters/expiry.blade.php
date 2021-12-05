@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
        a#passport-icon-tab {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab {
            width: 350px;
            text-align: center;
        }

        a#passport-icon-tab-t1 {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab-t1 {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab-t1 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t1 {
            width: 350px;
            text-align: center;
        }

        a#passport-icon-tab-t2 {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab-t2 {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab-t2 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t3 {
            width: 350px;
            text-align: center;
        }
        a#passport-icon-tab-t3 {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab-t3 {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab-t3 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t3 {
            width: 350px;
            text-align: center;
        }

        a#Emirates-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#passport-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t4 {
            width: 350px;
            text-align: center;
        }
        a#passport-icon-tab-t5 {
            width: 350px;
            text-align: center;
        }
        a#driving-icon-tab-t5 {
            width: 350px;
            text-align: center;
        }
        a#bikes-icon-tab-t5 {
            width: 350px;
            text-align: center;
        }
        a#Emirates-icon-tab-t5 {
            width: 350px;
            text-align: center;
        }
        .card.mb-4 {
            border: 1px solid;
        }




    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Master</a></li>
            <li>Expiry Details</li>
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





    <div class="col-md-12 mb-3">




        <div class="card text-left">
            <div class="card-body">
                {{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true">
                            <i class="nav-icon i-Calendar-4"></i> {{$current_month}}</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#first_month" role="tab" aria-controls="first_month" aria-selected="false">
                            <i class="nav-icon i-Calendar-4 mr-1"></i>{{$first_month}}</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#second_month" role="tab" aria-controls="second_month" aria-selected="false">
                            <i class="nav-icon i-Calendar-4 mr-1"></i>{{$second_month}}</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#third_month" role="tab" aria-controls="third_month" aria-selected="false">
                            <i class="nav-icon i-Calendar-4 mr-1"></i>{{$third_month}}</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#fourth_month" role="tab" aria-controls="fourth_month" aria-selected="false">
                            <i class="nav-icon i-Calendar-4 mr-1"></i>{{$fourth_month}}</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#fifth_month" role="tab" aria-controls="taking_visa" aria-selected="false">
                            <i class="nav-icon i-Calendar-4 mr-1"></i>{{$fifth_month}}</a></li>
                </ul>
                <di class="tab-content" id="myIconTabContent">

{{--                    --------table 1-------------}}
{{--                    --------table 1-------------}}
                    <div class="tab-pane fade show active" id="not_employee" role="tabpanel" aria-labelledby="home-icon-tab">


                        <ul class="nav nav-pills" id="myIconTab2" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="passport-icon-tab" data-toggle="tab" href="#passports" role="tab" aria-controls="not_employee" aria-selected="true">
                                    <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="driving-icon-tab" data-toggle="tab" href="#driving" role="tab" aria-controls="taking_visa" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="bikes-icon-tab" data-toggle="tab" href="#bikes" role="tab" aria-controls="taking_visa" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab" data-toggle="tab" href="#emirates" role="tab" aria-controls="taking_visa" aria-selected="false">
                                    <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                        </ul>




                        <div class="tab-content" id="myIconTabContent_passport">


{{--                            tab1 nested tab1--}}

                            <div class="tab-pane fade show active" id="passports" role="tabpanel" aria-labelledby="home-icon-tab">

{{--                                <div class="card mb-12">--}}
{{--                                    <div class="card-body">--}}
                                <div class="row">
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


                                </div>

                            </div>
                            {{--                            tab1 nested tab1 ends here--}}


                            {{--                            tab1 nested tab2--}}
                            <div class="tab-pane fade" id="driving" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_licese_expiry)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Driving License Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($driving_licese_expiry as $driving)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving->passport->passport_no}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Licence No</b>:&nbsp;{{$driving->license_number}}
                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>ZDS Code</b>:&nbsp;{{isset($driving->passport->zds_code)?$driving->passport->zds_code->zds_code:"N/A"}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Traffic Code</b>:&nbsp;{{isset($driving->traffic_code)?$driving->traffic_code:"N/A"}}
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                       @php
                                                              $expiry_date=$driving->expire_date;
                                                               $dt = new DateTime($expiry_date);


                                                           @endphp
                                                        <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                    </p>
                                                    <small  style="color: #0a0d1e">{{isset($driving->passport->personal_info)?$driving->passport->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>
                            </div>

{{--                            tab1 nested tab2 ends here--}}

                            {{--                            tab1 nested tab3--}}

                            <div class="tab-pane fade" id="bikes" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_licese_expiry)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Bikes License Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($bike_expiry as $bike)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike->plate_no}}

                                                    <b>Traffic File No</b>:&nbsp;{{isset($bike->traffic_file)?$bike->traffic_file:"N/A"}}
                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>Chassis No</b>:&nbsp;{{$bike->chassis_no}}
                                                    </h6>
                                                        <h6 class="mb-3">
                                                        <b>Category Type</b>:&nbsp;
                                                        @if($bike->category_type=='0')
                                                       Company
                                                            @else
                                                        Lease
                                                            @endif
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        <i class="i-Calendar-4"></i> {{$bike->expiry_date}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>
                            </div>
                            {{--                            tab1 nested tab3 ends here--}}
                            {{--                            tab1 nested tab4--}}

                            <div class="tab-pane fade" id="emirates" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($emirates_id_expiry)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Emirates ID Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($emirates_id_expiry as $emirates)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates->passport->passport_no }}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>ZDS Code</b>:&nbsp;{{isset($emirates->passport->zds_code)?$emirates->passport->zds_code->zds_code:"N/A"}}


                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>Emirates ID</b>:&nbsp;{{$emirates->card_no}}


                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        @php
                                                            $expiry_date=$emirates->expire_date;
                                                             $dt = new DateTime($expiry_date);


                                                        @endphp
                                                        <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                    </p>
                                                    <small>{{isset($emirates->passport->personal_info)?$emirates->passport->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>

                            {{--                            tab1 nested tab4 ends here--}}

                        </div>

                    </div>
                    </div>
                    {{--                    --------table 1 ends here-------------}}
                    {{--                    --------table 1 ends here-------------}}


                    {{--                    --------table 2 -------------}}
                    {{--                    --------table 2 -------------}}

                    <div class="tab-pane fade" id="first_month" role="tabpanel" aria-labelledby="home-icon-tab">

                            <ul class="nav nav-pills" id="myIconTab-t1" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="passport-icon-tab-t1" data-toggle="tab" href="#passports-t1" role="tab" aria-controls="passports-t1" aria-selected="true">
                                        <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                                <li class="nav-item"><a class="nav-link" id="driving-icon-tab-t1" data-toggle="tab" href="#driving-t1" role="tab" aria-controls="driving-t1" aria-selected="false">
                                        <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                                <li class="nav-item"><a class="nav-link" id="bikes-icon-tab-t1" data-toggle="tab" href="#bikes-t1" role="tab" aria-controls="bikes-t1" aria-selected="false">
                                        <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                                <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab-t1" data-toggle="tab" href="#emirates-t1" role="tab" aria-controls="emirates-t1" aria-selected="false">
                                        <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                            </ul>

{{--tab2 nested tab1--}}
                     <div class="tab-content" id="myIconTabContent_passport-t1">
                       <div class="tab-pane fade show active" id="passports-t1" role="tabpanel" aria-labelledby="home-icon-tab">

                            {{--                                <div class="card mb-12">--}}
                            {{--                                    <div class="card-body">--}}
                            <div class="row">
                                @if(count($passport_first_month)=='0')
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <h4><span class="badge badge-info">No Passport Expiring</span></h4>
                                    </div>
                                    <div class="col-md-4">
                                    </div>

                                @else
                                @foreach($passport_first_month as $passport1)
                                    <div class="col-md-3">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$passport1->passport_no}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b>PPUID</b>:&nbsp;{{$passport1->pp_uid}} </h6>

                                                <h6 class="mb-3">
                                                    <b>ZDS Code</b>:&nbsp;{{isset($passport1->zds_code->zds_code)?$passport1->zds_code->zds_code:"N/A"}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b>Nationality</b>:&nbsp;{{isset($passport1->nation->name)?$passport1->nation->name:"N/A"}}
                                                </h6>
                                                <p class="text-16 text-danger  line-height-1 mb-3">
                                                    <i class="i-Calendar-4"></i> {{$passport1->date_expiry}}
                                                </p>
                                                <small  style="color: #0a0d1e">{{isset($passport1->personal_info)?$passport1->personal_info->full_name:""}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif



                            </div>

                        </div>
{{--                        tab2 nested tab2--}}
                        <div class="tab-pane fade" id="driving-t1" role="tabpanel" aria-labelledby="home-icon-tab">

                            <div class="row">
                                @if(count($driving_first_month)=='0')
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <h4><span class="badge badge-info">No Driving License Expiring</span></h4>
                                    </div>
                                    <div class="col-md-4">
                                    </div>

                                @else
                                @foreach($driving_first_month as $driving1)
                                    <div class="col-md-3">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving1->passport->passport_no}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b>Licence No</b>:&nbsp;{{$driving1->license_number}}
                                                </h6>

                                                <h6 class="mb-3">
                                                    <b>ZDS Code</b>:&nbsp;{{isset($driving1->passport->zds_code)?$driving1->passport->zds_code->zds_code:"N/A"}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b>Traffic Code</b>:&nbsp;{{isset($driving1->traffic_code)?$driving1->traffic_code:"N/A"}}
                                                </h6>
                                                <p class="text-16 text-danger  line-height-1 mb-3">
                                                    @php
                                                        $expiry_date=$driving1->expire_date;
                                                         $dt = new DateTime($expiry_date);


                                                    @endphp
                                                    <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                </p>
                                                <small>{{isset($driving1->passport->personal_info)?$driving1->passport->personal_info->full_name:""}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif


                            </div>
                        </div>

{{--                        tab2 nested tab3--}}
                        <div class="tab-pane fade" id="bikes-t1" role="tabpanel" aria-labelledby="home-icon-tab">

                            <div class="row">
                                @if(count($bike_first_month)=='0')
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <h4><span class="badge badge-info">No Bike Expiring</span></h4>
                                    </div>
                                    <div class="col-md-4">
                                    </div>

                                @else
                                @foreach($bike_first_month as $bike1)
                                    <div class="col-md-3">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike1->plate_no}}

                                                    <b>Traffic File No</b>:&nbsp;{{isset($bike1->traffic_file)?$bike1->traffic_file:"N/A"}}
                                                </h6>

                                                <h6 class="mb-3">
                                                    <b>Chassis No</b>:&nbsp;{{$bike1->chassis_no}}
                                                </h6>
                                                <h6 class="mb-3">
                                                    <b>Category Type</b>:&nbsp;
                                                    @if($bike1->category_type=='0')
                                                        Company
                                                    @else
                                                        Lease
                                                    @endif
                                                </h6>
                                                <p class="text-16 text-danger  line-height-1 mb-3">
                                                    <i class="i-Calendar-4"></i> {{$bike1->expiry_date}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif


                            </div>
                        </div>

{{--                        tab2 nested tab4--}}

                        <div class="tab-pane fade" id="emirates-t1" role="tabpanel" aria-labelledby="home-icon-tab">

                            <div class="row">
                                @if(count($emirates_id_first_month)=='0')
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <h4><span class="badge badge-info">No Emirates ID Expiring</span></h4>
                                    </div>
                                    <div class="col-md-4">
                                    </div>

                                @else
                                @foreach($emirates_id_first_month as $emirates1)
                                    <div class="col-md-3">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates1->passport->passport_no }}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b>ZDS Code</b>:&nbsp;{{isset($emirates1->passport->zds_code)?$emirates1->passport->zds_code->zds_code:"N/A"}}


                                                </h6>

                                                <h6 class="mb-3">
                                                    <b>Emirates ID</b>:&nbsp;{{$emirates1->card_no}}


                                                </h6>
                                                <p class="text-16 text-danger  line-height-1 mb-3">
                                                    @php
                                                        $expiry_date=$emirates1->expire_date;
                                                         $dt = new DateTime($expiry_date);


                                                    @endphp
                                                    <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                </p>
                                                <small  style="color: #0a0d1e">{{isset($emirates1->passport->personal_info)?$emirates1->passport->personal_info->full_name:""}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @endif


                            </div>

                            {{--                            tab1 nested tab4 ends here--}}

                        </div>
                   </div>






                  </div>


                    {{--                    --------table 2 ends here -------------}}
                    {{--                    --------table 2 ends here -------------}}


                    {{--                    --------table 3 -------------}}
                    {{--                    --------table 3 -------------}}

                    <div class="tab-pane fade" id="second_month" role="tabpanel" aria-labelledby="home-icon-tab">

                        <ul class="nav nav-pills" id="myIconTab-t2" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="passport-icon-tab-t2" data-toggle="tab" href="#passports-t2" role="tab" aria-controls="passports-t1" aria-selected="true">
                                    <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="driving-icon-tab-t2" data-toggle="tab" href="#driving-t2" role="tab" aria-controls="driving-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="bikes-icon-tab-t2" data-toggle="tab" href="#bikes-t2" role="tab" aria-controls="bikes-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab-t2" data-toggle="tab" href="#emirates-t2" role="tab" aria-controls="emirates-t1" aria-selected="false">
                                    <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                        </ul>


                        <div class="tab-content" id="myIconTabContent_passport-t2">
                            <div class="tab-pane fade show active" id="passports-t2" role="tabpanel" aria-labelledby="home-icon-tab">

                                {{--                                <div class="card mb-12">--}}
                                {{--                                    <div class="card-body">--}}
                                <div class="row">
                                    @if(count($passport_sec_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Passport Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($passport_sec_month as $passport2)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$passport2->passport_no}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>PPUID</b>:&nbsp;{{$passport2->pp_uid}} </h6>

                                                    <h6 class="mb-3">
                                                        <b>ZDS Code</b>:&nbsp;{{isset($passport2->zds_code->zds_code)?$passport2->zds_code->zds_code:"N/A"}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Nationality</b>:&nbsp;{{isset($passport2->nation->name)?$passport2->nation->name:"N/A"}}
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        <i class="i-Calendar-4"></i> {{$passport2->date_expiry}}
                                                    </p>
                                                    <small  style="color: #0a0d1e">{{isset($passport2->personal_info)?$passport2->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>

                            </div>
                            {{--                        tab2 nested tab2--}}
                            <div class="tab-pane fade" id="driving-t2" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_sec_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Driving Expiring
                                                </span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                    @foreach($driving_sec_month as $driving2)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving2->passport->passport_no}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Licence No</b>:&nbsp;{{$driving2->license_number}}
                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>ZDS Code</b>:&nbsp;{{isset($driving2->passport->zds_code)?$driving2->passport->zds_code->zds_code:"N/A"}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b style="color:#663399">Traffic Code</b>:&nbsp;{{isset($driving2->traffic_code)?$driving2->traffic_code:"N/A"}}
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        @php
                                                            $expiry_date=$driving2->expire_date;
                                                             $dt = new DateTime($expiry_date);


                                                        @endphp
                                                        <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                    </p>
                                                    <small  style="color: #0a0d1e">{{isset($driving2->passport->personal_info)?$driving2->passport->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab3--}}
                            <div class="tab-pane fade" id="bikes-t2" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">

                                    @if(count($bike_sec_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Bikes Expiring
                                                </span>
                                            </h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else

                                    @foreach($bike_sec_month as $bike2)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike2->plate_no}}

                                                        <b>Traffic File No</b>:&nbsp;{{isset($bike2->traffic_file)?$bike2->traffic_file:"N/A"}}
                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>Chassis No</b>:&nbsp;{{$bike2->chassis_no}}
                                                    </h6>
                                                    <h6 class="mb-3">
                                                        <b>Category Type</b>:&nbsp;
                                                        @if($bike2->category_type=='0')
                                                            Company
                                                        @else
                                                            Lease
                                                        @endif
                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        <i class="i-Calendar-4"></i> {{$bike2->expiry_date}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab4--}}

                            <div class="tab-pane fade" id="emirates-t2" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($emirates_id_sec_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4> <span class="badge badge-info">No Emirates Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else


                                    @foreach($emirates_id_sec_month as $emirates2)
                                        <div class="col-md-3">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates2->passport->passport_no }}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>ZDS Code</b>:&nbsp;{{isset($emirates2->passport->zds_code)?$emirates2->passport->zds_code->zds_code:"N/A"}}


                                                    </h6>

                                                    <h6 class="mb-3">
                                                        <b>Emirates ID</b>:&nbsp;{{$emirates2->card_no}}


                                                    </h6>
                                                    <p class="text-16 text-danger  line-height-1 mb-3">
                                                        @php
                                                            $expiry_date=$emirates2->expire_date;
                                                             $dt = new DateTime($expiry_date);


                                                        @endphp
                                                        <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                    </p>
                                                    <small  style="color: #0a0d1e">{{isset($emirates2->passport->personal_info)?$emirates2->passport->personal_info->full_name:""}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif


                                </div>

                                {{--                            tab1 nested tab4 ends here--}}

                            </div>
                        </div>




                    </div>
                    {{--                    --------table 3 ends here -------------}}
                    {{--                    --------table 3ends here -------------}}

                    {{--                    --------table 4 -------------}}
                    {{--                    --------table 4 -------------}}

                    <div class="tab-pane fade" id="third_month" role="tabpanel" aria-labelledby="home-icon-tab">

                        <ul class="nav nav-pills" id="myIconTab-t3" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="passport-icon-tab-t3" data-toggle="tab" href="#passports-t3" role="tab" aria-controls="passports-t1" aria-selected="true">
                                    <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="driving-icon-tab-t3" data-toggle="tab" href="#driving-t3" role="tab" aria-controls="driving-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="bikes-icon-tab-t3" data-toggle="tab" href="#bikes-t3" role="tab" aria-controls="bikes-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab-t3" data-toggle="tab" href="#emirates-t3" role="tab" aria-controls="emirates-t1" aria-selected="false">
                                    <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                        </ul>

                        <div class="tab-content" id="myIconTabContent_passport-t3">
                            <div class="tab-pane fade show active" id="passports-t3" role="tabpanel" aria-labelledby="home-icon-tab">

                                {{--                                <div class="card mb-12">--}}
                                {{--                                    <div class="card-body">--}}
                                <div class="row">
                                    @if(count($passport_third_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Passport Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($passport_third_month as $passport3)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$passport3->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>PPUID</b>:&nbsp;{{$passport3->pp_uid}} </h6>

                                                        <h6 class="mb-3">
                                                            <b>ZDS Code</b>:&nbsp;{{isset($passport3->zds_code->zds_code)?$passport3->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b style="color:#663399">Nationality</b>:&nbsp;{{isset($passport3->nation->name)?$passport3->nation->name:"N/A"}}
                                                        </h6>
                                                        <p class="text-20 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$passport3->date_expiry}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($passport3->personal_info)?$passport3->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                            </div>
                            {{--                        tab2 nested tab2--}}
                            <div class="tab-pane fade" id="driving-t3" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_third_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Driving Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($driving_third_month as $driving3)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving3->passport->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Licence No</b>:&nbsp;{{$driving3->license_number}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>ZDS Code</b>:&nbsp;{{isset($driving3->passport->zds_code)?$driving3->passport->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Traffic Code</b>:&nbsp;{{isset($driving3->traffic_code)?$driving3->traffic_code:"N/A"}}
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$driving3->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($driving3->passport->personal_info)?$driving3->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab3--}}
                            <div class="tab-pane fade" id="bikes-t3" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">

                                    @if(count($bike_third_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4> <span class="badge badge-info">No Bikes Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else

                                        @foreach($bike_third_month as $bike3)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike3->plate_no}}

                                                            <b>Traffic File No</b>:&nbsp;{{isset($bike3->traffic_file)?$bike3->traffic_file:"N/A"}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Chassis No</b>:&nbsp;{{$bike3->chassis_no}}
                                                        </h6>
                                                        <h6 class="mb-3">
                                                            <b>Category Type</b>:&nbsp;
                                                            @if($bike3->category_type=='0')
                                                                Company
                                                            @else
                                                                Lease
                                                            @endif
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$bike3->expiry_date}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab4--}}

                            <div class="tab-pane fade" id="emirates-t3" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($emirates_third_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Emirates ID Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else


                                        @foreach($emirates_third_month as $emirates3)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates3->passport->passport_no }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>ZDS Code</b>:&nbsp;{{isset($emirates3->passport->zds_code)?$emirates3->passport->zds_code->zds_code:"N/A"}}


                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Emirates ID</b>:&nbsp;{{$emirates3->card_no}}


                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$emirates3->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($emirates3->passport->personal_info)?$emirates3->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                                {{--                            tab1 nested tab4 ends here--}}

                            </div>
                        </div>


                    </div>

                    {{--                    --------table 4 ends here -------------}}
                    {{--                    --------table 4 ends her -------------}}


                    {{--                    --------table 5 -------------}}
                    {{--                    --------table 5 -------------}}



                    <div class="tab-pane fade" id="fourth_month" role="tabpanel" aria-labelledby="home-icon-tab">

                        <ul class="nav nav-pills" id="myIconTab-t4" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="passport-icon-tab-t4" data-toggle="tab" href="#passports-t4" role="tab" aria-controls="passports-t1" aria-selected="true">
                                    <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="driving-icon-tab-t4" data-toggle="tab" href="#driving-t4" role="tab" aria-controls="driving-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="bikes-icon-tab-t4" data-toggle="tab" href="#bikes-t4" role="tab" aria-controls="bikes-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab-t4" data-toggle="tab" href="#emirates-t4" role="tab" aria-controls="emirates-t1" aria-selected="false">
                                    <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                        </ul>

                        <div class="tab-content" id="myIconTabContent_passport-t4">
                            <div class="tab-pane fade show active" id="passports-t4" role="tabpanel" aria-labelledby="home-icon-tab">

                                {{--                                <div class="card mb-12">--}}
                                {{--                                    <div class="card-body">--}}
                                <div class="row">
                                    @if(count($passport_fourth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4> <span class="badge badge-info">No Passport Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($passport_fourth_month as $passport4)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$passport4->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>PPUID</b>:&nbsp;{{$passport4->pp_uid}} </h6>

                                                        <h6 class="mb-3">
                                                            <b>ZDS Code</b>:&nbsp;{{isset($passport4->zds_code->zds_code)?$passport4->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Nationality</b>:&nbsp;{{isset($passport4->nation->name)?$passport4->nation->name:"N/A"}}
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$passport4->date_expiry}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($passport4->personal_info)?$passport4->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                            </div>
                            {{--                        tab2 nested tab2--}}
                            <div class="tab-pane fade" id="driving-t4" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_fourth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <br>
                                            <h4><span class="badge badge-info">No Driving Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($driving_fourth_month as $driving4)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving4->passport->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Licence No</b>:&nbsp;{{$driving4->license_number}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>ZDS Code</b>:&nbsp;{{isset($driving4->passport->zds_code)?$driving4->passport->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Traffic Code</b>:&nbsp;{{isset($driving4->traffic_code)?$driving4->traffic_code:"N/A"}}
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$driving4->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($driving4->passport->personal_info)?$driving4->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab3--}}
                            <div class="tab-pane fade" id="bikes-t4" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">

                                    @if(count($bike_fourth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4> <span class="badge badge-info">No Bike  Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else

                                        @foreach($bike_fourth_month as $bike4)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike4->plate_no}}

                                                            <b>Traffic File No</b>:&nbsp;{{isset($bike4->traffic_file)?$bike4->traffic_file:"N/A"}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Chassis No</b>:&nbsp;{{$bike4->chassis_no}}
                                                        </h6>
                                                        <h6 class="mb-3">
                                                            <b>Category Type</b>:&nbsp;
                                                            @if($bike4->category_type=='0')
                                                                Company
                                                            @else
                                                                Lease
                                                            @endif
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$bike4->expiry_date}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab4--}}

                            <div class="tab-pane fade" id="emirates-t4" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($emirates_fourth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4> <span class="badge badge-info">No Emirates Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else


                                        @foreach($emirates_fourth_month as $emirates4)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates4->passport->passport_no }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>ZDS Code</b>:&nbsp;{{isset($emirates4->passport->zds_code)?$emirates4->passport->zds_code->zds_code:"N/A"}}


                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Emirates ID</b>:&nbsp;{{$emirates4->card_no}}


                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$emirates4->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($emirates4->passport->personal_info)?$emirates4->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                                {{--                            tab1 nested tab4 ends here--}}

                            </div>
                        </div>
                    </div>

                    {{--                    --------table 5 ends here -------------}}
                    {{--                    --------table 5 ends here -------------}}



                    {{--                    --------table 6 -------------}}
                    {{--                    --------table 6 -------------}}

                    <div class="tab-pane fade" id="fifth_month" role="tabpanel" aria-labelledby="home-icon-tab">

                        <ul class="nav nav-pills" id="myIconTab-t5" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="passport-icon-tab-t5" data-toggle="tab" href="#passports-t5" role="tab" aria-controls="passports-t1" aria-selected="true">
                                    <i class="nav-icon  mr-1"></i>Passports Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="driving-icon-tab-t5" data-toggle="tab" href="#driving-t5" role="tab" aria-controls="driving-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Driving License Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="bikes-icon-tab-t5" data-toggle="tab" href="#bikes-t5" role="tab" aria-controls="bikes-t1" aria-selected="false">
                                    <i class="nav-icon mr-1"></i>Bikes Expiry</a></li>
                            <li class="nav-item"><a class="nav-link" id="Emirates-icon-tab-t5" data-toggle="tab" href="#emirates-t5" role="tab" aria-controls="emirates-t1" aria-selected="false">
                                    <i class="nav-icon  mr-1"></i>Emirates ID Expiry</a></li>

                        </ul>

                        <div class="tab-content" id="myIconTabContent_passport-t5">
                            <div class="tab-pane fade show active" id="passports-t5" role="tabpanel" aria-labelledby="home-icon-tab">

                                {{--                                <div class="card mb-12">--}}
                                {{--                                    <div class="card-body">--}}
                                <div class="row">
                                    @if(count($passport_fifth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Passport Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($passport_fifth_month as $passport5)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$passport5->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b style="color: #003473">PPUID</b>:&nbsp;{{$passport5->pp_uid}} </h6>

                                                        <h6 class="mb-3">
                                                            <b >ZDS Code</b>:&nbsp;{{isset($passport5->zds_code->zds_code)?$passport5->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Nationality</b>:&nbsp;{{isset($passport5->nation->name)?$passport5->nation->name:"N/A"}}
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$passport5->date_expiry}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($passport5->personal_info)?$passport5->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                            </div>
                            {{--                        tab2 nested tab2--}}
                            <div class="tab-pane fade" id="driving-t5" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($driving_fifth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Driving Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else
                                        @foreach($driving_fifth_month as $driving5)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$driving5->passport->passport_no}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>Licence No</b>:&nbsp;{{$driving5->license_number}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>ZDS Code</b>:&nbsp;{{isset($driving5->passport->zds_code)?$driving5->passport->zds_code->zds_code:"N/A"}}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b style="color:#663399">Traffic Code</b>:&nbsp;{{isset($driving5->traffic_code)?$driving5->traffic_code:"N/A"}}
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$driving5->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($driving5->passport->personal_info)?$driving5->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab3--}}
                            <div class="tab-pane fade" id="bikes-t5" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">

                                    @if(count($bike_fifth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Bike  Expiring</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else

                                        @foreach($bike_fifth_month as $bike5)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Plate No</b>:&nbsp;{{$bike5->plate_no}}

                                                            <b>Traffic File No</b>:&nbsp;{{isset($bike5->traffic_file)?$bike5->traffic_file:"N/A"}}
                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Chassis No</b>:&nbsp;{{$bike5->chassis_no}}
                                                        </h6>
                                                        <h6 class="mb-3">
                                                            <b>Category Type</b>:&nbsp;
                                                            @if($bike5->category_type=='0')
                                                                Company
                                                            @else
                                                                Lease
                                                            @endif
                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            <i class="i-Calendar-4"></i> {{$bike5->expiry_date}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            {{--                        tab2 nested tab4--}}

                            <div class="tab-pane fade" id="emirates-t5" role="tabpanel" aria-labelledby="home-icon-tab">

                                <div class="row">
                                    @if(count($emirates_fifth_month)=='0')
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <h4><span class="badge badge-info">No Emirates ID Expiring </span></h4>

                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                    @else


                                        @foreach($emirates_fifth_month as $emirates5)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h6 class="mb-3"><b>Passport No</b>:&nbsp;{{$emirates5->passport->passport_no }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <b>ZDS Code</b>:&nbsp;{{isset($emirates5->passport->zds_code)?$emirates5->passport->zds_code->zds_code:"N/A"}}


                                                        </h6>

                                                        <h6 class="mb-3">
                                                            <b>Emirates ID</b>:&nbsp;{{$emirates5->card_no}}


                                                        </h6>
                                                        <p class="text-16 text-danger  line-height-1 mb-3">
                                                            @php
                                                                $expiry_date=$emirates5->expire_date;
                                                                 $dt = new DateTime($expiry_date);


                                                            @endphp
                                                            <i class="i-Calendar-4"></i> {{$dt->format('Y-m-d')}}
                                                        </p>
                                                        <small  style="color: #0a0d1e">{{isset($emirates5->passport->personal_info)?$emirates5->passport->personal_info->full_name:""}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                                {{--                            tab1 nested tab4 ends here--}}

                            </div>
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
