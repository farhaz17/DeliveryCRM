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
        <li class="breadcrumb-item active" aria-current="page">Plate Replacement Request Register</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Selected Vehicle Information</div>
        <div class="row">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Chassis No</th>
                        <th>Currnet Plate No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="vehicle_model"></td>
                        <td id="vehicle_chassis_no"></td>
                        <td id="vehicle_current_plate_no"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('vehicle_plate_replace.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-title mb-3 col-12">Vehicle Plate Replacement Request</div>
        <div class="row">
            <div class="col-md-4 form-group mb-1"> 
                <label for="bike_id">Select Current Plate No</label>
                <select name="bike_id" id="bike_id" class="form-control form-control-sm" required>
                    <option value="">Select One</option>
                    @forelse ($all_bike_details as $bike_detail)
                        <option value="{{ $bike_detail->id }}">
                            {{ "Plate No: " . $bike_detail->plate_no ?? "" }} 
                            {{ $bike_detail->chassis_no ? " | Chassis No: " . $bike_detail->chassis_no : '' }}</option>
                    @empty
                        
                    @endforelse
                </select>
            </div>
            <div class="col-md-4 form-group mb-1"> 
                <label for="new_plate_no">New Plate No</label>
                <input type="text" name="new_plate_no" id="new_plate_no" class="form-control form-control-sm">
            </div>
            <div class="col-md-4 form-group mb-1">
                <label for="type">Reason of Replacement</label>
                <select name="reson_of_replacement" id="" class="form-control form-control-sm">
                    <option value="">Select One</option>
                    @foreach (get_plate_replace_reasons() as $key => $reason)
                        <option value="{{$key}}">{{ $reason }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 form-group mb-1">
                <label for="type">Remarks</label>
                <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
            </div>
            <div class="col-md-12 form-group mb-1">
                <label for="">&nbsp;</label><br>
                <button class="btn btn-primary btn-sm float-right text-10" id="attachment_add_more_btn" type="button">Add Attachment</button>
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
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();
</script>
<script>
    var attachment_row_number = 0;
    $('#attachment_add_more_btn').on('click', function(){
        var new_attachment_row = `<div class="row" id="attachment_row`+ attachment_row_number+ `">
        <div class="col-md-5 form-group mb-1">
                <label for="">Attachment Label</label>
                <select name="attachment_labels[]" id="" class="form-control form-control-sm">
                    <option value="">Select One</option>
                    @foreach ($labels as $label)
                        <option value="{{ $label->id }}">{{ $label->name ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 form-group mb-1">
                <label for="">Attachment</label>
                <input class="form-control-file form-control-sm" name="attachment_files[]" id="" type="file" placeholder="" required>
            </div>
            <div class="col-md-2 form-group mb-1">
                <label for="">&nbsp;</label>
                <input class="btn btn-danger btn-sm text-10 delete_activity float-right" id="" data-attachment_row_id = "attachment_row`+attachment_row_number+`" type="button" value="Delete Row">
            </div> 
        </div>`;
        $('#attachment_holder').append(new_attachment_row);
        attachment_row_number++
    });

    $(document).ready(function(){
        $('#attachment_holder').on('click', '.delete_activity', function() {
            var ids = $(this).attr('data-attachment_row_id');
            $("#"+ids).remove();
        });
    });
</script>
<script>
   $('#bike_id').on('change', function(){
       var bike_id = $(this).val();
       $.ajax({
          url: "{{ route('get_bike_detail_with_bike_id') }}",
          type:"GET",
          data:{bike_id},
          success:function(response){
            $('#vehicle_model').text(response.model);
            $('#vehicle_chassis_no').text(response.chassis_no);
            $('#vehicle_current_plate_no').text(response.vehicle_current_plate_no);
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