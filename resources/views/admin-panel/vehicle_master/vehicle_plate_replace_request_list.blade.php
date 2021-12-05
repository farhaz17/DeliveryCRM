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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'master-menu-items']) }}">RTA Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Plate Replacement Request List</li>
    </ol>
</nav>

<div class="card col-md-12 mb-2">
    <div class="card-body">
        <ul class="nav nav-tabs small" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#newRequestList" role="tab" aria-controls="newRequestList" aria-selected="true">New Requests ({{ $plate_repalce_requests->where('status', 0)->count() }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#ApprovedRequests" role="tab" aria-controls="ApprovedRequests" aria-selected="false">Approved ({{ $plate_repalce_requests->where('status', 1)->count() }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#RejectedRequest" role="tab" aria-controls="RejectedRequest" aria-selected="false">Rejected ({{$plate_repalce_requests->where('status',2)->count() }})</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="newRequestList" role="tabpanel" aria-labelledby="home-basic-tab">
                    <table class="table table-hover table-stripped table-sm text-10 data_table_cls" id="newRequestListTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate No</th>
                                <th>New Plate No</th>
                                <th>Reason </th>
                                <th>Remarks</th>
                                <th width = "20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plate_repalce_requests->where('status', 0) as $plate_repalce_request)
                            <tr>
                                <td>1</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->new_plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement !== null ? get_plate_replace_reason($plate_repalce_request->reson_of_replacement) : ''}}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                <td>
                                    <button href="#" class="btn btn-sm btn-info text-10 requestApprovalBtn"  data-toggle="modal" data-target="#RequestApprovalModal" data-request-id = {{ $plate_repalce_request->id }} data-new_plate_no = "{{ $plate_repalce_request->new_plate_no ?? '' }}">Check Info</button>
                                    {{-- <form class="form-check-inline" action="{{route('vehicle_plate_replace_reject_request',$plate_repalce_request->id)}}" method="post">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure to reject this request?')" class="btn btn-sm btn-danger text-10 request-reject-btn" id="">Reject</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
            </div>
            <div class="tab-pane fade " id="ApprovedRequests" role="tabpanel" aria-labelledby="home-basic-tab">
                    <table class="table table-hover table-stripped table-sm text-10 data_table_cls" id="ApprovedRequestsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate No</th>
                                <th>New Plate No</th>
                                <th>Reason</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plate_repalce_requests->where('status', 1) as $plate_repalce_request)
                            <tr>
                                <td>1</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->new_plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement !== null ? get_plate_replace_reason($plate_repalce_request->reson_of_replacement) : ''}}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info text-10" disabled >Approved</a>
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
            </div>
            <div class="tab-pane fade " id="RejectedRequest" role="tabpanel" aria-labelledby="home-basic-tab">
                    <table class="table table-hover table-stripped table-sm text-10 data_table_cls" id="RejectedRequestTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate No</th>
                                <th>New Plate No</th>
                                <th>Reason</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plate_repalce_requests->where('status', 2) as $plate_repalce_request)
                            <tr>
                                <td>1</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->new_plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement !== null ? get_plate_replace_reason($plate_repalce_request->reson_of_replacement) : ''}}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-danger text-10" readonly>Rejected</a>
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal for Approval form --}}
<div class="modal fade" id="RequestApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('vehicle_plate_replace_approve_request') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="plate_replace_request_id" id="plate_replace_request_id" required>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Plate Number Approval Form</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 form-group mb-1"> 
                    <label for="">New Plate No</label>
                    <input type="text" class="form-control" name="plate_no" value="" id="new_plate_no" required>
                </div>
            </div>
            <div class="card-body row" id="selectedRequestInfoHolder"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                <input class="btn btn-danger btn-sm" id="" name="accept_reject" type="submit" value="Reject">
                <input class="btn btn-info btn-sm" id="" name="accept_reject" type="submit" value="Accept">
            </div>
        </form>
        </div>
    </div>
</div>
{{-- Modal for Approval form --}}
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();

    $('.requestApprovalBtn').on('click', function(){
        $('#plate_replace_request_id').val($(this).attr('data-request-id'))
        $('#new_plate_no').val($(this).attr('data-new_plate_no'))
        var request_id = $(this).attr('data-request-id');
        $.ajax({
          url: "{{ route('get_plate_no_replace_info') }}",
          type:"GET",
          data:{request_id},
          success:function(response){
            $('#selectedRequestInfoHolder').empty();
            $('#selectedRequestInfoHolder').append(response.html);
          },
          error: function(response) {
             console.log(response)
           }
         });
    });
</script>
<script>

    $('input[name=accept_reject]').on('click', function(){
        if($(this).val() == 'Accept'){
            $('input[name=plate_no]').prop('required', true);
        }else if($(this).val() == 'Reject'){
            $('input[name=plate_no]').prop('required', false);
        }
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
                    title: 'Plate Replacement Report',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Plate Replacement Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Plate Replacement Report',
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
    $(document).ready(function () {
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var currentTab = $(e.target).attr('href'); // get current tab
             if(currentTab=="#newRequestList"){
                 var table = $('#newRequestListTable').DataTable();
                     $('#container').css( 'display', 'block' );
                     table.columns.adjust().draw();

             }else if(currentTab=="#ApprovedRequests"){
                 var table = $('#ApprovedRequestsTable').DataTable();
                     $('#container').css( 'display', 'block' );
                     table.columns.adjust().draw();

             }else if(currentTab=="#RejectedRequest"){
                 var table = $('#RejectedRequestTable').DataTable();
                     $('#container').css( 'display', 'block' );
                     table.columns.adjust().draw();
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