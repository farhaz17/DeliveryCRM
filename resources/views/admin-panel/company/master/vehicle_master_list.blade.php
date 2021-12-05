@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Bikes Master</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped text-10" id="datatable" style="width:100%">
                        <thead class="thead-dark">
                        <tr style="white-space: nowrap; font-size: 14px;">
                            <th scope="col">#</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Plate Code</th>
                            <th scope="col">Model</th>
                            <th scope="col">Make Year</th>
                            <th scope="col">Chassis no</th>
                            {{--                                <th scope="col">Mortgaged by</th>--}}
                            <th scope="col">Insurance Company</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Issue Date</th>
                            <th scope="col">Traffic File No</th>
                            <th scope="col">Category Type</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bike_detail as $bike)
                            <tr style="white-space: nowrap; font-size: 14px;">
                                <th scope="row">1</th>
                                <td>{{$bike->plate_no}}</td>
                                <td>{{$bike->plate_code->plate_code ?? "" }}</td>
                                <td>{{$bike->model->name ?? ""}}</td>
                                <td>{{$bike->make_year}}</td>
                                <td>{{$bike->chassis_no}}</td>
                                {{--                                    <td>{{$bike->mortgaged_by}}</td>--}}
                                <td>{{$bike->insurance_co}}</td>
                                <td>{{$bike->expiry_date}}</td>
                                <td>{{$bike->issue_date}}</td>
                                <td>{{$bike->traffic_file}}</td>

                                @if($bike->category_type == '0')
                                    <td>Company</td>
                                @elseif($bike->category_type == '1')
                                    <td>Lease</td>
                                @elseif($bike->category_type == '2')
                                    <td>Click Deliver</td>
                                @elseif($bike->category_type == '3')
                                    <td>Deliveroo</td>
                                @else
                                    <td>Other</td>
                                @endif

                                <td style="white-space: nowrap">
                                    <a class="text-success mr-2" href="{{route('bikedetail_edit2',$bike->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                    {{--                                        <a class="text-success mr-2 bike_history" id="{{$bike->id}}" href="#"><i class="nav-icon i-File font-weight-bold"></i></a>--}}
                                    <a class="text-primary mr-2 renew_btn_cls" id="{{$bike->id}}" href="javascript:void(0)"><i class="nav-icon i-Add-Window font-weight-bold"></i></a>
                                    <a class="text-danger mr-2 renew_btn_cls-1" id="{{$bike->id}}" href="javascript:void(0)"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });

            // tail.DateTime("#issue_date",{
            //     dateFormat: "dd-mm-YYYY",
            //     timeFormat: false,

            // }).on("change", function(){
            //     tail.DateTime("#issue_date",{
            //         dateStart: $('#start_tail').val(),
            //         dateFormat: "YYYY-mm-dd",
            //         timeFormat: false
            //     }).reload();
            // });
            // tail.DateTime("#expiry_date",{
            //     dateFormat: "dd-mm-YYYY",
            //     timeFormat: false,
            // }).on("change", function(){
            //     tail.DateTime("#expiry_date",{
            //         dateStart: $('#start_tail').val(),
            //         dateFormat: "YYYY-mm-dd",
            //         timeFormat: false
            //     }).reload();
            // });
        });

    </script>

    <script>
        $(".status").change(function(){
            if($(this).prop("checked") == true){
                var id = $(this).attr('id');
                var token = $("input[name='_token']").val();
                var status = '0';
                $.ajax({
                    url: "{{ route('update_issue_dep') }}",
                    method: 'POST',
                    data: {id: id, _token:token,status:status},
                    success: function(response) {

                    }
                });

            }else{
                var id = $(this).attr('id');
                var token = $("input[name='_token']").val();
                var status = '1';
                $.ajax({
                    url: "{{ route('update_issue_dep') }}",
                    method: 'POST',
                    data: {id: id, _token:token,status:status},
                    success: function(response) {

                    }
                });

            }
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
