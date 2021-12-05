@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Driving License Step</a></li>
            <li>Update Driving License step</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Update Status</div>
                    <form method="post" action="{{ route('driving_license_step.store')  }}">
                        {!! csrf_field() !!}


                        <div class="row ">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Passport</label>
                                <select class="form-control  " name="passport_id" id="passport_id" required >
                                    <option value="">select an option</option>
                                    @foreach($passports as $pass)
                                        <option value="{{ $pass->id  }}">{{ $pass->passport_no  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Status</label>
                                <select class="form-control  " name="status_id" id="status_id" required >
                                    <option value="">select an option</option>
                                    @foreach($driving_steps as $step)
                                        <option value="{{ $step->id  }}">{{ $step->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Remarks</label>
                                <textarea class="form-control" rows="3" name="remarks" required></textarea>
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
                                <th scope="col">Passport Number</th>
                                <th scope="col">Status</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Created At</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($save_steps as $step)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $step->passport_detail->passport_no }}</td>
                                    <td>{{ $step->step_detail->name }}</td>
                                    <td>{{ $step->remarks }}</td>
                                    <td>{{ $step->created_at }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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

            $('#passport_id').select2({
                placeholder: 'Select an option'
            });

            $("#passport_id").change(function () {


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_driving_current_status') }}",
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
