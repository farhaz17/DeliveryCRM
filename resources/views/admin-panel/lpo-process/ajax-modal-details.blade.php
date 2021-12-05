@if($process == 2)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Model</th>
            <th scope="col">Chassis</th>
            <th scope="col">VCC Attachment</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{$bike->model->name}}</td>
                <td>{{$bike->chassis_no}}</td>
                <td><a href="{{Storage::temporaryUrl($bike->vcc_attachment , now()->addMinutes(60)) }}" target="_blank">View File</a></td>
            </tr>
    </tbody>
</table>
@elseif($process == 3)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Model</th>
            <th scope="col">Chassis</th>
            <th scope="col">Insurance No</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{$bike->model->name}}</td>
                <td>{{$bike->chassis_no}}</td>
                <td>{{$bike->insurance_no}}</td>
            </tr>
    </tbody>
</table>
@elseif($process == 4)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Model</th>
            <th scope="col">Chassis</th>
            <th scope="col">Plate No</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{$bike->model->name}}</td>
                <td>{{$bike->chassis_no}}</td>
                <td>{{$bike->plate_no}}</td>
            </tr>
    </tbody>
</table>
@elseif($process == 5)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Model</th>
            <th scope="col">Chassis</th>
            <th scope="col">Salik tag</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>{{$bike->model->name}}</td>
                <td>{{$bike->chassis_no}}</td>
                <td>{{$bike->salik_tag_id}}</td>
            </tr>
    </tbody>
</table>
@endif
