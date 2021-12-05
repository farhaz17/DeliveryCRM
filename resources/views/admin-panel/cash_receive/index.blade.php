@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">COD</a></li>
            <li>Cash on Delivery</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('driving_license.update',1) }}">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3 append_div " >
                                <label for="repair_category">Select Passport</label>
                                <select class="form-control  " name="edit_passport_id" id="edit_passport_id" required >
                                    <option value="">select an option</option>
                                    @foreach($all_passports as $pass)
                                        <option value="{{ $pass->id  }}">{{ $pass->passport_no  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select License type</label>
                                <select class="form-control  " name="edit_license_type" id="edit_license_type" required >
                                    <option value="" selected disabled >select an option</option>
                                    <option value="1">Bike</option>
                                    <option value="2">Car</option>
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
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Issue Data</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_issue_date" id="edit_issue_date" required>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control"  autocomplete="off" name="edit_expire_date" id="edit_expire_date" required>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Traffic Code Number <Code></Code></label>
                                <input type="text" class="form-control" name="edit_traffic_cod" id="edit_traffic_cod" required>
                            </div>

                            <div class="col-md-4 form-group mb-3">
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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Collect Cash on Delivery</div>
                    <form method="post" action="{{ route('cash_receive.store')  }}">
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-5">

                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio" class="search_type_cls" checked  value="3" name="search_type" /><span>Passport Number</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio" class="search_type_cls" value="1" name="search_type"  /><span>PPUID</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio"  class="search_type_cls"  value="2" name="search_type" /><span>ZDS Code</span><span class="checkmark"></span>
                                    </label>
                                </div>



                            </div>

                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                <label class="radio-outline-success ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
                            </div>

                        </div>


                        <div class="row ">
                            <div class="col-md-6 form-group mb-3 append_div">
                                <label for="repair_category">Select Passport</label>
                                <select class="form-control  " name="passport_id" id="passport_id" required >
                                    <option value="">select an option</option>
                                    @foreach($all_passports as $pass)
                                        <option value="{{ $pass->id  }}">{{ $pass->passport_no  }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Amount</label>
                                <input type="number" class="form-control" required name="amount" id="amount">
                            </div>



                        </div>


                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Passport Number</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Received By</th>
                            </tr>
                            </thead>
                            <tbody>
                      @foreach($cash_receives as $cash)
                          <tr>
                              <td scope="row"> </td>
                              <td>{{ $cash->passport->personal_info->full_name }}</td>
                              <td>{{ $cash->passport->passport_no }}</td>
                              <td>{{ $cash->amount  }}</td>
                              <td>{{ $cash->user->name }}</td>
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

    <script>
        $(".search_type_cls").change(function(){
            var select_v = $(this).val();
            $("#name_div").hide();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_render_cat_dropdown') }}",
                method: 'POST',
                data: {type: select_v, _token:token},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);

                    if(select_v=="1"){
                        $('.ppui_id').select2({
                            placeholder: 'Select an option'
                        });
                    }else if(select_v=="2"){
                        $('.zds_code').select2({
                            placeholder: 'Select an option'
                        });
                    }else{
                        $('.passport_id').select2({
                            placeholder: 'Select an option'
                        });
                    }

                }
            });

        });
    </script>

    <script>
        $(document).on('change', '#ppui_id', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

        $(document).on('change', '#zds_code', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

        $(document).on('change', '#passport_id', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

    </script>


    <script>
        tail.DateTime("#issue_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#expire_date",{
                dateStart: $('#issue_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

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
                responsive: true,
            });

            $('#passport_id').select2({
                placeholder: 'Select an option'
            });


            $("#passport_id").change(function () {


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_current_passport_status') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {
                        $("#status_id").val(response);
                    }
                });

            });

        });

    </script>

    <script>
        $(".edit_cls").click(function(){


            tail.DateTime("#edit_issue_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });

            tail.DateTime("#edit_expire_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });



            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);



            $(".select2-container").css('width','100%');

            var ab  = $("#edit_from").attr('action');

            var now = ab.split('driving_license/');

            $("#edit_from").attr('action',now[0]+"driving_license/"+ids);



            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_driving_license_detail') }}",
                method: 'POST',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var arr = $.parseJSON(response);
                    if(arr !== null){
                        console.log(arr['passport_id']);
                        // alert(arr['passport_id']);
                        // $("#edit_passport_id").val(arr['passport_id']);
                        $("#edit_license_type").val(arr['license_type']);

                        if(arr['car_type'] !== null){
                            $(".car_type_div_edit").show();
                            $("#edit_car_type").prop('required',true);
                            $("#edit_car_type").val(arr['car_type']);
                        }

                        $("#edit_license_number").val(arr['license_number']);
                        $("#edit_issue_date").val(arr['issue_date']);
                        $("#edit_expire_date").val(arr['expire_date']);
                        $("#edit_traffic_cod").val(arr['traffic_code']);
                        $("#edit_place_issue").val(arr['place_issue']);

                        $('#edit_passport_id').val(arr['passport_id']);
                        $('#edit_passport_id').select2().trigger('change');


                        $("#edit_passport_id").select2({
                            dropdownParent: $("#edit_modal")
                        });
                    }

                }
            });

            $("#edit_modal").modal('show');
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
