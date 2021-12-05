<table class="table table-hover table-striped table-sm text-11">
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
        @foreach ($get_uploaded_vehicles as $bike)
            <tr>
                <td>{{ is_numeric($bike->model) ? $bike->model_info->name : $bike->model }}</td>
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
                     {!! get_vehicles_status_name($bike->status) !!}
                </td>
            </tr> 
        @endforeach
    </tbody>
</table>