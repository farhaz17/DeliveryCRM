<h2>Lease Used Bikes</h2>
<table class="table">
    <thead class="thead-dark">
    <tr>

        <th scope="col">Name</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">PPUID</th>
        <th scope="col">Passport Number</th>
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
    @foreach($lease_used_bike as $bike)
        <tr style="white-space: nowrap; font-size: 14px;">
            <td>
                @foreach($bike->assign_bike as $rw)
                    {{isset($rw->passport->personal_info->full_name)?$rw->passport->personal_info->full_name:"N/A"}}
                @endforeach
            </td>
            <td>
                @foreach($bike->assign_bike as $rw)
                    {{isset($rw->passport->zds_code->zds_code)?$rw->passport->zds_code->zds_code:"N/A"}}
                @endforeach
            </td>
            <td>
                @foreach($bike->assign_bike as $rw)
                    {{isset($rw->passport->pp_uid)?$rw->passport->pp_uid:"N/A"}}
                @endforeach
            </td>
            <td>
                @foreach($bike->assign_bike as $rw)
                    {{isset($rw->passport->passport_no)?$rw->passport->passport_no:"N/A"}}
                @endforeach
            </td>

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
<?php
