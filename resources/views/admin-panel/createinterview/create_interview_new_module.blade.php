@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .subject-info-box-1,
        .subject-info-box-2 {
            float: left;
            width: 45%;

        select {
            height: 200px;
            padding: 0;

        option {
            padding: 4px 10px 4px 10px;
        }

        option:hover {
            background: #EEEEEE;
        }
        }
        }

        .subject-info-arrows {
            float: left;
            width: 10%;

        input {
            width: 70%;
            margin-bottom: 5px;
        }
        }
        .lstBox2{
            height: 300px !important;
        }
        select.form-control[multiple] {
            height: 300px !important;
        }
        .select2-container{
            width: 100% !important;
        }

        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Create Interview</a></li>
            <li>Create Intreview</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('emirates_id_card.update',1) }}" enctype="multipart/form-data">
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
                                <label for="repair_category">Passport </label>
                                <input type="text" class="form-control" id="passport_id_edit" name="passport_id" readonly>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Id Number</label>
                                <input type="text" class="form-control" id="edit_id_number" name="edit_id_number" >
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Front Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="front_pic" id="front_pic" >
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Back Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="back_pic" id="back_id" >
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
                    <div class="card-title mb-3">Create Interview Batch</div>
                    <form method="post" action="{{ route('save_batch')  }}"  enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row ">
                            <div class="col-md-4 form-group mb-3 append_div">
                                <label for="repair_category">Select Platform</label>
                                <select class="form-control  " name="platform_id" id="platform_id" required >
                                    <option value="">select an option</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Enter Reference Number</label>
                                <input class="form-control form-control" id="reference_number" name="reference_number" type="text" required readonly  />
                            </div>


                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Interview Date</label>

                                <input class="form-control form-control" id="date_time"  autocomplete="off" name="date_time" type="text" required  />
                            </div>


                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select Start Time</label>
                                <input class="form-control form-control" id="start_time" name="start_time" type="time" required  />
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select End Time</label>
                                <input class="form-control form-control" id="end_time" name="end_time" type="time" required  />
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select City</label>
                                <select class="form_control" multiple name="cities[]" id="cities" required>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Enter Quantity Range</label>
                                <input class="form-control form-control" min="1" id="quantity" name="quantity" type="number" required  />
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary " id="save_btn" type="submit">Save</button>
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
                    <table class="display table table-striped table-bordered table-sm text-15" id="datatable_not_employee">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">PlatForm Name</th>
                            <th scope="col">Interview Date</th>
                            <th scope="col">Reference Number</th>
                            <th scope="col">start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Quantity Range</th>
                            <th scope="col">Total Candidate</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($batches as $batch)
                            <tr>
                                <td>{{ $batch->id }}</td>
                                <td>{{ isset($batch->platform) ? $batch->platform->name : '' }}</td>
                                <td>{{ $batch->interview_date }}</td>
                                <td>{{ $batch->reference_number }}</td>
                                <td>{{ $batch->start_time }}</td>
                                <td>{{ $batch->end_time }}</td>
                                <td>{{ $batch_status_array[$batch->is_complete] }}</td>
                                <td>{{ $batch->candidate_quantity ? $batch->candidate_quantity : 'N/A' }}</td>
                                <td>{{ isset($batch->interviews) ? $batch->interviews->count() : '0' }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
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
        tail.DateTime("#date_time",{
            dateFormat: "YYYY-mm-dd",
            dateStart:new Date(),
            timeFormat: false,

        });
    </script>

    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });
    </script>


    <script>
        {{--function ajax_table_load(){--}}

        {{--    var token = $("input[name='_token']").val();--}}
        {{--    var platform_id = $("#platform_id").val();--}}
        {{--    var quantity = $("#quantity").val();--}}
        {{--    var select_date_time = $("#select_date_time").val();--}}

        {{--    $.ajax({--}}
        {{--        url: "{{ route('display_interview_list') }}",--}}
        {{--        method: 'POST',--}}
        {{--        data: {_token:token,platform_id:platform_id,quantity:quantity,select_date_time:select_date_time},--}}
        {{--        success: function(response) {--}}

        {{--            $('#datatable tbody').empty();--}}
        {{--            $('#datatable tbody').append(response.html);--}}


        {{--        }--}}
        {{--    });--}}

        {{--}--}}


    </script>











    <script>
        $(document).ready(function () {


            $('#platform_id').select2({
                placeholder: 'Select an option'
            });



            $('#cities').select2({
                placeholder: 'Select an option'
            });

            $("#platform_id").change(function () {

                var id = $(this).val();
                $.ajax({
                    url: "{{ route('ajax_generate_reference_number') }}",
                    method: 'get',
                    data: {platform_id:id},
                    success: function(response) {
                        $("#reference_number").val(response);

                    }
                });

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
