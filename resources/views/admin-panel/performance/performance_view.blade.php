@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Performance</a></li>
            <li>View Performance</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            {{--                            <th scope="col">#</th>--}}
                            <th scope="col" >Dates</th>
                            <th scope="col" >Total</th>
                            <th scope="col">View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($date_ranges as $date_range)
                            <tr>
                                <td> {{$date_range->date_from}}&nbsp;&nbsp;<b>-</b> &nbsp;&nbsp;{{$date_range->date_to}}</td>
                                <td>{{count($total_number->where('date_from',$date_range->date_from))}}</td>
                                <td>
                                    <a class="text-success mr-2 view_performance" href="{{route('performance.show',$date_range->date_from)}}">
                                        <i class="nav-icon i-Add-Window font-weight-bold"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg settings" id="bike_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Settings</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="all-detail">


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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<!---->
<!--{{--    <script>--}}-->
<!--{{--        $(document).ready(function () {--}}-->
<!---->
<!---->
<!--{{--            $(".view_performance").click(function(){--}}-->
<!--{{--                var date_from = $(this).attr('id');--}}-->
<!--{{--                var token = $("input[name='_token']").val();--}}-->
<!---->
<!--{{--                $.ajax({--}}-->
<!--{{--                    url: "{{ route('show_deliveroo_performance') }}",--}}-->
<!--{{--                    method: 'POST',--}}-->
<!--{{--                    dataType: 'json',--}}-->
<!--{{--                    data: {_token: token, date_from:date_from},--}}-->
<!--{{--                    success: function (response) {--}}-->
<!--{{--                        $('#all-detail').empty();--}}-->
<!--{{--                        $('#all-detail').append(response.html);--}}-->
<!--{{--                        $('.settings').modal('show');--}}-->
<!---->
<!--{{--                    }});--}}-->
<!--{{--            });--}}-->
<!---->
<!---->
<!---->
<!--{{--        });--}}-->


    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    {"targets": [0],"width": "50%"}
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
