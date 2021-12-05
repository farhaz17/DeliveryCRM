 <table class="table table-striped" id="datatable_bike"  style="width: 100%">
            <div class="card-title">Bike Detail</div>
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 100px">Plate Number</th>
                <th scope="col" style="width: 100px">Name</th>
                <th scope="col" style="width: 100px">Check In</th>
                <th scope="col" style="width: 100px">Check Out</th>
                <th scope="col" style="width: 100px">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platform_bike as $row)
                <tr>
                    <td>{{isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A"}}</td>
                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                    <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                    <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                    <td>{{isset($row->remarks)?$row->remarks:"N/A"}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>



