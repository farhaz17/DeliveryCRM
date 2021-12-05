<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead>
        <tr>
            <th scope="col">Name </th>
            <th scope="col">Passport No </th>
            <th scope="col">Platform </th>
            <th scope="col">Bike Checkin </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$passport->personal_info->full_name}}</td>
            <td>{{$passport->passport_no}}</td>
            <td>{{$platform->plateformdetail->name}}</td>
            <td>{{$bike->checkin}}</td>
        </tr>
    </tbody>
</table>
