@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')

    {{--    remarks modal--}}

    <div class="modal fade" id="remark_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id="remark_p"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{--remarks modal end--}}

    <div class="card col-lg-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3">Temporary Bike History Report</div>
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
                        <th>CheckedOut</th>
                        <th>Used Days</th>
                        <th>Replace Remarks</th>
                        <th>Replace Taken Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bike_replacements as $bike)
                        <tr>
                            <td>1</td>
                            <td> {{ $bike->passport->personal_info->full_name ?? "NA" }} </td>
                            <td> {{ $bike->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td> {{ $bike->temporary_plate_number->plate_no ?? "NA" }}</td>
                            <td> {{ $bike->permanent_plate_number->plate_no ?? "NA"}} </td>
                            <td> {{ $bike->replace_checkin ?? "NA" }} </td>
                            <td> {{ $bike->replace_checkout ?? $bike->updated_at }} </td>
                            <?php
                            if($bike->replace_checkin != null){
                                $first_day =  date("Y-m-d", strtotime($bike->replace_checkin));
                                $last_day = date ("Y-m-d", strtotime($bike->replace_checkout ?? $bike->updated_at));
                                $datetime1= new \DateTime($first_day);
                                $datetime2= new \DateTime($last_day);
                                $difference = $datetime1->diff($datetime2);
                            }
                            ?>
                            <td>
                                {{ $difference->days ?? '0'  }}
                            </td>
                            <td>
                                {{ $bike->replace_remarks }}
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
        $(".view_cls_replace").click(function () {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_remarks_bike_replacement') }}",
                method: 'GET',
                data: {primary_id: ids ,type:"1"},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });

        $(".view_cls_replace_taken").click(function () {

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_view_remarks_bike_replacement') }}",
                method: 'GET',
                data: {primary_id: ids ,type:"2"},
                success: function(response) {
                    $("#remark_p").html(response);
                    $("#remark_modal").modal('show');

                }
            });
        });
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
                // scrollY: 300,
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
