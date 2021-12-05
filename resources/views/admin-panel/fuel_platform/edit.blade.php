@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .modal-content {
            width: 700px;
        }
        .remarks {
            text-align: justify;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Fuel Platform</a></li>
            <li><a href="{{ route('fuel_platform.index') }}" title="Click to view all Fuel Platforms">See All Fuel Platforms</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <form action="{{ route('fuel_platform.update', $fuelPlatform->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
    <div class="card col-md-8 offset-md-2 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Fuel Platform Registration</div>
            <div class="row">
                <div class="col-md-4 form-group mb-1">
                    <label for="platform_id">Platforms</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $fuelPlatform->platform->name ?? '' }}" disabled>
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="cities_ids">Cities / States</label>
                    <select name="cities_ids[]" id="cities_ids" class="form-control form-control-sm selet2  select multi-select" multiple  required>
                        <option value="" >Select City</option>
                        @php $cities_ids = json_decode($fuelPlatform->cities_ids) @endphp
                        @foreach ($cities as $city)
                            <option {{ in_array($city->id,  $cities_ids ) ? "selected" : "" }} value="{{ $city->id }}">{{ $city->name ?? "" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group mb-1">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control form-control-sm" required>
                        <option value="">Select Status</option>
                        <option {{ $fuelPlatform->status == 1 ? "selected" : "" }} value="1">Yes</option>
                        <option {{ $fuelPlatform->status == 0 ? "selected" : "" }} value="0">No</option>
                    </select>
                </div>
                <div class="col-md-12 form-group mb-1">
                    <label for="name">&nbsp;</label><br>
                    <input class="btn btn-info btn-sm float-right" id="" type="submit" value="Submit">
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#cities_ids').select2({
            placeholder: 'Select cities'
        });

        $('#platform_id').select2({
            placeholder: 'Select platform'
        });
    </script>
    <script>
        $(document).ready(function(){
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}", "Information!" , {timeOut:10000, prograssBar: true});
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}", "Worning!" , {timeOut:10000, prograssBar: true});
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}", "Success!" , {timeOut:10000, prograssBar: true});
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}", "Failed!" , {timeOut:10000, prograssBar: true});
                    break;
            }
            @endif 
        });
    </script>

@endsection
