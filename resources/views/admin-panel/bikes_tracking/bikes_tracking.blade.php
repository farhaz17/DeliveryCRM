@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tracking Inventory Operations</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title offset-1 mb-3">Install New Tracker</div>
                    <form   method="post"  action="{{isset($tracking_edit)?action('BikesTracking\BikesTrackingController@update',$tracking_edit->id):route('bike_tracking.store')}}">
                            {!! csrf_field() !!}
                        @if(isset($tracking_edit))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-3 form-group offset-1">
                                <label for="repair_category">Installation Date</label>
                                <input type="date" name="checkin" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="repair_category">Tracker Free Bikes</label>
                                <select id="bike_id" name="bike_id" class="form-control form-control-sm select2" required>
                                    <option value="" selected disabled>Select Category Type</option>
                                    @foreach($tracker_free_bikes as $bike)
                                        @php
                                            $isSelected=(isset($tracking_edit)?$tracking_edit->id:"") == $bike->id;
                                        @endphp
                                        <option value="{{$bike->id}}" {{ $isSelected ? 'selected': '' }}>{{ $bike->plate_no ?? '' }} | {{ $bike->chassis_no ?? '' }} | {{ $bike->engine_no ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="repair_category">Unoccupaied Trackers</label>
                                {{-- <input class="form-control form-control-sm"   value="{{isset($tracking_edit)?$tracking_edit->tracking_number:""}}" id="tracking_number" name="tracking_number" type="text" placeholder="Enter Tracking Number" required /> --}}
                                <select name="tracking_number" id="tracking_number" class="form-control form-control-sm select2">
                                    <option value="">Select One Option</option>
                                    @foreach ($unoccupied_trackers as $trackers)
                                        <option value="{{ $trackers->id ?? '' }}"> {{ $trackers->tracking_no }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 offset-1 form-group">
                                <br/>
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-hover table-sm text-10" id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Bike Plate No</th>
                                <th scope="col">Bike Chassis No</th>
                                <th scope="col">Bike Engine No</th>
                                <th scope="col">Installed Tracking No</th>
                                <th scope="col">Remove / Suffle Tracker</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($all_installed_trackers as $tracker_history)
                                <tr>
                                    <td id="bike_idd"><b>Plate No: </b>{{ $tracker_history->bike->plate_no ?? '' }}</td>
                                    <td><b>Chassis No: </b>{{ $tracker_history->bike->chassis_no ?? '' }}</td>
                                    <td><b>Engine No: </b>{{ $tracker_history->bike->engine_no ?? '' }}</td>
                                    <td>{{ $tracker_history->tracker->tracking_no ?? ''}}</td>
                                    <td>
                                        <a class="text-success mr-2 update_tracker_btn"
                                        data-update_tracker_no = "{{ $tracker_history->tracker->tracking_no ?? ''}}"
                                        data-update_tracker_id = "{{ $tracker_history->tracking_number}}"
                                        data-update_form_action = "{{ route('bike_tracking.update',$tracker_history->id )}}"
                                        href="javascript:void(0)"
                                        data-toggle='modal'
                                        data-target="#Update_modal">
                                            <i class="nav-icon i-Add-Window font-weight-bold"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    modal--}}
    <div class="modal fade" id="Update_modal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form  action="#" enctype="multipart/form-data" id="update_tracker_form" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title offset-1" id="">Remove Or Shuffle Trackers</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body row">
                        <label class="radio radio-outline-primary col-5 offset-1">
                            <input type="radio" name="removeOrShuffle" checked value="remove"><span>Remove Tracker</span><span class="checkmark"></span>
                        </label>
                        <label class="radio radio-outline-primary col-6">
                            <input type="radio" name="removeOrShuffle" value="shuffle"><span>Suffle Tracker</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="modal-body row">
                        <div class="form-group col-4 offset-1">
                            <label for="remarks">Current Tracker No</label>
                            <input type="text"  id="current_tracker_no" class="form-control form-control-sm" readonly>
                            <input type="hidden"  id="current_tracker_id" name="current_tracker_id" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="form-group col-5" id="new_tracker_id_div" style="display: none">
                            <label for="repair_category">Unoccupaied Trackers</label>
                            <select name="new_tracker_id" id="new_tracker_id" class="form-control form-control-sm select2">
                                <option value="">Select One Option</option>
                                @foreach ($unoccupied_trackers as $trackers)
                                    <option value="{{ $trackers->id ?? '' }}"> {{ $trackers->tracking_no }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-10 offset-1 ">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    < <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
    $('input[name=removeOrShuffle]').on('change', function(){
        let removeOrShuffle = $(this).val();
        removeOrShuffle == 'remove' ? $('#new_tracker_id_div').hide(400) : $('#new_tracker_id_div').show(400)
        removeOrShuffle == 'shuffle' ? $('#new_tracker_id_div').show(400) : $('#new_tracker_id_div').hide(400)

        removeOrShuffle == 'remove' ? $('#new_bike_id_div').hide() : $('#new_bike_id_div').show(400)
        removeOrShuffle == 'shuffle' ? $('#new_bike_id_div').show() : $('#new_bike_id_div').hide(400)

        $("#new_tracker_id").select2({
            dropdownParent: "#Update_modal",
            placeholder: 'Select an option'
        });

    });
    $('.update_tracker_btn').on('click',function(){
        $('#current_tracker_no').val($(this).attr('data-update_tracker_no'))
        $('#current_tracker_id').val($(this).attr('data-update_tracker_id'))
        $('#update_tracker_form').attr('action', $(this).attr('data-update_form_action') );
        $('#new_tracker_id').select2({
            placeholder: 'Select an option',
        });
    });
    </script>

    <script>
        $('select').select2({
            placeholder: 'Select an option',
        });
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": {{ defaultPaginate() }},
                "columnDefs": [
                    {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"} // last column width for all tables
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
                "scrollY": false,
            });

        });
    </script>
    <script>
        $(document).ready(function(){
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
        });
    </script>

@endsection
