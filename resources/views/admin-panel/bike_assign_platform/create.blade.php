@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Bike</a></li>
            <li>Bike Checkin By Platform</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Bike Checkin</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Bike Checkout</a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Bike Checkin By Platform</div>
                            <form method="post" action="{{ route("bike_assign_platform.store") }}">
                                @csrf
                                <input type="hidden" id="id" name="id" value="">
                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Platform Name</label>
                                        <select class="form-control" name="platform_id" id="platform_id" required>
                                            <option value=""  >select an option</option>
                                            @foreach($platforms as $plt)
                                                <option value="{{ $plt->id }}"  >{{ $plt->name }}</option>
                                            @endforeach
                                        </select>


                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Select Bike</label>
                                        <select  name="bike_id[]" id="bike_id" multiple class="form-control cls_card_type">
                                            <option value=""  >Select option</option>
                                            @foreach($bikes as $bike)
                                                <option value="{{ $bike->id }}"  >{{ $bike->plate_no }}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Check IN</label>
                                        <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required  />
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Remarks</label>
                                        <textarea class="form-control form-control" id="remarks" name="remarks" ></textarea>
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

        </div>
{{--        fist tab close here now--}}

        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Bike Checkout By Platform</div>
                            <form method="post" action="{{ route("bike_assign_platform.update",1) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id" name="id" value="">
                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Platform Name</label>
                                        <select class="form-control" name="platform_id_checkout" id="platform_id_checkout" required>
                                            <option value=""  >select an option</option>
                                            @foreach($platforms as $plt)
                                                <option value="{{ $plt->id }}"  >{{ $plt->name }}</option>
                                            @endforeach
                                        </select>


                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Select Bike</label>
                                        <select  name="bike_id_checkout[]" id="bike_id_checkout" multiple class="form-control cls_card_type">


                                        </select>
                                    </div>


                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Check Out</label>
                                        <input class="form-control form-control" id="checkin_checkout" name="checkin_checkout" type="datetime-local" required  />
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="repair_category">Remarks</label>
                                        <textarea class="form-control form-control" id="remarks_checkout" name="remarks_checkout" ></textarea>
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

        </div>
{{--        second tab close here--}}

    </div>





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

            $('#bike_id').select2({
                placeholder: 'Select an option'
            });
            $('#platform_id').select2({
                placeholder: 'Select an option'
            });

        });
    </script>

    <script>

        $("#platform_id_checkout").change(function () {

            var select_id = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_get_bikes_checkin_by_platform') }}",
                method: 'POST',
                dataType: 'json',
                data: {platform_id: select_id,_token:token},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }

                    var array_select = [];

                    if(len > 0){
                        for(var i=0; i<len; i++){
                           add_dynamic_opton(response[i].id,response[i].bike_number);
                            array_select.push(response[i].id);

                        }
                    }
                    // $('#bike_id_checkout').val(array_select).trigger('change');
                    $('#bike_id_checkout').val(null).trigger('change');

                }
            });

        });

        function add_dynamic_opton(id,text_ab){
                // Create a DOM Option and pre-select by default
                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#bike_id_checkout').append(newOption);

        }
        </script>

    <script>

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                $('#bike_id').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id').select2({
                    placeholder: 'Select an option'
                });

                $('#bike_id_checkout').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_checkout').select2({
                    placeholder: 'Select an option'
                });

            }) ;
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
