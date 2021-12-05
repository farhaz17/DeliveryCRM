@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
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

    .footer-text{
        color:#ffffff;

    }
</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Salary Sheet</a></li>
        <li>Uber Limo Salary Sheet Search</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>




<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <div class="talabat_table">
                    <h4 class="card-title mb-3 text-center"> <span class="text-primary font-weight-bold">Uber Limo</span> Salary Sheet</h4>
                    <table class="display table table-striped" id="datatable" width="100%">
                        <thead class="thead-dark">
                        <tr class="show-table">
                            <th scope="col">Driver UID</th>
                            <th scope="col">Trip UID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Timestamp</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Desclaimer</th>
                            <th scope="col">Date From</th>
                            <th scope="col">Date To</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uber_limo_file as $res)
                        <tr>
                            <td>{{ $res->driver_u_uid}}</td>
                            <td>{{ $res->trip_u_uid}}</td>
                            <td>{{ $res->first_name}}</td>
                            <td>{{ $res->last_name}}</td>
                            <td>{{ $res->amount}}</td>
                            <td>{{ $res->timestamp}}</td>
                            <td>{{ $res->item_type}}</td>
                            <td>{{ $res->description}}</td>
                            <td>{{ $res->disclaimer}}</td>
                            <td>{{ $res->date_from}}</td>
                            <td>{{ $res->date_to}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot width="100%">
                        <tr>
                            <th  class="footer-text"> total Driver UID</th>
                            <th class="footer-text">Trip UIDTrip UIDTrip UID</th>
                            <th  class="footer-text">First NameFirst NameFirst Name</th>
                            <th class="footer-text">Last NameLast NameLast Name</th>
                            <th  ><b>Total</b>={{$uber_limo_file->sum('amount')}}</th>
                            <th  class="footer-text">TimestampTimestampTimestamp</th>
                            <th class="footer-text">Item TypeItem TypeItem Type</th>
                            <th  class="footer-text">DescriptionDescriptionDescription</th>
                            <th  class="footer-text">DesclaimerDesclaimerDesclaimer</th>
                            <th  class="footer-text">DateDateDateDate From</th>
                            <th  class="footer-text">DateDateDateDate To</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <br>

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
    $(document).ready(function () {
        $(window).scroll(function() {
            if ( $(window).scrollTop() >= 5 ) {
                $('.layout-sidebar-large .main-header').css('z-index', '-1');

            } else {
                $('.layout-sidebar-large .main-header').css('z-index', '100');
            }
        });
        'use strict';
        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,

            "scrollY": true,
            "scrollX": true,
            fixedHeader: {
                header: true,
                footer: true,
                autoWidth: false,
            }

        });



        tail.DateTime("#dob",{
            dateFormat: "dd-mm-YYYY",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#dob",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_issue",{
            dateFormat: "dd-mm-YYYY",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_expiry",{
                dateStart: $('#date_issue').val(),
                dateFormat: "dd-mm-YYYY",
                timeFormat: false

            }).reload();

        });

        tail.DateTime("#date_expiry",{
            dateFormat: "dd-mm-YYYY",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_expiry",{
                dateStart: $('#date_issue').val(),
                dateFormat: "dd-mm-YYYY",
                timeFormat: false

            }).reload();

        });


    });


</script>

<script>
    $('#next-btn').click(function(){
        $("#profile-basic-tab").click();
    });


    $('#next-btn-2').click(function(){
        $("#contact-basic-tab").click();
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
