@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Bikes Tracking</a></li>
    </ul>
</div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <ul class="nav nav-tabs small" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#LicenseDocuments" role="tab" aria-controls="LicenseDocuments" aria-selected="true">All Trackers History</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#TaxDocuments" role="tab" aria-controls="TaxDocuments" aria-selected="false">Tax Documents ({{ $licenses->where('tax_attachment',!null)->count() }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#ContractDocuments" role="tab" aria-controls="ContractDocuments" aria-selected="false">Contract Documents ({{$licenses->where('contract_attachment',!null)->count() }})</a>
                </li> --}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="LicenseDocuments" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-11" id="datatable_license">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Total Tracker Installed</th>
                                    <th scope="col">Current Tracker Installed</th>
                                    <th scope="col">Bike Traker History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bike_tracker_histroy->groupBy('bike_id') as $bike_wise_history)
                                    {{-- @forelse ($bike_wise_history as $histroy) --}}
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td scope="col">Plate No: {{ $bike_wise_history[0]->bike->plate_no }}</td>
                                        <td scope="col">{{ $bike_wise_history->count() }} Tracker('s) Installed</td>
                                            @php $current_tracker = $bike_wise_history->where('checkout', null)->where('tracking_number', !null)->first() ?? [] @endphp
                                        <td scope="col">
                                            {{ $current_tracker ? $current_tracker->tracker->tracking_no : 'No Tracker Available' }}
                                        </td>

                                        <td scope="col">
                                            <a class="text-success mr-2 view_tracker_history_btn" data-toggle="modal" data-target="#showTrackerHistory" data-bike_id = {{ $bike_wise_history[0]->bike_id }}>
                                            <i class="nav-icon i-Add-Window font-weight-bold"></i>
                                        </a>
                                        </td>
                                    </tr>
                                    {{-- @empty

                                    @endforelse --}}
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="TaxDocuments" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-11" id="datatable_tax" style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $licenses->where('tax_attachment',!null) as $license)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $license->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ $license->tax_attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ $license->tax_attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $license->tax_attachment }}">Download</a>
                                    </td>
                                </tr>
                                @empty
                                <p>No data attachment available!</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ContractDocuments" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-11" id="datatable_contract"  style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($licenses->where('contract_attachment',!null) as $license)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $license->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ $license->contract_attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ $license->contract_attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $license->contract_attachment }}">Download</a>
                                    </td>
                                </tr>
                                @empty
                                <p>No data attachment available!</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

{{--    modal--}}
<div class="modal fade" id="showTrackerHistory" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Individual Bike Trackers History</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="showTrackerHistory_body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary" type="submit">Save</button> --}}
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable_license, #datatable_tax, #datatable_contract').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
            ],
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
                title: 'Bike Tracking',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            'pageLength',
        ],
            // "scrollY": false,
        });
    });
</script>
<script>
    $('.view_tracker_history_btn').on('click', function(){
        var bike_id = $(this).attr('data-bike_id');
        $.ajax({
                url: "{{ route('ajax_get_bike_tracker_history') }}",
                method: 'GET',
                data: { bike_id },
                success: function(response) {
                    $('#showTrackerHistory_body').empty()
                    $('#showTrackerHistory_body').append(response.html)
                }
        });
    });

</script>
<script>
function tostr_display(type,message){
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
