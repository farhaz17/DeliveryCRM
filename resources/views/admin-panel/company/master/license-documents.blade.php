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
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'documents-menu-items']) }}">Company Documents</a></li>
        <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <ul class="nav nav-tabs small" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#LicenseDocuments" role="tab" aria-controls="LicenseDocuments" aria-selected="true">License Documents ({{ $licenses->where('license_attachment',!null)->count() }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#TaxDocuments" role="tab" aria-controls="TaxDocuments" aria-selected="false">Tax Documents ({{ $licenses->where('tax_attachment',!null)->count() }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#ContractDocuments" role="tab" aria-controls="ContractDocuments" aria-selected="false">Contract Documents ({{$licenses->where('contract_attachment',!null)->count() }})</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="LicenseDocuments" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-11" id="datatable_license">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($licenses->where('license_attachment',!null) as $license)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $license->name ?? "" }}</td>
                                    <td>
                                        <a href="{{ $license->license_attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ $license->license_attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $license->license_attachment }}">Download</a>
                                    </td>
                                </tr> 
                                @empty
                                <p>No data attachment available!</p>
                                @endforelse
                            </tbody>
                        </table>                        
                    </div>
                </div>
                <div class="tab-pane fade" id="TaxDocuments" role="tabpanel" aria-labelledby="profile-basic-tab">
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
                </div>
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
            // "scrollY": false,
        });
    });
</script>
<script>
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