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
        #datatable2 .table th, .table td{
            border-top : unset !important;
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
            <li><a href="">Ar Balance Balance</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-sm-12">


            <div class="row ticket-row">

                <div class="col-md-3">
                    <div class="card card-icon mb-4 ticket-card">
                        <div class="card-body text-center"><i class="i-Wallet"></i>
                            <p class="text-muted mt-2 mb-2">Total Balance</p>
                            <p class="lead text-22 m-0">{{$ar_balance->sum('balance')}}</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card card-icon mb-4 ticket-card">
                        <div class="card-body text-center"><i class="i-Dollar-Sign"></i>
                            <p class="text-muted mt-2 mb-2"> Total Deduction</p>
                            <p class="lead text-22 m-0">{{$ar_balance->sum('deduction')}}</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card card-icon mb-4 ticket-card">
                        <div class="card-body text-center"><i class="i-Money"></i>
                            <p class="text-muted mt-2 mb-2">Total Advance Added</p>
                            <p class="lead text-22 m-0">{{$ar_balance_sheet->where('status','0')->sum('balance')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-icon mb-4 ticket-card">
                        <div class="card-body text-center"><i class="i-Money-2"></i>
                            <p class="text-muted mt-2 mb-2">Total Advance Deducted</p>
                            <p class="lead text-22 m-0">{{$ar_balance_sheet->where('status','1')->sum('balance')}}</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                <p>Total Balance= <span>{{$ar_balance->sum('balance')}}</span></p>--}}
{{--                <p>Total Deduction= <span>{{$ar_balance->sum('deduction')}}</span></p>--}}
{{--                <p>Total Advance Added= <span>{{$ar_balance_sheet->where('status','0')->sum('balance')}}</span></p>--}}
{{--                <p>Total Advance Deducted= <span>{{$ar_balance_sheet->where('status','1')->sum('balance')}}</span></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>


    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">






    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5>A/R Balance By Date</h5>

                            <table class="table table-striped  table-dark text-15  text-center dataTable no-footer" role="grid" aria-describedby="sales_table_info">
                                <tr style="background: #663399">
                                    <th>Date</th>
                                    <th>Balance</th>

                                </tr>
                                @foreach($balance_date as $date)
                                    <tr>
                                        <td>{{$date->date}}</td>
                                        <td>{{$date->total_balance}}</td>


                                    </tr>
                                @endforeach
                            </table>

                            </div>
                        <div class="col-lg-6">
                            <h5>A/R Balance By Platform</h5>

                            <?php $platform_total_balance =  0;
                                  $platform_total_current_balance =  0; ?>

                            <table class="table table-striped  table-dark text-15  text-center dataTable no-footer" role="grid" aria-describedby="sales_table_info">
                                <tr style="background: #663399">
                                    <th>Platform</th>
                                    <th>Agreed Amount</th>
                                    <th>Cash Received</th>
                                    <th>Discount</th>
                                    <th>Deduction</th>
                                    <th>Balance</th>
                                    <th>Current Balance</th>

                                </tr>
                                @foreach($platform_balance as $res)
                                    <tr>
                                        <td>{{$res['platform']}}</td>
                                        <td>{{$res['agreed_amount']}}</td>
                                        <td>{{$res['cash_received']}}</td>
                                        <td>{{$res['discount']}}</td>
                                        <td>{{$res['deduction']}}</td>
                                        <td>{{$res['balance']}}</td>
                                        <td>{{$res['current_balance']}}</td>
                                        @php
                                            $platform_total_balance = $platform_total_balance+$res['balance'];
                                            $platform_total_current_balance = $platform_total_current_balance+$res['current_balance'];
                                        @endphp



                                    </tr>
                                @endforeach
                            </table>
                            <table class="table table-striped  table-dark text-15">
                                <tr>
                                    <th> Others Balance</th> <td>{{$ar_balance->sum('balance')-$platform_total_balance}}</td>
                                </tr>
                                <tr>
                                    <th> Others Current Balance</th> <td>{{$current_balance_sheet-$platform_total_current_balance}}</td>
                                </tr>

                            </table>


                        </div>
                    </div>
                        </div>




                    </div>



                    {{------------------------------------------table matched----------------------------------------}}


{{--            ----------------------------------balance edit model---------------------------}}













                        @endsection
                    @section('js')
                        <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
                        <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>



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
                                    "scrollY": true,
                                    "scrollX": true,
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
                        `

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
