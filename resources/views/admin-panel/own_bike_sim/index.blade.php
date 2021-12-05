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

        <!--  Verify Modal content -->
        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Own Sim/Bike Verification</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <form id="edit_from" action="{{ route('own_sim_bike.update',1) }}" method="post">
                    <div class="modal-body">

                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Are you sure to remove own bike.?</h4>
                                </div>

                                <div class="col-md-12">
                                        <label for="repair_category">Checkout</label>
                                        <input class="form-control form-control" id="checkout" name="checkout" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" type="datetime-local" required  />

                                </div>

                            </div>
                            <input type="hidden" id="primary_id" name="primary_id">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="card-body">
            <div class="card-title mb-3">Own Bike/Sim Reports</div>
            <div class="row">
                <table class="table table-sm table-hover text-10 data_table_cls">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Zds code</th>
                        <th>Passport Number</th>
                        <th>Platform</th>
                        <th>Own Type</th>
                        <th>Checkin</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($bike_sim_history as $bike)
                        <tr>
                            <td>1</td>
                            <td> {{ $bike->passport->personal_info->full_name ?? "NA" }}</td>
                            <td> {{ $bike->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td> {{ $bike->passport->passport_no ?? "NA" }}</td>
                            <td> {{ $bike->get_platform->name ?? "NA" }}</td>
                            <td> {{ isset($own_type_array[$bike->own_type]) ? $own_type_array[$bike->own_type] : "NA" }} </td>
                            <td> {{ $bike->checkin ?? "NA" }} </td>
                            <td>
                                <a class="text-success mr-2 edit_cls" id="{{ $bike->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
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


        $(".edit_cls").click(function(){

            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);

            var ab  = $("#edit_from").attr('action');
            var now = ab.split('own_sim_bike/');

            $("#edit_from").attr('action',now[0]+"own_sim_bike/"+ids);

            $("#edit_modal").modal('show');
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
