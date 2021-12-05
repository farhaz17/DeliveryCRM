@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .col-lg-12.sugg-drop {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Fuel</a></li>
            <li>Bike/Person For Fuel</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('driving_license.update',1) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Passport</label>
                                <input type="text" class="form-control" id="passport_number" name="passport_number" readonly>

                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select License type</label>
                                <select class="form-control  " name="edit_license_type" id="edit_license_type" required >
                                    <option value="" selected disabled >select an option</option>
                                    <option value="1">Bike</option>
                                    <option value="2">Car</option>
                                    <option value="3">Both</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3 car_type_div_edit " style="display:none">
                                <label for="repair_category">Select Car type</label>
                                <select class="form-control  " name="edit_car_type" id="edit_car_type"  >
                                    <option value="" selected disabled >select an option</option>
                                    <option value="1">Automatic Car</option>
                                    <option value="2">Manual Car</option>
                                </select>
                            </div>


                        </div>

                        <div class="row ">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">License Number</label>
                                <input type="number" class="form-control" name="edit_license_number"  id="edit_license_number" required>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Issue Data</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_issue_date" id="edit_issue_date" required>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control"  autocomplete="off" name="edit_expire_date" id="edit_expire_date" required>
                            </div>


                        </div>

                        <div class="row ">
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Driving License Front Pic</label>
                                <input type="file" class="form-control"  name="image_update"  >
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Driving License Back Pic</label>
                                <input type="file" class="form-control"  name="image_back_update"  >
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Traffic Code Number <Code></Code></label>
                                <input type="text" class="form-control" name="edit_traffic_cod" id="edit_traffic_cod" required>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Place Issue<Code></Code></label>
                                <input type="text" class="form-control" name="edit_place_issue"  id="edit_place_issue" required>
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    status update modal end--}}

    <div class="row">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Bike/Person For Fuel</div>

                </div>
            </div>
        </div>



    </div>


    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-sm text-10" id="datatable" style="width: 100%">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Passport Number</th>
                                <th scope="col">Type</th>
                                <th scope="col">Bike Plate Number</th>
                                <th scope="col">Assign date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bike_persons as $bike)
                            <tr>
                                <td>{{ $bike->id }}</td>
                                <td>{{ isset($bike->passport) ? $bike->passport->personal_info->full_name :  'N/A' }}</td>
                                <td>{{ isset($bike->passport) ? $bike->passport->passport_no :  'N/A' }}</td>
                                <td>{{ $type_array[$bike->type] }}</td>
                                @if(isset($bike->bike_replacement))
                                    <td>{{ isset($bike->bike_replacement->temporary_plate_number->plate_no) ? $bike->bike_replacement->temporary_plate_number->plate_no : '' }}</td>

                                @else
                                    <td>{{ isset($bike->bike_detail->plate_no) ? $bike->bike_detail->plate_no : '' }}</td>

                                @endif

                                <td>{{ $bike->created_at->toDateString() ? $bike->created_at->toDateString() : '' }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
        var web_url = '{{ url('') }}'
    </script>
    <script src="{{ asset('js/custom_js/bike_person_fuel.js') }}"></script>

    <script>
        $(".search_type_cls").change(function(){
            var select_v = $(this).val();
            $("#name_div").hide();
            if(select_v=="2"){
                $('#passport_id').select2({
                    placeholder: 'Select an option'
                });
                $(".typeahead").val("");
                $("#user_passport_id").val("");

                $(".bike_div").hide();
                $(".bike_div_label").hide();
                $(".append_div").show();
            }else{
                $("#user_passport_id").val("");
                $('#bike_id').select2({
                    width: '100%',
                    placeholder: 'Select an option'
                });
                $(".bike_div_label").show();
                $(".bike_div").show();
                $(".append_div").hide();
            }
        });
    </script>

    <script>
        $('#passport_id').select2({
            placeholder: 'Select an option'
        });
        $('#bike_id').select2({
            placeholder: 'Select an option'
        });

    </script>
    <script>


        $("#bike_id").change(function () {

            var value_selected = $(this).val();

            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();

            $.ajax({
                url: web_url+"/get_current_bike_user",
                method: 'POST',
                data:{bike_id:value_selected,_token:token},
                success: function (response) {

                    var  array = JSON.parse(response);
                    $("#name_div").show();
                    $("#name_passport").html(array.name);
                    $("input[name='user_passport_id']").val(array.id);

                }
            });

        });


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
                scrollY: 300,
                // responsive: true,
                "scrollX": true,
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

@endsection
