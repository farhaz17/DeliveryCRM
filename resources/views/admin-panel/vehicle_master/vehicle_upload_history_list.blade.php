@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'reports-menu-items']) }}">RTA Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vehicle Upload History List</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Vehicle Upload History Reports</div>
        <div class="row">
            <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                    <tr>
                        <th> &nbsp; </th>
                        <th>Uploaded From</th>
                        <th>Count New</th>
                        <th>Uploaded At</th>
                        <th>Uploaded By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicle_upload_histories as $history)
                    <tr class="upload_history_row" data-upload_history_id = "{{ $history->id }}"  data-toggle="modal" data-target="#VehicleUploadHistoryModal" title="Click to watch vehicles in details">
                        <td> &nbsp; </td>
                        <td> {{ get_uploaded_form()[$history->updated_form] }} </td>
                        <td> {{ count($history->get_uploaded_vehicles()) }} </td>
                        <td> {{ dateToread($history->created_at ?? '') }} </td>
                        <td> {{ $history->user->name ?? '' }} </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="VehicleUploadHistoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="VehicleUploadHistoryModalTitle" style="display: none;" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="VehicleUploadHistoryModalTitle">Uploaded new vehicles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" id="VehicleUploadHistoryModalBody"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();
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
                    title: 'Vehicle Category Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Vehicle Category Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Vehicle Category Summary',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
            select: false,
            scrollY: 300,
            responsive: true,
            // scrollX: true,
            // scroller: true
        });
    });
    </script>
    <script>
        $('.upload_history_row').click(function(){
            var upload_history_id = $(this).data('upload_history_id');
            $.ajax({
                url : "{{ route('get_ajax_vehicle_upload_history') }}",
                data : { upload_history_id },
                success: function(response){
                    $('#VehicleUploadHistoryModalBody').empty()
                    $('#VehicleUploadHistoryModalBody').append(response.html)
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

@endsection