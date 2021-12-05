@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />\
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Companies Information</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Companies Information Details</div>
                    <form method="post" action="{{isset($company_info_data)?route('company_info_update',$company_info_data->id):route('company_info_store')}}">
                        {{ method_field('GET') }}
                        @if(isset($company_info_data))
                            {{ method_field('GET') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($company_info_data)?$company_info_data->id:""}}">
                        <div class="row">

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Company</label>
                                @if(isset($company_info_data))
                                    <input type="hidden" id="company_id" name="company_id" value="{{isset($company_info_data)?$company_info_data->id:""}}">
                                @endif
                                <select id="company_id" name="company_id" class="form-control cls_card_type">
                                    <option value=""  >Select option</option>
                                    @foreach($company as $lab)
                                        @php
                                            $isSelected=(isset($company_info_data)?$company_info_data->id:"")==$lab->id;
                                        @endphp
                                        <option value="{{$lab->id}}" {{ $isSelected ? 'selected': '' }}>{{ $lab->name  }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Trade License No</label>
                                <input class="form-control form-control-rounded" id="trade_license_no" name="trade_license_no" value="{{isset($company_info_data)?$company_info_data->trade_license_no:""}}" type="text" placeholder="Enter Trade License No" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Establishment Card</label>
                                <input class="form-control form-control-rounded" id="establishment_card" name="establishment_card" value="{{isset($company_info_data)?$company_info_data->establishment_card:""}}" type="text" placeholder="Enter Establishment Card" />
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Labour Card</label>
                                <input class="form-control form-control-rounded" id="labour_card" name="labour_card" value="{{isset($company_info_data)?$company_info_data->labour_card:""}}" type="text" placeholder="Enter the Labour Card" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Salik Acc</label>
                                <input class="form-control form-control-rounded" id="salik_acc" name="salik_acc" value="{{isset($company_info_data)?$company_info_data->salik_acc:""}}" type="text" placeholder="Enter Salik Acc" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Traffic File No</label>
                                <input class="form-control form-control-rounded" id="traffic_fle_no" name="traffic_fle_no" value="{{isset($company_info_data)?$company_info_data->traffic_fle_no:""}}" type="text" placeholder="Enter Traffic File No" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Etisalat Party Id</label>
                                <input class="form-control form-control-rounded" id="etisalat_party_id" name="etisalat_party_id" value="{{isset($company_info_data)?$company_info_data->etisalat_party_id:""}}" type="text" placeholder="Enter Etisalat Party Id" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Du Acc</label>
                                <input class="form-control form-control-rounded" id="du_acc" name="du_acc" value="{{isset($company_info_data)?$company_info_data->du_acc:""}}" type="text" placeholder="Enter Du Acc" />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Company</th>
                            <th scope="col">Trade License No</th>
                            <th scope="col">Establishment Card</th>
                            <th scope="col">Labour Card</th>
                            <th scope="col">Salik Acc</th>
                            <th scope="col">Traffic File No</th>
                            <th scope="col">Etisalat Party Id</th>
                            <th scope="col">Du Acc</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company_info as $com)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$com->com->name}}</td>
                                <td>{{$com->trade_license_no}}</td>
                                <td>{{$com->establishment_card}}</td>
                                <td>{{$com->labour_card}}</td>
                                <td>{{$com->salik_acc}}</td>
                                <td>{{$com->traffic_fle_no}}</td>
                                <td>{{$com->etisalat_party_id}}</td>
                                <td>{{$com->du_acc}}</td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('company_info_edit',$com->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                {{--<a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$part->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-sm">--}}
    {{--<div class="modal-content">--}}
    {{--<form action="" id="deleteForm" method="post">--}}
    {{--<div class="modal-header">--}}
    {{--<h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>--}}
    {{--<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--{{ csrf_field() }}--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--Are you sure want to delete the data?--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
    {{--<button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });

        });

        $('#company_id').select2({
            placeholder: 'Select an option'
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
