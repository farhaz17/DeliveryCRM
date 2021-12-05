
<style>
    body{
        position: relative;
        bottom: 0;
    }
</style>
<form action="#" method="POST" id="ajax_update_filtered_bikes_form">
    @csrf
    @method('put')
    <div class="row">
        <div class="col">Total Vehicles found <span class="badge bg-success text-white">{{ $filtered_bikes->count() ?? '' }}</span> </div>
        <div class="col">
            <input type="checkbox" class="btn" id="update_all_to_same_status" name="update_all_to_same_status" value="1"> <label for="update_all_to_same_status">Update all to same status</label>
        </div>
        <div class="col" id="update_all_status_holder" style="display: none">
            <label class="switch switch-success mr-3"><span>Working</span>
                <input type="radio" class="update_all_status" name="update_all_status" value="2"><span class="slider"></span>
            </label>
            <label class="switch switch-warning mr-3"><span>Holding</span>
                <input type="radio" class="update_all_status" name="update_all_status" value="3"><span class="slider"></span>
            </label>
            <label class="switch switch-danger mr-3"><span>Not Working</span>
                <input type="radio" class="update_all_status" name="update_all_status" value="0"><span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive" style="overflow-y: scroll; height: 350px;">
            <table class="table table-hover table-striped table-sm text-11" id="filteredVehicleListTable">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Plate No</th>
                        <th>Chassis No</th>
                        <th>Traffic Owner</th>
                        <th>Bike Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filtered_bikes as $bike)
                        <tr>
                            <td>{{ $bike->make->name ?? "" }}</td>
                            <td>{{ $bike->plate_no ?? "" }}</td>
                            <td>{{ $bike->chassis_no ?? "" }}</td>
                            <td>
                                @if(isset($bike->traffic) && $bike->traffic->traffic_for == 1)
                                    {{$bike->traffic->company->name ?? "NA" }}
                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 2)
                                    {{ $bike->traffic->passport_info->personal_info->full_name ?? "NA" }}
                                @elseif(isset($bike->traffic) && $bike->traffic->traffic_for == 3)
                                    {{ $bike->traffic->customer_supplier_info->contact_name ?? "NA" }}
                                @endif
                            </td>
                            <td>
                                <div>
                                    <label class="switch switch-success mr-3"><span>Working</span>
                                        <input type="radio" class="status" name="status[{{$bike->id}}]" {{ $bike->status == 2 ? 'checked' : ''}} value="2">
                                        <span class="slider"></span>
                                    </label>
                                    <label class="switch switch-warning mr-3"><span>Holding</span>
                                        <input type="radio" class="status" name="status[{{$bike->id}}]" {{ $bike->status == 3 ? 'checked' : ''}} value="3">
                                        <span class="slider"></span>
                                    </label>
                                    <label class="switch switch-danger mr-3"><span>Not Working</span>
                                        <input type="radio" class="status" name="status[{{$bike->id}}]" {{ $bike->status == 0 ? 'checked' : ''}} value="0">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group col-12">
            <button type="submit" onclick="return confirm('Are you sure to update all bike status')" class="btn btn-sm btn-info float-right">Update Bike Status</button>
        </div>
    </div>
</form>

<script>
    $('input.status').change(function(){
        $('#update_all_to_same_status').prop('checked',false);
        $('#update_all_status_holder').hide(300);
    });
    $('input.update_all_status').change(function(){
        $('#update_all_to_same_status').prop('checked',true);

    });
    $('#update_all_to_same_status').change(function(e){
        $('#update_all_status_holder').show(300);
        console.log(e.checked)
    });

    $(document).ready(function(){

        $("#ajax_update_filtered_bikes_form").on("submit", function(e) {
            e.preventDefault()
            var url = "{{ route('vehicle_working_status_bulk_update') }}";
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data:$(this).serialize(),
                success: function(response){
                    $('#bike_search_form').submit()
                    tostr_display(response['alert-type'], response['message'])
                }
            });
        });
    });

function tostr_display(type,message){
    switch(type){
        case 'info':
            toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
            break;
        case 'warning':
            toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
            break;
        case 'success':
            toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
            break;
        case 'error':
            toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
            break;
        }
    }
</script>
