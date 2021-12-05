@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
    .hide_cls{
        display: none;
    }
    </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Platform</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Platform Details</div>
                    <form method="post" action="{{isset($platforms_data)?route('mplatform.update',$platforms_data->id):route('mplatform.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($platforms_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($platforms_data)?$platforms_data->id:""}}">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Platform Name</label>
                                <input class="form-control form-control-rounded" id="platform_name" name="platform_name" value="{{isset($platforms_data)?$platforms_data->name:""}}" type="text" placeholder="Enter the platform name" />


                                @if(isset($platforms_data))
                                    <input type="hidden" id="platform_category" name="platform_category" value="{{isset($platforms_data)?$platforms_data->platform_category:""}}">
                                @endif
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Platform Category</label>
                                <select id="platform_category" name="platform_category" class="form-control cls_card_type">
                                    @php
                                        $isSelected=(isset($platforms_data)?$platforms_data->platform_category:"")==1;
                                        $isSelected2=(isset($platforms_data)?$platforms_data->platform_category:"")==2;
                                    @endphp
                                    <option value="" selected disabled>Select option</option>
                                    <option value="1" {{ $isSelected ? 'selected': '' }}>Platform</option>
                                    <option value="2" {{ $isSelected2 ? 'selected': '' }}>Restaurant</option>
                                </select>
                            </div>


                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Cities</label>
                                <select id="cities" name="city_id" class="form-control cls_card_type">
                                    <option value="" selected disabled>Select option</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @if(isset($platforms_data)) {{ ($city->id==$platforms_data->city_id) ? 'selected' : '' }} @endif >{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Need PlatformCode.?</label>
                                <select id="need_notify" name="need_notify" class="form-control cls_card_type">
                                    <option value="1"   @if(isset($platforms_data)) {{ ($platforms_data->need_platform_code=="1") ? 'selected' : '' }} @else selected @endif >Yes</option>
                                    <option value="0"  @if(isset($platforms_data)) {{ ($platforms_data->need_platform_code=="0") ? 'selected' : '' }}  @endif >No</option>

                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Need Training.?</label>
                                <select id="need_training" name="need_training" class="form-control cls_card_type">
                                    <option value="1"   @if(isset($platforms_data)) {{ ($platforms_data->need_training=="1") ? 'selected' : '' }} @else selected @endif >Yes</option>
                                    <option value="0"  @if(isset($platforms_data)) {{ ($platforms_data->need_training=="0") ? 'selected' : '' }}  @endif >No</option>

                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Need Reservation.?</label>
                                <select id="need_training" name="need_reservation" class="form-control cls_card_type">
                                    <option value="1"   @if(isset($platforms_data)) {{ ($platforms_data->need_reservation=="1") ? 'selected' : '' }} @else selected @endif >Yes</option>
                                    <option value="0"  @if(isset($platforms_data)) {{ ($platforms_data->need_reservation=="0") ? 'selected' : '' }}  @endif >No</option>

                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Enter Short Code</label>
                                <input class="form-control form-control-rounded" id="short_code_name" required name="short_code_name" value="{{isset($platforms_data)?$platforms_data->short_code:""}}" type="text" placeholder="Enter the platform Short Code" />
                            </div>

<!---------------------------------------------------------------------->
                            <div class="col-md-6 form-group mb-3 hide_cls" >
                                <div class="col-form-label col-sm-2 pt-0">Radios</div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="online" type="radio" name="structure" value="Online" checked="checked">
                                        <label class="form-check-label ml-3" for="gridRadios1">
                                            Online
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="gridRadios2" type="radio" name="structure" value="Direct">
                                        <label class="form-check-label ml-3" for="gridRadios2">
                                            Direct
                                        </label>
                                    </div>
                            </div>


                            <div class="col-md-6 form-group mb-3 hide_cls">
                                <div class="col-form-label pt-0">Invoice Cycle</div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="weekly" type="radio" name="invoice_cycle" value="" checked="checked">
                                        <label class="form-check-label ml-3" for="gridRadios1">
                                            Weekly
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="monthly" type="radio" name="invoice_cycle" value="Direct">
                                        <label class="form-check-label ml-3" for="gridRadios2">
                                            Monthly
                                        </label>
                                    </div>


                            </div>
  <!---------------------------------------------------------------------->
                           <!----------------------------------------------->
                                <div class="col-md-12 form-group mb-3 hide_cls">

                                      <h4 class="card-title mb-3">Company Rate</h4>
                                </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                    <input type="hidden" class="form-control" name="company_field_one"  id="platform_search">
                                    <label for="repair_category">Field 1</label>
                                    <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group mb-3 hide_cls">

                                    <input type="hidden" class="form-control" name="company_field_two"  id="platform_search">
                                    <label for="repair_category">Field 2</label>
                                    <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group mb-3 hide_cls">

                                    <input type="hidden" class="form-control" name="company_field_three"  id="platform_search">
                                    <label for="repair_category">Field 3</label>
                                    <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off" >
                                </div>
                                <div class="col-md-4 form-group mb-3 hide_cls">

                                    <input type="hidden" class="form-control" name="company_field_four"  id="platform_search">
                                    <label for="repair_category">Field 4</label>
                                    <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off"  >
                                </div>
                                <div class="col-md-4 form-group mb-3 hide_cls">

                                    <input type="hidden" class="form-control" name="company_field_five"  id="platform_search">
                                    <label for="repair_category">Field 5</label>
                                    <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off" >
                                </div>

                            <!---------------------------------------------->
                            <!---------------------------------------------------------------------->
                            <!----------------------------------------------->

                            <div class="col-md-12 form-group mb-3 hide_cls">
                                <h4 class="card-title mb-3">Rider Rate</h4>
                            </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                <input type="hidden" class="form-control" name="rider_field_one"  id="platform_search">
                                <label for="repair_category">Field 1</label>
                                <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off">
                            </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                <input type="hidden" class="form-control" name="rider_field_two"  id="platform_search">
                                <label for="repair_category">Field 2</label>
                                <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off">
                            </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                <input type="hidden" class="form-control" name="rider_field_three"  id="platform_search">
                                <label for="repair_category">Field 3</label>
                                <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off" >
                            </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                <input type="hidden" class="form-control" name="rider_field_four"  id="platform_search">
                                <label for="repair_category">Field 4</label>
                                <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off"  >
                            </div>
                            <div class="col-md-4 form-group mb-3 hide_cls">

                                <input type="hidden" class="form-control" name="rider_field_five"  id="platform_search">
                                <label for="repair_category">Field 5</label>
                                <input type="text" class="form-control" name="date_from" id="date_from_search"  autocomplete="off" >
                            </div>

                            <!---------------------------------------------->
                            <div class="col-md-12">
                                @if(isset($platforms_data))
                                <button class="btn btn-primary">Update</button>
                                @else
                                <button class="btn btn-primary">Add</button>
                                @endif
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
                            <th scope="col">Platform Name</th>
                            <th scope="col">Platform Category</th>
                            <th scope="col">City</th>
                            <th scope="col">Need PlatformCode</th>
                            <th scope="col">Need Training</th>
                            <th scope="col">Need Reservation</th>
                            <th scope="col">Short Code</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($platforms as $platform)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$platform->name}}</td>
                                @if($platform->platform_category==1)
                                <td>Platform</td>
                                @else
                                 <td>Restaurant</td>
                                @endif
                                <td>{{ isset($platform->city_name->name) ? $platform->city_name->name : 'N/A'  }}</td>
                                <td>{{ $plaform_code_status_array[$platform->need_platform_code] }}</td>
                                <td>{{ $need_training_status_array[$platform->need_training] }}</td>
                                <td>{{ $need_reservation_status_array[$platform->need_reservation] }}</td>
                                <td>{{ isset($platform->short_code) ? $platform->short_code : 'N/A'  }}</td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('mplatform.edit',$platform->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                {{--<a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$part->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!--    {{--<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}-->
<!--    {{--<div class="modal-dialog modal-sm">--}}-->
<!--    {{--<div class="modal-content">--}}-->
<!--    {{--<form action="" id="deleteForm" method="post">--}}-->
<!--    {{--<div class="modal-header">--}}-->
<!--    {{--<h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>--}}-->
<!--    {{--<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}-->
<!--    {{--</div>--}}-->
<!--    {{--<div class="modal-body">--}}-->
<!--    {{--{{ csrf_field() }}--}}-->
<!--    {{--{{ method_field('DELETE') }}--}}-->
<!--    {{--Are you sure want to delete the data?--}}-->
<!--    {{--</div>--}}-->
<!--    {{--<div class="modal-footer">--}}-->
<!--    {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}-->
<!--    {{--<button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>--}}-->
<!--    {{--</div>--}}-->
<!--    {{--</form>--}}-->
<!--    {{--</div>--}}-->
<!--    {{--</div>--}}-->
<!--    {{--</div>--}}-->

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
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

        // {{--function deleteData(id)--}}
        // {{--{--}}
        // {{--var id = id;--}}
        // {{--var url = '{{ route('parts.destroy', ":id") }}';--}}
        // {{--url = url.replace(':id', id);--}}
        // {{--$("#deleteForm").attr('action', url);--}}
        // {{--}--}}
        //
        // {{--function deleteSubmit()--}}
        // {{--{--}}
        // {{--$("#deleteForm").submit();--}}
        // {{--}--}}
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
