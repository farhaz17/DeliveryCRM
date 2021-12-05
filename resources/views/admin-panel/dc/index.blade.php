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
            <li><a href="">All Dc Request</a></li>
            <li>Dc Request</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered table-sm text-10" id="datatable_not_employee">
                        <thead >
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Rider Name</th>
                            <th scope="col">Checkout Date & Time</th>
                            <th scope="col">Checkout Type</th>
                            <th scope="col">Status</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $ab)
                        <tr>
                            <td>{{ $ab->id }}</td>
                            <td>{{ $ab->rider_name->personal_info->full_name }}</td>
                            <td>{{ $ab->checkout_date_time }}</td>
                            <td>{{ $checkout_type_array[$ab->checkout_type] }}</td>
                            <td>{{ $status_array[$ab->request_status] }}</td>
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
            'use-strict'

            $('#datatable_not_employee').DataTable( {

                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},

                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
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

    <script>
        function tostr_display(type,message){


            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }

        }
    </script>







@endsection
