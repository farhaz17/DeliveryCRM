<table class="table table-striped" id="datatable_bike"  style="width: 100%">
    <div class="card-title">Bike Detail</div>
    <thead class="thead-dark">
    <tr>
        <th scope="col">Company</th>
        <th scope="col">PPUID</th>
        <th scope="col">ZDS Code</th>
        <th scope="col" style="width: 100px">SIM Number</th>
        <th scope="col" style="width: 100px">Name</th>
        <th scope="col" style="width: 100px">Check In</th>
        <th scope="col" style="width: 100px">Check Out</th>
        <th scope="col" style="width: 100px">Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sim_deail as $row)
        <tr>
            <td>{{isset($row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name)?$row->bike_detail->get_current_bike->passport->agreement->fourpl_contractor->name :"N/A"}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->pp_uid ?$row->bike_detail->get_current_bike->passport->pp_uid :""}}</td>
            <td>{{ $row->bike_detail->get_current_bike->passport->zds_code->zds_code ?$row->bike_detail->get_current_bike->passport->zds_code->zds_code :""}}</td>
            <td>{{isset($row->telecome->account_number)?$row->telecome->account_number:"N/A"}}</td>
            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
            <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
            <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
            <td>{{isset($row->remarks)?$row->remarks:"N/A"}}</td>
        </tr>
    @endforeach
    </tbody>
</table>



