@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Total Current Vehilce</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>







    <!--------Passport Additional Information--------->


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                        <table class="table" id="datatable" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Plate Number</th>
                                <th scope="col">Plate Code</th>
                                <th scope="col">Model</th>
                                <th scope="col">Make Year</th>
                                <th scope="col">Chassis no</th>
                                <th scope="col">Insurance Company</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Issue Date</th>
                                <th scope="col">Traffic File No</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($total_current_vehilce as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{isset($row->plate_no)?$row->plate_no:""}}</td>
                                    <td>{{isset($row->plate_code)?$row->plate_code:""}}</td>
                                    <td>{{isset($row->model)?$row->model:""}}</td>
                                    <td>{{isset($row->make_year)?$row->make_year:""}}</td>
                                    <td>{{isset($row->chassis_no)? $row->chassis_no:""}}</td>
                                    <td>{{isset($row->insurance_co)?$row->insurance_co:""}}</td>
                                    <td>{{isset($row->expiry_date)?$row->expiry_date:""}}</td>
                                    <td>{{isset($row->issue_date)?$row->issue_date:""}}</td>
                                    <td>{{isset($row->traffic_file)?$row->traffic_file:""}}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });
        });





    </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

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
