@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Box</a></li>
        <li>Box Request RTA</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="card-title">Box Installation Request</div>
                <form action="{{ route('save_box_request_rta') }}" method="POST" id="myForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="">Select Bike</label>
                            <select id="bike" name="bike" class="form-control bike" required>
                                <option value="">Select option</option>
                                @foreach ($bikes as $bike)
                                    <option value="{{ $bike->id }}" >{{ $bike->plate_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="">Select Platform</label>
                            <select id="platform" name="platform" class="form-control platform" required>
                                <option value="">Select option</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->id }}" >{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12"><br>
                            <button class="btn btn-info save_btn">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#myForm').one('submit', function() {
            $(this).find('.save_btn').attr('onclick','this.style.opacity = "0.6"; return false;');
        });
    </script>
    <script>
        $('.bike').select2({
            placeholder: 'Select a Bike'
        });
        $('.platform').select2({
            placeholder: 'Select a Platform'
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
