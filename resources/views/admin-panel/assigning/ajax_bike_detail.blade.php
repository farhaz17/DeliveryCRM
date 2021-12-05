<style>


</style>

<table class="table" id="datatable-history" style="width:700px">
    @foreach($bike_detail as $bike)
    <tr>
        <th scope="col">Plate Number</th>
        <td>
            <i class="i-Motorcycle text-white bg-success rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->plate_no}}</td>
    </tr>
    <tr>
        <th scope="col">Plate Code</th>
        <td>
            <i class="i-Bar-Code text-white bg-primary rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->plate_code}}</td>
    </tr>
    <tr>
        <th scope="col">Model</th>
        <td>
            <i class="i-Receipt-4 text-white bg-danger rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->model}}</td>
    </tr>
    <tr>
        <th scope="col">Make Year</th>
        <td>
            <i class="i-Calendar-4 text-white bg-info rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->make_year}}</td>
    </tr>
    <tr>
        <th scope="col">Chassis no</th>
        <td>
            <i class="i-Split-Horizontal text-white bg-warning rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->chassis_no}}</td>
    </tr>
    <tr>
        <th scope="col">Insurance Company</th>
        <td>
            <i class="i-University1 text-white bg-success rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->insurance_co}}</td>
    </tr>
    <tr>
        <th scope="col">Expiry Date</th>
        <td>
            <i class="i-Calendar-2 text-white bg-primary rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->expiry_date}}</td>
    </tr>
    <tr>
        <th scope="col">Issue Date</th>
        <td>
            <i class="i-Calendar text-white bg-danger rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->issue_date}}</td>
    </tr>
    <tr>
        <th scope="col">Traffic File No</th>
        <td>
            <i class="i-File-Excel text-white bg-dark rounded-circle p-2 mr-3"></i>
        </td>
        <td>{{$bike->traffic_file}}</td>

    </tr>
        <tr>
        <th scope="col">Tracking Number</th>
        <td>
            <i class="i-Magnifi-Glass1 text-white bg-info rounded-circle p-2 mr-3"></i>
        </td>
        <td>
{{--            {{isset($bike->tracking->tracking_number)?$bike->tracking->tracking_number:"N/A"}}--}}


            @if(isset($bike->tracking[0]))
                <span>{{  $bike->tracking[0]->tracking_number}}</span>
            @else
                <span>N/A</span>
            @endif
        </td>

    </tr>
    <tr>
        <th scope="col">Category Type</th>
        <td>
            <i class="i-Suitcase text-white bg-warning rounded-circle p-2 mr-3"></i>
        </td>
        @if($bike->category_type=='0')
            <td>Company</td>
        @else
            <td>Lease</td>
        @endif

    </tr>




    @endforeach
</table>


<script>
    'use strict';

    $('#datatable-history').DataTable( {

        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    });


</script>
