<h2 class="align-content-center">Company Cance Bikes</h2>
<table class="table">
    <thead class="thead-dark">
    <tr>

        <th scope="col">Plate Number</th>
        <th scope="col">Plate Code</th>
        <th scope="col">Model</th>
        <th scope="col">Make Year</th>
        <th scope="col">Chassis no</th>
        <th scope="col">Insurance Company</th>
        <th scope="col">Expiry Date</th>
        <th scope="col">Issue Date</th>
        <th scope="col">Traffic File No</th>
        <th scope="col">Category Type</th>
    </tr>
    </thead>

    <tbody>
    @foreach($company_cancel_bike as $bike)
        <tr style="white-space: nowrap; font-size: 14px;">
            <td>{{$bike->plate_no}}</td>
            <td>{{$bike->plate_code}}</td>
            <td>{{$bike->model}}</td>
            <td>{{$bike->make_year}}</td>
            <td>{{$bike->chassis_no}}</td>
            <td>{{$bike->insurance_co}}</td>
            <td>{{$bike->expiry_date}}</td>
            <td>{{$bike->issue_date}}</td>
            <td>{{$bike->traffic_file}}</td>
            @if($bike->category_type == '0')
                <td>Company</td>
            @elseif($bike->category_type == '1')
                <td>Lease</td>
            @elseif($bike->category_type == '2')
                <td>Click Deliver</td>
            @elseif($bike->category_type == '3')
                <td>Deliveroo</td>
            @else
                <td>Other</td>
            @endif
        </tr>
    @endforeach
</table>
