@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('drc_dashboard',['active'=>'operations-menu-items']) }}">DRC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">DRC Rider Operations</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
                        <li class="nav-item">
                            <a class="nav-link active" id="PendingDefaulterRequestToDrcTab" data-toggle="tab" href="#PendingDefaulterRequestToDrc" role="tab" aria-controls="PendingDefaulterRequestToDrc" aria-selected="true">Pending Defaulter Requests ( {{ $defaulter_requests_to_drc->where('approval_status', 0)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="AcceptedDefaulterRequestToDrcTab" data-toggle="tab" href="#AcceptedDefaulterRequestToDrc" role="tab" aria-controls="AcceptedDefaulterRequestToDrc" aria-selected="true">Accepted Defaulter Requests ( {{ $defaulter_requests_to_drc->where('approval_status', 1)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="RejectedDefaulterRequestToDrcTab" data-toggle="tab" href="#RejectedDefaulterRequestToDrc" role="tab" aria-controls="RejectedDefaulterRequestToDrc" aria-selected="true">Rejected Defaulter Requests ( {{ $defaulter_requests_to_drc->where('approval_status', 2)->where('status', 1)->count() ?? 0}} )
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active show" id="PendingDefaulterRequestToDrc" role="tabpanel" aria-labelledby="PendingDefaulterRequestToDrcTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="PendingDefaulterRequestToDrcTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>DRCM</th>
                                            <th>DRC</th>
                                            {{-- <th>DC</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_to_drc->where('approval_status', 0)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                >Details
                                            </button>
                                            <button
                                                    class="btn btn-info btn-sm accpet_reject_btn"
                                                    data-drc_assign_request_id="{{ $rider->id }}"
                                                    data-defaulter_rider_ppuid="{{ $rider->defaulter_rider->passport->pp_uid ?? '' }}"
                                                    data-defaulter_rider_name="{{ $rider->defaulter_rider->passport->personal_info->full_name ?? '' }}"
                                                    data-toggle="modal"
                                                    data-target="#DrcDefaulterRiderAcceptRejectModal"
                                                    type="button"
                                                >Approval
                                            </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="AcceptedDefaulterRequestToDrc" role="tabpanel" aria-labelledby="AcceptedDefaulterRequestToDrcTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="AcceptedDefaulterRequestToDrcTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>DRCM</th>
                                            <th>DRC</th>
                                            {{-- <th>DC</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_to_drc->where('approval_status', 1)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                >Details
                                            </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="RejectedDefaulterRequestToDrc" role="tabpanel" aria-labelledby="RejectedDefaulterRequestToDrcTab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-11" id="RejectedDefaulterRequestToDrcTable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ppuid</th>
                                            <th>Rider Name</th>
                                            <th>DRCM</th>
                                            <th>DRC</th>
                                            {{-- <th>DC</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($defaulter_requests_to_drc->where('approval_status', 2)->where('status',1) as $rider)
                                        <tr>
                                            <td>{{ $rider->id }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->pp_uid ?? "" }}</td>
                                            <td>{{ $rider->defaulter_rider->passport->personal_info->full_name ?? "" }}</td>
                                            <td>{{ ucFirst($rider->drcm->name ?? "") }}</td>
                                            <td>{{ ucFirst($rider->drc->name ?? "") }}</td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-info btn-sm defaulter_rider_comments_btn"
                                                    data-defaulter_rider_id = "{{ $rider->id }}"
                                                    data-toggle="modal"
                                                    data-target="#DefaulterRiderCommentModal"
                                                    title="Click to see defaulter rider in details"
                                                >Details
                                            </button>
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
    </div>

    <!-- DefaulterRiderCommentModal starts-->

    <div id="DefaulterRiderCommentModal" class="modal fade col-11 m-5" tabindex="-1" role="dialog" aria-labelledby="DefaulterRiderCommentModalTitle" style="display: none;" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered row" role="document" id="DefaulterRiderCommentModalBody"></div>
    </div><!-- DefaulterRiderCommentModal ends-->

    <!-- dDrcDefaulterRiderAcceptRejectModal starts-->
    <div class="modal fade" id="DrcDefaulterRiderAcceptRejectModal" tabindex="-1" role="dialog" aria-labelledby="DrcDefaulterRiderAcceptRejectModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="DrcDefaulterRiderAcceptRejectModalLongTitle">DRC Rider Approval Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rider-name: <b id="defaulter_rider_name"></b> <br> PPUID: <b id="defaulter_rider_ppuid"></b></p>
                        <hr class="p-1">
                        <input type="hidden" id="drc_assign_request_id">
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea id="drcm_comment" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name = "drc_accept_reject" class="btn btn-primary drc_accept_reject" value="1">Accept</button>
                        <button type="submit" name = "drc_accept_reject" class="btn btn-danger drc_accept_reject" value="2">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DrcDefaulterRiderAcceptRejectModal ends-->

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        $('.PendingdefaulterRiderRequestStatusChangebutton').click(function(){
            $('#passport_id').val($(this).attr('data-passport_id'));
        });
    </script>
    <script>
        $('.defaulter_rider_comments_btn').click(function(){
            var defaulter_rider_id = $(this).data('defaulter_rider_id');
            $.ajax({
                url : "{{ route('get_ajax_defaulter_rider_comments') }}",
                data : { defaulter_rider_id },
                success: function(response){
                    $('#DefaulterRiderCommentModal').empty()
                    $('#DefaulterRiderCommentModal').append(response.html)
                }
            });
        });
    </script>
    <script>
        $('.accpet_reject_btn').click(function(){
            $('#drc_assign_request_id').val($(this).attr('data-drc_assign_request_id'));
            $('#defaulter_rider_name').text($(this).attr('data-defaulter_rider_name'));
            $('#defaulter_rider_ppuid').text($(this).attr('data-defaulter_rider_ppuid'));
        });
    </script>
    <script>
        $('.drc_accept_reject').click(function(e){
            e.preventDefault();
            var drc_assign_request_id = $('#drc_assign_request_id').val()
            var comment = $('#drcm_comment').val()
            var accept_reject = $(this).val();
            var _token = "{{ csrf_token() }}"
            var url = "{{ route('drc_rider_approval') }}"
            $.ajax({
                url,
                data:{ _token, comment, accept_reject, drc_assign_request_id },
                method: "POST",
                success: function(response){
                    tostr_display(response['alert-type'],response['message']);
                    if(response['status'] == 200){
                        $('#DrcDefaulterRiderAcceptRejectModal').modal('hide')
                        window.location.reload()
                    }
                }
            });
        });
    </script>
    <script>
        $('.reassign_accpet_reject_btn').click(function(){
            $('#reassign_defaulter_rider_id').val($(this).attr('data-defaulter_rider_id'));
            $('#reassign_defaulter_rider_name').text($(this).attr('data-defaulter_rider_name'));
            $('#reassign_defaulter_rider_ppuid').text($(this).attr('data-defaulter_rider_ppuid'));
        });
    </script>
    <script>
        $('.reassign_rider_to_dc_btn').click(function(){
            $('#reassign_rider_id').val($(this).attr('data-reassign_platform_id'));
            $('#reassign_rider_name').text($(this).attr('data-reassign_rider_name'));
            $('#reassign_rider_ppuid').text($(this).attr('data-reassign_rider_ppuid'));
            var platform_id = $(this).attr('data-reassign_platform_id')
            var url = "{{ route('rider_platform_wise_dc_list') }}"
            $.ajax({
                url,
                data:{platform_id},
                success: function(response){
                    $('#dc_user_id_div').empty();
                    $('#dc_user_id_div').append(response.html);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            'use-strict',
            $('#PendingDefaulterRequestToDrcTable, #AcceptedDefaulterRequestToDrcTable, #RejectedDefaulterRequestToDrcTable').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'DC Riders',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
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
        function tostr_display(type, message){
            switch(type){
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
            }
        }
    </script>
@endsection
