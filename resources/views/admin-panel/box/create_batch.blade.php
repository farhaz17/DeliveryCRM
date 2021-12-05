@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Box</a></li>
        <li>Create Batch</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="card-title mb-3">Create Batch</div>
            <form method="post" action="{{ route('save_box_batch')  }}"  enctype="multipart/form-data">
                @csrf
                <div class="row ">
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Select Platform</label>
                        <select class="form-control  " name="platform" id="platform" required >
                            <option value="">select an option</option>
                            @foreach($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Reference Number</label>
                        <input class="form-control form-control" id="reference_number" name="reference_number" type="text" required readonly  />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Select Date</label>
                        <input class="form-control form-control" id="date_time"  autocomplete="off" name="date_time" type="text" required  />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Enter Location</label>
                        <input type="text" class="form-control form-control" name="location" id="location" required>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Enter Quantity Range</label>
                        <input class="form-control form-control" min="1" id="quantity" name="quantity" type="number" required  />
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <button class="btn btn-primary " id="save_btn" type="submit">Create</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-11" id="batchs" style="width: 100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Platform</th>
                            <th scope="col">Reference Number</th>
                            <th scope="col">Date</th>
                            <th scope="col">Location</th>
                            <th scope="col">Quantity Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batchs as $batch)
                        <tr>
                            <td></td>
                            <td>{{ $batch->platform->name }}</td>
                            <td>{{ $batch->reference_number }}</td>
                            <td>{{ $batch->date }}</td>
                            <td>{{ $batch->location }}</td>
                            <td>{{ $batch->bike_quantity }}</td>
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#platform').select2({
            placeholder: 'Select a Platform'
        });
    </script>
    <script>
        tail.DateTime("#date_time",{
            dateFormat: "YYYY-mm-dd",
            dateStart:new Date(),
            timeFormat: false,
        });
    </script>
    <script>
        $('#platform').change(function(){
            var id = $(this).val();

            $.ajax({
                url: "{{ route('box_reference_number') }}",
                method: "get",
                data: {id:id},
                success:function(response){
                    $('#reference_number').val(response);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#batchs').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
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
