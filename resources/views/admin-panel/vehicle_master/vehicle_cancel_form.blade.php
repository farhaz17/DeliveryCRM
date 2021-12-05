@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA Operation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bike Cancellation</li>
    </ol>
</nav>
<div class="row">
<div class="card col-md-7 mb-2">
    <div class="card-body">
        <form action="{{ route('vehicle_cancel_store') }}" method="post">
        @csrf
        <div class="card-title mb-3 col-12">Vehicle Cancellation</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1"> 
                <label for="bike_id">Plate No</label>
                <select name="bike_id" id="bike_id" class="form-control form-control-sm select2" required>
                    <option value="">Select One</option>
                    @forelse ($all_bike_details as $bike_detail)
                        <option value="{{ $bike_detail->id }}">Plate: {{ $bike_detail->plate_no ?? "" }} | Chassis: {{ $bike_detail->chassis_no ?? "" }}</option>
                    @empty
                        
                    @endforelse
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="reson_of_cancellation">Reason of Cancellation</label>
                <select name="reson_of_cancellation" id="reson_of_cancellation" class="form-control form-control-sm select2">
                    <option value="">Select One</option>
                    <option value="1">Cancel Reason 1</option>
                    <option value="2">Cancel Reason 2</option>
                    <option value="3">Cancel Reason 3</option>
                    <option value="4">Cancel Reason 4</option>
                </select>
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="date_and_time">Date &amp; Time</label>
                <input class="form-control form-control-sm" id="date_and_time" name="date_and_time" type="date" required="">
            </div>
            <div class="col-md-12 form-group mb-1">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
            </div>
        </div>  
        <div id="attachment_holder"></div>          
        <div class="row">
            <div class="col-md-12 form-group mb-1">
                <label for="">&nbsp;</label><br>
                <input class="btn btn-info btn-sm float-right" id="" type="submit" value="Submit">
            </div>
        </div>
        </form>
    </div>
</div>
<div class="card col-md-5 mb-2">
<div class="card-body">
    <div class="card-title mb-3 col-12">Selected Vehicle Information</div>
        <div class="row">
            <table class="table table-sm table-striped text-11">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Chassis No</th>
                        <th>Traffic File No</th>
                        <th>Owner's Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="vehicle_model"></td>
                        <td id="vehicle_chassis_no"></td>
                        <td id="vehicle_traffic_file_no"></td>
                        <td id="vehicle_traffic_company_name"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('select.select2').select2({
            allowClear: true,
            placeholder: "Select One"
        });
    });
</script>

<script>
   $('#bike_id').on('change', function(){
       var bike_id = $(this).val();
       $.ajax({
          url: "{{ route('get_bike_detail_for_cancellation_with_bike_id') }}",
          type:"GET",
          data:{bike_id},
          success:function(response){
            $('#vehicle_model').text(response.model);
            $('#vehicle_chassis_no').text(response.chassis_no);
            $('#vehicle_traffic_file_no').text(response.traffic_file_no);
            $('#vehicle_traffic_company_name').text(response.company_name);
          },
          error: function(response) {
             console.log(response)
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