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
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Career</a></li>
            <li>Career Requests out Of UAE</li>
        </ul>
    </div>
</nav>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <ul class="nav nav-tabs small" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#LicenseDocuments" role="tab" aria-controls="LicenseDocuments" aria-selected="true">Out of UAE (  )</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#TaxDocuments" role="tab" aria-controls="TaxDocuments" aria-selected="false">Career Requests (0)</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#ContractDocuments" role="tab" aria-controls="ContractDocuments" aria-selected="false">Career Requests (0)</a>
                </li> --}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="LicenseDocuments" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-11" id="datatable_license">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Country Name</th>
                                    <th scope="col">City Name</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">What's App</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Passport</th>
                                    <th scope="col">License</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($career_requests as $career_requests)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td> {{ $career_requests->nationality ?? "" }} </td>
                                    <td> {{ $career_requests->belong_city_name ?? "" }} </td>
                                    <td> {{ $career_requests->name ?? "" }} </td>
                                    <td> {{ $career_requests->phone ?? "" }} </td>
                                    <td> {{ $career_requests->whatsapp ?? "" }} </td>
                                    <td> {{ $career_requests->email ?? "" }} </td>
                                    <td> {{ $career_requests->passport_no ?? "" }} </td>
                                    <td> {{ $career_requests->license_no ?? "" }} </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">Button</a>
                                        <a href="#" class="btn btn-info btn-sm">Button</a>
                                    </td>
                                </tr> 
                                @empty
                                
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
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                               </tr>
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