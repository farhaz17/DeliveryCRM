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
        <li>Box Removal</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-2 mb-3"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="card-title">Box Removal</div>
                <form action="{{ route('save_box_removal') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="">Select Bike</label>
                            <select class="form-control" name="bike" id="bike" required >
                                <option value="">select an option</option>
                                @foreach($bikes as $bike)
                                    <option value="{{ $bike->id }}">{{ $bike->bikes->plate_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="">Current Box</label><br>
                            <h5><span id="current_box"></span></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Date</label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Remark</label>
                            <textarea name="remark" id="remark" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button class="btn btn-info">Save</button>
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
        $('#bike').select2({
            placeholder: 'Select a Bike'
        });
    </script>
    <script>
        $('#bike').change(function(){
            var id = $(this).val();

            $.ajax({
                url: "{{ route('get_current_box') }}",
                method: "get",
                data:{id:id},
                success:function(response){
                    $('#current_box').empty();
                    $('#current_box').append(response);
                }
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
