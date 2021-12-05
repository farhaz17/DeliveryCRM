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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'documents-menu-items']) }}">RTA Documents</a></li>
        <li class="breadcrumb-item active" aria-current="page">Plate Replacement document List</li>
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
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped text-11" id="newRequestListTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">File Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- New Plate Replacement Request --}}
                            @forelse ($plate_repalce_requests->where('status', 0) as $plate_repalce_request)
                            <tr>
                                <td>&nbsp;</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement ?? "" }}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                    @php 
                                        $attachment_paths = json_decode($plate_repalce_request->attachment_paths) 
                                    @endphp
                                    @if(count($attachment_paths ?? []) > 0)
                                    <td>
                                    @forelse ($attachment_paths as $key => $attachment_path)
                                        {{ json_decode($plate_repalce_request->attachment_labels)[$key] }}
                            
                                        ( <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                        |
                                        <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" download="{{ $attachment_paths[$key] }}">Download</a> )<br>
                                        @empty
                                        
                                    @endforelse
                                    </td>
                                    @else
                                    <td></td> 
                                    @endif
                                </td>
                            </tr> 
                            @empty
                            @endforelse
                        </tbody>
                    </table>                        
                </div>
            </div>
            <div class="tab-pane fade " id="ApprovedRequests" role="tabpanel" aria-labelledby="home-basic-tab">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped text-11" id="ApprovedRequestsTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">File Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Approved Plate Replacement Request --}}
                            @forelse ($plate_repalce_requests->where('status', 1) as $plate_repalce_request)
                            <tr>
                                <td>&nbsp;</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement ?? "" }}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                    @php 
                                        $attachment_paths = json_decode($plate_repalce_request->attachment_paths) 
                                    @endphp
                                    @if(count($attachment_paths ?? []) > 0)
                                    <td>
                                    @forelse ($attachment_paths as $key => $attachment_path)
                                        {{ json_decode($plate_repalce_request->attachment_labels)[$key] }}
                            
                                        ( <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                        |
                                        <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" download="{{ $attachment_paths[$key] }}">Download</a> )<br>
                                        @empty
                                        
                                    @endforelse
                                    </td>
                                    @else
                                    <td></td> 
                                    @endif
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>                        
                </div>
            </div>
            <div class="tab-pane fade " id="RejectedRequest" role="tabpanel" aria-labelledby="home-basic-tab">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped text-11" id="RejectedRequestTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Plate No</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">File Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Rejected Plate Replacement Request --}}
                            @forelse ($plate_repalce_requests->where('status', 2) as $plate_repalce_request)
                            <tr>
                                <td>&nbsp;</td>
                                <td>{{ $plate_repalce_request->plate_no ?? "" }}</td>
                                <td>{{ $plate_repalce_request->reson_of_replacement ?? "" }}</td>
                                <td>{{ $plate_repalce_request->remarks ?? "" }}</td>
                                    @php 
                                        $attachment_paths = json_decode($plate_repalce_request->attachment_paths) 
                                    @endphp
                                    @if(count($attachment_paths ?? []) > 0)
                                    <td>
                                    @forelse ($attachment_paths as $key => $attachment_path)
                                        {{ json_decode($plate_repalce_request->attachment_labels)[$key] }}
                            
                                        ( <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                        |
                                        <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" download="{{ $attachment_paths[$key] }}">Download</a> )<br>
                                        @empty
                                        
                                    @endforelse
                                    </td>
                                    @else
                                    <td></td> 
                                    @endif
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
</div>
{{-- Modal for Approval form --}}
<div class="modal fade" id="RequestApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('vehicle_plate_replace_approve_request') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="plate_replace_request_id" id="plate_replace_request_id" value="">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Plate Number Approval Form</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 form-group mb-1"> 
                    <label for="">New Plate No</label>
                    <input type="text" class="form-control" name="new_plate_no">
                </div>
                <div class="col-md-6 form-group mb-1">
                    <label for="">Attachment</label>
                    <input class="form-control-file form-control-sm" id="" type="file" placeholder="" name="">
                </div>
            </div>
            <div class="card-body row">
                <div class="card-title mb-3 col-12">Selected Vehicle Information</div>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Chassis No</th>
                            <th>Currnet Plate No</th>
                            <th>Reason</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="vehicle_model"></td>
                            <td id="vehicle_chassis_no"></td>
                            <td id="vehicle_current_plate_no"></td>
                            <td id="reson_of_replacement"></td>
                            <td id="plate_no_replace_remarks"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-body row">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                <input class="btn btn-info btn-sm" id="" type="submit" value="Submit">
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
        var request_id = $(this).attr('data-request-id');
        $.ajax({
          url: "{{ route('get_plate_no_replace_info') }}",
          type:"GET",
          data:{request_id},
          success:function(response){
              console.log(response);
            $('#vehicle_model').text(response.bike_detail.model);
            $('#vehicle_chassis_no').text(response.bike_detail.chassis_no);
            $('#vehicle_current_plate_no').text(response.plate_no);
            $('#reson_of_replacement').text(response.reson_of_replacement);
            $('#plate_no_replace_remarks').text(response.remarks);
          },
          error: function(response) {
             console.log(response)
           }
         });
    })

</script>
<script>
    $(document).ready(function () {
        'use-strict'
        $('#newRequestListTable , #ApprovedRequestsTable, #RejectedRequestTable').DataTable( {
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
            select: true,
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