@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&family=Roboto+Slab:wght@900&display=swap" rel="stylesheet">
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
       @font-face {
            font-family: Digital-7;
            src:url("{{'assets/fonts/iconsmind/digital-7.ttf'}}");
            font-weight: 700
        }

        .text-attr-digit {
            font-size: 50px;
            font-weight: 900;
            color: #000;
            font-family: Digital-7
        }

        .text-attr-platform {
            font-size: 12px;
            font-weight: 700
        }

        .text-attr-platform2 {
            font-size: 7px;
            font-weight: 800
        }

        img.title_imag-icon {
            height: 30px;
            width: 30px;
            max-width: 300px
        }

        .card.card-profile-1.mb-4 {
            height: 80px;
            line-height: 5px;
            margin-left: 5px;
            margin-top: 3px;
            border-radius: 5px;
            border: 1px solid #bfbfbf
        }

        p.text-attr-title.font-weight-bold {
            font-size: 16px;
            text-align: center;
            font-family: Roboto Slab
        }

        p.text-attr {
            font-size: 16px;
            font-weight: 700
        }

        @media only screen and (min-device-width:375px) and (max-device-width:667px) and (orientation :portrait) {
            p.text-attr-title.font-weight-bold {
                font-size: 24px;
                position: relative;
                top: -59px;
                left: 20%
            }
            p.text-attr {
                font-size: 20px;
                position: relative;
                top: -56px;
                left: 20%
            }
        }

        @media only screen and (min-width:411px) and (max-width:767px) {
            p.text-attr-title.font-weight-bold {
                font-size: 24px;
                position: relative;
                top: -59px;
                left: 20%
            }
            p.text-attr {
                font-size: 20px;
                position: relative;
                top: -56px;
                left: 20%
            }
        }

        @media only screen and (min-device-width :768px) and (max-device-width :1024px) and (orientation :portrait) {
            img.title_imag-icon {
                height: 35px;
                width: 35px;
                max-width: 300px
            }
            .card.card-profile-1.mb-4 {
                width: 183px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px
            }
            p.text-attr-title.font-weight-bold {
                font-size: 15px
            }
            p.text-attr {
                font-size: 13px
            }
            p.text-attr-title.font-weight-bold {
                font-size: 15px;
                position: relative;
                top: -33px;
                left: 20%
            }
            p.text-attr.ml-4 {
                position: relative;
                top: -34px;
                left: 22%
            }
        }

        @media only screen and (min-device-width :1100px) and (max-device-width :1200px) {
            .card.card-profile-1.mb-4 {
                width: 153px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf
            }
            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                left: -27%;
                white-space: nowrap
            }
            p.text-attr {
                font-size: 18px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px
            }
        }

        @media only screen and (min-device-width :1200px) and (max-device-width :1300px) {
            .card.card-profile-1.mb-4 {
                width: 165px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf
            }
            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                left: -27%;
                white-space: nowrap
            }
            p.text-attr {
                font-size: 14px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
                white-space: nowrap
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px
            }
            .text-attr-platform {
                font-size: 10px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 33px;
                white-space: nowrap
            }
            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px
            }
        }

        @media only screen and (min-device-width :1301px) and (max-device-width :1400px) {
            .card.card-profile-1.mb-4 {
                width: 180px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf
            }
            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                left: -27%;
                white-space: nowrap
            }
            p.text-attr {
                font-size: 16px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
                white-space: nowrap
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px
            }
            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px
            }
            .text-attr-platform {
                font-size: 10px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 33px;
                white-space: nowrap
            }
            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px
            }
        }

        @media only screen and (min-device-width :1401px) and (max-device-width :1500px) {
            .card.card-profile-1.mb-4 {
                width: 188px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf
            }
            p.text-attr-title.font-weight-bold {
                font-size: 20px;
                position: relative;
                left: -27%;
                white-space: nowrap
            }
            p.text-attr {
                font-size: 16px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 37px;
                white-space: nowrap
            }
            .text-attr-digit {
                font-size: 40px;
                font-weight: 900;
                color: #000;
                font-family: Digital-7;
                position: relative;
                top: -47px;
                left: 39px
            }
            .text-attr-platform {
                font-size: 12px;
                font-weight: 700;
                position: relative;
                top: -45px;
                left: 35px;
                white-space: nowrap
            }
            .text-attr-platform2 {
                font-size: 7px;
                font-weight: 800;
                position: relative;
                top: -45px;
                left: 33px
            }
        }

        @media only screen and (min-device-width :1501px) and (max-device-width :1600px) {
            .card.card-profile-1.mb-4 {
                width: 200px;
                height: 80px;
                line-height: 5px;
                margin-left: 5px;
                margin-top: 3px;
                border-radius: 5px;
                border: 1px solid #bfbfbf
            }
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rider Attendances</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-12 row m-auto">
            <div class="card-body">
                <div class="row row-xs">
                    <div class="col-md-3 offset-2">
                        <select name="dc_id" id="dc_id" class="form-control form-control-sm select2">
                            <option value="">Select DC</option>
                            @foreach ($dc_list as $dc)
                                <option {{ $dc_list->count() == 1 ? "selected" : ""  }} value="{{ $dc->id }}">{{ $dc->name ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control form-control-sm" type="text" id="performance_date" placeholder="Select Date" value="{{ $last_performance_date ?? date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        {{-- <button class="btn btn-primary btn-block btn-sm">Filter <i class="i-Magnifi-Glass1 mt-2"></i></button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row m-auto">
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title font-weight-bold mt-3 ml-4">Platform </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title font-weight-bold mt-3 ml-4">Present </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title ml-4 font-weight-bold mt-3">
                                    Absent
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title font-weight-bold mt-3 ml-4">Orders </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title font-weight-bold mt-3 ml-4">Total Riders </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-10">
                                <p class="text-attr-title font-weight-bold mt-3 ml-4">Riders(MSP)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row m-auto" id="attendance_table_holder">
            @foreach($platform_att as $row)
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2 bg-left" >
                                <img class="title_imag-icon" src = "{{ get_platform_icon_url($row['platform_id']) }}" alt="icon">
                            </div>
                            <div class="col-sm-10">
                                <p  @if($row['platform_id']=='9'||$row['platform_id']=='22'||$row['platform_id']=='25'||$row['platform_id']=='19'||$row['platform_id']=='18'||$row['platform_id']=='23')
                                    class="text-attr-platform ml-4 mt-4"
                                    @elseif($row['platform_id']=='24'||$row['platform_id']=='17')
                                    class="text-attr-platform2 ml-4 mt-4"
                                    @else
                                    class="text-attr ml-4 mt-4" @endif >{{$row['platform']}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/yes_sir.png" alt="icon"></div>
                            <div class="col-sm-10">
                                <p class="text-attr-digit ml-4 mt-4" style="color: green">{{$row['present']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/delete-user.png" alt="icon"></div>
                            <div class="col-sm-10">
                                <p class="text-attr-digit ml-4 mt-4" style="color: red">{{$row['absent']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/order-food.png" alt="icon"></div>
                            <div class="col-sm-10">
                                <p class="text-attr-digit ml-4 mt-4" style="font-size: x-large;">{{$row['orders']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/bike.png" alt="icon"></div>
                            <div class="col-sm-10">
                                <p class="text-attr-digit ml-4 mt-4">{{$row['total_rider']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------->
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-profile-1 mb-4 mr-1">
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/day.png" alt="icon"></div>
                            <div class="col-sm-10">
                                <p class="text-attr-digit ml-4 mt-4">{{$row['as_per_system_total_rider']}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: "Select Dc to filter"
        });
    </script>
    <script>
    //     tail.DateTime("#end_date",{
    //        dateFormat: "YYYY-mm-dd",
    //        timeFormat: false
    //    })
        tail.DateTime("#performance_date",{
           dateFormat: "YYYY-mm-dd",
           timeFormat: false,
            // startOpen: true,
       })
    //    .on("change", function(){
    //        tail.DateTime("#end_date",{
    //            dateStart: $('#start_date').val(),
    //            dateFormat: "YYYY-mm-dd",
    //            timeFormat: false
    //        }).reload();
    //    });
   </script>
   <script>
       $('#performance_date, #dc_id').change(function(){
        $('body').addClass('loading');
        var performance_date = $('#performance_date').val();
        var dc_id = $('#dc_id').val();
           $.ajax({
               url: "{{ route('ajax_rider_attendance_report') }}",
               method:"GET",
               data:{performance_date, dc_id},
               success: function(response){
                    $('body').removeClass('loading')
                    $('#attendance_table_holder').empty();
                    $('#attendance_table_holder').append(response.html);
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
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
                }
            }
    </script>
@endsection
