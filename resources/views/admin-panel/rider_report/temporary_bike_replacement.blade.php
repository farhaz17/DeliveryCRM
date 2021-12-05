@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')

    <div class="card col-lg-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3">Temporary Bike Reports</div>
            <div class="row">
                <table class="table table-sm table-hover text-10 data_table_cls">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Zds code</th>
                        <th>Temporary Bike</th>
                        <th>Permanent Bike</th>
                        <th>Issue Data</th>
                        <th>Number Days</th>
                        <th>Remain Days</th>
                        <th>Repalce Remarks</th>
                        <th>Replace taken Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bike_replacements as $bike)
                        <tr>
                            <td>1</td>
                            <td> {{ $bike->passport->personal_info->full_name ?? "NA" }}</td>
                            <td> {{ $bike->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td> {{ $bike->temporary_plate_number->plate_no ?? "NA" }}</td>
                            <td> {{ $bike->permanent_plate_number->plate_no ?? "NA"}} </td>
                            <td> {{ $bike->replace_checkin ?? "NA" }} </td>
                            <td> {{ $bike->no_of_days ?? "NA" }} </td>
                            <?php
                            $first_day = "";
                            $last_day = "";
                            if($bike->replace_checkin != null){
                                $l_dat = explode(" ",$bike->replace_checkin);

                                $first_day =  date("Y-m-d");

                                $l_t = $l_dat[0]; // Or can put $today = date ("Y-m-d");

                                $last_day = date ("Y-m-d", strtotime ($l_t."+".$bike->no_of_days." days"));

//                                $last_day = date("Y-m-d");

                                $datetime1= new \DateTime($first_day);
                                $datetime2= new \DateTime($last_day);

                                $difference = $datetime1->diff($datetime2);

                            }

                            ?>
                            <td>{{ $difference->days ? $difference->days : '0'  }} </td>
                            <td>
                                {{ $bike->replace_remarks}}
                            </td>
                            <td>
                                {{ $bike->replace_taken_remarks }}
                            </td>
                        </tr>
                    @empty
                        <p>No data data available!</p>
                    @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection
@section('js')

    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>

    </script>

    <script>

        $(document).ready(function () {
            'use-strict'
            $('table.data_table_cls').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        title: 'License Summary',
                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'License Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'License Summary',
                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                select: true,
                scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });

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
