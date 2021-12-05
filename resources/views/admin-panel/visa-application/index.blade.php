@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

    <style>
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 600;
        }
        .btn-file {
    padding: 1px;
    font-size: 10px;
    color: #ffffff;
}
        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Application</a></li>
            <li>Visa</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {{-- <div class="row">

        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Visa Details</div> --}}
                    {{-- <form method="post" enctype="multipart/form-data" action="{{isset($visa_application_data)?route('visa_application.update',$visa_application_data->id):route('visa_application.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($visa_application_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($visa_application_data)?$visa_application_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Passport</label>
                                <input class="form-control typeahead" value="{{isset($visa_application_data)?$visa_application_data->passport->passport_no:""}}"    @if(isset($visa_application_data)) readonly @endif  id="keyword" autocomplete="off" type="text" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">UID Number</label>
                                    <input class="form-control" id="uid_num" name="uid_num" value="{{isset($visa_application_data)?$visa_application_data->uid_number:""}}" type="text" placeholder="Enter the UID/EID Number" />

                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">EID Number</label>
                                    <input class="form-control" id="eid_num" name="eid_num" value="{{isset($visa_application_data)?$visa_application_data->uid_number:""}}" type="text" placeholder="Enter the UID/EID Number" />
                                    <input class="form-control" id="passport_id" type="hidden" name="passport_id" value="{{isset($visa_application_data)?$visa_application_data->passport_id:""}}" />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">File Number</label>
                                    <input class="form-control" id="file_number" name="file_number" value="{{isset($visa_application_data)?$visa_application_data->file_number:""}}" type="text" placeholder="Enter the file number" required />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Date of Issue</label>
                                    <input class="form-control form-control" id="date_issue2" value="{{isset($visa_application_data)?$visa_application_data->issue_date:""}}" name="date_issue" type="date" placeholder="Enter Date of Issue" required />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Expiry Date</label>
                                    <input class="form-control form-control" id="date_expiry2" value="{{isset($visa_application_data)?$visa_application_data->expiry_date:""}}" name="date_expiry" type="date" placeholder="Enter Expiry Date" required />
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">State</label>
                                    <select id="state_id" name="state_id" class="form-control select">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            @php
                                                $isSelected=(isset($visa_application_data)?$visa_application_data->state_id:"")==$state->id;
                                            @endphp
                                            <option value="{{$state->id}}" {{ $isSelected ? 'selected': '' }}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Visa Profession</label>
                                    <select id="visa_profession_id" name="visa_profession_id" class="form-control select">
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            @php
                                                $isSelected=(isset($visa_application_data)?$visa_application_data->visa_profession_id:"")==$profession->id;
                                            @endphp
                                            <option value="{{$profession->id}}" {{ $isSelected ? 'selected': '' }}>{{$profession->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Visa Company</label>
                                    <select id="visa_company" name="visa_company" class="form-control select">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            @php
                                                $isSelected=(isset($visa_application_data)?$visa_application_data->visa_company_id:"")==$company->id;
                                            @endphp
                                            <option value="{{$company->id}}" {{ $isSelected ? 'selected': '' }}>{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>








                            @if(isset($visa_application_data))
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Scanned Visa Copy</label><br>

                                    <br>

                                    <input class="form-control form-control" value="{{isset($visa_application_data)?$visa_application_data->attachment:""}}" id="temp_file" name="temp_file" type="hidden"   />

                                    <a class="attachment_display" href="{{ isset($visa_application_data->attachment) ? url($visa_application_data->attachment) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Scanned Visa Copy</strong></a>
                            </div>
                            @endif
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category" id="copy_label">Visa Attachment</label>
                                <div class="custom-file">
                                    <input class="form-control custom-file-input" id="visa_attachment" multiple type="file" name="visa_attachment[]" />
                                    <label class="custom-file-label" for="select_file">Choose Scanned Visa Copy</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($visa_application_data)) Edit @else Save  @endif Visa Application</button>
                            </div>






                        </div>
                    </form> --}}
                {{-- </div>
            </div>
        </div>

        <div class="col-md-2">
        </div>
    </div> --}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered"  id="datatable">
                        <thead class="thead-dark">
                        <tr>

                            <th scope="col">UID Number</th>
                            <th scope="col">EID Number</th>
                            <th scope="col">File Number</th>
                            <th scope="col">Passport</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company</th>
                            <th scope="col">Attachment</th>
                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($visas as $visa)
                            <tr>

                                <td>{{isset($visa->uid_number)?$visa->uid_number:""}}</td>
                                <td>{{isset($visa->eid_number)?$visa->eid_number:""}}</td>
                                <td>{{isset($visa->file_number)?$visa->file_number:""}}</td>
                                <td>{{isset($visa->passport->passport_no)?$visa->passport->passport_no:""}}</td>
                                <td>{{isset($visa->passport->personal_info->full_name)?$visa->passport->personal_info->full_name:""}}</td>
                                <td>{{isset($visa->company->name)?$visa->company->name:"N/A"}}</td>
                                <td>
                                   @if(isset($visa->attachment))
                                   <br>
                                   @if(isJSON($visa->attachment))
                                    @foreach (json_decode($visa->attachment) as $visa_attach)
                                    <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/visa_applicatupion/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                                        <strong style="color: #ffffff">  View Attachment</strong>
                                    </a>
                                        <span>|</span>
                                    @endforeach
                                    @else
                                        <a class="btn btn-success btn-file" href="{{$visa->attachment}}" target="_blank">View Attachment</a>
                                    @endif

                                   @else
                                   N/A
                                   @endif

                                </td>

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

    <div class="modal fade bd-example-modal-lg-visa_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body" id="main_modal_now">
                    <div class="visa_show"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
<?php
function isJSON($string){
   return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}
?>
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>


    <script>
         function startVisa2(id)
                   {
            var id = id;
            var token = $("input[name='_token']").val();

            // alert('hghghghghghghghghhghghghghghghghghg');
            $.ajax({
                url: "{{ route('ajax_get_visa_app_att') }}",
                method: 'POST',
                data: {id: id, _token:token},
                success: function(response) {

                    $('.visa_show').empty();
                    $('.visa_show').append(response.html);
                }
            });
            $(".bd-example-modal-lg-visa_detail").modal('show');
        }
    </script>


    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

        });


    </script>

    <script>
        $('#state_id').select2({
            placeholder: 'Select the state'
        });
        $('#passport_id').select2({
            placeholder: 'Select the passport no'
        });
        $('#visa_profession_id').select2({
            placeholder: 'Select the Profession'
        });
        $('#visa_company').select2({
            placeholder: 'Select the Company'
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
