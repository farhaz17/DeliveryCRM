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
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'renewal-menu-items']) }}">Company Renewal</a></li>
        <li class="breadcrumb-item active" aria-current="page">Expiry Reports</li>
    </ol>
</nav>
    <div class="card col-md-12  mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Expiry Reports</div>
            <form action="{{route('company-master-expiry-reports')}}" method="get">
            <div class="row row-xs">
                <div class="col-md-5 row">
                    <label for=""  class="col-md-3">Select Master</label>
                    <select name="searchBy" id="searchBy" class="form-control form-control-sm col-md-8" required>
                        <option value="">Select Category</option>
                        @forelse ($master_categories as $master_category)
                            <option {{ request('searchBy') == $master_category->id ? 'selected' : '' }} value="{{ $master_category->id }}">{{ ucFirst($master_category->name)}}</option>
                        @empty
                            
                        @endforelse
                    </select>
                </div>
                <div class="col-md-5 row">
                    <label for="" class="col-md-3">Select Days</label>
                    <select name="dateRange" id="dateRange" class="form-control form-control-sm col-md-8">
                        <option value="">Select Days</option>
                        <option {{ request('dateRange') == '90' ? 'selected' : ' ' }} value="90">90</option>
                        <option {{ request('dateRange') == '60' ? 'selected' : ' ' }} value="60">60</option>
                        <option {{ request('dateRange') == '30' ? 'selected' : ' ' }} value="30">30</option>
                    </select>
                </div>
                {{-- <div class="col-md-2">
                    <input class="form-control form-control-sm" type="text" placeholder="Enter your username">
                </div>
                --}}
                <div class="col-md-2 mt-3 mt-md-0">
                    <button class="btn btn-sm btn-primary btn-block" type="submit"><i class="i-Funnel" aria-hidden="true"></i> Filter</button>
                </div>
            </div>
        </form>
            <hr>
            <div class="row">
                <table class="table table-sm table-hover text-11 data_table_cls">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Trade name</th>
                            <th>Trade No</th>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Expiring In Days</th>
                            <th>Total Renewal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @forelse ($data as $item)
                        <tr>
                           <td>1</td>
                           <td>{{ $item->name ?? $item->company->name ?? ''}}</td>
                           <td>{{ $item->trade_license_no ?? $item->company->trade_license_no ?? ''}}</td>
                           <td>{{ $item->issue_date ?? ''}}</td>
                           <td>{{ $item->expiry_date ?? '' }}</td>
                           <td>{{ $item->expires_in ?? '' }}</td>
                            <td>
                                <a class=" text-success mr-2 renewal-history-button" href="#" 
                                    @if(count($item->renewals)) data-toggle="modal" data-target="#renewalHistoryModalCenter" data-master-id={{ $item->id }} @endif
                                >
                                    {{ count($item->renewals) ?? "0" }} Renew(s)
                                </a>
                            </td>
                            <td>
                                <a class="text-success mr-2 edit-button" href="#" data-toggle="modal" data-target="#renewalModalCenter" data-master-id='{{$item->id}}'>
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
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
</div>
{{-- Modal for Renewal Histroy --}}
<div class="modal fade" id="renewalHistoryModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Renewal History</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="renewal_history_body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- Modal for Renewal Histroy --}}

{{-- Modal for Renewal Store --}}
<div class="modal fade" id="renewalModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{ route('company-master-expiry-reports-update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-2">Renew Expiry</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="master_category_id" id="master_category_id" value="{{ request('searchBy') !== null ? request('searchBy') : '' }}">
                        <input type="hidden" name="master_id" id="master_id">
                        <div class="col-md-6 form-group mb-1">
                            <label for="issue_date">Issue Date</label>
                            <input class="form-control form-control-sm" id="issue_date" type="date" placeholder="" name="issue_date">
                        </div>
                        <div class="col-md-6 form-group mb-1">
                            <label for="expiry_date">Expiry Date</label>
                            <input class="form-control form-control-sm" id="expiry_date" type="date" placeholder="" name="expiry_date">
                        </div>
                        <div class="col-md-6 form-group mb-1">
                            <label for="remarks">Remarks.</label>
                            <textarea class="form-control form-control-sm" id="remarks"placeholder="" name="remarks"></textarea>
                        </div>
                        <div class="col-md-6 form-group mb-1">
                            <label for="attachment">Attachment</label>
                            <input class="form-control-file form-control-sm" id="attachment" type="file" placeholder="" name="attachment">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary ml-2" type="submit">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- Modal for Renewal Store --}}
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
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
                    title: 'Expiry Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Expiry Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Expiry Summary',
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
    $(document).ready(function(){
        $('.edit-button').on('click',function(){
            $('#master_id').val($(this).attr('data-master-id'))
        }); 
    });
    $(document).ready(function(){
        $('.renewal-history-button').on('click', function(){
            var master_category_id = $('#master_category_id').val();
            var master_id = $(this).attr('data-master-id');     
            $.ajax({
                method: "GET",
                url: "renewal_history",
                dataType: "json",
                data: { master_category_id, master_id }
            })
            .done(function(response) {
                $('#renewal_history_body').empty();
                $('#renewal_history_body').append(response.html);
            });
        });
    });
</script>
@endsection